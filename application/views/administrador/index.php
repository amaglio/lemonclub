<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LemonClub | Administradorr </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
     
    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<style type="text/css">
		.navbar-brand{
			padding: 10px 15px;
		}

		.navbar-default{
			background-color:#000000;
		}

		.navbar-default .navbar-nav>li>a{
			color: white;
		}

 		.navbar-default .navbar-nav>.active>a, .navbar-default .navbar-nav>.active>a:focus, .navbar-default .navbar-nav>.active>a:hover{
 			color: #000;
 			background-color:#fce028;
 		}

 		.navbar-default .navbar-nav>li>a:focus, .navbar-default .navbar-nav>li>a:hover{
			color: #fce028;
		}
 		
 		.alert-info{
			    color: #000000;
    background-color: #fce028;
    border-color: #d8c129;
		}

	</style>

<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
</head>
<body style=" ">
	
	<nav class="navbar navbar-default" style="margin: 20px">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand"  ><img   style="width:100px; margin-bottom:10px" src="<?=base_url()?>assets/images/lemonlogo_admin.png"  > </a>
	    </div>
	    <ul class="nav navbar-nav">
	    	<li <? echo ($this->uri->segment(2) == 'productos')? 'class="active"' : ' ' ;  ?> ><a  href='<?php echo site_url('administrador/productos')?>'><i class="fa fa-lemon-o" aria-hidden="true"></i> Productos</a></li>

	    	<li <? echo ($this->uri->segment(2) == 'producto_dia')? 'class="active"' : ' ' ;  ?> ><a  href='<?php echo site_url('administrador/producto_dia')?>'><i class="fa fa-lemon-o" aria-hidden="true"></i> Producto Dia</a></li>

	      	<li <? echo ($this->uri->segment(2) == 'tipos_productos')? 'class="active"' : ' ' ;  ?>><a href='<?php echo site_url('administrador/tipos_productos')?>'><i class="fa fa-tags" aria-hidden="true"></i> Tipos de productos</a></li>

			<li <? echo ($this->uri->segment(2) == 'pedidos')? 'class="active"' : ' ' ;  ?>><a href='<?php echo site_url('administrador/pedidos')?>'><i class="fa fa-shopping-basket" aria-hidden="true"></i> Pedidos</a></li>

	      	<li <? echo ($this->uri->segment(2) == 'ingredientes')? 'class="active"' : ' ' ;  ?>><a href='<?php echo site_url('administrador/ingredientes')?>'><i class="fa fa-flask" aria-hidden="true"></i>Ingredientes</a></li>

	      	<li <? echo ($this->uri->segment(2) == 'tipos_ingrediente')? 'class="active"' : ' ' ;  ?>><a href='<?php echo site_url('administrador/tipos_ingredientes')?>'><i class="fa fa-tag" aria-hidden="true"></i>Tipo de Ingredientes</a></li>

	      	<li <? echo ($this->uri->segment(2) == 'usuarios')? 'class="active"' : ' ' ;  ?>><a href='<?php echo site_url('administrador/usuarios')?>'><i class="fa fa-users" aria-hidden="true"></i> Usuarios</a></li>

	      	<li ><a href='<?php echo site_url('login/logout')?>'><i class="fa fa-power-off" aria-hidden="true"></i> Salir</a></li>
	    </ul>
	  </div>
	  	
	</nav>


  
    <div style="margin: 20px">
 
		<div class="alert alert-info alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  <?php echo $titulo; ?>
		</div>
		<?php echo $output; ?>
    </div>
</body>
<!-- Jquery  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <!--Bootstrap 
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>-->
</html>
