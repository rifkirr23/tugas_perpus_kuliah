<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Public_c extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		// cek_session(); //cek session User Login
		// $this->load->model('Mpublic'); //Load Model Customer
	}

	//Function Halaman Awal Menu Customer
	 function upload_pl(){
		// die("maintenance");
		$data['id_fpr'] = $this->encrypt_decrypt('decrypt',$this->uri->segment(3));
		$data['data_fpr'] = $this->db->where('id_fp_resi',$data['id_fpr'])->get('file_packing_resi')->row();
		$cekdata = $this->db->where('id_fp_resi',$data['id_fpr'])->get('file_packing_resi')->num_rows();
		if($cekdata == 0){
			die("tidak ada resi, harap gunakan link terbaru yang kami kirim");
		}
		$this->load->view('public/upload_pl',$data);
	}

  function save_upload_pl(){
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
					$bb_rmb['id_fp_resi'] = $this->input->post('id_fp_resi');
		      $bb_rmb['nomor_resi'] = $this->input->post('nomor_resi');
					$bb_rmb['encrypt_resi'] = $this->input->post('encrypt_resi');
					$bb_rmb['kode_marking'] = $this->input->post('kode_marking');
		      $bb_rmb['file_pl'] = $file_pl;
					$bb_rmb['tanggal_upload'] = date('Y-m-d H:i:s');
		      $this->db->insert('file_packing', $bb_rmb);

					$updfile['id_fp_resi'] = $this->input->post('id_fp_resi');
					$updfile['status_fpr'] = 1;
					$this->db->where('id_fp_resi',$this->input->post('id_fp_resi'))->update('file_packing',$updfile);

	  }
    $this->session->set_flashdata('msg','success');
    redirect($_SERVER['HTTP_REFERER']);
  }

	public function encrypt_decrypt($action, $string) {
	  $output = false;
	  $encrypt_method = "AES-256-CBC";
	  $secret_key = 'wilopo123';
	  $secret_iv = 'wilopo123';
	  // hash
	  $key = hash('sha256', $secret_key);

	  // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	  $iv = substr(hash('sha256', $secret_iv), 0, 16);
	  if ( $action == 'encrypt' ) {
	    $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
	    $output = base64_encode($output);
	  } else if( $action == 'decrypt' ) {
	    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	  }
	  return $output;
	}

}
