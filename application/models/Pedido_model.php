<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pedido_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
		
	}


	function abm_pedido($accion, $array)
    {
   		$nombre = $array['nombre'];
   		$apellido = $array['apellido'];
   		$email = $array['email'];

   	 
	    if(isset($array['direccion_delivery']) && !empty($array['direccion_delivery']))
	        $direccion_delivery = "'".$array['direccion_delivery']."'";
	    else
	        $direccion_delivery = " NULL " ;


	    chrome_log("");
 

	    $sql = " ";

	    $query = $this->db->query($sql);

	    return $query->row_array(); 
    	 
    }


}

/* End of file  */
/* Location: ./application/models/ */