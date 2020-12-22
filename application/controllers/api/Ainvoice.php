<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ainvoice extends CI_Controller {

	public function __construct(){
		parent::__construct();
		  $this->load->model('Mapiinvoice');
			$this->load->model('Minvoice_lainnya');
			$this->load->model('Mbarang');
			$this->load->model('Minvoice_barang');
			$this->load->model('Mkomisi_referal');
	}

	function oke(){
		$cek_customer = $this->db->select('customer.id_kota2,master_ekspedisi_lokal.tipe_ekspedisi')->from('customer')
                             ->join('master_ekspedisi_lokal', 'customer.id_ekspedisi=master_ekspedisi_lokal.id_ekspedisi','left')
                             ->where('kode',"123/WC-JTJO")
                             ->get()->row();dd($cek_customer);
	}

	function tesajayakk(){
		$kodesj = "SJ-20/01938";
		$customer_kode = "123/WC-HRMNT";
		$tgl = date('Y-m-d');
		$kodeinv = "INV-20/01913";
		$total = "14352660";
		$idsj = "18018";
		$curl_handle=curl_init();
    curl_setopt($curl_handle,CURLOPT_URL,'http://office.wilopocargo.com/api/ainvoice/generate_invoice');
    curl_setopt($curl_handle, CURLOPT_POST, 1);
    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "no_sj=$kodesj&customer_kode=$customer_kode&tanggal=$tgl&no_inv=$kodeinv&jumlah_invoice=$total&id_sj_rts=$idsj");
    $res = curl_exec($curl_handle);
    curl_close($curl_handle);
  }

	function scan_barcode(){
		// die("oke");
		$this->Mapiinvoice->scan_barcode();
	}

	function scan_barcode2(){
		// die();
		// sendwhatsapp("asasas","083815423599");
		$nomor_giw = $this->input->post('giw_array');
		$scan_input= $this->input->post('scan_array');
		$counter   = $this->input->post('jmlh_counter');
		// print_r($this->input->post());die();
		$jumlah_array = count($nomor_giw);
		// $pesandev   = "Scan Barcode ".$jumlah_array;
		// sendwhatsapp($pesandev,"083815423599");
		for ($i=0; $i<$jumlah_array; $i++) {
			$get_barcode = $this->db->select('giw.*')->from('giw')->where('giw.nomor',$nomor_giw[$i])->get()->row();
			//echo json_encode($nomor_giw[$i]);die();
			$invoice_product['id_giw']= $get_barcode->id;
			$invoice_product['id_sj']= 0;
			$invoice_product['id_invoice']= 0;
			$invoice_product['id_invoice_beli']= 0;
			$invoice_product['jumlah']= $scan_input[$i];
			$this->db->insert('invoice_product',$invoice_product);

			$giw['counter']= $counter[$i];
			$giw['status']= 5;
			$this->db->where('id', $get_barcode->id);
			$this->db->update('giw',$giw);
		}
		// sendwhatsapp("asasas","083815423599")
		die("oke");
		// $this->Mapiinvoice->scan_barcode2();
	}

  function generate_invoice(){
    $this->Mapiinvoice->generate_invoice();
  }

	function tesgenerate_invoice(){
		// echo "ok ";die();
		$id_sj  = 1;
		$marking= "123/WC-UMI";
		$no_sj = "sj";
		$tgl = "2020-08-18";
		$no_inv = "INV/20/08/08796";
		$jml_inv = "0";
    $this->Mapiinvoice->generate_invoice2($id_sj,$marking,$no_sj,$tgl,$no_inv,$jml_inv);
  }

	function insert_potongan_beli(){
		sendwhatsapp("potongan beli","083815423599");
		$getinvoicebeli = $this->db->select('invoice.*,invoice_beli.*')->from('invoice')
															 ->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli', 'left')
															 ->where('invoice_beli.note_invoice_beli',$this->input->post('no_inv'))
															 ->where('invoice_beli.id_vendor',4)->get()->row();
		// var_dump($getinvoicebeli);die();
		$invoice['jumlah_dari_vendor'] = $getinvoicebeli->jumlah_dari_vendor + ($this->input->post('jumlah_potongan'));
    $this->db->where('note_invoice_beli',$this->input->post('no_inv'))->where('id_vendor',4)->update('invoice_beli', $invoice);

		// $potongan_beli['id_invoice'] = $getinvoicebeli->id_invoice_beli;
		// $potongan_beli['id_jenis_potongan'] = 5;
		// $potongan_beli['tipe_potongan'] = "beli_vendor";
		// $potongan_beli['jumlah_potongan'] = round($this->input->post('jumlah_potongan'));
		// $potongan_beli['keterangan_potongan'] = $this->input->post('note');
		// $potongan_beli['id_potongan_rts'] = $this->input->post('id_invoice_lainnya');
		// $this->db->insert('potongan',$potongan_beli);
  }

	function delete_potongan_beli(){
		sendwhatsapp("delete potongan beli","083815423599");
		// potongan
		$getpotongan = $this->db->where('id_potongan_rts',$this->input->post('id_invoice_lainnya'))->get('potongan')->row();
		$getinvbeli  = $this->db->where('id_invoice_beli',$getpotongan->id_invoice)->get('invoice_beli')->row();
		//
		$invoice['jumlah_dari_vendor'] = $getinvbeli->jumlah_dari_vendor - ($getpotongan->jumlah_potongan);
    $this->db->where('id_invoice_beli',$getinvbeli->id_invoice_beli)->update('invoice_beli', $invoice);

		$this->db->where('id_potongan_rts',$this->input->post('id_invoice_lainnya'))->delete('potongan');
  }

	function delete_potongan_beli_khusus(){
		sendwhatsapp("delete potongan beli","083815423599");
		// potongan
		$getpotongan = $this->db->where('id_potongan_rts',$this->input->post('id_invoice_lainnya'))->get('potongan')->row();
		$getinvbeli  = $this->db->where('id_invoice_beli',$getpotongan->id_invoice)->get('invoice_beli')->row();
		//
		$invoice['jumlah_invoice_beli'] = $getinvbeli->jumlah_invoice_beli - ($getpotongan->jumlah_potongan);
		$invoice['jumlah_dari_vendor']  = $getinvbeli->jumlah_dari_vendor - ($getpotongan->jumlah_potongan);
    $this->db->where('id_invoice_beli',$getinvbeli->id_invoice_beli)->update('invoice_beli', $invoice);

		$this->db->where('id_potongan_rts',$this->input->post('id_invoice_lainnya'))->delete('potongan');
  }

	function add_idsj_rts(){
		// sendwhatsapp("add id sj rts","083815423599");
		$id_sj_rts = $this->input->post('id_sj_rts');
		$nomor_giw = $this->input->post('nomor_giw');
		// $marking   = $this->input->post('customer_kode');
		// $get_customer = $this->db->where('kode',$marking)->get('customer')->row();
		// $id_cust   = $get_customer->id_cust;
		$get_giw = $this->db->where('nomor',$nomor_giw)->get('giw')->row();
		$id_giw  = $get_giw->id;
		//Update Invoice Product
    $sql = "UPDATE invoice_product AS ud JOIN giw AS u ON ud.id_giw = u.id SET ud.id_sj_rts = $id_sj_rts
            WHERE ud.id_sj = 0 and u.id = $id_giw";
    $this->db->query($sql);
	}

	function cron_generate_invoice(){
		die();
    $this->Mapiinvoice->cron_generate_invoice();
  }

	function cancel_scan(){
		sendwhatsapp("Delete Sj Dan Delete Invoice Product","083815423599");
		$id_sj_rts = $this->input->post('id_sj_rts');
		//delete Invoice Product
		$this->db->where('id_sj_rts',$id_sj_rts)->delete('invoice_product');
	}

	function info_gudang(){
	 die();
	}

	// function cek_alamat(){
	//  	$kode = $this->input->post('kode');
	// 	$id_sj_rts = $this->input->post('id_sj_rts');
	// 	$boleh_kirim = $this->input->post('boleh_kirim');
	// 	$id_sj_rts = $this->input->post('id_sj_rts');
	// 	$cek_customer = $this->db->select('customer.id_kota2')->from('customer')->where('kode',$kode)->get()->row();
	// 	if($cek_customer->id_kota2 == "3175" || $cek_customer->id_kota2 == "3174"){
	// 		// send curl to rts
	// 		$curl_handle=curl_init();
	// 		curl_setopt($curl_handle,CURLOPT_URL,"https://office.rtsekspedisi.com/api/a_invoice/update_boleh_kirim");
	// 		curl_setopt($curl_handle, CURLOPT_POST, 1);
	// 		curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "id_sj=$id_sj_rts");
	// 		$curlemail = curl_exec($curl_handle);
	// 		curl_close($curl_handle);
	// 	}
	// }

	function info_gudang2(){
		sendwhatsapp("whatsapp Grup Pengiriman","083815423599");
		$getinv = $this->db->select('invoice.id_invoice,customer.fix_alamat,invoice.kode_invoice,customer.kode')->from('invoice_product')
									     ->join('invoice', 'invoice.id_invoice=invoice_product.id_invoice', 'left')
											 ->join('customer', 'invoice.id_cust=customer.id_cust', 'left')
											 ->where('id_sj_rts',19591)->limit(1)->get()->row();
											 print_r($getinv);die();
		if($getinv->fix_alamat == 1){
			$invoice['status_boleh_kirim'] = 1;
			$invoice['tanggal_kasih_alamat'] = date('Y-m-d');
			$this->db->where('id_invoice',$getinv->id_invoice)->update('invoice',$invoice);
			$pesan  = "Informasi Alamat ".$this->input->post('no_sj')."\n".$this->input->post('kode')."\n".$this->input->post('nama')."\n".
								"".$this->input->post('telepon')."\n\n".$this->input->post('alamat');
			// Whatsapp Pengiriman
			whatsapp_grup("1554363574",$pesan,"6281293972529");
		}else{
			$invoice['status_boleh_kirim'] = 1;
			$this->db->where('id_invoice',$getinv->id_invoice)->update('invoice',$invoice);
			$pesan  = "*Alamat Tidak Fix*".
								"\n\nKode Invoice : ".$getinv->kode_invoice.
								"\nKode Marking : ".$getinv->kode.
								"\nNo SJ : ".$this->input->post('no_sj').
								"\n\n_Segera fix alamat customer agar barang cepat dikirim_";
			sendwhatsapp($pesan,"6281299053976");
		}
	}

	function status_berat_send(){
		die();
		// $kode = $this->input->post('kode');
		// $id_container = $this->input->post('id_container');
		// $sql = "UPDATE giw AS gi JOIN customer AS cust ON cust.id_cust = gi.customer_id SET gi.status_berat = 2
		//  				WHERE cust.kode = $kode and gi.container_id = $id_container";
    // $this->db->query($sql);
	}

	function insert_potongan_beli_khusus(){
		sendwhatsapp("potongan beli","083815423599");
		$get_potongan_beli = $this->db->select('potongan.*')->where('tipe_potongan',"beli")->get('potongan')->result();
		print_r($get_potongan_beli);die();
		foreach ($get_potongan_beli as $gpb ) {
			// potongan
			$getpotongan = $this->db->where('id_potongan',$gpb->id_potongan)->get('potongan')->row();
			$getinvbeli  = $this->db->where('id_invoice_beli',$getpotongan->id_invoice)->get('invoice_beli')->row();
			//
			$invoice['jumlah_dari_vendor'] = $getinvbeli->jumlah_dari_vendor - ($getpotongan->jumlah_potongan);
	    $this->db->where('id_invoice_beli',$getinvbeli->id_invoice_beli)->update('invoice_beli', $invoice);
			$this->db->where('id_potongan',$gpb->id_potongan)->delete('potongan');
		}
  }

	function fix_harga_beli(){
		// sendwhatsapp("Set inv beli","083815423599");
		$inv['jumlah_dari_vendor'] = $this->input->post('jumlah');
		$this->db->where('note_invoice_beli',$this->input->post('no_inv'))->update('invoice_beli',$inv);
  }

	function create_invoice(){
		//Insert Invoice Rts
		$getcust = $this->db->where('kode',"123/WC-JASONWJY")->get('customer')->row();
    $insert_inv['kode_invoice_beli']= $this->Mapiinvoice->kode_beli();
    $insert_inv['note_invoice_beli']= "INV/20/08/10324";
    $insert_inv['id_cust']= $getcust->id_cust;
    $insert_inv['tanggal_invoice_beli']="2020-08-31";
    $insert_inv['status_invoice_beli']=1;
    $insert_inv['id_vendor']=4;
    $insert_inv['jumlah_invoice_beli']=0;
    $insert_inv['jumlah_bayar_invoice_beli']=0;
    $insert_inv['jumlah_dari_vendor']= 1;

    $this->db->insert('invoice_beli', $insert_inv);
    $inv_id = $this->db->insert_id();

    $insert_invjual['id_invoice_beli']= $inv_id;
    $insert_invjual['id_cust']        = $getcust->id_cust;
    $insert_invjual['id_surat_jalan'] = 1;
    $insert_invjual['kode_invoice']   = $this->Mbarang->code_invoice_barang();
    $insert_invjual['tanggal_invoice']= "2020-08-31" ;
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
	}
	function fix_invoice(){
		// die("oke");
		// sendwhatsapp("Tes Ajaaa Niii yee asaxax","083815423599");
		$nomor_giw = $this->input->post('giw_array');
		$scan_input= $this->input->post('scan_array');
		$counter   = $this->input->post('jmlh_counter');
		$id_sj     = $this->input->post('id_sj_array');
		$no_inv_array  = $this->input->post('no_inv_array')[0];
		$cek_inv = $this->db->select('invoice.id_invoice,invoice.id_invoice_beli,invoice.id_surat_jalan,customer.id_cust,
																	customer.id_cgrup,customer.harga_otomatis,customer_grup.harga_otomatis_grup,
																	customer.id_referal')
												->from('invoice_beli')
												->join('invoice','invoice.id_invoice_beli=invoice_beli.id_invoice_beli','left')
												->join('customer','customer.id_cust=invoice.id_cust','left')
												->join('customer_grup','customer_grup.id_cgrup=customer.id_cgrup','left')
												->where('invoice_beli.note_invoice_beli',$no_inv_array)
												->get()->row();
		// sendwhatsapp("Tes Ajaaa Niii yee ","083815423599");
		$jumlah_array = count($nomor_giw);
		$nomor_barcode = "";
		// sendwhatsapp("Tes Ajaaa Niii yee ".$jumlah_array,"083815423599");
		// $invoice_product = "";
		// $this->db->where('id_sj_rts',$id_sj[0])->delete('invoice_product');
		for ($i=0; $i<$jumlah_array; $i++) {
			// $invoice_product = "";
			$get_barcode = $this->db->select('giw.*,customer.kode')->from('giw')
															->join('customer','giw.customer_id=customer.id_cust','left')
															->where('giw.nomor',$nomor_giw[$i])->get()->row();
			$cekbarcode = $this->db->where('id_giw',$get_barcode->id)->where('id_invoice',$cek_inv->id_invoice)->get('invoice_product')->num_rows();
			//echo json_encode($nomor_giw[$i]);die();
			if($cekbarcode == 0){
				$invoice_product['id_giw']= $get_barcode->id;
				$invoice_product['id_sj']= $cek_inv->id_surat_jalan;
				$invoice_product['id_invoice']= $cek_inv->id_invoice;
				$invoice_product['id_invoice_beli']= $cek_inv->id_invoice_beli;
				$invoice_product['id_sj_rts']= $id_sj[$i];
				$invoice_product['jumlah']= $scan_input[$i];
				$this->db->insert('invoice_product',$invoice_product);

				$giw['counter']= $counter[$i];
				$giw['status']= 5;
				$this->db->where('id', $get_barcode->id);
				$this->db->update('giw',$giw);
				$nomor_barcode .= "\n".$nomor_giw[$i]." Customer : ".$get_barcode->kode;
			}
			// sendwhatsapp("Tes Ajaaa Niii yee asaxax".$i,"083815423599");
		}
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
     $this->db->update('invoice_beli', $updinvbelipot);

     // // Referal
     // $kurs_global = $this->db->where('id_kurs',1)->get('kurs')->row();
     // $komisi_global_barang = $kurs_global->komisi_barang;
     // if($id_referal > 0){
     //   if($nama_customer == "Nurul Magfirah Putram"){
     //       $total_komisi_nurul = 0;
     //       $ket_komisi_nurul   = "";
     //     foreach($data_invoice_product as $ils2){
     //       $jumlahctns_nurul      = $ils2->jumlah;
     //       $volume_nurul          = $jumlahctns_nurul * $ils2->volume;
     //       $jenis_barang_id_nurul = $ils2->jenis_barang_id;
     //       if($jenis_barang_id_nurul == 22){
     //         $komisi_nurul     = $volume_nurul * 500000;
     //         $ket_komisi_nurul .= $ils2->nomor." ".$volume_nurul."m<sup>3</sup> * Komisi 500000 ,";
     //       }else{
     //         $komisi_nurul     = $volume_nurul * 250000;
     //         $ket_komisi_nurul .= $ils2->nomor." ".$volume_nurul."m<sup>3</sup> * Komisi 250000 ,";
     //       }
     //       $total_komisi_nurul += $komisi_nurul;
     //     }
     //     $get_referal = $this->db->where('id_cust',$id_referal)->get('customer')->row();
     //     $input_referal['id_cust'] = $id_referal;
     //     $input_referal['kode_komisi'] = $this->Mkomisi_referal->kode_komisi();
     //     $input_referal['customer'] = $rowinvoice->kode;
     //     $input_referal['id_invoice'] = $invjual_id;
     //     $input_referal['nilai'] = $total_komisi_nurul;
     //     $input_referal['keterangan'] = $ket_komisi_nurul;
     //     $input_referal['status'] = 1;
     //     // input
     //     $this->db->insert('komisi_referal', $input_referal);
     //   }else{
     //     $get_referal = $this->db->where('id_cust',$id_referal)->get('customer')->row();
     //     if($get_referal->komisi_barang == 0){
     //       $komisifix  = $komisi_global_barang * $total_volume;
     //       $ket_komisi = "Komisi Referal Global : ".$komisi_global_barang." * Total Volume : ".$total_volume;
     //     }else{
     //       $komisifix = $get_referal->komisi_barang * $total_volume;
     //       $ket_komisi = "Komisi Referal Khusus : ".$get_referal->komisi_barang." * Total Volume : ".$total_volume;
     //     }
     //     $input_referal['id_cust'] = $id_referal;
     //     $input_referal['kode_komisi'] = $this->Mkomisi_referal->kode_komisi();
     //     $input_referal['customer'] = $rowinvoice->kode;
     //     $input_referal['id_invoice'] = $invjual_id;
     //     $input_referal['nilai'] = $komisifix;
     //     $input_referal['keterangan'] = $ket_komisi;
     //     $input_referal['status'] = 1;
     //     // input
     //     $this->db->insert('komisi_referal', $input_referal);
     //   }
     // }

	}

	function update_tanggal_kirim(){
		sendwhatsapp("Invoice Tanggal Kirim ".$this->input->post('no_inv'),"083815423599");
		$no_inv = $this->input->post('no_inv');
		$getinv = $this->db->select('invoice.id_invoice,customer.fix_alamat,invoice.kode_invoice,customer.kode,invoice.tanggal_invoice,customer.id_cust,
                                 surat_jalan.no_sj,customer.alamat,customer.whatsapp,customer.ekspedisi_lokal,customer.nama,
                                 pengguna.whatsapp,crm.whatsapp as wacrm,invoice.tanggal_kasih_alamat')
											 ->from('invoice')
											 ->join('customer', 'invoice.id_cust=customer.id_cust', 'left')
											 ->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli', 'left')
                       ->join('pengguna', 'pengguna.id_pengguna=customer.id_pendaftar')
                   		 ->join('pengguna as crm', 'crm.id_pengguna=customer.id_crm')
                       ->join('surat_jalan', 'surat_jalan.id_surat_jalan=invoice.id_surat_jalan', 'left')
											 ->where('note_invoice_beli',$no_inv)
											 ->get()->row();

											 // print_r($getinv);die();

		if($getinv->tanggal_kasih_alamat != "" || $getinv->tanggal_kasih_alamat != null){
			$invoice['status_boleh_kirim'] = 1;
			$invoice['status_pengiriman'] = 1;
			$invoice['tanggal_kirim'] = date('Y-m-d');
			$this->db->where('id_invoice',$getinv->id_invoice)->update('invoice',$invoice);
		}else if($getinv->tanggal_kasih_alamat == "" || $getinv->tanggal_kasih_alamat == null){
			$invoice['status_boleh_kirim'] = 1;
			$invoice['status_pengiriman'] = 1;
			$invoice['tanggal_kirim'] = date('Y-m-d');
			$invoice['tanggal_kasih_alamat'] = date('Y-m-d');
			$this->db->where('id_invoice',$getinv->id_invoice)->update('invoice',$invoice);

			$tanggal_kasih_alamat  = strtotime(date('Y-m-d'));
			$tanggal_invoice    = strtotime($getinv->tanggal_invoice);
			$diff   = $tanggal_kasih_alamat - $tanggal_invoice;
			$jumlah_hari = floor($diff / (60 * 60 * 24)) - 7 ;// diskon 7 hari
			if($jumlah_hari > 0){
				// sendwhatsapp("inv sewa gudang","083815423599");
				$invprod = $this->db->select('sum(giw.ctns * giw.volume) as jumlah_cbm')->from('invoice_product')
														->join('invoice', 'invoice.id_invoice=invoice_product.id_invoice', 'left')
														->join('giw', 'giw.id=invoice_product.id_giw', 'left')
														->where('invoice.id_invoice',$getinv->id_invoice)->get()->row();
				$jumlah_cbm = $invprod->jumlah_cbm;
				$harga_sewa = (5000 * $jumlah_cbm) * $jumlah_hari;
				$id_kategori_il = 6;
				$keterangan = "Sewa Gudang ".$getinv->kode_invoice;
				$this->Minvoice_lainnya->save_bypengiriman($getinv->id_cust,$harga_sewa,$id_kategori_il,$getinv->id_invoice,$keterangan,$jumlah_hari);
			}
		}
	}

	function add_container_wc(){
		// $insertcontainer['id_rts']= $this->input->post('idcont');
		// $insertcontainer['nomor']= $this->input->post('nomorcont');
		// $insertcontainer['kode']= $this->input->post('kodecont');
		// $insertcontainer['status']= $this->input->post('statuscont');
		// $insertcontainer['tanggal_berangkat_c']= $this->input->post('tanggal_berangkat');
		// $insertcontainer['tanggal_monitoring_c']= $this->input->post('tanggal_monitoring');
		// $insertcontainer['tanggal_arrived_c']= $this->input->post('tanggal_tiba');
		// $this->db->insert('container',$insertcontainer);
		$noinv   = $this->input->post('no_inv');
		$getdata = $this->db->select('invoice_product.id_invoice')
												->from('invoice_product')
												->join('invoice', 'invoice.id_invoice=invoice_product.id_invoice', 'left')
												->join('invoice_beli', 'invoice_beli.id_invoice_beli=invoice.id_invoice_beli', 'left')
												->where('invoice_beli.note_invoice_beli',$noinv)
												->get()->row();
		$updateinvprod['container_generate'] = 1;
		$this->db->where('id_invoice',$getdata->id_invoice)->update('invoice_product',$updateinvprod);

	}

	function addcontgiw(){
		$updgiw['container_id'] = $this->input->post('container_id');
		$this->db->where('nomor',$this->input->post('nomor'))->update('giw',$updgiw);
	}

}
