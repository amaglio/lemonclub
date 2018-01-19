<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	private static $solapa = "home";

	public function __construct()
	{
		parent::__construct();

		$this->load->model('pedido_model');
		$this->load->model('producto_model');
		$this->load->model('Usuario_model');
		$this->load->model('producto_tipo_model');
	}

 	public function index()
	{
		$data['tipos'] = $this->producto_tipo_model->get_items();

		$this->load->view(self::$solapa.'/index', $data);
	}

	public function enviar_email()
	{	
		$email_to = 'adrian.magliola@gmail.com';
		$mensaje = "SI"; 
		$asunto = "Prueba";

		$CI =& get_instance();
    
        $CI->load->library('email'); // load library 
 
        // $configuracion = array(
        //         'protocol' => 'smtp',
        //         'smtp_host' => 'ssl://smtp.googlemail.com',
        //         'smtp_port' => 465,
        //         'smtp_user' => 'digipayargentina@gmail.com',
        //         'smtp_pass' => 'digipay2016',
        //         'mailtype' => 'html',
        //         'charset' => 'utf-8',
        //         'newline' => "\r\n"
        //     );

        // $configuracion = array(
        //     'protocol' => 'smtp',
        //     'smtp_host' => '10.0.0.3',
        //     'smtp_port' => 25,
        //     'smtp_user' => '',
        //     'smtp_pass' => '',
        //     'mailtype' => 'html',
        //     'charset' => 'utf-8',
        //     'newline' => "\r\n"
        // );
        
      
        $configuracion = array(
                        'protocol' => 'smtp',
                        'smtp_host' => 'mail.lemonclub.com.ar',
                        'smtp_port' => 587, 
                        'smtp_user' => 'info@lemonclub.com.ar',
                        'smtp_pass' => 'Webemail2018',
                        'mailtype' => 'html',
                        'charset' => 'utf-8',
                        'newline' => "\r\n" ,
                        'smtp_timeout' => 30,
                    ); 
 

        $CI->email->initialize($configuracion);

        // NO FUNCIONA ---
            // $config['protocol'] = 'sendmail';
            // $config['mailpath'] = '/usr/sbin/sendmail';
            // $config['charset'] = 'utf-8';
            // $config['wordwrap'] = TRUE;

            // $CI->email->initialize($config);
        //------------------------------

        
        $CI->email->from('no-reply@c0920276.ferozo.com');
        $CI->email->to($email_to); 

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
        	echo $this->email->print_debugger();
            chrome_log("send false3");
       
        }
        else{
            //echo "BIEN";
            chrome_log("send true3s");
            return TRUE;
        }
  
	}

}