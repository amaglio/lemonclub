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

    function get_productos_dia()
    {

        $query = $this->db->query('SELECT *
                                    FROM producto_dia pd,
                                         producto p
                                    WHERE pd.id_producto = p.id_producto');

        return $query->result_array();
    }

    function get_grupos_producto($id_producto)
    {
        $sql =  '   SELECT *
                    FROM    producto_grupo pg,
                            grupo g
                    WHERE   pg.id_producto = ?
                    AND     pg.id_grupo = g.id_grupo' ; 

        $query = $this->db->query($sql, array( $id_producto) ); 

        return $query->result_array();
    }

    function set_grupo_producto($array)
    {
        $array = array(
                'id_producto' => $array['id_producto'],
                'id_grupo' => $array['id_grupo']
            );

        return $this->db->insert('producto_grupo', $array);
    }

    function get_ingredientes_grupo_producto($id_producto)
    {
        $sql =  '   ' ; 

        $query = $this->db->query($sql, array( $id_producto) ); 

        return $query->result_array();
    }

}

/* End of file  */
/* Location: ./application/models/ */