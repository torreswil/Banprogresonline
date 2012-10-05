<?php     

echo form_open(current_url()); ?>
<?php echo $custom_error; ?>
<?php echo form_hidden('',$result->) ?>

                                    <p><label for="id_banco">Id_banco<span class="required">*</span></label>                                
                                    <input id="id_banco" type="text" name="id_banco" value="<?php echo $result->id_banco ?>"  />
                                    <?php echo form_error('id_banco','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="tipo_id">Tipo_id<span class="required">*</span></label>                                
                                    <input id="tipo_id" type="text" name="tipo_id" value="<?php echo $result->tipo_id ?>"  />
                                    <?php echo form_error('tipo_id','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="id_persona">Id_persona<span class="required">*</span></label>                                
                                    <input id="id_persona" type="text" name="id_persona" value="<?php echo $result->id_persona ?>"  />
                                    <?php echo form_error('id_persona','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="ocupacion">Ocupacion<span class="required">*</span></label>                                
                                    <input id="ocupacion" type="text" name="ocupacion" value="<?php echo $result->ocupacion ?>"  />
                                    <?php echo form_error('ocupacion','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="nombre1">Nombre1<span class="required">*</span></label>                                
                                    <input id="nombre1" type="text" name="nombre1" value="<?php echo $result->nombre1 ?>"  />
                                    <?php echo form_error('nombre1','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="nombre2">Nombre2</label>                                
                                    <input id="nombre2" type="text" name="nombre2" value="<?php echo $result->nombre2 ?>"  />
                                    <?php echo form_error('nombre2','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="apellido1">Apellido1<span class="required">*</span></label>                                
                                    <input id="apellido1" type="text" name="apellido1" value="<?php echo $result->apellido1 ?>"  />
                                    <?php echo form_error('apellido1','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="apellido2">Apellido2</label>                                
                                    <input id="apellido2" type="text" name="apellido2" value="<?php echo $result->apellido2 ?>"  />
                                    <?php echo form_error('apellido2','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="celular">Celular</label>                                
                                    <input id="celular" type="text" name="celular" value="<?php echo $result->celular ?>"  />
                                    <?php echo form_error('celular','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="fijo">Fijo</label>                                
                                    <input id="fijo" type="text" name="fijo" value="<?php echo $result->fijo ?>"  />
                                    <?php echo form_error('fijo','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="email">Email</label>                                
                                    <input id="email" type="text" name="email" value="<?php echo $result->email ?>"  />
                                    <?php echo form_error('email','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="direccion">Direccion</label>                                
                                    <input id="direccion" type="text" name="direccion" value="<?php echo $result->direccion ?>"  />
                                    <?php echo form_error('direccion','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="municipio_residencia">Municipio_residencia<span class="required">*</span></label>                                
                                    <input id="municipio_residencia" type="text" name="municipio_residencia" value="<?php echo $result->municipio_residencia ?>"  />
                                    <?php echo form_error('municipio_residencia','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="localidad">Localidad<span class="required">*</span></label>                                
                                    <input id="localidad" type="text" name="localidad" value="<?php echo $result->localidad ?>"  />
                                    <?php echo form_error('localidad','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="municipio_nacimiento">Municipio_nacimiento<span class="required">*</span></label>                                
                                    <input id="municipio_nacimiento" type="text" name="municipio_nacimiento" value="<?php echo $result->municipio_nacimiento ?>"  />
                                    <?php echo form_error('municipio_nacimiento','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="fecha_nacimiento">Fecha_nacimiento<span class="required">*</span></label>                                
                                    <input id="fecha_nacimiento" type="text" name="fecha_nacimiento" value="<?php echo $result->fecha_nacimiento ?>"  />
                                    <?php echo form_error('fecha_nacimiento','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="fecha_registro">Fecha_registro<span class="required">*</span></label>                                
                                    <input id="fecha_registro" type="text" name="fecha_registro" value="<?php echo $result->fecha_registro ?>"  />
                                    <?php echo form_error('fecha_registro','<div>','</div>'); ?>
                                    </p>
                                    
<p>
        <?php echo form_submit( 'submit', 'Submit'); ?>
</p>

<?php echo form_close(); ?>
