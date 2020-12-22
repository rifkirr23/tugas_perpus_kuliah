<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Minvoice_barang extends CI_Model {

	public function __construct(){
		parent::__construct();
    $this->load->model('Mbank');
    $this->load->model('Mpembayaran');
    $this->load->model('Minvoice_lainnya');
	}
	//Proses Get Data pembayaran
	function get_invoice() {
    $this->datatables->select('invoice.id_invoice,invoice.tipe_invoice,invoice.status_invoice,invoice.kode_invoice,invoice.tanggal_invoice,
                               invoice.total_tagihan,invoice.encrypt_invoice,invoice.jumlah_bayar,invoice.total_potongan,customer.id_cust,
                               customer.kode,customer.email,customer.deposit,customer_grup.kode_cgrup,customer_grup.id_cgrup,customer.fix_alamat');
    $this->datatables->from('invoice');
    $this->datatables->join('customer', 'invoice.id_cust=customer.id_cust');
    $this->datatables->join('customer_grup', 'customer.id_cgrup=customer_grup.id_cgrup');
    $this->datatables->where('invoice.tipe_invoice','barang');
    if($this->session->userdata('level') == "sales" || $this->session->userdata('level') == "saleso"){
      $this->datatables->where('id_pendaftar',$this->session->userdata('id_pengguna'));
    }else if($this->session->userdata('level') == "crm"){
      $this->datatables->where('id_crm',$this->session->userdata('id_pengguna'));
    }
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

          <li><a href="'.base_url().'admin/sendmail/mail_invoice_barang/$1" class="submitt">
           Mail Barang Invoice</a></li>

          <li><a href="'.base_url().'admin/sendmail/mail_payment_barang/$1" class="submitt">
           Mail Barang Pembayaran</a></li>

       </ul>
     </div>

      <div class="btn-group">
        <button type="button" class="btn btn-danger btn-xs"><i class="fa fa-print"></i></button>
        <button type="button" class="btn btn-danger btn-xs dropdown-toggle" data-toggle="dropdown">
          <span class="caret"></span>
          <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" role="menu">

          <li><a href="'.base_url().'admin/public_c/invoice_barang/$1" target="_blank">
          Invoice</a></li>

          <li><a href="'.base_url().'admin/public_c/payment_barang/$1" target="_blank">
          Paid</a></li>

        </ul>
      </div>

      <a href="javascript:void(0);" class="lunas_inv btn btn-warning btn-xs" data-id_invoice="$1" data-kode_invoice="$2" data-total_tagihan="$4"
        data-status_invoice="$3" data-jumlah_bayar="$7" data-deposit="$5" data-total_potongan="$8" data-kode="$6">
        <i class="fa fa-credit-card"></i></a>

      <a href="javascript:void(0);" onclick="bayar_deposit('.$q.')" class="btn btn-warning btn-xs" alt="deposit"><i class="fa fa-money"></i></a>


      <a href="'.site_url().'admin/invoice_barang/detail/$1" class="btn btn-info btn-xs" target="_blank"><i class="fa fa-ellipsis-h"></i></a>',

      'id_invoice,kode_invoice,status_invoice,total_tagihan,deposit,kode,jumlah_bayar,total_potongan');
    return $this->datatables->generate();
  }
//   <a href="javascript:void(0);" onclick="bayar_deposit('.$q.')" class="btn btn-warning btn-xs" alt="deposit"><i class="fa fa-money"></i></a>
  function get_invoice_byid($id) {
    $this->datatables->select('invoice.id_invoice,invoice.tipe_invoice,invoice.status_invoice,invoice.kode_invoice,invoice.tanggal_invoice,
                               invoice.total_tagihan,invoice.encrypt_invoice,invoice.jumlah_bayar,invoice.total_potongan,customer.id_cust,
                               customer.kode,customer.email,customer.deposit,customer_grup.kode_cgrup,customer_grup.id_cgrup');
    $this->datatables->from('invoice');
    $this->datatables->join('customer', 'invoice.id_cust=customer.id_cust');
    $this->datatables->join('customer_grup', 'invoice.id_cgrup=customer_grup.id_cgrup');
    $this->datatables->where('invoice.tipe_invoice','barang');
    $this->datatables->where('invoice.id_cust',$id);
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

          <li><a href="'.base_url().'admin/sendmail/mail_invoice_barang/$1" class="submitt">
           Mail Barang Invoice</a></li>

          <li><a href="'.base_url().'admin/sendmail/mail_payment_barang/$1" class="submitt">
           Mail Barang Payment</a></li>

       </ul>
     </div>

      <div class="btn-group">
        <button type="button" class="btn btn-danger btn-xs"><i class="fa fa-print"></i></button>
        <button type="button" class="btn btn-danger btn-xs dropdown-toggle" data-toggle="dropdown">
          <span class="caret"></span>
          <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" role="menu">

          <li><a href="'.base_url().'admin/public_c/invoice_barang/$1" target="_blank">
          Invoice</a></li>

          <li><a href="'.base_url().'admin/public_c/payment_barang/$1" target="_blank">
          Paid</a></li>

        </ul>
      </div>

      <a href="javascript:void(0);" class="lunas_inv btn btn-warning btn-xs" data-id_invoice="$1" data-kode_invoice="$2" data-total_tagihan="$4"
        data-status_invoice="$3" data-jumlah_bayar="$7" data-deposit="$5" data-total_potongan="$8" data-kode="$6">
        <i class="fa fa-credit-card"></i></a>

      <a href="javascript:void(0);" onclick="bayar_deposit('.$q.')" class="btn btn-warning btn-xs" alt="deposit"><i class="fa fa-money"></i></a>

      <a href="'.site_url().'admin/invoice_barang/detail/$1" class="btn btn-info btn-xs" target="_blank"><i class="fa fa-ellipsis-h"></i></a>',

      'id_invoice,kode_invoice,status_invoice,total_tagihan,deposit,kode,jumlah_bayar,total_potongan');
    return $this->datatables->generate();
  }

  function get_invoice_byidgrup($id) {
    $this->datatables->select('invoice.id_invoice,invoice.tipe_invoice,invoice.status_invoice,invoice.kode_invoice,invoice.tanggal_invoice,
                               invoice.total_tagihan,invoice.encrypt_invoice,invoice.jumlah_bayar,invoice.total_potongan,customer.id_cust,
                               customer.kode,customer.email,customer.deposit,customer_grup.kode_cgrup,customer_grup.id_cgrup');
    $this->datatables->from('invoice');
    $this->datatables->join('customer', 'invoice.id_cust=customer.id_cust');
    $this->datatables->join('customer_grup', 'invoice.id_cgrup=customer_grup.id_cgrup');
    $this->datatables->where('invoice.tipe_invoice','barang');
    $this->datatables->where('customer.id_cgrup',$id);
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

          <li><a href="'.base_url().'admin/sendmail/mail_invoice_barang/$1" class="submitt">
           Mail Barang Invoice</a></li>

          <li><a href="'.base_url().'admin/sendmail/mail_payment_barang/$1" class="submitt">
           Mail Barang Payment</a></li>

       </ul>
     </div>

      <div class="btn-group">
        <button type="button" class="btn btn-danger btn-xs"><i class="fa fa-print"></i></button>
        <button type="button" class="btn btn-danger btn-xs dropdown-toggle" data-toggle="dropdown">
          <span class="caret"></span>
          <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" role="menu">

          <li><a href="'.base_url().'admin/public_c/invoice_barang/$1" target="_blank">
          Invoice</a></li>

          <li><a href="'.base_url().'admin/public_c/payment_barang/$1" target="_blank">
          Paid</a></li>

        </ul>
      </div>

      <a href="javascript:void(0);" class="lunas_inv btn btn-warning btn-xs" data-id_invoice="$1" data-kode_invoice="$2" data-total_tagihan="$4"
        data-status_invoice="$3" data-jumlah_bayar="$7" data-deposit="$5" data-total_potongan="$8" data-kode="$6">
        <i class="fa fa-credit-card"></i></a>

      <a href="javascript:void(0);" onclick="bayar_deposit('.$q.')" class="btn btn-warning btn-xs" alt="deposit"><i class="fa fa-money"></i></a>
      <a href="'.site_url().'admin/invoice_barang/detail/$1" class="btn btn-info btn-xs" target="_blank"><i class="fa fa-ellipsis-h"></i></a>',

      'id_invoice,kode_invoice,status_invoice,total_tagihan,deposit,kode,jumlah_bayar,total_potongan');
    return $this->datatables->generate();
  }

  //get rincian inv
  function rincian_inv($id){

    $this->db->select('transaksi.*');
    $this->db->from('transaksi');
    $this->db->where('transaksi.id_invoice',$id);
    //$param = array('id_order'=>$id);
    return $this->db->get('');
  }
    //get data invoice per kode encrypt
  function data_invoice($encrypt){

    $this->db->select('invoice.*,customer.*,invoice_asuransi.jumlah_asuransi as asuransi_tambahan,invoice_beli.*,customer_grup.*');
    $this->db->from('invoice');
    $this->db->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli', 'left');
    $this->db->join('customer', 'invoice.id_cust=customer.id_cust', 'left');
    $this->db->join('customer_grup', 'customer.id_cgrup=customer_grup.id_cgrup', 'left');
    $this->db->join('invoice_asuransi', 'invoice.id_invoice=invoice_asuransi.id_invoice', 'left');
    $this->db->where('invoice.id_invoice',$encrypt, 'left');
    //$param = array('id_order'=>$id);
    return $this->db->get('');
  }

  function cek_asuransi($idinv){
    $this->db->select('invoice_asuransi.*,resi.*');
    $this->db->from('invoice_asuransi');
    $this->db->where('id_invoice',$idinv);
    $this->db->join('resi', 'invoice_asuransi.id_resi=resi.id_resi', 'left');
    //$param = array('id_order'=>$id);
    return $this->db->get();
  }

  function data_invoice_id($id){
    $this->db->select('invoice.*,customer_grup.*,customer.*');
    $this->db->from('invoice');
    $this->db->join('customer', 'invoice.id_cust=customer.id_cust', 'left');
    $this->db->join('customer_grup', 'customer.id_cgrup=customer_grup.id_cgrup', 'left');
    $this->db->where('invoice.id_invoice',$id, 'left');
    //$param = array('id_order'=>$id);
    return $this->db->get('');
  }

  function getinvoice_product($id){
    $this->db->select('giw.*,invoice_product.jumlah,invoice_product.id_invoice,invoice.tanggal_invoice, invoice.kode_invoice,
		 								   customer.kode AS custkode,customer.nama AS custnama,customer.alamat AS custalamat,customer.telepon AS custtelepon,
											 resi.nomor as nomorresi,resi.tanggal,jenis_barang.namalain');
    $this->db->from('invoice_product');
    $this->db->join('giw', 'giw.id=invoice_product.id_giw', 'left');
    $this->db->join('jenis_barang', 'jenis_barang.id=giw.jenis_barang_id', 'left');
    $this->db->join('resi', 'resi.id_resi=giw.resi_id', 'left');
    $this->db->join('invoice', 'invoice.id_invoice=invoice_product.id_invoice', 'left');
    $this->db->join('customer', 'invoice.id_cust=customer.id_cust', 'left');
    $this->db->where('invoice.id_invoice',$id);
    //$param = array('id_order'=>$id);
    return $this->db->get();
  }

  function data_barcode($id){
    $this->db->where('resi_id',$id);
    return $this->db->get('giw');
  }
  //by id customer
  function data_invoice_id2($id){

    $this->db->select('invoice.*,customer.*');
    $this->db->from('invoice');
    $this->db->join('customer', 'invoice.id_cust=customer.id_cust', 'left');
    $this->db->where('invoice.id_cust',$id);
    //$param = array('id_order'=>$id);
    return $this->db->get('');

  }

  public function get_id($id){
    $this->db->where('kode',$id);
    return $this->db->get('pembayaran');
  }

    //get kode pembelian automatically
   function kode_pembelian(){
     $cekkode= $this->db->query("SELECT max(kode_pembelian) as maxkode FROM pembelian where tipe_pembelian='barang' ")->result();
     foreach($cekkode as $hcekkode);
     $kodesaatini= $hcekkode->maxkode;
     $ambilkode= str_replace('BELI/TT/','',$kodesaatini);
     if($ambilkode=="")
     {
      $ambilkode=0000;
     }
     $kodejadi= $ambilkode+1;

     $hasil= str_pad($kodejadi, 4, "0", STR_PAD_LEFT);
     return 'BELI/TT/'.$hasil;

  }

  public function get_trs($id){
    $this->db->where('id_invoice',$id);
    $this->db->limit(1);

    return $this->db->get('transaksi');
  }

  public function get_cust($id){
    $this->db->where('id_cust',$id);

    return $this->db->get('customer');
  }

  	function pinvoice($data)
  {
      // print_r($this->input->post('id_invoice'));die();
      $data_kurs= $this->data_invoice($this->input->post('id_invoice'));

      foreach($data_kurs->result() as $krs ){
          $ttl_tagihan=$krs->total_tagihan;
          $jml_bayar=$krs->jumlah_bayar;
          $jmlh_potongan=$krs->total_potongan;
          $email=$krs->email;
          $namacust=$krs->nama;
          $ei=$krs->encrypt_invoice;
          $id_cust=$krs->id_cust;
          $kfid=$krs->konfirmasi_resi;
          $km = $krs->kode;
          $id_sj = $krs->id_surat_jalan;
          $id_referal = $krs->id_referal;
          $alamat_customer = $krs->alamat;
          $deposit_customer = $krs->deposit;
          $id_cgrup = $krs->id_cgrup;
          $egrup=$krs->email_cgrup;
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

      $total_bayar = ($ttl_tagihan-$jml_bayar)-$jmlh_potongan;

      $data_bank= $this->Mbank->get_dbank($this->input->post('id_bank'));
      foreach($data_bank->result() as $dbank ){
       $sbank    =$dbank->saldo_bank;
      }

      // Info gudang
      $this->info_gudang($this->input->post('id_invoice'));

      // print_r($res);die();
      // die("oke");
      //data Pembayaran
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
      $inv['status_invoice'] = 1;

      $this->db->where('id_invoice',$this->input->post('id_invoice'));
      $this->db->update('invoice', $inv);

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
			$idinvjual = $this->input->post('id_invoice');
			$cek_customer = $this->db->select('customer.fix_alamat')->from('customer')
															 ->where('id_cust',$id_cust)
															 ->get()->row();
			if($cek_customer->fix_alamat != 1){
				$boleh_kirim = 1;
			}else{
				$boleh_kirim = 2;
			}
			$sql = "UPDATE invoice_product
			 				JOIN giw ON invoice_product.id_giw = giw.id
			 				SET giw.boleh_kirim = $boleh_kirim
							WHERE invoice_product.id_invoice = $idinvjual";
			$this->db->query($sql);

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

      $test['status']=1;
      $test['record']= $this->data_invoice($id)->row();
      $test['barcode']= $this->getinvoice_product($id)->result();
      $test['potongan']=$this->data_potongan($id)->result();
      $test['record_asuransi'] = $this->cek_asuransi($id)->result();
     	$data = $this->load->view('admin/invoice_barang/pdf_invoice',$test,True);

      $mpdf = new \Mpdf\Mpdf();
      $mpdf->WriteHTML($data);
      $mpdf->Output("pdf_file/".time()."pay.pdf" ,'F');
      $time=time()."pay.pdf";
      $content = $mpdf->Output('', 'S');
      $this->load->library('email', $config);
      $this->email->attach($content, 'attachment', $ki , 'application/pdf');

      $pesan = "*Yth. Bpk/Ibu ".$namacust." (".$km.")*\n\nTerima kasih telah melakukan pembayaran \nBerikut kami lampirkan Invoice Terbayar ".$ki.
							 "\nBarang anda akan segera kami kirim ke alamat anda (Estimasi 1-5 hari).\nTerima kasih atas kerja samanya :)".
							 "\n\n*Wilopo Cargo* _(do not reply)_";

			sendwhatsapp($pesan,$whatsappaktif);
	 		$sendoc_cust = send_newdoc($time,$whatsappaktif,$ki);

      sendwhatsapp($pesan,"081310961108");
	 		$sendoc_cust = send_newdoc($time,"081310961108",$ki);

      $the_message="<html>
                            <body>
                                    <h3>Yth. Bpk/Ibu  ".$km." ,</h3>
                                    <p>Terima kasih telah melakukan pembayaran untuk ".$ki." , Berikut kami lampirkan Invoice Terbayar.
                                    Barang anda akan segera kami kirim ke alamat anda (Estimasi 1-5 hari)</p>
                                    <p>".nama_perusahaan()."</p>

                            </body>
                      </html>";

    //$this->load->library('email', $config);
    $this->email->set_newline("\r\n");
    $this->email->from(user_email());
    $this->email->to("gusmavin@gmail.com",$emailaktif); //email tujuan. Isikan dengan emailmu!
    $this->email->subject('[Wilopo Cargo] Payment Invoice Barang '.$ki);
    $this->email->message($the_message);
    if($this->email->send())
    {
      if($sendoc_cust){
				$path_unlink = './'.$time;
				unlink($path_unlink );
			}
    }
    else
    {
      //show_error($this->email->print_debugger());
    }

      $this->session->set_flashdata('msg','invoiceok');
      redirect(site_url('admin/invoice_barang'));

  }

  function invdeposit($data)
  {
      $data_kurs= $this->data_invoice($this->input->post('id_invoice'));
      foreach($data_kurs->result() as $krs ){
        $id_resi=$krs->id_resi;
        $ttl_tagihan=$krs->total_tagihan;
        $jml_bayar=$krs->jumlah_bayar;
        $jmlh_potongan=$krs->total_potongan;
        $email=$krs->email;
        $ei=$krs->encrypt_invoice;
        $id_cust=$krs->id_cust;
        $id_sj = $krs->id_surat_jalan;
        $id_referal = $krs->id_referal;
        $km = $krs->kode;
        $deposit_customer = $krs->deposit;
        $deposit_cgrup = $krs->deposit_cgrup;
        $id_cgrup = $krs->id_cgrup;
        $egrup=$krs->email_cgrup;
        $whatsapp_customergrup=$krs->whatsapp_cgrup;
        $whatsapp_customer=$krs->whatsapp;
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

      $data_cust= $this->get_cust($id_cust);
      foreach($data_cust->result() as $cst ){
          // $deposit=$cst->deposit;
          $kode=$cst->kode;
      }
      $jmlbyr = $ttl_tagihan - ($jml_bayar + $jmlh_potongan);
      if($deposit >= $jmlbyr){

      // Info gudang
      $this->info_gudang($this->input->post('id_invoice'));

      //sub bayar ganti total potongan
      $potongan['id_invoice'] = $this->input->post('id_invoice');
      $potongan['id_jenis_potongan'] = 2;
      $potongan['jumlah_potongan'] = - $jmlbyr;
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
      $dpst['keterangan_deposit'] ="Pemotongan Deposit Untuk Pelunasan Pembayaran Invoice ".$this->input->post('kode_invoice');;
      $this->db->insert('deposit', $dpst);

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

		 $idinvjual = $this->input->post('id_invoice');
		 $cek_customer = $this->db->select('customer.fix_alamat')->from('customer')
															->where('id_cust',$id_cust)
															->get()->row();
		 if($cek_customer->fix_alamat != 1){
			 $boleh_kirim = 1;
		 }else{
			 $boleh_kirim = 2;
		 }
		 $sql = "UPDATE invoice_product
						 JOIN giw ON invoice_product.id_giw = giw.id
						 SET giw.boleh_kirim = $boleh_kirim
						 WHERE invoice_product.id_invoice = $idinvjual";
		 $this->db->query($sql);

      $config = Array(
      'protocol' => 'smtp',
      'smtp_host' => 'ssl://smtp.gmail.com',
      'smtp_port' => 465,
      'smtp_user' => user_email(), //isi dengan gmailmu!
      'smtp_pass' => pass_email(), //isi dengan password gmailmu!
      'mailtype' => 'html',
      'charset' => 'iso-8859-1',
      'wordwrap' => TRUE
    );

            $kc     = $kode;
            $ki     = $this->input->post('kode_invoice');
            $encrypt= $ei;
            $id     = $this->input->post('id_invoice');


            $tst['status']=1;
            $tst['barcode']= $this->getinvoice_product($id)->result();
            $tst['record']= $this->data_invoice($encrypt)->result();
            $tst['potongan']=$this->data_potongan($id)->result();
            $tst['record_asuransi'] = $this->cek_asuransi($id)->result();
            $data = $this->load->view('admin/invoice_barang/pdf_invoice',$tst,True);

            $mpdf = new \Mpdf\Mpdf();



      //$data = $this->load->view('hasilPrint', [], TRUE);
      $mpdf->WriteHTML($data);
      $mpdf->Output("pdf_file/".time()."pay.pdf" ,'F');
      $time=time()."pay.pdf";
      $content = $mpdf->Output('', 'S');
     $this->load->library('email', $config);
     $this->email->attach($content, 'attachment', $ki , 'application/pdf');
     $path_unlink = './'.'Payment_TT_Wilopo.pdf';

     $pesan = "*Yth. Bpk/Ibu ".$namacust." (".$km.")*\n\nTerima kasih telah melakukan pembayaran \nBerikut kami lampirkan Invoice Terbayar ".$ki.
              "\nBarang anda akan segera kami kirim ke alamat anda (Estimasi 1-5 hari).\nTerima kasih atas kerja samanya :)".
              "\n\n*Wilopo Cargo* _(do not reply)_";

     sendwhatsapp($pesan,$whatsappaktif);
     $sendoc_cust = send_newdoc($time,$whatsappaktif,$ki);

     //unlink($path_unlink );
     $the_message="<html>
                           <body>
                                   <h3>Yth. Bpk/Ibu  ".$km." ,</h3>
                                   <p>Terima kasih telah melakukan pembayaran untuk ".$ki." , Berikut kami lampirkan Invoice Terbayar.
                                   Barang anda akan segera kami kirim ke alamat anda (Estimasi 1-5 hari)</p>
                                   <p>".nama_perusahaan()."</p>

                           </body>
                     </html>";

    //$this->load->library('email', $config);
    $this->email->set_newline("\r\n");
    $this->email->from(user_email());
    $this->email->to($emailaktif); //email tujuan. Isikan dengan emailmu!
    $this->email->subject('[Wilopo Cargo] Payment Invoice Barang '.$ki);
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
      $dpst['tanggal_deposit'] = date('Y-m-d');
      $this->db->insert('deposit', $dpst);

      $inv['total_potongan'] =$jmlh_potongan + $deposit;

      $this->db->where('id_invoice',$this->input->post('id_invoice'));
      $this->db->update('invoice', $inv);

  }

      //data Pembayaran


      $this->session->set_flashdata('msg','depositok');

      redirect(site_url('admin/invoice_barang'));


  }

  function data_sub_pembayaran($id){

    $this->db->select('sub_pembayaran.*,invoice.*,pembayaran.*');
    $this->db->from('sub_pembayaran');

    $this->db->join('invoice', 'sub_pembayaran.id_invoice=invoice.id_invoice', 'left');
    $this->db->join('pembayaran', 'sub_pembayaran.id_pembayaran=pembayaran.id_pembayaran', 'left');

    $this->db->where('sub_pembayaran.id_invoice',$id, 'left');

    //$param = array('id_order'=>$id);
    return $this->db->get('');

  }

  function select_jp(){
		return $this->db->get('jenis_potongan')->result();

	}

  function data_potongan($id){
    $this->db->select('potongan.*,invoice.*,jenis_potongan.*');
    $this->db->from('potongan');
    $this->db->join('invoice', 'potongan.id_invoice=invoice.id_invoice', 'left');
    $this->db->join('jenis_potongan', 'potongan.id_jenis_potongan=jenis_potongan.id_jenis_potongan', 'left');
    $this->db->where('potongan.id_invoice',$id, 'left');
    $this->db->where('potongan.tipe_potongan',null);

    //$param = array('id_order'=>$id);
    return $this->db->get('');
  }

  function data_potongan_beli($id){
    $this->db->select('potongan.*,invoice.*,jenis_potongan.*');
    $this->db->from('potongan');
    $this->db->join('invoice', 'potongan.id_invoice=invoice.id_invoice', 'left');
    $this->db->join('jenis_potongan', 'potongan.id_jenis_potongan=jenis_potongan.id_jenis_potongan', 'left');
    $this->db->where('potongan.id_invoice',$id, 'left');
    $this->db->where('potongan.tipe_potongan','beli');

    //$param = array('id_order'=>$id);
    return $this->db->get('');
  }

  public function info_gudang($idinv){
    $getinv = $this->db->select('invoice.id_invoice,customer.fix_alamat,invoice.kode_invoice,customer.kode,invoice.tanggal_invoice,customer.id_cust,
                                 surat_jalan.no_sj,customer.alamat,customer.whatsapp,customer.ekspedisi_lokal,customer.nama,
                                 pengguna.whatsapp as wasales,crm.whatsapp as wacrm,invoice.tanggal_kasih_alamat,customer.whatsapp as wacs')
											 ->from('invoice')
											 ->join('customer', 'invoice.id_cust=customer.id_cust', 'left')
                       ->join('pengguna', 'pengguna.id_pengguna=customer.id_pendaftar')
                   		 ->join('pengguna as crm', 'crm.id_pengguna=customer.id_crm')
                       ->join('surat_jalan', 'surat_jalan.id_surat_jalan=invoice.id_surat_jalan', 'left')
											 ->where('id_invoice',$idinv)
											 ->where('tipe_invoice','barang')
											 ->get()->row();
		if($getinv->id_invoice == null || $getinv->id_invoice == "" || $getinv->id_invoice ==0){
			die();
		}
		 if($getinv->fix_alamat == 1){
       $sql = "UPDATE invoice_product JOIN giw ON invoice_product.id_giw = giw.id SET giw.boleh_kirim = 2
               WHERE invoice_product.id_invoice = $getinv->id_invoice";
       $this->db->query($sql);
     }else{
       $sql = "UPDATE invoice_product JOIN giw ON invoice_product.id_giw = giw.id SET giw.boleh_kirim = 1
               WHERE invoice_product.id_invoice = $getinv->id_invoice";
       $this->db->query($sql);
     }
											 // print_r($getinv);die();
     $resi_list = $this->db->select('resi.nomor as nomor_resi')->from('invoice_product')
                           ->join('giw', 'invoice_product.id_giw=giw.id')
                           ->join('resi', 'giw.resi_id=resi.id_resi')
                           ->group_by('resi.id_resi')
                           ->where('invoice_product.id_invoice',$getinv->id_invoice)
                           ->get();
     $resilist = "";
     foreach ($resi_list->result() as $re_list) {
       if($resi_list->num_rows() > 1){
        $resilist .=  $re_list->nomor_resi.",";
      }else{
        $resilist = $re_list->nomor_resi;
      }
     }
     if($getinv->tanggal_kasih_alamat == "" || $getinv->tanggal_kasih_alamat == null ){
           if($getinv->fix_alamat == 1){
       			$invoice['status_boleh_kirim'] = 1;
       			$invoice['tanggal_kasih_alamat'] = date('Y-m-d');
       			$this->db->where('id_invoice',$getinv->id_invoice)->update('invoice',$invoice);
       			$pesan  = "Informasi Alamat ".$resilist."\n".$getinv->kode."\n".$getinv->nama."\n".
       								"".$getinv->wacs."\n\n".$getinv->alamat.','.$getinv->ekspedisi_lokal;
       			// Whatsapp Pengiriman
             // sendwhatsapp($pesan,'083815423599');
       			whatsapp_grup("1554363574",$pesan,"6281293972529");
       		}else{
       			$invoice['status_boleh_kirim'] = 3;
       			$this->db->where('id_invoice',$getinv->id_invoice)->update('invoice',$invoice);
       			$pesan  = "*Alamat Kirim Anda Belum Lengkap*".
       								"\n\nKode Invoice : ".$getinv->kode_invoice.
       								"\nKode Marking : ".$getinv->kode.
       								"\nNo SJ : ".$this->input->post('no_sj').
       								"\n\n_Segera hubungi CS kami dan lengkapi alamat Anda agar barang cepat dikirim_";
       			sendwhatsapp($pesan,"6281299053976");
             sendwhatsapp($pesan,$getinv->whatsapp);
             sendwhatsapp($pesan,$getinv->wasales);
             sendwhatsapp($pesan,$getinv->wacrm);
             if($getinv->wacrm == "" || $getinv->wacrm == 0){
               sendwhatsapp($pesan,'6282122486180');
             }

       		}
       		// Whatsapp Pengiriman
       		// sendwhatsapp($pesan,"6287884313171");
       		// whatsapp_grup("1554363574",$pesan,"6281293972529");
       		// Sew Gudang
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


}
