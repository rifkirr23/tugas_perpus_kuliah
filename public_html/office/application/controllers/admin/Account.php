<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {
	
	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		session_suadmin(); //cek session Login
		$this->load->model('Maccount');
	}

	//Function Halaman Awal Menu account
	 function index(){
		$this->template->load('template','admin/account/account');
	 }

	//Function Get data Json account
	function get_account_json() {
    header('Content-Type: application/json');
    echo $this->Maccount->get_account();
   }

   //Function Simpan Add New account
   function save(){
   		$data = $this->Maccount->save($this->input->post());
   }

	 //Function Update Account
   function update(){
  		$data = $this->Maccount->update($this->input->post());
   }

}
