<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mresi extends CI_Model {

	//Proses Get Data And Cloumn Resi and Parsing to Controller Resi function get_resi_json
	function get_resi() {
        $this->datatables->select('resi.id_resi,resi.nomor,resi.tanggal,resi.cust_id,resi.supplier,resi.tel,
        													 resi.note,resi.gudang,resi.konfirmasi_resi,customer.kode');
        $this->datatables->from('resi');
				$this->db->order_by('resi.id_resi','desc');
        $this->datatables->join('customer', 'resi.cust_id=customer.id_cust');
				// $this->datatables->where('resi.konfirmasi_resi !=');
        $this->datatables->add_column('view', 'resi(konfirmasi_resi)', 'id_resi,nomor,tanggal,kode,supplier,tel,note,gudang,konfirmasi_resi');
        return $this->datatables->generate();
  }

  function detail_resi() {

  }

  function get_resi_byid($id) {
        $this->datatables->select('resi.id_resi,resi.nomor,resi.tanggal,resi.cust_id,resi.supplier,resi.tel,
        resi.note,resi.gudang,resi.konfirmasi_resi,customer.kode');
        $this->datatables->from('resi');
        $this->datatables->join('customer', 'resi.cust_id=customer.id_cust');
        $this->datatables->where('resi.cust_id',$id);
        $this->datatables->add_column('view','$1', 'resi(konfirmasi_resi, id_resi)');
        $this->datatables->add_column('statusres','$1', 'statusresi(konfirmasi_resi)');
        return $this->datatables->generate();
  }

	function get_request_id($id) {
        $this->datatables->select('id_request_resi,id_resi,id_cust,kode_request,tanggal_request,supplier,tel,jumlah_koli,gudang,note,status_request');
        $this->datatables->from('request_resi');
        $this->datatables->where('id_cust',$id);
        // $this->datatables->add_column('view','$1', 'resi(konfirmasi_resi, id_resi)');
        return $this->datatables->generate();
  }

  function get_barcode_byid($id) {
        $this->datatables->select('giw.id,giw.nomor,giw.barang,giw.ctns,giw.qty,giw.berat,giw.tanggal_berangkat,
        													 giw.volume,giw.nilai,giw.note,giw.remarks,giw.resi_id,giw.jalur,giw.status,giw.harga_jual,jenis_barang.namalain');
        $this->datatables->from('giw');
        $this->datatables->where('giw.resi_id',$id);
				$this->datatables->join('jenis_barang', 'giw.jenis_barang_id=jenis_barang.id');
        $this->datatables->add_column('qtys','$1','c_qty(qty,ctns)');
        $this->datatables->add_column('berats','$1','c_berat(berat,ctns)');
        $this->datatables->add_column('nilais','$1','c_nilai(nilai,ctns,qty)');
        $this->datatables->add_column('volumes','$1','c_volume(volume,ctns)');
				$this->datatables->add_column('est','$1','c_est(jalur,tanggal_berangkat)');
        return $this->datatables->generate();
  }
	function get_barcodeidcust_json($id) {
        $this->datatables->select('giw.id,giw.nomor,giw.barang,giw.ctns,giw.qty,giw.berat,
        													 giw.volume,giw.nilai,giw.note,giw.remarks,giw.resi_id,giw.jalur,giw.status,giw.harga_jual,jenis_barang.namalain');
        $this->datatables->from('giw');
        $this->datatables->where('giw.customer_id',$id);
				$this->datatables->join('jenis_barang', 'giw.jenis_barang_id=jenis_barang.id');
        $this->datatables->add_column('qtys','$1','c_qty(qty,ctns)');
        $this->datatables->add_column('berats','$1','c_berat(berat,ctns)');
        $this->datatables->add_column('nilais','$1','c_nilai(nilai,ctns,qty)');
        $this->datatables->add_column('volumes','$1','c_volume(volume,ctns)');
				//$this->datatables->add_column('jalurs','$1','c_jalur(volume,ctns)');

        return $this->datatables->generate();
  }

  //Get Data Customer per Kode MArk
  public function get_id($id){
    $this->db->where('kode',$id);
    return $this->db->get('customer');
  }

  //all resi
   public function all_resi(){
    $this->db->select('resi.nomor,resi.id_resi,resi.id_resi_rts,resi.tanggal,resi.supplier,resi.tel,resi.note,customer.kode');
    $this->db->from('resi');
		$this->db->join('customer', 'resi.cust_id=customer.id_cust', 'left');
		$this->db->order_by('resi.id_resi','asc');
    return $this->db->get('');
  }

	//all resi by array id
   public function resi_array($id){
    $this->db->select('resi.id_resi,resi.id_resi_rts,resi.nomor,resi.tanggal,resi.supplier,resi.tel,resi.note,customer.kode');
    $this->db->from('resi');
		$this->db->join('customer', 'resi.cust_id=customer.id_cust', 'left');
		$this->db->where_in('resi.nomor', $id);
	//	$this->db->where_in('resi.id_resi',array('1','2'))
    return $this->db->get('');
  }

  //Get Deposit by ID Cust
  public function get_deposit($id){
    $this->db->where('id_cust',$id);
    return $this->db->get('deposit');
  }

  //get by id cust
  public function get_id2($id){
    $this->db->select('resi.*,customer.*,giw.nomor as nomorgiw');
    $this->db->from('resi');
    $this->db->join('customer', 'resi.cust_id=customer.id_cust', 'left');
    $this->db->join('giw', 'resi.id_resi=giw.resi_id', 'left');
    $this->db->where('resi.id_resi',$id);
    $this->db->limit(1);
    return $this->db->get('');
  }

}
