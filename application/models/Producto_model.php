<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Producto_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	function get_items($id = FALSE)
    {
   		if ($id === FALSE)
        {
            $query = $this->db->query('SELECT *
                                        FROM producto AS P');
            return $query->result_array();
        }

        $query = $this->db->query('SELECT *
                                    FROM producto AS P
                                    WHERE P.id_producto='.$id);
        return $query->row_array();
    }

    function get_items_x_tipo($id=FALSE)
    {
        if ($id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT *
                                    FROM producto AS P
                                    WHERE P.id_producto_tipo='.$id.'
                                    ORDER BY P.nombre');
        return $query->result_array();
    }

}

/* End of file  */
/* Location: ./application/models/ */