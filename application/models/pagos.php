<?php 
/**
 * 
 */
class pagos extends CI_Model {
	
	function __construct() {
		
		parent:: __construct();
		
	}
	
	function devolver_abonos($banco,$id_credito){
		
		$this->db->where('banco',$banco);
		$this->db->where('credito',$id_credito);
		$this->db->order_by('fecha','asc');
		$query=$this->db->get('vistaabonos');
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
	}

	function num_abonos($banco,$id_credito){
		
		$this->db->where('banco',$banco);
		$this->db->where('credito',$id_credito);
		$this->db->from('vistaabonos');
		$cant=$this->db->count_all_results();
		return $cant;
	}

	function delete($banco,$cliente,$credito){
		$this->db->where('banco',$banco);
		$this->db->where('credito',$id_credito);
		$this->db->where('credito',$id_credito);
	}
}
?>