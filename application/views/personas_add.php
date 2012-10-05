
<!DOCTYPE >
<html lang="es" >
<head>
      <meta charset="utf-8" />
      <title>Registrar Cliente</title>
      <link rel="stylesheet"  href="<?php echo base_url()?>css/bootstrap.css"/>
      <link href="<?php echo base_url()?>css/datepicker.css" rel="stylesheet">
      <script type="text/javascript" src="<?php echo base_url()?>js/jquery.js"></script>
      <script src="<?php echo base_url()?>js/bootstrap-datepicker.js"></script>
      
      <script type="text/javascript">
               var path = '<?php echo base_url()?>';
            jQuery(document).ready(function(){
                  cargarmunicipiosRec();
                  cargarmunicipiosNac();
                  $('#sdep_rec').change(cargarmunicipiosRec);
                  $('#sdep_nac').change(cargarmunicipiosNac);
            });


            
            function cargarmunicipiosRec () {
                  var cd = $('#sdep_rec').val();

                  $.get(path + 'index.php/banco/municipio', {'id' : cd}, function(resp) {
                        $('#smun_rec').empty().html(resp);
                  });
            }

            function cargarmunicipiosNac () {
                  var cd = $('#sdep_nac').val();

                  $.get(path + 'index.php/banco/municipio', {'id' : cd}, function(resp) {
                        $('#smun_nac').empty().html(resp);
                  });
            }

      </script>
