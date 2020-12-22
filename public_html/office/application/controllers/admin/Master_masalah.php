<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_masalah extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		// cek_session(); //cek session Login
		$this->load->model('Mmaster_masalah');
	}

	//Function Halaman Awal Menu Jenis Potongan
	function index(){
		$this->template->load('template','admin/master_masalah/master_masalah');
	}

	//Function Get data Json Jenis Potongan
	function get_jp_json() {
    header('Content-Type: application/json');
    echo $this->Mmaster_masalah->get_jp();
  }

  //Function Simpan Add New Jenis Potongan
  function save(){
    $data = $this->Mmaster_masalah->save($this->input->post());
  }

	// Function Update Jenis Potongan
  function update(){
    $data = $this->Mmaster_masalah->update($this->input->post());
  }

	// Function Select Potongan
 	function select_potongan(){
    $kode = $this->input->get('id_master_masalah');
    $data_jp = $this->Mmaster_masalah->select_potongan($kode);
    echo json_encode($data_jp);
  }

}
