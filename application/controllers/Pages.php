<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

	public function index()
	{
		$this->load->view('pages/index');
	}

	public function menu()
	{
		$this->load->view('pages/menu');
	}

	public function contacto()
	{
		$this->load->view('pages/contacto');
	}

	public function carrito()
	{
		$this->load->view('pages/carrito');
	}

	public function confirmar_pedido()
	{
		$this->load->view('pages/confirmar_pedido');
	}

	public function construccion()
	{
		$this->load->view('construccion');
	}
}
