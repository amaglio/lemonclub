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
		<div class="row" >
			<div class="col-xs-12">
				<div>
					<p>Ensaladas</p>
					<h3>Y wraps</h3>
				</div>
			</div>
		</div>
	</div>

	<div class="container-fluid area-menu">
		<div class="row">
			<div class="col-xs-12">
				<div class="menu">
				  <a href="#" class="active">Ensaladas y Wraps</a>
				  <a href="#">Sandwichs y paninis</a>
				  <a href="#">Platos calientes</a>
				  <a href="#">Cafetería y Pastelería</a>
				</div>
			</div>
		</div>
	</div>

	<div class="container area-menu-items">
		<div class="row">
			<div class="col-xs-12 col-sm-3 item">
				<div class="area-imagen"><img src="<?=base_url('assets/images/productos/ensalada1.jpg')?>" class="img-responsive"></div>
				<div class="titulo">Quinoa Kanikama</div>
				<div class="descripcion">Mix verdes, Quinoa, cherry, huevo, zanahoria, choclo y kanikama</div>
				<div class="precio">$86</div>
				<button class="btn btn-amarillo btn-mas-padding">COMPRAR</button>
			</div>
			<div class="col-xs-12 col-sm-3 item">
				<div class="area-imagen"><img src="<?=base_url('assets/images/productos/ensalada1.jpg')?>" class="img-responsive"></div>
				<div class="titulo">Quinoa Kanikama</div>
				<div class="descripcion">Mix verdes, Quinoa, cherry, huevo, zanahoria, choclo y kanikama</div>
				<div class="precio">$86</div>
				<button class="btn btn-amarillo btn-mas-padding">COMPRAR</button>
			</div>
			<div class="col-xs-12 col-sm-3 item">
				<div class="area-imagen"><img src="<?=base_url('assets/images/productos/ensalada1.jpg')?>" class="img-responsive"></div>
				<div class="titulo">Quinoa Kanikama</div>
				<div class="descripcion">Mix verdes, Quinoa, cherry, huevo, zanahoria, choclo y kanikama</div>
				<div class="precio">$86</div>
				<button class="btn btn-amarillo btn-mas-padding">COMPRAR</button>
			</div>
			<div class="col-xs-12 col-sm-3 item">
				<div class="area-imagen"><img src="<?=base_url('assets/images/productos/ensalada1.jpg')?>" class="img-responsive"></div>
				<div class="titulo">Quinoa Kanikama</div>
				<div class="descripcion">Mix verdes, Quinoa, cherry, huevo, zanahoria, choclo y kanikama</div>
				<div class="precio">$86</div>
				<button class="btn btn-amarillo btn-mas-padding">COMPRAR</button>
			</div>

			<div class="col-xs-12 col-sm-3 item">
				<div class="area-imagen"><img src="<?=base_url('assets/images/productos/ensalada1.jpg')?>" class="img-responsive"></div>
				<div class="titulo">Quinoa Kanikama</div>
				<div class="descripcion">Mix verdes, Quinoa, cherry, huevo, zanahoria, choclo y kanikama</div>
				<div class="precio">$86</div>
				<button class="btn btn-amarillo btn-mas-padding">COMPRAR</button>
			</div>
			<div class="col-xs-12 col-sm-3 item">
				<div class="area-imagen"><img src="<?=base_url('assets/images/productos/ensalada1.jpg')?>" class="img-responsive"></div>
				<div class="titulo">Quinoa Kanikama</div>
				<div class="descripcion">Mix verdes, Quinoa, cherry, huevo, zanahoria, choclo y kanikama</div>
				<div class="precio">$86</div>
				<button class="btn btn-amarillo btn-mas-padding">COMPRAR</button>
			</div>
			<div class="col-xs-12 col-sm-3 item">
				<div class="area-imagen"><img src="<?=base_url('assets/images/productos/ensalada1.jpg')?>" class="img-responsive"></div>
				<div class="titulo">Quinoa Kanikama</div>
				<div class="descripcion">Mix verdes, Quinoa, cherry, huevo, zanahoria, choclo y kanikama</div>
				<div class="precio">$86</div>
				<button class="btn btn-amarillo btn-mas-padding">COMPRAR</button>
			</div>
			<div class="col-xs-12 col-sm-3 item">
				<div class="area-imagen"><img src="<?=base_url('assets/images/productos/ensalada1.jpg')?>" class="img-responsive"></div>
				<div class="titulo">Quinoa Kanikama</div>
				<div class="descripcion">Mix verdes, Quinoa, cherry, huevo, zanahoria, choclo y kanikama</div>
				<div class="precio">$86</div>
				<button class="btn btn-amarillo btn-mas-padding">COMPRAR</button>
			</div>
		</div>
	</div>

<?php
$this->load->view('templates/footer');
?>

</body>
</html>