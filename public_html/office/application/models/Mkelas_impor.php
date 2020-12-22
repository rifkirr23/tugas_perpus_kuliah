<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mkelas_impor extends CI_Model {

	public function __construct(){
		parent::__construct();
    $this->load->model('Minvoice_lainnya');
	}
	//Proses Get Data kelas_impor
	function get_kelas_impor() {
        $this->datatables->select('id_daftar_kelas_impor,tgl_daftar,nama_lengkap,customer_email,customer_phone,paket_member,harga_member,s_konfirmasi');
        $this->datatables->from('daftar_kelas_impor');
        $this->datatables->where('daftar_kelas_impor.paket_member !=', null);
				$this->datatables->add_column('view', '$1','view_kelas_impor(s_konfirmasi)');
        return $this->datatables->generate();
  }

	function encrypt_decrypt($action,$string) {
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

	function random_password(){
		$chars = array(
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
        'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
        'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '?', '!', '@', '#',
        '$', '%', '^', '&', '*', '(', ')', '[', ']', '{', '}', '|', ';', '/', '=', '+'
    );
    shuffle($chars);
    $num_chars = count($chars) - 70;
    $token = '';
    for ($i = 0; $i < $num_chars; $i++){ // <-- $num_chars instead of $len
        $token .= $chars[mt_rand(0, $num_chars)];
    }
    return $token;
	}

  	function proses_konfirmasi($data)
  {
    // get data customer kelas impor
      $idkelas = $this->input->post('id_daftar_kelas_impor');
      $get_kelas_impor = $this->db->where('id_daftar_kelas_impor',$idkelas)->get('daftar_kelas_impor')->row();
			if ($get_kelas_impor->s_konfirmasi == 1) {
				die("tidak bisa konfirmasi");
			}
    // Update Status Konfirmasi
      $updatestatuskonfirmasi = $this->db->set('s_konfirmasi',1)
                                         ->where('id_daftar_kelas_impor',$idkelas)
                                         ->update('daftar_kelas_impor');
      // Input Marking
      $customer['id_referal'] = 0;
      $customer['nama'] = $get_kelas_impor->nama_lengkap;
      $customer['id_cgrup'] = 0;
      $customer['email'] = $get_kelas_impor->customer_email;
      $customer['telepon'] = $get_kelas_impor->customer_phone;
      $customer['whatsapp'] = $get_kelas_impor->customer_phone;
      $customer['alamat'] = " - ";
      $customer['nama_penerima'] = $get_kelas_impor->nama_lengkap;
      $customer['kode'] = "-";
      $customer['tanggal_daftar']  =date('Y-m-d');
      $customer['harga_udara'] = 0;
      $customer['komisi_titip_trf'] = 0;
      $customer['komisi_barang'] = 0;
      $customer['id_pendaftar'] = 0;
			$customer['status_ganti_marking'] = 1;
      $this->db->insert('customer', $customer);
      $idcust = $this->db->insert_id();
      // Set Marking
      $markcust     = $idcust;
      $markingudara = "WC-".$markcust."/AIR";
      $marking_baru = "123/WC-".$markcust;
      // update marking
      $updatemarking = $this->db->set('kode',$marking_baru)->where('id_cust',$idcust)->update('customer');
			// Set Login
			$password_login = $this->random_password();
			$tiket_reset_password = $this->encrypt_decrypt("encrypt",$password_login);
			$login['id_cust'] = $idcust;
      $login['username'] = $marking_baru;
      $login['password'] = md5($password_login);
			$login['tiket_reset_pass'] = $tiket_reset_password;
			$login['count'] = 0;
      $this->db->insert('pengguna_customer', $login);
    // Transaksi bank
      $trb['id_jenis_transaksi_bank'] = 41;
      $trb['id_bank'] = 1;
      $trb['tipe_transaksi_bank'] = "masuk";
      $trb['nominal_transaksi_bank'] = $get_kelas_impor->harga_member;
      $trb['keterangan_transaksi_bank'] = "Pembayaran Kelas Impor ".$marking_baru;
      $trb['tanggal_transaksi_bank'] = date('Y-m-d');
      $trb['sisa_saldo_bank'] = "99999999999";
      $this->db->insert('transaksi_bank', $trb);
      // Buat invoice Lainnya KAtegori Kelas Impor
      $id_kategori_il = 5;
      $id_invoice = 0;
      if($get_kelas_impor->paket_member == 1){
        $keterangan = "Kelas Impor 3 Tahun";
      }else if($get_kelas_impor->paket_member == 2){
        $keterangan = "Kelas Impor 1 Tahun";
      }
      $this->Minvoice_lainnya->save_bypengiriman($idcust,$get_kelas_impor->harga_member,$id_kategori_il,$id_invoice,$keterangan);

			// Whatsapp Info Login to Customer
			$pesan_login = "*[Wilopo Cargo] Informasi Login Member Area*\n\nYth. Bpk/Ibu $get_kelas_impor->nama_lengkap".
										 "\n\nTerimakasih Anda telah terdaftar sebagai member *Expert Importir* Wilopo Cargo! Silahkan akses akun Anda, dan ganti User ID / Kode Marking Anda di dalam dashboard agar mendapatkan akses ke dalam materi pembelajaran!".
										 "\n\nInformasi Login \nUsername :$marking_baru \nPassword:$password_login \nTiket Reset Password :$tiket_reset_password ".
										 "\nLink Login : https://wilopocargo.com/customer_wilopocargo \n\nTerimakasih :)"."\n\n*Wilopo Cargo* _(do not reply)_";
			sendwhatsapp($pesan_login,$whatsapp);

			$the_message="<html>
													 <body>
																	 <h3>Yth. Bpk/Ibu ".$get_kelas_impor->nama_lengkap.",</h3>
																	 <p>Terimakasih Anda telah terdaftar sebagai member *Expert Importir* Wilopo Cargo! Silahkan akses akun Anda, dan ganti User ID / Kode Marking Anda di dalam dashboard agar mendapatkan akses ke dalam materi pembelajaran!</p>
																	 <p><br /><b>Informasi Login</b>
																	 		<br />Username :".$marking_baru."
																			<br />Password :".$password_login."
																			<br />Tiket Reset Password :".$tiket_reset_password."
																			<br />Link Login :".'https://wilopocargo.com/customer_wilopocargo'."
																	 </p>
																	 <p>".nama_perusahaan2()."</p>

													 </body>
										 </html>";

			$config = Array(
				'protocol' => 'smtp',
				'smtp_host' => 'mail.wilopocargo.com',
				'smtp_port' => 587,
				'smtp_user' => user_email(), //isi dengan gmailmu!
				'smtp_pass' => pass_email(), //isi dengan password gmailmu!
				'mailtype' => 'html',
				'charset' => 'iso-8859-1',
				'wordwrap' => TRUE
			);
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
	    $this->email->from(user_email());
	    $this->email->to($customer['email']); //email tujuan. Isikan dengan emailmu!
	    $this->email->subject('[Wilopo Cargo] Informasi Login Member Area');
	    $this->email->message($the_message);

	    if($this->email->send())
	    {

	    }
	    else
	    {
	      //show_error($this->email->print_debugger());
	    }

      $this->session->set_flashdata('msg','success');
      redirect(site_url('admin/kelas_impor'));

  }

  function update($data)
  {                       //data Pelanggan
      $kelas_impor['nama_pengguna'] = $this->input->post('nama_pengguna');
      $kelas_impor['username'] = $this->input->post('username');

    if($this->input->post('password')==""){

    }else{
      $kelas_impor['password'] = md5($this->input->post('password'));
    }

      $kelas_impor['level'] = $this->input->post('level');

      	$this->db->where('id_pengguna',$this->input->post('id_pengguna'));
        $this->db->update('pengguna', $kelas_impor);

        $this->session->set_flashdata('msg','updated');
        redirect(site_url('admin/kelas_impor'));


  }

  function deleted($data)
  {                       //data Pelanggan
      $kelas_impor['aktif'] = '1';

      	$this->db->where('id_cust',$this->input->post('id_cust'));
        $this->db->update('kelas_impor', $kelas_impor);

        redirect(site_url('admin/kelas_impor'));


  }
}
