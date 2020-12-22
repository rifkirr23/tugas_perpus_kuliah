<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Manggota extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	//Proses Get Data anggota
	function get_anggota() {
        $this->datatables->select('id_anggota,nama_anggota,gender,no_telp,alamat,email,password');
        $this->datatables->from('anggota');
        $this->datatables->add_column('view', '<center><a href="javascript:void(0);" class="edit_record btn btn-warning btn-xs" data-id_anggota="$1"
																							 data-nama_anggota="$2" data-gender="$3" data-no_telp="$4" data-alamat="$5" data-email="$6" data-password="$7"
																							 > <i class="fa fa-edit"></i></a>
                                               <a onclick="return confirm(`Hapus anggota?`);" href="'.site_url().'admin/anggota/delete/$1" class="btn btn-danger btn-xs" data-id_anggota="$1"> <i class="fa fa-close"></i></a> </center>',
         'id_anggota,nama_anggota,gender,no_telp,alamat,email,password');
        return $this->datatables->generate();
  }



  	function save($data)
  {
      $anggota['anggota_jual'] = str_replace(".", "",$this->input->post('anggota_jual'));
      $anggota['anggota_beli'] = str_replace(".", "",$this->input->post('anggota_beli'));
			$anggota['anggota_klaim'] = str_replace(".", "",$this->input->post('anggota_klaim'));
      $anggota['fee_cs'] = str_replace(".", "",$this->input->post('fee_cs'));
      $this->db->insert('anggota', $anggota);
      $last_id = $this->db->insert_id();
      $this->session->set_flashdata('msg','success');
      redirect(site_url('admin/anggota'));

  }

  function update($data)
  {                       //data Pelanggan

       $anggota['anggota_jual'] = str_replace(".", "",$this->input->post('anggota_jual'));
       $anggota['anggota_beli'] = str_replace(".", "",$this->input->post('anggota_beli'));
       $anggota['fee_cs'] = str_replace(".", "",$this->input->post('fee_cs'));
			 $anggota['anggota_klaim'] = str_replace(".", "",$this->input->post('anggota_klaim'));
    	 $this->db->where('id_anggota',$this->input->post('id_anggota'));
       $this->db->update('anggota', $anggota);
			 $pesan = "*Update Info anggota RMB*".
			 					"\n\nanggota Jual : Rp. ".number_format($anggota['anggota_jual']);
			 whatsapp_grup("1583918717",$pesan,"081310085523");
			 // die("ok");
       $this->session->set_flashdata('msg','updated');
       redirect(site_url('admin/anggota'));


  }

  function deleted($data)
  {                       //data Pelanggan
      $anggota['aktif'] = '1';

      	$this->db->where('id_cust',$this->input->post('id_cust'));
        $this->db->update('anggota', $anggota);

        redirect(site_url('admin/anggota'));


  }
}
