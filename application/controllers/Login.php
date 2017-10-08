<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		
		parent::__construct();
		//$this->load->model('Login_model');
	}

	public function index()
	{ 
		$datos['mensaje'] = $this->session->flashdata('mensaje');
		$datos['error'] = $this->session->flashdata('error');
		$this->load->view('administrador/login');
	}

	public function procesa_logueo()
	{
		chrome_log("Login/procesa_login");
	 
		if ($this->form_validation->run('loguearse') == FALSE):

			chrome_log("No paso validacion");
			$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
			redirect('Login/index/','refresh');

		else: 
		 
			chrome_log("Paso validacion");
 			
 			$this->session->set_userdata('usuario_lemon',  "aaaaa" );
 			
 			echo "Post: ".$this->input->post('usuario')."<br>";
 			echo "Session: ".$this->session->userdata('usuario_lemon');
 			redirect('Administrador/index/','refresh');
	 
		endif;

		
	}

	public function logout()
	{
		$this->session->unset_userdata('usuario_lemon');

		$this->db->close();
		session_destroy();
		redirect('Login/index/','refresh');
		
	}
 

}
