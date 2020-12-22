<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran_beli extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		cek_session(); //cek session Login
		$this->load->model('Mpembayaran_beli');
	  $this->load->model('Mtransaksi');
		$this->load->model('Mvendor');
	}

	//Function Halaman Awal Menu Pembayaran Beli
	function index(){
		//$data['transaksi']= $this->Mdireksi1->transaksi();
		$this->template->load('template','admin/pembayaran_beli/pembayaran_beli');
	}

	// Function New Pembayaran Beli
	function new(){
		// print_r($this->Mpembayaran_beli->get_invoice_fcl(2));die();
		$parse['bank']= $this->db->get('master_bank')->result();
		$parse['vendor'] = $this->Mvendor->select_vendor();
    $parse['customer']=$this->Mtransaksi->get_customer();
    $parse['kode_pembayaran_beli']=$this->Mpembayaran_beli->code_pembayaran_beli();
    $this->template->load('template','admin/pembayaran_beli/new_pembayaran_beli',$parse);
  }

	//Function Get data Json pembayaran beli
	function get_pembayaran_beli_json() {
    header('Content-Type: application/json');
    echo $this->Mpembayaran_beli->get_pembayaran_beli();
  }

	// Data Pembayaran Beli by Id Json
  function get_pembayaran_beliid_json() {
    header('Content-Type: application/json');
    $id=$this->uri->segment(4);
    echo $this->Mpembayaran_beli->get_pembayaran_beli_byid($id);
  }

	//Function Get Invoice by Customer , Call back ajax
  public function get_invoice(){
    // Ambil Data Invoice
    $id_vendor = $this->input->post('id_vendor');
		if($id_vendor == 1){
			$invoice = $this->Mpembayaran_beli->get_invoiceair($id_vendor);
		}else if($id_vendor == 2){
			$invoice = $this->Mpembayaran_beli->get_invoice_fcl($id_vendor);
	  }else if($id_vendor == 4){
			$invoice = $this->Mpembayaran_beli->get_invoice($id_vendor);
		}else{
			$invoice = $this->Mpembayaran_beli->get_invoice_vendor($id_vendor);
		}
    // Buat variabel untuk menampung tag-tag option nya
    // Set defaultnya dengan tag option Pilih
    $lists = "";
    foreach($invoice as $data){
			if($id_vendor == 1){
				$lists .= "
				<tr>
				<td width='54px' ><center><input type='checkbox' id='id_invoice_beli".$data->id_invoice_beli."' name='id_invoice_beli[]' class='checkboxs' value='".$data->id_invoice_beli."'></center></td>
				<td width='200px'><center><label> ".$data->kode_invoice." (".$data->kode." , (".$data->berat." Kg)) </label></center></td>
				<td width='200px'><center><label> ".number_format($data->jumlah_invoice_beli-($data->jumlah_bayar_invoice_beli))."</label></center></td>
				</tr>
			   "; // Tambahkan tag option ke variabel $lists
			}else{
				$lists .= "
				<tr>
				<td width='54px' ><center><input type='checkbox' id='id_invoice_beli".$data->id_invoice_beli."' name='id_invoice_beli[]' class='checkboxs' value='".$data->id_invoice_beli."'></center></td>
				<td width='200px'><center><label> ".$data->note_invoice_beli." (".$data->kode." , (".$data->tanggal_invoice_beli.")) </label></center></td>
				<td width='200px'><center><label> ".number_format($data->jumlah_invoice_beli-($data->jumlah_bayar_invoice_beli))."</label></center></td>
				</tr>
			   "; // Tambahkan tag option ke variabel $lists
			}
    }
    $callback = array('get_invoice'=>$lists); // Masukan variabel lists tadi ke dalam array $callback dengan index array : list_kota
    echo json_encode($callback); // konversi varibael $callback menjadi JSON
  }

	// Function Get Invoice by Customer Grup , Call back Ajax
	public function get_invoicegrup(){
	   // Ambil Data Invoice
	   $id_cgrup = $this->input->post('id_cgrup');
	   $invoice = $this->Mpembayaran_beli->get_invoicegrup($id_cgrup);
	   // Buat variabel untuk menampung tag-tag option nya
	   // Set defaultnya dengan tag option Pilih
	   $lists = "";
	   foreach($invoice as $data){
       $lists .= "
   			<tr>
   			<td width='54px' ><center><input type='checkbox' id='id_invoice".$data->id_invoice."' name='id_invoice[]' class='checkboxs' value='".$data->id_invoice."'></center></td>
   			<td width='200px'><center><label> ".$data->kode_invoice."</label></center></td>
   			<td width='200px'><center><label> ".number_format($data->total_tagihan-($data->jumlah_bayar + $data->total_potongan))."</label></center></td>
   			</tr>
   		   "; // Tambahkan tag option ke variabel $lists
	    }
	   $callback = array('get_invoicegrup'=>$lists); // Masukan variabel lists tadi ke dalam array $callback dengan index array : list_kota
	   echo json_encode($callback); // konversi varibael $callback menjadi JSON
   }

	 // Function Get Invoice By id Invoice , untuk Get Harga di Pembayaran saat memilih invoice
   public function get_invoice2(){
  	//header('Content-Type: application/json');
    // Ambil Data Invoice
    $id_invoice = $this->input->post('id_invoice_beli');
    //die(json_encode($id_invoice[0]));
    $invoice = $this->Mpembayaran_beli->get_invoice2($id_invoice);
    // Buat variabel untuk menampung tag-tag option nya
    // Set defaultnya dengan tag option Pilih
    // $callback = array('get_invoice'=>$lists); // Masukan variabel lists tadi ke dalam array $callback dengan index array : list_kota
    echo json_encode($invoice); // konversi varibael $callback menjadi JSON
   }

   //Function Simpan Add New pembayaran
   function save(){
    	$data = $this->Mpembayaran_beli->save($this->input->post());
   }

	 // Function Update Pembayaran
   function update(){
      $data = $this->Mpembayaran_beli->update($this->input->post());
   }

	 // Function Deleted
   function deleted(){
      $data = $this->Mpembayaran_beli->deleted($this->input->post());
   }

	 // Function View Image Bukti Bayar
   function view_image(){
    $id= $this->uri->segment(4);
    $file1= $this->Mpembayaran_beli->getfile_beli($id)->result();
    include APPPATH. 'views/admin/pembayaran_beli/view_image.php';
   }

		// Function Keterangan Pembayaran
    function view_keterangan(){
      $id= $this->uri->segment(4);
      $gk= $this->Mpembayaran_beli->get_keterangan($id)->result();
      $gk1= $this->Mpembayaran_beli->get_keterangan1($id)->row_array();
      include APPPATH. 'views/admin/pembayaran_beli/view_keterangan.php';
    }

		function cancel_pembel(){
			if($this->session->userdata('level') != "suadmin"){
				die("Tidak Memiliki Akses");
			}
			$id_pembayaran = $this->uri->segment(4);
			$get_pembel = $this->db->where('id_pembel',$id_pembayaran)->get('pembayaran_beli')->row();
			// apus trs bank
			$this->db->where("id_transaksi_bank",$get_pembel->id_trs_bank)->delete('transaksi_bank');
			// Foreach Id Invoice
			$get_id_inv = $this->db->where('id_pembayaran',$id_pembayaran)->where("tipe_sub","beli")->get('sub_pembayaran')->result();
			foreach($get_id_inv as $getinv){
				$invoice_beli = $this->db->where('id_invoice_beli',$getinv->id_invoice)->get('invoice_beli')->row();
				$update_invbel['jumlah_bayar_invoice_beli'] = $invoice_beli->jumlah_bayar_invoice_beli - $getinv->jumlah_bayar_sub;
				if($update_invbel['jumlah_bayar_invoice_beli'] == 0){
					$update_invbel['status_invoice_beli'] = 1;
				}
				$this->db->where("id_invoice_beli",$invoice_beli->id_invoice_beli)->update('invoice_beli',$update_invbel);
			}
			// hapus sub Pembelian
			$this->db->where("id_pembayaran",$id_pembayaran)->where("tipe_sub","beli")->delete('sub_pembayaran');
			// hapus Keterangan Pembelian
			$this->db->where("id_pembayaran",$id_pembayaran)->where("tipe_keterangan","beli")->delete('keterangan_pembayaran');
			// hapus sub dan Pembelian
			$this->db->where("id_pembel",$id_pembayaran)->delete('pembayaran_beli');
			redirect(base_url("admin/pembayaran_beli"));
		}
}
