<?php
if (!defined( 'BASEPATH')) exit('No direct script access allowed'); 

class Chequear
{
	 	
	public function check_login()
	{	
		$CI =& get_instance();

        if( $CI->uri->segment(1) == 'Administrador' )
        {
        	if($CI->session->userdata('usuario_lemon') == false)
				redirect(base_url('index.php/login/index'));
        }

	}
}
/*
/end hooks/home.php
*/