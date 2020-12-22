<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mcontainer extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	//Proses Get Data Otw
	function get_data_otw() {
        $this->datatables->select('id_container,id_rts,nomor,kode,status,tanggal_berangkat_c');
        $this->datatables->from('container');
        $this->datatables->where('status',3);
				$this->datatables->add_column('view', '<center><a href="'.site_url().'admin/container/detail/$1" class="btn btn-info btn-xs" alt="Update Data"> <i class="fa fa-ellipsis-h"></i></a> </center>',
         'id_rts,id_container,id_rts,nomor,kode,status');
        return $this->datatables->generate();
  }

  //Proses Get Data Monitoring
	function get_data_monitoring() {
        $this->datatables->select('id_container,id_rts,nomor,kode,status,id_rts,tanggal_berangkat_c,tanggal_monitoring_c');
        $this->datatables->from('container');
        $this->datatables->where('status',4);
        $this->datatables->add_column('view', '<center><a href="'.site_url().'admin/container/detail/$1" class="btn btn-info btn-xs" alt="Update Data"> <i class="fa fa-ellipsis-h"></i></a> </center>',
         'id_rts,id_container,id_rts,nomor,kode,status');
        return $this->datatables->generate();
  }

  //Proses Get Data Otw
	function get_data_arrived() {
        $this->datatables->select('id_container,id_rts,nomor,kode,status,tanggal_berangkat_c,tanggal_monitoring_c,tanggal_arrived_c');
        $this->datatables->from('container');
        $this->datatables->where('status',5);
				$this->datatables->add_column('view', '<center><a href="'.site_url().'admin/container/detail/$1" class="btn btn-info btn-xs" alt="Update Data"> <i class="fa fa-ellipsis-h"></i></a>
																											 <a href="javascript:void(0);" class="complete_container btn btn-success btn-xs" data-id_cont="$1">
																											 <i class="fa fa-check"></i></a>
																							 </center>',
         'id_rts,id_container,id_rts,nomor,kode,status');
        return $this->datatables->generate();
  }

	//Proses Get Data Otw
	function get_data_selesai() {
        $this->datatables->select('id_container,id_rts,nomor,kode,status,tanggal_berangkat_c,tanggal_monitoring_c,tanggal_arrived_c,tanggal_selesai');
        $this->datatables->from('container');
        $this->datatables->where('status',15);
				$this->datatables->add_column('view', '<center><a href="'.site_url().'admin/container/detail/$1" class="btn btn-info btn-xs" alt="Update Data"> <i class="fa fa-ellipsis-h"></i></a> </center>',
         'id_rts,id_container,id_rts,nomor,kode,status');
        return $this->datatables->generate();
  }

}
