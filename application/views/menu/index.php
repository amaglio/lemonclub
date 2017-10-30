<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<?php
$this->load->view('templates/head');
?>

<body>
	<?php
	$this->load->view('templates/header');
	?>

	<div class="container-fluid area-banner">
		<div class="row" >
			<div class="col-xs-12">
				<?php
				$posicion_espacio = strpos($tipo_actual['descripcion'], ' ');
				if($posicion_espacio)
				{
					echo '<p>'.substr($tipo_actual['descripcion'], 0, $posicion_espacio).'</p>';
					echo '<h3>'.substr($tipo_actual['descripcion'], $posicion_espacio).'</h3>';
				}
				else
				{
					echo '<p>'.$tipo_actual['descripcion'].'</p>';
				}
				?>
			</div>
		</div>
	</div>

	<div class="container-fluid area-menu">
		<div class="row">
			<div class="col-xs-12">
				<div class="menu">
					<?php
					foreach ($tipos as $key_tipo => $tipo)
					{
						$active = "";
						if($tipo_actual['id_producto_tipo'] == $tipo['id_producto_tipo'])
						{
							$active = "class='active'";
						}
						echo '<a href="'.site_url('menu/index/'.$tipo['id_producto_tipo']).'" '.$active.'>'.$tipo['descripcion'].'</a>';
					}
					?>
				</div>
			</div>
		</div>
	</div>

	<div class="container area-menu-items">
		<div class="row">
			<?php
			foreach ($productos as $key_prod => $producto)
			{
				echo '<div class="col-xs-12 col-sm-3 item">
						<div class="area-imagen"><img src="'.base_url('assets/images/productos/'.$producto['path_imagen']).'" class="img-responsive"></div>
						<div class="titulo">'.$producto['nombre'].'</div>
						<div class="descripcion">'.$producto['descripcion'].'</div>
						<div class="precio">$'.$producto['precio'].'</div>
						<button onclick="comprar('.$producto['id_producto'].');" id="btn_'.$producto['id_producto'].'" class="btn btn-amarillo btn-mas-padding">COMPRAR</button>
					</div>';
			}
			?>
		</div>
	</div>

<?php
$this->load->view('templates/footer');
?>
<script type="text/javascript">
function comprar(id)
{
	var data = {id:id};
    $.ajax({
      	url: SITE_URL+'/pedido/agregar_producto_ajax',
      	type: 'POST',
      	data: jQuery.param( data ),
      	cache: false,
      	dataType: 'json',
      	processData: false, // Don't process the files
      	//contentType: false, // Set content type to false as jQuery will tell the server its a query string request
      	success: function(data, textStatus, jqXHR)
      	{
        	if(data.error == false)
	        {
	          	$('#btn_'+id).notify(data.data, "success");
	        }
	        else
	        {
	        	$('#btn_'+id).notify(data.data, "error");
	        }
      	},
      	error: function(x, status, error)
      	{
      		$.notify("Ocurrio un error: " + status + " \nError: " + error, "error");
      	}
    });
}
</script>

</body>
</html>