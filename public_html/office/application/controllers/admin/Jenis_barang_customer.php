<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_barang_customer extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		session_suadmin(); //cek session Login
		$this->load->model('Mjenis_barang_customer');
	}

	//Function Halaman Awal Menu Jenis barang_customer
	function index(){
		$data['jenis_barang'] = $this->Mjenis_barang_customer->getjb()->result();
		$this->template->load('template','admin/jenis_barang_customer/jenis_barang_customer',$data);
	}

	//Function Get data Json Jenis barang_customer
	function get_jbc_json() {
    header('Content-Type: application/json');
    echo $this->Mjenis_barang_customer->get_jbc();
  }

	//Function Get data Json by Id Jenis barang_customer
	function get_jbcid_json() {
		$id = $this->uri->segment(4);
    header('Content-Type: application/json');
    echo $this->Mjenis_barang_customer->get_jbcid($id);
  }

  //Function Simpan Add New Jenis barang_customer
  function save(){
    $data = $this->Mjenis_barang_customer->save($this->input->post());
  }

	// Function Update Jenis barang_customer
  function update(){
    $data = $this->Mjenis_barang_customer->update($this->input->post());
  }

}
