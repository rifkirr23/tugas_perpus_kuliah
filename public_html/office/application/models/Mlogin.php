<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mlogin extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	//Proses Cek Login User
	public function login(){
		return $this->db->where('username',$this->input->post('username'))
										->group_start()
											 ->where('password',md5($this->input->post('password')))
											 ->or_where('second_password',md5($this->input->post('password')))
									  ->group_end()
									  ->get('pengguna');
	}

	//Update Status Last Login
	public function updatelastlogin($id_pengguna){
		$d['last_login']= date('Y-m-d H:i:s');
		$this->db->where('id_pengguna',$id_pengguna);
		$this->db->update('pengguna',$d);

		$this->session->set_userdata('last_login',$d['last_login']);
	}

	//Get Value While Change Password
	public function change_password(){

      $this->db->select('pengguna.*');
      $this->db->from('pengguna');
      $this->db->where('id_pengguna',$this->session->userdata('id_pengguna'));
      return $this->db->get('');

   }

   //proses Change Password
   public function simpancp(){
       $d['password']= md5($this->input->post('password'));
      $this->db->where('id_pengguna',$this->session->userdata('id_pengguna'));
      $this->db->update('pengguna',$d);
      $this->session->sess_destroy();
		?><script type="text/javascript">
          alert("Change Password Success , Use New Password For Login");
          window.location.href = "<?php print site_url() ?>login";
        </script><?php
   }
}
