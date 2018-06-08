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
				<p>Recuperar contraseña</p> 
			</div>
		</div>
	</div>

	<div class="container confirmar">
		<div class="row">
			<div class="col-xs-12 col-sm-7 col-md-7 col-md-offset-1">

          <?php echo '<div id="area-mensaje"></div>'; ?>
			   
          <div role="tabpanel" class="tab-pane active" id="ingresar">
              <div class="formulario">
                <p>Ingresa tu email y te enviaremos un email para recuperar tu contraseña.</p>
              <form class="form-horizontal" action="#" method="POST" id="form-recuperar">
                <div class="form-group">
                    <div class="col-sm-12">
                      <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo set_value('email'); ?>">
                    </div>
                </div>
                <button type="submit" id="btn-ingresar" value="1" name="ingresar" class="btn btn-block btn-amarillo" style="margin-top:10px;" data-loading-text="Cargando...">RECUPERAR</button>
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
$('#form-recuperar').submit(function( event ) {
	$('#area-mensaje').html(' ');
	event.preventDefault();
	$('#btn-ingresar').button('loading');
	$('#area-mensaje').html("");
  	$.ajax({
       type: 'POST',
        data: $(event.target).serialize(),
        cache: false,
        dataType: 'json',
        processData: false, // Don't process the files
        //contentType: false, // Set content type to false as jQuery will tell the server its a query string request
       url: SITE_URL+"/usuario/procesa_recuperar_clave",
       success: function(data){
          if(data.resultado == true)
          {
            var htmlData = '<div class="alert with-icon alert-success" role="alert"><i class="icon fa fa-exclamation-triangle"></i> ';
            htmlData += data.mensaje;
            htmlData += '</div>';
            $('#area-mensaje').html(htmlData);
            //window.location.href = SITE_URL+"/menu"; 
          }
          else
          {
            var htmlData = '<div class="alert with-icon alert-danger" role="alert">';
            htmlData += data.mensaje;
            htmlData += '</div>';
     		$('#area-mensaje').html(htmlData);
          }
          $('#btn-ingresar').button('reset');
       },
       error: function(x, status, error){
          	var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i> ';
            htmlData += " Error: " + error;
            htmlData += '</div>';
            $('#area-mensaje').html(htmlData);
            $('#btn-ingresar').button('reset');
            alert(error);
       }
  	});
});

 
</script>

</body>
</html>