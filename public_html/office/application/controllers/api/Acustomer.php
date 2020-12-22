<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Acustomer extends CI_Controller {

	public function __construct(){
		parent::__construct();

		  $this->load->model('Mcustomer');
      $this->load->model('Mapicustomer');
			$this->load->model('Mapiinvoice');
			$this->load->model('Mkomisi_referal');
			$this->load->model('Mlaporan');
			$this->load->model('Mbarang');
	}

  function tes(){
		echo "ok";

  }

	function cekchatsales(){
		// sendwhatsapp('cekchatsales','083815423599');
		$d = 		$this->db->query('SELECT status_sales, COUNT(*) as hitungan
						FROM pengguna
						where level = "saleso" and status_sales > 0
						GROUP BY status_sales
						HAVING ( COUNT(status_sales) > 1 )')->num_rows();
		if($d > 0){
			$getsaleso = $this->db->select('id_pengguna')->from('pengguna')
														->where('status',1)
														->where('level','saleso')
														->where('status_sales >',0)
														->order_by('status_sales','asc')
														->get()->result();
			$antrian = 1;
			foreach($getsaleso as $gs){
				$updgs['status_sales'] = $antrian;
				$this->db->where('id_pengguna',$gs->id_pengguna)->update('pengguna',$updgs);
				$antrian++;
			}
		}
		dd($getsaleso);
	}

	function cek_input_customer(){
		$kode = $this->input->post('kode');
		$cek_customer = $this->db->where('kode',$kode)->get('customer')->row();
		if($cek_customer->jalur == 2){
			sendwhatsapp("api harga lama aktif","083815423599");
			$curl_handle=curl_init();
			curl_setopt($curl_handle,CURLOPT_URL,'https://office.rtsekspedisi.com/api/a_customer/update_harga_lama');
			curl_setopt($curl_handle, CURLOPT_POST, 1);
			curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "kode=$kode");
			$res = curl_exec($curl_handle);
			curl_close($curl_handle);
		}
	}

  function save(){
   $h=date('H')+5;  $i=date('i');   $s=date('s');
   $date= date('Y-m-d');
   $data_kode= $this->Mcustomer->get_id($this->input->post('kode'));

      if($data_kode->num_rows()>0){
        foreach($data_kode->result() as $c ){
          $kode=$c->kode;
        }
      }else{
        $kode="";
      }
      if ($kode == $this->input->post('kode')){

      }else{
         $data = $this->Mapicustomer->save($this->input->post());
     }
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

   function daftarclass(){
       $nama=$this->input->post('nama');
       $email=$this->input->post('email');
       $no_telepon=$this->input->post('no_telepon');
       $tgl=date('Y-m-d');
       $tgltoken=date('YmdHis');

       $action='encrypt';
       $kodeticket=$email.'/'.$tgltoken;
	     $token=$this->encrypt_decrypt($action, $kodeticket);

       $daftar['tgl_daftar'] = $tgl;
       $daftar['nama_lengkap'] = $nama;
	     $daftar['customer_email'] = $email;
       $daftar['customer_phone'] = $no_telepon;
       $daftar['token'] = $token;
       $daftar['s_token'] = 0;
       $daftar['s_konfirmasi'] = 0;
       $this->db->insert('daftar_kelas_impor', $daftar);
       $idawal = $this->db->insert_id();
       $last_id=$this->encrypt_decrypt($action, $idawal);


       $config = Array(
				'protocol' => 'smtp',
				'smtp_host' => 'mail.wilopocargo.com',
				'smtp_port' => 25,
				'smtp_user' => user_email(), //isi dengan gmailmu!
				'smtp_pass' => pass_email(),
				'mailtype' => 'html',
				'charset' => 'iso-8859-1',
				'wordwrap' => TRUE
			);

			$this->load->library('email', $config);
			$the_message='<body style="background-color: #fbfbfb; background-image: url(https://wilopocargo.com/wp-content/uploads/2020/03/abstrak-bg.svg); background-repeat: repeat; background-position: center center; background-size: contain; font-family: Arial, Helvetica, sans-serif; margin: 0;">

    <div style="max-width: 500px; margin: auto; padding: 15px;">
        <div style="text-align: center; padding: 10px; height: 50px;">
            <img style="height: 100%; width: 100%; object-fit: contain; object-position: center;" src="https://wilopocargo.com/wp-content/uploads/2019/12/cropped-logo-wc-01-1-e1580449499503.png" alt="">
        </div>
        <div style="padding: 25px 15px; background-color: #fff; border-radius: 2px; border: 1px solid #f0f0f0;">
            <div style="margin-bottom: 15px; text-align: center;">
                <H1 style="font-size: 20px; color: #333; font-weight: 700; margin-bottom: 10px; text-transform: uppercase;">Selamat Datang di Kelas!</H1>
            </div>
            <div style="text-align: center;">
                <p style="font-size: 15px; line-height: 1.8; color: #333; font-weight: 300;">Terimakasih telah mendaftar 2 hari kelas online eksklusif <strong>"Cara Mencari Supplier di Alibaba"</strong>
                <br/><br>Saya ingin mengucapkan selamat kepada Anda karena telah mendaftar di kelas ini. Karena kita tahu hanya
                    1 dari 10 orang yang mau belajar, dan Anda adalah 1 orang tersebut!

                    <br/><br>Pertama-tama Anda harus klik tombol di bawah ini untuk join grup Telegram kelas ini, materi dan langkah
                        selanjutnya akan kami informasikan di dalam grup. Selamat Belajar!</p>
                <div style="padding:15px 10px; display: block; text-align: center;">
                    <a href="https://wilopocargo.com/silahkan-lakukan-pembayaran?id='.$last_id.'" target="blank" style="display: inline-block; padding: 15px 35px; text-decoration: none; background: #F43B3B; font-size: 15px; color: #fff; border-radius: 4px;">PETUNJUK SELANJUTNYA</a>
                    <!--<a href="https://t.me/joinchat/PtZIFhhHWUYFxQEN4Cn6zg" target="blank" style="display: inline-block; padding: 15px 35px; text-decoration: none; background: #F43B3B; font-size: 15px; color: #fff; border-radius: 4px;">JOIN GRUP TELEGRAM</a>-->
                </div>
            </div>
        </div>
        <div style="text-align: center; padding: 15px;">
            <ul style="list-style: none; display: flex; align-items: center;justify-content: center; margin: 5px auto; padding-inline-start: 0; opacity: .5;">
                <li style="display: inline; padding: 3px 5px; font-size: 12px; color: #666;">
                    <a style="text-decoration: none; color: #666;" href="https://wilopocargo.com/">Homepage</a></li>
                <li style="display: inline; padding: 3px 5px; font-size: 12px; color: #666;">
                    <a style="text-decoration: none; color: #666;" href="https://wilopocargo.com/contact-us/">Hubungi Kami</a></li>
            </ul>
            <p style="font-size: 12px; opacity: .5; color: #666; line-height: 1.2; margin: 0;">Copyright ©2020 <a href="https://wilopocargo.com">Wilopo Cargo</a> All right reserved.</p>
        </div>
    </div>
</body>';

			$this->email->set_newline("\r\n");
			$this->email->from(user_email());
			$this->email->to($email); //email tujuan. Isikan dengan emailmu! $emailaktif
			$this->email->subject('[Wilopo Cargo] Registrasi Kelas Online');
			$this->email->message($the_message);
			$this->email->send();

			redirect('https://wilopocargo.com/silahkan-lakukan-pembayaran?id='.$last_id);

   }

	 function cron_status_customer(){
		 die();
	 }

	 function cron_saldo_harian(){
		 $get_bank = $this->db->get('master_bank')->result();
		 foreach($get_bank as $gb){
			 $cek_tanggal = $this->db->where('tanggal_saldo',date("Y-m-d"))->where('id_bank',$gb->id_bank)->get('saldo_harian')->num_rows();
			 if($cek_tanggal == 0){
				 $transaksi_bank_masuk  = $this->db->select('sum(nominal_transaksi_bank) as jumlah')->where('id_bank',$gb->id_bank)->where('tipe_transaksi_bank','masuk')->get('transaksi_bank')->row();
				 $transaksi_bank_keluar = $this->db->select('sum(nominal_transaksi_bank) as jumlah')->where('id_bank',$gb->id_bank)->where('tipe_transaksi_bank','keluar')->get('transaksi_bank')->row();
				 $saldo_harian['id_bank']    = $gb->id_bank;
				 $saldo_harian['jumlah']     = $transaksi_bank_masuk->jumlah - $transaksi_bank_keluar->jumlah;
				 $saldo_harian['Keterangan'] = "";
				 $saldo_harian['tanggal_saldo'] = date('Y-m-d');
				 $this->db->insert('saldo_harian',$saldo_harian);
			 }
		 }
	 }

	 function cron_set_pembulatan(){
		 	$bulan_ini = bulan_angka(date('m'));
			if($bulan_ini == 1){
				$setting_bulan = 9;
			}else if($bulan_ini == 2){
				$setting_bulan = 10;
			}else if($bulan_ini == 3){
				$setting_bulan = 11;
			}else if($bulan_ini == 4){
				$setting_bulan = 12;
			}else{
				$setting_bulan = $bulan_ini - 4;
			}
			$cek_pembulatan = $this->db->where('bulan_pembulatan',$setting_bulan)->get('pembulatan')->num_rows();
			if($cek_pembulatan > 0){
				sendwhatsapp("set 0 pembulatan",'083815423599');
				$update_pembulatan['jumlah_cbm'] = 0;
				$this->db->where('bulan_pembulatan',$setting_bulan)->update('pembulatan',$update_pembulatan);
			}
	 }

	 function cron_asuransi(){
		 sendwhatsapp("cron asuransi",'083815423599');
		 $sql = "DELETE t1 FROM invoice_asuransi t1
						INNER JOIN invoice_asuransi t2
						WHERE t1.id_invoice_asuransi < t2.id_invoice_asuransi AND t1.id_resi = t2.id_resi";
		 $this->db->query($sql);
	 }

	 function test_wa(){
		 sendwhatsapp("testskuy",'083815423599');
	 }

	 function cron_broadcast(){
		 // die();
		 // sendwhatsapp("cron bc","083815423599");
		 $get_customer = $this->db->where('status_broadcast',0)->order_by('id_cust','asc')->limit(50)->get('customer')->result();
		 $getpesan = $this->db->order_by('id_broadcast','desc')->limit(1)->get('broadcast')->row();
		 $pesannya = $getpesan->pesan."\n\n*Wilopo Cargo* _(do not reply)_";
		 // sendwhatsapp($pesannya,"083815423599");
		 foreach ($get_customer as $cust) {
			// sendwhatsapp("cron bc","083815423599");
		 	sendwhatsapp("*Dear ".$cust->kode."*\n\n".$pesannya,$cust->whatsapp);
		 }
		 $upd_cust['status_broadcast'] = 1;
		 $this->db->where('status_broadcast',0)->order_by('id_cust','asc')->limit(50)->update('customer',$upd_cust);
	 }

	 function cron_wa_pembulatan(){
	  die();
		sendwhatsapp("Cron Wa Pembulatan Ke Customer","083815423599");
		$bulan = date('m');
		$nama_bulan = bindo($bulan);
 		$tahun = date('Y');
 		$data_customer = $this->db->query('SELECT cbm , kode , nama , email , alamat ,bulan_barang,tahun_barang,whatsapp
 															FROM (SELECT sum(volume * ctns) as cbm ,kode,nama,email,alamat,month(resi.tanggal) as bulan_barang,Year(resi.tanggal) as tahun_barang,whatsapp FROM `giw`
 															left join customer on customer.id_cust = giw.customer_id
 															left join resi on resi.id_resi = giw.resi_id
 															group by customer_id) a
 															where cbm < 0.5 and bulan_barang="'.$bulan.'" and tahun_barang="'.$tahun.'" ')->result();
		foreach ($data_customer as $customer) {
			$cbm_cust = round($customer->cbm,3);
			$pesan = "*Dear $customer->kode* \n\nBarang Anda Pada Bulan $nama_bulan Kurang dari $cbm_cust Cbm , Jika kurang dari 0.5 maka Invoice anda akan kena pembulatan 0.5 perbulan \n\n *Wilopo Cargo* _(do not reply)_";
			sendwhatsapp($pesan,$customer->whatsapp);
		}
	 }

	 function cron_cancel_titip_trf(){
		 // sendwhatsapp("cron cancel Titip TRf","083815423599");
		 $tanggalSekarang = date("Y-m-d h:i:s");
		 $newTanggalSekarang=strtotime($tanggalSekarang);
		 $jumlahHari=1;
		 $NewjumlahHari=86400*$jumlahHari;
		 $hasilJumlah = $newTanggalSekarang - $NewjumlahHari;
		 $tampilHasil=date("Y-m-d h:i:s",$hasilJumlah);

		$get_transaksi =  $this->db->where('tanggal_transaksi <=',$tampilHasil)->where('status',1)->get('transaksi')->result();
 		foreach($get_transaksi as $gettrs){
 			$update_pembelian['status_pembelian'] = 3;
 			$this->db->where('id_transaksi',$gettrs->id_transaksi);
 			$this->db->update('pembelian',$update_pembelian);

	 		$update_transaksi['status'] = 5;
	 		$this->db->where('id_invoice',$gettrs->id_invoice);
	 		$this->db->update('transaksi',$update_transaksi);
	 		$update_invoice['status_invoice'] = 2;
	 		$this->db->where('id_invoice',$gettrs->id_invoice);
	 		$this->db->update('invoice',$update_invoice);
		}

	 }

	 function request_pl_harian(){
		 die();
		 sendwhatsapp("Api Request Pl Harian","083815423599");
		 $resi_array 			 = $this->input->post('resi_array');
     $kode_array			 = $this->input->post('kode_array');
     $supplier_array   = $this->input->post('supplier_array');
		 $tel_array   		 = $this->input->post('tel_array');
		 $ctns_array   		 = $this->input->post('ctns_array');
     $jumlah_array 		 = count($resi_array);
		 for ($i=0; $i<$jumlah_array; $i++) {
		   $encrypt_resi[$i]  = md5($resi_array[$i]);
			 $nomor_resi  = $resi_array[$i];
		   $real_code   = $this->encrypt_decrypt('encrypt',$kode_array[$i]);
		   $encrypt_resi  = md5($resi_array[$i]);
		   $data_customer = $this->db->select('customer.kode,customer.whatsapp,customer.email,customer.id_crm')->from('customer')
				                         ->where('customer.kode',$kode_array[$i])
				                         ->get()->row();

				$cek_fpr = $this->db->where('nomor_resi',$nomor_resi)->get('file_packing_resi')->num_rows();
		    if($cek_fpr == 0){
		      $ins_file['nomor_resi'] = $nomor_resi ;
		      $ins_file['kode_marking'] = $kode_array[$i] ;
					$ins_file['tanggal_fpr'] = date('Y-m-d') ;
		      $this->db->insert('file_packing_resi',$ins_file);
		      $last_id_fpr = $this->db->insert_id();
		      $enc_id_fpr  = $this->encrypt_decrypt('encrypt',$last_id_fpr);
		    }else{
		      $get_fpr = $this->db->where('nomor_resi',$nomor_resi)->get('file_packing_resi')->row();
		      $enc_id_fpr  = $this->encrypt_decrypt('encrypt',$get_fpr->id_fp_resi);
		    }

		   // whatsapp Pl and inv
		   $pesan ="*".$data_customer->kode."*, \n".$resi_array[$i]."\n".$supplier_array[$i]." (".$tel_array[$i].")\n".$ctns_array[$i].
		           " Ctns \nTidak ada packing list dan invoice dari supplier anda".
		           ",Silahkan upload invoice dan packing list anda di customer.wilopocargo.com/public_c/upload_pl/$enc_id_fpr".
		           "\n\n*Wilopo Cargo* _(do not reply)_";
		   sendwhatsapp($pesan,$data_customer->whatsapp);
		   sendwhatsapp($pesan,"081310961108");
		   sendwhatsapp($pesan,"6281299053976");
		   if($data_customer->id_crm > 0){
		     $get_crm = $this->db->where('id_pengguna',$data_customer->id_crm)->get('pengguna')->row();
		     sendwhatsapp($pesan,$get_crm->whatsapp);
		   }else{
		     sendwhatsapp($pesan,"6282122486180");
		   }

		 }
	 }

	 function create_akun_customer(){
		 // $password = $this->random_password(); print_r($password); die();
		 $data_customer = $this->db->select('customer.kode,customer.id_cust,customer.whatsapp')
		 													 ->from('customer')
															 ->join('pengguna_customer','customer.id_cust=pengguna_customer.id_cust','left')
															 ->where('pengguna_customer.id_pengguna is null' , Null , False)
															 ->order_by('customer.id_cust','asc')
															 ->limit(100)
															 ->get()->num_rows();
		 print_r($data_customer);die();
		 foreach($data_customer as $datacust){
			$password = $this->random_password();
			$input_pengguna['id_cust'] = $datacust->id_cust;
 			$input_pengguna['username'] = $datacust->kode;
 			$input_pengguna['password'] = md5($password);
 			$input_pengguna['last_login'] = date("Y-m-d H:i:s");
 			$input_pengguna['count'] = 0;
 			$input_pengguna['level'] = 1;
 			$this->db->insert('pengguna_customer',$input_pengguna);
 			$pesan = "*Informasi Login User Dashboard*\n\nUsername : $datacust->kode\nPassword: $password \nSilahkan Login di customer.wilopocargo.com\n\nTerimakasih :)"."\n\n*Wilopo Cargo* _(do not reply)_";
 			sendwhatsapp($pesan,$datacust->whatsapp);
		 }

	 }

	 //Function Test Api Wablas aja
 	function random_password(){
 		$chars = array(
			'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
			'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
			'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
			'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
			'0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '?', '!', '@'
     );

     shuffle($chars);

     $num_chars = count($chars) - 50;
     $token = '';

     for ($i = 0; $i < $num_chars; $i++){ // <-- $num_chars instead of $len
         $token .= $chars[mt_rand(0, $num_chars)];
     }

     return $token;
 	}

  function cron_laporan(){
		sendwhatsapp("Cron Laporan","083815423599");
		// die("oke");
		$getresi = $this->db->query('SELECT giw.*,resi.*,customer.* from giw
																left join resi on resi.id_resi = giw.resi_id
																left join customer on giw.customer_id = customer.id_cust
																where counter < ctns
																group by resi_id')->result();
		$totallaba = 0;
		$total_asr = 0;
		$total_komisi_semua = 0;
		// print_r($getresi);die();
		foreach($getresi as $rr){
			// row Total Jual
			$idresi = 0;
			$idresi = $rr->id_resi;
			$total  = 0;
			$jumlah = 0;
			$resijual = $this->db->query('SELECT status_berat,jenis_barang_id,jumlah,kurs,volume,berat,qty,nilai,harga_jual
																			FROM (SELECT giw.status_berat,giw.jenis_barang_id,sum(giw.ctns - giw.counter) as jumlah,giw.kurs,giw.volume,giw.berat,giw.qty,giw.nilai,giw.harga_jual from giw
																			left join resi on resi.id_resi = giw.resi_id
																			left join customer on giw.customer_id = customer.id_cust
																	  	where counter < ctns and giw.resi_id = "'.$idresi.'") truegiw
																	')->result();
																	// print_r($this->db->last_query());die();

			foreach ($resijual as $ils ) {
				include APPPATH. 'helpers/harga.php';
				$total_jual = $total ;
			}
			$total  = 0;
			$jumlah = 0;
			// row Total Beli
			$beliresi = $this->db->query('SELECT status_berat,jenis_barang_id,jumlah,kurs,volume,berat,qty,nilai,harga_jual
																			FROM (SELECT giw.status_berat,giw.jenis_barang_id,sum(giw.ctns - giw.counter) as jumlah,giw.kurs,giw.volume,giw.berat,giw.qty,giw.nilai,giw.harga as harga_jual from giw
																			left join resi on resi.id_resi = giw.resi_id
																			left join customer on giw.customer_id = customer.id_cust
																	  	where counter < ctns and giw.resi_id = "'.$idresi.'") truegiw
																	')->result();
			foreach ($beliresi as $ils ) {
				include APPPATH. 'helpers/harga.php';
				$total_beli = $total ;
			}

			$asr_resi = $this->db->where('id_resi',$rr->id_resi)->get('invoice_asuransi')->row();

			$data_giw = $this->db->select('giw.*')
														->from('giw')
														->where('giw.resi_id',$rr->id_resi)
														->get()->result();
			$kurs_global_filter = $this->db->where('id_kurs',1)->get('kurs')->row();
			$komisi_global_barang = $kurs_global_filter->komisi_barang;
			$id_referal = $rr->id_referal;
			$komisi_ref = 0;

			if($id_referal > 0){
				$get_referal = $this->db->where('id_cust',$id_referal)->get('customer')->row();
				if($rr->nama == "Nurul Magfirah Putram"){
					$komisi_ref = 0;
					$ket_komisi_nurul   = "";
					foreach($data_giw as $ils2){
						$jumlahctns_nurul      = $ils2->ctns;
						$volume_nurul          = $jumlahctns_nurul * $ils2->volume;
						$jenis_barang_id_nurul = $ils2->jenis_barang_id;
						if($jenis_barang_id_nurul == 22){
							$komisi_nurul     = $volume_nurul * 500000;
						}else{
							$komisi_nurul     = $volume_nurul * 250000;
						}
						$komisi_ref += $komisi_nurul;
					}
				}else{
					if($get_referal->komisi_barang == 0){
						$komisi_ref  = $komisi_global_barang * $cbmresi;
					}else{
						$komisi_ref = $get_referal->komisi_barang * $cbmresi;
					}
				}
			}

			$totallaba += (($total_jual - $total_beli) - $asr_resi->jumlah_asuransi) - $komisi_ref;
			$total_asr += $asr_resi->jumlah_asuransi;
			$total_komisi_semua += $komisi_ref;
		}
		$master['total_laba'] = $totallaba;
		$master['total_asuransi'] = $total_asr;
		$master['total_komisi'] = $total_komisi_semua;
	  $this->db->where('id_master_laporan',1)->update('master_laporan',$master);
	}

	function lempar_cs(){
		$get_customernya = $this->db->where('s_aktivasi',"Sudah Aktivasi")->where('status_rts',"2")->limit(30)->get('customer')->num_rows();
		// print_r($get_customernya);die();
		foreach($get_customernya as $get_customer){
			$master['status_rts'] = 3;
		  $this->db->where('id_cust',$get_customer->id_cust)->update('customer',$master);
			$marking = $get_customer->kode;
			$nama = $get_customer->nama;
			$email= "order@wilopocargo.com";
			$whatsapp= "6281299053976";
			$alamat= $get_customer->alamat;
			if($get_customer->jalur == 2){
				$jalur = 2;
			}else{
				$jalur = 1;
			}
			$curl_handle=curl_init();
			curl_setopt($curl_handle,CURLOPT_URL,'https://office.rtsekspedisi.com/api/a_customer/save_api');
			curl_setopt($curl_handle, CURLOPT_POST, 1);
			curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "kode=$marking&nama=$nama&email=$email&whatsapp=$whatsapp&alamat=$alamat&jalur=$jalur");
			$res = curl_exec($curl_handle);
			curl_close($curl_handle);
		}
	}

	function sesuaikan_giw(){
		$nomor_giw = $this->input->post('giw_array');
		$tgl_loading= $this->input->post('tgl_loading');
		$tgl_kirim   = $this->input->post('tgl_kirim');
		$tgl_monitoring   = $this->input->post('tgl_monitoring');
		$tgl_tiba   = $this->input->post('tgl_tiba');
		$cont_id   = $this->input->post('cont_id');
		$status   = $this->input->post('status');

		$tgl_closing= $this->input->post('tgl_closing');
		$tgl_eta_pk   = $this->input->post('tgl_eta_pk');
		$tgl_antri_kapal   = $this->input->post('tgl_antri_kapal');
		$tgl_atur_kapal   = $this->input->post('tgl_atur_kapal');
		$tgl_est_dumai   = $this->input->post('tgl_est_dumai');
		$tgl_pib   = $this->input->post('tgl_pib');
		$tgl_notul   = $this->input->post('tgl_notul');

		$jumlah_array = count($nomor_giw);
		$pesandev   = "Scan Barcode ".$jumlah_array;
		// sendwhatsapp($pesandev,"083815423599");
		$nomor_barcode = "";
		for ($i=0; $i<$jumlah_array; $i++) {
// 			$get_barcode = $this->db->select('giw.*,customer.kode')->from('giw')->join('customer','giw.customer_id=customer.id_cust','left')->where('giw.nomor',$nomor_giw[$i])->get()->row();
			$statuswc = $this->db->select('status_giw.id')->from('status_giw')->where('status_giw.id_rts',$status[$i])->get()->row();
			$giw['tanggal_loading']= $tgl_loading[$i];
			$giw['tanggal_berangkat']= $tgl_kirim[$i];
			$giw['tanggal_monitoring']= $tgl_monitoring[$i];
			$giw['tanggal_tiba']= $tgl_tiba[$i];
			$giw['tgl_closing']= $tgl_closing[$i];

// 			if($status[$i] == 4){
// 				$giw['status']= 7;
// 			}else{
				$giw['status']= $statuswc->id;
// 			}
			$giw['container_id']= $cont_id[$i];
			$this->db->where('nomor', $nomor_giw[$i]);
			$this->db->update('giw',$giw);




			$container['tgl_closing']= $tgl_closing[$i];
			$container['tgl_eta']= $tgl_eta_pk[$i];
			$container['tgl_antri_kapal']= $tgl_antri_kapal[$i];
			$container['tgl_atur_kapal']= $tgl_atur_kapal[$i];
			$container['tgl_est_dumai']= $tgl_est_dumai[$i];
			$container['tgl_pib']= $tgl_pib[$i];
			$container['tgl_notul']= $tgl_notul[$i];
// 			if($status[$i] == 4){
// 				$container['status']= 7;
// 			}else{
				$container['status']= $statuswc->id;
// 			}
			$this->db->where('id_rts', $cont_id[$i]);
			$this->db->update('container',$container);
// 			$nomor_barcode .= "\n".$nomor_giw[$i];
		}
		// sendwhatsapp("sesuaikan","083815423599");
	}

	function cron_add_resi(){
		die();
		// add resi yg gaada di container
		$getresinya = $this->db->select('nomor_resi')
													 ->from('sesuaikan_giw')
													 ->where('status_sesuaikan',0)
													 ->group_by('nomor_resi')
													 ->limit(3)
													 ->get()->result();dd($getresinya);

		foreach ($getresinya as $gr) {
			sendwhatsapp("sesuaikan".$gr->nomor_resi,"083815423599");
			$cek_resi = $this->db->where('nomor',$gr->nomor_resi)->get('resi')->num_rows();
			if($cek_resi > 0 ){
				$get_resiwc = $this->db->select('resi.id_resi,customer.id_cust,customer.id_cgrup')
															 ->from('resi')
															 ->join('customer', 'resi.cust_id=customer.id_cust', 'left')
															 ->where('nomor',$gr->nomor_resi)
															 ->get()->row();
				// Add Giw
				$db2 = $this->load->database('db2', TRUE);
				$datagiwresi = $db2->select('giw.*,container.status as contstatus')
														->from('giw')
														->join('resi', 'resi.id=giw.resi_id', 'left')
														->join('container', 'giw.container_id=container.id','left')
														->where('resi.nomor',$gr->nomor_resi)
														->get()->result();

				$updsesuaikan['status_sesuaikan'] = 1;
				$saveupd = $this->db->where('nomor_resi',$gr->nomor_resi)->update('sesuaikan_giw',$updsesuaikan);
				foreach($datagiwresi as $dgr){
					$cekbarcode = $this->db->where('nomor',$dgr->nomor)->get('giw')->num_rows();
					if($cekbarcode > 0){
	          continue;
	        }
					if($dgr->contstatus == 3 || $dgr->contstatus == 5 ){
						$statusgiw = 4;
					}else if($dgr->contstatus == 4){
						$statusgiw = 7;
					}else if($dgr->contstatus == 2 || ($dgr->contstatus >= 6 && $dgr->contstatus <= 12) ){
						$statusgiw = 3;
					}else{
						$statusgiw = 2;
					}
					if($statusgiw == 4){
						$hargabeli = $dgr->harga;
					}else{
						$hargabeli = $dgr->harga-500000;
					}
					$cekhargacustomer = $this->Mbarang->data_hbc($id_cust,$id_jenis_barang)->num_rows();
			    $cekhargagrup     = $this->Mbarang->data_hbcg($id_cgrup,$id_jenis_barang)->num_rows();
			    if($id_cgrup > 0 && $cekhargagrup > 0){
			      $dhbc = $this->Mbarang->data_hbcg($id_cgrup,$id_jenis_barang)->row();
			      $harga_jual   = $dhbc->harga;
			    }else if($cekhargacustomer > 0){
						$dhbc = $this->Mbarang->data_hbc($id_cust,$id_jenis_barang)->row();
						$harga_jual   = $dhbc->harga;
					}else{
						$dhb= $this->Mbarang->data_hb($id_jenis_barang)->row();
						$harga_jual = $dhb->harga;
					}
					$insert_brcd['barang']= $dgr->barang;
          $insert_brcd['nomor']=  $dgr->nomor;
          $insert_brcd['customer_id']= $get_resiwc->id_cust;
          $insert_brcd['jenis_barang_id']=  $dgr->jenis_barang_id;
          $insert_brcd['container_id']=  $dgr->container_id;
          $insert_brcd['ctns']= $dgr->ctns;
          $insert_brcd['qty']=  $dgr->qty;

          $insert_brcd['berat']= $dgr->berat;
          $insert_brcd['volume']=  $dgr->volume;
          $insert_brcd['nilai']= $dgr->nilai;
          $insert_brcd['status']=  $dgr->status;
          $insert_brcd['note']= $dgr->note;

          $insert_brcd['kurs']= $dgr->kurs;
          $insert_brcd['remarks']=  $dgr->remarks;
          $insert_brcd['harga']= $hargabeli;
          $insert_brcd['packing_fare']= $dgr->packing_fare;
          $insert_brcd['fare']= $dgr->fare;
          $insert_brcd['biaya_lain']= $dgr->biaya_lain;
          $insert_brcd['kurs_fare']= $dgr->kurs_fare;
          $insert_brcd['bm']= $dgr->bm;
          $insert_brcd['tax_import']= $dgr->tax_import;
          $insert_brcd['fee']= $dgr->fee;
          $insert_brcd['resi_id']=  $get_resiwc->id_resi;
          $insert_brcd['harga_jual']=  $harga_jual;
          $insert_brcd['status_berat']= $statusgiw;
          $insert_brcd['jalur']= $dgr->jalur;
          $insert_brcd['status_jalur']= 0;
          $savegiw = $this->db->insert('giw', $insert_brcd);
					$giwid = $this->db->insert_id();
					if($savegiw){
						$db2 = $this->load->database('db2', TRUE);
						$productgiw = $db2->select('invoice_product.jumlah,invoice_product.sj_id')
																->from('invoice_product')
																->join('giw', 'giw.id=invoice_product.giw_id', 'left')
																->where('resi.nomor',$dgr->nomor)
																->get()->result();
						foreach($productgiw as $pg){
							$insinvprod['id_giw']= $giwid;
			        $insinvprod['id_sj']= 0;
			        $insinvprod['id_invoice']= 0;
			        $insinvprod['id_invoice_beli']= 0;
			        $insinvprod['id_sj_rts']= $pg->sj_id;
			        $insinvprod['jumlah']= $pg->jumlah;
			        $this->db->insert('invoice_product',$insinvprod);
						}
					}
				}//foreach giw
			}else{ //jika gaada resi
				$db2 = $this->load->database('db2', TRUE);
				$dataresi = $db2->select('resi.*,customer.kode')
														->from('giw')
														->join('customer', 'resi.cust_id=customer.id','left')
														->where('resi.nomor',$gr->nomor_resi)
														->get()->row();
				// Cek CS
				$cekcs = $this->db->select('id_cust')
													->from('customer')
													->where('kode',$dataresi->kode)
													->get()->row();
				$cekresiexist = $this->db->where('nomor',$gr->nomor_resi)->get('resi')->num_rows();
				if($cekresiexist->num_rows() > 0){
					continue;
				}
				// Add giw dan Resi
				// Ada Resi
				$insert_brg['id_resi_rts']= $dataresi->id;
				$insert_brg['encrypt_resi']= $this->encrypt_decrypt2('encrypt', $dataresi->id);
				$insert_brg['nomor']= $dataresi->nomor;
				$insert_brg['cust_id']= $cekcs->id_cust;
				$insert_brg['tanggal']= $dataresi->tanggal;
				$insert_brg['supplier']= $dataresi->supplier;
				$insert_brg['tel']= $dataresi->tel;
				$insert_brg['note']= $dataresi->note;
				$insert_brg['konfirmasi_resi']= 0;
				$insert_brg['gudang']= 0;
				$insert_brg['validasi_email']= 1;
				$saveresi = $this->db->insert('resi', $insert_brg);
				$resi_id = $this->db->insert_id();
				// Add Giw
				$datagiwresi = $db2->select('giw.*,container.status as contstatus')
														->from('giw')
														->join('container', 'giw.container_id=container.id','left')
														->where('resi.nomor',$gr->nomor_resi)
														->get()->result();
				foreach($datagiwresi as $dgr){
					$cekbarcode = $this->db->where('nomor',$dgr->nomor)->get('giw')->num_rows();
					if($cekbarcode->num_rows() > 0){
	          continue;
	        }
					if($dgr->contstatus == 3 || $dgr->contstatus == 5 ){
						$statusgiw = 4;
					}else if($dgr->contstatus == 4){
						$statusgiw = 7;
					}else if($dgr->contstatus == 2 || ($dgr->contstatus >= 6 && $dgr->contstatus <= 12) ){
						$statusgiw = 3;
					}else{
						$statusgiw = 2;
					}
					if($statusgiw == 4){
						$hargabeli = $dgr->harga;
					}else{
						$hargabeli = $dgr->harga-500000;
					}
					$cekhargacustomer = $this->Mbarang->data_hbc($id_cust,$id_jenis_barang)->num_rows();
			    $cekhargagrup     = $this->Mbarang->data_hbcg($id_cgrup,$id_jenis_barang)->num_rows();
			    if($id_cgrup > 0 && $cekhargagrup > 0){
			      $dhbc = $this->Mbarang->data_hbcg($id_cgrup,$id_jenis_barang)->row();
			      $harga_jual   = $dhbc->harga;
			    }else if($cekhargacustomer > 0){
						$dhbc = $this->Mbarang->data_hbc($id_cust,$id_jenis_barang)->row();
						$harga_jual   = $dhbc->harga;
					}else{
						$dhb= $this->Mbarang->data_hb($id_jenis_barang)->row();
						$harga_jual = $dhb->harga;
					}
					$insert_brcd['barang']= $dgr->barang;
          $insert_brcd['nomor']=  $dgr->nomor;
          $insert_brcd['customer_id']= $get_resiwc->id_cust;
          $insert_brcd['jenis_barang_id']=  $dgr->jenis_barang_id;
          $insert_brcd['container_id']=  $dgr->container_id;
          $insert_brcd['ctns']= $dgr->ctns;
          $insert_brcd['qty']=  $dgr->qty;

          $insert_brcd['berat']= $dgr->berat;
          $insert_brcd['volume']=  $dgr->volume;
          $insert_brcd['nilai']= $dgr->nilai;
          $insert_brcd['status']=  $dgr->status;
          $insert_brcd['note']= $dgr->note;

          $insert_brcd['kurs']= $dgr->kurs;
          $insert_brcd['remarks']=  $dgr->remarks;
          $insert_brcd['harga']= $hargabeli;
          $insert_brcd['packing_fare']= $dgr->packing_fare;
          $insert_brcd['fare']= $dgr->fare;
          $insert_brcd['biaya_lain']= $dgr->biaya_lain;
          $insert_brcd['kurs_fare']= $dgr->kurs_fare;
          $insert_brcd['bm']= $dgr->bm;
          $insert_brcd['tax_import']= $dgr->tax_import;
          $insert_brcd['fee']= $dgr->fee;
          $insert_brcd['resi_id']=  $resi_id;
          $insert_brcd['harga_jual']=  $harga_jual;
          $insert_brcd['status_berat']= $statusgiw;
          $insert_brcd['jalur']= $dgr->jalur;
          $insert_brcd['status_jalur']= 0;
					$savegiw = $this->db->insert('giw', $insert_brcd);
					$giwid = $this->db->insert_id();
					if($savegiw){
						$db2 = $this->load->database('db2', TRUE);
						$productgiw = $db2->select('invoice_product.jumlah,invoice_product.sj_id')
																->from('invoice_product')
																->join('giw', 'giw.id=invoice_product.giw_id', 'left')
																->where('giw.nomor',$dgr->nomor)
																->get()->result();
						foreach($productgiw as $pg){
							$insinvprod['id_giw']= $giwid;
			        $insinvprod['id_sj']= 0;
			        $insinvprod['id_invoice']= 0;
			        $insinvprod['id_invoice_beli']= 0;
			        $insinvprod['id_sj_rts']= $pg->sj_id;
			        $insinvprod['jumlah']= $pg->jumlah;
			        $this->db->insert('invoice_product',$insinvprod);
						}
					}
			  }//foreach giw
			}//else id ada resi apa gaada
			if($savegiw){
				$updsesuaikan['status_sesuaikan'] = 1;
				$saveupd = $this->db->where('nomor_resi',$gr->nomor_resi)->update('sesuaikan_giw',$updsesuaikan);
			}
		} // foreach looping resi
	}

	public function encrypt_decrypt2($action, $string) {
         $output = false;
         $encrypt_method = "AES-256-CBC";
         $secret_key = 'This is my secret key';
         $secret_iv = 'This is my secret iv';
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

	 function cek_boleh_kirim(){
		 $getinvbuatstok = $this->db->select('invoice.id_invoice,invoice.id_cust')
		 														->from('invoice_product')
																->join('invoice','invoice.id_invoice=invoice_product.id_invoice','left')
																->join('giw','giw.id=invoice_product.id_giw','left')
																->where('giw.boleh_kirim <',2)
																->where('invoice_product.posisi_indo <',20)
		                            ->where('invoice_product.posisi_indo >',0)
																->where('invoice_product.id_sj_wc',0)
																->where('invoice.status_invoice',1)
																->group_by('invoice.id_invoice')
																->get()->result();
		 foreach($getinvbuatstok as $gibs){
			 $idinvjual = $gibs->id_invoice;
			 $cek_customer = $this->db->select('customer.fix_alamat')->from('customer')
																->where('id_cust',$gibs->id_cust)
																->get()->row();
			 if($cek_customer->fix_alamat != 1){
				 $boleh_kirim = 1;
			 }else{
				 $boleh_kirim = 2;
				 $tglbolehkirim = date('Y-m-d');
			 }
			 // dd($boleh_kirim);
			 if($boleh_kirim == 2){
				 $sql = "UPDATE invoice_product
								 JOIN giw ON invoice_product.id_giw = giw.id
								 SET giw.boleh_kirim = $boleh_kirim ,giw.tanggal_boleh_kirim = '$tglbolehkirim'
								 WHERE invoice_product.id_invoice = $idinvjual";
			 }else{
				 $sql = "UPDATE invoice_product
								 JOIN giw ON invoice_product.id_giw = giw.id
								 SET giw.boleh_kirim = $boleh_kirim
								 WHERE invoice_product.id_invoice = $idinvjual";
			 }
			 $this->db->query($sql);
		 }
	 }

}
