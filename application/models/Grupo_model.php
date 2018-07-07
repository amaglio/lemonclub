<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grupo_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_informacion_grupo( $id_grupo )
	{
		chrome_log("Grupo_model/get_informacion_grupo");

	 	$sql = "SELECT  *
				FROM 	grupo 
				WHERE 	id_grupo = ? "; 

		$query = $this->db->query($sql, array($id_grupo) );
	 
	    return $query->row_array();

        return $id_pago_online;
	}

	public function get_ingredientes_grupo( $id_grupo )
	{
		chrome_log("Grupo_model/get_ingredientes_grupo");

	 	$sql = "SELECT  *
				FROM 	grupo_ingrediente gi,
						ingrediente i 
				WHERE 	gi.id_grupo = ? 
				AND 	gi.id_ingrediente = i.id_ingrediente "; 

		$query = $this->db->query($sql, array($id_grupo) );
	 
	    return $query->result_array(); 
	}

	public function set_ingrediente_grupo($array)
    {
   		chrome_log("Administrador_model/agregar_ingrediente_grupo");
 
		//--- Producto ingrediente ---

		$grupo_ingrediente['id_grupo'] =  $array['id_grupo'];
		$grupo_ingrediente['id_ingrediente'] = $array['id_ingrediente']; 
	 
		$this->db->insert('grupo_ingrediente', $grupo_ingrediente); 
 
	    if($this->db->affected_rows() > 0)
			return true;
		else
	      	return false;
    }
 	
 	public function eliminar_ingrediente_grupo($array)
	{	
	 	$array_grupo_ingrediente = array( 	'id_ingrediente' => $array['id_ingrediente'], 
	 										'id_grupo' => $array['id_grupo'] 
	 									);
	 	
	 	$this->db->where($array_grupo_ingrediente);

	  	return $this->db->delete('grupo_ingrediente',$array_grupo_ingrediente);
	}

	public function eliminar_grupo_producto($array)
	{	
	 	$array_grupo_producto = array( 	'id_producto' => $array['id_producto'], 
	 										'id_grupo' => $array['id_grupo'] 
	 									);
	 	
	 	$this->db->where($array_grupo_producto);

	  	return $this->db->delete('producto_grupo',$array_grupo_producto);
	}
}

/* End of file  */
/* Location: ./application/models/ */