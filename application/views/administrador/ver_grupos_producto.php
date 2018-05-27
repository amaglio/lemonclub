<link   type="text/css" href="<?php echo base_url(); ?>assets/css/dark-hive/jquery-ui-1.8.10.custom.css" rel="stylesheet" /> 

<style type="text/css">
	.error{
		color:red;
	}
 
	#div_grupo_seleccionado{
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


<div class="col-md-3">
	<div class="panel panel-default">
	  	<div class="panel-heading"><strong>Informacion del producto</strong></div>
  		<div class="panel-body">

  			<form>
				<div class="form-group">
				    <label for="email">Producto</label>
				    <input type="email" class="form-control" id="email" value="<?=$producto_info->nombre?>" readonly="readonly">
				</div>
				<div class="form-group">
				    <label for="pwd">Descripcion</label>
				    <textarea class="form-control" readonly="readonly"><?=$producto_info->descripcion?></textarea>
				  </div>
		 		<div class="form-group">
			    	<label for="pwd">Precio</label>
			    	<input type="email" class="form-control" id="email" value="<?=$producto_info->precio?>" readonly="readonly">
				</div>
			</form>

  		</div>
	</div>

</div>
<div class="col-md-5">
  <? mensaje_resultado($mensaje); ?>
	<div class="panel panel-default">
	  	<div class="panel-heading"><strong>Grupos del producto</strong></div>
  		<div class="panel-body">

  			<?php if(count($grupos_ingredientes) > 0): ?>
				    
            <table class="table table-striped">
               
              <tbody>

              <?php for ($i=0; $i < count($grupos_ingredientes) ; $i++): ?>

                <?php $grupo = $grupos_ingredientes[$i]['informacion_grupo'];  ?>

                      <tr style="background-color: #80808059">
                        <th><?=$grupo['nombre']?></th> 
                        <td>
                          <a class="btn btn-danger btn-xs" onclick="eliminar_grupo_producto(<?=$grupo['id_producto']?>,<?=$grupo['id_grupo']?>)">
                            Eliminar
                          </a>
                        </td> 
                      </tr>
                      <tr>
                        <td colspan="2">
                          <table class="table table-striped">
                            <tr style="font-size: 12px">
                              <th>Ingrediente</th> 
                              <th>Fijo</th> 
                              <th>Default</th>
                            </tr>
                          <?php foreach ( $grupos_ingredientes[$i]['ingredientes_grupo'] as $ingrediente): ?>
                            <tr>
                              <td><?=$ingrediente['nombre']?></td> 
                              <td><input type="checkbox" name="fijo" value="1" ></td> 
                              <td><input type="checkbox" name="fijo" value="1" ></td>
                            </tr>


                          <?php endforeach; ?>
                          </table>
                        </td>
                      </tr>
              <?php endfor; ?>

              <?php /* foreach ($grupos_producto as $row): ?>
          
                <tr>
                  <td><?=$row['nombre']?></td> 
                  <td>
                    <a class="btn btn-danger btn-xs" onclick="eliminar_grupo_producto(<?=$row['id_producto']?>,<?=$row['id_grupo']?>)">
                      Eliminar
                    </a>
                  </td> 
                </tr>

              <?php endforeach */?>

              </tbody>

            </table>		

        <?php else: ?>

					<div class="alert alert-danger alert-dismissable"> 
					   Aún no hay grupos en el producto
					</div>

  			<?php endif; ?>

  		</div>
	</div>
 	 
</div>

<div class="col-md-4">

	<div class="panel panel-default">
	  	<div class="panel-heading"><strong>Agregar grupo</strong></div>
  		<div class="panel-body">

  			<form  name="form_agregar_grupo" id="form_agregar_grupo"  method="POST"  action="<?=base_url()?>index.php/administrador/agregar_grupo_producto/" >

          <input type="hidden" class="form-control" name="id_producto" id="id_producto" value="<?=$producto_info->id_producto?>" readonly="readonly">
  				
  				<div class="form-group">
  				    <label for="email">Grupo</label>
  				    <input type="text" class="form-control" id="grupo"  name="grupo" >
  				</div>

          <div class="form-group" id="div_grupo_seleccionado">
              <a class="btn btn-danger btn-xs" onclick="ocultar_grupo()"> 
                  <i class="fa fa-times" aria-hidden="true"> </i> Eliminar
              </a> 

              <input readonly="readonly" type="text" class="form-control" id="grupo_seleccionado"  name="grupo_seleccionado" >
              
              <input readonly="readonly" type="hidden" class="form-control" id="id_grupo" name="id_grupo" > <br>
  				
   
      				<div class="form-group">
      				    <input class="btn btn-primary" type="submit" value="Agregar grupo" >
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
	
	jq_va.validator.addMethod("seleccionar_grupo", 
      function(value, element) 
        {   
            var empresa_manual = jq_va( "#id_grupo" ).val().length; 
 

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
       "Debe seleccionar el grupo del listado o cargarlo desde el menu->grupo "
    );


	jq_va(function(){

            jq_va('#form_agregar_grupo').validate({

                rules :{

                        grupo: {
                            seleccionar_grupo : true
                        }

                },
                messages : {

                        grupo: {
                            seleccionar_grupo : "Debe seleccionar el grupo del listado o cargarlo desde el menu->grupo "
                        } 
                },
                invalidHandler: function(form, validator) {

                    jq_va('#form_agregar_grupo').find(":submit").removeAttr('disabled');
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

    jq_ui('#grupo').autocomplete({
          source:'<?php echo site_url('administrador/ajax_grupo'); ?>',
          select: function(event, ui) 
          {   
              $(ui.item.mensaje).appendTo("#programas_elegidos");
              $("#grupo").val("");
          } 

    });

 
    //-- EDUCACION 

    jq_ui('#grupo').autocomplete({
          
          minLength: 3,
          change: function( event, ui ) {
             //jq_ui('#div_educacion_manual').hide();
          },
          source:'<?php echo site_url('administrador/ajax_grupo'); ?>',
          select: function(event, ui) 
          {   
              jq_ui("#div_grupo_seleccionado").show();
              jq_ui("#id_grupo").val(ui.item.id_grupo);
              jq_ui("#grupo_seleccionado").val(ui.item.value);
              jq_ui('#grupo').attr('readonly', true);
              jq_ui('#grupo').val("");
              jq_ui( "#grupo_seleccionado" ).focus();

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

	function ocultar_grupo()
    {
        jq_ui('#div_grupo_seleccionado').hide();
        jq_ui('#id_grupo').val("");
        jq_ui('#grupo_seleccionado').val("");
        jq_ui('#grupo').val("");
        jq_ui('#grupo').attr('readonly', false);
    }


</script>

<script type="text/javascript">

  function eliminar_grupo_producto(id_producto, id_grupo)
  {
    
    if (confirm('Seguro queres eliminar el grupo del producto ?')) 
    { 
      $.ajax({
                  url: CI_ROOT+'index.php/administrador/eliminar_grupo_producto',
                  data: { id_producto: id_producto, id_grupo: id_grupo },
                  async: true,
                  type: 'POST',
                  dataType: 'JSON',
                  success: function(data)
                  {
                    if(data.error == false)
                    {
                      alert("Se ha eliminado el grupo del producto");
                      location.reload();
                    }
                    else
                    {
                      alert("No se ha eliminado el grupo");
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
