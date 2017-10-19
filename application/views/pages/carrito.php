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
				<div class="titulo"><i class="fa fa-shopping-cart fa-lg"></i> &nbsp; CARRITO (3 ITEMS)</div>
				<div class="table">
					<div class="row hidden-xs">
						<div class="col-xs-2 th"></div>
						<div class="col-xs-6 th">PRODUCTO</div>
						<div class="col-xs-2 th">PRECIO</div>
						<div class="col-xs-2 th">CANTIDAD</div>
					</div>
					<div class="row item">
						<div class="col-xs-12 col-sm-2"><img src="<?=base_url('assets/images/productos/ensalada1.jpg')?>" class="img-responsive"></div>
						<div class="col-xs-12 col-sm-6">
							<span class="title">Quinoa Kanikama</span><br>
							<span class="descripcion">Mix verdes, Quinoa, cherry, huevo, zanahoria, choclo y kanikama</span>
						</div>
						<div class="col-xs-12 col-sm-2 precio">$86</div>
						<div class="col-xs-12 col-sm-2 cantidad"><input type="number" name="cantidad[]" value="1" class="form-control"></div>
					</div>
					<div class="row item">
						<div class="col-xs-12 col-sm-2"><img src="<?=base_url('assets/images/productos/ensalada1.jpg')?>" class="img-responsive"></div>
						<div class="col-xs-12 col-sm-6">
							<span class="title">Quinoa Kanikama</span><br>
							<span class="descripcion">Mix verdes, Quinoa, cherry, huevo, zanahoria, choclo y kanikama</span>
						</div>
						<div class="col-xs-12 col-sm-2 precio">$86</div>
						<div class="col-xs-12 col-sm-2 cantidad"><input type="number" name="cantidad[]" value="1" class="form-control"></div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-4 col-sm-offset-8 total">
					<div class="col-xs-6">Total</div>
					<div class="col-xs-6">$172</div>
				</div>
				<div class="row hidden-xs">
					<div class="col-xs-12 col-sm-6" style="text-align:left"><a href="<?=site_url('pages/menu')?>" class="btn btn-default btn-mas-padding">SEGUIR COMPRANDO</a></div>
					<div class="col-xs-12 col-sm-6" style="text-align:right"><a href="<?=site_url('pages/confirmar_pedido')?>" class="btn btn-amarillo btn-mas-padding">COMPRAR</a></div>
				</div>
				<div class="row visible-xs">
					<div class="col-xs-12" style="text-align:right"><a href="<?=site_url('pages/confirmar_pedido')?>" class="btn btn-amarillo btn-block">COMPRAR</a></div>
					<div class="col-xs-12" style="text-align:left"><a href="<?=site_url('pages/menu')?>" class="btn btn-default btn-block">SEGUIR COMPRANDO</a></div>
				</div>
			</div>
		</div>
	</div>

<?php
$this->load->view('templates/footer');
?>

</body>
</html>