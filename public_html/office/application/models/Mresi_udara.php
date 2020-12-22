<?php

class Mresi_udara extends CI_Model
{
  public function __construct(){
		parent::__construct();
    $this->load->model('Mapiinvoice');
    $this->load->model('Mbank');
    $this->load->model('Mpembayaran');
    $this->load->model('Mkomisi_referal');
	}

  function get_resi() {
    $this->datatables->select('resi_udara.id_resi_udara,resi_udara.nama_barang,resi_udara.id_invoice,resi_udara.nomor_resi,resi_udara.ctns,resi_udara.berat,resi_udara.harga_jual
                              ,resi_udara.harga_beli,resi_udara.harga_jual_goni,resi_udara.harga_beli_goni,resi_udara.tanggal_resi
                              ,customer.kode,invoice.kode_invoice');
    $this->datatables->from('resi_udara');
    $this->datatables->join('customer', 'resi_udara.id_cust=customer.id_cust');
    $this->datatables->join('invoice', 'resi_udara.id_invoice=invoice.id_invoice');
    if($this->session->userdata('level') == "crm"){
			$this->datatables->where('customer.id_crm',$this->session->userdata('id_pengguna'));
		}
    // $this->db->order_by('invoice.status_invoice','asc');
    $this->db->order_by('resi_udara.id_resi_udara','desc');
    $this->datatables->add_column('view', '<a href="'.site_url().'admin/resi_udara/invoice_detail/$2/$1/air" class="btn btn-info btn-xs" target="_blank"><i class="fa fa-ellipsis-h"></i></a>
                                           <a onclick="return confirm(`Delete Resi?`);" href="'.site_url().'admin/resi_udara/delete_resi/$1" class="btn btn-danger btn-xs"> <i class="fa fa-close"></i></a>
                                  ', 'id_resi_udara,id_invoice');

    return $this->datatables->generate();
  }

  function get_invoiceresi() {
    $this->datatables->select('invoice.id_invoice_beli,invoice.id_invoice,invoice.tipe_invoice,invoice.status_invoice,invoice.kode_invoice,invoice.tanggal_invoice,
                               invoice.total_tagihan,invoice.encrypt_invoice,invoice.jumlah_bayar,invoice.total_potongan,customer.id_cust,
                               customer.kode,customer.email,customer.deposit,customer_grup.kode_cgrup,customer_grup.id_cgrup,resi_udara.id_resi_udara');
    $this->datatables->from('invoice');
    $this->datatables->join('resi_udara', 'invoice.id_invoice=resi_udara.id_invoice');
    $this->datatables->join('customer', 'invoice.id_cust=customer.id_cust');
    $this->datatables->join('customer_grup', 'customer.id_cgrup=customer_grup.id_cgrup');
    $this->datatables->where('invoice.tipe_invoice','air');
    if($this->session->userdata('level') == "sales" || $this->session->userdata('level') == "saleso"){
      $this->datatables->where('id_pendaftar',$this->session->userdata('id_pengguna'));
    }else if($this->session->userdata('level') == "crm"){
      $this->datatables->where('id_crm',$this->session->userdata('id_pengguna'));
    }
    $q="$1";
    $this->db->order_by('invoice.status_invoice','asc');
    $this->datatables->add_column('mark_transaksi', '$1','kode_mark_transaksi(id_cust,id_cgrup,kode,kode_cgrup)');
    $this->datatables->add_column('view', '

      <div class="btn-group">
        <button type="button" class="btn btn-success btn-xs"><i class="fa fa-envelope"></i></button>
        <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown">
          <span class="caret"></span>
          <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" role="menu">

          <li><a href="'.base_url().'admin/sendmail/resi_invoice/$1" class="submitt">
           Mail Invoice</a></li>

          <li><a href="'.base_url().'admin/sendmail/resi_payment/$1" class="submitt">
           Mail Payment</a></li>

       </ul>
     </div>

      <div class="btn-group">
        <button type="button" class="btn btn-danger btn-xs"><i class="fa fa-print"></i></button>
        <button type="button" class="btn btn-danger btn-xs dropdown-toggle" data-toggle="dropdown">
          <span class="caret"></span>
          <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" role="menu">

          <li><a href="'.base_url().'admin/public_c/invoice_udara/$1" target="_blank">
          Invoice</a></li>

          <li><a href="'.base_url().'admin/public_c/payment_udara/$1" target="_blank">
          Paid</a></li>

        </ul>
      </div>

      <a href="javascript:void(0);" class="lunas_inv btn btn-warning btn-xs" data-id_invoice="$1" data-kode_invoice="$2" data-total_tagihan="$4"
        data-status_invoice="$3" data-jumlah_bayar="$7" data-deposit="$5" data-total_potongan="$8" data-kode="$6">
        <i class="fa fa-credit-card"></i></a>

      <a href="javascript:void(0);" onclick="bayar_deposit('.$q.')" class="btn btn-warning btn-xs" alt="deposit"><i class="fa fa-money"></i></a>

      <a href="'.site_url().'admin/resi_udara/invoice_detail/$1/$9/air" class="btn btn-info btn-xs" target="_blank"><i class="fa fa-ellipsis-h"></i></a>',

      'id_invoice,kode_invoice,status_invoice,total_tagihan,deposit,kode,jumlah_bayar,total_potongan,id_resi_udara');
    return $this->datatables->generate();
  }

  function select_vendor(){
    return $this->db->get('vendor');
  }

  function getresiinv(){
    return $this->db->select('resi_udara.*,invoice.*,customer.*,invoice_beli.*')
                    ->from('resi_udara')
                    ->join('customer', 'resi_udara.id_cust=customer.id_cust')
                    ->join('invoice', 'resi_udara.id_invoice=invoice.id_invoice')
                    ->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
                    ->where('invoice.id_invoice',0)
                    ->get();
  }

  function getresiinvid($id){
    return $this->db->select('resi_udara.*,invoice.*,customer.*,invoice_beli.*')
             ->from('resi_udara')
             ->join('customer', 'resi_udara.id_cust=customer.id_cust')
             ->join('invoice', 'resi_udara.id_invoice=invoice.id_invoice')
             ->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
             ->where('resi_udara.id_resi_udara',$id)
             ->get();
  }

  function getresiinvidinv($id){
    return $this->db->select('resi_udara.*,invoice.*,customer.*,customer_grup.*,invoice_beli.*')
             ->from('resi_udara')
             ->join('customer', 'resi_udara.id_cust=customer.id_cust')
             ->join('customer_grup', 'customer.id_cgrup=customer_grup.id_cgrup', 'left')
             ->join('invoice', 'resi_udara.id_invoice=invoice.id_invoice')
             ->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
             ->where('resi_udara.id_invoice',$id)
             ->get();
  }

  function getnomorresi(){
     $tahun_sekarang = date('y');
     $cekkode= $this->db->query("SELECT SUBSTRING(nomor_resi,8,50) as nomor FROM resi_udara WHERE SUBSTRING(nomor_resi,5,2) = '$tahun_sekarang' ORDER BY id_resi_udara DESC LIMIT 1")->result();
     foreach($cekkode as $hcekkode);
     $ambilkode= $hcekkode->nomor;
     if($ambilkode=="" || $ambilkode==0)
     {
      $ambilkode=0;
     }
     $kodejadi= $ambilkode+1;
     return 'AIR/'.$tahun_sekarang.'/'.$kodejadi;
  }

  // Data Invoice
  function data_invoice($id){
    $this->db->select('invoice.*,customer_grup.*,customer.*');
    $this->db->from('invoice');
    $this->db->join('customer_grup', 'invoice.id_cgrup=customer_grup.id_cgrup', 'left');
    $this->db->join('customer', 'invoice.id_cust=customer.id_cust', 'left');
    $this->db->where('invoice.id_invoice',$id, 'left');
    //$param = array('id_order'=>$id);
    return $this->db->get('');
  }

  // Get Kode
  function kode_invoiceresi(){
    $hcekkode= $this->db->select('kode_invoice as maxkode')->where('tipe_invoice','air')->order_by('id_invoice','desc')->get('invoice')->row();
		$kodesaatini= $hcekkode->maxkode;
		$ambilkode= str_replace('INVOICE/AIR/','',$kodesaatini);
	  if($ambilkode=="")
		{
		 $ambilkode=0;
		}
		$kodejadi= $ambilkode;

		$hasil= $kodejadi;
		return $hasil;
  }

  // Get Kode
  function kode_beli(){
    $hcekkode= $this->db->select('kode_invoice_beli as maxkode')->where('id_vendor',1)->order_by('id_invoice_beli','desc')->get('invoice_beli')->row();
		$kodesaatini= $hcekkode->maxkode;
		$ambilkode= str_replace('BELI/AIR/','',$kodesaatini);
	  if($ambilkode=="")
		{
		 $ambilkode=0;
		}
		$kodejadi= $ambilkode;

		$hasil= $kodejadi;
		return $hasil;
  }

  // Get name Category
  function getnamecategory($id){
     $getcode = $this->db->where("id_kategori_il",$id)->from('kategori_il')->get()->row();
     $namaktgr= $getcode->nama_kategori_il;//print_r($namaktgr);die();
     return $namaktgr;
  }

  function save(){
    //Insert Resi Udara
    $insertresi['id_cust'] = $this->input->post('kode');
    $insertresi['nomor_resi']= $this->input->post('nomor_resi');
    $insertresi['nama_barang']= $this->input->post('nama_barang');
    $insertresi['ctns']= $this->input->post('ctns');
    $insertresi['berat']=$this->input->post('berat');
    if($this->input->post('berat') < 3){
      $insertresi['berat_pembulatan']=3;
    }else{
      $insertresi['berat_pembulatan']=$this->input->post('berat');
    }
    $insertresi['tanggal_resi']=date('Y-m-d',strtotime($this->input->post('tanggal_resi')));;
    $insertresi['harga_jual']=$this->input->post('harga_jual');
    $insertresi['harga_beli']=$this->input->post('harga_beli');
    $insertresi['harga_jual_goni']=$this->input->post('harga_jual_goni');
    $insertresi['harga_beli_goni']=$this->input->post('harga_beli_goni');
    $insertresi['harga_ekspedisi_lokal']= 0;
    $this->db->insert('resi_udara', $insertresi);

    $getcustomer = $this->db->select('customer.*,customer_grup.*')
                            ->from("customer")
                            ->where('customer.id_cust',$insertresi['id_cust'])
                            ->join('customer_grup', 'customer.id_cgrup=customer_grup.id_cgrup', 'left')
                            ->get()->row();
    if($getcustomer->id_cgrup > 0){
       $mail_cust         =$getcustomer->email_cgrup;
       $whatsapp          =$getcustomer->whatsapp_cgrup;
    }else{
       $mail_cust         =$getcustomer->email;
       $whatsapp          =$getcustomer->whatsapp;
    }

    $pesan =  "*Yth. Bpk/Ibu ".$getcustomer->nama."(".$getcustomer->kode.")*".
              "\n\nTanggal Resi : ".date_indo($insertresi['tanggal_resi']).
              "\nNomor Resi : ".$insertresi['nomor_resi'].
              "\n".$insertresi['nama_barang'].",\n".$insertresi['ctns']." ctns, ".$insertresi['berat']." kg\n\nTerima kasih atas kerja samanya :)".
              "\n*Wilopo Cargo* _(do not reply)_";

    sendwhatsapp($pesan,"081310961108");
    sendwhatsapp($pesan,$whatsapp);

    $the_message="<html>
                         <body>
                                 <h3>Yth. Bpk/Ibu ".$getcustomer->nama." (".$getcustomer->kode."),</h3>
                                 <p>Kami telah menerima barang Anda di Gudang Kami, Berikut adalah detail resi pengiriman Anda.</p>
                                 <p>Tanggal Resi : ".date_indo($insertresi['tanggal_resi'])."<br /> Nomor Resi : ".$insertresi['nomor_resi']."<br />"
                                 .$insertresi['nama_barang'].",<br />".$insertresi['ctns']."ctns,".$insertresi['berat']." kg</p>
                                 <p>".nama_perusahaan2()."</p>

                         </body>
                   </html>";
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
    $this->email->to("gusmavin@gmail.com",$mail_cust); //email tujuan. Isikan dengan emailmu!
    $this->email->subject('[Wilopo Cargo] Barang Masuk : '.$insertresi['nomor_resi']);
    $this->email->message($the_message);

    if($this->email->send())
    {

    }
    else
    {
      //show_error($this->email->print_debugger());
    }

    redirect('admin/resi_udara');
  }

  function generate_invoice(){
    // print_r($this->kode_invoiceresi());die();
    $idresi    = $this->input->post('id_resi_udara');
    $resiudara = $this->db->select('resi_udara.*,customer.*,customer_grup.*')
                          ->where_in('id_resi_udara',$idresi)
                          ->from('resi_udara')
                          ->join('customer', 'resi_udara.id_cust=customer.id_cust')
                          ->join('customer_grup', 'customer.id_cgrup=customer_grup.id_cgrup', 'left')
                          ->get()->result();
    // print_r($resiudara);die();
    $no = 1;
    $getkurs = $this->db->where('id_kurs',1)->get('kurs')->row();
    $komisi_global_udara = $getkurs->komisi_udara;
    foreach ($resiudara as $row) {
      if($row->id_cust == 64){
        $beratudara = $row->berat;
      }else{
        $beratudara = $row->berat_pembulatan;
      }
      if($row->id_cgrup > 0){
         $mail_cust         =$row->email_cgrup;
         $whatsapp          =$row->whatsapp_cgrup;
      }else{
         $mail_cust         =$row->email;
         $whatsapp          =$row->whatsapp;
      }
      $total_jual_kubikasi = 0;
      $total_beli_kubikasi = 0;
      if($row->berat_kubikasi > 0){
        $total_jual_kubikasi = $row->berat_kubikasi * ($row->harga_jual/2);
        $total_beli_kubikasi = $row->berat_kubikasi * ($row->harga_beli/2);
      }
      // kode
      $kode = $this->kode_invoiceresi()+$no;
      $kodebeli = $this->kode_beli()+$no;
      // Generate Invoice BELI
      $insert_inv['kode_invoice_beli']= 'BELI/AIR/'.$kodebeli;
      $insert_inv['note_invoice_beli']= "AIR";
      $insert_inv['id_cust']          = $row->id_cust;
      $insert_inv['id_vendor']        = 1;
      $insert_inv['tanggal_invoice_beli']= date('Y-m-d');
      $insert_inv['status_invoice_beli']= 1;
      $insert_inv['jumlah_invoice_beli']= ($row->harga_beli * $row->berat) + ($row->harga_beli_goni * $row->ctns) + $row->harga_ekspedisi_lokal + $total_beli_kubikasi ;
      $insert_inv['jumlah_bayar_invoice_beli']= 0;
      $this->db->insert('invoice_beli', $insert_inv);
      $inv_beli = $this->db->insert_id();

      //Generate Invoice
      $invoice['id_invoice_beli'] = $inv_beli;
      $invoice['id_cust']         = $row->id_cust;
      $invoice['id_cgrup']        = 0;
      $invoice['id_vendor']       = 1;
      $invoice['kode_invoice']    = 'INVOICE/AIR/'.$kode ;
      $invoice['tanggal_invoice'] = date('Y-m-d');
      $invoice['tipe_invoice']    = "air";
      $invoice['encrypt_invoice'] = md5($invoice['kode_invoice']);
      $invoice['status_invoice']  = 0;
      $invoice['total_tagihan']   = round(($row->harga_jual * $beratudara) + ($row->harga_jual_goni * $row->ctns) + $row->harga_ekspedisi_lokal) + $total_jual_kubikasi;
      $this->db->insert('invoice', $invoice);
      $last_id_invoice = $this->db->insert_id();

      $resi_udara['id_invoice']   = $last_id_invoice;
      $this->db->where('id_resi_udara',$row->id_resi_udara)->update('resi_udara',$resi_udara);

      $chargetambahan['id_invoice'] =$last_id_invoice;
      $chargetambahan['id_jenis_potongan'] = "17";
      $chargetambahan['jumlah_potongan'] = $total_jual_kubikasi;
      $chargetambahan['keterangan_potongan'] = "Berat Kubikasi ".$row->berat_kubikasi." Kg";
      // print_r($chargetambahan['jumlah_potongan']);
      $this->db->insert('potongan',$chargetambahan);

      if($row->id_referal > 0){
				$get_referal = $this->db->where('id_cust',$row->id_cust)->get('customer')->row();
				if($get_referal->komisi_udara == 0){
					$komisifix = $komisi_global_udara * $beratudara;
					$ket_komisi = "Komisi Referal Global : ".$komisi_global_udara." * Berat : ".$beratudara;
				}else{
					$komisifix = $get_referal->komisi_udara * $beratudara;
					$ket_komisi = "Komisi Referal Khusus : ".$get_referal->komisi_udara." * Berat : ".$beratudara;
				}
				$input_referal['id_cust'] = $row->id_referal;
				$input_referal['kode_komisi'] = $this->Mkomisi_referal->kode_komisi();
				$input_referal['customer'] = $row->kode;
				$input_referal['id_invoice'] = $last_id_invoice;
				$input_referal['nilai'] = $komisifix;
				$input_referal['keterangan'] = $ket_komisi;
				$input_referal['status'] = 1;
				// input
				$this->db->insert('komisi_referal', $input_referal);
			}

      $cekresi = $this->db->select('resi_udara.*,invoice.*,customer.*,invoice_beli.*')
  										->from('resi_udara')
  										->join('customer', 'resi_udara.id_cust=customer.id_cust')
  										->join('invoice', 'resi_udara.id_invoice=invoice.id_invoice')
  										->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
  										->where('invoice.id_invoice',0)
  										->where('resi_udara.id_cust',$row->id_cust)
  										->get();

      $rowresi = $cekresi->row();

      if($cekresi->num_rows() > 0){
        $pesangudang  = "Informasi Alamat ".$row->nomor_resi."\n".$row->kode."\n".$row->nama."\n".
                  "".$row->whatsapp."\n\n".$row->alamat.','.$row->ekspedisi_lokal;
        whatsapp_grup("1597199755",$pesangudang,"6281310961108");
        $updresud['wa_grup'] = 1;
        $this->db->where('nomor_resi',$row->nomor_resi)->update('resi_udara',$updresud);
      }

      $tst['status']=0;
			$tst['r']= $this->getresiinvid($row->id_resi_udara)->row();
      $data = $this->load->view('admin/resi_udara/pdf_invoice',$tst,True);
      $mpdf = new \Mpdf\Mpdf();

      //$data = $this->load->view('hasilPrint', [], TRUE);
      $mpdf->WriteHTML($data);
			$mpdf->Output("pdf_file/".time()."pay.pdf" ,'F');
			$time=time()."pay.pdf";
      $content = "";
      $content = $mpdf->Output('', 'S');

      $pesan ="*Yth. Bpk/Ibu ".$row->nama." (".$row->kode.")*\n\nBerikut kami lampirkan Invoice Resi Barang Udara ".$invoice['kode_invoice']." yang harus Anda bayar, yaitu sebesar *Rp.".number_format($invoice['total_tagihan']).
 		 					"* ke rekening berikut:\n\n*BCA 5810557747 a/n Gusmavin Willopo*\n\nSetelah melakukan pembayaran, harap melakukan konfirmasi pembayaran dengan menghubungi kami melalui telepon / WA.\nTerima kasih atas kerja samanya :)".
 							"\n\n*Wilopo Cargo* _(do not reply)_";

      sendwhatsapp($pesan,$whatsapp);
      $sendoc_resi = send_newdoc($time,$whatsapp,$invoice['kode_invoice']);

      sendwhatsapp($pesan,"081310961108");
      $sendoc_resi = send_newdoc($time,"081310961108",$invoice['kode_invoice']);

      $the_message="<html>
                           <body>
                                   <h3>Yth. Bpk/Ibu ".$row->nama." (".$row->kode.") ,</h3>
                                   <p>Berikut terlampir Invoice Resi Barang Udara <b>".$invoice['kode_invoice']."</b> yang harus Anda bayar, yaitu sebesar Rp.".number_format($invoice['total_tagihan'])." ke rekening berikut:</p>
                                   <p><b>BCA 5810557747 a/n Gusmavin Willopo</b></p>
                                   <p>Setelah melakukan pembayaran, harap melakukan konfirmasi pembayaran dengan menghubungi kami melalui telepon / WA.</p>
                                   <p>".nama_perusahaan()."</p>

                           </body>
                     </html>";
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
      $this->email->attach($content, 'attachment', $invoice['kode_invoice'] , 'application/pdf');
      $this->email->set_newline("\r\n");
      $this->email->from(user_email());
      $this->email->to("gusmavin@gmail.com",$mail_cust); //email tujuan. Isikan dengan emailmu!
      $this->email->subject('[Wilopo Cargo] Air '.$invoice['kode_invoice']);
      $this->email->message($the_message);

      if($this->email->send())
      {
        if($sendoc_resi){

        }
      }
      else
      {
        //show_error($this->email->print_debugger());
      }
      $no++;
    }

    redirect('admin/resi_udara/gen_invoice');
  }

  function update(){
    //Insert Resi Udara
    $updateresi['nama_barang']= $this->input->post('nama_barang');
    $updateresi['ctns']= $this->input->post('ctns');
    $updateresi['berat']=$this->input->post('berat');
    if($this->input->post('berat') < 3){
      $updateresi['berat_pembulatan']=3;
    }else{
      $updateresi['berat_pembulatan']=$this->input->post('berat');
    }
    $updateresi['tanggal_resi']=date('Y-m-d',strtotime($this->input->post('tanggal_resi')));;
    $updateresi['harga_jual'] = $this->input->post('harga_jual');
    $updateresi['harga_beli'] = $this->input->post('harga_beli');
    $updateresi['harga_jual_goni'] = $this->input->post('harga_jual_goni');
    $updateresi['harga_beli_goni'] = $this->input->post('harga_beli_goni');
    $updateresi['harga_ekspedisi_lokal'] = $this->input->post('harga_ekspedisi_lokal');
    $this->db->where('id_resi_udara',$this->input->post('id_resi_udara'))->update('resi_udara', $updateresi);

    if($this->input->post('id_cust') == 64){
      $beratudara = $updateresi['berat'];
    }else{
      $beratudara = $updateresi['berat_pembulatan'];
    }

    if($this->input->post('id_invoice') != 0 && $this->input->post('id_invoice_beli') != 0){
      $cek_invoice = $this->db->where('id_invoice',$this->input->post('id_invoice'))->get('invoice')->row();
      // Update Invoice Beli
      $insert_inv['jumlah_invoice_beli'] = $updateresi['harga_ekspedisi_lokal'] + ($updateresi['harga_beli'] * $updateresi['berat']) + ($updateresi['harga_beli_goni'] * $updateresi['ctns']);
      $this->db->where('id_invoice_beli',$this->input->post('id_invoice_beli'))->update('invoice_beli', $insert_inv);
      // Update Invoice Jual
      if($cek_invoice->status_invoice == 0){
        $invoice['total_tagihan']    = $updateresi['harga_ekspedisi_lokal'] + ($updateresi['harga_jual'] * $beratudara) + ($updateresi['harga_jual_goni'] * $updateresi['ctns']);
        $this->db->where('id_invoice',$this->input->post('id_invoice'))->update('invoice', $invoice);
      }else{

      }
    }
    // print_r($updateresi['harga_ekspedisi_lokal']."<br />".$invoice['total_tagihan']);die();
    redirect('admin/resi_udara/invoice_detail/'.$this->input->post('id_invoice').'/'.$this->input->post('id_resi_udara').'/air');
  }

  function data_sub_pembayaran($id){
    $this->db->select('sub_pembayaran.*,invoice.*,pembayaran.*');
    $this->db->from('sub_pembayaran');
    $this->db->join('invoice', 'sub_pembayaran.id_invoice=invoice.id_invoice', 'left');
    $this->db->join('pembayaran', 'sub_pembayaran.id_pembayaran=pembayaran.id_pembayaran', 'left');
    $this->db->where('sub_pembayaran.id_invoice',$id, 'left');

    //$param = array('id_order'=>$id);
    return $this->db->get();
  }

  function data_potongan($id){
    $this->db->select('potongan.*,invoice.*,jenis_potongan.*');
    $this->db->from('potongan');
    $this->db->join('invoice', 'potongan.id_invoice=invoice.id_invoice', 'left');
    $this->db->join('jenis_potongan', 'potongan.id_jenis_potongan=jenis_potongan.id_jenis_potongan', 'left');
    $this->db->where('potongan.id_invoice',$id, 'left');

    //$param = array('id_order'=>$id);
    return $this->db->get('');
  }

  function pinvoice($data)
{
    $data_kurs= $this->data_invoice($this->input->post('id_invoice'));
    foreach($data_kurs->result() as $krs ){

      $marking=$krs->kode;
      $ttl_tagihan=$krs->total_tagihan;
      $jml_bayar=$krs->jumlah_bayar;
      $jmlh_potongan=$krs->total_potongan;
      $email=$krs->email;
      $nama=$krs->nama;
      $ei=$krs->encrypt_invoice;
      $id_cust=$krs->id_cust;
      $id_cgrup = $krs->id_cgrup;
      $id_referal = $krs->id_referal;
      $email_customer=$krs->email;
      $egrup=$krs->email_cgrup;
      $kfid=$krs->konfirmasi_resi;
      $whatsapp_customergrup=$krs->whatsapp_cgrup;
      $whatsapp_customer=$krs->whatsapp;
    }

    if($id_cgrup > 0){
       $whatsappaktif = $whatsapp_customergrup;
       $status_invoice="grup";
       $emailaktif= $egrup;
       $cust_id = 0;
    }else if($id_cgrup <= 0){
       $whatsappaktif = $whatsapp_customer;
       $status_invoice="customer";
       $emailaktif= $email;
       $cust_id = $id_cust;

    }

      $total_bayar=($ttl_tagihan-$jml_bayar)-$jmlh_potongan;

      $data_bank= $this->Mbank->get_dbank($this->input->post('id_bank'));
      foreach($data_bank->result() as $dbank ){
       $sbank    =$dbank->saldo_bank;
      }
    //data Pembayaran
    $pembayaran['id_cust'] = $cust_id;
    $pembayaran['id_cgrup'] = $id_cgrup;
    $pembayaran['kode_pembayaran'] = $this->Mpembayaran->code_pembayaran();
    $pembayaran['tanggal_bayar'] = date('Y-m-d');
    $pembayaran['jumlah_bayar']  = $total_bayar;
    $pembayaran['total_dibayar'] = $ttl_tagihan;
    $this->db->insert('pembayaran', $pembayaran);
    $last_id = $this->db->insert_id();

    $trb['id_jenis_transaksi_bank'] = 1;
    $trb['id_bank'] = $this->input->post('id_bank');
    $trb['tipe_transaksi_bank'] = "masuk";
    $trb['nominal_transaksi_bank'] = $pembayaran['jumlah_bayar'];
    $trb['keterangan_transaksi_bank'] = "Penambahan Saldo dari Pembayaran Invoice ".$this->input->post('kode_invoice');
    $trb['tanggal_transaksi_bank'] = date('Y-m-d');
    $trb['sisa_saldo_bank'] = $sbank + $pembayaran['jumlah_bayar'];
    $this->db->insert('transaksi_bank', $trb);

    $bank['saldo_bank'] = $trb['sisa_saldo_bank'];
    $bank['edit_saldo'] = 1;
    $this->db->where('id_bank',$this->input->post('id_bank'));
    $this->db->update('master_bank', $bank);

    $kpmbyrn2['id_pembayaran'] =$last_id;
    $kpmbyrn2['keterangan_pembayaran'] = "Untuk pelunasan pembayaran invoice ".$this->input->post('kode_invoice')." Sebesar Rp.".number_format($pembayaran['jumlah_bayar']);
    $this->db->insert('keterangan_pembayaran', $kpmbyrn2);

    $subbayar['id_invoice'] = $this->input->post('id_invoice');
    $subbayar['id_pembayaran'] = $last_id;
    $subbayar['jumlah_bayar_sub'] = $pembayaran['jumlah_bayar'];
    $this->db->insert('sub_pembayaran', $subbayar);

    $inv['jumlah_bayar'] =$ttl_tagihan-$jmlh_potongan;
    $inv['status_invoice'] =1;

    $this->db->where('id_invoice',$this->input->post('id_invoice'));
    $this->db->update('invoice', $inv);

    $getresiudr = $this->db->where('id_invoice',$this->input->post('id_invoice'))->get('resi_udara')->row();
    if($getresiudr->wa_grup == 0){
      $pesangudang  = "Informasi Alamat ".$getresiudr->nomor_resi."\n".$getresiudr->kode."\n".$getresiudr->nama."\n".
                "".$getresiudr->whatsapp."\n\n".$getresiudr->alamat.','.$getresiudr->ekspedisi_lokal;
      whatsapp_grup("1597199755",$pesangudang,"6281310961108");
      $updresud['wa_grup'] = 1;
      $this->db->where('nomor_resi',$getresiudr->nomor_resi)->update('resi_udara',$updresud);
    }

    if($id_referal != 0){
      $data_komisi  = $this->db->where('id_invoice',$this->input->post('id_invoice'))->get('komisi_referal');
      $get_komisi   = $data_komisi->row();
      $deposit_ref  = $this->db->where('id_cust',$id_referal)->get('customer')->row();

      $update_komisi['status'] = 2;
      $this->db->where('id_invoice',$this->input->post('id_invoice'));
      $this->db->update('komisi_referal', $update_komisi);
      if($data_komisi->num_rows() > 0){
        $dpst['id_cust']  = $id_referal;
        $dpst['id_cgrup'] = 0;
        $dpst['nominal_deposit'] = $get_komisi->nilai ;
        $dpst['tipe_deposit'] ="masuk";
        $dpst['keterangan_deposit'] =$get_komisi->kode_komisi ." cair (".$get_komisi->keterangan.")";
        $dpst['tanggal_deposit'] = date('Y-m-d');
        $this->db->insert('deposit', $dpst);

        $customer['deposit'] =$deposit_ref->deposit + $get_komisi->nilai;
        $this->db->where('id_cust',$id_referal);
        $this->db->update('customer', $customer);
      }
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

          $ki     = $this->input->post('kode_invoice');
          $encrypt= $ei;
          $id     = $this->input->post('id_invoice');

          $tst['status']=1;
          $tst['r']= $this->getresiinvidinv($id)->row();
          $data = $this->load->view('admin/resi_udara/pdf_invoice',$tst,True);

          $mpdf = new \Mpdf\Mpdf();
          $mpdf->WriteHTML($data);
          $mpdf->Output("pdf_file/".time()."pay.pdf" ,'F');
    			$time=time()."pay.pdf";
          $content = $mpdf->Output('', 'S');
          $this->load->library('email', $config);
          $this->email->attach($content, 'attachment', $ki , 'application/pdf');

          $pesan = "*Yth. Bpk/Ibu ".$nama." (".$marking.")*\n\nTerima kasih telah melakukan pembayaran \nBerikut kami lampirkan Invoice Terbayar ".$ki.
    							 "\nBarang anda akan segera kami kirim ke alamat anda.\nTerima kasih atas kerja samanya :)".
    							 "\n\n*Wilopo Cargo* _(do not reply)_";

    			sendwhatsapp($pesan,$whatsappaktif);
    	 		$sendoc_cust = send_newdoc($time,$whatsappaktif,$ki);

          $the_message="<html>
                               <body>
                                       <h3>Yth. Bpk/Ibu  ".$marking." ,</h3>
                                       <p>Terima kasih telah melakukan pembayaran untuk ".$ki." , Berikut kami lampirkan Invoice Terbayar.
                                       Barang anda akan segera kami kirim ke alamat anda</p>
                                       <p>".nama_perusahaan()."</p>
                               </body>
                         </html>";

  //$this->load->library('email', $config);
  $this->email->set_newline("\r\n");
  $this->email->from(user_email());
  $this->email->to("gusmavin@gmail.com",$emailaktif); //email tujuan. Isikan dengan emailmu!
  $this->email->subject('[Wilopo Cargo] Payment Invoice '.$ki);
  $this->email->message($the_message);
  if($this->email->send())
  {
    // print_r($krs->kode);die();
  }
  else
  {
    // print_r($krs->kode);die();
  }

    $this->session->set_flashdata('msg','invoiceok');
    redirect(site_url('admin/resi_udara'));


}



function invdeposit($data)
{
    $data_kurs= $this->data_invoice($this->input->post('id_invoice'));

      foreach($data_kurs->result() as $krs ){
          $kode=$krs->kode;
          $id_resi=$krs->id_resi;
          $ttl_tagihan=$krs->total_tagihan;
          $jml_bayar=$krs->jumlah_bayar;
          $jmlh_potongan=$krs->total_potongan;
          $email=$krs->email;
          $ei=$krs->encrypt_invoice;
          $id_cust=$krs->id_cust;
          $id_cgrup = $krs->id_cgrup;
          $email_customer=$krs->email;
          $egrup=$krs->email_cgrup;
          // $kfid=$krs->konfirmasi_resi;
          $whatsapp_customergrup=$krs->whatsapp_cgrup;
          $whatsapp_customer=$krs->whatsapp;
          $deposit_customer = $krs->deposit;
          $deposit_cgrup = $krs->deposit_cgrup;
        }

        if($id_cgrup > 0){
           $whatsappaktif = $whatsapp_customergrup;
           $status_invoice="grup";
           $emailaktif= $egrup;
           $deposit = $deposit_cgrup;
        }else if($id_cgrup <= 0){
           $whatsappaktif = $whatsapp_customer;
           $status_invoice="customer";
           $emailaktif= $email;
           $deposit = $deposit_customer;
        }


      $jmlbyr = $ttl_tagihan - ($jml_bayar + $jmlh_potongan);

      if($deposit >= $jmlbyr){

        //sub bayar ganti total potongan

        $potongan['id_invoice'] = $this->input->post('id_invoice');
        $potongan['id_jenis_potongan'] = 1;
        $potongan['jumlah_potongan'] = $jmlbyr;
        $potongan['keterangan_potongan'] = "Potongan Untuk Invoice Udara";

        $this->db->insert('potongan', $potongan);

        $inv['total_potongan'] = $ttl_tagihan - $jml_bayar;
        $inv['status_invoice'] =1;

        $this->db->where('id_invoice',$this->input->post('id_invoice'));
        $this->db->update('invoice', $inv);

        if($id_cgrup > 0){
           $customer_grup['deposit_cgrup'] =$deposit - $jmlbyr;
           $this->db->where('id_cust',$id_cust);
           $this->db->update('customer_grup', $customer_grup);

           $dpst['id_cust'] =0;
           $dpst['id_cgrup'] =$id_cgrup;
        }else if($id_cgrup <= 0){
           $customer['deposit'] =$deposit - $jmlbyr;
           $this->db->where('id_cust',$id_cust);
           $this->db->update('customer', $customer);
           $dpst['id_cust'] =$id_cust;
           $dpst['id_cgrup'] =0;
        }

        $getresiudr = $this->db->where('id_invoice',$this->input->post('id_invoice'))->get('resi_udara')->row();
        if($getresiudr->wa_grup == 0){
          $pesangudang  = "Informasi Alamat ".$getresiudr->nomor_resi."\n".$getresiudr->kode."\n".$getresiudr->nama."\n".
                    "".$getresiudr->whatsapp."\n\n".$getresiudr->alamat.','.$getresiudr->ekspedisi_lokal;
          whatsapp_grup("1597199755",$pesangudang,"6281310961108");
          $updresud['wa_grup'] = 1;
          $this->db->where('nomor_resi',$getresiudr->nomor_resi)->update('resi_udara',$updresud);
        }

        // $dpst['id_cust'] =$id_cust;
        $dpst['nominal_deposit'] =$jmlbyr;
        $dpst['tipe_deposit'] ="keluar";
        $dpst['keterangan_deposit'] ="Pemotongan Deposit Untuk Pelunasan Pembayaran Invoice ".$this->input->post('kode_invoice');

        $this->db->insert('deposit', $dpst);

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


          $kc     = $kode;
          $ki     = $this->input->post('kode_invoice');
          $encrypt= $ei;
          $id     = $this->input->post('id_invoice');


          $tst['status']=1;
          $test['record']= $this->data_invoice($id)->row();
          $test['item']= $this->item_inv($id)->result();
          $data = $this->load->view('admin/resi_udara/pdf_invoice',$test,True);

          $mpdf = new \Mpdf\Mpdf();


    //$data = $this->load->view('hasilPrint', [], TRUE);
    $mpdf->WriteHTML($data);
    $mpdf->Output("pdf_file/".time()."pay.pdf" ,'F');
    $time=time()."pay.pdf";
    $content = $mpdf->Output('', 'S');
    $this->load->library('email', $config);
    $this->email->attach($content, 'attachment', $ki , 'application/pdf');
    $path_unlink = './'.'Payment_TT_Wilopo.pdf';

    $pesan = "*Yth. Bpk/Ibu ".$nama." (".$kc.")*\n\nTerima kasih telah melakukan pembayaran \nBerikut kami lampirkan Invoice Terbayar ".$ki.
						 "\nBarang anda akan segera kami kirim ke alamat anda.\nTerima kasih atas kerja samanya :)".
						 "\n\n*Wilopo Cargo* _(do not reply)_";

		sendwhatsapp($pesan,$whatsappaktif);
 		$sendoc_cust = send_newdoc($time,$whatsappaktif,$ki);
    //unlink($path_unlink );
    $the_message="<html>
                         <body>
                                 <h3>Yth. Bpk/Ibu  ".$kc." ,</h3>
                                 <p>Terima kasih telah melakukan pembayaran untuk ".$ki." , Berikut kami lampirkan Invoice Terbayar.
                                 Barang anda akan segera kami kirim ke alamat anda</p>
                                 <p>".nama_perusahaan()."</p>
                         </body>
                   </html>";
  //$this->load->library('email', $config);
  $this->email->set_newline("\r\n");
  $this->email->from(user_email());
  $this->email->to($emailaktif); //email tujuan. Isikan dengan emailmu!
  $this->email->subject('[Wilopo Cargo] Payment '.$ki);
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

      }else if($deposit < $jmlbyr){

    $potongan['id_invoice'] = $this->input->post('id_invoice');
    $potongan['id_jenis_potongan'] = 2;
    $potongan['jumlah_potongan'] = $deposit;
    $potongan['keterangan_potongan'] = "Pembayaran dengan deposit";

    $this->db->insert('potongan', $potongan);


    if($id_cgrup > 0){
       $customer_grup['deposit_cgrup'] =0;
       $this->db->where('id_cust',$id_cust);
       $this->db->update('customer_grup', $customer_grup);

       $dpst['id_cust'] =0;
       $dpst['id_cgrup'] =$id_cgrup;
    }else if($id_cgrup <= 0){
       $customer['deposit'] =0;
       $this->db->where('id_cust',$id_cust);
       $this->db->update('customer', $customer);
       $dpst['id_cust'] =$id_cust;
       $dpst['id_cgrup'] =0;
    }

    // $dpst['id_cust'] =$id_cust;
    $dpst['nominal_deposit'] =$deposit;
    $dpst['tipe_deposit'] ="keluar";
    $dpst['keterangan_deposit'] ="Deposit Keluar Untuk Potongan ".$this->input->post('kode_invoice');

        $this->db->insert('deposit', $dpst);

    $inv['total_potongan'] =$jmlh_potongan + $deposit;


    $this->db->where('id_invoice',$this->input->post('id_invoice'));
    $this->db->update('invoice', $inv);

}
    //data Pembayaran

    $this->session->set_flashdata('msg','depositok');
    redirect(site_url('admin/resi_udara/invoice'));

}

}
