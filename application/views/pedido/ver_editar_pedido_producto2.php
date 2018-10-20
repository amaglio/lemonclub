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

<form action="<?=site_url('pedido/ver_editar_ingredientes_producto/'.$informacion_pedido_producto['id_pedido_producto'])?>" method="POST" id="form-confirmar">

	<div class="container carrito">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">

				<div class="titulo">
					<i class="fa fa-shopping-cart fa-lg"></i> &nbsp; INGREDIENTES <span id="cant_items_carrito">(<?php echo $cantidad; ?>)</span>
				</div>

					
						<?php
						echo '<div class="table" style="margin-bottom:20px;">';
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
						$numero_item = 0;
						for ( $i=0; $i < count( $grupos_producto); $i++ )
						{
							// Aca tenes toda la informacion para controlar el grupo
							$informacion_grupo = $grupos_producto[$i]['datos_grupo'];
							echo '<div class="titulo">'.$informacion_grupo['nombre'].'</div>';
							echo '<div class="row" style="margin:auto;">';
								echo '<div class="col-xs-12 area-menu-items" style="border:1px solid #ccc; margin-top:0px;">';
								// Listamos los ingredientes y hacemos checkbox.
								foreach ($grupos_producto[$i]['ingredientes_grupo'] as $key => $row)
								{
									echo '<input type="hidden" name="id_grupo[]" value="'.$row['id_grupo'].'">';
									echo '<input type="hidden" name="id_ingrediente[]" value="'.$row['id_ingrediente'].'">';
									$checked = "";
									$visible1 = "";
									$visible2 = "display:none;";
									$color = "alert-danger";
									$disabled = "";
									$opacidad = "";
									if(array_key_exists('seleccionado', $row) || $row['es_fijo'])
									{
										$color = "alert-success";
										$visible1 = "display:none;";
										$visible2 = "";
										$checked = "checked";
										if($row['es_fijo'])
										{
											$disabled = "disabled";
											$opacidad = "opacity:0.5;";
										}
									}
									echo '<input type="checkbox" name="ingredientes[]" id="ingredientes'.$row['id_ingrediente'].'" value="'.$numero_item.'" '.$checked.' style="display:none;">';

									echo '<div class="col-xs-12 col-sm-3 item" style="text-align:center;">';
										echo '<div class="alert '.$color.'" data-fijo="'.$row['es_fijo'].'" onclick="toggle_producto('.$row['id_ingrediente'].');" id="item_color_'.$row['id_ingrediente'].'">';
											echo '<div class="area-imagen" style="background:url('.base_url('assets/images/productos/'.$row['path_imagen']).'); background-size:cover; background-position:center;"></div>';
											echo '<div class="descripcion">'.$row['nombre'].'</div>';
											echo '<div class="precio">$'.$grupos_producto[$i]['datos_grupo']['precio_adicional'].'</div>';

											echo '<img src="'.base_url('assets/images/success.png').'" width="50px" style="position:absolute; top:0px; right:10px; '.$visible2.' '.$opacidad.'" id="success'.$row['id_ingrediente'].'">';
											echo '<img src="'.base_url('assets/images/failure.png').'" width="50px" style="position:absolute; top:0px; right:10px; '.$visible1.'" id="failure'.$row['id_ingrediente'].'">';
											echo '<img src="'.base_url('assets/images/loading.gif').'" width="50px" style="position:absolute; top:0px; right:10px; display:none;" id="loading'.$row['id_ingrediente'].'">';
											//echo '<button type="button" onclick="sacar_producto('.$row['id_ingrediente'].');"   style="'.$visible2.'" id="btn_sacar'.$row['id_ingrediente'].'" '.$disabled.' class="btn btn-danger btn-mas-padding"   data-loading-text="CARGANDO...">SACAR</button>';
											//echo '<button type="button" onclick="agregar_producto('.$row['id_ingrediente'].');" style="'.$visible1.'" id="btn_poner'.$row['id_ingrediente'].'" '.$disabled.' class="btn btn-amarillo btn-mas-padding" data-loading-text="CARGANDO...">AGREGAR</button>';
										echo '</div>';
									echo '</div>';

									$numero_item++;
								}
								echo '</div>';
							echo '</div>';
						}
						?>

			</div>
		</div>
	</div>

	<div style="position:fixed; bottom:0px; background:#FFF; padding:10px; width:100%; border-top:1px solid #ccc;">
		<div class="container carrito" style="margin:0px auto;">
			<div id="area-mensaje">
			</div>
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
		</div>
	</div>
