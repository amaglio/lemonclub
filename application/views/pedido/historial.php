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

				<div class="titulo"><i class="fa fa-shopping-cart fa-lg"></i> &nbsp;<span id="cant_items_carrito"><?php echo $cantidad; ?></span> PEDIDOS</div>
				<div class="table">
					<div class="hidden-xs">
						<div class="col-xs-12 col-sm-4 th" style="background:#CCC;">FECHA</div>
						<div class="col-xs-12 col-sm-4 th" style="background:#CCC;">PRODUCTOS</div>
						<div class="col-xs-12 col-sm-2 th" style="background:#CCC;">PRECIO</div>
						<div class="col-xs-12 col-sm-2 th" style="background:#CCC;">CANTIDAD</div>
						<div style="clear:both;"></div>
					</div>
					<?php
					if($pedidos)
					{
						foreach ($pedidos as $key => $pedido)
						{
							$subtotal = 0;
							$subcantidad = 0;
							echo '<div class="row" id="item_'.$pedido['id_pedido'].'" style="padding:10px;">';
								echo '<div class="col-xs-12 col-sm-4">'.substr($pedido['fecha_pedido'],0,10).'</div>';
								echo '<div class="col-xs-12 col-sm-4">';
									foreach ($pedido['items'] as $key => $item)
									{
										echo '<span class="title">'.$item['nombre'].'</span><br>';
										$subtotal += $item['precio_unitario'];
										$subcantidad += $item['cantidad'];
									}
								echo '</div>';
								echo '<div class="col-xs-12 col-sm-2 precio">$'.$this->cart->format_number($subtotal).'</div>';
								echo '<div class="col-xs-12 col-sm-2 cantidad">'.$subcantidad.'</div>';
							echo '</div>';
						}
					}
					else
					{
						echo '<div class="row item" id="item">
									<div class="col-xs-12">
									Todavia no hiciste ningún pedido.
									</div>
								</div>';
					}
					?>
				</div>
				
				<div class="row">
					<div class="col-xs-12 col-sm-3 col-sm-push-9" style="text-align:right">
					</div>
					<div class="col-xs-12 col-sm-3 col-sm-pull-3" style="text-align:left">
						<a href="<?=site_url('menu')?>" class="btn btn-default btn-block">SEGUIR COMPRANDO</a>
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