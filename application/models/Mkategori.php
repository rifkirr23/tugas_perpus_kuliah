<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mkategori extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	//Proses Get Data buku
	function get_kategori() {
        $this->datatables->select('id_kategori,nama_kategori');
        $this->datatables->from('kategori');
        $this->datatables->add_column('view', '<center><a href="javascript:void(0);" class="edit_record btn btn-warning btn-xs"> <i class="fa fa-edit"></i></a>
                                               <a href="javascript:void(0);" class="delete_record btn btn-danger btn-xs"> <i class="fa fa-close"></i></a> </center>',
         'id_kategori,nama_kategori');
        return $this->datatables->generate();
  }



  	function save($data)
  {
      $buku['buku_jual'] = str_replace(".", "",$this->input->post('buku_jual'));
      $buku['buku_beli'] = str_replace(".", "",$this->input->post('buku_beli'));
			$buku['buku_klaim'] = str_replace(".", "",$this->input->post('buku_klaim'));
      $buku['fee_cs'] = str_replace(".", "",$this->input->post('fee_cs'));
      $this->db->insert('buku', $buku);
      $last_id = $this->db->insert_id();
      $this->session->set_flashdata('msg','success');
      redirect(site_url('admin/buku'));

  }

  function update($data)
  {                       //data Pelanggan

       $buku['buku_jual'] = str_replace(".", "",$this->input->post('buku_jual'));
       $buku['buku_beli'] = str_replace(".", "",$this->input->post('buku_beli'));
       $buku['fee_cs'] = str_replace(".", "",$this->input->post('fee_cs'));
			 $buku['buku_klaim'] = str_replace(".", "",$this->input->post('buku_klaim'));
    	 $this->db->where('id_buku',$this->input->post('id_buku'));
       $this->db->update('buku', $buku);
			 $pesan = "*Update Info buku RMB*".
			 					"\n\nbuku Jual : Rp. ".number_format($buku['buku_jual']);
			 whatsapp_grup("1583918717",$pesan,"081310085523");
			 // die("ok");
       $this->session->set_flashdata('msg','updated');
       redirect(site_url('admin/buku'));


  }

  function deleted($data)
  {                       //data Pelanggan
      $buku['aktif'] = '1';

      	$this->db->where('id_cust',$this->input->post('id_cust'));
        $this->db->update('buku', $buku);

        redirect(site_url('admin/buku'));


  }
}
