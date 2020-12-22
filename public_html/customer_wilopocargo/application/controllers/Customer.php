<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		cek_session(); //cek session User Login
		$this->load->model('Mcustomer'); //Load Model Customer
		$this->load->model('Mtransaksi'); //Load Model Customer
		$this->load->model('Minvoice'); //Load Model Customer
		$this->load->model('Mpembayaran'); //Load Model Customer
		$this->load->model('Mjenis_barang_customer'); //Load Model Customer
	}

	//Function Test Api Wablas aja
	function test_whatsapp(){
		$pesan ="_(Wilopo Cargo)_";
		sendwhatsapp($pesan,"083815423599");
		// send_document("Invoice.pdf","083815423599","tess");
	}

	//Function Test Api Wablas aja
	function test_api(){
		$a = -1000;
		$b = 2000;
		echo $b - ($a);
		die();
	}

	//Function Halaman Awal Menu Customer
	 function index(){
		$this->template->load('template','admin/customer/customer');
	}

	//Function Get data Json Customer
	function get_customer_json() {//data data Customer by JSON object
    header('Content-Type: application/json');
    echo $this->Mcustomer->get_customer();
  }

	// Function Deposit Customer
  function get_depositid_json() {//data data Deposit by JSON object
    header('Content-Type: application/json');
    $id=$this->uri->segment(4);
    echo $this->Mcustomer->get_depositid($id);
  }

	//Function View Image (Ktp,Sk) Customer
	function view_image(){
	 $id= $this->uri->segment(4);
	 $file1= $this->Mcustomer->get_id2($id)->row_array();
	 include APPPATH. 'views/admin/customer/view_image.php';
	}

	// Function Detail Customer
  function detail(){
    $id = $this->uri->segment(4);
		$segment = $this->uri->segment(5);
		$parse['detail'] = 1; //Set Detail = 1 Untuk di view/template.php
    $parse['r']=$this->Mcustomer->get_id2($id)->row();
		$parse['jenis_barang_customer']=$this->db->where('id_cust',$id)->get('jenis_barang_customer')->num_rows();
		$parse['rowjenisbarang']=$this->db->where('id_cust',$id)->from('jenis_barang_customer')->get()->result();
		// print_r($parse['rowjenisbarang']);die();
		// Untuk Tab Menu di Customer
		if($segment == "resi"){
			$this->template->load('template','admin/customer/detail_resi',$parse);
		}else if($segment == "transaksi"){
			$this->template->load('template','admin/customer/detail_transaksi',$parse);
		}else if($segment == "invoice"){
			$this->template->load('template','admin/customer/detail_invoice',$parse);
		}else if($segment == "pembayaran"){
			$this->template->load('template','admin/customer/detail_pembayaran',$parse);
		}else if($segment == "deposit"){
			$this->template->load('template','admin/customer/detail_deposit',$parse);
		}else if($segment == "invoice_barang"){
			$this->template->load('template','admin/customer/detail_invoicebarang',$parse);
		}else if($segment == "barang"){
			$this->template->load('template','admin/customer/detail_barcode',$parse);
		}else if($segment == "harga_khusus"){
			$this->template->load('template','admin/customer/detail_harga',$parse);
		}
  }

   //Function Proses Simpan Add New Customer
   function save(){
		 $h=date('H')+5;  $i=date('i');   $s=date('s');
		 $date= date('Y-m-d');
		 $data_kode= $this->Mcustomer->get_id($this->input->post('kode'));
		 // Validasi Marking Customer
	   if($data_kode->num_rows()>0){
       foreach($data_kode->result() as $c ){
        $kode=$c->kode;
       }
     }else{
      $kode="";
     }
     if($kode == $this->input->post('kode')){
        $this->session->set_flashdata('msg','notvalid');
      ?><script type="text/javascript">

          window.location.href = "<?php print site_url() ?>admin/customer";
    	  </script><?php
		 }else{
				$temp1 = explode(".", $_FILES['foto_ktp']['name']);
				$new_name1 = time().'.'.end($temp1);
				$config1['upload_path'] = './assets/foto_ktp/';
		    $config1['file_name'] = $new_name1;
		    $config1['allowed_types'] = 'jpg|jpeg|png|pdf';
		    $this->load->library('upload');
		    $this->upload->initialize($config1);
		    if(!$this->upload->do_upload('foto_ktp')){
			   	$this->upload->display_errors();
			    $new_name1 = "";
		    }
		    $media1 = $this->upload->data('foto_ktp');

			  $temp2 = explode(".", $_FILES['foto_sk']['name']);
			  $new_name2 = time().'.'.end($temp2);
			  $config2['upload_path'] = './assets/foto_sk/';
			  $config2['file_name'] = $new_name2;
			  $config2['allowed_types'] = 'jpg|jpeg|png|pdf';
			  $this->load->library('upload');
			  $this->upload->initialize($config2);
			  if(!$this->upload->do_upload('foto_sk')){
				 $this->upload->display_errors();
				 $new_name1 = "";
			  }
			  $media2 = $this->upload->data('foto_sk');

			  $data = $this->Mcustomer->save($new_name1,$new_name2);
			}
  	}

    //Function Proses Update Customer
    function update(){
			$temp1 = explode(".", $_FILES['foto_ktp']['name']);
			$new_name1 = time().'.'.end($temp1);
			$config1['upload_path'] = './assets/foto_ktp/';
			$config1['file_name'] = $new_name1;
			$config1['allowed_types'] = 'jpg|jpeg|png|pdf';
			$this->load->library('upload');
			$this->upload->initialize($config1);
			if(!$this->upload->do_upload('foto_ktp')){
				$this->upload->display_errors();
			  $new_name1 = "";
			}
		 $media1 = $this->upload->data('foto_ktp');

		 //var_dump($_FILES['foto_ktp']['name']);die();

		 $temp2 = explode(".", $_FILES['foto_sk']['name']);
		 $new_name2 = time().'.'.end($temp2);
		 $config2['upload_path'] = './assets/foto_sk/';
		 $config2['file_name'] = $new_name2;
		 $config2['allowed_types'] = 'jpg|jpeg|png|pdf';
		 $this->load->library('upload');
		 $this->upload->initialize($config2);
		 if(!$this->upload->do_upload('foto_sk')){
			 $this->upload->display_errors();
			 $new_name2 = "";
		 }
		 $media2 = $this->upload->data('foto_sk');
     $data = $this->Mcustomer->update($new_name1,$new_name2);
  }

	// Function Select Customer Output Json
	function select_grup(){
		 cek_session_all();
		 $kode = $this->input->get('kode_cgrup');
		 $data_cust = $this->Mcustomer->select_grup($kode);
		 echo json_encode($data_cust);
	}

	// Function Resend Chat Marking Customer
	function resend_chat(){
		 cek_session_all();
		 $this->Mcustomer->resend_chat();
	}

	function buka_harga(){
		$idcust = $this->input->post('id_cust');
		$this->Mjenis_barang_customer->buka_harga($idcust);
	}

	function update_harga(){
		$this->Mjenis_barang_customer->update_harga();
	}

	

}
