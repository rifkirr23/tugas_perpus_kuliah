<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mcustomer extends CI_Model {

	//Proses Get Data And Cloumn Customer and Parsing to Controller Customer function get_customer_json
	function get_customer() {
    $this->datatables->select('customer.id_cust,customer.nama,customer.email,customer.telepon,customer.whatsapp,customer.alamat,
    							customer.kode,customer.note,customer.deposit,customer.deposit,customer.foto_ktp,customer.foto_sk,customer.tanggal_daftar,
									customer.harga_udara,customer.nama_penerima,customer.fix_alamat,pengguna.nama_pengguna,
									customer.s_aktivasi,campaign.kode_campaign,crm.nama_pengguna as nama_crm,master_ekspedisi_lokal.nama_ekspedisi as ekspedisi_lokal');
    $this->datatables->from('customer');
    $this->datatables->where('customer.aktif',0);
		$this->datatables->join('pengguna', 'pengguna.id_pengguna=customer.id_pendaftar');
		$this->datatables->join('pengguna as crm', 'crm.id_pengguna=customer.id_crm');
		$this->datatables->join('campaign', 'campaign.id_campaign=customer.id_campaign');
		$this->datatables->join('master_ekspedisi_lokal', 'customer.id_ekspedisi=master_ekspedisi_lokal.id_ekspedisi');
		if($this->session->userdata('level') == "sales" || $this->session->userdata('level') == "saleso"){
			$this->datatables->where('id_pendaftar',$this->session->userdata('id_pengguna'));
		}else if($this->session->userdata('level') == "crm"){
			$this->datatables->where('id_crm',$this->session->userdata('id_pengguna'));
		}
		// $this->db->order_by('customer.id_cust','desc');
		$q="$1";
    //$this->datatables->join('kategori', 'barang_kategori_id=kategori_id
    $this->datatables->add_column('view', '<a href="'.site_url().'admin/customer/edit_customer/$1" class="btn btn-info btn-xs" alt="Update Data"> <i class="fa fa-edit"></i></a>
																	 <a href="javascript:void(0);" onclick="view_image('.$q.')" class="btn btn-danger btn-xs" alt="Update Data"> <i class="fa fa-file-image-o"></i></a>
																	 <p> </p>
												           <a href="'.site_url().'admin/customer/detail/$1/index" class="btn btn-warning btn-xs"> <i class="fa fa-ellipsis-h"></i></a>
																	 <a href="javascript:void(0);" class="resend_chat btn btn-success btn-xs" data-id_cust="$1"> <i class="fa fa-wechat"></i></a>
																	 <p></p><a href="javascript:void(0);" class="refund_deposit btn btn-primary btn-xs" data-id_cust="$1"> <i class="fa fa-money"></i></a>
																	 <a href="javascript:void(0);" onclick="akun_customer('.$q.')" class="btn btn-info btn-xs" alt="Update Data"> <i class="fa fa-user"></i></a>
																	 <p></p><a href="javascript:void(0);" class="setor_deposit btn btn-primary btn-xs" data-id_cust="$1"> <i class="fa fa-upload"></i></a>
																	 <p></p>
																	 <a href="javascript:void(0);" class="delete_customer btn btn-danger btn-xs" data-id_cust="$1"> <i class="fa fa-close"></i></a>
																	 <a href="javascript:void(0);" class="push_customer btn btn-success btn-xs" data-id_cust="$1"> <i class="fa fa-upload"></i></a>
												          ', 'id_cust,nama,email,telepon,whatsapp,alamat,fix_alamat,nama_penerima,harga_udara,note');
		// $this->datatables->add_column('sudah_aktivasi', '$1','sudah_aktivasi_cust(jumlah_rmb,jumlah_rmb2)');
    return $this->datatables->generate();
  }

	function get_customer_byid($id) {
    $this->datatables->select('customer.id_cust,customer.nama,customer.email,customer.telepon,customer.whatsapp,customer.alamat,
    							customer.kode,customer.note,customer.deposit,customer.deposit,customer.foto_ktp,customer.foto_sk,customer.tanggal_daftar,
									customer.harga_udara,customer.nama_penerima,customer.fix_alamat,customer.ekspedisi_lokal,pengguna.nama_pengguna,customer.s_aktivasi,campaign.kode_campaign');
    $this->datatables->from('customer');
    $this->datatables->where('customer.aktif',0);
		$this->datatables->where('customer.id_cgrup',$id);
		$this->datatables->join('pengguna', 'pengguna.id_pengguna=customer.id_pendaftar');
		$this->datatables->join('campaign', 'campaign.id_campaign=customer.id_campaign');
		// $this->db->order_by('customer.id_cust','desc');
		$q="$1";
    //$this->datatables->join('kategori', 'barang_kategori_id=kategori_id
    $this->datatables->add_column('view', '<a onclick="edit_customer('.$q.')" class="btn btn-info btn-xs" alt="Update Data"> <i class="fa fa-edit"></i></a>
																	 <a href="javascript:void(0);" onclick="view_image('.$q.')" class="btn btn-danger btn-xs" alt="Update Data"> <i class="fa fa-file-image-o"></i></a>
																	 <p> </p>
												           <a href="'.site_url().'admin/customer/detail/$1/index" class="btn btn-warning btn-xs"> <i class="fa fa-ellipsis-h"></i></a>
																	 <a href="javascript:void(0);" class="resend_chat btn btn-success btn-xs" data-id_cust="$1"> <i class="fa fa-wechat"></i></a>
																	 <p></p><a href="javascript:void(0);" class="refund_deposit btn btn-primary btn-xs" data-id_cust="$1"> <i class="fa fa-money"></i></a>
												          ', 'id_cust,nama,email,telepon,whatsapp,alamat,fix_alamat,nama_penerima,harga_udara,note');
		// $this->datatables->add_column('sudah_aktivasi', '$1','c_total_rmb(jumlah_rmb,jumlah_rmb2)');
    return $this->datatables->generate();
  }

	function get_customer_bycg($id) {
    $this->datatables->select('customer.id_cust,customer.nama,customer.email,customer.telepon,customer.whatsapp,customer.alamat,
    							customer.kode,customer.note,customer.deposit,customer.deposit,customer.foto_ktp,customer.foto_sk,customer.tanggal_daftar,
									customer.harga_udara,customer.nama_penerima,customer.fix_alamat,customer.ekspedisi_lokal,pengguna.nama_pengguna,customer.s_aktivasi,campaign.kode_campaign');
    $this->datatables->from('customer');
    $this->datatables->where('customer.aktif',0);
		$this->datatables->where('customer.id_campaign',$id);
		$this->datatables->join('pengguna', 'pengguna.id_pengguna=customer.id_pendaftar');
		$this->datatables->join('campaign', 'campaign.id_campaign=customer.id_campaign');
		// $this->db->order_by('customer.id_cust','desc');
		$q="$1";
    //$this->datatables->join('kategori', 'barang_kategori_id=kategori_id
    $this->datatables->add_column('view', '<a onclick="edit_customer('.$q.')" class="btn btn-info btn-xs" alt="Update Data"> <i class="fa fa-edit"></i></a>
																	 <a href="javascript:void(0);" onclick="view_image('.$q.')" class="btn btn-danger btn-xs" alt="Update Data"> <i class="fa fa-file-image-o"></i></a>
																	 <p> </p>
												           <a href="'.site_url().'admin/customer/detail/$1/index" class="btn btn-warning btn-xs"> <i class="fa fa-ellipsis-h"></i></a>
																	 <a href="javascript:void(0);" class="resend_chat btn btn-success btn-xs" data-id_cust="$1"> <i class="fa fa-wechat"></i></a>
																	 <p></p><a href="javascript:void(0);" class="refund_deposit btn btn-primary btn-xs" data-id_cust="$1"> <i class="fa fa-money"></i></a>
												          ', 'id_cust,nama,email,telepon,whatsapp,alamat,fix_alamat,nama_penerima,harga_udara,note');
		// $this->datatables->add_column('sudah_aktivasi', '$1','c_total_rmb(jumlah_rmb,jumlah_rmb2)');
    return $this->datatables->generate();
  }

	function get_tarik_dana(){
    $this->datatables->select('customer.id_cust,customer.kode,
															 tarik_dana.id_tarik_dana,tarik_dana.status,tarik_dana.tanggal_pengajuan,tarik_dana.nominal,rekening_pengguna.no_rek,rekening_pengguna.rekening,rekening_pengguna.an');
    $this->datatables->from('tarik_dana');
		$this->datatables->join('customer', 'customer.id_cust=tarik_dana.id_cust');
		$this->datatables->join('rekening_pengguna', 'customer.id_cust=rekening_pengguna.id_cust');
		$this->datatables->group_by('id_tarik_dana');
		$q="$1";
    $this->datatables->add_column('view', '<a href="javascript:void(0);" class="tarikd btn btn-primary btn-xs" data-id_tarik_dana="$3" data-nominal="$6"> <i class="fa fa-upload"></i></a>
												          ', 'id_cust,kode,id_tarik_dana,status,tanggal_pengajuan,nominal');
		// $this->datatables->add_column('sudah_aktivasi', '$1','sudah_aktivasi_cust(jumlah_rmb,jumlah_rmb2)');
    return $this->datatables->generate();
  }

	function customertidakfix() {
		$tgl = date('Y-m-d');
		$tglskrg = date("Y-m-d", strtotime("-50 days", strtotime($tgl)));
    $this->datatables->select('customer.nama,customer.kode,customer.alamat,customer.email,customer.id_cust');
    $this->datatables->from('giw');
		$this->datatables->join('customer','giw.customer_id=customer.id_cust','left');
		$this->datatables->join('container','giw.container_id=container.id_rts','left');
		$this->db->group_start();
			$this->db->where('customer.fix_alamat is null',null,false);
			$this->db->or_where('customer.id_provinsi','0');
			$this->db->or_where('customer.id_kota','0');
		$this->db->group_end();
		// $this->db->group_start();
		// 	$this->db->where('customer.fix_alamat',1);
		//   $this->db->where('customer.id_provinsi','0');
		// 	$this->db->where('customer.id_kota','0');
		// $this->db->group_end();
		$this->datatables->where('customer.id_cust >',0);
		$this->datatables->where('customer.s_aktivasi',"Sudah Aktivasi");
		$this->db->group_start();
			$this->db->where('container.status',4);
			$this->db->or_where('container.status',5);
		$this->db->group_end();
		if($this->session->userdata('level') == "crm"){
			$this->datatables->where('customer.id_crm',$this->session->userdata('id_pengguna'));
		}else if($this->session->userdata('level') == "suadmin"){

		}else if($this->session->userdata('level') == "spv"){
			$this->datatables->where('customer.id_crm',0);
		}else{
			$this->datatables->where('customer.id_crm',"-1");
		}
		$this->datatables->group_by('customer.id_cust');
		// $this->db->order_by('customer.id_cust','desc');
		$q="$1";
    // $this->datatables->join('kategori', 'barang_kategori_id=kategori_id
    $this->datatables->add_column('view', '<a href="'.site_url().'admin/customer/edit_customer/$1" target="_blank" class="btn btn-info btn-xs" alt="Update Data"> <i class="fa fa-edit"></i></a>

												          ', 'id_cust');
		// $this->datatables->add_column('sudah_aktivasi', '$1','sudah_aktivasi_cust(jumlah_rmb,jumlah_rmb2)');
    return $this->datatables->generate();
		// dd($this->db->get()->result());
  }

  function get_depositid($id) {
    $this->datatables->select('deposit.id_deposit,deposit.nominal_deposit,deposit.tipe_deposit,deposit.keterangan_deposit,deposit.id_cust,deposit.tanggal_deposit');
    $this->datatables->from('deposit');
    $this->datatables->where('deposit.id_cust',$id);
    //$this->datatables->join('kategori', 'barang_kategori_id=kategori_id');
    return $this->datatables->generate();
  }

	function get_depositidgrup($id) {
    $this->datatables->select('deposit.id_deposit,deposit.nominal_deposit,deposit.tipe_deposit,deposit.keterangan_deposit,deposit.id_cust,deposit.tanggal_deposit');
    $this->datatables->from('deposit');
    $this->datatables->where('deposit.id_cgrup',$id);
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
  	function save($f1,$f2)
  {
		// dd("sedang tidak bisa yoo");
		// Cek Crm
		 $cek_crm = $this->db->select('id_pengguna,nama_pengguna,whatsapp')->from('pengguna')
											 	 ->where('level','crm')->where('status',1)->where('status_sales',1)
												 ->get()->row();

												 // print_r($cek_crm->nama_pengguna);die();

			$markingudara = "WC-".$this->input->post('kode')."/AIR";
			$marking      = $this->input->post('markingdepan').$this->input->post('kode');
			if($this->input->post('id_referal') == 0 || $this->input->post('id_referal') == ""){
				$referal = 0;
			}else{
				$referal = $this->input->post('id_referal');
			}

			if($this->input->post('id_cgrup') == 0 || $this->input->post('id_cgrup') == ""){
				$id_cgrup = 0;
			}else{
				$id_cgrup = $this->input->post('id_cgrup');
			}
			$geteks = $this->db->where('id_ekspedisi',$this->input->post('id_ekspedisi'))->get('master_ekspedisi_lokal')->row();
			if($this->input->post('id_ekspedisi') >= 8 && $geteks->tipe_ekspedisi == "kirim"){
				$customer['id_provinsi2'] = $geteks->id_provinsi;
				$customer['id_kota2'] = $geteks->id_kota;
				$customer['id_kec2'] = $geteks->id_kec;
			}else{
				$customer['id_provinsi2'] = $this->input->post('id_provinsi');
				$customer['id_kota2'] = $this->input->post('id_kota');
				$customer['id_kec2'] = $this->input->post('id_kec');
			}
			$customer['id_referal'] = $referal;
      $customer['nama'] = $this->input->post('nama');
			$customer['id_cgrup'] = $id_cgrup;
      $customer['email'] = $this->input->post('email');
      $customer['telepon'] = $this->input->post('telepon');
      $customer['whatsapp'] = $this->input->post('whatsapp');
      $customer['alamat'] = $this->input->post('alamat');
			$customer['id_provinsi'] = $this->input->post('id_provinsi');
			$customer['id_kota'] = $this->input->post('id_kota');
			$customer['id_kec'] = $this->input->post('id_kec');
			$customer['nama_penerima'] = $this->input->post('nama_penerima');
      $customer['note'] = $this->input->post('note');
			$customer['id_ekspedisi'] = $this->input->post('id_ekspedisi');
			$customer['ekspedisi_lokal'] = $this->input->post('ekspedisi_lokal');
      $customer['kode'] = $marking;
			$customer['foto_ktp'] =$f1;
			$customer['foto_sk']  =$f2;
			$customer['tanggal_daftar']  =date('Y-m-d');
			$customer['harga_udara'] = $this->input->post('harga_udara');
			$customer['komisi_titip_trf'] = $this->input->post('komisi_titip_trf');
			$customer['komisi_barang'] = $this->input->post('komisi_barang');
			$customer['komisi_udara'] = $this->input->post('komisi_udara');
			$customer['fix_alamat'] = $this->input->post('fix_alamat');
			$customer['harga_otomatis'] = $this->input->post('harga_otomatis');
			if($this->session->userdata('level') == "crm"){
				$customer['id_pendaftar'] = 0;
				$customer['id_crm'] = $this->session->userdata('id_pengguna');
			}else{
				$customer['id_pendaftar'] = $this->session->userdata('id_pengguna');
				$customer['id_crm'] = $cek_crm->id_pengguna;
			}
			$customer['id_campaign'] = $this->input->post('id_campaign');
			$customer['s_aktivasi'] = "Sudah Aktivasi";
			$customer['jalur'] = $this->input->post('jalur');
      //Validasi Kode Mark
      $this->db->insert('customer', $customer);
      $last_id = $this->db->insert_id();
			// Login
			$psswrd = $this->random_password();
			$pengguna['id_cust'] 	= $last_id;
		  $pengguna['username'] 	= $marking;
		  $pengguna['password']   = md5($psswrd);
		  $pengguna['level'] 	= 0;
      $this->db->insert('pengguna_customer', $pengguna);

			// Antrian CRM
			$cek_crm_looping = $this->db->select('id_pengguna,status_sales')->from('pengguna')
													->where('level','crm')->where('status',1)
													->get()->result();
			foreach($cek_crm_looping as $cc){
				$max_crm = $this->db->select('id_pengguna')->from('pengguna')
														->where('level','crm')->where('status',1)
														->get()->num_rows();
				$status_crm_update=0;
				if($cc->status_sales == 1){
					$status_crm_update = $max_crm;
				}else{
					$status_crm_update = $cc->status_sales - 1;
				}
				// print_r($cc->status_sales);die();
				$upd_crm['status_sales'] = $status_crm_update;
				$this->db->where('id_pengguna',$cc->id_pengguna)->update('pengguna',$upd_crm);
			}
			$get_ekslok = $this->db->select('master_ekspedisi_lokal.*')->from('master_ekspedisi_lokal')
														 ->where('id_ekspedisi',$this->input->post('id_ekspedisi'))->get()->row();

			$nama = $this->input->post('nama');
			$email= "order@wilopocargo.com";
			$whatsapp= "6281299053976";
			$alamat= $this->input->post('alamat').' , '.$get_ekslok->nama_ekspedisi.'  '.$get_ekslok->alamat.'  '.$get_ekslok->no_telp;
			if($customer['jalur'] == 2){
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

			// get grup
			$get_grup = $this->db->where('id_cgrup',$id_cgrup)->get('customer_grup')->row();
			$the_message="<html>
													 <body>
																	 <h3>Yth. Bpk/Ibu ".$this->input->post('nama').",</h3>
																	 <p>Berikut kami lampirkan surat ketentuan & pernyataan untuk campaignan member Wilopo Cargo,
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
	    $this->email->to($this->input->post('email')); //email tujuan. Isikan dengan emailmu!
	    $this->email->subject('Surat Ketentuan & Pernyataan Pendaftaran Member Wilopo Cargo');
	    $this->email->message($the_message);

	    if($this->email->send())
	    {

	    }
	    else
	    {
	      //show_error($this->email->print_debugger());
	    }
			// $pesan_grup = "Yth. ".$get_grup->kode_cgrup.", \n\nPenambahan kode marking ".$marking." sukses ,".
  		// 					" Data kode marking baru telah di daftarkan kedalam grup anda."."\n\n*Wilopo Cargo* _(do not reply)_";
			//
	    // sendwhatsapp($pesan_grup,$get_grup->whatsapp_cgrup);

			$whatsapp = $this->input->post('whatsapp');
			$pesan1 = "Yth. ".$this->input->post('nama').", Selamat! Anda telah terdaftar sebagai member Wilopo Cargo. \n\nPertama-tama, harap save nomor ini di contact Whatsapp Anda,".
  							" karena kami akan mengirimkan data resi & status pengiriman barang, tagihan, dan berbagai informasi penting lainnya.";

	    sendwhatsapp($pesan1,$whatsapp);

      $pesan2 = "Kedua, kami sudah emailkan surat pernyataan dan ketentuan, harap dibaca dan diperhatikan dengan teliti, lalu tandatangani surat di atas materai Rp. 6000, ".
								"lalu di print dan kirim ke kantor kita via JNE/dll atau Gojek atau diantar sendiri. Berikut alamatnya: ".
								"\n\nWILOPO CARGO (Dwi)\nRukan Venice Blok B-85 Golf Lake Residence,\nJl. Kamal Raya Outer Ring Road, Cengkareng Timur\nJakarta Barat, 11730 - Indonesia \n(021) 22521995";
			sendwhatsapp($pesan2,$whatsapp);

      $pesan3 = "Kode Marking Anda adalah *".$marking."* (By SEA) dan *".$markingudara."* (By AIR). Sekarang, Anda sudah dapat mengirimkan barang Anda ke gudang kami dengan menyertakan kode marking ini pada kiriman Anda, berikut adalah list alamat gudang kami, baik udara maupun laut:";

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

      $pesan8 = "Apabila Anda memiliki pertanyaan atau masalah lebih lanjut, CSO (Customer Service Officer) kami siap melayani dengan senang hati. Anda dapat menanyakan apapun dan juga melakukan komplain apabila ada masalah. Berikut adalah kontak CSO kami: ".
      "\n\n$cek_crm->nama_pengguna\nWA: $cek_crm->whatsapp\n\natau bisa hubungi nomor kantor kami di\n\n021 2252 1995\n\nTerimakasih :)"."\n\n*Wilopo Cargo* _(do not reply)_";
			sendwhatsapp($pesan8,$whatsapp);

			$pesanlogin = "*Informasi Login User Dashboard*\n\nUsername : $marking\nPassword: $psswrd\n\nSilahkan Login di customer.wilopocargo.com \n\nTerimakasih :)"."\n\n*Wilopo Cargo* _(do not reply)_";
			sendwhatsapp($pesanlogin,$whatsapp);

			$image2a = $_FILES['foto_ktp'];
			$image2 = $_FILES['foto_ktp']['tmp_name'];
			$caption2 = "New Customer Wilopo Cargo \n\nNama : ".$this->input->post('nama')."\nKode Marking : ".$marking."\nAlamat : ".$this->input->post('alamat')."\nEmail : order@wilopocargo.com \nNo.Telepon : 6281299053976";
			$captionudara2 = "New Customer Wilopo Cargo \n\nNama : ".$this->input->post('nama')."\nKode Marking : ".$markingudara."\nAlamat : ".$this->input->post('alamat')."\nEmail : order@wilopocargo.com \nNo.Telepon : 6281299053976";

			sendimagelocal($caption2,'6281293488636',$image2,$image2a);
			sendwhatsapp($caption2,'6281293488636');

			// sendimagelocal($captionudara2,'08111353711',$image2,$image2a);
			// sendwhatsapp($captionudara2,'08111353711');

			$pesan_crm = "New Customer Wilopo Cargo \n\nNama : ".$this->input->post('nama')."\nKode Marking : ".$marking."\nNo.Whatsapp : $whatsapp";
			sendwhatsapp($pesan_crm,$cek_crm->whatsapp);

			// print_r($cek_crm);die();
      $this->session->set_flashdata('msg','success');
			// var_dump($image2);die();
      redirect(site_url('admin/customer'));

  }

  //Proses Update Data Customer
  function update($f1,$f2)
  {
			// print_r($this->input->post());die();
			$idcustomer = $this->input->post('id_cust');
			$getcustomer = $this->db->where('id_cust',$idcustomer)->get('customer')->row();
			if($this->input->post('id_referal') == 0 || $this->input->post('id_referal') == ""){
				$referal = 0;
			}else{
				$referal = $this->input->post('id_referal');
			}
			if($this->input->post('id_cgrup') == 0 || $this->input->post('id_cgrup') == ""){
				$id_cgrup = 0;
			}else{
				$id_cgrup = $this->input->post('id_cgrup');
			}
			$geteks = $this->db->where('id_ekspedisi',$this->input->post('id_ekspedisi'))->get('master_ekspedisi_lokal')->row();
			if($this->input->post('id_ekspedisi') >= 8 && $geteks->tipe_ekspedisi == "kirim"){
				$customer['id_provinsi2'] = $geteks->id_provinsi;
				$customer['id_kota2'] = $geteks->id_kota;
				$customer['id_kec2'] = $geteks->id_kec;
			}else{
				$customer['id_provinsi2'] = $this->input->post('id_provinsi');
				$customer['id_kota2'] = $this->input->post('id_kota');
				$customer['id_kec2'] = $this->input->post('id_kec');
			}
			$customer['id_referal'] = $referal;
      $customer['nama'] = $this->input->post('nama');
			$customer['id_cgrup'] = $id_cgrup;
			$customer['nama_penerima'] = $this->input->post('nama_penerima');
      $customer['email'] = $this->input->post('email');
      $customer['telepon'] = $this->input->post('telepon');
      $customer['whatsapp'] = $this->input->post('whatsapp');
      $customer['alamat'] = $this->input->post('alamat');
			$customer['ekspedisi_lokal'] = $this->input->post('ekspedisi_lokal');
			$customer['id_ekspedisi'] = $this->input->post('id_ekspedisi');
      $customer['note'] = $this->input->post('note');
			$customer['id_provinsi'] = $this->input->post('id_provinsi');
			$customer['id_kota'] = $this->input->post('id_kota');
			$customer['id_kec'] = $this->input->post('id_kec');
			$nama_penerima = $this->input->post('nama_penerima');
			$telepon = $this->input->post('whatsapp');
			$alamat  = $this->input->post('alamat')." , ".$this->input->post('ekspedisi_lokal');
      $kode    = $getcustomer->kode;
			$customer['foto_ktp'] =$f1;
			$customer['foto_sk']  =$f2;
			$customer['harga_udara'] = $this->input->post('harga_udara');
			$customer['komisi_titip_trf'] = $this->input->post('komisi_titip_trf');
			$customer['komisi_barang'] = $this->input->post('komisi_barang');
			$customer['komisi_udara'] = $this->input->post('komisi_udara');
			$customer['fix_alamat'] = $this->input->post('fix_alamat');
			$customer['harga_otomatis'] = $this->input->post('harga_otomatis');
			$customer['jalur'] = $this->input->post('jalur');
			$jalur = $this->input->post('jalur');
			$customer['id_campaign'] = $this->input->post('id_campaign');
			if($getcustomer->id_cgrup == 0 || $getcustomer->id_cgrup == ""){
				$this->db->where('id_cust',$this->input->post('id_cust'));
	      $this->db->update('customer', $customer);
			}else{
				$this->db->where('id_cgrup',$getcustomer->id_cgrup);
	      $this->db->update('customer', $customer);
			}

			$curl_handle=curl_init();
			curl_setopt($curl_handle,CURLOPT_URL,'https://office.rtsekspedisi.com/api/a_customer/edit_alamat');
			curl_setopt($curl_handle, CURLOPT_POST, 1);
			curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "kode=$kode&alamat=$alamat&telepon=$telepon&nama_penerima=$nama_penerima&jalur=$jalur");
			$res = curl_exec($curl_handle);
			curl_close($curl_handle);

			if($customer['fix_alamat'] == 1){
				$get_datainvoicebelumfix = $this->db->where('status_boleh_kirim',3)->where('id_cust',$this->input->post('id_cust'))->get('invoice')->result();
				foreach($get_datainvoicebelumfix as $blmfix){
					$getinv = $this->db->select('invoice.id_invoice,customer.fix_alamat,invoice.kode_invoice,customer.kode,invoice.tanggal_invoice,customer.id_cust,
																			 surat_jalan.no_sj,customer.alamat,customer.whatsapp,customer.ekspedisi_lokal,customer.nama,
																			 pengguna.whatsapp,crm.whatsapp as wacrm,customer.whatsapp as wacs')
														 ->from('invoice')
														 ->join('customer', 'invoice.id_cust=customer.id_cust', 'left')
														 ->join('pengguna', 'pengguna.id_pengguna=customer.id_pendaftar')
														 ->join('pengguna as crm', 'crm.id_pengguna=customer.id_crm')
														 ->join('surat_jalan', 'surat_jalan.id_surat_jalan=invoice.id_surat_jalan', 'left')
														 ->where('id_invoice',$blmfix->id_invoice)
														 ->get()->row();
														 // print_r($getinv);die();
					 $resi_list = $this->db->select('resi.nomor as nomor_resi')->from('invoice_product')
																 ->join('giw', 'invoice_product.id_giw=giw.id')
																 ->join('resi', 'giw.resi_id=resi.id_resi')
																 ->group_by('resi.id_resi')
																 ->where('invoice_product.id_invoice',$getinv->id_invoice)
																 ->get();
					 $resilist = "";
 		      foreach ($resi_list->result() as $re_list) {
 		        if($resi_list->num_rows() > 1){
 		         $resilist .=  $re_list->nomor_resi.",";
 		       }else{
 		         $resilist = $re_list->nomor_resi;
 		       }
 		      }

					$pesan  = "Informasi Alamat ".$resilist."\n".$getinv->kode."\n".$getinv->nama."\n".
										"".$getinv->wacs."\n\n".$getinv->alamat.','.$getinv->ekspedisi_lokal;
					// Whatsapp Pengiriman
					// sendwhatsapp("FIXXXXX".$pesan,'083815423599');
					whatsapp_grup("1554363574",$pesan,"6281293972529");
				}

				$updinvoice['status_boleh_kirim'] = 1;
				$updinvoice['tanggal_kasih_alamat'] = date('Y-m-d');
				$this->db->where('status_boleh_kirim',3)->where('id_cust',$this->input->post('id_cust'))->update('invoice',$updinvoice);

				$updgiw['boleh_kirim'] = 2;
				$this->db->where('boleh_kirim',1)->where('customer_id',$this->input->post('id_cust'))->update('giw',$updgiw);
			}

      $this->session->set_flashdata('msg','updated');
      redirect($_SERVER['HTTP_REFERER']);
  }

	function random_password(){
		$chars = array(
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
        'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
        'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '?', '!', '@', '#',
        '$', '%', '&', '*', '(', ')', '[', ']', '{', '}', '=', '+'
    );

    shuffle($chars);

    $num_chars = count($chars) - 70;
    $token = '';

    for ($i = 0; $i < $num_chars; $i++){ // <-- $num_chars instead of $len
        $token .= $chars[mt_rand(0, $num_chars)];
    }

    return $token;
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
		$marking      = $datacust->kode;
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
							"\n\n广州市，白云区，石井镇鸦岗大道黄金围金围东路，东方工业区4号仓，空运部".
							"\n联系人 何归先生 : (+86) 139-2219-5756 / 02081008446 送货带装箱单、订单".
							"\n包装要求：纸箱套袋， 注明客户唛头。".
							"\n麦头 : /AIR".
							"\nGuangzhou city, Baiyun district, shijing town ,ya gang , huang jin wei road ，dong fang industry area warehouse no.4 ".
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

	public function select_customer($kode){
    $this->db->select('id_cust,kode');
    $this->db->limit(10);
    $this->db->from('customer');
    $this->db->like('kode', $kode);
    return $this->db->get()->result_array();
  }


}