</form>

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
            var htmlData = '<div class="alert with-icon alert-success alert-dismissible fade in" role="alert"><i class="icon fa fa-exclamation-triangle"></i>';
            htmlData += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
            htmlData += data.mensaje;
            htmlData += '</div>';
            $('#area-mensaje').html(htmlData);

            window.location.href = SITE_URL+"/pedido";
          }
          else
          {
            var htmlData = '<div class="alert with-icon alert-danger alert-dismissible fade in" role="alert">';
            htmlData += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
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

function editar_precio(id, tipo)
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
          		if(tipo == "agregar")
          		{
          			$('#ingredientes'+id).prop('checked', true);
					$('#success'+id).show();
					$('#failure'+id).hide();
					$('#btn_sacar'+id).show();
					$('#btn_poner'+id).hide();
					$('#item_color_'+id).removeClass('alert-danger');
					$('#item_color_'+id).addClass('alert-success');
          		}
          		else
          		{
          			$('#ingredientes'+id).prop('checked', false);
					$('#success'+id).hide();
					$('#failure'+id).show();
					$('#btn_sacar'+id).hide();
					$('#btn_poner'+id).show();
					$('#item_color_'+id).removeClass('alert-success');
					$('#item_color_'+id).addClass('alert-danger');
          		}
	            $('#total').html('$ '+data.precio);
	            $('#cant_items_carrito').html('('+data.cantidad+')');
          	}
          	else
          	{
          		if(tipo == "agregar")
          		{
          			$('#ingredientes'+id).prop('checked', false);
          		}
          		else
          		{
          			$('#ingredientes'+id).prop('checked', true);
          		}
	            var htmlData = '<div class="alert with-icon alert-danger alert-dismissible fade in" role="alert">';
	            htmlData += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
	            htmlData += data.mensaje;
	            htmlData += '</div>';
	            $('#area-mensaje').html(htmlData);
          	}
          	$('#btn-comprar').button('reset');
          	$('#loading'+id).hide();
        },
        error: function(x, status, error){
          	var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i>';
            htmlData += " Error: " + error;
            htmlData += '</div>';
            $('#area-mensaje').html(htmlData);
            $('#btn-comprar').button('reset');
            $('#loading'+id).hide();
        }
  	});
}

function agregar_producto(id)
{
	$('#ingredientes'+id).prop('checked', true);
	$('#loading'+id).show();
	/*
	$('#success'+id).show();
	$('#failure'+id).hide();
	$('#btn_sacar'+id).show();
	$('#btn_poner'+id).hide();
	$('#item_color_'+id).removeClass('alert-danger');
	$('#item_color_'+id).addClass('alert-success');
	*/
	editar_precio(id, "agregar");
}

function sacar_producto(id)
{
	if($('#item_color_'+id).data('fijo'))
	{
		alert("No se puede quitar este ingrediente");
	}
	else
	{
		$('#ingredientes'+id).prop('checked', false);
		/*
		$('#success'+id).hide();
		$('#failure'+id).show();
		$('#btn_sacar'+id).hide();
		$('#btn_poner'+id).show();
		$('#item_color_'+id).removeClass('alert-success');
		$('#item_color_'+id).addClass('alert-danger');
		*/
		editar_precio(id, "sacar");
	}
}

function toggle_producto(id)
{
	if($('#ingredientes'+id).prop('checked') == true)
	{
		sacar_producto(id);
	}
	else
	{
		agregar_producto(id);
	}
}

function mensaje_no_items()
{
	$('#area-mensaje').html('<div id="no_items" class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>No hay items para comprar.</div>');
}

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>

</body>
</html>