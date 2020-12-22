<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();
		cek_session_all(); //cek session Login
		// $this->load->model('Mtbank');
		// $this->load->model('Mrmb');
		// $this->load->model('Mlaporan');
		//$this->load->model('files');
	}

	//Function Page After Login
	function index(){
		$data['tes'] = 0;
    $data['buku'] = $this->db->like('id_buku')->from('buku')->count_all_results();
		$data['anggota'] = $this->db->like('id_anggota')->from('anggota')->count_all_results();
		$data['peminjaman'] = $this->db->like('id_pinjam')->from('peminjaman')->count_all_results();
		$data['kategori'] = $this->db->like('id_kategori')->from('kategori')->count_all_results();

    $this->template->load('template','dashboard/home',$data);

  }

}
