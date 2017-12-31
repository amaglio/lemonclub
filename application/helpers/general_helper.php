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
        $CI =& get_instance();
    
        $CI->load->library('email'); // load library 

        //$config['mailtype'] = 'html';
        $configuracion_ucema = array(
            'protocol' => 'smtp',
            'smtp_host' => '10.0.0.3',
            'smtp_port' => 25,
            'smtp_user' => '',
            'smtp_pass' => '',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        );

        $CI->email->initialize($configuracion_ucema);
        
        $CI->email->from('info@lemonclub.com.ar', 'Lemon Club');
        $CI->email->to($email_to);
        //$CI->email->cc("contacto@3ddos.com.ar");
        //$CI->email->cc('another@another-example.com');
        //$CI->email->bcc('them@their-example.com');

        $CI->email->subject($asunto);

        $cuerpo = "<table width='100%' border='0' cellpadding='0' cellspacing='0' align='center' style='font-family: Arial, sans-serif;'>
            <tr>
                <td width='100%' valign='top' bgcolor='#ffffff' style='padding-top:20px'>";

        $cuerpo .= "<table width='580' bgcolor='#222222' border='0' cellpadding='0' cellspacing='0' align='center'>
                <tr>
                    <td style='padding:0; text-align:center;'>
                        <a href='".site_url()."'><img src='".base_url('assets/images/lemonlogo.png')."' alt='' border='0' width='100px' style='margin:auto;'/></a>
                    </td>
                </tr>
            </table>";
                    
        $cuerpo .= "<!-- One Column -->
                    <table width='580' border='0' cellpadding='0' cellspacing='0' align='center' bgcolor='#FFC50A'>
                        <tr>
                            <td valign='top' style='padding:10px; color:#333333; text-align:left;' bgcolor='#FFC50A'>
                                ".$mensaje."
                            </td>
                        </tr>           
                    </table>";

        $cuerpo .= "<table width='580' border='0' cellpadding='0' cellspacing='0' align='center' bgcolor='#fff'>
                <tr>
                    <td style='font-size: 9px; font-weight: normal; line-height: 12px; vertical-align: top;'>
                        <p style='color:#bf9415; padding:25px 10px;'>
                            Para m&aacute;s informaci&oacute;n, ingres&aacute; en ".site_url()."<br/>&copy; Lemon Club. Todos los derechos reservados.
                        </p>
                    </td>
                </tr>
            </table>";
                          
        $cuerpo .= "</td>
            </tr>
        </table>";

        $CI->email->message($cuerpo); 

        if ( ! $CI->email->send())
        {
            return false;
        }
        return true;
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