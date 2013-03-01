
<!DOCTYPE >
<html lang="es" >
<head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <title>Detalles Credito</title>
      <link href="<?php echo base_url()?>css/banprogreso.css" rel="stylesheet">
      <link href="<?php echo base_url()?>css/datepicker.css" rel="stylesheet">
      <link rel="stylesheet"  href="<?php echo base_url()?>css/bootstrap.css"/>
      <script type="text/javascript" src="<?php echo base_url()?>js/jquery.js"></script>
      <script type="text/javascript" src="<?php echo base_url()?>js/bootstrap-tab.js"></script>
      <script type="text/javascript" src="<?php echo base_url()?>js/plan_pagos.js"></script>
      <script type="text/javascript" src="<?php echo base_url()?>js/bootstrap-dropdown.js"></script>
      <script type="text/javascript" src="<?php echo base_url()?>js/bootstrap-modal.js"></script>
      <script src="<?php echo base_url()?>js/bootstrap-datepicker.js"></script>
      <script type="text/javascript" src="<?php echo base_url()?>js/abonar.js"></script>
      <!--script src="<?php echo base_url()?>js/amortizacion.js"></script-->

      <style>
      .container {
            background: #fff;
      }
      #alert {
            display: none;
      }
      </style>

      <script type="text/javascript" charset="utf-8">
            $('#estados').tab('show')
      </script>
