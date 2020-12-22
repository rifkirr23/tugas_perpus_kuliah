<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	public function __construct(){ //Construct Function
		parent:: __construct();
		$this->load->model('Mcustomer');//Load Model Login
	}

	//load view login
	public function index(){
		$data['provinsi'] = $this->db->get('provinsi')->result();
		// print_r($data['provinsi']);die();
		$this->load->view('register',$data);
	}

	public function listkota(){
			// Ambil data ID Provinsi yang dikirim via ajax post
			$id_provinsi = $this->input->post('id_provinsi');
			 $kota = $this->db->where('id_prov',$id_provinsi)->get('kabupaten')->result();
			// Buat variabel untuk menampung tag-tag option nya
			// Set defaultnya dengan tag option Pilih
			$lists = "";
			$lists .="<option value=''>--Pilih--</option>";
			foreach($kota as $data){
					$lists .= "<option value='".$data->id_kab."'>".$data->nama."</option>"; // Tambahkan tag option ke variabel $lists
			}
			$callback = array('list_kota'=>$lists); // Masukan variabel lists tadi ke dalam array $callback dengan index array : list_kota
			echo json_encode($callback); // konversi varibael $callback menjadi JSON
	}
	public function listkecamatan(){
		// Ambil data ID Provinsi yang dikirim via ajax post
		$id_kota = $this->input->post('id_kota');
		 $kota = $this->db->where('id_kab',$id_kota)->get('kecamatan')->result();
		// Buat variabel untuk menampung tag-tag option nya
		// Set defaultnya dengan tag option Pilih
		$lists = "";
		        $lists .="<option value=''>--Pilih--</option>";
		foreach($kota as $data){
				$lists .= "<option value='".$data->id_kec."'>".$data->nama."</option>"; // Tambahkan tag option ke variabel $lists
		}
		$callback = array('list_kota'=>$lists); // Masukan variabel lists tadi ke dalam array $callback dengan index array : list_kota
		echo json_encode($callback); // konversi varibael $callback menjadi JSON
	}
	public function listkelurahan(){
		// Ambil data ID Provinsi yang dikirim via ajax post
		$id_kec = $this->input->post('id_kec');
		 $kota = $this->db->where('id_kec',$id_kec)->get('kelurahan')->result();
		// Buat variabel untuk menampung tag-tag option nya
		// Set defaultnya dengan tag option Pilih
		$lists = "";
		$lists .="<option value=''>--Pilih--</option>";
		foreach($kota as $data){
				$lists .= "<option value='".$data->id_kel."'>".$data->nama."</option>"; // Tambahkan tag option ke variabel $lists
		}
		$callback = array('list_kota'=>$lists); // Masukan variabel lists tadi ke dalam array $callback dengan index array : list_kota
		echo json_encode($callback); // konversi varibael $callback menjadi JSON
	}
	//Load View change password user
	public function save(){
		// save Model
		// upload
		$secret_key = "6Ld_u9MUAAAAAECKBIXb5LdX_YIAWJZI1qtR0upH";
        $verify = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$this->input->post('g-recaptcha-response'));
        $response = json_decode($verify);
        if($response->success){
                        $vemail      = $this->input->post('email');
                        $vmarking      = "123/WC-".$this->input->post('kode');
		                $cek_marking  = $this->db->where('kode',$vmarking)->get('customer')->num_rows();
		                $cek_email  = $this->db->where('email',$vemail)->get('customer')->num_rows();
		                
		                if($cek_marking > 0 or $cek_email > 0){
		                    $this->session->set_flashdata('msg','kodeada');
                            redirect(site_url('register'));
		                }else{
                    		$temp1 = explode(".", $_FILES['foto_ktp']['name']);
                    		$new_name1 = time().'.'.end($temp1);
                    		$config1['upload_path'] = '../office/assets/foto_ktp/';
                    		$config1['quality']= '50%';
                    // 		$config1['max_size']= '1700';
                            $config1['width']= 600;
                            $config1['height']= 400;
                    		$config1['file_name'] = $new_name1;
                    		$config1['allowed_types'] = 'jpg|jpeg|png|pdf';
                    		$this->image_lib->resize();
                    		$this->load->library('upload');
                    		$this->upload->initialize($config1);
                    		if(!$this->upload->do_upload('foto_ktp')){
                    // 			$this->upload->display_errors();
                    // 			$new_name1 = "";
                    		}
                    		$media1 = $this->upload->data('foto_ktp');
                    	    $this->Mcustomer->save($new_name1);
                        }
        }else{
            $this->session->set_flashdata('msg','recapchasalah');
            redirect(site_url('register'));
        }
    }
	
	public function verifikasi(){
	    $idpeng= $this->uri->segment(3);
	   // echo "$id";
	  $this->Mcustomer->verifikasiemail($idpeng);
	}
	public function verifikasiman(){
	    $idpeng= $this->uri->segment(3);
	   // echo "$id";
	  $this->Mcustomer->verifikasimanual($idpeng);
	}
	public function emailtelegram(){
	    $idpeng= $this->uri->segment(3);
	   // echo "$id";
	  $this->Mcustomer->telegram($idpeng);
	}

	//Cek Marking
	public function cek_marking(){
		// Cek
		$marking      = "123/WC-".$this->input->post('kode_mark');
		$cek_marking  = $this->db->where('kode',$marking)->get('customer')->num_rows();
		if($cek_marking > 0){
			$result = "1";
		}else{
			$result = "0";
		}
		$callback = array('result'=>$result);
		echo json_encode($callback);
	}
	public function cek_email(){
		// Cek
		$email      = $this->input->post('email');
		$cek_email  = $this->db->where('email',$email)->get('customer')->num_rows();
		if($cek_email > 0){
			$result = "1";
		}else{
			$result = "0";
		}
		$callback = array('result'=>$result);
		echo json_encode($callback);
	}

}
