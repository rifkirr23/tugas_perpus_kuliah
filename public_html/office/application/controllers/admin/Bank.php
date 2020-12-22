<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bank extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		cek_session(); //cek session Login
		$this->load->model('Mbank');
		$this->load->model('Mtbank');
		$this->load->model('Mrmb');
	}

	//Function Halaman Awal Menu Bank
	function index(){
		$data['master_bank'] = $this->db->get('master_bank')->result();
		$this->template->load('template','admin/bank/bank',$data);
	}

	//Function Get data Json Bank
	function get_bank_json() {
    header('Content-Type: application/json');
    echo $this->Mbank->get_bank();
  }

	//Function Simpan Add New Bank
	function save(){
    $data = $this->Mbank->save($this->input->post());
	}

	// Function Simpan Update Bank
	function update(){
    $data = $this->Mbank->update($this->input->post());
	}

	// Function Transaksi Bank
  function transaksi(){
		$id_bank = $this->uri->segment(4);
		$data['bank']= $this->db->where('id_bank !=',$id_bank)->get('master_bank')->result();
		$data['jenis_transaksi_masuk'] = $this->db->where('tipe_jenis_transaksi',1)->get('jenis_transaksi_bank')->result();
		$data['jenis_transaksi_keluar'] = $this->db->where('tipe_jenis_transaksi',2)->order_by('kjenis_transaksi_bank','asc')->get('jenis_transaksi_bank')->result();
		$data['data_rmb'] = $this->Mrmb->allrmb()->result();
		$this->template->load('template','admin/bank/transaksi',$data);
	}

	// Function Saldo Harian
	function saldo_harian(){
		$id_bank = $this->uri->segment(4);
		$data['bank']= $this->db->where('id_bank !=',$id_bank)->get('master_bank')->result();
		$data['data_rmb'] = $this->Mrmb->allrmb()->result();
		$this->template->load('template','admin/bank/saldo_harian',$data);
	}

	// Function Save Transaksi Bank
	function save_transaksi(){
     $data = $this->Mtbank->save($this->input->post());
     redirect(site_url('admin/bank/transaksi/'.$this->input->post('id_bank')));
  }

	//Function Transaksi Bank Json
	function get_tb_json() { 				//data data kurs by JSON object
    header('Content-Type: application/json');
    $id=$this->uri->segment(4);
    echo $this->Mtbank->get_transaksi($id);
  }

	//Function Transaksi Bank Json
	function get_saldo_harian_json() { 				//data data kurs by JSON object
    header('Content-Type: application/json');
    $id=$this->uri->segment(4);
    echo $this->Mbank->get_saldo_harian($id);
  }

	// Function Select Jenis Transaksi Bank
  function select_jtb(){
    $kode = $this->input->get('kode');
    $data_jtb = $this->Mtbank->select_jtb($kode);
    echo json_encode($data_jtb);
  }

	//Function Select Jenis Transaksi Bank dengan parameter Kode , Tipe Jenis Transaksi
  function select_jtb2(){
    $kode = $this->input->get('kode');
    $data_jtb = $this->Mtbank->select_jtb2($kode,$this->uri->segment(4));
    echo json_encode($data_jtb);
  }

	// Function Select Data Master Bank
  function select_bank(){
    $kode = $this->input->get('id_bank');
    $data_bank = $this->Mbank->select_bank($kode);
    echo json_encode($data_bank);
  }

	//Function Get Invoice by Customer , Call back ajax
  public function pilih_jenis_transaksi(){
    // Ambil Data Invoice
    $id_jenis_transaksi = $this->input->post('kode');
    if($id_jenis_transaksi){

		}
    $callback = array('get_invoice'=>$lists); // Masukan variabel lists tadi ke dalam array $callback dengan index array : list_kota
    echo json_encode($callback); // konversi varibael $callback menjadi JSON
  }

	// Function Simpan Update Bank
	function update_saldoharian(){
		// print_r($this->input->post());die();
    $update_saldo['keterangan'] = $this->input->post('keterangan');
		$this->db->where('id_saldo_harian',$this->input->post('id_saldo_harian'))->update('saldo_harian',$update_saldo);
		redirect(base_url('admin/bank/saldo_harian/'.$this->input->post('id_bank')));
	}

}
