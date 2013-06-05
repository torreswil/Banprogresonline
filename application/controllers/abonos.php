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

    	if($_POST){
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
		$interes_pagado_total=0;
		$interes_corriente_pagado=0;
		$capital_pagado=0;
		$i=1;
		$devolucion=0;
		//recorre el plan de pagos y pago los intereses de mora pendientes y generados.
		
		if($abonos){

			echo '
			<table class="table table-striped" id="distribucion-abonos">
			<thead>
	          	<tr>
	              <th>Fecha del abono</th>
	              <th>Valor</th>
	              <th>Interes de Mora</th>
	              <th>Interes Corriente</th>
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
				//echo '<p>Abono No:'.$i.'por:'.$dinero.'</p>';
				$c=0;

				foreach ($cuotas as $cuota) {

					$dias_mora=0;
					$interes_mora=0;
					$fecha_cuota=new DateTime($cuota['fechaCuota']);
					$fecha_ult_mora= new DateTime($cuota['fecha_ult_abono_mora']);
					//Si hay dinero lo distribuyo en los interes de mora.
					//echo  '<p>debe:'.$cuota['deuda_capital'].'</p>';
					if($dinero>0){
						if($credito->interes_mora>0) {
							if($fecha_abono>$fecha_cuota){
								$intervalo=$fecha_ult_mora->diff($fecha_abono);
								$dias_mora=$intervalo->format('%R%a');
								$interes_mora=$cuota['deuda_capital']*(($credito->interes_mora/100)/30)*$dias_mora;
								$interes_mora+=$cuota['interes_mora_deuda'];
								$cuota['fecha_ult_abono_mora']=$fecha_abono->format('Y-m-d');
								//$interes_mora+=$cuota['interes_mora_deuda'];
								//echo  '<p>debe:'.$cuota['deuda_capital'].'</p>';
								if($dinero>=$interes_mora){
									$cuota['interes_mora_pagado']=0;
									$cuota['interes_mora_deuda']=0;
									$dinero-=$interes_mora;
									$cuota['fecha_ult_abono_mora']=$fecha_abono->format('Y-m-d');
									//echo $fecha_abono->format('Y-m-d');
								}
								else{
									$cuota['interes_mora_pagado']+=$dinero;
									$cuota['interes_mora_deuda']=$interes_mora-$dinero;
									$cuota['fecha_ult_abono_mora']=$fecha_abono->format('Y-m-d');

									$interes_mora=$dinero;
									$dinero=0;

								}
							}
							//echo '<p>Cuota:'.$c.'   Capital Adeudado: '.$cuota['deuda_capital'].' dias mora: '.$dias_mora.'   Interes de Mora:'.$interes_mora.'</p>';
							$interes_mora_abono+=$interes_mora;
						}
					}
					
					$cuotas[$c]=$cuota;

					$c++;
				}
				$interes_pagado_total+=$interes_mora_abono;
				//echo $interes_pagado_total;
				//si queda dinero, distribuyo en los intereses corrientes vencidos hasta la fecha.
				if($dinero>0&&$saldo>0&&$fecha_credito<$fecha_abono){
					$intervalo_corriente=$ultimo_capital->diff($fecha_abono);
					$meses_corriente=$intervalo_corriente->format('%m');
					$años_corriente=$intervalo_corriente->format('%y');
					$meses_corriente+=($años_corriente*12);
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
				$ncta=0;
				//Distribuyo el capital abonado entre las diferentes cuotas con capital pactado.
				$capital_abonado=$capital_pagado;
				foreach ($cuotas as $cuota) {
					if($capital_abonado>0){
						if($cuota['capitalCuota']<$capital_abonado){
							$capital_abonado-=$cuota['capitalCuota'];
							$cuota['deuda_capital']=0;
							$cuota['interes_mora_pagado']=0;
						}
						else{
							$cuota['deuda_capital']=$cuota['capitalCuota']-$capital_abonado;
							$capital_abonado=0;
							$cuota['interes_mora_pagado']=0;

						}
					}
					$cuotas[$ncta]=$cuota;
					$ncta++;
				}

				$i++;
				//$intervalo_corriente=$ultimo_capital->diff($fecha_abono);
				//$meses_corriente=$intervalo_corriente->format('%m');
				//$dias_corriente=$intervalo_corriente->format('%d');
				//echo $meses_corriente.' ';
				echo '<tr>
	              <td>'.$abono->fecha.'</td>
	              <td>$ '.number_format($abono->valor, 0, ',', '.').'</td>
	              <td>$ '.number_format($interes_mora_abono, 0, ',', '.').'</td>
	              <td>$ '.number_format($interes_corriente_abono, 0, ',', '.').'</td>
	              <td>$ '.number_format($capital_abono, 0, ',', '.').'</td>
	              <td>$'.number_format($saldo, 0, ',', '.').'</td>
	              <td><input type="button" id="elim_abono" class="btn btn-danger btn-small" value="Eliminar" onclick="eliminarAbono('.$banco.','.$credito->id_credito.','.$abono->id.')"></td>
	           	</tr> ';
			}
			echo '</tbody>';

		}
		else{
			echo 'No se han realizado abonos';
		}

		if($devolucion>0){echo '<p>Saldo a Favor: '.$devolucion.'</p>';}
		$saldo_corriente_total=0;
		$fecha_act=date('Y-m-d');
		$fecha_actual= new DateTime($fecha_act);
		if($fecha_actual>$ultimo_capital){
			$intervalo_ultimo_cap=$ultimo_capital->diff($fecha_actual);
			$meses_corriente=$intervalo_ultimo_cap->format('%m');
			$años_corriente=$intervalo_ultimo_cap->format('%y');
			$meses_corriente+=($años_corriente*12);
			$dias_corriente=$intervalo_ultimo_cap->format('%d');
			$saldo_corriente_en_meses=($corriente_pactado/100)*$saldo*$meses_corriente;
			$saldo_corriente_en_dias=(($corriente_pactado/100)/30)*$saldo*$dias_corriente;
 			$saldo_corriente_total=($saldo_corriente_en_meses+$saldo_corriente_en_dias)-$interes_corriente_pagado;
		}
		//echo 'Ultimo capital:'.$ultimo_capital->format('Y-m-d').' Fecha Actual:'. $fecha_act .' Cpagado:'.$interes_corriente_pagado;
		$interes_mora_fecha=0;

		foreach ($cuotas as $cuota) {
			$dias_mora=0;
			$interes_mora=0;
			$fecha_cuota=new DateTime($cuota['fechaCuota']);
			$fecha_ult_mora= new DateTime($cuota['fecha_ult_abono_mora']);
			
			if($credito->interes_mora>0) {
				//echo '<p>'.$cuota['deuda_capital'].'</p>';
				
				//echo'<p>PAGADO '. $cuota['interes_mora_pagado'].'</p>';
				if($fecha_actual>$fecha_cuota&&$cuota['deuda_capital']>0){
					$intervalo=$fecha_ult_mora->diff($fecha_actual);
					$dias_mora=$intervalo->format('%R%a');
					$interes_mora=$cuota['deuda_capital']*(($credito->interes_mora/100)/30)*$dias_mora;
					//echo'<p>MORA '. $interes_mora.'</p>';
					//echo'<p>PAGADO '. $cuota['interes_mora_pagado'].'</p>';
					$interes_mora-=$cuota['interes_mora_pagado'];
				}
				$interes_mora_fecha+=$interes_mora;
			}
			
			
		}
		$total_fecha=0;
		$total_fecha=$saldo+$saldo_corriente_total+$interes_mora_fecha;
		echo '<legend>Saldo a la fecha</legend><div>

		<div class="saldo"><span class="titulo-saldo">Saldo Total:</span>$'.number_format($total_fecha, 0, ',', '.').'</div>
		<div class="saldo"><span class="titulo-saldo">Interes Corriente:</span>$'.number_format($saldo_corriente_total, 0, ',', '.').'</div>';
		echo '<div class="saldo"><span class="titulo-saldo">Interes Mora: </span>$'.number_format($interes_mora_fecha, 0, ',', '.').'</div>';
		echo '<div class="saldo"><span class="titulo-saldo">Saldo Capital: </span>$'.number_format($saldo, 0, ',', '.').'</div></div><hr class="divisor"><br><legend>Abonos Realizados</legend><br>';
		
	}

	function delete(){
		$banco=$this->input->get('banco');
		$credito=$this->input->get('credito');
		$abono=$this->input->get('abono');
		$transa=$this->transacciones->eliminar_abono($banco,$credito,$abono);
		if($this->codegen_model->delete('transacciones','id',$transa)==true){
			echo 'El abono ha sido eliminado con exito';
		}
		else{
			echo 'No se pudo eliminar este abono';
		}
	}
}
