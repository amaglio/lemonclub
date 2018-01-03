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

	$html = '<h1>HTML Example</h1>
Some special characters: &lt; € &euro; &#8364; &amp; è &egrave; &copy; &gt; \\slash \\\\double-slash \\\\\\triple-slash
<h2>List</h2>
List example:
<ol>
    <li><img src="images/logo_example.png" alt="test alt attribute" width="30" height="30" border="0" /> test image</li>
    <li><b>bold text</b></li>
    <li><i>italic text</i></li>
    <li><u>underlined text</u></li>
    <li><b>b<i>bi<u>biu</u>bi</i>b</b></li>
    <li><a href="http://www.tecnick.com" dir="ltr">link to http://www.tecnick.com</a></li>
    <li>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.<br />Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</li>
    <li>SUBLIST
        <ol>
            <li>row one
                <ul>
                    <li>sublist</li>
                </ul>
            </li>
            <li>row two</li>
        </ol>
    </li>
    <li><b>T</b>E<i>S</i><u>T</u> <del>line through</del></li>
    <li><font size="+3">font + 3</font></li>
    <li><small>small text</small> normal <small>small text</small> normal <sub>subscript</sub> normal <sup>superscript</sup> normal</li>
</ol>
<dl>
    <dt>Coffee</dt>
    <dd>Black hot drink</dd>
    <dt>Milk</dt>
    <dd>White cold drink</dd>
</dl>
<div style="text-align:center">IMAGES<br />
 
</div>';

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
 

}
