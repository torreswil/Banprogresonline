<?php

class Abonos extends CI_Controller {
    
    function __construct() {
        parent::__construct();
		$this->load->library('form_validation');		
		$this->load->helper(array('form','url','codegen_helper'));
		$this->load->model('codegen_model','',TRUE);
		$this->load->model('transacciones');
		$this->load->model('pagos');
		$this->load->model('credito');
		$this->load->helper('date');
		$this->load->library('cuotas');
		date_default_timezone_set('America/Bogota');
	}	
	

    function abonar(){
	    $transac=array(
	            'banco'=> $_POST['banco'],
	            'tipo_transac'=>2,
	            'valor'=>$_POST['valor'],
	            'fecha'=>$_POST['fecha_abono']
	        );

	    if ($this->codegen_model->add('transacciones',$transac) == TRUE) {
	        $transaccion=$this->transacciones->obtener_ultimo_id();
	        if($transaccion){
	            $data = array(
	            'banco'=> $_POST['banco'],
	            'persona'=>$_POST['abonCliente'],
	            'credito'=>$_POST['abonCredito'],
	            'fecha_registro'=>$_POST['fecha_abono'],
	            'soporte'=>$_POST['soporte'],
	            'transaccion'=>$transaccion,
	            );

	            if ($this->codegen_model->add('abonos',$data) == TRUE)
	            {
	                //$this->data['custom_error'] = '<div class="form_ok"><p>Added</p></div>';
	                // or redirect
	                echo 'El abono se ha realizado con exito';
	            }
	            else
	            {
	                echo '<div class="form_error"><p>A ocurrido un error.</p></div>';

	            }
	        }
	   }
	}  

