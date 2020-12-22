<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Realtime extends CI_Controller {

	public function __construct(){
		parent::__construct();
		cek_session(); //cek session User Login
	}

	//Function Halaman Awal Menu Customer

	 function request_resi(){
      $id= $this->session->userdata('id_pengguna');
			$this->db->select('file_packing_resi.*')->from('file_packing_resi');
      $this->db->join('customer','file_packing_resi.kode_marking=customer.kode','left');
			if($this->session->userdata('level') == "crm"){
				$this->db->where('customer.id_crm',$id);
			}else if($this->session->userdata('level') == "spv"){
				$this->db->where('customer.id_crm',0);
			}else if($this->session->userdata('level') == "suadmin"){
				// $this->db->where('customer.id_crm',0);
			}else{
				$this->db->where('customer.id_crm',"-1");
			}
			$this->db->limit(10);
      $this->db->where('status_fpr',0);
      $this->db->order_by('id_fp_resi','desc');
      $reqpl = $this->db->get()->result();
      // $cust_grup = $this->db->where('id_cgrup >',0)->get('customer_grup')->result();
      $lists = '';
                           foreach($reqpl as $rp){
                             $lists .= '
                               <tr>
                                 <td>'.$rp->tanggal_fpr .'</td>
                                 <td>'.$rp->nomor_resi .'</td>
                                 <td>'.$rp->kode_marking .'</td>
                                 <td><span class="label label-warning">Warning</span></td>
                                 <td>
                                   <div class="sparkbar" data-color="#f39c12" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div>
                                 </td>
                               </tr>
                             ';
                           }
     $callback = array('listresi'=>$lists); // Masukan variabel lists tadi ke dalam array $callback dengan index array : list_kota
     echo json_encode($callback);
	 }

	 function afix(){ //alamat tidak fix
		 $tgl = date('Y-m-d');
     $tglskrg = date("Y-m-d", strtotime("-50 days", strtotime($tgl)));
		 $this->db->select('customer.nama,customer.kode,customer.alamat,customer.email,customer.id_cust');
     $this->db->from('resi');
		 $this->db->join('customer','resi.cust_id=customer.id_cust','left');
		 $this->db->where('customer.fix_alamat is null',null,false);
		 $this->db->where('customer.id_cust >',0);
		 $this->db->where('customer.s_aktivasi',"Sudah Aktivasi");
		 $this->db->where('resi.tanggal >=',$tglskrg);
		 $this->db->limit(10);
		 $this->db->order_by('id_cust','desc');
		 $this->db->group_by('resi.cust_id');
		 if($this->session->userdata('level') == "crm"){
			 $this->db->where('customer.id_crm',$this->session->userdata('id_pengguna'));
		 }else if($this->session->userdata('level') == "suadmin"){

		 }else if($this->session->userdata('level') == "spv"){
			 $this->db->where('customer.id_crm',0);
		 }else{
			 $this->db->where('customer.id_crm',"-1");
		 }
		 $afix = $this->db->get()->result();
		 $lists = '';
                           foreach($afix as $af){
                             $lists .= '
                               <tr>
                                 <td>'.$af->nama .'</td>
                                 <td>'.$af->kode .'</td>
                                 <td>'.$af->alamat .'</td>
																 <td>'.$af->email .'</td>
                                 <td><a href="'.site_url().'admin/customer/edit_customer/'.$af->id_cust.'" target="_blank" class="btn btn-xs btn-primary btn-block" alt="Update Data">Update</b></a></td>
                               </tr>
                             ';
                           }
     $callback = array('listcust'=>$lists); // Masukan variabel lists tadi ke dalam array $callback dengan index array : list_kota
     echo json_encode($callback);
	 }

}
