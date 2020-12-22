<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mtransaksi extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	//Proses Get Data transaksi
	function get_transaksi() {
        $this->datatables->select('id_pinjam,nama_anggota,judul_buku,tgl_pinjam,tgl_kembali,total_denda,status_pinjam');
        $this->datatables->from('peminjaman');
				$this->datatables->join('anggota', 'anggota.id_anggota=peminjaman.id_anggota');
				$this->datatables->join('buku', 'buku.id_buku=peminjaman.id_buku');
				$q="$1";
        $this->datatables->add_column('view', '<center><a onclick="return confirm(`Selesaikan Peminjaman?`);" href="'.site_url().'admin/transaksi/selesaikan/$1" class="btn btn-success btn-xs" data-id_buku="$1"> <i class="fa fa-hourglass"></i></a>
                                               <a onclick="return confirm(`Hapus Transaksi?`);" href="'.site_url().'admin/transaksi/delete/$1" class="btn btn-danger btn-xs" data-id_buku="$1"> <i class="fa fa-close"></i></a> </center>',
         'id_pinjam,judul_transaksi,pengarang');
        return $this->datatables->generate();
  }



  	function save($data)
  {
      $transaksi['transaksi_jual'] = str_replace(".", "",$this->input->post('transaksi_jual'));
      $transaksi['transaksi_beli'] = str_replace(".", "",$this->input->post('transaksi_beli'));
			$transaksi['transaksi_klaim'] = str_replace(".", "",$this->input->post('transaksi_klaim'));
      $transaksi['fee_cs'] = str_replace(".", "",$this->input->post('fee_cs'));
      $this->db->insert('transaksi', $transaksi);
      $last_id = $this->db->insert_id();
      $this->session->set_flashdata('msg','success');
      redirect(site_url('admin/transaksi'));

  }

  function update($data)
  {                       //data Pelanggan

       $transaksi['transaksi_jual'] = str_replace(".", "",$this->input->post('transaksi_jual'));
       $transaksi['transaksi_beli'] = str_replace(".", "",$this->input->post('transaksi_beli'));
       $transaksi['fee_cs'] = str_replace(".", "",$this->input->post('fee_cs'));
			 $transaksi['transaksi_klaim'] = str_replace(".", "",$this->input->post('transaksi_klaim'));
    	 $this->db->where('id_transaksi',$this->input->post('id_transaksi'));
       $this->db->update('transaksi', $transaksi);
			 $pesan = "*Update Info transaksi RMB*".
			 					"\n\ntransaksi Jual : Rp. ".number_format($transaksi['transaksi_jual']);
			 whatsapp_grup("1583918717",$pesan,"081310085523");
			 // die("ok");
       $this->session->set_flashdata('msg','updated');
       redirect(site_url('admin/transaksi'));


  }

  function deleted($data)
  {                       //data Pelanggan
      $transaksi['aktif'] = '1';

      	$this->db->where('id_cust',$this->input->post('id_cust'));
        $this->db->update('transaksi', $transaksi);

        redirect(site_url('admin/transaksi'));


  }
}
