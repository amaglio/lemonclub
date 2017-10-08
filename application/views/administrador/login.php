<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>LEMONCLUB | Administradorr </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
     
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


    <style type="text/css">
     .login-box, .register-box{
        width:360px;
        margin:7% auto;
        background-color: rgba(0, 0, 0, 0.55);
        padding: 50px;
     }

     .login-logo{
      text-align: center;
      padding-bottom: 20px;
     }

     .login-box-msg{
      color:white;
     }

      label.error {
        color: red;
        background-color: rgba(0, 0, 0, 0.98);
        width: -webkit-fill-available;
        padding: 5px;
        font-size: 12px;
      }
          
    </style>
 
  </head>
  <body class="login-page" style=" background-image: url('<?=base_url()?>assets/images/fondos/fondo_admin.jpg');  background-repeat: no-repeat;">
    
    <div class="login-box">
      <div class="login-logo">
        <img src="<?=base_url()?>assets/images/lemonlogo.png" style="height:169px; widht:244px;"> 
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        
        <p class="login-box-msg">Loguearse para iniciar sesion.</p>
        
        <form autocomplete="off" id="form_logueo" method="post" action="<?=base_url()?>index.php/login/procesa_logueo">

            <div class="form-group has-feedback">
           
              <input autocomplete="false"  type="text" id="usuario" name="usuario" class="form-control" placeholder="Usuario"/>
           
            </div>
            
            <div class="form-group has-feedback">
           
              <input type="password" id="clave" name="clave" class="form-control" placeholder="Password"/>
           
            </div>

            <div class="row">
           
              <div class="col-xs-12">
                <button type="submit" class="btn btn-block btn-primary "> Ingresar <div id="cargando" class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></div> </button> 
              </div><!-- /.col -->
           
            </div>
        
        </form>

      </div> 

  

  </body>
  
  <!-- Jquery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <!--Bootstrap -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  
  <!--Jquery validate -->
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js" ></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/additional-methods.min.js" ></script>

   <script>
            var q = jQuery.noConflict();
    </script>



  <script language="javascript" type="text/javascript" >

      
      q(function(){

        q("#cargando").hide();   
      });

      q(function(){

              q('#form_logueo').validate({

                  rules :{

                          usuario : {
                              required : true
                          },
                          clave : {
                              required : true
                          }
                  },
                  messages : {

                          usuario : {
                              required : "Debe ingresar su usuario."
                          },

                          clave : {
                              required :  "Debe ingresar su clave."
                          }
                  },
                   submitHandler: function(form) {
                      // do other things for a valid form
                      //$("#btnAddProfile").prop('value', );
                      q('#cargando').show();
                      form.submit();
                     
                  }

              });    
      }); 

   

    </script>
  
</html>