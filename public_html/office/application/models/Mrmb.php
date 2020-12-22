<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mrmb extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	//Proses Get Data kurs
	function get_rmb() {
        $this->datatables->select('rmb.id_rmb,rmb.saldo_rmb');
        $this->datatables->from('rmb');

        return $this->datatables->generate();
  }

  function get_trmb() {
        $this->datatables->select('transaksi_rmb.id_transaksi_rmb,transaksi_rmb.jumlah_trmb,transaksi_rmb.keterangan_rmb,transaksi_rmb.tanggal_rmb
																	 ,transaksi_rmb.tipe_trmb,transaksi_rmb.sisa_saldo_trmb,transaksi_rmb.kurs_trmb');
        $this->datatables->from('transaksi_rmb');
				$this->db->order_by('id_transaksi_rmb','desc');
				//$this->datatables->add_column('count_rmb', '$1','count_rmb(tipe_trmb,jumlah_trmb)');
				$this->datatables->add_column('result_rmb', '$1','result_rmb(tipe_trmb,jumlah_trmb)');

        return $this->datatables->generate();
  }

	function get_detailrmb() {
        $this->datatables->select('transaksi_detail_rmb.id_tdrmb,transaksi_detail_rmb.jumlah_tdrmb,transaksi_detail_rmb.keterangan_tdrmb,transaksi_detail_rmb.tanggal_tdrmb
																	 ,transaksi_detail_rmb.tipe_tdrmb,transaksi_detail_rmb.formula_tdrmb');
        $this->datatables->from('transaksi_detail_rmb');
				$this->db->order_by('id_tdrmb','desc');
				//$this->datatables->add_column('count_rmb', '$1','count_rmb(tipe_trmb,jumlah_trmb)');
				$this->datatables->add_column('result_rmb', '$1','result_rmb(tipe_tdrmb,jumlah_tdrmb)');

        return $this->datatables->generate();
  }

	public function allrmb(){
    return $this->db->get('rmb');
  }

	public function sumrmb(){
    $getjumlahrmb = $this->db->select('sum(saldo_rmb) as total_rmb')->get('rmb')->row();
		return $getjumlahrmb->total_rmb;
  }

	public function rmbid($id){
    $this->db->where('id_rmb',$id);

    return $this->db->get('rmb');
  }

	public function rmb_nonaktif(){
		$this->db->where('status_rmb',2);
    return $this->db->get('rmb');
	}

  public function data_rmb(){
    $this->db->where('status_rmb',1);
    return $this->db->get('rmb');
  }

	public function data_rmb2(){
    $this->db->where('status_rmb',2);
    return $this->db->get('rmb');
  }

  	function save($data)
  {                       //data Pelanggan

      $kurs['kurs_jual'] = str_replace(".", "",$this->input->post('kurs_jual'));
      $kurs['kurs_beli'] = str_replace(".", "",$this->input->post('kurs_beli'));
      $kurs['fee_cs'] = str_replace(".", "",$this->input->post('fee_cs'));


        $this->db->insert('kurs', $kurs);
        $last_id = $this->db->insert_id();

        $this->session->set_flashdata('msg','success');
        redirect(site_url('admin/kurs'));


  }

  function update($data)
  {                       //data Pelanggan
       $kurs['kurs_jual'] = str_replace(".", "",$this->input->post('kurs_jual'));
       $kurs['kurs_beli'] = str_replace(".", "",$this->input->post('kurs_beli'));
       $kurs['fee_cs'] = str_replace(".", "",$this->input->post('fee_cs'));

      	$this->db->where('id_kurs',$this->input->post('id_kurs'));
        $this->db->update('kurs', $kurs);

        $this->session->set_flashdata('msg','updated');
        redirect(site_url('admin/kurs'));


  }

  function deleted($data)
  {                       //data Pelanggan
      $kurs['aktif'] = '1';

      	$this->db->where('id_cust',$this->input->post('id_cust'));
        $this->db->update('kurs', $kurs);

        redirect(site_url('admin/kurs'));


  }
}