	function distribuir_abonos(){	
		$banco = $this->input->get('banco');
		$credito = $this->input->get('credito');
		$cliente = $this->input->get('cliente');
		$abonos=$this->pagos->devolver_abonos($banco,$credito);
		$credito=$this->credito->devolver_credito($banco,$credito);
		$cuotas=$this->cuotas->calcular_cuotas($credito);
		$saldo=$credito->monto;
		$fecha_credito=new DateTime($credito->fecha_desembolso);
		$corriente_pactado=$credito->interes_corriente;
		$ultimo_capital=$fecha_credito;
		$interes_corriente_pagado=0;
		$capital_pagado=0;
		$i=1;
		$devolucion=0;
		//recorre el plan de pagos y pago los intereses de mora pendientes y generados.
		if($abonos){

			echo '<table class="table table-striped" id="distribucion-abonos">
			<thead>
	          	<tr>
	              <th>Fecha del abono</th>
	              <th>Valor</th>
	              <th>Interes de Mora</th>
	              <th>Intereses Corriente</th>
	              <th>Abono a Capital</th>
	              <th>Saldo</th>
	              <th></th>
	            <tr>
	        </thead><tbody>';

			foreach ($abonos as $abono) {
				$interes_mora_abono=0;
				$interes_corriente_abono=0;
				$capital_abono=0;
				$dinero=$abono->valor;
				$fecha_abono=new DateTime($abono->fecha);
				//$interes_corriente_generado=
				//ciclo para pagar interes de mora
				$dias_mora=0;
				echo '<p>Abono No:'.$i.'por:'.$dinero.'</p>';
				$c=1;



				$capital_abonado=$capital_pagado;
				
				//distribuyo el capital abonado en las cuotas.
				echo $capital_abonado .'<p>';
				foreach ($cuotas as $cuota) {
					
					//echo '<p>' .$cuota['deuda_capital'].' '.$cuota['interes_mora_pagado'].'</p>';
				}
				echo '</p>';



				foreach ($cuotas as $cuota) {

					if($capital_abonado>0){
						if($cuota['deuda_capital']<$capital_abonado){
							$capital_abonado-=$cuota['deuda_capital'];
							$cuota['deuda_capital']=0;
						}
						else{
							$cuota['deuda_capital']-=$capital_abonado;
							$capital_abonado=0;
						}
					}
					else{
					}
					$dias_mora=0;
					$interes_mora=0;
					$fecha_cuota=new DateTime($cuota['fechaCuota']);
					$fecha_ult_mora= new DateTime($cuota['fecha_ult_abono_mora']);
					if($dinero>0){
						if($credito->interes_mora>0) {
							if($fecha_abono>$fecha_cuota&&$cuota['deuda_capital']>0){
								$intervalo=$fecha_ult_mora->diff($fecha_abono);
								$dias_mora=$intervalo->format('%R%a');
								$interes_mora=$cuota['deuda_capital']*(($credito->interes_mora/100)/30)*$dias_mora;
								$interes_mora-=$cuota['interes_mora_pagado'];
								$cuota['fecha_ult_abono_mora']=$fecha_cuota;
								//$interes_mora+=$cuota['interes_mora_deuda'];
								//echo ' <p>debe:'.$interes_mora.' de interes de mora capital cuota: '.$cuota['deuda_capital'].'</p>';
								if($dinero>=$interes_mora){
									$cuota['interes_mora_pagado']=$interes_mora;
									$dinero-=$interes_mora;
								}
								else{
									$cuota['interes_mora_pagado']+=$dinero;
									$cuota['interes_mora_deuda']=$interes_mora-$dinero;
									$cuota['fecha_ult_abono_mora']=$fecha_cuota;
									$interes_mora=$dinero;
									$dinero=0;

								}
							}
							echo '<p>Cuota:'.$c.'   Capital Adeudado: '.$cuota['deuda_capital'].' dias mora: '.$dias_mora.'   Interes de Mora:'.$interes_mora.'</p>';
							$interes_mora_abono+=$interes_mora;
						}
					}
					else{
					}
					$c++;
				}
				
				//si queda dinero, distribuyo en los intereses corrientes vencidos hasta la fecha.
				if($dinero>0&&$saldo>0){
					$intervalo_corriente=$ultimo_capital->diff($fecha_abono);
					$meses_corriente=$intervalo_corriente->format('%m');
					$dias_corriente=$intervalo_corriente->format('%d');
					$corriente_en_meses=($corriente_pactado/100)*$saldo*$meses_corriente;
					$corriente_en_dias=(($corriente_pactado/100)/30)*$saldo*$dias_corriente;
					$corriente_total=$corriente_en_meses+$corriente_en_dias;
					$interes_corriente_abono=$corriente_total-$interes_corriente_pagado;
					
					//si queda mas dinero que lo que debo de interes corriente, 
					//le descuento estos intereses al dinero y el interes corriente queda pagado hasta la fecha del abono.
					if($dinero>$interes_corriente_abono){
						$dinero-=$interes_corriente_abono;
						$interes_corriente_pagado=$corriente_total;
					}

					//sino pago lo que alcance y se lo sumo a los intereses pagados.
					else{
						$interes_corriente_abono=$dinero;
						$interes_corriente_pagado+=$interes_corriente_abono;
						$dinero=0;
					}
				}
				
				//si queda saldo, abono lo que quede a capital.
				
				if($saldo>0&&$dinero>0){
					
					if($dinero>$saldo){
						$capital_abono=$dinero;
						$ultimo_capital=$fecha_abono;
						$interes_corriente_pagado=0;
						$capital_pagado+=$capital_abono;
						$dinero-=$saldo;
						$saldo=0;
						$devolucion=$dinero;
					}
					else{
						$capital_abono=$dinero;
						$capital_pagado+=$capital_abono;
						$ultimo_capital=$fecha_abono;
						$interes_corriente_pagado=0;
						$saldo-=$capital_abono;
					}

				}
				else{
					$devolucion+=$dinero;
				}

				$i++;
				$intervalo_corriente=$ultimo_capital->diff($fecha_abono);
				$meses_corriente=$intervalo_corriente->format('%m');
				$dias_corriente=$intervalo_corriente->format('%d');
				echo '<tr>
	              <td>'.$abono->fecha.'</td>
	              <td>'.$abono->valor.'</td>
	              <td>'.$interes_mora_abono.'</td>
	              <td>'.$interes_corriente_abono.'</td>
	              <td>'.$capital_abono.'</td>
	              <td>'.$saldo.'</td>
	              <td><a href="'.base_url().'abonos/delete/'.$abono->id.'/'.$abono->cliente.'/'.$credito->id_credito.'/'.$banco.'" data-toggle="modal" id="elim_abono" class="btn btn-danger btn-small" style="float: right">Eliminar</a></td>
	           	</tr> ';
			}

		}
		else{
			echo 'No se han realizado abonos';
		}

		if($devolucion>0){echo '<p>Saldo a Favor: '.$devolucion.'</p>';}
		$fecha_actual=date('Y-m-d');
		$fecha_actual= new DateTime($fecha_actual);
		if($ultimo_capital<$fecha_actual){
			$intervalo_ultimo_cap=$ultimo_capital->diff($fecha_actual);
			$meses_corriente_saldo=$intervalo_corriente->format('%m');
			$dias_corriente_saldo=$intervalo_corriente->format('%d');
			$saldo_corriente_en_meses=($corriente_pactado/100)*$saldo*$meses_corriente;
			$saldo_corriente_en_dias=(($corriente_pactado/100)/30)*$saldo*$dias_corriente;
			$saldo_corriente_total=$saldo_corriente_en_meses+$saldo_corriente_en_dias;

			$saldo_mora_en_meses=($credito->interes_mora/100)*$saldo*$meses_corriente;
			$saldo_mora_en_dias=(($credito->interes_mora/100)/30)*$saldo*$dias_corriente;
			$saldo_mora_total=$saldo_mora_en_meses+$saldo_mora_en_dias;
			echo '<p>Interes Corriente a la fecha'.$saldo_corriente_total.'</p>';
			echo '<p>Interes Mora a la fecha'.$saldo_mora_total.'</p>';
			echo '<p>Saldo Capital'.$saldo.'</p>';
		}

	}

	function delete(){
		$id =  $this->uri->segment(3);
		$cliente=$this->uri->segment(4);
		$credito=$this->uri->segment(5);
		$credito=$this->uri->segment(6);
            $this->pagos->delete($id,$cliente,$credito);             
            redirect(base_url().'creditos/ver/');
	}
}
