<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mmaster_masalah extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	//Proses Get Data kurs
	function get_jp() {
        $this->datatables->select('master_masalah.id_masalah,master_masalah.keterangan_masalah');
        $this->datatables->from('master_masalah');
        $this->db->order_by('keterangan_masalah','asc');
        $this->datatables->add_column('view', '
        <center>
        <a href="javascript:void(0);" class="edit_record btn btn-warning btn-xs" data-id_masalah="$1" data-keterangan_masalah="$2" >
        <i class="fa fa-edit"></i>
        </a>
        </center>',
         'id_masalah,keterangan_masalah');
        return $this->datatables->generate();
  }



  	function save($data)
  {                       //data Pelanggan

      $jp['keterangan_masalah'] = $this->input->post('keterangan_masalah');

        $this->db->insert('master_masalah', $jp);
        $last_id = $this->db->insert_id();

        $this->session->set_flashdata('msg','success');
        redirect(site_url('admin/master_masalah'));


  }

  function update($data)
  {                       //data Pelanggan
        $jp['keterangan_masalah'] = $this->input->post('keterangan_masalah');

      	$this->db->where('id_masalah',$this->input->post('id_masalah'));
        $this->db->update('master_masalah', $jp);

        $this->session->set_flashdata('msg','updated');
        redirect(site_url('admin/master_masalah'));


  }



  public function select_potongan($kode){
    $this->db->select('id_masalah,keterangan_masalah');
    $this->db->limit(10);
    $this->db->from('master_masalah');
    $this->db->like('keterangan_masalah', $kode);
    return $this->db->get()->result_array();
  }

}
