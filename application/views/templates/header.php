    <div class="container-fluid barra-menu hidden-xs">
    	<div class="container">
    		<div class="row">
    			<div class="col-xs-5 area-botones" style="">
		            <a class="" href="<?=site_url('pages')?>">HOME</a>
		            <a class="" href="<?=site_url('menu')?>">MENU</a>
		            <a class="" href="<?=site_url('pages/contacto')?>">CONTACTO</a>
    			</div>
    			<div class="col-xs-2 area-logo">
    				<a href="<?=site_url('pages')?>"><img src="<?=base_url('assets/images/lemonlogo.png')?>"></a>
    			</div>
    			<div class="col-xs-5 area-carrito" style="text-align:right">
    				<a href="<?=site_url('pedido')?>" class="btn btn-amarillo"><i class="fa fa-shopping-cart fa-lg"></i> INGRES&Aacute; AL CARRITO</a>
    			</div>
    		</div>
    	</div>
    </div>

    <!-- Static navbar -->
    <nav class="navbar navbar-inverse navbar-static-top barra-menu visible-xs">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?=site_url('pages')?>"><img src="<?=base_url('assets/images/lemonlogo.png')?>" height="100%"></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="<?=site_url('pages')?>">HOME</a></li>
            <li><a href="<?=site_url('menu')?>">MENU</a></li>
            <li><a href="<?=site_url('pages/contacto')?>">CONTACTO</a></li>
            <li><a href="<?=site_url('pedido')?>">CARRITO</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>