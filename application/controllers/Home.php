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

}