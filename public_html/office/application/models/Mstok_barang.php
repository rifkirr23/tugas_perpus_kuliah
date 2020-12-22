<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mstok_barang extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	//Proses Get Data Otw
	function get_data_otw() {
        $this->datatables->select('id_container,id_rts,nomor,kode,status');
        $this->datatables->from('container');
        $this->datatables->where('status',3);
				$this->datatables->add_column('view', '<center><a href="'.site_url().'admin/container/detail/$1" class="btn btn-info btn-xs" alt="Update Data"> <i class="fa fa-ellipsis-h"></i></a> </center>',
         'id_rts,id_container,id_rts,nomor,kode,status');
        return $this->datatables->generate();
  }

}
