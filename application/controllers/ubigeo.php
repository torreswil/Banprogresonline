<?php
/*
 * 
 * 
 * 
 * 
 */
class banco extends CI_Controller {
	
	
	function __construct()
	{
		parent:: __construct();

		$this->load->helper(array('form','url'));
		$this->load->model('ubigeo');
	}
	
	
	function index()
	{
			
		$this->departamento();

	}
		function departamento()
	{
			
		$data['titulo']='Agregar un banco';
		$data['encabezado']='Gestion de Bancos';
		$data['dptos']=$this->ubigeo->devolver_departamentos();
		$this->load->view('lista_bancos',$data);
		
		return $data;

	}
	public function municipio()
	{
		$coddep=$this->input->get('id');	
		$this->ubigeo->devolver_municipios($coddep);
		
	}

	
} 

?>