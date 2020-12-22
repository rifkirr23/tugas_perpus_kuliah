<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resi_udara extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		cek_session();
	  $this->load->model('Mresi_udara');
		$this->load->model('Minvoice');
	}

	// Function Index Resi Udara
  function index(){
    $data['nomor_resi'] = $this->Mresi_udara->getnomorresi();//print_r($data['nomor_resi']);die();
    $this->template->load('template','admin/resi_udara/resi_udara',$data);
  }

	// Function Index Generate Invoice Resi Udara
  function gen_invoice(){
    $data['resi'] = $this->Mresi_udara->getresiinv()->result();
    $this->template->load('template','admin/resi_udara/invoice',$data);
  }

	// Function Index Invoice Resi Udara
  function invoice(){
		$data['bank']= $this->db->get('master_bank')->result();
    $this->template->load('template','admin/resi_udara/index_invoice',$data);
  }

	function get_invoice_json() {
    header('Content-Type: application/json');
    echo $this->Mresi_udara->get_invoiceresi();
  }

	// Function Get Data Resi Udara Output Json
  function get_resi_json() {
    header('Content-Type: application/json');
    echo $this->Mresi_udara->get_resi();
  }

	// Function Save Input Resi Udara
  function save(){
    $this->Mresi_udara->save();
  }

	// Function Generate Invoice Resi Udara
	function generate_invoice(){
		$this->Mresi_udara->generate_invoice();
	}

	// Function Update Item Resi Udara
	function update(){
		$this->Mresi_udara->update();
	}

	// Function Detail Invoice
  function invoice_detail(){
    $id = $this->uri->segment(4);
		$idresi = $this->uri->segment(5);
		$dariinvbeli = $this->uri->segment(6);
		$parse['jenis_potongan'] = $this->db->get('jenis_potongan')->result();

		if($dariinvbeli == "air"){
				$parse['r']=$this->Mresi_udara->getresiinvid($idresi)->row();
		}else if($dariinvbeli == "beli"){
				$parse['r']=$this->Mresi_udara->getresiinvidinv($id)->row();
		}
    $parse['sub_pembayaran']=$this->Minvoice->data_sub_pembayaran($id)->result();
    $parse['potongan']=$this->Minvoice->data_potongan($id)->result();
    $this->template->load('template','admin/resi_udara/invoice_detail',$parse);
  }

	// Function Edit Item From Ajax
	function edit_item(){
		cek_session_all();
		$id= $this->uri->segment(4);
		$record= $this->Mresi_udara->getresiinvid($id)->row();
		include APPPATH. 'views/admin/resi_udara/edit.php';
	}

	// Function Simpan Proses Pembayaran Resi Udara
	function simpan_proses(){
		$data = $this->Mresi_udara->pinvoice($this->input->post());
	}

	// Function Simpan Proses Pembayaran Deposit Resi Udara
	function simpan_deposit(){
		$data = $this->Mresi_udara->invdeposit($this->input->post());
	}

	//Function Get Harga by Customer , Call back ajax
  public function get_harga(){
    // Ambil Data Invoice
    $id_cust = $this->input->post('id_cust');
    $harga  = $this->db->where('id_cust',$id_cust)->get('customer')->row();
    // Buat variabel untuk menampung tag-tag option nya
    // Set defaultnya dengan tag option Pilih
		$callback = array('harga_udara' => $harga->harga_udara);
    echo json_encode($callback); // konversi varibael $callback menjadi JSON
  }

	function bayar_deposit(){
		// die();
		$id_inv = $this->uri->segment(4);
		$get_data_inv = $this->Mresi_udara->getresiinvidinv($id_inv)->row();
		include APPPATH. 'views/admin/resi_udara/bayar_deposit.php';
	}

	function delete_resi(){
		if($this->session->userdata('level') != "suadmin"){
			die("dont have access");
		}
		$idresiudara = $this->uri->segment(4);
		$getresi = $this->db->select('invoice.id_invoice_beli,invoice.id_invoice')
												->from('resi_udara')
												->join('invoice', 'resi_udara.id_invoice=invoice.id_invoice')
												->where('id_resi_udara',$idresiudara)
												->get()->row();
		if($getresi->id_invoice > 0){
			$this->db->where('id_invoice_beli',$getresi->id_invoice_beli)->delete('invoice_beli');
			$this->db->where('id_invoice',$getresi->id_invoice)->delete('invoice');
		}
		$delete = $this->db->where('id_invoice',$getresi->id_invoice)->delete('resi_udara');
		if($delete){
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

}
