<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mcustomer extends CI_Model {
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

	//Proses Get Data And Cloumn Customer and Parsing to Controller Customer function get_customer_json
	function get_customer() {
        $this->datatables->select('customer.id_cust,customer.nama,customer.email,customer.telepon,customer.whatsapp,customer.alamat,
        							customer.kode,customer.note,customer.deposit,customer.deposit,customer.foto_ktp,customer.foto_sk,customer.tanggal_daftar,customer.harga_udara');
        $this->datatables->from('customer');
        $this->datatables->where('customer.aktif',0);
				$this->db->order_by('customer.id_cust','desc');
				$q="$1";
        //$this->datatables->join('kategori', 'barang_kategori_id=kategori_id
        $this->datatables->add_column('view', '<a href="javascript:void(0);" class="edit_record btn btn-info btn-xs"
																			 data-id_cust="$1" data-nama="$2" data-email="$3" data-telepon="$4" data-whatsapp="$5" data-alamat="$6" data-kode="$7"
																			 data-note="$8" data-harga_udara="$9"> <i class="fa fa-edit"></i></a>
																			 <a href="javascript:void(0);" onclick="view_image('.$q.')" class="btn btn-danger btn-xs" alt="Update Data"> <i class="fa fa-file-image-o"></i></a>
																			 <p> </p>
														           <a href="'.site_url().'admin/customer/detail/$1/resi" class="btn btn-warning btn-xs"> <i class="fa fa-ellipsis-h"></i></a>
																			 <a href="javascript:void(0);" class="resend_chat btn btn-success btn-xs" data-id_cust="$1"> <i class="fa fa-wechat"></i></a>

														          ', 'id_cust,nama,email,telepon,whatsapp,alamat,kode,note,harga_udara,foto_ktp,foto_sk');
        return $this->datatables->generate();
  }

  function get_depositid($id) {
        $this->datatables->select('deposit.id_deposit,deposit.nominal_deposit,deposit.tipe_deposit,deposit.keterangan_deposit,deposit.id_cust');
        $this->datatables->from('deposit');
        $this->datatables->where('deposit.id_cust',$id);
        //$this->datatables->join('kategori', 'barang_kategori_id=kategori_id');

        return $this->datatables->generate();
  }

  //Get Data Customer per Kode MArk
  public function get_id($id){
    $this->db->where('kode',$id);

    return $this->db->get('customer');
  }

  //Get Deposit by ID Cust

  public function get_deposit($id){
    $this->db->where('id_cust',$id);

    return $this->db->get('deposit');
  }

  //get by id cust
  public function get_id2($id){
		$this->db->select('customer.*,customer_grup.*');
		$this->db->from('customer');
    $this->db->where('id_cust',$id);
		$this->db->join('customer_grup', 'customer.id_cgrup=customer_grup.id_cgrup', 'left');
    return $this->db->get();
  }

    //Proses Simpan Customer BAru
  	function save($fktp)
  {                       //data Pelanggan
			$markingudara = "WC-".$this->input->post('kode')."/AIR";
			$marking      = "123/WC-".$this->input->post('kode');

      $customer['nama'] = $this->input->post('nama');
	  $customer['id_cgrup'] = 0;
      $customer['email'] = $this->input->post('email');
      $customer['telepon'] = $this->input->post('whatsapp');
      $customer['whatsapp'] = $this->input->post('whatsapp');
      $customer['alamat'] = $this->input->post('alamat');
	  $customer['id_kota'] = $this->input->post('id_kota');
	  $customer['id_provinsi'] = $this->input->post('id_provinsi');
	  $customer['id_kec'] = $this->input->post('id_kec');
// 	  $customer['id_kel'] = $this->input->post('id_kel');
      $customer['kode'] = $marking;
	  $customer['foto_ktp'] =$fktp;
	  $customer['tanggal_daftar']  =date('Y-m-d');
	  $customer['id_campaign'] = '11';
		$customer['s_aktivasi'] = 'Belum Aktivasi';
			// Insert
      $this->db->insert('customer', $customer);
      $last_id = $this->db->insert_id();

			// Pengguna
	  $pengguna['id_cust'] 	= $last_id;
	  $pengguna['username'] 	= $marking;
	  $pengguna['password']   = md5($this->input->post('password'));
	  $pengguna['level'] 	= 0;
      $this->db->insert('pengguna_customer', $pengguna);
			// informasi
			// $whatsapp = "083815423599";
		$cek=$this->db->select('id_pengguna')
		->from('pengguna_customer')
		->where('username',$marking)
		->get()->row();
		$idpengguna=$this->encrypt_decrypt('encrypt', $cek->id_pengguna);

		redirect(site_url('register/verifikasi/'.$idpengguna));
// 		$config = Array(
// 			'protocol' => 'smtp',
// 			'smtp_host' => 'mail.wilopocargo.com',
// 			'smtp_port' => 25,
// 			'smtp_user' => user_email(), //isi dengan gmailmu!
// 			'smtp_pass' => pass_email(),
// 			'mailtype' => 'html',
// 			'charset' => 'iso-8859-1',
// 			'wordwrap' => TRUE
// 		);

// 		$this->load->library('email', $config);
// 		$the_message='</html>
// 				  <html lang="id">
// 		<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

// 		<meta name="viewport" content="width=device-width, initial-scale=1.0">
// 		<title>Email</title>
// 		</head>
// 		<body style=" background-color: #fbfbfb;
// 				font-family: Arial, Helvetica, sans-serif;

// 		<div style="max-width: 500px;
// 				margin: auto;
// 				padding: 15px;">
// 			<div style=" text-align: center;
// 				padding: 15px;">
// 				<img style=" height: 40px;" src="'.base_url().'assets/register_login/gambar/logo.png" alt="">
// 			</div>
// 			<div style="padding: 25px 15px;
// 				background-color: #fff;
// 				border-radius: 2px;
// 				border: 1px solid #f0f0f0;">
// 				<div style="margin-bottom: 15px;
// 				text-align: center;">
// 					<H1 style="font-size: 20px;
// 				color: #333;
// 				font-weight: 700;
// 				margin-bottom: 10px;">Verifikasi Email</H1>
// 				</div>
// 				<div style=" text-align: center;">
// 					<p style="font-size: 15px;
// 				line-height: 1.8;
// 				color: #666;
// 				font-weight: 300;">Terimakasih Telah Mendaftar di sistem kami, untuk dapat login di sistem kami. berikut tombol untuk melakukan verifikasi email</p>
// 					<div style="padding:15px 10px; display: block; text-align: center;">
// 						<a href="'.base_url().'register/verifikasi/'.$idpengguna.'" style="display: inline-block;
// 				padding: 15px 35px;
// 				text-decoration: none;
// 				background: #44b6eb;
// 				font-size: 15px;
// 				color: #fff;
// 				border-radius: 4px;">Verifikasi Email</a>
// 					</div>
// 					<p>Jika anda sudah verifikasi harap abaikan pesan ini!</p>
// 				</div>
// 			</div>
// 			<div style=" text-align: center;
// 				padding: 15px;">
// 				<ul style="list-style: none;
// 				display: flex;
// 				align-items: center;
// 				justify-content: center;
// 				margin: 5px auto;
// 				padding-inline-start: 0;
// 				opacity: .5;">
// 					<li style=" display: inline;
// 				padding: 3px 5px;
// 				font-size: 12px;
// 				color: #666;"><a style=" text-decoration: none;
// 				color: #666;" href="#">Tentang</a></li>
// 					<li style=" display: inline;
// 				padding: 3px 5px;
// 				font-size: 12px;
// 				color: #666;"><a style=" text-decoration: none;
// 				color: #666;" href="#">Bantuan</a></li>
// 					<li style=" display: inline;
// 				padding: 3px 5px;
// 				font-size: 12px;
// 				color: #666;"><a style=" text-decoration: none;
// 				color: #666;" href="">Customer Services</a></li>
// 				</ul>
// 				<p style="font-size: 12px;
// 				opacity: .5;
// 				color: #666;
// 				line-height: 1.2;
// 				margin: 0;">Copyright ©2020 <a href="https://wilopocargo.com">Wilopo Cargo</a> All right reserved.</p>
// 			</div>
// 		</div>
// 		</body>
// 		</html>';

// 		$this->email->set_newline("\r\n");
// 		$this->email->from(user_email());
// 		$this->email->to($this->input->post('email')); //email tujuan. Isikan dengan emailmu! $emailaktif
// 		$this->email->subject('[Wilopo Cargo] Verifikasi Akun Customer Wilopo Cargo!');
// 		$this->email->message($the_message);
// 		$this->email->send();

//       $this->session->set_flashdata('msg','successregis');
// 			// var_dump($image2);die();
//       redirect(site_url('login'));

  }

  function telegram($idpeng){
      $cek=$this->db->select('customer.email')
		->from('pengguna_customer')
		->join('customer', 'customer.id_cust=pengguna_customer.id_cust')
		->where('pengguna_customer.id_pengguna',$idpeng)
		->get()->row();
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
					    	$the_message1='</html>
                            				  <html lang="id">
                            		<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

                            		<meta name="viewport" content="width=device-width, initial-scale=1.0">
                            		<title>Email</title>
                            		</head>
                            		<body style=" background-color: #fbfbfb;
                            				font-family: Arial, Helvetica, sans-serif;

                            		<div style="max-width: 500px;
                            				margin: auto;
                            				padding: 15px;">
                            			<div style=" text-align: center;
                            				padding: 15px;">
                            				<img style=" height: 40px;" src="'.base_url().'assets/register_login/gambar/logo.png" alt="">
                            			</div>
                            			<div style="padding: 25px 15px;
                            				background-color: #fff;
                            				border-radius: 2px;
                            				border: 1px solid #f0f0f0;">
                            				<div style="margin-bottom: 15px;
                            				text-align: center;">
                            					<H1 style="font-size: 20px;
                            				color: #333;
                            				font-weight: 700;
                            				margin-bottom: 10px;">Join Group Telegram</H1>
                            				</div>
                            					<div style=" text-align: center;">
                            					<p style="font-size: 15px;
                            				line-height: 1.8;
                            				color: #666;
                            				font-weight: 300;">Klik Tombol Dibawah Ini untuk bergabung di telegram kami :) !</p>
                            					<div style="padding:15px 10px; display: block; text-align: center;">
                            						<a href="https://t.me/joinchat/PtZIFlOcSTonimofw2Ld6g" style="display: inline-block;
                            				padding: 15px 35px;
                            				text-decoration: none;
                            				background: #44b6eb;
                            				font-size: 15px;
                            				color: #fff;
                            				border-radius: 4px;">Join Telegram</a>
                            					</div>
                            					<p>Jika anda sudah bergabung harap abaikan pesan ini!</p>
                            				</div>
                            			</div>
                            			<div style=" text-align: center;
                            				padding: 15px;">
                            				<ul style="list-style: none;
                            				display: flex;
                            				align-items: center;
                            				justify-content: center;
                            				margin: 5px auto;
                            				padding-inline-start: 0;
                            				opacity: .5;">
                            					<li style=" display: inline;
                            				padding: 3px 5px;
                            				font-size: 12px;
                            				color: #666;"><a style=" text-decoration: none;
                            				color: #666;" href="#">Tentang</a></li>
                            					<li style=" display: inline;
                            				padding: 3px 5px;
                            				font-size: 12px;
                            				color: #666;"><a style=" text-decoration: none;
                            				color: #666;" href="#">Bantuan</a></li>
                            					<li style=" display: inline;
                            				padding: 3px 5px;
                            				font-size: 12px;
                            				color: #666;"><a style=" text-decoration: none;
                            				color: #666;" href="">Customer Services</a></li>
                            				</ul>
                            				<p style="font-size: 12px;
                            				opacity: .5;
                            				color: #666;
                            				line-height: 1.2;
                            				margin: 0;">Copyright ©2020 <a href="https://wilopocargo.com">Wilopo Cargo</a> All right reserved.</p>
                            			</div>
                            		</div>
                            		</body>
                            		</html>';

                            		$this->email->set_newline("\r\n");
                            		$this->email->from(user_email());
                            		$this->email->to($cek->email); //email tujuan. Isikan dengan emailmu! $emailaktif
                            		$this->email->subject('[Wilopo Cargo] Join Group Telegram Kami!');
                            		$this->email->message($the_message1);
                            		$this->email->send();
                            			$this->session->set_flashdata('msg','successaktif');
                    						// var_dump($image2);die();
                    				redirect("https://wilopocargo.com/terima-kasih");
  }
  function verifikasiemail($idcust)
  {                       //data Pelanggan
	$idpengguna=$this->encrypt_decrypt('decrypt', $idcust);
	$cek=$this->db->select('pengguna_customer.id_pengguna,customer.*')
		->from('pengguna_customer')
		->join('customer', 'customer.id_cust=pengguna_customer.id_cust')
		->where('pengguna_customer.id_pengguna',$idpengguna)
		->where('pengguna_customer.level',0)
		->get()->row();
			// informasi
			// $whatsapp = "083815423599";
	if($cek->id_pengguna > 0){
			$dat['level']= 1;
			$this->db->where('id_pengguna',$idpengguna);
			$this->db->update('pengguna_customer', $dat);

				$whatsapp = $cek->whatsapp;
				$pesan1 = "Yth. ".$cek->nama.", Selamat! Anda telah terdaftar sebagai member Wilopo Cargo. \n\nPertama-tama, harap save nomor ini di contact Whatsapp Anda,".
								" karena kami akan mengirimkan data resi & status pengiriman barang, tagihan, dan berbagai informasi penting lainnya.";
				sendwhatsapp($pesan1,$whatsapp);

				$pesan2 = "Kedua, kami sudah emailkan surat pernyataan dan ketentuan, harap dibaca dan diperhatikan dengan teliti, lalu tandatangani surat di atas materai Rp. 6000, ".
											"lalu di print dan kirim ke kantor kita via JNE/dll atau Gojek atau diantar sendiri. Berikut alamatnya: ".
											"\n\nWILOPO CARGO (Dwi)\nRukan Venice Blok B-85 Golf Lake Residence,\nJl. Kamal Raya Outer Ring Road, Cengkareng Timur\nJakarta Barat, 11730 - Indonesia \n(021) 22521995";
				sendwhatsapp($pesan2,$whatsapp);

				$pesan3 = "Kode Marking Anda adalah *".$cek->kode."* (By SEA) dan *".$cek->kode."/AIR * (By AIR). Sekarang, Anda sudah dapat mengirimkan barang Anda ke gudang kami dengan menyertakan kode marking ini pada kiriman Anda, berikut adalah list alamat gudang kami, baik udara maupun laut:";
				sendwhatsapp($pesan3,$whatsapp);

				$pesan6 = "GUANGZHOU - LAUT / BY SEA ".
									"\n\nADDRESS:".
									"\nGUANGZHOU SHI BAIYUNQU BAIYUNHUJIE".
									"\nXIA HUA ER LU 961HAO".
	                "\nHENG HE SHA WU YE SHI JING CANG 1011HAO".
	                "\n广州市白云区白云湖街夏花二路961号 恒河沙物业石井仓1011号".
									"\n\nProvince: Guangdong".
									"\nCity: Guangzhou".
									"\nDistict: Baiyun".
									"\nRoad/Street: Xiahua 2nd Road, Hujie Street, No. 1011, Shijingcang, Henghesha".
	                "\nPostal Code: 510000".
									"\n\nCONTACT PERSON 联系人 :".
									"\n\nMRS.FISH (陈小姐)".
									"\n18819350302（微信）".
									"\nQQ：169482416".
									"\n导航恒河沙物业石井仓";
				sendwhatsapp($pesan6,$whatsapp);

	      $pesan5 = "YIWU - LAUT / BY SEA ".
									"\n\n我司收货地址 : 浙江省义乌市江南三区7幢1号".
									"\nHUO CANG DI ZHI : NO. 1. 7  BUILDING  JIANGNAN THREE AREAS YI WU".
									"\n\n联系电话/LIAN XI DIAN HUA:".
	                "\n15355378182 MS. FUU".
	                "\n13957949089 MR. KHUNG";
				sendwhatsapp($pesan5,$whatsapp);

				$pesan4 = "GUANGZHOU - UDARA / BY AIR".
									"\n\n莉苹物流".
									"\nLi ping logistics".
									"\n\n仓库地址 ：".
	                "\n广东省 广州市 白云区 百花岭街  自编6号 银瑜便利店后面 B01栋".
	                "\nBai hua Ling road zi bian 6 hao , Baiyun District, GuangZhou City, GuangDong Province, China.".
									"\n\n百度地图 ： 印尼仓库".
									"\nPake baidu map ketik 印尼仓库 langsung keluar petanya ".
	                "\n\nCONTACT PERSON 联系人 : ".
	                "\nAndy : 13059186237 (wechat :plg808080) ".
	                "\nmiss zeng :18664666127".
	                "\n小曾/Xiao zeng : 18664666127".
	                "\n电话/Office : 020-36772001".
	                "\nQQ : 1807619203".
	                "\n唛头/Kode Marking : ".
									"\n\nNote : untuk brg yg masuk ke gudang di harapkan di sertain marking dan PL lengkap".
									"\n\n备注：进仓的货物要随着客户代码， 装箱清单， 以及货物照片".
									"\n\n*NOTE*".
									"\nUntuk *Kode Marking pengiriman udara* harus di sertakan tambahan *”/AIR”*. Contoh : *123/WC-WILOPOCARGO/AIR*".
									"\n\nAtas perhatian Anda kami ucapkan terima kasih 🙏🏻";
				sendwhatsapp($pesan4,$whatsapp);

				$image1  = 'https://i.ibb.co/Zx7T17t/delivery.jpg';
					$caption1 = "Harap diperhatikan delivery instruction berikut, lalu harap berikan delivery instruction ini ke supplier Anda di China sebagai standard peraturan penerimaan barang di gudang China kami.";
					sendimage($caption1,$whatsapp,$image1);
						sendwhatsapp($caption1,$whatsapp);

				$pesan81 = "Join Group Telegram Kami sekarang disini, untuk belajar kelas impor online\nhttps://t.me/joinchat/PtZIFlOcSTonimofw2Ld6g";
						sendwhatsapp($pesan81,$whatsapp);

				$pesan8 = "Kode Marking Anda belum aktif dan belum dapat mengirim barang ke gudang China kami, namun sudah dapat belajar kelas impor di dalam User Dashboard kami.".
				"\n\nLogin sekarang disini untuk belajar kelas impor online:\nhttps://customer.wilopocargo.com/\n\nApabila sudah siap mengirim barang, Anda dapat konsultasi dengan sales kami dan melakukan aktivasi Kode Marking, klik link dibawah untuk Whatsapp Sales kami:\nhttps://wilopocargo.com/chat_sales?id=C10\n\nTerimakasih :)"."\n\n*Wilopo Cargo* _(do not reply)_";
						sendwhatsapp($pesan8,$whatsapp);

				// 		$image2a = 'https://office.wilopocargo.com/assets/foto_ktp/'.$cek->foto_ktp;
				// 		$image2 = $cek->foto_ktp;
				// 		$caption2 = "New Customer Wilopo Cargo \n\nNama : ".$cek->nama."\nKode Marking : ".$cek->kode."\nAlamat : ".$cek->alamat."\nEmail : order@wilopocargo.com \nNo.Telepon : 081293972529";
				// 		$captionudara2 = "New Customer Wilopo Cargo \n\nNama : ".$cek->nama."\nKode Marking : ".$cek->kode."/AIR \nAlamat : ".$cek->alamat."\nEmail : order@wilopocargo.com \nNo.Telepon : 081293972529";

				// 		sendimage($caption2,$whatsapp,$image2a);
				// 		sendwhatsapp($caption2,$whatsapp);

				// 		sendimage($captionudara2,$whatsapp,$image2a);
				// 		sendwhatsapp($captionudara2,$whatsapp);

				// 		sendimagelocal($caption2,'081317518779',$image2,$image2a);
    //         			sendwhatsapp($caption2,'081317518779');

    //         			sendimagelocal($captionudara2,'08111353711',$image2,$image2a);
    //         			sendwhatsapp($captionudara2,'08111353711');

						$the_message="<html>
																<body>
																				<h3>Yth. Bpk/Ibu ".$cek->nama.",</h3>
																				<p>Berikut kami lampirkan surat ketentuan & pernyataan untuk pendaftaran member Wilopo Cargo,
																				harap dibaca dan diperhatikan dengan teliti. Lalu, harap surat ditanda tangani di atas materai Rp. 6000.</p>
																				<p>Setelah ditandatangani, harap surat dikirimkan kembali ke kantor kami di alamat:</p>
																				<p>".nama_perusahaan2()."</p>

																</body>
													</html>";

						$atch=base_url().'assets/'.skwilopo();
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
					$this->email->attach($atch);
						$this->email->set_newline("\r\n");
					$this->email->from(user_email());
					$this->email->to($cek->email); //email tujuan. Isikan dengan emailmu!
					$this->email->subject('Surat Ketentuan & Pernyataan Pendaftaran Member Wilopo Cargo');
					$this->email->message($the_message);

					if($this->email->send())
					{
					    redirect(site_url('register/emailtelegram/'.$idpengguna));
                        // $this->telegram($cek->email);
					}
					else
					{
					 echo "gagal verifikasi";
					}

		}else{
				redirect(site_url('login'));
		}

  }

  function verifikasimanual($idcust)
  {                       //data Pelanggan
	$idpengguna=$idcust;
	$cek=$this->db->select('pengguna_customer.id_pengguna,customer.*')
		->from('pengguna_customer')
		->join('customer', 'customer.id_cust=pengguna_customer.id_cust')
		->where('pengguna_customer.id_pengguna',$idpengguna)
		->where('pengguna_customer.level',0)
		->get()->row();
			// informasi
			// $whatsapp = "083815423599";
	if($cek->id_pengguna > 0){
			$dat['level']= 1;
			$this->db->where('id_pengguna',$idpengguna);
			$this->db->update('pengguna_customer', $dat);

				$whatsapp = $cek->whatsapp;
				$pesan1 = "Yth. ".$cek->nama.", Selamat! Anda telah terdaftar sebagai member Wilopo Cargo. \n\nPertama-tama, harap save nomor ini di contact Whatsapp Anda,".
								" karena kami akan mengirimkan data resi & status pengiriman barang, tagihan, dan berbagai informasi penting lainnya.";
				sendwhatsapp($pesan1,$whatsapp);

				$pesan2 = "Kedua, kami sudah emailkan surat pernyataan dan ketentuan, harap dibaca dan diperhatikan dengan teliti, lalu tandatangani surat di atas materai Rp. 6000, ".
											"lalu di print dan kirim ke kantor kita via JNE/dll atau Gojek atau diantar sendiri. Berikut alamatnya: ".
											"\n\nWILOPO CARGO (Dwi)\nRukan Venice Blok B-85 Golf Lake Residence,\nJl. Kamal Raya Outer Ring Road, Cengkareng Timur\nJakarta Barat, 11730 - Indonesia \n(021) 22521995";
				sendwhatsapp($pesan2,$whatsapp);

				$pesan3 = "Kode Marking Anda adalah *".$cek->kode."* (By SEA) dan *".$cek->kode."/AIR * (By AIR). Sekarang, Anda sudah dapat mengirimkan barang Anda ke gudang kami dengan menyertakan kode marking ini pada kiriman Anda, berikut adalah list alamat gudang kami, baik udara maupun laut:";
				sendwhatsapp($pesan3,$whatsapp);

				$pesan4 = "GUANGZHOU - LAUT / BY SEA ".
											"\n\nADDRESS:".
											"\nGUANGZHOU SHI BAIYUNQU BAIYUNHUJIE".
											"\nXIA HUA ER LU 961HAO".
							"\nHENG HE SHA WU YE SHI JING CANG 1011HAO".
							"\n广州市白云区白云湖街夏花二路961号 恒河沙物业石井仓1011号".
							"\n\nCONTACT PERSON 联系人 : ".
							"\n13424121400".
							"\n13418099277".
							"\n13418099255(微信)WECHAT".
							"\nQQ: 184304836".
							"\nQQ: 1341958821".
							"\n导航恒河沙物业石井仓";
				sendwhatsapp($pesan4,$whatsapp);

				$pesan5 = "YIWU - LAUT / BY SEA ".
											"\n\n我司收货地址 : 浙江省义乌市江南三区7幢1号".
											"\nHUO CANG DI ZHI : NO. 1. 7  BUILDING  JIANGNAN THREE AREAS YI WU".
											"\n\n联系电话/LIAN XI DIAN HUA:".
							"\n15355378182 MS. FUU".
							"\n13957949089 MR. KHUNG";
				sendwhatsapp($pesan5,$whatsapp);

				$pesan6 = "GUANGZHOU - UDARA / BY AIR ".
											"\n\n广州市，白云区，石井镇鸦岗大道黄金围金围东路，东方工业区5号仓，空运部".
											"\n联系人 何归先生 : (+86) 139-2219-5756 / 02081008446 送货带装箱单、订单".
											"包装要求 纸箱套袋".
							"\nGuangzhou city, Baiyun district, shijing town ,ya gang , huang jin wei road ，dong fang industry area warehouse no.5 ".
							"\ncontact person : ".
							"\nMr. He Gui +86139-2219-5756 /02081008446";
				sendwhatsapp($pesan6,$whatsapp);

				$image1  = 'https://i.ibb.co/Zx7T17t/delivery.jpg';
					$caption1 = "Harap diperhatikan delivery instruction berikut, lalu harap berikan delivery instruction ini ke supplier Anda di China sebagai standard peraturan penerimaan barang di gudang China kami.";
					sendimage($caption1,$whatsapp,$image1);
						sendwhatsapp($caption1,$whatsapp);

				$pesan81 = "Join Group Telegram Kami sekarang disini, untuk belajar kelas impor online\nhttps://t.me/joinchat/PtZIFlOcSTonimofw2Ld6g";
					sendwhatsapp($pesan81,$whatsapp);

				$pesan8 = "Kode Marking Anda belum aktif dan belum dapat mengirim barang ke gudang China kami, namun sudah dapat belajar kelas impor di dalam User Dashboard kami.".
				"\n\nLogin sekarang disini untuk belajar kelas impor online:\nhttps://customer.wilopocargo.com/\n\nApabila sudah siap mengirim barang, Anda dapat konsultasi dengan sales kami dan melakukan aktivasi Kode Marking, klik link dibawah untuk Whatsapp Sales kami:\nhttps://wilopocargo.com/chat_sales?id=C10\n\nTerimakasih :)"."\n\n*Wilopo Cargo* _(do not reply)_";
						sendwhatsapp($pesan8,$whatsapp);

				// 		$image2a = 'https://office.wilopocargo.com/assets/foto_ktp/'.$cek->foto_ktp;
				// 		$image2 = $cek->foto_ktp;
				// 		$caption2 = "New Customer Wilopo Cargo \n\nNama : ".$cek->nama."\nKode Marking : ".$cek->kode."\nAlamat : ".$cek->alamat."\nEmail : order@wilopocargo.com \nNo.Telepon : 081293972529";
				// 		$captionudara2 = "New Customer Wilopo Cargo \n\nNama : ".$cek->nama."\nKode Marking : ".$cek->kode."/AIR \nAlamat : ".$cek->alamat."\nEmail : order@wilopocargo.com \nNo.Telepon : 081293972529";

				// 		sendimage($caption2,$whatsapp,$image2a);
				// 		sendwhatsapp($caption2,$whatsapp);

				// 		sendimage($captionudara2,$whatsapp,$image2a);
				// 		sendwhatsapp($captionudara2,$whatsapp);

				// 		sendimagelocal($caption2,'081317518779',$image2,$image2a);
    //         			sendwhatsapp($caption2,'081317518779');

    //         			sendimagelocal($captionudara2,'08111353711',$image2,$image2a);
    //         			sendwhatsapp($captionudara2,'08111353711');

						$the_message="<html>
																<body>
																				<h3>Yth. Bpk/Ibu ".$cek->nama.",</h3>
																				<p>Berikut kami lampirkan surat ketentuan & pernyataan untuk pendaftaran member Wilopo Cargo,
																				harap dibaca dan diperhatikan dengan teliti. Lalu, harap surat ditanda tangani di atas materai Rp. 6000.</p>
																				<p>Setelah ditandatangani, harap surat dikirimkan kembali ke kantor kami di alamat:</p>
																				<p>".nama_perusahaan2()."</p>

																</body>
													</html>";

						$atch=base_url().'assets/'.skwilopo();
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
					$this->email->attach($atch);
						$this->email->set_newline("\r\n");
					$this->email->from(user_email());
					$this->email->to($cek->email); //email tujuan. Isikan dengan emailmu!
					$this->email->subject('Surat Ketentuan & Pernyataan Pendaftaran Member Wilopo Cargo');
					$this->email->message($the_message);

					if($this->email->send())
					{
					       redirect(site_url('register/emailtelegram/'.$idpengguna));
					}
					else
					{
					   echo "gagal verifikasi";
					}

		}else{
				redirect(site_url('login'));
		}

  }

  //Proses Update Data Customer
  function update($f1,$f2)
  {
      $customer['nama'] = $this->input->post('nama');
      $customer['email'] = $this->input->post('email');
      $customer['telepon'] = $this->input->post('telepon');
      $customer['whatsapp'] = $this->input->post('whatsapp');
      $customer['alamat'] = $this->input->post('alamat');
      $customer['note'] = $this->input->post('note');
      //$customer['kode'] = $this->input->post('kode');
			$customer['foto_ktp'] =$f1;
			$customer['foto_sk']  =$f2;
			$customer['harga_udara'] = $this->input->post('harga_udara');

    	$this->db->where('id_cust',$this->input->post('id_cust'));
      $this->db->update('customer', $customer);

      $this->session->set_flashdata('msg','updated');
      redirect(site_url('admin/customer'));
  }

	// Resend Chat Marking Customer
	function resend_chat(){
		$idcust = $this->input->post('id_cust');
		$datacust = $this->get_id2($idcust)->row();
		$namacust = $datacust->nama;
		$emailcust= $datacust->email;
		$markcust = substr($datacust->kode,7);
		$wacust   = $datacust->whatsapp;
		$markingudara = "WC-".$markcust."/AIR";
		$marking      = "123/WC-".$markcust;
		$the_message="<html>
												 <body>
																 <h3>Yth. Bpk/Ibu ".$namacust.",</h3>
																 <p>Berikut kami lampirkan surat ketentuan & pernyataan untuk pendaftaran member Wilopo Cargo,
																	harap dibaca dan diperhatikan dengan teliti. Lalu, harap surat ditanda tangani di atas materai Rp. 6000.</p>
																 <p>Setelah ditandatangani, harap surat dikirimkan kembali ke kantor kami di alamat:</p>
																 <p>".nama_perusahaan2()."</p>

												 </body>
									 </html>";

		$atch=base_url().'assets/'.skwilopo();
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
		$this->email->attach($atch);
		$this->email->set_newline("\r\n");
		$this->email->from(user_email());
		$this->email->to($emailcust); //email tujuan. Isikan dengan emailmu!
		$this->email->subject('Surat Ketentuan & Pernyataan Pendaftaran Member Wilopo Cargo');
		$this->email->message($the_message);

		if($this->email->send())
		{

		}
		else
		{
			//show_error($this->email->print_debugger());
		}
		$whatsapp = $wacust;
		$pesan1 = "Yth. ".$namacust.", Selamat! Anda telah terdaftar sebagai member Wilopo Cargo. \n\nPertama-tama, harap save nomor ini di contact Whatsapp Anda,".
							" karena kami akan mengirimkan data resi & status pengiriman barang, tagihan, dan berbagai informasi penting lainnya.";;

		sendwhatsapp($pesan1,$whatsapp);

		$pesan2 = "Kedua, kami sudah emailkan surat pernyataan dan ketentuan, harap dibaca dan diperhatikan dengan teliti, lalu tandatangani surat di atas materai Rp. 6000, ".
							"lalu di print dan kirim ke kantor kita via JNE/dll atau Gojek atau diantar sendiri. Berikut alamatnya: ".
							"\n\nWILOPO CARGO (Dwi)\nRukan Venice Blok B-85 Golf Lake Residence,\nJl. Kamal Raya Outer Ring Road, Cengkareng Timur\nJakarta Barat, 11730 - Indonesia \n(021) 22521995";
		sendwhatsapp($pesan2,$whatsapp);

		$pesan3 = "Kode Marking Anda adalah *".$marking."* (By SEA) dan *".$markingudara."* (By AIR). Sekarang, Anda sudah dapat mengirimkan barang Anda ke gudang kami dengan menyertakan kode marking ini pada kiriman Anda, berikut adalah list alamat gudang kami, baik udara maupun laut:";

		sendwhatsapp($pesan3,$whatsapp);

		$pesan4 = "GUANGZHOU - LAUT / BY SEA ".
							"\n\nADDRESS:".
							"\nGUANGZHOU SHI BAIYUNQU BAIYUNHUJIE".
							"\nXIA HUA ER LU 961HAO".
							"\nHENG HE SHA WU YE SHI JING CANG 1011HAO".
							"\n广州市白云区白云湖街夏花二路961号 恒河沙物业石井仓1011号".
							"\n\nCONTACT PERSON 联系人 : ".
							"\n13424121400".
							"\n13418099277".
							"\n13418099255(微信)WECHAT".
							"\nQQ: 184304836".
							"\nQQ: 1341958821".
							"\n导航恒河沙物业石井仓";
		sendwhatsapp($pesan4,$whatsapp);

		$pesan5 = "YIWU - LAUT / BY SEA ".
							"\n\n我司收货地址 : 浙江省义乌市江南三区7幢1号".
							"\nHUO CANG DI ZHI : NO. 1. 7  BUILDING  JIANGNAN THREE AREAS YI WU".
							"\n\n联系电话/LIAN XI DIAN HUA:".
							"\n15355378182 MS. FUU".
							"\n13957949089 MR. KHUNG";
		sendwhatsapp($pesan5,$whatsapp);

		$pesan6 = "GUANGZHOU - UDARA / BY AIR ".
							"\n\n广州市，白云区，石井镇鸦岗大道黄金围金围东路，东方工业区5号仓，空运部".
							"\n联系人 何归先生 : (+86) 139-2219-5756 / 02081008446 送货带装箱单、订单".
							"包装要求 纸箱套袋".
							"\nGuangzhou city, Baiyun district, shijing town ,ya gang , huang jin wei road ，dong fang industry area warehouse no.5 ".
							"\ncontact person : ".
							"\nMr. He Gui +86139-2219-5756 /02081008446";
		sendwhatsapp($pesan6,$whatsapp);

		$image1  = 'https://i.ibb.co/Zx7T17t/delivery.jpg';
		$caption1 = "Harap diperhatikan delivery instruction berikut, lalu harap berikan delivery instruction ini ke supplier Anda di China sebagai standard peraturan penerimaan barang di gudang China kami.";
		sendimage($caption1,$whatsapp,$image1);
		sendwhatsapp($caption1,$whatsapp);

		$pesan8 = "Apabila Anda memiliki pertanyaan atau masalah lebih lanjut, CSO (Customer Service Officer) kami siap melayani dengan senang hati. Anda dapat menanyakan apapun dan juga melakukan komplain apabila ada masalah. Berikut adalah kontak CSO kami: ".
		"\n\nDwi (CSO 1)\nWA: 0812 9397 2529\n\natau bisa hubungi nomor kantor kami di\n\n021 2252 1995\n\nTerimakasih :)"."\n\n*Wilopo Cargo* _(do not reply)_";
		sendwhatsapp($pesan8,$whatsapp);

		// $image2a = $_FILES['foto_ktp'];
		// $image2 = $_FILES['foto_ktp']['tmp_name'];
		// $caption2 = "New Customer Wilopo Cargo \n\nNama : ".$this->input->post('nama')."\nKode Marking : ".$marking."\nAlamat : ".$this->input->post('alamat')."\nEmail : order@wilopocargo.com \nNo.Telepon : 081293972529";
		// $captionudara2 = "New Customer Wilopo Cargo \n\nNama : ".$this->input->post('nama')."\nKode Marking : ".$markingudara."\nAlamat : ".$this->input->post('alamat')."\nEmail : order@wilopocargo.com \nNo.Telepon : 081293972529";
		//
		// sendimagelocal($caption2,'081317518779',$image2,$image2a);
		// sendwhatsapp($caption2,'081317518779');
		//
		// sendimagelocal($captionudara2,'08111353711',$image2,$image2a);
		// sendwhatsapp($captionudara2,'08111353711');

		$this->session->set_flashdata('msg','okresend');
		// var_dump($image2);die();
		redirect(site_url('admin/customer'));
	}

	public function select_grup($kode){
    $this->db->select('id_cgrup,kode_cgrup');
    $this->db->limit(10);
    $this->db->from('customer_grup');
    $this->db->like('kode_cgrup', $kode);
    return $this->db->get()->result_array();
  }


}
