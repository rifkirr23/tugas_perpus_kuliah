<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mlead extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	//Proses Get Data kurs
	function get_lead() {
				$idpengguna = $this->session->userdata('id_pengguna');
        $this->datatables->select('leads.jenis_barang,leads.nama,leads.whatsapp,leads.email,leads.sp_cargo,leads.sp_supplier,leads.dihub,
																		leads.tanggal,pengguna.nama_pengguna');
				$this->datatables->join('pengguna', 'leads.id_sales=pengguna.id_pengguna');
        $this->datatables->from('leads');
				if($this->session->userdata('level')=="sales"){
						$this->datatables->where("pengguna.id_pengguna",$idpengguna);
				}
        $this->db->order_by('id_leads','desc');
        $this->datatables->add_column('view', '
        <center>
        <a href="'.site_url().'admin/bank/transaksi/$1" class="btn btn-info btn-xs"> <i class="fa fa-ellipsis-h"></i></a>
        </center>');
        return $this->datatables->generate();
  }


}
