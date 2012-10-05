<?php

class V_clientes extends CI_Controller {
    
    function __construct() {
        parent::__construct();
		$this->load->library('form_validation');		
		$this->load->helper(array('form','url','codegen_helper'));
		$this->load->model('codegen_model','',TRUE);
		$this->load->model('bancos');
	}	
	
	function index(){
		$this->manage();
	}

	function manage(){
        $this->load->library('table');
        $this->load->library('pagination');
        
        //paging
        $config['base_url'] = base_url().'index.php/v_clientes/manage/';
        $config['total_rows'] = $this->codegen_model->count('v_clientes');
        $config['per_page'] = 3;	
        $this->pagination->initialize($config); 	
        // make sure to put the primarykey first when selecting , 
		//eg. 'userID,name as Name , lastname as Last_Name' , Name and Last_Name will be use as table header.
		// Last_Name will be converted into Last Name using humanize() function, under inflector helper of the CI core.
		$this->data['results'] = $this->codegen_model->get('v_clientes',',id_banco,tipo_id,id_persona,ocupacion,nombre1,nombre2,apellido1,apellido2,celular,fijo,email,direccion,municipio_residencia,localidad,municipio_nacimiento,fecha_nacimiento,fecha_registro','',$config['per_page'],$this->uri->segment(3));
       
	   $this->load->view('v_clientes_list', $this->data); 
       //$this->template->load('content', 'v_clientes_list', $this->data); // if have template library , http://maestric.com/doc/php/codeigniter_template
		
    }
	
    function add(){        
        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';
		
        if ($this->form_validation->run('v_clientes') == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);

        } else
        {                            
            $data = array(
                    'id_banco' => set_value('id_banco'),
					'tipo_id' => set_value('tipo_id'),
					'id_persona' => set_value('id_persona'),
					'ocupacion' => set_value('ocupacion'),
					'nombre1' => set_value('nombre1'),
					'nombre2' => set_value('nombre2'),
					'apellido1' => set_value('apellido1'),
					'apellido2' => set_value('apellido2'),
					'celular' => set_value('celular'),
					'fijo' => set_value('fijo'),
					'email' => set_value('email'),
					'direccion' => set_value('direccion'),
					'municipio_residencia' => set_value('municipio_residencia'),
					'localidad' => set_value('localidad'),
					'municipio_nacimiento' => set_value('municipio_nacimiento'),
					'fecha_nacimiento' => set_value('fecha_nacimiento'),
					'fecha_registro' => set_value('fecha_registro')
            );
           
			if ($this->codegen_model->add('v_clientes',$data) == TRUE)
			{
				//$this->data['custom_error'] = '<div class="form_ok"><p>Added</p></div>';
				// or redirect
				redirect(base_url().'index.php/v_clientes/manage/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';

			}
		}	
		$this->data['titulo']='Agregar un Cliente';	
		$this->data['bancos']=$this->bancos->devolver_bancos();		   
		$this->load->view('v_clientes_add', $this->data);   
        //$this->template->load('content', 'v_clientes_add', $this->data);
    }	
    
    function edit(){        
        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';
		
        if ($this->form_validation->run('v_clientes') == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);

        } else
        {                            
            $data = array(
                    'id_banco' => $this->input->post('id_banco'),
					'tipo_id' => $this->input->post('tipo_id'),
					'id_persona' => $this->input->post('id_persona'),
					'ocupacion' => $this->input->post('ocupacion'),
					'nombre1' => $this->input->post('nombre1'),
					'nombre2' => $this->input->post('nombre2'),
					'apellido1' => $this->input->post('apellido1'),
					'apellido2' => $this->input->post('apellido2'),
					'celular' => $this->input->post('celular'),
					'fijo' => $this->input->post('fijo'),
					'email' => $this->input->post('email'),
					'direccion' => $this->input->post('direccion'),
					'municipio_residencia' => $this->input->post('municipio_residencia'),
					'localidad' => $this->input->post('localidad'),
					'municipio_nacimiento' => $this->input->post('municipio_nacimiento'),
					'fecha_nacimiento' => $this->input->post('fecha_nacimiento'),
					'fecha_registro' => $this->input->post('fecha_registro')
            );
           
			if ($this->codegen_model->edit('v_clientes',$data,'',$this->input->post('')) == TRUE)
			{
				redirect(base_url().'index.php/v_clientes/manage/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';

			}
		}

		$this->data['result'] = $this->codegen_model->get('v_clientes',',id_banco,tipo_id,id_persona,ocupacion,nombre1,nombre2,apellido1,apellido2,celular,fijo,email,direccion,municipio_residencia,localidad,municipio_nacimiento,fecha_nacimiento,fecha_registro',' = '.$this->uri->segment(3),NULL,NULL,true);
		$this->data['titulo']='Agregar un Cliente';	
		$this->data['bancos']=$this->bancos->devolver_bancos();	
		$this->load->view('v_clientes_edit', $this->data);		
        //$this->template->load('content', 'v_clientes_edit', $this->data);
    }
	
    function delete(){
            $ID =  $this->uri->segment(3);
            $this->codegen_model->delete('v_clientes','',$ID);             
            redirect(base_url().'index.php/v_clientes/manage/');
    }
	

}

/* End of file v_clientes.php */
/* Location: ./system/application/controllers/v_clientes.php */