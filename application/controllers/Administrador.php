<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administrador extends CI_Controller {

public $pedidos_pendientes;

public function __construct()
{
	
	parent::__construct();

	$this->load->database();
	$this->load->helper('url');
	$this->load->model('Administrador_model');
	$this->load->model('Pedido_model');
	$this->load->model('Producto_model');
	$this->load->model('Grupo_model');
	$this->load->model('Estadisticas_model');
	$this->load->library('grocery_CRUD'); 
 
}

public function _example_output($output = null)
{


	$output->titulo = traer_titulo($this->uri->segment(2));
	$this->load->view('administrador/index.php',(array)$output);
}

public function imprimir_comanda($id_pedido)
{
	$pedidos = $this->Pedido_model->get_informacion_pedido($id_pedido);
	$total_pedido = $this->Pedido_model->get_total_pedido($id_pedido);
	$productos = $this->Pedido_model->get_pedido_productos($id_pedido);

	$this->load->library('Pdf');
 
	$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
	$pdf->SetTitle('Imprimir comanda');
	$pdf->SetHeaderMargin(30);
	$pdf->SetTopMargin(20);
	$pdf->setFooterMargin(20);
	$pdf->SetAutoPageBreak(true);
	$pdf->SetAuthor('Author');
	$pdf->SetDisplayMode('real', 'default');

	$pdf->AddPage();

	$html = '<h3>PEDIDO NRO: '.$pedidos['id_pedido'].' </h3>
			 <h3>FECHA DE ENTREGA: '.$pedidos['fecha_entrega'].'</h3>
	 		 <h3>EMAIL: '.$pedidos['email'].' </h3>
	 		 <h4>FORMA DE PAGO: '.$pedidos['forma_pago'].' </h4>
	 		 <h4>FORMA DE ENTREGA: '.$pedidos['forma_entrega'].' </h4>  ';

	 		if( $pedidos['id_forma_entrega'] == FORMA_ENTREGA_DELIVERY):

	 			$html .= '<h5>DIRECION: '.$pedidos['direccion'].' - '.$pedidos['nota'].' </h5>  ';

	 		endif;
	
	$html .='

				<table cellpadding="5">
					<tr style="font-weight:bold; border:1px solid #000">
						<th style="text-align:center; border:1px solid #000">Producto</th>
						<th style="text-align:center; border:1px solid #000">Cantidad</th>
						<th style="text-align:center; border:1px solid #000">Precio</th>
					</tr>
				
			';

			foreach ($productos as $row) 
			{
				$html .=' 	<tr style="  border:1px solid #000">
								<td style="text-align:center; border:1px solid #000">'.$row['nombre'].'</td>
								<td style="text-align:center; border:1px solid #000">'.$row['cantidad'].'</td>
								<td style="text-align:center; border:1px solid #000">$'.$row['cantidad']*$row['precio'].'</td>
							</tr>';
			}

			$html .=' 	<tr style="  border:1px solid #000">
								<td colspan="2" style="font-weight:bold;  text-align:center; border:1px solid #000"> Total </td> 
								<td style=" font-weight:bold; text-align:center; border:1px solid #000">$'.$total_pedido.'</td>
							</tr>';

	$html .='</table>';

	// output the HTML content
	$pdf->writeHTML($html, true, false, true, false, '');

	// $pdf->Write(5, "Numero de pedido: ".$pedidos['id_pedido'].".\n"  );
	// $pdf->Write(5, "Fecha y hora de entregra: ".$pedidos['fecha_entrega'].".\n"  );
	// $pdf->Write(5, "Forma de pago: ".$pedidos['forma_pago']."\n"  );
	// $pdf->Write(5, "Tipo de entrega: ".$pedidos['forma_entrega'].".\n\n"  );


	// $pdf->Write(5, "Productos: \n\n"  );

	// foreach ($productos as $row) 
	// {
	// 	 $pdf->Write(5, $row['nombre']." (x".$row['cantidad'].") ".".\n" );
	// }
 

	$pdf->Output('My-File-Name.pdf', 'I');
}


public function index()
{
	redirect ('Administrador/pedidos');
	/*$output = (object)array('output' => '' , 'js_files' => array() , 'css_files' => array());
	$output->titulo = traer_titulo($this->uri->segment(2));
	$this->load->view('administrador/index.php',(array)$output);
	$this->load->view('administrador/footer');*/
}

public function pedidos($vista='tabla')
{
	$data['mensaje'] = $this->session->flashdata('mensaje');
	$output = (object)array('output' => '' , 'js_files' => array() , 'css_files' => array());
	$output->titulo = traer_titulo($this->uri->segment(2));
	$this->load->view('administrador/index.php',(array)$output); 

	$pedidos = $this->Pedido_model->traer_pedidos_hoy(); // Busco los pedidos de hoy

	$array_pedidos = array();

	foreach($pedidos as $row) // Recorro los pedidos
	{
		$informacion['informacion_pedido'] =  $row;
		$informacion['total_pedido'] = $this->Pedido_model->get_total_pedido($row['id_pedido']);
		
		$informacion['productos'] = $productos = $this->Pedido_model->get_pedido_productos($row['id_pedido']); // Busco los productos
	 
		foreach($productos as $row_producto ) // Recorro los productos
		{
			$datos['producto'] = $row_producto;
			$datos['pedido_producto_ingrediente'] = $this->Pedido_model->get_pedido_producto_ingrediente($row_producto['id_pedido_producto']);
		} 

		array_push($array_pedidos, $informacion);
	}

	$data['estados_pedidos'] = $this->Pedido_model->get_pedido_estados();

	$data['pedidos'] = $array_pedidos;

	$filtros['forma_entrega'] = $this->Pedido_model->get_forma_entrega();
	$filtros['productos'] = $this->Producto_model->get_items();
	$filtros['estados'] = $this->Pedido_model->get_pedido_estados();

	$filtros['texto_filtros'] = "<span class='label label-primary'>Pedidos de HOY</span>";

	$data['menu_pedidos'] = $this->load->view('administrador/menu_pedidos.php',$filtros, TRUE);
	
	if($vista == 'tabla')
		$this->load->view('administrador/pedidos_tabla.php',$data);
	else
		$this->load->view('administrador/pedidos.php',$data);
}

public function productos()
{
	$crud = new grocery_CRUD();
	$crud->set_language("spanish"); 
	$crud->set_theme('datatables');
	$crud->set_subject('Producto');
	$crud->unset_read();
	$crud->set_table('producto');
	$crud->where('producto.fecha_baja IS NULL');
	$crud->columns('id_producto','nombre','id_producto_tipo','precio','path_imagen');
	$crud->display_as('id_producto','Id')
		 ->display_as('descripcion','Descripcion del tipo de plato')
		 ->display_as('path_imagen','Imagen')
		 ->display_as('id_producto_tipo','Tipo de producto');

	$crud->unset_texteditor(array('descripcion','full_text'));
	$crud->add_action('Grupo de ingredientes',   base_url().'assets/grocery_crud/themes/flexigrid/css/images/grupo_ingredientes.png', 'Administrador/ver_grupos_producto');
	
	$state_info = $crud->getStateInfo();
	$state = $crud->getState();

	if($state == "edit")
	{
		$primary_key = $state_info->primary_key;
		$crud->field_type('id_producto','hidden');
	}
 	
	$crud->field_type('fecha_alta', 'hidden');
	$crud->field_type('fecha_modificacion', 'hidden');
	$crud->field_type('fecha_baja', 'hidden');

	$crud->set_relation('id_producto_tipo','producto_tipo','descripcion', "fecha_baja IS NULL" );

	$crud->required_fields('id_producto_tipo' , 'nombre' , 'precio');

	$crud->set_field_upload('path_imagen','assets/images/productos');

	$crud->callback_delete(array($this,'delete_producto'));

	$output = $crud->render();

	$this->_example_output($output);
}

public function grupo_ingregientes()
{
	$crud = new grocery_CRUD();
	$crud->set_theme('datatables');
	$crud->set_table('grupo');
	$crud->columns('id_grupo','nombre','cantidad_default','cantidad_minima'	,'cantidad_maxima','precio_adicional' );
	$crud->display_as('id_grupo','Id') 
	     ->display_as('cantidad_minima','Cantidad mínima')
	     ->display_as('precio_adicional','Precio por adicional')
	     ->display_as('cantidad_maxima','Cantidad máxima');
	$crud->unset_delete();
	$crud->set_language("spanish"); 
	$crud->required_fields('nombre');

	$crud->add_action('Ingredientes del grupo',   base_url().'assets/grocery_crud/themes/flexigrid/css/images/ingredientes.png', 'Administrador/ver_agregar_ingrediente_grupo');

	if($crud->getState() == 'add' OR $crud->getState() == 'edit')
    {
        //Do your cool stuff here . You don't need any State info you are in add
      	$crud->field_type('usar_precio_ingrediente', 'hidden');
        $crud->field_type('fecha_alta', 'hidden');
        $crud->field_type('fecha_modificacion', 'hidden');
        $crud->field_type('fecha_baja', 'hidden');

    }
    
    $crud->unset_read();

	$output = $crud->render();

	$this->_example_output($output);
}


public function ingredientes()
{
	$crud = new grocery_CRUD();
	$crud->set_table('ingrediente'); 
	$crud->set_theme('datatables');
	$crud->where('fecha_baja IS NULL');
	
	$crud->columns('id_ingrediente','nombre','precio', 'path_imagen'	);
	$crud->display_as('id_ingrediente','Id') 
		 ->display_as('descripcion','Descripcion del tipo')
		 ->display_as('path_imagen','Imagen');
 
	$crud->set_language("spanish"); 
	$crud->required_fields('descripcion');
	
	$crud->callback_delete(array($this,'delete_ingrediente'));

	$crud->set_field_upload('path_imagen','assets/images/productos'); 

	if($crud->getState() == 'add' OR $crud->getState() == 'edit')
    { 
      	$crud->field_type('calorias', 'hidden');
        $crud->field_type('fecha_alta', 'hidden');
        $crud->field_type('fecha_modificacion', 'hidden');
        $crud->field_type('fecha_baja', 'hidden');
    }

    $crud->unset_read();
	$output = $crud->render();

	$this->_example_output($output);
}

/*
public function producto_dia()
{
	$crud = new grocery_CRUD();
	$crud->set_language("spanish"); 
	$crud->set_theme('datatables');
	$crud->set_table('producto_dia');
	$crud->set_relation('id_producto','producto','{nombre}'.'- '.'{path_imagen}'); 
	$crud->display_as('id_producto', 'Plato del dia' );
	
	$crud->set_field_upload('path_imagen','assets/images/productos');

	$crud->required_fields('id_producto');

	$output = $crud->render();

	$this->_example_output($output);
}*/

public function producto_dia()
{
	$crud = new grocery_CRUD();
	$crud->set_theme('datatables');
	$crud->set_language("spanish");
	$crud->set_table('producto_dia');
	$crud->columns('id_producto','precio', 'path_imagen'	);

	$crud->set_relation('id_producto','producto','nombre'); 

	$crud->set_model('my_custom_model');

	if($crud->getState() == "list")
	{
		$this->my_custom_model->join_where_solicitud_web_administrador();
		$crud->callback_column('path_imagen',array($this,'_callback_webpage_url'));
	}

	$crud->display_as('path_imagen', 'Imagen' )
		 ->display_as('id_producto', 'Plato del dia' );

	$crud->set_field_upload('path_imagen','assets/images/');

	$crud->unset_read();

	$output = $crud->render();

	$this->_example_output($output); 
}


public function tipos_productos()
{
	$crud = new grocery_CRUD();
	$crud->set_theme('datatables');
	$crud->set_table('producto_tipo');

	$crud->where('producto_tipo.fecha_baja IS NULL');

	$crud->columns('id_producto_tipo','descripcion','path_imagen');
	$crud->display_as('id_producto_tipo','Id')
			->display_as('path_imagen','Imagen')
		 	->display_as('descripcion','Descripcion del tipo');
	 
	$crud->set_language("spanish"); 
	$crud->required_fields('descripcion');

	$crud->set_field_upload('path_imagen','assets/images');
	
	// Deshabilitar agregar y editar
	$crud->unset_read();
	$crud->callback_delete(array($this,'delete_tipo_producto'));
	

	if($crud->getState() == 'add' OR $crud->getState() == 'edit')
    { 
      	$crud->unset_fields('fecha_alta', 'fecha_modificacion','fecha_baja'); 
    }

    $output = $crud->render();

	$this->_example_output($output);
}



public function usuarios_invitados()
{
	$crud = new grocery_CRUD();
	$crud->set_theme('datatables');
	$crud->set_table('usuario');
	$crud->set_language("spanish");
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
	$crud->set_theme('datatables');
	$crud->set_language("spanish");
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



public function tipos_ingredientes()
{
	$crud = new grocery_CRUD();
	$crud->set_theme('datatables');
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
	
	$filtros['opciones_busqueda'] = $this->input->post();
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
 

	$fecha_desde = date('Y-m-d', strtotime( '-20 days' ));
	$fecha_hasta = date('Y-m-d', strtotime( '+1 days' ));

	$data['texto_filtros'] = "<span class='label label-primary'> HOY :  ".$fecha_desde." al  ".$fecha_hasta."</span> &nbsp;";

	$data['estadisticas_productos'] = $this->Estadisticas_model->get_cantidad_productos( $fecha_desde, $fecha_hasta );

	$data['estadisticas_email'] = $this->Estadisticas_model->get_cantidad_email( $fecha_desde, $fecha_hasta);
	$data['cantidad_pedidos'] = $this->Estadisticas_model->get_cantidad_pedidos( $fecha_desde, $fecha_hasta);
	$data['estadisticas_forma_entrega'] = $this->Estadisticas_model->get_cantidad_forma_entrega( $fecha_desde, $fecha_hasta);
	$data['estadisticas_forma_pago'] = $this->Estadisticas_model->get_cantidad_forma_pago( $fecha_desde, $fecha_hasta);
	$data['estadisticas_estados'] = $this->Estadisticas_model->get_cantidad_estado( $fecha_desde, $fecha_hasta);

	$this->load->view('administrador/estadisticas.php',$data);
}

public function buscar_estaditicas()
{	
	chrome_log("buscar_estaditicas");

	if ($this->form_validation->run('buscar_estaditicas') == FALSE):

		chrome_log("No paso validacion");
		$return["resultado"] = FALSE;
		$return["mensaje"] = validation_errors(); 
		
	else: 

		chrome_log("Paso validacion");
		$data['mensaje'] = $this->session->flashdata('mensaje');
		$output = (object)array('output' => '' , 'js_files' => array() , 'css_files' => array());
		$output->titulo = traer_titulo($this->uri->segment(2));
		$this->load->view('administrador/index.php',(array)$output);

		$fecha_desde = $this->input->post('fecha_desde');
		$fecha_hasta = $this->input->post('fecha_hasta');

		$data['texto_filtros'] = "<span class='label label-primary'> ".$fecha_desde." al  ".$fecha_hasta."</span> &nbsp;";

		$data['estadisticas_productos'] = $this->Estadisticas_model->get_cantidad_productos( $fecha_desde, $fecha_hasta );

		$data['estadisticas_email'] = $this->Estadisticas_model->get_cantidad_email( $fecha_desde, $fecha_hasta);
		$data['cantidad_pedidos'] = $this->Estadisticas_model->get_cantidad_pedidos( $fecha_desde, $fecha_hasta);
		$data['estadisticas_forma_entrega'] = $this->Estadisticas_model->get_cantidad_forma_entrega( $fecha_desde, $fecha_hasta);
		$data['estadisticas_forma_pago'] = $this->Estadisticas_model->get_cantidad_forma_pago( $fecha_desde, $fecha_hasta);
		$data['estadisticas_estados'] = $this->Estadisticas_model->get_cantidad_estado( $fecha_desde, $fecha_hasta);
		
		$this->load->view('administrador/estadisticas.php',$data);

	endif;
}

public function f_agregar_textarea()
{

    return '<textarea name="address" rows="15"></textarea>';
}

public function ver_grupos_producto()
{
 	$datos['mensaje'] = $this->session->flashdata('mensaje');
	$output = (object)array('output' => '' , 'js_files' => array() , 'css_files' => array());
	$output->titulo = traer_titulo($this->uri->segment(2));
	$this->load->view('administrador/index.php',(array)$output);

	$id_producto = $this->uri->segment(3);

	//[REVISAR] Esta funcion tiene que ser del PRODUCTO MODEL: get_informacion_producto
	$datos['producto_info'] = $this->Administrador_model->traer_informacion_producto($id_producto);
	//$datos['grupos_producto'] = $this->Producto_model->get_grupos_producto($id_producto);

	//var_dump($datos['producto_info']);

	$grupos_producto = $this->Producto_model->get_grupos_producto($id_producto);

	//var_dump($grupos_producto);

	$array_grupos = array();

	foreach ($grupos_producto as $row) 
	{
		$grupo['informacion_grupo']	= $row;
		$grupo['ingredientes_grupo'] = $this->Producto_model->get_ingredientes_grupo_producto($id_producto,$row['id_grupo']);
		//echo '<pre>'; print_r($grupo['ingredientes_grupo']); echo '</pre>';
 
		array_push($array_grupos, $grupo);
	}

	$datos['grupos_ingredientes'] = $array_grupos;

	$this->load->view('administrador/ver_grupos_producto.php',$datos); 
 
}

public function ver_agregar_ingrediente_grupo()
{
 	$datos['mensaje'] = $this->session->flashdata('mensaje');
	$output = (object)array('output' => '' , 'js_files' => array() , 'css_files' => array());
	$output->titulo = traer_titulo($this->uri->segment(2));

	$this->load->view('administrador/index.php',(array)$output);

	$id_grupo = $this->uri->segment(3);

	$datos['grupo_informacion'] = $this->Grupo_model->get_informacion_grupo($id_grupo);
	$datos['grupo_ingredientes'] = $this->Grupo_model->get_ingredientes_grupo($id_grupo);

	$this->load->view('administrador/ver_agregar_ingredientes_grupo.php',$datos); 
 
}

// GRUPOS 
public function agregar_ingrediente_grupo()
{
	chrome_log("Administrador/agregar_ingrediente_grupo");
 
	if ($this->form_validation->run('agregar_ingrediente_grupo') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.'); 

	else: 
	 
		chrome_log("Paso validacion");

		//	print_r($this->input->post());
 
		$query = $this->Grupo_model->set_ingrediente_grupo( $this->input->post() );

		if ( $query ):   // Si se creo el token, se envia el email
		 
			chrome_log("Pudo agrego el ingrediente al producto");
 			 
			$this->session->set_flashdata('mensaje', 'Se le ha agregado el ingrediente exitosamente ');
		 				 
		else: 

 			$this->session->set_flashdata('mensaje', 'Ha ocurrido un error, por favor, intentá mas tarde.');

		endif;  
 
	endif; 

	redirect('Administrador/ver_agregar_ingrediente_grupo/'.$this->input->post('id_grupo'),'refresh');
}

public function eliminar_ingrediente_grupo()
{	
	if ($this->form_validation->run('eliminar_ingrediente_grupo') == FALSE):

		$this->session->set_flashdata('mensaje', 'Error, no paso validacion ');
		chrome_log("No paso validacion");
		$return["error"] = TRUE;

	else:

		chrome_log("Paso validacion");

		if( $this->Grupo_model->eliminar_ingrediente_grupo( $this->input->post()) ):

 			$this->session->set_flashdata('mensaje', 'Se le ha eliminado el ingrediente exitosamente ');
			$return["error"] = FALSE;

		else:

			$this->session->set_flashdata('mensaje', 'Error, no se le ha eliminado el ingrediente.');
			$return["error"] = TRUE;

		endif;
		 

	endif;		

	print json_encode($return);	 
}
 
public function ajax_eliminar_grupo_producto()
{	
	if ($this->form_validation->run('eliminar_grupo_producto') == FALSE):

		chrome_log("No paso validacion");
		$return["error"] = TRUE;
		$return["mensaje"] = 'Error, no paso validacion ';

	else:

		chrome_log("Paso validacion");

		if( $this->Grupo_model->eliminar_grupo_producto( $this->input->post()) ):

 			$return["mensaje"] = 'Se le ha eliminado el grupo exitosamente ';
			$return["error"] = FALSE;

		else:

			$return["mensaje"] = 'Error, no se le ha eliminado el grupo.';
			$return["error"] = TRUE;

		endif;
		 

	endif;		

	print json_encode($return);	 
}
 

public function agregar_grupo_producto()
{
	chrome_log("Administrador/agregar_grupo_producto: ".$this->input->post('id_producto'));

	$this->form_validation->set_message('existe_grupo_producto', 'Ya existe el grupo en el grupo');
 
	if ($this->form_validation->run('agregar_grupo_producto') == FALSE):
 
		chrome_log("No paso validacion o ya existe el grupo en el producto");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.'); 

	else: 
	 
		chrome_log("Paso validacion"); 
 
		$query = $this->Producto_model->set_grupo_producto( $this->input->post() );

		if ( $query ):  
		 
			chrome_log("Pudo agrego el ingrediente al producto");
 			 
			$this->session->set_flashdata('mensaje', 'Se ha agregado el grupo exitosamente ');
		 				 
		else: 

 			$this->session->set_flashdata('mensaje', 'Ha ocurrido un error, por favor, intentá mas tarde.');

		endif;  
 
	endif; 
	
	redirect('Administrador/ver_grupos_producto/'.$this->input->post('id_producto'),'refresh');
}

public function eliminar_grupo_producto()
{
	chrome_log("Administrador/eliminar_grupo_producto");
 
	if ($this->form_validation->run('eliminar_grupo_producto') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.'); 
		$return["error"] = TRUE;

	else: 
	 
		chrome_log("Paso validacion"); 
 
		$query = $this->Producto_model->delete_grupo_producto( $this->input->post() );

		if ( $query ):  
		 
			chrome_log("Pudo elimino el grupo del producto");
			$this->session->set_flashdata('mensaje', 'Se ha eliminado el grupo exitosamente ');
			$return["error"] = FALSE;
		 				 
		else: 

 			$this->session->set_flashdata('mensaje', 'Ha ocurrido un error, por favor, intentá mas tarde.');
 			$return["error"] = TRUE;

		endif;  
 
	endif; 

	print json_encode($return);	
}

/*
public function configuracion_ingrediente_producto()
{
	chrome_log("configuracion_ingrediente_producto: ".$this->input->post("id_producto")." - ".$this->input->post("id_grupo")." - ".$this->input->post("id_ingrediente")); 
 
	if ($this->form_validation->run('configuracion_ingrediente_producto') == FALSE):
		
 
		chrome_log("No paso validacion  ");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.'); 
		$return["error"] = TRUE;

	else: 
	 
		chrome_log("Paso validacion"); 
 
		$query = $this->Producto_model->configuracion_ingrediente_producto( $this->input->post() );

		if ( $query ):  
		 
			chrome_log("Pudo configurar el ingrediente al producto grupo");
 			$return["error"] = FALSE; 
			$this->session->set_flashdata('mensaje', 'Se ha configurado el ingrediente del grupo ');
		 				 
		else: 

 			$this->session->set_flashdata('mensaje', 'Ha ocurrido un error, por favor, intentá mas tarde.');
 			$return["error"] = TRUE;

		endif;  
 
	endif; 

	print json_encode($return);	
	//redirect('Administrador/ver_grupos_producto/'.$this->input->post('id_producto'),'refresh'); 
}*/

public function set_producto_grupo_ingrediente()
{ 
	chrome_log("set_producto_grupo_ingrediente");
 
	if ($this->form_validation->run('set_producto_grupo_ingrediente') == FALSE):
		
		chrome_log("No paso validacion  ");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.'); 
		$return["error"] = TRUE;

	else: 
	 
		chrome_log("Paso validacion"); 
 		
 		 
		$query = $this->Producto_model->set_producto_grupo_ingrediente( $this->input->post() );
		
		if ( $query ):  
		 
			chrome_log("Cambio exitoso");
 			$return["error"] = FALSE;  
		 				 
		else: 
 
 			$return["error"] = TRUE;

		endif;   
 
	endif; 

	print json_encode($return);	 
}


public function delete_producto($primary_key)
{

	return $this->db->update('producto',array('fecha_baja' => date('Y-m-d H:i:s') ),array('id_producto' => $primary_key));
}

public function delete_tipo_producto($primary_key)
{

	return $this->db->update('producto_tipo',array('fecha_baja' => date('Y-m-d H:i:s') ),array('id_producto_tipo' => $primary_key));
}


public function delete_ingrediente($primary_key)
{
	return $this->db->update('ingrediente',array('fecha_baja' => date('Y-m-d H:i:s') ),array('id_ingrediente' => $primary_key));
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

	$buscar = $this->input->post('term');
	$id_grupo = $this->input->post('id_grupo');

	if( isset($buscar) && strlen($buscar) > 1 )
	{
		$query=$this->db->query("   SELECT *
									FROM	ingrediente i
									WHERE 	i.nombre like '%$buscar%'
									AND i.fecha_baja IS NULL
									AND i.id_ingrediente NOT IN ( 
																SELECT gi.id_ingrediente
																FROM  grupo_ingrediente gi
																WHERE gi.id_grupo = $id_grupo
																)
									ORDER BY i.nombre"
								);

		
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{	
 				$variable = "<img style='width:100px' src='".base_url()."/assets/images/productos/".$row->path_imagen."'> ".$row->nombre;

				$result[]= array( 	"id_ingrediente" => $row->id_ingrediente, 
									"value" => $variable,
									"nombre" => $row->nombre
								);

			 
			}
		} 
		
		echo json_encode($result);
	}
}
 

/*
public function ajax_ingrediente()
{
	chrome_log("ajax_ingrediente:2 " );

	$buscar = $this->input->post('term'); 

	if( isset($buscar) && strlen($buscar) > 1 )
	{
		$query=$this->db->query("   SELECT *
									FROM	ingrediente i
									WHERE 	i.nombre like '%$buscar%'
									AND i.fecha_baja IS NULL 
									ORDER BY i.nombre"
								);

		chrome_log("aaa" );
		
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{	
 				$variable = "<img style='width:100px' src='".base_url()."/assets/images/productos/".$row->path_imagen."'> ".$row->nombre;

				$result[]= array( 	"id_ingrediente" => $row->id_ingrediente, 
									"value" => $variable,
									"nombre" => $row->nombre
								);

			 
			}
		} 
		
		echo json_encode($result);
	}
}*/ 

public function ajax_grupo()
{
	chrome_log("ajax_grupos: ".$this->input->post('term') );


	$buscar = $this->input->post('term');
	$id_producto = $this->input->post('id_producto');

	if( isset($buscar) && strlen($buscar) > 1 )
	{
		$query=$this->db->query("   SELECT *
									FROM	grupo g
									WHERE 	g.nombre like '%$buscar%'
									AND 	g.id_grupo NOT IN ( 	SELECT pg.id_grupo 
																	FROM producto_grupo pg
																	WHERE pg.id_producto = $id_producto )
									ORDER BY g.nombre"
								);

		
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{	
 

				$result[]= array( 	"id_grupo" => $row->id_grupo, 
									"value" => $row->nombre 
								);

			 
			}
		}
		
		echo json_encode($result);
	}
}
 

public function existe_grupo_producto($id_producto=null, $id_grupo=null)
{
	chrome_log("callback_existe_grupo_producto: ".$this->input->post('id_producto')." - ".$this->input->post('id_grupo'));
 
	if ( $this->Producto_model->existe_grupo_producto( $this->input->post('id_producto'), $this->input->post('id_grupo')) ):  
	 
		return false;
	else: 

		return true;

	endif;  	
}

public function _callback_webpage_url($value, $row)
{	
	return "<a href='http://localhost/lemonclub/assets/images/productos/".$value."' class='image-thumbnail'><img src='http://localhost/lemonclub/assets/images/productos/".$value."' height='50px'></a>";


	//return "<img class='thumbnail'  src='".base_url()."assets/images/productos/".."'>";
}


}