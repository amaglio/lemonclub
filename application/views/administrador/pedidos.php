<link   type="text/css" href="<?php echo base_url(); ?>assets/css/dark-hive/jquery-ui-1.8.10.custom.css" rel="stylesheet" /> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>



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

    .estados_pedido{
      font-weight: bold;
      background-color: #80808012;
      padding-left: 50px;
      margin-left: 
    }

    .panel-default>.panel-heading{
      background-color:black;

    }
    
    .h4, h4, h5{
      color: white;
    }

</style>

 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<? echo $menu_pedidos; ?>

<? echo "<div class='col-md-12'>".mensaje_resultado($mensaje)."</div>";

  $i=0;

  //var_dump($pedidos);

if( count($pedidos) > 0):

  foreach ($pedidos as $row) 
  {  
        if(! ($i % 4) ){

          if(! ($i % 4) && $i != 0 ) echo "</div>";

          echo "<div class='row col-md-12'>";
        } ?>
        
        <form autocomplete="off" id="form_cambiar_estado_<?=$row['informacion_pedido']['id_pedido']?>" method="post" action="<?=base_url()?>index.php/pedido/procesa_cambiar_estado_pedido">
          
          <div class="col-md-3">
            
            <input type="hidden" name="id_pedido" id="id_pedido" value="<?=$row['informacion_pedido']['id_pedido']?>" >
            <div class="panel panel-default">

                  <div class="panel-heading text-center">

                      <h4>Pedido: <strong><?=$row['informacion_pedido']['id_pedido']?></strong></h4> <i class="fa fa-print" aria-hidden="true"></i>
                      <h5><strong>[ <?=$row['informacion_pedido']['email']?> ]</strong>
                      <? if(isset($row['informacion_pedido']['nombre'])) echo '<i class="fa fa-registered" aria-hidden="true"></i>';?> 
                        
                      </h5>
                  </div>
                  <div class="panel-body">



                          <?
                            foreach ($row['productos'] as $row2) 
                            { ?>
                                <div class="col-md-12">
                                    <strong><?=$row2['nombre']?></strong>
                                    <div class="pull-right"><span>$</span><span><?=$row2['precio']?></span></div>
                                </div>
                          <?
                            }
                          ?>

                          <div class="col-md-12">
                              <small>- <?=$row['informacion_pedido']['forma_pago']?></small><br>
                              <small>- <?=$row['informacion_pedido']['forma_entrega']?></small><br>
                              <small>- <?=$row['informacion_pedido']['fecha_entrega']?></small><br>
                              <small>- <?=$row['informacion_pedido']['fecha_pedido']?></small>
                              
                              <? if($row['informacion_pedido']['forma_entrega'] == 'Delivery'): ?>
                                  
                                  <div class="pull-right">
                                      <? if(isset($row['informacion_pedido']['direccion']))?>
                                            <span><small><?="(".$row['informacion_pedido']['direccion']." ".$row['informacion_pedido']['nota'].")"?></small></span>

                                  </div>

                              <?  endif;  ?>
                              <hr>
                          </div>

                          <div class="col-md-12">
                              <strong>Total</strong>
                              <div class="pull-right"><span>$</span><span style="font-size:20px; font-weight:bold"> <?=$row['total_pedido']?> </span></div>
                              <hr>
                          </div>
                          

                          <!-- <button type="button" class="btn btn-primary btn-lg btn-block">Checkout</button>-->
                            <?  $estados = array(); ?>
                                          
                            <?  foreach ($estados_pedidos as $row3):  

                                  
                                    $estados[$row3['id_pedido_estado']] = strtoupper($row3['descripcion']);

                                endforeach; 
                               
                                echo form_dropdown('id_pedido_estado', $estados, $row['informacion_pedido']['id_pedido_estado']  ,'class="form-control estados_pedido" id="id_estado_cons_prg" name="id_estado_cons_prg" style="height:40px; font-size:15px; padding:0px" ' ); 
                            ?>

                            <button type="submit" class="btn btn-primary btn-lg btn-block">Cambiar</button>
                          
                  </div>
                  
              </div>

          </div>
        
        </form>

      <?  
      $i++;
  } 

else: ?>
  
   <div class="col-md-12">
        <div class="alert alert-danger" style="padding:5px 30px 5px 15px">
          <h5 style="color:#000; font-weight:bold">No hay pedidos que cumplan los filtros</h5>
        </div>
    </div>

<?
endif;

?>
 

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

    jq_ui('#ingrediente').autocomplete({
          source:'<?php echo site_url('administrador/ajax_ingrediente'); ?>',
          select: function(event, ui) 
          {   
              $(ui.item.mensaje).appendTo("#programas_elegidos");
              $("#ingrediente").val("");
          } 

    });

 
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
    jq_ui(function() 
    {
        jq_ui( ".mensaje_resultado" ).hide( 8000, function() {
            jq_ui( ".mensaje_resultado" ).remove();
        });

    });

  
</script>