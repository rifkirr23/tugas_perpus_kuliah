<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mjenis_potongan extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	//Proses Get Data kurs
	function get_jp() { 
        $this->datatables->select('jenis_potongan.id_jenis_potongan,jenis_potongan.kjenis_potongan');
        $this->datatables->from('jenis_potongan');
        $this->db->order_by('kjenis_potongan','asc');
        $this->datatables->add_column('view', '
        <center>
        <a href="javascript:void(0);" class="edit_record btn btn-warning btn-xs" data-id_jenis_potongan="$1" data-kjenis_potongan="$2" >
        <i class="fa fa-edit"></i>
        </a>
        </center>', 
         'id_jenis_potongan,kjenis_potongan');
        return $this->datatables->generate();
  }



  	function save($data)
  {                       //data Pelanggan
     
      $jp['kjenis_potongan'] = $this->input->post('kjenis_potongan'); 
     
      
      
        $this->db->insert('jenis_potongan', $jp);
        $last_id = $this->db->insert_id(); 
     
        $this->session->set_flashdata('msg','success');
        redirect(site_url('admin/jenis_potongan'));

       
  }

  function update($data)
  {                       //data Pelanggan
        $jp['kjenis_potongan'] = $this->input->post('kjenis_potongan'); 
      
      	$this->db->where('id_jenis_potongan',$this->input->post('id_jenis_potongan'));
        $this->db->update('jenis_potongan', $jp);

        $this->session->set_flashdata('msg','updated');
        redirect(site_url('admin/jenis_potongan'));

       
  }

  

  public function select_potongan($kode){
    $this->db->select('id_jenis_potongan,kjenis_potongan');
    $this->db->limit(10);
    $this->db->from('jenis_potongan');
    $this->db->like('kjenis_potongan', $kode);
    return $this->db->get()->result_array();
  }

}