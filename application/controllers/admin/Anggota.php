<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anggota extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		cek_session(); //cek session Login
		$this->load->model('Manggota');
	}

	//Function Halaman Awal Menu anggota
	function index(){
		$this->db->like('id_anggota');
		$this->db->from('anggota');
		$data['jumlah_anggota'] = $this->db->count_all_results();
		$this->template->load('template','admin/anggota/anggota',$data);
	}

	//Function Get data Json anggota
	function get_anggota_json() {
    header('Content-Type: application/json');
    echo $this->Manggota->get_anggota();
  }

   //Function Simpan Add New anggota
  function save(){
    $insanggota['nama_anggota'] = $this->input->post('nama_anggota');
    $insanggota['gender'] = $this->input->post('gender');
    $insanggota['no_telp'] = $this->input->post('no_telp');
    $insanggota['alamat'] = $this->input->post('alamat');
    $insanggota['email'] = $this->input->post('email');
    $insanggota['password'] = $this->input->post('password');
    // $insanggota['status_anggota'] = 0;
    $this->db->insert('anggota',$insanggota);
    redirect($_SERVER['HTTP_REFERER']);
  }

	// Function Update anggota
  function update(){
		// dd($this->input->post());
		$insanggota['nama_anggota'] = $this->input->post('nama_anggota');
    $insanggota['gender'] = $this->input->post('gender');
    $insanggota['no_telp'] = $this->input->post('no_telp');
    $insanggota['alamat'] = $this->input->post('alamat');
    $insanggota['email'] = $this->input->post('email');
    $insanggota['password'] = $this->input->post('password');
    // $insanggota['status_anggota'] = 0;
    $this->db->where('id_anggota',$this->input->post('id_anggota'))->update('anggota',$insanggota);
    redirect($_SERVER['HTTP_REFERER']);
  }

	function delete(){
	   $id= $this->uri->segment(4);
	   $delete = $this->db->where('id_anggota',$id)->delete('anggota');
	   redirect($_SERVER['HTTP_REFERER']);
  }



}
