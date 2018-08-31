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

	<div class="container-fluid area-index">
		<div class="row">
			<div class="col-xs-12">
				<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
					<div class="carousel-inner">

						<div class="item active">
							<img class="d-block w-100" src="<?=base_url('assets/images/fondos/home_wok.jpg')?>" alt="Second slide">
							<div class="carousel-caption">
								<h3>Reinventando el</h3>
								<p>Fast casual</p>
								<a href="<?=site_url('menu/index/-1')?>"><button class="btn btn-mas-padding btn-amarillo">MENU DEL DÍA</button></a>
							</div>
						</div>

						<div class="item">
							<img class="d-block w-100" src="<?=base_url('assets/images/fondos/home_plato.jpg')?>" alt="Third slide">
							<div class="carousel-caption">
								<h3>Reinventando el</h3>
								<p>Fast casual</p>
								<a href="<?=site_url('menu/index/-1')?>"><button class="btn btn-mas-padding btn-amarillo">MENU DEL DÍA</button></a>
							</div>
						</div>

						<div class="item " >
							<img class="d-block w-100" src="<?=base_url('assets/images/fondos/home_ensalada.jpg')?>" alt="First slide">
							<div class="carousel-caption">
								<h3>Reinventando el</h3>
								<p>Fast casual</p>
								<a href="<?=site_url('menu/index/-1')?>"><button class="btn btn-mas-padding btn-amarillo">MENU DEL DÍA</button></a>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>

		<div class="row cont-btns-index">
			<div class="col-xs-12 btns-index">
				<?php
				echo '<div class="visible-xs">';
					foreach ($tipos as $key => $tipo)
					{
						echo '<a class="btn-index-xs" style="background:url(\''.base_url('assets/images/'.$tipo['path_imagen']).'\'); background-size:cover; background-position:center;" href="'.site_url('menu/index/'.$tipo['id_producto_tipo']).'">
								<div class="btn btn-amarillo">'.strtoupper($tipo['descripcion']).'</div>
							</a>';
					}
				echo '</div>';
				?>
				<ul id="slider" class="hidden-xs">
					<?php
					foreach ($tipos as $key => $tipo)
					{
						echo '<li>
								<div class="btn-index" style="background:url(\''.base_url('assets/images/'.$tipo['path_imagen']).'\'); background-size:cover; background-position:center;" onclick="abrir_menu('.$tipo['id_producto_tipo'].')">
									<div class="btn btn-amarillo">'.strtoupper($tipo['descripcion']).'</div>
								</div>
							</li>';
					}
					?>
				</ul>
			</div>
		</div>
	</div>

<?php
$this->load->view('templates/footer');
?>

<!-- Anything Slider -->
<link rel="stylesheet" href="<?=base_url()?>assets/css/anythingslider.css">
<script src="<?=base_url()?>assets/js/jquery.anythingslider.min.js"></script>

	<!-- AnythingSlider initialization -->
	<script>
		var res = $( window ).width();
		var cant = 6;
		if(res > 1200)
		{
			cant = 6;
		}
		else if(res > 1000)
		{
			cant = 5;
		}
		else if(res > 800)
		{
			cant = 4;
		}
		else if(res > 600)
		{
			cant = 3;
		}
		else if(res > 400)
		{
			cant = 2;
		}
		else
		{
			cant = 1;
		}
		//alert(res+" "+cant);
		// DOM Ready
		$(function(){
			if(res > 750)
			{
				$('#slider').anythingSlider({
				    showMultiple: cant,
				    buildArrows         : false,      // If true, builds the forwards and backwards buttons
					buildNavigation     : false,      // If true, builds a list of anchor links to link to each panel
					buildStartStop      : false,      // If true, builds the start/stop button
					autoPlay            : true
				});
			}
		});

		function abrir_menu(id)
		{
			location.href = "<?=site_url('menu/index/')?>"+id;
		}
	</script>

</body>
</html>