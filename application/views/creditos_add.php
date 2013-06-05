
<!DOCTYPE >
<html lang="es" >
<head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <title>Registrar Credito</title>
      <link href="<?php echo base_url()?>css/banprogreso.css" rel="stylesheet">
      <link href="<?php echo base_url()?>css/datepicker.css" rel="stylesheet">
      <link rel="stylesheet"  href="<?php echo base_url()?>css/bootstrap.css">
      <script type="text/javascript" src="<?php echo base_url()?>js/jquery.js"></script>
      <script type="text/javascript" src="<?php echo base_url()?>js/bootstrap-datepicker.js"></script>
      <script src="<?php echo base_url()?>js/amortizacion.js"></script>
      <style>
      .container {
            background: #fff;
      }
      #alert {
            display: none;
      }
      </style>

</head>
<body>
      <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
            <div class="container">
                        <ul class="nav">
                          <li>
                            <a href="<?php echo base_url() ?>banco">Inicio</a>
                          </li>
                        </ul>
                </div>
            </div>
      </div>
      <div class="container espacio">
              
            <div class="span12">
                  <div class="row">
                        <div class="span12">
                              <h1 class="well">Registrar Credito</h1>
                        </div>
                  </div>

                  <div class="row">
                              <div class="span4">
                                    <div class="well">
                                          <legend>Datos del Cliente</legend>
                                          <table class="datos-cliente">
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
                              </div>

                              <div class="span8">
                                    <div class="well">
                                          <?php     
                                          $atributos = array('class' => 'form-horizontal');
                                          echo form_open(current_url(), $atributos); ?>
                                          <?php echo $custom_error; ?>
                                          <input type="hidden" id="carpeta" value="<?php echo base_url()?>">
                                          <input type="hidden" id="txtIdBanco" name="txtIdBanco" value="<?php echo $banco->id ?>">
                                          <input type="hidden" id="txtIdCliente" name="txtIdCliente" value="<?php echo $cliente->Identificacion ?>">
                                          <div id="intereses">
                                                <input type="hidden" id="txtIdCliente" name="txtIdCliente" value="<?php echo $cliente->Identificacion ?>">
                                          </div>
                                          <fieldset id="reg-credito">

                                                <legend>Establezca los Datos del Crédito </legend>

                                                <div class="control-group">
                                                      <label class="control-label" for="fecha_desemb">Fecha desembolso<span class="required">*</span></label>                                
                                                      <div class="controls">
                                                            <div class="input-append date" id="fecha_desemb" data-date="2012-10-10" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
                                                                  <input  size="16" type="text" id="fecha_desembolso" name="fecha_desembolso" value="<?php echo set_value('fecha_desembolso'); ?>">
                                                                  <span class="add-on"><i class="icon-calendar"></i></span>
                                                                  <p class="help-inline"><?php echo form_error('fecha_desembolso','<div>','</div>'); ?></p>
                                                            </div>
                                                      </div>
                                                </div>

                                                <div class="control-group">
                                                      <p><label class="control-label" for="monto">Monto <span class="required">*</span></label>   
                                                      <div class="controls">                             
                                                                  <input class="input-xlarge" type="number" id="monto" min="100000" max="50000000" step="100000" name="monto" value="<?php echo set_value('monto'); ?>"  />
                                                                  <?php echo form_error('monto','<div>','</div>'); ?>
                                                      </p>
                                                      </div>
                                                </div>


                                                <div class="control-group">
                                                      <p><label class="control-label" for="plazo">Plazo <span class="required">*</span></label>   
                                                      <div class="controls">                             
                                                                  <input class="input-xlarge"  placeholder="Meses" id="plazo" type="text" name="plazo" value="<?php echo set_value('plazo'); ?>"  />
                                                                  <?php echo form_error('plazo','<div>','</div>'); ?>
                                                      </p>
                                                      </div>
                                                </div>

                                                <div class="control-group">
                                                      <p><label class="control-label" for="periodo_intereses">Periodo intereses<span class="required">*</span></label>   
                                                      <div class="controls">                             
                                                            <input class="input-xlarge"  id="periodo_intereses" type="text" placeholder="Meses" name="periodo_intereses" value="<?php echo set_value('periodo_intereses'); ?>"  />
                                                            <?php echo form_error('periodo_intereses','<div class="controls">','</div>'); ?>
                                                      </p>
                                                      </div>
                                                </div>

                                                <div class="control-group">
                                                      <p><label class="control-label" for="periodo_capital">Periodo capital<span class="required">*</span></label>   
                                                      <div class="controls">                             
                                                            <input class="input-xlarge"  id="periodo_capital" type="text" placeholder="Meses" name="periodo_capital" value="<?php echo set_value('periodo_capital'); ?>"  />
                                                            <?php echo form_error('periodo_capital','<div>','</div>'); ?>
                                                      </p>
                                                      </div>
                                                </div>
                                                
                                                <div class="control-group">
                                                      <p><label class="control-label" for="linea_credito">Linea credito<span class="required">*</span></label>   
                                                      <div class="controls">                             
                                                                  <select class="span2" id="linea_credito" type="text" name="linea_credito" ><?php echo $lineas?></select>
                                                                  
                                                                  <?php echo form_error('linea_credito','<div>','</div>'); ?>
                                                      </p>
                                                      </div>
                                                </div>
                                                </fieldset>

                                                <div id="amortizar" class="control-group">
                                                           <?php 
                                                           $atrboton = array(
                                                            'class' => 'btn-large btn-primary span2',
                                                            );
                                                            echo form_submit( $atrboton,'Aprobar', 'Generar'); ?>
                                                </div>
                                          
                                          <?php echo form_close(); ?>
                                          <div class="final"></div>
                                    </div>
                              </div>
                  </div>
                  

                  <div class="row" >
                        <div id="amortizacion" class="span12">
                              <div class="well">
                                    <h3>Amortización</h3>
                                    <hr>
                                    <table class="table table-striped" id="tabla-pagos">
                                        <thead>
                                            <tr>
                                                <th>Cuota</th>
                                                <th>Fecha Pago</th>
                                                <th>Valor Cuota</th>
                                                <th>Intereses</th>
                                                <th>Capital</th>
                                                <th>Saldo</th>
                                          </tr>
                                          </thead>
                                          <tbody id="tabla-cuotas">
                                                
                                          </tbody>
                                    </table>
                              </div>
                        </div>
                  </div>
            </div>
      </div>
      <script>
      $(function(){
            window.prettyPrint && prettyPrint();

            $('#fecha_desemb').datepicker();

      });
      </script>

      <?php echo form_close(); ?>