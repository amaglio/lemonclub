<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

	public function index()
	{
		$this->load->view('pages/index');
	}

	public function contacto()
	{
		$this->load->view('pages/contacto');
	}

	public function construccion()
	{
		$this->load->view('construccion');
	}
}
