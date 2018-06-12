<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pedido_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_pedido( $id ) 
	{
		if($this->session->userdata('id_usuario') == "")
		{
			$aux = array(
	            'id_pedido' => NULL,
	            'id_pedido_estado' => PEDIDO_ESTADO_SIN_CONFIRMAR,
	            'id_sucursal' => SUCURSAL,
	            'id_usuario' => NULL,
	            'id_forma_pago' => NULL,
	            'id_forma_entrega' => NULL,
	            'hora_entrega' => NULL,
	            'fecha_pedido' => NULL
	        );
	        return $aux;
		}

		$query = $this->db->query('SELECT *
		                            FROM pedido AS P
		                            WHERE P.id_pedido='.$id);
		return $query->row_array();
	}
	
	public function get_pedido_productos( $id ) 
	{
		if($this->session->userdata('id_usuario') == "")
		{
			$array = array();
			foreach ($this->cart->contents() as $item)
			{
				$query = $this->db->query('SELECT *
				                            FROM producto AS P
				                            WHERE P.id_producto='.$item['id']);
				$producto = $query->row_array();
				$aux = array(
		            'id_pedido_producto' => $item['rowid'],
		            'id_pedido' => NULL,
		            'id_producto' => $item['id'],
		            'cantidad' => $item['qty'],
		            'precio_unitario' => $item['price'],

		            'id_producto_tipo' => $producto['id_producto_tipo'],
		            'nombre' => $producto['nombre'],
		            'path_imagen' => $producto['path_imagen'],
		            'descripcion' => $producto['descripcion'],
		            'precio' => $producto['precio'],
		            'orden_aparicion_web' => $producto['orden_aparicion_web']
		        );
		        $array[] = $aux;
			}
			return $array;
		}

		$query = $this->db->query('SELECT *
		                            FROM pedido_producto AS PP
		                            INNER JOIN producto AS P ON PP.id_producto = P.id_producto
		                            WHERE PP.id_pedido='.$id);
		return $query->result_array();
	}

	public function get_informacion_pedido_producto($id_pedido_producto)
	{
		chrome_log("Pedido_model/get_informacion_pedido_producto");

	 	$sql = "SELECT 
				           pp.*
				FROM
				           pedido_producto pp 
				WHERE
				         pp.id_pedido_producto = ? "; 

		$query = $this->db->query($sql, array($id_pedido_producto) );
	 
	    return $query->row_array();
	}

	public function get_ingredientes_pedido_producto($id_pedido_producto)
	{
		chrome_log("Pedido_model/get_ingredientes_pedido_producto");

		$sql = "SELECT 	ppi.*, 
			           	i.nombre,
			           	i.path_imagen,
			           	i.precio,
			           	i.calorias
				FROM
				        pedido_producto_ingrediente ppi,
				      	ingrediente i 

				WHERE
				        ppi.id_pedido_producto = ?
				AND    	ppi.id_ingrediente = i.id_ingrediente  "; 

		$query = $this->db->query($sql, array($id_pedido_producto) );
	 
	    return $query->result_array();
	}
	
	public function get_total_pedido( $id ) 
	{
		if($this->session->userdata('id_usuario') == "")
		{
			return number_format($this->cart->total(),2);
		}

		$query = $this->db->query('SELECT SUM(PP.cantidad*PP.precio_unitario) as total
		                            FROM pedido_producto AS PP
		                            WHERE PP.id_pedido='.$id);
		$result = $query->row_array();
		return number_format($result['total'],2);
	}

	public function get_cantidad_items_pedido( $id ) 
	{
		if($this->session->userdata('id_usuario') == "")
		{
			return $this->cart->total_items();
		}

		$query = $this->db->query('SELECT SUM(PP.cantidad) as cantidad
		                            FROM pedido_producto AS PP
		                            WHERE PP.id_pedido='.$id);
		$result = $query->row_array();
		
		if($result && $result['cantidad'])
		{
			return $result['cantidad'];
		}
		else
		{
			return 0;
		}
	}

	public function set_pedido( $array = FALSE )
	{
		chrome_log("Pedido_model/set_pedido");

		if($this->session->userdata('id_usuario') == "")
		{
			return NULL;
		}

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
        chrome_log("finalizar_pedido".$id_pedido.", ".$id_usuario.", ".$array['horario']  );

		if($array['entrega'] == FORMA_ENTREGA_DELIVERY ):

			chrome_log("FORMA_ENTREGA_DELIVERY");

			$array_delivery = array(
	            'direccion' => $array['calle'],
	            'nota' => $array['nota'],
	            'id_pedido' => $id_pedido
	        );

        	$this->db->insert('pedido_delivery', $array_delivery);

        endif;

        $fecha_entrega = date("Y-m-d")." ".$array['horario'];

         chrome_log("fecha_entrega: ".$fecha_entrega );

    	$array_pedido = array(
			'id_pedido_estado' => PEDIDO_ESTADO_PENDIENTE,
            'id_usuario' => $id_usuario,
            'id_forma_pago' => $array['pago'],
            'id_forma_entrega' => $array['entrega'],
            'fecha_entrega' => $fecha_entrega,
            'fecha_pedido' => date('Y-m-d H:i:s')
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

		if($this->session->userdata('id_usuario') == "")
		{
			$aux = array(
		        'id'      => $producto['id_producto'],
		        'qty'     => 1,
		        'price'   => $producto['precio'],
		        'name'    => $producto['nombre']
			);

			return $this->cart->insert($aux);
		}

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
	        $this->db->insert('pedido_producto', $array);
	        $id_pedido_producto = $this->db->insert_id();

	        //-----------------------------------------
	        //-------------- [NUEVO] -------------------
	        //-----------------------------------------

		        $array_grupo_ingredientes = $this->get_ingredientes_default_producto($id_producto);

		        // Recorro los ingredientes
		        foreach ($array_grupo_ingredientes as $row) 
		        {
		        	$result = $this->set_pedido_producto_ingrediente($id_pedido_producto, $row['id_grupo'], $row['id_ingrediente']);
		        }

	        //-----------------------------------------
	        //-------------- [FIN NUEVO] -------------------
	        //-----------------------------------------
		}

        return $result;
	}

	public function set_pedido_producto_ingrediente($id_pedido_producto, $id_grupo, $id_ingrediente)
	{
		$array_ingredientes = array(
            'id_pedido_producto' => $id_pedido_producto,
            'id_grupo' => $id_grupo,
            'id_ingrediente' => $id_ingrediente
    	);

    	return $this->db->insert('pedido_producto_ingrediente', $array_ingredientes);
	}

	public function delete_pedido_producto_ingredientes($id_pedido_producto)
	{
		$this->db->where( array('id_pedido_producto' => $id_pedido_producto) );
        return $this->db->delete('pedido_producto_ingrediente');
	}

	public function get_ingredientes_default_producto($id_producto)
    {
        chrome_log("Producto_model/get_ingredientes_producto");

        // Traigo los ingredientes default del producto 

        $sql = "SELECT pg.id_grupo
                FROM producto_grupo pg,
                     producto_grupo_ingrediente pgi 
                WHERE pg.id_producto = ? 
                AND pg.id_producto = pgi.id_producto
                AND pg.id_grupo = pgi.id_grupo 
                AND pgi.es_default = 1"; 

        $query = $this->db->query($sql, array($id_producto) );
     
        return $query->result_array();
    }

	public function mover_productos_carrito()
	{
		foreach ($this->cart->contents() as $item)
		{
	        $array = array(
	            'id_pedido' => $this->session->userdata('id_pedido'),
	            'id_producto' => $item['id'],
	            'cantidad' => $item['qty'],
	            'precio_unitario' => $item['price']
	        );
	        $result = $this->db->insert('pedido_producto', $array);
		}

        return TRUE;
	}

	public function modificar_producto_cantidad( $id_pedido_producto, $cantidad )
	{
		if($this->session->userdata('id_usuario') == "")
		{
			$data = array(
		        'rowid' => $id_pedido_producto,
		        'qty'   => $cantidad
			);

			return $this->cart->update($data);
		}

		$array = array(
            'cantidad' => $cantidad
        );

        $this->db->where( array('id_pedido_producto' => $id_pedido_producto) );
        return $this->db->update('pedido_producto', $array);
	}

	public function eliminar_producto( $id_pedido_producto )
	{
		if($this->session->userdata('id_usuario') == "")
		{
			return $this->cart->remove($id_pedido_producto);
		}

        $this->db->where( array('id_pedido_producto' => $id_pedido_producto) );
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

	public function get_forma_pago()
	{	

		chrome_log("Pedido_model/get_forma_pago");

	 	$sql = "SELECT *
                FROM forma_pago  "; 

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


	public function traer_pedidos_pendientes()
    {
   	
    	$resultado = $this->db->query("	SELECT pe.*,
    										   pd.direccion, pd.telefono, pd.nota,
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
						    			WHERE pe.id_pedido_estado != 1
						    			AND pe.id_usuario =  u.id_usuario
						    			ORDER BY id_pedido DESC "  ); //traer_pedidos_pendientes

    	return $resultado->result_array();
    }

    public function get_informacion_pedido($id_pedido)
    {
   	
    	$resultado = $this->db->query("	SELECT pe.*,
    										   pd.direccion, pd.telefono, pd.nota,
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
						    			WHERE pe.id_pedido_estado != 1
						    			AND pe.id_usuario =  u.id_usuario
						    			AND pe.id_pedido = $id_pedido
						    			ORDER BY id_pedido DESC "  ); //traer_pedidos_pendientes

    	return $resultado->row_array();
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
 
	public function buscar_pedidos($array , &$texto_filtros)  
	{
		chrome_log("Pedido_model/buscar_pedidos");

		if( !$array)
			redirect('administrador/pedidos/','refresh');

		$filtros = $ordenar = $productos = "";

		if($array['id_forma_entrega'] != -1 ):

			$filtros .= " AND pe.id_forma_entrega = ".$array['id_forma_entrega'];
			$valor = $this->get_nombre_forma_entrega($array['id_forma_entrega']); 
			$texto_filtros .= "<span class='label label-primary'> Forma entrega: $valor </span> &nbsp;";

		endif;

		if($array['id_pedido_estado'] != -1 ):

			$filtros .= " AND pe.id_pedido_estado = ".$array['id_pedido_estado'];
			$valor = $this->get_nombre_estado_pedido($array['id_pedido_estado']); 
			$texto_filtros .= "<span class='label label-primary'> Forma entrega: $valor </span> &nbsp;";

		endif;

		if($array['email']):
			$filtros .= " AND u.email LIKE '%".$array['email']."%'";
			$valor = $array['email'];
			$texto_filtros .= "<span class='label label-primary'> Email: $valor </span> &nbsp;";
		endif;


		if(isset($array['id_productos'])):
			
			$texto_filtros .= "<span class='label label-primary'> Productos: ";

			$i = 0;

			foreach ($array['id_productos'] as $row) 
			{	
				$texto_filtros .= $this->get_nombre_producto($row).". ";

				if($i == 0)
					$productos .= " AND ";
				else
					$productos .= " OR";

				$productos .= " pp.id_producto = ".$row;

				$i++;

			}

			$texto_filtros .= "</span> &nbsp;";

 		endif;

 		$fecha_desde_entrega = $array['fecha_desde']." ".$array['hora_desde'];
 		$fecha_hasta_entrega = $array['fecha_hasta']." ".$array['hora_hasta'];
 	 
		//$filtros .= " AND pe.fecha_pedido BETWEEN '".$array['fecha_desde']."' AND '".$array['fecha_hasta']."'";	
		$texto_filtros .= "<span class='label label-primary'> Fecha desde: ".$array['fecha_desde']." - Fecha hasta: ".$array['fecha_hasta']."</span> &nbsp;";
 
		//$filtros .= " AND pe.fecha_entrega BETWEEN '".$array['hora_desde']."' AND '".$array['hora_hasta']."'";
		$texto_filtros .= "<span class='label label-primary'> Hora desde: ".$array['hora_desde']." - Hora hasta: ".$array['hora_hasta']."</span> &nbsp;";

		$filtros .= " AND pe.fecha_entrega BETWEEN '".$fecha_desde_entrega."' AND '".$fecha_hasta_entrega."'" ;

		$texto_filtros .= "<span class='label label-info'> Ordenado por: ";

		switch ($array['ordenar']) 
		{
			case 'fecha_entrega':
				$ordenar = 'pe.fecha_entrega';
				$texto_filtros .= "hora de entrega";
				break;
		
			case 'pedido_estado':
				$ordenar = 'pe.id_pedido_estado';
				$texto_filtros .= "estado pedido";
				break;

			case 'forma_entrega':
				$ordenar = 'pe.id_forma_entrega';
				$texto_filtros .= "forma de entrega";
				break;

			default:
				$ordenar = 'pe.id_pedido';
				$texto_filtros .= "numero de pedido";
				break;
		}

		$texto_filtros .= "</span> &nbsp;";


		$ordenar = $ordenar." ".$array['ordenar_direccion'];

	 	$sql = 		"SELECT distinct(pe.id_pedido),
	 	                    pe.*,
						    pd.direccion, pd.telefono, pd.nota, 
						    fp.descripcion as forma_pago,
						    fe.descripcion as forma_entrega,
						    pes.descripcion as estado,
						    u.email 
	    			FROM pedido pe
		    				 left join pedido_delivery pd ON pe.id_pedido = pd.id_pedido
		    				 inner join forma_pago fp ON pe.id_forma_pago =  fp.id_forma_pago
		    				 inner join forma_entrega fe ON pe.id_forma_entrega =  fe.id_forma_entrega
		    				 inner join pedido_estado pes ON pe.id_pedido_estado =  pes.id_pedido_estado
		    				 inner join usuario u ON pe.id_usuario =  u.id_usuario,
	    				 pedido_producto pp
	    			WHERE  pe.id_pedido = pp.id_pedido
	    				   $filtros
	    				   $productos
	    			ORDER BY $ordenar "; 

		//echo $sql;

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

	// Traer nombres

	public function get_nombre_forma_entrega($id_forma_entrega)
	{	

		chrome_log("Pedido_model/get_nombre_forma_entrega");

	 	$sql = "SELECT descripcion
                FROM forma_entrega  
                WHERE id_forma_entrega = ? "; 

		$query = $this->db->query($sql, array($id_forma_entrega ) );

		if($query->num_rows() > 0)
			return $query->row()->descripcion;
		else
			return false;

	}

	public function get_nombre_estado_pedido($id_pedido_estado)
	{	

		chrome_log("Pedido_model/get_nombre_estado_pedido");

	 	$sql = "SELECT descripcion
                FROM pedido_estado  
                WHERE id_pedido_estado = ? "; 

		$query = $this->db->query($sql, array($id_pedido_estado ) );

		if($query->num_rows() > 0)
			return $query->row()->descripcion;
		else
			return false;

	}

	public function get_nombre_producto($id_producto)
	{	

		chrome_log("Pedido_model/get_nombre_producto");

	 	$sql = "SELECT nombre
                FROM producto  
                WHERE id_producto = ? "; 

		$query = $this->db->query($sql, array($id_producto ) );

		if($query->num_rows() > 0)
			return $query->row()->nombre;
		else
			return false;

	}
 
	/***************
	HORARIOS
	****************/
	
	public function get_horarios_disponibles()
	{
		$fecha = date('Y-m-d');
		$return = array();

		$horarios = $this->get_horarios_entrega();
		$margen = $this->get_margen_horarios();

		foreach ($horarios as $key => $horario)
		{
			$hora = $horario['hora_inicio'];
			if(strtotime($hora) < strtotime(date('H:i:s')))
			{
				$nuevaHora = strtotime( '+1 hour' , strtotime(date('H:00:00')) );
				$hora = date( 'H:i:00' , $nuevaHora );
			}
			while(strtotime($hora) <= strtotime($horario['hora_fin']))
			{
				//echo $hora." - ".$horario['hora_fin']."<br>";
				$cant_pedido = $this->get_pedidos_horario($hora, $fecha);
				$disponibilidad = $margen['capacidad_entrega'] - $cant_pedido;
				if($disponibilidad > 0)
				{
					$return[] = $hora;
				}

				$nuevaHora = strtotime( '+'.$margen['margen_entrega'].' minute' , strtotime($hora) );
				$hora = date( 'H:i:00' , $nuevaHora );
			}
		}

    	return $return;
	}

	public function get_margen_horarios()
	{
 		$resultado = $this->db->query("	SELECT *
						    			FROM sucursal AS S
						    			WHERE S.id_sucursal = 1" );

    	return $resultado->row_array();
	}

	public function get_horarios_entrega()
	{
		$dia = date('w');

 		$resultado = $this->db->query("	SELECT *
						    			FROM sucursal_horario AS H
						    			WHERE H.id_sucursal = 1
						    			AND H.dia = ".$dia."
						    			ORDER BY H.id_horario " );

    	return $resultado->result_array();
	}

	public function get_pedidos_horario($hora = "00:00:00", $fecha = "0000-00-00")
	{
 		$resultado = $this->db->query("	SELECT COUNT(1) as cant
						    			FROM pedido AS P
						    			WHERE P.fecha_entrega = '".$hora."'
						    			AND P.fecha_pedido >= '".$fecha." 00:00:00'
						    			AND P.fecha_pedido <= '".$fecha." 23:59:59'" );

    	return $resultado->row()->cant;
	}
 
}

/* End of file  */
/* Location: ./application/models/ */