<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Klaim extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		cek_session(); //cek session Login
		$this->load->model('Mklaim');
	}

	//Function Halaman Awal Menu klaim
	 function index(){
 	  $data['bank'] = $this->db->get('master_bank')->result();
		$this->template->load('template','admin/klaim/klaim',$data);
	 }

	//Function Get data Json klaim
	function get_klaim_json() {
    header('Content-Type: application/json');
    echo $this->Mklaim->get_klaim();
   }

   //Function Simpan Add New klaim
   function save(){
   		$data = $this->Mklaim->save($this->input->post());
   }

	 //Function Update klaim
   function delete(){
		 $idklaim = $this->input->post('id_klaim');
  	 $this->db->where('id_klaim',$idklaim)->delete('klaim');
		 $this->session->set_flashdata('msg','deleted');
		 redirect(site_url('admin/klaim'));
   }

	 //Function Refund klaim
   function refund(){
		 $data = $this->Mklaim->refund($this->input->post());
   }

	 //Function Potongan klaim
   function potongan(){
		 $data = $this->Mklaim->potongan($this->input->post());
   }

	 //Function Potongan klaim
   function vendor_klaim(){
		 $data = $this->Mklaim->vendor_klaim($this->input->post());
   }

	 //Function Get Invoice by Customer , Call back ajax
   public function invoice_customer(){
     // Ambil Data Invoice
     $id_cust = $this->input->post('cust_id');
     $invoice = $this->db->where('status_invoice',0)->where('id_cust',$id_cust)->get('invoice')->result();
		 $lists = "";
     $lists .= '<select name="id_invoice" class="form-control">';
     foreach($invoice as $data){
     	$lists .= "
 			<option value='".$data->id_invoice."'>".$data->kode_invoice."</option>
 		   "; // Tambahkan tag option ke variabel $lists
     }
		 $lists .= '</select>';
     $callback = array('get_invoice'=>$lists); // Masukan variabel lists tadi ke dalam array $callback dengan index array : list_kota
     echo json_encode($callback); // konversi varibael $callback menjadi JSON
   }

}
