<?php

class Creditos extends CI_Controller {
    
    function __construct() {
        parent::__construct();
		$this->load->library('form_validation');		
		$this->load->helper(array('form','url','codegen_helper'));
		$this->load->model('codegen_model','',TRUE);
		$this->load->model('cliente');
		$this->load->model('bancos');
		$this->load->model('ubigeo');
		$this->load->model('lineas');
		$this->load->model('transacciones');

	}	
	
	function index(){
		$this->manage();
	}

	function manage(){
        $this->load->library('table');
        $this->load->library('pagination');
        
        //paging
        $config['base_url'] = base_url().'index.php/creditos/manage/';
        $config['total_rows'] = $this->codegen_model->count('creditos');
        $config['per_page'] = 3;	
        $this->pagination->initialize($config); 	
        // make sure to put the primarykey first when selecting , 
		//eg. 'userID,name as Name , lastname as Last_Name' , Name and Last_Name will be use as table header.
		// Last_Name will be converted into Last Name using humanize() function, under inflector helper of the CI core.
		$this->data['results'] = $this->codegen_model->get('creditos','id_credito,monto,plazo,linea_credito,periodo_intereses,periodo_capital,fecha_registro,transaccion','',$config['per_page'],$this->uri->segment(3));
       
	   $this->load->view('creditos_list', $this->data); 
       //$this->template->load('content', 'creditos_list', $this->data); // if have template library , http://maestric.com/doc/php/codeigniter_template
		
    }
	
    function add(){        
        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';
		
        if ($this->form_validation->run('creditos') == false or $this->form_validation->run('transaccion') == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);

        } else
        {                            
            
            $transac=array(
            		'banco'=> $this->uri->segment(4),
            		'tipo_transac'=>1,
            		'valor'=>set_value('monto'),
            		'fecha'=>set_value('fecha_desembolso')
            	);

            if ($this->codegen_model->add('transacciones',$transac) == TRUE) {
            	$transaccion=$this->transacciones->obtener_ultimo_id();
            	if($transaccion){
            		$data = array(
            		'banco'=> $this->uri->segment(4),
            		'persona'=> $this->uri->segment(3),
                    'monto' => set_value('monto'),
					'plazo' => set_value('plazo'),
					'linea_credito' => set_value('linea_credito'),
					'periodo_intereses' => set_value('periodo_intereses'),
					'periodo_capital' => set_value('periodo_capital'),
					'transaccion'=>$transaccion,
            		);

            		if ($this->codegen_model->add('creditos',$data) == TRUE)
						{
							//$this->data['custom_error'] = '<div class="form_ok"><p>Added</p></div>';
							// or redirect
							redirect(base_url().'index.php/personas/ver/'.$this->uri->segment(3).'/'.$this->uri->segment(4));
						}
						else
						{
							$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';

						}
            	}
            }
           
			
		}
		$this->data['lineas']=$this->lineas->obtener_todas($id_banco=$this->uri->segment(4));
		$this->ver_cliente();  
		$this->load->view('creditos_add', $this->data);   
        //$this->template->load('content', 'creditos_add', $this->data);
    }	
    
    function edit(){        
        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';
		
        if ($this->form_validation->run('creditos') == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);

        } else
        {                            
            $data = array(
                    'monto' => $this->input->post('monto'),
					'plazo' => $this->input->post('plazo'),
					'linea_credito' => $this->input->post('linea_credito'),
					'periodo_intereses' => $this->input->post('periodo_intereses'),
					'periodo_capital' => $this->input->post('periodo_capital'),
					'fecha_registro' => $this->input->post('fecha_registro'),
					'transaccion' => $this->input->post('transaccion')
            );
           
			if ($this->codegen_model->edit('creditos',$data,'id_credito',$this->input->post('id_credito')) == TRUE)
			{
				redirect(base_url().'creditos/manage/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';

			}
		}

		$this->data['result'] = $this->codegen_model->get('creditos','id_credito,monto,plazo,linea_credito,periodo_intereses,periodo_capital,fecha_registro,transaccion','id_credito = '.$this->uri->segment(3),NULL,NULL,true);
		
		$this->load->view('creditos_edit', $this->data);		
        //$this->template->load('content', 'creditos_edit', $this->data);
    }
	
    function delete(){
            $ID =  $this->uri->segment(3);
            $this->codegen_model->delete('creditos','id_credito',$ID);             
            redirect(base_url().'index.php/creditos/manage/');
    }

    function ver_cliente(){
	    $id_banco=$this->uri->segment(4);
		$id_cliente=$this->uri->segment(3);
		$cliente=$this->cliente->devolver_cliente($id_banco,$id_cliente);
		$this->data['cliente']=$cliente;
		$this->data['municipio']=$this->ubigeo->devolver_mun($cliente->Municipio);
		$this->data['banco']=$this->bancos->devolver_nombre_banco($id_banco);
		return $this->data;	
    }


    function abonos(){

    	$datos_credito=

    }



}

/* End of file creditos.php */
/* Location: ./system/application/controllers/creditos.php */