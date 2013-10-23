$(document).ready(function(){

	$('#tap-cartera').click(function(){
		recuperarSaldos();
	});
});
function recuperarSaldos(){
	var banco= $('#id-banco').val();
	var carpeta = $('#carpeta').val();
	$.get(carpeta + 'creditos/saldos', {'banco' : banco}, function(respuesta) {
                        $('#cartera').empty().html(respuesta);

                  })
}
