<?php 

/**
 * 
 */
class Cliente extends CI_Model {
	
	function __construct() {
		
		parent:: __construct();
		
	}
	
	
	function devolver_cliente($banco,$id_cliente){
		
		$this->db->where('id_banco',$banco);
		$this->db->where('id_persona',$id_cliente);
		$this->db->get('vistacliente');
	}

	function edit($id_banco,$id_persona,$data){
		$this->db->where('banco',$id_banco);
		$this->db->where('persona',$id_persona);
		$this->db->update('cliente',$data);

	}
	
	

}
?>
