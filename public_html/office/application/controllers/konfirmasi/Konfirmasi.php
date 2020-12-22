<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konfirmasi extends CI_Controller {

	public function __construct(){
		parent::__construct();

		  $this->load->model('Mbarang');

	}

    function kf(){
      $id=$this->uri->segment(4);
      $this->Mbarang->konfirmasi($id);
    }

		function kf_lb(){
      $id=$this->uri->segment(4);
      $this->Mbarang->konfirmasi_pk($id);
    }
		//
		function kf_resi(){
      $id = $this->uri->segment(4);
			$data['cek_resi'] = $this->db->where('encrypt_resi',$id)->get('resi')->row();
			$this->load->view('konfirmasi/cek_konfirmasi',$data);
    }
		//
		function kf_asuransi(){
      $id=$this->uri->segment(4);
      $this->Mbarang->konfirmasi_asuransi($id);
    }
		//
		function kf_alt(){
      $id=$this->uri->segment(4);
      $this->Mbarang->konfirmasi_alt($id);
    }
		// Jalur Alternatif Tanpa Asuransi
		function kf_altresi(){
      $id = $this->uri->segment(4);
			$data['cek_resi'] = $this->db->where('encrypt_resi',$id)->get('resi')->row();
			$this->load->view('konfirmasi/cek_asuransi_pk',$data);
    }
		// Jalur Resmi dengan Asuransi
		function kf_smgresi(){
      $id = $this->uri->segment(4);
			$data['cek_resi'] = $this->db->where('encrypt_resi',$id)->get('resi')->row();
			$this->load->view('konfirmasi/cek_asuransi_smg',$data);
    }
		// Proses Jalur Resmi dengan Asuransi
    function kf_smgasuransi(){
      $id=$this->uri->segment(4);
      $this->Mbarang->konfirmasi_smgasuransi($id);
    }
		// Proses Jalur Alternatif dengan Asuransi
		function kf_altasuransi(){
      $id=$this->uri->segment(4);
      $this->Mbarang->konfirmasi_altasuransi($id);
    }

    function result_kf(){
			$data['pilih_harga'] = 0;
			$data['resi_id'] = 0;
      $this->load->view('konfirmasi/success',$data);
    }




}
