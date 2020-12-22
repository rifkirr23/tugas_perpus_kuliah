<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Maccount extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	//Proses Get Data account
	function get_account() {
        $this->datatables->select('pengguna.id_pengguna,pengguna.nama_pengguna,pengguna.username,pengguna.password,pengguna.level,pengguna.last_login');
        $this->datatables->from('pengguna');
        $this->datatables->add_column('view', '<center><a href="javascript:void(0);" class="edit_record btn btn-warning btn-xs" data-id_pengguna="$1" data-nama_pengguna="$2" data-username="$3" data-password="$4" data-level="$5"> <i class="fa fa-edit"></i></a> </center>',
         'id_pengguna,nama_pengguna,username,password,level');
        return $this->datatables->generate();
  }



  	function save($data)
  {                       //data Pelanggan

      $account['nama_pengguna'] = $this->input->post('nama_pengguna');
      $account['username'] = $this->input->post('username');
      $account['password'] = md5($this->input->post('password'));
      $account['level'] = $this->input->post('level');


        $this->db->insert('pengguna', $account);
        $last_id = $this->db->insert_id();

        $this->session->set_flashdata('msg','success');
        redirect(site_url('admin/account'));


  }

  function update($data)
  {                       //data Pelanggan
      $account['nama_pengguna'] = $this->input->post('nama_pengguna');
      $account['username'] = $this->input->post('username');

    if($this->input->post('password')==""){

    }else{
      $account['password'] = md5($this->input->post('password'));
    }

      $account['level'] = $this->input->post('level');

      	$this->db->where('id_pengguna',$this->input->post('id_pengguna'));
        $this->db->update('pengguna', $account);

        $this->session->set_flashdata('msg','updated');
        redirect(site_url('admin/account'));


  }

  function deleted($data)
  {                       //data Pelanggan
      $account['aktif'] = '1';

      	$this->db->where('id_cust',$this->input->post('id_cust'));
        $this->db->update('account', $account);

        redirect(site_url('admin/account'));


  }
}
