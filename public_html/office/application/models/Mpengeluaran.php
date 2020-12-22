<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mpengeluaran extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	//Proses Get Data Transaksi Per Bank
	function get_pengeluaran() {
      $this->datatables->select('transaksi_bank.id_transaksi_bank,transaksi_bank.tipe_transaksi_bank,transaksi_bank.nominal_transaksi_bank,
                                 transaksi_bank.keterangan_transaksi_bank,transaksi_bank.sisa_saldo_bank,transaksi_bank.tanggal_transaksi_bank,
                                 jenis_transaksi_bank.kjenis_transaksi_bank,
                                 master_bank.nama_bank');
      $this->datatables->from('transaksi_bank');
      $this->datatables->join('jenis_transaksi_bank', 'transaksi_bank.id_jenis_transaksi_bank=jenis_transaksi_bank.id_jenis_transaksi_bank');
      $this->datatables->join('master_bank', 'master_bank.id_bank=transaksi_bank.id_bank');
			$this->datatables->where('transaksi_bank.id_jenis_transaksi_bank !=',3);
      // $this->db->order_by('transaksi_bank.id_transaksi_bank','desc');
      $this->datatables->where('jenis_transaksi_bank.id_jenis_transaksi_utama',1);
      return $this->datatables->generate();
  }

}
