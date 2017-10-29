<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
		
	}


	function traer_id_persona($usuario_oracle)
    {
   	
    	$resultado = $this->db->query("	SELECT p.n_id_persona
						    			FROM personas p
						    			WHERE p.user_oracle = '$usuario_oracle' " );

    	return $resultado->row();
    }


}

/* End of file  */
/* Location: ./application/models/ */