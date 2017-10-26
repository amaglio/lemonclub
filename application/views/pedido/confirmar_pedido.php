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
					<form class="form-horizontal" action="<?=site_url('pedido/comprar')?>" method="POST">
						<div class="form-group">
						    <div class="col-sm-12">
						    	<input type="email" class="form-control" id="mail" name="mail" placeholder="Email" value="<?php echo set_value('mail'); ?>">
						    </div>
						</div>
						<div class="form-group">
						    <div class="col-sm-6">
						    	<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo set_value('nombre'); ?>">
						    </div>
						    <div class="col-sm-6">
						    	<input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido" value="<?php echo set_value('apellido'); ?>">
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
						    	<input type="text" class="form-control" id="calle" name="calle" placeholder="Calle" value="<?php echo set_value('calle'); ?>">
						    </div>
						    <div class="col-sm-6">
						    	<input type="text" class="form-control" id="altura" name="altura" placeholder="Altura" value="<?php echo set_value('altura'); ?>">
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

				<?php echo validation_errors(); ?>
				<?php
				if($error)
				{
					echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.$error.'</div>';
				}
				if($success)
				{
					echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.$success.'</div>';
				}
				?>

				<div class="seguir"><a href="<?=site_url('menu')?>" class="btn btn-default btn-block">SEGUIR COMPRANDO</a></div>
			</div>

			<div class="col-xs-12 col-sm-3">
				<div class="titulo">DETALLE DE COMPRA</div>
				<div class="formulario">
					<?php
					foreach ($this->cart->contents() as $item)
					{
						echo '<div class="row item">
								<div class="col-xs-3 area-imagen"><img src="'.base_url('assets/images/productos/ensalada1.jpg').'" class="img-responsive"></div>
								<div class="col-xs-9 area-texto">'.$item['name'].' x'.$item['qty'].'</div>
							</div>';
					}
					?>
				</div>
				<div class="total">
					<div class="row">
					<div class="col-xs-6">Total</div>
					<div class="col-xs-6">$<?php echo $this->cart->format_number($this->cart->total()); ?></div>
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