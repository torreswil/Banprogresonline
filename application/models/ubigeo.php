<?php 

/**
 * 
 */
class ubigeo extends CI_Model {
	
	function __construct() {
		
		parent:: __construct();
		
	}
	
	function devolver_departamentos()
	{
		$this->db->select('id,nombre');
		$query=$this->db->get('departamentos');
		
		foreach ($query->result() as $fila) {		
			$data[$fila->id]=$fila->nombre;		
		}
		return $data;
	}
	
	public function devolver_municipios($coddep)
	{
	$sql = $this->db->where('departamento', $coddep)->get('municipios');

		$cadena = "";

		foreach ($sql->result_array() as $reg) {
			$cadena.="<option value='{$reg['id']}'>{$reg['nombre_municipio']}</option>";
		}

		echo $cadena;
		
	}
	
}




 ?>