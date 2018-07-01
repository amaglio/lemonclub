<link   type="text/css" href="<?php echo base_url(); ?>assets/css/dark-hive/jquery-ui-1.8.10.custom.css" rel="stylesheet" /> 

<style type="text/css">
	.error{
		color:red;
	}
 
	#div_ingrediente_seleccionado{
      display: none;
      background-color: rgba(60, 141, 188, 0.55);
      padding: 20px 20px 0px 20px;
      margin-left: 0px;
      border-top:1px solid silver;
      border:1px solid silver;
    }

</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<?php mensaje_resultado($mensaje); ?>

<div class="col-md-3">
	<div class="panel panel-default">
	  	<div class="panel-heading"><strong>Informacion del grupo</strong></div>
  		<div class="panel-body">

  			<form>
				<div class="form-group">
				    <label for="email">Nombre</label>
				    <input type="email" class="form-control" id="email" value="<?=$grupo_informacion['nombre']?>" readonly="readonly">
				</div>
				<div class="form-group">
				    <label for="pwd">Cantidad default</label>
            <input type="email" class="form-control" id="email" value="<?=$grupo_informacion['cantidad_default']?>" readonly="readonly">				  
        </div>
		 		<div class="form-group">
			    	<label for="pwd">Cantidad máxima</label>
			    	<input type="email" class="form-control" id="email" value="<?=$grupo_informacion['cantidad_minima']?>" readonly="readonly">
				</div>
        <div class="form-group">
            <label for="pwd">Cantidad minima</label>
            <input type="email" class="form-control" id="email" value="<?=$grupo_informacion['cantidad_maxima']?>" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="pwd">Precio adicional ($)</label>
            <input type="email" class="form-control" id="email" value="<?=$grupo_informacion['precio_adicional']?>" readonly="readonly">
        </div>
			</form>

  		</div>
	</div>

</div>

<div class="col-md-5">
  
	<div class="panel panel-default">
	  	<div class="panel-heading"><strong>Ingredientes del grupo</strong></div>
  		<div class="panel-body">
        
          
          <?php if(count($grupo_ingredientes) > 0 ): ?>

            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Nombre</th> 
                  <th></th> 
                </tr>
              </thead>
              <tbody>

              <?php foreach ($grupo_ingredientes as $row): ?>
          
                <tr>
                  <td><?=$row['nombre']?></td> 
                  <td>
                    <a class="btn btn-danger btn-xs" onclick="eliminar_ingrediente_grupo(<?=$row['id_ingrediente']?>,<?=$row['id_grupo']?>)">
                      Eliminar
                    </a>
                  </td> 
                </tr>

              <?php endforeach ?>

              </tbody>

            </table>

        <?php  else: ?>

              <div class="alert alert-danger">
                <strong>No hay ingredientes</strong>. Aún no se ha cargado ningún ingrediente al grupo.
              </div>

        <?php  endif;  ?> 

  		</div>
	</div>
 	 
</div>

<div class="col-md-4">

	<div class="panel panel-default">
	  	<div class="panel-heading"><strong>Agregar ingrediente</strong></div>
  		<div class="panel-body">

    		<form  name="form_agregar_ingrediente" id="form_agregar_ingrediente"  method="POST"  action="<?=base_url()?>index.php/administrador/agregar_ingrediente_grupo/" >

          <input type="hidden" class="form-control" name="id_grupo" id="id_grupo" value="<?=$grupo_informacion['id_grupo']?>" readonly="readonly">
  				
  				<div class="form-group">
  				    <label for="email">Ingrediente</label>
  				    <input type="text" class="form-control" id="ingrediente"  name="ingrediente" >
  				</div>

          <div class="form-group" id="div_ingrediente_seleccionado">
              <a class="btn btn-danger btn-xs" onclick="ocultar_ingrediente()"> <i class="fa fa-times" aria-hidden="true"> Eliminar </i></a> <input readonly="readonly" type="text" class="form-control" id="ingrediente_seleccionado"  name="ingrediente_seleccionado" >
              
              <input readonly="readonly" type="hidden" class="form-control" id="id_ingrediente" name="id_ingrediente" > <br>
              <div class="form-group">
                <input class="btn btn-primary" type="submit" value="Agregar Ingrediente" >
              </div>

  				</div>
   
  			</form>

  		</div>
	</div>
 	 
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<script language="javascript" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js" ></script>
<script language="javascript" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js" ></script> 

