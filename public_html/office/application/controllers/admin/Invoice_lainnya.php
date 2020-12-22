<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice_lainnya extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
	  $this->load->model('Minvoice_lainnya');
		$this->load->model('Mbarang');
	  $this->load->model('Minvoice_barang');
	  $this->load->model('Mtransaksi');
	  $this->load->model('Mpembayaran');
	}

	// Function Index Invoice Lainnya
  function index(){
		// print_r($this->Minvoice_lainnya->kode_il(5));
    $data['vendor'] = $this->Minvoice_lainnya->select_vendor()->result();
    $data['kategori'] = $this->Minvoice_lainnya->select_kategori_il()->result();
		$data['bank']= $this->db->get('master_bank')->result();
    $this->template->load('template','admin/invoice_lainnya/invoice_lainnya',$data);
  }

	// Function Get Data Invoice Lainnya Output Json
  function get_invoice_json() {
    header('Content-Type: application/json');
    echo $this->Minvoice_lainnya->get_invoice();
  }

	// Function Get Data Invoice Lainnya Output Json
  function get_invoiceid_json() {
		$id =  $this->uri->segment(4);
    header('Content-Type: application/json');
    echo $this->Minvoice_lainnya->get_invoicebyid($id);
  }

	// Function Save Input Invoice Lainnya
  function save(){
    $this->Minvoice_lainnya->save();
  }

	// Function Save Item Invoice Lainnya
	function save_item(){
		$this->Minvoice_lainnya->save_item();
	}

	// Function Save Edit Item Invoice Lainnya
	function saveedit_item(){
		$this->Minvoice_lainnya->saveedit_item();
	}

	// Function Detail Invoice Lainnya
	function detail(){
		$id = $this->uri->segment(4);
		$parse['r'] = $this->Minvoice_lainnya->data_invoice($id)->row();
		$parse['invoicedetail']=$this->Minvoice_lainnya->item_inv($id)->result();
		$parse['sub_pembayaran']=$this->Minvoice_lainnya->data_sub_pembayaran($id)->result();
		$parse['potongan']=$this->Minvoice_lainnya->data_potongan($id)->result();
		//print_r($parse['r']);die();
		$this->template->load('template','admin/invoice_lainnya/detail',$parse);
	}

	// Function Edit Item From Ajax
	function edit_item(){
		cek_session_all();
		$id= $this->uri->segment(4);
		$record= $this->Minvoice_lainnya->data_item($id)->row();
		include APPPATH. 'views/admin/invoice_lainnya/edit_item.php';
	}

	// Function Simpan Proses Pembayaran Invoice Lainnya
	function simpan_proses(){
		$data = $this->Minvoice_lainnya->pinvoice($this->input->post());
	}

	// Function Simpan Proses Pembayaran Deposit Invoice Lainnya
	function simpan_deposit(){
		$data = $this->Minvoice_lainnya->invdeposit($this->input->post());
	}

	function bayar_deposit(){
		// die();
		$id_inv = $this->uri->segment(4);
		$get_data_inv = $this->Minvoice_lainnya->data_invoice($id_inv)->row();
		include APPPATH. 'views/admin/invoice_lainnya/bayar_deposit.php';
	}

	function delete_inv(){
		$id_inv = $this->uri->segment(4);
		$getinvbeli = $this->db->where('id_invoice',$id_inv)->get('invoice')->row();
		$this->db->where('id_invoice',$id_inv)->delete('invoice');
		$this->db->where('id_invoice_beli',$getinvbeli->id_invoice_beli)->delete('invoice_beli');
		$this->db->where('id_invoice',$id_inv)->delete('item_il');
		redirect($_SERVER['HTTP_REFERER']);
	}

}
