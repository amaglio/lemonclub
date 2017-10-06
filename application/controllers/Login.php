<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		
		parent::__construct();
		$this->load->model('Login_model');
	}

	public function login()
	{
		 
		$this->load->view('administrador/login');
	}

	public function procesa_login()
	{
		chrome_log("Login/procesa_login");
	 
		if ($this->form_validation->run('procesa_login') == FALSE):

			chrome_log("No paso validacion");
			$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');

		else: 
		 
			chrome_log("Paso validacion");
 	
 
	 
		endif;

		redirect('administrador/home/','refresh');
	}

	public function logout()
	{
		$this->session->unset_userdata('usuario_lemon');

		$this->db->close();
		session_destroy();
		redirect(base_url()."index.php/login/login");
		
	}
 

}
