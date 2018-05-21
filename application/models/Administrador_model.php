<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administrador_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
		
	}


	function traer_informacion_producto($id_producto)
    {
   	
    	$resultado = $this->db->query("	SELECT *
						    			FROM producto p
						    			WHERE p.id_producto = '$id_producto' " );

    	return $resultado->row();
    }


	function traer_ingredientes_producto($id_producto)
    {
   	
    	$resultado = $this->db->query("	SELECT 	pi.*,
												it.descripcion as tipo_ingrediente,
												i.nombre as nombre,
												i.precio as precio,
												i.calorias as calorias
						    			FROM 	producto_ingrediente pi,
												ingrediente_tipo it,
												ingrediente i
						    			WHERE pi.id_producto = '$id_producto' 
						    			AND pi.id_ingrediente = i.id_ingrediente
						    			AND i.id_ingrediente_tipo = it.id_ingrediente_tipo " );

    	return $resultado;
    }

	function agregar_ingrediente_producto($array)
    {
   		chrome_log("Administrador_model/agregar_ingrediente_producto");
 
		//--- Producto ingrediente ---

		$producto_ingrediente['id_producto'] =  $array['id_producto'];
		$producto_ingrediente['id_ingrediente'] = $array['id_ingrediente']; 
   
		if(isset($array['ingrediente_default']))
	        $producto_ingrediente['ingrediente_default'] =  1;
	    else
	    	$producto_ingrediente['ingrediente_default'] =  0;

	   	if(isset($array['ingrediente_fijo']))
	        $producto_ingrediente['ingrediente_fijo'] =  1;
	    else
	    	$producto_ingrediente['ingrediente_fijo'] =  0;
	 
		$this->db->insert('producto_ingrediente', $producto_ingrediente); 
 
	    if($this->db->affected_rows() > 0)
			return true;
		else
	      	return false;
 
    }

	


}

/* End of file  */
/* Location: ./application/models/ */