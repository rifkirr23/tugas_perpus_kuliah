<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mparent_jenis_transaksi extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	//Proses Get Data kurs
	function get_jtb() {
        $this->datatables->select('id_parent,nama_parent');
        $this->datatables->from('parent_jenis_transaksi');
        // $this->db->order_by('kjenis_transaksi_bank','asc');
        $this->datatables->add_column('view', '
        <center>
        <a href="javascript:void(0);" class="edit_record btn btn-warning btn-xs" data-id_parent="$1" data-nama_parent="$2" >
        <i class="fa fa-edit"></i>
        </a>
				<a href="'.site_url().'admin/parent_jenis_transaksi/detail/$1" class="btn btn-info btn-xs"> <i class="fa fa-ellipsis-h"></i></a>
        </center>',
         'id_parent,nama_parent');
        return $this->datatables->generate();
  }



  	function save($data)
  {                       //data Parent
      $parent['nama_parent'] = $this->input->post('nama_parent');
      $this->db->insert('parent_jenis_transaksi', $parent);
      $last_id = $this->db->insert_id();
      $this->session->set_flashdata('msg','success');
      redirect(site_url('admin/parent_jenis_transaksi'));
  }

  function update($data)
  {                       //data Pelanggan
        $parent['nama_parent'] = $this->input->post('nama_parent');

      	$this->db->where('id_parent',$this->input->post('id_parent'));
        $this->db->update('parent_jenis_transaksi', $parent);

        $this->session->set_flashdata('msg','updated');
        redirect(site_url('admin/parent_jenis_transaksi'));


  }


}
