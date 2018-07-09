<?php
class My_custom_model extends grocery_CRUD_Model {
    

    public function join_where_solicitud_web_administrador() 
    {   
        
         
        $this->db->join('producto p', 'p.id_producto = producto_dia.id_producto', 'inner');
        $this->db->select('p.nombre, p.path_imagen, p.precio ', FALSE);   
    }

    function db_update($post_array, $primary_key_value)
    {
        if ($this->field_exists('updated'))
        {
            $this->load->helper('date');
            $post_array['updated'] = date('Y-m-d H:i:s',now());
        }
    
        return parent::db_update($post_array, $primary_key_value);
    }  
  
    function db_insert($post_array)
    {
        if ($this->field_exists('updated') && $this->field_exists('created'))
        {
            $this->load->helper('date');
            $post_array['created'] = date('Y-m-d H:i:s',now());
            $post_array['updated'] = date('Y-m-d H:i:s',now());
        }
        return parent::db_insert($post_array);
    }
  

}