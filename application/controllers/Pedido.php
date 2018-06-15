<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pedido extends CI_Controller {

	private static $solapa = "pedido";
			
	public function __construct()
	{
		parent::__construct();

		date_default_timezone_set ( "America/Argentina/Buenos_Aires" );

		$this->load->model('pedido_model');
		$this->load->model('pago_model');
		$this->load->model('producto_model');
		$this->load->model('Usuario_model');

		if(!$this->session->userdata('id_pedido'))
		{
			$id_pedido = $this->pedido_model->set_pedido();
			$this->session->set_userdata('id_pedido', $id_pedido); 
		}

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
	}

	public function index()
	{
		$data['pedido'] = $this->pedido_model->get_pedido( $this->session->userdata('id_pedido') );
		$data['items'] = $this->pedido_model->get_pedido_productos( $this->session->userdata('id_pedido') );
		$data['cantidad'] = $this->pedido_model->get_cantidad_items_pedido( $this->session->userdata('id_pedido') );
		$data['total'] = $this->pedido_model->get_total_pedido( $this->session->userdata('id_pedido') );

		$this->load->view(self::$solapa.'/index', $data);
	}

	public function ver_editar_ingredientes_producto($id_pedido_producto)
	{	
		// Buscamos la informacion del pedido_producto

		$datos['informacion_pedido_producto'] =  $this->pedido_model->get_informacion_pedido_producto($id_pedido_producto);

		// Buscamos los ingredientes del pedido_producto

		$datos['informacion_ingredientes_pedido_producto'] =  $this->pedido_model->get_ingredientes_pedido_producto($id_pedido_producto);

		// Buscamos informacion del producto: aca habria que comprobar el estado del producto. 

		$datos['informacion_producto'] =  $this->producto_model->get_informacion_producto($datos['informacion_pedido_producto']['id_producto']);

		// Buscamos los grupos que forman el producto.

		$grupos_producto =  $this->producto_model->get_grupos_producto($datos['informacion_pedido_producto']['id_producto']);

		$array_grupos = array();

		$datos['cantidad'] = 0;

		foreach ($grupos_producto as $row) // Recorremos los grupos para traer los ingredientes.
		{
			$grupo['datos_grupo'] = $row;

			// Buscamos los ingredientes del grupo: aca habria que comprobar el estado del ingrediente.  
			$grupo['ingredientes_grupo'] = $this->producto_model->get_ingredientes_grupo_producto( $row['id_grupo'], $row['id_producto'] );
			foreach ($grupo['ingredientes_grupo'] as $key_ingrediente_grupo => $ingrediente_grupo)
			{
				foreach ($datos['informacion_ingredientes_pedido_producto'] as $key_ingrediente_pedido_producto => $ingrediente_pedido_producto)
				{
					if($ingrediente_grupo['id_ingrediente'] == $ingrediente_pedido_producto['id_ingrediente'] && $row['id_grupo'] == $ingrediente_pedido_producto['id_grupo'])
					{
						$grupo['ingredientes_grupo'][$key_ingrediente_grupo]['seleccionado'] = TRUE;
						$datos['cantidad']++;
					}
				}
			}
			
			array_push($array_grupos, $grupo);
		}

		$datos['grupos_producto'] = $array_grupos;

		$datos['total'] = 0;

		$this->load->view(self::$solapa.'/ver_editar_pedido_producto', $datos);
	}

	public function editar_ingredientes_producto_ajax()
	{
		if ($this->form_validation->run('ver_editar_ingredientes_producto') == FALSE)
		{
			chrome_log("No paso validacion");
			$return["resultado"] = FALSE;
			$return["mensaje"] = 'Ha ocurrido un error en la validacion.'; 
		}
		else
		{
			$this->pedido_model->delete_pedido_producto_ingredientes($this->input->post('id_pedido_producto'));

			$datos['informacion_producto'] =  $this->producto_model->get_informacion_producto($this->input->post('id_producto'));
			$grupos_producto = $this->producto_model->get_grupos_producto($this->input->post('id_producto'));

			$return["precio"] = $datos['informacion_producto'][0]['precio'];
			$return['cantidad'] = 0;

			$id_grupos = $this->input->post('id_grupo[]');
			$id_ingredientes = $this->input->post('id_ingrediente[]');
			if($this->input->post('ingredientes[]') != "")
			{
				foreach ($this->input->post('ingredientes[]') as $key => $value)
				{
					$this->pedido_model->set_pedido_producto_ingrediente($this->input->post('id_pedido_producto'), $id_grupos[$value], $id_ingredientes[$value]);

					$pos = array_search($id_grupos[$value], $grupos_producto);
					if(array_key_exists('cantidad', $grupos_producto[$pos]))
					{
						$grupos_producto[$pos]['cantidad']++;
					}
					else
					{
						$grupos_producto[$pos]['cantidad'] = 1;
					}

					if($grupos_producto[$pos]['cantidad'] > $grupos_producto[$pos]['cantidad_default'])
					{
						$return["precio"] += $grupos_producto[$pos]['precio_adicional'];
					}
					$return['cantidad']++;
				}
			}

			$result = $this->pedido_model->modificar_producto_precio($this->input->post('id_pedido_producto'), $return["precio"]);
			if($result)
			{
				$return["resultado"] = TRUE;
				$return["mensaje"] = 'Perfecto';
			}
			else
			{
				$return["resultado"] = FALSE;
				$return["mensaje"] = 'Ocurrio un error al actualizar el producto.';
			}
		}

		echo json_encode($return);
	}

	public function editar_precio_producto_ajax()
	{
		if ($this->form_validation->run('ver_editar_ingredientes_producto') == FALSE)
		{
			chrome_log("No paso validacion");
			$return["resultado"] = FALSE;
			$return["mensaje"] = 'Ha ocurrido un error en la validacion.'; 
		}
		else
		{
			$return["resultado"] = TRUE;
			$return["mensaje"] = 'Perfecto';

			$datos['informacion_producto'] =  $this->producto_model->get_informacion_producto($this->input->post('id_producto'));
			$grupos_producto = $this->producto_model->get_grupos_producto($this->input->post('id_producto'));

			$return["precio"] = $datos['informacion_producto'][0]['precio'];
			$return['cantidad'] = 0;

			$id_grupos = $this->input->post('id_grupo[]');
			$id_ingredientes = $this->input->post('id_ingrediente[]');
			if($this->input->post('ingredientes[]') != "")
			{
				foreach ($this->input->post('ingredientes[]') as $key => $value)
				{
					//$this->pedido_model->set_pedido_producto_ingrediente($this->input->post('id_pedido_producto'), $id_grupos[$value], $id_ingredientes[$value]);
					
					$pos = array_search($id_grupos[$value], $grupos_producto);
					if(array_key_exists('cantidad', $grupos_producto[$pos]))
					{
						$grupos_producto[$pos]['cantidad']++;
					}
					else
					{
						$grupos_producto[$pos]['cantidad'] = 1;
					}

					if($grupos_producto[$pos]['cantidad'] > $grupos_producto[$pos]['cantidad_default'])
					{
						$return["precio"] += $grupos_producto[$pos]['precio_adicional'];
					}
					$return['cantidad']++;
				}
			}
			
			foreach ($grupos_producto as $pos => $row)
			{
				if($row['cantidad'] < $row['cantidad_minima'])
				{
					$return["resultado"] = FALSE;
					$return["mensaje"] = 'Tiene que seleccionar mas ingredientes';
				}
				if($row['cantidad'] > $row['cantidad_maxima'])
				{
					$return["resultado"] = FALSE;
					$return["mensaje"] = 'Tiene que seleccionar menos ingredientes';
				}
			}

			$return["precio"] = number_format($return["precio"],2);
		}

		echo json_encode($return);
	}

	public function agregar_producto_ajax()
	{
		//$_POST['id'] = 1;
		if ( $this->form_validation->run('agregar_producto_ajax') == FALSE):

			$return['error'] = TRUE;
			$return['data'] = validation_errors();

		else:

			$result = $this->pedido_model->set_producto($this->input->post('id'));
			if($result)
			{
				$return['error'] = FALSE;
				$return['data'] = "El producto fue agregado.";
				$return['cantidad'] = $this->pedido_model->get_cantidad_items_pedido($this->session->userdata('id_pedido'));
				$this->session->set_userdata('pedido_activo', 1);
			}
			else
			{
				$return['error'] = TRUE;
				$return['data'] = "Ocurrio un error al cargar el producto al pedido.";
			}

			if(count($this->pedido_model->get_pedido_productos($this->session->userdata('id_pedido'))) > 0)
				$this->session->set_userdata('pedido_activo', 1);

		endif;

		echo json_encode($return);
	}

	public function confirmar_pedido()
	{

		$_POST['id_usuario'] = $this->session->userdata('id_usuario');
   		$this->form_validation->set_data($_POST);

		if ( $this->form_validation->run('confirmar_pedido') == FALSE):

			redirect('usuario/ingresar'); 

		else:

			$data['error'] = FALSE;
			$data['success'] = FALSE;

			$data['datos_usuario'] = $this->Usuario_model->traer_datos_usuario($this->session->userdata('id_usuario'));
			$data['direcciones'] = $this->Usuario_model->traer_direcciones($this->session->userdata('id_usuario'));
	 		
			$data['pedido'] = $this->pedido_model->get_pedido( $this->session->userdata('id_pedido') );
			$data['items'] = $this->pedido_model->get_pedido_productos( $this->session->userdata('id_pedido') );
			$data['cantidad'] = $this->pedido_model->get_cantidad_items_pedido( $this->session->userdata('id_pedido') );
			$data['total'] = $this->pedido_model->get_total_pedido( $this->session->userdata('id_pedido') );
			
			$data['horarios'] = $this->pedido_model->get_horarios_disponibles();
			$data['formas_pago'] = $this->pedido_model->get_forma_pago(); 

			$this->load->view(self::$solapa.'/confirmar_pedido', $data);


		endif;	
	}

	public function modificar_cantidad_ajax()
	{

		if ( $this->form_validation->run('modificar_cantidad_ajax') == FALSE):

			$return['error'] = TRUE;
			$return['data'] = "Debe seleccionar un producto.";

		else:

			$result = $this->pedido_model->modificar_producto_cantidad( $this->input->post('id_producto'), $this->input->post('qty') );
			if($result)
			{
				$return['error'] = FALSE;
				$return['data'] = "La cantidad fue modificada.";
				$return['total'] = $this->pedido_model->get_total_pedido( $this->session->userdata('id_pedido') );
				$return['cantidad'] = $this->pedido_model->get_cantidad_items_pedido($this->session->userdata('id_pedido'));

				if(count($this->pedido_model->get_pedido_productos($this->session->userdata('id_pedido'))) > 0)
					$this->session->set_userdata('pedido_activo', 1);
				else
					$this->session->unset_userdata('pedido_activo');
			}
			else
			{
				$return['error'] = TRUE;
				$return['data'] = "Ocurrio un error al modificar la cantidad.";
			}

		endif;

		echo json_encode($return); 
	}

	public function eliminar_producto_ajax()
	{
		if ( $this->form_validation->run('eliminar_producto_ajax') == FALSE):

			$return['error'] = TRUE;
			$return['data'] = "Debe seleccionar un producto.";

		else:

			$result = $this->pedido_model->eliminar_producto( $this->input->post('id_producto') );
			if($result)
			{
				$return['error'] = FALSE;
				$return['data'] = "La cantidad fue modificada.";
				$return['total'] = $this->pedido_model->get_total_pedido( $this->session->userdata('id_pedido') );
				$return['cantidad'] = $this->pedido_model->get_cantidad_items_pedido($this->session->userdata('id_pedido'));

				if(count($this->pedido_model->get_pedido_productos($this->session->userdata('id_pedido'))) == 0)
					$this->session->unset_userdata('pedido_activo');

			}
			else
			{
				$return['error'] = TRUE;
				$return['data'] = "Ocurrio un error al modificar la cantidad.";
			}

		endif;	

		echo json_encode($return);
	}

	public function finalizar_pedido_ajax()
	{
		chrome_log("pedido/finalizar_pedido_ajax");
 		
 		$return["resultado"] = TRUE;
 		 
 		$this->session->set_userdata('id_pedido',12);

 		$_POST['id_pedido'] = $this->session->userdata('id_pedido');
 		$_POST['mail'] = "fabianmayoral@hotmail.com";
 		$_POST['nombre'] = "fabian";
 		$_POST['apellido'] = "mayoral";
 		$_POST['calle'] = "cerrito";
 		$_POST['altura'] = 620;
 		$_POST['pago'] = FORMA_PAGO_ONLINE;
 		$_POST['entrega'] = FORMA_ENTREGA_TAKEAWAY;
 		$_POST['horario'] = "12:00:00";

 			$this->form_validation->set_data($_POST);
	 
		if ($this->form_validation->run('finalizar_pedido') == FALSE):

			chrome_log("No paso validacion");
			$return["resultado"] = FALSE;
			$return["mensaje"] = validation_errors(); 
			echo validation_errors();
			
		else: 
			chrome_log("Paso validacion");

			if( $this->input->post('entrega') == FORMA_ENTREGA_DELIVERY )
    		{	
    			chrome_log("Delivery");

    			if($this->input->post('calle') == "")
    			{
    				chrome_log("Calle o altura vacios");
    				$return["resultado"] = FALSE;
					$return["mensaje"] = "Debe completar la dirección";
    			}
    		}

    		if($return["resultado"] == TRUE)
    		{	
    			chrome_log("Entro");

				$result = $this->pedido_model->finalizar_pedido( $this->session->userdata('id_pedido'), $this->session->userdata('id_usuario'), $this->input->post() );

	        	if($result)
	        	{	
	        		chrome_log("True finalizar_pedido");

	        		$usuario = $this->Usuario_model->traer_datos_usuario( $this->session->userdata('id_usuario') );

	        		$mensaje =  '<h2>NUEVO PEDIDO</h2><hr><br>';
	        		$mensaje .= 'Has recibido un nuevo pedido en lemonclub.com.<br>';
	        		$mensaje .= 'Email: '.$usuario->email.'<br>';
	        		
	        		if($usuario->nombre)
	        			$mensaje .= 'Nombre: '.$usuario->nombre.'<br>';

	        		if($usuario->apellido)
	        			$mensaje .= 'Apellido: '.$usuario->apellido.'<br>';
	 
	        		$descripcion_forma_pago =  $this->pedido_model->traer_descripcion_forma_pago($this->input->post('pago'));
	        		$descripcion_forma_entrega =  $this->pedido_model->traer_descripcion_forma_entrega($this->input->post('entrega'));	 

	        		if( $this->input->post('entrega') == FORMA_ENTREGA_DELIVERY )
	        		{	
	        			chrome_log("FORMA_ENTREGA_DELIVERY");
	  					$mensaje .= 'Forma entrega:  DELIVERY <br>';

	        			if($this->input->post('calle'))
	        				$mensaje .= 'Calle: '.$this->input->post('calle').'<br>';

		        		if($this->input->post('altura'))
		        			$mensaje .= 'Altura: '.$this->input->post('altura').'<br>';
	        		}
	        		else
	        		{
	        			chrome_log("TAKE AWAY");
	        			$mensaje .= 'Forma entrega:  TAKE AWAY <br>';
	        		}


	        		$mensaje .= 'Forma de pago:  '.$descripcion_forma_pago.' <br>';
	        		
	       
	        		$pedido = $this->pedido_model->get_pedido_productos( $this->session->userdata('id_pedido') );

	        		$mensaje .= '<h3>Productos</h3> ';

	        		foreach ($pedido as $key => $value) 
	        		{	
	        			chrome_log("pedido");
	        			$mensaje .= '-----------------------------------------------------<br>';
	        			$mensaje .= 'Nombre: '.$value['nombre'].'<br>';
	        			$mensaje .= 'Descripcion: '.$value['descripcion'].'<br>';
	        			$mensaje .= 'Cantidad: '.$value['cantidad'].'<br>';
	        			$mensaje .= 'Precio: $'.$value['precio'].'<br>';
	        		}

	        		$mensaje .= '-----------------------------------------------------<br>';
	        		$mensaje .= '<b>TOTAL:</b> $'.$this->pedido_model->get_total_pedido( $this->session->userdata('id_pedido') ).'<br>';

	        		$asunto = "Lemonclub: Nuevo pedido";

	        		//enviar_email("info@lemonclub.com.ar", $mensaje, $asunto );

	        		//////////////////
	        		// MERCADO PAGO //
	        		//////////////////
	        		if( $this->input->post('pago') == FORMA_PAGO_ONLINE )
	        		{	
	        			chrome_log("FORMA_PAGO_ONLINE");
	  					//$CI = &get_instance();
					    $this->config->load("mercadopago", TRUE);


					    $config = $this->config->item('mercadopago');
					    $this->load->library('Mercadopago', $config);
					    //$this->mercadopago->sandbox_mode(TRUE);

					    $items = array();
					    foreach ($pedido as $key => $value) 
					    {
					    	chrome_log("FORMA_PAGO_ONLINE pedido ");
					    	$aux = array();
					    	$aux['title'] = $value['nombre'];
					    	$aux['quantity'] = intval($value['cantidad']);
					    	$aux['currency_id'] = "ARS";
					    	$aux['unit_price'] = floatval($value['precio']);
					    	$items[] = $aux;
					    }
					    //https://api.mercadolibre.com/sites/MLA/payment_methods
					    //https://api.mercadolibre.com/payment_types
					    $pedido_data = array (
						    "items" => $items,
						    "payment_methods" => array(
								"excluded_payment_methods" => array( array( "id"=>"pagofacil"), array("id"=>"rapipago")	)		
							),
						    "payer" => array(
								"name" => $usuario->nombre,
					            "surname" => $usuario->apellido,
					            "email" => $usuario->email
							),
							"back_urls" => array(
								"success" => site_url('pedido/success'),
					            "failure" => site_url('pedido/failure'),
					            "pending" => site_url('pedido/pending')
							),
							"notification_url" => site_url('pedido/nuevo_pago')
						);

						$preference = $this->mercadopago->create_preference($pedido_data);
 
						//$return["link"] = $preference['response']['init_point']; //PRODUCCION
						$return["link"] = $preference['response']['sandbox_init_point']; //SANDBOX
 
	        		}
	        		else
	        		{
	        			$return["link"] = site_url('pedido/success_efectivo');
	        		}
	        		//////////////////////
	        		// FIN MERCADO PAGO //
	        		//////////////////////

	        		$this->session->unset_userdata('id_pedido');
	        		$this->session->unset_userdata('pedido_activo');

		          	$return["resultado"] = TRUE;
	        		$return['mensaje'] = "Su pedido ha sido enviado.";
	        	}
	        	else
	        	{
	        		chrome_log("False ");
	        		$return["resultado"] = FALSE;
	        		$return['mensaje'] = "Ocurrio un error al cargar el pedido.";
	        	}
			}
		endif;

		print json_encode($return);
	}

	public function success_efectivo()
	{
		$data['datos_usuario'] = $this->Usuario_model->traer_datos_usuario($this->session->userdata('id_usuario'));
		if($data['datos_usuario']->tipo_usuario == "Usuario Invitado")
		{
			session_destroy();
		}

		$this->load->view(self::$solapa.'/success');
	}

	public function success()
	{
		if(isset($_GET["id"]))
		{
			if($this->session->userdata('id_usuario') != "")
			{
				$data['datos_usuario'] = $this->Usuario_model->traer_datos_usuario($this->session->userdata('id_usuario'));
				$this->pago_model->set_item($this->session->userdata('id_pedido'), PAGO_ONLINE_ESTADO_ACEPTADO, $_GET["id"]);

				if($data['datos_usuario']->tipo_usuario == "Usuario Invitado")
				{
					session_destroy();
				}

				$this->load->view(self::$solapa.'/success');
			}
			else
			{
				redirect('home');
			}
		}
		else
		{
			$this->load->view(self::$solapa.'/failure');
		}
	}

	public function failure()
	{
		if($this->session->userdata('id_usuario') != "")
		{
			$data['datos_usuario'] = $this->Usuario_model->traer_datos_usuario($this->session->userdata('id_usuario'));
			$this->pago_model->set_item($this->session->userdata('id_pedido'), PAGO_ONLINE_ESTADO_RECHAZADO);

			if($data['datos_usuario']->tipo_usuario == "Usuario Invitado")
			{
				session_destroy();
			}

			$this->load->view(self::$solapa.'/failure');
		}
		else
		{
			redirect('home');
		}
	}

	public function pending()
	{
		$this->load->view(self::$solapa.'/pending');
	}

	public function procesa_cambiar_estado_pedido()
	{
		chrome_log("Pedido/procesa_cambiar_estado_pedido");

	 	if ($this->form_validation->run('procesa_cambiar_estado_pedido') == FALSE): 

			chrome_log("No Paso validacion");
			$this->session->set_flashdata('mensaje', 'Error en la validacion');
			echo validation_errors(); 

		else:
			chrome_log("Si Paso validacion");
	 		 
	 	 	$resultado = $this->pedido_model->procesa_cambiar_estado_pedido( $this->input->post() );

	 	 	if ( $resultado ):  
			 
				chrome_log("Pudo validar ");

				$this->session->set_flashdata('mensaje', 'Estado modificado exitosamente.');
				
			 				 
			else:  
			 	
			 	$this->session->set_flashdata('mensaje', 'Error al cambia el estado, intente mas tarde.');

			endif;  

		endif; 	

		$this->load->library('user_agent');
		$url = $this->agent->referrer();
		
		redirect($url);
	}

	/*
 
	// SE USA ?
	public function finalizar_pedido()
	{
		chrome_log("usuario/finalizar_pedido");

		$data['error'] = FALSE;
		$data['success'] = FALSE;

		$_POST['id_pedido'] = $this->session->userdata('id_pedido');
 
		if ($this->form_validation->run('finalizar_pedido') == FALSE):

			chrome_log("No paso validacion");
			$data['error'] = "Ocurrio un error al cargar el pedido.";
			
		else: 
		 
			chrome_log("Paso validacion");

			$result = $this->pedido_model->finalizar_pedido( $this->session->userdata('id_pedido'), $this->session->userdata('id_usuario'), $this->input->post() );
        	if($result)
        	{	
        		$usuario = $this->Usuario_model->traer_datos_usuario( $this->session->userdata('id_usuario') );

        		$mensaje =  '<h2>NUEVO PEDIDO</h2><hr><br>';
        		$mensaje .= 'Has recibido un nuevo pedido en lemonclub.com.<br>';
        		$mensaje .= 'Email: '.$usuario->email.'<br>';
        		
        		if($usuario->nombre)
        			$mensaje .= 'Nombre: '.$usuario->nombre.'<br>';

        		if($usuario->apellido)
        			$mensaje .= 'Apellido: '.$usuario->apellido.'<br>';
 
        		$descripcion_forma_pago =  $this->pedido_model->traer_descripcion_forma_pago($this->input->post('pago'));
        		$descripcion_forma_entrega =  $this->pedido_model->traer_descripcion_forma_entrega($this->input->post('entrega'));	 

        		if( $this->input->post('entrega') == FORMA_ENTREGA_DELIVERY )
        		{
  					$mensaje .= 'Forma entrega:  DELIVERY <br>';

        			if($this->input->post('calle'))
        				$mensaje .= 'Calle: '.$this->input->post('calle').'<br>';

	        		if($this->input->post('altura'))
	        			$mensaje .= 'Altura: '.$this->input->post('altura').'<br>';

        		}
        		else
        		{
        			$mensaje .= 'Forma entrega:  TAKE AWAY <br>';
        		}

       
        		$pedido = $this->pedido_model->get_pedido_productos( $this->session->userdata('id_pedido') );

        		$mensaje .= '<h3>Productos</h3> ';

        		foreach ($pedido as $key => $value) 
        		{
        			$mensaje .= '-----------------------------------------------------<br>';
        			$mensaje .= 'Nombre: '.$value['nombre'].'<br>';
        			$mensaje .= 'Descripcion: '.$value['descripcion'].'<br>';
        			$mensaje .= 'Cantidad: '.$value['cantidad'].'<br>';
        			$mensaje .= 'Precio: $'.$value['precio'].'<br>';
        		}

        		$mensaje .= '-----------------------------------------------------<br>';
        		$mensaje .= '<b>TOTAL:</b> $'.$this->pedido_model->get_total_pedido( $this->session->userdata('id_pedido') ).'<br>';

        		$asunto = "Lemonclub: Nuevo pedido";

        		enviar_email("info@lemonclub.com.ar", $mensaje, $asunto );

        		$this->session->unset_userdata('id_pedido');
        		$this->session->unset_userdata('pedido_activo');

	          	redirect(self::$solapa.'/success');
        	}
        	else
        	{
        		$data['error'] = "Ocurrio un error al cargar el pedido.";
        	}
		 
		endif; 
	}
 
	*/
 

}