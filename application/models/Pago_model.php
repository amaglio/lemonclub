<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pago_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function set_item( $id_pedido, $id_estado, $id_mercadopago = NULL )
	{
		$data = array(
    		'id_pago_online' => NULL,
            'fecha_pago' => date('Y-m-d H:i:s'),
            'id_pedido' => $id_pedido,
            'id_pago_online_estado' => $id_estado
    	);

    	$this->db->insert('pago_online', $data);
        $id_pago_online = $this->db->insert_id();

        if($id_mercadopago)
        {
	        $data = array(
	    		'id_pago_online' => $id_pago_online,
	            'id_mercadopago' => $id_mercadopago
	    	);
    	}

    	$this->db->insert('pago_mercadopago', $data);

        return $id_pago_online;
	}
 
}

/* End of file  */
/* Location: ./application/models/ */