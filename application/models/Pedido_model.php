<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pedido_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
		
	}


	function abm_pedido($accion, $array)
    {
 		/*
   		$nombre = $array['nombre'];
   		$apellido = $array['apellido'];
   		$mail = $array['mail'];

   
 		$this->db->trans_start();
 			
 			// Pedido 

			$array_agregar_programa['id_pedido'] = ;
		    $array_agregar_programa['id_sucursal'] = ;
		    $array_agregar_programa['id_usuario'] = ;
		    $array_agregar_programa['id_forma_pago'] = ;
		    $array_agregar_programa['id_forma_entrega'] = ;

		    $this->db->insert('pedido',$array_agregar_programa);

		    // Pedido 



 		$this->db->trans_complete();
	 
		if ($this->db->trans_status() === FALSE) // Error en la transaccion
		{
		    return false;
		}
		else
		{
	   		return true;
		}    		
		*/

 		foreach ($this->cart->contents() as $item)
		{
			print_r($item);
			
			/*echo '<div class="row item">
					<div class="col-xs-3 area-imagen"><img src="'.base_url('assets/images/productos/ensalada1.jpg').'" class="img-responsive"></div>
					<div class="col-xs-9 area-texto">'.$item['name'].' x'.$item['qty'].'</div>
				</div>';*/
		}
    	 
    }


}

/* End of file  */
/* Location: ./application/models/ */