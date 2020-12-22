<?php

class Mapiinvoice extends CI_Model
{

  public function __construct(){
		parent::__construct();
	  $this->load->model('Mbarang');
    $this->load->model('Minvoice_barang');
    $this->load->model('Mkomisi_referal');
	}

  function get_invoice_product($id_invoice){
    $this->db->select('giw.*,customer.*,invoice_product.jumlah,invoice_product.id_invoice_beli,
                       invoice_product.id_invoice,giw.id as idgiw,resi.id_resi as idresi,resi.tanggal');
    $this->db->from('invoice_product');
    $this->db->join('giw','giw.id=invoice_product.id_giw','left');
    $this->db->join('customer','giw.customer_id=customer.id_cust','left');
    $this->db->join('resi','giw.resi_id=resi.id_resi','left');
    $this->db->where('invoice_product.id_invoice_beli',$id_invoice);

    return $this->db->get();
  }

  function get_invoice_product2($id_invoice){
    $this->db->select('giw.*,customer.*,invoice_product.jumlah,invoice_product.id_invoice_beli,
                       invoice_product.id_invoice,giw.id as idgiw,resi.id_resi as idresi,resi.tanggal');
    $this->db->from('invoice_product');
    $this->db->join('giw','giw.id=invoice_product.id_giw','left');
    $this->db->join('customer','giw.customer_id=customer.id_cust','left');
    $this->db->join('resi','giw.resi_id=resi.id_resi','left');
    $this->db->where('invoice_product.id_invoice',$id_invoice);

    return $this->db->get();
  }

  function harga_tertinggi_resi($id){
    $this->db->select('giw.harga_jual,invoice_product.*');
    $this->db->from('invoice_product');
    $this->db->join('giw','giw.id=invoice_product.id_giw','left');
    $this->db->where('invoice_product.id_invoice_beli',$id);
    $this->db->order_by('giw.harga_jual','desc');

    return $this->db->get()->row();
  }

  function giwbyresi($id_invoice){
    $this->db->select('giw.customer_id,giw.resi_id');
    $this->db->from('invoice_product');
    $this->db->join('giw','giw.id=invoice_product.id_giw','left');
    $this->db->where('invoice_product.id_invjual',$id_invoice);
    $this->db->group_by('giw.resi_id');

    return $this->db->get();
  }

  function getinvasr($resi_id){
    $this->db->select('id');
    $this->db->from('invoice_asuransi');
    $this->db->where('id_resi',$resi_id);
    $this->db->where('id_invoice',0);
    $this->db->group_by('giw.resi_id');

    return $this->db->get();
  }

  // Get Kode
  function kode_beli(){
    $hcekkode= $this->db->select('kode_invoice_beli as maxkode')->where('id_vendor',4)->order_by('id_invoice_beli','desc')->get('invoice_beli')->row();
		$kodesaatini= $hcekkode->maxkode;
		$ambilkode= str_replace('BELI/SEA/','',$kodesaatini);
	  if($ambilkode=="")
		{
		 $ambilkode=0;
		}
		$kodejadi= $ambilkode+1;

		$hasil= $kodejadi;
		return 'BELI/SEA/'.$hasil;
  }

  function scan_barcode(){
     $nomor_giw = $this->input->post('giw_array');
     $scan_input= $this->input->post('scan_array');
     $counter   = $this->input->post('jmlh_counter');
     $jumlah_array = count($nomor_giw);
     $pesandev   = "Scan Barcode ".$jumlah_array;
     // sendwhatsapp($pesandev,"083815423599");
     $nomor_barcode = "";
     for ($i=0; $i<$jumlah_array; $i++) {
       $get_barcode = $this->db->select('giw.*,customer.kode')->from('giw')->join('customer','giw.customer_id=customer.id_cust','left')->where('giw.nomor',$nomor_giw[$i])->get()->row();
       //echo json_encode($nomor_giw[$i]);die();
       $invoice_product['id_giw']= $get_barcode->id;
       $invoice_product['id_sj']= 0;
       $invoice_product['id_invoice']= 0;
       $invoice_product['id_invoice_beli']= 0;
       $invoice_product['id_sj_rts']= 0;
       $invoice_product['jumlah']= $scan_input[$i];
       $this->db->insert('invoice_product',$invoice_product);

       $giw['counter']= $counter[$i];
       $giw['status']= 5;
       $giw['boleh_kirim']= 0;
       $this->db->where('id', $get_barcode->id);
       $this->db->update('giw',$giw);
       // $nomor_barcode .= "\n".$nomor_giw[$i]." Customer : ".$get_barcode->kode;
     }
     // sendwhatsapp("Scan Barcode ".$nomor_barcode,"085318999004");
  }

  function scan_barcode2(){
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

  }

  function generate_invoice(){
    $id_sj_rts = $this->input->post('id_sj_rts');
    $bolehkirim = $this->input->post('bolehkirim');
    if($bolehkirim == "2"){
      $posisigiw = 1;
    }else{
      $posisigiw = 0;
    }
    $cek_customer = $this->db->select('customer.id_provinsi2,customer.id_kota2,master_ekspedisi_lokal.tipe_ekspedisi,customer.fix_alamat')->from('customer')
                             ->join('master_ekspedisi_lokal', 'customer.id_ekspedisi=master_ekspedisi_lokal.id_ekspedisi','left')
                             ->where('kode',$this->input->post('customer_kode'))
                             ->get()->row();
    if($cek_customer->id_provinsi2 != "31" || $cek_customer->id_kota2 == "3175" || $cek_customer->id_kota2 == "3174" || $cek_customer->tipe_ekspedisi = "pickup" || $cek_customer->tipe_ekspedisi = "nanya" || $cek_customer->fix_alamat != 1){
			// send curl to rts
			$curl_handle=curl_init();
			curl_setopt($curl_handle,CURLOPT_URL,"https://office.rtsekspedisi.com/api/a_invoice/update_boleh_kirim");
			curl_setopt($curl_handle, CURLOPT_POST, 1);
			curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "id_sj=$id_sj_rts");
			$curlemail = curl_exec($curl_handle);
			curl_close($curl_handle);
		}
    //Insert Surat Jalan
    $data_customer= $this->Mbarang->data_customer($this->input->post('customer_kode'));
    foreach($data_customer->result() as $dcusto ){
          $id_cust           =$dcusto->id_cust;
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

    // cek harga
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

    // var_dump($this->input->post()); die();
    $insert_sj['no_sj']=$this->input->post('no_sj');
    $insert_sj['tanggal_sj']=$this->input->post('tanggal');
    $insert_sj['id_cust']=$id_cust;
    $insert_sj['status']=1;
    $this->db->insert('surat_jalan', $insert_sj);
    $sj_id = $this->db->insert_id();

    //Insert Invoice Rts
    $insert_inv['kode_invoice_beli']= $this->kode_beli();
    $insert_inv['note_invoice_beli']= $this->input->post('no_inv');
    $insert_inv['id_cust']= $id_cust;
    $insert_inv['tanggal_invoice_beli']=$this->input->post('tanggal');
    $insert_inv['status_invoice_beli']=1;
    $insert_inv['id_vendor']=4;
    $insert_inv['jumlah_invoice_beli']=0;
    $insert_inv['jumlah_bayar_invoice_beli']=0;
    $insert_inv['jumlah_dari_vendor']= $this->input->post('jumlah_invoice');

    $this->db->insert('invoice_beli', $insert_inv);
    $inv_id = $this->db->insert_id();

    $insert_invjual['id_invoice_beli']= $inv_id;
    $insert_invjual['id_cust']        = $id_cust;
    $insert_invjual['id_surat_jalan'] = $sj_id;
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

    //Update Invoice Product
    if($boleh_kirim == 2){
      $sql = "UPDATE invoice_product AS ud JOIN giw AS u ON ud.id_giw = u.id SET ud.id_sj = $sj_id,
              ud.id_invoice_beli = $inv_id,ud.id_invoice = $invjual_id,ud.container_generate = 1,u.boleh_kirim=$boleh_kirim
              ,u.tanggal_boleh_kirim = '$tglbolehkirim'
              WHERE ud.id_sj_rts = $id_sj_rts and u.customer_id = $id_cust and ud.container_generate <= 1";
    }else{
      $sql = "UPDATE invoice_product AS ud JOIN giw AS u ON ud.id_giw = u.id SET ud.id_sj = $sj_id,
              ud.id_invoice_beli = $inv_id,ud.id_invoice = $invjual_id,ud.container_generate = 1,u.boleh_kirim=$boleh_kirim
              WHERE ud.id_sj_rts = $id_sj_rts and u.customer_id = $id_cust and ud.container_generate <= 1";
    }
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

     $jumlah=0; $total=0; $totalsamping=0;
     $data_invoice_product = $this->get_invoice_product($inv_id)->result();
     foreach($data_invoice_product as $ils){
       // Cek Harga Khusus
       $cekhargacustomer = $this->Mbarang->data_hbc($ils->id_cust,$ils->jenis_barang_id)->num_rows();
       $cekhargagrup     = $this->Mbarang->data_hbcg($id_cgrup,$ils->jenis_barang_id)->num_rows();
      //  if($id_cgrup > 0 && $cekhargagrup > 0){
      //    $dhbc = $this->Mbarang->data_hbcg($id_cgrup,$ils->jenis_barang_id)->row();
    	// 	 $hj   = $dhbc->harga;
      //    $updhargakhusus['harga_jual'] = $hj;
      //    // $this->db->where('nomor',$ils->nomor)->update('giw',$updhargakhusus);
      //  }else if($id_cgrup > 0 && $cekhargagrup == 0 && $cekhargacustomer == 0 && $harga_otomatis_grup == 1){
      //    $month = date("m",strtotime($ils->tanggal));
     	// 	 $cek_cbm = $this->db->select('sum(ctns*volume) as jumlah')->from('giw')
     	// 											->join('resi','giw.resi_id=resi.id_resi','left')
      //                       ->join('customer', 'giw.customer_id=customer.id_cust', 'left')
     	// 											->where('customer.id_cgrup',$id_cgrup)
     	// 											->where('month(resi.tanggal)',$month)
     	// 											->get()->row();
      //    if($cek_cbm->jumlah > 10){
      //      $updhargakhusus2['harga_jual'] = $ils->harga_jual - 500000;
      //      // $this->db->where('nomor',$ils->nomor)->update('giw',$updhargakhusus2);
      //    }
      //  }else if($cekhargacustomer > 0){
   		// 	$dhbc = $this->Mbarang->data_hbc($ils->id_cust,$ils->jenis_barang_id)->row();
   		// 	$hj   = $dhbc->harga;
      //   $updhargakhusus['harga_jual'] = $hj;
      //   // $this->db->where('nomor',$ils->nomor)->update('giw',$updhargakhusus);
   		// }else
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
     $update_invb['jumlah_invoice_beli'] = $total;
     if($insert_inv['jumlah_dari_vendor'] != $update_invb['jumlah_invoice_beli']){
       $update_invb['status_hitung'] = 1;
     }
     $this->db->where('id_invoice_beli',$inv_id);
     $this->db->update('invoice_beli', $update_invb);

     // Row Inv
     $rowinvoice = $this->Minvoice_barang->data_invoice($invjual_id)->row();

     $jumlah=0; $total=0; $totalsamping=0; $total_volume=0; $total_diskon=0; $jumlah_diskon =0; $biayatambahan = 0; $ketbiaya = "";
     $data_invoice_product = $this->get_invoice_product($inv_id)->result();
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
                                 ->where('invoice_product.id_invoice_beli',$inv_id)
                                 ->group_by("resi.id_resi")
                                 ->get()->result();

     $jumlah_potong_resi_perbulan = 0;
     if($dataresi->cbm < 2){
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
     // $cekvolumeinv   = $this->db->select('sum(invoice_product.jumlah * giw.volume) as cbm')
     //                            ->from('invoice_product')
     //                            ->join('giw','giw.id=invoice_product.id_giw','left')
     //                            ->where('invoice_product.id_invoice_beli',$inv_id)
     //                            ->get()->row();
     // $chargekirim = 0;
     // if($cekvolumeinv->cbm < 0.5){
     //   $chargekirim = 100000;
     //   $chargetambahan['id_invoice'] =$invjual_id;
     //   $chargetambahan['id_jenis_potongan'] = "16";
     //   $chargetambahan['jumlah_potongan'] = $chargekirim;
     //   $chargetambahan['keterangan_potongan'] = "Charge Pengiriman dibawah 0.5 m<sup>3</sup>";
     //   // print_r($chargetambahan['jumlah_potongan']);
     //   $this->db->insert('potongan',$chargetambahan);
     // }
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
     $data_invoice_product2 = $this->get_invoice_product($inv_id)->num_rows();
     if($data_invoice_product2 <= 0){
       die();
     }
     // die();
     if($cekharga->harga_barang > $tagihan_jual){
       $this->Minvoice_barang->info_gudang($invjual_id);
     }
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

     sendwhatsapp($pesan,"081310961108");
     $sendoc = send_newdoc($time,"081310961108",$rowinvoice->kode_invoice);

     sendwhatsapp($pesan,$whatsapp);
     $sendoc = send_newdoc($time,$whatsapp,$rowinvoice->kode_invoice);

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
     $this->email->to($mail_cust,"gusmavin@gmail.com"); //email tujuan. Isikan dengan emailmu!
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

  // function generate_invoice2($id_sj,$marking,$no_sj,$tgl,$no_inv,$jml_inv){
  //   $id_sj_rts = $id_sj;
  //   $cek_customer = $this->db->select('customer.id_provinsi2,customer.id_kota2,master_ekspedisi_lokal.tipe_ekspedisi,customer.fix_alamat')->from('customer')
  //                            ->join('master_ekspedisi_lokal', 'customer.id_ekspedisi=master_ekspedisi_lokal.id_ekspedisi','left')
  //                            ->where('kode',$marking)
  //                            ->get()->row();
  //   if($cek_customer->id_provinsi2 != "31" || $cek_customer->id_kota2 == "3175" || $cek_customer->id_kota2 == "3174" || $cek_customer->tipe_ekspedisi = "pickup" || $cek_customer->tipe_ekspedisi = "nanya" || $cek_customer->fix_alamat != 1){
	// 		// send curl to rts
	// 		$curl_handle=curl_init();
	// 		curl_setopt($curl_handle,CURLOPT_URL,"https://office.rtsekspedisi.com/api/a_invoice/update_boleh_kirim");
	// 		curl_setopt($curl_handle, CURLOPT_POST, 1);
	// 		curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "id_sj=$id_sj_rts");
	// 		$curlemail = curl_exec($curl_handle);
	// 		curl_close($curl_handle);
	// 	}
  //   //Insert Surat Jalan
  //   $data_customer= $this->Mbarang->data_customer($marking);
  //   foreach($data_customer->result() as $dcusto ){
  //         $id_cust           =$dcusto->id_cust;
  //         if($dcusto->id_cgrup > 0){
  //          $mail_cust         =$dcusto->email_cgrup;
  //          $whatsapp          =$dcusto->whatsapp_cgrup;
  //         }else{
  //          $mail_cust         =$dcusto->email;
  //          $whatsapp          =$dcusto->whatsapp;
  //         }
  //         $nama_penerima     =$dcusto->nama_penerima;
  //         $alamat_penerima   =$dcusto->alamat;
  //         $telepon_penerima  =$dcusto->telepon;
  //         $id_referal        =$dcusto->id_referal;
  //         $nama_customer     =$dcusto->nama;
  //   }
  //
  //   // var_dump($this->input->post()); die();
  //   $insert_sj['no_sj']=$no_sj;
  //   $insert_sj['tanggal_sj']=$tgl;
  //   $insert_sj['id_cust']=$id_cust;
  //   $insert_sj['status']=1;
  //   $this->db->insert('surat_jalan', $insert_sj);
  //   $sj_id = $this->db->insert_id();
  //
  //   //Insert Invoice Rts
  //   $insert_inv['kode_invoice_beli']= $this->kode_beli();
  //   $insert_inv['note_invoice_beli']= $no_inv;
  //   $insert_inv['id_cust']= $id_cust;
  //   $insert_inv['tanggal_invoice_beli']=$tgl;
  //   $insert_inv['status_invoice_beli']=1;
  //   $insert_inv['id_vendor']=4;
  //   $insert_inv['jumlah_invoice_beli']=0;
  //   $insert_inv['jumlah_bayar_invoice_beli']=0;
  //   $insert_inv['jumlah_dari_vendor']= $jml_inv;
  //
  //   $this->db->insert('invoice_beli', $insert_inv);
  //   $inv_id = $this->db->insert_id();
  //
  //   $insert_invjual['id_invoice_beli']= $inv_id;
  //   $insert_invjual['id_cust']        = $id_cust;
  //   $insert_invjual['id_surat_jalan'] = $sj_id;
  //   $insert_invjual['kode_invoice']   = $this->Mbarang->code_invoice_barang();
  //   $insert_invjual['tanggal_invoice']= date('Y-m-d') ;
  //   $insert_invjual['id_vendor']      = 4;
  //   $insert_invjual['total_tagihan']  = 0 ;
  //   $insert_invjual['total_potongan'] = 0 ;
  //   $insert_invjual['jumlah_bayar']   = 0 ;
  //   $insert_invjual['encrypt_invoice']= md5($insert_invjual['kode_invoice']) ;
  //   $insert_invjual['tipe_invoice']   = 'barang';
  //   $insert_invjual['status_invoice'] = 0;
  //
  //   $this->db->insert('invoice', $insert_invjual);
  //   $invjual_id = $this->db->insert_id();
  //
  //   $cekharga=$this->db->select('SUM(((giw.qty*giw.ctns)*giw.nilai)*2000) as harga_barang')
  //                     ->from('giw')
  //                     ->join('status_giw','status_giw.id=giw.status','left')
  //                     ->where('customer_id',$id_cust)
  //                     ->where('status_giw.urutan <',12)
  //                     ->get()->row();
  //   if($cekharga->harga_barang > 0){
  //       if($cek_customer->fix_alamat != 1){
  //         $boleh_kirim = 1;
  //       }else{
  //         $boleh_kirim = 2;
  //       }
  //   }else{
  //     $boleh_kirim = 0;
  //   }
  //
  //   //Update Invoice Product
  //   $sql = "UPDATE invoice_product AS ud JOIN giw AS u ON ud.id_giw = u.id SET ud.id_sj = $sj_id,
  //           ud.id_invoice_beli = $inv_id,ud.id_invoice = $invjual_id ,u.boleh_kirim=$boleh_kirim
  //           WHERE ud.id_sj_rts = $id_sj_rts and u.customer_id = $id_cust and ud.container_generate <= 1";
  //   $this->db->query($sql);
  //
  //   // Update Invoice Asuransi dengan Id Invoice Jika Barang ber asuransi
  //   $giwbyresi=$this->db->select('giw.customer_id,giw.resi_id')->from('invoice_product')->join('giw','giw.id=invoice_product.id_giw','left')
  //                        ->where('invoice_product.id_invoice',$invjual_id)->group_by('giw.resi_id')->get()->result();
  //                        // echo "oke"; print_r($giwbyresi);die();
  //    foreach ($giwbyresi as $gbr) {
  //      $getinvasr=$this->db->where('id_resi',$gbr->resi_id)->where('id_invoice',0)->get('invoice_asuransi')->num_rows();
  //      if($getinvasr > 0){
  //        $update_asr['id_invoice']= $invjual_id;
  //        $this->db->where('id_resi',$gbr->resi_id)->where('id_invoice',0)->update('invoice_asuransi',$update_asr);
  //      }
  //    }
  //
  //    $selectasuransi=$this->db->select("sum(jumlah_asuransi) as jumlah")->from('invoice_asuransi')->where('id_invoice', $invjual_id)->get()->row();
  //    $asuransiinvoice=@$selectasuransi->jumlah;
  //
  //    $jumlah=0; $total=0; $totalsamping=0;
  //    $data_invoice_product = $this->get_invoice_product($inv_id)->result();
  //    foreach($data_invoice_product as $ils){
  //      include APPPATH. 'helpers/harga_beli.php';
  //    }
  //    $update_invb['jumlah_invoice_beli'] = $total;
  //    if($insert_inv['jumlah_dari_vendor'] != $update_invb['jumlah_invoice_beli']){
  //      $update_invb['status_hitung'] = 1;
  //    }
  //    $this->db->where('id_invoice_beli',$inv_id);
  //    $this->db->update('invoice_beli', $update_invb);
  //
  //    // Row Inv
  //    $rowinvoice = $this->Minvoice_barang->data_invoice($invjual_id)->row();
  //
  //    $jumlah=0; $total=0; $totalsamping=0; $total_volume=0; $total_diskon=0; $jumlah_diskon =0;
  //    $data_invoice_product = $this->get_invoice_product($inv_id)->result();
  //    foreach($data_invoice_product as $ils){
  //      $diskon = 0;
  //      $tgl_barang_di_china = $ils->tanggal;
  //      $tgl_dapet_diskon = date('Y-m-d', strtotime('+45 days', strtotime($tgl_barang_di_china)));
  //     if($tgl_dapet_diskon > date('Y-m-d')){
  //        // ga kena diskon
  //     }else{
  //        $diskon = 1;
  //     }
  //      include APPPATH. 'helpers/harga.php';
  //    }
  //    if($total_diskon > 0){
  //      // $potongan_diskon['id_invoice'] =$invjual_id;
  //      // $potongan_diskon['id_jenis_potongan'] = "10";
  //      // $potongan_diskon['jumlah_potongan'] = 0;
  //      // $potongan_diskon['keterangan_potongan'] = "Potongan Barang Telat";
  //      // // print_r($potongan_diskon);
  //      // // echo "<br />";
  //      // // print_r($potongan_diskon['jumlah_potongan']);
  //      // $this->db->insert('potongan',$potongan_diskon);
  //      // $sql = "INSERT INTO potongan (id_invoice, id_jenis_potongan, jumlah_potongan, keterangan_potongan)
  //      //         VALUES ($invjual_id, 10,-$total_diskon,'Potongan Barang Telat')";
  //      // $this->db->query($sql);
  //    }
  //    $biayatambahannya = 0;
  //    if(@$biayatambahan > 0){
  //      $biaya_tambahan['id_invoice'] =$invjual_id;
  //      $biaya_tambahan['id_jenis_potongan'] = "15";
  //      $biaya_tambahan['jumlah_potongan'] = $biayatambahan;
  //      $biaya_tambahan['keterangan_potongan'] = "Biaya ".$ketbiaya;
  //      // print_r($biaya_tambahan['jumlah_potongan']);
  //      $this->db->insert('potongan',$biaya_tambahan);
  //    }
  //    $biayatambahannya = $biayatambahan;
  //    $bulaninvoice = date('m');
  //    $tglinv = date("Y-m-d");
  //    if($bulaninvoice == 1){
  //       $bulansebelumnya = 12;
  //       $tglsblmnya = date("Y"."-12-"."01");
  //    }else{
  //       $bulanisebelumnya = date('m') - 1;
  //       $tglsblmnya = date("Y-".$bulanisebelumnya."-01");
  //    }
  //    $dataresi   = $this->db->select('sum(giw.volume * giw.ctns) as cbm')->from('giw')
  //                           ->join('resi','resi.id_resi=giw.resi_id','left')
  //                           ->where('resi.cust_id',$id_cust)
  //                           ->where('resi.tanggal >=',$tglsblmnya)
  //                           ->where('resi.tanggal <=',$tglinv)
  //                           ->get()->row();
  //     $dataresi_inv   = $this->db->select('giw.resi_id,resi.nomor as nomor_resi,sum(giw.volume * giw.ctns) as cbm')->from('invoice_product')
  //                                ->join('giw','giw.id=invoice_product.id_giw','left')
  //                                ->join('resi','resi.id_resi=giw.resi_id','left')
  //                                ->where('invoice_product.id_invoice_beli',$inv_id)
  //                                ->group_by("resi.id_resi")
  //                                ->get()->result();
  //    if($dataresi->cbm < 2){
  //      $jumlah_potong_resi_perbulan = 0;
  //      foreach($dataresi_inv as $dri){
  //        $hargatertinggiresi = $this->db->select('giw.harga_jual')->from('giw')->where('giw.resi_id',$dri->resi_id)->order_by('giw.harga_jual','desc')->limit(1)->get()->row();
  //        if($dri->cbm <= 0.1){
  //          $countpembulatannya = 0.1-$dri->cbm ;
  //          $cek_pembulatan = 1;
  //          $dataresiinv['id_invoice'] =$invjual_id;
  //          $dataresiinv['id_jenis_potongan'] = "3";
  //          $dataresiinv['jumlah_potongan'] = $countpembulatannya * $hargatertinggiresi->harga_jual;
  //          $dataresiinv['keterangan_potongan'] = "Pembulatan Resi 0.1 ".$dri->nomor_resi;
  //          // print_r($dataresiinv['jumlah_potongan']);
  //          $this->db->insert('potongan',$dataresiinv);
  //        }
  //        $jumlah_potong_resi_perbulan += $dataresiinv['jumlah_potongan'];
  //      }
  //    }
  //    $id_resi_array = array();
  //    $ongkos_perbulan05 = 0;
  //    foreach($dataresi_inv as $dri){
  //      if($dri->cbm <= 0.5){
  //        $cek_pembulatan = 1;
  //        $chargetambahan['id_invoice'] =$invjual_id;
  //        $chargetambahan['id_jenis_potongan'] = "16";
  //        $chargetambahan['jumlah_potongan'] = 100000;
  //        $chargetambahan['keterangan_potongan'] = "Charge Pengiriman dibawah 0.5 m<sup>3</sup> ".$dri->nomor_resi;
  //        // print_r($chargetambahan['jumlah_potongan']);
  //        $this->db->insert('potongan',$chargetambahan);
  //        $ongkos_perbulan05+=$chargetambahan['jumlah_potongan'];
  //      }
  //    }
  //    if($cek_pembulatan == 1){
  //      $statusinvoicenya = "Pembulatan 0.1";
  //      $tagihan_jual = $total + $jumlah_potong_resi_perbulan + $biayatambahannya + $ongkos_perbulan05;
  //    }else{
  //      $statusinvoicenya = "Normal";
  //      $tagihan_jual = $total + $biayatambahannya;
  //    }
  //
  //    $pesankedev = "Generate ".$insert_invjual['kode_invoice']." Status ".$statusinvoicenya." Jumlah Tagihan ".number_format($tagihan_jual)." Jumlah Potongan ".$jumlah_potong_resi_perbulan." harga utama ".$total;
  //    sendwhatsapp($pesankedev,"083815423599");
  //
  //    $update_invjual['total_tagihan'] = $tagihan_jual;
  //    $this->db->where('id_invoice',$invjual_id);
  //    $this->db->update('invoice', $update_invjual);
  //
  //    // Referal
  //    $kurs_global = $this->db->where('id_kurs',1)->get('kurs')->row();
  //    $komisi_global_barang = $kurs_global->komisi_barang;
  //    if($id_referal > 0){
  //      if($nama_customer == "Nurul Magfirah Putram"){
  //          $total_komisi_nurul = 0;
  //          $ket_komisi_nurul   = "";
  //        foreach($data_invoice_product as $ils2){
  //          $jumlahctns_nurul      = $ils2->jumlah;
  //          $volume_nurul          = $jumlahctns_nurul * $ils2->volume;
  //          $jenis_barang_id_nurul = $ils2->jenis_barang_id;
  //          if($jenis_barang_id_nurul == 22){
  //            $komisi_nurul     = $volume_nurul * 500000;
  //            $ket_komisi_nurul .= $ils2->nomor." ".$volume_nurul."m<sup>3</sup> * Komisi 500000 ,";
  //          }else{
  //            $komisi_nurul     = $volume_nurul * 250000;
  //            $ket_komisi_nurul .= $ils2->nomor." ".$volume_nurul."m<sup>3</sup> * Komisi 250000 ,";
  //          }
  //          $total_komisi_nurul += $komisi_nurul;
  //        }
  //        $get_referal = $this->db->where('id_cust',$id_referal)->get('customer')->row();
  //        $input_referal['id_cust'] = $id_referal;
  //        $input_referal['kode_komisi'] = $this->Mkomisi_referal->kode_komisi();
  //        $input_referal['customer'] = $rowinvoice->kode;
  //        $input_referal['id_invoice'] = $invjual_id;
  //        $input_referal['nilai'] = $total_komisi_nurul;
  //        $input_referal['keterangan'] = $ket_komisi_nurul;
  //        $input_referal['status'] = 1;
  //        // input
  //        $this->db->insert('komisi_referal', $input_referal);
  //      }else{
  //        $get_referal = $this->db->where('id_cust',$id_referal)->get('customer')->row();
  //        if($get_referal->komisi_barang == 0){
  //          $komisifix  = $komisi_global_barang * $total_volume;
  //          $ket_komisi = "Komisi Referal Global : ".$komisi_global_barang." * Total Volume : ".$total_volume;
  //        }else{
  //          $komisifix = $get_referal->komisi_barang * $total_volume;
  //          $ket_komisi = "Komisi Referal Khusus : ".$get_referal->komisi_barang." * Total Volume : ".$total_volume;
  //        }
  //        $input_referal['id_cust'] = $id_referal;
  //        $input_referal['kode_komisi'] = $this->Mkomisi_referal->kode_komisi();
  //        $input_referal['customer'] = $rowinvoice->kode;
  //        $input_referal['id_invoice'] = $invjual_id;
  //        $input_referal['nilai'] = $komisifix;
  //        $input_referal['keterangan'] = $ket_komisi;
  //        $input_referal['status'] = 1;
  //        // input
  //        $this->db->insert('komisi_referal', $input_referal);
  //      }
  //    }
  //
  //    if($tagihan_jual <= 0){
  //      // die();
  //    }
  //    // die();
  //    $test['status'] =0;
  //    $test['record_asuransi'] = $this->Minvoice_barang->cek_asuransi($invjual_id)->result();
  //    $test['record'] = $this->Minvoice_barang->data_invoice($invjual_id)->row();
  //    $test['barcode']= $this->Minvoice_barang->getinvoice_product($invjual_id)->result();
  //    $test['potongan']=$this->Minvoice_barang->data_potongan($invjual_id)->result();
  //    $data = $this->load->view('admin/invoice_barang/pdf_invoice',$test,True);
  //
  //    $mpdf = new \Mpdf\Mpdf();
  //    $mpdf->WriteHTML($data);
  //    $mpdf->Output("pdf_file/".time()."inv.pdf" ,'F');
  //    $time=time()."inv.pdf";
  //
  //    $pesan = "*Yth. Bpk/Ibu ".$rowinvoice->nama." (".$rowinvoice->kode.")*\n\nBarang Anda akan segera sampai di gudang Jakarta kami. ".
  //               "Berikut kami lampirkan detail barang dan invoice barang ".$rowinvoice->kode_invoice." yang harus Anda bayar, yaitu sebesar *Rp. ".number_format($tagihan_jual).
  //               "* ke rekening berikut:\n\n*BCA 5810557747 a/n Gusmavin Willopo*\n\nHarap segera lakukan pembayaran agar barang dapat segera masuk dalam antrian pengiriman barang.".
  //               " Setelah melakukan pembayaran harap konfirmasi pembayaran Anda dengan menghubungi CS kami melalui telepon / WA.".
  //               "\n\nAlamat kirim : (".$nama_penerima.",".$telepon_penerima.",".$alamat_penerima.")".
  //               "\nJika ada perubahan alamat mendadak, harap segera informasikan ke CS kami!".
  //               "\nTerima kasih atas kerjasamanya :)".
  //               "\n\n*Wilopo Cargo* _(do not reply)_";
  //
  //    // sendwhatsapp($pesan,"081310961108");
  //    // $sendoc = send_newdoc($time,"081310961108",$rowinvoice->kode_invoice);
  //    //
  //    // sendwhatsapp($pesan,$whatsapp);
  //    // $sendoc = send_newdoc($time,$whatsapp,$rowinvoice->kode_invoice);
  //
  //    $config = Array(
  //      'protocol' => 'smtp',
  //     'smtp_host' => 'mail.wilopocargo.com',
  //     'smtp_port' => 25,
  //     'smtp_user' => user_email(), //isi dengan gmailmu!
  //     'smtp_pass' => pass_email(),
  //     'mailtype' => 'html',
  //     'charset' => 'iso-8859-1',
  //     'wordwrap' => TRUE
  //    );
  //
  //    $content = $mpdf->Output('', 'S');
  //    $this->load->library('email', $config);
  //    $this->email->attach($content, 'attachment', $rowinvoice->kode_invoice , 'application/pdf');
  //    $the_message="<html>
  //                        <body>
  //                                <h3>Yth. ".$rowinvoice->kode." ,</h3>
  //                                <p>Barang Anda akan segera sampai di gudang Jakarta kami. Berikut kami lampirkan detail barang dan invoice barang ".$rowinvoice->kode_invoice."
  //                                    yang harus Anda bayar, yaitu sebesar <b>Rp.".number_format($tagihan_jual)." </b>ke rekening berikut:</p>
  //                                <p><b>BCA 5810557747 a/n Gusmavin Willopo</b></p>
  //                                <p>Harap segera lakukan pembayaran agar barang dapat segera masuk dalam antrian pengiriman barang.</p>
  //                                <p>Setelah melakukan pembayaran harap konfirmasi pembayaran Anda dengan menghubungi CS kami melalui telepon / WA.</p>
  //                                <p>".nama_perusahaan()."</p>
  //
  //                        </body>
  //                  </html>";
  //
  //    $this->email->set_newline("\r\n");
  //    $this->email->from(user_email());
  //    $this->email->to("rr318929@gmail.com"); //email tujuan. Isikan dengan emailmu!
  //    $this->email->subject('[Wilopo Cargo] Invoice Barang '.$rowinvoice->kode_invoice);
  //    $this->email->message($the_message);
  //
  //    if($this->email->send())
  //    {
  //      if($sendoc){
  //       $path_unlink = './'.$time;
  //       unlink($path_unlink );
  //      }
  //    }
  //    else
  //    {
  //      //show_error($this->email->print_debugger());
  //    }
  //  }
   //
   // function cron_generate_invoice(){
   //    die();
   //    $get_invcron = $this->db->select('customer.kode as custkode,customer.id_cust')
   //                            ->from('invoice_product')
   //                            ->join('giw', 'invoice_product.id_giw=giw.id','left')
   //                            ->join('customer', 'giw.customer_id=customer.id_cust','left')
   //                            ->where('id_invoice',0)
   //                            ->where('container_generate > 0')
   //                            ->order_by('id_invoice_product','asc')
   //                            ->group_by('customer.id_cust')
   //                            ->limit(5)
   //                            ->get()->result();
   //    foreach($get_invcron as $geninv){
   //         if($geninv->id_cust <= 0 || $geninv->id_cust == null || $geninv->id_cust == ""){
   //           dd("tidak ada inv");
   //         }
   //         //Insert Surat Jalan
   //         sendwhatsapp("Generate Auto Invoice","083815423599");
   //         $data_customer= $this->Mbarang->data_customer($geninv->custkode);
   //         foreach($data_customer->result() as $dcusto ){
   //               $id_cust           =$dcusto->id_cust;
   //               $fix_alamat        =$dcusto->fix_alamat;
   //               $id_cgrup          =$dcusto->id_cgrup;
   //               $harga_otomatis    =$dcusto->harga_otomatis;
   //               $harga_otomatis_grup=$dcusto->harga_otomatis_grup;
   //               if($dcusto->id_cgrup > 0){
   //                $mail_cust         =$dcusto->email_cgrup;
   //                $whatsapp          =$dcusto->whatsapp_cgrup;
   //               }else{
   //                $mail_cust         =$dcusto->email;
   //                $whatsapp          =$dcusto->whatsapp;
   //               }
   //               $nama_penerima     =$dcusto->nama_penerima;
   //               $alamat_penerima   =$dcusto->alamat;
   //               $telepon_penerima  =$dcusto->telepon;
   //               $id_referal        =$dcusto->id_referal;
   //               $nama_customer     =$dcusto->nama;
   //         }
   //
   //         $insert_invjual['id_invoice_beli']= 1;
   //         $insert_invjual['id_cust']        = $id_cust;
   //         $insert_invjual['id_surat_jalan'] = 1;
   //         $insert_invjual['kode_invoice']   = $this->Mbarang->code_invoice_barang();
   //         $insert_invjual['tanggal_invoice']= date('Y-m-d') ;
   //         $insert_invjual['id_vendor']      = 4;
   //         $insert_invjual['total_tagihan']  = 0 ;
   //         $insert_invjual['total_potongan'] = 0 ;
   //         $insert_invjual['jumlah_bayar']   = 0 ;
   //         $insert_invjual['encrypt_invoice']= md5($insert_invjual['kode_invoice']) ;
   //         $insert_invjual['tipe_invoice']   = 'barang';
   //         $insert_invjual['status_invoice'] = 0;
   //         $insert_invjual['status_boleh_kirim'] = 0;
   //
   //         $this->db->insert('invoice', $insert_invjual);
   //         $invjual_id = $this->db->insert_id();
   //
   //         $cek_customer = $this->db->select('customer.fix_alamat')->from('customer')
   //                                  ->where('id_cust',$id_cust)
   //                                  ->get()->row();
   //
   //         $cekharga=$this->db->select('SUM(((giw.qty*giw.ctns)*giw.nilai)*2000) as harga_barang')
   //                           ->from('giw')
   //                           ->join('status_giw','status_giw.id=giw.status','left')
   //                           ->where('customer_id',$id_cust)
   //                           ->where('status_giw.urutan <',12)
   //                           ->get()->row();
   //         if($cekharga->harga_barang > 0){
   //             if($cek_customer->fix_alamat != 1){
   //               $boleh_kirim = 1;
   //             }else{
   //               $boleh_kirim = 2;
   //             }
   //         }else{
   //           $boleh_kirim = 0;
   //         }
   //
   //         //Update Invoice Product
   //         $sql = "UPDATE invoice_product JOIN giw ON invoice_product.id_giw = giw.id SET invoice_product.id_sj = 1,
   //                 invoice_product.id_invoice_beli = 1,invoice_product.id_invoice = $invjual_id,giw.boleh_kirim = $boleh_kirim
   //                 WHERE invoice_product.id_invoice = 0 and invoice_product.container_generate > 1 and giw.customer_id = $id_cust";
   //         $this->db->query($sql);
   //
   //         // Update Invoice Asuransi dengan Id Invoice Jika Barang ber asuransi
   //         $giwbyresi=$this->db->select('giw.customer_id,giw.resi_id')->from('invoice_product')->join('giw','giw.id=invoice_product.id_giw','left')
   //                              ->where('invoice_product.id_invoice',$invjual_id)->group_by('giw.resi_id')->get()->result();
   //                              // echo "oke"; print_r($giwbyresi);die();
   //          foreach ($giwbyresi as $gbr) {
   //            $getinvasr=$this->db->where('id_resi',$gbr->resi_id)->where('id_invoice',0)->get('invoice_asuransi')->num_rows();
   //            if($getinvasr > 0){
   //              $update_asr['id_invoice']= $invjual_id;
   //              $this->db->where('id_resi',$gbr->resi_id)->where('id_invoice',0)->update('invoice_asuransi',$update_asr);
   //            }
   //          }
   //
   //          $selectasuransi=$this->db->select("sum(jumlah_asuransi) as jumlah")->from('invoice_asuransi')->where('id_invoice', $invjual_id)->get()->row();
   //          $asuransiinvoice=@$selectasuransi->jumlah;
   //
   //          $jumlah=0; $total=0; $totalsamping=0;
   //          $data_invoice_product = $this->get_invoice_product2($invjual_id)->result();
   //          foreach($data_invoice_product as $ils){
   //            // Cek Harga Khusus
   //            $cekhargacustomer = $this->Mbarang->data_hbc($ils->id_cust,$ils->jenis_barang_id)->num_rows();
   //            $cekhargagrup     = $this->Mbarang->data_hbcg($id_cgrup,$ils->jenis_barang_id)->num_rows();
   //            if($cekhargacustomer == 0 && $harga_otomatis == 1){
   //             $month = date("m",strtotime($ils->tanggal));
   //         		 $cek_cbm = $this->db->select('sum(ctns*volume) as jumlah')->from('giw')
   //         												->join('resi','giw.resi_id=resi.id_resi','left')
   //         												->where('giw.customer_id',$ils->id_cust)
   //         												->where('month(resi.tanggal)',$month)
   //         												->get()->row();
   //              if($cek_cbm->jumlah > 10){
   //                $updhargakhusus2['harga_jual'] = $ils->harga_jual - 500000;
   //                $this->db->where('nomor',$ils->nomor)->update('giw',$updhargakhusus2);
   //              }
   //            }
   //            include APPPATH. 'helpers/harga_beli.php';
   //          }
   //
   //          // Row Inv
   //          $rowinvoice = $this->Minvoice_barang->data_invoice($invjual_id)->row();
   //
   //          $jumlah=0; $total=0; $totalsamping=0; $total_volume=0; $total_diskon=0; $jumlah_diskon =0; $biayatambahan = 0; $ketbiaya = "";
   //          $data_invoice_product = $this->get_invoice_product2($invjual_id)->result();
   //          foreach($data_invoice_product as $ils){
   //            $diskon = 0;
   //            $tgl_barang_di_china = $ils->tanggal;
   //        	 	 $tgl_dapet_diskon = date('Y-m-d', strtotime('+45 days', strtotime($tgl_barang_di_china)));
   //        		if($tgl_dapet_diskon > date('Y-m-d')){
   //              // ga kena diskon
   //        		}else{
   //              $diskon = 1;
   //        		}
   //            include APPPATH. 'helpers/harga.php';
   //          }
   //          if(@$total_diskon > 0){
   //            // $potongan_diskon['id_invoice'] =$invjual_id;
   //            // $potongan_diskon['id_jenis_potongan'] = "10";
   //            // $potongan_diskon['jumlah_potongan'] = 0;
   //            // $potongan_diskon['keterangan_potongan'] = "Potongan Barang Telat";
   //            // // print_r($potongan_diskon);
   //            // // echo "<br />";
   //            // // print_r($potongan_diskon['jumlah_potongan']);
   //            // $this->db->insert('potongan',$potongan_diskon);
   //            // $sql = "INSERT INTO potongan (id_invoice, id_jenis_potongan, jumlah_potongan, keterangan_potongan)
   //            //         VALUES ($invjual_id, 10,-$total_diskon,'Potongan Barang Telat')";
   //            // $this->db->query($sql);
   //          }
   //          $biayatambahannya = 0;
   //          if(@$biayatambahan > 0){
   //            $biaya_tambahan['id_invoice'] =$invjual_id;
   //            $biaya_tambahan['id_jenis_potongan'] = "15";
   //            $biaya_tambahan['jumlah_potongan'] = $biayatambahan;
   //            $biaya_tambahan['keterangan_potongan'] = "Biaya ".$ketbiaya;
   //            // print_r($biaya_tambahan['jumlah_potongan']);
   //            $this->db->insert('potongan',$biaya_tambahan);
   //          }
   //          $biayatambahannya = $biayatambahan;
   //          $bulaninvoice = date('m');
   //          $tglinv = date("Y-m-d");
   //          if($bulaninvoice == 1){
   //             $bulansebelumnya = 12;
   //             $tglsblmnya = date("Y"."-12-"."01");
   //          }else{
   //             $bulanisebelumnya = date('m') - 1;
   //             $tglsblmnya = date("Y-".$bulanisebelumnya."-01");
   //          }
   //          $dataresi   = $this->db->select('sum(giw.volume * giw.ctns) as cbm')->from('giw')
   //                                 ->join('resi','resi.id_resi=giw.resi_id','left')
   //                                 ->where('resi.cust_id',$id_cust)
   //                                 ->where('resi.tanggal >=',$tglsblmnya)
   //                                 ->where('resi.tanggal <=',$tglinv)
   //                                 ->get()->row();
   //         $dataresi_inv   = $this->db->select('giw.resi_id,resi.nomor as nomor_resi,sum(giw.volume * giw.ctns) as cbm')->from('invoice_product')
   //                                    ->join('giw','giw.id=invoice_product.id_giw','left')
   //                                    ->join('resi','resi.id_resi=giw.resi_id','left')
   //                                    ->where('invoice_product.id_invoice',$invjual_id)
   //                                    ->group_by("resi.id_resi")
   //                                    ->get()->result();
   //        if($dataresi->cbm < 2){
   //          $jumlah_potong_resi_perbulan = 0;
   //          foreach($dataresi_inv as $dri){
   //            $hargatertinggiresi = $this->db->select('giw.harga_jual')->from('giw')->where('giw.resi_id',$dri->resi_id)->order_by('giw.harga_jual','desc')->limit(1)->get()->row();
   //            if($dri->cbm <= 0.1){
   //              $countpembulatannya = 0.1-$dri->cbm ;
   //              $cek_pembulatan = 1;
   //              $dataresiinv['id_invoice'] =$invjual_id;
   //              $dataresiinv['id_jenis_potongan'] = "3";
   //              $dataresiinv['jumlah_potongan'] = $countpembulatannya * $hargatertinggiresi->harga_jual;
   //              $dataresiinv['keterangan_potongan'] = "Pembulatan Resi 0.1 ".$dri->nomor_resi;
   //              // print_r($dataresiinv['jumlah_potongan']);
   //              $this->db->insert('potongan',$dataresiinv);
   //            }
   //            $jumlah_potong_resi_perbulan += $dataresiinv['jumlah_potongan'];
   //          }
   //        }
   //        $id_resi_array = array();
   //        $ongkos_perbulan05 = 0;
   //        foreach($dataresi_inv as $dri){
   //          if($dri->cbm <= 0.5){
   //            $cek_pembulatan = 1;
   //            $chargetambahan['id_invoice'] =$invjual_id;
   //            $chargetambahan['id_jenis_potongan'] = "16";
   //            $chargetambahan['jumlah_potongan'] = 100000;
   //            $chargetambahan['keterangan_potongan'] = "Charge Pengiriman dibawah 0.5 m<sup>3</sup>";
   //            // print_r($chargetambahan['jumlah_potongan']);
   //            $this->db->insert('potongan',$chargetambahan);
   //            $ongkos_perbulan05+=$chargetambahan['jumlah_potongan'];
   //          }
   //        }
   //        if($cek_pembulatan == 1){
   //          $statusinvoicenya = "Pembulatan 0.1";
   //          $tagihan_jual = $total + $jumlah_potong_resi_perbulan + $biayatambahannya + $ongkos_perbulan05;
   //        }else{
   //          $statusinvoicenya = "Normal";
   //          $tagihan_jual = $total + $biayatambahannya;
   //        }
   //          $pesankedev = "Generate ".$insert_invjual['kode_invoice']." Status ".$statusinvoicenya." Jumlah Tagihan ".number_format($tagihan_jual)." Jumlah Potongan ".$jumlah_potong_resi_perbulan." harga utama ".$total;
   //          sendwhatsapp($pesankedev,"083815423599");
   //
   //          $update_invjual['total_tagihan'] = $tagihan_jual;
   //          $this->db->where('id_invoice',$invjual_id);
   //          $this->db->update('invoice', $update_invjual);
   //
   //          // Referal
   //          $kurs_global = $this->db->where('id_kurs',1)->get('kurs')->row();
   //          $komisi_global_barang = $kurs_global->komisi_barang;
   //          if($id_referal > 0){
   //            if($nama_customer == "Nurul Magfirah Putram"){
   //                $total_komisi_nurul = 0;
   //                $ket_komisi_nurul   = "";
   //              foreach($data_invoice_product as $ils2){
   //                $jumlahctns_nurul      = $ils2->jumlah;
   //                $volume_nurul          = $jumlahctns_nurul * $ils2->volume;
   //                $jenis_barang_id_nurul = $ils2->jenis_barang_id;
   //                if($jenis_barang_id_nurul == 22){
   //                  $komisi_nurul     = $volume_nurul * 500000;
   //                  $ket_komisi_nurul .= $ils2->nomor." ".$volume_nurul."m<sup>3</sup> * Komisi 500000 ,";
   //                }else{
   //                  $komisi_nurul     = $volume_nurul * 250000;
   //                  $ket_komisi_nurul .= $ils2->nomor." ".$volume_nurul."m<sup>3</sup> * Komisi 250000 ,";
   //                }
   //                $total_komisi_nurul += $komisi_nurul;
   //              }
   //              $get_referal = $this->db->where('id_cust',$id_cust)->get('customer')->row();
   //              $input_referal['id_cust'] = $id_referal;
   //              $input_referal['kode_komisi'] = $this->Mkomisi_referal->kode_komisi();
   //              $input_referal['customer'] = $rowinvoice->kode;
   //              $input_referal['id_invoice'] = $invjual_id;
   //              $input_referal['nilai'] = $total_komisi_nurul;
   //              $input_referal['keterangan'] = $ket_komisi_nurul;
   //              $input_referal['status'] = 1;
   //              // input
   //              $this->db->insert('komisi_referal', $input_referal);
   //            }else{
   //              $get_referal = $this->db->where('id_cust',$id_cust)->get('customer')->row();
   //              if($get_referal->komisi_barang == 0){
   //                $komisifix  = $komisi_global_barang * $total_volume;
   //                $ket_komisi = "Komisi Referal Global : ".$komisi_global_barang." * Total Volume : ".$total_volume;
   //              }else{
   //                $komisifix = $get_referal->komisi_barang * $total_volume;
   //                $ket_komisi = "Komisi Referal Khusus : ".$get_referal->komisi_barang." * Total Volume : ".$total_volume;
   //              }
   //              $input_referal['id_cust'] = $id_referal;
   //              $input_referal['kode_komisi'] = $this->Mkomisi_referal->kode_komisi();
   //              $input_referal['customer'] = $rowinvoice->kode;
   //              $input_referal['id_invoice'] = $invjual_id;
   //              $input_referal['nilai'] = $komisifix;
   //              $input_referal['keterangan'] = $ket_komisi;
   //              $input_referal['status'] = 1;
   //              // input
   //              $this->db->insert('komisi_referal', $input_referal);
   //            }
   //          }
   //
   //          if($tagihan_jual <= 0){
   //            die();
   //          }
   //          $data_invoice_product2 = $this->get_invoice_product2($invjual_id)->num_rows();
   //          if($data_invoice_product2 <= 0){
   //            die();
   //          }
   //          // die();
   //          // cek harga
   //          $cekharga=$this->db->select('SUM(((giw.qty*giw.ctns)*giw.nilai)*2000) as harga_barang')
   //                            ->from('giw')
   //                            ->join('status_giw','status_giw.id=giw.status','left')
   //                            ->where('customer_id',$id_cust)
   //                            ->where('status_giw.urutan <',12)
   //                            ->get()->row();
   //          if($cekharga->harga_barang > $tagihan_jual){
   //            if($fix_alamat == 1){
   //              $sql = "UPDATE invoice_product JOIN giw ON invoice_product.id_giw = giw.id SET giw.boleh_kirim = 2
   //                      WHERE invoice_product.id_invoice = $invjual_id";
   //              $this->db->query($sql);
   //            }else{
   //              $sql = "UPDATE invoice_product JOIN giw ON invoice_product.id_giw = giw.id SET giw.boleh_kirim = 1
   //                      WHERE invoice_product.id_invoice = $invjual_id";
   //              $this->db->query($sql);
   //            }
   //          }else{
   //            $sql = "UPDATE invoice_product JOIN giw ON invoice_product.id_giw = giw.id SET giw.boleh_kirim = 0
   //                    WHERE invoice_product.id_invoice = $invjual_id";
   //            $this->db->query($sql);
   //          }
   //          // Info Ke Customer
   //          $test['status'] =0;
   //          $test['record_asuransi'] = $this->Minvoice_barang->cek_asuransi($invjual_id)->result();
   //          $test['record'] = $this->Minvoice_barang->data_invoice($invjual_id)->row();
   //          $test['barcode']= $this->Minvoice_barang->getinvoice_product($invjual_id)->result();
   //          $test['potongan']=$this->Minvoice_barang->data_potongan($invjual_id)->result();
   //          $data = $this->load->view('admin/invoice_barang/pdf_invoice',$test,True);
   //
   //          $mpdf = new \Mpdf\Mpdf();
   //          $mpdf->WriteHTML($data);
   //          $mpdf->Output("pdf_file/".time()."inv.pdf" ,'F');
   //          $time=time()."inv.pdf";
   //
   //          $pesan = "*Yth. Bpk/Ibu ".$rowinvoice->nama." (".$rowinvoice->kode.")*\n\nBarang Anda akan segera sampai di gudang Jakarta kami. ".
   //                     "Berikut kami lampirkan detail barang dan invoice barang ".$rowinvoice->kode_invoice." yang harus Anda bayar, yaitu sebesar *Rp. ".number_format($tagihan_jual).
   //                     "* ke rekening berikut:\n\n*BCA 5810557747 a/n Gusmavin Willopo*\n\nHarap segera lakukan pembayaran agar barang dapat segera masuk dalam antrian pengiriman barang.".
   //                     " Setelah melakukan pembayaran harap konfirmasi pembayaran Anda dengan menghubungi CS kami melalui telepon / WA.".
   //                     "\n\nAlamat kirim : (".$nama_penerima.",".$telepon_penerima.",".$alamat_penerima.")".
   //                     "\nJika ada perubahan alamat mendadak, harap segera informasikan ke CS kami!".
   //                     "\nTerima kasih atas kerjasamanya :)".
   //                     "\n\n*Wilopo Cargo* _(do not reply)_";
   //
   //          sendwhatsapp($pesan,$whatsapp);
   //          $sendoc = send_newdoc($time,$whatsapp,$rowinvoice->kode_invoice);
   //
   //          sendwhatsapp($pesan,"081310961108");
   //          $sendoc = send_newdoc($time,"081310961108",$rowinvoice->kode_invoice);
   //
   //          $config = Array(
   //            'protocol' => 'smtp',
   //      			'smtp_host' => 'mail.wilopocargo.com',
   //      			'smtp_port' => 25,
   //      			'smtp_user' => user_email(), //isi dengan gmailmu!
   //      			'smtp_pass' => pass_email(),
   //      			'mailtype' => 'html',
   //      			'charset' => 'iso-8859-1',
   //      			'wordwrap' => TRUE
   //          );
   //
   //          $content = $mpdf->Output('', 'S');
   //          $this->load->library('email', $config);
   //          $this->email->attach($content, 'attachment', $rowinvoice->kode_invoice , 'application/pdf');
   //          $the_message="<html>
   //                              <body>
   //                                      <h3>Yth. ".$rowinvoice->kode." ,</h3>
   //                                      <p>Barang Anda akan segera sampai di gudang Jakarta kami. Berikut kami lampirkan detail barang dan invoice barang ".$rowinvoice->kode_invoice."
   //                                          yang harus Anda bayar, yaitu sebesar <b>Rp.".number_format($tagihan_jual)." </b>ke rekening berikut:</p>
   //                                      <p><b>BCA 5810557747 a/n Gusmavin Willopo</b></p>
   //                                      <p>Harap segera lakukan pembayaran agar barang dapat segera masuk dalam antrian pengiriman barang.</p>
   //                                      <p>Setelah melakukan pembayaran harap konfirmasi pembayaran Anda dengan menghubungi CS kami melalui telepon / WA.</p>
   //                                      <p>".nama_perusahaan()."</p>
   //
   //                              </body>
   //                        </html>";
   //
   //          $this->email->set_newline("\r\n");
   //          $this->email->from(user_email());
   //          $this->email->to($mail_cust); //email tujuan. Isikan dengan emailmu!
   //          $this->email->subject('[Wilopo Cargo] Invoice Barang '.$rowinvoice->kode_invoice);
   //          $this->email->message($the_message);
   //
   //          if($this->email->send())
   //          {
   //            if($sendoc){
   //             $path_unlink = './'.$time;
   //             unlink($path_unlink );
   //            }
   //          }
   //          else
   //          {
   //            //show_error($this->email->print_debugger());
   //          }
   //      }
   //  }

}
