<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){
    parent::__construct();

		cek_session(); //cek session Login
		// $this->load->model('Mtbank');
		// $this->load->model('Mrmb');
		// $this->load->model('Mlaporan');
		//$this->load->model('files');
	}

	//Function Page After Login
	function index(){
    // var_dump($iduser);
	  $idcust=$this->session->userdata('id_cust');
		$parse['cek_customerr'] = $this->db->select('id_cust,status_ganti_marking,kode')->from('customer')->where('id_cust',$idcust)->get()->row();

		$parse['lv']=$this->db->select('y_video.id')->from('y_video')->order_by('title', 'ASC')->get()->result();
		$parse['jumditonton']='';
		$parse['jumditonton']=$this->db->select('count(id) as jumlahnya')->from('status_tonton')
			->where('id_cust',$idcust)
			->get()->row();
		$idtonton=$this->db->select('status_tonton.videoid, y_video.id_kategori_video, y_video.no_urut')->from('status_tonton')->join('y_video', 'status_tonton.videoid=y_video.videoId', 'left')->where('id_cust', $idcust)->order_by('status_tonton.id', 'desc')->get()->row();
		if(isset($idtonton->videoid)){
		    $kateg=$idtonton->id_kategori_video;
		    $urutnya=$idtonton->no_urut;
		}else{
		   $idtonton=array();
		   $kateg=0;
		    $urutnya=0;
		}

		$cekada=$this->db->select('y_video.videoId')->from('y_video')->join('status_tonton', 'y_video.videoId=status_tonton.videoid', 'left')->where('y_video.id_kategori_video', $kateg)->where('y_video.no_urut >', $urutnya)->order_by('y_video.title', 'ASC')->get()->row();
		if(isset($cekada->videoId)){
		    $dcekada=$cekada->videoId;
		}else{
		    $dcekada='';
		    $cekada=array();
		}
		$parse['lj']=array();
		if($dcekada !=''){
		    $parse['lj']=$this->db->select('y_video.id, kategori_video.judul')->from('y_video')->join('status_tonton', 'y_video.videoId=status_tonton.videoid', 'left')->join('kategori_video', 'y_video.id_kategori_video=kategori_video.id', 'left')->where('y_video.id_kategori_video', $kateg)->where('y_video.no_urut >', $urutnya)->order_by('y_video.title', 'ASC')->get()->row();
		}else if(!isset($idtonton->videoid)){
		    $parse['lj']=$this->db->select('y_video.id, kategori_video.judul')->from('y_video')->join('status_tonton', 'y_video.videoId=status_tonton.videoid', 'left')->join('kategori_video', 'y_video.id_kategori_video=kategori_video.id', 'left')->order_by('kategori_video.id', 'ASC')->order_by('y_video.no_urut', 'ASC')->get()->row();
		}else{
		    $parse['lj']=$this->db->select('y_video.id, kategori_video.judul')->from('y_video')->join('status_tonton', 'y_video.videoId=status_tonton.videoid', 'left')->join('kategori_video', 'y_video.id_kategori_video=kategori_video.id', 'left')->where('y_video.id_kategori_video >', $kateg)->order_by('y_video.title', 'ASC')->get()->row();
		}

		$parse['invjumlah']=$this->db->select('sum(total_tagihan-jumlah_bayar) as jumlahnya')->from('invoice')->where('id_cust',$idcust)->where('status_invoice',0)->get()->row();
		$parse['resi']=$this->db->select('count(resi.id_resi) as jumlahnya')->from('resi')->join('giw','resi.id_resi=giw.resi_id')->where('giw.tanggal_berangkat is NOT NULL', NULL, FALSE)->where('resi.cust_id',$idcust)->get()->row();
		$parse['saldomasuk']=$this->db->select('sum(deposit.nominal_deposit) as jumlahnya')->from('deposit')->where('deposit.id_cust',$idcust)->where('deposit.tipe_deposit','masuk')->get()->row();
		$parse['saldokeluar']=$this->db->select('sum(deposit.nominal_deposit) as jumlahnya')->from('deposit')->where('deposit.id_cust',$idcust)->where('deposit.tipe_deposit','keluar')->get()->row();
		$parse['deposit']=$this->db->select('customer.deposit as jumlah')->from('customer')->where('customer.id_cust',$idcust)->get()->row();
		$parse['pending']=$this->db->select('count(id_transaksi) as jumlahnya')->from('transaksi')->where('status',1)->where('id_cust',$idcust)->get()->row();
	  $this->template->load('template_dashboard','dashboard/home/home',$parse);

  }

	function save_ganti_marking(){
	    $temp1 = explode(".", $_FILES['foto_ktp']['name']);
		$new_name1 = time().'.'.end($temp1);
		$config1['upload_path'] = '../office/assets/foto_ktp/';
		$config1['file_name'] = $new_name1;
		$config1['allowed_types'] = 'jpg|jpeg|png|pdf';
		$this->load->library('upload');
		$this->upload->initialize($config1);
		if(!$this->upload->do_upload('foto_ktp')){
			$this->upload->display_errors();
			$new_name1 = "";
		}
		$customer['kode'] = "123/WC-".$this->input->post('marking_baru');
// 		$customer['nama'] = $this->input->post('nama');
		$customer['nama_penerima'] = $this->input->post('nama_penerima');
// 		$customer['telepon'] = $this->input->post('telepon');
		$customer['whatsapp'] = $this->input->post('whatsapp');
		$customer['alamat'] = $this->input->post('alamat');
		$customer['fix_alamat'] = $this->input->post('fix_alamat');
// 		$customer['ekspedisi_lokal'] = $this->input->post('ekspedisi_lokal');
		$customer['foto_ktp'] = $new_name1;
		$customer['status_ganti_marking'] = 2;
		$this->db->where('id_cust',$this->input->post('id_cust'))->update('customer',$customer);

		$pengcus['username'] = "123/WC-".$this->input->post('marking_baru');
		$this->db->where('id_cust',$this->input->post('id_cust'))->update('pengguna_customer',$pengcus);

		$markingudara = "WC-".$this->input->post('marking_baru')."/AIR";
		$marking      = "123/WC-".$this->input->post('marking_baru');

		$getcustomer = $this->db->where('id_cust',$this->input->post('id_cust'))->get('customer')->row();
		// whatsapp
		$the_message="<html>
												 <body>
																 <h3>Yth. Bpk/Ibu ".$getcustomer->nama.",</h3>
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
		$this->email->to($getcustomer->email); //email tujuan. Isikan dengan emailmu!
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

		$whatsapp = $getcustomer->whatsapp;
		$pesan1 = "Yth. ".$getcustomer->nama.", Selamat! Anda telah terdaftar sebagai member Wilopo Cargo. \n\nPertama-tama, harap save nomor ini di contact Whatsapp Anda,".
							" karena kami akan mengirimkan data resi & status pengiriman barang, tagihan, dan berbagai informasi penting lainnya.";

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

		$image2a = $_FILES['foto_ktp'];
		$image2 = $_FILES['foto_ktp']['tmp_name'];
		$caption2 = "New Customer Wilopo Cargo \n\nNama : ".$getcustomer->nama."\nKode Marking : ".$marking."\nAlamat : ".$getcustomer->alamat."\nEmail : order@wilopocargo.com \nNo.Telepon : 081293972529";
		$captionudara2 = "New Customer Wilopo Cargo \n\nNama : ".$getcustomer->nama."\nKode Marking : ".$markingudara."\nAlamat : ".$getcustomer->alamat."\nEmail : order@wilopocargo.com \nNo.Telepon : 081293972529";

		// sendimagelocal($caption2,'081317518779',$image2,$image2a);
		// sendwhatsapp($caption2,'081317518779');
		//
		// sendimagelocal($captionudara2,'08111353711',$image2,$image2a);
		// sendwhatsapp($captionudara2,'08111353711');

			$this->session->set_userdata('kode',"123/WC-".$this->input->post('marking_baru'));
			$this->session->set_userdata('status_ganti_marking',2);

		$this->session->set_flashdata('msg','success');
		redirect('dashboard');
	}

}
