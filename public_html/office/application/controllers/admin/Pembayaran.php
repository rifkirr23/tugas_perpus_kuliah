<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		// cek_session(); //cek session Login
	  $this->load->model('Mpembayaran');
		$this->load->model('Mpembayaran_beli');
	  $this->load->model('Mtransaksi');
	}

	//Function Halaman Awal Menu pembayaran
	function index(){
		$this->template->load('template','admin/pembayaran/pembayaran');
	}

	// Function New Pembayaran
	function new(){
		$parse['bank']= $this->db->get('master_bank')->result();
    $parse['customer']=$this->Mtransaksi->get_customer();
    $parse['kode_pembayaran']=$this->Mpembayaran->code_pembayaran();
    $this->template->load('template','admin/pembayaran/new_pembayaran',$parse);
  }

	//Function Get data Json pembayaran
	function get_pembayaran_json() {
    header('Content-Type: application/json');
    echo $this->Mpembayaran->get_pembayaran();
  }

	// Data Pembayaran Json
  function get_pembayaranid_json() {
    header('Content-Type: application/json');
    $id=$this->uri->segment(4);
    echo $this->Mpembayaran->get_pembayaran_byid($id);
  }

	function get_pembayaranidgrup_json() {
    header('Content-Type: application/json');
    $id=$this->uri->segment(4);
    echo $this->Mpembayaran->get_pembayaran_byidgrup($id);
  }

	//Function Get Invoice by Customer , Call back ajax
  public function get_invoice(){
    // Ambil Data Invoice
    $id_cust = $this->input->post('id_cust');
    $invoice = $this->Mpembayaran->get_invoice($id_cust);
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
    $callback = array('get_invoice'=>$lists); // Masukan variabel lists tadi ke dalam array $callback dengan index array : list_kota
    echo json_encode($callback); // konversi varibael $callback menjadi JSON
  }

	// Function Get Invoice by Customer Grup , Call back Ajax
	public function get_invoicegrup(){
	   // Ambil Data Invoice
	   $id_cgrup = $this->input->post('id_cgrup');
	   $invoice = $this->Mpembayaran->get_invoicegrup($id_cgrup);//print_r($invoice);die();
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
    $id_invoice = $this->input->post('id_invoice');
    //die(json_encode($id_invoice[0]));
    $invoice = $this->Mpembayaran->get_invoice2($id_invoice);
    // Buat variabel untuk menampung tag-tag option nya
    // Set defaultnya dengan tag option Pilih
    // $callback = array('get_invoice'=>$lists); // Masukan variabel lists tadi ke dalam array $callback dengan index array : list_kota
    echo json_encode($invoice); // konversi varibael $callback menjadi JSON
   }

	 function select_customer(){
	    cek_session_all();
	    $kode = $this->input->get('kode');
	    $data_cust = $this->db->select('id_cust,kode')
	    											->limit(10)
														->where('id_cgrup',0)
	    											->from('customer')
	    											->like('kode', $kode)
	    											->get()->result_array();
	    echo json_encode($data_cust);
   }

   //Function Simpan Add New pembayaran
   function save(){
    	$data = $this->Mpembayaran->save($this->input->post());
   }

	 // Function Update Pembayaran
   function update(){
      $data = $this->Mpembayaran->update($this->input->post());
   }

	 // Function Deleted
   function deleted(){
      $data = $this->Mpembayaran->deleted($this->input->post());
   }

	 // Function View Image Bukti Bayar
   function view_image(){
    $id= $this->uri->segment(4);
    $file1= $this->Mpembayaran->getfile_bb_cust($id)->result();
    include APPPATH. 'views/admin/pembayaran/view_image.php';
   }

		// Function Keterangan Pembayaran
    function view_keterangan(){
      $id= $this->uri->segment(4);
      $gk= $this->Mpembayaran->get_keterangan($id)->result();
      $gk1= $this->Mpembayaran->get_keterangan1($id)->row_array();
      include APPPATH. 'views/admin/pembayaran/view_keterangan.php';
    }

		function cancel_pembayaran(){
			if($this->session->userdata('level') != "suadmin"){
				die("Tidak Memiliki Akses");
			}
			$id_pembayaran = $this->uri->segment(4);
			$get_pembayaran = $this->db->where('id_pembayaran',$id_pembayaran)->get('pembayaran')->row();
			// apus trs bank
			// $this->db->where("id_transaksi_bank",$get_pembayaran->id_trs_bank)->delete('transaksi_bank');
			// Foreach Id Invoice
			$get_id_inv = $this->db->where('id_pembayaran',$id_pembayaran)->where("tipe_sub is null",null,false)->get('sub_pembayaran')->result();
			foreach($get_id_inv as $getinv){
				$invoice = $this->db->where('id_invoice',$getinv->id_invoice)->get('invoice')->row();
				$update_invbel['jumlah_bayar'] = $invoice->jumlah_bayar - $getinv->jumlah_bayar_sub;
				if($update_invbel['jumlah_bayar'] == 0){
					$update_invbel['status_invoice'] = 0;
				}
				$this->db->where("id_invoice",$invoice->id_invoice)->update('invoice',$update_invbel);
			}
			// hapus sub Pembelian
			$this->db->where("id_pembayaran",$id_pembayaran)->where("tipe_sub is null",null,false)->delete('sub_pembayaran');
			// hapus Keterangan Pembelian
			$this->db->where("id_pembayaran",$id_pembayaran)->where("tipe_keterangan is null",null,false)->delete('keterangan_pembayaran');
			// hapus sub dan Pembelian
			$this->db->where("id_pembayaran",$id_pembayaran)->delete('pembayaran');
			redirect(base_url("admin/pembayaran"));
		}

}
