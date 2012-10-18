
		var monto = $('#monto').val();
		var plazo = $('#plazo').val();
		var interes = 1;
		var pInteres = $('#periodo_intereses').val();//Periodo de pago de intereses (mensual,trimestral,semestras,etc)
		var pCapital = $('#periodo_capital').val();//Periodo pago de capital(mensual,trimestral,semestras,etc)
		var fechaInicial = $('#fecha_desembolso').val();//Es la fecha que se toma para iniciar a correr el credito, se supone que es valida desde el html.

		var credito new Credito(monto,plazo,interes,pInteres,pCapital,fechaInicial);





		


	function Cuota(numero,fecha,valor,intereses,capital,saldo){

		var numero=numero;
		var fecha=fecha;
		var valor = valor;
		var intereses=intereses;
		var capital = capital;
		var papeleria = papeleria;
		var seguro = seguro;
		var saldo = saldo;

		var tomarNumero = function(){
			return = numero;
		};

		var tomarFecha = function(){
			return = fecha;
		};

		var tomarValor = function(){
			return = valor;
		};

		var tomarIntereses = function(){
			return = intereses;
		};
		var tomarCapital = function(){
			return = capital;
		};

		var tomarPapeleria = function(){
			return = papeleria;
		};

		var tomarSeguro = function(){
			return = seguro;
		};

		var tomarSaldo = function(){
			return = saldo;
		};

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



		var calcularNumAbonos = function(plazo,periodo){
			if(plazo%periodo==0){
				return plazo/periodo;
			}
			else{
				return (plazo/periodo)+1;
			}
		}



		var calcularCuotas= function(){
			
			var saldo=monto;
			var interesAdeudado=0;
			var numCuota = 0;
			var interesCuota =0;
			var capitalCuota = 0;//lo que se pagara en la cuota, este valor se pasa cuando se cree la cuota.
			var fechaCuota = "";
			
			for(mes=1;mes<=plazo;mes++){

				interesAdeudado+=saldo*(interes/100);

				if(mes%pIntereses==0 || mes%pCapital==0){
					
					fechaCuota=calcularFecha(fechaInicial,mes);

					if(mes%pInteres==0){						
						interesCuota=interesAdeudado;
						interesAdeudado=0;
					}

					if(mes%pCapital==0){
						capitalCuota=valorCuotaCapital;
						capitalAdeudado=0;
						saldo-=capitalCuota;
					}
					valorCuota=capitalCuota+interesCuota;
					numCuota+=1;

					var cuotas[mes-1] = new Cuota(numCuota,fechaCuota,valorCuota,interesCuota,capitalCuota,saldo);
				}
				else if(mes==plazo&saldo>0){
					fechaCuota=calcularFecha(fechaInicial,mes);
					interesCuota=interesAdeudado;
					capitalCuota=valorCuotaCapital;
					interesAdeudado=0;
					valorCuota=capitalCuota+interesCuota;
					saldo-=capitalCuota;

					var cuotas[mes-1] = new Cuota(numCuota,fechaCuota,valorCuota,interesCuota,capitalCuota,saldo);
				}
			}
		}


		var armarCuotas = function(){


		}

	};



			function cerosIzq(sVal, nPos){
		    var sRes = sVal;
		    for (var i = sVal.length; i < nPos; i++)
		     sRes = "0" + sRes;
		    return sRes;
		   }

		 
		   function armaFecha(nDia, nMes, nAno){
		    var sRes = cerosIzq(String(nAno), 4);
		    sRes = sRes + "-" + cerosIzq(String(nMes), 2);
		    sRes = sRes + "-" + cerosIzq(String(nAno), 2);
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
		    if (!isNaN(nSum)){
		     var nDia = parseInt(sFc0.substr(8, 2));
		     var nMes = parseInt(sFc0.substr(5, 2));
		     var nAno = parseInt(sFc0.substr(0, 4));
		     sFc1 = sumaMes(nDia, nMes, nAno, nSum);
		    }
		    return sFc1;
		   }