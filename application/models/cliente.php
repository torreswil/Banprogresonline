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
	
	function creditos($id_banco,$id_persona){
		$this->db->where('banco',$id_banco);
		$this->db->where('cliente',$id_persona);
		$sql=$this->db->get('vistacreditos');
		$cadena = "";
		foreach ($sql->result_array() as $fila) {
			$cadena.='<tr><td>'.$fila['id_credito'].'</td><td>$'.number_format($fila['monto'], 0,",",".").
			'</td><td>'.$fila['plazo'].'</td><td>'.$fila['fecha_desembolso'].'</td>
			<td><a class="btn btn-success btn-mini" href="'.base_url().'creditos/ver/'.$fila['id_credito'].'/'.$id_persona.'/'.$id_banco.'">
			<i class="icon-eye-open icon-white"></i> Detalles</a></td>

			<td><input type="button" id="id="eliminar-credito"" class="btn btn-danger btn-mini" value="Eliminar" onclick="eliminarCredito('.$id_banco.','.$fila['id_credito'].','.$id_persona.')"></td></tr>';
		}
		return $cadena;
	}
	

}
?>
