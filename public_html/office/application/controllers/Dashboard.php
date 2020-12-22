<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();
		cek_session_all(); //cek session Login
		$this->load->model('Mtbank');
		$this->load->model('Mrmb');
		$this->load->model('Mlaporan');
		//$this->load->model('files');
	}

	//Function Page After Login
	function index(){
    $this->db->like('id_cust');
    $this->db->from('customer');
    $data['customer'] = $this->db->count_all_results();

    $this->db->like('id_transaksi');
    $this->db->from('transaksi');
    //$this->db->where('tanggal_transaksi >=','2019-04-01');
    //$this->db->where('tanggal_transaksi <=','2019-04-31');
    $data['transaksi'] = $this->db->count_all_results();

    $this->db->like('id_invoice');
    $this->db->from('invoice');
    $data['invoice'] = $this->db->count_all_results();

    $this->db->like('id_pembayaran');
    $this->db->from('pembayaran');
    $data['pembayaran'] = $this->db->count_all_results();

		$data['cek_rmb'] = $this->db->where('saldo_rmb',0)->get('rmb')->num_rows();
		$transaksibank_keluar = $this->Mtbank->data_tb()->result();
    $data['pengeluaran'] = json_encode($transaksibank_keluar);
		//var_dump($data['pengeluaran']);die();
		$data['total_rmb'] = $this->Mrmb->sumrmb();
		$data['total_laba_rmb'] =  $this->Mlaporan->get_laba_tt();

		$transaksi_bank_masuk  = $this->db->select('sum(nominal_transaksi_bank) as jumlah')->where('id_bank',1)->where('tipe_transaksi_bank','masuk')->get('transaksi_bank')->row();
		$transaksi_bank_keluar = $this->db->select('sum(nominal_transaksi_bank) as jumlah')->where('id_bank',1)->where('tipe_transaksi_bank','keluar')->get('transaksi_bank')->row();
		$data['rowbank'] = $transaksi_bank_masuk->jumlah - $transaksi_bank_keluar->jumlah;

    $this->template->load('template','dashboard/home',$data);

  }

}
