$(document).ready(function(){
    distriAbonos()
	$('#soporte,#valor,input#fecha_abono').keyup(function(){
		var soporte=$('#soporte').val();
		var valor=$('#valor').val();
		var fecha_abono=$('input#fecha_abono').val();
		
		if(soporte && valor && fecha_abono){
			$('#abonar').removeAttr('disabled');
		}
		else{
			$('#abonar').attr('disabled',"disabled");
		};

	});

	$('#abonar').click(function(){
		abonar();
	});

	$('#distri').click(function(){
		distriAbonos();
	});
});

function abonar(){
	var baseurl=$('#abonUrl').val();
	var datos=$('#frmAbonar').serialize();
	$.ajax({
            url: baseurl+"/abonos/abonar",
            type: "POST",
            data: datos,
            success:
                function(r)
                {
                    //alert(r);
                    $('input#soporte').val('');
                    $('input#valor').val('');
                    $('input#fecha_abono').val('');
                    //$('#myModal').modal('hide');
                    distriAbonos();
                    //location.reload(true);
                },
            error:  alert('No se pudo realizar este abono')
    });
};

function distriAbonos(){
	var carpeta= $('#carpeta').val()
	var banco= $('#txtIdBanco').val();
	var cliente=$('#txtIdCliente').val();
	var credito=$('#txtIdCredito').val();
	$.get(carpeta + 'abonos/distribuir_abonos', {'banco' : banco, 'cliente' : cliente, 'credito' : credito}, function(respuesta) {
                        $('#distri-abonos').empty().html(respuesta);
                  })
};

function eliminarAbono(banco,credito,abono){
    if(confirm("Esta seguro que desea eliminar este abono?"))
    {
        var baseurl=$('#abonUrl').val();                  
        $.get(baseurl+"abonos/delete", {'banco': banco,'credito': credito,'abono': abono},
            function(respuesta)
            {
                alert(respuesta);
                distriAbonos();
            }                        
        )
    }
};
