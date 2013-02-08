
<!DOCTYPE >
<html lang="es" >
<head>
	<meta charset="utf-8" />
	<title><?php echo $titulo?></title>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<link rel="stylesheet"  href="<?php echo base_url()?>css/bootstrap.css"/>
	<script type="text/javascript" src="<?php echo base_url()?>js/jquery.js"></script>
	<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
	
	
	
	
	<script type="text/javascript">
		var path = '<?php echo base_url()?>';
		jQuery(document).ready(function(){
			cargarmunicipios();
			$('#sdep').change(cargarmunicipios);
		});
		
		function cargarmunicipios () {
			var cd = $('#sdep').val();

			$.get(path + 'banco/municipio', {'id' : cd}, function(resp) {
				$('#smun').empty().html(resp);
			});
		}


		
	</script>
	
	<script type="text/javascript">
var stockholm = new google.maps.LatLng(5.175727788050049,-72.5684826660156);
var parliament = new google.maps.LatLng(5.175727788050049,-72.5684826660156);
var marker;
var map;
var geocoder;

function initialize() {
  var mapOptions = {
    zoom: 11,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    center: stockholm
  };

  map = new google.maps.Map(document.getElementById("map_canvas"),
      mapOptions);

  marker = new google.maps.Marker({
    map:map,
    draggable:true,
    animation: google.maps.Animation.DROP,
    position: parliament
  });
  google.maps.event.addListener(marker, 'click', toggleBounce);
  google.maps.event.addListener(marker, 'mouseup', function(event) {
			findAddress(event.latLng);
		});
}

function toggleBounce() {

  if (marker.getAnimation() != null) {
    marker.setAnimation(null);
  } else {
    marker.setAnimation(google.maps.Animation.BOUNCE);
    

  }
}	

	function findAddress(loc)
	{
		geocoder = new google.maps.Geocoder(); 
		
		if (geocoder) 
		{
			geocoder.geocode({'latLng': loc}, function(results, status) 
			{
				if (status == google.maps.GeocoderStatus.OK) 
				{
					if (results[0]) 
					{
						address = results[0].formatted_address;
						
						// fill in the results in the form
						document.getElementById('latitud').value = loc.lat();
						document.getElementById('longitud').value = loc.lng();
					}
				} 
				else 
				{
					alert("Geocoder failed due to: " + status);
				}
			});
		}
	}	
	// finds the address for the given location
		

</script>
</head>
<body onload="initialize()">
	<div class="container">
		<div class="row">
			<div class="offset0 span11 well">
				<h1 class="offset2"><?php echo $titulo ?></h1>
			</div>
		</div>
		<div class="row">
			<div class="offset0 span3 well">

<?php     

echo form_open(current_url()); ?>
<?php echo $custom_error; ?>

                                    <p><label for="id">Código<span class="required">*</span></label>                                
                                    <input id="id" type="text" name="id" value="<?php echo set_value('id'); ?>"  />
                                    <?php echo form_error('id','<div>','</div>'); ?>
                                    </p>
                                    

                                    <!--p><label for="departamento">Departamento<span class="required">*</span></label>                                
                                    <input id="departamento" type="text" name="departamento" value="<?php echo set_value('departamento'); ?>"  />
                                    <?php echo form_error('departamento','<div>','</div>'); ?>
                                    </p-->
                                    
                                    <?php echo form_label('Departamento:') ?>
									<?php echo form_dropdown('departamento',$dptos,set_value('departamento'),"id='sdep'"); ?>
									<?php echo form_error('departamento','<div>','</div>'); ?>
									
									
									<?php echo form_label('Municipio') ?>
									<?php echo form_dropdown('municipio',array(), set_value('municipio'),"id='smun'"); ?>
									<?php echo form_error('municipio','<div>','</div>'); ?>	
									
                                    <p><label for="nombre_banco">Nombre<span class="required">*</span></label>                                
                                    <input id="nombre_banco" type="text" name="nombre_banco" value="<?php echo set_value('nombre_banco'); ?>"  />
                                    <?php echo form_error('nombre_banco','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="localidad">Vereda/Barrio<span class="required">*</span></label>                                
                                    <input id="localidad" type="text" name="localidad" value="<?php echo set_value('localidad'); ?>"  />
                                    <?php echo form_error('localidad','<div>','</div>'); ?>
                                    </p>
                                    

                                    <!--p><label for="municipio">Municipio<span class="required">*</span></label>                                
                                    <input id="municipio" type="text" name="municipio" value="<?php echo set_value('municipio'); ?>"  />
                                    <?php echo form_error('municipio','<div>','</div>'); ?>
                                    </p-->
                                    

                                    <p><label for="direccion">Direccion<span class="required">*</span></label>                                
                                    <input id="direccion" type="text" name="direccion" value="<?php echo set_value('direccion'); ?>"  />
                                    <?php echo form_error('direccion','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label  for="longitud">Longitud</label>                                
                                    <input readonly id="longitud" type="text" name="longitud" value="<?php echo set_value('longitud'); ?>"  />
                                    <?php echo form_error('longitud','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="latitud">Latitud</label>                                
                                    <input id="latitud" type="text" name="latitud" readonly value="<?php echo set_value('latitud'); ?>"  />
                                    <?php echo form_error('latitud','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="fecha_creacion">Fecha de creación<span class="required">*</span></label>                                
                                    <input id="fecha_creacion" type="text" name="fecha_creacion" value="<?php echo set_value('fecha_creacion'); ?>"  />
                                    <?php echo form_error('fecha_creacion','<div>','</div>'); ?>
                                    </p>
                                    
<p>
        <input type="submit" name="username" id="submit" value="Guardar" class="btn btn-primary"/>
</p>

<?php echo form_close(); ?>

			</div>
			
			
			<div class="span7 well">
				<h4>Arrastre el marcador y sueltelo en el punto en el que se encuentra situada la oficina del banco. Para guiarse mejor puede utilizar la vista Satelite</h4><br>
				<div id="map_canvas" style="width:100%; height:432px"></div>
			</div>

		</div>
	</div>
</body>
</html>
