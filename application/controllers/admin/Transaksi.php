<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		cek_session(); //cek session Login
		$this->load->model('Mtransaksi');
	}

	//Function Halaman Awal Menu transaksi
	function index(){
		$this->db->like('id_pinjam');
		$this->db->from('peminjaman');
		$data['jumlah_transaksi'] = $this->db->count_all_results();
		$data['anggota'] = $this->db->get('anggota')->result();
		$data['buku'] = $this->db->get('buku')->result();
		$this->template->load('template','admin/transaksi/transaksi',$data);
	}

	//Function Get data Json transaksi
	function get_transaksi_json() {
    header('Content-Type: application/json');
    echo $this->Mtransaksi->get_transaksi();
  }

   //Function Simpan Add New transaksi
  function save(){
		// dd($this->input->post());
    $instransaksi['id_anggota'] = $this->input->post('id_anggota');
		$instransaksi['id_buku'] = $this->input->post('id_buku');
    $instransaksi['tanggal'] = date('Y-m-d');
    $instransaksi['tgl_pinjam'] = $this->input->post('tgl_pinjam');
    $instransaksi['tgl_kembali'] = $this->input->post('tgl_kembali');
    $instransaksi['total_denda'] = 0;
    $instransaksi['status_pinjam'] = 0;
    $this->db->insert('peminjaman',$instransaksi);

    redirect($_SERVER['HTTP_REFERER']);
  }

	// Function Update transaksi
  function update(){
    $data = $this->Mtransaksi->update($this->input->post());
  }

	function delete(){
	   $id= $this->uri->segment(4);
	   $delete = $this->db->where('id_pinjam',$id)->delete('peminjaman');
	   redirect($_SERVER['HTTP_REFERER']);
  }

	function selesaikan(){
	   $id= $this->uri->segment(4);
	   $dpinjam = $this->db->where('id_pinjam',$id)->get('peminjaman')->row();
		 $now = date('Y-m-d');
		 $tglkembaliasli  = strtotime($now);
		 $tglkembaliest    = strtotime($dpinjam->tgl_kembali);
		 $diff   = $tglkembaliasli - $tglkembaliest;
		 $jumlah_hari = floor($diff / (60 * 60 * 24));
		 $instransaksi['total_denda'] = $jumlah_hari * 5000;
     $instransaksi['status_pinjam'] = 1;
     $this->db->update('peminjaman',$instransaksi);

	   redirect($_SERVER['HTTP_REFERER']);
  }



}
