<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pedido_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_pedido( $id ) 
	{
		$query = $this->db->query('SELECT *
		                            FROM pedido AS P
		                            WHERE P.id_pedido='.$id);
		return $query->row_array();
	}

	public function get_pedido_productos( $id ) 
	{
		$query = $this->db->query('SELECT *
		                            FROM pedido_producto AS PP
		                            INNER JOIN producto AS P ON PP.id_producto = P.id_producto
		                            WHERE PP.id_pedido='.$id);
		return $query->result_array();
	}

	public function get_total_pedido( $id ) 
	{
		$query = $this->db->query('SELECT SUM(PP.cantidad*PP.precio) as total
		                            FROM pedido_producto AS PP
		                            WHERE PP.id_pedido='.$id);
		$result = $query->row_array();
		return number_format($result['total'],2);
	}

	public function set_pedido( $array = FALSE )
	{
		chrome_log("Pedido_model/set_pedido");

		if($array)
		{
			if(!array_key_exists('id_pedido_estado', $array))
			{
				$array['id_pedido_estado'] = PEDIDO_ESTADO_SIN_CONFIRMAR;
			}
			if(!array_key_exists('id_sucursal', $array))
			{
				$array['id_sucursal'] = SUCURSAL;
			}
			if(!array_key_exists('id_usuario', $array))
			{
				$array['id_usuario'] = NULL;
			}
			if(!array_key_exists('id_forma_pago', $array))
			{
				$array['id_forma_pago'] = NULL;
			}
			if(!array_key_exists('id_forma_entrega', $array))
			{
				$array['id_forma_entrega'] = NULL;
			}
		}
		else
		{
			$array = array(
	            'id_pedido' => NULL,
	            'id_pedido_estado' => PEDIDO_ESTADO_SIN_CONFIRMAR,
	            'id_sucursal' => SUCURSAL,
	            'id_usuario' => NULL,
	            'id_forma_pago' => NULL,
	            'id_forma_entrega' => NULL
	        );
		}

		$this->db->insert('pedido', $array);
        return $this->db->insert_id();
	}

	public function finalizar_pedido( $id_pedido, $id_usuario, $array )
	{
		$array = array(
			'id_pedido_estado' => PEDIDO_ESTADO_PENDIENTE,
            'id_usuario' => $id_usuario,
            'id_forma_pago' => $array['pago'],
            'id_forma_entrega' => $array['entrega']
        );

        $this->db->where( array('id_pedido' => $id_pedido) );
        return $this->db->update('pedido', $array);
	}

	public function set_producto( $id_producto )
	{
		$query = $this->db->query('SELECT *
		                            FROM producto AS P
		                            WHERE P.id_producto='.$id_producto);
		$producto = $query->row_array();

		$query = $this->db->query('SELECT *
		                            FROM pedido_producto AS P
		                            WHERE P.id_pedido ='.$this->session->userdata('id_pedido').'
		                            AND P.id_producto='.$id_producto);
		$pedido_producto = $query->row_array();

		if($pedido_producto)
		{
			// UPDATE
			$cantidad = $pedido_producto['cantidad']+1;
			$array = array(
	            'cantidad' => $cantidad
	        );

	        $this->db->where( array('id_pedido' => $pedido_producto['id_pedido'], 'id_producto' => $pedido_producto['id_producto']) );
	        $result = $this->db->update('pedido_producto', $array);
		}
		else
		{
			//INSERT
			$array = array(
	            'id_pedido' => $this->session->userdata('id_pedido'),
	            'id_producto' => $producto['id_producto'],
	            'precio' => $producto['precio']
	        );
	        $result = $this->db->insert('pedido_producto', $array);
		}

        return $result;
	}

	public function modificar_producto_cantidad( $id_pedido, $id_producto, $cantidad )
	{
		$array = array(
            'cantidad' => $cantidad
        );

        $this->db->where( array('id_pedido' => $id_pedido, 'id_producto' => $id_producto) );
        return $this->db->update('pedido_producto', $array);
	}

	public function eliminar_producto( $id_pedido, $id_producto )
	{
        $this->db->where( array('id_pedido' => $id_pedido, 'id_producto' => $id_producto) );
        return $this->db->delete('pedido_producto');
	}


	public function traer_descripcion_forma_pago( $id_forma_pago )
	{	

		chrome_log("Usuario_model/traer_descripcion_forma_pago");

	 	$sql = "SELECT *
                FROM forma_pago  
                WHERE id_forma_pago = ? "; 

		$query = $this->db->query($sql, array( $id_forma_pago ));

		if($query->num_rows() > 0)
		{ 
			return $query->row()->descripcion;
		}
		else
		{
			return false;
		}


	}

	public function traer_descripcion_forma_entrega( $id_forma_entrega )
	{	

		chrome_log("Usuario_model/traer_descripcion_forma_entrega");

	 	$sql = "SELECT *
                FROM forma_entrega  
                WHERE id_forma_entrega = ? "; 

		$query = $this->db->query($sql, array( $id_forma_entrega ));

		if($query->num_rows() > 0)
		{ 
			return $query->row()->descripcion;
		}
		else
		{
			return false;
		}

	}
 

}

/* End of file  */
/* Location: ./application/models/ */