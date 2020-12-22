<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Public_c extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
	  $this->load->model('Minvoice');
		$this->load->model('Mbarang');
	  $this->load->model('Minvoice_barang');
		$this->load->model('Minvoice_lainnya');
	  $this->load->model('Mtransaksi');
	  $this->load->model('Mpembayaran');
		$this->load->model('Mresi_udara');
	}

    //View Invoice Titip Transfer
    public function invoice_admin() {
      $id     = $this->uri->segment(4);
			$data_invoice= $this->Minvoice->data_invoice_id($id);
	  	foreach($data_invoice->result() as $inv ){
				$id_cust=$inv->id_cust;
				$id_cgrup=$inv->id_cgrup;
	      $ei    =$inv->encrypt_invoice;
	      $ki=$inv->kode_invoice;
	      $tt=$inv->total_tagihan;
	      $kcustomer=$inv->kode;
	      $ecustomer=$inv->email;
				$kgrup=$inv->kode_cgrup;
	      $egrup=$inv->email_cgrup;
	   	 }

			 if($id_cust==0){
					 $emailaktif= $egrup;
					 $kodeaktif = $kgrup;
				}else if($id_cgrup==""){
					 $emailaktif= $ecustomer;
					 $kodeaktif = $kcustomer;
				}

      $test['status']=0;
			$test['record']= $this->Mpembayaran->data_invoiceid($id)->result();
      $test['rincian']= $this->Mpembayaran->rincian_inv($id)->result();
     	$data = $this->load->view('admin/invoice/pdf_invoice',$test,True);

      $mpdf = new \Mpdf\Mpdf();
			//$data = $this->load->view('hasilPrint', [], TRUE);
			$mpdf->WriteHTML($data);
			$mpdf->Output();

    }

		// View Payment Titip Transfer
    public function payment_admin() {
			$id = $this->uri->segment(4);
			$data_invoice= $this->Minvoice->data_invoice_id($id);
			foreach($data_invoice->result() as $inv ){
				$id_cust=$inv->id_cust;
				$id_cgrup=$inv->id_cgrup;
				$ei=$inv->encrypt_invoice;
				$ki=$inv->kode_invoice;
				$tt=$inv->total_tagihan;
				$kcustomer=$inv->kode;
				$ecustomer=$inv->email;
				$kgrup=$inv->kode_cgrup;
				$egrup=$inv->email_cgrup;
			}

		 if($id_cust==0){
			 $status_invoice="grup";
			 $emailaktif= $egrup;
			 $kodeaktif = $kgrup;
			}else if($id_cgrup==""){
				$status_invoice="customer";
				$emailaktif= $ecustomer;
				$kodeaktif = $kcustomer;
			}

      $test['status']=1;
			if($status_invoice=="customer"){
				$test['record']= $this->Mpembayaran->data_invoiceid($id)->result();
			}else if($status_invoice=="grup"){
				$test['record']= $this->Mpembayaran->grup_invoiceid($id)->result();
			}
			$test['record']= $this->Mpembayaran->data_invoiceid($id)->result();
			// print_r();die()
      $test['rincian']= $this->Mpembayaran->rincian_inv($id)->result();
      $data = $this->load->view('admin/invoice/pdf_invoice',$test,True);
      $mpdf = new \Mpdf\Mpdf();
			//$data = $this->load->view('hasilPrint', [], TRUE);
			$mpdf->WriteHTML($data);
			$mpdf->Output();
    }

    //View Invoice Barang
    public function invoice_barang() {
      $id= $this->uri->segment(4);
      $test['status']=0;
      $test['record']= $this->Minvoice_barang->data_invoice($id)->row();
      $test['barcode']= $this->Minvoice_barang->getinvoice_product($id)->result();
			$test['potongan']=$this->Minvoice_barang->data_potongan($id)->result();
			$test['record_asuransi'] = $this->Minvoice_barang->cek_asuransi($id)->result();
     	$data = $this->load->view('admin/invoice_barang/pdf_invoice_ttd',$test,True);
    	$mpdf = new \Mpdf\Mpdf();
			//$data = $this->load->view('hasilPrint', [], TRUE);
			$mpdf->WriteHTML($data);
			$mpdf->Output();
    }

		// View Payment Barang
    public function payment_barang() {
      $id= $this->uri->segment(4);
      $test['status']=1;
      $test['record']= $this->Minvoice_barang->data_invoice($id)->row();
			$test['potongan']=$this->Minvoice_barang->data_potongan($id)->result();
			$test['record_asuransi'] = $this->Minvoice_barang->cek_asuransi($id)->result();
      $test['barcode']= $this->Minvoice_barang->getinvoice_product($id)->result();
			// dd($test['barcode']);
     	$data = $this->load->view('admin/invoice_barang/pdf_invoice',$test,True);
      $mpdf = new \Mpdf\Mpdf();
			$mpdf->WriteHTML($data);
			$mpdf->Output();
    }

		//View Invoice Lainnya
    public function invoice_lainnya() {
      $id= $this->uri->segment(4);
      $test['status']=0;
			$test['record_asuransi'] = $this->Minvoice_barang->cek_asuransi($invjual_id)->result();
      $test['record']= $this->Minvoice_lainnya->data_invoice($id)->row();
      $test['item']= $this->Minvoice_lainnya->item_inv($id)->result();
     	$data = $this->load->view('admin/invoice_lainnya/pdf_invoice',$test,True);
    	$mpdf = new \Mpdf\Mpdf();
			//$data = $this->load->view('hasilPrint', [], TRUE);
			$mpdf->WriteHTML($data);
			$mpdf->Output();
    }

		// View Payment Lainnya
    public function payment_lainnya() {
      $id= $this->uri->segment(4);
      $test['status']=1;
			$test['record']= $this->Minvoice_lainnya->data_invoice($id)->row();
      $test['item']= $this->Minvoice_lainnya->item_inv($id)->result();//print_r($test['item']);die();
     	$data = $this->load->view('admin/invoice_lainnya/pdf_invoice',$test,True);
      $mpdf = new \Mpdf\Mpdf();
			$mpdf->WriteHTML($data);
			$mpdf->Output();
    }

		//View Invoice Barang
    public function invoice_udara() {
      $id= $this->uri->segment(4);
      $tst['status']=0;
			$tst['r']= $this->Mresi_udara->getresiinvidinv($id)->row();
      $data = $this->load->view('admin/resi_udara/pdf_invoice',$tst,True);
    	$mpdf = new \Mpdf\Mpdf();
			//$data = $this->load->view('hasilPrint', [], TRUE);
			$mpdf->WriteHTML($data);
			$mpdf->Output();
    }

		// View Payment Barang
    public function payment_udara() {
      $id= $this->uri->segment(4);
			$tst['status']=1;
			$tst['r']= $this->Mresi_udara->getresiinvidinv($id)->row();
      $data = $this->load->view('admin/resi_udara/pdf_invoice',$tst,True);
      $mpdf = new \Mpdf\Mpdf();
			$mpdf->WriteHTML($data);
			$mpdf->Output();
    }

		// public function pilih_harga(){
			//die($this->uri->segment(4));
			// $resi_id = $this->uri->segment(4);
			// $status_kf = $this->uri->segment(5);
			//
			// $data_barcodes= $this->Mbarang->data_brcd($resi_id)->result();
			// $selectresi = $this->db->where('id_resi',$resi_id)->get('resi')->row();
			// // var_dump($data_barcodes);die();
			// $wa =0;
			// foreach ($data_barcodes as $g ) {
			// 	 $nilaibarangrp = $g->nilai * $g->qty * $g->ctns * $g->kurs;
			// 	 $volume = $g->volume * $g->ctns;
			// 	 $idgiw = $g->id;
			// 	 $status = $g->status;
			// 	 $jalur = $g->jalur;
			// 	 $jenisbarang = $g->jenis_barang_id;
			// 	 //die($jenisbarang);
			// 	 if($status == 1 && $jalur != 1){
	    //       if(in_array($jenisbarang,array(18,19,20,21,22,28,33,34))){
	    //         if($jenisbarang == 22){
	    //             $hargabaru = 5250000;
	    //         }else if($jenisbarang == 28){
	    //             $hargabaru = 5500000;
	    //         }else if($jenisbarang == 18){
	    //             $hargabaru = 4500000;
	    //         }else if($jenisbarang == 19){
	    //             $hargabaru = 4750000;
	    //         }else if($jenisbarang == 20){
	    //             $hargabaru = 5000000;
	    //         }else if($jenisbarang == 21){
	    //             $hargabaru = 5250000;
	    //         }else if($jenisbarang == 33){
	    //           $hargabaru = 6000000;
	    //         }else if($jenisbarang == 34){
	    //           $hargabaru = 6250000;
	    //         } //die($g->id_resi_rts);
			// 				//update giw
			// 				$updategiw['harga_jual']= $hargabaru;
			// 				$updategiw['jalur']= 1;
			// 				$updategiw['status_jalur']= 1;
			// 				$this->db->where('id', $idgiw);
			//         $this->db->update('giw',$updategiw);
			//
			// 				$curl_handle3=curl_init();
      //         curl_setopt($curl_handle3,CURLOPT_URL,'http://office.rtsekspedisi.com/api/a_resi/pilih_harga/'.$g->id_resi_rts);
      //         curl_setopt($curl_handle3, CURLOPT_POST, 1);
      //         curl_setopt($curl_handle3, CURLOPT_POSTFIELDS);
      //         $curlemail = curl_exec($curl_handle3);
      //         curl_close($curl_handle3);
			// 				$this->session->set_flashdata('msg','okhargalama');
			// 				$wa =1;
			// 				// echo $wa;die();
	    //       }else{
			// 				$wa =0;
			// 				$this->session->set_flashdata('msg','nohargalama');
			// 			}//end if array
	    //     }else{ // else status
			// 			// echo $wa;die();
			// 			$wa =0;
			// 			$this->session->set_flashdata('msg','nohargalama');
	    //     }
			//  }//endforeach
			//  if($wa == 1 && $status_kf="kf"){
			// 	 $pesan = "Anda Memilih Jalur Lambat & Berhasil Konfirmasi ".$selectresi->nomor." \nTerimakasih \n\n*Wilopo Cargo* _(do not reply)_";
			// 	 sendwhatsapp($pesan,'081293972529');
			// 	 sendwhatsapp($pesan,'081310961108');
			//  }
			//  else if($wa == 1 && $status_kf="kf_asuransi"){
			// 	 $pesan = "Anda Memilih Jalur Lambat & Berhasil Konfirmasi + Beli Asuransi ".$selectresi->nomor." \nTerimakasih \n\n*Wilopo Cargo* _(do not reply)_";
			// 	 sendwhatsapp($pesan,'081293972529');
			// 	 sendwhatsapp($pesan,'081310961108');
			//  }
			//  // echo $wa;die();
			//  $this->load->view('success_hargalama');
		// }

		// public function pilih_harga2(){
		// 	$resi_id = $this->uri->segment(4);
		// 	$status_kf = $this->uri->segment(5);
		// 	$selectresi = $this->db->where('id_resi',$resi_id)->get('resi')->row();
		//
		// 	$updategiw['status_jalur']= 1;
		// 	$this->db->where('resi_id', $resi_id);
		// 	$this->db->update('giw',$updategiw);
		//
		// 	if($status_kf="kf"){
		// 		$pesan = "Anda Memilih Jalur Cepat & Berhasil Konfirmasi ".$selectresi->nomor." \nTerimakasih \n\n*Wilopo Cargo* _(do not reply)_";
		// 		sendwhatsapp($pesan,'081293972529');
		// 		sendwhatsapp($pesan,'081310961108');
		// 	}
		// 	else if($status_kf="kf_asuransi"){
		// 		$pesan = "Anda Memilih Jalur Cepat & Berhasil Konfirmasi + Beli Asuransi ".$selectresi->nomor." \nTerimakasih \n\n*Wilopo Cargo* _(do not reply)_";
		// 		sendwhatsapp($pesan,'081293972529');
		// 		sendwhatsapp($pesan,'081310961108');
		// 	}
		//
		// 	$this->session->set_flashdata('msg','okhargalama');
		// 	$this->load->view('success_hargalama');
		// }

 }
