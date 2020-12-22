 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Minvoice_barang extends CI_Model {

	public function __construct(){
		parent::__construct();
    $this->load->model('Mbank');
    $this->load->model('Mpembayaran');
	}
	//Proses Get Data pembayaran
	function get_invoice() {
    $this->datatables->select('invoice.id_invoice,invoice.tipe_invoice,invoice.status_invoice,invoice.kode_invoice,invoice.tanggal_invoice,
                               invoice.total_tagihan,invoice.encrypt_invoice,invoice.jumlah_bayar,invoice.total_potongan,customer.id_cust,
                               customer.kode,customer.email,customer.deposit,customer_grup.kode_cgrup,customer_grup.id_cgrup');
    $this->datatables->from('invoice');
    $this->datatables->join('customer', 'invoice.id_cust=customer.id_cust');
    $this->datatables->join('customer_grup', 'invoice.id_cgrup=customer_grup.id_cgrup');
    $this->datatables->where('invoice.tipe_invoice','barang');
    $this->db->order_by('status_invoice','asc');
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

      <a href="javascript:void(0);" class="deposit_inv btn btn-warning btn-xs" data-id_invoice="$1" data-kode_invoice="$2" data-total_tagihan="$4"
      data-status_invoice="$3" data-jumlah_bayar="$7" data-deposit="$5" data-total_potongan="$8" data-kode="$6" alt="deposit"><i class="fa fa-money"></i></a>

      <a href="'.site_url().'admin/invoice_barang/detail/$1" class="btn btn-info btn-xs" target="_blank"><i class="fa fa-ellipsis-h"></i></a>',

      'id_invoice,kode_invoice,status_invoice,total_tagihan,deposit,kode,jumlah_bayar,total_potongan');
    return $this->datatables->generate();
  }

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

      <a href="javascript:void(0);" class="deposit_inv btn btn-warning btn-xs" data-id_invoice="$1" data-kode_invoice="$2" data-total_tagihan="$4"
      data-status_invoice="$3" data-jumlah_bayar="$7" data-deposit="$5" data-total_potongan="$8" data-kode="$6" alt="deposit"><i class="fa fa-money"></i></a>

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

    $this->db->select('invoice.*,customer.*,invoice_asuransi.jumlah_asuransi as asuransi_tambahan,invoice_beli.*');
    $this->db->from('invoice');
    $this->db->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli', 'left');
    $this->db->join('customer', 'invoice.id_cust=customer.id_cust', 'left');
    $this->db->join('invoice_asuransi', 'invoice.id_invoice=invoice_asuransi.id_invoice', 'left');
    $this->db->where('invoice.id_invoice',$encrypt, 'left');
    //$param = array('id_order'=>$id);
    return $this->db->get('');
  }

  function cek_asuransi($idinv){
    $id=$this->session->userdata('id_cust');
    $this->db->select('invoice_asuransi.*,resi.*');
    $this->db->from('invoice_asuransi');
    $this->db->where('id_invoice',$idinv);
    $this->db->where('id_cust',$id);
    $this->db->join('resi', 'invoice_asuransi.id_resi=resi.id_resi', 'left');
    //$param = array('id_order'=>$id);
    return $this->db->get();
  }

  function data_invoice_id($id){
    $this->db->select('invoice.*,customer_grup.*,customer.*');
    $this->db->from('invoice');
    $this->db->join('customer_grup', 'invoice.id_cgrup=customer_grup.id_cgrup', 'left');
    $this->db->join('customer', 'invoice.id_cust=customer.id_cust', 'left');
    $this->db->where('invoice.id_invoice',$id, 'left');
    //$param = array('id_order'=>$id);
    return $this->db->get('');
  }

  function getinvoice_product($id){
    $idcust=$this->session->userdata('id_cust');
    $this->db->select('giw.*,invoice_product.jumlah,invoice_product.id_invoice,invoice.tanggal_invoice, invoice.kode_invoice, customer.kode AS custkode,customer.nama AS custnama,customer.alamat AS custalamat,customer.telepon AS custtelepon,resi.nomor as nomorresi,resi.tanggal, jenis_barang.namalain');
    $this->db->from('invoice_product');
    $this->db->join('giw', 'giw.id=invoice_product.id_giw', 'left');
    $this->db->join('jenis_barang', 'giw.jenis_barang_id=jenis_barang.id', 'left');
    $this->db->join('resi', 'resi.id_resi=giw.resi_id', 'left');
    $this->db->join('invoice', 'invoice.id_invoice=invoice_product.id_invoice', 'left');
    $this->db->join('customer', 'invoice.id_cust=customer.id_cust', 'left');
    $this->db->where('invoice.id_invoice',$id);
    $this->db->where('invoice.id_cust',$idcust);
    //$param = array('id_order'=>$id);
    return $this->db->get('');
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
            $id_resi=$krs->id_resi;
            $ttl_tagihan=$krs->total_tagihan;
            $jml_bayar=$krs->jumlah_bayar;
            $jmlh_potongan=$krs->total_potongan;
            $email=$krs->email;
            $namacust=$krs->nama;
            $ei=$krs->encrypt_invoice;
            $id_cust=$krs->id_cust;
            $email_customer=$krs->email;
            $kfid=$krs->konfirmasi_resi;
            $km = $krs->kode;
          }
        $total_bayar=($ttl_tagihan-$jml_bayar)-$jmlh_potongan;

        $data_bank= $this->Mbank->get_dbank($this->input->post('id_bank'));
        foreach($data_bank->result() as $dbank ){
         $sbank    =$dbank->saldo_bank;
          }
      //data Pembayaran
      $pembayaran['id_cust'] = $id_cust;
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

       $data_barcodes= $this->data_barcode($id_resi);
        	foreach($data_barcodes->result() as $dbar ){

            $volumes=$dbar->volume;
            $nilais=$dbar->nilai;
            $ctnss=$dbar->ctns;
            $qtys=$dbar->qty;
            $kurss=$dbar->kurs;
            $hbb=$dbar->harga;

            $harga_barcode = $hbb * $ctnss * $volumes;
            $hrg += $harga_barcode;

             $rmb1 = $nilais * $ctnss * $qtys;
             $rmb2 = $rmb1 * $kurss;
             $tvolumes += $volumes;
             $total_asuransi += $rmb2;

         	 }

         	 $hrg;

         $asrns = $total_asuransi;
         $asuransi_tanggungan = $tvolumes * 20000000;

        $asrns_tambahan = ($total_asuransi - $asuransi_tanggungan) * 1/100;

         if($asrns_tambahan <= 0){
             $asrns_tambahan=0;
         }

         $ttl_pembelian = round($hrg+$asrns_tambahan);

      // $pembelian['kode_pembelian'] = $this->kode_pembelian();
      // $pembelian['id_invoice'] = $this->input->post('id_invoice');
      // $pembelian['total_pembelian'] = $ttl_pembelian;
      // $pembelian['tanggal_pembelian'] = date('Y-m-d');
      // $pembelian['status_pembelian'] = 1;
      // $pembelian['tipe_pembelian'] = "barang";
      //
      // $this->db->insert('pembelian', $pembelian);

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
     	$data = $this->load->view('admin/invoice_barang/pdf_invoice',$test,True);

      $mpdf = new \Mpdf\Mpdf();
      $mpdf->WriteHTML($data);
      $mpdf->Output(time()."pay.pdf" ,'F');
      $time=time()."pay.pdf";
      $content = $mpdf->Output('', 'S');
      $this->load->library('email', $config);
      $this->email->attach($content, 'attachment', $ki , 'application/pdf');

      $pesan = "*Yth. Bpk/Ibu ".$namacust." (".$km.")*\n\nTerima kasih telah melakukan pembayaran \nBerikut kami lampirkan Invoice Terbayar ".$ki.
							 "\nBarang anda akan segera kami kirim ke alamat anda (Estimasi 1-5 hari).\nTerima kasih atas kerja samanya :)".
							 "\n\n*Wilopo Cargo* _(do not reply)_";

			sendwhatsapp($pesan,"081310961108");
	 		$sendoc_cust = send_document($time,"081310961108",$ki);

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
    $this->email->to("gusmavin@gmail.com"); //email tujuan. Isikan dengan emailmu!
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
        $email_customer=$krs->email;
      }
      $data_cust= $this->get_cust($id_cust);
      foreach($data_cust->result() as $cst ){
          $deposit=$cst->deposit;
          $kode=$cst->kode;
      }
      $jmlbyr = $ttl_tagihan - ($jml_bayar + $jmlh_potongan);
      if($deposit >= $jmlbyr){
      //sub bayar ganti total potongan
      $potongan['id_invoice'] = $this->input->post('id_invoice');
      $potongan['id_jenis_potongan'] = $this->input->post('id_jenis_potongan');
      $potongan['jumlah_potongan'] = $jmlbyr;
      $potongan['keterangan_potongan'] = $this->input->post('keterangan_potongan');
      $this->db->insert('potongan', $potongan);

      $inv['total_potongan'] = $ttl_tagihan - $jml_bayar;
      $inv['status_invoice'] =1;

      $this->db->where('id_invoice',$this->input->post('id_invoice'));
      $this->db->update('invoice', $inv);

      $customer['deposit'] =$deposit - $jmlbyr;

      $this->db->where('id_cust',$id_cust);
      $this->db->update('customer', $customer);

      $dpst['id_cust'] =$id_cust;
      $dpst['nominal_deposit'] =$jmlbyr;
      $dpst['tipe_deposit'] ="keluar";
      $dpst['keterangan_deposit'] ="Pemotongan Deposit Untuk Pelunasan Pembayaran Invoice ".$this->input->post('kode_invoice');;

          $this->db->insert('deposit', $dpst);

            $data_barcodes= $this->data_barcode($id_resi);
        	foreach($data_barcodes->result() as $dbar ){

            $volumes=$dbar->volume;
            $nilais=$dbar->nilai;
            $ctnss=$dbar->ctns;
            $qtys=$dbar->qty;
            $kurss=$dbar->kurs;
            $hbb=$dbar->harga;

             $harga_barcode = $hbb * $ctnss * $volumes;
             $hrg += $harga_barcode;

             $rmb1 = $nilais * $ctnss * $qtys;
             $rmb2 = $rmb1 * $kurss;
             $tvolumes += $volumes;
             $total_asuransi += $rmb2;

         	 }

         	 $hrg;

         $asrns = $total_asuransi;
         $asuransi_tanggungan = $tvolumes * 20000000;

        $asrns_tambahan = ($total_asuransi - $asuransi_tanggungan) * 1/100;

         if($asrns_tambahan <= 0){
             $asrns_tambahan=0;
         }

         $ttl_pembelian = round($hrg+$asrns_tambahan);


      // $pembelian['kode_pembelian'] = $this->kode_pembelian();
      // $pembelian['id_invoice'] = $this->input->post('id_invoice');
      // $pembelian['total_pembelian'] = $ttl_pembelian;
      // $pembelian['tanggal_pembelian'] = date('Y-m-d');
      // $pembelian['status_pembelian'] = 1;
      // $pembelian['tipe_pembelian'] = "barang";
      //
      //
      // $this->db->insert('pembelian', $pembelian);

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
            $tst['record']= $this->data_invoice($encrypt)->result();
            $tst['rincian']= $this->rincian_inv($id)->result();
            $data = $this->load->view('admin/invoice/pdf_invoice',$tst,True);

            $mpdf = new \Mpdf\Mpdf();



      //$data = $this->load->view('hasilPrint', [], TRUE);
      $mpdf->WriteHTML($data);
      $content = $mpdf->Output('', 'S');
     $this->load->library('email', $config);
     $this->email->attach($content, 'attachment', $ki , 'application/pdf');
     $path_unlink = './'.'Payment_TT_Wilopo.pdf';
     //unlink($path_unlink );
       $the_message="<html>
                            <body>
                                    <h3>Yth. ".$kc." ,</h3>
                                    <p>Terima kasih telah melakukan pembayaran untuk ".$ki." </p>
                                    <p>...</p>
                                    ".nama_perusahaan()."

                            </body>
                      </html>";
    //$this->load->library('email', $config);
    $this->email->set_newline("\r\n");
    $this->email->from(user_email());
    $this->email->to($email); //email tujuan. Isikan dengan emailmu!
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
      $potongan['id_jenis_potongan'] = $this->input->post('id_jenis_potongan');
      $potongan['jumlah_potongan'] = $deposit;
      $potongan['keterangan_potongan'] = $this->input->post('keterangan_potongan');

      $this->db->insert('potongan', $potongan);


      $customer['deposit'] =0;

      $this->db->where('id_cust',$id_cust);
      $this->db->update('customer', $customer);

      $dpst['id_cust'] =$id_cust;
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

  function data_sub_pembayaran($id){
    $idcust=$this->session->userdata('id_cust');

    $this->db->select('sub_pembayaran.*,invoice.*,pembayaran.*');
    $this->db->from('sub_pembayaran');

    $this->db->join('invoice', 'sub_pembayaran.id_invoice=invoice.id_invoice', 'left');
    $this->db->join('pembayaran', 'sub_pembayaran.id_pembayaran=pembayaran.id_pembayaran', 'left');

    $this->db->where('sub_pembayaran.id_invoice',$id);
    $this->db->where('invoice.id_cust',$idcust);


    //$param = array('id_order'=>$id);
    return $this->db->get('');

  }

  function select_jp(){
		return $this->db->get('jenis_potongan')->result();

	}

  function data_potongan($id){
    $idcust=$this->session->userdata('id_cust');
    $this->db->select('potongan.*,invoice.*,jenis_potongan.*');
    $this->db->from('potongan');
    $this->db->join('invoice', 'potongan.id_invoice=invoice.id_invoice', 'left');
    $this->db->join('jenis_potongan', 'potongan.id_jenis_potongan=jenis_potongan.id_jenis_potongan', 'left');
    $this->db->where('potongan.id_invoice',$id);
    $this->db->where('invoice.id_cust',$idcust);
    //$param = array('id_order'=>$id);
    return $this->db->get('');
  }


}
