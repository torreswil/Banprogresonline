<?php 

/**
 * 
 */
class Lineas extends CI_Model {
	
	function __construct() {
		
		parent:: __construct();
		
	}

	function obtener_todas($banco)
	{
		$sql = $this->db->where('banco', $banco)->get('linea_credito');

		$cadena = "";

		foreach ($sql->result_array() as $reg) {
			$cadena.="<option value='{$reg['id']}'>{$reg['nombre']}</option>";
		}

		return $cadena;
	}
	function devolver_intereses($linea,$banco){
		$this->db->where('id', $linea);
		$this->db->where('banco',$banco);
		$sql=$this->db->get('linea_credito');
		$result=$sql->row();
		return $result;
	}



}