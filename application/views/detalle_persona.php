<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="<?php echo base_url()?>css/banprogreso.css">
        <title><?php echo $banco->nombre_banco." - ".$cliente->Nombre1." ".$cliente->Apellido1?></title>
        <link rel="stylesheet"  href="<?php echo base_url()?>css/bootstrap.css"/>
	</head>
	<body>
      <div class="container">

            <div class="row show-grid">
                  <div class="span12 well ">
                        <h1><?php echo $banco->nombre_banco." - ".$cliente->Nombre1." ".$cliente->Apellido1?></h1>
                  </div>
            </div>
             <div class="row show-grid">
                  <div class="span3 well">
                        <legend>Datos del Cliente</legend>
                        <table>
                        	<tr>
                        		<td><h4>Nombre:</h4></td>
                        		<td><?php echo $cliente->Nombre1." ".$cliente->Apellido1 ?></td>
                        	</tr>
                        	<tr>
                        		<td><h4>Identificacion:</h4></td>
                        		<td><?php echo $cliente->Identificacion?></td>
                        	</tr>
                        	<tr>
                        		<td><h4>Celular:</h4></td>
                        		<td><?php echo $cliente->Celular ?></td>
                        	</tr>
                        	<tr>
                        		<td><h4>Municipio:</h4></td>
                        		<td><?php echo $municipio->nombre_municipio ?></td>
                        	</tr>
                        	<tr>
                        		<td><h4>Vereda/Barrio:</h4></td>
                        		<td><?php echo $cliente->Vereda ?></td>
                        	</tr>
                        	<tr>
                        		<td><h4>Direccion:</h4></td>
                        		<td><?php echo $cliente->Direccion ?></td>
                        	</tr>
                        </table>
                        <a class="btn btn-success  btn-large" href="<?php echo base_url().'personas/edit/'.$cliente->Identificacion.'/'.$banco->id ?>"><i class="icon-refresh icon-white"></i> Editar</a>
                  </div>
                  <div class="span8 well">
                  	<a class="btn btn-large btn-primary offset4" style="float: right" href="<?php echo base_url().'creditos/add/'.$cliente->Identificacion.'/'.$banco->id?>">Nuevo Credito</a>
                  	<legend>Creditos Asignados</legend>

                    <table class="table table-striped" id="credito_asignados">
                                        <thead>
                                            <tr>
                                                <th>Codigo</th>
                                                <th>Monto</th>
                                                <th>Plazo</th>
                                                <th>Fecha</th>
                                          </thead>
                                          <tbody>
                                            <?php echo $creditos ?>
                                          </tbody>
                  </div>
            </div>
			

	</body>
</html>