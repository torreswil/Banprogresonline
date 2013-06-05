$(document).ready(function(){
    $('#eliminar-credito').click(function(){
		eliminarCredito();
	});
});

function eliminarCredito(banco,credito,persona){
	if(confirm("Esta seguro que desea eliminar este credito?"))
    {
        var baseurl=$('#abonUrl').val();                  
        $.get(baseurl+"creditos/delete", {'banco': banco,'credito': credito,'persona': persona},
            function(respuesta)
            {
                alert(respuesta);
                location.reload(true);
            }                        
        )
    }
}