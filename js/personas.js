var path = '<?php echo base_url()?>';
$(document).ready(function(){
	$('input#id,input#banco').focusout(function(){

		var banco = $('#banco').val();
		var persona = $('#id').val();
		$.get(path + 'index.php/personas/devolver_persona_ajax', {'id_banco' : banco,'id_persona': persona}, function(resp) {
		if (resp == persona && resp!==''){
			$('#advert').empty().html('Esta persona ya fue registrada en este banco');
			$('#guardar_persona').attr('disabled',"disabled");
			$('#advert').fadeIn(400);
		} 
      	})
		
	})

	$('input#id,input#banco').focusin(function(){
		$('#guardar_persona').removeAttr('disabled');
		$('#advert').fadeOut(400);
	})

})