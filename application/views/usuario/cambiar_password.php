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
		<div class="row">
			<div class="col-xs-12">
				<p>Cambiar Password</p>
				<h3>en Lemonclub</h3>
			</div>
		</div>
	</div>

	<div class="container confirmar">
		<div class="row">
			<div class="col-xs-12 col-sm-7 col-md-7 col-md-offset-1">
			   
          <div role="tabpanel" class="tab-pane active" id="ingresar">
              <div class="formulario">
 
              <form class="form-horizontal" action="#" method="POST" id="form-cambiar-password"> 

                <? echo '<div id="area-mensaje"></div>';?> 

                <input type="hidden" name="id_usuario" id="id_usuario" value="<?=$id_usuario?>">
 
                <div class="form-group">
                    <div class="col-sm-6">
                      <input type="password" class="form-control" name="clave" placeholder="Contraseña" value="<?php echo set_value('clave'); ?>">
                    </div>
                    <div class="col-sm-6">
                      <input type="password" class="form-control" name="clave2" placeholder="Repetir Contraseña" value="<?php echo set_value('clave2'); ?>">
                    </div>
                </div>
                <button type="submit" id="btn-registro" value="3" name="ingresar" class="btn btn-block btn-amarillo" style="margin-top:10px;" data-loading-text="Cargando...">REGISTRAR</button>
              </form>

            </div>
            </div>
				 

				<div class="seguir"><a href="<?=site_url('menu')?>" class="btn btn-default btn-block">SEGUIR COMPRANDO</a></div>
			</div>
 
		</div>
	</div>

<?php
$this->load->view('templates/footer');
?>

<script type="text/javascript">
 
 $('#form-cambiar-password').submit(function( event ) {

  event.preventDefault();
  $('#btn-registro').button('loading');
  $('#area-mensaje').html("");
    $.ajax({
       type: 'POST',
        data: $(event.target).serialize(),
        cache: false,
        dataType: 'json',
        processData: false, // Don't process the files
        //contentType: false, // Set content type to false as jQuery will tell the server its a query string request
       url: SITE_URL+"/usuario/procesa_cambiar_password",
       success: function(data){
          if(data.resultado == true)
          {
            var htmlData = '<div class="alert with-icon alert-success" role="alert"><i class="icon fa fa-exclamation-triangle"></i>';
            htmlData += data.mensaje;
            htmlData += '</div>';
            $('#area-mensaje').html(htmlData);

          }
          else
          {
            var htmlData = '<div class="alert with-icon alert-danger" role="alert">';
            htmlData += data.mensaje;
            htmlData += '</div>';
            $('#area-mensaje').html(htmlData);
          }
          $('#btn-registro').button('reset');
       },
       error: function(x, status, error){
            var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i>';
            htmlData += " Error: " + error;
            htmlData += '</div>';
            $('#area-mensaje').html(htmlData);
            $('#btn-registro').button('reset');
       }
    });
});

 
</script>

</body>
</html>