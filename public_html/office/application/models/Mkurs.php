<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mkurs extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	//Proses Get Data kurs
	function get_kurs() {
        $this->datatables->select('kurs.id_kurs,kurs.kurs_jual,kurs.kurs_beli,kurs.fee_cs,kurs.kurs_klaim');
        $this->datatables->from('kurs');
        $this->datatables->add_column('view', '<center><a href="javascript:void(0);" class="edit_record btn btn-warning btn-xs" data-id_kurs="$1" data-kurs_jual="$2" data-kurs_beli="$3" data-fee_cs="$4" data-kurs_klaim="$5"> <i class="fa fa-edit"></i></a> </center>',
         'id_kurs,kurs_jual,kurs_beli,fee_cs,kurs_klaim');
        return $this->datatables->generate();
  }



  	function save($data)
  {
      $kurs['kurs_jual'] = str_replace(".", "",$this->input->post('kurs_jual'));
      $kurs['kurs_beli'] = str_replace(".", "",$this->input->post('kurs_beli'));
			$kurs['kurs_klaim'] = str_replace(".", "",$this->input->post('kurs_klaim'));
      $kurs['fee_cs'] = str_replace(".", "",$this->input->post('fee_cs'));
      $this->db->insert('kurs', $kurs);
      $last_id = $this->db->insert_id();
      $this->session->set_flashdata('msg','success');
      redirect(site_url('admin/kurs'));

  }

  function update($data)
  {                       //data Pelanggan

       $kurs['kurs_jual'] = str_replace(".", "",$this->input->post('kurs_jual'));
       $kurs['kurs_beli'] = str_replace(".", "",$this->input->post('kurs_beli'));
       $kurs['fee_cs'] = str_replace(".", "",$this->input->post('fee_cs'));
			 $kurs['kurs_klaim'] = str_replace(".", "",$this->input->post('kurs_klaim'));
    	 $this->db->where('id_kurs',$this->input->post('id_kurs'));
       $this->db->update('kurs', $kurs);
			 $pesan = "*Update Info Kurs RMB*".
			 					"\n\nKurs Jual : Rp. ".number_format($kurs['kurs_jual']);
			 whatsapp_grup("1583918717",$pesan,"081310085523");
			 // die("ok");
       $this->session->set_flashdata('msg','updated');
       redirect(site_url('admin/kurs'));


  }

  function deleted($data)
  {                       //data Pelanggan
      $kurs['aktif'] = '1';

      	$this->db->where('id_cust',$this->input->post('id_cust'));
        $this->db->update('kurs', $kurs);

        redirect(site_url('admin/kurs'));


  }
}
