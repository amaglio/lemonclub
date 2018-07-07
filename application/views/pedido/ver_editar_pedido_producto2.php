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

				<div id="area-mensaje">
				</div>

				<div class="titulo">
					<i class="fa fa-shopping-cart fa-lg"></i> &nbsp; INGREDIENTES <span id="cant_items_carrito">(<?php echo $cantidad; ?>)</span>
				</div>

				<form action="<?=site_url('pedido/ver_editar_ingredientes_producto/'.$informacion_pedido_producto['id_pedido_producto'])?>" method="POST" id="form-confirmar">

					
						<?php
						echo '<div class="table">';
						echo '<input type="hidden" value="'.$informacion_pedido_producto['id_pedido_producto'].'" name="id_pedido_producto">';
						echo '<input type="hidden" value="'.$informacion_pedido_producto['id_producto'].'" name="id_producto">';

						if($informacion_producto)
						{
							echo '<div class="row item" style="background:#ccc; margin:0px;">
								<div class="col-xs-12 col-sm-2"><img src="'.base_url('assets/images/productos/'.$informacion_producto[0]['path_imagen']).'" class="img-responsive"></div>
								<div class="col-xs-12 col-sm-6">
									<span class="title">'.$informacion_producto[0]['nombre'].'</span><br>
									<span class="descripcion">'.$informacion_producto[0]['descripcion'].'</span>
								</div>
								<div class="col-xs-12 col-sm-2 precio">$'.$this->cart->format_number($informacion_producto[0]['precio']).'</div>
								<div class="col-xs-12 col-sm-2 cantidad">
									<input type="number" min="1" step="1" name="cantidad[]" value="'.$informacion_pedido_producto['cantidad'].'" class="form-control pull-left" disabled>
									</div>
							</div>';
						}
						echo '</div>';
						/*
						echo '<div class="row hidden-xs">
								<div class="col-xs-2 th"></div>
								<div class="col-xs-6 th">INGREDIENTE</div>
								<div class="col-xs-2 th">PRECIO</div>
								<div class="col-xs-2 th">SELECCIONADO</div>
							</div>';
						*/
						echo '<div class="row area-menu-items" style="border:1px solid #ccc; border-radius:10px;">';
						for ( $i=0; $i < count( $grupos_producto); $i++ )
						{
							// Aca tenes toda la informacion para controlar el grupo
							$informacion_grupo = $grupos_producto[$i]['datos_grupo'];
							echo '<h3 class="col-xs-12" style="background:#FFC50A; margin:0px; border-top-left-radius:8px; border-top-right-radius:8px; border-bottom:solid 1px #ccc; padding:10px;">'.$informacion_grupo['nombre'].'</h3>';

							// Listamos los ingredientes y hacemos checkbox.
							foreach ($grupos_producto[$i]['ingredientes_grupo'] as $key => $row)
							{
								echo '<input type="hidden" name="id_grupo[]" value="'.$row['id_grupo'].'">';
								echo '<input type="hidden" name="id_ingrediente[]" value="'.$row['id_ingrediente'].'">';
								$checked = "";
								$visible1 = "";
								$visible2 = "display:none;";
								if(array_key_exists('seleccionado', $row))
								{
									$visible1 = "display:none;";
									$visible2 = "";
									$checked = "checked";
								}
								$disabled = "";
								if($row['es_fijo'])
								{
									$disabled = "disabled";
									$checked = "checked";
								}
								echo '<input type="checkbox" name="ingredientes[]" id="ingredientes'.$row['id_ingrediente'].'" value="'.$key.'" '.$checked.' style="display:none;">';

								echo '<div class="col-xs-12 col-sm-3 item" style="text-align:center;">';
									echo '<div class="area-imagen" style="background:url('.base_url('assets/images/productos/'.$row['path_imagen']).'); background-size:cover; background-position:center;"></div>';
									echo '<div class="descripcion">'.$row['nombre'].'</div>';
									echo '<div class="precio">$'.$grupos_producto[$i]['datos_grupo']['precio_adicional'].'</div>';

									echo '<img src="'.base_url('assets/images/success.png').'" width="50px" style="position:absolute; top:0px; right:10px; '.$visible2.'" id="success'.$row['id_ingrediente'].'">';
									echo '<img src="'.base_url('assets/images/failure.png').'" width="50px" style="position:absolute; top:0px; right:10px; '.$visible1.'" id="failure'.$row['id_ingrediente'].'">';
									echo '<button type="button" onclick="sacar_producto('.$row['id_ingrediente'].');"   style="'.$visible2.'" id="btn_sacar'.$row['id_ingrediente'].'" '.$disabled.' class="btn btn-danger btn-mas-padding"   data-loading-text="CARGANDO...">SACAR</button>';
									echo '<button type="button" onclick="agregar_producto('.$row['id_ingrediente'].');" style="'.$visible1.'" id="btn_poner'.$row['id_ingrediente'].'" '.$disabled.' class="btn btn-amarillo btn-mas-padding" data-loading-text="CARGANDO...">AGREGAR</button>';
								echo '</div>';
								/*
								// Hay que controlar si le ingrediente ya esta en el pedido para chequearlo.
								// hay que usar el array:  $informacion_ingredientes_pedido_producto.
								$dato['id_grupo'] = $row['id_grupo'];
								$dato['id_ingrediente'] = $row['id_ingrediente'];
								$json_dato = json_encode($dato);
								echo '<div class="row item" id="item_'.$row['id_grupo'].'">';
									echo '<input type="hidden" name="id_grupo[]" value="'.$row['id_grupo'].'">';
									echo '<input type="hidden" name="id_ingrediente[]" value="'.$row['id_ingrediente'].'">';
									echo '<div class="col-xs-12 col-sm-2">';
										echo '<img src="'.base_url('assets/images/productos/'.$row['path_imagen']).'" class="img-responsive">';
									echo '</div>';
									echo '<div class="col-xs-12 col-sm-6">';
										echo $row['nombre'];
									echo '</div>';
									echo '<div class="col-xs-12 col-sm-2">';
										echo '$'.$grupos_producto[$i]['datos_grupo']['precio_adicional'];
									echo '</div>';
									echo '<div class="col-xs-12 col-sm-2">';
										$checked = "";
										if(array_key_exists('seleccionado', $row))
										{
											$checked = "checked";
										}
										$disabled = "";
										if($row['es_fijo'])
										{
											$disabled = "disabled";
											$checked = "checked";
											echo '<input type="hidden" name="ingredientes[]" value="'.$key.'">';
										}
										echo '<input type="checkbox" name="ingredientes[]" value="'.$key.'" '.$checked.' onclick="editar_precio()" '.$disabled.'>';
									echo '</div>';
								echo '</div>';
								*/
							}
						}
						echo '</div>';
						?>
					
					<div class="col-xs-12 col-sm-4 col-sm-offset-8 total" style="border-top:solid 1px #999;">
						<div class="col-xs-6">Total</div>
						<div class="col-xs-6" id="total">$<?php echo $this->cart->format_number($informacion_pedido_producto['precio_unitario']); ?></div>
					</div>
					
					<div class="row">
						<div class="col-xs-12 col-sm-3 col-sm-push-9" style="text-align:right">
							<?php
								echo '<button type="submit" class="btn btn-amarillo btn-block" id="btn-comprar">GUARDAR</button>';
							?>
						</div>
						<div class="col-xs-12 col-sm-3 col-sm-pull-3" style="text-align:left">
							<a href="<?=site_url('pedido')?>" class="btn btn-default btn-block">CANCELAR</a>
						</div>
					</div>
				
				</form>

			</div>
		</div>
	</div>

