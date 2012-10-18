<?php

class Cliente extends CI_Controller {
    
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
		$data['query']=$this->db->get('vistacliente');
		$data['titulo']='Lista de Clientes';
		$data['lista_clientes']=$this->
		$this->load->view('v_clientes',$data);
		
    }
	
    function add(){        
        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';
		
        if ($this->form_validation->run('cliente') == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);

        } else
        {                            
            $datos_persona = array(
					'tipo_id' => set_value('tipo_id'),
					'id_persona' => set_value('id_persona'),
					'nombre1' => set_value('nombre1'),
					'nombre2' => set_value('nombre2'),
					'apellido1' => set_value('apellido1'),
					'apellido2' => set_value('apellido2'),
					'celular' => set_value('celular'),
					'fijo' => set_value('fijo'),
					'email' => set_value('email'),
					'direccion' => set_value('direccion'),
					'municipio_residencia' => set_value('municipio_residencia'),
					'departamento_residencia' => set_value('departamento_residencia'),
					'localidad' => set_value('localidad'),
					'municipio_nacimiento' => set_value('municipio_nacimiento'),
					'departamento_nacimiento' => set_value('departamento_nacimiento'),
					'fecha_nacimiento' => set_value('fecha_nacimiento'),
					'fecha_registro' => set_value('fecha_registro')
            );

            $datos_cliente=array(
            	'id_banco' => set_value('id_banco'),
            	'id_persona' => set_value('id_persona'),
            	'ocupacion' => set_value('ocupacion'),
            	);
           
			if ($this->codegen_model->add('personas',$datos_persona) == TRUE)

			{
				if($this->codegen_model->add('clientes',$datos_cliente) == TRUE){
				//$this->data['custom_error'] = '<div class="form_ok"><p>Added</p></div>';
				// or redirect
				redirect(base_url().'index.php/cliente/manage/');
				}
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';

			}
		}		
		$this->data['titulo']='Agregar un Cliente';	
		$this->data['bancos']=$this->bancos->devolver_bancos();	   
		$this->load->view('cliente_add', $this->data);   
        //$this->template->load('content', 'cliente_add', $this->data);
    }	
    
    function edit(){        
        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';
		$this->load->model('cliente');
		
        if ($this->form_validation->run('cliente') == false)
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
					'departamento_residencia' => $this->input->post('departamento_residencia'),
					'localidad' => $this->input->post('localidad'),
					'municipio_nacimiento' => $this->input->post('municipio_nacimiento'),
					'departamento_nacimiento' => $this->input->post('departamento_nacimiento'),
					'fecha_nacimiento' => $this->input->post('fecha_nacimiento'),
					'fecha_registro' => $this->input->post('fecha_registro')
            );
           
			if ($this->codegen_model->edit('vistacliente',$data,'',$this->input->post('')) == TRUE)
			{
				redirect(base_url().'index.php/cliente/manage/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';

			}
		}

		$this->data['result'] = $this->cliente->devolver_cliente($this->uri->segment(3),$this->uri->segment(4));
		
		$this->load->view('cliente_edit', $this->data);		
        //$this->template->load('content', 'cliente_edit', $this->data);
    }
	
    function delete(){
            $ID =  $this->uri->segment(3);
            $banco  = $this->uri->segment(4);
            $this->db->delete('clientes', array('persona' => $ID, 'banco' => $banco ));             
            redirect(base_url().'index.php/banco/ver');
    }
}

/* End of file cliente.php */
/* Location: ./system/application/controllers/cliente.php */