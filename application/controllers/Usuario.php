<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Controller {

private static $solapa = "usuario";

public function __construct()
{
	parent::__construct();
	$this->load->model('Usuario_model');
	$this->load->model('pedido_model');
}

public function loguearse()
{
	$data['error'] = FALSE;
	$data['success'] = FALSE;
	$this->load->view(self::$solapa.'/loguearse', $data);
}


public function logout()
{
	$this->session->unset_userdata('usuario_lemon');
	$this->db->close();
	session_destroy();
	redirect('home/index/','refresh');
}

public function loguearse_solo()
{
	chrome_log("Usuario/procesa_logueo");
  
	if ($this->form_validation->run('loguearse_usuario') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'No paso validacion para loguearse.');

	else: 
	 
		chrome_log("Paso validacion");

		$id_usuario = $this->Usuario_model->loguearse( $this->input->post() );

		if ( $id_usuario ):  
		 	
		 	chrome_log("Pudo loguearse ");
		 	$return["resultado"] = TRUE;
			$return["mensaje"] = 'Logueo exitoso';
			$this->session->set_userdata('id_usuario', $id_usuario);
			
		 				 
		else:  

		 	chrome_log("No Pudo loguearse ");
		 	$this->session->set_flashdata('mensaje', 'Usuario o password incorrectos.');
		 	$return["resultado"] = FALSE;
 			$return["mensaje"] ='Usuario o password incorrecto.';

		endif; 

 
	endif;	

	print json_encode($return);	
}

/*

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
 

 



public function procesa_logueo()
{
	chrome_log("Usuario/procesa_logueo");
 
	if ($this->form_validation->run('loguearse_usuario') == FALSE):

		chrome_log("No paso validacion");
		$return["resultado"] = FALSE;
		$return["mensaje"] =  validation_errors();

	else: 
	 
		chrome_log("Paso validacion");

		$id_usuario = $this->Usuario_model->loguearse( $this->input->post() );

		if ( $id_usuario ):  
		 	
		 	chrome_log("Pudo loguearse ");
			$this->session->set_userdata('id_usuario', $id_usuario);

			$aux = array(
				'id_usuario' => $id_usuario
			);
			$id_pedido = $this->pedido_model->set_pedido( $aux );
			$this->session->set_userdata('id_pedido', $id_pedido);

			$this->pedido_model->mover_productos_carrito();

			$return["resultado"] = TRUE;
			$return["mensaje"] = 'Logueo exitoso';
		 				 
		else:  
		 	chrome_log("No Pudo loguearse ");

			$return["resultado"] = FALSE;
 			$return["mensaje"] ='Usuario o password incorrecto.';

		endif; 

 
	endif;	

	print json_encode($return);	
}

public function procesa_usuario_invitado()
{
	chrome_log("Usuario/procesa_usuario_invitado");
 
 

	$this->form_validation->set_data($_POST);
 
	if ($this->form_validation->run('usuario_invitado') == FALSE):

		chrome_log("No paso validacion");
		$return["resultado"] = FALSE;
		$return["mensaje"] = validation_errors(); 

	else: 
 
		chrome_log("Paso validacion");
		date_default_timezone_set('America/New_York'); 	 	
	 	$token = sha1($this->input->post('email').rand(1,9999999).time());

		$id_usuario = $this->Usuario_model->usuario_invitado( $this->input->post('email') );
		$this->session->set_userdata('id_usuario', $id_usuario);

		$aux = array(
			'id_usuario' => $id_usuario
		);
		$id_pedido = $this->pedido_model->set_pedido( $aux );
		$this->session->set_userdata('id_pedido', $id_pedido);

		$this->pedido_model->mover_productos_carrito();

		$this->Usuario_model->token_pedido_invitado( $id_usuario, $token, $id_pedido );

		if ( $id_usuario && $id_pedido ):   // Si se creo el token, se envia el email
		 
			chrome_log("Pudo procesar usuario invitado");

 
			$id_usuario_sha1 =  sha1($id_usuario);

			$return["resultado"] = TRUE;
			$return["mensaje"] = 'Se le ha enviado un email, por favor ingresá a tu email y continua el pedido. La próxima vez podes registrarte y hacer tu pedido aún mas fácil.';
 
			$enlace = base_url().'index.php/usuario/procesa_validar_usuario_invitado/'.$id_usuario_sha1.'/'.$token;
 

			$mensaje =  '<h2>TERMINÁ TU PEDIDO!</h2><hr><br>';
			$mensaje .= 'Has recibido este e-mail por que se efectuó una solicitud de usuario invitado en lemonclub.com.<br>';
			$mensaje .= 'En caso de querer continuar con el proceso de compra, haga click en el siguiente link <a href="'.$enlace.'"> Validar Email </a>.<br>';
			$mensaje .= '<br>';
			$mensaje .= 'Si el link no funciona, podes copiar y pegar el enlace "'.$enlace.'" en tu navegador.<br>';
			$mensaje .= '<br>';

			$pedido = $this->pedido_model->get_pedido( $this->session->userdata('id_pedido') );
			$items = $this->pedido_model->get_pedido_productos( $this->session->userdata('id_pedido') );
			//$cantidad = $this->pedido_model->get_cantidad_items_pedido( $this->session->userdata('id_pedido') );
			$total = $this->pedido_model->get_total_pedido( $this->session->userdata('id_pedido') );

			$mensaje .= '<hr>';
			$mensaje .= 'DETALLE DEL PEDIDO<br>';
			$mensaje .= '<table class="table">
					<tr>
						<th colspan="2">PRODUCTO</th>
						<th>PRECIO</th>
						<th>CANT.</th>
					</tr>';
					
					foreach ($items as $key => $item)
					{
						$mensaje .= '<tr class="item">
								<td><img src="'.base_url('assets/images/productos/'.$item['path_imagen']).'" width="100"></td>
								<td>
									<span class="title">'.$item['nombre'].'</span><br>
									<span class="descripcion">'.$item['descripcion'].'</span>
								</td>
								<td class="precio">$'.$this->cart->format_number($item['precio']).'</td>
								<td class="cantidad">'.$item['cantidad'].'</dt>
							</tr>';
					}
					
			$mensaje .= '<tr class="total">
						<td colspan="4"><b>Total: $ '.$total.'</b></td>
					</tr>
				</table>';
			$mensaje .= '<hr>';

			$mensaje .= '<br>';
			$mensaje .= 'Recordá que podes registarte, asi haces tu pedido mas fácil.';
			$mensaje .= '<h4>Gracias por elegirnos! </h4> ';
			$mensaje .= 'Si usted no realizo el pedido, puede ignorar este mensaje.<br>';
			$mensaje  = html_entity_decode( $mensaje , ENT_QUOTES, "UTF-8");

			$asunto = "LemonClub - Usuario invitado";
 			
			if( enviar_email( $this->input->post('email') , $mensaje, $asunto )):

				chrome_log("Envio email");
				$return["resultado"] = TRUE;
				$return["mensaje"] = 'Se le ha enviado un email, por favor ingresá a tu email y continua el pedido. La próxima vez podes registrarte y hacer tu pedido aún mas fácil.';

			else:

				chrome_log("NO Envio email");
				$return["resultado"] = FALSE;
				$return["mensaje"] ='Ha ocurrido un error, por favor, intentá mas tarde.'; 

			endif; 
			 
		else: 
			chrome_log("No Pudo procesar usuario invitado");
			$return["resultado"] = FALSE;
 			$return["mensaje"] ='Ha ocurrido un error, por favor, intentá mas tarde.';

		endif; 
 	 
 
	endif; 

	print json_encode($return);	
}

// Valida la URL en enviamos en procesa_usuario_invitado()
public function procesa_validar_usuario_invitado($id_usuario, $token) 
{
	chrome_log("Usuario/procesa_validar_usuario_invitado");

	$this->form_validation->set_data(array(
        'id_usuario'    =>  $id_usuario,
        'token'    =>  $token
	));
 
	if ($this->form_validation->run('validar_usuario_invitado') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'El link al que accediste es incorrecto o ya ha sido utilizado.');
 
	else: 
	 
		chrome_log("Paso validacion");

		$resultado = $this->Usuario_model->procesa_validar_usuario_invitado( $id_usuario, $token);

		if ( $resultado ):   
		 
			chrome_log("Pudo validar el usuario invitado");
			
			redirect(base_url()."index.php/pedido/confirmar_pedido");
		 				 
		else: 

			chrome_log("No pudo validar el usuario invitado");
 			$this->session->set_flashdata('mensaje', 'El link al que accediste es incorrecto o ya ha sido utilizado.');

		endif; 
 
 
	endif;	

	$this->load->view('errors/html/mensaje');
}

public function procesa_registrarse() 
{
	$this->form_validation->set_message('comprobar_email_existente_validation', 'El email ya existe, elija otro email o denuncie su propiedad');
 
	if ($this->form_validation->run('registrarse') == FALSE): 

		chrome_log("No Paso validacion");
		$return["resultado"] = FALSE;
		$return["mensaje"] = validation_errors();
 
		 
	else:
		chrome_log("Si Paso validacion");
 		
 		$token = sha1($this->input->post('email').rand(1,9999999).time());
		$id_usuario = $this->Usuario_model->registrar_usuario( $this->input->post() );

		$this->session->set_userdata('id_usuario', $id_usuario);

		$aux = array(
			'id_usuario' => $id_usuario
		);
		$id_pedido = $this->pedido_model->set_pedido( $aux );
		$this->session->set_userdata('id_pedido', $id_pedido);

		$this->pedido_model->mover_productos_carrito();
		 
		if ( $id_usuario ):  

			chrome_log("Enviar email");
		 	
		 	$id_usuario_sha1 =  sha1($id_usuario);
			$enlace = base_url().'index.php/usuario/procesa_validar_registro/'.$id_usuario_sha1.'/'.$token;

			$mensaje =  '<h2>TERMINÁ TU PEDIDO!</h2><hr><br>';
			$mensaje .= 'Has recibido este e-mail por que se efectuó una solicitud para registrarte a lemonclub.com.<br>';
			$mensaje .= 'En caso de querer continuar con el proceso de compra, haga click en el siguiente link  <a href="'.$enlace.'"> Validar Email </a>.<br>';
			$mensaje .= '<h4>Gracias por elegirnos! </h4> ';
			$mensaje .= 'Si usted no realizo el pedido, puede ignorar este mensaje.<br>';
			$mensaje  = html_entity_decode( $mensaje , ENT_QUOTES, "UTF-8");

			$asunto = "LemonClub - Registro de usuario";

			if( enviar_email( $this->input->post('email'), $mensaje, $asunto) ):

				chrome_log("TRUE");
				$return["resultado"] = TRUE;
				$return["mensaje"] = "Gracias por registrarte ! Te hemos enviado un email para confirmar tu registro y finalizar tu pedido.";

			else:

				chrome_log("FALSE");
				$return["resultado"] = FALSE;
				$return["mensaje"] = "Ha ocurrido un error al enviarte el email de registro, por favor, intenta mas tarde";

			endif;
		 				 
		else: 
		 	
		 	chrome_log("No envio email");
			$return["resultado"] = FALSE;
			$return["mensaje"] = "Ha ocurrido un error al registrarte, por favor, intenta mas tarde";

		endif;  

	endif; 	

	///redirect("Login/index");
	print json_encode($return);
}

public function procesa_validar_registro($id_usuario, $token) // Valida la URL en enviamos en procesa_usuario_invitado()
{
	chrome_log("Usuario/procesa_validar_usuario_invitado");

	$this->form_validation->set_data(array(
        'id_usuario'    =>  $id_usuario,
        'token'    =>  $token,
	));

 	if ($this->form_validation->run('procesa_validar_registro') == FALSE): 

		chrome_log("No Paso validacion");
		 
	else:
		chrome_log("Si Paso validacion");
 		
 	 	$resultado = $this->Usuario_model->procesa_validar_registro( $id_usuario, $token );

 	 	if ( $resultado ):  
		 
			chrome_log("Pudo validar ");

			$this->session->set_flashdata('mensaje', 'Se ha registrado su usuario exitosamente. Por favor, finalice su pedido.');
			redirect(base_url()."index.php/pedido/confirmar_pedido");
		 				 
		else:  
		 	
		 	chrome_log("No Pudo validar"); 

		endif; 

	endif; 	

	show_404();
}



public function comprobar_email_existente_validation($email=null)  
{
	if( $this->Usuario_model->existe_email_registrado($email) )
		return false; 
	else 
		return true; // Duplicado 	
}
*/


}