<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resi extends CI_Controller {

	public function __construct(){
		parent::__construct();
		cek_session(); //cek session User Login
		$this->load->model('Mresi');
		$this->load->model('Mgiw');
		$this->load->model('Mbarang'); //Load Model Resi
	}

	//Function Halaman Awal Menu Customer
    public function encrypt_decryptrts($action, $string) {
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
     
	 function index(){
		$this->template->load('template','admin/resi/resi');
	 }

	//Function Get data Json Customer

	function get_resi_json() { 				//data data Customer by JSON object
    header('Content-Type: application/json');
    echo $this->Mresi->get_resi();
  }

   function get_resiid_json() { 				//data data Customer by JSON object
    header('Content-Type: application/json');
    $id=$this->uri->segment(4);
    echo $this->Mresi->get_resi_byid($id);
   }

	 function get_resiidgrup_json() { 				//data data Customer by JSON object
    header('Content-Type: application/json');
    $id=$this->uri->segment(4);
    echo $this->Mresi->get_resi_byidgrup($id);
   }

   function get_barcodeid_json() { 				//data data Customer by JSON object
    header('Content-Type: application/json');
    $id = $this->uri->segment(4);
    echo $this->Mresi->get_barcode_byid($id);
   }

	 function get_barcodeidcust_json() { 				//data data Customer by JSON object
    header('Content-Type: application/json');
    $id = $this->uri->segment(4);
    echo $this->Mresi->get_barcodeidcust_json($id);
   }

	 function get_barcodeidgrup_json() { 				//data data Customer by JSON object
    header('Content-Type: application/json');
    $id = $this->uri->segment(4);
    echo $this->Mresi->get_barcodeidgrup_json($id);
   }

   function detail(){
    $id = $this->uri->segment(4);
    $parse['r']=$this->Mresi->get_id2($id)->row();
    $parse['d']=$this->db->select('resi.id_resi_rts')->from('resi')->where('id_resi', $id)->get()->row();
    $detailresi=$this->db->select('resi.id_resi_rts')->from('resi')->where('id_resi', $id)->get()->row();
    $parse['detailcontainer']=$this->db->select('giw.container_id')->from('giw')->where('resi_id', $detailresi->id_resi_rts)->get()->result();
    $parse['s']=$this->db->select('history_date_status.tanggal,status_resi.*,history_date_status.hari as jumlahhari')->from('history_date_status')->join('status_resi', 'history_date_status.tipe_resi=status_resi.id')->where('history_date_status.resi_id', $detailresi->id_resi_rts)->order_by('history_date_status.tanggal','asc')->order_by('history_date_status.id','asc')->get()->result();
    
    $parse['h']=$this->Mgiw->cekresioffice($id)->result();
    // var_dump($gg);
    $this->template->load('template','admin/resi/detail',$parse);
  }


    function cek_resi(){
			//Cek Resi
      $data_resi= $this->Mresi->all_resi();
			$id_r = array();//array id resi
			$id_g = array();//array id barcode
      foreach($data_resi->result() as $dresis ){

      $id_resi          =$dresis->id_resi;
			$nomoresi          =$dresis->nomor;
      $id_resi_rts      =$dresis->id_resi_rts;
			$tanggal          =$dresis->tanggal;
      $kodem            =$dresis->kode;
      $supp             =$dresis->supplier;
      $supptel          =$dresis->tel;
      $note             =$dresis->note;

      $url='https://wilopocargo.com/tes_curl/api/resi.php?id='.$id_resi_rts;
      $json = file_get_contents($url);
      $dresi = json_decode($json);

         foreach($dresi as $dr ){
             $dr->tanggal;
					   $dr->kode;
						 $dr->supplier;
						 $dr->tel;
					   $dr->note;
         }
				 if($tanggal != $dr->tanggal || $kodem != $dr->kode || $supp != $dr->supplier || $supptel != $dr->tel || $note != $dr->note)
				 		{	$id_r[]=$nomoresi; }

						//cek id barcode
						$cek_id_barcode= $this->Mbarang->data_barcode($id_resi);
						foreach($cek_id_barcode->result() as $db ){
								$nbar      =$db->nomor;


					//Cek barcode
					$data_barcode= $this->Mbarang->barcode_nomor($nbar);
					foreach($data_barcode->result() as $dbar ){

							$id_barcode       =$dbar->id;
							$nomorbarcode     =$dbar->nomor;
	            $barang           =$dbar->barang;
	            $jenis_barang_id  =$dbar->jenis_barang_id;
							$ctns             =$dbar->ctns;
	            $qty              =$dbar->qty;
	            $berat            =$dbar->berat;
	            $volume           =$dbar->volume;
	            $nilai            =$dbar->nilai;
							$status           =$dbar->status;
							$noteg            =$dbar->note;
							$kurs             =$dbar->kurs;
							$remarks          =$dbar->remarks;
							$harga            =$dbar->harga;

						}
	            $url3='https://wilopocargo.com/tes_curl/api/barcode.php?id='.$nbar;
	            $jsonbar = file_get_contents($url3);
	            $api_bar = json_decode($jsonbar);

	               foreach($api_bar as $ab ){
	                   $ab->barang;
									   $ab->jenis_barang_id;
										 $ab->ctns;
										 $ab->qty;
									   $ab->berat;
										 $ab->volume;
										 $ab->nilai;
										 $ab->status;
										 $ab->note;
										 $ab->kurs;
										 $ab->remarks;
										 $ab->harga;
	               }
								 if($barang != $ab->barang || $jenis_barang_id != $ab->jenis_barang_id || $ctns != $ab->ctns || $qty != $ab->qty || $berat != $ab->berat
								    || $volume != $ab->volume || $nilai != $ab->nilai || $status != $ab->status || $noteg != $ab->note || $kurs != $ab->kurs
										|| $remarks != $ab->remarks || $harga != $ab->harga)
								 		{	$id_g[]=$nomorbarcode; }

						 }
					}
					if($id_r==null){$id_r[]=1;}
					if($id_g==null){$id_g[]=1;}


				  $url2='https://wilopocargo.com/tes_curl/api/resi_array.php';
				  $postdata = http_build_query($id_r);
					$opts =array('http' =>
													array(
                          'method'  => 'POST',
                          'header'  => 'Content-Type: application/x-www-form-urlencoded',
                          'content' => $postdata
											    )
                      );


          $context   = stream_context_create($opts);
					$json_resi = file_get_contents($url2, false, $context);
				 // var_dump($json_resi);die();


					$url4='https://wilopocargo.com/tes_curl/api/barcode_array.php';
				  $postdata2 = http_build_query($id_g);
					$opts2 =array('http' =>
													array(
                          'method'  => 'POST',
                          'header'  => 'Content-Type: application/x-www-form-urlencoded',
                          'content' => $postdata2
											    )
                      );


          $context2   = stream_context_create($opts2);
					$json_barcode = file_get_contents($url4, false, $context2);
				  //var_dump($json_barcode);die();

    $parse['barcode_rts']  = json_decode($json_barcode);
		$parse['resi_rts']  = json_decode($json_resi);
		$parse['resi']=$this->Mresi->resi_array($id_r)->result();
		$parse['barcode']=$this->Mbarang->barcode_array($id_g)->result();
		$this->template->load('template','admin/resi/cek_resi',$parse);
  }

		function cancel_asuransi(){
			$idresi = $this->input->post('id_resi');
			// Ubah Status Ke Konfirmasi dr asuransi
			$resi['konfirmasi_resi'] = 1;
			$this->db->where('id_resi',$idresi)->update('resi',$resi);
			// Delete Asuransi
			$this->db->where('id_resi',$idresi)->delete('invoice_asuransi');
			$this->session->set_flashdata('msg','okcancel');
			redirect(site_url('admin/resi/detail/'.$idresi));
		}

		function select_giw(){
 	    // cek_session_all();
 	    $nomor = $this->input->get('nomor');
 	    $datagiw = $this->db->select('id,nomor')->limit(10)->from('giw')->like('nomor', $nomor)->get()->result_array();
 	    echo json_encode($datagiw);
    }

		function send_kf(){
			$id_resi  = $this->input->post('id_resi');
			$dataresi = $this->db->select('resi.nomor,resi.id_resi,resi.id_resi_rts,resi.tanggal,resi.supplier,resi.tel,resi.note,customer.kode,customer.email,customer.whatsapp')
	    				 ->from('resi')->join('customer', 'resi.cust_id=customer.id_cust', 'left')
							 ->where('id_resi',$id_resi)
							 ->get()->row();
			$the_message="<html>
													 <body>
																	 <h3>Dear Customer Yth. Bpk/Ibu ".$dataresi->kode.",</h3>
																	 <p> Mohon segera konfirmasi ".$dataresi->nomor." yang telah kami kirim </p>
																	 <p>".nama_perusahaan2()."</p>

													 </body>
										 </html>";

			$atch=base_url().'assets/'.skwilopo();
			$config = Array(
				'protocol' => 'smtp',
				'smtp_host' => 'mail.wilopocargo.com',
				'smtp_port' => 587,
				'smtp_user' => user_email(), //isi dengan gmailmu!
				'smtp_pass' => pass_email(), //isi dengan password gmailmu!
				'mailtype' => 'html',
				'charset' => 'iso-8859-1',
				'wordwrap' => TRUE
			);
			$this->load->library('email', $config);
	    $this->email->attach($atch);
			$this->email->set_newline("\r\n");
	    $this->email->from(user_email());
	    $this->email->to($dataresi->email); //email tujuan. Isikan dengan emailmu!
	    $this->email->subject('Konfirmasi '.$dataresi->nomor);
	    $this->email->message($the_message);

	    if($this->email->send())
	    {

	    }
	    else
	    {
	      //show_error($this->email->print_debugger());
	    }
			$whatsapp = $dataresi->whatsapp;
			$pesan1 = "Dear Customer Yth. ".$dataresi->kode.", \n\nMohon Konfirmasi ".$dataresi->nomor." Yang Telah kami Kirim.\n\nTerimakasih :)"."\n\n*Wilopo Cargo* _(do not reply)_";

	    sendwhatsapp($pesan1,$whatsapp);

			$this->session->set_flashdata('msg','success');
			redirect(site_url('admin/resi'));
		}

		//Function Update resi
    function delete(){
		 if($this->session->userdata('level')=="suadmin"){
			 // print_r($this->input->post('id_resi')); die("oke");
			 $idresi = $this->input->post('id_resi');
	   	 $this->db->where('id_resi',$idresi)->delete('resi');
			 $this->db->where('resi_id',$idresi)->delete('giw');
			 $this->session->set_flashdata('msg','deleted');
		 }else{
			 // die("not oke");
			 $this->session->set_flashdata('msg','gagal');
		 }
 		 redirect(site_url('admin/resi'));
    }

		function resend(){
			$id_resi = $this->uri->segment(4);
			// $nomor_resi=$this->uri->segment(4);
      $data_resi= $this->Mbarang->data_resiid($id_resi);
      foreach($data_resi->result() as $dresis ){
          $id_resi      =$dresis->id_resi;
					$nomor_resi      =$dresis->nomor;
          $kodem  =$dresis->kode;
          $supp  =$dresis->supplier;
          $supptel  =$dresis->tel;
          $eid  =$dresis->encrypt_resi;
          $email_customer  =$dresis->email;
					$whatsapp_customer  =$dresis->whatsapp;
          $vmail  =$dresis->validasi_email;
          $tgl_resi  =$dresis->tanggal;
					$id_pendaftar  =$dresis->id_pendaftar;
					$id_crm  =$dresis->id_crm;
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

	    if($vmail==20){
					echo "v";
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
	               <th colspan='8' style='height:28px;'> RECEIPT NO : ".$nomor_resi." (Revisi Data)</th>
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
			$pesan .= "Customer yth. *".$kodem."*,\nTanggal Resi : ".$tgl_resi."\nBarang Masuk *".$nomor_resi."* (Revisi Data): \n\n".$result."\n".$teks_khusus."\n".
								"*TOTAL: ".$tctns." ctn, ".$tqty." pcs, ".$tberat." kg, ".$tvolume." m3, ".$trmb." RMB*\n\nKlik tombol dibawah untuk konfirmasi packing list resi, jika tidak maka barang Anda belum kami loading ke container.";
		}else{
			$pesan .= "Customer yth. *".$kodem."*,\nTanggal Resi : ".$tgl_resi."\nBarang Masuk *".$nomor_resi."* (Revisi Data): \n\n".$result.
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
	  }

		redirect("admin/resi");
	}

	function pl(){
		$this->template->load('template','admin/resi/pl');
	}

	function get_pl_json() { 				//data data Customer by JSON object
    header('Content-Type: application/json');
    echo $this->Mresi->get_pl();
  }

	function view_packing()
	{
		cek_session_all();
		$id= $this->uri->segment(4);
		$record= $this->db->where('id_file_packing',$id)->get('file_packing')->row();

		include APPPATH. 'views/admin/resi/view_packing.php';
	}

	function upload_to_china(){
		$encrypt_resi = $this->input->post('encrypt_resi');
		$idresirts   = $this->encrypt_decryptrts('decrypt',$encrypt_resi);
		$get_pl = $this->db->where('encrypt_resi',$encrypt_resi)->get('file_packing')->result();
// 		$getfile = $this->db->select('file_packing.nomor_resi')->from('file_packing')->where('encrypt_resi',$encrypt_resi)->get()->row();
		$id_resi_rts = $this->db->select('resi.id_resi_rts')->from('resi')->where('id_resi_rts',$idresirts)->get()->row();
		foreach ($get_pl as $row_pl) {
			$nomor_resi = $row_pl->nomor_resi;
			$file_pl = $row_pl->file_pl;
			$curl_handle=curl_init();
			curl_setopt($curl_handle,CURLOPT_URL,"https://office.rtsekspedisi.com/api/a_resi/upload_plwc");
			curl_setopt($curl_handle, CURLOPT_POST, 1);
			curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "nomor_resi=$nomor_resi&file_pl=$file_pl");
			$curlemail = curl_exec($curl_handle);
			curl_close($curl_handle);

			$update_status_pl['status_proses'] = 1;
			$this->db->where('id_file_packing',$row_pl->id_file_packing)->update('file_packing',$update_status_pl);
		}
		//history resi
		$resi_id=@$id_resi_rts->id_resi_rts; 
		$container_id=0; 
		$date=date('Y-m-d'); 
		$status_giw_id=0;
		$tipe_resi=3; 
		$tipe_delay=0;
		$this->Mbarang->history_status($resi_id, $container_id, $date, $status_giw_id,$tipe_resi,$tipe_delay);
		//history resi
		
		$this->session->set_flashdata('msg','uploadok');
    redirect(site_url('admin/resi/pl'));
	}

	function upload_resi_to_china(){
		// Add Resi
		$nomor_resi = $this->input->post('nomor_resi');
		$get_request = $this->db->select('customer.*,request_resi.*')->from('request_resi')
														->join('customer', 'request_resi.id_cust=customer.id_cust')
														->where('kode_request',$nomor_resi)->get()->row();

		$note_request = $get_request->note.",".$get_request->jumlah_koli." ctns";
		if($get_request->gudang == "Ghuangzhou"){
			$userchina = 5;
		}else if($get_request->gudang == "Yiwu"){
			$userchina = 6;
		}
		$curl_handle1=curl_init();
		curl_setopt($curl_handle1,CURLOPT_URL,"https://office.rtsekspedisi.com/api/a_resi/add_upload_resi");
		curl_setopt($curl_handle1, CURLOPT_POST, 1);
		curl_setopt($curl_handle1, CURLOPT_POSTFIELDS, "tanggal_request=$get_request->tanggal_request&kode=$get_request->kode&supplier=$get_request->supplier&tel=$get_request->tel
																										&note=$note_request&note=$note_request&id_user=$userchina&id_request_resi=$get_request->id_request_resi");
		$curlresi = curl_exec($curl_handle1);
		curl_close($curl_handle1);
		$get_pl = $this->db->where('nomor_resi',$nomor_resi)->get('file_packing')->result();
		foreach ($get_pl as $row_pl) {
			$nomorresi = $row_pl->nomor_resi;
			$file_pl = $row_pl->file_pl;
			$curl_handle=curl_init();
			curl_setopt($curl_handle,CURLOPT_URL,"https://office.rtsekspedisi.com/api/a_resi/upload_plwcid");
			curl_setopt($curl_handle, CURLOPT_POST, 1);
			curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "id_request_resi=$get_request->id_request_resi&file_pl=$file_pl");
			$curlemail = curl_exec($curl_handle);
			curl_close($curl_handle);

			$update_status_pl['status_proses'] = 1;
			$this->db->where('id_file_packing',$row_pl->id_file_packing)->update('file_packing',$update_status_pl);
		}
		$this->session->set_flashdata('msg','uploadok');
    redirect(site_url('admin/resi/pl'));
	}

	function delete_pl(){
		$id = $this->uri->segment(4);
		$this->db->where('id_file_packing',$id)->delete('file_packing');
		$this->session->set_flashdata('msg','deleteplok');
    redirect(site_url('admin/resi/pl'));
	}

	function edit_barcode()
	{
		cek_session_all();
		$id= $this->uri->segment(4);
		$record= $this->db->where('id',$id)->get('giw')->row();
		$jenis_barang = $this->db->order_by('id','asc')->get('jenis_barang')->result();
		include APPPATH. 'views/admin/resi/edit_barcode.php';
	}

	function saveeditbarcode(){
		$potongan = "500000";
		$idgiw = $this->input->post('id');
		$data_barcode = $this->db->select('giw.*,customer.id_cgrup')->from('giw')
                             ->join('customer', 'giw.customer_id=customer.id_cust', 'left')
                             ->where('giw.id',$idgiw)->get()->row();
		$jalurr = $data_barcode->jalur;
		$id_cust = $data_barcode->customer_id;
    $id_cgrup = $data_barcode->id_cgrup;
		$id_jenis_barang = $this->input->post('id_jenis_barang');
    $updresi['status_ubah'] = 1;
    $this->db->where('id_resi',$data_barcode->resi_id)->update('resi',$updresi);

		$cekhargacustomer = $this->Mbarang->data_hbc($id_cust,$id_jenis_barang)->num_rows();
    $cekhargagrup     = $this->Mbarang->data_hbcg($id_cgrup,$id_jenis_barang)->num_rows();
		$dhb= $this->Mbarang->data_hb($id_jenis_barang)->row();
    if($id_cgrup > 0 && $cekhargagrup > 0){
      $dhbc = $this->Mbarang->data_hbcg($id_cgrup,$id_jenis_barang)->row();
      $harga_jual   = $dhbc->harga;
    }else if($cekhargacustomer > 0){
			$dhbc = $this->Mbarang->data_hbc($id_cust,$id_jenis_barang)->row();
			$harga_jual   = $dhbc->harga;
		}else{
			$harga_jual = $dhb->harga;
		}
    // sendwhatsapp("resi id ".$data_barcode->resi_id,"083815423599");
	  $hb	= $harga_jual;
		// dd($data_barcode->nomor);
		$qty = $this->input->post('qty');
		$nilai = $this->input->post('nilai');
		$curl_handle=curl_init();
		curl_setopt($curl_handle,CURLOPT_URL,"https://office.rtsekspedisi.com/api/a_resi/updategiwwc");
		curl_setopt($curl_handle, CURLOPT_POST, 1);
		curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "nomor_giw=$data_barcode->nomor&qty=$qty&nilai=$nilai");
		$curlemail = curl_exec($curl_handle);
		curl_close($curl_handle);

		$update_barcode['barang']=  $this->input->post('barang');
		$update_barcode['jenis_barang_id']= $id_jenis_barang;
		$update_barcode['harga']= $dhb->harga_rts - $potongan;
		$update_barcode['harga_jual']= $hb;
		$update_barcode['qty']=  $this->input->post('qty');
		$update_barcode['nilai']= $this->input->post('nilai');
		$update_barcode['berat']= $this->input->post('berat');
		$update_barcode['ctns']= $this->input->post('ctns');
		$update_barcode['volume']= $this->input->post('volume');

		$this->db->where('id',$idgiw);
		$this->db->update('giw', $update_barcode);
		$this->session->set_flashdata('msg','okeupdate');
		redirect($_SERVER['HTTP_REFERER']);
	}

	function savepesan_tolak(){
		$getcust = $this->db->where('kode',$this->input->post('kode'))->get('customer')->row();
		$getfile = $this->db->where('encrypt_resi',$this->input->post('encrypt_resi'))->get('file_packing')->row();
		$idresirts=$this->encrypt_decryptrts('decrypt',$this->input->post('encrypt_resi'));
// 		$getfilea = $this->db->select('file_packing.nomor_resi')->from('file_packing')->where('encrypt_resi',$this->input->post('encrypt_resi'))->get()->row();
		$id_resi_rts = $this->db->select('resi.id_resi_rts')->from('resi')->where('id_resi_rts',$idresirts)->get()->row();
		$real_code   = $this->encrypt_decrypt('encrypt',$this->input->post('kode'));
		$pesancust = "Dear $getcust->kode \n\n".
									$this->input->post('pesan_tolak').
									"\n,Silahkan upload invoice dan packing list anda di customer.wilopocargo.com/public_c/upload_pl/$getfile->encrypt_resi/$getfile->nomor_resi/$real_code".
									"\n\n*Wilopo Cargo* _(do not reply)_";
		sendwhatsapp($pesancust,$getcust->whatsapp);
		$this->db->where('encrypt_resi',$this->input->post('encrypt_resi'))->delete('file_packing');
		
		//history resi
		$resi_id=$id_resi_rts->id_resi_rts; 
		$container_id=0; 
		$date=date('Y-m-d'); 
		$status_giw_id=0;
		$tipe_resi=4; 
		$tipe_delay=0;
		$this->Mbarang->history_status($resi_id, $container_id, $date, $status_giw_id,$tipe_resi,$tipe_delay);
		//history resi
		
		$this->session->set_flashdata('msg','oketolak');
		redirect($_SERVER['HTTP_REFERER']);
	}

	function savepesan_tolakresi(){
		$getcust = $this->db->where('kode',$this->input->post('kode'))->get('customer')->row();
		$getfile = $this->db->where('nomor_resi',$this->input->post('nomor_resi'))->get('file_packing')->row();
		$real_code   = $this->encrypt_decrypt('encrypt',$this->input->post('kode'));
		$pesancust = "Dear $getcust->kode \n\n".
									$this->input->post('pesan_tolak').
									"\nSilahkan Input Kembali Data Request Resi Anda di Customer Dashboard".
									"\n\n*Wilopo Cargo* _(do not reply)_";
		sendwhatsapp($pesancust,$getcust->whatsapp);
		$this->db->where('nomor_resi',$this->input->post('nomor_resi'))->delete('file_packing');
		$this->db->where('kode_request',$this->input->post('nomor_resi'))->delete('request_resi');
		$this->session->set_flashdata('msg','oketolak');
		redirect($_SERVER['HTTP_REFERER']);
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

	function resi_asuransi(){
		$resi_asuransi = array();
		$get_resi_asuransi = $this->db->query('SELECT resi.id_resi,resi.nomor,customer.kode FROM resi
																					left join customer on resi.cust_id = customer.id_cust
																					where month(tanggal) = "8" and year(tanggal) = "2020"')->result();
		foreach($get_resi_asuransi as $gra){
			$total_asuransi= 0;
			$nilaibarangrpasu = array();
			$volumeasu        = array();
			$data_barcodes= $this->Mbarang->data_brcd($gra->id_resi);
			foreach($data_barcodes->result() as $dbar ){
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
					 }else{
							 $totalasuransi = 0;
					 }
				 $asrns_tambahan = round($totalasuransi);
				 if($asrns_tambahan > 0){
					 $resi_asuransi[] =  $gra->nomor.",".$gra->kode.",".number_format($asrns_tambahan);
				 }
		}
		dd($resi_asuransi);
	}

}
