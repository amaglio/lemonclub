<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<?php
$this->load->view('templates/head');
?>

<style type="text/css">
	
	.subtitulo{
		 padding: 10px;
	    background-color: #fac80054;
	    font-size: 12px;
	    font-weight: bold;
	    /* color: #fac800; */
	}

	.popover-title{
		width: 200px;
	}

</style>
<body>
	<?php
	$this->load->view('templates/header');
	?>

	<div class="container-fluid area-banner" style="background: url('<?=base_url("assets/images/fondos/carrito.jpg")?>'); background-size: cover; background-position: top;">
		<div class="row">
			<div class="col-xs-12">
				<p>Confirmá</p>
				<h3>Tu pedido</h3>
			</div>
		</div>
	</div>

	<div class="container confirmar">
		<div class="row">
			<div class="col-xs-12 col-sm-7 col-md-7 col-md-offset-1">
				<div id="area-mensaje"></div>
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
				?>

				<div class="titulo"><i class="fa fa-shopping-cart fa-lg"></i> &nbsp; CONFIRMAR PEDIDO</div>

				<div class="subtitulo"><?=$datos_usuario->tipo_usuario?></div>
				<div class="formulario">
					<form class="form-horizontal" id="form-confirmar" action="<?=site_url('pedido/finalizar_pedido')?>" method="POST">
						<input type="hidden" name="id_pedido" value="<?php echo $this->session->userdata('id_pedido'); ?>">
						<div class="form-group">
						    <div class="col-sm-12">
						    	<input type="email" class="form-control" id="mail" name="mail" placeholder="Email" value="<?=$datos_usuario->email?>" readonly="readonly">
						    </div>
						</div>
						<?
						if($datos_usuario->tipo_usuario == "Usuario Registrado")
						{
						?>
						<div class="form-group">
						    <div class="col-sm-6">
						    	<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?=$datos_usuario->nombre?>" readonly="readonly">
						    </div>
						    <div class="col-sm-6">
						    	<input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido" value="<?=$datos_usuario->apellido?>" readonly="readonly">
						    </div>
						</div>
						<?
						}
						?>
						<hr>

						<h4>Forma de Entrega</h4>
						<div class="radio">
						  <label>
						    <input type="radio" name="entrega" id="entrega1" value="<?php echo FORMA_ENTREGA_DELIVERY; ?>" onchange="select_delivery()">
						    Quiero que me lo envien
						  </label>
						</div>
						<div class="form-group" id="area_envio" style="display:none;">
							<?php
							foreach ($direcciones as $key_dir => $direccion)
							{
								echo '<div class="col-sm-12">
										<div class="radio" style="margin-left:20px;">
										  <label>
										    <input type="radio" name="direccion" id="direccion'.$key_dir.'" value="1" onchange="select_dir_vieja(\''.$direccion['direccion'].'\', \''.$direccion['altura'].'\')">
										    '.$direccion['direccion'].' '.$direccion['altura'].'
										  </label>
										</div>
									</div>';
							}
							echo '<div class="col-sm-12">
										<div class="radio" style="margin-left:20px;">
										  <label>
										    <input type="radio" name="direccion" id="direccion_nueva" value="1" checked onchange="select_dir_nueva()">
										    Nueva dirección
										  </label>
										</div>
									</div>';
							?>
							<div id="area_dir_nueva">
							    <div class="col-sm-6">
							    	<input type="text" class="form-control" id="calle" name="calle" placeholder="Calle"  value="<?php echo set_value('calle'); ?>" required="required">
							    </div>
							    <div class="col-sm-6">
							    	<input type="text" class="form-control" id="altura" name="altura" placeholder="Altura"  value="<?php echo set_value('altura'); ?>" required="required">
							    </div>
						    </div>
						</div>
						<div class="radio">
						  <label>
						    <input type="radio" name="entrega" id="entrega2" value="<?php echo FORMA_ENTREGA_TAKEAWAY; ?>" onchange="select_takeaway()" checked>
						    Quiero pasarlo a buscar
						  </label>
						</div>

						<hr>
						
						<h4>Horario de Entrega</h4>
						<?php
						echo '<select name="horario" class="form-control">';
						foreach ($horarios as $key => $horario)
						{
							echo '<option value="'.$horario.'">'.substr($horario,0,5).'</option>';
						}
						echo '</select>';
						?>

						<hr>

						<h4>Forma de Pago</h4>
						<?php
						foreach ($formas_pago as $key => $forma_pago)
						{
							echo '<div class="radio">
									  <label>
									    <input type="radio" name="pago" id="pago'.$forma_pago['id_forma_pago'].'" value="'.$forma_pago['id_forma_pago'].'" checked>
									    '.$forma_pago['descripcion'].'
									  </label>
									</div>';
						}
						?>

						<hr>

						<!--<input type="submit" value="COMPRAR" name="comprar" id="btn-comprar" class="btn btn-block btn-amarillo confirmation-callback" style="margin-top:10px;">-->

						<?php
							if($items && count($items))
							{
								echo '<button type="button" name="comprar" id="btn-comprar" class="btn btn-block btn-amarillo confirmation-callback" 
								        data-btn-ok-label="Continuar" data-btn-ok-icon="glyphicon glyphicon-share-alt"
								        data-btn-ok-class="btn btn-primary"
								        data-btn-cancel-label="Cancelar" data-btn-cancel-icon="glyphicon glyphicon-ban-circle"
								        data-btn-cancel-class="btn btn-danger"
								        data-title="Is it ok?" data-content="This might be dangerous" data-loading-text="Cargando...">
								  COMPRAR
								</button>';
							}
							else
							{
								echo '<a href="javascript: mensaje_no_items();" class="btn btn-amarillo btn-block">COMPRAR</a>';
							}
						?>

					</form>
				</div>

				<div class="seguir"><a href="<?=site_url('menu')?>" class="btn btn-default btn-block">SEGUIR COMPRANDO</a></div>
			</div>

			<div class="col-xs-12 col-sm-5 col-md-3">
				<div class="titulo" style="width:100%;">DETALLE DE COMPRA</div>
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
					<div class="col-xs-6">$<?php echo $total; ?></div>
					</div>
				</div>
 

			</div>
		</div>
	</div>

