<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	private static $solapa = "home";

	public function __construct()
	{
		parent::__construct();

		$this->load->model('pedido_model');
		$this->load->model('producto_model');
		$this->load->model('Usuario_model');
	}

 	public function index()
	{
		$this->load->view(self::$solapa.'/index');
	}

}