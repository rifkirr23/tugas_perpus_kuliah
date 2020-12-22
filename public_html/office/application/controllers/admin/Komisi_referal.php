<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Komisi_referal extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		cek_session(); //cek session User Login
		$this->load->model('Mkomisi_referal'); //Load Model komisi_referal
	}

	//Function Halaman Awal Menu referal
	 function index(){
		$this->template->load('template','admin/komisi_referal/index');
	}

	//Function Get data Json komisi_referal
	function get_komisi_referal_json() {//data data komisi_referal by JSON object
    header('Content-Type: application/json');
    echo $this->Mkomisi_referal->get_komisi_referal();
  }


   //Function Proses Simpan Add New komisi_referal
   function save(){

  	}

    //Function Proses Update komisi_referal
    function update(){
     $data = $this->Mkomisi_referal->update();
  }

}
