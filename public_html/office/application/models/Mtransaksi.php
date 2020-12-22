<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mtransaksi extends CI_Model {

	public function __construct(){
		parent::__construct();
     $this->load->model('Mrmb');
		 $this->load->model('Mkomisi_referal');
	}
	//Proses Get Data transaksi
	function get_transaksi() {
        $this->datatables->select('transaksi.id_transaksi,transaksi.id_cust,transaksi.id_cgrup,transaksi.kode_transaksi,transaksi.tanggal_transaksi,
															 		 transaksi.jumlah_rmb,transaksi.kurs_jual,transaksi.kurs_beli,transaksi.bank_tujuan,transaksi.file_bank_tujuan,transaksi.status,
																	 transaksi.input_name,transaksi.fee_bank,transaksi.fee_cs,transaksi.kurs_beli2,transaksi.jumlah_rmb2,customer.kode,invoice.kode_invoice,transaksi.id_invoice,
																	 customer_grup.kode_cgrup');
        $this->datatables->from('transaksi');
				$this->datatables->join('customer', 'transaksi.id_cust=customer.id_cust');
				$this->datatables->join('customer_grup', 'transaksi.id_cgrup=customer_grup.id_cgrup');
        $this->datatables->join('invoice', 'transaksi.id_invoice=invoice.id_invoice');
				$this->db->order_by('id_transaksi','desc');
				// $this->datatables->group_by('id_transaksi');
				if($this->session->userdata('level') == "sales" || $this->session->userdata('level') == "saleso"){
					$this->datatables->where('id_pendaftar',$this->session->userdata('id_pengguna'));
				}else if($this->session->userdata('level') == "crm"){
					$this->datatables->where('id_crm',$this->session->userdata('id_pengguna'));
				}
				$this->datatables->where('transaksi.status !=',5);
				$level=$this->session->userdata('level');
        $this->datatables->add_column('view', '$1','status_transaksi(id_invoice,kode_invoice,bank_tujuan,file_bank_tujuan,kode_transaksi,id_transaksi,status,'.$level.')');
				$this->datatables->add_column('mark_transaksi', '$1','kode_mark_transaksi(id_cust,id_cgrup,kode,kode_cgrup)');
				$this->datatables->add_column('total_rmb', '$1','c_total_rmb(jumlah_rmb,jumlah_rmb2)');
        return $this->datatables->generate();
  }

  function get_transaksi2() {
		$this->datatables->select('transaksi.id_transaksi,transaksi.id_cust,transaksi.id_cgrup,transaksi.kode_transaksi,transaksi.tanggal_transaksi,
															 transaksi.jumlah_rmb,transaksi.kurs_jual,transaksi.kurs_beli,transaksi.bank_tujuan,transaksi.file_bank_tujuan,transaksi.status,
															 transaksi.input_name,transaksi.fee_bank,transaksi.fee_cs,transaksi.kurs_beli2,transaksi.jumlah_rmb2,customer.kode,invoice.kode_invoice,transaksi.id_invoice,
															 customer_grup.kode_cgrup');
		$this->datatables->from('transaksi');
		$this->datatables->join('customer', 'transaksi.id_cust=customer.id_cust');
		$this->datatables->join('customer_grup', 'transaksi.id_cgrup=customer_grup.id_cgrup');
		$this->datatables->join('invoice', 'transaksi.id_invoice=invoice.id_invoice');
		$this->db->order_by('status','asc');
		$this->db->order_by('id_transaksi','desc');
		$this->datatables->group_by('id_transaksi');
    $this->datatables->where('transaksi.status >',1);
		$this->datatables->where('transaksi.status <',5);
		$this->datatables->where('transaksi.jumlah_rmb <',10000);
		$level=$this->session->userdata('level');
    $this->datatables->add_column('view', '$1','status_transaksi(id_invoice,kode_invoice,bank_tujuan,file_bank_tujuan,kode_transaksi,id_transaksi,status,'.$level.')');
		$this->datatables->add_column('mark_transaksi', '$1','kode_mark_transaksi(id_cust,id_cgrup,kode,kode_cgrup)');
		$this->datatables->add_column('total_rmb', '$1','c_total_rmb(jumlah_rmb,jumlah_rmb2)');
		//$this->datatables->set_row_attr('style','$1', 'setrowtransaksi(id_cust)');
    return $this->datatables->generate();
  }

  function get_transaksi_byid($id) {
		$this->datatables->select('transaksi.id_transaksi,transaksi.id_cust,transaksi.id_cgrup,transaksi.kode_transaksi,transaksi.tanggal_transaksi,
															 transaksi.jumlah_rmb,transaksi.kurs_jual,transaksi.kurs_beli,transaksi.bank_tujuan,transaksi.file_bank_tujuan,transaksi.status,
															 transaksi.input_name,transaksi.fee_bank,transaksi.fee_cs,transaksi.kurs_beli2,transaksi.jumlah_rmb2,customer.kode,invoice.kode_invoice,transaksi.id_invoice,
															 customer_grup.kode_cgrup');
		$this->datatables->from('transaksi');
		$this->datatables->join('customer', 'transaksi.id_cust=customer.id_cust');
		$this->datatables->join('customer_grup', 'transaksi.id_cgrup=customer_grup.id_cgrup');
		$this->datatables->join('invoice', 'transaksi.id_invoice=invoice.id_invoice');
		$this->datatables->where('transaksi.status !=',5);
		$this->datatables->where('transaksi.id_cust',$id);
		$level=$this->session->userdata('level');
		$this->datatables->add_column('view', '$1','status_transaksi(id_invoice,kode_invoice,bank_tujuan,file_bank_tujuan,kode_transaksi,id_transaksi,status,'.$level.')');
		$this->datatables->add_column('mark_transaksi', '$1','kode_mark_transaksi(id_cust,id_cgrup,kode,kode_cgrup)');
		$this->datatables->add_column('total_rmb', '$1','c_total_rmb(jumlah_rmb,jumlah_rmb2)');
		return $this->datatables->generate();
  }

	function get_transaksi_byidgrup($id) {
		$this->datatables->select('transaksi.id_transaksi,transaksi.id_cust,transaksi.id_cgrup,transaksi.kode_transaksi,transaksi.tanggal_transaksi,
															 transaksi.jumlah_rmb,transaksi.kurs_jual,transaksi.kurs_beli,transaksi.bank_tujuan,transaksi.file_bank_tujuan,transaksi.status,
															 transaksi.input_name,transaksi.fee_bank,transaksi.fee_cs,transaksi.kurs_beli2,transaksi.jumlah_rmb2,customer.kode,invoice.kode_invoice,transaksi.id_invoice,
															 customer_grup.kode_cgrup');
		$this->datatables->from('transaksi');
		$this->datatables->join('customer', 'transaksi.id_cust=customer.id_cust');
		$this->datatables->join('customer_grup', 'transaksi.id_cgrup=customer_grup.id_cgrup');
		$this->datatables->join('invoice', 'transaksi.id_invoice=invoice.id_invoice');
		$this->datatables->where('transaksi.status !=',5);
		$this->datatables->where('customer.id_cgrup',$id);
		$level=$this->session->userdata('level');
		$this->datatables->add_column('view', '$1','status_transaksi(id_invoice,kode_invoice,bank_tujuan,file_bank_tujuan,kode_transaksi,id_transaksi,status,'.$level.')');
		$this->datatables->add_column('mark_transaksi', '$1','kode_mark_transaksi(id_cust,id_cgrup,kode,kode_cgrup)');
		$this->datatables->add_column('total_rmb', '$1','c_total_rmb(jumlah_rmb,jumlah_rmb2)');
		return $this->datatables->generate();
  }

  function data_transaksi($id){
    $this->db->select('transaksi.id_transaksi,transaksi.kode_transaksi,transaksi.id_cust,transaksi.id_cgrup,transaksi.tanggal_transaksi,transaksi.jumlah_rmb,
											 transaksi.kurs_jual,transaksi.kurs_beli,transaksi.bank_tujuan ,transaksi.file_bank_tujuan,transaksi.status,
											 transaksi.input_name,transaksi.fee_bank,transaksi.fee_cs,transaksi.id_invoice,customer.kode,customer_grup.kode_cgrup');
    $this->db->from('transaksi');
    $this->db->join('customer', 'transaksi.id_cust=customer.id_cust', 'left');
		$this->db->join('customer_grup', 'transaksi.id_cgrup=customer_grup.id_cgrup', 'left');
    $this->db->where('transaksi.id_transaksi',$id);
    return $query = $this->db->get();
  }
  //by id
  function data_transaksi2($id){
  	$this->db->select('transaksi.id_transaksi,transaksi.kode_transaksi,transaksi.id_cust,transaksi.tanggal_transaksi,transaksi.jumlah_rmb,transaksi.kurs_jual,transaksi.kurs_beli,transaksi.bank_tujuan ,transaksi.file_bank_tujuan,transaksi.status,transaksi.input_name,customer.kode,transaksi.fee_bank,transaksi.fee_cs,invoice.kode_invoice,invoice.id_invoice');
    $this->db->from('transaksi');
    $this->db->join('customer', 'transaksi.id_cust=customer.id_cust', 'left');
    $this->db->join('invoice', 'transaksi.id_invoice=invoice.id_invoice', 'left');
    $this->db->where('transaksi.id_cust',$id);
    return $query = $this->db->get();
  }

  function getfile_bb_rmb($id){
    $this->db->select('bukti_bayar_rmb.*');
    $this->db->from('bukti_bayar_rmb');
    $this->db->where('bukti_bayar_rmb.id_transaksi',$id);
    return $query = $this->db->get();
  }

  function data_invoice($encrypt){
    $this->db->select('invoice.*,customer.*');
    $this->db->from('invoice');
    $this->db->join('customer', 'invoice.id_cust=customer.id_cust', 'left');
    $this->db->where('invoice.id_invoice',$encrypt, 'left');
    //$param = array('id_order'=>$id);
    return $this->db->get('');
  }

	function data_invoiceid($id){
    $this->db->select('invoice.*,customer.*');
    $this->db->from('invoice');
    $this->db->join('customer', 'invoice.id_cust=customer.id_cust', 'left');
    $this->db->where('invoice.id_invoice',$id);
    //$param = array('id_order'=>$id);
    return $this->db->get('');
  }

	function grup_invoiceid($id){
    $this->db->select('invoice.*,customer_grup.kode_cgrup as kode,customer_grup.nama_cgrup as nama,customer_grup.alamat_cgrup as alamat,customer_grup.whatsapp_cgrup as whatsapp');
    $this->db->from('invoice');
    $this->db->join('customer_grup', 'invoice.id_cgrup=customer_grup.id_cgrup', 'left');
    $this->db->where('invoice.id_invoice',$id);
    //$param = array('id_order'=>$id);
    return $this->db->get('');
  }

  function rincian_inv($id){
    $this->db->select('transaksi.*');
    $this->db->from('transaksi');
    $this->db->where('transaksi.id_invoice',$id);
    //$param = array('id_order'=>$id);
    return $this->db->get('');
  }

  function code_transaksi(){
	 $hcekkode= $this->db->select('kode_transaksi as maxkode')->order_by('id_transaksi','desc')->get('transaksi')->row();
	 $kodesaatini= $hcekkode->maxkode;
	 $ambilkode= str_replace('TRS/TT/','',$kodesaatini);
	 if($ambilkode=="")
	 {
		$ambilkode=0;
	 }
	 $kodejadi= $ambilkode;

	 $hasil= $kodejadi;
	 return $hasil;
  }

  function code_invoice(){
		$hcekkode= $this->db->select('kode_invoice as maxkode')->where('tipe_invoice','tt')->order_by('id_invoice','desc')->get('invoice')->row();
		$kodesaatini= $hcekkode->maxkode;
		$ambilkode= str_replace('INVOICE/TT/','',$kodesaatini);
	  if($ambilkode=="")
		{
		 $ambilkode=0;
		}
		$kodejadi= $ambilkode+1;

		$hasil= $kodejadi;
		return 'INVOICE/TT/'.$hasil;
   }

	 function code_invoice_tes(){
      $hcekkode= $this->db->select('kode_invoice as maxkode')->where('tipe_invoice','tt')->order_by('id_invoice','desc')->get('invoice')->row();
      $kodesaatini= $hcekkode->maxkode;
      $ambilkode= str_replace('INVOICE/TT/','',$kodesaatini);
 		 if($ambilkode=="")
      {
       $ambilkode=0;
      }
      $kodejadi= $ambilkode+1;

      $hasil= $kodejadi;
      return 'INVOICE/TT/'.$hasil;
    }

  public function select_customer($kode){
    $this->db->select('id_cust,kode');
    $this->db->limit(10);
    $this->db->from('customer');
    $this->db->like('kode', $kode);
    return $this->db->get()->result_array();
  }

	public function select_customergrup($kode){
    $this->db->select('id_cgrup,kode_cgrup');
    $this->db->limit(10);
		$this->db->where('id_cgrup >',0);
    $this->db->from('customer_grup');
    $this->db->like('kode_cgrup', $kode);
    return $this->db->get()->result_array();
  }

	public function get_id($id){
    $this->db->select('customer.*,customer_grup.*');
    $this->db->from("customer");
    $this->db->where('customer.kode',$id);
    $this->db->join('customer_grup', 'customer.id_cgrup=customer_grup.id_cgrup', 'left');
    return $this->db->get();
  }

	public function get_idgrup($id){
    $this->db->where('kode_cgrup',$id);
    return $this->db->get('customer_grup');
  }

	public function get_idcust($id){
		$this->db->select('customer.*,customer_grup.*');
    $this->db->from("customer");
    $this->db->where('customer.id_cust',$id);
    $this->db->join('customer_grup', 'customer.id_cgrup=customer_grup.id_cgrup', 'left');
    return $this->db->get();
  }

	public function get_idcgrup($id){
    $this->db->where('id_cgrup',$id);
    return $this->db->get('customer_grup');
  }

  public function get_image_rmb($id){
    $this->db->where('id_transaksi',$id);
    return $this->db->get('bukti_bayar_rmb');
  }

  //get Customer
  function get_customer(){
    $hsl=$this->db->get('customer');
    return $hsl;
  }

  public function get_kurs(){
    $this->db->where('id_kurs',1);
    return $this->db->get('kurs');
  }

	function salah_bank(){
		$pesan = "Tujuan Bank Salah di Transaksi ".$this->input->post('kode_transaksi');
		sendwhatsapp($pesan,'081293972529');
		$insert['status']  = 4;
		$this->db->where('id_transaksi',$this->input->post('id_transaksi'));
		$this->db->update('transaksi', $insert);
		$this->session->set_flashdata('msg','okbank');
		redirect(site_url('admin/transaksi'));
	}

	function cancel_transaksi(){
		$id_inv = $this->input->post('id_invoice');
		$get_transaksi = $this->db->where('id_invoice',$id_inv)->get('transaksi')->result();
		foreach($get_transaksi as $gettrs){
			$update_pembelian['status_pembelian'] = 3;
			$this->db->where('id_transaksi',$gettrs->id_transaksi);
			$this->db->update('pembelian',$update_pembelian);
		}
		$update_transaksi['status'] = 5;
		$this->db->where('id_invoice',$id_inv);
		$this->db->update('transaksi',$update_transaksi);
		$update_invoice['status_invoice'] = 2;
		$this->db->where('id_invoice',$id_inv);
		$this->db->update('invoice',$update_invoice);
		$this->session->set_flashdata('msg','okcancel');
		redirect(site_url('admin/transaksi'));
	}

	function refund_invoice(){
		$getjumlah = $this->db->select('sum(total_tagihan - total_potongan) as total_refund')->from('invoice')->where('id_invoice',$this->input->post('id_invoice'))->get()->row();
		$total_refund = $getjumlah->total_refund;
		$getbank = $this->db->where('id_bank',1)->get('master_bank')->row();
		$ssaldo  = $getbank->saldo_bank;

		$trb['id_jenis_transaksi_bank'] = 7;
		$trb['id_bank'] = 1;
		$trb['tipe_transaksi_bank'] = "keluar";
		$trb['nominal_transaksi_bank'] = $total_refund;
		$trb['keterangan_transaksi_bank'] = "Refund Transaksi Titip Transfer ".$this->input->post('kode_invoice');
		$trb['tanggal_transaksi_bank'] = date('Y-m-d');
		$trb['sisa_saldo_bank'] = $ssaldo - $total_refund;
		$this->db->insert('transaksi_bank', $trb);
		$last_id = $this->db->insert_id();

		$bank['saldo_bank'] = $ssaldo - $total_refund;
		$bank['edit_saldo'] = 1;
		$this->db->where('id_bank',1);
		$this->db->update('master_bank', $bank);

		$id_inv = $this->input->post('id_invoice');
		$get_transaksi = $this->db->where('id_invoice',$id_inv)->get('transaksi')->result();
		foreach($get_transaksi as $gettrs){
			$update_pembelian['status_pembelian'] = 3;
			$this->db->where('id_transaksi',$gettrs->id_transaksi);
			$this->db->update('pembelian',$update_pembelian);
		}
		$update_transaksi['status'] = 5;
		$this->db->where('id_invoice',$id_inv);
		$this->db->update('transaksi',$update_transaksi);
		$update_invoice['status_invoice'] = 2;
		$this->db->where('id_invoice',$id_inv);
		$this->db->update('invoice',$update_invoice);
		$this->session->set_flashdata('msg','okrefund');
		redirect(site_url('admin/transaksi'));
	}

	function update_bank(){
		foreach ($_FILES['file_bank_tujuan']['name'] as $key => $image) {
		 // print_r("img".time());die();
		 $time = "banktujuan".time();
		 $filename=$_FILES['file_bank_tujuan']['name'][$key];
		 $extension=end(explode(".", $filename));
		 $newfilename=$time .".".$extension;

				if($_FILES['file_bank_tujuan']['name'][$key] == "")
				{

				}else{
					move_uploaded_file($_FILES["file_bank_tujuan"]["tmp_name"][$key], './assets/bank_tujuan/'.$newfilename);
					$file_bank_tujuan=$newfilename;
				}
		}
		$insert['bank_tujuan']  = $this->input->post('bank_tujuan');
		if($file_bank_tujuan != ""){
		$insert['file_bank_tujuan']  = $file_bank_tujuan;
		}
		$cektransaksi = $this->db->where('id_transaksi',$this->input->post('id_transaksi'))->get('transaksi')->row();
		if($cektransaksi->status != 1){
			$insert['status']  = 2;
		}
		$this->db->where('id_transaksi',$this->input->post('id_transaksi'));
		$this->db->update('transaksi', $insert);

		$infokechina="Transaksi".$this->input->post('kode_transaksi')."Bank Tujuan Telah diPerbaharui ";
		sendwhatsapp($infokechina,'081212110961');
		$this->session->set_flashdata('msg','okbank');
		redirect(site_url('admin/transaksi'));
	}

  	function save()
  {
		$kode = $this->input->post('kode');
		$kodeg= $this->input->post('kode_cgrup');

    $data_kurs= $this->get_kurs();
    foreach($data_kurs->result() as $krs ){
      $kurs_jual=$krs->kurs_jual;
      $kurs_beli=$krs->kurs_beli;
      $fee_cs=$krs->fee_cs;
			$komisi_global_titip_trf=$krs->komisi_titip_trf;
    }

		$data_kode= $this->get_id($kode);
    foreach($data_kode->result() as $koderow ){
      $email    =$koderow->email;
	    $whatsapp =$koderow->whatsapp;
			$email_grup     =$koderow->email_cgrup;
			$whatsapp_grup  =$koderow->whatsapp_cgrup;
      $id_cust  =$koderow->id_cust;
      $id_cgrup  =$koderow->id_cgrup;
	    $id_referal=$koderow->id_referal;
	    $namaaktif=$koderow->nama;
	    $kodeaktif=$koderow->kode;
    }

			if($id_cgrup > 0){
			   $status_invoice="grup";
				 $emailaktif= $email_grup;
				 $whatsappaktif= $whatsapp_grup;
			}else{
				 $status_invoice="customer";
				 $emailaktif= $email;
				 $whatsappaktif= $whatsapp;
			}

      $h=date('H');
      $i=date('i');
      $s=date('s');

      $invoice['id_cust']         = $id_cust;
			$invoice['id_cgrup']        = 0;
      $invoice['kode_invoice']    = $this->code_invoice();
      $invoice['tanggal_invoice'] = date('Y-m-d '.$h.'-'.$i.'-'.$s,strtotime($this->input->post('tanggal_transaksi')));
			$invoice['tanggal_kirim']   = date('Y-m-d '.$h.'-'.$i.'-'.$s);
      $invoice['tipe_invoice']    = "tt";
      $invoice['encrypt_invoice'] = md5($invoice['kode_invoice']);
      $invoice['status_invoice']  = 0;

      $this->db->insert('invoice', $invoice);
      $last_id_invoice = $this->db->insert_id();

      $id_array = $this->input->post('jumlah_rmb');
      if($this->input->post('kurs_jual')==""){
          $kj = $kurs_jual;
      }else if($this->input->post('kurs_jual')!=""){
          $kj = str_replace(".", "",$this->input->post('kurs_jual'));
      }

      $bank_tujuan = $this->input->post('bank_tujuan');
      $tt = date('Y-m-d '.$h.'-'.$i.'-'.$s,strtotime($this->input->post('tanggal_transaksi')));
      $in= $this->session->userdata('nama_pengguna').'('.$this->session->userdata('level').')';
      $ja=count($id_array);
      $insertArray = array();

      for($ff=0;$ff<$ja;$ff++){

        $jrmb = str_replace(",", "",$this->input->post('jumlah_rmb'));
        $kode= $this->code_transaksi()+1+$ff;
        $hasil=$kode;
        $resulthasil= 'TRS/TT/'.$hasil;
        //die ($id_invoice[$ff]);
        $tti2 = $tti += $jrmb[$ff];
        error_reporting(0);
        $tfeecs=$fee_cs * $ja;
				$fee_bank = round($jrmb[$ff]/1000,2);

        foreach ($_FILES['file_bank_tujuan']['name'] as $key => $image) {
				// print_r($image."<br>");
            if($_FILES['file_bank_tujuan']['name'][$key] == "")
            {

            }else{
              move_uploaded_file($_FILES["file_bank_tujuan"]["tmp_name"][$key], './assets/bank_tujuan/'.$_FILES["file_bank_tujuan"]["name"][$key]);

              $file_bank_tujuan=$_FILES["file_bank_tujuan"]["name"][$key];

        			//$this->Mtransaksi->save_bb_cust($file_bb_cust);
       			}
				}

        $insertArray[] = array(

        'id_cust'=>$id_cust,
				'id_cgrup'=>$id_cgrup,
        'id_invoice'=>$last_id_invoice,
        'jumlah_rmb'=>$jrmb[$ff],
				'jumlah_rmb2'=>0,
        'bank_tujuan'=>$bank_tujuan[$ff],
        'tanggal_transaksi'=>$tt,
        'kode_transaksi'=>$resulthasil,
        'kurs_jual'=>$kj,
        'kurs_beli'=>0,
				'kurs_beli2'=>0,
        'file_bank_tujuan'=>$_FILES["file_bank_tujuan"]["name"][$ff],
        'status'=>1,
        'input_name'=>$in,
        'fee_cs'=>$fee_cs,
				'fee_bank'=>$fee_bank,

        );

			}

      $this->db->insert_batch('transaksi',$insertArray);

      $invoice2['total_tagihan']    = ($tti2 * $kj) + ($tfeecs * $kj);
      $total_rmb                    = $tti2 + $tfeecs;
      $this->db->where('id_invoice',$last_id_invoice);
      $this->db->update('invoice', $invoice2);

			if($id_referal > 0){
				$get_referal = $this->db->where('id_cust',$id_cust)->get('customer')->row();
				if($get_referal->komisi_titip_trf == 0){
					$komisifix = $komisi_global_titip_trf * $tti2;
					$ket_komisi = "Komisi Referal Global : ".$komisi_global_titip_trf." * Jumlah Rmb : ".$tti2;
				}else{
					$komisifix = $get_referal->komisi_titip_trf * $tti2;
					$ket_komisi = "Komisi Referal Khusus : ".$get_referal->komisi_titip_trf." * Jumlah Rmb : ".$tti2;
				}
				$input_referal['id_cust'] = $id_referal;
				$input_referal['kode_komisi'] = $this->Mkomisi_referal->kode_komisi();
				$input_referal['customer'] = $kodeaktif;
				$input_referal['id_invoice'] = $last_id_invoice;
				$input_referal['nilai'] = $komisifix;
				$input_referal['keterangan'] = $ket_komisi;
				$input_referal['status'] = 1;
				// input
				$this->db->insert('komisi_referal', $input_referal);
			}

  if($last_id_invoice != 0){
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

      $test['status']=0;
      $this->load->model('Minvoice');
	    $test['record']= $this->data_invoiceid($last_id_invoice)->result();
      $test['rincian']= $this->rincian_inv($last_id_invoice)->result();
      $data = $this->load->view('admin/invoice/pdf_invoice',$test,True);

      $mpdf = new \Mpdf\Mpdf();

      $mpdf->WriteHTML($data);
      $mpdf->Output("pdf_file/".time()."inv.pdf" ,'F');
			$time=time()."inv.pdf";
      $content = $mpdf->Output('', 'S');
      $atch=base_url()."pdf_file/".$nama_file;

			$pesan = "*Yth. Bpk/Ibu ".$namaaktif." (".$kodeaktif.")*\n\nBerikut kami lampirkan invoice titip transfer ".$invoice['kode_invoice']." yang harus Anda bayar, yaitu sebesar *Rp.".number_format($invoice2['total_tagihan']).
 		 					"* ke rekening berikut:\n\n*BCA 5810557747 a/n Gusmavin Willopo*\n\nSetelah melakukan pembayaran, harap melakukan konfirmasi pembayaran dengan menghubungi kami melalui telepon / WA.\nTerima kasih atas kerja samanya :)".
 							"\n\n*Wilopo Cargo* _(do not reply)_";
 		  sendwhatsapp($pesan,$whatsappaktif);
 		  $sendoc_cust = send_newdoc($time,$whatsappaktif,$invoice['kode_invoice']);

 		  sendwhatsapp($pesan,whatsapp_direksi());
 		  $sendoc = send_newdoc($time,whatsapp_direksi(),$invoice['kode_invoice']);

      $this->load->library('email', $config);

      $this->email->attach($content, 'attachment', $invoice['kode_invoice'], 'application/pdf');

      $the_message="<html>
                            <body>
                                    <h3>Yth. Bpk/Ibu ".$namaaktif." (".$kodeaktif.") ,</h3>
                                    <p>Berikut terlampir invoice <b>".$invoice['kode_invoice']."</b> yang harus Anda bayar, yaitu sebesar Rp.".number_format($invoice2['total_tagihan'])." ke rekening berikut:</p>
                                		<p><b>BCA 5810557747 a/n Gusmavin Willopo</b></p>
                                    <p>Setelah melakukan pembayaran, harap melakukan konfirmasi pembayaran dengan menghubungi kami melalui telepon / WA.</p>
                                    <p>".nama_perusahaan()."</p>

                            </body>
                      </html>";

    $this->email->set_newline("\r\n");
    $this->email->from(user_email());
    $this->email->to($emailaktif,"gusmavin@gmail.com"); //email tujuan. Isikan dengan emailmu! $emailaktif
    $this->email->subject('[Wilopo Cargo] Invoice Titip Transfer '.$invoice['kode_invoice']);
    $this->email->message($the_message);

    if($this->email->send())
    {
			if($sendoc && $sendoc_cust){
 			 $path_unlink = './'.$time;
 			 unlink($path_unlink );
 		  }
    }
    else
    {
      //show_error($this->email->print_debugger());
    }

  }else{
      echo "Transaksi Gagal";
  }

  $this->session->set_flashdata('msg','success');
  redirect(site_url('admin/transaksi'));

  }

  function update()
  {
		// print_r($this->input->post('id_transaksi'));die();
		$data_rmb= $this->Mrmb->data_rmb();
		foreach($data_rmb->result() as $rm ){
				$saldo_rmb=$rm->saldo_rmb;
				$kurs_beli_rmb=$rm->kurs_beli_rmb;
				$id_rmb = $rm->id_rmb;
		}
		$data_rmb2= $this->Mrmb->data_rmb2();
		foreach($data_rmb2->result() as $rm2 ){
				$saldo_rmb2=$rm2->saldo_rmb;
				$kurs_beli_rmb2=$rm2->kurs_beli_rmb;
				$id_rmb2 = $rm2->id_rmb;
		}
		$feecs= str_replace(".", "",$this->input->post('fee_cs'));
		$jrmb = $this->input->post('jumlah_rmb');
		$total_rmb=$jrmb + $feecs + $this->input->post('fee_bank');

		if($total_rmb > ($saldo_rmb + $saldo_rmb2)){
			$this->session->set_flashdata('msg','saldo_takcukup');
	    redirect(site_url('admin/transaksi'));
		}
		$no = 1;
	  foreach ($_FILES['file_bb_rmb']['name'] as $key => $image) {
			$time = "buktirmb".time().$no; $no++;
 		  $filename=$_FILES['file_bb_rmb']['name'][$key];
 		  $extension=end(explode(".", $filename));
 		  $newfilename=$time .".".$extension;
	    if($_FILES['file_bb_rmb']['name'][$key] == "")
	    {

	    }else{
		      move_uploaded_file($_FILES["file_bb_rmb"]["tmp_name"][$key], './assets/bukti_bayar_rmb/'.$newfilename);

					$imagepath = $newfilename;
			    $save = "./assets/bukti_bayar_rmb/" . $imagepath; //This is the new file you saving
			    $file = "./assets/bukti_bayar_rmb/" . $imagepath; //This is the original file
					// print_r($save);die();
			    list($width, $height) = getimagesize($file) ;
					if($width > 1500){
						$modwidth = 800;

						$diff = ceil($width / $modwidth);

						$modheight = $height / $diff;
						$tn = imagecreatetruecolor($modwidth, $modheight) ;
						$image = imagecreatefromjpeg($file) ;
						imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ;

						imagejpeg($tn, $save, 100) ;
					}

		      $file_bb_rmb=$newfilename;

		      $bb_rmb['id_transaksi'] = $this->input->post('id_transaksi');
		      $bb_rmb['file_bb_rmb'] = $file_bb_rmb;
		      $this->db->insert('bukti_bayar_rmb', $bb_rmb);
		      //$this->Mtransaksi->save_bb_cust($file_bb_cust);
	     }
	  }
		$data_kode= $this->get_idcust($this->input->post('id_cust'));
		foreach($data_kode->result() as $koderow ){
			$email     =$koderow->email;
			$whatsapp  =$koderow->whatsapp;
			$email_grup     =$koderow->email_cgrup;
			$whatsapp_grup  =$koderow->whatsapp_cgrup;
			$id_cust   =$koderow->id_cust;
			$id_cgrup  =$koderow->id_cgrup;
			$id_referal=$koderow->id_referal;
			$namaaktif =$koderow->nama;
			$kodeaktif =$koderow->kode;
		}

			if($id_cgrup > 0){
				 $status_invoice="grup";
				 $emailaktif= $email_grup;
				 $whatsappaktif= $whatsapp_grup;
			}else{
				 $status_invoice="customer";
				 $emailaktif= $email;
				 $whatsappaktif= $whatsapp;
			}

			$h=date('H');  $i=date('i');    $s=date('s');

			if($saldo_rmb > $total_rmb){
				$rmbb['jumlah_trmb'] = $total_rmb;
				$rmbb['id_rmb'] = $id_rmb;
	      $rmbb['keterangan_rmb'] = "Transaksi Titip Transfer".$this->input->post('kode_transaksi');
	      $rmbb['tanggal_rmb'] = date('Y-m-d '.$h.'-'.$i.'-'.$s);
				$rmbb['tipe_trmb'] = "keluar";
				$rmbb['sisa_saldo_trmb'] = $saldo_rmb - $total_rmb;
				$rmbb['kurs_trmb'] = $kurs_beli_rmb;
	      $this->db->insert('transaksi_rmb', $rmbb);
	      $last_id = $this->db->insert_id();

	      $masterrmb['saldo_rmb'] = $saldo_rmb - $total_rmb;
	      $this->db->where('status_rmb',1);
	      $this->db->update('rmb', $masterrmb);

				$jumlah_rmb=$jrmb;
				$jumlah_rmb2=0;
				$kurs_beli=$kurs_beli_rmb;
				$kurs_beli2=0;
			}else if($saldo_rmb < $total_rmb){
				$lainlain=$feecs + $this->input->post('fee_bank');
				if($saldo_rmb >= $jrmb){
					$jumlah_rmb = $jrmb;
					$jumlah_rmb2= 0;
				}else if($saldo_rmb <= $jrmb){
					$jumlah_rmb = $saldo_rmb;
					$jumlah_rmb2= $jrmb - $saldo_rmb;
			  }

				$kurs_beli  = $kurs_beli_rmb;
				$kurs_beli2 = $kurs_beli_rmb2;
				$sisa_rmb   = $total_rmb - $saldo_rmb;

				$rmbb['jumlah_trmb'] = $saldo_rmb;
				$rmbb['id_rmb'] = $id_rmb;
	      $rmbb['keterangan_rmb'] = "Transaksi Titip Transfer".$this->input->post('kode_transaksi');
	      $rmbb['tanggal_rmb'] = date('Y-m-d '.$h.'-'.$i.'-'.$s);
				$rmbb['tipe_trmb'] = "keluar";
				$rmbb['sisa_saldo_trmb'] = 0;
				$rmbb['kurs_trmb'] = $kurs_beli_rmb;
	      $this->db->insert('transaksi_rmb', $rmbb);
	      $last_id = $this->db->insert_id();

	      $rmb2['saldo_rmb'] = 0;
	      $this->db->where('status_rmb',1);
	      $this->db->update('rmb', $rmb2);

				$rmbb2['jumlah_trmb'] = $sisa_rmb;
				$rmbb2['id_rmb'] = $id_rmb2;
	      $rmbb2['keterangan_rmb'] = "Transaksi Titip Transfer".$this->input->post('kode_transaksi');
	      $rmbb2['tanggal_rmb'] = date('Y-m-d '.$h.'-'.$i.'-'.$s);
				$rmbb2['tipe_trmb'] = "keluar";
				$rmbb2['sisa_saldo_trmb'] = $saldo_rmb2 - $sisa_rmb;
				$rmbb2['kurs_trmb'] = $kurs_beli_rmb2;
	      $this->db->insert('transaksi_rmb', $rmbb2);
	      $last_id = $this->db->insert_id();

	      $masterrmb2['saldo_rmb'] = $saldo_rmb2 - $sisa_rmb;
				$masterrmb2['status_rmb'] = 1;
	      $this->db->where('status_rmb',2);
	      $this->db->update('rmb', $masterrmb2);

				$masterrmb3['status_rmb'] = 2;
	      $this->db->where('status_rmb',1);
				$this->db->where('saldo_rmb',0);
	      $this->db->update('rmb', $masterrmb3);
			}

			$tdrmb['jumlah_tdrmb'] = $total_rmb;
			$tdrmb['formula_tdrmb'] = $jrmb."+".$feecs."+".$this->input->post('fee_bank');
			$tdrmb['keterangan_tdrmb'] = "Transaksi Titip Transfer".$this->input->post('kode_transaksi');
			$tdrmb['tanggal_tdrmb'] = date('Y-m-d '.$h.'-'.$i.'-'.$s);
			$tdrmb['tipe_tdrmb'] = "keluar";
			$this->db->insert('transaksi_detail_rmb', $tdrmb);

      //$transaksi['id_cust'] = $id_cust;
      //$transaksi['tanggal_transaksi'] = $this->input->post('tanggal_transaksi');
      $transaksi['jumlah_rmb'] = $jumlah_rmb;
			$transaksi['jumlah_rmb2'] = $jumlah_rmb2;
      $transaksi['bank_tujuan'] = $this->input->post('bank_tujuan');
      $transaksi['fee_bank'] = $this->input->post('fee_bank');
      $transaksi['fee_cs'] = str_replace(".", "",$this->input->post('fee_cs'));

      $transaksi['kurs_jual'] = str_replace(".", "",$this->input->post('kurs_jual'));
      $transaksi['kurs_beli'] = $kurs_beli;
			$transaksi['kurs_beli2'] = $kurs_beli2;
      $transaksi['bank_tujuan'] = $this->input->post('bank_tujuan');
			$transaksi['status'] = 3;

      if($file_lampiran1==""){

      }else{
          $transaksi['file_bank_tujuan'] = str_replace("/", "", $file_lampiran1);;
      }

      $this->db->where('id_transaksi',$this->input->post('id_transaksi'));
      $this->db->update('transaksi', $transaksi);

			$data_rmb= $this->get_image_rmb($this->input->post('id_transaksi'));
			// Send Whatsapp
			$pesan = "*Yth. Bpk/Ibu ".$namaaktif." (".$kodeaktif.")*\n\nTransaksi ".$this->input->post('kode_transaksi')." telah selesai.".
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
                                <p>Transaksi ".$this->input->post('kode_transaksi')." telah selesai</p>
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
    $this->email->to($emailaktif,"gusmavin@gmail.com"); //email tujuan. Isikan dengan emailmu!
    $this->email->subject('[Wilopo Cargo] Transaksi '.$this->input->post('kode_transaksi').' telah selesai');
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
    redirect(site_url('admin/transaksi'));


  }

  function deleted($data)
  {                       //data Pelanggan
      $transaksi['aktif'] = '1';

      	$this->db->where('id_cust',$this->input->post('id_cust'));
        $this->db->update('transaksi', $transaksi);

        redirect(site_url('admin/transaksi'));


  }
}
