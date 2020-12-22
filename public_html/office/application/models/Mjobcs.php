<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mjobcs extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	//Proses Get Data jobcs
	function get_jobcs() {
        $this->datatables->select('jobcs.id_job,pertanyaan,jawaban,tanggal,jobcs.status,pengguna.nama_pengguna,master_masalah.keterangan_masalah');
        $this->datatables->from('jobcs');
				$this->datatables->join('pengguna', 'jobcs.peminta=pengguna.id_pengguna');
				$this->datatables->join('master_masalah', 'jobcs.id_masalah=master_masalah.id_masalah');
        $this->datatables->add_column('view', '<center><a href="javascript:void(0);" class="edit_record btn btn-info btn-xs"
                                      data-id_job="$1" data-pertanyaan="$2" data-jawaban="$3" data-status="$4"> <i class="fa fa-edit"></i></a>
                                      <a href="javascript:void(0);" class="complete_record btn btn-success btn-xs"
                                      data-id_job="$1" data-status="$4"> <i class="fa fa-check"></i></a>
                                       </center>',
                                      'id_job,pertanyaan,jawaban,status');
        return $this->datatables->generate();
  }



  	function save($data)
  {
      $jobcs['pertanyaan'] = $this->input->post('pertanyaan');
      $jobcs['jawaban'] = $this->input->post('jawaban');
			$jobcs['id_masalah'] = $this->input->post('id_masalah');
			$jobcs['peminta'] = $this->session->userdata('id_pengguna');
      $jobcs['tanggal'] = date('Y-m-d H:i:s');
      $jobcs['status']  = 1;
      $this->db->insert('jobcs', $jobcs);
      $last_id = $this->db->insert_id();
      $this->session->set_flashdata('msg','success');
      redirect(site_url('admin/jobcs'));

  }

  function update($data)
  {                       //data Pelanggan
      $jobcs['pertanyaan'] = $this->input->post('pertanyaan');
      $jobcs['jawaban'] = $this->input->post('jawaban');
			$jobcs['peminta'] = $this->session->userdata('id_pengguna');
    	$this->db->where('id_job',$this->input->post('id_job'));
      $this->db->update('jobcs', $jobcs);

      $this->session->set_flashdata('msg','updated');
      redirect(site_url('admin/jobcs'));

  }

  function complete($data)
  {                       //data Pelanggan
      $jobcs['status'] = 2;
    	$this->db->where('id_job',$this->input->post('id_job'));
      $this->db->update('jobcs', $jobcs);

      $this->session->set_flashdata('msg','completed');
      redirect(site_url('admin/jobcs'));

  }

  function deleted($data)
  {                       //data Pelanggan
      $jobcs['aktif'] = '1';

      	$this->db->where('id_cust',$this->input->post('id_cust'));
        $this->db->update('jobcs', $jobcs);

        redirect(site_url('admin/jobcs'));


  }
}
