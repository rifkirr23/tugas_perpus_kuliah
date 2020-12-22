<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice_barang extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		cek_session(); //cek session Login
		$this->load->model('Mapiinvoice');
		$this->load->model('Minvoice_lainnya');
		$this->load->model('Mbarang');
	  $this->load->model('Minvoice_barang');
	  $this->load->model('Mtransaksi');
	}

	//Function Halaman Awal Menu invoice
	function index(){
		$data['invoice'] = $this->db->select('sum((total_tagihan - jumlah_bayar)-total_potongan) as total_semua_tagihan')->where('tipe_invoice','barang')->from('invoice')->get()->row();
		$data['total_inv_jual'] = $this->db->where('tipe_invoice','barang')->from('invoice')->get()->num_rows();
		$data['total_inv_beli'] = $this->db->where('id_vendor',4)->from('invoice_beli')->get()->num_rows();
		$data['jenis_potongan'] = $this->db->get('jenis_potongan')->result();
		$data['bank']= $this->db->get('master_bank')->result();
		$this->template->load('template','admin/invoice_barang/invoice',$data);
	}

	//Function Get data Json invoice
	function get_invoice_json() {
    // header('Content-Type: application/json');
    echo $this->Minvoice_barang->get_invoice();
  }

	// Function get Data Invoice Barang By Id
  function get_invoiceid_json() {
    header('Content-Type: application/json');
    $id=$this->uri->segment(4);
    echo $this->Minvoice_barang->get_invoice_byid($id);
  }

	// Function get Data Invoice Barang By Id
  function get_invoiceidgrup_json() {
    header('Content-Type: application/json');
    $id=$this->uri->segment(4);
    echo $this->Minvoice_barang->get_invoice_byidgrup($id);
  }

  //Function View Index Pembayaran invoice
  function proses_invoice(){
    $id= $this->uri->segment(4);
    $inv= $this->Minvoice_barang->data_invoice($id)->row_array();
    include APPPATH. 'views/admin/invoice_barang/proses_invoice.php';
  }

	// Function View Index Pembayaran Deposit Invoice
  function deposit_invoice(){
    $id= $this->uri->segment(4);
    $jp= $this->Minvoice_barang->select_jp();
    //$gk= $this->Mpembayaran->get_keterangan($id)->result();
    $inv= $this->Minvoice_barang->data_invoice($id)->row_array();
    include APPPATH. 'views/admin/invoice_barang/deposit_invoice.php';
  }

	// Function Proses Pembayaran Invoice Barang
  function simpan_proses(){
    $data = $this->Minvoice_barang->pinvoice($this->input->post());
  }

	// Function Proses Pembayaran dengan Deposit
  function simpan_deposit(){
    $data = $this->Minvoice_barang->invdeposit($this->input->post());
  }

	// Function Detail Invoice Barang
  function detail(){
    $id = $this->uri->segment(4);
		$detail_inv = $this->db->where('id_invoice',$id)->get('invoice')->row();
		$parse['jenis_potongan'] = $this->db->get('jenis_potongan')->result();
		$parse['potongan'] = $this->db->where('id_invoice',$id)->get('potongan')->result();
		$parse['r'] = $this->Minvoice_barang->data_invoice($id)->row();
		$parse['record_asuransi'] = $this->Minvoice_barang->cek_asuransi($id)->result();
    $parse['invoicedetail']=$this->Minvoice_barang->getinvoice_product($id)->result();
    $parse['sub_pembayaran']=$this->Minvoice_barang->data_sub_pembayaran($id)->result();
    $parse['potongan']=$this->Minvoice_barang->data_potongan($id)->result();
		$parse['potongan_beli']=$this->Minvoice_barang->data_potongan_beli($detail_inv->id_invoice_beli)->result();
		$parse['semua_potongan']=$this->db->select('jenis_potongan.*,potongan.*')->from('potongan')
																			->join('jenis_potongan', 'jenis_potongan.id_jenis_potongan=potongan.id_jenis_potongan')
																	    ->where('id_invoice',$id)->or_where('id_invoice',$detail_inv->id_invoice_beli)->get()->result();

    $this->template->load('template','admin/invoice_barang/detail',$parse);
  }

	// Function Edit Item From Ajax
	function edit_potongan(){
		cek_session_all();
		$id = $this->uri->segment(4);
		$record = $this->db->where('id_potongan',$id)->get('potongan')->row();
		include APPPATH. 'views/admin/invoice_barang/edit_potongan.php';
	}

	function save_edit_potongan(){
		$potongan['jumlah_potongan'] = $this->input->post('jumlah_potongan');
		$potongan['keterangan_potongan'] = $this->input->post('keterangan_potongan');
		$this->db->where('id_potongan',$this->input->post('id_potongan'))->update('potongan',$potongan);

		$getinv = $this->db->where('id_invoice',$this->input->post('id_invoice'))->get('invoice')->row();
		$invoice['total_tagihan'] = ($getinv->total_tagihan - $this->input->post('jumlah_potongan_lama')) + $this->input->post('jumlah_potongan');
		$this->db->where('id_invoice',$this->input->post('id_invoice'))->update('invoice',$invoice);

		redirect(site_url('admin/invoice_barang/detail/'.$this->input->post('id_invoice')));
	}

	function bayar_deposit(){
		die();
		$id_inv = $this->uri->segment(4);
		$get_data_inv = $this->Minvoice_barang->data_invoice($id_inv)->row();//print_r($get_data_inv);die();
		include APPPATH. 'views/admin/invoice_barang/bayar_deposit.php';
	}

	function sesuaikan_invoice(){
		// die("on maintenance");
		$no_inv = $this->input->post('no_inv');
		// die($no_inv);
		// $curl_handle=curl_init();
		// curl_setopt($curl_handle,CURLOPT_URL,"https://office.rtsekspedisi.com/api/a_invoice/cek_inv_product");
		// curl_setopt($curl_handle, CURLOPT_POST, 1);
		// curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "no_inv=$no_inv");
		// $curlemail = curl_exec($curl_handle);
		// curl_close($curl_handle);
		// dd("ok");
		$cek_inv = $this->db->select('invoice.id_invoice,invoice.id_invoice_beli,invoice.id_surat_jalan,customer.id_cust,
																	customer.id_cgrup,customer.harga_otomatis,customer_grup.harga_otomatis_grup,
																	customer.id_referal')
												->from('invoice_beli')
												->join('invoice','invoice.id_invoice_beli=invoice_beli.id_invoice_beli','left')
												->join('customer','customer.id_cust=invoice.id_cust','left')
												->join('customer_grup','customer_grup.id_cgrup=customer.id_cgrup','left')
												->where('invoice_beli.note_invoice_beli',$no_inv)
												->get()->row();
		// live
		$db2 = $this->load->database('db2', TRUE);
		$dataproductlive = $db2->select('invoice_product.*,giw.nomor,giw.counter,resi.nomor as nomor_resi')
												->from('invoice_product')
												->join('invoice', 'invoice_product.inv_id=invoice.id','left')
												->join('giw', 'invoice_product.giw_id=giw.id','left')
												->join('resi', 'giw.resi_id=resi.id','left')
												->where('invoice.no_inv',$no_inv)
												->get()->result();
		foreach($dataproductlive as $dpl){
			$cek_resi = $this->db->where('nomor',$dpl->nomor_resi)->get('resi')->num_rows();
			if($cek_resi == 0){
				$dataresi = $db2->select('resi.*,customer.kode')
														->from('giw')
														->join('customer', 'resi.cust_id=customer.id','left')
														->join('resi', 'giw.resi_id=resi.id','left')
														->where('resi.nomor',$dpl->nomor_resi)
														->get()->row();
				$cekcs = $this->db->select('id_cust')
													->from('customer')
													->where('kode',$dataresi->kode)
													->get()->row();
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

				$datagiwresi = $db2->select('giw.*,container.status as contstatus')
														->from('giw')
														->join('resi', 'resi.id=giw.resi_id', 'left')
														->join('container', 'giw.container_id=container.id','left')
														->where('resi.nomor',$dpl->nomor_resi)
														->get()->result();

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
          $insert_brcd['resi_id']=  $resi_id;
          $insert_brcd['harga_jual']=  $harga_jual;
          $insert_brcd['status_berat']= $statusgiw;
          $insert_brcd['jalur']= $dgr->jalur;
          $insert_brcd['status_jalur']= 0;
					$savegiw = $this->db->insert('giw', $insert_brcd);
					$giwid = $this->db->insert_id();
			 } //foreach giw
		 }else{ //jika ada resi
			 $datagiwresi = $db2->select('giw.*,container.status as contstatus')
													 ->from('giw')
													 ->join('resi', 'resi.id=giw.resi_id', 'left')
													 ->join('container', 'giw.container_id=container.id','left')
													 ->where('resi.nomor',$dpl->nomor_resi)
													 ->get()->result();
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
				 $insert_brcd['resi_id']=  $resi_id;
				 $insert_brcd['harga_jual']=  $harga_jual;
				 $insert_brcd['status_berat']= $statusgiw;
				 $insert_brcd['jalur']= $dgr->jalur;
				 $insert_brcd['status_jalur']= 0;
				 $savegiw = $this->db->insert('giw', $insert_brcd);
				 $giwid = $this->db->insert_id();
		  }//foreach giw
		}//jika ada resi
		$get_barcode = $this->db->select('giw.*,customer.kode')->from('giw')
														->join('customer','giw.customer_id=customer.id_cust','left')
														->where('giw.nomor',$dpl->nomor)->get()->row();
		$cekproduct = $this->db->where('id_giw',$get_barcode->id)->where('id_invoice',$cek_inv->id_invoice)->get('invoice_product')->num_rows();
		//echo json_encode($nomor_giw[$i]);die();
		if($cekproduct == 0){
			$invoice_product['id_giw']= $get_barcode->id;
			$invoice_product['id_sj']= $cek_inv->id_surat_jalan;
			$invoice_product['id_invoice']= $cek_inv->id_invoice;
			$invoice_product['id_invoice_beli']= $cek_inv->id_invoice_beli;
			$invoice_product['id_sj_rts']= $dpl->sj_id;
			$invoice_product['jumlah']= $dpl->jumlah;
			$this->db->insert('invoice_product',$invoice_product);

			$giw['counter']= $dpl->counter;
			$giw['status']= 5;
			$this->db->where('id', $get_barcode->id);
			$this->db->update('giw',$giw);
		}
	 }// foreach product $dataproductlive
	 // die("ok");
	 $invjual_id = $cek_inv->id_invoice;
	 $inv_id     = $cek_inv->id_invoice_beli;
	 $id_cust           =$cek_inv->id_cust;
	 $id_cgrup          =$cek_inv->id_cgrup;
	 $harga_otomatis    =$cek_inv->harga_otomatis;
	 $harga_otomatis_grup=$cek_inv->harga_otomatis_grup;
	 $id_referal        =$cek_inv->id_referal;
	 // Update invoice
	 // Update Invoice Asuransi dengan Id Invoice Jika Barang ber asuransi
	 $giwbyresi=$this->db->select('giw.customer_id,giw.resi_id')->from('invoice_product')->join('giw','giw.id=invoice_product.id_giw','left')
												->where('invoice_product.id_invoice',$invjual_id)->group_by('giw.resi_id')->get()->result();
												// echo "oke"; print_r($giwbyresi);die();
		foreach ($giwbyresi as $gbr) {
			$getinvasr=$this->db->where('id_resi',$gbr->resi_id)->where('id_invoice',0)->get('invoice_asuransi')->num_rows();
			if($getinvasr > 0){
				$update_asr['id_invoice']= $invjual_id;
				$this->db->where('id_resi',$gbr->resi_id)->where('id_invoice',0)->update('invoice_asuransi',$update_asr);
			}else{

			}
		}

		$selectasuransi=$this->db->select("sum(jumlah_asuransi) as jumlah")->from('invoice_asuransi')->where('id_invoice', $invjual_id)->get()->row();
		$asuransiinvoice=@$selectasuransi->jumlah;

		$jumlah=0; $total=0; $totalsamping=0;
		$data_invoice_product = $this->Mapiinvoice->get_invoice_product($inv_id)->result();
		foreach($data_invoice_product as $ils){
			// Cek Harga Khusus
			$cekhargacustomer = $this->Mbarang->data_hbc($ils->id_cust,$ils->jenis_barang_id)->num_rows();
			$cekhargagrup     = $this->Mbarang->data_hbcg($id_cgrup,$ils->jenis_barang_id)->num_rows();
			if($id_cgrup > 0 && $cekhargagrup > 0){
				$dhbc = $this->Mbarang->data_hbcg($id_cgrup,$ils->jenis_barang_id)->row();
				$hj   = $dhbc->harga;
				$updhargakhusus['harga_jual'] = $hj;
				$this->db->where('nomor',$ils->nomor)->update('giw',$updhargakhusus);
			}else if($id_cgrup > 0 && $cekhargagrup == 0 && $cekhargacustomer == 0 && $harga_otomatis_grup == 1){
				$month = date("m",strtotime($ils->tanggal));
				$cek_cbm = $this->db->select('sum(ctns*volume) as jumlah')->from('giw')
													 ->join('resi','giw.resi_id=resi.id_resi','left')
													 ->join('customer', 'giw.customer_id=customer.id_cust', 'left')
													 ->where('customer.id_cgrup',$id_cgrup)
													 ->where('month(resi.tanggal)',$month)
													 ->get()->row();
				if($cek_cbm->jumlah > 10){
					$updhargakhusus2['harga_jual'] = $ils->harga_jual - 500000;
					$this->db->where('nomor',$ils->nomor)->update('giw',$updhargakhusus2);
				}
			}else if($cekhargacustomer > 0){
			 $dhbc = $this->Mbarang->data_hbc($ils->id_cust,$ils->jenis_barang_id)->row();
			 $hj   = $dhbc->harga;
			 $updhargakhusus['harga_jual'] = $hj;
			 $this->db->where('nomor',$ils->nomor)->update('giw',$updhargakhusus);
		 }else if($cekhargacustomer == 0 && $harga_otomatis == 1){
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
		$update_invb['jumlah_invoice_beli'] = $total;
		if($insert_inv['jumlah_dari_vendor'] != $update_invb['jumlah_invoice_beli']){
			$update_invb['status_hitung'] = 1;
		}
		$this->db->where('id_invoice_beli',$inv_id);
		$this->db->update('invoice_beli', $update_invb);

		// Row Inv
		$rowinvoice = $this->Minvoice_barang->data_invoice($invjual_id)->row();

		$jumlah=0; $total=0; $totalsamping=0; $total_volume=0; $total_diskon=0; $jumlah_diskon =0;
		$data_invoice_product = $this->Mapiinvoice->get_invoice_product($inv_id)->result();
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
																->where('invoice_product.id_invoice_beli',$inv_id)
																->group_by("resi.id_resi")
																->get()->result();
		if($dataresi->cbm < 2){
			$jumlah_potong_resi_perbulan = 0;
			foreach($dataresi_inv as $dri){
				$hargatertinggiresi = $this->db->select('giw.harga_jual')->from('giw')->where('giw.resi_id',$dri->resi_id)->order_by('giw.harga_jual','desc')->limit(1)->get()->row();
				if($dri->cbm <= 0.1){
					$cektambahan   = $this->db->where('id_invoice',$invjual_id)->where('id_jenis_potongan',3)->like('keterangan_potongan',$dri->nomor_resi)->get('potongan')->num_rows();
					if($cektambahan == 0){
						$countpembulatannya = 0.1-$dri->cbm ;
						$cek_pembulatan = 1;
						$dataresiinv['id_invoice'] =$invjual_id;
						$dataresiinv['id_jenis_potongan'] = "3";
						$dataresiinv['jumlah_potongan'] = $countpembulatannya * $hargatertinggiresi->harga_jual;
						$dataresiinv['keterangan_potongan'] = "Pembulatan Resi 0.1 ".$dri->nomor_resi;
						// print_r($dataresiinv['jumlah_potongan']);
						$this->db->insert('potongan',$dataresiinv);
					}
				}
				$jumlah_potong_resi_perbulan += $dataresiinv['jumlah_potongan'];
			}
		}
		$id_resi_array = array();

		$cektambahancharge   = $this->db->where('id_invoice',$invjual_id)->where('id_jenis_potongan',16)->like('keterangan_potongan',$dri->nomor_resi)->get('potongan')->num_rows();
		if($cektambahancharge == 0){
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
		}
		$get_potonganinv = $this->db->select('sum(jumlah_potongan) as total')
																->from('potongan')
																->where('id_invoice',$invjual_id)
																->where('tipe_potongan is null',null,false)
																->get()->row();
		if($cek_pembulatan == 1){
			$statusinvoicenya = "Pembulatan 0.1";
			$tagihan_jual = $total + $jumlah_potong_resi_perbulan + $biayatambahannya + $chargekirim + $get_potonganinv->total;
		}else{
			$statusinvoicenya = "Normal";
			$tagihan_jual = $total + $biayatambahannya + $chargekirim + $get_potonganinv->total;
		}
		$get_potonganbeli = $this->db->select('sum(jumlah_potongan) as total')
																->from('potongan')
																->where('id_invoice',$inv_id)
																->where('tipe_potongan','beli')
																->get()->row();
		$getinvbelih = $this->db->where('id_invoice_beli',$inv_id)->get('invoice_beli')->row();
		$pesankedev = "Generate ".$insert_invjual['kode_invoice']." Status ".$statusinvoicenya." Jumlah Tagihan ".number_format($tagihan_jual)." Jumlah Potongan ".$jumlah_potong_resi_perbulan." harga utama ".$total;
		sendwhatsapp($pesankedev,"083815423599");
		$db2 = $this->load->database('db2', TRUE);
		$livebeli = $db2->select('jumlah')
											 ->from('invoice')
											 ->where('no_inv',$getinvbelih->note_invoice_beli)
											 ->get()->row();
		$update_invjual['total_tagihan'] = $tagihan_jual;
		$this->db->where('id_invoice',$invjual_id);
		$this->db->update('invoice', $update_invjual);

		$updinvbelipot['jumlah_invoice_beli'] = $getinvbelih->jumlah_invoice_beli + $get_potonganbeli->total;
		$updinvbelipot['jumlah_dari_vendor'] = $livebeli->jumlah;
		$this->db->where('id_invoice_beli',$inv_id);
		$saveinvbel = $this->db->update('invoice_beli', $updinvbelipot);

	 if($saveinvbel){
			redirect(site_url('admin/invoice_barang/detail/'.$this->input->post('id_invoice')));
	 }
	}

	function excel_tagihan_laut(){
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=invoiceWC.xls");
		$data['gettagihan'] = $this->db->select('invoice.id_invoice,invoice.tipe_invoice,invoice.status_invoice,invoice.kode_invoice,invoice.tanggal_invoice,
                               invoice.total_tagihan,invoice.encrypt_invoice,invoice.jumlah_bayar,invoice.total_potongan,customer.id_cust,
                               customer.kode,customer.email,customer.deposit,customer_grup.kode_cgrup,customer_grup.id_cgrup,customer.fix_alamat')
				    ->from('invoice')
				    ->join('customer', 'invoice.id_cust=customer.id_cust')
				    ->join('customer_grup', 'customer.id_cgrup=customer_grup.id_cgrup')
						->where('invoice.tanggal_invoice >=','2020-08-01')
				    ->where('invoice.tipe_invoice','barang')
						->where('invoice.status_invoice',0)
						->get()->result();
		$this->load->view('admin/invoice_barang/excelunpaid',$data);
	}

	function sesuaikan_jumlah(){
		// dd($this->input->post());
		$id_invoice = $this->input->post('id_invoice');
		$total_sebenarnya = $this->input->post('totalsebenarnya');
		$updinv['total_tagihan'] = $total_sebenarnya;
		$this->db->where('id_invoice',$id_invoice)->update('invoice',$updinv);
		redirect($_SERVER['HTTP_REFERER']);
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

}
