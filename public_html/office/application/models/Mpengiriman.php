<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mpengiriman extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	//Proses Get Data Transaksi Per Bank
	function get_pengiriman() {
    $this->db->select('invoice.*,customer.*');
    $this->db->from('invoice');
    $this->db->join('customer', 'invoice.id_cust=customer.id_cust');
    $this->db->where('invoice.tipe_invoice','barang');
		$this->db->where('invoice.tanggal_invoice >=',"2020-03-20");
		// $this->db->limit(10);
		// $this->db->order_by('invoice.status_pengiriman','asc');
		// $this->db->order_by('invoice.id_invoice','desc');
    return $this->db->get()->result();
  }

	function get_pengiriman_id($id) {
    $this->db->select('invoice.*,customer.*,surat_jalan.*');
    $this->db->from('invoice');
    $this->db->join('customer', 'invoice.id_cust=customer.id_cust');
		$this->db->join('surat_jalan', 'invoice.id_surat_jalan=surat_jalan.id_surat_jalan');
    $this->db->where('invoice.id_invoice',$id);
    return $this->db->get()->row();
  }

}
