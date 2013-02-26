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
		$interes_corriente_pagado=0;
		$i=1;
		//recorre el plan de pagos y pago los intereses de mora pendientes y generados.
		foreach ($abonos as $abono) {
			$dinero=$abono->valor;
			$fecha_abono=new DateTime($abono->fecha);
			//$interes_corriente_generado=
			echo '<p>el '.$abono->fecha.'abono No:'.$i.' por '.$dinero.'</p>';
			foreach ($cuotas as $cuota) {
				$fecha_cuota=new DateTime($cuota['fechaCuota']);
				$fecha_ult_capital= new DateTime($cuota['fecha_ult_abono_cap']);
				if( $dinero>0) {
					if($fecha_abono>$fecha_cuota&&$cuota['deuda_capital']>0){
						$intervalo=$fecha_ult_capital->diff($fecha_abono);
						$dias_mora=$intervalo->format('%R%a');
						$interes_mora=$cuota['deuda_capital']*(($credito->interes_mora/100)/30)*$dias_mora;
						$interes_mora-=$cuota['interes_mora_pagado'];
						//$interes_mora+=$cuota['interes_mora_deuda'];
						echo ' <p>debe:'.$interes_mora.' de interes de mora</p>';
						if($dinero>=$interes_mora){
							$cuota['interes_mora_pagado']=$interes_mora;
							$dinero-=$interes_mora;
						}
						else{
							$cuota['interes_mora_pagado']=$dinero;
							$cuota['interes_mora_deuda']=$interes_mora-$dinero;
							$cuota['fecha_ult_abono_cap']=$fecha_cuota;
							$dinero=0;
						}
					}
					$dinero=0;
				}
				else{
					break;
				}
			}
			//$dias_credito=
			//$interes_corriente_generado=
			foreach ($cuotas as $cuota) {
				$fecha_cuota=new DateTime($cuota['fechaCuota']);
				$interes_corriente_pagado=$cuota['interes_corriente_pagado'];
				$interes_corriente=$cuota['interesCuota'];
				//while ( $dinero>0) {

				//}
			}
			$i++;
		}
		
		foreach ($cuotas as $cuota) {
			
		}			
	}
}
