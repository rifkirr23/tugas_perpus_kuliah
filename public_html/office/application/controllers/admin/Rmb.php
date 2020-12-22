<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rmb extends CI_Controller {

	public function __construct(){
		parent::__construct();
		cek_session_all(); //cek session Login
		$this->load->model('Mrmb');
	}

	//Function Halaman Awal Menu kurs

	 function index(){
	 	$parse['data_rmb']=$this->Mrmb->sumrmb();
		$this->template->load('template','admin/rmb/rmb',$parse);
	}

	function detail_rmb(){
	 $parse['data_rmb']=$this->Mrmb->sumrmb();
	 $this->template->load('template','admin/rmb/detail_rmb',$parse);
 }

	//Function Get data Json kurs

	function get_rmb_json() { 				//data data kurs by JSON object
    header('Content-Type: application/json');
    echo $this->Mrmb->get_rmb();
   }

   function get_trmb_json() { 				//data data kurs by JSON object
    header('Content-Type: application/json');
    echo $this->Mrmb->get_trmb();
   }

	 function get_detailrmb_json() { 				//data data kurs by JSON object
    header('Content-Type: application/json');
    echo $this->Mrmb->get_detailrmb();
   }

   //Function Simpan Add New kurs
   function save(){
            $data = $this->Mrmb->save($this->input->post());
    }

    function update(){
            $data = $this->Mrmb->update($this->input->post());
    }



}