<?php
$this->load->view('templates/footer');
?>

<script type="text/javascript">
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
       url: SITE_URL+"/pedido/editar_ingredientes_producto_ajax",
       success: function(data){
       	//alert(JSON.stringify(data));
          if(data.resultado == true)
          {
            var htmlData = '<div class="alert with-icon alert-success" role="alert"><i class="icon fa fa-exclamation-triangle"></i>';
            htmlData += data.mensaje;
            htmlData += '</div>';
            $('#area-mensaje').html(htmlData);

            window.location.href = SITE_URL+"/pedido";
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

function editar_precio()
{
	$('#btn-comprar').button('loading');
	$('#area-mensaje').html("");
  	$.ajax({
        type: 'POST',
        data: $('#form-confirmar').serialize(),
        cache: false,
        dataType: 'json',
        processData: false, // Don't process the files
        //contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        url: SITE_URL+"/pedido/editar_precio_producto_ajax",
        success: function(data){
       		//alert(JSON.stringify(data));
          	if(data.resultado == true)
          	{
	            $('#total').html('$ '+data.precio);
	            $('#cant_items_carrito').html('('+data.cantidad+')');
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
}

function agregar_producto(id)
{
	$('#ingredientes'+id).prop('checked', true);
	$('#succes'+id).show();
	$('#failure'+id).hide();
	$('#btn_sacar'+id).show();
	$('#btn_poner'+id).hide();
	editar_precio();
}

function sacar_producto(id)
{
	$('#ingredientes'+id).prop('checked', false);
	$('#succes'+id).hide();
	$('#failure'+id).show();
	$('#btn_sacar'+id).hide();
	$('#btn_poner'+id).show();
	editar_precio();
}

function mensaje_no_items()
{
	$('#area-mensaje').html('<div id="no_items" class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>No hay items para comprar.</div>');
}
</script>

</body>
</html>