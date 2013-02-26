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
                  <div class="span12">
                      <div class="well">
                        <h2><a href="<?php echo base_url().'banco/ver/'.$banco->id?>"><?php echo 'Banco '.$banco->nombre_banco?></a><?php echo ' - '.$cliente->Nombre1." ".$cliente->Apellido1?></h2>
                      </div>
                  </div>
            </div>
             <div class="row show-grid">
                  <div class="span4">
                    <div class="well">
                      <a class="btn btn-success  btn-small" style="float: right" href="<?php echo base_url().'personas/edit/'.$cliente->Identificacion.'/'.$banco->id ?>"><i class="icon-refresh icon-white"></i> Editar</a>
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
                        
                    </div>
                  </div>
                  <div class="span8">
                    <div class="well">
                      <div class="infor">
                    	<a class="btn btn-small btn-primary offset4" style="float: right" href="<?php echo base_url().'creditos/add/'.$cliente->Identificacion.'/'.$banco->id?>"><i class="icon-plus-sign icon-white"></i> Nuevo Credito</a>
                    	<legend>Creditos Aprobados</legend>

                      <table class="table table-striped" id="credito_asignados">
                                          <thead>
                                              <tr>
                                                  <th>Codigo</th>
                                                  <th>Monto</th>
                                                  <th>Plazo</th>
                                                  <th>Fecha</th>
                                                  <th><th>
                                            </thead>
                                            <tbody>
                                              <?php echo $creditos ?>
                                            </tbody>
                      </div> 
                    </div>                  
                  </div>
            </div>
			

	</body>
</html>