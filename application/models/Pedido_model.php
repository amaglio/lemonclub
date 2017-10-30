<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pedido_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
		
	}


	function abm_pedido($accion, $array)
    {
 	 
   		$nombre = $array['nombre'];
   		$apellido = $array['apellido'];
   		$mail = $array['mail'];

   
 		$this->db->trans_start();

 			//--- Insertar USUARIO


 			
 			//--- Insertar PEDIDO 

			$array_pedido['id_pedido_estado'] = 1; // Sin confirmar pero hay que ver si la envia ya logueado
		    $array_pedido['id_sucursal'] = 1; // Harcodeada la de reconquista
		    $array_pedido['id_usuario'] = 0; // 
		    $array_pedido['id_forma_pago'] = 0;
		    $array_pedido['id_forma_entrega'] = 0;

		    $this->db->insert('pedido',$array_pedido);

		    $id_pedido = $this->db->insert_id();

		    //---- Insertar PRODUCTOS DEL PEDIDO

		    foreach ($this->cart->contents() as $item)
			{
				print_r($item);
				
				$array_pedido_producto['id_pedido'] = $id_pedido;
		    	$array_pedido_producto['id_producto'] = $item['id']; 
		    	$array_pedido_producto['cantidad'] = $item['qty']; // 

		    	$this->db->insert('pedido_producto',$array_pedido_producto);

			}

			//---- Insertar PEDIDO DELIVEY 

			$array_pedido_delivey['id_pedido'] = $id_pedido;  
		    $array_pedido_delivey['dirección'] = $array['calle'];  
		    $array_pedido_delivey['telefono'] = $array['telefono'];
		    // $array_pedido_delivey['latitud'] = $array['latitud'];
		    // $array_pedido_delivey['longitud'] = $array['longitud'];
		    // $array_pedido_delivey['nota'] = $array['nota'];

			$this->db->insert('pedido_delivery',$array_pedido_delivey);

			//---- Insertar PEDIDO DELIVEY 

 		$this->db->trans_complete();
	 
		if ($this->db->trans_status() === FALSE) // Error en la transaccion
		{
		    return false;
		}
		else
		{
	   		return true;
		}    		 
 		
    	 
    }


}

/* End of file  */
/* Location: ./application/models/ */