<?php if (!defined('BASEPATH')) exit('No permitir el acceso directo al script'); 

class Cuotas {

    function calcular_cuotas($credito)
    {
    	$valorCuota=0;
		$saldo=$credito->monto;
		$plazo=$credito->plazo;
		$interesAdeudado=0;
		$numCuota = 0;
		$interes=$credito->interes_corriente;
		$interesCuota =0;
		$capitalCuota = 0;//lo que se pagara en la cuota, este valor se pasa cuando se cree la cuota.
		$fechaCuota = "";
		$mes = 0;
		$monto=$credito->monto;
		$cuotas= array();
		$fechaInicial=$credito->fecha_desembolso;
		$pInteres=$credito->periodo_intereses;
		$pCapital=$credito->periodo_capital;
		$numAbonosInteres = ceil($plazo/$pInteres);
		$numAbonosCapital = ceil($plazo/$pCapital);
		$valorCuotaCapital = $monto/$numAbonosCapital;
		
		if($pInteres==$pCapital){
			$numCuotas=ceil($plazo/$pInteres);
			$potencia=pow((1+($interes/100)),$numCuotas);
			$cuotaFija= ($monto*(($interes*$potencia)/($potencia-1)))/100;
			for($mes=1;$mes<=$plazo;$mes++){
				$capitalCuota=0;
				$interesCuota=0;
				if($mes%$pCapital==0 || $mes==$plazo){
					$fechaCuota=calcularFecha($fechaInicial,$mes);
					$interesCuota=$saldo*($interes/100)*$pCapital;
					$capitalCuota=$cuotaFija-$interesCuota;
					$saldo-=$capitalCuota;
					$valorCuota=$capitalCuota+$interesCuota;
					$numCuota+=1;
					$cuotas[$numCuota-1] = array('numCuota'=>$numCuota,'fechaCuota'=>$fechaCuota,'valorCuota'=>$valorCuota,'interesCuota'=>$interesCuota,'capitalCuota'=>$capitalCuota,'saldo'=>$saldo, 'interes_mora_pagado'=>0,'interes_corriente_pagado'=>0,'capital_pagado'=>0,'fecha_ult_abono_cap'=>$fechaCuota, 'deuda_capital'=>$capitalCuota,'interes_mora_deuda'=>0);
				}
			}
		}	
		else{
			for($mes=1;$mes<=$plazo;$mes++){

				$interesAdeudado+=$saldo*($interes/100);
				$capitalCuota=0;
				$interesCuota=0;

				//En 3 casos se crea una nueva cuota, si se vence interes, si se vence capital o si se vence el PLAZO.
				if($mes%$pInteres==0 || $mes%$pCapital==0 || $mes==$plazo){
					
					$fechaCuota=$this->calcularFecha($fechaInicial,$mes);

					if($mes%$pInteres==0){				//Si se vence interes		
						$interesCuota=$interesAdeudado;	//Se asigna el interes para esta cuota
						$interesAdeudado=0;				//Se reinicia la variable. Ya no se debe intereses.
					}

					if($mes%$pCapital==0){				//Si se vence Capital
						$capitalCuota=$valorCuotaCapital;	//Se asigna el Capital que se paga en esta cuota.
						$capitalAdeudado=0;
					}
					

					if($mes>=$plazo&&$saldo>0){
					$capitalCuota=$saldo;

						if($interesCuota==0){
							$interesCuota=$interesAdeudado;
						}
					}

					$valorCuota=$capitalCuota+$interesCuota;
					$numCuota+=1;
					$saldo-=$capitalCuota;
					$cuotas[$numCuota-1] = array('numCuota'=>$numCuota,'fechaCuota'=>$fechaCuota,'valorCuota'=>$valorCuota,'interesCuota'=>$interesCuota,'capitalCuota'=>$capitalCuota,'saldo'=>$saldo, 'interes_mora_pagado'=>0,'interes_corriente_pagado'=>0,'capital_pagado'=>0,'fecha_ult_abono_cap'=>$fechaCuota, 'deuda_capital'=>$capitalCuota,'interes_mora_deuda'=>0);
				}
			}
		}

		return $cuotas;
	}

	function calcularFecha($fechaInicial, $meses){
		$fecha = new DateTime($fechaInicial);
		$intervalo = new DateInterval('P'.$meses.'M');
		$fecha->add($intervalo);
		return $fecha->format('Y-m-d');
	}
}