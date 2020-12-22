<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mpembayaran_beli extends CI_Model {

  public function __construct(){
    parent::__construct();
    $this->load->model('Mbank');
  }
  //Proses Get Data pembayaran
  function get_pembayaran_beli() {
      $this->datatables->select('vendor.nama_vendor,pembayaran_beli.id_pembel,pembayaran_beli.kode_pembel,pembayaran_beli.tanggal_pembel,
                                 pembayaran_beli.jumlah_pembel');
      $this->datatables->from('pembayaran_beli');
      $this->datatables->join('vendor', 'pembayaran_beli.id_vendor=vendor.id_vendor');
      $this->db->order_by('pembayaran_beli.id_pembel','desc');
      $q="$2";
      $this->datatables->add_column('view', '
          <a href="javascript:void(0);" onclick="view_image('.$q.')" class="btn btn-danger btn-xs" alt="Update Data"> <i class="fa fa-file-image-o"></i></a>
          <a href="javascript:void(0);" onclick="view_keterangan('.$q.')" class="btn btn-warning btn-xs" alt="Update Data"> <i class="fa fa-sticky-note-o"></i></a>
          <a href="'.site_url().'admin/pembayaran_beli/cancel_pembel/$2" onclick="return confirm(`Delete Pembayaran Beli?`);" class="btn btn-primary btn-xs" alt="Update Data"> <i class="fa fa-close"></i></a>
          ',  'nama_vendor,id_pembel,kode_pembel,tanggal_pembel,jumlah_pembel,id_vendor');
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
    $this->db->where('tipe_keterangan','beli');
    $this->db->where('keterangan_pembayaran.id_pembayaran',$id);
    return $this->db->get('');
  }

  function get_keterangan1($id){
    $this->db->select('pembayaran_beli.*');
    $this->db->from('pembayaran_beli');
    $this->db->limit(1);
    $this->db->where('pembayaran_beli.id_pembel',$id);
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

   function getfile_beli($id){
    $this->db->select('*');
    $this->db->from('bukti_bayar_beli');
    //$this->db->join('customer', 'transaksi.id_cust=customer.id_cust', 'left');
    $this->db->where('id_pembayaran_beli',$id);
    return $query = $this->db->get();
   }

  function data_barcode($id){
    $this->db->where('resi_id',$id);
    return $this->db->get('giw');
  }

  function code_pembayaran_beli(){
     $cekkode= $this->db->query("SELECT max(kode_pembel) as maxkode FROM pembayaran_beli")->result();
     foreach($cekkode as $hcekkode);
     $kodesaatini = $hcekkode->maxkode;
     $ambilkode   = str_replace('BELI/INV/','',$kodesaatini);
     if($ambilkode=="")
     {
      $ambilkode=0000;
     }
     $kodejadi= $ambilkode+1;
     $hasil= str_pad($kodejadi, 4, "0", STR_PAD_LEFT);
     return 'BELI/INV/'.$hasil;
  }

  public function get_invoiceair($id_vendor){
    $this->db->select('invoice_beli.*,customer.*,vendor.*,invoice.*,resi_udara.*');
    $this->db->from('invoice_beli');
    $this->db->join('vendor', 'invoice_beli.id_vendor=vendor.id_vendor', 'left');
    $this->db->join('invoice', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli', 'left');
    $this->db->join('resi_udara', 'invoice.id_invoice=resi_udara.id_invoice', 'left');
    $this->db->join('customer', 'invoice_beli.id_cust=customer.id_cust', 'left');
    $this->db->where('invoice_beli.status_invoice_beli',1);
    $this->db->where('invoice_beli.id_vendor', $id_vendor);
    $this->db->order_by('invoice_beli.id_invoice_beli', 'desc');
    $result = $this->db->get()->result(); // Tampilkan semua data kota berdasarkan id provinsi
    return $result;
  }

  public function get_invoice($id_vendor){
    $sql = "SELECT invoice_beli.id_invoice_beli,invoice_beli.id_vendor,invoice_beli.kode_invoice_beli,invoice_beli.tanggal_invoice_beli,invoice_beli.status_invoice_beli
                   ,invoice_beli.note_invoice_beli,invoice_beli.jumlah_invoice_beli,invoice_beli.jumlah_bayar_invoice_beli
                   ,invoice_beli.jumlah_dari_vendor,customer.kode,invoice.id_invoice,invoice.kode_invoice FROM invoice_beli left join customer on invoice_beli.id_cust=customer.id_cust
                   left join invoice on invoice.id_invoice_beli=invoice_beli.id_invoice_beli where invoice_beli.id_vendor = $id_vendor and
                    invoice_beli.jumlah_invoice_beli = invoice_beli.jumlah_dari_vendor and status_invoice_beli = 1 order by note_invoice_beli asc";
    return $this->db->query($sql)->result();
  }

  public function get_invoice_vendor($id_vendor){
    $sql = "SELECT invoice_beli.id_invoice_beli,invoice_beli.id_vendor,invoice_beli.kode_invoice_beli,invoice_beli.tanggal_invoice_beli,invoice_beli.status_invoice_beli
                   ,invoice_beli.note_invoice_beli,invoice_beli.jumlah_invoice_beli,invoice_beli.jumlah_bayar_invoice_beli
                   ,invoice_beli.jumlah_dari_vendor,customer.kode,invoice.id_invoice,invoice.kode_invoice FROM invoice_beli left join customer on invoice_beli.id_cust=customer.id_cust
                   left join invoice on invoice.id_invoice_beli=invoice_beli.id_invoice_beli where invoice_beli.id_vendor = $id_vendor
                   and status_invoice_beli = 1 order by note_invoice_beli asc";
    return $this->db->query($sql)->result();
  }

  public function get_invoice_fcl($id_vendor){
    $sql = "SELECT invoice.*,customer.*,invoice_beli.* FROM invoice_beli left join customer on invoice_beli.id_cust=customer.id_cust
                   left join invoice on invoice.id_invoice_beli=invoice_beli.id_invoice_beli where invoice_beli.id_vendor = $id_vendor
                   and status_invoice_beli = 1 order by invoice_beli.id_invoice_beli asc";
    return $this->db->query($sql)->result();
  }

  public function get_invoicegrup($id){
    $this->db->where('status_invoice',0);
    $this->db->where('id_cgrup', $id);
    $this->db->order_by('id_cgrup', 'desc');
    $result = $this->db->get('invoice')->result(); // Tampilkan semua data kota berdasarkan id provinsi
    return $result;
  }

  public function get_invoice2($id_invoice){
    // $this->db->where('id_vendor !=','1');
    $this->db->where('status_invoice_beli',1);
    $this->db->where_in('id_invoice_beli', $id_invoice);
    $result = $this->db->get('invoice_beli')->result(); // Tampilkan semua data kota berdasarkan id provinsi
    return $result;
  }

  public function get_id($id){
    $this->db->where('kode',$id);
    return $this->db->get('pembayaran');
  }

  public function get_inv($id){
    $this->db->select('invoice_beli.*,vendor.*');
    $this->db->from('invoice_beli');
    $this->db->join('vendor', 'invoice_beli.id_vendor=vendor.id_vendor', 'left');
    $this->db->where_in('invoice_beli.id_invoice_beli',$id);
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
    $this->db->where('status_invoice_beli',1);
    $this->db->where('id_invoice_beli',$id);

    return $this->db->get('invoice_beli');
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

    function save($data)
  {
      $kode = $this->input->post('kode');
      // $kodeg= $this->input->post('kode_cgrup');

      $data_cust_email= $this->get_cust_email($kode);
      foreach($data_cust_email->result() as $c ){
        $nama_customer=$c->nama;
        $email_customer=$c->email;
        $whatsapp_customer =$koderow->whatsapp;
        $kode_customer=$c->kode;
        $deposit=$c->deposit;
      }

      $data_kurs= $this->get_kurs();
      foreach($data_kurs->result() as $krs ){
            $kurs_jual=$krs->kurs_jual;
            $kurs_beli=$krs->kurs_beli;
      }

      // $data_custgrup_email= $this->get_custgrup_email($kodeg);
      // foreach($data_custgrup_email->result() as $cg ){
      //   $email_customergrup=$cg->email_cgrup;
      //   $nama_customergrup=$cg->nama_cgrup;
      //   $whatsapp_customergrup=$cg->whatsapp_cgrup;
      //   $kode_customergrup=$cg->kode_cgrup;
      //   $depositgrup=$cg->deposit_cgrup;
      // }

      $data_bank= $this->Mbank->get_dbank($this->input->post('id_bank'));
      foreach($data_bank->result() as $dbank ){
       $sbank    =$dbank->saldo_bank;
      }

      // if($kode==""){
      //    $status_invoice="grup";
  		// 	 $kode =0;
  		// 	 $emailaktif= $email_customergrup;
      //    $whatsappaktif= $whatsapp_customergrup;
  		// 	 $kodeaktif = $kode_customergrup;
      //    $namaaktif = $nama_customergrup;
			// }else if($kodeg==""){
         $status_invoice="customer";
				 $kodeg =0;
				 $emailaktif= $email_customer;
         $whatsappaktif= $whatsapp_customer;
				 $kodeaktif = $kode_customer;
         $namaaktif = $nama_customer;
			// }else	if($kode=="" && $kodeg==""){
			// 	$this->session->set_flashdata('msg','gagal_input');
			// 	redirect(site_url('admin/transaksi/newt'));
			// }

      $h=date('H')+5;
      $i=date('i');
      $s=date('s');
      //data Pelanggan
      $pembayaran['id_vendor'] = $this->input->post('id_vendor');
      $pembayaran['kode_pembel'] = $this->input->post('kode_pembel');
      $pembayaran['tanggal_pembel'] = date('Y-m-d '.$h.'-'.$i.'-'.$s,strtotime($this->input->post('tanggal_pembel')));
      $pembayaran['jumlah_pembel'] = $this->input->post('jumlah_pembel');

      $this->db->insert('pembayaran_beli', $pembayaran);
      $last_id = $this->db->insert_id();

      $trb['id_jenis_transaksi_bank'] = 2;
      $trb['id_bank'] = $this->input->post('id_bank');
      $trb['tipe_transaksi_bank'] = "keluar";
      $trb['nominal_transaksi_bank'] = $pembayaran['jumlah_pembel'];
      $trb['keterangan_transaksi_bank'] = "Pengurangan Saldo dari Pembelian ".$pembayaran['kode_pembel'];
      $trb['tanggal_transaksi_bank'] = date('Y-m-d');
      $trb['sisa_saldo_bank'] = $sbank - $pembayaran['jumlah_pembel'];
      $this->db->insert('transaksi_bank', $trb);
      $id_trs = $this->db->insert_id();

      $bank['saldo_bank'] = $trb['sisa_saldo_bank'];
      $bank['edit_saldo'] = 1;
    	$this->db->where('id_bank',$this->input->post('id_bank'));
      $this->db->update('master_bank', $bank);

      $update_pembayaran['id_trs_bank'] = $id_trs;
    	$this->db->where('id_pembel',$last_id);
      $this->db->update('pembayaran_beli', $update_pembayaran);

      foreach ($_FILES['bukti_beli']['name'] as $key => $image) {
       // print_r($image."<br>");
       if($_FILES['bukti_beli']['name'][$key] == "")
        {

        }else{

          move_uploaded_file($_FILES["bukti_beli"]["tmp_name"][$key], './assets/bukti_beli/'.$_FILES["bukti_beli"]["name"][$key]);

          $bukti_beli=$_FILES["bukti_beli"]["name"][$key];

          $bb_cust['id_pembayaran_beli'] = $last_id;
          $bb_cust['bukti_beli'] = $bukti_beli;

         // die($_FILES['file_bb_cust']['name'][$key]);
            $this->db->insert('bukti_bayar_beli', $bb_cust);
        //$this->Mtransaksi->save_bb_cust($file_bb_cust);
       }
     }

      $id_invoice = $this->input->post('id_invoice_beli');
      $ja=count($id_invoice);

    if($this->input->post('sisa_billing') >= 0){
        $id_invoice = $this->input->post('id_invoice_beli');
        $jarr=count($id_invoice);
        $test="";
        for($ff=0;$ff<$jarr;$ff++){
            $data_inv= $this->get_inv($id_invoice[$ff]);
            foreach($data_inv->result() as $c ){
                $kdinv=$c->kode_invoice_beli;
                $ttlghn=$c->jumlah_invoice_beli;
                $jmlbyr=$c->jumlah_bayar_invoice_beli;

                $hcount= $ttlghn - ($jmlbyr);
                $kdis = "Pembayaran Invoice ".$kdinv." Sebesar Rp. ".number_format($hcount);

                $kpmbyrn2['id_pembayaran'] =$last_id;
                $kpmbyrn2['keterangan_pembayaran'] = $kdis;
                $kpmbyrn2['tipe_keterangan'] = "beli";
                $this->db->insert('keterangan_pembayaran', $kpmbyrn2);
            }
         }

    }else if($this->input->post('sisa_billing') < 0){

      $last_array = end($id_invoice);
      $data_inv3= $this->get_inv_one($last_array);
      foreach($data_inv3->result() as $b ){
        $kode_inv1= $b->kode_invoice_beli;
        $total_tagihan3=$b->jumlah_invoice_beli;
        $jumlah_bayar3=$b->jumlah_bayar_invoice_beli;
      }

      $sub_bayar['id_invoice'] = $last_array;
      $sub_bayar['id_pembayaran'] = $last_id;
      $sub_bayar['jumlah_bayar_sub'] = ($total_tagihan3 - ($jumlah_bayar3)) + ($this->input->post('sisa_billing'));
      $sub_bayar['tipe_sub'] = "beli";
      $this->db->insert('sub_pembayaran', $sub_bayar);

      $kpmbyrn3['id_pembayaran'] =$last_id;
      $kpmbyrn3['keterangan_pembayaran'] = 'Sub Pembayaran ke Invoice '.$kode_inv1.' Sebesar Rp. '.number_format($sub_bayar['jumlah_bayar_sub']);
      $kpmbyrn3['tipe_keterangan'] = "beli";
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
              $kdinv=$c->kode_invoice_beli;
              $ttlghn=$c->jumlah_invoice_beli;
              $jmlbyr=$c->jumlah_bayar_invoice_beli;

              $hcount= $ttlghn - ($jmlbyr);
              $kdis = "Pembayaran Invoice ".$kdinv." Sebesar Rp. ".number_format($hcount);

              $kpmbyrn4['id_pembayaran'] =$last_id;
              $kpmbyrn4['keterangan_pembayaran'] = $kdis;
              $kpmbyrn4['tipe_keterangan'] = "beli";
              $this->db->insert('keterangan_pembayaran', $kpmbyrn4);
          }

        }

      }

      $invoice4['jumlah_bayar_invoice_beli'] =$jumlah_bayar3 + $sub_bayar['jumlah_bayar_sub'];
      $this->db->where('kode_invoice_beli',$kode_inv1);
      $this->db->update('invoice_beli', $invoice4);
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
            $total_tagihan2=$c->jumlah_invoice_beli;
            $jumlah_bayar2=$c->jumlah_bayar_invoice_beli;
        }
        $r=$total_tagihan2;
        $r2=$jumlah_bayar2;

        $rr=$r-($r2);
        $insertArray[] = array(

          'id_invoice'=>$id_invoice[$ff],
          'id_pembayaran'=>$last_id,
          'jumlah_bayar_sub'=>$rr,
          'tipe_sub'=>"beli",

        );

       $updateArray[] = array(

         'id_invoice_beli'=>$id_invoice[$ff],
         'status_invoice_beli'=>2,
         'jumlah_bayar_invoice_beli'=>$r-$r3,

       );

      }
      $this->db->insert_batch('sub_pembayaran',$insertArray);

      $this->db->update_batch('invoice_beli',$updateArray,'id_invoice_beli');

    }

    $this->session->set_flashdata('msg','success');
    redirect(site_url('admin/pembayaran_beli'));



 }



  function deleted($data)
  {                       //data Pelanggan
      $pembayaran['aktif'] = '1';

        $this->db->where('id_cust',$this->input->post('id_cust'));
        $this->db->update('pembayaran', $pembayaran);

        redirect(site_url('admin/pembayaran'));


  }
}
