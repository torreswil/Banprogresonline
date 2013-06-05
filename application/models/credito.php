<?php 
/**
 * 
 */
class Credito extends CI_Model {
	
	function __construct() {
		
		parent:: __construct();
		
	}
	
	function devolver_credito($banco,$id_credito){
		
		$this->db->where('banco',$banco);
		$this->db->where('id_credito',$id_credito);
		$query=$this->db->get('vistacreditos');
		$result=$query->row();
		return $result;
	}

	function devolver_intereses($banco,$id_credito){
		
		$this->db->where('banco',$banco);
		$this->db->where('id_credito',$id_credito);
		$query=$this->db->get('creditos');
		$result=$query->row();
		return $result;
	}

	function obtener_transac($banco,$cliente,$credito){
		$this->db->select('transaccion');
		$this->db->where('banco',$banco);
		$this->db->where('persona',$cliente);
		$this->db->where('id_credito',$credito);

		$query=$this->db->get('creditos');
		$result=$query->row();
		return $result->transaccion;
	}

}
?>