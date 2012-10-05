
<?php

class Banco extends CI_Controller {
    
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
        ///$this->load->library('table');
        ///$this->load->library('pagination');
        
        //paging
        ///$config['base_url'] = base_url().'index.php/banco/manage/';
        ///$config['total_rows'] = $this->codegen_model->count('banco');
        ///$config['per_page'] = 3;	
        ///$this->pagination->initialize($config); 	
        // make sure to put the primarykey first when selecting , 
		//eg. 'userID,name as Name , lastname as Last_Name' , Name and Last_Name will be use as table header.
		// Last_Name will be converted into Last Name using humanize() function, under inflector helper of the CI core.
		///$this->data['results'] = $this->codegen_model->get('banco','id,id,departamento,nombre_banco,localidad,municipio,direccion,longitud,latitud,fecha_creacion','',$config['per_page'],$this->uri->segment(3));
       
	   ///$this->load->view('banco_list', $this->data); 
       //$this->template->load('content', 'banco_list', $this->data); // if have template library , http://maestric.com/doc/php/codeigniter_template
		
		$data['query']=$this->db->get('vistabanco');
		$data['titulo']='Lista de Bancos';
		$this->load->view('lista_bancos',$data);
		
		
    }



		function departamento()
	{
		$data['dptos']=$this->ubigeo->devolver_departamentos();
		
		return $data ['dptos'];

	}
	public function municipio()
	{
		$coddep=$this->input->get('id');	
		$this->ubigeo->devolver_municipios($coddep);
		
	}
	
    function add(){        
        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';
		
        if ($this->form_validation->run('banco') == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);

        } else
        {                            
            $data = array(
                    'id' => set_value('id'),
					'departamento' => set_value('departamento'),
					'nombre_banco' => set_value('nombre_banco'),
					'localidad' => set_value('localidad'),
					'municipio' => set_value('municipio'),
					'direccion' => set_value('direccion'),
					'longitud' => set_value('longitud'),
					'latitud' => set_value('latitud'),
					'fecha_creacion' => set_value('fecha_creacion')
            );
           
			if ($this->codegen_model->add('banco',$data) == TRUE)
			{
				//$this->data['custom_error'] = '<div class="form_ok"><p>Added</p></div>';
				// or redirect
				redirect(base_url().'index.php/banco/manage/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';

			}
		}
		$this->data['titulo']='Agregar un banco';	
		$this->data['dptos']=$this->departamento();			   
		$this->load->view('banco_add', $this->data);   
        //$this->template->load('content', 'banco_add', $this->data);
    }	
    
    function edit(){        
        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';
		
        if ($this->form_validation->run('banco') == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);

        } else
        {                            
            $data = array(
                    'id' => $this->input->post('id'),
					'departamento' => $this->input->post('departamento'),
					'nombre_banco' => $this->input->post('nombre_banco'),
					'localidad' => $this->input->post('localidad'),
					'municipio' => $this->input->post('municipio'),
					'direccion' => $this->input->post('direccion'),
					'longitud' => $this->input->post('longitud'),
					'latitud' => $this->input->post('latitud'),
					'fecha_creacion' => $this->input->post('fecha_creacion')
            );
           
			if ($this->codegen_model->edit('banco',$data,'id',$this->input->post('id')) == TRUE)
			{
				redirect(base_url().'index.php/banco/manage/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';

			}
		}

		$this->data['result'] = $this->codegen_model->get('banco','id,id,departamento,nombre_banco,localidad,municipio,direccion,longitud,latitud,fecha_creacion','id = '.$this->uri->segment(3),NULL,NULL,true);
		$this->data['titulo'] = 'Editar Banco';
		$this->data['dptos']=$this->departamento();	
		$this->load->view('banco_edit', $this->data);		
        //$this->template->load('content', 'banco_edit', $this->data);
    }
	
    function delete(){
            $ID =  $this->uri->segment(3);
            $this->codegen_model->delete('banco','id',$ID);             
            redirect(base_url().'index.php/banco/manage/');
    }
	
}

/* End of file banco.php */
/* Location: ./system/application/controllers/banco.php */