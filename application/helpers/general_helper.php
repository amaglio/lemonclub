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
                $titulo = "Agregar, modifica o elimina los <strong>productos</strong> de tu carta.";
                break;

            case 'agregar_ingrediente':
                $titulo = "Agregue los ingredientes que puede incluir su <strong>producto</strong>.";
                break;
            
            case 'ingredientes':
                $titulo = "Agregue los ingredientes que se pueden incluir en tus <strong>productos</strong>.";
                break;

            case 'pedidos':
                $titulo = "Administre los pedidos recibidos";
                break;
            
            default:
                # code...
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
  