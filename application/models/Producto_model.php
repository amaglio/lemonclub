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

    /*
    function set_grupo_producto($array)
    {
        $array = array(
                'id_producto' => $array['id_producto'],
                'id_grupo' => $array['id_grupo']
            );

        return $this->db->insert('producto_grupo', $array);
    }
    /*
    function get_ingredientes_grupo_producto($id_grupo, $id_producto)
    {
        $sql =  '   SELECT  *
                    FROM    producto_grupo_ingrediente pgi
                    INNER JOIN ingrediente i ON pgi.id_ingrediente = i.id_ingrediente
                    WHERE pgi.id_grupo = ?
                    AND pgi.id_producto = ?' ; 

        $query = $this->db->query($sql, array( $id_grupo, $id_producto) ); 

        return $query->result_array();
    }*/

    function get_informacion_producto($id_producto)
    {
        $sql =  '   SELECT 
                          p.id_producto,
                          p.id_producto_tipo,
                          p.nombre,
                          p.path_imagen,
                          p.descripcion,
                          p.precio,
                          pt.descripcion as descripcion_tipo_producto

                    FROM
                          producto p,
                          producto_tipo pt

                    WHERE
                          p.id_producto = ?
                    AND   p.id_producto_tipo = pt.id_producto_tipo'; 

        $query = $this->db->query($sql, array( $id_producto) ); 

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
        $this->db->trans_start();

        $array_grupo = array(
                'id_producto' => $array['id_producto'],
                'id_grupo' => $array['id_grupo']
            );

        $this->db->insert('producto_grupo', $array_grupo);

        // Traigo los ingredientes del grupo y los agrego al producto-grupo

        $this->load->model('Grupo_model');

        $ingredientes = $this->Grupo_model->get_ingredientes_grupo($array['id_grupo']);

        foreach ($ingredientes as $row) 
        {
            $array_ingrediente = array(
                'id_producto' => $array['id_producto'],
                'id_grupo' => $array['id_grupo'],
                'id_ingrediente' => $row['id_ingrediente'],
            );

            $this->db->insert('producto_grupo_ingrediente', $array_ingrediente);
        }

        $this->db->trans_complete();


        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $flag = false;
        }
        else
        {
            $this->db->trans_commit();
            $flag = true;
        } 

        return $flag; 
    }

    function delete_grupo_producto($array)
    {   
        $this->db->trans_start();

        // Eliminos los ingredientes grupos productos

        $array_grupo_producto_ing['id_producto'] = utf8_decode($array['id_producto']);
        $array_grupo_producto_ing['id_grupo'] = utf8_decode($array['id_grupo']); 

        $this->db->delete('producto_grupo_ingrediente',  $array_grupo_producto_ing );

        // Elimino el grupo

        $array_grupo_producto['id_producto'] = utf8_decode($array['id_producto']);
        $array_grupo_producto['id_grupo'] = utf8_decode($array['id_grupo']); 

        $this->db->delete('producto_grupo',  $array_grupo_producto );

        $this->db->trans_complete();


        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $flag = false;
        }
        else
        {
            $this->db->trans_commit();
            $flag = true;
        } 

        return $flag; 
        
    }

    
    function get_ingredientes_grupo_producto($id_producto, $id_grupo)
    {
        $sql =  '   SELECT *
                    FROM    producto_grupo_ingrediente pgi,
                            ingrediente i
                    WHERE   pgi.id_producto = ?
                    AND     pgi.id_grupo = ?  
                    AND     pgi.id_ingrediente = i.id_ingrediente ' ; 

        $query = $this->db->query($sql, array( $id_producto, $id_grupo) ); 
 
        return $query->result_array();
    }

    function existe_grupo_producto($id_producto, $id_grupo)
    {
        $sql =  '   SELECT *
                    FROM    producto_grupo pg 
                    WHERE   pg.id_producto = ?
                    AND     pg.id_grupo = ?   ' ; 

        $query = $this->db->query($sql, array( $id_producto, $id_grupo) ); 
 
        return $query->result_array();
    }
    
    function configuracion_ingrediente_producto($array)
    {   
        $this->db->trans_start();

        // Elimino la relacion

        $array_grupo_producto_ing['id_producto'] = utf8_decode($array['id_producto']);
        $array_grupo_producto_ing['id_grupo'] = utf8_decode($array['id_grupo']); 
        $array_grupo_producto_ing['id_ingrediente'] = utf8_decode($array['id_ingrediente']);

        $this->db->delete('producto_grupo_ingrediente',  $array_grupo_producto_ing );

        // Inserto la nueva relacion

        $array_grupo_producto_insert['id_producto'] = utf8_decode($array['id_producto']);
        $array_grupo_producto_insert['id_grupo'] = utf8_decode($array['id_grupo']); 
        $array_grupo_producto_insert['id_ingrediente'] = utf8_decode($array['id_ingrediente']);
        
        if(isset($array['fijo']))
            $array_grupo_producto_insert['es_fijo'] = 1;

        if(isset($array['default']))
            $array_grupo_producto_insert['es_default'] = 1;

        $this->db->insert('producto_grupo_ingrediente',  $array_grupo_producto_insert );

        $this->db->trans_complete();


        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $flag = false;
        }
        else
        {
            $this->db->trans_commit();
            $flag = true;
        } 

        return $flag; 
        
    }


}

/* End of file  */
/* Location: ./application/models/ */