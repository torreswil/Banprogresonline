<?php

class Personas extends CI_Controller {
    
    function __construct() {
        parent::__construct();
		$this->load->library('form_validation');		
		$this->load->helper(array('form','url','codegen_helper'));
		$this->load->model('codegen_model','',TRUE);
		$this->load->model('ubigeo');
	}	
	
	function index(){
		$this->manage();
	}

	function manage(){
        $this->load->library('table');
        $this->load->library('pagination');
        
        //paging
        $config['base_url'] = base_url().'index.php/personas/manage/';
        $config['total_rows'] = $this->codegen_model->count('personas');
        $config['per_page'] = 3;	
        $this->pagination->initialize($config); 	
        // make sure to put the primarykey first when selecting , 
		//eg. 'userID,name as Name , lastname as Last_Name' , Name and Last_Name will be use as table header.
		// Last_Name will be converted into Last Name using humanize() function, under inflector helper of the CI core.
		$this->data['results'] = $this->codegen_model->get('personas','id,id,tipo_id,nombre1,nombre2,apellido1,apellido2,celular,fijo,email,direccion,departamento_residencia,municipio_residencia,localidad,departamento_nacimiento,municipio_nacimiento,fecha_nacimiento,fecha_registro','',$config['per_page'],$this->uri->segment(3));
       
	   $this->load->view('personas_list', $this->data); 
       //$this->template->load('content', 'personas_list', $this->data); // if have template library , http://maestric.com/doc/php/codeigniter_template
		
    }
	
    function add(){        
        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';
		
        if ($this->form_validation->run('personas') == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);

        } else
        {                            
            $data_persona = array(
                    'id' => set_value('id'),
					'tipo_id' => set_value('tipo_id'),
					'nombre1' => set_value('nombre1'),
					'nombre2' => set_value('nombre2'),
					'apellido1' => set_value('apellido1'),
					'apellido2' => set_value('apellido2'),
					'celular' => set_value('celular'),
					'fijo' => set_value('fijo'),
					'email' => set_value('email'),
					'direccion' => set_value('direccion'),
					'departamento_residencia' => set_value('departamento_residencia'),
					'municipio_residencia' => set_value('municipio_residencia'),
					'localidad' => set_value('localidad'),
					'departamento_nacimiento' => set_value('departamento_nacimiento'),
					'municipio_nacimiento' => set_value('municipio_nacimiento'),
					'fecha_nacimiento' => set_value('fecha_nacimiento'),
					'fecha_registro' => set_value('fecha_registro')
            );
           
			if ($this->codegen_model->add('personas',$data_persona) == TRUE)
			{
				$data_cliente=array(
					'banco' => $this->input->post('banco'),
					'persona' => set_value('id'),
					'ocupacion' => $this->input->post('ocupacion')
					);
				$this->codegen_model->add('clientes',$data_cliente);
				//$this->data['custom_error'] = '<div class="form_ok"><p>Added</p></div>';
				// or redirect
				redirect(base_url().'index.php/personas/manage/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';

			}
		}	
		$this->data['dptos']=$this->ubigeo->devolver_departamentos();	   
		$this->load->view('personas_add', $this->data);   
        //$this->template->load('content', 'personas_add', $this->data);
    }	
    
    function edit(){        
        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';
		
        if ($this->form_validation->run('personas') == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);

        } else
        {                            
            $data = array(
                    'id' => $this->input->post('id'),
					'tipo_id' => $this->input->post('tipo_id'),
					'nombre1' => $this->input->post('nombre1'),
					'nombre2' => $this->input->post('nombre2'),
					'apellido1' => $this->input->post('apellido1'),
					'apellido2' => $this->input->post('apellido2'),
					'celular' => $this->input->post('celular'),
					'fijo' => $this->input->post('fijo'),
					'email' => $this->input->post('email'),
					'direccion' => $this->input->post('direccion'),
					'departamento_residencia' => $this->input->post('departamento_residencia'),
					'municipio_residencia' => $this->input->post('municipio_residencia'),
					'localidad' => $this->input->post('localidad'),
					'departamento_nacimiento' => $this->input->post('departamento_nacimiento'),
					'municipio_nacimiento' => $this->input->post('municipio_nacimiento'),
					'fecha_nacimiento' => $this->input->post('fecha_nacimiento'),
					'fecha_registro' => $this->input->post('fecha_registro')
            );
           
			if ($this->codegen_model->edit('personas',$data,'id',$this->input->post('id')) == TRUE)
			{
				redirect(base_url().'index.php/personas/manage/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';

			}
		}

		$this->data['result'] = $this->codegen_model->get('personas','id,id,tipo_id,nombre1,nombre2,apellido1,apellido2,celular,fijo,email,direccion,departamento_residencia,municipio_residencia,localidad,departamento_nacimiento,municipio_nacimiento,fecha_nacimiento,fecha_registro','id = '.$this->uri->segment(3),NULL,NULL,true);
		
		$this->load->view('personas_edit', $this->data);		
        //$this->template->load('content', 'personas_edit', $this->data);
    }
	
    function delete(){
            $ID =  $this->uri->segment(3);
            $this->codegen_model->delete('personas','id',$ID);             
            redirect(base_url().'index.php/personas/manage/');
    }
}

/* End of file personas.php */
/* Location: ./system/application/controllers/personas.php */