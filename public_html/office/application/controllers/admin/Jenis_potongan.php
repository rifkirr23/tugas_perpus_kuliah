<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_potongan extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		// cek_session(); //cek session Login
		$this->load->model('Mjenis_potongan');
	}

	//Function Halaman Awal Menu Jenis Potongan
	function index(){
		$this->template->load('template','admin/jenis_potongan/jenis_potongan');
	}

	//Function Get data Json Jenis Potongan
	function get_jp_json() {
    header('Content-Type: application/json');
    echo $this->Mjenis_potongan->get_jp();
  }

  //Function Simpan Add New Jenis Potongan
  function save(){
    $data = $this->Mjenis_potongan->save($this->input->post());
  }

	// Function Update Jenis Potongan
  function update(){
    $data = $this->Mjenis_potongan->update($this->input->post());
  }

	// Function Select Potongan
 	function select_potongan(){
    $kode = $this->input->get('id_jenis_potongan');
    $data_jp = $this->Mjenis_potongan->select_potongan($kode);
    echo json_encode($data_jp);
  }

	function tambah_potongan(){

		if($this->input->post('id_jenis_potongan') == 5){
			$potongan['id_invoice'] =$this->input->post('id_invoice_beli');
			$potongan['tipe_potongan'] = "beli";
			$potongan['id_jenis_potongan'] = $this->input->post('id_jenis_potongan');
			$potongan['jumlah_potongan'] = $this->input->post('jumlah_potongan');
			$potongan['keterangan_potongan'] = $this->input->post('keterangan_potongan');
			$this->db->insert('potongan', $potongan);

			$invoice['jumlah_invoice_beli'] = $this->input->post('jumlah_invoice_beli') + ($this->input->post('jumlah_potongan'));
			$this->db->where('id_invoice_beli',$potongan['id_invoice'])->update('invoice_beli', $invoice);
		}else{
			$potongan['id_invoice'] =$this->input->post('id_invoice');
			$potongan['id_jenis_potongan'] = $this->input->post('id_jenis_potongan');
			$potongan['jumlah_potongan'] = $this->input->post('jumlah_potongan');
			$potongan['keterangan_potongan'] = $this->input->post('keterangan_potongan');
			$this->db->insert('potongan', $potongan);

			$invoice['total_tagihan'] = $this->input->post('total_tagihan') + ($this->input->post('jumlah_potongan'));
			$this->db->where('id_invoice',$potongan['id_invoice'])->update('invoice', $invoice);
		}

		redirect($this->input->post('redirect'));
	}

	function hapus_potongan(){
		$id = $this->uri->segment(4);
		$cek_potongan  = $this->db->where('id_potongan',$id)->get('potongan')->row();
		$jumlah_potongan = $cek_potongan->jumlah_potongan;
		$idinv = $cek_potongan->id_invoice;
		// update Invoice
		if($cek_potongan->tipe_potongan == "beli"){
			$sql = "UPDATE invoice_beli set jumlah_invoice_beli = jumlah_invoice_beli - $jumlah_potongan where id_invoice_beli = $idinv";
	    $this->db->query($sql);
		}else{
			$sql = "UPDATE invoice set total_tagihan = total_tagihan - $jumlah_potongan where id_invoice = $idinv";
	    $this->db->query($sql);
		}
		if($cek_potongan->id_jenis_potongan == 3){
			$update_data_pembulatan['jumlah_cbm'] = 0;
			$this->db->where('id_pembulatan',$cek_potongan->id_pembulatan)->update('pembulatan',$update_data_pembulatan);
		}
		$this->db->where('id_potongan',$id)->delete('potongan');
		$this->session->set_flashdata('msg','potongan_tercancel');
		redirect($_SERVER['HTTP_REFERER']);
	}

	function insert_potongan_beli(){
		$getinvoicebeli = $this->db->where('note_invoice_beli',$this->input->post('no_inv'))->where('id_vendor',4)->get('invoice_beli')->row();
		$invoice['jumlah_dari_vendor'] = $jumlah_dari_vendor + ($this->input->post('jumlah_potongan'));
    $this->db->where('note_invoice_beli',$this->input->post('no_inv'))->where('id_vendor',4)->update('invoice_beli', $invoice);
  }

}
