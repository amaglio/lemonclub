<?php
if (!defined( 'BASEPATH')) exit('No direct script access allowed'); 

class Chequear extends CI_Controller
{
	 	
	public function check_login()
	{	
		$CI =& get_instance();

		
		/*!$CI->load->library('session') ? $CI->load->library('session') : false;
		!$CI->load->helper('url') ? $CI->load->helper('url') : false;
        
        //echo $CI->session->userdata('usuario_crm');

        if( $CI->session->userdata('usuario_lemon') == false && ( $CI->uri->segment(1) != 'login' &&  $CI->uri->segment(1) != 'login' ) )
        {
        	redirect(base_url('index.php/login/login'));
        }*/

	}
}
/*
/end hooks/home.php
*/