</head>
<body>
      <div class="container">
          <div class="row">
                <div class="span12">
                      <h2 class="well"><a href="<?php echo base_url().'banco/ver/'.$banco->id?>"><?php echo $banco->nombre_banco.' - '?></a><a href="<?php echo base_url().'personas/ver/'.$cliente->Identificacion.'/'.$credito->banco ?>"><?php echo $cliente->Nombre1." ".$cliente->Apellido1." - "?></a>Detalles Credito</h2>
                </div>
          </div>

          <div class="row">
              <div class="span4">
                    <div class="well">
                          <a class="btn btn-success  btn-small" style="float: right" href="<?php echo base_url().'personas/edit/'.$cliente->Identificacion.'/'.$credito->banco ?>"><i class="icon-refresh icon-white"></i> Editar</a>
                          <legend>Datos del Cliente</legend>
                          <br>
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
                    </div>
              </div>

              <div class="span8">
                  <div class="well">
                   <a data-toggle="modal" href="#myModal" class="btn btn-primary btn-small" style="float: right">Abonar a este credito</a>
                   <legend>Datos del Credito</legend>
                        <div class="span7">
                                <div class="oculto">
                                    <input id="carpeta" name "carpeta" value="<?php echo base_url()?>">
                                    <input  id="txtIdBanco" name="txtIdBanco" value="<?php echo $cliente->Banco?>">
                                    <input  id="txtIdCliente" name="txtIdCliente" value="<?php echo $cliente->Identificacion ?>">
                                    <input  id="corriente" name="txtIdCliente" value="<?php echo $linea->int_corriente ?>">
                                    <input  id="monto" name="txtIdCliente" value="<?php echo $credito->monto ?>">
                                    <input  id="txtIdCredito" name="txtIdCredito" value="<?php echo $credito->id_credito ?>">
                                    <input  id="fecha_desembolso" name="txtIdCliente" value="<?php echo $credito->fecha_desembolso ?>">
                                    <input  id="plazo" name="txtIdCliente" value="<?php echo $credito->plazo?>">
                                    <input  id="periodo_intereses" name="txtPInteres" value="<?php echo $credito->periodo_intereses?>">
                                    <input  id="periodo_capital" name="txtIdPCapital" value="<?php echo $credito->periodo_capital?>">
                                </div>
                              <p><span class="dato-credito">Credito No:</span><label class="eti-credito"><?php echo ' '. number_format($credito->id_credito,0,",",".") ?></label><span class="dato-credito">Int Corriente:</span><label class="eti-credito"><?php echo ' '. $credito->interes_corriente ?>%</label><span class="dato-credito">Mora:</span><label class="eti-credito"><?php echo ' '. $credito->interes_mora ?>%</label><p>
                              <p><span class="dato-credito">Monto Aprobado:</span><label  class="eti-credito">$<?php echo ' '. number_format($credito->monto,0,",",".") ?></label><p>
                              <p><span class="dato-credito">Fecha desembolso:</span><label  class="eti-credito"><?php echo ' '. $credito->fecha_desembolso ?></label><p>
                              <p><span class="dato-credito">Plazo:</span><label class="eti-credito"><?php echo ' '. $credito->plazo; echo ($credito->plazo) <=1 ? ' Mes' : ' Meses'  ?></label><p>                                          
                              <p><span class="dato-credito">Intereses cada:</span><label class="eti-credito"><?php echo ' '. $credito->periodo_intereses.' '; echo ($credito->periodo_intereses) <=1 ? ' Mes' : ' Meses' ?></label><p>
                              <p><span class="dato-credito">Capital cada:</span><label  class="eti-credito"><?php echo ' '. $credito->periodo_capital.' '; echo ($credito->periodo_capital) <=1 ? ' Mes' : ' Meses'  ?></label><p>
                        </div>
                        <div class="final"></div>

                  </div>
              </div>
            </div>
          <div class="row" >
                <div class="span12">
                    <div class="well">
                        <ul id="tab" class="nav nav-tabs">
                              <li id class="active"><a href="#plan-pagos" data-toggle="tab">Plan de Pagos</a></li>
                              <li id="distri"><a href="#distri-abonos" data-toggle="tab">Abonos Realizados</a></li>
                              <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Desplegable <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#dropdown1" data-toggle="tab">@fat</a></li>
                                    <li><a href="#dropdown2" data-toggle="tab">@mdo</a></li>
                                </ul>
                              </li>
                        </ul>
                          <div id="myTabContent" class="tab-content">
                              <div class="tab-pane fade in active" id="plan-pagos">
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
                              <div class="tab-pane fade" id="distri-abonos">
                              </div>
                              <div class="tab-pane fade" id="dropdown1">
                                    <p id='abonprueba'>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy retro mlkshk vice blog. Scenester cred you probably haven't heard of them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.</p>
                              </div>
                              <div class="tab-pane fade" id="dropdown2">
                                    <p>Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin. Cred vinyl keffiyeh DIY salvia PBR, banh mi before they sold out farm-to-table VHS viral locavore cosby sweater. Lomo wolf viral, mustache readymade thundercats keffiyeh craft beer marfa ethical. Wolf salvia freegan, sartorial keffiyeh echo park vegan.</p>
                              </div>
                          </div>
                    </div>
                </div>
          </div>
      </div>
      <div id="myModal" class="modal hide fade">
            <div class="modal-header">
              <a class="close" data-dismiss="modal" >&times;</a>
              <h3>Ingrese Datos del Abono</h3>
            </div>
            <div class="modal-body">
             <?php     
              $atributos = array('class' => 'form-horizontal','id'=>'frmAbonar');
              echo form_open(current_url(), $atributos); 
              ?>
                <input class="input-xlarge" id="abonUrl" type="hidden" name="url" value="<?php echo base_url()?>" />
                <input class="input-xlarge" id="abonBanco" type="hidden" name="banco" value="<?php echo $cliente->Banco?>" />
                <input class="input-xlarge" id="abonCliente" type="hidden" name="abonCliente" value="<?php echo $cliente->Identificacion?>"  />
                <input class="input-xlarge" id="abonCredito" type="hidden" name="abonCredito" value="<?php echo $credito->id_credito?>" />
              <div class="control-group">
                  <label class="control-label" for="fecha_abono">Fecha Abono:<span class="required">*</span></label>                                
                  <div class="controls">
                        <div class="input-append date" id="fecha_abono" data-date="2012-10-10" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
                              <input size="16" type="text" id="fecha_abono" name="fecha_abono">
                              <span class="add-on"><i class="icon-calendar"></i></span>
                              <p class="help-inline"><?php echo form_error('fecha_desembolso','<div>','</div>'); ?></p>
                        </div>
                  </div>
              </div>

              <div class="control-group">
                  <label class="control-label" for="valor">Valor:<span class="required">*</span></label>                                
                  <div class="controls">
                        <input class="input-xlarge" id="valor" type="number" name="valor"  />
                        <p class="help-inline"></p>
                  </div>
              </div>

              <div class="control-group">
                  <label class="control-label" for="soporte">Soporte:<span class="required">*</span></label>                                
                  <div class="controls">
                        <input class="input-xlarge" id="soporte" type="text" name="soporte"  />
                        <p class="help-inline"></p>
                  </div>
              </div>
              <p id='pru'>prueba</p>

            </div>
            <div class="modal-footer">
              <a  class="btn" data-dismiss="modal" >Cerrar</a>
              <input type="button" id="abonar" class="btn btn-primary" disabled="disabled" value="Abonar">
            </div>
            
          </div>          
      <script>
              $(function(){
                window.prettyPrint && prettyPrint();

                $('#fecha_abono').datepicker();

              });
      </script>
      

</body>

      