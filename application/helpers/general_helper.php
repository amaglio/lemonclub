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

if(!function_exists('enviar_email'))
{
    function enviar_email($email_to, $token )
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
        $CI->email->subject('Lemon Club - usuario invitado');

        $enlace = base_url().'index.php/usuario/procesa_validar_usuario_invitado/'.$email_to.'/'.$token;

        $mensaje =  '<h2>TERMINÁ TU PEDIDO!</h2><hr><br>';
        $mensaje .= 'Has recibido este e-mail por que se efectuó una solicitud para realizar un pedido como usuario invitado en lemonclub.com.<br>';

        $mensaje .= 'En caso de querer continuar con el proceso de compra, haga click el siguiente link  <a href="'.$enlace.'"> Validar Email </a>.<br>';

        $mensaje .= '<h4>Gracias por elegirnos y recordá que podes REGISTRARTE a lemonclub.com y hacer tu pedido mas fácil. </h4> ';

        $mensaje .= 'Si usted no lo pidió, puede ignorar este mensaje.<br>';

        $mensaje  = html_entity_decode( $mensaje , ENT_QUOTES, "UTF-8");
       
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
}
  