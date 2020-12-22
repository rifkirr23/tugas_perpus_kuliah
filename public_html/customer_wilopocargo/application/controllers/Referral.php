<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Referral extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		cek_session(); //cek session User Login
		$this->load->model('Mkomisi_referal'); //Load Model Customer
		// $this->load->model('Mtransaksi'); //Load Model Customer
		// $this->load->model('Minvoice'); //Load Model Customer
		// $this->load->model('Mpembayaran'); //Load Model Customer
		// $this->load->model('Mjenis_barang_customer'); //Load Model Customer
	}

	//Function Halaman Awal Menu Customer
	function index(){
		$idcust=$this->session->userdata('id_cust');
		// var_dump($gr);
		$parse['pending']=$this->db->select('sum(komisi_referal.nilai) as jumlahnya')->from('komisi_referal')->where('komisi_referal.id_cust',$idcust)->where('status',1)->get()->row();
		$parse['proccess']=$this->db->select('customer.deposit as jumlahnya')->from('customer')->where('id_cust',$idcust)->get()->row();
		$this->template->load('template_dashboard','dashboard/referral/referral', $parse);
	}

	function referrallist(){
		$idcust=$this->session->userdata('id_cust');
		$parse['pending']=$this->db->select('sum(komisi_referal.nilai) as jumlahnya')->from('komisi_referal')->where('komisi_referal.id_cust',$idcust)->where('status',1)->get()->row();
		$parse['proccess']=$this->db->select('customer.deposit as jumlahnya')->from('customer')->where('id_cust',$idcust)->get()->row();
		$this->template->load('template_dashboard','dashboard/referral/referrallist', $parse);
	}

	//Function Get data Json komisi_referal
	function get_komisi_referal_json() {//data data komisi_referal by JSON object
		header('Content-Type: application/json');
		echo $this->Mkomisi_referal->get_komisi_referal();
	}

	function get_komisi_referallist_json() {//data data komisi_referal by JSON object
		header('Content-Type: application/json');
		echo $this->Mkomisi_referal->get_komisi_referallist();
	}

	function resilist(){
		$idcust=$this->session->userdata('id_cust');
		$parse['pending']=$this->db->select('sum(komisi_referal.nilai) as jumlahnya')->from('komisi_referal')->where('komisi_referal.id_cust',$idcust)->where('status',1)->get()->row();
		$parse['proccess']=$this->db->select('customer.deposit as jumlahnya')->from('customer')->where('id_cust',$idcust)->get()->row();
		$parse['record_resi'] = $this->db->select('resi.*,customer.*')
											    					->from('resi')
											    					->join('customer', 'resi.cust_id=customer.id_cust')
																		->where('customer.id_referal',$idcust)
																		->order_by('resi.id_resi','desc')
																		->get()->result();
																		// var_dump($record_resi);die();
		$this->template->load('template_dashboard','dashboard/referral/resilist', $parse);
	}

}
