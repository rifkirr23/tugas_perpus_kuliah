<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jobcs extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		cek_session(); //cek session Login
		$this->load->model('Mjobcs');
	}

	//Function Halaman Awal Menu jobcs
	function index(){
		$data['master_masalah'] = $this->db->where('id_masalah >',0)->get('master_masalah')->result();
		$this->template->load('template','admin/jobcs/jobcs',$data);
	}

	//Function Get data Json jobcs
	function get_jobcs_json() {
    header('Content-Type: application/json');
    echo $this->Mjobcs->get_jobcs();
  }

   //Function Simpan Add New jobcs
  function save(){
    $data = $this->Mjobcs->save($this->input->post());
  }

	// Function Update jobcs
  function update(){
    $data = $this->Mjobcs->update($this->input->post());
  }

  // Function Update jobcs
  function complete(){
    $data = $this->Mjobcs->complete($this->input->post());
  }


}
