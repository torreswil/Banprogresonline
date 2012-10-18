
<!DOCTYPE >
<html lang="es" >
<head>
      <meta charset="utf-8" />
      <title>Registrar Cliente</title>
      <link rel="stylesheet"  href="<?php echo base_url()?>css/bootstrap.css"/>
      <link href="<?php echo base_url()?>css/datepicker.css" rel="stylesheet">
      <link href="<?php echo base_url()?>css/banprogreso.css" rel="stylesheet">
      <script type="text/javascript" src="<?php echo base_url()?>js/jquery.js"></script>
      <script src="<?php echo base_url()?>js/bootstrap-datepicker.js"></script>
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
      <div class="container">

            <div class="row">
                  <div class="offset0 span12 well">
                        <h1>Registrar Credito</h1>
                  </div>
            </div>

            <div class="row">
                  <div class="span12 well">

                        <?php     
                        $atributos = array('class' => 'form-horizontal span1');
                        echo form_open(current_url(), $atributos); ?>
                        <?php echo $custom_error; ?>

                        <fieldset id="reg-credito">

                              <legend>Datos del Credito</legend>

                              <div class="control-group">
                                    <label class="control-label" for="fecha_desembolso">Fecha desembolso<span class="required">*</span></label>                                
                                    <div class="controls input-append date" id="fecha_desemb" data-date="2012-10-10" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
                                          <input  size="16" type="text" id="fecha_desembolso" name="fecha_desembolso" value="<?php echo set_value('fecha_desembolso'); ?>">
                                          <span class="add-on"><i class="icon-calendar"></i></span>
                                          <p class="help-inline"><?php echo form_error('fecha_desembolso','<div>','</div>'); ?></p>
                                    </div>
                              </div>

                              <div class="control-group">
                                    <p><label class="control-label" for="monto">Monto <span class="required">*</span></label>   
                                          <div class="controls">                             
                                                <input class="input-xlarge" type="number" id="monto" type="text" name="monto" value="<?php echo set_value('monto'); ?>"  />
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


                              <!--div class="control-group">
                                    <p><label class="control-label" for="linea_credito">Linea credito<span class="required">*</span></label>   
                                          <div class="controls">                             
                                                <input class="input-xlarge"  id="linea_credito" type="text" name="linea_credito" value="<?php echo set_value('linea_credito'); ?>"  />
                                                <?php echo form_error('linea_credito','<div>','</div>'); ?>
                                          </p>
                                    </div>
                              </div-->


                              <div class="control-group">
                                    <p><label class="control-label" for="periodo_intereses">Periodo intereses<span class="required">*</span></label>   
                                          <div class="controls">                             
                                                <input class="input-xlarge"  id="periodo_intereses" type="text" placeholder="Meses" name="periodo_intereses" value="<?php echo set_value('periodo_intereses'); ?>"  />
                                                <?php echo form_error('periodo_intereses','<div>','</div>'); ?>
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


                              <!--div class="control-group">
                                    <p><label class="control-label" for="fecha_registro">Fecha registro<span class="required">*</span></label>   
                                          <div class="controls">                             
                                                <input class="input-xlarge"  id="fecha_registro" type="text" name="fecha_registro" value="<?php echo set_value('fecha_registro'); ?>"  />
                                                <?php echo form_error('fecha_registro','<div>','</div>'); ?>
                                          </p>
                                    </div>
                              </div-->


                              <!--div class="control-group">
                                    <p><label class="control-label" for="transaccion">Transaccion<span class="required">*</span></label>   
                                          <div class="controls">                             
                                                <input class="input-xlarge"  id="transaccion" type="text" name="transaccion" value="<?php echo set_value('transaccion'); ?>"  />
                                                <?php echo form_error('transaccion','<div>','</div>'); ?>
                                          </p>
                                    </div>
                              </div-->


                              <div class="control-group">
                                    <div class="controls"> 
                                         <?php 
                                         $atrboton = array(
                                          'class' => 'btn btn-primary',
                                          'id'    => 'amortizar'
                                          );

                                          echo form_submit( $atrboton,'Generar', 'Generar'); ?>
                                    </div>
                              </div>

                              

                        </fieldset>
                        <?php echo form_close(); ?>
                  </div>
            </div>
            

            <div class="row" >
                  <div id="amortizacion" class="offset0 span12 well">
                        <h3>Amortización</h3>
                        <hr>
                        <table id="tabla-amort"class="table table-striped" id="tabla-pagos">
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
      <script>
      $(function(){
            window.prettyPrint && prettyPrint();

            $('#fecha_desemb').datepicker();

      });
      </script>

      <?php echo form_close(); ?>