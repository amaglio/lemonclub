<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contacto extends CI_Controller {

	private static $solapa = "contacto";

	public function __construct()
	{
		parent::__construct();

		$this->load->model('pedido_model');
		$this->load->model('producto_model');
		$this->load->model('Usuario_model');

 
	}

	public function index()
	{
		$this->load->view('pages/contacto');
	}

 	
 	public function alta_contacto()
	{
		chrome_log("Contacto/alta_contacto");
 
		if ($this->form_validation->run('alta_contacto') == FALSE):

			chrome_log("No paso validacion");
			$return["resultado"] = FALSE;
			$return["mensaje"] ='Ha ocurrido un error en la validacion.'; 


		else: 
		  	
		  	$mensaje =  '<h2>CONTACTO WEB</h2><hr><br>';
			$mensaje .= 'Has recibido un contacto desde lemonclub.com.<br>';
			$mensaje .= 'Nombre:'.$this->input->post('nombre').'<br>';
			$mensaje .= 'Apellido:'.$this->input->post('apellido').'<br>';
			$mensaje .= 'Email:'.$this->input->post('mail').'<br>';
			$mensaje .= 'Mensaje:'.$this->input->post('mensaje').'<br>';
			$mensaje  = html_entity_decode( $mensaje , ENT_QUOTES, "UTF-8");

			$asunto = "LemonClub - contacto web";
 			
			if( enviar_email( "adrian.magliola@gmail.com" , $mensaje, $asunto )):

				$return["resultado"] = TRUE;
				$return["mensaje"] = 'Se le ha enviado el contacto exitosamente. Gracias por comunicarte con lemonclub.';

			else:
				$return["resultado"] = FALSE;
				$return["mensaje"] ='Ha ocurrido un error, por favor, intentá mas tarde.'; 

			endif; 
	 
		endif;

		print json_encode($return);	
 
	}


}