</head>
<body>
            <div class="container">
                  <div class="row">
                        <div class="offset0 span12 well">
                              <h1 class="offset2">Registrar Cliente</h1>
                        </div>
                  </div>
                  <div class="row">
                        <div class="offset2 span8 well">
                        <?php     
                              $atributos = array('class' => 'form-horizontal span1');
                              echo form_open(current_url(), $atributos); ?>
                              <?php echo $custom_error; ?>
                              <fieldset>
                                  <legend>Datos Personales</legend>
                                    <div class="control-group">
                                          <label class="control-label" for="banco">Banco<span class="required">*</span></label>                                
                                          <div class="controls">
                                                <input class="input-xlarge" id="banco" type="text" name="banco" value="<?php echo set_value('banco'); ?>"  />
                                                <p class="help-inline"><?php echo form_error('banco','<div>','</div>'); ?></p>
                                          </div>
                                    </div>
                                    
                                    <div class="control-group">
                                    <label class="control-label" for="id">Id<span class="required">*</span></label>                                
                                          <div class="controls">
                                                <input class="input-xlarge"  id="id" type="text" name="id" value="<?php echo set_value('id'); ?>"  />
                                                <p class="help-inline"><?php echo form_error('id','<div>','</div>'); ?></p>
                                          </div>
                                    </div>
                                    
                                    <div class="control-group">
                                    <label class="control-label" for="tipo_id">Tipo_id<span class="required">*</span></label>                                
                                          <div class="controls">
                                                <input class="input-xlarge"  id="tipo_id" type="text" name="tipo_id" value="<?php echo set_value('tipo_id'); ?>"  />
                                                <p class="help-inline"><?php echo form_error('tipo_id','<div>','</div>'); ?></p>
                                          </div>
                                    </div>
                                    
                                    <div class="control-group">
                                    <label class="control-label" for="nombre1">Nombre1<span class="required">*</span></label>                                
                                          <div class="controls">
                                                <input class="input-xlarge"  id="nombre1" type="text" name="nombre1" value="<?php echo set_value('nombre1'); ?>"  />
                                                <p class="help-inline"><?php echo form_error('nombre1','<div>','</div>'); ?></p>
                                          </div>
                                    </div>
                                    
                                    <div class="control-group">
                                          
                                          <label class="control-label" for="nombre2">Nombre2</label>                                
                                          <div class="controls">
                                          <input class="input-xlarge"  id="nombre2" type="text" name="nombre2" value="<?php echo set_value('nombre2'); ?>"  />
                                          <p class="help-inline"><?php echo form_error('nombre2','<div>','</div>'); ?></p>
                                          </div>
                                    </div>
                                    
                                    <div class="control-group">
                                          <label class="control-label" for="apellido1">Apellido1<span class="required">*</span></label>                                
                                          <div class="controls">
                                          <input class="input-xlarge"  id="apellido1" type="text" name="apellido1" value="<?php echo set_value('apellido1'); ?>"  />
                                          <p class="help-inline"><?php echo form_error('apellido1','<div>','</div>'); ?></p>
                                          </div>
                                    </div>     
                                    
                                    <div class="control-group">
                                          <label class="control-label" for="apellido2">Apellido2</label>                                
                                          <div class="controls">
                                          <input class="input-xlarge"  id="apellido2" type="text" name="apellido2" value="<?php echo set_value('apellido2'); ?>"  />
                                          <p class="help-inline"><?php echo form_error('apellido2','<div>','</div>'); ?></p>
                                          </div>
                                    </div>
                                    
                                    <div class="control-group">
                                          <label class="control-label" for="ocupacion">Ocupación</label>                                
                                          <div class="controls">
                                          <input class="input-xlarge"  id="ocupacion" type="text" name="ocupacion" value="<?php echo set_value('ocupacion'); ?>"  />
                                          <p class="help-inline"><?php echo form_error('ocupacion','<div>','</div>'); ?></p>
                                          </div>
                                    </div>
                              </br>
                        </fiedset>
                              <fieldset>
                                    <legend>Datos De Contacto</legend>
                                    <div class="control-group">
                                          <label class="control-label" for="celular">Celular<span class="required">*</span></label>                                
                                          <div class="controls">
                                          <input class="input-xlarge"  id="celular" type="text" name="celular" value="<?php echo set_value('celular'); ?>"  />
                                          <p class="help-inline"><?php echo form_error('celular','<div>','</div>'); ?></p>
                                          </div>
                                    </div>
                                    
                                    <div class="control-group">
                                          <label class="control-label" for="fijo">Fijo</label>                                
                                          <div class="controls">
                                          <input class="input-xlarge"  id="fijo" type="text" name="fijo" value="<?php echo set_value('fijo'); ?>"  />
                                          <p class="help-inline"><?php echo form_error('fijo','<div>','</div>'); ?></p>
                                          </div>
                                    </div>
                                    
                                    <div class="control-group">
                                          <label class="control-label" for="email">Email</label>                                
                                          <div class="controls">
                                          <input class="input-xlarge"  id="email" type="text" name="email" value="<?php echo set_value('email'); ?>"  />
                                          <p class="help-inline"><?php echo form_error('email','<div>','</div>'); ?></p>
                                          </div>
                                    </div>
                                    
                                    <div class="control-group">
                                          <label class="control-label" for="direccion">Direccion<span class="required">*</span></label>                                
                                          <div class="controls">
                                          <input class="input-xlarge"  id="direccion" type="text" name="direccion" value="<?php echo set_value('direccion'); ?>"  />
                                          <p class="help-inline"><?php echo form_error('direccion','<div>','</div>'); ?></p>
                                          </div>
                                    </div>
                                    
                                    <?php $atrlabel = array(
                                    'class' => 'control-label',
                                    );?>

                                    <?php $atrselect = array(
                                    'class' => 'control-label span3',
                                    );?>


                                    <div class="control-group">
                                    <?php echo form_label('Departamento:','',$atrlabel) ?>
                                    <div class="controls">
                                    <?php echo form_dropdown('departamento',$dptos,set_value('departamento'),"id='sdep_rec'"); ?>
                                    <p class="help-inline"><?php echo form_error('departamento','<div>','</div>'); ?></p>
                                    </div>
                                    </div>

                                    <div class="control-group">
                                    <?php echo form_label('Municipio','',$atrlabel) ?>
                                    <div class="controls">
                                    <?php echo form_dropdown('municipio',array(), set_value('municipio'),"id='smun_rec'"); ?>
                                    <p class="help-inline"><?php echo form_error('municipio','<div>','</div>'); ?>    </p> 
                                    </div>
                                    </div>

                                    <div class="control-group">
                                    <label class="control-label" for="localidad">Localidad<span class="required">*</span></label>                                
                                    <div class="controls">
                                    <input class="input-xlarge" id="localidad" type="text" name="localidad" value="<?php echo set_value('localidad'); ?>"  />
                                    <p class="help-inline"><?php echo form_error('localidad','<div>','</div>'); ?></p>
                                    </div>
                                    </div>

                                    </br>
                              </fieldset>
                              <fieldset>
                                    <legend>Lugar y Fecha de Nacimiento</legend>
                                    <div class="control-group">
                                    <?php echo form_label('Departamento:','',$atrlabel) ?>
                                    <div class="controls">
                                    <?php echo form_dropdown('departamento',$dptos,set_value('departamento'),"id='sdep_nac'"); ?>
                                    <p class="help-inline"><?php echo form_error('departamento','<div>','</div>'); ?></p>
                                    </div>
                                    </div>

                                    <div class="control-group">
                                    <?php echo form_label('Municipio', '',$atrlabel) ?>
                                    <div class="controls">
                                    <?php echo form_dropdown('municipio',array(), set_value('municipio'),"id='smun_nac'"); ?>
                                    <p class="help-inline"><?php echo form_error('municipio','<div>','</div>'); ?>  </p>   
                                    </div>
                                    </div>

                                    <div class="control-group"  value="02/16/12" data-date-format="mm/dd/yy">
                                    <label class="control-label" for="fecha_nacimiento">Fecha_nacimiento<span class="required">*</span></label>                                
                                    <div class="controls input-append date">
                                    <input class="span2"  id="fecha_nacimiento" type="text" name="fecha_nacimiento" value="<?php echo set_value('fecha_nacimiento'); ?>"  />
                                    <p class="help-inline"><?php echo form_error('fecha_nacimiento','<div>','</div>'); ?></p>
                                    </div>
                                    </div>
                                    
                                    <div class="control-group">
                                    <label class="control-label" for="fecha_registro">Fecha_registro<span class="required">*</span></label>                                
                                    <div class="controls">
                                    <input class="input-xlarge" id="fecha_registro" type="text" name="fecha_registro" value="<?php echo set_value('fecha_registro'); ?>"  />
                                    <p class="help-inline"><?php echo form_error('fecha_registro','<div>','</div>'); ?></p>
                                    </div>
                                    </div>
                                    
                                    <div class="control-group">
                                          <div class="controls">
                                            <?php 
                                          $atrboton = array(
                                          'class' => 'btn btn-primary',
                                          );

                                            echo form_submit($atrboton,'Registrar', 'Submit'); ?>
                                          </div>
                                    </div>

                                    <div class="input-append date" id="dp3" data-date="12/02/2012" data-date-format="dd/mm/yyyy">
                                      <input class="span2" size="16" type="text" value="12/02/2012">
                                      <span class="add-on"><i class="icon-th"></i></span>
                                    </div>   

                                    <div class="well">
                                      <div class="input-append date" id="dpMonths" data-date="102/2012" data-date-format="mm/yyyy" data-date-viewmode="years" data-date-minviewmode="months">
                                          <input class="span2" size="16" type="text" value="02/2012" readonly>
                                          <span class="add-on"><i class="icon-calendar"></i></span>
                                      </div>  
                                    </div> 

                              </fieldset>

                                    <?php echo form_close(); ?>
                        </div>
      <script>
            $(function(){
                  window.prettyPrint && prettyPrint();
                  $('#dp1').datepicker({
                        format: 'mm-dd-yyyy'
                  });
                  $('#dp2').datepicker();
                  $('#dp3').datepicker();
                  $('#dp3').datepicker();
                  $('#dpYears').datepicker();
                  $('#dpMonths').datepicker();
                  
                  
                  var startDate = new Date(2012,1,20);
                  var endDate = new Date(2012,1,25);
                  $('#dp4').datepicker()
                        .on('changeDate', function(ev){
                              if (ev.date.valueOf() > endDate.valueOf()){
                                    $('#alert').show().find('strong').text('The start date can not be greater then the end date');
                              } else {
                                    $('#alert').hide();
                                    startDate = new Date(ev.date);
                                    $('#startDate').text($('#dp4').data('date'));
                              }
                              $('#dp4').datepicker('hide');
                        });
                  $('#dp5').datepicker()
                        .on('changeDate', function(ev){
                              if (ev.date.valueOf() < startDate.valueOf()){
                                    $('#alert').show().find('strong').text('The end date can not be less then the start date');
                              } else {
                                    $('#alert').hide();
                                    endDate = new Date(ev.date);
                                    $('#endDate').text($('#dp5').data('date'));
                              }
                              $('#dp5').datepicker('hide');
                        });
            });
      </script>
                  </div>
            </div>
</body>