<script>
	var jq_va = jQuery.noConflict();
</script>


<script type="text/javascript">
	
	jq_va.validator.addMethod("seleccionar_ingrediente", 
      function(value, element) 
        {   
            var empresa_manual = jq_va( "#id_ingrediente" ).val().length; 
 

            if( empresa_manual<= 0 )
            {
              console.log("Falta empresa");
              return false;
            }
            else
            {
             
              console.log("Perfecto");
              return true;
            } 
           
        }, 
       "Debe seleccionar el ingrediente del listado o cargarlo desde el menu->ingrediente "
    );


	jq_va(function(){

            jq_va('#form_agregar_ingrediente').validate({

                rules :{

                        ingrediente: {
                            seleccionar_ingrediente : true
                        }

                },
                messages : {

                        ingrediente: {
                            seleccionar_ingrediente : "Debe seleccionar el ingrediente del listado o cargarlo desde el menu->ingrediente "
                        } 
                },
                invalidHandler: function(form, validator) {

                    jq_va('#form_agregar_ingrediente').find(":submit").removeAttr('disabled');
                },
			    submitHandler: function(form) {
			    
			    	form.submit();
			  	}   

            });    
    });  

</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.ui/1.12.1/jquery-ui.js"></script> 

<script>
  var jq_ui = jQuery.noConflict();
</script>



<script type="text/javascript">

 
 
    //-- EDUCACION 

    jq_ui('#ingrediente').autocomplete({
          
          minLength: 3,
          change: function( event, ui ) {
             //jq_ui('#div_educacion_manual').hide();
          },
          source:'<?php echo site_url('administrador/ajax_ingrediente'); ?>',
          select: function(event, ui) 
          {   
              jq_ui("#div_ingrediente_seleccionado").show();
              jq_ui("#id_ingrediente").val(ui.item.id_ingrediente);
              jq_ui("#ingrediente_seleccionado").val(ui.item.value);
              jq_ui('#ingrediente').attr('readonly', true);
              jq_ui('#ingrediente').val("");
              jq_ui( "#ingrediente_seleccionado" ).focus();

              jq_ui(this).val("");
              return false; // Importante, si esto no borra el input
            
          },
          response: function(event, ui) {

            //alert(ui.content.length);

            if (ui.content.length === 0) 
            {
                 jq_ui('#sin_resultado').show();
                 //jq_ui('#educacion').attr('readonly', true);

            } 
            else 
            {
                 jq_ui('#sin_resultado').hide();
            }

          }

    });

	   function ocultar_ingrediente()
    {
        jq_ui('#div_ingrediente_seleccionado').hide();
        jq_ui('#id_ingrediente').val("");
        jq_ui('#ingrediente_seleccionado').val("");
        jq_ui('#ingrediente').val("");
        jq_ui('#ingrediente').attr('readonly', false);
    }


</script>

<script type="text/javascript">

  function eliminar_ingrediente_grupo(id_ingrediente, id_grupo)
  {
    

    if (confirm('Seguro queres eliminar el ingrediente ?')) 
    { 
      $.ajax({
                  url: CI_ROOT+'index.php/administrador/eliminar_ingrediente_grupo',
                  data: { id_ingrediente: id_ingrediente, id_grupo: id_grupo },
                  async: true,
                  type: 'POST',
                  dataType: 'JSON',
                  success: function(data)
                  {
                    if(data.error == false)
                    {
                      alert("Se ha eliminado el ingrediente exitosamente");
                      location.reload();
                    }
                    else
                    {
                      alert("No se ha eliminado el ingrediente");
                      location.reload();
                    }
                  },
                  error: function(x, status, error){
                    alert("error");
                  }
            });
    }
  }

</script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
