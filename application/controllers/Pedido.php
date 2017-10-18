<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pedido extends CI_Controller {

	public function __construct()
	{
		
		parent::__construct(); 
		$this->load->model('pedido_model');
	}
 

	public function alta_pedido()
	{
		chrome_log("alta_pedido");

		if ($this->form_validation->run('alta_pedido') == FALSE):  

			chrome_log("No Paso validacion");
			$mensaje['mensaje'] = 'No pasó la validación, intente nuevamente';
 
		 
		else:

			chrome_log("Si Paso validacion");

			$query = $this->Area_model->abm_pedido( 'A', $this->input->post() );
	  
 
		endif; 
	}
		 

 
}