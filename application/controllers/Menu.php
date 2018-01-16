<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

	private static $solapa = "menu";

	public function __construct()
	{
		parent::__construct();

                $this->load->model('producto_tipo_model');
                $this->load->model('producto_model');
                $this->load->model('pedido_model'); 
	}

	public function index($id = FALSE)
	{       
                $data['plato_dia'] = 0;

                $data['tipos'] = $this->producto_tipo_model->get_items();

                if($id == FALSE)
                {       
                        $data['tipo_actual'] = $this->producto_tipo_model->get_primer_item();
                }
                else
                {
                        $data['tipo_actual'] = $this->producto_tipo_model->get_items($id);
                }

                if($data['tipo_actual'])
                {
                	$data['productos'] = $this->producto_model->get_items_x_tipo($data['tipo_actual']['id_producto_tipo']);
                }
                else
                {
                	if($id == -1 )// traigo los platos del dia
                        { 
                                $data['productos'] = $this->producto_model->get_productos_dia();
                                $data['plato_dia'] = 1;
                        }
                        else
                        {
                                redirect('menu/index/-1');
                        }
                }

                $this->load->view(self::$solapa.'/index', $data);
	}

}
