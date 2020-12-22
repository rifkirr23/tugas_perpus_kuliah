<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mresi extends CI_Model {

	//Proses Get Data And Cloumn Resi and Parsing to Controller Resi function get_resi_json
	function get_resi() {
        $this->datatables->select('resi.id_resi,resi.nomor,,resi.encrypt_resi,resi.tanggal,resi.cust_id,resi.supplier,resi.tel,
        													 resi.note,resi.gudang,resi.konfirmasi_resi,customer.kode');
        $this->datatables->from('resi');
				$this->db->order_by('resi.id_resi','desc');
        $this->datatables->join('customer', 'resi.cust_id=customer.id_cust');
				// $this->datatables->where('resi.konfirmasi_resi !=');
				if($this->session->userdata('level') == "sales" || $this->session->userdata('level') == "saleso"){
					$this->datatables->where('id_pendaftar',$this->session->userdata('id_pengguna'));
				}else if($this->session->userdata('level') == "crm"){
					$this->datatables->where('id_crm',$this->session->userdata('id_pengguna'));
				}
        $this->datatables->add_column('view', ' <a href="'.site_url().'admin/resi/detail/$1" class="btn btn-info btn-xs" target="_blank"> <i class="fa fa-ellipsis-h"></i></a>
																								<a href="javascript:void(0);" class="send_konfirmasi btn btn-success btn-xs" data-id_resi="$1">
																								<i class="fa fa-wechat"></i></a>
																								<a href="javascript:void(0);" class="delete_resi btn btn-danger btn-xs"
																								data-id_resi="$1"><i class="fa fa-close"></i></a>
																								<a onclick="return confirm(`Kirim Ulang Resi?`);" href="'.site_url().'admin/resi/resend/$1" class="btn btn-warning btn-xs"> <i class="fa fa-send-o"></i></a>
          														', 'id_resi,nomor,encrypt_resi,kode,supplier,tel,note,gudang,konfirmasi_resi');
        return $this->datatables->generate();
  }

  function get_resi_byid($id) {
        $this->datatables->select('resi.id_resi,resi.nomor,resi.tanggal,resi.cust_id,resi.supplier,resi.tel,
        													 resi.note,resi.gudang,resi.konfirmasi_resi,customer.kode');
        $this->datatables->from('resi');
        $this->datatables->join('customer', 'resi.cust_id=customer.id_cust');
        $this->datatables->where('resi.cust_id',$id);
				$this->datatables->add_column('view', ' <a href="'.site_url().'admin/resi/detail/$1" class="btn btn-info btn-xs"> <i class="fa fa-ellipsis-h"></i></a>

          ', 'id_resi,nomor,tanggal,kode,supplier,tel,note,gudang,konfirmasi_resi');

        return $this->datatables->generate();
  }

	function get_resi_byidgrup($id) {
        $this->datatables->select('resi.id_resi,resi.nomor,resi.tanggal,resi.cust_id,resi.supplier,resi.tel,
        													 resi.note,resi.gudang,resi.konfirmasi_resi,customer.kode');
        $this->datatables->from('resi');
        $this->datatables->join('customer', 'resi.cust_id=customer.id_cust');
        $this->datatables->where('customer.id_cgrup',$id);
				$this->datatables->add_column('view', ' <a href="'.site_url().'admin/resi/detail/$1" class="btn btn-info btn-xs"> <i class="fa fa-ellipsis-h"></i></a>

          ', 'id_resi,nomor,tanggal,kode,supplier,tel,note,gudang,konfirmasi_resi');

        return $this->datatables->generate();
  }

  function get_barcode_byid($id) {
        $this->datatables->select('giw.id,giw.nomor,giw.barang,giw.ctns,giw.qty,giw.berat,giw.tanggal_berangkat,giw.container_id,
        													 giw.volume,giw.nilai,giw.note,giw.remarks,giw.resi_id,giw.jalur,giw.status,giw.harga_jual,jenis_barang.namalain');
        $this->datatables->from('giw');
        $this->datatables->where('giw.resi_id',$id);
				$this->datatables->join('jenis_barang', 'giw.jenis_barang_id=jenis_barang.id');
        $this->datatables->add_column('qtys','$1','c_qty(qty,ctns)');
        $this->datatables->add_column('berats','$1','c_berat(berat,ctns)');
        $this->datatables->add_column('nilais','$1','c_nilai(nilai,ctns,qty)');
        $this->datatables->add_column('volumes','$1','c_volume(volume,ctns)');
				$this->datatables->add_column('est','$1','c_est(jalur,tanggal_berangkat)');
				$q = "$1";
        $this->datatables->add_column('view', ' <a onclick="edit_barcode('.$q.')" class="btn btn-info btn-xs" alt="Update Data"> <i class="fa fa-edit"></i></a>
          														', 'id');
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

	function get_barcodeidgrup_json($id) {
        $this->datatables->select('giw.id,giw.nomor,giw.barang,giw.ctns,giw.qty,giw.berat,
        													 giw.volume,giw.nilai,giw.note,giw.remarks,giw.resi_id,giw.jalur,giw.status,giw.harga_jual,jenis_barang.namalain');
        $this->datatables->from('giw');
				$this->datatables->join('customer', 'giw.customer_id=customer.id_cust');
        $this->datatables->where('customer.id_cgrup',$id);
				$this->datatables->join('jenis_barang', 'giw.jenis_barang_id=jenis_barang.id');
        $this->datatables->add_column('qtys','$1','c_qty(qty,ctns)');
        $this->datatables->add_column('berats','$1','c_berat(berat,ctns)');
        $this->datatables->add_column('nilais','$1','c_nilai(nilai,ctns,qty)');
        $this->datatables->add_column('volumes','$1','c_volume(volume,ctns)');
				//$this->datatables->add_column('jalurs','$1','c_jalur(volume,ctns)');
        return $this->datatables->generate();
  }

	function get_pl() {
        $this->datatables->select('id_file_packing,nomor_resi,encrypt_resi,status_proses,tanggal_upload,kode_marking as kode,pesan_tolak,request_resi.id_request_resi,supplier,tel,jumlah_koli,gudang,customer.kode as real_kode');
        $this->datatables->from('file_packing');
				$this->datatables->join('request_resi', 'file_packing.id_request_resi=request_resi.id_request_resi');
				$this->datatables->join('customer', 'customer.id_cust=request_resi.id_cust');
				$this->datatables->group_by('nomor_resi');
				$this->db->order_by('id_file_packing','desc');
				$q = "$3";
				$this->datatables->add_column('view','$1','view_pl(nomor_resi,encrypt_resi,id_file_packing,real_kode,pesan_tolak,id_request_resi)');
				$this->datatables->add_column('krequest','$1','keterangan_request_resi(id_request_resi,supplier,tel,jumlah_koli,gudang)');
				$this->datatables->add_column('req_kode','$1','req_kode(id_request_resi,kode,real_kode)');
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
    $this->db->select('resi.*,customer.*');
    $this->db->from('resi');
    $this->db->join('customer', 'resi.cust_id=customer.id_cust', 'left');
    $this->db->where('resi.id_resi',$id);
    return $this->db->get('');
  }

}
