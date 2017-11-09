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



<div class="col-md-3">
	 aaaaaa

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