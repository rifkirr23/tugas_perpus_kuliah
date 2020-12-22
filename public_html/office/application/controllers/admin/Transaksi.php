<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

	public function __construct(){
		parent::__construct();
		//echo base_url()."assets/bukti_bayar_rmb/";
		$this->load->model('Mtransaksi'); //Load Model Transaksi
	}

	//Function Halaman Awal Menu transaksi

	 function index(){
		$parse['customer']=$this->Mtransaksi->get_customer();//Data Customer
        $parse['kode_transaksi']=$this->Mtransaksi->code_transaksi();//Code TRansaksi

        if($this->session->userdata('level')=="admin2"){
                  cek_session_all();//cek session
                  $this->template->load('template','admin/transaksi/transaksi2',$parse);
        }else{
                  cek_session(); //cek session
    		      $this->template->load('template','admin/transaksi/transaksi',$parse); //Load View Transaksi
        }
   }

  function newt(){
    cek_session();
    $parse['customer']=$this->Mtransaksi->get_customer();
    $parse['kode_transaksi']=$this->Mtransaksi->code_transaksi();
    $this->template->load('template','admin/transaksi/new_transaksi',$parse);
  }

	//Function Get data Json transaksi

	function get_transaksi_json() { 				//data data transaksi by JSON object
    cek_session();
    header('Content-Type: application/json');
    echo $this->Mtransaksi->get_transaksi();
   }

   function get_transaksi2_json() {
    cek_session_all();//data data transaksi2 by JSON object
    header('Content-Type: application/json');
    echo $this->Mtransaksi->get_transaksi2();
   }

   function get_transaksiid_json() { 				//data data transaksi by JSON object
    cek_session();
    header('Content-Type: application/json');
    $id=$this->uri->segment(4);
    echo $this->Mtransaksi->get_transaksi_byid($id);
   }

	 function get_transaksiidgrup_json() { 				//data data transaksi by JSON object
    cek_session();
    header('Content-Type: application/json');
    $id=$this->uri->segment(4);
    echo $this->Mtransaksi->get_transaksi_byidgrup($id);
   }

	 function select_customer(){
	    cek_session_all();
	    $kode = $this->input->get('kode');
	    $data_cust = $this->Mtransaksi->select_customer($kode);
	    echo json_encode($data_cust);
   }

	 function select_customergrup(){
	    cek_session_all();
	    $kode = $this->input->get('kode_cgrup');
	    $data_cust = $this->Mtransaksi->select_customergrup($kode);
	    echo json_encode($data_cust);
   }

   //Function Simpan Add New transaksi
   function save(){
      cek_session();
      $this->Mtransaksi->save();
    }

	 function salah_bank(){
     cek_session_all();
     $this->Mtransaksi->salah_bank();
   }

	 function update_bank(){
      cek_session_all();
      $this->Mtransaksi->update_bank();
    }

		function cancel_transaksi(){
       cek_session_all();
       $this->Mtransaksi->cancel_transaksi();
     }

		 function refund_invoice(){
        cek_session_all();
        $this->Mtransaksi->refund_invoice();
      }

    function update_v(){
	    cek_session_all();
	    $id = $this->uri->segment(4);
	    $parse['file2']= $this->Mtransaksi->getfile_bb_rmb($id)->result();
	    $parse['customer']=$this->Mtransaksi->get_customer();
	    $parse['transaksi']=$this->Mtransaksi->data_transaksi($id)->row_array();
	    $this->template->load('template','admin/transaksi/update_transaksi',$parse);
	  }

    function update(){
     cek_session_all();
     $this->Mtransaksi->update();
    //redirect('user/transaksisaya');
    }

    function view_image()
    {
      cek_session_all();
      $id= $this->uri->segment(4);
      $record= $this->Mtransaksi->data_transaksi($id)->result();
      $file2= $this->Mtransaksi->getfile_bb_rmb($id)->result();

      include APPPATH. 'views/admin/transaksi/view_image.php';
    }

}
