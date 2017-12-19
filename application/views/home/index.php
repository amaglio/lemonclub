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
						<div class="item active" >
							<img class="d-block w-100" src="<?=base_url('assets/images/fondos/carne.jpg')?>" alt="First slide">
							<div class="carousel-caption">
								<h3>Reinventando el</h3>
								<p>Fast casual</p>
								<a href="<?=site_url('menu/index/-1')?>"><button class="btn btn-mas-padding btn-amarillo">MENU DEL DÍA</button></a>
							</div>
						</div>
						<div class="item">
							<img class="d-block w-100" src="<?=base_url('assets/images/fondos/ensalada.jpg')?>" alt="Second slide">
							<div class="carousel-caption">
								<h3>Reinventando el</h3>
								<p>Fast casual</p>
								<a href="<?=site_url('menu/index/-1')?>"><button class="btn btn-mas-padding btn-amarillo">MENU DEL DÍA</button></a>
							</div>
						</div>
						<div class="item">
							<img class="d-block w-100" src="<?=base_url('assets/images/fondos/pizza.jpg')?>" alt="Third slide">
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
			<div class="col-sm-12 btns-index">
				<?php
				/*
				foreach ($tipos as $key => $tipo)
				{
					echo '<a class="btn-index" style="background:url(\''.base_url('assets/images/'.$tipo['imagen']).'\'); background-size:cover; background-position:center;" href="'.site_url('menu/index/'.$tipo['id_producto_tipo']).'">
							<div class="btn btn-amarillo">'.strtoupper($tipo['descripcion']).'</div>
						</a>';
				}
				*/
				?>
				<ul id="slider">
					<?php
					foreach ($tipos as $key => $tipo)
					{
						echo '<li>
								<div class="btn-index" style="background:url(\''.base_url('assets/images/'.$tipo['imagen']).'\'); background-size:cover; background-position:center;" href="'.site_url('menu/index/'.$tipo['id_producto_tipo']).'">
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
		// DOM Ready
		$(function(){
			$('#slider').anythingSlider({
			    showMultiple: 6,
			    buildArrows         : false,      // If true, builds the forwards and backwards buttons
				buildNavigation     : false,      // If true, builds a list of anchor links to link to each panel
				buildStartStop      : false,      // If true, builds the start/stop button
				autoPlay            : true
			});
		});
	</script>

</body>
</html>