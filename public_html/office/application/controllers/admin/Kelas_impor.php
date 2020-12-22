<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas_impor extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		//session_suadmin(); //cek session Login
		$this->load->model('Mkelas_impor');
	}

	//Function Halaman Awal Menu kelas impor
	 function index(){
		$this->template->load('template','admin/kelas_impor/index');
	 }

	//Function Get data Json kelas impor
	function get_kelas_impor_json() {
    header('Content-Type: application/json');
    echo $this->Mkelas_impor->get_kelas_impor();
   }

   //Function Simpan Add New kelas impor
   function proses_konfirmasi(){
   		$data = $this->Mkelas_impor->proses_konfirmasi($this->input->post());
   }

	 function cek_kode_unik(){
		 for($i=1;$i>0;$i++){
	 			$kode_unik_trf = rand(1,300);
	 			$cek = $this->db->where('SUBSTRING(harga_member,5,3)',$kode_unik_trf,false)
	 											->get('daftar_kelas_impor')
	 											->num_rows();
	 			echo "<br />".$kode_unik_trf;
	 			if($cek == 0){
					return $kode_unik_trf;
	 				break;
	 			}
 		 }
	 }
	 //Function Update kelas impor
   function save_landing_page(){
        $secret_key = "6Ld_u9MUAAAAAECKBIXb5LdX_YIAWJZI1qtR0upH";

        $verify = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['g-recaptcha-response']);
        $response = json_decode($verify);
        if($response->success){
        	   $klsimpr['nama_lengkap'] = $this->input->post('nama');
        	   $klsimpr['customer_email'] = $this->input->post('email');
        	   $klsimpr['customer_phone'] = $this->input->post('telepon');
        	   $klsimpr['paket_member'] = $this->input->post('paket_member');
        	   $klsimpr['tgl_daftar'] = date("Y-m-d H:i:s");
        		 $cek_kode_unik = $this->cek_kode_unik();

        	   if($klsimpr['paket_member'] == 1){
        	     $klsimpr['harga_member'] = 4000000+$cek_kode_unik;
        			 $paket_daftar = "3 Tahun";
        	   }else if($klsimpr['paket_member'] == 2){
        	     $klsimpr['harga_member'] = 2400000+$cek_kode_unik;
        			 $paket_daftar = "1 Tahun";
        	   }
        		 $klsimpr['s_konfirmasi'] = 0;
        		 $this->db->insert('daftar_kelas_impor',$klsimpr);
        		 $last_id_ki = $this->db->insert_id();

        		 $nama = $klsimpr['nama_lengkap'];
        		 $email= $klsimpr['customer_email'];
        		 $telepon = $klsimpr['customer_phone'];
        		 $harga_member= $klsimpr['harga_member'];

        	   $curl_handle=curl_init();
        	   curl_setopt($curl_handle,CURLOPT_URL,"https://office.wilopocargo.com/api/email_kelas_impor/email_expert");
        	   curl_setopt($curl_handle, CURLOPT_POST, 1);
        	   curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "nama=$nama&email=$email&telepon=$telepon&paket=$paket_daftar&harga=$harga_member");
        	   $curlemail = curl_exec($curl_handle);
        	   curl_close($curl_handle);

        	   redirect("https://wilopocargo.com/silahkan-lakukan-pembayaran?daftar=".$last_id_ki."&nama=".$nama."&email=".$email."&telepon=".$telepon."&paket=".$paket_daftar."&harga=".$harga_member);
        }else{
            redirect("https://wilopocargo.com/jagoan-impor/?message=recaptcha#daftarexp");
        }
   }

	 //Function Update kelas impor
   function save_admin(){
	   $klsimpr['nama_lengkap'] = $this->input->post('nama');
	   $klsimpr['customer_email'] = $this->input->post('email');
	   $klsimpr['customer_phone'] = $this->input->post('telepon');
	   $klsimpr['paket_member'] = $this->input->post('paket_member');
	   $klsimpr['tgl_daftar'] = date("Y-m-d H:i:s");
		 $cek_kode_unik = $this->cek_kode_unik();

	   if($klsimpr['paket_member'] == 1){
	     $klsimpr['harga_member'] = 4000000+$cek_kode_unik;
			 $paket_daftar = "3 Tahun";
	   }else if($klsimpr['paket_member'] == 2){
	     $klsimpr['harga_member'] = 2400000+$cek_kode_unik;
			 $paket_daftar = "1 Tahun";
	   }
		 $klsimpr['s_konfirmasi'] = 0;
		 $this->db->insert('daftar_kelas_impor',$klsimpr);
		 $last_id_ki = $this->db->insert_id();

		 $nama = $klsimpr['nama_lengkap'];
		 $email= $klsimpr['customer_email'];
		 $telepon = $klsimpr['customer_phone'];
		 $harga_member= $klsimpr['harga_member'];

	   $curl_handle=curl_init();
	   curl_setopt($curl_handle,CURLOPT_URL,"https://office.wilopocargo.com/api/email_kelas_impor/email_expert");
	   curl_setopt($curl_handle, CURLOPT_POST, 1);
	   curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "nama=$nama&email=$email&telepon=$telepon&paket=$paket_daftar&harga=$harga_member");
	   $curlemail = curl_exec($curl_handle);
	   curl_close($curl_handle);

		 redirect(site_url("admin/kelas_impor"));
   }

}
