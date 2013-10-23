<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="<?php echo base_url()?>images/favicon.ico" />
        <title><?php echo $banco->nombre_banco." - ".$cliente->Nombre1." ".$cliente->Apellido1?></title>
        <link rel="stylesheet"  href="<?php echo base_url()?>css/bootstrap.css"/>
        <link rel="stylesheet" href="<?php echo base_url()?>css/banprogreso.css">
        <script type="text/javascript" src="<?php echo base_url()?>js/jquery.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>js/credito.js"></script>
	</head>
	<body>
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <ul class="nav">
            <li><a id='logo' href='<?php echo base_url() ?>banco' title='Fleetio homepage'>
            <img  width="150" src="<?php echo base_url() ?>images/Logotipo Banprogreso.png" />
          </a></li>
            <li>
              <a href="<?php echo base_url() ?>banco">Inicio</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
      <div class="container espacio">
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
                <input class="input-xlarge" id="abonUrl" type="hidden" name="url" value="<?php echo base_url()?>" />
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
                </table>
              </div> 
              <div id="errores"></div>
            </div>                  
          </div>
        </div>
      </div>
    </div>
    <div id="footer">
      <center>
        <p>Desarrollado por: <a href="https://twitter.com/Wiltoco">Wilfredo Torres  @wiltoco</a></p>
      <img id="logo-footer" width="150" src="<?php echo base_url() ?>images/Logo Amanecer WEB 2.jpg" />
      </center>
    </div>
			

	</body>
</html>