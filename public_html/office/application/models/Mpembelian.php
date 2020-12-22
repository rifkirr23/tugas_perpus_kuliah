<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mpembelian extends CI_Model {

	public function __construct(){
		parent::__construct();
    $this->load->model('Mbank');
	}
	//Proses Get Data pembayaran
	function get_pembelian() {
    $this->datatables->select('pembelian.id_pembelian,pembelian.kode_pembelian,pembelian.id_transaksi,
                               pembelian.tanggal_pembelian,pembelian.status_pembelian,transaksi.id_transaksi,transaksi.kode_transaksi,
															 transaksi.jumlah_rmb,transaksi.kurs_beli,transaksi.status,sum((transaksi.jumlah_rmb*transaksi.kurs_beli)+100000) as total_pembelian');
    $this->datatables->from('pembelian');
		$this->db->group_by('pembelian.id_pembelian');
    $this->db->order_by('pembelian.id_pembelian','desc');
		$this->datatables->where('pembelian.status_pembelian !=',3);
    $this->datatables->join('transaksi', 'pembelian.id_transaksi=transaksi.id_transaksi');
		$this->datatables->add_column('actionpaid', '$1','actionpaid(status,id_pembelian,status_pembelian,kode_pembelian,id_transaksi)');
		$this->datatables->add_column('kurs_beli_pembelian', '$1','kurs_beli_pembelian(kurs_beli,jumlah_rmb,tanggal_pembelian)');
		$this->datatables->add_column('keterangan_pembelian', '$1','keterangan_pembelian(kurs_beli,jumlah_rmb,tanggal_pembelian)');
    return $this->datatables->generate();
  }

	function data_transaksi($id){

    $this->db->select('transaksi.id_transaksi,transaksi.kode_transaksi,transaksi.id_cust,transaksi.id_cgrup,transaksi.tanggal_transaksi,transaksi.jumlah_rmb,
											 transaksi.kurs_jual,transaksi.kurs_beli,transaksi.bank_tujuan ,transaksi.file_bank_tujuan,transaksi.status,
											 transaksi.input_name,transaksi.fee_bank,transaksi.fee_cs,transaksi.id_invoice,customer.kode,customer.email,customer.whatsapp,
											 customer_grup.kode_cgrup,customer_grup.email_cgrup,customer_grup.whatsapp_cgrup');
    $this->db->from('transaksi');
    $this->db->join('customer', 'transaksi.id_cust=customer.id_cust', 'left');
		$this->db->join('customer_grup', 'transaksi.id_cgrup=customer_grup.id_cgrup', 'left');
    $this->db->where('transaksi.id_transaksi',$id);

    return $query = $this->db->get();
  }

	public function get_image_rmb($id){
    $this->db->where('id_transaksi',$id);

    return $this->db->get('bukti_bayar_rmb');
  }

	function total_semua_pembelian(){
		$cekdata = $this->db->select('transaksi.*,pembelian.*')->from('transaksi')
												->join('pembelian', 'transaksi.id_pembelian=pembelian.id_pembelian', 'left')
												->where('transaksi.jumlah_rmb >=', 10000)->where('pembelian.status_pembelian',1)->where('(status=2 OR status=4)', null ,FALSE)
												->where('transaksi.kurs_beli !=',0)->get()->num_rows();
		$total_fee = $cekdata * 0;
		 // print_r($cekdata);die();
		$sumdata = $this->db->select('sum(jumlah_rmb*kurs_beli) as total')->from('transaksi')
												->join('pembelian', 'transaksi.id_pembelian=pembelian.id_pembelian', 'left')
												->where('(status=2 OR status=4)', null ,FALSE)->where('jumlah_rmb >=', 10000)->where('pembelian.status_pembelian',1)->get()->row();
		if($cekdata > 0){
			return $sumdata->total+$total_fee;
		}else{
			return 0;
		}
	}

	function total_semua_pembelian_today(){
		$cekdata = $this->db->select('transaksi.*,pembelian.*')->from('transaksi')
												->join('pembelian', 'transaksi.id_pembelian=pembelian.id_pembelian', 'left')
												->where('transaksi.jumlah_rmb >=', 10000)->where('pembelian.status_pembelian',1)->where('(status=2 OR status=4)', null ,FALSE)
												->where('pembelian.tanggal_pembelian',date('Y-m-d'))
												->where('transaksi.kurs_beli !=',0)->get()->num_rows();
		$total_fee = $cekdata * 0;
		 // print_r($cekdata);die();
		$sumdata = $this->db->select('sum(jumlah_rmb*kurs_beli) as total')->from('transaksi')
												->join('pembelian', 'transaksi.id_pembelian=pembelian.id_pembelian', 'left')
												->where('pembelian.tanggal_pembelian',date('Y-m-d'))
												->where('(status=2 OR status=4)', null ,FALSE)->where('jumlah_rmb >=', 10000)->where('pembelian.status_pembelian',1)->get()->row();
		if($cekdata > 0){
			return $sumdata->total+$total_fee;
		}else{
			return 0;
		}
	}

	function total_semua_pembelian_filter($min,$max){
		$cekdata = $this->db->select('transaksi.*,pembelian.*')->from('transaksi')
												->join('pembelian', 'transaksi.id_pembelian=pembelian.id_pembelian', 'left')
												->where('transaksi.jumlah_rmb >=', 10000)->where('pembelian.status_pembelian',1)->where('(status=2 OR status=4)', null ,FALSE)
												->where('pembelian.tanggal_pembelian >=',$min)
												->where('pembelian.tanggal_pembelian <=',$max)
												->where('transaksi.kurs_beli !=',0)->get()->num_rows();
		$total_fee = $cekdata * 0;
		 // print_r($cekdata);die();
		$sumdata = $this->db->select('sum(jumlah_rmb*kurs_beli) as total')->from('transaksi')
												->join('pembelian', 'transaksi.id_pembelian=pembelian.id_pembelian', 'left')
												->where('(status=2 OR status=4)', null ,FALSE)->where('jumlah_rmb >=', 10000)->where('pembelian.status_pembelian',1)->get()->row();
		if($cekdata > 0){
			return $sumdata->total+$total_fee;
		}else{
			return 0;
		}
	}

	function transaksi_pending(){
		$cek_kurs = $this->db->get('kurs')->row();
		$cekdata = $this->db->select('transaksi.*')->from('transaksi')
												->where('transaksi.jumlah_rmb >=', 10000)->where('(status=1)', null ,FALSE)
												->get()->num_rows();
		$total_fee = $cekdata * 0;
		 // print_r($cekdata);die();
		$sumdata = $this->db->select('sum(jumlah_rmb*'.$cek_kurs->kurs_beli.') as total')->from('transaksi')
												->where('(status=1)', null ,FALSE)->where('jumlah_rmb >=', 10000)->get()->row();
		if($cekdata > 0){
			return $sumdata->total+$total_fee;
		}else{
			return 0;
		}
	}

	function transaksi_pending_today(){
		$cek_kurs = $this->db->get('kurs')->row();
		$cekdata = $this->db->select('transaksi.*')->from('transaksi')
												->where('transaksi.jumlah_rmb >=', 10000)->where('status','1')
												->where('transaksi.tanggal_transaksi >=',date('Y-m-d '.'00:'.'00:'.'00'))
												->get()->num_rows();
		$total_fee = $cekdata * 0;
		 // print_r($cekdata);die();
		$sumdata = $this->db->select('sum(jumlah_rmb*'.$cek_kurs->kurs_beli.') as total')->from('transaksi')
												->where('transaksi.tanggal_transaksi >=',date('Y-m-d '.'00:'.'00:'.'00'))
												->where('(status=1)', null ,FALSE)->where('jumlah_rmb >=', 10000)->get()->row();
		if($cekdata > 0){
			return $sumdata->total+$total_fee;
		}else{
			return 0;
		}
	}

	function transaksi_pending_filter($min,$max){
		$cek_kurs = $this->db->get('kurs')->row();
		$cekdata = $this->db->select('transaksi.*')->from('transaksi')
												->where('transaksi.jumlah_rmb >=', 10000)->where('status','1')
												->where('transaksi.tanggal_transaksi >=',$min)
												->where('transaksi.tanggal_transaksi <=',$max)
												->get()->num_rows();
		$total_fee = $cekdata * 0;
		 // print_r($cekdata);die();
		$sumdata = $this->db->select('sum(jumlah_rmb*'.$cek_kurs->kurs_beli.') as total')->from('transaksi')
												->where('transaksi.tanggal_transaksi >=',$min)
												->where('transaksi.tanggal_transaksi <=',$max)
												->where('(status=1)', null ,FALSE)->where('jumlah_rmb >=', 10000)->get()->row();
		if($cekdata > 0){
			return $sumdata->total+$total_fee;
		}else{
			return 0;
		}
	}

  function paid_pembelian($data)
  {
		$gettransaksi = $this->data_transaksi($this->input->post('id_transaksi'))->result();
		foreach($gettransaksi as $row_transaksi){
			$id_cust = $row_transaksi->id_cust;
			$id_cgrup= $row_transaksi->id_cgrup;
			$kode_cust= $row_transaksi->kode;
			$kode_cgrup= $row_transaksi->kode_cgrup;
			$email_cust= $row_transaksi->email;
			$emailcgrup= $row_transaksi->email_cgrup;
			$whatsapp_cust= $row_transaksi->whatsapp;
			$whatsapp_grup= $row_transaksi->whatsapp_cgrup;
			$kode_transaksi= $row_transaksi->kode_transaksi;
			$nama_customer= $row_transaksi->nama;
			$nama_customergrup=$row_transaksi->nama_cgrup;
		}
		if($id_cust!=0){
			$kodeaktif = $kode_cust;
			$emailaktif= $email_cust;
			$whatsappaktif= $whatsapp_cust;
			$namaaktif = $nama_customer;
		}else if($id_cust!=0){
			$kodeaktif = $kode_cgrup;
			$emailaktif= $emailcgrup;
			$whatsappaktif= $whatsapp_grup;
			$namaaktif = $nama_customergrup;
		}
			foreach ($_FILES['file_bb_rmb']['name'] as $key => $image) {
		      // print_r($image."<br>");
		    if($_FILES['file_bb_rmb']['name'][$key] == "")
		    {

		    }else{
		      move_uploaded_file($_FILES["file_bb_rmb"]["tmp_name"][$key], './assets/bukti_bayar_rmb/'.$_FILES["file_bb_rmb"]["name"][$key]);

		      $file_bb_rmb=$_FILES["file_bb_rmb"]["name"][$key];

		      $bb_rmb['id_transaksi'] = $this->input->post('id_transaksi');
		      $bb_rmb['file_bb_rmb'] = $file_bb_rmb;

		      $this->db->insert('bukti_bayar_rmb', $bb_rmb);
		      //$this->Mtransaksi->save_bb_cust($file_bb_cust);
		    }
			}

				$transaksi['status'] = 3;
	      $this->db->where('id_transaksi', $this->input->post('id_transaksi'));
	      $this->db->update('transaksi',$transaksi);

		    $data_rmb= $this->get_image_rmb($this->input->post('id_transaksi'));
				// Send whatsapp
				$pesan = "*Yth. Bpk/Ibu ".$namaaktif." (".$kodeaktif.")*\n\nTransaksi ".$kode_transaksi." telah selesai.".
								 "\nTerlampir bukti transfer RMB ke rekening yang Anda tuju\nTerima kasih atas kerja samanya :)".
								 "\n\n*Wilopo Cargo* _(do not reply)_";

				sendwhatsapp($pesan,$whatsappaktif);
				sendwhatsapp($pesan,"081310961108");
				foreach($data_rmb->result() as $row_file ){
					$frmb=$row_file->file_bb_rmb;
					$atch=base_url().'assets/bukti_bayar_rmb/'.$frmb;
					$sendimg1 = sendimage('complete',$whatsappaktif,$atch);
					$sendimg2 = sendimage('complete','081310961108',$atch);
				}

				//send email
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

	   $the_message="<html>
	                        <body>
	                                <h3>Yth. Bpk/Ibu ".$namaaktif." (".$kodeaktif.") ,</h3>
	                                <p>Transaksi ".$kode_transaksi." telah selesai</p>
	                                <p>Berikut terlampir bukti transfer RMB ke rekening yang Anda tuju</p>
	                                <p>".nama_perusahaan()."</p>

	                        </body>
	                  </html>";
	    $this->load->library('email', $config);

	        foreach($data_rmb->result() as $dr ){
	            $frmb=$dr->file_bb_rmb;
					    $atch=base_url().'assets/bukti_bayar_rmb/'.$frmb;
					    $this->email->attach($atch);
					 }

	    $this->email->set_newline("\r\n");
	    $this->email->from(user_email());
	    $this->email->to("gusmavin@gmail.com"); //email tujuan. Isikan dengan emailmu!
	    $this->email->subject('[Wilopo Cargo] Transaksi '.$kode_transaksi.' telah selesai');
	    $this->email->message($the_message);
	    if($this->email->send())
	    {
				if($sendimg1 && $sendimg2){

				}
	    }
	    else
	    {
	      //show_error($this->email->print_debugger());
	    }

        $this->session->set_flashdata('msg','updated');
        redirect(site_url('admin/pembelian'));

  }

	function lunasi_pembelian(){
		$data_bank= $this->Mbank->get_dbank($this->input->post('id_bank'));
			foreach($data_bank->result() as $dbank ){
			 $sbank    =$dbank->saldo_bank;
			}

			$trb['id_jenis_transaksi_bank'] = 2;
      $trb['id_bank'] = $this->input->post('id_bank');
      $trb['tipe_transaksi_bank'] = "keluar";
      $trb['nominal_transaksi_bank'] = $this->total_semua_pembelian();

      $trb['keterangan_transaksi_bank'] = "Pengurangan Saldo Untuk Pembayaran ".$this->input->post('kode_pembelian');
      $trb['tanggal_transaksi_bank'] = date('Y-m-d');
      $trb['sisa_saldo_bank'] = $sbank - $this->total_semua_pembelian();
      $this->db->insert('transaksi_bank', $trb);

      $bank['saldo_bank'] = $trb['sisa_saldo_bank'];
      $bank['edit_saldo'] = 1;

      $this->db->where('id_bank',$this->input->post('id_bank'));
      $this->db->update('master_bank', $bank);

			$pembelian['status_pembelian'] = 2;
      $this->db->where('status_pembelian', 1);
      $this->db->update('pembelian',$pembelian);

			redirect(site_url('admin/pembelian'));
	}

	function lunasi_satu(){
		$data_bank= $this->Mbank->get_dbank("1");
			foreach($data_bank->result() as $dbank ){
			 $sbank    =$dbank->saldo_bank;
			}
			$idtrs = $this->input->post('id_transaksi');
			$getjumlah = $this->db->where('id_transaksi',$idtrs)->get('transaksi')->row();
			// print_r($getjumlah);die();

			$trb['id_jenis_transaksi_bank'] = 2;
      $trb['id_bank'] = 1;
      $trb['tipe_transaksi_bank'] = "keluar";
      $trb['nominal_transaksi_bank'] = ($getjumlah->jumlah_rmb * $getjumlah->kurs_beli);

      $trb['keterangan_transaksi_bank'] = "Pengurangan Saldo Untuk Pembayaran ".$this->input->post('kode_pembelian');
      $trb['tanggal_transaksi_bank'] = date('Y-m-d');
      $trb['sisa_saldo_bank'] = $sbank - $trb['nominal_transaksi_bank'];
      $this->db->insert('transaksi_bank', $trb);

      $bank['saldo_bank'] = $trb['sisa_saldo_bank'];
      $bank['edit_saldo'] = 1;

      $this->db->where('id_bank',1);
      $this->db->update('master_bank', $bank);

			$pembelian['status_pembelian'] = 2;
      $this->db->where('id_transaksi',$idtrs);
      $this->db->update('pembelian',$pembelian);

			redirect(site_url('admin/pembelian'));
	}

	function update_kurs_beli($data)
  {
			$kursbeli = $this->input->post('kurs_beli');
			$sql = "UPDATE transaksi AS ud JOIN pembelian AS u ON ud.id_pembelian = u.id_pembelian SET ud.kurs_beli = $kursbeli
			 				WHERE ud.jumlah_rmb >= 10000 and ud.status = 2 and u.status_pembelian = 1";
			$this->db->query($sql);
      $this->session->set_flashdata('msg','okkurs');
      redirect(site_url('admin/pembelian'));

  }


}
