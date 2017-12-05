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

		<div class="row ">
			<div class="col-md-10 col-md-offset-1 btns-index">
				<?php
				foreach ($tipos as $key => $tipo)
				{
					echo '<a class="btn-index btn1-index" style="background:url(\''.base_url('assets/images/'.$tipo['imagen']).'\'); background-size:cover; background-position:center;" href="'.site_url('menu/index/'.$tipo['id_producto_tipo']).'">
							<button class="btn btn-amarillo">'.strtoupper($tipo['descripcion']).'</button>
						</a>';
				}
				?>
			</div>
		</div>
	</div>

<?php
$this->load->view('templates/footer');
?>

</body>
</html>