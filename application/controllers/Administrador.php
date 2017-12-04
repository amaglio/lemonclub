<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administrador extends CI_Controller {

public function __construct()
{
	
	parent::__construct();

	$this->load->database();
	$this->load->helper('url');
	$this->load->model('Administrador_model');
	$this->load->model('Pedido_model');
	$this->load->model('Producto_model');
	$this->load->model('Estadisticas_model');
	$this->load->library('grocery_CRUD'); 
}

public function _example_output($output = null)
{	

	$output->titulo = traer_titulo($this->uri->segment(2));
	$this->load->view('administrador/index.php',(array)$output);

}

public function index()
{
	$output = (object)array('output' => '' , 'js_files' => array() , 'css_files' => array());
	$output->titulo = traer_titulo($this->uri->segment(2));
	$this->load->view('administrador/index.php',(array)$output);
	$this->load->view('administrador/footer');
}

public function tipos_productos()
{
	$crud = new grocery_CRUD();

	$crud->set_table('producto_tipo');
	$crud->columns('id_producto_tipo','descripcion');
	$crud->display_as('id_producto_tipo','Id')
		 ->display_as('descripcion','Descripcion del tipo');
	$crud->unset_delete();
	$crud->set_language("spanish"); 
	$crud->required_fields('descripcion');
	
	// Deshabilitar agregar y editar
	//$crud->unset_add();
	//$crud->unset_edit();

	$output = $crud->render();



	$this->_example_output($output);
}

public function productos()
{
	$crud = new grocery_CRUD();

	$crud->set_table('producto');
	$crud->columns('id_producto','id_producto_tipo','nombre','descripcion','precio','path_imagen');
	$crud->display_as('id_producto','Id')
		 ->display_as('descripcion','Descripcion del tipo de plato')
		 ->display_as('id_producto_tipo','Tipo de producto');

	$crud->add_action('Agregar Ingredientes',   base_url().'assets/grocery_crud/themes/flexigrid/css/images/ingredientes.png', 'Administrador/agregar_ingrediente');

	
	$state_info = $crud->getStateInfo();
	$state = $crud->getState();
	if($state == "edit")
	{
		$primary_key = $state_info->primary_key;
		$crud->field_type('id_producto','readonly');
	}

	$crud->set_subject('Producto');
	$crud->set_relation('id_producto_tipo','producto_tipo','descripcion');

	$crud->set_language("spanish"); 

	$crud->required_fields('id_producto_tipo' , 'nombre' , 'precio');

	$crud->set_field_upload('path_imagen','assets/images/productos');

	$output = $crud->render();

	$this->_example_output($output);
}

public function usuarios_invitados()
{
	$crud = new grocery_CRUD();

	$crud->set_table('usuario');
	$crud->columns('email');
	$crud->display_as('id_usuario','Usuario Registrado');

	$crud->set_relation('id_usuario','usuario_registrado','id_usuario' );
	$crud->where('apellido', NULL);

	$crud->unset_delete();
	$crud->unset_add();
	$crud->unset_edit();
	$crud->unset_read();
	$output = $crud->render();

	$this->_example_output($output);
}

public function usuarios_registrados()
{
	$crud = new grocery_CRUD();

	$crud->set_table('usuario_registrado');
	$crud->columns('id_usuario','nombre','apellido','telefono', 'direccion');
	$crud->display_as('id_usuario','ID - Email');

	$crud->set_relation('id_usuario','usuario','[{id_usuario}] - {email}');
	$crud->unset_delete();
	$crud->unset_add();
	$crud->unset_edit();
	$crud->unset_read();
 
	$output = $crud->render();

	$this->_example_output($output);
}

public function ingredientes()
{
	$crud = new grocery_CRUD();

	$crud->set_table('ingrediente');
	$crud->columns('id_ingrediente','nombre','precio','calorias', 'path_imagen', 'id_ingrediente_tipo');
	$crud->display_as('id_ingrediente','Id')
		 ->display_as('id_ingrediente_tipo','Tipo de Ingrediente')
		 ->display_as('descripcion','Descripcion del tipo');
	$crud->unset_delete();
	$crud->set_language("spanish"); 
	$crud->required_fields('descripcion');
	

	$crud->set_field_upload('path_imagen','assets/images/productos');

	$crud->set_relation('id_ingrediente_tipo','ingrediente_tipo','descripcion');

	$output = $crud->render();

	$this->_example_output($output);
}


public function tipos_ingredientes()
{
	$crud = new grocery_CRUD();

	$crud->set_table('ingrediente_tipo');
	$crud->columns('id_ingrediente_tipo','descripcion');
	$crud->display_as('id_ingrediente_tipo','Id')
		 ->display_as('descripcion','Tipo de ingrediente');
	$crud->unset_delete();
	$crud->set_language("spanish"); 
	$crud->required_fields('descripcion');



	$output = $crud->render();

	$this->_example_output($output);
}

public function pedidos($vista=null)
{
		$data['mensaje'] = $this->session->flashdata('mensaje');
		$output = (object)array('output' => '' , 'js_files' => array() , 'css_files' => array());
		$output->titulo = traer_titulo($this->uri->segment(2));
		$this->load->view('administrador/index.php',(array)$output);

		$pedidos = $this->Pedido_model->traer_pedidos_pendientes();
 
		$array_pedidos = array();

		foreach($pedidos as $row)
		{
			$informacion['informacion_pedido'] =  $row;
			$informacion['total_pedido'] = $this->Pedido_model->get_total_pedido($row['id_pedido']);
			$informacion['productos'] = $this->Pedido_model->get_pedido_productos($row['id_pedido']);

			array_push($array_pedidos, $informacion);
		}

		$data['estados_pedidos'] = $this->Pedido_model->get_pedido_estados();

		$data['pedidos'] = $array_pedidos;

		$filtros['forma_entrega'] = $this->Pedido_model->get_forma_entrega();
		$filtros['productos'] = $this->Producto_model->get_items();
		$filtros['estados'] = $this->Pedido_model->get_pedido_estados();

		$data['menu_pedidos'] = $this->load->view('administrador/menu_pedidos.php',$filtros, TRUE);
		
		if($vista == 'tabla')
			$this->load->view('administrador/pedidos_tabla.php',$data);
		else
			$this->load->view('administrador/pedidos.php',$data);

		
 
}



public function buscar_pedidos($vista=null)
{
		$data['mensaje'] = $this->session->flashdata('mensaje');
		$output = (object)array('output' => '' , 'js_files' => array() , 'css_files' => array());
		$output->titulo = traer_titulo($this->uri->segment(2));
		$this->load->view('administrador/index.php',(array)$output);

		$texto_filtros = "";

		$pedidos = $this->Pedido_model->buscar_pedidos( $this->input->post(), $texto_filtros );
 	
		$array_pedidos = array();
 
		if( $pedidos ): 

			foreach($pedidos as $row)
			{
				$informacion['informacion_pedido'] =  $row;
				$informacion['total_pedido'] = $this->Pedido_model->get_total_pedido($row['id_pedido']);
				$informacion['productos'] = $this->Pedido_model->get_pedido_productos($row['id_pedido']);

				array_push($array_pedidos, $informacion);
			}
		else:

			$array_pedidos = NULL;
		
		endif;

		$data['estados_pedidos'] = $this->Pedido_model->get_pedido_estados();

		$data['pedidos'] = $array_pedidos;

		$filtros['forma_entrega'] = $this->Pedido_model->get_forma_entrega();
		$filtros['productos'] = $this->Producto_model->get_items();
		$filtros['estados'] = $this->Pedido_model->get_pedido_estados();
		
		$filtros['texto_filtros'] = $texto_filtros;

		$data['menu_pedidos'] = $this->load->view('administrador/menu_pedidos.php',$filtros, TRUE);
		
		if($vista == 'tabla')
			$this->load->view('administrador/pedidos_tabla.php',$data);
		else
			$this->load->view('administrador/pedidos.php',$data);

 
}

public function estadisticas( )
{
	$data['mensaje'] = $this->session->flashdata('mensaje');
	$output = (object)array('output' => '' , 'js_files' => array() , 'css_files' => array());
	$output->titulo = traer_titulo($this->uri->segment(2));
	$this->load->view('administrador/index.php',(array)$output);

	//$data['cantidad_pedidos'] = $this->Estadisticas_model->get_cantidad_pedidos();


	$this->load->view('administrador/estadisticas.php',$data);

		
 
}


public function f_agregar_textarea()
{

      return '<textarea name="address" rows="15"></textarea>';

}

public function agregar_ingrediente()
{
 	$datos['mensaje'] = $this->session->flashdata('mensaje');
	$output = (object)array('output' => '' , 'js_files' => array() , 'css_files' => array());
	$output->titulo = traer_titulo($this->uri->segment(2));

	$this->load->view('administrador/index.php',(array)$output);

	$id_producto = $this->uri->segment(3);

	$datos['producto_info'] = $this->Administrador_model->traer_informacion_producto($id_producto);
	$datos['ingredientes_producto'] = $this->Administrador_model->traer_ingredientes_producto($id_producto);

	$this->load->view('administrador/agregar_ingredientes_producto.php',$datos); 

	/*

	$output = (object)array('output' => '' , 'js_files' => array() , 'css_files' => array());
	$output->titulo = "Disponible en la <b>  etapa 2 <b>";
	$this->load->view('administrador/index.php',(array)$output);*/
}


public function agregar_ingrediente_producto()
{
	chrome_log("Administrador/agregar_ingrediente_producto");
 
	if ($this->form_validation->run('agregar_ingrediente_producto') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
		//redirect('Admin/index/','refresh');

	else: 
	 
		chrome_log("Paso validacion");

		print_r($this->input->post());
 
		$query = $this->Administrador_model->agregar_ingrediente_producto( $this->input->post() );

		if ( $query ):   // Si se creo el token, se envia el email
		 
			chrome_log("Pudo agrego el ingrediente al producto");
 			 
			$this->session->set_flashdata('mensaje', 'Se le ha agregado el ingrediente exitosamente ');
		 				 
		else: 

 			$this->session->set_flashdata('mensaje', 'Ha ocurrido un error, por favor, intentá mas tarde.');

		endif;  
 
 		redirect('Administrador/agregar_ingrediente/'.$this->input->post('id_producto'),'refresh');

	endif; 
		 
}

public function ajax_ingrediente()
{
	chrome_log("ajax_ingrediente: " );

	$buscar = $this->input->get('term');

	if( isset($buscar) && strlen($buscar) > 1 )
	{
		$query=$this->db->query("   SELECT *
									FROM	ingrediente i
									WHERE 	i.nombre like '%$buscar%'
									ORDER BY i.nombre"
								);

		
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{	
 

				$result[]= array( 	"id_ingrediente" => $row->id_ingrediente, 
									"value" => $row->nombre 
								);

			 
			}
		} 
		
		echo json_encode($result);
	}
}
 
public function producto_dia()
{
	$crud = new grocery_CRUD();

	$crud->set_table('producto_dia');
	$crud->columns('id_producto');
	$crud->display_as('id_producto','Id');
	$crud->set_relation('id_producto','producto','nombre');

	$crud->set_language("spanish"); 

	$crud->required_fields('id_producto');


	$output = $crud->render();

	$this->_example_output($output);
}

/*
public function offices_management()
{
	try{
		$crud = new grocery_CRUD();

		$crud->set_theme('datatables');
		$crud->set_table('offices');
		$crud->set_subject('Office');
		$crud->required_fields('city');
		$crud->columns('city','country','phone','addressLine1','postalCode');

		$output = $crud->render();

		$this->_example_output($output);

	}catch(Exception $e){
		show_error($e->getMessage().' --- '.$e->getTraceAsString());
	}
}

public function employees_management()
{
		$crud = new grocery_CRUD();

		$crud->set_theme('datatables');
		$crud->set_table('employees');
		$crud->set_relation('officeCode','offices','city');
		$crud->display_as('officeCode','Office City');
		$crud->set_subject('Employee');

		$crud->required_fields('lastName');

		$crud->set_field_upload('file_url','assets/uploads/files');

		$output = $crud->render();

		$this->_example_output($output);
}



public function orders_management()
{
		$crud = new grocery_CRUD();

		$crud->set_relation('customerNumber','customers','{contactLastName} {contactFirstName}');
		$crud->display_as('customerNumber','Customer');
		$crud->set_table('orders');
		$crud->set_subject('Order');
		$crud->unset_add();
		$crud->unset_delete();

		$output = $crud->render();

		$this->_example_output($output);
}

public function products_management()
{
		$crud = new grocery_CRUD();

		$crud->set_table('products');
		$crud->set_subject('Product');
		$crud->unset_columns('productDescription');
		$crud->callback_column('buyPrice',array($this,'valueToEuro'));

		$output = $crud->render();

		$this->_example_output($output);
}

public function valueToEuro($value, $row)
{
	return $value.' &euro;';
}

public function film_management()
{
	$crud = new grocery_CRUD();

	$crud->set_table('film');
	$crud->set_relation_n_n('actors', 'film_actor', 'actor', 'film_id', 'actor_id', 'fullname','priority');
	$crud->set_relation_n_n('category', 'film_category', 'category', 'film_id', 'category_id', 'name');
	$crud->unset_columns('special_features','description','actors');

	$crud->fields('title', 'description', 'actors' ,  'category' ,'release_year', 'rental_duration', 'rental_rate', 'length', 'replacement_cost', 'rating', 'special_features');

	$output = $crud->render();

	$this->_example_output($output);
}

public function film_management_twitter_bootstrap()
{
	try{
		$crud = new grocery_CRUD();

		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('film');
		$crud->set_relation_n_n('actors', 'film_actor', 'actor', 'film_id', 'actor_id', 'fullname','priority');
		$crud->set_relation_n_n('category', 'film_category', 'category', 'film_id', 'category_id', 'name');
		$crud->unset_columns('special_features','description','actors');

		$crud->fields('title', 'description', 'actors' ,  'category' ,'release_year', 'rental_duration', 'rental_rate', 'length', 'replacement_cost', 'rating', 'special_features');

		$output = $crud->render();
		$this->_example_output($output);

	}catch(Exception $e){
		show_error($e->getMessage().' --- '.$e->getTraceAsString());
	}
}

function multigrids()
{
	$this->config->load('grocery_crud');
	$this->config->set_item('grocery_crud_dialog_forms',true);
	$this->config->set_item('grocery_crud_default_per_page',10);

	$output1 = $this->offices_management2();

	$output2 = $this->employees_management2();

	$output3 = $this->customers_management2();

	$js_files = $output1->js_files + $output2->js_files + $output3->js_files;
	$css_files = $output1->css_files + $output2->css_files + $output3->css_files;
	$output = "<h1>List 1</h1>".$output1->output."<h1>List 2</h1>".$output2->output."<h1>List 3</h1>".$output3->output;

	$this->_example_output((object)array(
			'js_files' => $js_files,
			'css_files' => $css_files,
			'output'	=> $output
	));
}

public function offices_management2()
{
	$crud = new grocery_CRUD();
	$crud->set_table('offices');
	$crud->set_subject('Office');

	$crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/multigrids")));

	$output = $crud->render();

	if($crud->getState() != 'list') {
		$this->_example_output($output);
	} else {
		return $output;
	}
}

public function employees_management2()
{
	$crud = new grocery_CRUD();

	$crud->set_theme('datatables');
	$crud->set_table('employees');
	$crud->set_relation('officeCode','offices','city');
	$crud->display_as('officeCode','Office City');
	$crud->set_subject('Employee');

	$crud->required_fields('lastName');

	$crud->set_field_upload('file_url','assets/uploads/files');

	$crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/multigrids")));

	$output = $crud->render();

	if($crud->getState() != 'list') {
		$this->_example_output($output);
	} else {
		return $output;
	}
}

public function customers_management2()
{
	$crud = new grocery_CRUD();

	$crud->set_table('customers');
	$crud->columns('customerName','contactLastName','phone','city','country','salesRepEmployeeNumber','creditLimit');
	$crud->display_as('salesRepEmployeeNumber','from Employeer')
		 ->display_as('customerName','Name')
		 ->display_as('contactLastName','Last Name');
	$crud->set_subject('Customer');
	$crud->set_relation('salesRepEmployeeNumber','employees','lastName');

	$crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/multigrids")));

	$output = $crud->render();

	if($crud->getState() != 'list') {
		$this->_example_output($output);
	} else {
		return $output;
	}
}*/

}
