<?php     

echo form_open(current_url()); ?>
<?php echo $custom_error; ?>
<?php echo form_hidden('id_credito',$result->id_credito) ?>

                                    <div class="control-group">
                                    <p><label class="control-label" for="monto">Monto<span class="required">*</span></label>    
                                    <div class="controls">                             
                                    <input class="input-xlarge" id="monto" type="text" name="monto" value="<?php echo $result->monto ?>"  />
                                    <?php echo form_error('monto','<div>','</div>'); ?>
                                    </p>
                                    </di>
                                    </div>
                                    

                                    <div class="control-group">
                                    <p><label class="control-label" for="plazo">Plazo<span class="required">*</span></label>    
                                    <div class="controls">                             
                                    <input class="input-xlarge" id="plazo" type="text" name="plazo" value="<?php echo $result->plazo ?>"  />
                                    <?php echo form_error('plazo','<div>','</div>'); ?>
                                    </p>
                                    </di>
                                    </div>
                                    

                                    <div class="control-group">
                                    <p><label class="control-label" for="linea_credito">Linea_credito<span class="required">*</span></label>    
                                    <div class="controls">                             
                                    <input class="input-xlarge" id="linea_credito" type="text" name="linea_credito" value="<?php echo $result->linea_credito ?>"  />
                                    <?php echo form_error('linea_credito','<div>','</div>'); ?>
                                    </p>
                                    </di>
                                    </div>
                                    

                                    <div class="control-group">
                                    <p><label class="control-label" for="periodo_intereses">Periodo_intereses<span class="required">*</span></label>    
                                    <div class="controls">                             
                                    <input class="input-xlarge" id="periodo_intereses" type="text" name="periodo_intereses" value="<?php echo $result->periodo_intereses ?>"  />
                                    <?php echo form_error('periodo_intereses','<div>','</div>'); ?>
                                    </p>
                                    </di>
                                    </div>
                                    

                                    <div class="control-group">
                                    <p><label class="control-label" for="periodo_capital">Periodo_capital<span class="required">*</span></label>    
                                    <div class="controls">                             
                                    <input class="input-xlarge" id="periodo_capital" type="text" name="periodo_capital" value="<?php echo $result->periodo_capital ?>"  />
                                    <?php echo form_error('periodo_capital','<div>','</div>'); ?>
                                    </p>
                                    </di>
                                    </div>
                                    

                                    <div class="control-group">
                                    <p><label class="control-label" for="fecha_registro">Fecha_registro<span class="required">*</span></label>    
                                    <div class="controls">                             
                                    <input class="input-xlarge" id="fecha_registro" type="text" name="fecha_registro" value="<?php echo $result->fecha_registro ?>"  />
                                    <?php echo form_error('fecha_registro','<div>','</div>'); ?>
                                    </p>
                                    </di>
                                    </div>
                                    

                                    <div class="control-group">
                                    <p><label class="control-label" for="transaccion">Transaccion<span class="required">*</span></label>    
                                    <div class="controls">                             
                                    <input class="input-xlarge" id="transaccion" type="text" name="transaccion" value="<?php echo $result->transaccion ?>"  />
                                    <?php echo form_error('transaccion','<div>','</div>'); ?>
                                    </p>
                                    </di>
                                    </div>
                                    
<p>
        <?php echo form_submit( 'submit', 'Submit'); ?>
</p>

<?php echo form_close(); ?>
