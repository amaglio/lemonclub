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

        public function producto($id_producto = FALSE)
        {       
                if($id_producto == FALSE)
                {       
                        redirect('menu');
                }

                // Buscamos la informacion del pedido_producto

                //$datos['informacion_pedido_producto'] =  $this->pedido_model->get_informacion_pedido_producto($id_pedido_producto);

                // Buscamos los ingredientes del pedido_producto

                //$datos['informacion_ingredientes_pedido_producto'] =  $this->pedido_model->get_ingredientes_pedido_producto($id_pedido_producto);

                // Buscamos informacion del producto: aca habria que comprobar el estado del producto. 

                $datos['informacion_producto'] =  $this->producto_model->get_informacion_producto($id_producto);

                $datos['ingredientes_default'] = $this->pedido_model->get_ingredientes_default_producto($id_producto);

                // Buscamos los grupos que forman el producto.

                $grupos_producto =  $this->producto_model->get_grupos_producto($id_producto);

                //var_dump($grupos_producto);

                $array_grupos = array();

                $datos['cantidad'] = 0;

                foreach ($grupos_producto as $row) // Recorremos los grupos para traer los ingredientes.
                {
                        chrome_log("Grupo: [".$row['id_grupo']."]- ".$row['nombre']."]- ".$row['id_producto']);

                        $grupo['datos_grupo'] = $row;

                        // Buscamos los ingredientes del grupo: aca habria que comprobar el estado del ingrediente.  
                        $grupo['ingredientes_grupo'] = $this->producto_model->get_ingredientes_grupo_producto( $row['id_producto'], $row['id_grupo'] );
                        /*
                        foreach ($grupo['ingredientes_grupo'] as $key_ingrediente_grupo => $ingrediente_grupo)
                        {       
                                chrome_log("Ingrediente: ".$ingrediente_grupo['nombre']);
                                
                                foreach ($datos['informacion_ingredientes_pedido_producto'] as $key_ingrediente_pedido_producto => $ingrediente_pedido_producto)
                                {
                                        if($ingrediente_grupo['id_ingrediente'] == $ingrediente_pedido_producto['id_ingrediente'] && $row['id_grupo'] == $ingrediente_pedido_producto['id_grupo'])
                                        {
                                                $grupo['ingredientes_grupo'][$key_ingrediente_grupo]['seleccionado'] = TRUE;
                                                $datos['cantidad']++;
                                        }
                                }
                        }
                        */
                        array_push($array_grupos, $grupo);
                }

                //print_r($array_grupos);

                $datos['grupos_producto'] = $array_grupos;

                $datos['total'] = 0;


                $this->load->view('pedido/ver_editar_pedido_producto3', $datos);
        }

}
