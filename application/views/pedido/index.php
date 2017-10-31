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
				<div class="titulo"><i class="fa fa-shopping-cart fa-lg"></i> &nbsp; CARRITO (<?php echo $this->cart->total_items(); ?> ITEMS)</div>
				<div class="table">
					<div class="row hidden-xs">
						<div class="col-xs-2 th"></div>
						<div class="col-xs-6 th">PRODUCTO</div>
						<div class="col-xs-2 th">PRECIO</div>
						<div class="col-xs-2 th">CANTIDAD</div>
					</div>
					<?php
					foreach ($this->cart->contents() as $item)
					{
						echo '<div class="row item">
								<div class="col-xs-12 col-sm-2"><img src="'.base_url('assets/images/productos/ensalada1.jpg').'" class="img-responsive"></div>
								<div class="col-xs-12 col-sm-6">
									<span class="title">'.$item['name'].'</span><br>
									<span class="descripcion">'.$item['descripcion'].'</span>
								</div>
								<div class="col-xs-12 col-sm-2 precio">$'.$this->cart->format_number($item['price']).'</div>
								<div class="col-xs-12 col-sm-2 cantidad"><input type="number" min="1" step="1" name="cantidad[]" id="cant_'.$item['rowid'].'" value="'.$item['qty'].'"  onchange="modificar_cantidad(\''.$item['rowid'].'\', this.value);" class="form-control"></div>
							</div>';
					}
					?>
				</div>
				<div class="col-xs-12 col-sm-4 col-sm-offset-8 total">
					<div class="col-xs-6">Total</div>
					<div class="col-xs-6" id="total">$<?php echo $this->cart->format_number($this->cart->total()); ?></div>
				</div>
				<div class="row hidden-xs">
					<div class="col-xs-12 col-sm-6" style="text-align:left"><a href="<?=site_url('menu')?>" class="btn btn-default btn-mas-padding">SEGUIR COMPRANDO</a></div>
					<div class="col-xs-12 col-sm-6" style="text-align:right"><a href="<?=site_url('pedido/confirmar_pedido')?>" class="btn btn-amarillo btn-mas-padding">COMPRAR</a></div>
				</div>
				<div class="row visible-xs">
					<div class="col-xs-12" style="text-align:right"><a href="<?=site_url('pedido/confirmar_pedido')?>" class="btn btn-amarillo btn-block">COMPRAR</a></div>
					<div class="col-xs-12" style="text-align:left"><a href="<?=site_url('menu')?>" class="btn btn-default btn-block">SEGUIR COMPRANDO</a></div>
				</div>
			</div>
		</div>
	</div>

<?php
$this->load->view('templates/footer');
?>

<script type="text/javascript">
function modificar_cantidad(rowid, qty)
{
	if(qty > 0)
	{
		var data = {rowid:rowid, qty:qty};
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
		        	$('#total').html(data.total);
		          	$('#cant_'+rowid).notify(data.data, { className:'success', position:"top" });
		        }
		        else
		        {
		        	$('#cant_'+rowid).notify(data.data, { className:'error', position:"top" });
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
</script>

</body>
</html>