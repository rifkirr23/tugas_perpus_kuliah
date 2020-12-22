<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Broadcast extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		cek_session(); //cek session Login
		$this->load->model('Mbroadcast');
	}

	//Function Halaman Awal Menu broadcast
	function index(){
		$this->template->load('template','admin/broadcast/index');
	}

	// Function Get data Json broadcast
	function get_broadcast_json() {
    header('Content-Type: application/json');
    echo $this->Mbroadcast->get_broadcast();
  }

   //Function Simpan Add New broadcast
  function save(){
    $data = $this->Mbroadcast->save($this->input->post());
  }

	function alamat(){
    $data_customer = $this->db->order_by('id_cust','desc')->get('customer')->result();//print_r($data_customer);die();
    $pesan = "";
    foreach($data_customer as $dc){
      $pesan = "";
      $pesan = "Customer yth.*".$dc->kode.
                "* \n\nHalo member Wilopo Cargo, untuk mempercepat kiriman barang Anda ketika sampai di Jakarta, harap informasikan kepada kami alamat kirim Anda dan juga ekspedisi lokal (untuk luar kota jakarta) yang biasa Anda gunakan kepada kami. Apabila alamat dan ekspedisi lokal di bawah sudah benar, harap abaikan chat ini.".
                "\n\nAlamat kirim :".
								"\n".$dc->alamat.
								"\n\n*Wilopo Cargo*";
  		sendwhatsapp($pesan,$dc->whatsapp);
    }

    $this->session->set_flashdata('msg','success');
    redirect(site_url('admin/broadcast'));
  }


}
