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
		$query = $this->db->query('SELECT SUM(PP.cantidad*PP.precio_unitario) as total
		                            FROM pedido_producto AS PP
		                            WHERE PP.id_pedido='.$id);
		$result = $query->row_array();
		return number_format($result['total'],2);
	}

	public function get_cantidad_items_pedido( $id ) 
	{
		$query = $this->db->query('SELECT SUM(PP.cantidad) as cantidad
		                            FROM pedido_producto AS PP
		                            WHERE PP.id_pedido='.$id);
		$result = $query->row_array();
		return $result['cantidad'];
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
        //if(isset($array['calle'])):

		if($array['entrega'] == FORMA_ENTREGA_DELIVERY ):

			$array_delivery = array(
	            'direccion' => $array['calle'],
	            'altura' => $array['altura'],
	            'id_pedido' => $id_pedido
	        );

        	$this->db->insert('pedido_delivery', $array_delivery);

        endif;


    	$array_pedido = array(
			'id_pedido_estado' => PEDIDO_ESTADO_PENDIENTE,
            'id_usuario' => $id_usuario,
            'id_forma_pago' => $array['pago'],
            'id_forma_entrega' => $array['entrega']
        );

        $this->db->where( array('id_pedido' => $id_pedido) );
        return $this->db->update('pedido', $array_pedido);
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
	            'precio_unitario' => $producto['precio']
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

		chrome_log("Pedido_model/traer_descripcion_forma_pago");

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

	public function buscar_pedidos($array)
	{
		chrome_log("Pedido_model/buscar_pedidos");

		//var_dump($array);

		$filtros = $ordenar = "";

		if($array['id_forma_entrega'] != -1 ):
			$filtros .= " AND pe.id_forma_entrega = ".$array['id_forma_entrega'];
		endif;

		if($array['id_pedido_estado'] != -1 ):
			$filtros .= " AND pe.id_pedido_estado = ".$array['id_pedido_estado'];
		endif;

		if($array['email']):
			$filtros .= " AND u.email LIKE '%".$array['email']."%'";	
		endif;

		// ORDENAR

		switch ($array['ordenar']) 
		{
			case 'hora_entrega':
				$ordenar = 'pe.hora_entrega';
				break;
		
			case 'pedido_estado':
				$ordenar = 'pe.id_pedido_estado';
				break;

			case 'forma_entrega':
				$ordenar = 'pe.id_forma_entrega';
				break;

			default:
				$ordenar = 'pe.id_pedido';
				break;
		}

		$ordenar = $ordenar." ".$array['ordenar_direccion'];

	 	$sql = 		"SELECT pe.*,
						   pd.direccion, pd.telefono, pd.nota, pd.altura,
						   fp.descripcion as forma_pago,
						   fe.descripcion as forma_entrega,
						   pes.descripcion as estado,
						   u.email,
						   ur.nombre
	    			FROM pedido pe
		    				 left join pedido_delivery pd ON pe.id_pedido = pd.id_pedido
		    				 inner join forma_pago fp ON pe.id_forma_pago =  fp.id_forma_pago
		    				 inner join forma_entrega fe ON pe.id_forma_entrega =  fe.id_forma_entrega
		    				 inner join pedido_estado pes ON pe.id_pedido_estado =  pes.id_pedido_estado,
	    				 usuario u
	    				 	left join usuario_registrado ur ON ur.id_usuario =  u.id_usuario
	    			WHERE  pe.id_usuario =  u.id_usuario 
	    				   $filtros
	    			ORDER BY $ordenar "; 

		$query = $this->db->query($sql);

		//echo $sql;

		if($query->num_rows() > 0)
		{ 
			return $query->result_array();
 		}
		else
		{
			return false;
		}

	}

	public function traer_descripcion_forma_entrega( $id_forma_entrega )
	{	

		chrome_log("Pedido_model/traer_descripcion_forma_entrega");

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

 	public function get_pedido_estados()
	{	

		chrome_log("Pedido_model/get_pedido_estados");

	 	$sql = "SELECT *
                FROM pedido_estado 
                WHERE id_pedido_estado != ".PEDIDO_ESTADO_SIN_CONFIRMAR; 

		$query = $this->db->query($sql);

		if($query->num_rows() > 0)
		{ 
			return $query->result_array();
		}
		else
		{
			return false;
		}
	}

	public function get_forma_entrega()
	{	

		chrome_log("Pedido_model/get_forma_entrega");

	 	$sql = "SELECT *
                FROM forma_entrega  "; 

		$query = $this->db->query($sql);

		if($query->num_rows() > 0)
		{ 
			return $query->result_array();
		}
		else
		{
			return false;
		}
	}


	function traer_pedidos_pendientes()
    {
   	
    	$resultado = $this->db->query("	SELECT pe.*,
    										   pd.direccion, pd.telefono, pd.nota, pd.altura,
    										   fp.descripcion as forma_pago,
    										   fe.descripcion as forma_entrega,
    										   pes.descripcion as estado,
    										   u.email,
    										   ur.nombre
						    			FROM pedido pe
							    				 left join pedido_delivery pd ON pe.id_pedido = pd.id_pedido
							    				 inner join forma_pago fp ON pe.id_forma_pago =  fp.id_forma_pago
							    				 inner join forma_entrega fe ON pe.id_forma_entrega =  fe.id_forma_entrega
							    				 inner join pedido_estado pes ON pe.id_pedido_estado =  pes.id_pedido_estado,
						    				 usuario u
						    				 	left join usuario_registrado ur ON ur.id_usuario =  u.id_usuario
						    			WHERE  pe.id_pedido_estado != 1
						    			AND pe.id_usuario =  u.id_usuario
						    			ORDER BY id_pedido DESC "  ); //traer_pedidos_pendientes

    	return $resultado->result_array();
    }

	public function procesa_cambiar_estado_pedido( $array )
	{
 		$array_pedido = array(
            'id_pedido_estado' => $array['id_pedido_estado']
        );

        $this->db->where( array('id_pedido' =>  $array['id_pedido'] ) );

        return	$this->db->update('pedido', $array_pedido);
	
        //return $this->db->affected_rows();
	}
}

/* End of file  */
/* Location: ./application/models/ */