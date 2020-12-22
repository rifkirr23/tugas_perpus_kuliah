<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {

	public function __construct(){
		parent::__construct();

		  $this->load->model('Mbarang');


	}

    function ins_barcode(){

           $data_resi= $this->Mbarang->data_resi($this->input->post('resi_id'));
        	foreach($data_resi->result() as $dresis ){
            $id_resi      =$dresis->id_resi;
            $id_customer  =$dresis->cust_id;

         	 }

           $dhb= $this->Mbarang->data_hb($this->input->post('id_jenis_barang'));
        	foreach($dhb->result() as $harb ){
            $hb      =$harb->harga_jb;
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
          $harga                = $this->input->post('harga');
          $packing_fare         = $this->input->post('packing_fare');
          $fare                 = $this->input->post('fare');
          $biaya_lain           = $this->input->post('biaya_lain');
          $kurs_fare            = $this->input->post('kurs_fare');
          $resi_id              = $id_resi;
          $status_berat         = $this->input->post('status_berat');


          $this->Mbarang->insert_barcode($barang,$nomor_brcd,$idc,$id_jenis_barang,$ctns,$qty,$berat,$volume,$nilai,$status,$note,$asuransi,
          $kurs,$remarks,$harga,$packing_fare,$fare,$biaya_lain,$kurs_fare,$resi_id,$status_berat,$hb);
    }

    function ins_resi(){
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
          $tanggal_resi = $this->input->post('tanggal');
          $supplier = $this->input->post('supplier');
          $tel = $this->input->post('tel');
          $note = $this->input->post('note');

          $this->Mbarang->insert_resi($eid,$id_resi_rts,$kode,$nomor_resi,$tanggal_resi,$supplier,$tel,$note,$konifrmasi_resi,$gudang);


    }

    function resi_email(){


        $nomor_resi=$this->uri->segment(4);

        $data_resi= $this->Mbarang->data_resi($nomor_resi);
        	foreach($data_resi->result() as $dresis ){
            $id_resi      =$dresis->id_resi;
            $kodem  =$dresis->kode;
            $supp  =$dresis->supplier;
            $supptel  =$dresis->tel;
            $eid  =$dresis->encrypt_resi;
            $email_customer  =$dresis->email;
            $vmail  =$dresis->validasi_email;
            $tgl_resi  =$dresis->tanggal;
         	 }

    if($vmail==2){
				echo"v";
    }else{

         $config = Array(
      'protocol' => 'smtp',
      'smtp_host' => 'ssl://smtp.gmail.com',
      'smtp_port' => 465,
			'smtp_user' => user_email(), //isi dengan gmailmu!
      'smtp_pass' => pass_email(),
      'mailtype' => 'html',
      'charset' => 'iso-8859-1',
      'wordwrap' => TRUE
    );


         	 $data_barcodes= $this->Mbarang->data_brcd($id_resi);
        	foreach($data_barcodes->result() as $dbar ){

            $volumes=$dbar->volume;
            $nilais=$dbar->nilai;
            $ctnss=$dbar->ctns;
            $qtys=$dbar->qty;
            $kurss=$dbar->kurs;

         $rmb1 = $nilais * $ctnss * $qtys;
         $rmb2 = $rmb1 * $kurss;
         $tvolumes += $volumes;
         $total_asuransi += $rmb2;

         	 }

         $asrns = $total_asuransi;
         $asuransi_tanggungan = $tvolumes * 20000000;

				 $asr=$total_asuransi - $asuransi_tanggungan;
         $na=($asr / $tvolumes) / 10000000;
         $n = floor($na);
         $asrns_tambahan = round(($total_asuransi - $asuransi_tanggungan) * ($n/100));


            $test['resi']= $this->Mbarang->data_resi($nomor_resi)->row_array();
            $test['barcode']= $this->Mbarang->data_barcode($id_resi)->result();
            $data = $this->load->view('api/pdf_konfirmasi',$test,True);
            $mpdf = new \Mpdf\Mpdf();

            $mpdf->WriteHTML($data);
            $content = $mpdf->Output('', 'S');
            $this->load->library('email', $config);
            $this->email->attach($content, 'attachment', $nomor_resi , 'application/pdf');

             $c1="<table cellpadding='1' cellspacing='2' border='1'>
            <thead>
            <tr>
                <th colspan='4'><img src='".base_url()."assets/logo2.jpg' height='100px' width='150px'></th>
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



            if($total_asuransi < $asuransi_tanggungan){
                 $h="<html>
                            <body>
                                    <p>Dear Customer Wilopo Cargo, Kami telah menerima barang Anda di Gudang Kami, Berikut adalah detail resi pengiriman Anda.
                                    Klik tombol dibawah untuk konfirmasi packing list resi, jika tidak maka barang Anda belum kami loading ke container. Terimakasih telah menggunakan Wilopo Cargo.</p>
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

            }else if($total_asuransi > $asuransi_tanggungan){
               // echo $total_asuransi;
                 $h="<html>
                            <body>
                                    <p>Dear Customer Wilopo Cargo, Kami telah menerima barang Anda di Gudang Kami, Berikut adalah detail resi pengiriman Anda.
                                    Klik tombol dibawah untuk konfirmasi packing list resi, jika tidak maka barang Anda belum kami loading ke container. Terimakasih telah menggunakan Wilopo Cargo. </p>
                                    <p>Nilai barang yang Anda kirim ada yang melebihi jumlah asuransi yang kami cover per barcode (Rp. 20.000.000 / cbm), Anda dapat membeli asuransi
                                    tambahan pada barang kiriman Anda. Biaya asuransi tambahan pada barang Anda adalah sebesar RP.".number_format($asrns_tambahan).", yaitu 1% dari nilai barang Anda setelah dikurangi
                                    asuransi yang kami cover (Rp. 20.000.000 / cbm). Klik tombol dibawah ini untuk menyetujui pembelian asuransi tambahan yang nanti akan kami bebankan pada invoice Anda,
                                    atau Anda dapat mengabaikannya jika tidak ingin membeli asuransi tambahan. (Harap segera melakukan konfirmasi dengan klik tombol dibawah, apabila barang kiriman sudah
                                    jalan dari gudang China, maka pembelian asuransi tambahan tidak bisa lagi dilakukan)</p>

                                    <p><a href='".base_url()."konfirmasi/konfirmasi/kf_asuransi/".$eid."'><button style='background-color: #f44336; padding: 10px 24px; border: none;
                                                   color: white; font-size: 10px; border-radius: 12px;'>Konfirmasi Resi & Beli Asuransi</button>
                                    </a></p>
                                    <p><a href='".base_url()."konfirmasi/konfirmasi/kf/".$eid."'><button style='background-color: #008CBA; padding: 10px 24px; border: none;
                                                   color: white; font-size: 10px; border-radius: 12px;'>Konfirmasi Resi aja</button>
                                    </a></p>
                                   ";
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

                $the_message= $h."<br/>".$c1.$c2.$f;
            }


    $this->email->set_newline("\r\n");
    $this->email->from(user_email());
    $this->email->to($email_customer);
    $this->email->subject('[Wilopo Cargo] Barang Masuk : '.$nomor_resi);
    $this->email->message("$the_message");

    if($this->email->send())
    {

    }
    else
    {
      //show_error($this->email->print_debugger());
    }

  }

}

public function resimail() {

	$nomor_resi=$this->uri->segment(4);

	$data_resi= $this->Mbarang->data_resi($nomor_resi);
		foreach($data_resi->result() as $dresis ){
			$id_resi      =$dresis->id_resi;
			$kodem  =$dresis->kode;
			$supp  =$dresis->supplier;
			$supptel  =$dresis->tel;
			$eid  =$dresis->encrypt_resi;
			$email_customer  =$dresis->email;
			$vmail  =$dresis->validasi_email;
			$tgl_resi  =$dresis->tanggal;
		 }

	if($vmail==2){
		echo"v";
	}else{

			 $config = Array(
	'protocol' => 'smtp',
	'smtp_host' => 'ssl://smtp.gmail.com',
	'smtp_port' => 465,
	'smtp_user' => user_email(), //isi dengan gmailmu!
	'smtp_pass' => pass_email(),
	'mailtype' => 'html',
	'charset' => 'iso-8859-1',
	'wordwrap' => TRUE
);

		$data_barcodes= $this->Mbarang->data_brcd($id_resi);
		foreach($data_barcodes->result() as $dbar ){

		 $volumes=$dbar->volume;
		 $nilais=$dbar->nilai;
		 $ctnss=$dbar->ctns;
		 $qtys=$dbar->qty;
		 $kurss=$dbar->kurs;

		$rmb1 = $nilais * $ctnss * $qtys;
		$rmb2 = $rmb1 * $kurss;
		$tvolumes += $volumes;
		$total_asuransi += $rmb2;

		}

		$asrns = $total_asuransi;
		$asuransi_tanggungan = $tvolumes * 20000000;

		$asr=$total_asuransi - $asuransi_tanggungan;
		$na=($asr / $tvolumes) / 10000000;
		$n = floor($na);
		$asrns_tambahan = round(($total_asuransi - $asuransi_tanggungan) * ($n/100));


		 $test['resi']= $this->Mbarang->data_resi($nomor_resi)->row_array();
		 $test['barcode']= $this->Mbarang->data_barcode($id_resi)->result();
		 $data = $this->load->view('api/pdf_konfirmasi',$test,True);
		 $mpdf = new \Mpdf\Mpdf();

		 $mpdf->WriteHTML($data);
		 $content = $mpdf->Output('', 'S');
		 $this->load->library('email', $config);
		 $this->email->attach($content, 'attachment', $nomor_resi , 'application/pdf');

			$c1="<table cellpadding='1' cellspacing='2' border='1'>
		 <thead>
		 <tr>
				 <th colspan='4'><img src='".base_url()."assets/logo2.jpg' height='100px' width='150px'></th>
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



				if($total_asuransi < $asuransi_tanggungan){
						 $h="<html>
												<body>
																<p>Dear Customer Wilopo Cargo, Kami telah menerima barang Anda di Gudang Kami, Berikut adalah detail resi pengiriman Anda.
																Klik tombol dibawah untuk konfirmasi packing list resi, jika tidak maka barang Anda belum kami loading ke container. Terimakasih telah menggunakan Wilopo Cargo.</p>
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

				}else if($total_asuransi > $asuransi_tanggungan){
					 // echo $total_asuransi;
						 $h="<html>
												<body>
																<p>Dear Customer Wilopo Cargo, Kami telah menerima barang Anda di Gudang Kami, Berikut adalah detail resi pengiriman Anda.
																Klik tombol dibawah untuk konfirmasi packing list resi, jika tidak maka barang Anda belum kami loading ke container. Terimakasih telah menggunakan Wilopo Cargo. </p>
																<p>Nilai barang yang Anda kirim ada yang melebihi jumlah asuransi yang kami cover per barcode (Rp. 20.000.000 / cbm), Anda dapat membeli asuransi
																tambahan pada barang kiriman Anda. Biaya asuransi tambahan pada barang Anda adalah sebesar RP.".number_format($asrns_tambahan).", yaitu 1% dari nilai barang Anda setelah dikurangi
																asuransi yang kami cover (Rp. 20.000.000 / cbm). Klik tombol dibawah ini untuk menyetujui pembelian asuransi tambahan yang nanti akan kami bebankan pada invoice Anda,
																atau Anda dapat mengabaikannya jika tidak ingin membeli asuransi tambahan. (Harap segera melakukan konfirmasi dengan klik tombol dibawah, apabila barang kiriman sudah
																jalan dari gudang China, maka pembelian asuransi tambahan tidak bisa lagi dilakukan)</p>
																<p><a href='".base_url()."konfirmasi/konfirmasi/kf_asuransi/".$eid."'><button style='background-color: #f44336; padding: 10px 24px; border: none;
																							 color: white; font-size: 10px; border-radius: 12px;'>Konfirmasi Resi & Beli Asuransi</button>
																</a></p>
																<p><a href='".base_url()."konfirmasi/konfirmasi/kf/".$eid."'><button style='background-color: #008CBA; padding: 10px 24px; border: none;
																							 color: white; font-size: 10px; border-radius: 12px;'>Konfirmasi Resi aja</button>
																</a></p>
															 ";
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

						$the_message= $h."<br/>".$c1.$c2.$f;
				}


//$this->load->library('email', $config);
$this->email->set_newline("\r\n");
$this->email->from(user_email());
$this->email->to($email); //email tujuan. Isikan dengan emailmu!
$this->email->subject('[Wilopo Cargo] Pembayaran '.$ki.' telah kami terima');
$this->email->message($the_message);

			if($this->email->send())
			{
				$path_unlink = './'.'Payment_TT_Wilopo.pdf';
				 unlink($path_unlink );
			}
			else
			{
				//show_error($this->email->print_debugger());
			}

		}

	}

}




}
