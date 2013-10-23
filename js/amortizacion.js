$(document).ready(function(){

	var path = $('#carpeta').val();
	var linea = $('#linea_credito').val();
	var banco = $('#txtIdBanco').val();
	$.get(path + 'creditos/linea', {'id' : linea, 'banco' : banco}, 
		function(resp) {
				$('#intereses').empty().html(resp);
			});


	$('#amort').click(function(){
		mostrarCuotas();
	});

	$('#monto,#plazo,#periodo_capital,#periodo_intereses').keyup(function(){
		mostrarCuotas();
	});

	$('#monto,#fecha_desembolso').change(function(){
		mostrarCuotas();
	});

	$('#fecha_desembolso').focusout(function(){

		mostrarCuotas();
	});

	$('#linea_credito').change(function(){
	var path = $('#carpeta').val();
	var linea = $('#linea_credito').val();
	var banco = $('#txtIdBanco').val();
	$.get(path + 'creditos/linea', {'id' : linea, 'banco' : banco}, 
		function(resp) {
				$('#intereses').empty().html(resp);
				mostrarCuotas();
			})
	
	});


})

function mostrarCuotas(){
		var monto = $('#monto').val();
		
		var plazo = $('#plazo').val();
		var interes = $('#corriente').html();
		var pInteres = $('#periodo_intereses').val(); //Periodo de pago de intereses (mensual,trimestral,semestras,etc)
		var pCapital = $('#periodo_capital').val();//Periodo pago de capital(mensual,trimestral,semestras,etc)
		var fechaInicial = $('#fecha_desembolso').val();//Es la fecha que se toma para iniciar a correr el credito, se supone que es valida desde el html.
		$('#tabla-cuotas').empty();
		if(monto!==''& plazo!==''& interes!==''& pInteres!==''& pCapital!==''& fechaInicial!==''){

			var credito = new Credito(monto,plazo,interes,pInteres,pCapital,fechaInicial);

			
			credito.calcularCuotas();

			var cuotas = credito.tomarCuotas();
			var cuota='';
			var valorPropiedad = '';
			for(i=0;i<cuotas.length;i++){
				
				cuota=cuotas[i];
				datos=cuota.tomarDatosCuota();
				$('#tabla-cuotas').append(datos);
			}

			$('#amortizacion').slideDown(400);
		}

};


function Cuota(numero,fecha,valor,intereses,capital,saldo){

	var numero=numero;
	var fecha=fecha;
	var valor = valor;
	var intereses=intereses;
	var capital = capital;
	var saldo = saldo;

	this.tomarDatosCuota = function(){
		var datos = '<tr><td>'+numero+'</td><td>'+fecha+'</td><td>$ '+valor.toFixed(0)+'</td><td>$ '+intereses.toFixed(0)+'</td><td>$'+capital.toFixed(0)+'</td><td>$ '+saldo.toFixed(0)+'</td></tr>';
		return datos;

	}
};



function Credito(monto,plazo,interes,pInteres,pCapital,fechaInicial){

	var monto =monto;
	var plazo =plazo;
	var interes =interes;//El porcentaje que se pacta como interes mensual.
	var pInteres = pInteres;
	var pCapital =pCapital;
	var fechaInicial = fechaInicial;
	var cuotas = [];
	var numAbonosInteres = calcularNumAbonos(plazo,pInteres);
	var numAbonosCapital = calcularNumAbonos(plazo,pCapital);
	var valorCuotaCapital = monto/numAbonosCapital;


	this.tomarCuotas = function(){
			return cuotas;
		};

	this.calcularCuotas= function(){
		var valorCuota=0;
		var saldo=monto;
		var interesAdeudado=0;
		var numCuota = 0;
		var interesCuota =0;
		var capitalCuota = 0;//lo que se pagara en la cuota, este valor se pasa cuando se cree la cuota.
		var fechaCuota = "";
		var mes = 0;
		var numCuotas = 0;
		var potencia = 0;
		var cuotaFija = 0;
		var mesesAdeudados = 0;
		if(pInteres==pCapital){
			numCuotas=Math.ceil(plazo/pInteres);
			potencia=Math.pow((1+(interes*pInteres/100)),numCuotas);
			cuotaFija= ((monto*((interes*potencia)/(potencia-1)))/100)*pInteres;

			for(mes=1;mes<=plazo;mes++){
				capitalCuota=0;
				interesCuota=0;
				mesesAdeudados++;
				if(mes%pCapital==0 || mes==plazo){
					fechaCuota=calcularFecha(fechaInicial,mes);
					interesCuota=saldo*(interes/100)*mesesAdeudados;
					capitalCuota=cuotaFija-interesCuota;
					saldo-=capitalCuota;
					valorCuota=capitalCuota+interesCuota;
					numCuota+=1;
					cuotas[numCuota-1] = new Cuota(numCuota,fechaCuota,valorCuota,interesCuota,capitalCuota,saldo);
					mesesAdeudados=0;
				}
			}
		}	
		else{
			for(mes=1;mes<=plazo;mes++){

				interesAdeudado+=saldo*(interes/100);
				capitalCuota=0;
				interesCuota=0;

				//En 3 casos se crea una nueva cuota, si se vence interes, si se vence capital o si se vence el PLAZO.
				if(mes%pInteres==0 || mes%pCapital==0 || mes==plazo){
					
					fechaCuota=calcularFecha(fechaInicial,mes);

					if(mes%pInteres==0){				//Si se vence interes		
						interesCuota=interesAdeudado;	//Se asigna el interes para esta cuota
						interesAdeudado=0;				//Se reinicia la variable. Ya no se debe intereses.
					}

					if(mes%pCapital==0){				//Si se vence Capital
						capitalCuota=valorCuotaCapital;	//Se asigna el Capital que se paga en esta cuota.
						capitalAdeudado=0;
					}
					

					if(mes>=plazo&saldo>0){
					capitalCuota=saldo;

						if(interesCuota==0){
							interesCuota=interesAdeudado;
						}
					}

					valorCuota=capitalCuota+interesCuota;
					numCuota+=1;
					saldo-=capitalCuota;
					cuotas[numCuota-1] = new Cuota(numCuota,fechaCuota,valorCuota,interesCuota,capitalCuota,saldo);
				}
			}
		}
	}

	function calcularNumAbonos(plazo,periodo){
		if(plazo%periodo==0){
			return plazo/periodo;
		}
		else{
			var num = Math.floor(plazo/periodo)+1;
			return num;
		}
	}

};

function calcularFecha(fechaInicial, meses){
var sFc1 = new Date(fechaInicial);
/*if (!isNaN(meses)){
 var nDia = parseInt(fechaInicial.substr(8, 2));
 var nMes = parseInt(fechaInicial.substr(5, 2));
 var nAno = parseInt(fechaInicial.substr(0, 4));
 sFc1 = sumaMes(nDia, nMes, nAno, meses);
}*/
sFc1.setMonth(sFc1.getMonth()+meses);
return sFc1.toISOString().substr(0, 10);
}

