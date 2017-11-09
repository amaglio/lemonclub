    <div class="container-fluid barra-menu hidden-xs">
    	<div class="container">
    		<div class="row">
    			<div class="col-xs-5 area-botones" style="">
		            <a class="" href="<?=site_url('home')?>">HOME</a>
		            <a class="" href="<?=site_url('menu')?>">MENU</a>
                    
		            <a class="" href="<?=site_url('contacto')?>">CONTACTO</a>
    			</div>
    			<div class="col-xs-2 area-logo">
    				<a href="<?=site_url('pages')?>"><img src="<?=base_url('assets/images/lemonlogo.png')?>"></a>
    			</div>
                <div class="col-xs-2 area-botones" style="">
                    <a class="" href="<?=site_url('servicio_corporativo')?>">SERVICIO CORPORATIVO</a>
                </div>
    			<div class="col-xs-3 area-carrito" style="text-align:right">

    				<a href="<?=site_url('pedido')?>" class="btn btn-amarillo">
                            <i class="fa fa-shopping-cart fa-lg"></i> 

                            INGRES&Aacute; AL CARRITO
                            <?
                                if($this->session->userdata('pedido_activo') != "")
                                    echo "(1)";
                            ?>

                    </a>
                    <?
                    if($this->session->userdata('id_usuario') != "")
                    {
                        echo '<a href="'.site_url('usuario/logout').'" class="btn btn-amarillo">CERRAR SESIÓN</a>';
                    }
                    ?>
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
            <li class="active"><a href="<?=site_url('home')?>">HOME</a></li>
            <li><a href="<?=site_url('menu')?>">MENU</a></li>
            <li><a href="<?=site_url('contacto')?>">CONTACTO</a></li>
            <li><a href="<?=site_url('pedido')?>">CARRITO</a></li>
            <li><a href="<?=site_url('servicio_corporativo')?>">SERVICIO CORPORATIVO</a></li>
            <?
            if($this->session->userdata('id_usuario') != "")
            {
                echo '<li><a href="'.site_url('usuario/logout').'">CERRAR SESIÓN</a></li>';
            }
            ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>