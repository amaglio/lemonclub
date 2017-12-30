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
				<p>PEDIDO CONFIRMADO</p>
			</div>
		</div>
	</div>

	<div class="container confirmar">
		<div class="row">
			<div class="col-xs-12 col-sm-3">
				<img src="<?=base_url('assets/images/success.png')?>" class="img-responsive" style="margin:auto;">
			</div>
			<div class="col-xs-12 col-sm-9">
				<p style="font-size:20px; text-align:center; padding: 30px;">
				Su pedido fue enviado exitosamente.<br>
				Gracias por confiar en Lemon Club!
				</p>
				<div class="seguir"><a href="<?=site_url('menu')?>" class="btn btn-default btn-block">SEGUIR COMPRANDO</a></div>
			</div>
		</div>
	</div>

<?php
$this->load->view('templates/footer');
?>

</body>
</html>