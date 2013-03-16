<?php 
/**
 * 
 */
class Transacciones extends CI_Model {
	
	function __construct() {
		
		parent:: __construct();
		
	}

	function obtener_ultimo_id()
	{
		$query=$this->db->select_max('id')->get('transacciones');
		$fila=$query->row();
		return $fila->id;	 
	}



}

?>