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



}