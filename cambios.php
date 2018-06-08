<?php 

// -----------------------------------------------------------
// 1) SET PRODUCTO: 
// -----------------------------------------------------------

// Al agregar el producto al carrito tambien hay que agregar los ingredientes default de ese producto, a ese pedido. En el controlador Pedido, en la funcion agregar_producto_ajax, se llama a la funcion pedido_model->set_producto, ahi hay que buscar los ingredientes y despues insertarlos.

// PEDIDO_MODEL 

// 1.1 - En [NUEVO] hay que llamar a la funcion que trae los ingredientes default.
	
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
        $result = $this->db->insert('pedido_producto', $array);

        //-----------------------------------------
        //-------------- [NUEVO] -------------------
        //-----------------------------------------

	        $array_grupo_ingredientes = $this->Producto_model->get_ingredientes_default_producto($id_producto);

	        // Recorro los ingredientes

	        foreach ($array_grupo_ingredientes as $row) 
	        {

				$array_ingredientes = array(
		            'id_pedido_producto' => $this->session->userdata('id_pedido'),
		            'id_grupo' => $row['id_grupo'],
		            'id_ingrediente' => $row['id_ingrediente']
	        	);

	        	$result = $this->db->insert('pedido_producto_ingrediente', $array_ingredientes);
 
	        }

        //-----------------------------------------
        //-------------- [FIN NUEVO] -------------------
        //-----------------------------------------

	}

    return $result;
}

// PRODUCTO_MODEL 

// 1.2-  Selecciona los ingredientes default de cada grupo que forman el producto.

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
 

// -----------------------------------------------------------
// FIN SET PRODUCTO 
// -----------------------------------------------------------



// -----------------------------------------------------------
// 2) EDITAR LOS INGREDIENTES DE UN PRODUCTO 
// -----------------------------------------------------------

// CONTROLADOR PEDIDO

// 2.1 - En el carrito, cada producto tiene un boton EDITAR. Al apretar editar, hay que llamar a la funcion:

public function ver_editar_ingredientes_producto()
{	

	if ($this->form_validation->run('ver_editar_ingredientes_producto') == FALSE):

		chrome_log("No paso validacion");
		$return["resultado"] = FALSE;
		$return["mensaje"] ='Ha ocurrido un error en la validacion.'; 


	else: 

		// Buscamos la informacion del pedido_producto

		$datos['informacion_pedido_producto'] =  $this->Pedido_model->get_informacion_pedido_producto($this->input->post('id_pedido_producto'));

		// Buscamos los ingredientes del pedido_producto

		$datos['informacion_ingredientes_pedido_producto'] =  $this->Pedido_model->get_ingredientes_pedido_producto($this->input->post('id_pedido_producto'));

		// Buscamos informacion del producto: aca habria que comprobar el estado del producto. 

		$datos['informacion_producto'] =  $this->Producto_model->get_informacion_producto($datos['informacion_pedido_producto']['id_producto']);

		// Buscamos los grupos que forman el producto.

		$grupos_producto =  $this->Producto_model->get_grupos_producto($datos['informacion_pedido_producto']['id_producto']);

		$array_grupos = array();

		foreach ($grupos_producto as $row) // Recorremos los grupos para traer los ingredientes.
		{
			$grupo['datos_grupo'] = $row;

			// Buscamos los ingredientes del grupo: aca habria que comprobar el estado del ingrediente.  
			$grupo['ingredientes_grupo'] = $this->Producto_model->get_ingredientes_grupo( $row['id_grupo'] );
			array_push($array_grupos, $grupo);
		}

		$datos['grupos_producto'] = $array_grupos;

		$this->load->view('Pedido/ver_editar_pedido_producto', $datos);

	endif;
}

// 2.2 - Despues que el cliente edita el pedido, se llama a esta funcion. Puede ser con un ajax o con un redirect, como te parezca mejor.

public function editar_ingredientes_producto()
{	

	if ($this->form_validation->run('editar_ingredientes_producto') == FALSE):

		chrome_log("No paso validacion");
		$return["resultado"] = FALSE;
		$return["mensaje"] ='Ha ocurrido un error en la validacion.'; 

	else: 

		

	endif;

}


// FORM VALIDATION

	'ver_editar_ingredientes_producto' => array(
                                     array(
                                            'field' => 'id_pedido_producto',
                                            'label' => 'id_pedido_producto',
                                            'rules' => 'strip_tags|required|trim|xss_clean'
                                         ) 
                                ),

  	
  	'editar_ingredientes_producto' => array(
                                     array(
                                       
                                         ) 
                                ),

