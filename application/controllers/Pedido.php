<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pedido extends CI_Controller {

	private static $solapa = "pedido";

	public function __construct()
	{
		parent::__construct();

		date_default_timezone_set ( "America/Argentina/Buenos_Aires" );

		$this->load->model('pedido_model');
		$this->load->model('producto_model');
		$this->load->model('Usuario_model');

		if($this->session->userdata('id_pedido') == "")
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

	public function confirmar_pedido()
	{
		$data['error'] = FALSE;
		$data['success'] = FALSE;

		if($this->session->userdata('id_usuario') == "")
		{
			redirect('usuario/ingresar');
		}

		$data['datos_usuario'] = $this->Usuario_model->traer_datos_usuario($this->session->userdata('id_usuario'));
		$data['direcciones'] = $this->Usuario_model->traer_direcciones($this->session->userdata('id_usuario'));
 		
		$data['pedido'] = $this->pedido_model->get_pedido( $this->session->userdata('id_pedido') );
		$data['items'] = $this->pedido_model->get_pedido_productos( $this->session->userdata('id_pedido') );
		$data['cantidad'] = $this->pedido_model->get_cantidad_items_pedido( $this->session->userdata('id_pedido') );
		$data['total'] = $this->pedido_model->get_total_pedido( $this->session->userdata('id_pedido') );

		$data['horarios'] = $this->pedido_model->get_horarios_disponibles();
		$data['formas_pago'] = $this->pedido_model->get_forma_pago();

		$this->load->view(self::$solapa.'/confirmar_pedido', $data);
	}

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

	public function finalizar_pedido_ajax()
	{
		chrome_log("usuario/finalizar_pedido");
 		
 		$return["resultado"] = TRUE;
 		/*
 		//$this->session->set_userdata('id_pedido',12);
 		$_POST['id_pedido'] = $this->session->userdata('id_pedido');
 		$_POST['mail'] = "fabianmayoral@hotmail.com";
 		$_POST['nombre'] = "fabian";
 		$_POST['apellido'] = "mayoral";
 		$_POST['calle'] = "cerrito";
 		$_POST['altura'] = 620;
 		$_POST['pago'] = FORMA_PAGO_ONLINE;
 		$_POST['entrega'] = FORMA_ENTREGA_TAKEAWAY;
 		$_POST['horario'] = "12:00:00";
		*/
		if ($this->form_validation->run('finalizar_pedido') == FALSE):

			chrome_log("No paso validacion");
			$return["resultado"] = FALSE;
			$return["mensaje"] = validation_errors(); 
			
		else: 
		
			if( $this->input->post('entrega') == FORMA_ENTREGA_DELIVERY )
    		{
    			if($this->input->post('calle') == "" || $this->input->post('altura') == "")
    			{
    				$return["resultado"] = FALSE;
					$return["mensaje"] = "Debe completar la calle y la altura";
    			}
    		}

    		if($return["resultado"] == TRUE)
    		{
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


	        		$mensaje .= 'Forma de pago:  '.$descripcion_forma_pago.' <br>';
	        		
	       
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

	        		//enviar_email("info@lemonclub.com.ar", $mensaje, $asunto );

	        		//////////////////
	        		// MERCADO PAGO //
	        		//////////////////
	        		if( $this->input->post('pago') == FORMA_PAGO_ONLINE )
	        		{
	  					//$CI = &get_instance();
					    $this->config->load("mercadopago", TRUE);
					    $config = $this->config->item('mercadopago');
					    $this->load->library('Mercadopago', $config);
					    //$this->mercadopago->sandbox_mode(TRUE);

					    $items = array();
					    foreach ($pedido as $key => $value) 
					    {
					    	$aux = array();
					    	$aux['title'] = $value['nombre'];
					    	$aux['quantity'] = intval($value['cantidad']);
					    	$aux['currency_id'] = "ARS";
					    	$aux['unit_price'] = floatval($value['precio']);
					    	$items[] = $aux;
					    }
					    $pedido_data = array (
						    "items" => $items,
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
	        			$return["link"] = site_url('pedido/success');
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
	        		$return["resultado"] = FALSE;
	        		$return['mensaje'] = "Ocurrio un error al cargar el pedido.";
	        	}
			}
		endif;

		print json_encode($return);
	}

	public function success()
	{
		$this->load->view(self::$solapa.'/success');
	}

	public function failure()
	{
		$this->load->view(self::$solapa.'/failure');
	}

	public function pending()
	{
		$this->load->view(self::$solapa.'/pending');
	}

	public function agregar_producto_ajax()
	{
		$return['error'] = FALSE;

		if($this->input->post('id') != "")
		{
 
			$result = $this->pedido_model->set_producto($this->input->post('id'));
			if($result)
			{
				$return['error'] = FALSE;
				$return['data'] = "El producto fue agregado al carrito.";
				$this->session->set_userdata('pedido_activo', 1);

			}
			else
			{
				$return['error'] = TRUE;
				$return['data'] = "Ocurrio un error al cargar el producto al pedido.";
			}

			if(count($this->pedido_model->get_pedido_productos($this->session->userdata('id_pedido'))) > 0)
				$this->session->set_userdata('pedido_activo', 1);
		}
		else
		{
			$return['error'] = TRUE;
			$return['data'] = "Debe seleccionar un producto.";
		}

		echo json_encode($return);
	}

	public function modificar_cantidad_ajax()
	{
		$return['error'] = FALSE;

		if($this->input->post('id_producto') != "")
		{
 
			$result = $this->pedido_model->modificar_producto_cantidad( $this->session->userdata('id_pedido'), $this->input->post('id_producto'), $this->input->post('qty') );
			if($result)
			{
				$return['error'] = FALSE;
				$return['data'] = "La cantidad fue modificada.";
				$return['total'] = $this->pedido_model->get_total_pedido( $this->session->userdata('id_pedido') );

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
		}
		else
		{
			$return['error'] = TRUE;
			$return['data'] = "Debe seleccionar un producto.";
		}

		echo json_encode($return);
	}

	public function eliminar_producto_ajax()
	{
		$return['error'] = FALSE;

		if($this->input->post('id_producto') != "")
		{
			$result = $this->pedido_model->eliminar_producto( $this->session->userdata('id_pedido'), $this->input->post('id_producto') );
			if($result)
			{
				$return['error'] = FALSE;
				$return['data'] = "La cantidad fue modificada.";
				$return['total'] = $this->pedido_model->get_total_pedido( $this->session->userdata('id_pedido') );

				if(count($this->pedido_model->get_pedido_productos($this->session->userdata('id_pedido'))) == 0)
					$this->session->unset_userdata('pedido_activo');

			}
			else
			{
				$return['error'] = TRUE;
				$return['data'] = "Ocurrio un error al modificar la cantidad.";
			}
		}
		else
		{
			$return['error'] = TRUE;
			$return['data'] = "Debe seleccionar un producto.";
		}

		echo json_encode($return);
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



 

}