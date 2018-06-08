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

	<div class="container-fluid area-banner" style="background: url('<?=base_url("assets/images/fondos/carrito.jpg")?>'); background-size: cover; background-position: top;">
		<div class="row">
			<div class="col-xs-12">
			</div>
		</div>
	</div>

	<div class="container carrito">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">

				<div id="area-mensaje"></div>

				<div class="titulo">
					<i class="fa fa-shopping-cart fa-lg"></i> &nbsp; INGREDIENTES <span id="cant_items_carrito">(<?php echo $informacion_pedido_producto['cantidad']; ?>)</span>
				</div>
				<div class="table">
					<?php
					foreach ($informacion_producto as $key => $item)
					{
						echo '<div class="row item" style="background:#ccc; margin:0px;">
								<div class="col-xs-12 col-sm-2"><img src="'.base_url('assets/images/productos/'.$item['path_imagen']).'" class="img-responsive"></div>
								<div class="col-xs-12 col-sm-6">
									<span class="title">'.$item['nombre'].'</span><br>
									<span class="descripcion">'.$item['descripcion'].'</span>
								</div>
								<div class="col-xs-12 col-sm-2 precio">$'.$this->cart->format_number($item['precio']).'</div>
								<div class="col-xs-12 col-sm-2 cantidad">
									<input type="number" min="1" step="1" name="cantidad[]" value="'.$informacion_pedido_producto['cantidad'].'" class="form-control pull-left" disabled>
									</div>
							</div>';
					}
					
					echo '<div class="row hidden-xs">
							<div class="col-xs-2 th"></div>
							<div class="col-xs-6 th">INGREDIENTE</div>
							<div class="col-xs-2 th">PRECIO</div>
							<div class="col-xs-2 th">SELECCIONADO</div>
						</div>';
					for ( $i=0; $i < count( $grupos_producto); $i++ )
					{
						// Aca tenes toda la informacion para controlar el grupo
						$informacion_grupo = $grupos_producto[$i]['datos_grupo'];

						// Listamos los ingredientes y hacemos checkbox.
						foreach ($grupos_producto[$i]['ingredientes_grupo'] as $row)
						{
							// Hay que controlar si le ingrediente ya esta en el pedido para chequearlo.
							// hay que usar el array:  $informacion_ingredientes_pedido_producto.
							$dato['id_grupo'] = $row['id_grupo'];
							$dato['id_ingrediente'] = $row['id_ingrediente'];
							$json_dato = json_encode($dato);
							echo '<div class="row item" id="item_'.$row['id_ingrediente'].'">';
								echo '<div class="col-xs-12 col-sm-2">';
									echo '<img src="'.base_url('assets/images/productos/'.$row['path_imagen']).'" class="img-responsive">';
								echo '</div>';
								echo '<div class="col-xs-12 col-sm-6">';
									echo $row['nombre'];
								echo '</div>';
								echo '<div class="col-xs-12 col-sm-2">';
									echo $grupos_producto[$i]['datos_grupo']['precio_adicional'];
								echo '</div>';
								echo '<div class="col-xs-12 col-sm-2">';
									echo '<input type="checkbox" name="ingrediente[]" value="'.$json_dato.'" >';
								echo '</div>';
							echo '</div>';
						}
					}
					?>
				</div>
				<div class="col-xs-12 col-sm-4 col-sm-offset-8 total">
					<div class="col-xs-6">Total</div>
					<div class="col-xs-6" id="total">$<?php echo $total; ?></div>
				</div>
				
				<div class="row">
					<div class="col-xs-12 col-sm-3 col-sm-push-9" style="text-align:right">
						<?php
							echo '<a href="'.site_url('pedido/confirmar_pedido').'" class="btn btn-amarillo btn-block">GUARDAR</a>';
						?>
					</div>
					<div class="col-xs-12 col-sm-3 col-sm-pull-3" style="text-align:left">
						<a href="<?=site_url('pedido')?>" class="btn btn-default btn-block">CANCELAR</a>
					</div>
				</div>
				
			</div>
		</div>
	</div>

<?php
$this->load->view('templates/footer');
?>

<script type="text/javascript">
function modificar_cantidad(id, qty)
{
	if(qty > 0)
	{
		var data = {id_producto:id, qty:qty};
	    $.ajax({
	      	url: SITE_URL+'/pedido/modificar_cantidad_ajax',
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
		        	$('#total').html("$"+data.total);
		        	$('#cant_items_carrito_header').html("("+data.cantidad+")");
		        	$('#cant_items_carrito').html("("+data.cantidad+")");
		          	$('#cant_'+id).notify(data.data, { className:'success', position:"top" });
		        }
		        else
		        {
		        	$('#cant_'+id).notify(data.data, { className:'error', position:"top" });
		        }
	      	},
	      	error: function(x, status, error)
	      	{
	      		$.notify("Ocurrio un error: " + status + " \nError: " + error, "error");
	      	}
	    });
	}
	else
	{
		$.notify("La cantidad no puede ser menor que 1.", "warn");
	}
}

function eliminar_producto(id)
{
	var data = {id_producto:id};
    $.ajax({
      	url: SITE_URL+'/pedido/eliminar_producto_ajax',
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
	        	$('#total').html("$"+data.total);
	        	$('#cant_items_carrito_header').html("("+data.cantidad+")");
	        	$('#cant_items_carrito').html("("+data.cantidad+")");
	          	$('#item_'+id).remove();
	        }
	        else
	        {
	        	$('#cant_'+id).notify(data.data, { className:'error', position:"top" });
	        }
      	},
      	error: function(x, status, error)
      	{
      		$.notify("Ocurrio un error: " + status + " \nError: " + error, "error");
      	}
    });
}

function mensaje_no_items()
{
	$('#area-mensaje').html('<div id="no_items" class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>No hay items para comprar.</div>');
}
</script>

</body>
</html>