<?php
$this->load->view('templates/footer');
?>

<script type="text/javascript">
function select_delivery()
{
	$('#area_envio').show();
}

function select_takeaway()
{
	$('#area_envio').hide();
}

function select_dir_vieja(calle, altura)
{
	$('#area_dir_nueva').hide();
	$('#calle').val(calle);
	$('#altura').val(altura);
}

function select_dir_nueva()
{
	$('#area_dir_nueva').show();
	$('#calle').val("");
	$('#altura').val("");
}
	
	$(function() {
		
		$('body').confirmation({
			selector: '[data-toggle="confirmation"]'
		});

		$('.confirmation-callback').confirmation({
			onConfirm: function() {  $('#form-confirmar').submit(); },
			onCancel: function() {   },
			title:'¿ Seguro desea confirmar el pedido ?'
		});
	});
	
	$('#form-confirmar').submit(function( event ) {
		event.preventDefault();
		$('#btn-comprar').button('loading');
		$('#area-mensaje').html("");
	  	$.ajax({
	       type: 'POST',
	        data: $(event.target).serialize(),
	        cache: false,
	        dataType: 'json',
	        processData: false, // Don't process the files
	        //contentType: false, // Set content type to false as jQuery will tell the server its a query string request
	       url: SITE_URL+"/pedido/finalizar_pedido_ajax",
	       success: function(data){
	          if(data.resultado == true)
	          {
	            var htmlData = '<div class="alert with-icon alert-success" role="alert"><i class="icon fa fa-exclamation-triangle"></i>';
	            htmlData += data.mensaje;
	            htmlData += '</div>';
	            $('#area-mensaje').html(htmlData);

	            if(data.link)
	            {
	            	window.location.href = data.link;
	            }
	          }
	          else
	          {
	            var htmlData = '<div class="alert with-icon alert-danger" role="alert">';
	            htmlData += data.mensaje;
	            htmlData += '</div>';
	            $('#area-mensaje').html(htmlData);
	          }
	          $('#btn-comprar').button('reset');
	       },
	       error: function(x, status, error){
	          	var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i>';
	            htmlData += " Error: " + error;
	            htmlData += '</div>';
	            $('#area-mensaje').html(htmlData);
	            $('#btn-comprar').button('reset');
	       }
	  	});
	});

	function mensaje_no_items()
	{
		$('#area-mensaje').html('<div id="no_items" class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>No hay items para comprar.</div>');
	}
	</script>

</body>
</html>