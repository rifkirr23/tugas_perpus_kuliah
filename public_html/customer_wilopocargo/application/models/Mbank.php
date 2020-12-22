<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mbank extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	//Proses Get Data kurs
	function get_bank() { 
        $this->datatables->select('master_bank.id_bank,master_bank.nama_bank,master_bank.nomor_rekening_bank,master_bank.atas_nama_bank,master_bank.saldo_bank,master_bank.edit_saldo');
        $this->datatables->from('master_bank');
        $this->db->order_by('master_bank.nama_bank','asc');
        $this->datatables->add_column('view', '
        <center>
        <a href="javascript:void(0);" class="edit_record btn btn-warning btn-xs" data-id_bank="$1" data-nama_bank="$2" data-nomor_rekening_bank="$3" data-atas_nama_bank="$4" data-saldo_bank="$5" 
        data-edit_saldo="$6">
        <i class="fa fa-edit"></i>
        </a>
        <a href="'.site_url().'admin/bank/transaksi/$1" class="btn btn-info btn-xs"> <i class="fa fa-ellipsis-h"></i></a>
        </center>', 
         'id_bank,nama_bank,nomor_rekening_bank,atas_nama_bank,saldo_bank,edit_saldo');
        return $this->datatables->generate();
  }

  public function get_dbank($id){
    $this->db->where('id_bank',$id);
    
    return $this->db->get('master_bank');
  }

  	function save($data)
  {                       //data Pelanggan
     
      $jp['nama_bank'] = $this->input->post('nama_bank'); 
      $jp['nomor_rekening_bank'] = $this->input->post('nomor_rekening_bank'); 
      $jp['atas_nama_bank'] = $this->input->post('atas_nama_bank'); 
      $jp['saldo_bank'] = str_replace(".", "",$this->input->post('saldo_bank')); 
     
        $this->db->insert('master_bank', $jp);
        $last_id = $this->db->insert_id(); 
     
      $trb['id_jenis_transaksi_bank'] = 4; 
      $trb['id_bank'] = $last_id; 
      $trb['tipe_transaksi_bank'] = "masuk"; 
      $trb['nominal_transaksi_bank'] = $jp['saldo_bank']; 
      
      $trb['keterangan_transaksi_bank'] = "Saldo Awal"; 
      $trb['tanggal_transaksi_bank'] = date('Y-m-d');
      $trb['sisa_saldo_bank'] = $jp['saldo_bank'];
     
      
      $this->db->insert('transaksi_bank', $trb);
      
        $this->session->set_flashdata('msg','success');
        redirect(site_url('admin/bank'));

       
  }

  function update($data)
  { 
      if($this->input->post('edit_saldo')==0){
          
        $jp['saldo_bank'] = str_replace(".", "",$this->input->post('saldo_bank')); 
              
        $tb['nominal_transaksi_bank'] = $jp['saldo_bank']; 
        $tb['sisa_saldo_bank'] = $jp['saldo_bank']; 
      
          	$this->db->where('id_bank',$this->input->post('id_bank'));
          	$this->db->where('id_jenis_transaksi_bank',4);
            $this->db->update('transaksi_bank', $tb);
        
      }else if($this->input->post('edit_saldo')==1){
          
      }
      $jp['nama_bank'] = $this->input->post('nama_bank'); 
      $jp['nomor_rekening_bank'] = $this->input->post('nomor_rekening_bank'); 
      $jp['atas_nama_bank'] = $this->input->post('atas_nama_bank'); 
      
      
      	$this->db->where('id_bank',$this->input->post('id_bank'));
        $this->db->update('master_bank', $jp);
        

        $this->session->set_flashdata('msg','updated');
        redirect(site_url('admin/bank'));

       
  }
  
  public function select_bank($kode){
    $this->db->select('id_bank,nama_bank');
    $this->db->limit(10);
    $this->db->from('master_bank');
    $this->db->like('nama_bank', $kode);
    return $this->db->get()->result_array();
  }

  
}