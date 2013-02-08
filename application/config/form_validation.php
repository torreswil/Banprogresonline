<?php

$config = array(

             	'abonos' => array(array(
                                	'field'=>'banco',
                                	'label'=>'Banco',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'fecha_registro',
                                	'label'=>'Fecha_registro',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'transaccion',
                                	'label'=>'Transaccion',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'soporte',
                                	'label'=>'Soporte',
                                	'rules'=>'required|trim|xss_clean'
                                ))
			   
			   
				,


				'personas' => array(array(
                                    'field'=>'banco',
                                    'label'=>'Banco',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                	'field'=>'id',
                                	'label'=>'Id',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'tipo_id',
                                	'label'=>'Tipo_id',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'nombre1',
                                	'label'=>'Nombre1',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'nombre2',
                                	'label'=>'Nombre2',
                                	'rules'=>'trim|xss_clean'
                                ),
								array(
                                	'field'=>'apellido1',
                                	'label'=>'Apellido1',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'apellido2',
                                	'label'=>'Apellido2',
                                	'rules'=>'trim|xss_clean'
                                ),

                                array(
                                    'field'=>'ocupacion',
                                    'label'=>'Ocupacion',
                                    'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'celular',
                                	'label'=>'Celular',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'fijo',
                                	'label'=>'Fijo',
                                	'rules'=>'trim|xss_clean'
                                ),
								array(
                                	'field'=>'email',
                                	'label'=>'Email',
                                	'rules'=>'trim|valid_email|xss_clean'
                                ),
								array(
                                	'field'=>'direccion',
                                	'label'=>'Direccion',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'departamento_residencia',
                                	'label'=>'Departamento_residencia',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'municipio_residencia',
                                	'label'=>'Municipio_residencia',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'localidad',
                                	'label'=>'Localidad',
                                	'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'fecha_nacimiento',
                                    'label'=>'Fecha_nacimiento',
                                    'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'departamento_nacimiento',
                                	'label'=>'Departamento_nacimiento',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'municipio_nacimiento',
                                	'label'=>'Municipio_nacimiento',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								
								array(
                                	'field'=>'fecha_registro',
                                	'label'=>'Fecha_registro',
                                	'rules'=>'required|trim|xss_clean'
                                ))
			   
			   
			   
				,

				'banco' => array(array(
                                	'field'=>'id',
                                	'label'=>'Id',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'departamento',
                                	'label'=>'Departamento',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'nombre_banco',
                                	'label'=>'Nombre_banco',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'localidad',
                                	'label'=>'Localidad',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'municipio',
                                	'label'=>'Municipio',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'direccion',
                                	'label'=>'Direccion',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'longitud',
                                	'label'=>'Longitud',
                                	'rules'=>'trim|xss_clean'
                                ),
								array(
                                	'field'=>'latitud',
                                	'label'=>'Latitud',
                                	'rules'=>'trim|xss_clean'
                                ),
								array(
                                	'field'=>'fecha_creacion',
                                	'label'=>'Fecha_creacion',
                                	'rules'=>'required|trim|xss_clean'
                                ))
			   
			   
				,

				'creditos' => array(array(
                                	'field'=>'monto',
                                	'label'=>'Monto',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'plazo',
                                	'label'=>'Plazo',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'linea_credito',
                                	'label'=>'Linea_credito',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'periodo_intereses',
                                	'label'=>'Periodo_intereses',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'periodo_capital',
                                	'label'=>'Periodo_capital',
                                	'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'fecha_desembolso',
                                    'label'=>'Fecha del desembolso',
                                    'rules'=>'required|trim|xss_clean'
                                ))
			   );

			   
?>