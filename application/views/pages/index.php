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
		<div class="row" >
			<div class="col-xs-12">
				<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
					<div class="carousel-inner">
						<div class="item active">
							<img class="d-block w-100" src="<?=base_url('assets/images/fondos/carne.jpg')?>" alt="First slide">
							<div class="carousel-caption">
								<h3>Reinventando el</h3>
								<p>Fast casual</p>
								<button class="btn btn-mas-padding btn-amarillo">MENU DEL DÍA</button>
							</div>
						</div>
						<div class="item">
							<img class="d-block w-100" src="<?=base_url('assets/images/fondos/ensalada.jpg')?>" alt="First slide">
							<div class="carousel-caption">
								<h3>Reinventando el</h3>
								<p>Fast casual</p>
								<button class="btn btn-mas-padding btn-amarillo">MENU DEL DÍA</button>
							</div>
						</div>
						<div class="item">
							<img class="d-block w-100" src="<?=base_url('assets/images/fondos/pizza.jpg')?>" alt="First slide">
							<div class="carousel-caption">
								<h3>Reinventando el</h3>
								<p>Fast casual</p>
								<button class="btn btn-mas-padding btn-amarillo">MENU DEL DÍA</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row ">
			<div class="col-md-10 col-md-offset-1 btns-index">
				<a class="btn-index btn1-index" href="#">
					<button class="btn btn-amarillo"><strong>ENSALADAS</strong><br>Y WRAPS</button>
				</a>
				<a class="btn-index btn2-index" href="#">
					<button class="btn btn-amarillo"><strong>SANDWICHS</strong><br>Y PANINIS</button>
				</a>
				<a class="btn-index btn3-index" href="#">
					<button class="btn btn-amarillo"><strong>PLATOS</strong><br>CALIENTES</button>
				</a>
				<a class="btn-index btn4-index" href="#">
					<button class="btn btn-amarillo"><strong>CAFETERÍA</strong><br>Y PASTELERÍA</button>
				</a>
			</div>
		</div>
	</div>

<?php
$this->load->view('templates/footer');
?>

</body>
</html>