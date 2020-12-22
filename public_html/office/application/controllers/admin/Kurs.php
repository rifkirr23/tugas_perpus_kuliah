<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kurs extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		cek_session(); //cek session Login
		$this->load->model('Mkurs');
	}

	//Function Halaman Awal Menu kurs
	function index(){
		$this->db->like('id_kurs');
		$this->db->from('kurs');
		$data['jumlah_kurs'] = $this->db->count_all_results();
		$this->template->load('template','admin/kurs/kurs',$data);
	}

	//Function Get data Json kurs
	function get_kurs_json() {
    header('Content-Type: application/json');
    echo $this->Mkurs->get_kurs();
  }

   //Function Simpan Add New kurs
  function save(){
    $data = $this->Mkurs->save($this->input->post());
  }

	// Function Update Kurs
  function update(){
    $data = $this->Mkurs->update($this->input->post());
  }



}
