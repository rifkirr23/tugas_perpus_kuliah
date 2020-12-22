<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){ //Construct Function
		parent:: __construct();
		$this->load->model('Mlogin');//Load Model Login
	}

	//load view login
	public function index(){
		$this->load->view('login');
	}

	//Load View change password user
	public function change_password(){
	  $data['change']= $this->Mlogin->change_password()->row_array();
		$this->load->view('change_password',$data);
	}

	//process change password
	public function simpancp(){
		$this->Mlogin->simpancp();	//Proses Change Password

	}

	//Logout
	public function logout(){
			$this->session->sess_destroy();
			redirect('login');
		}

	//process login
	public function proses(){
		$cek= $this->Mlogin->login();//Cek User
		if($cek->num_rows()>0){ //Cek Jika User sudah Terdaftar
			foreach($cek->result() as $r);//Set Session
				if($r->status == 100){
					$this->session->set_flashdata('msg','nonaktif');
					redirect(base_url());
				}
				$this->session->set_userdata('id_pengguna',$r->id_pengguna);
				$this->session->set_userdata('nama_pengguna',$r->nama_pengguna);
				$this->session->set_userdata('level',$r->level);
				$this->Mlogin->updatelastlogin($this->session->userdata('id_pengguna'));
				//Redirect Jika User Adalah admin
				if($r->level=='admin' || $r->level=='admin2' || $r->level=='suadmin' || $r->level=='finance' ||
				 	 $r->level=='crm' || $r->level=='cs' || $r->level=='spv' || $r->level=='gudang' || $r->level=='cschina'){
					redirect(base_url('dashboard'));
				}else if($r->level=='sales' || $r->level=='saleso'){
					redirect(base_url('admin/customer'));
				}

		}
		else{ //Jika USer Gagal Login
			$this->session->set_flashdata('msg','gagal');
			redirect(base_url());
		}
	}
}
