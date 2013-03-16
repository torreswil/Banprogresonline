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
	
	public function devolver_municipio($id)
	{
		$query=$this->db->where('id',$id)->get('municipios');
		foreach ($query->result() as $fila) {
			$municipio=$fila->nombre_municipio;
		}
		return $municipio;
	}
	public function devolver_mun($id)
	{
		$query=$this->db->where('id',$id)->get('municipios');
		$result=$query->row();
		return $result;
	}

	public function devolver_departamento($id)
	{
		return $this->db->where('id',$id)->get('departamentos');

	}
}




 ?>