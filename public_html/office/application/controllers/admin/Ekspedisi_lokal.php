<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ekspedisi_lokal extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		cek_session(); //cek session Login
		$this->load->model('Mekspedisi_lokal');
	}

	//Function Halaman Awal Menu kurs
	function index(){
		$data['provinsi'] = $this->db->get('provinsi')->result();
		$this->template->load('template','admin/ekspedisi_lokal/index',$data);
	}

	//Function Get data Json kurs
	function get_data_json() {
    header('Content-Type: application/json');
    echo $this->Mekspedisi_lokal->get_data();
  }

   //Function Simpan Add New kurs
  function save(){
    $data = $this->Mekspedisi_lokal->save($this->input->post());
  }

	// Function Update Kurs
  function update(){
    $data = $this->Mekspedisi_lokal->update($this->input->post());
  }

	function edit(){
	 $id= $this->uri->segment(4);
	 $data['eks'] = $this->db->select('master_ekspedisi_lokal.id_ekspedisi,master_ekspedisi_lokal.nama_ekspedisi,
																 master_ekspedisi_lokal.alamat,master_ekspedisi_lokal.no_telp,
															 	 master_ekspedisi_lokal.tipe_ekspedisi,provinsi.nama as namaprov,kabupaten.nama as namakota
																 ,kecamatan.nama as namakec,master_ekspedisi_lokal.id_provinsi,master_ekspedisi_lokal.id_kota,master_ekspedisi_lokal.id_kec')
											 ->from('master_ekspedisi_lokal')
											 ->where('id_ekspedisi',$id)
											 ->join('provinsi', 'master_ekspedisi_lokal.id_provinsi=provinsi.id_prov','left')
											 ->join('kabupaten', 'master_ekspedisi_lokal.id_kota=kabupaten.id_kab','left')
											 ->join('kecamatan', 'master_ekspedisi_lokal.id_kec=kecamatan.id_kec','left')
											 ->get()->row();
	 $data['provinsi'] = $this->db->get('provinsi')->result();
	 $this->template->load('template','admin/ekspedisi_lokal/edit',$data);
	 // include APPPATH. 'views/admin/ekspedisi_lokal/edit.php';
	}


}
