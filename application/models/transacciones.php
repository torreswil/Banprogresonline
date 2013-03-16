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

	function eliminar_abono($banco,$credito,$abono){
		$this->db->select('transaccion');
		$this->db->where('banco', $banco);
		$this->db->where('credito', $credito);
		$this->db->where('id_abono', $abono);
		$query=$this->db->get('abonos');
		$fila=$query->row();
		return $fila->transaccion;
	}


}

?>