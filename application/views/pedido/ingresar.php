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
				<?php
				echo validation_errors();
				
				if($error)
				{
					echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.$error.'</div>';
				}
				if($success)
				{
					echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.$success.'</div>';
				}

				echo '<ul class="nav nav-tabs " role="tablist">';
					$active="";
					if($this->input->post('ingresar')==1 || $this->input->post('ingresar')=="")
					{
						$active = 'class="active"';
					}
				    echo '<li role="presentation" '.$active.'><a href="#ingresar" aria-controls="ingresar" role="tab" data-toggle="tab">Ingresar</a></li>';

				    $active="";
					if($this->input->post('ingresar')==2)
					{
						$active = 'class="active"';
					}
				    echo '<li role="presentation" '.$active.'><a href="#invitado" aria-controls="invitado" role="tab" data-toggle="tab">Invitado</a></li>';

				    $active="";
					if($this->input->post('ingresar')==3)
					{
						$active = 'class="active"';
					}
				    echo '<li role="presentation" '.$active.'><a href="#registro" aria-controls="registro" role="tab" data-toggle="tab">Registro</a></li>';
				echo '</ul>';
				?>

				<!-- Tab panes -->
				<div class="tab-content">
					<?php
					$active="";
					if($this->input->post('ingresar')==1 || $this->input->post('ingresar')=="")
					{
						$active = 'active';
					}
					?>
				    <div role="tabpanel" class="tab-pane <?php echo $active; ?>" id="ingresar">
				    	<div class="formulario">
				    		<p>Si ya estas registrado ingresa con tu email y contraseña.</p>
							<form class="form-horizontal" action="<?=site_url('pedido/ingresar')?>" method="POST">
								<div class="form-group">
								    <div class="col-sm-12">
								    	<input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo set_value('email'); ?>">
								    </div>
								</div>
								<div class="form-group">
								    <div class="col-sm-12">
								    	<input type="password" class="form-control" name="clave" placeholder="Contraseña" value="<?php echo set_value('clave'); ?>">
								    </div>
								</div>
								<button type="submit" value="1" name="ingresar" class="btn btn-block btn-amarillo" style="margin-top:10px;">INGRESAR</button>
							</form>
						</div>
				    </div>
				    <?php
					$active="";
					if($this->input->post('ingresar')==2)
					{
						$active = 'active';
					}
					?>
				    <div role="tabpanel" class="tab-pane <?php echo $active; ?>" id="invitado">
				    	<div class="formulario">
				    		<p>No necesitas registrarte, pero te enviaremos un email para validar tu correo.</p>
							<form class="form-horizontal" action="<?=site_url('pedido/ingresar')?>" method="POST">
								<div class="form-group">
								    <div class="col-sm-12">
								    	<input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo set_value('email'); ?>">
								    </div>
								</div>
								<button type="submit" value="2" name="ingresar" class="btn btn-block btn-amarillo" style="margin-top:10px;">INGRESAR</button>
							</form>
						</div>
				    </div>
				    <?php
					$active="";
					if($this->input->post('ingresar')==3)
					{
						$active = 'active';
					}
					?>
				    <div role="tabpanel" class="tab-pane <?php echo $active; ?>" id="registro">
				    	<div class="formulario">
				    		<p>Registrate para que sea más rapido y facil realizar futuros pedidos.</p>
							<form class="form-horizontal" action="<?=site_url('pedido/ingresar')?>" method="POST">
								<div class="form-group">
								    <div class="col-sm-6">
								    	<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo set_value('nombre'); ?>">
								    </div>
								    <div class="col-sm-6">
								    	<input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido" value="<?php echo set_value('apellido'); ?>">
								    </div>
								</div>
								<div class="form-group">
								    <div class="col-sm-12">
								    	<input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo set_value('email'); ?>">
								    </div>
								</div>
								<div class="form-group">
								    <div class="col-sm-6">
								    	<input type="password" class="form-control" name="clave" placeholder="Contraseña" value="<?php echo set_value('clave'); ?>">
								    </div>
								    <div class="col-sm-6">
								    	<input type="password" class="form-control" name="clave2" placeholder="Repetir Contraseña" value="<?php echo set_value('clave2'); ?>">
								    </div>
								</div>
								<button type="submit" value="3" name="ingresar" class="btn btn-block btn-amarillo" style="margin-top:10px;">REGISTRAR</button>
							</form>
						</div>
				    </div>
				</div>

				<div class="seguir"><a href="<?=site_url('menu')?>" class="btn btn-default btn-block">SEGUIR COMPRANDO</a></div>
			</div>

			<div class="col-xs-12 col-sm-3">
				<div class="titulo">DETALLE DE COMPRA</div>
				<div class="formulario">
					<?php
					foreach ($items as $item)
					{
						echo '<div class="row item">
								<div class="col-xs-3 area-imagen"><img src="'.base_url('assets/images/productos/'.$item['path_imagen']).'" class="img-responsive"></div>
								<div class="col-xs-9 area-texto">'.$item['nombre'].' x'.$item['cantidad'].'</div>
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