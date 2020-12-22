<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		// cek_session(); //cek session User Login
		$this->load->model('Mcustomer'); //Load Model Customer
		// $this->load->model('Mtransaksi'); //Load Model Customer
		// $this->load->model('Minvoice'); //Load Model Customer
		// $this->load->model('Mpembayaran'); //Load Model Customer
		// $this->load->model('Mjenis_barang_customer'); //Load Model Customer
	}

	//Function Halaman Awal Menu Customer
	 function index(){
		$idcust=$this->session->userdata('id_cust');
		$parse['cs']=$this->Mcustomer->get_id2($idcust)->row();
		$this->template->load('template_dashboard','dashboard/pengaturan/pengaturan',$parse);
	}

	function keamanan(){
		$this->template->load('template_dashboard','dashboard/pengaturan/keamanan');
	}
	function finance(){
		$idcust=$this->session->userdata('id_cust');
		$parse['rek']=$this->db->select('rekening,an,no_rek')->from('rekening_pengguna')                   
		->where('id_cust',$idcust)
		->get()->row();
		$this->template->load('template_dashboard','dashboard/pengaturan/finance',$parse);
	}

	//update datacustomer
	function updaterekening(){
		$idcust=$this->session->userdata('id_cust');
		$cekresk=$this->db->select('id_rekening_pengguna')->from('rekening_pengguna')                   
		->where('id_cust',$idcust)
		->get()->row();
		if(empty(@$cekresk->id)){
			$ins['id_cust'] = $idcust;
			$ins['rekening'] = $this->input->post('rekening');
			$ins['an'] = $this->input->post('an');
			$ins['no_rek'] = $this->input->post('no_rek');
			$this->db->insert('rekening_pengguna', $ins);
		}else{
			$reken['rekening'] = $this->session->userdata('rekening');
			$reken['an'] = $this->input->post('an');
			$reken['no_rek'] = $this->input->post('no_rek');
			$this->db->where('id_cust',$idcust);
			$this->db->update('rekening_pengguna', $reken);
		}
		
		 $this->session->set_flashdata('msg','success');
        redirect(site_url('pengaturan/finance'));
	}

	//update datacustomer
	function update(){
		$cus['id_cust'] = $this->session->userdata('id_cust');
		$cus['nama'] = $this->input->post('nama');
		$cus['telepon'] = $this->input->post('telepon');
		$cus['whatsapp'] = $this->input->post('whatsapp');
		$cus['email'] = $this->input->post('email');
 
		 $this->db->where('id_cust',$this->session->userdata('id_cust'));
		 $this->db->update('customer', $cus);
		 $this->session->set_flashdata('msg','success');
		 $this->session->set_userdata('nama',$this->input->post('nama'));
        redirect(site_url('pengaturan'));
	}

	//update password
	function updatepassword(){
		$idcust=$this->session->userdata('id_cust');
		$selectuser=$this->db->select('id_pengguna')->from('pengguna_customer')                   
		->where('id_cust',$idcust)
		->where('password',md5($this->input->post('passwordlama')))
		->get()->row();
		if($selectuser->id_pengguna > 0){
		  //  var_dump($selectuser->id_pengguna);
			$pass['password'] = md5($this->input->post('passwordbaru'));
  
			$this->db->where('id_cust',$this->session->userdata('id_cust'));
			$this->db->update('pengguna_customer', $pass);
			  $this->session->set_flashdata('msg','updated');
        	 redirect(site_url('pengaturan/keamanan'));
		}else{
			$this->session->set_flashdata('msg','passwordsalah');
        	redirect(site_url('pengaturan/keamanan'));
		}
	}

}
