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

	$crud->add_action('Grupo de ingredientes',   base_url().'assets/grocery_crud/themes/flexigrid/css/images/grupo_ingredientes.png', 'Administrador/ver_grupos_producto');

	
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

public function grupo_ingregientes()
{
	$crud = new grocery_CRUD();

	$crud->set_table('grupo');
	$crud->columns('id_grupo','nombre','cantidad_default','cantidad_minima'	,'cantidad_maxima','precio_adicional' );
	$crud->display_as('id_grupo','Id');
	$crud->unset_delete();
	$crud->set_language("spanish"); 
	$crud->required_fields('nombre');

	$crud->add_action('Ingredientes del grupo',   base_url().'assets/grocery_crud/themes/flexigrid/css/images/ingredientes.png', 'Administrador/ver_agregar_ingrediente_grupo');

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

	$datos['producto_info'] = $this->Administrador_model->traer_informacion_producto($id_producto);
	//$datos['grupos_producto'] = $this->Producto_model->get_grupos_producto($id_producto);

	$grupos_producto = $this->Producto_model->get_grupos_producto($id_producto);

	$array_grupos = array();

	foreach ($grupos_producto as $row) 
	{
		$grupo['informacion_grupo']	= $row;
		$grupo['ingredientes_grupo'] = $this->Producto_model->get_ingredientes_grupo_producto($id_producto,$row['id_grupo']);

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

	$id_gripo = $this->uri->segment(3);

	$datos['grupo_informacion'] = $this->Grupo_model->get_informacion_grupo($id_gripo);
	$datos['grupo_ingredientes'] = $this->Grupo_model->get_ingredientes_grupo($id_gripo);

	$this->load->view('administrador/ver_agregar_ingredientes_grupo.php',$datos); 

	/*

	$output = (object)array('output' => '' , 'js_files' => array() , 'css_files' => array());
	$output->titulo = "Disponible en la <b>  etapa 2 <b>";
	$this->load->view('administrador/index.php',(array)$output);*/
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

// PRODUCTO - GRUPOS 

public function agregar_grupo_producto()
{
	chrome_log("Administrador/agregar_grupo_producto");
 
	if ($this->form_validation->run('agregar_grupo_producto') == FALSE):

		chrome_log("No paso validacion");
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
 
public function ajax_grupo()
{
	chrome_log("ajax_grupos: " );

	$buscar = $this->input->get('term');

	if( isset($buscar) && strlen($buscar) > 1 )
	{
		$query=$this->db->query("   SELECT *
									FROM	grupo g
									WHERE 	g.nombre like '%$buscar%'
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
 


}