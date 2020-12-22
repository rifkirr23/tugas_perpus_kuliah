<?php

class Minvoice_lainnya extends CI_Model
{
  public function __construct(){
		parent::__construct();
		$this->load->model('Mbank');
		$this->load->model('Mpembayaran');
    $this->load->model('Mtransaksi');
    $this->load->model('Mapiinvoice');
	}

  function get_invoice() {
    $this->datatables->select('invoice.id_invoice_beli,invoice.id_invoice,invoice.tipe_invoice,invoice.status_invoice,invoice.kode_invoice,invoice.tanggal_invoice,
                               invoice.total_tagihan,invoice.encrypt_invoice,invoice.jumlah_bayar,invoice.total_potongan,invoice.tanggal_kirim,customer.id_cust,
                               customer.kode,customer.email,customer.deposit,customer_grup.kode_cgrup,customer_grup.id_cgrup');
    $this->datatables->from('invoice');
    $this->datatables->join('customer', 'invoice.id_cust=customer.id_cust');
    $this->datatables->join('customer_grup', 'invoice.id_cgrup=customer_grup.id_cgrup');
    $this->datatables->where('invoice.tipe_invoice','lainnya');
    $q="$1";
    $this->datatables->add_column('mark_transaksi', '$1','kode_mark_transaksi(id_cust,id_cgrup,kode,kode_cgrup)');
    $this->datatables->add_column('view', '

      <div class="btn-group">
        <button type="button" class="btn btn-success btn-xs"><i class="fa fa-envelope"></i></button>
        <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown">
          <span class="caret"></span>
          <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" role="menu">

          <li><a href="'.base_url().'admin/sendmail/mail_invoice_lainnya/$1" class="submitt">
           Mail Invoice</a></li>
          <li><a href="'.base_url().'admin/sendmail/mail_payment_lainnya/$1" class="submitt">
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

          <li><a href="'.base_url().'admin/public_c/invoice_lainnya/$1" target="_blank">
          Invoice</a></li>

          <li><a href="'.base_url().'admin/public_c/payment_lainnya/$1" target="_blank">
          Paid</a></li>

        </ul>
      </div>

      <a href="javascript:void(0);" class="lunas_inv btn btn-warning btn-xs" data-id_invoice="$1" data-kode_invoice="$2" data-total_tagihan="$4"
        data-status_invoice="$3" data-jumlah_bayar="$7" data-deposit="$5" data-total_potongan="$8" data-kode="$6">
        <i class="fa fa-credit-card"></i></a>

      <a href="javascript:void(0);" onclick="bayar_deposit('.$q.')" class="btn btn-warning btn-xs" alt="deposit"><i class="fa fa-money"></i></a>
      <a href="'.site_url().'admin/invoice_lainnya/detail/$1/$9" class="btn btn-info btn-xs"><i class="fa fa-ellipsis-h"></i></a>
      <a onclick="return confirm(`Yakin Mneghapus?`);" href="'.site_url().'admin/invoice_lainnya/delete_inv/$1" class="btn btn-danger btn-xs"> <i class="fa fa-close"></i></a>',

      'id_invoice,kode_invoice,status_invoice,total_tagihan,deposit,kode,jumlah_bayar,total_potongan,id_invoice_beli');
    return $this->datatables->generate();
  }

  function get_invoicebyid($id) {
    $this->datatables->select('invoice.id_invoice_beli,invoice.id_invoice,invoice.tipe_invoice,invoice.status_invoice,invoice.kode_invoice,invoice.tanggal_invoice,
                               invoice.total_tagihan,invoice.encrypt_invoice,invoice.jumlah_bayar,invoice.total_potongan,customer.id_cust,
                               customer.kode,customer.email,customer.deposit,customer_grup.kode_cgrup,customer_grup.id_cgrup');
    $this->datatables->from('invoice');
    $this->datatables->join('customer', 'invoice.id_cust=customer.id_cust');
    $this->datatables->join('customer_grup', 'customer.id_cgrup=customer_grup.id_cgrup');
    $this->datatables->where('invoice.tipe_invoice','lainnya');
    $this->datatables->where('invoice.id_vendor',$id);
    $q="$1";
    $this->datatables->add_column('mark_transaksi', '$1','kode_mark_transaksi(id_cust,id_cgrup,kode,kode_cgrup)');
    $this->datatables->add_column('view', '

      <div class="btn-group">
        <button type="button" class="btn btn-success btn-xs"><i class="fa fa-envelope"></i></button>
        <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown">
          <span class="caret"></span>
          <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" role="menu">

          <li><a href="'.base_url().'admin/sendmail/mail_invoice_lainnya/$1" class="submitt">
           Mail Invoice</a></li>

          <li><a href="'.base_url().'admin/sendmail/mail_payment_lainnya/$1" class="submitt">
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

          <li><a href="'.base_url().'admin/public_c/invoice_lainnya/$1" target="_blank">
          Invoice</a></li>

          <li><a href="'.base_url().'admin/public_c/payment_lainnya/$1" target="_blank">
          Paid</a></li>

        </ul>
      </div>

      <a href="javascript:void(0);" class="lunas_inv btn btn-warning btn-xs" data-id_invoice="$1" data-kode_invoice="$2" data-total_tagihan="$4"
        data-status_invoice="$3" data-jumlah_bayar="$7" data-deposit="$5" data-total_potongan="$8" data-kode="$6">
        <i class="fa fa-credit-card"></i></a>

      <a href="javascript:void(0);" class="deposit_inv btn btn-warning btn-xs" data-id_invoice="$1" data-kode_invoice="$2" data-total_tagihan="$4"
      data-status_invoice="$3" data-jumlah_bayar="$7" data-deposit="$5" data-total_potongan="$8" data-kode="$6" alt="deposit"><i class="fa fa-money"></i></a>

      <a href="'.site_url().'admin/invoice_lainnya/detail/$1/$9" class="btn btn-info btn-xs"><i class="fa fa-ellipsis-h"></i></a>',

      'id_invoice,kode_invoice,status_invoice,total_tagihan,deposit,kode,jumlah_bayar,total_potongan,id_invoice_beli');
    return $this->datatables->generate();
  }

  function select_vendor(){
    return $this->db->get('vendor');
  }

  function select_kategori_il(){
    return $this->db->where('id_kategori_il >',1)->get('kategori_il');
  }

  function data_invoice($id){
    $this->db->select('invoice.*,customer_grup.*,customer.*,invoice_beli.*');
    $this->db->from('invoice');
    $this->db->join('customer', 'invoice.id_cust=customer.id_cust', 'left');
    $this->db->join('customer_grup', 'customer.id_cgrup=customer_grup.id_cgrup', 'left');
    $this->db->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli');
    $this->db->where('invoice.id_invoice',$id);
    //$param = array('id_order'=>$id);
    return $this->db->get();
  }

  function item_inv($id){
    $oke = $this->db->select('item_il.*')->from('item_il')->where('id_invoice',$id)->get();
    // print_r($oke);die();
    return $oke;
  }

  function data_item($id){
    $oke = $this->db->select('item_il.*')->from('item_il')->where('id_item_il',$id)->get();
    // print_r($oke);die();
    return $oke;
  }

  // Get Kode
  function kode_il($id){
    // get kategori
    $getcode = $this->db->where("id_vendor",$id)->from('kategori_il')->get()->row();
    $namaktgr= $getcode->kode_kategori_il;//print_r($namaktgr);die();
    // kode otomatis
    $getinv= $this->db->where('id_vendor',$id)->order_by('id_invoice','desc')->limit(1)->get('invoice')->row();
    $ambilkode= str_replace('INVOICE/'.$namaktgr.'/','',$getinv->kode_invoice);
    // print_r($getinvbeli->kode_invoice_beli);die();
    if($ambilkode==0)
    {
     $ambilkode=0;
    }
   $kodejadi= $ambilkode+1;
    // print_r($kodejadi);die();
   $hasil= $kodejadi;
    //echo $hitungcode; die($namaktgr);
    $kodeinvoice = 'INVOICE/'.$namaktgr.'/'.$hasil;
   return $kodeinvoice;
  }

  // Get name Category
  function getnamecategory($id){
     $getcode = $this->db->where("id_kategori_il",$id)->from('kategori_il')->get()->row();
     $namaktgr= $getcode->nama_kategori_il;//print_r($namaktgr);die();
     return $namaktgr;
  }

  // Kode Invoice Beli
  function kode_beli($id){
    // get kategori
    $getcode = $this->db->where("id_vendor",$id)->from('kategori_il')->get()->row();
    $namaktgr= $getcode->kode_kategori_il;//print_r($namaktgr);die();
    // kode otomatis
    $getinvbeli= $this->db->where('id_vendor',$id)->order_by('id_invoice_beli','desc')->limit(1)->get('invoice_beli')->row();
    $ambilkode= str_replace('BELI/'.$namaktgr.'/','',$getinvbeli->kode_invoice_beli);
    // print_r($getinvbeli->kode_invoice_beli);die();
    if($ambilkode==0)
    {
     $ambilkode=0;
    }
		$kodejadi= $ambilkode+1;
    // print_r($kodejadi);die();
		$hasil= $kodejadi;
    //echo $hitungcode; die($namaktgr);
    $kodeinvoice = 'BELI/'.$namaktgr.'/'.$hasil;
		return $kodeinvoice;
  }

  function save(){
    // $hitungcode= $this->db->where("id_kategori_il",$this->input->post('id_kategori_il'))->from('kategori_il')->get()->row();print_r($hitungcode);die();
    //print_r($this->kode_il($this->input->post('id_kategori_il')));die("oke");
    $id_kategori_il = $this->input->post('id_kategori_il');
    $getkategori = $this->db->where('id_kategori_il',$id_kategori_il)->get('kategori_il')->row();
    // print_r($this->kode_il($getkategori->id_vendor));
    // print_r($this->kode_beli($getkategori->id_vendor));
    // die();
    $kode = $this->input->post('id_cust');
    $data_kode = $this->Mtransaksi->get_id($kode)->row();
    //Insert Invoice Beli
    $insert_inv['kode_invoice_beli'] = $this->kode_beli($getkategori->id_vendor);
    $insert_inv['note_invoice_beli'] = $this->getnamecategory($id_kategori_il);
    $insert_inv['id_cust']   = $data_kode->id_cust;
    $insert_inv['id_vendor'] = $getkategori->id_vendor;
    $insert_inv['tanggal_invoice_beli'] =date('Y-m-d');
    $insert_inv['status_invoice_beli'] =1;
    $insert_inv['jumlah_invoice_beli'] =0;
    $insert_inv['jumlah_bayar_invoice_beli']=0;
    $this->db->insert('invoice_beli', $insert_inv);
    $inv_beli = $this->db->insert_id();

    $insert_il['id_cust']= $data_kode->id_cust;
    $insert_il['id_vendor']= $getkategori->id_vendor;
    $insert_il['id_kategori_il']= $this->input->post('id_kategori_il');
    $insert_il['id_invoice_beli']= $inv_beli;
    $insert_il['id_cgrup']= 0;
    $insert_il['kode_invoice']= $this->kode_il($getkategori->id_vendor);
    $insert_il['tanggal_invoice']= date('Y-m-d');
    $insert_il['total_tagihan']= 0;
    $insert_il['tipe_invoice']= "lainnya";
    $insert_il['status_invoice']= 0;
    $this->db->insert('invoice', $insert_il);
    $last_id_invoice = $this->db->insert_id();
    redirect('admin/invoice_lainnya/detail/'.$last_id_invoice.'/'.$inv_beli);//detail/'.$last_id_invoice
  }

  function save_bypengiriman($id_cust,$harga_lokal,$id_kategori_il,$id_invoice,$ket_item,$jumlah_hari){
    $getkategori = $this->db->where('id_kategori_il',$id_kategori_il)->get('kategori_il')->row();
    //Insert Invoice Beli
    $insert_inv['kode_invoice_beli'] = $this->kode_beli($getkategori->id_vendor);
    $insert_inv['note_invoice_beli'] = $this->getnamecategory($id_kategori_il);
    $insert_inv['id_cust']   = $id_cust;
    $insert_inv['id_vendor'] = $getkategori->id_vendor;
    $insert_inv['tanggal_invoice_beli'] =date('Y-m-d');
    $insert_inv['status_invoice_beli'] =1;
    $insert_inv['jumlah_invoice_beli'] =0;
    $insert_inv['jumlah_bayar_invoice_beli']=0;
    $this->db->insert('invoice_beli', $insert_inv);
    $inv_beli = $this->db->insert_id();
    // Jual
    $insert_il['id_cust']= $id_cust;
    $insert_il['id_vendor']= $getkategori->id_vendor;
    $insert_il['id_kategori_il']= $id_kategori_il;
    $insert_il['id_invoice_beli']= $inv_beli;
    $insert_il['id_cgrup']= 0;
    $insert_il['kode_invoice']= $this->kode_il($getkategori->id_vendor);
    $insert_il['tanggal_invoice']= date('Y-m-d');
    $insert_il['total_tagihan']= $harga_lokal;
    $insert_il['jumlah_bayar']= 0;
    $insert_il['tipe_invoice']= "lainnya";
    $insert_il['status_invoice']= 0;
    $this->db->insert('invoice', $insert_il);
    $last_id_invoice = $this->db->insert_id();
    $upd_inv['inv_lainnya_id'] = $last_id_invoice;
    $this->db->where('id_invoice',$id_invoice)->update('invoice',$upd_inv);
    // item
    $insert_item['id_invoice']= $last_id_invoice;
    $insert_item['id_invoice_beli']= $inv_beli;
    $insert_item['qty_il']= $jumlah_hari." Hari";
    $insert_item['keterangan_il']= $ket_item;
    $insert_item['harga_jual']= $harga_lokal/$jumlah_hari;
    $insert_item['harga_beli']= 0;
    $this->db->insert('item_il', $insert_item);
    // redirect('admin/invoice_lainnya/detail/'.$last_id_invoice.'/'.$inv_beli);//detail/'.$last_id_invoice
    // die();
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

    $data_invoice= $this->data_invoice($last_id_invoice);
    foreach($data_invoice->result() as $inv ){
      $ei=$inv->encrypt_invoice;
      $ki=$inv->kode_invoice;
      $tt=$inv->total_tagihan;
      $km=$inv->kode;
      $email=$inv->email;
      $nama=$inv->nama;
      $whatsapp=$inv->whatsapp;
    }
    if($id_kategori_il == 5){
      $subjectemail = "Invoice Membership";
      $test['status'] =1 ;
      $pesan = "*Yth. Bpk/Ibu ".$nama." (".$km.")*\n\nTerima kasih telah melakukan pembayaran \nBerikut kami lampirkan Invoice Terbayar ".$ki.
              "\n\nTerima kasih atas kerja samanya :)".
              "\n\n*Wilopo Cargo* _(do not reply)_";
      $the_message="<html>
                           <body>
                                   <h3>Yth. Bpk/Ibu  ".$km." ,</h3>
                                   <p>Terima kasih telah melakukan pembayaran untuk ".$ki."</p>
                                   <p>".nama_perusahaan()."</p>

                           </body>
                     </html>";
    }else{
      $subjectemail = $ket_item;
      $test['status'] =0 ;
      $pesan = "*Yth. Bpk/Ibu ".$nama." (".$km.")*\n\nBerikut kami lampirkan invoice titip transfer ".$ki." yang harus Anda bayar, yaitu sebesar *Rp.".number_format($tt).
              "* ke rekening berikut:\n\n*BCA 5810557747 a/n Gusmavin Willopo*\n\nSetelah melakukan pembayaran, harap melakukan konfirmasi pembayaran dengan menghubungi kami melalui telepon / WA.".
              "\n\nTerima kasih atas kerja samanya :)".
              "\n\n*Wilopo Cargo* _(do not reply)_";
      $the_message="<html>
                           <body>
                                   <h3>Yth. Bpk/Ibu  ".$km." ,</h3>
                                   <p>Berikut terlampir invoice yang harus Anda bayar, yaitu sebesar Rp.".number_format($tt).". ke rekening berikut:</p>
                                   <p><b>BCA 5810557747 a/n Gusmavin Willopo</b></p>
                                   <br />Setelah melakukan pembayaran, harap melakukan konfirmasi pembayaran dengan menghubungi kami melalui telepon / WA.</p>
                                   <p>".nama_perusahaan()."</p>

                           </body>
                     </html>";
    }
    $test['record'] = $this->data_invoice($last_id_invoice)->row();
    $test['item']= $this->item_inv($last_id_invoice)->result(); //print_r($test['item']);die();
    $data = $this->load->view('admin/invoice_lainnya/pdf_invoice',$test,True);

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($data);
    $mpdf->Output("pdf_file/".time()."inv.pdf" ,'F');
    $time=time()."inv.pdf";
    $content = $mpdf->Output('', 'S');

      sendwhatsapp($pesan,"081310961108");
      $sendoc = send_newdoc($time,"081310961108",$ki);

      sendwhatsapp($pesan,$whatsapp);
      $sendoc = send_newdoc($time,$whatsapp,$ki);

      $this->load->library('email', $config);
      $this->email->attach($content, 'attachment', $ki , 'application/pdf');

      $this->email->set_newline("\r\n");
      $this->email->from(user_email());
      $this->email->to($email); //email tujuan. Isikan dengan emailmu!
      $this->email->subject('[Wilopo Cargo]'.$subjectemail.' '.$ki);
      $this->email->message($the_message);

      if($this->email->send())
      {
        if($sendoc){
         $path_unlink = './'.$time;
         unlink($path_unlink );
         // update tanggal kirim
         $h=date('H')+7;
         $inv['tanggal_kirim'] = date('Y-m-d '.$h.'-i-s');
         $this->db->where('id_invoice',$last_id_invoice)->update('invoice',$inv);
        }
      }
      else
      {
        //show_error($this->email->print_debugger());
      }
      // print_r($email);print_r($whatsapp);die();
  }

  function save_item(){
    $insert_item['id_invoice']= $this->input->post('id_invoice');
    $insert_item['id_invoice_beli']= $this->input->post('id_invoice_beli');
    $insert_item['qty_il']= $this->input->post('qty_il');
    $insert_item['keterangan_il']= $this->input->post('keterangan_il');
    $insert_item['harga_jual']= str_replace(".", "",$this->input->post('harga_jual'));
    $insert_item['harga_beli']= str_replace(".", "",$this->input->post('harga_beli'));
    $this->db->insert('item_il', $insert_item);

    $get_harga = $this->db->where('id_invoice',$insert_item['id_invoice'])->get('invoice')->row();
    $update_il['total_tagihan']= $get_harga->total_tagihan + ($insert_item['harga_jual'] * $insert_item['qty_il']);
    $this->db->where('id_invoice',$insert_item['id_invoice'])->update('invoice',$update_il);

    $get_harga_beli = $this->db->where('id_invoice_beli',$insert_item['id_invoice_beli'])->get('invoice_beli')->row();
    $invbeli['jumlah_invoice_beli']= $get_harga_beli->jumlah_invoice_beli + ($insert_item['harga_beli'] * $insert_item['qty_il']);
    $this->db->where('id_invoice_beli',$insert_item['id_invoice_beli'])->update('invoice_beli',$invbeli);


    redirect('admin/invoice_lainnya/detail/'.$insert_item['id_invoice'].'/'.$insert_item['id_invoice']);
  }

  function saveedit_item(){
    // $insert_item['id_invoice']= $this->input->post('id_invoice');
    $harga_jual_lama = str_replace(".", "",$this->input->post('harga_jual_lama')) * $this->input->post('qty_il');
    $harga_beli_lama = str_replace(".", "",$this->input->post('harga_beli_lama')) * $this->input->post('qty_il');
    $insert_item['qty_il']= $this->input->post('qty_il');
    $insert_item['keterangan_il']= $this->input->post('keterangan_il');
    $insert_item['harga_jual']= str_replace(".", "",$this->input->post('harga_jual'));
    $insert_item['harga_beli']= str_replace(".", "",$this->input->post('harga_beli'));
    $this->db->where('id_item_il',$this->input->post('id_item_il'));
    $this->db->update('item_il', $insert_item);

    $get_harga = $this->db->where('id_invoice',$this->input->post('id_invoice'))->get('invoice')->row();
    $update_il['total_tagihan']= ($get_harga->total_tagihan - $harga_jual_lama) + ($insert_item['harga_jual'] * $insert_item['qty_il']);
    $this->db->where('id_invoice',$this->input->post('id_invoice'))->update('invoice',$update_il);

    $get_harga_beli = $this->db->where('id_invoice_beli',$this->input->post('id_invoice_beli'))->get('invoice_beli')->row();
    $invbeli['jumlah_invoice_beli']= ($get_harga_beli->jumlah_invoice_beli - $harga_beli_lama) + ($insert_item['harga_beli'] * $insert_item['qty_il']);
    $this->db->where('id_invoice_beli',$this->input->post('id_invoice_beli'))->update('invoice_beli',$invbeli);

    redirect('admin/invoice_lainnya/detail/'.$this->input->post('id_invoice').'/'.$this->input->post('id_invoice_beli'));
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
      $id_cgrup=$krs->id_cgrup;
      $marking=$krs->kode;
      $ttl_tagihan=$krs->total_tagihan;
      $jml_bayar=$krs->jumlah_bayar;
      $jmlh_potongan=$krs->total_potongan;
      $email=$krs->email;
      $ei=$krs->encrypt_invoice;
      $id_cust=$krs->id_cust;
      $email_customer=$krs->email;
      $kfid=$krs->konfirmasi_resi;
      $whatsapp_customer=$krs->whatsapp;
      $whatsapp_customergrup=$krs->whatsapp_cgrup;
      $egrup=$krs->email_cgrup;

    }
      $total_bayar=($ttl_tagihan-$jml_bayar)-$jmlh_potongan;

      // $kodeaktif = $marking;
			// $namaaktif = $nama_customer;
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

      $data_bank= $this->Mbank->get_dbank($this->input->post('id_bank'));
      foreach($data_bank->result() as $dbank ){
       $sbank    =$dbank->saldo_bank;
      }
    // //data Pembayaran
    $pembayaran['id_cust'] = $cust_id;
    $pembayaran['id_cgrup'] = $id_cgrup;
    $pembayaran['kode_pembayaran'] = $this->Mpembayaran->code_pembayaran();
    $pembayaran['tanggal_bayar'] = date('Y-m-d');
    $pembayaran['jumlah_bayar'] = $total_bayar;
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
          $test['record']= $this->data_invoice($id)->row();
          $test['item']= $this->item_inv($id)->result();
          $data = $this->load->view('admin/invoice_lainnya/pdf_invoice',$test,True);

          $mpdf = new \Mpdf\Mpdf();
          $mpdf->WriteHTML($data);
          $mpdf->Output("pdf_file/".time()."pay.pdf" ,'F');
    			$time=time()."pay.pdf";
          $content = $mpdf->Output('', 'S');
          $this->load->library('email', $config);
          $this->email->attach($content, 'attachment', $ki , 'application/pdf');

          $pesan = "*Yth. Bpk/Ibu ".$kc."*\n\nTerima kasih telah melakukan pembayaran \nBerikut kami lampirkan Invoice Terbayar ".$ki.
    							 "\n\n*Wilopo Cargo* _(do not reply)_";

          sendwhatsapp($pesan,$whatsappaktif);
 			 		$sendoc_cust = send_newdoc($time,$whatsappaktif,$ki);

          sendwhatsapp($pesan,"081310961108");
 			 		$senddoc=send_newdoc($time,"081310961108",$ki);

          $the_message="<html>
                          <body>
                                  <h3>Yth. Bpk/Ibu  ".$marking." ,</h3>
                                  <p>Terima kasih telah melakukan pembayaran untuk ".$ki."</p>
                                  <p>".nama_perusahaan()."</p>

                          </body>
                    </html>";

  //$this->load->library('email', $config);
  $this->email->set_newline("\r\n");
  $this->email->from(user_email());
  $this->email->to($emailaktif); //email tujuan. Isikan dengan emailmu!
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
    redirect(site_url('admin/invoice_lainnya'));


}



function invdeposit($data)
{
    $data_kurs= $this->data_invoice($this->input->post('id_invoice'));

      foreach($data_kurs->result() as $krs ){
          $id_cgrup=$krs->id_cgrup;
          $ttl_tagihan=$krs->total_tagihan;
          $jml_bayar=$krs->jumlah_bayar;
          $jmlh_potongan=$krs->total_potongan;
          $email=$krs->email;
          $ei=$krs->encrypt_invoice;
          $id_cust=$krs->id_cust;
          $email_customer=$krs->email;
          $egrup=$krs->email_cgrup;
          $deposit_customer = $krs->deposit;
          $deposit_cgrup = $krs->deposit_cgrup;
  				$whatsapp_customer=$krs->whatsapp;
  				$whatsapp_customergrup=$krs->whatsapp_cgrup;
          $kode = $krs->kode;

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
        $potongan['id_jenis_potongan'] = 2;
        $potongan['jumlah_potongan'] = $jmlbyr;
        $potongan['keterangan_potongan'] = "Pembayaran dengan deposit";

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
          $data = $this->load->view('admin/invoice_lainnya/pdf_invoice',$test,True);

          $mpdf = new \Mpdf\Mpdf();

    //$data = $this->load->view('hasilPrint', [], TRUE);
    $mpdf->WriteHTML($data);
    $mpdf->Output("pdf_file/".time()."pay.pdf" ,'F');
    $time=time()."pay.pdf";
    $content = $mpdf->Output('', 'S');
    $this->load->library('email', $config);
    $this->email->attach($content, 'attachment', $ki , 'application/pdf');
    $path_unlink = './'.'Payment_TT_Wilopo.pdf';

    $pesan = "*Yth. Bpk/Ibu ".$kc."*\n\nTerima kasih telah melakukan pembayaran \nBerikut kami lampirkan Invoice Terbayar ".$ki.
						 "\n\n*Wilopo Cargo* _(do not reply)_";

    sendwhatsapp($pesan,$whatsappaktif);
	 		$sendoc_cust = send_newdoc($time,$whatsappaktif,$ki);

    sendwhatsapp($pesan,"081310961108");
	 		$senddoc=send_newdoc($time,"081310961108",$ki);
    //unlink($path_unlink );
     $the_message="<html>
                          <body>
                                  <h3>Yth. ".$kc." ,</h3>
                                  <p>Terima kasih telah melakukan pembayaran untuk ".$ki." </p>

                                  ".nama_perusahaan()."

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
    $potongan['id_jenis_potongan'] = $this->input->post('id_jenis_potongan');
    $potongan['jumlah_potongan'] = $deposit;
    $potongan['keterangan_potongan'] = $this->input->post('keterangan_potongan');

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
    redirect(site_url('admin/invoice_barang'));

}

}
