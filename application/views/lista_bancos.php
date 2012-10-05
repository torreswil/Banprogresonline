<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <style type="text/css" media="screen">
			@import "<?php echo base_url()?>css/site_jui.css";
			@import "<?php echo base_url()?>css/demo_table_jui.css";
			@import "<?php echo base_url()?>css/jquery-ui-1.7.2.custom.css";
			
			/*
			 * Override styles needed due to the mix of three different CSS sources! For proper examples
			 * please see the themes example in the 'Examples' section of this site
			 */
			.dataTables_info { padding-top: 0; }
			.dataTables_paginate { padding-top: 0; }
			.css_right { float: right; }
			#tabla_wrapper .fg-toolbar { font-size: 0.8em }
			#theme_links span { float: left; padding: 2px 10px; }
			#tabla_wrapper { -webkit-box-shadow: 2px 2px 6px #666; box-shadow: 2px 2px 6px #666; border-radius: 5px; }
			#tabla tbody {
				border-left: 1px solid #AAA;
				border-right: 1px solid #AAA;
			}
			#tabla thead th:first-child { border-left: 1px solid #AAA; }
			#tabla thead th:last-child { border-right: 1px solid #AAA; }
		</style>
		<script type="text/javascript" language="javascript" src="<?php echo base_url()?>js/jquery.js"></script>
		<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
		<script type="text/javascript" language="javascript" src="<?php echo base_url()?>js/jquery.dataTables.js"></script>
		
		<script type="text/javascript" charset="utf-8">
	var geocoder;
	var map;
	
	// initializing the map
	function initialize()
	{
		// define map center
		var latlng = new google.maps.LatLng(5.175727788050049,-72.5684826660156);
		// define map options
			  var myOptions = {
    zoom: 11,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    center: latlng
  };
		
		
		// initialize map
		map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		
		// add event listener for when a user clicks on the map
		google.maps.event.addListener(map, 'click', function(event) {
			findAddress(event.latLng);
		});
	}
	
	// finds the address for the given location

	// initialize the array of markers
	var markers = new Array();
	
	// the function that adds the markers to the map
	function addMarkers()
	{
		// get the values for the markers from the hidden elements in the form
		var lats = document.getElementById('lats').value;
		var lngs = document.getElementById('lngs').value;
		var names = document.getElementById('names').value;
		
		var las = lats.split(";;")
		var lgs = lngs.split(";;")
		var nms = names.split(";;")
		
		// for every location, create a new marker and infowindow for it
		for (i=0; i<las.length; i++)
		{
			if (las[i] != "")
			{
				// add marker
				var loc = new google.maps.LatLng(las[i],lgs[i]);
				var marker = new google.maps.Marker({
					position: loc, 
					map: window.map,
					title: nms[i]
				});
				
				markers[i] = marker;
				
				var contentString = [
				  '<div id="tabs">',
				  '<ul>',
					'<li><a href="#tab-1"><span>photo</span></a></li>',
					'<li><a href="#tab-2"><span>description</span></a></li>',
					'<li><a href="#tab-3"><span>location</span></a></li>',
				  '</ul>',
				  '<div id="tab-1">',
					'<p><h1>'+nms[i]+'</h1></p>',
				  '</div>',
				  '<div id="tab-2">',
				   '<p><h1>'+nms[i]+'</h1></p>',
				  '</div>',
				  '<div id="tab-3">',
					'<p><h1>'+nms[i]+'</h1></p>',
				  '</div>',
				  '</div>'
				].join('');
				
				//var infowindow = new google.maps.InfoWindow;
				
				//bindInfoWindow(marker, window.map, infowindow, contentString);
			}
		}
	}
	
	// make conection between infowindow and marker (the infowindw shows up when the user goes with the mouse over the marker)
	function bindInfoWindow(marker, map, infoWindow, contentString)
	{
		google.maps.event.addListener(marker, 'mouseover', function() {
			
			map.setCenter(marker.getPosition());
			
			infoWindow.setContent(contentString);
			infoWindow.open(map, marker);
			$("#tabs").tabs();
		 });
	}
	
	// highlighting a marker
		// make the marker show on top of the others
		// change the selected markers icon
	function highlightMarker(index)
	{
		// change zindex and icon
		for (i=0; i<markers.length; i++)
		{
			if (i == index)
			{
				markers[i].setZIndex(10);
				markers[i].setIcon('http://www.google.com/mapfiles/arrow.png');
			}
			else
			{
				markers[i].setZIndex(2);
				markers[i].setIcon('http://www.google.com/mapfiles/marker.png');
			}
		}
	}
		$(document).ready(function() {
		oTable = $('#tabla').dataTable({
		"bJQueryUI": true,
		"sPaginationType": "full_numbers"
			});
		} );
		</script>
        
