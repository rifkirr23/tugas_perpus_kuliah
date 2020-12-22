<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengiriman extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		cek_session(); //cek session Login
		$this->load->model('Mpengiriman');
		$this->load->model('Mtbank');
		$this->load->model('Minvoice_lainnya');
	}

	//Function Halaman Awal Menu klaim
	 function index(){
    $data['pengiriman'] = $this->Mpengiriman->get_pengiriman();
		// print_r($data['pengiriman']);die();
		$this->template->load('template','admin/pengiriman/index',$data);
	 }

	 function index2(){
    $data['pengiriman'] = $this->Mpengiriman->get_pengiriman();
		print_r($data['pengiriman']);die();
		$this->template->load('template','admin/pengiriman/index',$data);
	 }

	 //
	 function update_status(){
		 $id_invoice = $this->uri->segment(4);
		 $upd_invoice['status_pengiriman'] = 1;
		 $this->db->where('id_invoice',$id_invoice)->update('invoice',$upd_invoice);
		 $this->session->set_flashdata('msg','okstatus');
		 redirect(site_url('admin/pengiriman'));
	 }

	 function pesan_gudang(){
		 $id_invoice = $this->uri->segment(4);
		 $data_invoice = $this->Mpengiriman->get_pengiriman_id($id_invoice);
		 $pesan  = "Informasi Alamat ".$data_invoice->no_sj."\n".$data_invoice->kode."\n".$data_invoice->nama_penerima."\n".
							 "".$data_invoice->whatsapp."\n\n".$data_invoice->alamat."\n".$data_invoice->ekspedisi_lokal;
		 whatsapp_grup("1554363574",$pesan,"6281293972529");
		 $this->session->set_flashdata('msg','okgudang');
		 redirect(site_url('admin/pengiriman'));
	 }

	 function save(){
		 $id_invoice = $this->input->post('id_invoice');
		 $id_cust = $this->input->post('id_cust');
		 $harga_lokal = $this->input->post('harga_lokal');
		 $file = $this->input->post('file');
		 $id_kategori_il = 3;
		 $keterangan = "Ekspedisi Lokal";
		 $this->Minvoice_lainnya->save_bypengiriman($id_cust,$harga_lokal,$id_kategori_il,$id_invoice,$keterangan);
		 //
		 foreach ($_FILES['file']['name'] as $key => $image) {
			// print_r($image."<br>");
			if($_FILES['file']['name'][$key] == "")
			 {
				 // no action
			 }else{
				 move_uploaded_file($_FILES["file"]["tmp_name"][$key], './assets/bukti_ekspedisi/'.$_FILES["file"]["name"][$key]);
				 $file=$_FILES["file"]["name"][$key];
				 $bukti_ekspedisi['id_invoice'] = $id_invoice;
				 $bukti_ekspedisi['file'] = $file;
				 $bukti_ekspedisi['tanggal_file'] = date('Y-m-d');
				 $this->db->insert('bukti_ekspedisi', $bukti_ekspedisi);
			 //$this->Mtransaksi->save_bb_cust($file);
			}
		 }
		 $this->session->set_flashdata('msg','okekspedisi');
		 redirect(site_url('admin/pengiriman'));
	 }

}