// PEDIDO_MODEL

	public function get_informacion_pedido_producto($id_pedido_producto)
	{
		chrome_log("Pedido_model/get_informacion_pedido_producto");

	 	$sql = "SELECT 
				           pp.*
				FROM
				           pedido_producto pp 
				WHERE
				         pp.id_pedido = ? "; 

		$query = $this->db->query($sql, array($id_pedido_producto) );
	 
	    return $query->row_array();
	}

	public function get_ingredientes_pedido_producto($id_pedido_producto)
	{
		chrome_log("Pedido_model/get_ingredientes_pedido_producto");

		$sql = "SELECT 	ppi.*, 
			           	i.nombre,
			           	i.path_image,
			           	i.precio,
			           	i.calorias
				FROM
				        pedido_producto_ingrediente ppi,
				      	ingrediente i 

				WHERE
				        ppi.id_pedido_producto = ?
				AND    	pi.id_ingrediente = i.id_ingrediente  "; 

		$query = $this->db->query($sql, array($id_pedido_producto) );
	 
	    return $query->result_array();
	}

// PRODUCTO_MODEL

	function get_informacion_producto($id_producto)
	{
		$sql = 	'	SELECT 
					      p.id_producto,
					      p.id_producto_tipo,
					      p.nombre,
					      p.path_image,
					      p.descripcion,
					      p.precio,
					      pt.descripcion as descripcion_tipo_producto,
					      pes.id_producto_estado,
					      pe.descripcion as descripcion_estado_producto,

					FROM
					      producto p,
					      producto_tipo pt,
					      producto_estado_sucursal pes,
					      producto_estado pe

					WHERE
					      p.id_producto = ?
					AND   p.id_producto_tipo = pt.id_producto_tipo
					AND   p.id_producto = pes.id_producto
					AND   pes.id_producto_estado = pe.id_producto_estado '; 

		$query = $this->db->query($sql, array( $id_producto) ); 

	    return $query->result_array();
	}

	function get_grupos_producto($id_producto)
	{
		$sql = 	'	SELECT *
				 	FROM 	producto_grupo pg,
				 			grupo g
				 	WHERE 	pg.id_producto = ?
				 	AND 	pg.id_grupo = g.id_grupo' ; 

		$query = $this->db->query($sql, array( $id_producto) ); 

	    return $query->result_array();
	}

	function get_ingredientes_grupo($id_grupo)
	{
		$sql = 	'	SELECT 	*
				 	FROM 	grupo_ingrediente gi,
				 			ingrediente i,
				 			ingrediente_estado_cucursal ies,
    						ingrediente_estado ie
				 	WHERE   gi.id_grupo = ? 	
				 	AND 	gi.id_ingrediente = i.id_ingrediente 
				 	AND   	ies.id_ingrediente = i.id_ingrediente 
				 	AND   	ies.id_ingrediente_estado = ie.id_ingrediente_estado  ' ; 

		$query = $this->db->query($sql, array( $id_grupo) ); 

	    return $query->result_array();
	}
 
// VISTA VER_EDITAR PEDIDO PRODUCTO

	// Esta vista la definis vos Fabi, te dejo algunas cosas que pensamos el otro dia y una sugerencia de como acceder a los datos en base a como te envié los datos desde backgrund. Cualquier mejora o cambio que sea necesario, hacelo sin preguntarme.

	// Tenes que listar todos los ingredientes por grupo y en ese listado/grupo tenes la informacion para cobrar el adicional cuando pasan la cantidad default, controlar que no pasen el maximo ni el minimo.
	// Cuando se hace el submit, necesito:
	// 1. El id_pedido_producto, un input hidden.
	// 2. El par : id_ingrediente- id_grupo. Para esto, como vamos a usar checkbox, capaz podemos enviarlo en un json en cada input.
	// Si se te ocurre otra forma mejor, hacelo.

	for ( $i=0; $i < count( $grupos_producto); $i++ ):

		// Aca tenes toda la informacion para controlar el grupo
		$informacion_grupo = $grupos_producto[$i]['datos_grupo'];

		// Listamos los ingredientes y hacemos checkbox.

		foreach ($grupos_producto[$i]['ingredientes_grupo'] as $row)
		{
			// Hay que controlar si le ingrediente ya esta en el pedido para chequearlo.
			// hay que usar el array:  $informacion_ingredientes_pedido_producto.

			$dato['id_grupo'] = $row['id_grupo'];
			$dato['id_ingrediente'] = $row['id_ingrediente'];
			$json_dato = json_encode($dato);

			echo '<input type="checkbox" name="ingrediente[]" value="<?=$json_dato?>" >';
		}

	endif;

	 

?>
