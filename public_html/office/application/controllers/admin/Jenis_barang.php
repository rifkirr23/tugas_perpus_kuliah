<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_barang extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		session_suadmin(); //cek session Login
		$this->load->model('Mjenis_barang');
	}

	//Function Halaman Awal Menu Jenis Barang
	function index(){
		$this->template->load('template','admin/jenis_barang/jenis_barang');
	}

	//Function Get data Json Jenis Barang
	function get_jb_json() {
    header('Content-Type: application/json');
    echo $this->Mjenis_barang->get_jb();
  }

  //Function Simpan Add New Jenis Barang
  function save(){
    $data = $this->Mjenis_barang->save($this->input->post());
  }

	// Function Update Jenis Barang
  function update(){
    $data = $this->Mjenis_barang->update($this->input->post());
  }

}
