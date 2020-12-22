<?php

class Mresi_udara extends CI_Model
{
  public function __construct(){
		parent::__construct();
    // $this->load->model('Mapiinvoice');
    // $this->load->model('Mbank');
    // $this->load->model('Mpembayaran');
	}
  function get_resiudara() {
    $idcust=$this->session->userdata('id_cust');
    $this->datatables->select('resi_udara.id_resi_udara,resi_udara.nama_barang,resi_udara.id_invoice,resi_udara.nomor_resi,resi_udara.ctns,resi_udara.berat,resi_udara.harga_jual
                              ,resi_udara.harga_beli,resi_udara.harga_jual_goni,resi_udara.harga_beli_goni,resi_udara.tanggal_resi
                              ,customer.kode,invoice.kode_invoice');
    $this->datatables->from('resi_udara');
    $this->datatables->join('customer', 'resi_udara.id_cust=customer.id_cust');
    $this->datatables->join('invoice', 'resi_udara.id_invoice=invoice.id_invoice');
    $this->datatables->where('resi_udara.id_cust',$idcust);
    $this->datatables->add_column('view', '<a href="'.site_url().'resi/detail_udara/$1/$2" target="_blank">Lihat</a>
                                  ', 'id_resi_udara,id_invoice');

    return $this->datatables->generate();
  }

  public function get_id2($id){
    $idcust=$this->session->userdata('id_cust');
    $this->db->select('resi_udara.*,customer.kode as kodecustomer,customer.telepon,customer.whatsapp');
    $this->db->from('resi_udara');
    $this->db->join('customer', 'resi_udara.id_cust=customer.id_cust', 'left');
    $this->db->where('resi_udara.id_resi_udara',$id);
    // $this->db->where('resi_udara.id_cust',$idcust);
    return $this->db->get();
  }
  function getresiinvid($id){
    $idcust=$this->session->userdata('id_cust');
    return $this->db->select('resi_udara.*,invoice.*,customer.kode as kodecustomer,customer.telepon,customer.whatsapp')
             ->from('resi_udara')
             ->join('customer', 'resi_udara.id_cust=customer.id_cust')
             ->join('invoice', 'resi_udara.id_invoice=invoice.id_invoice')
             ->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
             ->where('resi_udara.id_resi_udara',$id)
             // $this->db->where('resi_udara.id_cust',$idcust);
             ->get();
  }
  function getinvid($id){
    $idcust=$this->session->userdata('id_cust');
    return $this->db->select('resi_udara.*,invoice.*,customer.kode as kodecustomer,customer.telepon,customer.whatsapp,customer.alamat')
             ->from('resi_udara')
             ->join('customer', 'resi_udara.id_cust=customer.id_cust')
             ->join('invoice', 'resi_udara.id_invoice=invoice.id_invoice')
             ->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
             ->where('invoice.id_invoice',$id)
             // $this->db->where('resi_udara.id_cust',$idcust);
             ->get();
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
}
