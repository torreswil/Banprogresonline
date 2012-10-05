<?php 

/**
 * 
 */
class cliente extends CI_Model {
	
	function __construct() {
		
		parent:: __construct();
		
	}
	
	
	function devolver_cliente($banco,$id_cliente){
		
		$this->db->where('id_banco',$banco);
		$this->db->where('id_persona',$id_cliente);
		$this->db->get('vistacliente');
	}
	
	

}
?>
