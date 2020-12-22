<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembelian extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		cek_session(); //cek session Login
	  $this->load->model('Mpembelian');
		$this->load->model('Mtransaksi');
	}

	//Function Halaman Awal Menu Pembelian
	function index(){
		$data['total_semua_pembelian']= $this->Mpembelian->total_semua_pembelian();
		$this->template->load('template','admin/pembelian/pembelian',$data);
	}

	//Function Get data Json Pembelian
	function get_pembelian_json() {
    header('Content-Type: application/json');
    echo $this->Mpembelian->get_pembelian();
  }

	// Function Paid Pembelian
	function paid_pembelian(){
	   $data = $this->Mpembelian->paid_pembelian($this->input->post());
	}

	// Function Update Kurs Beli Sebelum di paid
	function update_kurs_beli(){
	   $data = $this->Mpembelian->update_kurs_beli($this->input->post());
	}

	// Function Lunasi Pembelian Setelah Update Kurs beli
	function lunasi_pembelian(){
	   $data = $this->Mpembelian->lunasi_pembelian($this->input->post());
	}

	// Function Lunasi Pembelian Setelah Update Kurs beli
	function lunasi_satu(){
	   $data = $this->Mpembelian->lunasi_satu($this->input->post());
	}

	// Function View Image Bukti Bayar Pembelian
	function view_image(){
		cek_session_all();
		$id= $this->uri->segment(4);
		$record= $this->Mtransaksi->data_transaksi($id)->result();
		$file2= $this->Mtransaksi->getfile_bb_rmb($id)->result();
		include APPPATH. 'views/admin/pembelian/view_image.php';
	}

	function edit_kurs_beli(){
		cek_session_all();
		$id = $this->uri->segment(4);
		$r = $this->Mtransaksi->data_transaksi($id)->row();
		include APPPATH. 'views/admin/pembelian/edit_kurs_beli.php';
	}

	function save_editkurs(){
		$kursbeli['kurs_beli'] = $this->input->post('kurs_beli');
		$this->db->where('id_transaksi',$this->input->post('id_transaksi'))->update('transaksi',$kursbeli);
		redirect(site_url('admin/pembelian'));
	}

}
