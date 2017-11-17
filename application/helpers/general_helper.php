<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
// Titulos de la pagina del admin
if(!function_exists('traer_titulo'))
{
    //formateamos la fecha y la hora, función de cesarcancino.com
    function traer_titulo($controlador )
    {   
        
      
 		switch ($controlador) {
            
            case 'index':
                $titulo = " Bienvenido al <strong>  Administrador de Lemon Club </strong> <br> Desde aquí podrá administrar los  <strong> productos, ingredientes y pedidos  </strong> del restaurant.";
                break;

            case 'productos':
                $titulo = "Agregá, modificá o eliminá los <strong>productos</strong> de tu carta.";
                break;

            case 'agregar_ingrediente':
                $titulo = "Agregá los ingredientes que se pueden incluir en este <strong>producto</strong>.";
                break;
            
            case 'ingredientes':
                $titulo = "Agregá, modificá o eliminá los <strong>ingredientes</strong> que se pueden incluir en tus <strong>productos</strong>.";
                break;

            case 'pedidos':
                $titulo = "Administrá los <strong>pedidos</strong> recibidos.";
                break;

            case 'usuarios':
                $titulo = "Administrá los <strong>usuarios</strong> del sistema.";
                break;

            case 'tipos_productos':
                $titulo = "Agregá, modificá o eliminá los <strong>tipos de platos</strong> del menu.";
                break;

            case 'tipos_ingredientes':
                $titulo = "Agregá, modificá o eliminá los <strong>tipos de ingredientes</strong>.";
                break;

            case 'usuarios_registrados':
                $titulo = "Gestioná los <strong>usuarios registrados</strong> en el sistema.</strong>.";
                break;

            case 'usuarios_invitados':
                $titulo = "Gestioná los <strong>usuarios que realizaron pedidos como invitados</strong>.";
                break;

            default:
               $titulo = " Bienvenido al <strong>  Administrador de Lemon Club </strong> <br> Desde aquí podrá administrar los  <strong> productos, ingredientes y pedidos  </strong> del restaurant.";
                break;
        }
    
    	return $titulo;	
	 
    		
    }
}


//si no existe la función invierte_date_time la creamos
if(!function_exists('esta_logueado'))
{
    //formateamos la fecha y la hora, función de cesarcancino.com
    function esta_logueado()
    {
        $CI =& get_instance();

        if(!$CI->session->userdata('usuario_tesoreria'))
            redirect(base_url()."index.php/login/logout");
            
    }
}


/*
if(!function_exists('enviar_email'))
{
    function enviar_email($email_to, $mensaje, $asunto )
    {   
        $CI =& get_instance();

        $CI->load->library("email"); 

        $configuracion_gmail = array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://smtp.googlemail.com',
                'smtp_port' => 465,
                'smtp_user' => 'digipayargentina@gmail.com',
                'smtp_pass' => 'digipay2016',
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'newline' => "\r\n"
            );

        //Cargamos la configuración 

        $CI->email->initialize($configuracion_gmail);
        $CI->email->from("lemonclub@gmail.com");
        $CI->email->subject($asunto);     
        $CI->email->to($email_to);  

        $CI->email->message($mensaje);
        
        if( $CI->email->send() ):

            chrome_log("ENVIO EL EMAIL"); 
            return true;
         
        else:
            
            chrome_log("NO ENVIO EL EMAIL");
            return false;
        
        endif;  
    }
}*/

if(!function_exists('enviar_email'))
{
    function enviar_email($email_to, $mensaje, $asunto )
    {   
         //para el envío en formato HTML 
        $headers = "MIME-Version: 1.0\r\n"; 
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

        //dirección del remitente 
        $headers .= "From: Web <pepito@desarrolloweb.com>\r\n"; 

        //dirección de respuesta, si queremos que sea distinta que la del remitente 
        $headers .= "Reply-To: mariano@desarrolloweb.com\r\n"; 

        //ruta del mensaje desde origen a destino 
        $headers .= "Return-path: holahola@desarrolloweb.com\r\n"; 

        //direcciones que recibián copia 
       // $headers .= "Cc: maria@desarrolloweb.com\r\n"; 

        //direcciones que recibirán copia oculta 
        //$headers .= "Bcc: pepe@pepe.com,juan@juan.com\r\n"; 

        if(mail($email_to,$asunto,$mensaje,$headers)):

            chrome_log("ENVIO EL EMAIL A"); 
            return true;
         
        else:
            
            chrome_log("NO ENVIO EL EMAIL2");
            return false;
        
        endif;  
    }
}

// Mensaje de error de las variables flash session
if(!function_exists('mensaje_resultado'))
{
    function mensaje_resultado($mensaje)
    {
        if ($mensaje): ?>
            <div class="col-md-12">
                <div class="alert alert-success mensaje_resultado" style="padding:5px 30px 5px 15px">
                  <h5 style="color:#000; font-weight:bold"><?=$mensaje?></h5>
                </div>
            </div>
        <? endif;  
    }
}