<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Container extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		cek_session(); //cek session Login
		$this->load->model('Mcontainer');
		$this->load->model('Mbarang');
		$this->load->model('Minvoice_barang');
		$this->load->model('Mapiinvoice');
	}

	//Function Halaman Awal Menu Container
	function otw(){
		$this->template->load('template','admin/container/otw');
	}

	//Function Get data Json Container
	function get_otw_json() {
    header('Content-Type: application/json');
    echo $this->Mcontainer->get_data_otw();
  }

  //Function Halaman Awal Menu Container
	function monitoring(){
		$this->template->load('template','admin/container/monitoring');
	}

	//Function Get data Json Container
	function get_monitoring_json() {
    header('Content-Type: application/json');
    echo $this->Mcontainer->get_data_monitoring();
  }

  //Function Halaman Awal Menu Container
	function arrived(){
		$this->template->load('template','admin/container/arrived');
	}

	//Function Get data Json Container
	function get_arrived_json() {
    header('Content-Type: application/json');
    echo $this->Mcontainer->get_data_arrived();
  }

	//Function Halaman Awal Menu Container
	function selesai(){
		$this->template->load('template','admin/container/selesai');
	}

	//Function Get data Json Container
	function get_selesai_json() {
    header('Content-Type: application/json');
    echo $this->Mcontainer->get_data_selesai();
  }

	//Function Halaman Awal Menu Container
	function detail(){
		$id = $this->uri->segment(4);
		$data['dc'] = $this->db->where('id_rts',$id)->get('container')->row();
		$dc = $this->db->where('id_rts',$id)->get('container')->row();
		$data['data_resi'] = $this->db->select('resi.nomor as nomor_resi,resi.note as resinote,sum(giw.volume * giw.ctns) as cbm, sum(giw.ctns) as jumlah_koli
																					 , sum(giw.berat * giw.ctns) as total_berat,customer.kode as marking,resi.id_resi
																					 ,master_ekspedisi_lokal.tipe_ekspedisi,master_ekspedisi_lokal.nama_ekspedisi
																					 ,master_ekspedisi_lokal.alamat as almteks,
																					 master_ekspedisi_lokal.no_telp as notelpeks
																					 ,customer.id_ekspedisi,provinsi.nama as namaprov,kabupaten.nama as namakota
																					 ,kecamatan.nama as namakec
																					 ,customer.id_provinsi2,customer.id_kota2
																					 ,customer.id_kec2,customer.fix_alamat
																					 ,customer.id_cust,customer.alamat as almtcust
																					 ,customer.telepon as telpcs,customer.whatsapp as wacs,customer.nama as namacs')
																	->from('giw')
																	// ->join('invoice_product', 'invoice_product.id_giw=giw.id','left')
																	->join('customer', 'customer.id_cust=giw.customer_id','left')
																	->join('resi', 'giw.resi_id=resi.id_resi','left')
																	->join('master_ekspedisi_lokal', 'customer.id_ekspedisi=master_ekspedisi_lokal.id_ekspedisi','left')
																	->join('provinsi', 'customer.id_provinsi=provinsi.id_prov','left')
																	->join('kabupaten', 'customer.id_kota=kabupaten.id_kab','left')
																	->join('kecamatan', 'customer.id_kec=kecamatan.id_kec','left')
																	->where('giw.container_id',$id)
																	->group_by('resi.id_resi')
																	->order_by('customer.id_cust','desc')
																	->get()->result();
			if(strpos($dc->kode, 'FCL') !== false){
				$data['data_resi2'] = $this->db->select('resi.nomor as nomor_resi,giw.nomor as nomor_giw,resi.note as resinote,sum(giw.volume * invoice_product.jumlah) as cbm, sum(invoice_product.jumlah) as jumlah_koli
																							 , sum(giw.berat * invoice_product.jumlah) as total_berat,customer.kode as marking,resi.id_resi,container_generate
																							 ,invoice_product.posisi_indo,posisi_indo.tempat,invoice.kode_invoice,sj_wc.kode_sj,surat_jalan.no_sj
																							 ,giw.id as idgiw,sum(giw.ctns - giw.counter) as hilang')
																			->from('invoice_product')
																			->join('posisi_indo', 'invoice_product.posisi_indo=posisi_indo.id_posisi_indo','left')
																			->join('giw', 'invoice_product.id_giw=giw.id','left')
																			->join('invoice', 'invoice_product.id_invoice=invoice.id_invoice','left')
																			->join('sj_wc', 'invoice_product.id_sj_wc=sj_wc.id_sj','left')
																			->join('surat_jalan', 'invoice_product.id_sj=surat_jalan.id_surat_jalan','left')
																			->join('customer', 'customer.id_cust=giw.customer_id','left')
																			->join('resi', 'giw.resi_id=resi.id_resi','left')
																			->where('giw.container_id',$id)
																			->group_by('invoice_product.id_giw')
																			->order_by('container_generate','desc')
																			->order_by('customer.kode','desc')
																			->get()->result();
			}else{
				$data['data_resi2'] = $this->db->select('resi.nomor as nomor_resi,resi.note as resinote,sum(giw.volume * invoice_product.jumlah) as cbm, sum(invoice_product.jumlah) as jumlah_koli
																							 , sum(giw.berat * invoice_product.jumlah) as total_berat,customer.kode as marking,resi.id_resi,container_generate
																							 ,invoice_product.posisi_indo,posisi_indo.tempat,invoice.kode_invoice,sj_wc.kode_sj,surat_jalan.no_sj
																							 ,sum(giw.ctns - giw.counter) as hilang')
																			->from('invoice_product')
																			->join('posisi_indo', 'invoice_product.posisi_indo=posisi_indo.id_posisi_indo','left')
																			->join('giw', 'invoice_product.id_giw=giw.id','left')
																			->join('invoice', 'invoice_product.id_invoice=invoice.id_invoice','left')
																			->join('sj_wc', 'invoice_product.id_sj_wc=sj_wc.id_sj','left')
																			->join('surat_jalan', 'invoice_product.id_sj=surat_jalan.id_surat_jalan','left')
																			->join('customer', 'customer.id_cust=giw.customer_id','left')
																			->join('resi', 'giw.resi_id=resi.id_resi','left')
																			->where('giw.container_id',$id)
																			->group_by('resi.id_resi')
																			->order_by('container_generate','desc')
																			->order_by('customer.kode','desc')
																			->get()->result();//dd($data['data_resi2']);
			}

			$data['data_posisi'] = $this->db->where('id_posisi_indo <',20)->where('id_posisi_indo !=',5)->get('posisi_indo')->result();

		$db2 = $this->load->database('db2', TRUE);
		$data['total_live'] = $db2->select('sum(giw.volume * giw.ctns) as cbm, sum(giw.ctns) as jumlah_koli
																	, sum(giw.berat * giw.ctns) as total_berat')
												->from('giw')
												->join('customer', 'giw.customer_id=customer.id','left')
												->where('giw.container_id',$id)
												->where('customer.broker_id',30)
												->get()->row();
		// dd($stuff);

																	// dd($data['data_resi']);
		$this->template->load('template','admin/container/detail',$data);
	}

	function detail_arrived(){
		$id = $this->uri->segment(4);
		$data['dc'] = $this->db->where('id_rts',$id)->get('container')->row();
		$data['data_resi'] = $this->db->select('resi.nomor as nomor_resi,sum(giw.volume * invoice_product.jumlah) as cbm, sum(invoice_product.jumlah) as jumlah_koli
																					 , sum(giw.berat * invoice_product.jumlah) as total_berat,customer.kode as marking,resi.id_resi,container_generate')
																	->from('giw')
																	->join('invoice_product', 'invoice_product.id_giw=giw.id','left')
																	->join('customer', 'customer.id_cust=giw.customer_id','left')
																	->join('resi', 'giw.resi_id=resi.id_resi','left')
																	->where('giw.container_id',$id)
																	->group_by('resi.id_resi')
																	->order_by('container_generate','desc')
																	->get()->result();
																	// dd($data['data_resi']);
		$this->template->load('template','admin/container/detail_arrived',$data);
	}

	function arrived_cont(){
		$id = $this->uri->segment(4);
		$arrived['status'] = 5;
		$arrived['tanggal_arrived_c']= date('Y-m-d');
		$this->db->where('id_rts',$id)->update('container',$arrived);
		$getgiwcont = $this->db->select('giw.id,giw.ctns,giw.container_id')->from('giw')->where('container_id',$id)->get()->result();
		foreach($getgiwcont as $gc){
			$invoice_product['id_giw']= $gc->id;
			$invoice_product['id_sj']= 0;
			$invoice_product['id_invoice']= 0;
			$invoice_product['id_invoice_beli']= 0;
			$invoice_product['id_sj_rts']= 0;
			$invoice_product['jumlah']= $gc->ctns;
			$invoice_product['container_generate']= $gc->container_id;
			$invoice_product['status_generate']= 0;
			$invoice_product['posisi_indo']= 0;
			$this->db->insert('invoice_product',$invoice_product);

			$giw['counter']= $gc->ctns;
			$giw['status']= 5;
			$giw['posisi_indo']= 0;
			$updategiw = $this->db->where('id',$gc->id)->update('giw',$giw);
		}
		if($updategiw){
			redirect(site_url('admin/container/detail/'.$id));
		}
	}

	function viewpdf(){
		$id = $this->uri->segment(4);
		$tp = $this->uri->segment(5);
		$data['dc'] = $this->db->where('id_rts',$id)->get('container')->row();
		if($tp == "noalamat"){
			$data['data_resi'] = $this->db->select('resi.nomor as nomor_resi,resi.note as resinote,sum(giw.volume * giw.ctns) as cbm, sum(giw.ctns) as jumlah_koli
																						 , sum(giw.berat * giw.ctns) as total_berat,customer.kode as marking,resi.id_resi
																						 ,master_ekspedisi_lokal.tipe_ekspedisi,master_ekspedisi_lokal.nama_ekspedisi
																						 ,master_ekspedisi_lokal.alamat as almteks,
																						 master_ekspedisi_lokal.no_telp as notelpeks
																						 ,customer.id_ekspedisi,provinsi.nama as namaprov,kabupaten.nama as namakota
																						 ,kecamatan.nama as namakec
																						 ,customer.id_provinsi2,customer.id_kota2
																						 ,customer.id_kec2,customer.fix_alamat
																						 ,customer.id_cust,customer.alamat as almtcust
																						 ,customer.telepon as telpcs,customer.whatsapp as wacs,customer.nama as namacs')
																		->from('giw')
																		// ->join('invoice_product', 'invoice_product.id_giw=giw.id','left')
																		->join('customer', 'customer.id_cust=giw.customer_id','left')
																		->join('resi', 'giw.resi_id=resi.id_resi','left')
																		->join('master_ekspedisi_lokal', 'customer.id_ekspedisi=master_ekspedisi_lokal.id_ekspedisi','left')
																		->join('provinsi', 'customer.id_provinsi=provinsi.id_prov','left')
																		->join('kabupaten', 'customer.id_kota=kabupaten.id_kab','left')
																		->join('kecamatan', 'customer.id_kec=kecamatan.id_kec','left')
																		->where('giw.container_id',$id)
																		->group_by('customer.id_cust')
																		->order_by('customer.kode','asc')
																		->get()->result();
		}else{
			$data['data_resi'] = $this->db->select('resi.nomor as nomor_resi,resi.note as resinote,sum(giw.volume * giw.ctns) as cbm, sum(giw.ctns) as jumlah_koli
																						 , sum(giw.berat * giw.ctns) as total_berat,customer.kode as marking,resi.id_resi
																						 ,master_ekspedisi_lokal.tipe_ekspedisi,master_ekspedisi_lokal.nama_ekspedisi
																						 ,master_ekspedisi_lokal.alamat as almteks,
																						 master_ekspedisi_lokal.no_telp as notelpeks
																						 ,customer.id_ekspedisi,provinsi.nama as namaprov,kabupaten.nama as namakota
																						 ,kecamatan.nama as namakec
																						 ,customer.id_provinsi2,customer.id_kota2
																						 ,customer.id_kec2,customer.fix_alamat
																						 ,customer.id_cust,customer.alamat as almtcust
																						 ,customer.telepon as telpcs,customer.whatsapp as wacs,customer.nama as namacs')
																		->from('giw')
																		// ->join('invoice_product', 'invoice_product.id_giw=giw.id','left')
																		->join('customer', 'customer.id_cust=giw.customer_id','left')
																		->join('resi', 'giw.resi_id=resi.id_resi','left')
																		->join('master_ekspedisi_lokal', 'customer.id_ekspedisi=master_ekspedisi_lokal.id_ekspedisi','left')
																		->join('provinsi', 'customer.id_provinsi=provinsi.id_prov','left')
																		->join('kabupaten', 'customer.id_kota=kabupaten.id_kab','left')
																		->join('kecamatan', 'customer.id_kec=kecamatan.id_kec','left')
																		->where('giw.container_id',$id)
																		->group_by('resi.id_resi')
																		->order_by('customer.id_cust','desc')
																		->get()->result();
		}

		$data = $this->load->view('admin/container/pdf_detail',$data,True);

		$mpdf = new \Mpdf\Mpdf();
		//$data = $this->load->view('hasilPrint', [], TRUE);
		$mpdf->WriteHTML($data);
		$mpdf->Output();
	}

	function add_to_stok(){
		$id_container = $this->input->post('id_container');
		$posisi = $this->input->post('posisi');
		$action = $this->input->post('action');//
		// dd($this->input->post());
		if($action == 'addstok') {
			$id_resi = $this->input->post('id_resi');
			$hitungjumlaharray = count($id_resi);//dd($hitungjumlaharray);
// 			$qhist = $this->db->select('giw.id')->from('giw')->where_in('giw.resi_id',$id_resi)
// 			->join('resi', 'giw.resi_id=resi.id_resi', 'left')->get()->result();

// 			foreach($qhist as $hi){
// 			    	//history resi
//             		$resi_id=0;
//             		$container_id=0;
//             		$date=date('Y-m-d');
//             		$status_giw_id=14;
//             		$giw_id=$hi->id;
//             		$tipe_delay=0;
//             		$this->Mbarang->history_status_gudang($resi_id, $container_id, $date, $status_giw_id,$giw_id,$tipe_delay);
// 			}

			for($i=0; $i<$hitungjumlaharray; $i++){

				$cekresinya = $this->db->select('resi.cust_id')->from('resi')->where('id_resi',$id_resi[$i])->get()->row();

				// cek harga
				$cekharga=$this->db->select('SUM(((giw.qty*giw.ctns)*giw.nilai)*2000) as harga_barang')
		                      ->from('giw')
		                      ->join('status_giw','status_giw.id=giw.status','left')
		                      ->where('customer_id',$cekresinya->cust_id)
		                      ->where('status_giw.urutan <',12)
		                      ->get()->row();

				$cek_customer = $this->db->select('customer.fix_alamat')->from('customer')
		                             ->where('id_cust',$cekresinya->cust_id)
		                             ->get()->row();
		    if($cekharga->harga_barang > 0){
		        if($cek_customer->fix_alamat != 1){
		          $boleh_kirim = 1;
		        }else{
		          $boleh_kirim = 2;
							$tglbolehkirim = date('Y-m-d');
		        }
		    }else{
		      $boleh_kirim = 0;
		    }
				if($boleh_kirim == 2){
					$sql = "UPDATE giw
									left join invoice_product on invoice_product.id_giw=giw.id
									set invoice_product.posisi_indo = $posisi , giw.boleh_kirim=$boleh_kirim,giw.tanggal_boleh_kirim = '$tglbolehkirim'
									where resi_id = $id_resi[$i]
									";
				}else{
					$sql = "UPDATE giw
									left join invoice_product on invoice_product.id_giw=giw.id
									set invoice_product.posisi_indo = $posisi , giw.boleh_kirim=$boleh_kirim
									where resi_id = $id_resi[$i]
									";
				}
				$updatestok = $this->db->query($sql);
			}
		}
		if($action == 'drts') {
			$id_resi = $this->input->post('id_resi');
			$hitungjumlaharray = count($id_resi);//dd($hitungjumlaharray);
			for($i=0; $i<$hitungjumlaharray; $i++){
				$sql = "UPDATE giw
								left join invoice_product on invoice_product.id_giw=giw.id
								set invoice_product.posisi_indo = 21
								where resi_id = $id_resi[$i]
								";
				$updatestok = $this->db->query($sql);
			}
		}

		if($action == 'generatefcl'){
			// dd($this->input->post());
			$idgiw = $this->input->post('id_giw');
			$hilang = $this->input->post('hilang');
			$hitungjumlaharray = count($idgiw);//dd($hitungjumlaharray);
			for($i=0; $i<$hitungjumlaharray; $i++){
				$sql = "UPDATE giw
								left join invoice_product on invoice_product.id_giw=giw.id
								set invoice_product.posisi_indo = $posisi,invoice_product.jumlah = invoice_product.jumlah -$hilang[$i]
										, giw.counter = giw.counter - $hilang[$i] , invoice_product.status_generate = 1
								where giw.id = $idgiw[$i]
								";
				$updatestok = $this->db->query($sql);
			}
				if($updatestok){
				 $idgiw = $this->input->post('id_giw');//dd($idgiw);
		 		 $get_invcron = $this->db->select('customer.kode as custkode,customer.id_cust')
		 														 ->from('invoice_product')
		 														 ->join('giw', 'invoice_product.id_giw=giw.id','left')
		 														 ->join('customer', 'giw.customer_id=customer.id_cust','left')
		 														 ->where('id_invoice',0)
		 														 ->where('container_generate > 1')
		 														 ->where('status_generate > 0')
		 														 ->where_in('id_giw',$idgiw)
		 														 ->order_by('id_invoice_product','asc')
		 														 ->group_by('customer.id_cust')
		 														 // ->limit(7)
		 														 ->get()->result();
		 		 foreach($get_invcron as $geninv){
		 					if($geninv->id_cust <= 0 || $geninv->id_cust == null || $geninv->id_cust == ""){
		 						dd("tidak ada inv");
		 					}
		 					//Insert Surat Jalan
		 					sendwhatsapp("Generate Auto Invoice","083815423599");
		 					$data_customer= $this->Mbarang->data_customer($geninv->custkode);
		 					foreach($data_customer->result() as $dcusto ){
		 								$id_cust           =$dcusto->id_cust;
		 								$fix_alamat        =$dcusto->fix_alamat;
		 								$id_cgrup          =$dcusto->id_cgrup;
		 								$harga_otomatis    =$dcusto->harga_otomatis;
		 								$harga_otomatis_grup=$dcusto->harga_otomatis_grup;
		 								if($dcusto->id_cgrup > 0){
		 								 $mail_cust         =$dcusto->email_cgrup;
		 								 $whatsapp          =$dcusto->whatsapp_cgrup;
		 								}else{
		 								 $mail_cust         =$dcusto->email;
		 								 $whatsapp          =$dcusto->whatsapp;
		 								}
		 								$nama_penerima     =$dcusto->nama_penerima;
		 								$alamat_penerima   =$dcusto->alamat;
		 								$telepon_penerima  =$dcusto->telepon;
		 								$id_referal        =$dcusto->id_referal;
		 								$nama_customer     =$dcusto->nama;
		 					}

		 					$insert_invjual['id_invoice_beli']= 1;
		 					$insert_invjual['id_cust']        = $id_cust;
		 					$insert_invjual['id_surat_jalan'] = 1;
		 					$insert_invjual['kode_invoice']   = $this->Mbarang->code_invoice_barang();
		 					$insert_invjual['tanggal_invoice']= date('Y-m-d') ;
		 					$insert_invjual['id_vendor']      = 4;
		 					$insert_invjual['total_tagihan']  = 0 ;
		 					$insert_invjual['total_potongan'] = 0 ;
		 					$insert_invjual['jumlah_bayar']   = 0 ;
		 					$insert_invjual['encrypt_invoice']= md5($insert_invjual['kode_invoice']) ;
		 					$insert_invjual['tipe_invoice']   = 'barang';
		 					$insert_invjual['status_invoice'] = 0;
		 					$insert_invjual['status_boleh_kirim'] = 0;

		 					$this->db->insert('invoice', $insert_invjual);
		 					$invjual_id = $this->db->insert_id();

		 					$cek_customer = $this->db->select('customer.fix_alamat')->from('customer')
		 																	 ->where('id_cust',$id_cust)
		 																	 ->get()->row();

						  $cekharga=$this->db->select('SUM(((giw.qty*giw.ctns)*giw.nilai)*2000) as harga_barang')
					                      ->from('giw')
					                      ->join('status_giw','status_giw.id=giw.status','left')
					                      ->where('customer_id',$id_cust)
					                      ->where('status_giw.urutan <',12)
					                      ->get()->row();
							if($cekharga->harga_barang > 0){
					        if($cek_customer->fix_alamat != 1){
					          $boleh_kirim = 1;
					        }else{
					          $boleh_kirim = 2;
										$tglbolehkirim = date('Y-m-d');
					        }
					    }else{
					      $boleh_kirim = 0;
					    }
							if($boleh_kirim == 2){
			 					$sql = "UPDATE invoice_product JOIN giw ON invoice_product.id_giw = giw.id SET invoice_product.id_sj = 1,
			 									invoice_product.id_invoice_beli = 1,invoice_product.id_invoice = $invjual_id,giw.boleh_kirim = $boleh_kirim
												,giw.tanggal_boleh_kirim = '$tglbolehkirim'
			 									WHERE invoice_product.id_invoice = 0 and invoice_product.container_generate > 1 and giw.customer_id = $id_cust
			 									and status_generate > 0";
							}else{
			 					$sql = "UPDATE invoice_product JOIN giw ON invoice_product.id_giw = giw.id SET invoice_product.id_sj = 1,
			 									invoice_product.id_invoice_beli = 1,invoice_product.id_invoice = $invjual_id,giw.boleh_kirim = $boleh_kirim
			 									WHERE invoice_product.id_invoice = 0 and invoice_product.container_generate > 1 and giw.customer_id = $id_cust
			 									and status_generate > 0";
							}
		 					//Update Invoice Product
		 					$this->db->query($sql);

		 					// Update Invoice Asuransi dengan Id Invoice Jika Barang ber asuransi
		 					$giwbyresi=$this->db->select('giw.customer_id,giw.resi_id')->from('invoice_product')->join('giw','giw.id=invoice_product.id_giw','left')
		 															 ->where('invoice_product.id_invoice',$invjual_id)->group_by('giw.resi_id')->get()->result();
		 															 // echo "oke"; print_r($giwbyresi);die();
		 					 foreach ($giwbyresi as $gbr) {
		 						 $getinvasr=$this->db->where('id_resi',$gbr->resi_id)->where('id_invoice',0)->get('invoice_asuransi')->num_rows();
		 						 if($getinvasr > 0){
		 							 $update_asr['id_invoice']= $invjual_id;
		 							 $this->db->where('id_resi',$gbr->resi_id)->where('id_invoice',0)->update('invoice_asuransi',$update_asr);
		 						 }
		 					 }

		 					 $selectasuransi=$this->db->select("sum(jumlah_asuransi) as jumlah")->from('invoice_asuransi')->where('id_invoice', $invjual_id)->get()->row();
		 					 $asuransiinvoice=@$selectasuransi->jumlah;

		 					 $jumlah=0; $total=0; $totalsamping=0; $total_volume=0;
		 					 $data_invoice_product = $this->Mapiinvoice->get_invoice_product2($invjual_id)->result();
		 					 foreach($data_invoice_product as $ils){
		 						 // Cek Harga Khusus
		 						 $cekhargacustomer = $this->Mbarang->data_hbc($ils->id_cust,$ils->jenis_barang_id)->num_rows();
		 						 $cekhargagrup     = $this->Mbarang->data_hbcg($id_cgrup,$ils->jenis_barang_id)->num_rows();
		 						 if($cekhargacustomer == 0 && $harga_otomatis == 1){
		 							$month = date("m",strtotime($ils->tanggal));
		 							$cek_cbm = $this->db->select('sum(ctns*volume) as jumlah')->from('giw')
		 																 ->join('resi','giw.resi_id=resi.id_resi','left')
		 																 ->where('giw.customer_id',$ils->id_cust)
		 																 ->where('month(resi.tanggal)',$month)
		 																 ->get()->row();
		 							 if($cek_cbm->jumlah > 10){
		 								 $updhargakhusus2['harga_jual'] = $ils->harga_jual - 500000;
		 								 $this->db->where('nomor',$ils->nomor)->update('giw',$updhargakhusus2);
		 							 }
		 						 }
		 						 include APPPATH. 'helpers/harga_beli.php';
		 					 }

		 					 // Row Inv
		 					 $rowinvoice = $this->Minvoice_barang->data_invoice($invjual_id)->row();

		 					 $jumlah=0; $total=0; $totalsamping=0; $total_volume=0; $total_diskon=0; $jumlah_diskon =0; $biayatambahan = 0; $ketbiaya = "";
		 					 $data_invoice_product = $this->Mapiinvoice->get_invoice_product2($invjual_id)->result();
		 					 foreach($data_invoice_product as $ils){
		 						 $diskon = 0;
		 						 $tgl_barang_di_china = $ils->tanggal;
		 							$tgl_dapet_diskon = date('Y-m-d', strtotime('+45 days', strtotime($tgl_barang_di_china)));
		 						 if($tgl_dapet_diskon > date('Y-m-d')){
		 							 // ga kena diskon
		 						 }else{
		 							 $diskon = 1;
		 						 }
		 						 include APPPATH. 'helpers/harga.php';
		 					 }
		 					 if(@$total_diskon > 0){
		 						 // $potongan_diskon['id_invoice'] =$invjual_id;
		 						 // $potongan_diskon['id_jenis_potongan'] = "10";
		 						 // $potongan_diskon['jumlah_potongan'] = 0;
		 						 // $potongan_diskon['keterangan_potongan'] = "Potongan Barang Telat";
		 						 // // print_r($potongan_diskon);
		 						 // // echo "<br />";
		 						 // // print_r($potongan_diskon['jumlah_potongan']);
		 						 // $this->db->insert('potongan',$potongan_diskon);
		 						 // $sql = "INSERT INTO potongan (id_invoice, id_jenis_potongan, jumlah_potongan, keterangan_potongan)
		 						 //         VALUES ($invjual_id, 10,-$total_diskon,'Potongan Barang Telat')";
		 						 // $this->db->query($sql);
		 					 }
		 					 $biayatambahannya = 0;
		 					 if(@$biayatambahan > 0){
		 						 $biaya_tambahan['id_invoice'] =$invjual_id;
		 						 $biaya_tambahan['id_jenis_potongan'] = "15";
		 						 $biaya_tambahan['jumlah_potongan'] = $biayatambahan;
		 						 $biaya_tambahan['keterangan_potongan'] = "Biaya ".$ketbiaya;
		 						 // print_r($biaya_tambahan['jumlah_potongan']);
		 						 $this->db->insert('potongan',$biaya_tambahan);
		 					 }
		 					 $biayatambahannya = $biayatambahan;
		 					 $bulaninvoice = date('m');
		 					 $tglinv = date("Y-m-d");
		 					 if($bulaninvoice == 1){
		 							$bulansebelumnya = 12;
		 							$tglsblmnya = date("Y"."-12-"."01");
		 					 }else{
		 							$bulanisebelumnya = date('m') - 1;
		 							$tglsblmnya = date("Y-".$bulanisebelumnya."-01");
		 					 }
							 $dataresi   = $this->db->select('sum(giw.volume * giw.ctns) as cbm')->from('giw')
	                                    ->join('resi','resi.id_resi=giw.resi_id','left')
	                                    ->where('resi.cust_id',$id_cust)
	                                    ->where('resi.tanggal >=',$tglsblmnya)
	                                    ->where('resi.tanggal <=',$tglinv)
	                                    ->get()->row();
	            $dataresi_inv   = $this->db->select('giw.resi_id,resi.nomor as nomor_resi,sum(giw.volume * giw.ctns) as cbm')->from('invoice_product')
	                                       ->join('giw','giw.id=invoice_product.id_giw','left')
	                                       ->join('resi','resi.id_resi=giw.resi_id','left')
	                                       ->where('invoice_product.id_invoice',$invjual_id)
	                                       ->group_by("resi.id_resi")
	                                       ->get()->result();
	           if($dataresi->cbm < 2){
	             $jumlah_potong_resi_perbulan = 0;
	             foreach($dataresi_inv as $dri){
	               $hargatertinggiresi = $this->db->select('giw.harga_jual')->from('giw')->where('giw.resi_id',$dri->resi_id)->order_by('giw.harga_jual','desc')->limit(1)->get()->row();
	               if($dri->cbm <= 0.1){
	                 $countpembulatannya = 0.1-$dri->cbm ;
	                 $cek_pembulatan = 1;
	                 $dataresiinv['id_invoice'] =$invjual_id;
	                 $dataresiinv['id_jenis_potongan'] = "3";
	                 $dataresiinv['jumlah_potongan'] = $countpembulatannya * $hargatertinggiresi->harga_jual;
	                 $dataresiinv['keterangan_potongan'] = "Pembulatan Resi 0.1 ".$dri->nomor_resi;
	                 // print_r($dataresiinv['jumlah_potongan']);
	                 $this->db->insert('potongan',$dataresiinv);
		               $jumlah_potong_resi_perbulan += $dataresiinv['jumlah_potongan'];
	               }
	             }
	           }
	           $id_resi_array = array();
	           $ongkos_perbulan05 = 0;
	           foreach($dataresi_inv as $dri){
	             if($dri->cbm <= 0.5){
	               $cek_pembulatan = 1;
	               $chargetambahan['id_invoice'] =$invjual_id;
	               $chargetambahan['id_jenis_potongan'] = "16";
	               $chargetambahan['jumlah_potongan'] = 100000;
	               $chargetambahan['keterangan_potongan'] = "Handling Fee Resi dibawah 0.5 m<sup>3</sup> ".$dri->nomor_resi;
	               // print_r($chargetambahan['jumlah_potongan']);
	               $this->db->insert('potongan',$chargetambahan);
	               $ongkos_perbulan05+=$chargetambahan['jumlah_potongan'];
	             }
	           }
	           if($cek_pembulatan == 1){
	             $statusinvoicenya = "Pembulatan 0.1";
	             $tagihan_jual = $total + $jumlah_potong_resi_perbulan + $biayatambahannya + $ongkos_perbulan05;
	           }else{
	             $statusinvoicenya = "Normal";
	             $tagihan_jual = $total + $biayatambahannya;
	           }
		 					 $pesankedev = "Generate ".$insert_invjual['kode_invoice']." Status ".$statusinvoicenya." Jumlah Tagihan ".number_format($tagihan_jual)." Jumlah Potongan ".$jumlah_potong_resi_perbulan." harga utama ".$total;
		 					 sendwhatsapp($pesankedev,"083815423599");

		 					 $update_invjual['total_tagihan'] = $tagihan_jual;
		 					 $this->db->where('id_invoice',$invjual_id);
		 					 $this->db->update('invoice', $update_invjual);

		 					 // Referal
		 					 $kurs_global = $this->db->where('id_kurs',1)->get('kurs')->row();
		 					 $komisi_global_barang = $kurs_global->komisi_barang;
		 					 if($id_referal > 0){
		 						 if($nama_customer == "Nurul Magfirah Putram"){
		 								 $total_komisi_nurul = 0;
		 								 $ket_komisi_nurul   = "";
		 							 foreach($data_invoice_product as $ils2){
		 								 $jumlahctns_nurul      = $ils2->jumlah;
		 								 $volume_nurul          = $jumlahctns_nurul * $ils2->volume;
		 								 $jenis_barang_id_nurul = $ils2->jenis_barang_id;
		 								 if($jenis_barang_id_nurul == 22){
		 									 $komisi_nurul     = $volume_nurul * 500000;
		 									 $ket_komisi_nurul .= $ils2->nomor." ".$volume_nurul."m<sup>3</sup> * Komisi 500000 ,";
		 								 }else{
		 									 $komisi_nurul     = $volume_nurul * 250000;
		 									 $ket_komisi_nurul .= $ils2->nomor." ".$volume_nurul."m<sup>3</sup> * Komisi 250000 ,";
		 								 }
		 								 $total_komisi_nurul += $komisi_nurul;
		 							 }
		 							 $get_referal = $this->db->where('id_cust',$id_cust)->get('customer')->row();
		 							 $input_referal['id_cust'] = $id_referal;
		 							 $input_referal['kode_komisi'] = $this->Mkomisi_referal->kode_komisi();
		 							 $input_referal['customer'] = $rowinvoice->kode;
		 							 $input_referal['id_invoice'] = $invjual_id;
		 							 $input_referal['nilai'] = $total_komisi_nurul;
		 							 $input_referal['keterangan'] = $ket_komisi_nurul;
		 							 $input_referal['status'] = 1;
		 							 // input
		 							 $this->db->insert('komisi_referal', $input_referal);
		 						 }else{
		 							 $get_referal = $this->db->where('id_cust',$id_cust)->get('customer')->row();
		 							 if($get_referal->komisi_barang == 0){
		 								 $komisifix  = $komisi_global_barang * $total_volume;
		 								 $ket_komisi = "Komisi Referal Global : ".$komisi_global_barang." * Total Volume : ".$total_volume;
		 							 }else{
		 								 $komisifix = $get_referal->komisi_barang * $total_volume;
		 								 $ket_komisi = "Komisi Referal Khusus : ".$get_referal->komisi_barang." * Total Volume : ".$total_volume;
		 							 }
		 							 $input_referal['id_cust'] = $id_referal;
		 							 $input_referal['kode_komisi'] = $this->Mkomisi_referal->kode_komisi();
		 							 $input_referal['customer'] = $rowinvoice->kode;
		 							 $input_referal['id_invoice'] = $invjual_id;
		 							 $input_referal['nilai'] = $komisifix;
		 							 $input_referal['keterangan'] = $ket_komisi;
		 							 $input_referal['status'] = 1;
		 							 // input
		 							 $this->db->insert('komisi_referal', $input_referal);
		 						 }
		 					 }

		 					 if($tagihan_jual <= 0){
		 						 die();
		 					 }
		 					 $data_invoice_product2 = $this->Mapiinvoice->get_invoice_product2($invjual_id)->num_rows();
		 					 if($data_invoice_product2 <= 0){
		 						 die();
		 					 }
		 					 // die();
		 					 // Info Ke Customer
		 					 $test['status'] =0;
		 					 $test['record_asuransi'] = $this->Minvoice_barang->cek_asuransi($invjual_id)->result();
		 					 $test['record'] = $this->Minvoice_barang->data_invoice($invjual_id)->row();
		 					 $test['barcode']= $this->Minvoice_barang->getinvoice_product($invjual_id)->result();
		 					 $test['potongan']=$this->Minvoice_barang->data_potongan($invjual_id)->result();
		 					 $data = $this->load->view('admin/invoice_barang/pdf_invoice',$test,True);

		 					 $mpdf = new \Mpdf\Mpdf();
		 					 $mpdf->WriteHTML($data);
		 					 $mpdf->Output("pdf_file/".time()."inv.pdf" ,'F');
		 					 $time=time()."inv.pdf";

		 					 $pesan = "*Yth. Bpk/Ibu ".$rowinvoice->nama." (".$rowinvoice->kode.")*\n\nBarang Anda akan segera sampai di gudang Jakarta kami. ".
		 											"Berikut kami lampirkan detail barang dan invoice barang ".$rowinvoice->kode_invoice." yang harus Anda bayar, yaitu sebesar *Rp. ".number_format($tagihan_jual).
		 											"* ke rekening berikut:\n\n*BCA 5810557747 a/n Gusmavin Willopo*\n\nHarap segera lakukan pembayaran agar barang dapat segera masuk dalam antrian pengiriman barang.".
		 											" Setelah melakukan pembayaran harap konfirmasi pembayaran Anda dengan menghubungi CS kami melalui telepon / WA.".
		 											"\n\nAlamat kirim : (".$nama_penerima.",".$telepon_penerima.",".$alamat_penerima.")".
		 											"\nJika ada perubahan alamat mendadak, harap segera informasikan ke CS kami!".
		 											"\nTerima kasih atas kerjasamanya :)".
		 											"\n\n*Wilopo Cargo* _(do not reply)_";

		 					 sendwhatsapp($pesan,$whatsapp);
		 					 $sendoc = send_newdoc($time,$whatsapp,$rowinvoice->kode_invoice);

		 					 sendwhatsapp($pesan,"081310961108");
		 					 $sendoc = send_newdoc($time,"081310961108",$rowinvoice->kode_invoice);

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

		 					 $content = $mpdf->Output('', 'S');
		 					 $this->load->library('email', $config);
		 					 $this->email->attach($content, 'attachment', $rowinvoice->kode_invoice , 'application/pdf');
		 					 $the_message="<html>
		 															 <body>
		 																			 <h3>Yth. ".$rowinvoice->kode." ,</h3>
		 																			 <p>Barang Anda akan segera sampai di gudang Jakarta kami. Berikut kami lampirkan detail barang dan invoice barang ".$rowinvoice->kode_invoice."
		 																					 yang harus Anda bayar, yaitu sebesar <b>Rp.".number_format($tagihan_jual)." </b>ke rekening berikut:</p>
		 																			 <p><b>BCA 5810557747 a/n Gusmavin Willopo</b></p>
		 																			 <p>Harap segera lakukan pembayaran agar barang dapat segera masuk dalam antrian pengiriman barang.</p>
		 																			 <p>Setelah melakukan pembayaran harap konfirmasi pembayaran Anda dengan menghubungi CS kami melalui telepon / WA.</p>
		 																			 <p>".nama_perusahaan()."</p>

		 															 </body>
		 												 </html>";

		 					 $this->email->set_newline("\r\n");
		 					 $this->email->from(user_email());
		 					 $this->email->to($mail_cust); //email tujuan. Isikan dengan emailmu!
		 					 $this->email->subject('[Wilopo Cargo] Invoice Barang '.$rowinvoice->kode_invoice);
		 					 $this->email->message($the_message);

		 					 if($this->email->send())
		 					 {
		 						 if($sendoc){
		 							$path_unlink = './'.$time;
		 							unlink($path_unlink );
		 						 }
		 					 }
		 					 else
		 					 {
		 						 //show_error($this->email->print_debugger());
		 					 }
		 			 }
				}
			}

		if($updatestok){
			$this->session->set_flashdata('msg','okstok');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	function sesuaikan(){
		$id = $this->uri->segment(4);
		$db2 = $this->load->database('db2', TRUE);
		$datagiwcont = $db2->select('giw.nomor,container_id,resi.nomor as nomor_resi')
												->from('giw')
												->join('customer', 'giw.customer_id=customer.id','left')
												->join('resi', 'giw.resi_id=resi.id','left')
												->where('giw.container_id',$id)
												->where('customer.broker_id',30)
												->get();
		$hitunggiw = $datagiwcont->num_rows();
		$giwnya = array();
		foreach($datagiwcont->result() as $dgc){
			$giwnya[] = $dgc->nomor;
			$cekgiwilopo = $this->db->select('giw.nomor')
															->from('giw')
															->where('nomor',$dgc->nomor)
															->get()
															->row();
			if($cekgiwilopo->nomor == null || $cekgiwilopo->nomor == ""){
				$insertsesuaikan['nomor_resi']= $dgc->nomor_resi;
				$insertsesuaikan['nomor']= $dgc->nomor;
				$insertsesuaikan['status_sesuaikan']= 0;
				$this->db->insert('sesuaikan_giw', $insertsesuaikan);
			}
		}
		$updgiwnya['container_id']= $id;
		$this->db->where_in('nomor',$giwnya)->update('giw', $updgiwnya);

		if($updgiwnya){
			redirect($_SERVER['HTTP_REFERER']);
		}
		// $db2 = $this->load->database('db2', TRUE);
		// $datagiwcont = $db2->select('nomor,container_id')
		// 										->from('giw')
		// 										->join('customer', 'giw.customer_id=customer.id','left')
		// 										->where('giw.container_id',$id)
		// 										->where('customer.broker_id',30)
		// 										->get()->row();
	}

	function complete_container(){
		$id_cont  = $this->input->post('id_cont');
		$updcont['status'] = 15;
		$updcont['tanggal_selesai'] = date('Y-m-d');
		$this->db->where('id_rts',$id_cont)->update('container',$updcont);
		redirect($_SERVER['HTTP_REFERER']);
	}



}
