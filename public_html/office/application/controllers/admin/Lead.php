<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lead extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		cek_session(); //cek session Login
		$this->load->model('Mlead');
	}

	//Function Halaman Awal Menu Bank
	function index(){
		$this->template->load('template','admin/marketing/lead');
	}

	//Function Get data Json Bank
 	function json_list() {
		header('Content-Type: application/json');
		echo $this->Mlead->get_lead();
  	}


}
