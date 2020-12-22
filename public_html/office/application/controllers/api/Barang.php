 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {

	public function __construct(){
		parent::__construct();

		  $this->load->model('Mbarang');
			$this->load->model('Mapiinvoice');

	}

	function tes_aja(){
		sendwhatsapp("Barang Masuk",'083815423599');
		die("oke");
	}

	function delete_barcode(){
		// sendwhatsapp("Delete Giw ".$this->input->post('nomor_giw'),'083815423599');
		$this->db->where('nomor',$this->input->post('nomor_giw'))->delete('giw');
	}

	function update_resi(){
		$getcust = $this->db->where('kode',$this->input->post('kode'))->get('customer')->row();
		$getresi = $this->db->where('id_resi_rts',$this->input->post('id_resi_rts'))->get('resi')->row();
		$update_resi['supplier']=  $this->input->post('supplier');
		$update_resi['tel']= $this->input->post('tel');
		$update_resi['note']= $this->input->post('note');
		$update_resi['cust_id']= $getcust->id_cust;

		$this->db->where('id_resi_rts',$this->input->post('id_resi_rts'));
		$this->db->update('resi', $update_resi);

    $update_giw['customer_id']= $getcust->id_cust;

		$this->db->where('resi_id',$getresi->id_resi);
		$this->db->update('giw', $update_giw);

		$update_barcode['resi_id']= $getresi->id_resi;

		$this->db->where('resi_id',$getresi->id_resi);
		$this->db->update('giw', $update_barcode);
	}

	function update_barcode(){
    // sendwhatsapp("Ubah Giw ".$this->input->post('nomor_giw'),"083815423599");
		$potongan = "500000";
		$nomor_giw = $this->input->post('nomor_giw');
		$data_barcode = $this->db->select('giw.*,customer.id_cgrup')->from('giw')
                             ->join('customer', 'giw.customer_id=customer.id_cust', 'left')
                             ->where('nomor',$nomor_giw)->get()->row();
		$jalurr = $data_barcode->jalur;
		$id_cust = $data_barcode->customer_id;
    $id_cgrup = $data_barcode->id_cgrup;
		$id_jenis_barang = $this->input->post('id_jenis_barang');
    $updresi['status_ubah'] = 1;
    $this->db->where('id_resi',$data_barcode->resi_id)->update('resi',$updresi);

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
    // sendwhatsapp("resi id ".$data_barcode->resi_id,"083815423599");
	  $hb	= $harga_jual;

		$update_barcode['barang']=  $this->input->post('barang');
		$update_barcode['jenis_barang_id']= $id_jenis_barang;
		$update_barcode['ctns']= $this->input->post('ctns');
		$update_barcode['qty']=  $this->input->post('qty');
		$update_barcode['volume']= $this->input->post('volume');
		$update_barcode['berat']= $this->input->post('berat');
		$update_barcode['nilai']= $this->input->post('nilai');
		$update_barcode['note']= $this->input->post('note');
		$update_barcode['remarks']= $this->input->post('remarks');
		$update_barcode['harga']= $this->input->post('harga') - $potongan;
		$update_barcode['harga_jual']= $hb;
    $update_barcode['packing_fare']= $this->input->post('packing_fare');
    $update_barcode['fare']= $this->input->post('fare');
    $update_barcode['biaya_lain']= $this->input->post('biaya_lain');
    $update_barcode['kurs_fare']= $this->input->post('kurs_fare');
    $update_barcode['bm']= $this->input->post('bm');
    $update_barcode['tax_import']= $this->input->post('tax_import');
    $update_barcode['fee']= $this->input->post('fee');

		$this->db->where('nomor',$nomor_giw);
		$this->db->update('giw', $update_barcode);
	}

  function update_barcode2(){
    // sendwhatsapp("ubahgiw","083815423599");
		$potongan = "500000";
		$nomor_giw = "123-22596";
		$data_barcode = $this->db->where('nomor',$nomor_giw)->get('giw')->row();
    // print_r($data_barcode->resi_id);die();
		$jalurr = $data_barcode->jalur;
		$id_cust = $data_barcode->customer_id;
		$id_jenis_barang = $this->input->post('id_jenis_barang');
    $updresi['status_ubah'] = 1;
    $this->db->where('id_resi',$data_barcode->resi_id)->update('resi',$updresi);

	}

	function cekinsertbarcode(){
		$potongan = "500000";
		$data_resi= $this->Mbarang->data_resirts($this->input->post('resi_id'));
		if($data_resi->num_rows() == 0){
			die();
		}
		foreach($data_resi->result() as $dresis ){
					$id_resi      =$dresis->id_resi;
					$id_customer  =$dresis->cust_id;
          $id_cgrup     =$dresis->id_cgrup;
		 }
		$hb  = 0;
		$cekhargacustomer = $this->Mbarang->data_hbc($id_customer,$this->input->post('id_jenis_barang'))->num_rows();
    $cekhargagrup     = $this->Mbarang->data_hbcg($id_cgrup,$this->input->post('id_jenis_barang'))->num_rows();
    if($id_cgrup > 0 && $cekhargagrup > 0){
      $dhbc = $this->Mbarang->data_hbcg($id_cgrup,$this->input->post('id_jenis_barang'))->row();
      $hj   = $dhbc->harga;
    }else if($cekhargacustomer > 0){
			$dhbc = $this->Mbarang->data_hbc($id_customer,$this->input->post('id_jenis_barang'))->row();
			$hj   = $dhbc->harga;
		}else{
			$dhb = $this->Mbarang->data_hb($this->input->post('id_jenis_barang'));
			foreach($dhb->result() as $harb ){
				$hj      =$harb->harga;
			}
		}

		$barang               = $this->input->post('barang');
		$nomor_brcd           = $this->input->post('nomor');
		$idc                  = $id_customer;
		$id_jenis_barang      = $this->input->post('id_jenis_barang');
		$ctns                 = $this->input->post('ctns');
		$qty                  = $this->input->post('qty');
		$berat                = $this->input->post('berat');
		$volume               = $this->input->post('volume');
		$nilai                = $this->input->post('nilai');
		$status               = $this->input->post('status');
		$note                 = $this->input->post('note');
		$asuransi             = $this->input->post('asuransi');
		$kurs                 = $this->input->post('kurs');
		$remarks              = $this->input->post('remarks');
		$harga                = $this->input->post('harga') - $potongan;
		$packing_fare         = $this->input->post('packing_fare');
		$fare                 = $this->input->post('fare');
		$biaya_lain           = $this->input->post('biaya_lain');
		$kurs_fare            = $this->input->post('kurs_fare');
    $bm                   = $this->input->post('bm');
    $tax_import           = $this->input->post('tax_import');
    $fee                  = $this->input->post('fee');
		$resi_id              = $id_resi;
		$status_berat         = $this->input->post('status_berat');
		$jalur                = $this->input->post('jalur');

		if(in_array($id_jenis_barang,array(18,19,20,21,22,28,33,34))){
			$jalur                = 2;
			$statusjalur					= 0;
		}else{
			$jalur                = 1;
			$statusjalur					= 0;
		}
		$hb				            = $hj;

		$this->Mbarang->insert_barcode($barang,$nomor_brcd,$idc,$id_jenis_barang,$ctns,$qty,$berat,$volume,$nilai,$status,$note,$asuransi,
		$kurs,$remarks,$harga,$resi_id,$status_berat,$hb,$jalur,$bm,$tax_import,$fee);

    $updresi['status_ubah'] = 1;
    $this->db->where('id_resi',$id_resi)->update('resi',$updresi);
	}

  function cekinsertbiaya(){
    sendwhatsapp("api cek insert biaya","083815423599");
    $cek_barcode = $this->db->where('nomor',$this->input->post('nomor_giw'))->get('giw')->row();
    $cek_biaya   = $this->db->where('id_rts',$this->input->post('id_biaya_tambahan'))->get('biaya_tambahan')->num_rows();
    if($cek_biaya > 0){
      die("sudah ada biaya");
    }
    $inputbiaya['giw_id'] = $cek_barcode->id ;
    $inputbiaya['jenis_biaya_tam_id'] = $this->input->post('jenis_biaya_tam_id');
    $inputbiaya['tipe'] = $this->input->post('tipe');
    $inputbiaya['tgl'] = $this->input->post('tgl');
    $inputbiaya['jumlah'] = $this->input->post('jumlah');
    $inputbiaya['rmb'] = $this->input->post('rmb');
    $inputbiaya['id_rts'] = $this->input->post('id_biaya_tambahan');
    $this->db->insert('biaya_tambahan',$inputbiaya);
  }

  function insert_biaya_tambahan(){
    sendwhatsapp("api edit cek insert biaya","083815423599");
    $cek_barcode = $this->db->where('nomor',$this->input->post('nomor_giw'))->get('giw')->row();
    $cek_biaya   = $this->db->where('id_rts',$this->input->post('id_biaya'))->get('biaya_tambahan')->num_rows();
    if($cek_biaya > 0){
      die("sudah ada biaya");
    }
    $inputbiaya['giw_id'] = $cek_barcode->id ;
    $inputbiaya['jenis_biaya_tam_id'] = $this->input->post('jenis_biaya_tam_id');
    $inputbiaya['tipe'] = $this->input->post('tipe');
    $inputbiaya['tgl'] = $this->input->post('tgl');
    $inputbiaya['jumlah'] = $this->input->post('jumlah');
    $inputbiaya['rmb'] = $this->input->post('rmb');
    $inputbiaya['ket'] = $this->input->post('ket');
    $inputbiaya['id_rts'] = $this->input->post('id_biaya');
    $this->db->insert('biaya_tambahan',$inputbiaya);
  }

  function update_biaya_tambahan(){
    sendwhatsapp("edit biaya","083815423599");
    $cek_barcode = $this->db->where('nomor',$this->input->post('nomor_giw'))->get('giw')->row();
    $cek_biaya   = $this->db->where('id_rts',$this->input->post('id_biaya'))->get('biaya_tambahan')->num_rows();

    // $inputbiaya['giw_id'] = $cek_barcode->id ;
    $inputbiaya['jenis_biaya_tam_id'] = $this->input->post('jenis_biaya_tam_id');
    $inputbiaya['tipe'] = $this->input->post('tipe');
    $inputbiaya['tgl'] = $this->input->post('tgl');
    $inputbiaya['jumlah'] = $this->input->post('jumlah');
    $inputbiaya['rmb'] = $this->input->post('rmb');
    $inputbiaya['ket'] = $this->input->post('ket');
    $inputbiaya['id_rts'] = $this->input->post('id_biaya');
    $this->db->where('id',$this->input->post('id_biaya'));
    $this->db->update('biaya_tambahan',$inputbiaya);
  }

    function ins_barcode(){
			$potongan = "500000";
      $data_resi= $this->Mbarang->data_resi($this->input->post('resi_id'));
    	foreach($data_resi->result() as $dresis ){
            $id_resi      =$dresis->id_resi;
            $id_customer  =$dresis->cust_id;
            $id_cgrup     =$dresis->id_cgrup;
     	 }
			$hb  = 0;
			$cekhargacustomer = $this->Mbarang->data_hbc($id_customer,$this->input->post('id_jenis_barang'))->num_rows();
      $cekhargagrup     = $this->Mbarang->data_hbcg($id_cgrup,$this->input->post('id_jenis_barang'))->num_rows();
      if($id_cgrup > 0 && $cekhargagrup > 0){
        $dhbc = $this->Mbarang->data_hbcg($id_cgrup,$this->input->post('id_jenis_barang'))->row();
        $hj   = $dhbc->harga;
      }else if($cekhargacustomer > 0){
				$dhbc = $this->Mbarang->data_hbc($id_customer,$this->input->post('id_jenis_barang'))->row();
				$hj   = $dhbc->harga;
			}else{
				$dhb = $this->Mbarang->data_hb($this->input->post('id_jenis_barang'));
	    	foreach($dhb->result() as $harb ){
          $hj      =$harb->harga;
	     	}
			}

      $barang               = $this->input->post('barang');
      $nomor_brcd           = $this->input->post('nomor');
      $idc                  = $id_customer;
      $id_jenis_barang      = $this->input->post('id_jenis_barang');
      $ctns                 = $this->input->post('ctns');
      $qty                  = $this->input->post('qty');
      $berat                = $this->input->post('berat');
      $volume               = $this->input->post('volume');
      $nilai                = $this->input->post('nilai');
      $status               = $this->input->post('status');
      $note                 = $this->input->post('note');
      $asuransi             = $this->input->post('asuransi');
      $kurs                 = $this->input->post('kurs');
      $remarks              = $this->input->post('remarks');
      $harga                = $this->input->post('harga') - $potongan;
      $packing_fare         = $this->input->post('packing_fare');
      $fare                 = $this->input->post('fare');
      $biaya_lain           = $this->input->post('biaya_lain');
      $kurs_fare            = $this->input->post('kurs_fare');
      $bm                   = $this->input->post('bm');
      $tax_import           = $this->input->post('tax_import');
      $fee                  = $this->input->post('fee');
      $resi_id              = $id_resi;
      $status_berat         = $this->input->post('status_berat');
			$jalur                = $this->input->post('jalur');

			if(in_array($id_jenis_barang,array(18,19,20,21,22,28,33,34))){
				$jalur                = $this->input->post('jalur');
				$statusjalur					= 0;
			}else{
				$jalur                = 1;
				$statusjalur					= 0;
			}
			$hb				            = $hj;

      $this->Mbarang->insert_barcode($barang,$nomor_brcd,$idc,$id_jenis_barang,$ctns,$qty,$berat,$volume,$nilai,$status,$note,$asuransi,
      $kurs,$remarks,$harga,$resi_id,$status_berat,$hb,$jalur,$packing_fare,$fare,$biaya_lain,$kurs_fare,$bm,$tax_import,$fee);
    }

    function ins_resi(){
				// sendwhatsapp("Barang Masuk",'083815423599');
				sendwhatsapp("Barang Masuk China ".$this->input->post('nomor'),'085318999004');
				// die();
        $data_customer= $this->Mbarang->data_customer($this->input->post('cust_id'));
      	foreach($data_customer->result() as $dcusto ){
              $id_cust      =$dcusto->id_cust;
              $mail_cust    =$dcusto->email;
       	}

        $eid=$this->input->post('eid');
        $id_resi_rts=$this->input->post('id_resi_rts');
        $kode = $id_cust;
        $konifrmasi_resi = $this->input->post('konfirmasi_resi');
        $gudang = $this->input->post('gudang');
        $nomor_resi = $this->input->post('nomor');
        $tanggal_resi = date('Y-m-d');
        $supplier = $this->input->post('supplier');
        $tel = $this->input->post('tel');
        $note = $this->input->post('note');
        $id_request_resi = $this->input->post('id_request_resi');
        $this->Mbarang->insert_resi($eid,$id_resi_rts,$kode,$nomor_resi,$tanggal_resi,$supplier,$tel,$note,$konifrmasi_resi,$gudang,$id_request_resi);
    }

    function resi_email(){
      $nomor_resi=$this->input->post('nomor');
	    // $nomor_resi=$this->uri->segment(4);
      $data_resi= $this->Mbarang->data_resi($nomor_resi);
    //   print_r($data_resi->result());die();
      foreach($data_resi->result() as $dresis ){
          $id_resi      =$dresis->id_resi;
          $kodem  =$dresis->kode;
          $supp  =$dresis->supplier;
          $supptel  =$dresis->tel;
          $eid  = $dresis->encrypt_resi;
          $id_pendaftar  =$dresis->id_pendaftar;
          $id_crm  =$dresis->id_crm;
          if($dresis->id_cgrup > 0){
           $email_customer  =$dresis->email_cgrup;
		       $whatsapp_customer  =$dresis->whatsapp_cgrup;
          }else{
           $email_customer  =$dresis->email;
		       $whatsapp_customer  =$dresis->whatsapp;
          }
          $vmail  =$dresis->validasi_email;
          $tgl_resi  =$dresis->tanggal;
          $status_ubah  =$dresis->status_ubah;
       }
			 $limit1barcode = $this->db->where('resi_id',$id_resi)->limit(1)->get('giw')->row();
			 $kode_barcode  = substr($limit1barcode->nomor,0,4);
			 if($kode_barcode == "123Y"){
				 $updresi['gudang'] = "6";
				 $this->db->where('id_resi',$id_resi)->update('resi',$updresi);
			 }else{
				 $updresi['gudang'] = "5";
				 $this->db->where('id_resi',$id_resi)->update('resi',$updresi);
			 }
       $revisi_data = "";

      if($status_ubah !=0){
        $revisi_data = " (Revisi Data) ";
      }

      // echo $revisi_data;die();
      // die();
	    if($vmail==2 && $status_ubah==0){
        sendwhatsapp("ga masuk",'083815423599');
					echo "v";die();
	    }else{
				$result ='';
				$pesan = '';
				$tvolumes = 0;
				$total_asuransi= 0;
        $totalasuransipk=0;
				$nilaibarangrpasu = array();
	      $volumeasu        = array();
				$overbarcode = 0;
				$data_barcodes= $this->Mbarang->data_brcd($id_resi);
				if($data_barcodes->num_rows() > 15){
					$overbarcode   = 1;
					$data_barcodes2= $this->Mbarang->data_brcd2($id_resi);
					foreach($data_barcodes2->result() as $barcodelimit ){
				 	   $result .= $barcodelimit->nomor.': '.$barcodelimit->barang.' ('.$barcodelimit->namalain.'), '.$barcodelimit->ctns.' ctns, '.
						 						$barcodelimit->qty * $barcodelimit->ctns.' pcs, '.$barcodelimit->berat * $barcodelimit->ctns.' kg, '.
												$barcodelimit->volume * $barcodelimit->ctns.' m3, '.$barcodelimit->nilai * $barcodelimit->ctns * $barcodelimit->qty.
												' RMB, '.$barcodelimit->remarks."\n";

						$teks_khusus = "Untuk selengkapnya mohon cek resi anda di website utama kami www.wilopocargo.com/cek-resi";
	       	}
				}
      	foreach($data_barcodes->result() as $dbar ){
          if(in_array($dbar->jenis_barang_id,array(18,19,20,21,37,38,22,28,33,34))){
            if($dbar->jalurcust == 3){
              $jalurnya = 5 ; //Wajib Asuransi
            }else if($dbar->jalurcust == 2){
              $jalurnya = 6;
            }else{
              $jalurnya = 4 ; //Pilih Asuransi(SMG) atau tidak (PK)
            }
              //Pilih Asuransi(SMG) atau tidak (PK)
          }else{
             $jalurnya = 6;  //PK Asuransi Atau No Asuransi
          }
           $volumes=$dbar->volume * $dbar->ctns;
           $nilais=$dbar->nilai * $dbar->ctns ;
           $ctnss=$dbar->ctns;
		       $berats=$dbar->berat * $dbar->ctns;
           $qtys=$dbar->qty * $dbar->ctns;

	         $rmb1 = $dbar->nilai * $dbar->ctns * $dbar->qty;
	         $rmb2 = $rmb1 * $dbar->kurs;
	         $tvolumes += $dbar->volume;
	         $total_asuransi += $rmb2;
	         $nilaibarangrpasu[] = $dbar->nilai * $dbar->qty * $dbar->ctns * $dbar->kurs;
           $volumeasu[] = $dbar->volume * $dbar->ctns;
					 // result
					 if($overbarcode != 1){
						 $result .= $dbar->nomor.': '.$dbar->barang.' ('.$dbar->namalain.'), '.$dbar->ctns.' ctns, '.$qtys.' pcs, '.$berats.' kg, '.$volumes.' m3, '.$rmb1.' RMB, '.$dbar->remarks."\n";
					 }
       	}

	            $totalnilaibarangrp = array_sum($nilaibarangrpasu);
	           $totalvolume = array_sum($volumeasu);
	           $totalkompensasi = $totalvolume * 20000000;

	           $selisihasuransi = $totalnilaibarangrp - $totalkompensasi;

	           if($selisihasuransi > 0){
	               $persentase = ($selisihasuransi/$totalvolume)/10000000;
	                if($persentase < 1){
	                    $persentasebaru = 1;
	                }else if(floor($persentase) > 20){
										  $persentasebaru = 20;
									}else{
	                    $persentasebaru = floor($persentase);
	                }
	               $totalasuransi = $persentasebaru/100 * $selisihasuransi;
                 $totalasuransipk = round($totalasuransi/2);
	           }else{
	               $totalasuransi = 0;
	           }
           if($jalurnya == 6){
             $asrns_tambahan = round($totalasuransipk);
           }else{
             $asrns_tambahan = round($totalasuransi);
           }
	         //die($total_asuransi);

	         $c1="<table cellpadding='1' cellspacing='2' border='1'>
	          <thead>
	          <tr>
	              <th colspan='4'><img src='".base_url()."assets/logo2.jpg' style='height:100px;'></th>
	              <th colspan='4'>
	                              <p>DATE : ".$tgl_resi."</p>
	                              <p>CUSTOMER CODE : ".$kodem."</p>
	                              <p>SUPPLIER : ".$supp."</p>
	                              <p>SUPPLIER TEL : ".$supptel."</p>
	              </th>
	          </tr>

	          <tr>
	               <th colspan='8' style='height:28px;'> RECEIPT NO : ".$nomor_resi.$revisi_data."</th>
	          </tr>

	               <tr>

					<th style='height: 25px;'><font color='black'>BARCODE</font></th>
					<th><font color='black'>GOODS</font></th>
					<th><font color='black'>CTNS</font></th>
					<th><font color='black'>QTY</font></th>
					<th><font color='black'>WEIGHT</font></th>
					<th><font color='black'>VOLUME</font></th>
					<th><font color='black'>RMB</font></th>
					<th><font color='black'>REMARK</font></th>

		    	</tr>
		   </thead>
		   <tbody>";

	     $this->db->like('id');
	     $this->db->where('resi_id',$id_resi);
	     $this->db->from('giw');
	     $jloop = $this->db->count_all_results();
	     $c2="";


		    	foreach($data_barcodes->result() as $c){

			     $mrmb = $c->nilai * $c->ctns * $c->qty;
		         $mqty= $c->qty * $c->ctns;
		         $mberat= $c->berat * $c->ctns;
		         $mvolume= $c->volume * $c->ctns;

		         $tctns  +=$c->ctns;
		         $tqty   +=$mqty;
		         $tberat +=$mberat;
		         $tvolume +=$mvolume;
		         $trmb +=$mrmb;
				     $nilaibarangrp += $c->nilai * $c->ctns * $c->qty * $c->kurs;


						 $c2 .= "<tr>
						    	<td style='height: 25px;'><font color='black'>".$c->nomor."</td>
								<td><font color='black'>".$c->barang."</td>
								<td><font color='black'><font color='black'>".$c->ctns."</td>
								<td><font color='black'>@".$mqty."/".$c->qty." pcs</td>
								<td><font color='black'>@".$c->berat."  kg</td>
								<td><font color='black'>@".$c->volume." m<sup>3</sup></td>
								<td><font color='black'>@".$c->nilai."/".$rmb." RMB</td>
								<td><font color='black'>".$c->remarks."</td>
						    	 </tr>";

		    	}

	            if($asrns_tambahan == 0){
	                 $h="<html>
	                            <body>
	                                    <p><h3>Yth. Bpk/Ibu ".$kodem.",</h3><br /> Kami telah menerima barang Anda di Gudang Kami, Berikut adalah detail resi pengiriman Anda.
	                                    Klik tombol dibawah untuk konfirmasi packing list resi, jika tidak maka barang Anda belum kami loading ke container.</p>
	                                    <p><a href='".base_url()."konfirmasi/konfirmasi/kf/".$eid."'><button style='background-color: #008CBA; padding: 10px 24px; border: none;
	                                                   color: white; font-size: 10px; border-radius: 12px;'>KONFIRMASI RESI AJA</button>
	                                    </a></p>

	                                    ";


	                          //</table>";

	                $f="<tr>
											<td colspan='2'><center><font color='black'>TOTAL </center></td>
											<td colspan=''><center><font color='black'> ".$tctns."  </center></td>
											<td colspan=''><center><font color='black'>".$tqty." pcs</center></td>
											<td colspan=''><center><font color='black'>".$tberat." kg</center></td>
											<td colspan=''><center><font color='black'>".round_up($tvolume,3)." m<sup>3</sup></center></td>
											<td colspan=''><center><font color='black'>".ceil($trmb)." RMB</center></td>
											<td style='height: 30px;'></td>
											</tr>
			                </tbody></table>
			                <p>".nama_perusahaan()."</p>

		                        </body>
		                  </html>";
	                //dipanggilnya disini
	               $the_message= $h."<br/>".$c1.$c2.$f;

	            }else if($asrns_tambahan != 0){
	               // echo $total_asuransi;
                 if($jalurnya == 5){
                   $h="<html>
	                            <body>
	                                    <p><h3>Yth. Bpk/Ibu ".$kodem.",</h3><br /> Kami telah menerima barang Anda di Gudang Kami, Berikut adalah detail resi pengiriman Anda.
	                                    Klik tombol dibawah untuk konfirmasi packing list resi, jika tidak maka barang Anda belum kami loading ke container.</p>
	                                    <p>Nilai barang yang Anda kirim ada yang melebihi jumlah asuransi yang kami cover per barcode (Rp. 20.000.000 / cbm), Anda dapat membeli asuransi
	                                    tambahan pada barang kiriman Anda sebesar <span style='color: #ff0000;font-size: 20px;'><strong>Rp.".number_format($asrns_tambahan)."</strong></span>,
	                                    agar dapat di cover full.</p>

	                                    <p><a href='".base_url()."konfirmasi/konfirmasi/kf_resi/".$eid."'><button style='background-color: #f44336; padding: 10px 24px; border: none;
	                                                   color: white; font-size: 10px; border-radius: 12px;'>KONFIRMASI & BELI ASURANSI</button>
	                                    </a></p>
	                                   ";
                 }else if($jalurnya == 4){
                   $h="<html>
	                            <body>
	                                    <p><h3>Yth. Bpk/Ibu ".$kodem.",</h3><br /> Kami telah menerima barang Anda di Gudang Kami, Berikut adalah detail resi pengiriman Anda.
	                                    Klik tombol dibawah untuk konfirmasi packing list resi, jika tidak maka barang Anda belum kami loading ke container.</p>
	                                    <p>Nilai barang yang Anda kirim ada yang melebihi jumlah asuransi yang kami cover per barcode (Rp. 20.000.000 / cbm), Anda dapat membeli asuransi
	                                    tambahan pada barang kiriman Anda sebesar <span style='color: #ff0000;font-size: 20px;'><strong>Rp.".number_format($asrns_tambahan)."</strong></span>,
	                                    agar dapat di cover full.</p>

	                                    <p><a href='".base_url()."konfirmasi/konfirmasi/kf_resi/".$eid."'><button style='background-color: #f44336; padding: 10px 24px; border: none;
	                                                   color: white; font-size: 10px; border-radius: 12px;'>KONFIRMASI & BELI ASURANSI</button>
	                                    </a></p>
	                                    <p><a href='".base_url()."konfirmasi/konfirmasi/kf_lb/".$eid."'><button style='background-color: #008CBA; padding: 10px 24px; border: none;
	                                                   color: white; font-size: 10px; border-radius: 12px;'>KONFIRMASI RESI AJA</button>
	                                    </a></p>
	                                   ";
                 }else if($jalurnya == 6){
                   $h="<html>
	                            <body>
	                                    <p><h3>Yth. Bpk/Ibu ".$kodem.",</h3><br /> Kami telah menerima barang Anda di Gudang Kami, Berikut adalah detail resi pengiriman Anda.
	                                    Klik tombol dibawah untuk konfirmasi packing list resi, jika tidak maka barang Anda belum kami loading ke container.</p>
	                                    <p>Nilai barang yang Anda kirim ada yang melebihi jumlah asuransi yang kami cover per barcode (Rp. 20.000.000 / cbm), Anda dapat membeli asuransi
	                                    tambahan pada barang kiriman Anda sebesar <span style='color: #ff0000;font-size: 20px;'><strong>Rp.".number_format($asrns_tambahan)."</strong></span>,
	                                    agar dapat di cover full.</p>

	                                    <p><a href='".base_url()."konfirmasi/konfirmasi/kf_resi/".$eid."'><button style='background-color: #f44336; padding: 10px 24px; border: none;
	                                                   color: white; font-size: 10px; border-radius: 12px;'>KONFIRMASI & BELI ASURANSI</button>
	                                    </a></p>
	                                    <p><a href='".base_url()."konfirmasi/konfirmasi/kf_lb/".$eid."'><button style='background-color: #008CBA; padding: 10px 24px; border: none;
	                                                   color: white; font-size: 10px; border-radius: 12px;'>KONFIRMASI RESI AJA</button>
	                                    </a></p>
	                                   ";
                 }
	                $f="<tr>
											<td colspan='2'><center><b>TOTAL </b></center></td>
											<td colspan=''><center><b> ".$tctns."  </b></center></td>
											<td colspan=''><center><b>".$tqty." pcs</b></center></td>
											<td colspan=''><center><b>".$tberat." kg</b></center></td>
											<td colspan=''><center><b>".round_up($tvolume,3)." m<sup>3</sup></b></center></td>
											<td colspan=''><center><b>".ceil($trmb)." RMB</b></center></td>
											<td style='height: 30px;'></td>
											</tr>
			                </tbody></table>
			                <p>".nama_perusahaan()."</p>

	                            </body>
	                      </html>";

	                $the_message= $h."<br/>".$c1.$c2.$f;
	            }

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
			$test['resi']= $this->Mbarang->data_resi($nomor_resi)->row_array();
			$test['barcode']= $this->Mbarang->data_barcode($id_resi)->result();
			$data = $this->load->view('api/pdf_konfirmasi',$test,True);
			$mpdf = new \Mpdf\Mpdf();

			$mpdf->WriteHTML($data);
			$content = $mpdf->Output('', 'S');
			$emailrifki="gusmavin@gmail.com";
			$this->load->library('email', $config);
			$this->email->attach($content, 'attachment', $nomor_resi , 'application/pdf');
	    $this->email->set_newline("\r\n");
	    $this->email->from(user_email());
	    // $this->email->to($emailrifki);
      $this->email->to($emailrifki,$email_customer);
	    $this->email->subject('[Wilopo Cargo] Barang Masuk : '.$nomor_resi);
	    $this->email->message($the_message);

	    if($this->email->send())
	    {

	    }
	    else
	    {
	      //print_r(show_error($this->email->print_debugger()));
	    }

		if($overbarcode == 1){
			$pesan .= "Customer yth. *".$kodem."*,\nTanggal Resi : ".$tgl_resi."\nBarang Masuk *".$nomor_resi."*".$revisi_data.": \n\n".$result."\n".$teks_khusus."\n".
								"*TOTAL: ".$tctns." ctn, ".$tqty." pcs, ".$tberat." kg, ".$tvolume." m3, ".$trmb." RMB*\n\nKlik tombol dibawah untuk konfirmasi packing list resi, jika tidak maka barang Anda belum kami loading ke container.";
		}else{
			$pesan .= "Customer yth. *".$kodem."*,\nTanggal Resi : ".$tgl_resi."\nBarang Masuk *".$nomor_resi."*".$revisi_data.": \n\n".$result.
								"*TOTAL: ".$tctns." ctn, ".$tqty." pcs, ".$tberat." kg, ".$tvolume." m3, ".$trmb." RMB*\n\nKlik tombol dibawah untuk konfirmasi packing list resi, jika tidak maka barang Anda belum kami loading ke container.";
		}

		 if($asrns_tambahan != 0){
       if($jalurnya == 5){
         $pesan .= "\n\nNilai barang Anda melebihi 20jt/cbm, Anda wajib membayar biaya tambahan tax import & asuransi tambahan sebesar *Rp.". number_format($asrns_tambahan) ."*, dan barang Anda akan kami loading jalur cepat, Klik link dibawah ini jika setuju:\n".base_url()."konfirmasi/konfirmasi/kf_resi/".$eid;
       }else if($jalurnya == 4){
         $pesan .= "\n\nNilai barang Anda melebihi 20jt/cbm, Anda wajib membayar biaya tambahan tax import & asuransi tambahan sebesar *Rp.". number_format($asrns_tambahan) ."*, dan barang Anda akan kami loading jalur cepat, Klik link dibawah ini jika setuju:\n".base_url()."konfirmasi/konfirmasi/kf_resi/".$eid;
         $pesan .="\n\nJika Anda tidak mau membayar asuransi, barang akan kami loading ke Jalur Lambat (4-6 minggu), dan maksimal penggantian jika terjadi kehilangan adalah 20jt/cbm. Klik link dibawah ini jika setuju :\n".base_url()."konfirmasi/konfirmasi/kf_lb/".$eid;
       }else if($jalurnya == 6){
         $pesan .= "\n\nNilai barang Anda melebihi 20jt/cbm, Anda wajib membayar biaya tambahan tax import & asuransi tambahan sebesar *Rp.". number_format($asrns_tambahan) ."*, Klik link dibawah ini jika setuju:\n".base_url()."konfirmasi/konfirmasi/kf_resi/".$eid;
         $pesan .="\n\nKlik link dibawah ini untuk konfirmasi resi :\n".base_url()."konfirmasi/konfirmasi/kf_lb/".$eid;
       }

		 }else{
       $pesan .="\n\nKlik link dibawah ini untuk konfirmasi resi :\n".base_url()."konfirmasi/konfirmasi/kf/".$eid;
     }
		 $pesan .="\n\n*Wilopo Cargo* _(do not reply)_";
     // sendwhatsapp($pesan,'083815423599');
     sendwhatsapp($pesan,'081299053976');
		 sendwhatsapp($pesan,'081293972529');
		 sendwhatsapp($pesan,'081310961108');
		 sendwhatsapp($pesan,'081310085523');
     sendwhatsapp($pesan,'6282122486180');
		 sendwhatsapp($pesan,$whatsapp_customer);
     if($id_pendaftar > 0 || $id_pendaftar != "" || $id_pendaftar != Null){
       $get_sales = $this->db->where('id_pengguna',$id_pendaftar)->get('pengguna')->row();
       sendwhatsapp($pesan,$get_sales->whatsapp);
     }
     if($id_crm > 0 || $id_crm != "" || $id_crm != Null){
       $get_crm = $this->db->where('id_pengguna',$id_crm)->get('pengguna')->row();
       sendwhatsapp($pesan,$get_crm->whatsapp);
     }
     // echo $revisi_data;die();
     $updresi['status_ubah'] = 0;
     $this->db->where('id_resi',$id_resi)->update('resi',$updresi);
	  }

}

function emailresend(){
	$data_resi= $this->Mbarang->dataresiresend();
	foreach($data_resi->result() as $dresis ){
			$id_resi      =$dresis->id_resi;
			$kodem  =$dresis->kode;
			$supp  =$dresis->supplier;
			$supptel  =$dresis->tel;
			$eid  =$dresis->encrypt_resi;
			$email_customer  =$dresis->email;
			$whatsapp_customer  =$dresis->whatsapp;
			$vmail  =$dresis->validasi_email;
			$tgl_resi  =$dresis->tanggal;
			$nomor_resi = $dresis->nomor;

		if($vmail==10000){
				echo"v";
				die();
		}else{
			$result ='';
			$pesan = '';
			$tvolumes = 0;
			$total_asuransi= 0;
      $totalasuransipk=0;
			$nilaibarangrpasu = array();
			$volumeasu        = array();
			$data_barcodes= $this->Mbarang->data_brcd($id_resi);
			foreach($data_barcodes->result() as $dbar ){
          if(in_array($dbar->jenis_barang_id,array(22,28,33,34))){
             $jalurnya = 4 ; //Pilih Asuransi(SMG) atau tidak (PK)
          }else if(in_array($dbar->jenis_barang_id,array(18,19,20,21,37,38))){
            if($dbar->jalurcust == 3){
              $jalurnya = 5 ; //Wajib Asuransi
            }else{
              $jalurnya = 4 ; //Pilih Asuransi(SMG) atau tidak (PK)
            }
          }else{
             $jalurnya = 6;  //PK Asuransi Atau No Asuransi
          }
					$volumes=$dbar->volume * $dbar->ctns;
					$nilais=$dbar->nilai * $dbar->ctns ;
					$ctnss=$dbar->ctns;
			    $berats=$dbar->berat * $dbar->ctns;
					$qtys=$dbar->qty * $dbar->ctns;

				  $rmb1 = $dbar->nilai * $dbar->ctns * $dbar->qty;
				  $rmb2 = $rmb1 * $dbar->kurs;
				  $tvolumes += $dbar->volume;
				  $total_asuransi += $rmb2;
				  $nilaibarangrpasu[] = $dbar->nilai * $dbar->qty * $dbar->ctns * $dbar->kurs;
				  $volumeasu[] = $dbar->volume * $dbar->ctns;
		      $result .= $dbar->nomor.': '.$dbar->barang.' ('.$dbar->namalain.'), '.$dbar->ctns.' ctn, '.$qtys.' pcs, '.$berats.' kg, '.$volumes.' m3, '.$rmb1.' RMB, '.$dbar->remarks."\n";
			}

					 $totalnilaibarangrp = array_sum($nilaibarangrpasu);
					 $totalvolume = array_sum($volumeasu);
					 $totalkompensasi = $totalvolume * 20000000;

					 $selisihasuransi = $totalnilaibarangrp - $totalkompensasi;

					 if($selisihasuransi > 0){
							 $persentase = ($selisihasuransi/$totalvolume)/10000000;
								if($persentase < 1){
										$persentasebaru = 1;
								}else{
										$persentasebaru = floor($persentase);
								}
							 $totalasuransi = $persentasebaru/100 * $selisihasuransi;
               $totalasuransipk = round($totalasuransi/2);
					 }else{
							 $totalasuransi = 0;
					 }
				 $asrns_tambahan = round($totalasuransi);
				 //die($total_asuransi);

				 $c1="<table cellpadding='1' cellspacing='2' border='1'>
					<thead>
					<tr>
							<th colspan='4'><img src='".base_url()."assets/logo2.jpg' style='height:100px;'></th>
							<th colspan='4'>
															<p>DATE : ".$tgl_resi."</p>
															<p>CUSTOMER CODE : ".$kodem."</p>
															<p>SUPPLIER : ".$supp."</p>
															<p>SUPPLIER TEL : ".$supptel."</p>
							</th>
					</tr>

					<tr>
							 <th colspan='8' style='height:28px;'> RECEIPT NO : ".$nomor_resi."</th>
					</tr>

							 <tr>

				<th style='height: 25px;'><font color='black'>BARCODE</font></th>
				<th><font color='black'>GOODS</font></th>
				<th><font color='black'>CTNS</font></th>
				<th><font color='black'>QTY</font></th>
				<th><font color='black'>WEIGHT</font></th>
				<th><font color='black'>VOLUME</font></th>
				<th><font color='black'>RMB</font></th>
				<th><font color='black'>REMARK</font></th>

				</tr>
		 </thead>
		 <tbody>";

		 $this->db->like('id');
		 $this->db->where('resi_id',$id_resi);
		 $this->db->from('giw');
		 $jloop = $this->db->count_all_results();
		 $c2="";


				foreach($data_barcodes->result() as $c){

				   $mrmb = $c->nilai * $c->ctns * $c->qty;
					 $mqty= $c->qty * $c->ctns;
					 $mberat= $c->berat * $c->ctns;
					 $mvolume= $c->volume * $c->ctns;

					 $tctns  +=$c->ctns;
					 $tqty   +=$mqty;
					 $tberat +=$mberat;
					 $tvolume +=$mvolume;
					 $trmb +=$mrmb;
					 $nilaibarangrp += $c->nilai * $c->ctns * $c->qty * $c->kurs;


					 $c2 .= "<tr>
								<td style='height: 25px;'><font color='black'>".$c->nomor."</td>
							<td><font color='black'>".$c->barang."</td>
							<td><font color='black'><font color='black'>".$c->ctns."</td>
							<td><font color='black'>@".$mqty."/".$c->qty." pcs</td>
							<td><font color='black'>@".$c->berat."  kg</td>
							<td><font color='black'>@".$c->volume." m<sup>3</sup></td>
							<td><font color='black'>@".$c->nilai."/".$rmb." RMB</td>
							<td><font color='black'>".$c->remarks."</td>
								 </tr>";

				}

						if($asrns_tambahan == 0){
								 $h="<html>
														<body>
																		<p><h3>Yth. Bpk/Ibu ".$kodem.",</h3><br /> Kami telah menerima barang Anda di Gudang Kami, Berikut adalah detail resi pengiriman Anda.
																		Klik tombol dibawah untuk konfirmasi packing list resi, jika tidak maka barang Anda belum kami loading ke container.</p>
																		<p><a href='".base_url()."konfirmasi/konfirmasi/kf/".$eid."'><button style='background-color: #008CBA; padding: 10px 24px; border: none;
																									 color: white; font-size: 10px; border-radius: 12px;'>Konfirmasi Resi aja</button>
																		</a></p>

																		";


													//</table>";

								$f="<tr>
										<td colspan='2'><center><font color='black'>TOTAL </center></td>
										<td colspan=''><center><font color='black'> ".$tctns."  </center></td>
										<td colspan=''><center><font color='black'>".$tqty." pcs</center></td>
										<td colspan=''><center><font color='black'>".$tberat." kg</center></td>
										<td colspan=''><center><font color='black'>".round_up($tvolume,3)." m<sup>3</sup></center></td>
										<td colspan=''><center><font color='black'>".ceil($trmb)." RMB</center></td>
										<td style='height: 30px;'></td>
										</tr>
										</tbody></table>
										<p>".nama_perusahaan()."</p>

													</body>
										</html>";
								//dipanggilnya disini
							 $the_message= $h."<br/>".$c1.$c2.$f;

						}else if($asrns_tambahan != 0){
							 // echo $total_asuransi;
								 $h="<html>
														<body>
																		<p><h3>Yth. Bpk/Ibu ".$kodem.",</h3><br /> Kami telah menerima barang Anda di Gudang Kami, Berikut adalah detail resi pengiriman Anda.
																		Klik tombol dibawah untuk konfirmasi packing list resi, jika tidak maka barang Anda belum kami loading ke container.</p>
																		<p>Nilai barang yang Anda kirim ada yang melebihi jumlah asuransi yang kami cover per barcode (Rp. 20.000.000 / cbm), Anda dapat membeli asuransi
																		tambahan pada barang kiriman Anda sebesar <span style='color: #ff0000;font-size: 20px;'><strong>Rp.".number_format($asrns_tambahan)."</strong></span>,
																		agar dapat di cover full.</p>

																		<p><a href='".base_url()."konfirmasi/konfirmasi/kf_resi/".$eid."'><button style='background-color: #f44336; padding: 10px 24px; border: none;
																									 color: white; font-size: 10px; border-radius: 12px;'>KONFIRMASI & BELI ASURANSI</button>
																		</a></p>
																		<p><a href='".base_url()."konfirmasi/konfirmasi/kf/".$eid."'><button style='background-color: #008CBA; padding: 10px 24px; border: none;
																									 color: white; font-size: 10px; border-radius: 12px;'>KONFIRMASI RESI AJA</button>
																		</a></p>
																	 ";
								$f="<tr>
										<td colspan='2'><center><b>TOTAL </b></center></td>
										<td colspan=''><center><b> ".$tctns."  </b></center></td>
										<td colspan=''><center><b>".$tqty." pcs</b></center></td>
										<td colspan=''><center><b>".$tberat." kg</b></center></td>
										<td colspan=''><center><b>".round_up($tvolume,3)." m<sup>3</sup></b></center></td>
										<td colspan=''><center><b>".ceil($trmb)." RMB</b></center></td>
										<td style='height: 30px;'></td>
										</tr>
										</tbody></table>
										<p>".nama_perusahaan()."</p>

														</body>
											</html>";

								$the_message= $h."<br/>".$c1.$c2.$f;
						}

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
				$test['resi']= $this->Mbarang->data_resi($nomor_resi)->row_array();
				$test['barcode']= $this->Mbarang->data_barcode($id_resi)->result();
				$data = $this->load->view('api/pdf_konfirmasi',$test,True);
				$mpdf = new \Mpdf\Mpdf();

				$mpdf->WriteHTML($data);
				$content = $mpdf->Output('', 'S');
				$emailrifki="rr318929@gmail.com";
				$this->load->library('email', $config);
				$this->email->attach($content, 'attachment', $nomor_resi , 'application/pdf');
				$this->email->set_newline("\r\n");
				$this->email->from(user_email());
				$this->email->to($emailrifki);
				$this->email->subject('[Wilopo Cargo] Barang Masuk : '.$nomor_resi);
				$this->email->message($the_message);

				if($this->email->send())
				{

				}
				else
				{
					//print_r(show_error($this->email->print_debugger()));
				}

			$pesan .= "Customer yth. *".$kodem."*,\nTanggal Resi : ".$tgl_resi."\nBarang Masuk *".$nomor_resi."* (Revisi Data) : \n\n".$result."*TOTAL: ".$tctns." ctn, ".$tqty." pcs, ".$tberat." kg, ".$tvolume." m3, ".$trmb." RMB*\n\nKlik tombol dibawah untuk konfirmasi packing list resi, jika tidak maka barang Anda belum kami loading ke container.";

			 if($asrns_tambahan != 0){
					 $pesan .= "\n\nAnda dapat membeli asuransi tambahan sebesar *Rp.". number_format($asrns_tambahan) ."*, Klik link dibawah ini untuk membeli asuransi:\n".base_url()."konfirmasi/konfirmasi/kf_resi/".$eid;
			 }

			 $pesan .="\n\nKlik link dibawah ini untuk konfirmasi resi :\n".base_url()."konfirmasi/konfirmasi/kf/".$eid;
			 $pesan .="\n\n*Wilopo Cargo* _(do not reply)_";
			  sendwhatsapp($pesan,'083815423599');
				sendwhatsapp($pesan,'081293972529');
			  sendwhatsapp($pesan,'081310961108');
			  sendwhatsapp($pesan,'081310085523');
			  sendwhatsapp($pesan,$whatsapp_customer);

		}

	}

  // die("oke");

}

function add_to_container(){
    $this->Mbarang->add_to_container($this->input->post());
}

function pindah_container(){
    $this->Mbarang->pindah_container($this->input->post());
}
function container_closing(){
  $id = $this->uri->segment(4);
  $tanggalclosing = $this->input->post('tgl_closing');
  $this->Mbarang->container_closing($id,$tanggalclosing);
}
function container_otw(){
  $id = $this->uri->segment(4);
  $tanggalotw = $this->input->post('tanggal_otw');
  $this->Mbarang->container_otw($id,$tanggalotw);
}
function container_eta(){
  $id = $this->uri->segment(4);
  $tanggaleta = $this->input->post('tgl_eta');
  $this->Mbarang->container_eta($id,$tanggaleta);
}
function container_antri_kapal(){
  $id = $this->uri->segment(4);
  $tanggalantrikapal = $this->input->post('tgl_antri_kapal');
  $this->Mbarang->container_antri_kapal($id,$tanggalantrikapal);
}
function container_atur_kapal(){
  $id = $this->uri->segment(4);
  $tanggalaturkapal = $this->input->post('tgl_atur_kapal');
  $this->Mbarang->container_atur_kapal($id,$tanggalaturkapal);
}
function container_est_dumai(){
  $id = $this->uri->segment(4);
  $tanggalestdumai = $this->input->post('tgl_est_dumai');
  $this->Mbarang->container_est_dumai($id,$tanggalestdumai);
}
function container_pib(){
  $id = $this->uri->segment(4);
  $tanggalpib = $this->input->post('tgl_pib');
  $this->Mbarang->container_pib($id,$tanggalpib);
}
function container_notul(){
  $id = $this->uri->segment(4);
  $tanggalnotul = $this->input->post('tgl_notul');
  $this->Mbarang->container_notul($id,$tanggalnotul);
}
function container_monitoring(){
  sendwhatsapp("Ki ada container monitoring","083815423599");
  $id = $this->input->post('id');
  $tanggal_monitoring = $this->input->post('tanggal_monitoring');
  $this->Mbarang->container_monitoring($id,$tanggal_monitoring);
}

function container_arrived(){
  $id      = $this->uri->segment(4);
  $tgltiba = $this->uri->segment(5);
  $this->Mbarang->container_arrived($id,$tgltiba);
}

function request_packinglist(){
  $nomor_resi  = $this->input->post('nomor_resi');
  $real_code   = $this->encrypt_decrypt('encrypt',$this->input->post('kode'));
  $encrypt_resi  = md5($this->input->post('nomor_resi'));
  $data_customer = $this->db->select('customer.kode,customer.whatsapp,customer.email,customer.id_crm')->from('customer')
                       ->where('customer.kode',$this->input->post('kode'))
                       ->get()->row();
   $cek_fpr = $this->db->where('nomor_resi',$nomor_resi)->get('file_packing_resi')->num_rows();
   if($cek_fpr == 0){
     $ins_file['nomor_resi'] = $nomor_resi ;
     $ins_file['kode_marking'] = $this->input->post('kode') ;
     $ins_file['tanggal_fpr'] = date('Y-m-d') ;
     $this->db->insert('file_packing_resi',$ins_file);
     $last_id_fpr = $this->db->insert_id();
     $enc_id_fpr  = $this->encrypt_decrypt('encrypt',$last_id_fpr);
   }else{
     $get_fpr = $this->db->where('nomor_resi',$nomor_resi)->get('file_packing_resi')->row();
     $enc_id_fpr  = $this->encrypt_decrypt('encrypt',$get_fpr->id_fp_resi);
   }

  // whatsapp Pl and inv
  $pesan ="*".$data_customer->kode."*, \n".$this->input->post('nomor_resi')."\n".$this->input->post('supplier')." (".$this->input->post('tel').")\n".$this->input->post('jumlah_koli').
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

  // message email
  $messageemail = "<html>
                      <body>
                         <p><h3>Yth. Bpk/Ibu ".$data_customer->kode.",</h3><br />
                            <b>".$this->input->post('nomor_resi')."</b> tidak ada packing list dan invoice dari supplier anda
                            ,Silahkan upload invoice dan packing list anda di customer.wilopocargo.com/public_c/upload_pl/".$enc_id_fpr."
                         </p>
                         <p>".nama_perusahaan()."</p>
                      </body>
                    </html>
                     ";
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
  $this->email->set_newline("\r\n");
  $this->email->from(user_email());
  $this->email->to($data_customer->email);
  $this->email->subject('[Wilopo Cargo] Packing list & Invoice: '.$this->input->post('nomor_resi'));
  $this->email->message($messageemail);

  if($this->email->send())
  {

  }
  else
  {
    //print_r(show_error($this->email->print_debugger()));
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

function scan_barcode(){
  // die("oke");
  $this->Mapiinvoice->scan_barcode($this->input-post());
}

function oketes(){
  echo $this->encrypt_decrypt('decrypt','dzRRY2VubHFlZ09rNjB2aU1aa09yUT09');
}
function history_status(){
    $resi_id=$this->input->post('resi_id');
    $container_id=$this->input->post('container_id');
    $date=$this->input->post('date');
    $status_giw_id=$this->input->post('status_giw_id');
    $tipe_resi=$this->input->post('tipe_resi');
    $tipe_delay=$this->input->post('tipe_delay');

    $this->Mbarang->history_status($resi_id, $container_id, $date, $status_giw_id,$tipe_resi, $tipe_delay);

}
function history_status_gudang(){
    $resi_id=$this->input->post('resi_id');
    $container_id=$this->input->post('container_id');
    $date=$this->input->post('date');
    $status_giw_id=$this->input->post('status_giw_id');
    $giw_id=$this->input->post('giw_id');
    $tipe_delay=$this->input->post('tipe_delay');

    $this->Mbarang->history_status_gudang($resi_id, $container_id, $date, $status_giw_id,$giw_id, $tipe_delay);

}
function deadline_status(){
    $resi_id=$this->input->post('resi_id');
    $container_id=$this->input->post('container_id');
    $date=$this->input->post('date');
    $status_giw_id=$this->input->post('status_giw_id');
    $tipe_resi=$this->input->post('tipe_resi');

    $this->Mbarang->deadline_status($resi_id, $container_id, $date, $status_giw_id, $tipe_resi);
}

function benerin_status_giw(){
    $resi_id=$this->input->post('resi_id');
    $container_id=$this->input->post('container_id');
    $date=$this->input->post('date');
    $status_giw_id=$this->input->post('status_giw_id');
    $tipe_resi=$this->input->post('tipe_resi');

    $this->Mbarang->deadline_status($resi_id, $container_id, $date, $status_giw_id, $tipe_resi);
}

}
