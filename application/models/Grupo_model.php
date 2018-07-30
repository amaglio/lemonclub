<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grupo_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	//-- Buscar grupos para agregar a un producto por un string.

	public function get_grupos_producto_by_string( $string, $id_producto )
	{
		chrome_log("Grupo_model/get_grupos");

	 	$sql = " 	SELECT *
					FROM	grupo g
					WHERE 	g.nombre like '%$string%'
					AND 	g.id_grupo NOT IN ( 	SELECT pg.id_grupo 
													FROM producto_grupo pg
													WHERE pg.id_producto = $id_producto 
													AND pg.fecha_baja IS NULL)
					ORDER BY g.nombre"; 

		$query = $this->db->query($sql);
	 
	    return $query;     
	}

	//-- Traer informacion del grupo 

	public function get_informacion_grupo( $id_grupo )
	{
		chrome_log("Grupo_model/get_informacion_grupo");

	 	$sql = "SELECT  *
				FROM 	grupo g
				WHERE 	g.id_grupo = ? "; 

		$query = $this->db->query($sql, array($id_grupo) );
	 
	    return $query->row_array();

        return $id_pago_online;
	}

	//-- Traer ingredientes del grupo 

	public function get_ingredientes_grupo( $id_grupo )
	{
		chrome_log("Grupo_model/get_ingredientes_grupo");

		chrome_log("SELECT  *
				FROM 	grupo_ingrediente gi,
						ingrediente i 
				WHERE 	gi.id_grupo = ? 
				AND 	gi.id_ingrediente = i.id_ingrediente 
				AND 	gi.fecha_baja IS NULL");

	 	$sql = "SELECT  *
				FROM 	grupo_ingrediente gi,
						ingrediente i 
				WHERE 	gi.id_grupo = ? 
				AND 	gi.id_ingrediente = i.id_ingrediente 
				AND 	gi.fecha_baja IS NULL 
				AND 	i.fecha_baja IS NULL"; 

		$query = $this->db->query($sql, array($id_grupo) );
	 
	    return $query->result_array(); 
	}

	//-- ABM ingredientes del grupo 

	public function abm_ingrediente_grupo($accion, $array)
	{
	    switch ($accion) 
	    {

	    	case 'A':
	    		
	    			$result = $this->db->get_where('grupo_ingrediente', array(	'id_grupo' => $array['id_grupo'] , 
   																				'id_ingrediente' => $array['id_ingrediente'] ) );

			   		if( !$result ):

						$grupo_ingrediente['id_grupo'] =  $array['id_grupo'];
						$grupo_ingrediente['id_ingrediente'] = $array['id_ingrediente']; 
					 
						$result = $this->db->insert('grupo_ingrediente', $grupo_ingrediente); 

					else:

						$where['id_grupo'] =  $array['id_grupo'];
						$where['id_ingrediente'] = $array['id_ingrediente']; 

						$data = array(
			               'fecha_baja' => NULL
			            );

						$this->db->where( $where);
						$result =  $this->db->update('grupo_ingrediente', $data); 


					endif;

					break;

	    	case 'B':
	    		
	    		$where['id_grupo'] =  $array['id_grupo'];
				$where['id_ingrediente'] = $array['id_ingrediente']; 

				$data = array(
	               'fecha_baja' => date('Y-m-d H:i:s')
	            );

				$this->db->where( $where);
				$result =  $this->db->update('grupo_ingrediente', $data); 

	    		break;
 
	    	default:
	    		 
	    		break;
	    }

	    if( $result )
			return true;
		else
	      	return false;	 	
	}
 	
	//-- ABM   del grupo 

	public function abm_grupo($accion, $array)
	{	
		chrome_log("abm_grupo");

	    switch ($accion) 
	    {

	    	case 'A':

	    	case 'B':
	    		
	    		chrome_log("B");

	    		$where['id_grupo'] =  $array['id_grupo']; 

				$data = array(
	               'fecha_baja' => date('Y-m-d H:i:s')
	            );

				$this->db->where( $where);
				$result =  $this->db->update('grupo', $data); 

	    		break;
 
	    	default:
	    		 
	    		break;
	    }

	    if( $result )
			return true;
		else
	      	return false;	 	
	}


}

/* End of file  */
/* Location: ./application/models/ */
 