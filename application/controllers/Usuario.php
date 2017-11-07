<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Controller {

public function __construct()
{
	parent::__construct();
	$this->load->model('Usuario_model');
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

		$resultado = $this->Usuario_model->loguearse( $this->input->post() );

		if ( $resultado ):  
		 	
		 	chrome_log("Pudo loguearse ");
			$id_usuario = $resultado;
			$this->session->set_userdata('id_usuario', $id_usuario);
		
			//redirect(base_url()."index.php/pedido/comprar")

			$return["resultado"] = TRUE;
			$return["mensaje"] = 'Logueo exitoso';

			//redirect(base_url()."index.php/pedido/confirmar_pedido");
		 				 
		else:  
		 
			$return["resultado"] = FALSE;
 			$return["mensaje"] ='Ha ocurrido un error, por favor, intentá mas tarde.';

		endif; 

 
	endif;	

	print json_encode($return);	
}

public function procesa_usuario_invitado()
{
	chrome_log("Usuario/procesa_usuario_invitado");
 
	if ($this->form_validation->run('usuario_invitado') == FALSE):

		chrome_log("No paso validacion");
		$return["resultado"] = FALSE;
		$return["mensaje"] = "Ha ocurrido un error en la validación, por favor, intenta mas tarde";

	else: 
 
		chrome_log("Paso validacion");
		date_default_timezone_set('America/New_York'); 	 	
	 	$token = sha1($this->input->post('email').rand(1,9999999).time());


		$resultado = $this->Usuario_model->usuario_invitado( $this->input->post('email'), $token ); 

		if ( $resultado ):   // Si se creo el token, se envia el email
		 
			chrome_log("Pudo procesar usuario invitado");

			$id_usuario =  sha1($resultado);

			$return["resultado"] = TRUE;
			$return["mensaje"] = 'Se le ha enviado un email, por favor ingresá a tu email y continua el pedido. La próxima vez podes registrarte y hacer tu pedido aún mas fácil.';

 
			$enlace = base_url().'index.php/usuario/procesa_validar_usuario_invitado/'.$id_usuario.'/'.$token;

			$mensaje =  '<h2>TERMINÁ TU PEDIDO!</h2><hr><br>';
			$mensaje .= 'Has recibido este e-mail por que se efectuó una solicitud de usuario invitado en lemonclub.com.<br>';
			$mensaje .= 'En caso de querer continuar con el proceso de compra, haga click en el siguiente link  <a href="'.$enlace.'"> Validar Email </a>.<br>';
			$mensaje .= 'Recordá que podes registarte, asi haces tu pedido mas fácil.';
			$mensaje .= '<h4>Gracias por elegirnos! </h4> ';
			$mensaje .= 'Si usted no realizo el pedido, puede ignorar este mensaje.<br>';
			$mensaje  = html_entity_decode( $mensaje , ENT_QUOTES, "UTF-8");

			$asunto = "LemonClub - Usuario invitado";
 			
			if( enviar_email( $this->input->post('email') , $mensaje, $asunto )):

				$return["resultado"] = TRUE;
				$return["mensaje"] = 'Se le ha enviado un email, por favor ingresá a tu email y continua el pedido. La próxima vez podes registrarte y hacer tu pedido aún mas fácil.';

			else:
				$return["resultado"] = FALSE;
				$return["mensaje"] ='Ha ocurrido un error, por favor, intentá mas tarde.'; 

			endif; 
			 
		else: 

			$return["resultado"] = FALSE;
 			$return["mensaje"] ='Ha ocurrido un error, por favor, intentá mas tarde.';

		endif; 
 	 
 
	endif; 

	print json_encode($return);	
}

public function procesa_validar_usuario_invitado($id_usuario, $token) // Valida la URL en enviamos en procesa_usuario_invitado()
{
	chrome_log("Usuario/procesa_validar_usuario_invitado");

	$this->form_validation->set_data(array(
        'id_usuario'    =>  $id_usuario,
        'token'    =>  $token,
	));
 
	if ($this->form_validation->run('validar_usuario_invitado') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
 
	else: 
	 
		chrome_log("Paso validacion");

		$resultado = $this->Usuario_model->procesa_validar_usuario_invitado( $id_usuario, $token);

		if ( $resultado ):   
		 
			chrome_log("Pudo validar el usuario invitado");
			$this->session->set_userdata('id_usuario', $resultado ); 
			redirect(base_url()."index.php/pedido/confirmar_pedido");
		 				 
		else: 

			chrome_log("No pudo validar el usuario invitado");
 			$this->session->set_flashdata('mensaje', 'Ha ocurrido un error, por favor, intentá mas tarde.');

		endif; 
 
 
	endif;	
}

public function procesa_registrarse() 
{
	$this->form_validation->set_message('comprobar_email_existente_validation', 'El email ya existe, elija otro email o denuncie su propiedad');

	if ($this->form_validation->run('registrarse') == FALSE): 

		chrome_log("No Paso validacion");
		$return["resultado"] = FALSE;
		$return["mensaje"] = "Ha ocurrido un error en la validación, por favor, intenta mas tarde";

		//var_dump($this->form_validation->error_array());
		 
	else:
		chrome_log("Si Paso validacion");
 		
 		$token = sha1($this->input->post('email').rand(1,9999999).time());
		$resultado = $this->Usuario_model->registrar_usuario( $this->input->post(), $token );
		 
		if ( $resultado ):  
		 	
		 	$id_usuario =  sha1($resultado);
			$enlace = base_url().'index.php/usuario/procesa_validar_registro/'.$id_usuario.'/'.$token;

			$mensaje =  '<h2>TERMINÁ TU PEDIDO!</h2><hr><br>';
			$mensaje .= 'Has recibido este e-mail por que se efectuó una solicitud para registrarte a lemonclub.com.<br>';
			$mensaje .= 'En caso de querer continuar con el proceso de compra, haga click en el siguiente link  <a href="'.$enlace.'"> Validar Email </a>.<br>';
			$mensaje .= '<h4>Gracias por elegirnos! </h4> ';
			$mensaje .= 'Si usted no realizo el pedido, puede ignorar este mensaje.<br>';
			$mensaje  = html_entity_decode( $mensaje , ENT_QUOTES, "UTF-8");

			$asunto = "LemonClub - Registro de usuario";

			if( enviar_email( $this->input->post('email'), $mensaje, $asunto) ):

				$return["resultado"] = TRUE;
				$return["mensaje"] = "Gracias por registrarte ! Te hemos enviado un email para confirmar tu registro y finalizar tu pedido.";

			else:

				$return["resultado"] = FALSE;
				$return["mensaje"] = "Ha ocurrido un error al enviarte el email de registro, por favor, intenta mas tarde";

			endif;
		 				 
		else: 
		 	
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

			$this->session->set_userdata('id_usuario', $resultado );
			$this->session->set_flashdata('mensaje', 'Se ha registrado su usuario exitosamente. Por favor, finalice su pedido.');
			redirect(base_url()."index.php/pedido/confirmar_pedido");
		 				 
		else:  
		 	
		 	chrome_log("No Pudo validar"); 

		endif; 

	endif; 	
}


public function logout()
{
	$this->session->unset_userdata('usuario_lemon');

	$this->db->close();
	session_destroy();
	redirect('pages/index/','refresh');
}

public function comprobar_email_existente_validation($email=null)  
{
	if( $this->Usuario_model->existe_email_registrado($email) )
		return false; 
	else 
		return true; // Duplicado 	
}




}