<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="<?php echo base_url()?>images/favicon.ico" />
        <title>Banco<?php echo " ".$detalles_banco->nombre_banco?></title>
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
		<link rel="stylesheet" href="<?php echo base_url()?>css/banprogreso.css">
		<script type="text/javascript" language="javascript" src="<?php echo base_url()?>js/jquery.js"></script>
		<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
		<script type="text/javascript" language="javascript" src="<?php echo base_url()?>js/jquery.dataTables.js"></script>
		
		<script type="text/javascript" charset="utf-8">

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
				<h1 class="span9">Banco Comunal <?php echo " ". $detalles_banco->nombre_banco?></h1>
				</div>
				<div class="well row">
				<a class="btn btn-large btn-primary" style="float: right" href="<?php echo base_url().'personas/add/'.$detalles_banco->id;?>">Nuevo Cliente</a>
				<h3>Clientes</h3>
					<?php echo $clientes?>
				</div>

<script type="text/javascript">
	function deletechecked(link)
	{
	    var answer = confirm('Desea borrar este Cliente?')
	    if (answer){
	        window.location = link;
	    }
	    
	    return false;  
	}
</script>