<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Controller {

public function __construct()
{
	parent::__construct();
	$this->load->model('Usuario_model');
}
 

public function procesa_logueo()
{
	chrome_log("Login/procesa_login");
 
	if ($this->form_validation->run('loguearse_usuario') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
		redirect('Login/index/','refresh');

	else: 
	 
		chrome_log("Paso validacion");

		$query = $this->Usuario_model->loguearse( $this->input->post() );

		if ( $query ):  
		 
			chrome_log("Pudo loguearse ");

			$this->session->set_userdata('usuario_lemon',  $query['id_usuario']);
			redirect(base_url()."index.php/pedido/comprar");
		 				 
		else:  
		 
			$this->session->set_flashdata('mensaje_login', 'Email o usuario incorrecto');

		endif; 

 
	endif;	
}

public function procesa_registrarse() 
{
	$this->form_validation->set_message('comprobar_email_existente_validation', 'El email ya existe, elija otro email o denuncie su propiedad');

	if ($this->form_validation->run('registrarse') == FALSE): 

		chrome_log("No Paso validacion");
		$this->session->set_flashdata('mensaje', 'No pasó la validacion, intente nuevamente');
		$this->session->set_flashdata('error', $this->form_validation->error_array());
		 
	else:
		chrome_log("Si Paso validacion");

		$query = $this->Usuario_model->registrar_usuario( $this->input->post() );
		 
		if ( $query['codigo_error'] == 0 ):  
		 
			chrome_log("Pudo registrarse ");

			$this->session->set_userdata('usuario_lemon', $query['id_usuario']); 

			redirect(base_url()."index.php/home");
		 				 
		else: 
		 	
			chrome_log("No pudo registrarse, intenta mas tarde");
		
			$this->session->set_flashdata('mensaje', 'No pudo registrarse, intente nuevamente');
			$this->load->view('login/login',$data);

		endif;  

	endif; 	

	redirect("Login/index");
}


public function logout()
{
	$this->session->unset_userdata('usuario_lemon');

	$this->db->close();
	session_destroy();
	redirect('Login/index/','refresh');
}

public function comprobar_email_existente_validation($email=null)  
{
	if( $this->Usuario_model->existe_email_registrado($email) )
		return false; 
	else 
		return true; // Duplicado 	
}
 


}