<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pedido extends CI_Controller {

	private static $solapa = "pedido";

	public function __construct()
	{
		parent::__construct();

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
		$data['total'] = $this->pedido_model->get_total_pedido( $this->session->userdata('id_pedido') );

		$this->load->view(self::$solapa.'/index', $data);
	}

	public function confirmar_pedido()
	{
		$data['error'] = FALSE;
		$data['success'] = FALSE;

		if($this->session->userdata('id_usuario') == "")
			redirect('pedido/ingresar');

		$data['datos_usuario'] = $this->Usuario_model->traer_datos_usuario($this->session->userdata('id_usuario'));
 		
		$data['pedido'] = $this->pedido_model->get_pedido( $this->session->userdata('id_pedido') );
		$data['items'] = $this->pedido_model->get_pedido_productos( $this->session->userdata('id_pedido') );
		$data['total'] = $this->pedido_model->get_total_pedido( $this->session->userdata('id_pedido') );

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

        		enviar_email("adrian.magliola@gmail.com", $mensaje, $asunto );

        		$this->session->unset_userdata('id_pedido');

	          	redirect(self::$solapa.'/success');
        	}
        	else
        	{
        		$data['error'] = "Ocurrio un error al cargar el pedido.";
        	}
		 
		endif; 


	}


	/*
	public function confirmar_pedido()
	{
		$data['error'] = FALSE;
		$data['success'] = FALSE;

		if($this->session->userdata('id_usuario') == "")
		{
			redirect('pedido/ingresar');
		}

		$data['pedido'] = $this->pedido_model->get_pedido( $this->session->userdata('id_pedido') );
		$data['items'] = $this->pedido_model->get_pedido_productos( $this->session->userdata('id_pedido') );
		$data['total'] = $this->pedido_model->get_total_pedido( $this->session->userdata('id_pedido') );

		$this->form_validation->set_rules('nombre', 'nombre', 'required');
		$this->form_validation->set_rules('apellido', 'apellido', 'required');
		$this->form_validation->set_rules('mail', 'Email', 'required');
		$this->form_validation->set_rules('entrega', 'forma de entrega', 'required');
		$this->form_validation->set_rules('pago', 'forma de pago', 'required');

		if($this->form_validation->run() !== FALSE)
        {
        	$result = $this->pedido_model->finalizar_pedido( $this->session->userdata('id_pedido'), $this->session->userdata('id_usuario'), $this->input->post() );
        	if($result)
        	{
        		$this->session->set_userdata('id_pedido', "");

	            redirect(self::$solapa.'/success');
        	}
        	else
        	{
        		$data['error'] = "Ocurrio un error al cargar el pedido.";
        	}
        }

		
	}

	*/

	public function ingresar()
	{
		$data['error'] = FALSE;
		$data['success'] = FALSE;

		if($this->session->userdata('id_usuario') != "")
		{
			redirect('pedido/confirmar_pedido');
		}

		$data['pedido'] = $this->pedido_model->get_pedido( $this->session->userdata('id_pedido') );
		$data['items'] = $this->pedido_model->get_pedido_productos( $this->session->userdata('id_pedido') );
		$data['total'] = $this->pedido_model->get_total_pedido( $this->session->userdata('id_pedido') );

		
		//$this->form_validation->set_rules('ingresar', 'ingresar', 'required');

    	if($this->input->post('ingresar') == 1)
    	{
    		$this->form_validation->set_rules('email', 'email', 'required');
    		$this->form_validation->set_rules('clave', 'contraseña', 'required');

    		if($this->form_validation->run() !== FALSE)
    		{
    			if($this->Usuario_model->loguearse($this->input->post()))
    			{
    				redirect(self::$solapa.'/confirmar_pedido');
    			}
    			else
    			{
    				$data['error'] = "El email o la contraseña son incorrectos.";
    			}
    		}
    	}
    	elseif($this->input->post('ingresar') == 2)
    	{
    		$this->form_validation->set_rules('email', 'email', 'required');

    		if($this->form_validation->run() !== FALSE)
    		{
    			//Enviar email

    			$data['success'] = "Ingresa al link que te enviamos por email para validar tu cuenta.";
    		}
    	}
    	elseif($this->input->post('ingresar') == 3)
    	{
    		$this->form_validation->set_rules('nombre', 'nombre', 'required');
    		$this->form_validation->set_rules('apellido', 'apellido', 'required');
    		$this->form_validation->set_rules('email', 'email', 'required|valid_email');
    		$this->form_validation->set_rules('clave', 'contraseña', 'required');
    		$this->form_validation->set_rules('clave2', 'repetir contraseña', 'required|matches[clave]');

    		if($this->form_validation->run() !== FALSE)
    		{
    			$result = $this->Usuario_model->registrar_usuario($this->input->post());
	    		if($result)
	    		{
	    			$data['success'] = "El usuario fue registrado con exito.<br>Ingresa al link que te enviamos por email para validar tu cuenta.";
	    		}
	    		else
	    		{
	    			$data['error'] = "Ocurrio un error al regitrar el usuario.";
	    		}
    		}
    	}
        

		$this->load->view(self::$solapa.'/ingresar', $data);
	}

	public function success()
	{
		$this->load->view(self::$solapa.'/success');
	}

	public function agregar_producto_ajax()
	{
		$return['error'] = FALSE;

		//$_POST['id'] = 1;

		if($this->input->post('id') != "")
		{
			/*
			$producto = $this->producto_model->get_items($this->input->post('id'));
			$data = array(
		        'id'      => $producto['id_producto'],
		        'qty'     => 1,
		        'price'   => $producto['precio'],
		        'name'    => $producto['nombre'],
		        'descripcion' => $producto['descripcion']
		        //'options' => array('Size' => 'L', 'Color' => 'Red')
			);

			$this->cart->insert($data);
			*/
			$result = $this->pedido_model->set_producto($this->input->post('id'));
			if($result)
			{
				$return['error'] = FALSE;
				$return['data'] = "El producto fue agregado al carrito.";
			}
			else
			{
				$return['error'] = TRUE;
				$return['data'] = "Ocurrio un error al cargar el producto al pedido.";
			}
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
			/*
			$data = array(
		        'rowid' => $this->input->post('rowid'),
		        'qty'   => $this->input->post('qty')
			);

			$this->cart->update($data);
			*/
			$result = $this->pedido_model->modificar_producto_cantidad( $this->session->userdata('id_pedido'), $this->input->post('id_producto'), $this->input->post('qty') );
			if($result)
			{
				$return['error'] = FALSE;
				$return['data'] = "La cantidad fue modificada.";
				$return['total'] = $this->pedido_model->get_total_pedido( $this->session->userdata('id_pedido') );
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

	public function comprar()
	{
		chrome_log("Pedido/comprar");	 

		if ($this->form_validation->run('comprar') == FALSE):

			chrome_log("No paso validacion");
			$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
			//redirect('Login/index/','refresh');

		else: 
		 
			chrome_log("Paso validacion");

			//$this->pedido_model->abm_pedido('A',$this->input->post());

 			
 			/*
			foreach ($this->cart->contents() as $item)
			{
				 
			}*/


 			
	 
		endif;


	}

}