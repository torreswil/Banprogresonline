<?php 

/**
 * 
 */
class Creditos extends CI_Model {
	
	function __construct() {
		
		parent:: __construct();
		
	}
	
	function devolver_credito($banco,$id_credito){
		
		$this->db->where('Banco',$banco);
		$this->db->where('Identificacion',$id_credito);
		$query=$this->db->get('vistacliente');
		$result=$query->row();
		return $result;
	}

	
	

}
?>