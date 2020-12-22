<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mekspedisi_lokal extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	//Proses Get Data kurs
	function get_data() {
        $this->datatables->select('master_ekspedisi_lokal.id_ekspedisi,master_ekspedisi_lokal.nama_ekspedisi,
																	 master_ekspedisi_lokal.alamat,master_ekspedisi_lokal.no_telp,
																	 master_ekspedisi_lokal.tipe_ekspedisi,provinsi.nama as namaprov,kabupaten.nama as namakota
																	 ,kecamatan.nama as namakec
																	 ');
        $this->datatables->from('master_ekspedisi_lokal');
        $this->datatables->where('id_ekspedisi >',0);
				$this->datatables->join('provinsi', 'master_ekspedisi_lokal.id_provinsi=provinsi.id_prov','left');
				$this->datatables->join('kabupaten', 'master_ekspedisi_lokal.id_kota=kabupaten.id_kab','left');
				$this->datatables->join('kecamatan', 'master_ekspedisi_lokal.id_kec=kecamatan.id_kec','left');
				$q="$1";
        $this->datatables->add_column('view', '<center><a href="'.site_url().'admin/ekspedisi_lokal/edit/$1" class="btn btn-info btn-xs" alt="Update Data"> <i class="fa fa-edit"></i></a> </center>',
         'id_ekspedisi,nama_ekspedisi,alamat,no_telp');
        return $this->datatables->generate();
  }



  	function save($data)
  {
      $msteks['nama_ekspedisi'] = $this->input->post('nama_ekspedisi');
      $msteks['alamat'] = $this->input->post('alamat');
			$msteks['no_telp'] = $this->input->post('no_telp');
			$msteks['id_provinsi'] = $this->input->post('id_provinsi');
			$msteks['id_kota'] = $this->input->post('id_kota');
			$msteks['id_kec'] = $this->input->post('id_kec');
			$msteks['tipe_ekspedisi'] = $this->input->post('tipe_ekspedisi');
      $this->db->insert('master_ekspedisi_lokal', $msteks);
      $last_id = $this->db->insert_id();
      $this->session->set_flashdata('msg','success');
      redirect(site_url('admin/ekspedisi_lokal'));

  }

  function update($data)
  {                       //data Pelanggan

       $msteks['nama_ekspedisi'] = $this->input->post('nama_ekspedisi');
       $msteks['alamat'] = $this->input->post('alamat');
       $msteks['no_telp'] = $this->input->post('no_telp');
			 $msteks['id_provinsi'] = $this->input->post('id_provinsi');
 			$msteks['id_kota'] = $this->input->post('id_kota');
 			$msteks['id_kec'] = $this->input->post('id_kec');
 			$msteks['tipe_ekspedisi'] = $this->input->post('tipe_ekspedisi');
    	 $this->db->where('id_ekspedisi',$this->input->post('id_ekspedisi'));
       $this->db->update('master_ekspedisi_lokal', $msteks);
			 // die("ok");
       $this->session->set_flashdata('msg','updated');
       redirect(site_url('admin/ekspedisi_lokal'));


  }

  function deleted($data)
  {                       //data Pelanggan
      $kurs['aktif'] = '1';

      	$this->db->where('id_cust',$this->input->post('id_cust'));
        $this->db->update('kurs', $kurs);

        redirect(site_url('admin/kurs'));

  }
}
