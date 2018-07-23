<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Producto_tipo_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	function get_items($id = FALSE)
    {
   		if ($id === FALSE)
        {
            $query = $this->db->query('SELECT *
                                        FROM producto_tipo AS PT
                                        WHERE PT.fecha_baja IS NULL');
            return $query->result_array();
        }

        $query = $this->db->query(' SELECT *
                                    FROM producto_tipo AS PT
                                    WHERE PT.fecha_baja IS NULL AND PT.id_producto_tipo = '.$id);
        return $query->row_array();
    }

    function get_primer_item()
    {
        $query = $this->db->query('SELECT *
                                    FROM producto_tipo AS PT
                                    ORDER BY PT.id_producto_tipo AND PT.fecha_baja IS NULL 
                                    LIMIT 1');
        return $query->row_array();
    }

}

/* End of file  */
/* Location: ./application/models/ */