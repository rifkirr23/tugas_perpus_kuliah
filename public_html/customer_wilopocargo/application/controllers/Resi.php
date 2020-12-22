<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resi extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		// cek_session(); //cek session User Login
		$this->load->model('Mresi'); //Load Model Customer
		$this->load->model('Mresi_udara');
		// $this->load->model('Mtransaksi'); //Load Model Customer
		// $this->load->model('Minvoice'); //Load Model Customer
		// $this->load->model('Mpembayaran'); //Load Model Customer
		// $this->load->model('Mjenis_barang_customer'); //Load Model Customer
	}

	//Function Halaman Awal Menu Customer
	function index(){
		$this->template->load('template_dashboard','dashboard/resi/resi');
	}

	function udara(){
		$this->template->load('template_dashboard','dashboard/resi/resi_udara');
	}

	function request_resi(){
		$this->template->load('template_dashboard','dashboard/resi/request_resi');
	}

	function resi_order(){
		$this->template->load('template_dashboard','dashboard/resi/resi_order');
	}

	//Function Get data Json resi
	function get_request_id_json() {
		header('Content-Type: application/json');
		$id=$this->uri->segment(3);
		echo $this->Mresi->get_request_id($id);
	}

	//Function Get data Json resi
	function get_resiid_json() {
		header('Content-Type: application/json');
		$id=$this->uri->segment(3);
		echo $this->Mresi->get_resi_byid($id);
	}

	function detail() {
		$id = $this->uri->segment(3);			//data data Customer by JSON object
		$parse['r']=$this->Mresi->get_id2($id)->row();
		$this->template->load('template_dashboard','dashboard/resi/detail',$parse);
	}
	function detail_udara() {
		$id = $this->uri->segment(3);
		$idinv = $this->uri->segment(4);			//data data Customer by JSON object
		$parse['r']=$this->Mresi_udara->getresiinvid($id)->row();
		$parse['sub_pembayaran']=$this->Mresi_udara->data_sub_pembayaran($idinv)->result();
    	$parse['potongan']=$this->Mresi_udara->data_potongan($idinv)->result();
		// var_dump($parse);
		$this->template->load('template_dashboard','dashboard/resi/detail_udara',$parse);
	}
	function get_resiudara_json() {
		header('Content-Type: application/json');
		echo $this->Mresi_udara->get_resiudara();
	}

	function get_barcodeid_json() { 				//data data Customer by JSON object
		header('Content-Type: application/json');
		$id = $this->uri->segment(3);
		echo $this->Mresi->get_barcode_byid($id);
	}

	function kode_request(){
		$hcekkode= $this->db->select('kode_request as maxkode')->order_by('id_request_resi','desc')->get('request_resi')->row();
		$kodesaatini= $hcekkode->maxkode;
		$ambilkode= str_replace('WC/RESI/','',$kodesaatini);
	  if($ambilkode=="")
		{
		 $ambilkode=0;
		}
		$kodejadi= $ambilkode+1;

		$hasil= $kodejadi;
		return 'WC/RESI/'.$hasil;
  }

	function save_requestresi(){
		// print_r($this->input->post());die();
		$save_request['supplier'] = $this->input->post('supplier');
		$save_request['tel'] = $this->input->post('tel');
		$save_request['id_cust'] = $this->session->userdata('id_cust');
		$save_request['jumlah_koli'] = $this->input->post('jumlah_koli');
		$save_request['gudang'] = $this->input->post('gudang');
		$save_request['note'] = $this->input->post('note');
		$save_request['tanggal_request'] = date('Y-m-d');
		$save_request['kode_request'] = $this->kode_request();
		// input
		$this->db->insert('request_resi', $save_request);
		$id_request = $this->db->insert_id();
		// print_r($this->session->userdata('id_cust'));die();
		// Upload File
		// print_r($_FILES['fotoekspedisi_lokal']);die();
		foreach ($_FILES['fotoekspedisi_lokal']['name'] as $key => $image) {
		 // print_r("img".time());die();
		 $time = "fotoekspedisi_lokal".time();
		 $filename=$_FILES['fotoekspedisi_lokal']['name'][$key];
		 $extension=end(explode(".", $filename));
		 $newfilename=$time .".".$extension;

				if($_FILES['fotoekspedisi_lokal']['name'][$key] == "")
				{

				}else{
					move_uploaded_file($_FILES["fotoekspedisi_lokal"]["tmp_name"][$key], './../office/assets/fotoekspedisi_lokal/'.$newfilename);
					$fotoekspedisi_lokal=$newfilename;
					$upload_fotoeks['id_request_resi'] = $id_request;
					$upload_fotoeks['nama_file'] = $newfilename;
					// input
					$this->db->insert('file_ekspedisi', $upload_fotoeks);
				}
		}
		$no = 1;
    $encrypt  = $this->input->post('encrypt_resi');
	  foreach ($_FILES['file_pl']['name'] as $key => $image) {
			$time = "file_pl".time().$no; $no++;
 		  $filename=$_FILES['file_pl']['name'][$key];
 		  $extension=end(explode(".", $filename));
 		  $newfilename=$time .".".$extension;
	    if($_FILES['file_pl']['name'][$key] == "")
	    {

	    }else{
		      move_uploaded_file($_FILES["file_pl"]["tmp_name"][$key], './../office/assets/file_pl/'.$newfilename);
			}
		      $file_pl=$newfilename;
		      $filepacking['file_pl'] = $file_pl;
					$filepacking['tanggal_upload'] = date('Y-m-d H:i:s');
					$filepacking['id_request_resi'] = $id_request;
					$filepacking['nomor_resi'] = $save_request['kode_request'];
		      $this->db->insert('file_packing', $filepacking);

	  }

		$upd_req['id_request_resi'] = $id_request;
		$this->db->where('nomor__resi',$save_request['kode_request'])->update('file_packing', $upd_req);

		$this->session->set_flashdata('msg','oksave');
		redirect(site_url('resi/resi_order'));
	}
}
