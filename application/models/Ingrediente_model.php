<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ingrediente_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

    function abm_ingrediente($accion, $array) 
    {   
        // Solo utilizamos el borrar, el Alta y Modificar usamos GC.

        switch ($accion) 
        {

            case 'B': 


                $where['id_ingrediente'] =  $array['id_ingrediente']; 

                $data = array(
                   'fecha_baja' => date('Y-m-d H:i:s')
                );

                $this->db->where( $where);
                $result =  $this->db->update('ingrediente', $data); 

                break;
 
            default:
                 
                break;
        }

        if( $result )
            return true;
        else
            return false;       
    }

    //-- Buscar ingredientes para agregar a un producto por un string.

    public function get_ingrediente_grupo_by_string( $string, $id_grupo )
    {
        chrome_log("Grupo_model/get_ingrediente_grupo_by_string");

        $sql = "    SELECT *
                    FROM    ingrediente i
                    WHERE   i.nombre like '%$string%'
                    AND i.fecha_baja IS NULL
                    AND i.id_ingrediente NOT IN ( 
                                                SELECT gi.id_ingrediente
                                                FROM  grupo_ingrediente gi
                                                WHERE gi.id_grupo = $id_grupo
                                                AND gi.fecha_baja IS NULL
                                                )
                    ORDER BY i.nombre"; 

        $query = $this->db->query($sql);
     
        return $query;

        
    }

}

/* End of file  */
/* Location: ./application/models/ */