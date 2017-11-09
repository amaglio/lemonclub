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

	<div class="container-fluid area-contacto">
		<div class="row area-negra">
			<div class="col-xs-12 col-sm-10 col-sm-offset-1">
				<h3>Contacto</h3>
				<p>
					RECONQUISTA 869, CABA<br>
					011 4893-2535 (HASTA LAS 15.30)
				</p>
				<div class="contacto">
					<div class="col-xs-12 col-sm-6 area-mapa">
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6568.5198024976735!2d-58.37739271266708!3d-34.59758887554453!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95bccacb2142f201%3A0xeaba3281cd3f0c9f!2sReconquista+869%2C+C1003ABQ+CABA!5e0!3m2!1ses-419!2sar!4v1508250156160" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
					</div>
					<div class="col-xs-12 col-sm-6">
						<div id="area-mensaje"></div>
						<form action="<?=site_url('contacto/alta_contacto')?>" method="POST" id="form-contactar">
							<div class="form-group">
								<label for="nombre">Nombre</label>
								<input type="text" class="form-control" id="nombre" name="nombre" placeholder="" required="required">
							</div>
							<div class="form-group">
								<label for="apellido">Apellido</label>
								<input type="text" class="form-control" id="apellido" name="apellido" placeholder="" required="required">
							</div>
							<div class="form-group">
								<label for="mail">Email</label>
								<input type="email" class="form-control" id="mail" name="mail" placeholder="" required="required">
							</div>
							<div class="form-group">
								<label for="mensaje">Mensaje</label>
								<textarea class="form-control" id="mensaje" name="mensaje" required="required"></textarea>
							</div>
							<button id="btn-contactar" type="submit" class="btn btn-amarillo btn-mas-padding">ENVIAR</button>
						</form>
					</div>
					<div style="clear:both"></div>
				</div>
			</div>
		</div>

		<div class="row">
				<img src="<?=base_url('assets/images/barra-contacto.jpg')?>" class="img-responsive">
		</div>
	</div>

	<div class="container-fluid contacto-footer">
		<div class="row">
			<div class="col-xs-12">
				<div class="col-xs-12"><img src="<?=base_url('assets/images/lemonlogo.png')?>" width="150px"></div>
				<div class="col-xs-12 col-sm-4 datos">RECONQUISTA 869, CABA</div>
				<div class="col-xs-12 col-sm-4 datos">011 4893-2535 (HASTA LAS 15.30)</div>
				<div class="col-xs-12 col-sm-4 datos">DAMIAN@LEMONCLUB.COM.AR</div>
				<div class="col-xs-12 copy">Copyright © 2017 LEMONCLUB. All rights reserved.</div>
				<div class="col-xs-12"><a href="<?=site_url('pages/menu')?>" class="btn btn-amarillo btn-mas-padding">IR AL MENÚ</a></div>
			</div>
		</div>
	</div>


<?php
$this->load->view('templates/footer');
?>
<script type="text/javascript">

$('#form-contactar').submit(function( event ) {
	event.preventDefault();
	$('#btn-contactar').button('loading');
	$('#area-mensaje').html("");
  	$.ajax({
       type: 'POST',
        data: $(event.target).serialize(),
        cache: false,
        dataType: 'json',
        processData: false, // Don't process the files
        //contentType: false, // Set content type to false as jQuery will tell the server its a query string request
       url: SITE_URL+"/contacto/alta_contacto",
       success: function(data){
          if(data.resultado == true)
          {
            var htmlData = '<div class="alert with-icon alert-success" role="alert"><i class="icon fa fa-exclamation-triangle"></i> ';
            htmlData += data.mensaje;
            htmlData += '</div>';
            $('#area-mensaje').html(htmlData);
          }
          else
          {
            var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i> ';
            htmlData += data.mensaje;
            htmlData += '</div>';
            $('#area-mensaje').html(htmlData);
          }
          $('#btn-contactar').button('reset');
       },
       error: function(x, status, error){
          	var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i> ';
            htmlData += " Error: " + error;
            htmlData += '</div>';
            $('#area-mensaje').html(htmlData);
            $('#btn-contactar').button('reset');
       }
  	});
});

</script>

</body>
</html>