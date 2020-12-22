<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		cek_session(); //cek session Login
		$this->load->model('Mkategori');
	}

	//Function Halaman Awal Menu kategori
	function index(){
		$this->db->like('id_kategori');
		$this->db->from('kategori');
		$data['jumlah_kategori'] = $this->db->count_all_results();
		$this->template->load('template','admin/kategori/kategori',$data);
	}

	//Function Get data Json kategori
	function get_kategori_json() {
    header('Content-Type: application/json');
    echo $this->Mkategori->get_kategori();
  }

   //Function Simpan Add New kategori
  function save(){
    $inskategori['nama_kategori'] = $this->input->post('nama_kategori');
    $this->db->insert('kategori',$inskategori);
    redirect($_SERVER['HTTP_REFERER']);
  }

	// Function Update kategori
  function update(){
    $data = $this->Mkategori->update($this->input->post());
  }



}
