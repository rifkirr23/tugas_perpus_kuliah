<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mjenis_barang extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	//Proses Get Data kurs
	function get_jb() {
    $this->datatables->select('jenis_barang.id,jenis_barang.nama,jenis_barang.list,jenis_barang.note,jenis_barang.namalain,jenis_barang.harga');
    $this->datatables->from('jenis_barang');
    $this->db->order_by('id','asc');
    $this->datatables->add_column('view', '
    <center>
    <a href="javascript:void(0);" class="edit_record btn btn-warning btn-xs" data-id="$1" data-nama="$2" data-list="$3" data-note="$4" data-namalain="$5" data-harga="$6">
    <i class="fa fa-edit"></i>
    </a>
    </center>',
     'id,nama,list,note,namalain,harga');
    return $this->datatables->generate();
  }



  	function save($data)
  {                       //data Pelanggan
      $jp['nama'] = $this->input->post('nama');
      $jp['list'] = $this->input->post('list');
      $jp['note'] = $this->input->post('note');
      $jp['namalain'] = $this->input->post('namalain');
      $jp['harga'] = $this->input->post('harga');
      $this->db->insert('jenis_barang', $jp);
      $last_id = $this->db->insert_id();
      $this->session->set_flashdata('msg','success');
      redirect(site_url('admin/jenis_barang'));
  }

  function update($data)
  {                       //data Pelanggan
    $jp['nama'] = $this->input->post('nama');
    $jp['list'] = $this->input->post('list');
    $jp['note'] = $this->input->post('note');
    $jp['namalain'] = $this->input->post('namalain');
    $jp['harga'] = $this->input->post('harga');
  	$this->db->where('id',$this->input->post('id'));
    $this->db->update('jenis_barang', $jp);

    $this->session->set_flashdata('msg','updated');
    redirect(site_url('admin/jenis_barang'));

  }


}
