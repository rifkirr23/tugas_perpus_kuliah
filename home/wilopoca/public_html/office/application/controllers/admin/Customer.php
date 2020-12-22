<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		cek_session(); //cek session User Login
		$this->load->model('Mcustomer'); //Load Model Customer
		$this->load->model('Mtransaksi'); //Load Model Customer
		$this->load->model('Minvoice'); //Load Model Customer
		$this->load->model('Mpembayaran'); //Load Model Customer
		$this->load->model('Mjenis_barang_customer'); //Load Model Customer
		$this->load->model('Mapiinvoice');
		$this->load->model('Mkomisi_referal');
		$this->load->model('Mbarang');
	}

	//Function Test Api Wablas aja
	function test_whatsapp(){
		sendwhatsapp("tes","083815423599");die();
		$curl = curl_init();
    $token = "I3BrgPiHQXI4svgBjmJrDVRssanjtHzOcIjEaC8bfCDYOfYcDYkx7ZvJk9Rvpkaf";
    $data = [
        'groupId' => '6283807393023',
        'phone' => '6283815423599',
        'message' => 'tesaja',
    ];

    curl_setopt($curl, CURLOPT_HTTPHEADER,
        array(
            "Authorization: $token",
        )
    );
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_URL, "https://simo.wablas.com/api/send-group");
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($curl);
    curl_close($curl);
    echo "<pre>";
    print_r($result);
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

	//Function Test Api Wablas aja
	function test_api(){
		// sendwhatsapp("whatsapp Grup Pengiriman","083815423599");
		// sendimage("tes","083815423599","https://office.wilopocargo.com/assets/foto_ktp/1564114467.png");
		// $tanggal_kasih_alamat  = strtotime("2020-05-29");
		// $tanggal_invoice    = strtotime("2020-04-08");
		// $diff   = $tanggal_kasih_alamat - $tanggal_invoice;
		// $jumlah_hari = floor($diff / (60 * 60 * 24)) - 7 ;// diskon 7 hari
		// $month = date("m",strtotime("2020-06-01"));
		// $cek_cbm = $this->db->select('sum(ctns*volume) as jumlah')->from('giw')
		// 										->join('resi','giw.resi_id=resi.id_resi','left')
		// 										->where('giw.customer_id',321)
		// 										->where('month(resi.tanggal)',$month)
		// 										->get()->row();
		// for($i=1; $i<=12; $i++){
		//
    // }
		// foreach ($arr as $value) {
		//     // $value = $value * 2;
		// 		echo $value->;
		// }
		// $dataresi   = $this->db->select('month(resi.tanggal) as bulan,giw.resi_id')->from('invoice_product')->join('giw','giw.id=invoice_product.id_giw','left')
		// 											 ->join('resi','resi.id_resi=giw.resi_id','left')->where('invoice_product.id_invoice_beli',1698)
		// 											 ->group_by("month(resi.tanggal)")
		// 											 ->get()->result();
		// print_r($dataresi);die();
		// $id_cust = "1010" ;
		// $bulanwoi = "06";
		// $sql_update_giw = "UPDATE giw JOIN resi ON resi.id_resi = giw.resi_id SET giw.status_pembulatan = 0 WHERE giw.customer_id = $id_cust and month(resi.tanggal) = '$bulanwoi' ";
		// $this->db->query($sql_update_giw);
		// $arraynya = $cars = array("Volvo", "BMW", "Toyota");
		// $getcust = $this->db->query('SELECT *, COUNT(*)
		// 															FROM pengguna
		// 															where pengguna.level = "saleso" and whatsapp is not null
		// 															GROUP BY status_sales
		// 															HAVING ( COUNT(status_sales) > 1 )')->num_rows();
		// if($getcust > 0){
		//
		// }
		// $hitungsaleso = $this->db->where('level','saleso')->where('status',1)->where('whatsapp is not null',null,false)->get('pengguna')->num_rows();
		// dd($hitungsaleso);
		// $getresifile = $this->db->select('*')->from('file_packing')->where('nomor_resi !=',"")->where('status_update',0)->group_by('nomor_resi')->limit(250)->get()->result();
		// // dd($getresifile);
		// foreach($getresifile as $recordresi){
		// 	$ins_file['nomor_resi'] = $recordresi->nomor_resi ;
		// 	$ins_file['kode_marking'] = $recordresi->kode_marking ;
		// 	$this->db->insert('file_packing_resi',$ins_file);
		// 	$last_id_fpr = $this->db->insert_id();
		//
		// 	$updfile['id_fp_resi'] = $last_id_fpr;
		// 	$updfile['status_update'] = 1;
		// 	$this->db->where('nomor_resi',$recordresi->nomor_resi)->update('file_packing',$updfile);
		// }
		// $cekresi = $this->db->select('resi.*')
		// 								->from('resi')
		// 								->join('giw','resi.id_resi=giw.resi_id','left')
		// 								->where_in('giw.jenis_barang_id', ['18','19','20','21','22','28','33','34','37','38'])
		// 								->where('konfirmasi_resi',2)
		// 								->where('resi.tanggal >=',"2020-08-17")
		// 								->where('resi.tanggal <=',"2020-08-18")
		// 								->group_by('resi.id_resi')
		// 								->get()->result();
		// 								// dd($cekresi);
		// 								foreach ($cekresi as $rowresi) {
		// 									$curl_handle=curl_init();
		// 			            curl_setopt($curl_handle,CURLOPT_URL,"https://office.rtsekspedisi.com/api/a_resi/konfirmasi");
		// 			            curl_setopt($curl_handle, CURLOPT_POST, 1);
		// 			            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "jalur=0&eid=$rowresi->encrypt_resi&jalur_cepat=1");
		// 			            $curlemail = curl_exec($curl_handle);
		// 			            curl_close($curl_handle);
		// 								}
									// $tes = 	$extension=end(explode(".", "tesaja.pdf"));
									// $bulanisebelumnya = date('m') - 1;
					        // $tglsblmnya = date("Y-".$bulanisebelumnya."-01");
									// dd($tglsblmnya);
									// $allcont = array();
									// $getcont = $this->db->select('id_rts')->from('container')->get()->result();
									// foreach($getcont as $gc){
									// 	echo $gc->id_rts.",";
									// }
									// $db2 = $this->load->database('db2', TRUE);
									// $datagiwcont = $db2->select('giw.nomor,container_id,resi.nomor as nomor_resi')
									// 										->from('giw')
									// 										->join('customer', 'giw.customer_id=customer.id','left')
									// 										->join('resi', 'giw.resi_id=resi.id','left')
									// 										->where('giw.container_id',861)
									// 										->where('customer.broker_id',30)
									// 										->get();
									// $hitunggiw = $datagiwcont->num_rows();
									// $giwnya = array();
									// foreach($datagiwcont->result() as $dgc){
									// 	$giwnya[] = $dgc->nomor;
									// 	$cekgiwilopo = $this->db->select('giw.nomor')
									// 													->from('giw')
									// 													->where('nomor',$dgc->nomor)
									// 													->get()
									// 													->row();
									// 	if($cekgiwilopo->nomor == null || $cekgiwilopo->nomor == ""){
									// 		$insertsesuaikan['nomor_resi']= $dgc->nomor_resi;
						      //     $insertsesuaikan['nomor']= $dgc->nomor;
						      //     $insertsesuaikan['status_sesuaikan']= 0;
						      //     $this->db->insert('sesuaikan_giw', $insertsesuaikan);
									// 	}
									// }
									// $updgiwnya['container_id']= 861;
									// $this->db->where_in('nomor',$giwnya)->update('giw', $updgiwnya);
									// $cekvolumeinv   = $this->db->select('sum(invoice_product.jumlah * giw.volume) as cbm')
						      //                            ->from('invoice_product')
						      //                            ->join('giw','giw.id=invoice_product.id_giw','left')
						      //                            ->where('invoice_product.id_invoice_beli',4987)
						      //                            ->get()->row();
									// dd($cekvolumeinv->cbm);
									$kemarintgl = date('Y-m-d', strtotime('-1 days', strtotime(date('Y-m-d'))));
									echo $kemarintgl;
									// dd($jumlah_hari);
 				 	         //
								 // $cektambahan   = $this->db->where('id_invoice',6950)
								 // 													 ->like('keterangan_potongan',"RESI-20-19238")
									// 												 ->get('potongan')->result();dd($cektambahan);
	}

	//Function Test Api Wablas aja
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

	//Function Halaman Awal Menu Customer
	function index(){
		$data['campaign'] = $this->db->where('id_campaign >',0)->get('campaign')->result();
		$data['data_ekspedisi'] = $this->db->order_by('id_ekspedisi','asc')->get('master_ekspedisi_lokal')->result();
		$data['provinsi'] = $this->db->get('provinsi')->result();
		$this->template->load('template','admin/customer/customer',$data);
	}

	function excel_customer(){
		$data['customer'] = $this->db->select('customer.nama,customer.email,kabupaten.nama as namakota,customer.tanggal_daftar')
																 ->join('kabupaten', 'customer.id_kota=kabupaten.id_kab', 'left')
																 ->where('tanggal_daftar >=',"2020-06-01")->get('customer')->result();
		$this->load->view('admin/customer/customer_excel',$data);
	}

	function index_10cbm(){
		$bulan = date('m');
		$tahun = date('Y');
		$data['data_customer'] = $this->db->query('SELECT cbm , kode , nama , email , alamat ,bulan_barang,tahun_barang
															FROM (SELECT sum(volume * ctns) as cbm ,kode,nama,email,alamat,month(resi.tanggal) as bulan_barang,Year(resi.tanggal) as tahun_barang FROM `giw`
															left join customer on customer.id_cust = giw.customer_id
															left join resi on resi.id_resi = giw.resi_id
															group by customer_id) a
															where cbm > 10 and bulan_barang="'.$bulan.'" and tahun_barang="'.$tahun.'" ')->result();
		$this->template->load('template','admin/customer/customer_10cbm',$data);
	}

	//Function Get data Json Customer
	function get_customer_json() {//data data Customer by JSON object
    header('Content-Type: application/json');
    echo $this->Mcustomer->get_customer();
  }


	function get_customerid_json() {//data data Customer by JSON object
		$id=$this->uri->segment(4);
    header('Content-Type: application/json');
    echo $this->Mcustomer->get_customer_byid($id);
  }

	function get_customercg_json() {//data data Customer by JSON object
		$cg=$this->uri->segment(4);
    header('Content-Type: application/json');
    echo $this->Mcustomer->get_customer_bycg($cg);
  }

	// Function Deposit Customer
  function get_depositid_json() {//data data Deposit by JSON object
    header('Content-Type: application/json');
    $id=$this->uri->segment(4);
    echo $this->Mcustomer->get_depositid($id);
  }

	function get_depositidgrup_json() {//data data Deposit by JSON object
    header('Content-Type: application/json');
    $id=$this->uri->segment(4);
    echo $this->Mcustomer->get_depositidgrup($id);
  }

	//Function Halaman Awal Menu Customer
	function index_tidakfix(){
		$this->template->load('template','admin/customer/tidakfix');
	}

	function get_tidakfix_json() {//data data Customer by JSON object
    header('Content-Type: application/json');
    echo $this->Mcustomer->customertidakfix();
  }

    //Function View Image (Ktp,Sk) Customer
    function view_image(){
     $id= $this->uri->segment(4);
     $file1= $this->Mcustomer->get_id2($id)->row_array();
     include APPPATH. 'views/admin/customer/view_image.php';
    }

    //Function Edit Customer
    function edit_customer(){
     $id = $this->uri->segment(4);
     $data['data_cust'] = $this->db->select('customer.*,kabupaten.nama as nama_kota,kecamatan.nama as nama_kecamatan,provinsi.nama as nama_provinsi')
		 															 ->from('customer')
																	 ->join('provinsi', 'customer.id_provinsi=provinsi.id_prov')
																	 ->join('kabupaten', 'customer.id_kota=kabupaten.id_kab')
																	 ->join('kecamatan', 'customer.id_kec=kecamatan.id_kec')
																	 ->where('id_cust',$id)->get()->row();//dd($data['data_cust']);
		 $data['campaign'] = $this->db->where('id_campaign >',0)->get('campaign')->result();
 		 $data['provinsi'] = $this->db->get('provinsi')->result();
		 $data['cust_referal'] = $this->db->where('id_cust >',0)->get('customer')->result();
     $data['cust_grup'] = $this->db->where('id_cgrup >',0)->get('customer_grup')->result();
		 $data['data_ekspedisi'] = $this->db->order_by('id_ekspedisi','asc')->get('master_ekspedisi_lokal')->result();
		 $this->template->load('template','admin/customer/edit_customer',$data);
    }

		function akun_customer(){
     $id= $this->uri->segment(4);
     $data_cust = $this->db->where('id_cust',$id)->get('customer')->row();
		 $cek_akun = $this->db->where('id_cust',$id)->get('pengguna_customer')->num_rows();
     include APPPATH. 'views/admin/customer/akun_customer.php';
    }

		function add_crm(){
			$data['customer'] = $this->db->select('customer.id_cust,tanggal_daftar,kode,nama,email,customer.whatsapp,alamat,pengguna.nama_pengguna,
																				 customer.s_aktivasi,campaign.kode_campaign,crm.nama_pengguna as nama_crm')
											    		 ->from('customer')
															 ->where('id_crm',0)
															 ->where('s_aktivasi',"Sudah Aktivasi")
															 ->join('pengguna', 'pengguna.id_pengguna=customer.id_pendaftar')
															 ->join('pengguna as crm', 'crm.id_pengguna=customer.id_crm')
															 ->join('campaign', 'campaign.id_campaign=customer.id_campaign')
															 ->get()->result();
      $data['crm'] = $this->db->where('level','crm')->get('pengguna')->result();
	    $this->template->load('template','admin/customer/add_crm',$data);
		}

		function save_crm(){
			// dd($this->input->post());
			if($this->input->post('id_cust') == "" || $this->input->post('id_cust') == null){
				$this->session->set_flashdata('msg','nocheckbox');
				redirect(site_url('admin/customer/add_crm'));
			}
			$customer = $this->db->where_in('id_cust',$this->input->post('id_cust'))->get('customer')->result();
			foreach($customer as $cust){
				$updcrm['id_crm'] = $this->input->post('id_crm');
				$this->db->where('id_cust',$cust->id_cust)->update('customer',$updcrm);
			}
			$this->session->set_flashdata('msg','oksave');
			redirect(site_url('admin/customer/add_crm'));
		}

		function save_nosk(){
			// dd($this->input->post());
			if($this->input->post('id_cust') == "" || $this->input->post('id_cust') == null){
				$this->session->set_flashdata('msg','nocheckbox');
				redirect(site_url('admin/customer/no_sk'));
			}
			$customer = $this->db->where_in('id_cust',$this->input->post('id_cust'))->get('customer')->result();
			foreach($customer as $cust){
				$updcrm['status_sk'] = "sudah";
				$updcrm['tanggal_sk'] = date('Y-m-d');
				$this->db->where('id_cust',$cust->id_cust)->update('customer',$updcrm);
			}
			$this->session->set_flashdata('msg','oksave');
			redirect(site_url('admin/customer/no_sk'));
		}

		function no_sk(){
			$data['customer'] = $this->db->select('customer.id_cust,tanggal_daftar,kode,nama,email,customer.whatsapp,alamat,pengguna.nama_pengguna,
																				 customer.s_aktivasi,campaign.kode_campaign,crm.nama_pengguna as nama_crm')
											    		 ->from('customer')
															 ->where('status_sk is null',null,false)
															 ->where('s_aktivasi',"Sudah Aktivasi")
															 ->join('pengguna', 'pengguna.id_pengguna=customer.id_pendaftar')
															 ->join('pengguna as crm', 'crm.id_pengguna=customer.id_crm')
															 ->join('campaign', 'campaign.id_campaign=customer.id_campaign')
															 ->order_by('id_cust','asc')
															 // ->limit(500)
															 ->get()->result();
	    $this->template->load('template','admin/customer/no_sk',$data);
		}

		function buat_akun(){
			$id_cust = $this->input->post('id_cust');
			$password = $this->random_password();
			$get_customer = $this->db->where('id_cust',$id_cust)->get('customer')->row();
			$input_pengguna['id_cust'] = $get_customer->id_cust;
			$input_pengguna['username'] = $get_customer->kode;
			$input_pengguna['password'] = md5($password);
			$input_pengguna['last_login'] = date("Y-m-d H:i:s");
			$input_pengguna['count'] = 0;
			$input_pengguna['level'] = 1;
			$this->db->insert('pengguna_customer',$input_pengguna);
			$pesan = "*Informasi Login User Dashboard*\n\nUsername : $get_customer->kode\nPassword:$password\n\nTerimakasih :)"."\n\n*Wilopo Cargo* _(do not reply)_";
			sendwhatsapp($pesan,$get_customer->whatsapp);
			$this->session->set_flashdata('msg','buatakun');
			redirect(site_url('admin/customer'));
			// print_r($password."<br />".$input_pengguna['password']);die();
		}

		function new_password(){
			$id_cust  = $this->input->post('id_cust');
			$password = $this->random_password();
			$get_customer = $this->db->where('id_cust',$id_cust)->get('customer')->row();
			$update_user['password'] = md5($password);
			$this->db->where('id_cust',$id_cust)->update('pengguna_customer',$update_user);
			$pesan = "*Informasi Login User Dashboard*\n\nUsername : $get_customer->kode\nPassword: $password\n\nTerimakasih :)"."\n\n*Wilopo Cargo* _(do not reply)_";
			sendwhatsapp($pesan,$get_customer->whatsapp);
			$this->session->set_flashdata('msg','newpw');
			redirect(site_url('admin/customer'));
			// print_r($password."<br />".$input_pengguna['password']);die();
		}

	// Function Detail Customer
  function detail(){
    $id = $this->uri->segment(4);
		$segment = $this->uri->segment(5);
		$bulanini  = bulan_angka(date('m'));
		$tahun_ini = date('Y');
		$parse['data_giw'] = $this->db->select('sum(giw.volume * giw.ctns) as cbm')->from('giw')->join('customer','giw.customer_id=customer.id_cust','left')
													 ->join('resi','giw.resi_id=resi.id_resi','left')
													 ->where('month(resi.tanggal)',$bulanini)->where('year(resi.tanggal)',$tahun_ini)->where('customer.id_cust',$id)
													 ->get()->row();
	  $parse['all_giw'] = $this->db->select('sum(giw.volume * giw.ctns) as cbm')->from('giw')->join('customer','giw.customer_id=customer.id_cust','left')
													 ->join('resi','giw.resi_id=resi.id_resi','left')
													 ->where('customer.id_cust',$id)
													 ->get()->row();
		$parse['detail'] = 1; //Set Detail = 1 Untuk di view/template.php
    $parse['r']=$this->Mcustomer->get_id2($id)->row();
		$parse['jenis_barang_customer']=$this->db->where('id_cust',$id)->get('jenis_barang_customer')->num_rows();
		$parse['rowjenisbarang']=$this->db->where('id_cust',$id)->from('jenis_barang_customer')->get()->result();
		$parse['invoice_barang'] = $this->db->select('sum(total_tagihan - jumlah_bayar) as total_semua_tagihan')->where('tipe_invoice','barang')
																				->where('id_cust',$id)->from('invoice')->get()->row();
		$parse['invoice_titip_transfer'] = $this->db->select('sum(total_tagihan - jumlah_bayar) as total_semua_tagihan')->where('tipe_invoice','tt')
																								->where('id_cust',$id)->from('invoice')->get()->row();
		$parse['invoice_udara'] = $this->db->select('sum(total_tagihan - jumlah_bayar) as total_semua_tagihan')->where('tipe_invoice','air')
																				->where('id_cust',$id)->from('invoice')->get()->row();
		$parse['invoice_lainnya'] = $this->db->select('sum(total_tagihan - jumlah_bayar) as total_semua_tagihan')->where('tipe_invoice','lainnya')
																								->where('id_cust',$id)->from('invoice')->get()->row();
		$parse['pembayaran'] = $this->db->select('sum(jumlah_bayar) as jumlah')->where('id_cust',$id)->from('pembayaran')->get()->row();
		$parse['cbm_customer'] = $this->db->select('sum(giw.ctns * giw.volume) as jumlah')->from('giw')->where('giw.customer_id',$id)->get()->row();
		$parse['komisi_ref'] = $this->db->select('sum(nilai) as jumlah')->from('komisi_referal')->where('id_cust',$id)->get()->row();
		$year = date('Y');
		$parse['cbm_perbulan'] = $this->db->select('sum(ctns*volume) as cbm , month(tanggal) as bulan')->from('giw')
														 ->join('resi','giw.resi_id=resi.id_resi','left')
														 ->where('giw.customer_id',$id)
														 ->where('year(tanggal)',$year)->group_by('month(tanggal)')->get()->result();
		// print_r($parse['rowjenisbarang']);die();
		// Untuk Tab Menu di Customer
		if($segment == "index"){
			$this->template->load('template','admin/customer/detail_index',$parse);
		}else if($segment == "resi"){
			$this->template->load('template','admin/customer/detail_resi',$parse);
		}else if($segment == "transaksi"){
			$this->template->load('template','admin/customer/detail_transaksi',$parse);
		}else if($segment == "invoice"){
			$this->template->load('template','admin/customer/detail_invoice',$parse);
		}else if($segment == "pembayaran"){
			$this->template->load('template','admin/customer/detail_pembayaran',$parse);
		}else if($segment == "deposit"){
			$this->template->load('template','admin/customer/detail_deposit',$parse);
		}else if($segment == "invoice_barang"){
			$this->template->load('template','admin/customer/detail_invoicebarang',$parse);
		}else if($segment == "barang"){
			$this->template->load('template','admin/customer/detail_barcode',$parse);
		}else if($segment == "harga_khusus"){
			$this->template->load('template','admin/customer/detail_harga',$parse);
		}else if($segment == "cbm"){
			$this->template->load('template','admin/customer/detail_cbm',$parse);
		}
  }

   //Function Proses Simpan Add New Customer
   function save(){
		 // print_r($this->input->post('id_referal'));die();
		 $h=date('H')+5;  $i=date('i');   $s=date('s');
		 $date= date('Y-m-d');
		 $data_kode= $this->Mcustomer->get_id($this->input->post('kode'));
		 // Validasi Marking Customer
	   if($data_kode->num_rows()>0){
       foreach($data_kode->result() as $c ){
        $kode=$c->kode;
       }
     }else{
      $kode="";
     }
     if($kode == $this->input->post('kode')){
        $this->session->set_flashdata('msg','notvalid');
      ?><script type="text/javascript">
          window.location.href = "<?php print site_url() ?>admin/customer";
    	  </script><?php
		 }else{
				$temp1 = explode(".", $_FILES['foto_ktp']['name']);
				$new_name1 = time().'.'.end($temp1);
				$config1['upload_path'] = './assets/foto_ktp/';
		    $config1['file_name'] = $new_name1;
		    $config1['allowed_types'] = 'jpg|jpeg|png|pdf';
		    $this->load->library('upload');
		    $this->upload->initialize($config1);
		    if(!$this->upload->do_upload('foto_ktp')){
			   	$this->upload->display_errors();
			    $new_name1 = "";
		    }
		    $media1 = $this->upload->data('foto_ktp');

			  $temp2 = explode(".", $_FILES['foto_sk']['name']);
			  $new_name2 = time().'.'.end($temp2);
			  $config2['upload_path'] = './assets/foto_sk/';
			  $config2['file_name'] = $new_name2;
			  $config2['allowed_types'] = 'jpg|jpeg|png|pdf';
			  $this->load->library('upload');
			  $this->upload->initialize($config2);
			  if(!$this->upload->do_upload('foto_sk')){
				 $this->upload->display_errors();
				 $new_name1 = "";
			  }
			  $media2 = $this->upload->data('foto_sk');

			  $data = $this->Mcustomer->save($new_name1,$new_name2);
			}
  	}

    //Function Proses Update Customer
    function update(){
			// var_dump($this->input->post());die();
			$temp1 = explode(".", $_FILES['foto_ktp']['name']);
			$new_name1 = time().'.'.end($temp1);
			$config1['upload_path'] = './assets/foto_ktp/';
			$config1['file_name'] = $new_name1;
			$config1['allowed_types'] = 'jpg|jpeg|png|pdf';
			$this->load->library('upload');
			$this->upload->initialize($config1);
			if(!$this->upload->do_upload('foto_ktp')){
				$this->upload->display_errors();
			  $new_name1 = "";
			}
		 $media1 = $this->upload->data('foto_ktp');

		 //var_dump($_FILES['foto_ktp']['name']);die();

		 $temp2 = explode(".", $_FILES['foto_sk']['name']);
		 $new_name2 = time().'.'.end($temp2);
		 $config2['upload_path'] = './assets/foto_sk/';
		 $config2['file_name'] = $new_name2;
		 $config2['allowed_types'] = 'jpg|jpeg|png|pdf';
		 $this->load->library('upload');
		 $this->upload->initialize($config2);
		 if(!$this->upload->do_upload('foto_sk')){
			 $this->upload->display_errors();
			 $new_name2 = "";
		 }
		 $media2 = $this->upload->data('foto_sk');
     $data = $this->Mcustomer->update($new_name1,$new_name2);
  }

	// Function Select Customer Output Json
	function select_grup(){
		 cek_session_all();
		 $kode = $this->input->get('kode_cgrup');
		 $data_cust = $this->Mcustomer->select_grup($kode);
		 echo json_encode($data_cust);
	}

	// Function Select Customer Output Json
	function select_customer(){
		 // cek_session_all();
		 $kode = $this->input->get('id_referal');
		 $data_cust = $this->Mcustomer->select_customer($kode);
		 echo json_encode($data_cust);
	}

	// Function Resend Chat Marking Customer
	function resend_chat(){
		 cek_session_all();
		 $this->Mcustomer->resend_chat();
	}

	function buka_harga(){
		$idcust = $this->input->post('id_cust');
		$this->Mjenis_barang_customer->buka_harga($idcust);
	}

	function harga10(){
		$idcust = $this->input->post('id_cust');
		$this->Mjenis_barang_customer->harga10($idcust);
	}

	function update_harga(){
		$this->Mjenis_barang_customer->update_harga();
	}

	function api_khusus(){
		$customer    = $this->db->order_by('id_cust','asc')->get('customer')->result();// echo $customer; die();
		$kode  = array();
    $alamat=array();

		foreach ($customer as $cust) {
			$kode[]   = $cust->kode;
			$alamat[] = $cust->alamat;
		}

		$kode_array=implode(' ',$kode);//Implode
		$alamat_array = implode(' ',$alamat);
    $url2='https://office.rtsekspedisi.com/api/a_customer/alamat_customer';
    $postdata = http_build_query(array("kode"=>$kode_array,"alamat"=>$alamat_array));
    $opts =array('http' =>
                    array(
                    'method'  => 'GET',
                    'header'  => 'Content-Type: application/x-www-form-urlencoded',
                    'content' => $postdata
                    )
                );
    //$rslt=implode(',',$nomor_giw_array);
    //dd($postdata);
		// var_dump($postdata);die();

    $context   = stream_context_create($opts);
    $json_resi = file_get_contents($url2, false, $context);

	}

	function refund_deposit(){
		$id_cust = $this->input->post('id_cust');
		$jumlah_refund = $this->input->post('jumlah_refund');
		$data_customer = $this->db->where('id_cust',$id_cust)->get('customer')->row();
		if($jumlah_refund > $data_customer->deposit || $jumlah_refund <= 0){
			$this->session->set_flashdata('msg','gagalrefund');
			redirect(site_url('admin/customer'));
		}
		// deposit
		$dpst['id_cust']  = $id_cust;
		$dpst['id_cgrup'] = 0;
		$dpst['nominal_deposit'] = $jumlah_refund ;
		$dpst['tipe_deposit'] ="keluar";
		$dpst['keterangan_deposit'] ="Refund ".$jumlah_refund;
		$dpst['tanggal_deposit'] = date('Y-m-d');
		$this->db->insert('deposit', $dpst);

		$customer['deposit'] =$data_customer->deposit - $jumlah_refund;
		$this->db->where('id_cust',$id_cust);
		$this->db->update('customer', $customer);
		// Bank
		$trb['id_jenis_transaksi_bank'] = 48;
		$trb['id_bank'] = 1;
		$trb['tipe_transaksi_bank'] = "keluar";
		$trb['nominal_transaksi_bank'] = $jumlah_refund;
		$trb['keterangan_transaksi_bank'] = "Refund Deposit ".$jumlah_refund." , ".$data_customer->kode;
		$trb['tanggal_transaksi_bank'] = date('Y-m-d');
		$trb['sisa_saldo_bank'] = 0;
		$this->db->insert('transaksi_bank', $trb);
		// $last_id = $this->db->insert_id();
		//redirect
		$this->session->set_flashdata('msg','refund');
		redirect(site_url('admin/customer'));
	}

	function setor_deposit(){
		$id_cust = $this->input->post('id_cust');
		$jumlah_setor = $this->input->post('jumlah_setor');
		$data_customer = $this->db->where('id_cust',$id_cust)->get('customer')->row();
		// deposit
		$dpst['id_cust']  = $id_cust;
		$dpst['id_cgrup'] = 0;
		$dpst['nominal_deposit'] = $jumlah_setor ;
		$dpst['tipe_deposit'] ="masuk";
		$dpst['keterangan_deposit'] ="Setor ".$jumlah_setor;
		$dpst['tanggal_deposit'] = date('Y-m-d');
		$this->db->insert('deposit', $dpst);

		$customer['deposit'] =$data_customer->deposit + $jumlah_setor;
		$this->db->where('id_cust',$id_cust);
		$this->db->update('customer', $customer);
		// Bank
		$trb['id_jenis_transaksi_bank'] = 48;
		$trb['id_bank'] = 1;
		$trb['tipe_transaksi_bank'] = "masuk";
		$trb['nominal_transaksi_bank'] = $jumlah_setor;
		$trb['keterangan_transaksi_bank'] = "Setor Deposit ".$jumlah_setor." , ".$data_customer->kode;
		$trb['tanggal_transaksi_bank'] = date('Y-m-d');
		$trb['sisa_saldo_bank'] = 0;
		$this->db->insert('transaksi_bank', $trb);
		// $last_id = $this->db->insert_id();
		//redirect
		$this->session->set_flashdata('msg','setorok');
		redirect(site_url('admin/customer'));
	}

	function customer_excel(){
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=customerwilopocargo.xls");
		$data['data_customer'] = $this->db->where('id_cust >',0)->order_by('nama','asc')->get('customer')->result();
		$this->load->view('admin/customer/excel.php',$data);
	}

	function unverified(){
		$data['cek'] = 0;
		$this->template->load('template','admin/customer/unverified',$data);
	}

	function cek_customer(){
		$marking = "";$email="";
		$marking = $this->input->post('kode');
		$email   = $this->input->post('email');
		$data['cek_customer']     = $this->db->select('customer.*,pengguna.nama_pengguna,crm.nama_pengguna as nama_crm')
																        ->from('customer')
																				->join('pengguna_customer','pengguna_customer.id_cust=customer.id_cust','left')
																				->join('pengguna', 'pengguna.id_pengguna=customer.id_pendaftar')
																				->join('pengguna as crm', 'crm.id_pengguna=customer.id_crm')
																				->where('pengguna_customer.level',0)
																				->where('kode',$marking)
																				->or_where('email',$email)
																				->get()->row();
												// print_r($data);//die("oke");
		$data['cek'] = $data['cek_customer']->id_cust;
		$this->template->load('template','admin/customer/unverified',$data);
	}

	function verifikasi(){
		// Cek Crm
		$cek_crm = $this->db->select('id_pengguna,nama_pengguna,whatsapp')->from('pengguna')
												->where('level','crm')->where('status',1)->where('status_sales',1)
												->get()->row();
		$idcust = $this->input->post('id_cust');
		$upd_cust2['whatsapp'] = $this->input->post('whatsapp');
		$this->db->where('id_cust',$idcust)->update('customer',$upd_cust2);
		$get_customer = $this->db->where('id_cust',$idcust)->get('customer')->row();
		// print_r($this->input->post('kode'));print_r($get_customer->kode);die('Marking beda');
		if($this->input->post('kode') != $get_customer->kode){
			// die('Marking beda');
			$get_customer2 = $this->db->where('kode',$this->input->post('kode'))->get('customer')->num_rows();
			// print_r($get_customer2);die();
			if($get_customer2 == 0){
				// die('bisa ganti marking');
				$upd_customer['kode'] = $this->input->post('kode');
			}else{
				// die("gabisa");
				$this->session->set_flashdata('msg','sudahada');
				redirect(site_url('admin/customer/unverified'));
			}
		}
		$upd_pengguna['level'] = 1;
		$this->db->where('id_cust',$idcust)->update('pengguna_customer',$upd_pengguna);
		if($this->session->userdata('level') == "crm"){
			$upd_customer['id_pendaftar'] = 0;
			$upd_customer['id_crm'] = $this->session->userdata('id_pengguna');
		}else{
			$upd_customer['id_pendaftar'] = $this->session->userdata('id_pengguna');
			$upd_customer['id_crm'] = $cek_crm->id_pengguna;
		}
		$upd_customer['s_aktivasi'] = "Sudah Aktivasi";
		$upd_customer['kode'] = $this->input->post('kode');
		$this->db->where('id_cust',$idcust)->update('customer',$upd_customer);
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

		$nama = $get_customer->nama;
		$email= "order@wilopocargo.com";
		$whatsapp= "6281299053976";
		$alamat= $get_customer->alamat;
		if($get_customer->jalur == 2){
			$jalur = 2;
		}else{
			$jalur = 1;
		}
		$kodemarkingnya = $upd_customer['kode'];
		$curl_handle=curl_init();
		curl_setopt($curl_handle,CURLOPT_URL,'https://office.rtsekspedisi.com/api/a_customer/save_api');
		curl_setopt($curl_handle, CURLOPT_POST, 1);
		curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "kode=$kodemarkingnya&nama=$nama&email=$email&whatsapp=$whatsapp&alamat=$alamat&jalur=$jalur");
		$res = curl_exec($curl_handle);
		curl_close($curl_handle);

		// print_r(substr($get_customer->kode,7));die();
		$kode = substr($get_customer->kode,7);
		$markingudara = "WC-".$kode."/AIR";
		$marking      = "123/WC-".$kode;
		$pesan8 = "Selamat! Kode Marking Anda sudah aktif dan Anda sudah dapat mengirim barang ke gudang China kami. Apabila Anda memiliki pertanyaan atau masalah lebih lanjut, CSO (Customer Service Officer) kami siap melayani dengan senang hati. Anda dapat menanyakan apapun dan juga melakukan komplain apabila ada masalah. Berikut adalah kontak CSO kami:  ".
		"\n\n$cek_crm->nama_pengguna\nWA: $cek_crm->whatsapp\n\natau bisa hubungi nomor kantor kami di\n\n021 2252 1995\n\nTerimakasih :)"."\n\n*Wilopo Cargo* _(do not reply)_";
		sendwhatsapp($pesan8,$get_customer->whatsapp);

		$caption2 = "New Customer Wilopo Cargo \n\nNama : ".$get_customer->nama."\nKode Marking : ".$marking."\nAlamat : ".$get_customer->alamat."\nEmail : order@wilopocargo.com \nNo.Telepon : 6281299053976";
		$captionudara2 = "New Customer Wilopo Cargo \n\nNama : ".$get_customer->nama."\nKode Marking : ".$markingudara."\nAlamat : ".$get_customer->alamat."\nEmail : order@wilopocargo.com \nNo.Telepon : 6281299053976";
		// print_r($get_customer->foto_ktp);die();
		$imagenya = "https://office.wilopocargo.com/assets/foto_ktp/".$get_customer->foto_ktp;
		// print_r($imagenya);die();
		sendimage("Ktp","6281293488636","$imagenya");
		sendwhatsapp($caption2,'6281293488636');

		// sendimage("KTP","08111353711","$imagenya");
		// sendwhatsapp($captionudara2,'08111353711');

		$pesan_crm = "New Customer Wilopo Cargo \n\nNama : ".$get_customer->nama."\nKode Marking : ".$marking."\nNo.Whatsapp : $get_customer->whatsapp";
		sendwhatsapp($pesan_crm,$cek_crm->whatsapp);

		$this->session->set_flashdata('msg','okeverif');
		redirect(site_url('admin/customer/unverified'));
	}

	function push_customer(){
		$idcust = $this->input->post('id_cust');
		$get_customer = $this->db->where('id_cust',$idcust)->get('customer')->row();
		if($get_customer->jalur == 2){
			$jalur = 2;
		}else{
			$jalur = 1;
		}

		$curl_handle=curl_init();
		curl_setopt($curl_handle,CURLOPT_URL,'https://office.rtsekspedisi.com/api/a_customer/save_api');
		curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl_handle, CURLOPT_POST, 1);
		curl_setopt($curl_handle, CURLOPT_POSTREDIR, 3);
		curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "kode=$get_customer->kode&nama=$get_customer->nama&email=$get_customer->email&whatsapp=$get_customer->whatsapp&alamat=$get_customer->alamat&jalur=$jalur");
		$res = curl_exec($curl_handle);
		curl_close($curl_handle);
		// dd($res);
		$this->session->set_flashdata('msg','pushcust');
		redirect(site_url('admin/customer'));
	}

	function tarik_dana(){
		$this->template->load('template','admin/customer/tarik_dana');
	}

	function get_tarikdana_json(){
		header('Content-Type: application/json');
    echo $this->Mcustomer->get_tarik_dana();
	}

	function accept_tarik_dana(){
		$id_tarik_dana = $this->input->post('id_tarik_dana');
		$data_customer = $this->db->select('tarik_dana.*,customer.*')
															->from('tarik_dana')
															->join('customer', 'tarik_dana.id_cust=customer.id_cust')
															->where('id_tarik_dana',$id_tarik_dana)
															->get()->row();
    if($data_customer->status == 2 ){
			die("Cant");
		}
		// dd($data_customer);
		if($data_customer->nominal > $data_customer->deposit || $data_customer->nominal <= 0){
			$this->session->set_flashdata('msg','gagalrefund');
			redirect(site_url('admin/customer/tarik_dana'));
		}
		// deposit
		// $dpst['id_cust']  = $data_customer->id_cust;
		// $dpst['id_cgrup'] = 0;
		// $dpst['nominal_deposit'] = $data_customer->nominal ;
		// $dpst['tipe_deposit'] ="keluar";
		// $dpst['keterangan_deposit'] ="Tarik Dana ".$data_customer->nominal;
		// $dpst['tanggal_deposit'] = date('Y-m-d');
		// $this->db->insert('deposit', $dpst);

		$customer['deposit'] =$data_customer->deposit - $data_customer->nominal;
		$this->db->where('id_cust',$data_customer->id_cust);
		$this->db->update('customer', $customer);

		$tarik_dana['status'] =2;
		$this->db->where('id_tarik_dana',$data_customer->id_tarik_dana);
		$this->db->update('tarik_dana', $tarik_dana);
		// Bank
		$trb['id_jenis_transaksi_bank'] = 62;
		$trb['id_bank'] = 1;
		$trb['tipe_transaksi_bank'] = "keluar";
		$trb['nominal_transaksi_bank'] = $data_customer->nominal;
		$trb['keterangan_transaksi_bank'] = "Tarik Dana ".$data_customer->nominal." , ".$data_customer->kode;
		$trb['tanggal_transaksi_bank'] = date('Y-m-d');
		$trb['sisa_saldo_bank'] = 0;
		$this->db->insert('transaksi_bank', $trb);
		// $last_id = $this->db->insert_id();
		//redirect
		$this->session->set_flashdata('msg','oktarik');
		redirect(site_url('admin/customer'));
	}

	public function listkota(){
			// Ambil data ID Provinsi yang dikirim via ajax post
			$id_provinsi = $this->input->post('id_provinsi');
			 $kota = $this->db->where('id_prov',$id_provinsi)->get('kabupaten')->result();
			// Buat variabel untuk menampung tag-tag option nya
			// Set defaultnya dengan tag option Pilih
			$lists = "";
			$lists .="<option value=''>--Pilih--</option>";
			foreach($kota as $data){
					$lists .= "<option value='".$data->id_kab."'>".$data->nama."</option>"; // Tambahkan tag option ke variabel $lists
			}
			$callback = array('list_kota'=>$lists); // Masukan variabel lists tadi ke dalam array $callback dengan index array : list_kota
			echo json_encode($callback); // konversi varibael $callback menjadi JSON
	}
	public function listkecamatan(){
		// Ambil data ID Provinsi yang dikirim via ajax post
		$id_kota = $this->input->post('id_kota');
		 $kota = $this->db->where('id_kab',$id_kota)->get('kecamatan')->result();
		// Buat variabel untuk menampung tag-tag option nya
		// Set defaultnya dengan tag option Pilih
		$lists = "";
		        $lists .="<option value=''>--Pilih--</option>";
		foreach($kota as $data){
				$lists .= "<option value='".$data->id_kec."'>".$data->nama."</option>"; // Tambahkan tag option ke variabel $lists
		}
		$callback = array('list_kota'=>$lists); // Masukan variabel lists tadi ke dalam array $callback dengan index array : list_kota
		echo json_encode($callback); // konversi varibael $callback menjadi JSON
	}

	function delete_customer(){
		if($this->session->userdata('level')!="suadmin"){
			die("dont have access");
		}
		$id_cust = $this->input->post('id_cust');
		$get_cust = $this->db->where('id_cust',$id_cust)->get('customer')->row();
		$kode = $get_cust->kode;
		// print_r($kode);die();
		$this->db->where('kode',$kode)->delete('customer');
		$curl_handle=curl_init();
		curl_setopt($curl_handle,CURLOPT_URL,"https://office.rtsekspedisi.com/api/a_customer/delete_customer_wilopo");
		curl_setopt($curl_handle, CURLOPT_POST, 1);
		curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "kode=$kode");
		$curlemail = curl_exec($curl_handle);
		curl_close($curl_handle);
	}
}
