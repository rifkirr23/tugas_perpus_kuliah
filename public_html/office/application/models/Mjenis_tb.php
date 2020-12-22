<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mjenis_tb extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	//Proses Get Data kurs
	function get_jtb() {
      $this->datatables->select('jenis_transaksi_bank.id_jenis_transaksi_bank,jenis_transaksi_bank.kjenis_transaksi_bank,jenis_transaksi_bank.tipe_jenis_transaksi');
      $this->datatables->from('jenis_transaksi_bank');
      $this->db->order_by('kjenis_transaksi_bank','asc');
			$id = "$1";
      $this->datatables->add_column('view', '
      <center>
      <a href="javascript:void(0);" onclick="view_update('.$id.')" class="btn btn-info btn-xs" alt="Update Data"> <i class="fa fa-edit"></i></a>
      </center>',
       'id_jenis_transaksi_bank,kjenis_transaksi_bank');
      return $this->datatables->generate();
  }



  	function save($data)
  {                       //data Pelanggan

      $jp['kjenis_transaksi_bank'] = $this->input->post('kjenis_transaksi_bank');
      $jp['tipe_jenis_transaksi'] = $this->input->post('tipe_jenis_transaksi');
			$jp['id_jenis_transaksi_utama'] = 1;
			$jp['id_parent'] = $this->input->post('id_parent');
      $this->db->insert('jenis_transaksi_bank', $jp);
      $last_id = $this->db->insert_id();

      $this->session->set_flashdata('msg','success');
      redirect(site_url('admin/jenis_tb'));


  }

  function update($data)
  {                       //data Pelanggan
        $jp['kjenis_transaksi_bank'] = $this->input->post('kjenis_transaksi_bank');
				$jp['tipe_jenis_transaksi'] = $this->input->post('tipe_jenis_transaksi');
				$jp['id_parent'] = $this->input->post('id_parent');
      	$this->db->where('id_jenis_transaksi_bank',$this->input->post('id_jenis_transaksi_bank'));
        $this->db->update('jenis_transaksi_bank', $jp);

        $this->session->set_flashdata('msg','updated');
        redirect(site_url('admin/jenis_tb'));


  }


}
