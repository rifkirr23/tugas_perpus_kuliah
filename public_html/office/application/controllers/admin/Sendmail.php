<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sendmail extends CI_Controller {

	public function __construct(){
		parent::__construct();
		  cek_session();
		  $this->load->model('Minvoice');
		  $this->load->model('Minvoice_barang');
			$this->load->model('Minvoice_lainnya');
		  $this->load->model('Mtransaksi');
      $this->load->model('Mpembayaran');
			$this->load->model('Mresi_udara');
	}

	public function mail_invoice() {

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

	    $id_invoice = $this->uri->segment(4);

	   	$data_invoice= $this->Minvoice->data_invoice_id($id_invoice);
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
				$nama =$inv->nama;
				$namagrup=$inv->nama_cgrup;
				$whatsapp=$inv->whatsapp;
	 		  $whatsapp_grup=$inv->whatsapp_cgrup;
	 		}

			$namaaktif = $nama;
			$kodeaktif = $kcustomer;

	 		 if($id_cgrup > 0){
	 				$status_invoice="grup";
	 				$emailaktif= $egrup;
	 				$whatsappaktif= $whatsapp_grup;
	 		 }else if($id_cgrup <=0 ){
	 				$status_invoice="customer";
	 				$emailaktif= $ecustomer;
	 				$whatsappaktif= $whatsapp;
	 		 }

	      $test['status']=0;
				if($status_invoice=="customer"){
					$test['record']= $this->Mpembayaran->data_invoiceid($id_invoice)->result();
				}else if($status_invoice=="grup"){
					$test['record']= $this->Mpembayaran->grup_invoiceid($id_invoice)->result();
				}
	      $test['rincian']= $this->Mpembayaran->rincian_inv($id_invoice)->result();
	      $data = $this->load->view('admin/invoice/pdf_invoice',$test,True);
	      $mpdf = new \Mpdf\Mpdf();
				//$data = $this->load->view('hasilPrint', [], TRUE);
	      $mpdf->WriteHTML($data);
				$mpdf->Output("pdf_file/".time()."inv.pdf" ,'F');
				$time=time()."inv.pdf";

				$pesan = "*Yth. Bpk/Ibu ".$namaaktif." (".$kodeaktif.")*\n\nBerikut kami lampirkan invoice titip transfer ".$ki." yang harus Anda bayar, yaitu sebesar *Rp.".number_format($tt).
								"* ke rekening berikut:\n\n*BCA 5810557747 a/n Gusmavin Willopo*\n\nSetelah melakukan pembayaran, harap melakukan konfirmasi pembayaran dengan menghubungi kami melalui telepon / WA.\nTerima kasih atas kerja samanya :)".
								"\n\n*Wilopo Cargo* _(do not reply)_";

				sendwhatsapp($pesan,$whatsappaktif);
				$sendoc = send_newdoc($time,$whatsappaktif,$ki);

				$content = $mpdf->Output('', 'S');
	      $this->load->library('email', $config);
	      $this->email->attach($content, 'attachment', $ki , 'application/pdf');

	       $the_message="<html>
	                            <body>
	                                    <h3>Yth. Bpk/Ibu ".$namaaktif." (".$kodeaktif.") ,</h3>
	                                    <p>Berikut terlampir invoice yang harus Anda bayar, yaitu sebesar Rp.".number_format($tt).". ke rekening berikut:</p>
	                                		<p><b>BCA 5810557747 a/n Gusmavin Willopo</b></p>
																			<br />Setelah melakukan pembayaran, harap melakukan konfirmasi pembayaran dengan menghubungi kami melalui telepon / WA.</p>
	                                    <p>".nama_perusahaan()."</p>

	                            </body>
	                      </html>";

	    $this->email->set_newline("\r\n");
	    $this->email->from(user_email());
	    $this->email->to($emailaktif); //email tujuan. Isikan dengan emailmu!
	    $this->email->subject('[Wilopo Cargo] Invoice Titip Transfer '.$ki);
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

	    $this->session->set_flashdata('msg','success');
		  redirect(site_url('admin/invoice'));

    }

    public function mail_payment() {

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

      		$id_invoice = $this->uri->segment(4);

         	$data_invoice= $this->Minvoice->data_invoice_id($id_invoice);
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
						$nama =$inv->nama;
						$namagrup=$inv->nama_cgrup;
						$whatsapp=$inv->whatsapp;
						$whatsapp_grup=$inv->whatsapp_cgrup;
         	 }

					 $namaaktif = $nama;
		 			 $kodeaktif = $kcustomer;

		 	 		 if($id_cgrup > 0){
		 	 				$status_invoice="grup";
		 	 				$emailaktif= $egrup;
		 	 				$whatsappaktif= $whatsapp_grup;
		 	 		 }else if($id_cgrup <=0 ){
		 	 				$status_invoice="customer";
		 	 				$emailaktif= $ecustomer;
		 	 				$whatsappaktif= $whatsapp;
		 	 		 }

            $test['status']=1;
						if($status_invoice=="customer"){
							$test['record']= $this->Mpembayaran->data_invoiceid($id_invoice)->result();
						}else if($status_invoice=="grup"){
							$test['record']= $this->Mpembayaran->grup_invoiceid($id_invoice)->result();
						}
            $test['rincian']= $this->Mpembayaran->rincian_inv($id_invoice)->result();
            $data = $this->load->view('admin/invoice/pdf_invoice',$test,True);

            $mpdf = new \Mpdf\Mpdf();
      			//$data = $this->load->view('hasilPrint', [], TRUE);
			      $mpdf->WriteHTML($data);
						$mpdf->Output("pdf_file/".time()."inv.pdf" ,'F');
						$time=time()."inv.pdf";

						$pesan = "*Yth. Bpk/Ibu ".$namaaktif." (".$kodeaktif.")*\n\nTerima kasih telah melakukan pembayaran \nBerikut kami lampirkan Invoice Terbayar ".$ki.
										"\nTransaksi Anda sedang kami proses, harap tunggu info selanjutnya dari kami.\nTerima kasih atas kerja samanya :)".
										"\n\n*Wilopo Cargo* _(do not reply)_";

						sendwhatsapp($pesan,$whatsappaktif);
						$sendoc = send_newdoc($time,$whatsappaktif,$ki);

			      $content = $mpdf->Output('', 'S');
			      $this->load->library('email', $config);
			      $this->email->attach($content, 'attachment', $ki , 'application/pdf');
			     //$path_unlink = './'.'Payment_TT_Wilopo.pdf';
			     //unlink($path_unlink );
		       	$the_message="<html>
		                            <body>
		                                    <h3>Yth. Bpk/Ibu ".$namaaktif." (".$kodeaktif.") ,</h3>
		                                    <p>Terima kasih telah melakukan pembayaran untuk ".$ki."
																				<br />Transaksi Anda sedang kami proses, harap tunggu email selanjutnya dari kami</p>
		                                    ".nama_perusahaan()."

		                            </body>
		                      </html>";
    //$this->load->library('email', $config);
    $this->email->set_newline("\r\n");
    $this->email->from(user_email());
    $this->email->to($emailaktif); //email tujuan. Isikan dengan emailmu!
    $this->email->subject('[Wilopo Cargo] Pembayaran '.$ki.' telah kami terima');
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

            $this->session->set_flashdata('msg','success');
            redirect(site_url('admin/invoice'));
    }

    public function mail_complete() {

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

        	$id_invoice = $this->uri->segment(4);

         	$data_invoice= $this->Minvoice->data_transaksi_id($id_invoice);
        	foreach($data_invoice->result() as $inv ){

						$id_cust=$inv->id_cust;
						$id_cgrup=$inv->id_cgrup;
            $it=$inv->id_transaksi;
            $kt=$inv->kode_transaksi;
						$kcustomer=$inv->kode;
			      $ecustomer=$inv->email;
						$kgrup=$inv->kode_cgrup;
			      $egrup=$inv->email_cgrup;
						$whatsapp = $inv->whatsapp;
						$whatsappgrup = $inv->whatsapp_cgrup;
						$namaaktif = $inv->nama;
						$kodeaktif = $inv->kode;

						$namaaktif = $nama;
						$kodeaktif = $kcustomer;

				 		 if($id_cgrup > 0){
				 				$status_invoice="grup";
				 				$emailaktif= $egrup;
				 				$whatsappaktif= $whatsapp_grup;
				 		 }else if($id_cgrup <=0 ){
				 				$status_invoice="customer";
				 				$emailaktif= $ecustomer;
				 				$whatsappaktif= $whatsapp;
				 		 }


						$pesan = "*Yth. Bpk/Ibu ".$namaaktif." (".$kodeaktif.")*\n\nTransaksi ".$kt." telah selesai.".
										 "\nTerlampir bukti transfer RMB ke rekening yang Anda tuju\nTerima kasih atas kerja samanya :)".
										 "\n\n*Wilopo Cargo* _(do not reply)_";
						sendwhatsapp($pesan,$whatsappaktif);
						// sendwhatsapp($pesan,"081310961108");

		       $the_message="<html>
		                            <body>
		                                    <h3>Yth. Bpk/Ibu ".$namaaktif." (".$kodeaktif.") ,</h3>
		                                    <p>Transaksi ".$kt." telah selesai
																				<br />Berikut terlampir bukti transfer RMB ke rekening yang Anda tuju</p>
		                                    <p>".nama_perusahaan()."</p>

		                            </body>
		                      </html>";

				    $this->load->library('email', $config);
				    $data_rmb= $this->Mtransaksi->get_image_rmb($it);

				        foreach($data_rmb->result() as $dr ){
				            $frmb=$dr->file_bb_rmb;
								    $atch=base_url().'assets/bukti_bayar_rmb/'.$frmb;
								    $this->email->attach($atch);
										$sendimg1 = sendimage('complete',$whatsappaktif,$atch);
										// $sendimg2 = sendimage('complete','081310961108',$atch);
						    }

				    $this->email->set_newline("\r\n");
				    $this->email->from(user_email());
				    $this->email->to($emailaktif); //email tujuan. Isikan dengan emailmu!
				    $this->email->subject('[Wilopo Cargo] Transaksi '.$kt.' telah selesai');
				    $this->email->message($the_message);
				    if($this->email->send())
				    {

				    }
				    else
				    {
				      //show_error($this->email->print_debugger());
				    }

  			}
        $this->session->set_flashdata('msg','success');
	      redirect(site_url('admin/invoice'));

    }

    public function mail_invoice_barang() {
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
      $id_invoice = $this->uri->segment(4);

     	$data_invoice= $this->Minvoice_barang->data_invoice_id($id_invoice);
    	foreach($data_invoice->result() as $inv ){
        $ei=$inv->encrypt_invoice;
        $ki=$inv->kode_invoice;
        $tt=$inv->total_tagihan - ($inv->jumlah_bayar + $inv->total_potongan);
				// $jmlbayar=$inv->jumlah_bayar;
        $km=$inv->kode;
        $email=$inv->email;
				$nama=$inv->nama;
				$whatsapp=$inv->whatsapp;
				$whatsapp_grup = $inv->whatsapp_cgrup;
				$egrup = $inv->email_cgrup;
				$id_cgrup = $inv->id_cgrup;
     	}

			$namaaktif = $nama;
			$kodeaktif = $kcustomer;

	 		 if($id_cgrup > 0){
	 				$status_invoice="grup";
	 				$emailaktif= $egrup;
	 				$whatsappaktif= $whatsapp_grup;
	 		 }else if($id_cgrup <=0 ){
	 				$status_invoice="customer";
	 				$emailaktif= $email;
	 				$whatsappaktif= $whatsapp;
	 		 }

        $test['status']=0;
				$test['record_asuransi'] = $this->Minvoice_barang->cek_asuransi($id_invoice)->result();
        $test['record']= $this->Minvoice_barang->data_invoice($id_invoice)->row();
        $test['barcode']= $this->Minvoice_barang->getinvoice_product($id_invoice)->result();
				$test['potongan']=$this->Minvoice_barang->data_potongan($id_invoice)->result();
       	$data = $this->load->view('admin/invoice_barang/pdf_invoice',$test,True);

        $mpdf = new \Mpdf\Mpdf();
				$mpdf->WriteHTML($data);
				$mpdf->Output("pdf_file/".time()."inv.pdf" ,'F');
				$time=time()."inv.pdf";
        $content = $mpdf->Output('', 'S');

				$pesan = "*Yth. Bpk/Ibu ".$nama." (".$km.")*\n\nBarang Anda akan segera sampai di gudang Jakarta kami.. ".
		               "Berikut kami lampirkan detail barang dan invoice barang ".$ki." yang harus Anda bayar, yaitu sebesar *Rp. ".number_format($tt).
		               "* ke rekening berikut:\n\n*BCA 5810557747 a/n Gusmavin Willopo*\n\nHarap segera lakukan pembayaran agar barang dapat segera masuk dalam antrian pengiriman barang.".
		               " Setelah melakukan pembayaran harap konfirmasi pembayaran Anda dengan menghubungi CS kami melalui telepon / WA.".
		               "\nTerima kasih atas kerjasamanya :)".
		               "\n\n*Wilopo Cargo* _(do not reply)_";

				sendwhatsapp($pesan,$whatsappaktif);
		 		$sendoc = send_newdoc($time,$whatsappaktif,$ki);

				sendwhatsapp($pesan,"081310961108");
		 		$sendoc = send_newdoc($time,"081310961108",$ki);

        $this->load->library('email', $config);
        $this->email->attach($content, 'attachment', $ki , 'application/pdf');

				$the_message="<html>
		                        <body>
		                                <h3>Yth. Bpk/Ibu ".$nama." (".$km.") ,</h3>
		                                <p>Barang Anda akan segera sampai di gudang Jakarta kami. Berikut kami lampirkan detail barang dan invoice barang ".$ki."
		                                    yang harus Anda bayar, yaitu sebesar Rp.".number_format($tt)." ke rekening berikut:</p>
		                                <p><b>BCA 5810557747 a/n Gusmavin Willopo</b></p>
		                                <p>Harap segera lakukan pembayaran agar barang dapat segera masuk dalam antrian pengiriman barang..
																			 <br />Setelah melakukan pembayaran harap konfirmasi pembayaran Anda dengan menghubungi CS kami melalui telepon / WA.</p>
		                                <p>".nama_perusahaan()."</p>

		                        </body>
		                  </html>";

		    $this->email->set_newline("\r\n");
		    $this->email->from(user_email());
		    $this->email->to($emailaktif,"gusmavin@gmail.com"); //email tujuan. Isikan dengan emailmu!
		    $this->email->subject('[Wilopo Cargo] Invoice Barang '.$ki);
		    $this->email->message($the_message);

		    if($this->email->send())
		    {
					if($sendoc){
		 			 $path_unlink = './'.$time;
		 			 unlink($path_unlink );
					 // update tanggal kirim
					 $h=date('H')+7;
					 $inv['tanggal_kirim'] = date('Y-m-d '.$h.'-i-s');
					 $this->db->where('id_invoice',$id_invoice)->update('invoice',$inv);
		 		  }
		    }
		    else
		    {
		      //show_error($this->email->print_debugger());
		    }

		    $this->session->set_flashdata('msg','success');
			  redirect(site_url('admin/invoice_barang'));
    }

    public function mail_payment_barang() {

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
			$id_invoice = $this->uri->segment(4);

			$data_invoice= $this->Minvoice_barang->data_invoice_id($id_invoice);
			foreach($data_invoice->result() as $inv ){
				$ei=$inv->encrypt_invoice;
				$ki=$inv->kode_invoice;
				$tt=$inv->total_tagihan - ($inv->jumlah_bayar + $inv->total_potongan);
				$km=$inv->kode;
				$nama=$inv->nama;
				$email=$inv->email;
				$whatsapp=$inv->whatsapp;
				$whatsapp_grup = $inv->whatsapp_cgrup;
				$egrup = $inv->email_cgrup;
				$id_cgrup = $inv->id_cgrup;
     	}

			$namaaktif = $nama;
			$kodeaktif = $kcustomer;

	 		 if($id_cgrup > 0){
	 				$status_invoice="grup";
	 				$emailaktif= $egrup;
	 				$whatsappaktif= $whatsapp_grup;
	 		 }else if($id_cgrup <=0 ){
	 				$status_invoice="customer";
	 				$emailaktif= $email;
	 				$whatsappaktif= $whatsapp;
	 		 }

				$test['status']=1;
				$test['record_asuransi'] = $this->Minvoice_barang->cek_asuransi($id_invoice)->result();
				$test['record'] = $this->Minvoice_barang->data_invoice($id_invoice)->row();
				$test['barcode']= $this->Minvoice_barang->getinvoice_product($id_invoice)->result();
				$test['potongan']=$this->Minvoice_barang->data_potongan($id_invoice)->result();
				$data = $this->load->view('admin/invoice_barang/pdf_invoice',$test,True);

				// print_r($test['record']);die();

				$mpdf = new \Mpdf\Mpdf();
				$mpdf->WriteHTML($data);
				$mpdf->Output("pdf_file/".time()."pay.pdf" ,'F');
				$time=time()."pay.pdf";
				$content = $mpdf->Output('', 'S');

				$pesan = "*Yth. Bpk/Ibu ".$nama." (".$km.")*\n\nTerima kasih telah melakukan pembayaran \nBerikut kami lampirkan Invoice Terbayar ".$ki.
								"\nBarang anda akan segera kami kirim ke alamat anda (Estimasi 1-5 hari).\nTerima kasih atas kerja samanya :)".
								"\n\n*Wilopo Cargo* _(do not reply)_";

				sendwhatsapp($pesan,$whatsapp);
		 		$sendoc = send_newdoc($time,$whatsapp,$ki);

				sendwhatsapp($pesan,"081310961108");
		 		$sendoc = send_newdoc($time,"081310961108",$ki);

				$this->load->library('email', $config);
				$this->email->attach($content, 'attachment', $ki , 'application/pdf');

				$the_message="<html>
                             <body>
                                     <h3>Yth. Bpk/Ibu  ".$km." ,</h3>
                                     <p>Terima kasih telah melakukan pembayaran untuk ".$ki." , Berikut kami lampirkan Invoice Terbayar.
                                     Barang anda akan segera kami kirim ke alamat anda (Estimasi 1-5 hari)</p>
                                     <p>".nama_perusahaan()."</p>

                             </body>
                       </html>";

				$this->email->set_newline("\r\n");
				$this->email->from(user_email());
				$this->email->to($email); //email tujuan. Isikan dengan emailmu!
				$this->email->subject('[Wilopo Cargo] Pembayaran Invoice Barang '.$ki);
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

				$this->session->set_flashdata('msg','success');
	  		redirect(site_url('admin/invoice_barang'));

    }

		public function mail_invoice_lainnya() {
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
      $id_invoice = $this->uri->segment(4);

     	$data_invoice= $this->Minvoice_lainnya->data_invoice($id_invoice);
    	foreach($data_invoice->result() as $inv ){
        $ei=$inv->encrypt_invoice;
        $ki=$inv->kode_invoice;
        $tt=$inv->total_tagihan;
        $km=$inv->kode;
        $email=$inv->email;
				$nama=$inv->nama;
				$whatsapp=$inv->whatsapp;
				$whatsapp_grup = $inv->whatsapp_cgrup;
				$egrup = $inv->email_cgrup;
				$id_cgrup = $inv->id_cgrup;
     	}

			$namaaktif = $nama;
			$kodeaktif = $kcustomer;

	 		 if($id_cgrup > 0){
	 				$status_invoice="grup";
	 				$emailaktif= $egrup;
	 				$whatsappaktif= $whatsapp_grup;
	 		 }else if($id_cgrup <=0 ){
	 				$status_invoice="customer";
	 				$emailaktif= $email;
	 				$whatsappaktif= $whatsapp;
	 		 }

        $test['status'] =0;
        $test['record'] = $this->Minvoice_lainnya->data_invoice($id_invoice)->row();
        $test['item']= $this->Minvoice_lainnya->item_inv($id_invoice)->result(); //print_r($test['item']);die();
       	$data = $this->load->view('admin/invoice_lainnya/pdf_invoice',$test,True);

        $mpdf = new \Mpdf\Mpdf();
				$mpdf->WriteHTML($data);
				$mpdf->Output("pdf_file/".time()."inv.pdf" ,'F');
				$time=time()."inv.pdf";
        $content = $mpdf->Output('', 'S');

				$pesan = "*Yth. Bpk/Ibu ".$nama." (".$km.")*\n\nBerikut kami lampirkan invoice ".$ki." yang harus Anda bayar, yaitu sebesar Rp.".number_format($tt).
	 		 					"\nSetelah melakukan pembayaran, harap melakukan konfirmasi pembayaran dengan menghubungi kami melalui telepon / WA.\nTerima kasih atas kerja samanya :)".
	 							"\n\n*Wilopo Cargo* _(do not reply)_";

				sendwhatsapp($pesan,"081310961108");
		 		$sendoc = send_newdoc($time,"081310961108",$ki);

				sendwhatsapp($pesan,$whatsappaktif);
		 		$sendoc = send_newdoc($time,$whatsappaktif,$ki);

        $this->load->library('email', $config);
        $this->email->attach($content, 'attachment', $ki , 'application/pdf');

        $the_message="<html>
                            <body>
                                    <h3>Yth. ".$km." ,</h3>
                                    <p>Berikut terlampir invoice yang harus Anda bayar, yaitu ".$ki." sebesar Rp.".number_format($tt)." </p>
                                    <p>Setelah melakukan pembayaran, harap melakukan konfirmasi pembayaran dengan menghubungi kami melalui telepon / WA.</p>
                                    <p>".nama_perusahaan()."</p>

                            </body>
                      </html>";

		    $this->email->set_newline("\r\n");
		    $this->email->from(user_email());
		    $this->email->to($emailaktif); //email tujuan. Isikan dengan emailmu!
		    $this->email->subject('[Wilopo Cargo] Invoice Barang '.$ki);
		    $this->email->message($the_message);

		    if($this->email->send())
		    {
					if($sendoc){
		 			 $path_unlink = './'.$time;
		 			 unlink($path_unlink );
					 // update tanggal kirim
					 $h=date('H')+7;
					 $inv['tanggal_kirim'] = date('Y-m-d '.$h.'-i-s');
					 $this->db->where('id_invoice',$id_invoice)->update('invoice',$inv);
		 		  }
		    }
		    else
		    {
		      //show_error($this->email->print_debugger());
		    }

		    $this->session->set_flashdata('msg','success');
			  redirect(site_url('admin/invoice_lainnya'));
    }

    public function mail_payment_lainnya() {

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
			$id_invoice = $this->uri->segment(4);

			$data_invoice= $this->Minvoice_lainnya->data_invoice($id_invoice);
    	foreach($data_invoice->result() as $inv ){
        $ei=$inv->encrypt_invoice;
        $ki=$inv->kode_invoice;
        $tt=$inv->total_tagihan;
        $km=$inv->kode;
        $email=$inv->email;
				$nama=$inv->nama;
				$whatsapp=$inv->whatsapp;
				$whatsapp_grup = $inv->whatsapp_cgrup;
				$egrup = $inv->email_cgrup;
				$id_cgrup = $inv->id_cgrup;
     	}

			$namaaktif = $nama;
			$kodeaktif = $kcustomer;

	 		 if($id_cgrup > 0){
	 				$status_invoice="grup";
	 				$emailaktif= $egrup;
	 				$whatsappaktif= $whatsapp_grup;
	 		 }else if($id_cgrup <=0 ){
	 				$status_invoice="customer";
	 				$emailaktif= $email;
	 				$whatsappaktif= $whatsapp;
	 		 }

        $test['status'] =1;
        $test['record'] = $this->Minvoice_lainnya->data_invoice($id_invoice)->row();
        $test['item']= $this->Minvoice_lainnya->item_inv($id_invoice)->result();
       	$data = $this->load->view('admin/invoice_lainnya/pdf_invoice',$test,True);

				$mpdf = new \Mpdf\Mpdf();
				$mpdf->WriteHTML($data);
				$mpdf->Output("pdf_file/".time()."pay.pdf" ,'F');
				$time=time()."pay.pdf";
				$content = $mpdf->Output('', 'S');

				$pesan = "*Yth. Bpk/Ibu ".$nama." (".$km.")*\n\nTerima kasih telah melakukan pembayaran \nBerikut kami lampirkan Invoice Terbayar ".$ki.
								"\nTransaksi Anda sedang kami proses, harap tunggu info selanjutnya dari kami.\nTerima kasih atas kerja samanya :)".
								"\n\n*Wilopo Cargo* _(do not reply)_";

				sendwhatsapp($pesan,"081310961108");
		 		$sendoc = send_newdoc($time,"081310961108",$ki);

				sendwhatsapp($pesan,$whatsappaktif);
		 		$sendoc = send_newdoc($time,$whatsappaktif,$ki);

				$this->load->library('email', $config);
				$this->email->attach($content, 'attachment', $ki , 'application/pdf');


				$the_message="<html>
														<body>
																		<h3>Yth. ".$km." ,</h3>
																		<p>Berikut terlampir invoice yang harus Anda bayar, yaitu Invoice".$ki." sebesar Rp.".number_format($tt)." </p>
																		<p>Setelah melakukan pembayaran, harap melakukan konfirmasi pembayaran dengan menghubungi kami melalui telepon / WA.</p>
																		<p>".nama_perusahaan()."</p>

														</body>
											</html>";

				$this->email->set_newline("\r\n");
				$this->email->from(user_email());
				$this->email->to($whatsappaktif,"gusmavin@gmail.com"); //email tujuan. Isikan dengan emailmu!
				$this->email->subject('[Wilopo Cargo] Invoice Resi Barang '.$ki);
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
				$this->session->set_flashdata('msg','success');
	  		redirect(site_url('admin/invoice_lainnya'));

    }

		public function semua_invoice_lainnya() {
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
			$cekinvlainnya = $this->db->query('SELECT * from invoice where tipe_invoice = "lainnya" and tanggal_kirim is null')->result();
			// print_r($cekinvlainnya);die();
			foreach($cekinvlainnya as $cekinv){
	      $id_invoice = $cekinv->id_invoice;
	     	$data_invoice= $this->Minvoice_lainnya->data_invoice($id_invoice);
	    	foreach($data_invoice->result() as $inv ){
	        $ei=$inv->encrypt_invoice;
	        $ki=$inv->kode_invoice;
	        $tt=$inv->total_tagihan;
	        $km=$inv->kode;
	        $email=$inv->email;
					$nama=$inv->nama;
					$whatsapp=$inv->whatsapp;
					$whatsapp_grup = $inv->whatsapp_cgrup;
					$egrup = $inv->email_cgrup;
					$id_cgrup = $inv->id_cgrup;
	     	}

				$namaaktif = $nama;
				$kodeaktif = $kcustomer;

		 		 if($id_cgrup > 0){
		 				$status_invoice="grup";
		 				$emailaktif= $egrup;
		 				$whatsappaktif= $whatsapp_grup;
		 		 }else if($id_cgrup <=0 ){
		 				$status_invoice="customer";
		 				$emailaktif= $email;
		 				$whatsappaktif= $whatsapp;
		 		 }

	        $test['status'] =0;
	        $test['record'] = $this->Minvoice_lainnya->data_invoice($id_invoice)->row();
	        $test['item']= $this->Minvoice_lainnya->item_inv($id_invoice)->result(); //print_r($test['item']);die();
	       	$data = $this->load->view('admin/invoice_lainnya/pdf_invoice',$test,True);

	        $mpdf = new \Mpdf\Mpdf();
					$mpdf->WriteHTML($data);
					$mpdf->Output("pdf_file/".time()."inv.pdf" ,'F');
					$time=time()."inv.pdf";
	        $content = $mpdf->Output('', 'S');

					$pesan = "*Yth. Bpk/Ibu ".$nama." (".$km.")*\n\nBerikut kami lampirkan invoice ".$ki." yang harus Anda bayar, yaitu sebesar Rp.".number_format($tt).
		 		 					"\nSetelah melakukan pembayaran, harap melakukan konfirmasi pembayaran dengan menghubungi kami melalui telepon / WA.\nTerima kasih atas kerja samanya :)".
		 							"\n\n*Wilopo Cargo* _(do not reply)_";

					sendwhatsapp($pesan,"081310961108");
			 		$sendoc = send_newdoc($time,"081310961108",$ki);

					sendwhatsapp($pesan,$whatsappaktif);
			 		$sendoc = send_newdoc($time,$whatsappaktif,$ki);

	        $this->load->library('email', $config);
	        $this->email->attach($content, 'attachment', $ki , 'application/pdf');

	        $the_message="<html>
	                            <body>
	                                    <h3>Yth. ".$km." ,</h3>
	                                    <p>Berikut terlampir invoice yang harus Anda bayar, yaitu Invoice".$ki." sebesar Rp.".number_format($tt)." </p>
	                                    <p>Setelah melakukan pembayaran, harap melakukan konfirmasi pembayaran dengan menghubungi kami melalui telepon / WA.</p>
	                                    <p>".nama_perusahaan()."</p>

	                            </body>
	                      </html>";

			    $this->email->set_newline("\r\n");
			    $this->email->from(user_email());
			    $this->email->to($emailaktif,"gusmavin@gmail.com"); //email tujuan. Isikan dengan emailmu!
			    $this->email->subject('[Wilopo Cargo] Invoice Barang '.$ki);
			    $this->email->message($the_message);

			    if($this->email->send())
			    {
						if($sendoc){
			 			 $path_unlink = './'.$time;
			 			 unlink($path_unlink );
						 // update tanggal kirim
						 $h=date('H')+7;
						 $inv['tanggal_kirim'] = date('Y-m-d '.$h.'-i-s');
						 $this->db->where('id_invoice',$id_invoice)->update('invoice',$inv);
			 		  }
			    }
			    else
			    {
			      //show_error($this->email->print_debugger());
			    }
				}

		    $this->session->set_flashdata('msg','success');
			  redirect(site_url('admin/invoice_lainnya'));
    }

		public function resi_invoice() {

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

		    $id_invoice = $this->uri->segment(4);

		   	$data_invoice= $this->Minvoice->data_invoice_id($id_invoice);
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
					$nama =$inv->nama;
					$namagrup=$inv->nama_cgrup;
					$whatsapp=$inv->whatsapp;
		 		  $whatsapp_grup=$inv->whatsapp_cgrup;
		 		}

				$namaaktif = $nama;
				$kodeaktif = $kcustomer;

		 		 if($id_cgrup > 0){
		 				$status_invoice="grup";
		 				$emailaktif= $egrup;
		 				$whatsappaktif= $whatsapp_grup;
		 		 }else if($id_cgrup <=0 ){
		 				$status_invoice="customer";
		 				$emailaktif= $email;
		 				$whatsappaktif= $whatsapp;
		 		 }

				  $tst['status']=0;
				  $tst['r']= $this->Mresi_udara->getresiinvidinv($id_invoice)->row();
				  $data = $this->load->view('admin/resi_udara/pdf_invoice',$tst,True);
		      $mpdf = new \Mpdf\Mpdf();
					//$data = $this->load->view('hasilPrint', [], TRUE);
		      $mpdf->WriteHTML($data);
					$mpdf->Output("pdf_file/".time()."inv.pdf" ,'F');
					$time=time()."inv.pdf";

					$pesan = "*Yth. Bpk/Ibu ".$namaaktif." (".$kodeaktif.")*\n\nBerikut kami lampirkan Invoice Resi Barang Udara ".$ki." yang harus Anda bayar, yaitu sebesar Rp.".number_format($tt).
		 		 					". ke rekening berikut:\n\n*BCA 5810557747 a/n Gusmavin Willopo*\n\nSetelah melakukan pembayaran, harap melakukan konfirmasi pembayaran dengan menghubungi kami melalui telepon / WA.\nTerima kasih atas kerja samanya :)".
		 							"\n\n*Wilopo Cargo* _(do not reply)_";

					sendwhatsapp($pesan,$whatsappaktif);
					$sendoc = send_newdoc($time,$whatsappaktif,$ki);

					$content = $mpdf->Output('', 'S');
		      $this->load->library('email', $config);
		      $this->email->attach($content, 'attachment', $ki , 'application/pdf');

		       $the_message="<html>
		                            <body>
		                                    <h3>Yth. Bpk/Ibu ".$namaaktif." (".$kodeaktif.") ,</h3>
		                                    <p>Berikut terlampir Invoice Resi Barang Udara <b>".$ki."</b> yang harus Anda bayar, yaitu sebesar Rp.".number_format($tt).". ke rekening berikut:</p>
		                                    <p><b>BCA 5810557747 a/n Gusmavin Willopo</b></p>
																				<br />Setelah melakukan pembayaran, harap melakukan konfirmasi pembayaran dengan menghubungi kami melalui telepon / WA.</p>
		                                    <p>".nama_perusahaan()."</p>

		                            </body>
		                      </html>";

		    $this->email->set_newline("\r\n");
		    $this->email->from(user_email());
		    $this->email->to($emailaktif); //email tujuan. Isikan dengan emailmu!
		    $this->email->subject('[Wilopo Cargo] Invoice Resi Udara '.$ki);
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

		    $this->session->set_flashdata('msg','success');
			  redirect(site_url('admin/resi_udara/invoice'));

	    }

			public function resi_payment() {

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

			    $id_invoice = $this->uri->segment(4);

			   	$data_invoice= $this->Minvoice->data_invoice_id($id_invoice);
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
						$nama =$inv->nama;
						$namagrup=$inv->nama_cgrup;
						$whatsapp=$inv->whatsapp;
			 		  $whatsapp_grup=$inv->whatsapp_cgrup;
			 		}

					$namaaktif = $nama;
					$kodeaktif = $kcustomer;

			 		 if($id_cgrup > 0){
			 				$status_invoice="grup";
			 				$emailaktif= $egrup;
			 				$whatsappaktif= $whatsapp_grup;
			 		 }else if($id_cgrup <=0 ){
			 				$status_invoice="customer";
			 				$emailaktif= $email;
			 				$whatsappaktif= $whatsapp;
			 		 }

					  $tst['status']=1;
					  $tst['r']= $this->Mresi_udara->getresiinvidinv($id_invoice)->row();
					  $data = $this->load->view('admin/resi_udara/pdf_invoice',$tst,True);
			      $mpdf = new \Mpdf\Mpdf();
						//$data = $this->load->view('hasilPrint', [], TRUE);
			      $mpdf->WriteHTML($data);
						$mpdf->Output("pdf_file/".time()."inv.pdf" ,'F');
						$time=time()."inv.pdf";

						$pesan = "*Yth. Bpk/Ibu ".$namaaktif." (".$kodeaktif.")*\n\nTerima kasih telah melakukan pembayaran \nBerikut kami lampirkan Invoice Terbayar ".$ki.
										"\nTerima kasih atas kerja samanya :)".
										"\n\n*Wilopo Cargo* _(do not reply)_";

						sendwhatsapp($pesan,$whatsappaktif);
						$sendoc = send_newdoc($time,$whatsappaktif,$ki);

						$content = $mpdf->Output('', 'S');
			      $this->load->library('email', $config);
			      $this->email->attach($content, 'attachment', $ki , 'application/pdf');

						$the_message="<html>
																<body>
																				<h3>Yth. Bpk/Ibu ".$namaaktif." (".$kodeaktif.") ,</h3>
																				<p>Terima kasih telah melakukan pembayaran untuk ".$ki."
																				".nama_perusahaan()."

																</body>
													</html>";

			    $this->email->set_newline("\r\n");
			    $this->email->from(user_email());
			    $this->email->to($emailaktif); //email tujuan. Isikan dengan emailmu!
			    $this->email->subject('[Wilopo Cargo] Pembayaran Invoice Resi Udara '.$ki);
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

			    $this->session->set_flashdata('msg','success');
				  redirect(site_url('admin/resi_udara/invoice'));

		    }

 }
