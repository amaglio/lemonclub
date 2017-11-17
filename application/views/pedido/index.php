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
		<div class="row">
			<div class="col-xs-12">
			</div>
		</div>
	</div>

	<div class="container carrito">
		<div class="row">
			<div class="col-xs-12 col-sm-10 col-sm-offset-1">

				<div id="area-mensaje"></div>

				<div class="titulo"><i class="fa fa-shopping-cart fa-lg"></i> &nbsp; CARRITO (<?php echo $cantidad; ?> ITEMS)</div>
				<div class="table">
					<div class="row hidden-xs">
						<div class="col-xs-2 th"></div>
						<div class="col-xs-6 th">PRODUCTO</div>
						<div class="col-xs-2 th">PRECIO</div>
						<div class="col-xs-2 th">CANTIDAD</div>
					</div>
					<?php
					foreach ($items as $key => $item)
					{
						echo '<div class="row item" id="item_'.$item['id_producto'].'">
								<div class="col-xs-12 col-sm-2"><img src="'.base_url('assets/images/productos/'.$item['path_imagen']).'" class="img-responsive"></div>
								<div class="col-xs-12 col-sm-6">
									<span class="title">'.$item['nombre'].'</span><br>
									<span class="descripcion">'.$item['descripcion'].'</span>
								</div>
								<div class="col-xs-12 col-sm-2 precio">$'.$this->cart->format_number($item['precio']).'</div>
								<div class="col-xs-12 col-sm-2 cantidad">
									<input type="number" min="1" step="1" name="cantidad[]" id="cant_'.$item['id_producto'].'" value="'.$item['cantidad'].'"  onchange="modificar_cantidad(\''.$item['id_producto'].'\', this.value);" class="form-control pull-left">
									<button class="btn btn-danger" onclick="eliminar_producto('.$item['id_producto'].')"><i class="fa fa-times"></i></button>
									</div>
							</div>';
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
							if($items && count($items))
							{
								echo '<a href="'.site_url('pedido/confirmar_pedido').'" class="btn btn-amarillo btn-block">COMPRAR</a>';
							}
							else
							{
								echo '<a href="javascript: mensaje_no_items();" class="btn btn-amarillo btn-block">COMPRAR</a>';
							}
						?>
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