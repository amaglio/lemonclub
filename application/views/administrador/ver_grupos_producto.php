<link   type="text/css" href="<?php echo base_url(); ?>assets/css/dark-hive/jquery-ui-1.8.10.custom.css" rel="stylesheet" /> 

<style type="text/css">
  .error{
    color:red;
        font-size: 13px;

  }
 
  #div_grupo_seleccionado{
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


  </style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<?php mensaje_resultado($mensaje); ?>
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
  
  <div class="panel panel-default">

      <div class="panel-heading"><strong>Grupos del producto</strong></div>

      <div class="panel-body">

        <?php if(count($grupos_ingredientes) > 0): ?>
            

              <?php for ($i=0; $i < count($grupos_ingredientes) ; $i++): ?>

                <?php $grupo = $grupos_ingredientes[$i]['informacion_grupo'];  ?>
                    
                    <div class="row ">
                      
                        <div class="col-md-5 nombre_grupo"   > 
                            <?=ucfirst($grupo['nombre'])?><br>
                            <a class="btn btn-danger btn-xs " onclick="eliminar_grupo_producto(<?=$grupo['id_producto']?>,<?=$grupo['id_grupo']?>)">
                            <i class="fa fa-trash fa-1x" ></i>  Eliminar 
                          </a>
                        </div>
                        <div class="col-md-6" style="border-top: 1px solid #dedede;">
                          <table class="table table-responsive" style="    font-size: 12px;">
                              <thead>
                                <tr>
                                  <th>Minima</th>
                                  <th>Maxima</th>
                                  <th>Default</th>
                                  <th>Adicional</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr style="text-align: center;">
                                  <td><?=$grupo['cantidad_minima']?></td>
                                  <td><?=$grupo['cantidad_maxima']?></td>
                                  <td><?=$grupo['cantidad_default']?></td>
                                  <td>$<?=$grupo['precio_adicional']?></td>
                                </tr>
                              </tbody>
                          </table> 
                        </div>
                      
                    </div>
 
                    
                    <?php $w=0; ?>
                    <?php    foreach ( $grupos_ingredientes[$i]['ingredientes_grupo'] as $ingrediente):?>

                                <?/*
                                <form method="post"

                                      name="form_configuracion_ingrediente_producto_<?=$ingrediente['id_producto']?>_<?=$ingrediente['id_grupo']?>_<?=$ingrediente['id_ingrediente']?>" 

                                      id="form_configuracion_ingrediente_producto_<?=$ingrediente['id_producto']?>_<?=$ingrediente['id_grupo']?>_<?=$ingrediente['id_ingrediente']?>"  

                                      class="form_configuracion_ingrediente"
                                > */ ?>
                                  
                                    <input type="hidden" name="id_producto" value="<?=$ingrediente['id_producto']?>">
                                    <input type="hidden" name="id_grupo" value="<?=$ingrediente['id_grupo']?>">
                                    <input type="hidden" name="id_ingrediente" value="<?=$ingrediente['id_ingrediente']?>">

                                    <?php if($w==0): ?>
                                      <div class="row" style="font-size: 12px; font-weight: bold">
                                        <div class="col-md-3">   </div >
                                         <div class="col-md-3">  </div >  
                                        <div class="col-md-3">  Fijo</div > 
                                        <div class="col-md-3">  Default</div > 
                                      </div>
                                     <?php endif; ?>

                                    <div class="row" style="padding: 5px">
                                      <div class="col-md-3"> <img   style="width:100px; margin-bottom:10px" src="<?=base_url()?>assets/images/productos/<?=$ingrediente['path_imagen']?>"  > </div>
                                      <div class="col-md-3"> <?=ucfirst($ingrediente['nombre'])?></div > 
                                      <div class="col-md-3"> 

                                        <input  type="checkbox" class="checkbox" name="es_fijo" id="es_fijo" value="<?=$ingrediente['id_producto']?>_<?=$ingrediente['id_grupo']?>_<?=$ingrediente['id_ingrediente']?>" <? if( $ingrediente['es_fijo'] ==1 ) echo "checked='checked'"; ?> >

                                      </div > 
                                      <div class="col-md-3"> 

                                        <input  type="checkbox" class="checkbox" name="es_default" id="es_default" value="<?=$ingrediente['id_producto']?>_<?=$ingrediente['id_grupo']?>_<?=$ingrediente['id_ingrediente']?>" <? if( $ingrediente['es_default'] ==1 ) echo "checked='checked'"; ?> >

                                      </div> 
                                    </div >

                                <?/*
                                </form> */ ?>

                              

                          <?php
                              $w++;

                              endforeach;  ?>

                          <?php $w=0; ?>
                        
              <?php endfor; ?>
    

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
              <label for="email">Buscar grupo</label>
              <input type="text" class="form-control" id="grupo"  name="grupo" >
          </div>

          <div class="form-group" id="div_grupo_seleccionado">
             

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

 
  jq_va('.form_configuracion_ingrediente').each( function(){ 
        
        var form1 = jq_va(this);

        //alert(form1.attr("name"));

        form1.validate({

              rules: {

                fijo: {
                  require_from_group: [1, ".phone-group"]
                },
                default: {
                  require_from_group: [1, ".phone-group"]
                } 

              },
              submitHandler: function (form) 
              {
 
                  var formulario = '#'+form.name; 
                  var values = $(formulario).serialize();
 
 
                  jq_va.ajax({
                      url: CI_ROOT+'index.php/administrador/configuracion_ingrediente_producto',
                      data: values,
                      async: true,
                      type: 'POST',
                      dataType: 'JSON' ,
                      success: function(data)
                      { 
                        if(data.error == false)
                        {
                          alert("Se ha configurado el ingrediente exitosamente");
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

    function eliminar_grupo(id_producto, id_grupo)
    {
      $.ajax({
         type: 'POST',
          data: jQuery.param({ id_producto:id_producto, id_grupo:id_grupo}),
          cache: false,
          dataType: 'json',
          processData: false, // Don't process the files
          //contentType: false, // Set content type to false as jQuery will tell the server its a query string request
         url: "<?php echo site_url('administrador/ajax_eliminar_grupo_producto'); ?>",
         success: function(data){
          //alert(JSON.stringify(data));
            if(data.error == false)
            {
              location.reload();
            }
            else
            {
              alert(data.mensaje);
            }
         },
         error: function(x, status, error){
              alert(error);
         }
      });
    }

    
    jq_ui(".checkbox").change(function() {
        
        var accion;
        var campo;

        if(this.checked) 
          accion = 1; // agregar
        else
          accion = 0; // eliminar

        //alert(this.value);
        //alert(this.name);

        campo = this.name;

        valor = this.value.split('_');

        var id_producto = valor[0] ;
        var id_grupo = valor[1] ;
        var id_ingrediente = valor[2] ;

        var input_checkbox = this;

        var div_respuesta = 'div_respuesta'+$.now();


        $.ajax({
                  url: CI_ROOT+'index.php/administrador/set_producto_grupo_ingrediente',  
                  data: { id_producto: id_producto,
                          id_grupo: id_grupo , 
                          id_ingrediente : id_ingrediente,
                          accion : accion,
                          campo: campo
                        },
                  async: true,
                  type: 'POST',
                  dataType: 'JSON',
                  success: function(data)
                  {
                    if(data.error == false)
                    {
                      //alert("Cambio exitoso"); 
                      texto_respuesta = "Cambio exitoso";
                    }
                    else
                    {
                      //alert("Error al cambiar");
                      texto_respuesta = "Error al cambiar";
                    }

                    $(input_checkbox).append("<div id='"+div_respuesta+"' class='div_respuesta'>"+texto_respuesta+"</div>");

                    //$('#div_respuesta').remove();

                    $( '#'+div_respuesta ).fadeOut( 1700, function() {
                     
                      $( div_respuesta ).remove();

                    });


                  },
                  error: function(x, status, error){
                    alert("error");
                  }
            });    
           
    });

   
    jq_ui( "#grupo" ).focusin(function() {

      jq_ui('#div_grupo_seleccionado').hide();
        jq_ui('#id_grupo').val("");
        jq_ui('#grupo_seleccionado').val("");
        jq_ui('#grupo').val("");
        jq_ui('#grupo').attr('readonly', false);
    });

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

  function dump(obj) {
    var out = '';
    for (var i in obj) {
        out += i + ": " + obj[i] + "\n";
    }

    alert(out);

    // or, if you wanted to avoid alerts...

    var pre = document.createElement('pre');
    pre.innerHTML = out;
    document.body.appendChild(pre)
  }



</script>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
