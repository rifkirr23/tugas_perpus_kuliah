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
			// if(isset($_COOKIE['atk']))
			// {
			// $time = time();
			// 	setcookie("atk[wilopoc]", $time - 3600);
			// }
			redirect('login');
		}

	//process login
	public function proses(){
		$cek= $this->Mlogin->login();//Cek User
		// var_dump($cek->result());
		if($cek <=-1){
			$parse['selisih']=$cek;
			$this->session->set_flashdata('msg','banned15');
			$this->load->view('login',$parse);
		}else if($cek == 'salahpass'){
			$this->session->set_flashdata('msg','salahpass');
			redirect(base_url());
		}else if($cek == 'salahus'){
			$this->session->set_flashdata('msg','salahus');
			redirect(base_url());
		}else if($cek == 'tidakaktif'){
			$this->session->set_flashdata('msg','tidakaktif');
			redirect(base_url());
		}else if(@$cek->id_pengguna > 0){

			$this->session->set_userdata('id_pengguna',$cek->id_pengguna);
			$this->session->set_userdata('id_cust',$cek->id_cust);
			$this->session->set_userdata('nama',$cek->nama);
			$this->session->set_userdata('kode',$cek->kode);
			$this->session->set_userdata('status_ganti_marking',$cek->status_ganti_marking);
			$this->session->set_userdata('levelc',$cek->level);
			$this->Mlogin->updatelastlogin($this->session->userdata('id_cust'));
				//halaman customer
					redirect(base_url('dashboard'));
		}else{
			$this->session->set_flashdata('msg','gagal');
			redirect(base_url());
		}
	}

	public function teslogin(){
		// die("ini link");
		$cek= $this->Mlogin->login();//Cek User
		// print_r($this->input->post());die();
		if($cek <=-1){
			$callback = array('status'=>"500"); // Masukan variabel lists tadi ke dalam array $callback dengan index array : list_kota
			 echo json_encode($callback);
		}else if($cek == 'salahpass'){
			$callback = array('status'=>"502"); // Masukan variabel lists tadi ke dalam array $callback dengan index array : list_kota
			 echo json_encode($callback);
		}else if($cek == 'salahus'){
			$this->session->set_flashdata('msg','salahus');
			redirect(base_url());
		}else if($cek == 'tidakaktif'){
			$this->session->set_flashdata('msg','tidakaktif');
			redirect(base_url());
		}else if(@$cek->id_pengguna > 0){

			$this->session->set_userdata('id_pengguna',$cek->id_pengguna);
			$this->session->set_userdata('id_cust',$cek->id_cust);
			$this->session->set_userdata('nama',$cek->nama);
			$this->session->set_userdata('kode',$cek->kode);
			$this->session->set_userdata('status_ganti_marking',$cek->status_ganti_marking);
			$this->session->set_userdata('levelc',$cek->level);
			$this->Mlogin->updatelastlogin($this->session->userdata('id_cust'));
				//halaman customer
			$callback = array('status'=>"200"); // Masukan variabel lists tadi ke dalam array $callback dengan index array : list_kota
			 echo json_encode($callback); // konversi varibael $callback menjadi JSON
		}else{
			$callback = array('status'=>"501"); // Masukan variabel lists tadi ke dalam array $callback dengan index array : list_kota
			 echo json_encode($callback);
		}
	}
}
