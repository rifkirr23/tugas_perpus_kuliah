<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengeluaran extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		cek_session(); //cek session Login
		$this->load->model('Mpengeluaran');
		$this->load->model('Mtbank');
	}

	//Function Halaman Awal Menu klaim
	 function index(){
		$data['bank']= $this->db->get('master_bank')->result();
		$data['jenis_transaksi_keluar'] = $this->db->where('id_jenis_transaksi_utama',1)->order_by('kjenis_transaksi_bank','asc')->get('jenis_transaksi_bank')->result();
		$this->template->load('template','admin/pengeluaran/index',$data);
	 }

	//Function Get data Json klaim
	function get_pengeluaran_json() {
    header('Content-Type: application/json');
    echo $this->Mpengeluaran->get_pengeluaran();
   }

	 function save_pengeluaran(){
		 $data = $this->Mtbank->save($this->input->post());
		 redirect(site_url('admin/pengeluaran'));
	 }


}
