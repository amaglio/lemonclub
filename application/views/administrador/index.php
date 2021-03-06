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

	<script type="text/javascript">
        CI_ROOT = "<?=base_url()?>";
	</script>

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



		.navbar-default .navbar-nav>.open>a, .navbar-default .navbar-nav>.open>a:focus, .navbar-default .navbar-nav>.open>a:hover{
			background-color: #fce129;
		}

		.error{
    color:red;
        font-size: 13px;

  }
 
    .div_resultado_ajax{
         display: none;
    background-color: rgba(0, 0, 0, 0.08);
    padding: 20px 20px 0px 20px;
    margin-left: 0px;
    border-top: 1px solid #ececec;
    border: 1px solid #dcdcdc;
    }

    .alert-info {
          color: #000000;
    background-color: #fbe75961;
    border-color: #ecdd9d94;
    font-weight: bold;
    color: #303030d6;
    padding: 10px;
    letter-spacing: 0.5px;
    }

    .btn-danger 
    {
            color: #7f6800;
    background-color: #f0f8ff00;
    border: none;
    }

  .alert { 
        border-radius: 3px;
    }

    .checkbox{
      width: 30px; height: 30px;
    }

    .div_respuesta {
      padding: 20px;
      background-color: #ffff008a;
      width: fit-content;
      font-weight: bold;
      position: relative;
      left: 35px;
      top: -24px;
      z-index: 8000;
  }

  .nombre_grupo{
    background-color: black;
    padding: 10px 10px;
    color: white;
    font-size: 15px;
    font-weight: 600;
  }

  .ui-widget-content {
    border: 1px solid #555555;
    background: #000000 url(images/ui-bg_loop_25_000000_21x21.png) 50% 50% repeat;
    color: #ffffff;
    padding: 10px !important;
    font-size: 13px !important;
}

#sin_resultado{
      display: none;   
    color: red;
    }

    .badge{
    	background-color: #4CAF50 !important;
    }
	
	</style>
 
<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>

<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>

<!--
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> --> 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


</head>
<body style=" ">
	
	<nav class="navbar navbar-default" style="margin: 20px">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand"  ><img   style="width:100px; margin-bottom:10px" src="<?=base_url()?>assets/images/lemonlogo_admin.png"  > </a>
	    </div>
	    <ul class="nav navbar-nav">
		   	
		   	<li <?php echo ($this->uri->segment(2) == 'pedidos')? 'class="active"' : ' ' ;  ?>><a href='<?php echo site_url('administrador/pedidos')?>'><i class="fa fa-shopping-basket" aria-hidden="true"></i> Pedidos 
				</a>
			</li>

	    	<li <?php echo ($this->uri->segment(2) == 'productos')? 'class="active"' : ' ' ;  ?> ><a  href='<?php echo site_url('administrador/productos')?>'><i class="fa fa-lemon-o" aria-hidden="true"></i> Productos</a>
	    	</li>

	    	<li <?php echo ($this->uri->segment(2) == 'grupo_ingregientes')? 'class="active"' : ' ' ;  ?>><a href='<?php echo site_url('administrador/grupo_ingregientes')?>'><i class="fa fa-tag" aria-hidden="true"></i> Grupos de Ingr.</a>
	    	</li>

	    	<li <?php echo ($this->uri->segment(2) == 'ingredientes')? 'class="active"' : ' ' ;  ?>><a href='<?php echo site_url('administrador/ingredientes')?>'><i class="fa fa-flask" aria-hidden="true"></i> Ingredientes</a>
	    	</li>

	    	<li <?php echo ($this->uri->segment(2) == 'producto_dia')? 'class="active"' : ' ' ;  ?> ><a  href='<?php echo site_url('administrador/producto_dia')?>'><i class="fa fa-lemon-o" aria-hidden="true"></i> Producto Dia</a></li>

	      	<li <?php echo ($this->uri->segment(2) == 'tipos_productos')? 'class="active"' : ' ' ;  ?>><a href='<?php echo site_url('administrador/tipos_productos')?>'><i class="fa fa-tags" aria-hidden="true"></i> Tipos de productos</a>
	      	</li>

	      	<li <?php echo ($this->uri->segment(2) == 'estadisticas')? 'class="active"' : ' ' ;  ?>><a href='<?php echo site_url('administrador/estadisticas')?>'><i class="fa fa-bar-chart" aria-hidden="true"></i> Estadisticas</a>
	      	</li>

			<li <?php echo ($this->uri->segment(2) == 'usuarios_registrados' || $this->uri->segment(2) == 'usuarios_invitados' )? 'class="dropdown active"' :  'class="dropdown"' ;  ?>>
	        	<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-users" aria-hidden="true"></i> Usuarios<span class="caret"></span></a>
	            <ul class="dropdown-menu" role="menu">
	                <li <?php echo ($this->uri->segment(2) == 'usuarios_registrados')? 'class="active"' : ' ' ;  ?> ><a href='<?php echo site_url('administrador/usuarios_registrados')?>'> <i class="fa fa-registered" aria-hidden="true"></i> Registrados</a></li>
	                <li <?php echo ($this->uri->segment(2) == 'usuarios_invitados')? 'class="active"' : ' ' ;  ?> ><a href='<?php echo site_url('administrador/usuarios_invitados')?>'>Invitados</a></li>
	            </ul>
	        </li>


	      	<li ><a href='<?php echo site_url('login/logout')?>'><i class="fa fa-power-off" aria-hidden="true"></i> Salir</a></li>
	    </ul>
	  </div>
	  	
	</nav>


  
    <div style="margin: 20px">
 		<?php /*
		<div class="alert alert-info alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  <?php echo $titulo; ?>
		</div>*/ ?>
		<?php echo $output; ?>
    </div>