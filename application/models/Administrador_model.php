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
												pit.descripcion as tipo_ingrediente,
												i.nombre as nombre,
												i.precio as precio,
												i.calorias as calorias
						    			FROM 	producto_ingrediente pi,
												producto_ingrediente_tipo pit,
												ingrediente i
						    			WHERE pi.id_producto = '$id_producto' 
						    			AND pi.id_ingrediente = i.id_ingrediente
						    			AND pi.id_producto_ingrediente_tipo = pit.id_producto_ingrediente_tipo " );

    	return $resultado;
    }




}

/* End of file  */
/* Location: ./application/models/ */