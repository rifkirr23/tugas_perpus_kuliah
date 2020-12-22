<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Saldo extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		cek_session(); //cek session User Login
		$this->load->model('Msaldo'); //Load Model Customer
		// $this->load->model('Mtransaksi'); //Load Model Customer
		// $this->load->model('Minvoice'); //Load Model Customer
		// $this->load->model('Mpembayaran'); //Load Model Customer
		// $this->load->model('Mjenis_barang_customer'); //Load Model Customer
	}

	//Function Halaman Awal Menu Customer
	 function index(){
		$idcust=$this->session->userdata('id_cust');
		$parse['komisi']=$this->db->select('sum(komisi_referal.nilai) as jumlahnya')->from('komisi_referal')->where('komisi_referal.id_cust',$idcust)->where('status',2)->get()->row();
		$parse['saldomasuk']=$this->db->select('sum(deposit.nominal_deposit) as jumlahnya')->from('deposit')->where('deposit.id_cust',$idcust)->where('deposit.tipe_deposit','masuk')->get()->row();
		$parse['saldokeluar']=$this->db->select('sum(deposit.nominal_deposit) as jumlahnya')->from('deposit')->where('deposit.id_cust',$idcust)->where('deposit.tipe_deposit','keluar')->get()->row();
		$parse['refund']=$this->db->select('sum(tarik_dana.nominal) as jumlahnya')->from('tarik_dana')->where('tarik_dana.id_cust',$idcust)->where('status',1)->get()->row();
		$parse['tarikdana']=$this->db->select('sum(nominal) as jumlahnya')->from('tarik_dana')->where('status',1)->where('id_cust',$idcust)->get()->row();
		$this->template->load('template_dashboard','dashboard/saldo/saldo',$parse);
	}

	function get_historitransaksi_json(){
		header('Content-Type: application/json');
		// echo'sdfsdf';
		echo $this->Msaldo->get_saldo();
	}

	function get_penarikandana_json(){
		header('Content-Type: application/json');
		// echo'sdfsdf';
		echo $this->Msaldo->get_penarikan();
	}
	function save(){
		$idcust=$this->session->userdata('id_cust');
		$password=$this->input->post('password');
		$datesekarang=date('Y-m-d H:i:s');
		$cekpass=$this->db->select('id_pengguna')->from('pengguna_customer')->where('pengguna_customer.id_cust',$idcust)->where('pengguna_customer.password',md5($password))->get()->row();
		// var_dump($password);
		if($cekpass->id_pengguna > 0){
			$saldomasuk=$this->db->select('sum(deposit.nominal_deposit) as jumlahnya')->from('deposit')->where('deposit.id_cust',$idcust)->where('deposit.tipe_deposit','masuk')->get()->row();
			$saldokeluar=$this->db->select('sum(deposit.nominal_deposit) as jumlahnya')->from('deposit')->where('deposit.id_cust',$idcust)->where('deposit.tipe_deposit','keluar')->get()->row();
			$tarikdana=$this->db->select('sum(nominal) as jumlahnya')->from('tarik_dana')->where('id_cust',$idcust)->get()->row();
			if($saldomasuk->jumlahnya-$saldokeluar->jumlahnya-$tarikdana->jumlahnya >= $this->input->post('nominal')){
				if($this->input->post('semua') == 1){
					$tarik['id_cust'] = $idcust;
					$tarik['status'] = 1;
					$tarik['tanggal_pengajuan'] = $datesekarang;
					$tarik['nominal'] = $saldomasuk->jumlahnya-$saldokeluar->jumlahnya-$tarikdana->jumlahnya;

					$this->db->insert('tarik_dana', $tarik);
					$this->session->set_flashdata('msg','success');
						redirect(site_url('saldo'));
				}else{
					$tarik['id_cust'] = $idcust;
					$tarik['status'] = 1;
					$tarik['tanggal_pengajuan'] = $datesekarang;
					$tarik['nominal'] = $this->input->post('nominal');

					$this->db->insert('tarik_dana', $tarik);
					$this->session->set_flashdata('msg','success');
						redirect(site_url('saldo'));
				}
			}else{
				$this->session->set_flashdata('msg','gagal');
					redirect(site_url('saldo'));
			}
		}else{
			$this->session->set_flashdata('msg','passwordsalah');
			redirect(site_url('saldo'));
		}
	}

}
