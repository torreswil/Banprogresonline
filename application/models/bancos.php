<?php 

/**
 * 
 */
class bancos extends CI_Model {
	
	function __construct() {
		
		parent:: __construct();
		
	}
	
	function devolver_bancos()
	{
		$this->db->select('Id,Nombre');
		$query=$this->db->get('vistabanco');
		
		foreach ($query->result() as $fila) {		
			$data[$fila->Id]=$fila->Nombre;		
		}
		return $data;
	}

	function get_clientes_banco($id_banco){

		$query=$this->db->where('Banco',$id_banco)->get('vistacliente');
		return $query;
	}
	
}




 ?>