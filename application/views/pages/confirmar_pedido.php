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
				<p>Confirmá</p>
				<h3>Tu pedido</h3>
			</div>
		</div>
	</div>

	<div class="container confirmar">
		<div class="row">
			<div class="col-xs-12 col-sm-7 col-sm-offset-1">
				<div class="titulo"><i class="fa fa-shopping-cart fa-lg"></i> &nbsp; CONFIRMAR PEDIDO</div>
				<div class="formulario">
					<form class="form-horizontal">
						<div class="form-group">
						    <div class="col-sm-12">
						    	<input type="email" class="form-control" id="mail" name="mail" placeholder="Email">
						    </div>
						</div>
						<div class="form-group">
						    <div class="col-sm-6">
						    	<input type="email" class="form-control" id="nombre" name="nombre" placeholder="Nombre">
						    </div>
						    <div class="col-sm-6">
						    	<input type="email" class="form-control" id="apellido" name="apellido" placeholder="Apellido">
						    </div>
						</div>
						<div class="radio">
						  <label>
						    <input type="radio" name="entrega" id="entrega1" value="envio">
						    Quiero que me lo envien
						  </label>
						</div>
						<div class="form-group">
						    <div class="col-sm-6">
						    	<input type="email" class="form-control" id="calle" name="calle" placeholder="Calle">
						    </div>
						    <div class="col-sm-6">
						    	<input type="email" class="form-control" id="altura" name="altura" placeholder="Altura">
						    </div>
						</div>
						<div class="radio">
						  <label>
						    <input type="radio" name="entrega" id="entrega2" value="retiro" checked>
						    Quiero pasarlo a buscar
						  </label>
						</div>
						<input type="submit" value="COMPRAR" name="comprar" class="btn btn-block btn-amarillo" style="margin-top:10px;">
					</form>
				</div>
				<div class="seguir"><a class="btn btn-default btn-block">SEGUIR COMPRANDO</a></div>
			</div>

			<div class="col-xs-12 col-sm-3">
				<div class="titulo">DETALLE DE COMPRA</div>
				<div class="formulario">
					<div class="row item">
						<div class="col-xs-3 area-imagen"><img src="<?=base_url('assets/images/productos/ensalada1.jpg')?>" class="img-responsive"></div>
						<div class="col-xs-9 area-texto">Quinoa Kanikama x1</div>
					</div>
					<div class="row item">
						<div class="col-xs-3 area-imagen"><img src="<?=base_url('assets/images/productos/ensalada1.jpg')?>" class="img-responsive"></div>
						<div class="col-xs-9 area-texto">Quinoa Kanikama x1</div>
					</div>
					<div class="row item">
						<div class="col-xs-3 area-imagen"><img src="<?=base_url('assets/images/productos/ensalada1.jpg')?>" class="img-responsive"></div>
						<div class="col-xs-9 area-texto">Quinoa Kanikama x1</div>
					</div>
				</div>
				<div class="total">
					<div class="row">
					<div class="col-xs-6">Total</div>
					<div class="col-xs-6">$172</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php
$this->load->view('templates/footer');
?>

</body>
</html>