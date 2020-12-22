<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mmobil_sj extends CI_Model {

  public function __construct(){
		parent::__construct();
    // $this->load->model('Mbank');
	}

	//Proses Get Data And Cloumn Resi and Parsing to Controller Resi function get_resi_json
	function datasj() {
        $this->datatables->select('sj_wc.id_sj,sj_wc.kode_sj,sj_wc.tanggal_kirim,sj_wc.tanggal_terima,sj_wc.status,customer.kode,
                                   mobil.plat_mobil,volume,jumlah');
        $this->datatables->from('giw')
                         ->join('invoice_product', 'invoice_product.id_giw=giw.id','left')
                         ->join('sj_wc', 'sj_wc.id_sj=invoice_product.id_sj_wc','left');
        $this->datatables->join('customer', 'sj_wc.id_cust=customer.id_cust');
        $this->datatables->join('mobil', 'sj_wc.id_mobil=mobil.id_mobil')
                         ->group_by('sj_wc.id_sj');
        $this->db->order_by('sj_wc.id_sj','desc');
        $this->datatables->add_column('view', '<a href="'.site_url().'admin/mobilsj/detail_sj/$1" class="" target="_blank" style="margin-right:10px;"> <i class="fa fa-ellipsis-h"></i></a>
          														', 'id_sj');
        return $this->datatables->generate();
  }
}