</head>
<body  class="grid_2_3" onload="initialize(); addMarkers()">
		<div id="fw_container"
			<div id="fw_content">
				<div class="well row">
				<h1 class="span6"><?php echo $titulo ?></h1>
					<a class="btn btn-large btn-primary offset4" style="float: right" href="<?php echo base_url().'index.php/banco/add';?>">Nuevo Banco</a>
				<div class="clear"></div>
				
				</div>
				<br>
				<div class="well">
					<div id="map_canvas" style="width:100%; height:400px"></div>
					<a class="btn btn-large btn-primary offset4" style="float: right" href="<?php echo base_url().'index.php/banco/add/','Add';?>">Nuevo Banco</a>
					<div class="clear"></div>
				</div>
								
        		<table cellpadding="0" cellspacing="0" border="0" class="display" id="tabla">
				<thead>
				<tr>
					<th>Nombre</th>	
					<th>Departamento</th>
					<th>Municipio</th>
					<th>Vereda</th>
					<th>Direccion</th>
					<th>Fecha creacion</th>
					<th></th>
		            <th></th>
				</tr>

				</thead>
				<tbody>
					<?php
						$lats = "";			// string with latitude values
						$lngs = "";			// string with longitude values	// string with address values
						$names = "";
						$i=0;
					?>
			
					<?php foreach($query->result()as $fila): ?>
						<tr class="odd gradeX">	
							<td><a onmouseover="highlightMarker(<?php echo $i;?>)"><?php echo $fila->Nombre;?></a></td>
							<td><?php echo $fila->Departamento;?></td>
							<td><?php echo $fila->Muncipio;?></td>
							<td><?php echo $fila->Vereda;?></td>	
							<td><?php echo $fila->Direccion;?></td>
							<?php 
							$lats .= $fila->Latitud.";;";
							$lngs .= $fila->longitud.";;";
							$names .= $fila->Nombre.";;";
							
							?>
							
							<td><?php echo $fila->Fecha;?></td>
							<td><a class="btn btn-success" href="<?php echo base_url().'index.php/banco/edit/'.$fila->Id;?>"><i class="icon-refresh icon-white"></i> Editar</a></td>
							<td><?php echo anchor(base_url().'index.php/banco/delete/'.$fila->Id,'<i class="icon-trash icon-white"></i> Eliminar',array('class'=>'btn btn-danger','onClick'=>'return deletechecked(\' '.base_url().'index.php/banco/delete/'.$fila->Id.' \')'));?></td>	
						</tr>
						
					<?php $i++; endforeach;?>
				</tbody>
				<tfoot>
					<tr>
						<th></th>
						<th></th>
						<th></th>
                        <th></th>
                        <th></th>
                        <th></th>
					</tr>
				</tfoot>
</table>
<br>


<script type="text/javascript">
function deletechecked(link)
{
    var answer = confirm('Desea borrar este Banco?')
    if (answer){
        window.location = link;
    }
    
    return false;  
}

</script>
<input type="hidden" value="<?php echo $lats;?>" id="lats" name="lats"/>
<input type="hidden" value="<?php echo $lngs;?>" id="lngs" name="lngs"/>
<input type="hidden" value="<?php echo $names;?>" id="names" name="names"/>
</div>
</div>
</div>

