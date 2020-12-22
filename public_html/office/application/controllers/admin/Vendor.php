<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		cek_session(); //cek session User Login
		$this->load->model('Mvendor'); //Load Model vendor
	}

  //Function Halaman Awal Menu vendor
	 function index(){
		$this->template->load('template','admin/vendor/vendor');
	}

	//Function Get data Json vendor
	function get_vendor_json() {//data data vendor by JSON object
    header('Content-Type: application/json');
    echo $this->Mvendor->get_vendor();
  }

  //Function Proses Simpan Add New Vendor
  function save(){
    $this->Mvendor->save();
  }

  //Function Proses Simpan Add New Vendor
  function update(){
    $this->Mvendor->update();
  }

	// Function Detail Vendor
  function detail(){
    $id = $this->uri->segment(4);
		$segment = $this->uri->segment(5);
		$parse['detail'] = 1; //Set Detail = 1 Untuk di view/template.php
    $parse['v']=$this->Mvendor->getdata_vendor($id)->row();
		// Untuk Tab Menu di Vendor
		if($segment == "invoice"){
			if($id == 4){
				$sql = "SELECT count(id_invoice_beli) as hitunginv from `invoice_beli` where id_vendor = 4 and jumlah_invoice_beli != jumlah_dari_vendor";
				$parsecekinv = $this->db->query($sql)->row();
				$parse['cek_inv'] = $parsecekinv->hitunginv;
				$parse['hitung']  = $this->db->select('sum(jumlah_invoice_beli - jumlah_bayar_invoice_beli) as jumlah_hitung_wilopo ,
				 																			sum(jumlah_dari_vendor - jumlah_bayar_invoice_beli) as jumlah_hitung_vendor')->where('id_vendor',4)
																							->from('invoice_beli')->get()->row();
				$parse['jumlah_rowrts'] = json_decode(file_get_contents("https://office.rtsekspedisi.com/invwilopo/jumlah_row"));
				$parse['invrts'] = json_decode(file_get_contents("https://office.rtsekspedisi.com/invwilopo/jumlah_invoice"));
				$parse['invpaidrts'] = json_decode(file_get_contents("https://office.rtsekspedisi.com/invwilopo/jumlah_invoicepaid"));
				$parse['jumlah_rowwc'] = $this->db->where('id_vendor',4)->get('invoice_beli')->num_rows();
				// print_r(file_get_contents("https://office.rtsekspedisi.com/invwilopo/jumlah_row"));die();
			}
				// header("Content-type: application/vnd-ms-excel");
				// header("Content-Disposition: attachment; filename=nama_filenya.xls");
			$this->template->load('template','admin/vendor/detail_invoice',$parse);
		}
  }

	// Function Detail Vendor Beda Hitungan
  function detail_beda(){
		$id = $this->uri->segment(4);
		if($id != 4){
			die("Tidak bisa masuk ke page ini");
		}
		$segment = $this->uri->segment(5);
		$parse['detail'] = 1; //Set Detail = 1 Untuk di view/template.php
    $parse['v']=$this->Mvendor->getdata_vendor($id)->row();
		// Untuk Tab Menu di Vendor
		if($segment == "invoice"){
			if($id == 4){
				$parse['hitung'] = $this->db->select('sum(jumlah_invoice_beli-jumlah_bayar_invoice_beli) as jumlah_hitung_wilopo , sum(jumlah_dari_vendor-jumlah_bayar_invoice_beli) as jumlah_hitung_vendor')->where('id_vendor',4)->from('invoice_beli')->get()->row();
				$parse['data_beda'] = $this->Mvendor->get_rtsbeda($id);
			}
			$this->template->load('template','admin/vendor/detail_beda',$parse);
		}
  }

	//Function Get data Invoice Beli Json by vendor
	function get_invoice_beli_json() {
		$id = $this->uri->segment(4);
    header('Content-Type: application/json');
    echo $this->Mvendor->get_invoice_beli($id);
  }

	//Function Get data Invoice Beli Json by vendor
	function tes_api_invrts() {
		$this->db->select('invoice_beli.id_invoice_beli,invoice_beli.id_vendor,invoice_beli.kode_invoice_beli,invoice_beli.tanggal_invoice_beli,invoice_beli.status_invoice_beli
															 ,invoice_beli.note_invoice_beli,invoice_beli.jumlah_invoice_beli,invoice_beli.jumlah_bayar_invoice_beli
															 ,invoice_beli.jumlah_dari_vendor,customer.kode,invoice.id_invoice,invoice_rts.jumlah');
		$this->db->from('invoice_beli');
		$this->db->join('customer', 'invoice_beli.id_cust=customer.id_cust');
		$this->db->join('invoice', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli');
		$this->db->join('invoice_rts', 'invoice_rts.no_inv=invoice_beli.note_invoice_beli');
		$this->db->where('invoice_beli.id_vendor',4);
		$this->db->where('invoice_rts.jumlah !',4);
		$tes = $this->db->get()->result();
		print_r($tes);die();
  }


}
