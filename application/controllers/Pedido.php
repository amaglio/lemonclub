<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pedido extends CI_Controller {

	private static $solapa = "pedido";

	public function __construct()
	{
		parent::__construct();

		$this->load->model('pedido_model');
		$this->load->model('producto_model');

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
	}
 

	public function index()
	{
		$this->load->view(self::$solapa.'/index');
	}

	public function confirmar_pedido()
	{
		$data['error'] = FALSE;
		$data['success'] = FALSE;

		$this->form_validation->set_rules('nombre', 'nombre', 'required');
		$this->form_validation->set_rules('apellido', 'apellido', 'required');
		$this->form_validation->set_rules('mail', 'Email', 'required');

		if($this->form_validation->run() !== FALSE)
        {
        	$this->cart->destroy();

            redirect(self::$solapa.'/success');
        }

		$this->load->view(self::$solapa.'/confirmar_pedido', $data);
	}

	public function success()
	{
		$this->load->view(self::$solapa.'/success');
	}

	public function agregar_producto_ajax()
	{
		$return['error'] = FALSE;

		if($this->input->post('id') != "")
		{
			$producto = $this->producto_model->get_items($this->input->post('id'));
			$data = array(
		        'id'      => $producto['id_producto'],
		        'qty'     => 1,
		        'price'   => $producto['precio'],
		        'name'    => $producto['nombre'],
		        'descripcion' => $producto['descripcion']
		        //'options' => array('Size' => 'L', 'Color' => 'Red')
			);

			$this->cart->insert($data);

			$return['error'] = FALSE;
			$return['data'] = "El producto fue agregado al carrito.";
		}
		else
		{
			$return['error'] = TRUE;
			$return['data'] = "Debe seleccionar un producto.";
		}

		echo json_encode($return);
	}

	public function modificar_cantidad_ajax()
	{
		$return['error'] = FALSE;

		if($this->input->post('rowid') != "")
		{
			$data = array(
		        'rowid' => $this->input->post('rowid'),
		        'qty'   => $this->input->post('qty')
			);

			$this->cart->update($data);

			$return['error'] = FALSE;
			$return['data'] = "La cantidad fue modificada.";
			$return['total'] = $this->cart->format_number($this->cart->total());
		}
		else
		{
			$return['error'] = TRUE;
			$return['data'] = "Debe seleccionar un producto.";
		}

		echo json_encode($return);
	}

	public function comprar()
	{
		chrome_log("Pedido/comprar");	 

		if ($this->form_validation->run('comprar') == FALSE):

			chrome_log("No paso validacion");
			$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
			//redirect('Login/index/','refresh');

		else: 
		 
			chrome_log("Paso validacion");

			//$this->pedido_model->abm_pedido('A',$this->input->post());

 			
 			/*
			foreach ($this->cart->contents() as $item)
			{
				 
			}*/


 			
	 
		endif;


	}

}