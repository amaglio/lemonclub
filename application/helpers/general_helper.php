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
  