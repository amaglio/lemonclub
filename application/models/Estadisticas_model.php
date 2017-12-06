<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Estadisticas_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_cantidad_productos( $fecha_desde, $fecha_hasta ) 
	{
		$query = $this->db->query(" SELECT count(pr.id_producto) as cantidad, pr.nombre
									FROM 	pedido pe,
											pedido_producto pp,
									        producto pr
									WHERE
										 pe.id_pedido = pp.id_pedido
									AND  pp.id_producto = pr.id_producto   
									AND  pe.fecha_pedido BETWEEN '$fecha_desde' AND '$fecha_hasta'
									GROUP BY pr.id_producto "  );
									
		return $query->result_array();
	}

	public function get_cantidad_email( $fecha_desde, $fecha_hasta ) 
	{
		$query = $this->db->query(" SELECT count(u.id_usuario) cantidad, u.email
									FROM 	pedido pe,
											usuario u
									WHERE
										 pe.id_usuario = u.id_usuario  
									AND  pe.fecha_pedido BETWEEN '$fecha_desde' AND '$fecha_hasta'
									GROUP BY u.id_usuario "  );
		return $query->result_array();
	}



	public function get_cantidad_pedidos( $fecha_desde , $fecha_hasta ) 
	{	

		$query = $this->db->query(" SELECT count(pe.id_pedido) cantidad
									FROM  pedido pe 
									WHERE pe.fecha_pedido BETWEEN '$fecha_desde' AND '$fecha_hasta'
									AND pe.id_pedido_estado != 1 "  );

		return $query->row()->cantidad;
	}

	public function get_cantidad_forma_entrega( $fecha_desde, $fecha_hasta ) 
	{
		$query = $this->db->query(" SELECT count(pe.id_forma_entrega) as cantidad, fe.descripcion
									FROM 	pedido pe,
											forma_entrega fe
									WHERE
										 pe.id_forma_entrega = fe.id_forma_entrega  
									AND  pe.fecha_pedido BETWEEN '$fecha_desde' AND '$fecha_hasta'
									GROUP BY pe.id_forma_entrega"  );
		return $query->result_array();
	}

	public function get_cantidad_forma_pago( $fecha_desde, $fecha_hasta ) 
	{
		$query = $this->db->query(" SELECT count(fp.id_forma_pago) as cantidad, fp.descripcion
									FROM 	pedido pe,
											forma_pago fp
									WHERE
										 pe.id_forma_pago = fp.id_forma_pago  
									AND  pe.fecha_pedido BETWEEN '$fecha_desde' AND '$fecha_hasta'
									GROUP BY fp.id_forma_pago"  );
		return $query->result_array();
	}

	 public function get_cantidad_estado( $fecha_desde, $fecha_hasta ) 
	{
		$query = $this->db->query(" SELECT  count(pe.id_pedido_estado) cantidad, pee.descripcion
									FROM 	pedido pe,
											pedido_estado pee
									WHERE
										 pe.id_pedido_estado = pee.id_pedido_estado  
									AND  pe.fecha_pedido BETWEEN '$fecha_desde' AND '$fecha_hasta'
									AND pe.id_pedido_estado != 1 
									GROUP BY pe.id_pedido_estado "  );
		return $query->result_array();
	}
}

/* End of file  */
/* Location: ./application/models/ */