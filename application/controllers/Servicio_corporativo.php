<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Servicio_corporativo extends CI_Controller {

	private static $solapa = "servicio_corporativo";

	public function __construct()
	{
		parent::__construct();

		$this->load->model('pedido_model');
		$this->load->model('producto_model');
		$this->load->model('Usuario_model');

 
	}

	public function index()
	{
		$this->load->view('construccion');
	}

 

}