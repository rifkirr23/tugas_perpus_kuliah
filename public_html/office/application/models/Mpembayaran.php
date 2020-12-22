<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mpembayaran extends CI_Model {

  public function __construct(){
    parent::__construct();
    $this->load->model('Mbank');
    $this->load->model('Minvoice_barang');
  }
  //Proses Get Data pembayaran
  function get_pembayaran() {
        $this->datatables->select('customer.kode,pembayaran.id_pembayaran,pembayaran.kode_pembayaran,
                                   pembayaran.tanggal_bayar,pembayaran.jumlah_bayar,pembayaran.keterangan_bayar
                                   ,customer.id_cust,customer_grup.kode_cgrup,customer_grup.id_cgrup');
        $this->datatables->from('pembayaran');
        $this->datatables->join('sub_pembayaran', 'pembayaran.id_pembayaran=sub_pembayaran.id_pembayaran');
        $this->datatables->join('invoice', 'sub_pembayaran.id_invoice=invoice.id_invoice');
        $this->datatables->join('customer', 'invoice.id_cust=customer.id_cust');
        $this->datatables->join('customer_grup', 'customer.id_cgrup=customer_grup.id_cgrup');
        $this->db->order_by('pembayaran.id_pembayaran','desc');
        $this->db->group_by('pembayaran.id_pembayaran');
        $q="$2";
        $this->datatables->add_column('view', '
            <a href="javascript:void(0);" onclick="view_image('.$q.')" class="btn btn-danger btn-xs" alt="Update Data"> <i class="fa fa-file-image-o"></i></a>
            <a href="javascript:void(0);" onclick="view_keterangan('.$q.')" class="btn btn-warning btn-xs" alt="Update Data"> <i class="fa fa-sticky-note-o"></i></a>
            <a href="'.site_url().'admin/pembayaran/cancel_pembayaran/$2" onclick="return confirm(`Delete Pembayaran?`);" class="btn btn-primary btn-xs" alt="Update Data"> <i class="fa fa-close"></i></a>

            ',  'kode,id_pembayaran,kode_pembayaran,tanggal_bayar,jumlah_bayar,keterangan_bayar,id_cust');
        return $this->datatables->generate();
  }

  function get_pembayaran_byid($id) {
        $this->datatables->select('customer.kode,pembayaran.id_pembayaran,pembayaran.kode_pembayaran,pembayaran.tanggal_bayar,pembayaran.jumlah_bayar,pembayaran.keterangan_bayar');
        $this->datatables->from('pembayaran');
        $this->datatables->join('customer', 'pembayaran.id_cust=customer.id_cust');
        $this->datatables->where('pembayaran.id_cust',$id);
        $this->db->order_by('pembayaran.id_pembayaran','desc');
        $q="$2";
        $this->datatables->add_column('view', '
            <a href="javascript:void(0);" onclick="view_image_pembayaran('.$q.')" class="btn btn-danger btn-xs" alt="Update Data"> <i class="fa fa-file-image-o"></i></a>

            <a href="javascript:void(0);" onclick="view_keterangan('.$q.')" class="btn btn-warning btn-xs" alt="Update Data"> <i class="fa fa-sticky-note-o"></i></a>

            ',  'kode,id_pembayaran,kode_pembayaran,tanggal_bayar,jumlah_bayar,keterangan_bayar,id_cust');
        return $this->datatables->generate();
  }

  function get_pembayaran_byidgrup($id) {
        $this->datatables->select('customer.kode,pembayaran.id_pembayaran,pembayaran.kode_pembayaran,pembayaran.tanggal_bayar,pembayaran.jumlah_bayar,pembayaran.keterangan_bayar');
        $this->datatables->from('pembayaran');
        $this->datatables->join('customer', 'pembayaran.id_cust=customer.id_cust');
        $this->datatables->where('customer.id_cgrup',$id);
        $this->db->order_by('pembayaran.id_pembayaran','desc');
        $q="$2";
        $this->datatables->add_column('view', '
            <a href="javascript:void(0);" onclick="view_image_pembayaran('.$q.')" class="btn btn-danger btn-xs" alt="Update Data"> <i class="fa fa-file-image-o"></i></a>

            <a href="javascript:void(0);" onclick="view_keterangan('.$q.')" class="btn btn-warning btn-xs" alt="Update Data"> <i class="fa fa-sticky-note-o"></i></a>

            ',  'kode,id_pembayaran,kode_pembayaran,tanggal_bayar,jumlah_bayar,keterangan_bayar,id_cust');
        return $this->datatables->generate();
  }

  //by id
  function data_pembayaran_id($id){

    $this->db->select('pembayaran.*,customer.*');
    $this->db->from('pembayaran');
    $this->db->join('customer', 'pembayaran.id_cust=customer.id_cust', 'left');
    $this->db->where('pembayaran.id_cust',$id);
    //$param = array('id_order'=>$id);
    return $this->db->get('');

  }

  function get_keterangan($id){

    $this->db->select('keterangan_pembayaran.*');
    $this->db->from('keterangan_pembayaran');
    $this->db->where('keterangan_pembayaran.id_pembayaran',$id);
    return $this->db->get('');

  }

  function get_keterangan1($id){
    $this->db->select('pembayaran.*');
    $this->db->from('pembayaran');
    $this->db->limit(1);
    $this->db->where('pembayaran.id_pembayaran',$id);
    return $this->db->get('');
  }

  function sub_pembayaran_id($id){
    $this->db->select('sub_pembayaran.*,pembayaran.*,invoice.*');
    $this->db->from('sub_pembayaran');
    $this->db->join('pembayaran', 'sub_pembayaran.id_pembayaran=pembayaran.id_pembayaran', 'left');
    $this->db->join('invoice', 'sub_pembayaran.id_invoice=invoice.id_invoice', 'left');
    $this->db->where('sub_pembayaran.id_invoice',$id);
    //$param = array('id_order'=>$id);
    return $this->db->get('');

  }

   function getfile_bb_cust($id){
    $this->db->select('*');
    $this->db->from('bukti_bayar_customer');
    //$this->db->join('customer', 'transaksi.id_cust=customer.id_cust', 'left');
    $this->db->where('id_pembayaran',$id);
    return $query = $this->db->get();
   }

  function data_barcode($id){
    $this->db->where('resi_id',$id);
    return $this->db->get('giw');
  }

  function code_pembayaran(){
    $hcekkode= $this->db->select('kode_pembayaran as maxkode')->order_by('id_pembayaran','desc')->get('pembayaran')->row();
    $kodesaatini= $hcekkode->maxkode;
    $ambilkode= str_replace('WC/BAYAR/','',$kodesaatini);
    if($ambilkode=="")
    {
     $ambilkode=0;
    }
    $kodejadi= $ambilkode+1;

    $hasil= $kodejadi;
    return 'WC/BAYAR/'.$hasil;
  }

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

  public function get_invoice($id_cust){
    $this->db->where('status_invoice',0);
    $this->db->where('id_cust', $id_cust);
    $this->db->order_by('id_cust', 'desc');
    $result = $this->db->get('invoice')->result(); // Tampilkan semua data kota berdasarkan id provinsi
    return $result;
  }

  public function get_invoicegrup($id){
    return $this->db->select('invoice.*')
              ->from('invoice')
              ->join('customer', 'customer.id_cust=invoice.id_cust', 'left')
              ->where('status_invoice',0)
              ->where('customer.id_cgrup', $id)
              ->order_by('invoice.tanggal_invoice', 'desc')
              ->get()->result(); // Tampilkan semua data kota berdasarkan id provinsi

  }

  public function get_invoice2($id_invoice){
    $this->db->where('status_invoice',0);
    $this->db->where_in('id_invoice', $id_invoice);
    $result = $this->db->get('invoice')->result(); // Tampilkan semua data kota berdasarkan id provinsi
    return $result;
  }

  public function get_id($id){
    $this->db->where('kode',$id);
    return $this->db->get('pembayaran');
  }

  public function get_inv($id){
    $this->db->select('invoice.*,customer.*');
    $this->db->from('invoice');
    $this->db->join('customer', 'invoice.id_cust=customer.id_cust', 'left');
    $this->db->where_in('invoice.id_invoice',$id);
    return $this->db->get('');
  }

  public function get_inv_tt($id){
    $this->db->select('invoice.*,customer.*');
    $this->db->from('invoice');
    $this->db->join('customer', 'invoice.id_cust=customer.id_cust', 'left');
    $this->db->where_in('invoice.id_invoice',$id);
    $this->db->where('invoice.tipe_invoice','tt');
    return $this->db->get('');
  }

  public function get_inv_barang($id){
    $this->db->select('invoice.*,resi.*,customer.*');
    $this->db->from('invoice');
    $this->db->join('resi', 'invoice.id_resi=resi.id_resi', 'left');
    $this->db->join('customer', 'invoice.id_cust=customer.id_cust', 'left');
    $this->db->where_in('invoice.id_invoice',$id);
    $this->db->where('invoice.tipe_invoice','barang');
    return $this->db->get('');
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

  public function get_cust_email($id){
   $this->db->where('id_cust',$id);
   return $this->db->get('customer');
  }

 public function get_custgrup_email($id){
  $this->db->where('id_cgrup',$id);
  return $this->db->get('customer_grup');
 }

  public function get_inv_one($id){
    $this->db->where('status_invoice',0);
    $this->db->where('id_invoice',$id);
    return $this->db->get('invoice');
  }

  public function get_inv_cust($id){
    $this->db->where('status_invoice',0);
    $this->db->where('id_cust',$id);
    $this->db->order_by('id_invoice','ASC');
    $this->db->limit(1);

    return $this->db->get('invoice');
  }

  public function get_kurs(){
    $this->db->where('id_kurs',1);
    return $this->db->get('kurs');
  }

    function save($data){
      $kode = $this->input->post('kode');
      $kodeg= $this->input->post('kode_cgrup');
      $id_cgrup= "";
      $data_cust_email= $this->get_cust_email($kode);
      foreach($data_cust_email->result() as $c ){
        $nama_customer=$c->nama;
        $email_customer=$c->email;
        $whatsapp_customer =$koderow->whatsapp;
        $kode_customer=$c->kode;
        $deposit=$c->deposit;
        $id_referal=$c->id_referal;
        $id_cgrup=$c->id_cgrup;
        $id_cust=$c->id_cust;
      }

      if($id_cgrup == ""){
        $id_cgrup  = $kodeg;
      }

      $data_kurs= $this->get_kurs();
      foreach($data_kurs->result() as $krs ){
            $kurs_jual=$krs->kurs_jual;
            $kurs_beli=$krs->kurs_beli;
      }

      $data_custgrup_email= $this->get_custgrup_email($kodeg);
      foreach($data_custgrup_email->result() as $cg ){
        $email_customergrup=$cg->email_cgrup;
        $nama_customergrup=$cg->nama_cgrup;
        $whatsapp_customergrup=$cg->whatsapp_cgrup;
        $kode_customergrup=$cg->kode_cgrup;
        $depositgrup=$cg->deposit_cgrup;
      }

      $data_bank= $this->Mbank->get_dbank($this->input->post('id_bank'));
      foreach($data_bank->result() as $dbank ){
       $sbank    =$dbank->saldo_bank;
      }

      if($kodeg > 0){
         $kodeaktif = $kode_customergrup;
         $namaaktif = $nama_customergrup;
         $status_invoice="grup";
  			 $kode =0;
  			 $emailaktif= $email_customergrup;
         $whatsappaktif= $whatsapp_customergrup;
			}else if($kodeg <= 0){
         $kodeaktif = $kode_customer;
         $namaaktif = $nama_customer;
         $status_invoice="customer";
				 $kodeg =0;
				 $emailaktif= $email_customer;
         $whatsappaktif= $whatsapp_customer;
			}else	if($kode=="" && $kodeg==""){
				 $this->session->set_flashdata('msg','gagal_input');
				 redirect(site_url('admin/transaksi/newt'));
			}
      // dd($kode);
      // print_r($kode);die();
      $h=date('H')+5;
      $i=date('i');
      $s=date('s');
      //data Pelanggan
      $pembayaran['id_cust'] = $kode;
      $pembayaran['id_cgrup'] = $kodeg;
      $pembayaran['kode_pembayaran'] = $this->input->post('kode_pembayaran');
      $pembayaran['tanggal_bayar'] = date('Y-m-d '.$h.'-'.$i.'-'.$s,strtotime($this->input->post('tanggal_bayar')));
      $pembayaran['jumlah_bayar'] = $this->input->post('jumlah_bayar');
      $pembayaran['total_dibayar'] = $this->input->post('jumlah_bayar');

      $this->db->insert('pembayaran', $pembayaran);
      $last_id = $this->db->insert_id();

      $trb['id_jenis_transaksi_bank'] = 1;
      $trb['id_bank'] = $this->input->post('id_bank');
      $trb['tipe_transaksi_bank'] = "masuk";
      $trb['nominal_transaksi_bank'] = $pembayaran['jumlah_bayar'];

      $trb['keterangan_transaksi_bank'] = "Penambahan Saldo dari Pembayaran ".$pembayaran['kode_pembayaran'];
      $trb['tanggal_transaksi_bank'] = date('Y-m-d');
      $trb['sisa_saldo_bank'] = $sbank + $pembayaran['jumlah_bayar'];

      $this->db->insert('transaksi_bank', $trb);

      $bank['saldo_bank'] = $trb['sisa_saldo_bank'];
      $bank['edit_saldo'] = 1;

      	$this->db->where('id_bank',$this->input->post('id_bank'));
        $this->db->update('master_bank', $bank);

      foreach ($_FILES['file_bb_cust']['name'] as $key => $image) {
       // print_r($image."<br>");
       if($_FILES['file_bb_cust']['name'][$key] == "")
        {
          // no action
        }else{

          move_uploaded_file($_FILES["file_bb_cust"]["tmp_name"][$key], './assets/bukti_bayar_cust/'.$_FILES["file_bb_cust"]["name"][$key]);
          $file_bb_cust=$_FILES["file_bb_cust"]["name"][$key];
          $bb_cust['id_pembayaran'] = $last_id;
          $bb_cust['file_bb_cust'] = $file_bb_cust;
         // die($_FILES['file_bb_cust']['name'][$key]);
            $this->db->insert('bukti_bayar_customer', $bb_cust);
        //$this->Mtransaksi->save_bb_cust($file_bb_cust);
       }
     }

      $id_invoice = $this->input->post('id_invoice');
      $ja=count($id_invoice);

    if($this->input->post('sisa_billing') > 0){
        if($kodeg=="" || $kodeg==0){
          $cust['deposit'] =$deposit + $this->input->post('sisa_billing');
          $this->db->where('id_cust',$kode);
          $this->db->update('customer', $cust);
        }else if($kode=="" || $kode==0){
          $cust['deposit_cgrup'] =$depositgrup + $this->input->post('sisa_billing');
          $this->db->where('id_cgrup',$kodeg);
          $this->db->update('customer_grup', $cust);
        }

        $dpst['id_cust'] =$kode;
        $dpst['id_cgrup'] =$kodeg;
        $dpst['nominal_deposit'] =$this->input->post('sisa_billing');
        $dpst['tipe_deposit'] ="masuk";
        $dpst['keterangan_deposit'] ="Deposit masuk dari Pembayaran ".$pembayaran['kode_pembayaran'];
        $dpst['tanggal_deposit'] = date('Y-m-d');
        $this->db->insert('deposit', $dpst);

        $kpmbyrn1['id_pembayaran'] =$last_id;
        $kpmbyrn1['keterangan_pembayaran'] ="Sisa bayar masuk ke deposit sebesar Rp." .number_format($this->input->post('sisa_billing'));

        $this->db->insert('keterangan_pembayaran', $kpmbyrn1);

        $id_invoice = $this->input->post('id_invoice');
        $jarr=count($id_invoice);
        $test="";
        for($ff=0;$ff<$jarr;$ff++){
            $data_inv= $this->get_inv($id_invoice[$ff]);
            foreach($data_inv->result() as $c ){
                $kdinv=$c->kode_invoice;
                $ttlghn=$c->total_tagihan;
                $jmlbyr=$c->jumlah_bayar;
                $ttl_potongan=$c->total_potongan;

                $hcount= $ttlghn - ($jmlbyr + $ttl_potongan) ;

                $kdis = "Pembayaran Invoice ".$kdinv." Sebesar Rp. ".number_format($hcount);

                $kpmbyrn2['id_pembayaran'] =$last_id;
                $kpmbyrn2['keterangan_pembayaran'] = $kdis;

                $this->db->insert('keterangan_pembayaran', $kpmbyrn2);

            }

         }

    }else if($this->input->post('sisa_billing') < 0){

      $last_array = end($id_invoice);
      $data_inv3= $this->get_inv_one($last_array);
      foreach($data_inv3->result() as $b ){
        $kode_inv1= $b->kode_invoice;
        $total_tagihan3=$b->total_tagihan;
        $jumlah_bayar3=$b->jumlah_bayar;
        $total_potongan3=$b->total_potongan3;
      }

      $sub_bayar['id_invoice'] = $last_array;
      $sub_bayar['id_pembayaran'] = $last_id;
      $sub_bayar['jumlah_bayar_sub'] = ($total_tagihan3 - ($jumlah_bayar3 + $total_potongan3)) + ($this->input->post('sisa_billing'));

      $this->db->insert('sub_pembayaran', $sub_bayar);

      $kpmbyrn3['id_pembayaran'] =$last_id;
      $kpmbyrn3['keterangan_pembayaran'] = 'Sub Pembayaran ke Invoice '.$kode_inv1.' Sebesar Rp. '.number_format($sub_bayar['jumlah_bayar_sub']);

      $this->db->insert('keterangan_pembayaran', $kpmbyrn3);

      if($ja == 1){
       array_pop($id_invoice);
      }else if($ja > 1){

        array_pop($id_invoice);
        $jc=count($id_invoice);

        $test="";
        for($ff=0;$ff<$jc;$ff++){
          $data_inv= $this->get_inv($id_invoice[$ff]);
          foreach($data_inv->result() as $c ){
              $kdinv=$c->kode_invoice;
              $ttlghn=$c->total_tagihan;
              $jmlbyr=$c->jumlah_bayar;
              $ttl_ptngn=$c->total_potongan;

              $hcount= $ttlghn - ($jmlbyr + $ttl_ptngn);
              $kdis = "Pembayaran Invoice ".$kdinv." Sebesar Rp. ".number_format($hcount);
              $kpmbyrn4['id_pembayaran'] =$last_id;
              $kpmbyrn4['keterangan_pembayaran'] = $kdis;
              $this->db->insert('keterangan_pembayaran', $kpmbyrn4);
          }

        }

      }

      $invoice4['jumlah_bayar'] =$jumlah_bayar3 + $sub_bayar['jumlah_bayar_sub'];
      $this->db->where('kode_invoice',$kode_inv1);
      $this->db->update('invoice', $invoice4);
  }

      $jb=count($id_invoice);
      if($jb < 1){

      }else{
       $insertArray = array();
       $updateArray = array();
       for($ff=0;$ff<$jb;$ff++){
        //die ($id_invoice[$ff]);
        $data_inv= $this->get_inv($id_invoice[$ff]);
        foreach($data_inv->result() as $c ){
          $total_tagihan2=$c->total_tagihan;
          $jumlah_bayar2=$c->jumlah_bayar;
          $total_potongan2=$c->total_potongan;
          $tipe_invoice=$c->tipe_invoice;
          $id_sj=$c->id_surat_jalan;
          $id_custnya = $c->id_cust;
        }

        $data_surat_jalan = $this->db->where('id_sj',$id_sj)->get('invoice_product')->row();
        $idsj_rts = $data_surat_jalan->id_sj_rts;
        curl_setopt($curl_handle,CURLOPT_URL,'http://office.rtsekspedisi.com/api/a_invoice/alamat_sj');
        curl_setopt($curl_handle, CURLOPT_POST, 1);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "id_sj_rts=$idsj_rts&alamat=$alamat_customer");
        $res = curl_exec($curl_handle);
        curl_close($curl_handle);

        $r=$total_tagihan2;
        $r2=$jumlah_bayar2;
        $r3=$total_potongan2;

        $rr=$r-($r2 + $r3);
        $insertArray[] = array(
          'id_invoice'=>$id_invoice[$ff],
          'id_pembayaran'=>$last_id,
          'jumlah_bayar_sub'=>$rr,
        );

       $updateArray[] = array(
         'id_invoice'=>$id_invoice[$ff],
         'status_invoice'=>1,
         'jumlah_bayar'=>$r-$r3,
       );
       if($tipe_invoice == "barang"){
         $this->Minvoice_barang->info_gudang($id_invoice[$ff]);
         $idinvjual = $id_invoice[$ff];
    		 $cek_customer = $this->db->select('customer.fix_alamat')->from('customer')
    															->where('id_cust',$id_custnya)
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
       }else if($tipe_invoice == "tt"){
         $cektransaksi=$this->rincian_inv($id_invoice[$ff])->result();
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
        }//foreach tt
       }//else if tipe inv

      }
      $this->db->insert_batch('sub_pembayaran',$insertArray);
      $this->db->update_batch('invoice',$updateArray,'id_invoice');

      $content = "";
      $data    = "";
      for($ff=0;$ff<$jb;$ff++){
        $data_inv= $this->get_inv($id_invoice[$ff]);
        foreach($data_inv->result() as $c ){
            $ki=$c->kode_invoice;
            $tt=$c->total_tagihan;
            $ei=$c->encrypt_invoice;
            $jbr=$c->jumlah_bayar;
            $ii=$c->id_invoice;
            $kc=$c->kode;
            $tipeinv = $c->tipe_invoice;
            $deposit_customer = $c->deposit;
            $id_referal_cust  = $c->id_referal;
         }

         if($id_referal_cust != 0){
           $data_komisi  = $this->db->where('id_invoice',$id_invoice[$ff])->get('komisi_referal');
           $get_komisi   = $data_komisi->row();
           $deposit_ref  = $this->db->where('id_cust',$id_referal_cust)->get('customer')->row();

           $update_komisi['status'] = 2;
           $this->db->where('id_invoice',$id_invoice[$ff]);
           $this->db->update('komisi_referal', $update_komisi);
           if($data_komisi->num_rows() > 0){
             $dpst['id_cust']  = $id_referal_cust;
             $dpst['id_cgrup'] = 0;
             $dpst['nominal_deposit'] = $get_komisi->nilai ;
             $dpst['tipe_deposit'] ="masuk";
             $dpst['keterangan_deposit'] =$get_komisi->kode_komisi ." cair (".$get_komisi->keterangan.")";
             $dpst['tanggal_deposit'] = date('Y-m-d');
             $this->db->insert('deposit', $dpst);

             $customer['deposit'] =$deposit_ref->deposit + $get_komisi->nilai;
             $this->db->where('id_cust',$id_referal_cust);
             $this->db->update('customer', $customer);
           }
         }

         $trs['status'] =2;

          $this->db->where('id_invoice',$id_invoice[$ff]);
          $this->db->update('transaksi', $trs);

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

            $encrypt= $ei;
            $id     = $id_invoice[$ff];
            // status
            $tst['status']=1;
            // cek tipe INVOICE
            if($tipeinv == "barang"){
              $test['record_asuransi'] = $this->Minvoice_barang->cek_asuransi($id)->result();
              $test['record']= $this->data_invoiceid($id)->row();
              $test['barcode']= $this->Minvoice_barang->getinvoice_product($id)->result();
      				$test['potongan']=$this->Minvoice_barang->data_potongan($id)->result();
             	$data = $this->load->view('admin/invoice_barang/pdf_invoice',$test,True);
              $pesan = "*Yth. Bpk/Ibu ".$namaaktif." (".$kodeaktif.")*\n\nTerima kasih telah melakukan pembayaran \nBerikut kami lampirkan Invoice Terbayar ".$ki.
      								"\nBarang anda akan segera kami kirim ke alamat anda (Estimasi 1-5 hari).\nTerima kasih atas kerja samanya :)".
      								"\n\n*Wilopo Cargo* _(do not reply)_";

              $the_message="<html>
                                   <body>
                                           <h3>Yth. Bpk/Ibu  ".$kodeaktif." ,</h3>
                                           <p>Terima kasih telah melakukan pembayaran untuk ".$ki." , Berikut kami lampirkan Invoice Terbayar.
                                           Barang anda akan segera kami kirim ke alamat anda (Estimasi 1-5 hari)</p>
                                           <p>".nama_perusahaan()."</p>

                                   </body>
                             </html>";
            }else if($tipeinv == "tt"){
							$tst['record']= $this->data_invoiceid($id)->result();
              $tst['rincian']= $this->rincian_inv($id)->result();
              $data = $this->load->view('admin/invoice/pdf_invoice',$tst,True);
              // Pesan
              $pesan = "*Yth. Bpk/Ibu ".$namaaktif." (".$kodeaktif.")*\n\nTerima kasih telah melakukan pembayaran \nBerikut kami lampirkan Invoice Terbayar ".$ki.
                       "\nTransaksi Anda sedang kami proses, harap tunggu info selanjutnya dari kami.\nTerima kasih atas kerja samanya :)".
                       "\n\n*Wilopo Cargo* _(do not reply)_";
              $the_message="<html>
                                  <body>
                                          <h3>Yth. Bpk/Ibu ".$namaaktif." (".$kodeaktif.") ,</h3>
                                          <p>Terima kasih telah melakukan pembayaran untuk ".$ki." </p>
                                          <p>Transaksi Anda sedang kami proses, harap tunggu email selanjutnya dari kami</p>
                                          ".nama_perusahaan()."

                                  </body>
                            </html>";
            }
            $mpdf = new \Mpdf\Mpdf();

             $mpdf->WriteHTML($data);
             $mpdf->Output("pdf_file/".time()."pay.pdf" ,'F');
       			 $time=time()."pay.pdf";
             $content = $mpdf->Output('', 'S');

             //$infokechina="Transaksi Titip Transfer Masuk , Silahkan Cek Di Aplikasi Untuk Detail";
          		//sendwhatsapp($infokechina,'081293972529');
            sendwhatsapp($pesan,$whatsappaktif);
       		  send_newdoc($time,$whatsappaktif,$ki);

       		  sendwhatsapp($pesan,"081310961108");
       		  $senddoc=send_newdoc($time,"081310961108",$ki);

            $this->load->library('email', $config);
            $this->email->attach($content, 'attachment', $ki, 'application/pdf');

          $this->email->set_newline("\r\n");
          $this->email->from(user_email());
          $this->email->to($emailaktif,'gusmavin@gmail.com'); //email tujuan. Isikan dengan emailmu!
          $this->email->subject('[Wilopo Cargo] Pembayaran '.$ki.' telah kami terima');
          $this->email->message($the_message);
          if($this->email->send())
          {
            if($senddoc){
             $path_unlink = './'.$time;
             unlink($path_unlink );
            }
          }
          else
          {
            //show_error($this->email->print_debugger());
          }
    		  //sendwhatsapp($pesan1,$whatsappaktif);
      }


    }

    $this->session->set_flashdata('msg','success');
    redirect(site_url('admin/pembayaran'));



 }



  function deleted($data)
  {                       //data Pelanggan
      $pembayaran['aktif'] = '1';

        $this->db->where('id_cust',$this->input->post('id_cust'));
        $this->db->update('pembayaran', $pembayaran);

        redirect(site_url('admin/pembayaran'));


  }
}
