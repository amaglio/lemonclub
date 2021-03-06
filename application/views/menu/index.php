<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<?php
$this->load->view('templates/head');
?>

<style>

/*
.area-imagen {
    padding: 50px;
    background-color: green;
    transition: transform .2s; /* Animation  
    width: 200px;
    height: 200px;
    margin: 0 auto;
}

.area-imagen:hover {
    transform: scale(1.5); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport)  
} */

.parent {
    width: 100%;
    margin: 20px;  
    overflow: hidden;
    position: relative;
    float: left;
    display: inline-block; 
}

.area-imagen {
    height: 100%;
    width: 100%;
    background-size: cover;
    background-repeat: no-repeat;
    -webkit-transition: all .5s;
    -moz-transition: all .5s;
    -o-transition: all .5s;
    transition: all .5s;
}


.parent:hover .area-imagen, .parent:focus .area-imagen {
    -ms-transform: scale(1.2);
    -moz-transform: scale(1.2);
    -webkit-transform: scale(1.2);
    -o-transform: scale(1.2);
    transform: scale(1.2);
}

.parent:hover .area-imagen:before, .parent:focus .area-imagen:before {
    display: block;
}

.parent:hover a, .parent:focus a {
    display: block;
}
 

/* Media Queries */
@media screen and (max-width: 960px) {
    .parent {width: 100%; margin: 20px 0px}
        .wrapper {padding: 20px 20px;}
}


</style>
<body>
	<?php
	$this->load->view('templates/header');
	?>

	<div class="container-fluid area-banner">
		<div class="row" >
			<div class="col-xs-12">
				<?php
				$posicion_espacio = strpos($tipo_actual['descripcion'], ' ');
				if($posicion_espacio)
				{
					echo '<p>'.substr($tipo_actual['descripcion'], 0, $posicion_espacio).'</p>';
					echo '<h3>'.substr($tipo_actual['descripcion'], $posicion_espacio).'</h3>';
				}
				else
				{
					echo '<p>'.$tipo_actual['descripcion'].'</p>';
				}
				?>
			</div>
		</div>
	</div>

	<div class="container-fluid area-menu">
		<div class="row">
			<div class="col-xs-12">
				<div class="menu">
					<?php
					if($plato_dia == 1)
						$active = "class='active'"; 
					else
						$active = "";
					
					echo '<a style="color:" href="'.site_url('menu/index/-1').'" '.$active.' > <i class="fa fa-star-o" aria-hidden="true"></i> Menú del dia </a>';

					foreach ($tipos as $key_tipo => $tipo)
					{
						$active = "";
						if($tipo_actual['id_producto_tipo'] == $tipo['id_producto_tipo'])
						{
							$active = "class='active'";
						}
						echo '<a href="'.site_url('menu/index/'.$tipo['id_producto_tipo']).'" '.$active.'>'.$tipo['descripcion'].'</a>';
					}
					?>
				</div>
			</div>
		</div>
	</div>

	<div class="container area-menu-items">
		<div class="row">
			<?php
			foreach ($productos as $key_prod => $producto)
			{
				echo '<div class="col-xs-12 col-sm-3 item">
						<div class="parent" >
							<div class="area-imagen" style="background:url('.base_url('assets/images/productos/'.$producto['path_imagen']).'); background-size:cover; background-position:center;"></div>
						</div>
						<div class="titulo">'.$producto['nombre'].'</div>
						<div class="descripcion">'.$producto['descripcion'].'</div>
						<div class="precio">$'.$producto['precio'].'</div>
						<button onclick="comprar('.$producto['id_producto'].');" id="btn_'.$producto['id_producto'].'" class="btn btn-amarillo btn-mas-padding" data-loading-text="CARGANDO...">AGREGAR</button>
					</div>';
			}
			?>
		</div>
	</div>

<?php
$this->load->view('templates/footer');
?>
<script type="text/javascript">
function comprar(id)
{
	$('#btn_'+id).button('loading');
	var data = {id:id};
    $.ajax({
      	url: SITE_URL+'/pedido/agregar_producto_ajax',
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
	          	//$('#btn_'+id).notify(data.data, { className:'success', position:"top" });
	          	$('#cant_items_carrito_header').html("("+data.cantidad+")");

				$('#btn_'+id).notify({
				  title: data.data,
				  button: 'Ir al carrito'
				}, { 
				  style: 'foo',
				  clickToHide: false,
				  position:"top center"
				});
				
	        }
	        else
	        {
	        	$('#btn_'+id).notify(data.data, { className:'error', position:"top" });
	        }
	        $('#btn_'+id).button('reset');
      	},
      	error: function(x, status, error)
      	{
      		$.notify("Ocurrio un error: " + status + " \nError: " + error, "error");
      		$('#btn_'+id).button('reset');
      	}
    });
}

//add a new style 'foo'
$.notify.addStyle('foo', {
  html: 
    "<div>" +
      "<div class='clearfix'>" +
        "<div class='title' data-notify-html='title'/>" +
        "<div class='buttons'>" +
          "<i class='fa fa-shopping-cart'></i> <button class='btn btn-link yes' data-notify-text='button'>Ir al carrito</button>" +
        "</div>" +
      "</div>" +
    "</div>"
});

$(document).on('click', '.notifyjs-foo-base .yes', function() {
  $(this).trigger('notify-hide');
  location.href = "<?=site_url('pedido')?>";
});
</script>

</body>
</html>