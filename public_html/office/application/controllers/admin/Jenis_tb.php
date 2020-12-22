<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_tb extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		// session_suadmin(); //cek session Login
		$this->load->model('Mjenis_tb');
	}

	//Function Halaman Awal Menu Jenis Transaksi Bank
	function index(){
		$data['data_parent'] = $this->db->order_by('id_parent','asc')->get('parent_jenis_transaksi')->result();
		$this->template->load('template','admin/jenis_tb/jenis_tb',$data);
	}

	//Function Get data Json Jenis Transaksi Bank
	function get_jtb_json() {
    header('Content-Type: application/json');
    echo $this->Mjenis_tb->get_jtb();
  }

   //Function Simpan Add New Jenis Transaksi Bank
  function save(){
    $data = $this->Mjenis_tb->save($this->input->post());
  }

	// Function Simpan Update Jenis Transaksi Bank
  function update(){
    $data = $this->Mjenis_tb->update($this->input->post());
  }

	function view_update(){
		 $id= $this->uri->segment(4);
		 $data_jenis_tb = $this->db->where('id_jenis_transaksi_bank',$id)->get('jenis_transaksi_bank')->row();
		 $data_parent = $this->db->order_by('id_parent','asc')->get('parent_jenis_transaksi')->result();
		 include APPPATH. 'views/admin/jenis_tb/view_update.php';
	}

}
