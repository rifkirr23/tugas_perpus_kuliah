<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mlogin extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	//Proses Cek Login User
	public function login(){
		$cek=$this->db->select('pengguna_customer.id_pengguna,pengguna_customer.last_login,pengguna_customer.count,pengguna_customer.level')
				->from('pengguna_customer')
				->join('customer', 'customer.id_cust=pengguna_customer.id_cust')
                ->where('pengguna_customer.username',$this->input->post('username'))
                ->or_where('customer.email',$this->input->post('username'))
				->get()->row();
// 		$blmuser=$this->db->select('id')
// 				->from('customer')
//                 ->where('customer.kode',$this->input->post('username'))
//                 ->or_where('customer.email',$this->input->post('username'))
// 				->get()->row();
		$datesekarang=date('Y-m-d H:i:s');
		$jambisalogin = date('Y-m-d H:i:s',strtotime('+15 minutes',strtotime($cek->last_login)));
		$convdatesekarang=strtotime($datesekarang);
		$convjambisalogin=strtotime($jambisalogin);
		// var_dump($jambisalogin);
		//cekwaktu banned15
		if($cek->count >= 3 and $convdatesekarang < $convjambisalogin){
			// var_dump('sdfsd');
			$hitungselisih=$convdatesekarang-$convjambisalogin;
			$hasil=floor($hitungselisih/60);
			return $hasil;
		}else{
			if($cek->id_pengguna > 0){

				$ceklog=$this->db->select('pengguna_customer.*, customer.nama, customer.kode, customer.status_ganti_marking')
				->from('pengguna_customer')
				->join('customer', 'customer.id_cust=pengguna_customer.id_cust')
                ->where('pengguna_customer.id_pengguna',$cek->id_pengguna)
				->where('pengguna_customer.password',md5($this->input->post('password')))
				->get()->row();
				//cek kebenaran login
				if($ceklog->id_pengguna > 0){
					$reken['last_login'] = date('Y-m-d H:i:s');
					$reken['count'] = 0;
					$this->db->where('id_pengguna',$cek->id_pengguna);
					$this->db->update('pengguna_customer', $reken);
					return $ceklog;
				}else{
					if($cek->count >= 3){
						$reken['last_login'] = date('Y-m-d H:i:s');
						$reken['count'] = 1;
						$this->db->where('id_pengguna',$cek->id_pengguna);
						$this->db->update('pengguna_customer', $reken);
					}
					$reken['last_login'] = date('Y-m-d H:i:s');
					$reken['count'] = $cek->count+1;
					$this->db->where('id_pengguna',$cek->id_pengguna);
					$this->db->update('pengguna_customer', $reken);
					$hasil='salahpass';
					return $hasil;
				}
			}else if($cek->id_pengguna > 0){
			    $hasil='tidakaktif';
				return $hasil;
			}else{
				$hasil='salahus';
				return $hasil;
			}
		}
	}

	//Update Status Last Login
	public function updatelastlogin($id_pengguna){
		$d['last_login']= date('Y-m-d H:i:s');
		$this->db->where('id_cust',$id_pengguna);
		$this->db->update('customer',$d);

		$this->session->set_userdata('last_login',$d['last_login']);
	}

	//Get Value While Change Password
	public function change_password(){

      $this->db->select('customer.*');
      $this->db->from('customer');
      $this->db->where('id_cust',$this->session->userdata('id_cust'));
      return $this->db->get('');


   }

   //proses Change Password
   public function simpancp(){
       $d['password']= md5($this->input->post('password'));
      $this->db->where('id_cust',$this->session->userdata('id_cust'));
      $this->db->update('customer',$d);
      $this->session->sess_destroy();
		?><script type="text/javascript">
          alert("Change Password Success , Use New Password For Login");
          window.location.href = "<?php print site_url() ?>login";
        </script><?php
   }
}
