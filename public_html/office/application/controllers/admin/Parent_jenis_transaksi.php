<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Parent_jenis_transaksi extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		// session_suadmin(); //cek session Login
		$this->load->model('Mparent_jenis_transaksi');
	}

	//Function Halaman Awal Menu Jenis Transaksi Bank
	function index(){
		$this->template->load('template','admin/Parent_jenis_transaksi/parent_jenis_transaksi');
	}

	//Function Get data Json Jenis Transaksi Bank
	function get_jtb_json() {
    header('Content-Type: application/json');
    echo $this->Mparent_jenis_transaksi->get_jtb();
  }

   //Function Simpan Add New Jenis Transaksi Bank
  function save(){
    $data = $this->Mparent_jenis_transaksi->save($this->input->post());
  }

	// Function Simpan Update Jenis Transaksi Bank
  function update(){
    $data = $this->Mparent_jenis_transaksi->update($this->input->post());
  }

	function setting_jenis_transaksi(){
    $data['jenis_transaksi'] = $this->db->where('tipe_jenis_transaksi',2)->get('jenis_transaksi_bank')->result();
    $this->template->load('template','admin/parent_jenis_transaksi/setting_jenis_transaksi',$data);
  }

}
