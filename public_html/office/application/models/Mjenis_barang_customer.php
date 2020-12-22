<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mjenis_barang_customer extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	//Proses Get Data kurs
	function get_jbc() {
    $this->datatables->select('jenis_barang_customer.id_jenis_barang_customer,jenis_barang_customer.nama,jenis_barang_customer.namalain,
                               jenis_barang_customer.harga,jenis_barang_customer.id_jenis_barang,customer.kode,customer.id_cust');
    $this->datatables->from('jenis_barang_customer');
    $this->datatables->join('customer', 'jenis_barang_customer.id_cust=customer.id_cust');
    $this->db->order_by('customer.id_cust','desc');
		$this->db->order_by('jenis_barang_customer.id_jenis_barang','desc');
    $this->datatables->add_column('view', '
    <center>
    <a href="javascript:void(0);" class="edit_record btn btn-warning btn-xs" data-id_jenis_barang_customer="$1" data-nama="$2" data-namalain="$3"
		 data-harga="$4" data-id_cust="$5" data-id_jenis_barang="$6">
    <i class="fa fa-edit"></i>
    </a>
    </center>',
     'id_jenis_barang_customer,nama,namalain,harga,id_cust,id_jenis_barang');
    return $this->datatables->generate();
  }

	function get_jbcid($id) {
    $this->datatables->select('jenis_barang_customer.id_jenis_barang_customer,jenis_barang_customer.nama,jenis_barang_customer.namalain,
                               jenis_barang_customer.harga,jenis_barang_customer.id_jenis_barang,customer.kode,customer.id_cust');
    $this->datatables->from('jenis_barang_customer');
    $this->datatables->join('customer', 'jenis_barang_customer.id_cust=customer.id_cust');
		$this->datatables->where('jenis_barang_customer.id_cust',$id);
    $this->db->order_by('customer.id_cust','desc');
		$this->db->order_by('jenis_barang_customer.id_jenis_barang','desc');
    $this->datatables->add_column('view', '
    <center>
    <a href="javascript:void(0);" class="edit_record btn btn-warning btn-xs" data-id_jenis_barang_customer="$1" data-nama="$2" data-namalain="$3"
		 data-harga="$4" data-id_cust="$5" data-id_jenis_barang="$6">
    <i class="fa fa-edit"></i>
    </a>
    </center>',
     'id_jenis_barang_customer,nama,namalain,harga,id_cust,id_jenis_barang');
    return $this->datatables->generate();
  }

  	function save($data)
  {
			$idjb = $this->input->post('id_jenis_barang');
			$jb = $this->db->where('id',$idjb)->get('jenis_barang')->row();
			$jbc['id_jenis_barang'] = $idjb;
      $jbc['id_cust'] = $this->input->post('id_cust');
      $jbc['nama'] = $jb->nama;
      $jbc['namalain'] = $jb->namalain;
      $jbc['harga'] = $this->input->post('harga');
      $this->db->insert('jenis_barang_customer', $jbc);
      $last_id = $this->db->insert_id();
      $this->session->set_flashdata('msg','success');
      redirect(site_url('admin/jenis_barang_customer'));
  }

  function update($data)
  {
		$idjb = $this->input->post('id_jenis_barang');
		$jb = $this->db->where('id',$idjb)->get('jenis_barang')->row();

		if($this->input->post('id_cust') == ""){

		}else{
			$jbc['id_cust'] = $this->input->post('id_cust');
		}
		$jbc['id_jenis_barang'] = $idjb;
		$jbc['nama'] = $jb->nama;
		$jbc['namalain'] = $jb->namalain;
		$jbc['harga'] = $this->input->post('harga');
  	$this->db->where('id_jenis_barang_customer',$this->input->post('id_jenis_barang_customer'));
    $this->db->update('jenis_barang_customer', $jbc);

    $this->session->set_flashdata('msg','updated');
    redirect(site_url('admin/jenis_barang_customer'));

  }

	function getjb(){
		return $this->db->get('jenis_barang');
	}

	function buka_harga($idcust){
		$cekjb = $this->db->where('id_cust',$idcust)->get('jenis_barang_customer')->num_rows();
		if($cekjb == 0){
			$jenisbarang = $this->db->get('jenis_barang')->result();
			foreach ($jenisbarang as $jb) {
				$jbc['id_jenis_barang'] = $jb->id;
				$jbc['id_cust'] = $idcust;
				$jbc['nama'] = $jb->nama;
				$jbc['namalain'] = $jb->namalain;
				$jbc['harga'] = 0;
				$this->db->insert('jenis_barang_customer', $jbc);
			}
		}
		redirect(site_url('admin/customer/detail/'.$idcust.'/harga_khusus'));
	}

	function harga10($idcust){
		$cekjb = $this->db->where('id_cust',$idcust)->get('jenis_barang_customer')->num_rows();
		if($cekjb == 0){
			die('buka harga khusus terlebih dahulu');
		}
		$jenisbarang = $this->db->get('jenis_barang')->result();
		foreach ($jenisbarang as $jb) {
			$jbc['harga'] = $jb->harga - 500000;
			$this->db->where('id_cust',$idcust)->where('id_jenis_barang',$jb->id)->update('jenis_barang_customer', $jbc);
		}
		redirect(site_url('admin/customer/detail/'.$idcust.'/harga_khusus'));
	}

	function update_harga(){
		$idjbc = $this->input->post('id_jenis_barang_customer');
		$harga = $this->input->post('harga');
		$countrow = count($idjbc);
		$harga_customer = 0;
		$insertArray = array();
		for ($i=0; $i < $countrow; $i++) {
			$harga_customer = 0;
			$data_jbc = $this->db->where('id_jenis_barang_customer',$idjbc[$i])->get('jenis_barang_customer')->row();
			$data_jenis_brg = $this->db->where('id',$data_jbc->id_jenis_barang)->get('jenis_barang')->row();
			// if($harga[$i] < ($data_jenis_brg->harga_rts - 500000)){
			// 	$harga_customer = 0;
			// }else{
			// 	$harga_customer = $harga[$i];
			// }
			$insertArray[] = array(
				'id_jenis_barang_customer'=>$idjbc[$i],
				'harga'=>$harga[$i]
			);
			// print_r($harga_customer);die();
		}
		$this->db->update_batch('jenis_barang_customer',$insertArray,'id_jenis_barang_customer');
		redirect(site_url('admin/customer/detail/'.$this->input->post('id_cust').'/harga_khusus'));
	}

}
