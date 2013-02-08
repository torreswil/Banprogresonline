<?php 

/**
 * 
 */
class Cliente extends CI_Model {
	
	function __construct() {
		
		parent:: __construct();
		
	}
	
	
	function devolver_cliente($banco,$id_cliente){
		
		$this->db->where('Banco',$banco);
		$this->db->where('Identificacion',$id_cliente);
		$query=$this->db->get('vistacliente');
		$result=$query->row();
		return $result;
	}

	function edit($id_banco,$id_persona,$data){
		$this->db->where('banco',$id_banco);
		$this->db->where('persona',$id_persona);
		$this->db->update('clientes',$data);

	}
	
	

}
?>
