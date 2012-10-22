$(document).ready(function(){

	$('#amort').click(function(){
		mostrarCuotas();
	});

	$('#monto,#plazo,#periodo_capital,#periodo_intereses').keyup(function(){

		mostrarCuotas();

	});
	$('#fecha_desembolso').focusout(function(){

		mostrarCuotas();

	});

})


function mostrarCuotas(){
		var monto = $('#monto').val();
		
		var plazo = $('#plazo').val();
		var interes = 1;
		var pInteres = $('#periodo_intereses').val();//Periodo de pago de intereses (mensual,trimestral,semestras,etc)
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


	function calcularNumAbonos(plazo,periodo){
		if(plazo%periodo==0){
			return plazo/periodo;
		}
		else{
			var num = Math.floor(plazo/periodo)+1;
			return num;
		}
	}

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
		
		for(mes=1;mes<=plazo;mes++){

			interesAdeudado+=saldo*(interes/100);
			capitalCuota=0;
			interesCuota=0;

			//En 3 casos se crea una nueva cuota, si se vence interes, si se vence capital o si se vence el saldo.
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

};


function calcularNumAbonos(plazo,periodo){
	if(plazo%periodo==0){
		return plazo/periodo;
	}
	else{
		return (plazo/periodo)+1;
	}
}

function cerosIzq(sVal, nPos){
var sRes = sVal;
for (var i = sVal.length; i < nPos; i++)
 sRes = "0" + sRes;
return sRes;
}


function armaFecha(nDia, nMes, nAno){
var sRes = cerosIzq(String(nAno), 4);
sRes = sRes + "-" + cerosIzq(String(nMes), 2);
sRes = sRes + "-" + cerosIzq(String(nDia), 2);
return sRes;
}


function sumaMes(nDia, nMes, nAno, nSum){

	if (nSum >= 0){
		for (var i = 0; i < Math.abs(nSum); i++){
			if (nMes == 12){
				nMes = 1;
				nAno += 1;
			} else nMes += 1;
		}
	} else {
		for (var i = 0; i < Math.abs(nSum); i++){
			if (nMes == 1){
				nMes = 12;
				nAno -= 1;
			} else nMes -= 1;
		}
	}
	return armaFecha(nDia, nMes, nAno);
}



function calcularFecha(fechaInicial, meses){
var sFc1 = fechaInicial;
if (!isNaN(meses)){
 var nDia = parseInt(fechaInicial.substr(8, 2));
 var nMes = parseInt(fechaInicial.substr(5, 2));
 var nAno = parseInt(fechaInicial.substr(0, 4));
 sFc1 = sumaMes(nDia, nMes, nAno, meses);
}
return sFc1;
}
