<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Minvoice extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->model('Mbank');
		$this->load->model('Mpembayaran');
		$this->load->model('Mrmb');
		$this->load->model('Mkomisi_referal');
	}
	//Proses Get Data pembayaran
	function get_invoice() {
        $this->datatables->select('invoice.id_invoice,invoice.tipe_invoice,invoice.status_invoice,invoice.kode_invoice,invoice.tanggal_invoice,
                                   invoice.total_tagihan,invoice.encrypt_invoice,invoice.jumlah_bayar,invoice.total_potongan,customer.id_cust,
																	 customer.kode,customer.email,customer.deposit,customer_grup.kode_cgrup,customer_grup.id_cgrup');
        $this->datatables->from('invoice');
        $this->datatables->join('customer', 'invoice.id_cust=customer.id_cust');
				$this->datatables->join('customer_grup', 'invoice.id_cgrup=customer_grup.id_cgrup');
				if($this->session->userdata('level') == "sales" || $this->session->userdata('level') == "saleso"){
					$this->datatables->where('id_pendaftar',$this->session->userdata('id_pengguna'));
				}else if($this->session->userdata('level') == "crm"){
					$this->datatables->where('id_crm',$this->session->userdata('id_pengguna'));
				}
				$this->db->order_by('invoice.status_invoice','asc');
				$this->db->order_by('invoice.id_invoice','desc');
				$q="$1";
        $this->datatables->where('invoice.tipe_invoice','tt');
				$this->datatables->where('invoice.status_invoice !=','2');
				$this->datatables->add_column('mark_transaksi', '$1','kode_mark_transaksi(id_cust,id_cgrup,kode,kode_cgrup)');
        $this->datatables->add_column('view', '

          <div class="btn-group">
                  <button type="button" class="btn btn-success btn-xs"><i class="fa fa-envelope"></i></button>
                  <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">

                    <li><a href="'.base_url().'admin/sendmail/mail_invoice/$1/$8" class="submitt" data-email="$6" data-kode_invoice="$2"
                         data-id_transaksi="$7" data-id_cust="$8">
                    Send Mail Pending</a></li>

                    <li><a href="'.base_url().'admin/sendmail/mail_payment/$1/$8" class="submitt" data-kode="$1" data-email="$6">
                    Send Mail Process</a></li>

                    <li><a href="'.base_url().'admin/sendmail/mail_complete/$1/$8" class="submitt" data-kode="$1" data-email="$6">
                    Send Mail Complete</a></li>

                  </ul>
                </div>

              <div class="btn-group">
                  <button type="button" class="btn btn-danger btn-xs"><i class="fa fa-print"></i></button>
                  <button type="button" class="btn btn-danger btn-xs dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">

                    <li><a href="'.base_url().'admin/public_c/invoice_admin/$1" target="_blank" >
                    Invoice</a></li>

                    <li><a href="'.base_url().'admin/public_c/payment_admin/$1" target="_blank" >
                    Process</a></li>

                  </ul>
                </div>

          <a href="javascript:void(0);" class="lunas_inv btn btn-warning btn-xs" data-id_invoice="$1" data-kode_invoice="$2" data-total_tagihan="$4"
          data-status_invoice="$3" data-jumlah_bayar="$7" data-deposit="$5" data-total_potongan="$8" data-kode="$6"><i class="fa  fa-credit-card"></i></a>

          <a href="javascript:void(0);" onclick="bayar_deposit('.$q.')" class="btn btn-warning btn-xs" alt="deposit"><i class="fa fa-money"></i></a>

          <a href="'.site_url().'admin/invoice/detail/$1" class="btn btn-info btn-xs"> <i class="fa fa-ellipsis-h"></i></a>',

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
		$this->datatables->where('invoice.tipe_invoice','tt');
		$this->datatables->where('invoice.id_cust',$id)->where('invoice.status_invoice !=','2');
		$this->datatables->add_column('mark_transaksi', '$1','kode_mark_transaksi(id_cust,id_cgrup,kode,kode_cgrup)');
		$this->datatables->add_column('view', '

			<div class="btn-group">
							<button type="button" class="btn btn-success btn-xs"><i class="fa fa-envelope"></i></button>
							<button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
							</button>
							<ul class="dropdown-menu" role="menu">

								<li><a href="'.base_url().'admin/sendmail/mail_invoice/$1/$8" class="submitt" data-email="$6" data-kode_invoice="$2"
										 data-id_transaksi="$7" data-id_cust="$8">
								Send Mail Pending</a></li>

								<li><a href="'.base_url().'admin/sendmail/mail_payment/$1/$8" class="submitt" data-kode="$1" data-email="$6">
								Send Mail Process</a></li>

								<li><a href="'.base_url().'admin/sendmail/mail_complete/$1/$8" class="submitt" data-kode="$1" data-email="$6">
								Send Mail Complete</a></li>

							</ul>
						</div>

					<div class="btn-group">
							<button type="button" class="btn btn-danger btn-xs"><i class="fa fa-print"></i></button>
							<button type="button" class="btn btn-danger btn-xs dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
							</button>
							<ul class="dropdown-menu" role="menu">

								<li><a href="'.base_url().'admin/public_c/invoice_admin/$1" target="_blank" >
								Invoice</a></li>

								<li><a href="'.base_url().'admin/public_c/payment_admin/$1" target="_blank" >
								Process</a></li>

							</ul>
						</div>

			<a href="javascript:void(0);" class="lunas_inv btn btn-warning btn-xs" data-id_invoice="$1" data-kode_invoice="$2" data-total_tagihan="$4"
			data-status_invoice="$3" data-jumlah_bayar="$7" data-deposit="$5" data-total_potongan="$8" data-kode="$6"><i class="fa  fa-credit-card"></i></a>

			<a href="javascript:void(0);" onclick="bayar_deposit('.$q.')" class="btn btn-warning btn-xs" alt="deposit"><i class="fa fa-money"></i></a>

			<a href="'.site_url().'admin/invoice/detail/$1" class="btn btn-info btn-xs"> <i class="fa fa-ellipsis-h"></i></a>',

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
		$this->datatables->where('invoice.tipe_invoice','tt');
		$q="$1";
		$this->datatables->where('customer.id_cgrup',$id)->where('invoice.status_invoice !=','2');
		$this->datatables->add_column('mark_transaksi', '$1','kode_mark_transaksi(id_cust,id_cgrup,kode,kode_cgrup)');
		$this->datatables->add_column('view', '

			<div class="btn-group">
							<button type="button" class="btn btn-success btn-xs"><i class="fa fa-envelope"></i></button>
							<button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
							</button>
							<ul class="dropdown-menu" role="menu">

								<li><a href="'.base_url().'admin/sendmail/mail_invoice/$1/$8" class="submitt" data-email="$6" data-kode_invoice="$2"
										 data-id_transaksi="$7" data-id_cust="$8">
								Send Mail Pending</a></li>

								<li><a href="'.base_url().'admin/sendmail/mail_payment/$1/$8" class="submitt" data-kode="$1" data-email="$6">
								Send Mail Process</a></li>

								<li><a href="'.base_url().'admin/sendmail/mail_complete/$1/$8" class="submitt" data-kode="$1" data-email="$6">
								Send Mail Complete</a></li>

							</ul>
						</div>

					<div class="btn-group">
							<button type="button" class="btn btn-danger btn-xs"><i class="fa fa-print"></i></button>
							<button type="button" class="btn btn-danger btn-xs dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
							</button>
							<ul class="dropdown-menu" role="menu">

								<li><a href="'.base_url().'admin/public_c/invoice_admin/$1" target="_blank" >
								Invoice</a></li>

								<li><a href="'.base_url().'admin/public_c/payment_admin/$1" target="_blank" >
								Process</a></li>

							</ul>
						</div>

			<a href="javascript:void(0);" class="lunas_inv btn btn-warning btn-xs" data-id_invoice="$1" data-kode_invoice="$2" data-total_tagihan="$4"
			data-status_invoice="$3" data-jumlah_bayar="$7" data-deposit="$5" data-total_potongan="$8" data-kode="$6"><i class="fa  fa-credit-card"></i></a>

			<a href="javascript:void(0);" onclick="bayar_deposit('.$q.')" class="btn btn-warning btn-xs" alt="deposit"><i class="fa fa-money"></i></a>

			<a href="'.site_url().'admin/invoice/detail/$1" class="btn btn-info btn-xs"> <i class="fa fa-ellipsis-h"></i></a>',

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
    //get data invoice per id
  function data_invoice($id){
    $this->db->select('invoice.*,customer.*');
    $this->db->from('invoice');
    $this->db->join('customer', 'invoice.id_cust=customer.id_cust', 'left');
    $this->db->where('invoice.id_invoice',$id, 'left');
    //$param = array('id_order'=>$id);
    return $this->db->get('');
  }
    //get per id invoice dipakai di beberapa controller
  function data_invoice_id($id){
    $this->db->select('invoice.*,customer_grup.*,customer.*');
    $this->db->from('invoice');
    $this->db->join('customer', 'invoice.id_cust=customer.id_cust', 'left');
    $this->db->join('customer_grup', 'customer.id_cgrup=customer_grup.id_cgrup', 'left');
    $this->db->where('invoice.id_invoice',$id, 'left');
    //$param = array('id_order'=>$id);
    return $this->db->get('');
  }

  function data_transaksi_id($id){

    $this->db->select('invoice.*,transaksi.*,customer.*,customer_grup.*');
    $this->db->from('transaksi');

    $this->db->join('invoice', 'transaksi.id_invoice=invoice.id_invoice', 'left');
    $this->db->join('customer', 'transaksi.id_cust=customer.id_cust', 'left');
		$this->db->join('customer_grup', 'transaksi.id_cgrup=customer_grup.id_cgrup', 'left');

    $this->db->where('invoice.id_invoice',$id, 'left');

    //$param = array('id_order'=>$id);
    return $this->db->get('');


  }
  //by id customer
  function data_invoice_id2($id){

    $this->db->select('invoice.*,transaksi.*,customer.*');
    $this->db->from('invoice');

    $this->db->join('transaksi', 'invoice.id_transaksi=transaksi.id_transaksi', 'left');
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
     $cekkode= $this->db->query("SELECT max(kode_pembelian) as maxkode FROM pembelian")->result();
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

	public function get_kurs(){
    $this->db->where('id_kurs',1);

    return $this->db->get('kurs');
  }

  	function pinvoice($data)
  {
      $data_inv= $this->data_invoice_id($this->input->post('id_invoice'));
      foreach($data_inv->result() as $krs ){
				$id_cust=$krs->id_cust;
				$id_cgrup=$krs->id_cgrup;
        $jml_bayar=$krs->jumlah_bayar;
        $jmlh_potongan=$krs->total_potongan;
        $ei=$krs->encrypt_invoice;
				$kcustomer=$krs->kode;
	      $ecustomer=$krs->email;
				$kgrup=$krs->kode_cgrup;
	      $egrup=$krs->email_cgrup;
				$nama_customer=$krs->nama;
	      $nama_customergrup=$krs->nama_cgrup;
				$whatsapp_customer=$krs->whatsapp;
				$whatsapp_customergrup=$krs->whatsapp_cgrup;
				$id_referal = $krs->id_referal;
      }

			$data_krs= $this->get_kurs();
      foreach($data_krs->result() as $kr ){
            $kurs_jual=$kr->kurs_jual;
            $kurs_beli=$kr->kurs_beli;
						$komisi_global_titip_trf=$kr->komisi_titip_trf;
      }
			$kodeaktif = $kcustomer;
			$namaaktif = $nama_customer;
			if($id_cgrup > 0){
				 $whatsappaktif = $whatsapp_customergrup;
         $status_invoice="grup";
 				 $emailaktif= $egrup;
				 $cust_id = 0;
 			}else if($id_cgrup <= 0){
				 $whatsappaktif = $whatsapp_customer;
         $status_invoice="customer";
 				 $emailaktif= $ecustomer;
				 $cust_id = $id_cust;
 			}
      $total_bayar=($this->input->post('total_tagihan')-$jml_bayar)-$jmlh_potongan;

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
      $pembayaran['total_dibayar'] = $this->input->post('total_tagihan');
      //$pembayaran['keterangan_bayar'] = "Untuk pelunasan pembayaran invoice ".$this->input->post('kode_invoice')." Sebesar ".$pembayaran['jumlah_bayar'];
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
      $subbayar['jumlah_bayar_sub'] = $total_bayar;
      $this->db->insert('sub_pembayaran', $subbayar);

      $inv['jumlah_bayar'] = $this->input->post('total_tagihan') - $jmlh_potongan;
      $inv['status_invoice'] =1;
      $this->db->where('id_invoice',$this->input->post('id_invoice'));
      $this->db->update('invoice', $inv);

      $trs['status'] =2;
      $this->db->where('id_invoice',$this->input->post('id_invoice'));
      $this->db->update('transaksi', $trs);

			$cektransaksi=$this->data_transaksi_id($this->input->post('id_invoice'))->result();
			foreach ($cektransaksi as $rowcek ) {
				if($rowcek->jumlah_rmb >= 10000){
					$pembelian['kode_pembelian'] = $this->kode_pembelian();
		      $pembelian['id_transaksi'] = $rowcek->id_transaksi;
					$pembelian['keterangan_pembelian']= " ";
		      $pembelian['tanggal_pembelian'] = date('Y-m-d');
		      $pembelian['status_pembelian'] = 1;
					$this->db->insert('pembelian', $pembelian);
					$id_pembelian = $this->db->insert_id();

					$data_rmb1 = $this->db->get('kurs')->row();
					$kurs_beli1= $data_rmb1->kurs_beli;
					// transaksi
					$transaksi_u['kurs_beli'] = $kurs_beli1;
					$transaksi_u['id_pembelian'] = $id_pembelian;
					$this->db->where('id_transaksi',$rowcek->id_transaksi);
					$this->db->update('transaksi', $transaksi_u);

					$infokechina="Transaksi Titip Transfer Masuk dengan Kode Transaksi ".$rowcek->kode_transaksi." Silahkan Cek Di office.wilopocargo.com Untuk Detail";
					sendwhatsapp($infokechina,'085318999004');
				}else if($rowcek->jumlah_rmb < 10000){
					$data_rmb1 = $this->Mrmb->data_rmb()->row();
					$saldo1    = $data_rmb1->saldo_rmb;
					$kurs_beli1= $data_rmb1->kurs_beli_rmb;
					$transaksi_u['kurs_beli'] = $kurs_beli1;
					$this->db->where('id_transaksi',$rowcek->id_transaksi);
					$this->db->update('transaksi', $transaksi_u);

					$infokechina="Transaksi Titip Transfer Masuk dengan Kode Transaksi ".$rowcek->kode_transaksi." Silahkan Cek Di office.wilopocargo.com Untuk Detail";
					sendwhatsapp($infokechina,'081212110961');
				}
			}
			$sumrmb = $this->db->select('sum(jumlah_rmb + jumlah_rmb2) as totalrmb')->from('transaksi')->where('id_invoice',$this->input->post('id_invoice'))->get()->row();

			if($id_referal != 0){
				$get_referal = $this->db->where('id_cust',$id_cust)->get('customer')->row();
				if($get_referal->komisi_titip_trf == 0){
					$komisifix = $komisi_global_titip_trf * $sumrmb->totalrmb;
					$ket_komisi = "Komisi Referal Global : ".$komisi_global_titip_trf." * Jumlah Rmb : ".$sumrmb->totalrmb;
				}else{
					$komisifix = $get_referal->komisi_titip_trf * $sumrmb->totalrmb;
					$ket_komisi = "Komisi Referal Khusus : ".$get_referal->komisi_titip_trf." * Jumlah Rmb : ".$sumrmb->totalrmb;
				}
				$input_referal['id_cust'] = $id_referal;
				$input_referal['kode_komisi'] = $this->Mkomisi_referal->kode_komisi();
				$input_referal['customer'] = $kodeaktif;
				$input_referal['id_invoice'] = $this->input->post('id_invoice');
				$input_referal['nilai'] = $komisifix;
				$input_referal['keterangan'] = $ket_komisi;
				$input_referal['status'] = 2;
				// input
				$this->db->insert('komisi_referal', $input_referal);

        $data_komisi  = $this->db->where('id_invoice',$this->input->post('id_invoice'))->get('komisi_referal');
        $get_komisi   = $data_komisi->row();
        $deposit_ref  = $this->db->where('id_cust',$id_referal)->get('customer')->row();

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

      $kc     = $kodeaktif;
      $ki     = $this->input->post('kode_invoice');
      $encrypt= $ei;
      $id     = $this->input->post('id_invoice');

      $tst['status']=1;
			$tst['record']= $this->Mpembayaran->data_invoiceid($id)->result();
      $tst['rincian']= $this->rincian_inv($id)->result();
      $data = $this->load->view('admin/invoice/pdf_invoice',$tst,True);

      $mpdf = new \Mpdf\Mpdf();

      //$data = $this->load->view('hasilPrint', [], TRUE);
      $mpdf->WriteHTML($data);
			$mpdf->Output("pdf_file/".time()."pay.pdf" ,'F');
			$time=time()."pay.pdf";
      $content = $mpdf->Output('', 'S');

			$pesan = "*Yth. Bpk/Ibu ".$namaaktif." (".$kodeaktif.")*\n\nTerima kasih telah melakukan pembayaran \nBerikut kami lampirkan Invoice Terbayar ".$ki.
							 "\nTransaksi Anda sedang kami proses, harap tunggu info selanjutnya dari kami.\nTerima kasih atas kerja samanya :)".
							 "\n\n*Wilopo Cargo* _(do not reply)_";

			sendwhatsapp($pesan,$whatsappaktif);
	 		$sendoc_cust = send_newdoc($time,$whatsappaktif,$ki);

	 		sendwhatsapp($pesan,"081310961108");
	 		$senddoc=send_newdoc($time,"081310961108",$ki);

      $this->load->library('email', $config);
      $this->email->attach($content, 'attachment', $ki , 'application/pdf');
      $path_unlink = './'.'Payment_TT_Wilopo.pdf';
     //unlink($path_unlink );
		 $the_message="<html>
													<body>
																	<h3>Yth. Bpk/Ibu ".$namaaktif." (".$kodeaktif.") ,</h3>
																	<p>Terima kasih telah melakukan pembayaran untuk ".$ki." </p>
																	<p>Transaksi Anda sedang kami proses, harap tunggu email selanjutnya dari kami</p>
																	".nama_perusahaan()."

													</body>
										</html>";
    //$this->load->library('email', $config);
    $this->email->set_newline("\r\n");
    $this->email->from(user_email());
    $this->email->to($emailaktif,"gusmavin@gmail.com"); //email tujuan. Isikan dengan emailmu!
    $this->email->subject('[Wilopo Cargo] Pembayaran '.$ki.' telah kami terima');
    $this->email->message($the_message);
    if($this->email->send())
    {
			if($senddoc && $sendoc_cust){
				$path_unlink = './'.$time;
				unlink($path_unlink );
			}
    }
    else
    {
      //show_error($this->email->print_debugger());
    }

 		//sendwhatsapp($pesan1,$whatsappaktif);
    $this->session->set_flashdata('msg','invoiceok');
    redirect(site_url('admin/invoice'));

  }

  function invdeposit($data)
  {
      $data_inv= $this->data_invoice_id($this->input->post('id_invoice'));
			foreach($data_inv->result() as $krs ){
				$id_cust=$krs->id_cust;
				$id_cgrup=$krs->id_cgrup;
				$ttl_tagihan=$krs->total_tagihan;
				$jml_bayar=$krs->jumlah_bayar;
				$jmlh_potongan=$krs->total_potongan;
				$ei=$krs->encrypt_invoice;
				$kcustomer=$krs->kode;
				$ecustomer=$krs->email;
				// $deposit=$krs->deposit;
				$kgrup=$krs->kode_cgrup;
				$egrup=$krs->email_cgrup;
				$nama_customer=$krs->nama;
	      $nama_customergrup=$krs->nama_cgrup;
				$deposit_customer = $krs->deposit;
        $deposit_cgrup = $krs->deposit_cgrup;
				$whatsapp_customer=$krs->whatsapp;
				$whatsapp_customergrup=$krs->whatsapp_cgrup;
				$id_referal = $krs->id_referal;
      }

			$data_krs= $this->get_kurs();
      foreach($data_krs->result() as $kr ){
            $kurs_jual=$kr->kurs_jual;
            $kurs_beli=$kr->kurs_beli;
      }
			$kodeaktif = $kcustomer;
			$namaaktif = $nama_customer;
			if($id_cgrup > 0){
				 $whatsappaktif = $whatsapp_customergrup;
         $status_invoice="grup";
 				 $emailaktif= $egrup;
				 $deposit = $deposit_cgrup;
 			}else if($id_cgrup <= 0){
				 $whatsappaktif = $whatsapp_customer;
         $status_invoice="customer";
 				 $emailaktif= $ecustomer;
				 $deposit = $deposit_customer;
 			}

      $jmlbyr = $ttl_tagihan - ($jml_bayar + $jmlh_potongan);
				// print_r($ttl_tagihan);die();
      if($deposit >= $jmlbyr){

		      $potongan['id_invoice'] = $this->input->post('id_invoice');
		      $potongan['id_jenis_potongan'] = 1;
		      $potongan['jumlah_potongan'] = $jmlbyr;
		      $potongan['keterangan_potongan'] = "Potongan Untuk Invoice Titip Transfer";

		      $this->db->insert('potongan', $potongan);

		      $inv['total_potongan'] = $ttl_tagihan - $jml_bayar;
		      $inv['status_invoice'] =1;

		      $this->db->where('id_invoice',$this->input->post('id_invoice'));
		      $this->db->update('invoice', $inv);

		      $trs['status'] =2;

		      $this->db->where('id_invoice',$this->input->post('id_invoice'));
		      $this->db->update('transaksi', $trs);

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

		      // $dpst['id_cust'] = $id_cust;
		      $dpst['nominal_deposit'] = $jmlbyr;
		      $dpst['tipe_deposit'] ="keluar";
		      $dpst['keterangan_deposit'] ="Pemotongan Deposit Untuk Pelunasan Pembayaran Invoice ".$this->input->post('kode_invoice');
					$dpst['tanggal_deposit'] = date('Y-m-d');
		      $this->db->insert('deposit', $dpst);

					$cektransaksi=$this->data_transaksi_id($this->input->post('id_invoice'))->result();
					foreach ($cektransaksi as $rowcek ) {
						if($rowcek->jumlah_rmb >= 10000){
							$pembelian['kode_pembelian'] = $this->kode_pembelian();
				      $pembelian['id_transaksi'] = $rowcek->id_transaksi;
							$pembelian['keterangan_pembelian']= " ";
				      $pembelian['tanggal_pembelian'] = date('Y-m-d');
				      $pembelian['status_pembelian'] = 1;
							$this->db->insert('pembelian', $pembelian);
							$id_pembelian = $this->db->insert_id();

							$transaksi_u['id_pembelian'] = $id_pembelian;
							$this->db->where('id_transaksi',$rowcek->id_transaksi);
							$this->db->update('transaksi', $transaksi_u);
						}else if($rowcek->jumlah_rmb < 10000){
							$data_rmb1 = $this->Mrmb->data_rmb()->row();
							$saldo1    = $data_rmb1->saldo_rmb;
							$kurs_beli1= $data_rmb1->kurs_beli_rmb;
							$transaksi_u['kurs_beli'] = $kurs_beli1;
							$this->db->where('id_transaksi',$rowcek->id_transaksi);
							$this->db->update('transaksi', $transaksi_u);

							$infokechina="Transaksi Titip Transfer Masuk dengan Kode Transaksi ".$rowcek->kode_transaksi." Silahkan Cek Di office.wilopocargo.com Untuk Detail";
							sendwhatsapp($infokechina,'081212110961');
						}
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

          $kc     = $kodeaktif;
          $ki     = $this->input->post('kode_invoice');
          $encrypt= $ei;
          $id     = $this->input->post('id_invoice');

          $tst['status']=1;
					$tst['record']= $this->Mpembayaran->data_invoiceid($id)->result();
          $tst['rincian']= $this->rincian_inv($id)->result();
          $data = $this->load->view('admin/invoice/pdf_invoice',$tst,True);

          $mpdf = new \Mpdf\Mpdf();
		      //$data = $this->load->view('hasilPrint', [], TRUE);
		      $mpdf->WriteHTML($data);
					$mpdf->Output("pdf_file/".time()."pay.pdf" ,'F');
					$time=time()."pay.pdf";
		      $content = $mpdf->Output('', 'S');

					$pesan = "*Yth. Bpk/Ibu ".$namaaktif." (".$kodeaktif.")*\n\nTerima kasih telah melakukan pembayaran \nBerikut kami lampirkan Invoice Terbayar ".$ki.
									 "\nTransaksi Anda sedang kami proses, harap tunggu info selanjutnya dari kami.\nTerima kasih atas kerja samanya :)".
									 "\n\n*Wilopo Cargo* _(do not reply)_";

					sendwhatsapp($pesan,$whatsappaktif);
 			 		$sendoc_cust = send_newdoc($time,$whatsappaktif,$ki);

 			 		sendwhatsapp($pesan,"081310961108");
 			 		$senddoc=send_newdoc($time,"081310961108",$ki);

		      $this->load->library('email', $config);
		      $this->email->attach($content, 'attachment', $ki , 'application/pdf');
					$the_message="<html>
															 <body>
																			 <h3>Yth. Bpk/Ibu ".$namaaktif." (".$kodeaktif.") ,</h3>
																			 <p>Terima kasih telah melakukan pembayaran untuk ".$ki." </p>
																			 <p>Transaksi Anda sedang kami proses, harap tunggu email selanjutnya dari kami</p>
																			 ".nama_perusahaan()."

															 </body>
												 </html>";
		    //$this->load->library('email', $config);
		    $this->email->set_newline("\r\n");
		    $this->email->from(user_email());
		    $this->email->to("gusmavin@gmail.com"); //email tujuan. Isikan dengan emailmu!
		    $this->email->subject('[Wilopo Cargo] Pembayaran '.$ki.' telah kami terima');
		    $this->email->message($the_message);
		    if($this->email->send())
		    {
					if($senddoc && $sendoc_cust){
						$path_unlink = './'.$time;
						unlink($path_unlink );
					}
		    }
		    else
		    {
		      //show_error($this->email->print_debugger());
		    }


 				//sendwhatsapp($pesan1,$whatsappaktif);

    }else if($deposit < $jmlbyr){

      $potongan['id_invoice'] = $this->input->post('id_invoice');
      $potongan['id_jenis_potongan'] = 1;
      $potongan['jumlah_potongan'] = $deposit;
      $potongan['keterangan_potongan'] = "Potongan Untuk Invoice Titip Transfer";

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

      redirect(site_url('admin/invoice'));


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

  function data_potongan($id){

    $this->db->select('potongan.*,invoice.*,jenis_potongan.*');
    $this->db->from('potongan');
    $this->db->join('invoice', 'potongan.id_invoice=invoice.id_invoice', 'left');
    $this->db->join('jenis_potongan', 'potongan.id_jenis_potongan=jenis_potongan.id_jenis_potongan', 'left');

    $this->db->where('potongan.id_invoice',$id, 'left');

    //$param = array('id_order'=>$id);
    return $this->db->get('');


  }


}
