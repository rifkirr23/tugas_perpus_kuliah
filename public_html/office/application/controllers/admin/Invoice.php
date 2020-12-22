<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		cek_session(); //cek session Login
	  $this->load->model('Minvoice');
	  $this->load->model('Mtransaksi');
	}

	//Function Halaman Awal Menu invoice
	function index(){
		$data['bank']= $this->db->get('master_bank')->result();
		$this->template->load('template','admin/invoice/invoice',$data);
	}

	//Function Get data Json invoice
	function get_invoice_json() {
    header('Content-Type: application/json');
    echo $this->Minvoice->get_invoice();
  }

	// Function Get Data Json Invoice By Id
  function get_invoiceid_json() {
    header('Content-Type: application/json');
    $id=$this->uri->segment(4);
    echo $this->Minvoice->get_invoice_byid($id);
  }

	function get_invoiceidgrup_json() {
    header('Content-Type: application/json');
    $id=$this->uri->segment(4);
    echo $this->Minvoice->get_invoice_byidgrup($id);
  }

  //Function Proses Pembayaran invoice
  function proses_invoice(){
    $data = $this->Minvoice->pinvoice($this->input->post());
  }

	// Function Pembayaran Invoice dengan Deposit
  function deposit_invoice(){
    $data = $this->Minvoice->invdeposit($this->input->post());
  }

	// Function Detail Invoice
  function detail(){
    $id = $this->uri->segment(4);
    $parse['invoice']=$this->Minvoice->data_invoice_id($id)->result();
    $parse['sub_pembayaran']=$this->Minvoice->data_sub_pembayaran($id)->result();
    $parse['potongan']=$this->Minvoice->data_potongan($id)->result();
    $parse['transaksi']=$this->Minvoice->data_transaksi_id($id)->result();
    $this->template->load('template','admin/invoice/detail',$parse);
  }

	function bayar_deposit(){
		// die();
		$id_inv = $this->uri->segment(4);
		$get_data_inv = $this->Minvoice->data_invoice_id($id_inv)->row();//print_r($get_data_inv);die();
		include APPPATH. 'views/admin/invoice/bayar_deposit.php';
	}

}
