<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mobilsj extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		cek_session(); //cek session Login
		$this->load->model('Mmobil_sj');
	}

  function index(){
		// dd("ok");
		$data['data_mobil'] = $this->db->where('id_mobil >',0)->order_by('status_mobil','desc')->get('mobil')->result();
		$this->template->load('template','admin/Mobilsj/index',$data);
	}

	function detail_mobil(){
		// dd("ok");
		$id = $this->uri->segment(4);
		$data['data_mobil'] = $this->db->where('id_mobil',$id)->get('mobil')->row();
		$data['data_sj'] = $this->db->select('sj_wc.id_sj,sj_wc.kode_sj,sj_wc.tanggal_kirim,sj_wc.tanggal_terima,sj_wc.status,customer.kode,
																					mobil.plat_mobil,sum(volume*jumlah) as cbm')
															->from('giw')
															->join('invoice_product', 'invoice_product.id_giw=giw.id','left')
															->join('sj_wc', 'sj_wc.id_sj=invoice_product.id_sj_wc','left')
															->join('customer', 'sj_wc.id_cust=customer.id_cust')
															->join('mobil', 'sj_wc.id_mobil=mobil.id_mobil')
															->order_by('sj_wc.status','asc')
															->order_by('sj_wc.id_mobil','desc')
															->order_by('sj_wc.id_sj','desc')
															->where('sj_wc.id_mobil',$id)
															->where('sj_wc.status <',2)
															->group_by('sj_wc.id_sj')
															->get()->result();
		$this->template->load('template','admin/Mobilsj/detail_mobil',$data);
	}

	function update_mobil(){
		$updmobil['plat_mobil'] = $this->input->post('plat_mobil');
		$updmobil['limit_cbm'] = $this->input->post('limit_cbm');
		$this->db->where('id_mobil',$this->input->post('id_mobil'))->update('mobil',$updmobil);
		$this->session->set_flashdata('msg','okupdate');
		redirect(site_url('admin/mobilsj/detail_mobil/'.$this->input->post('id_mobil')));
	}

	function detail_sj(){
		// dd("ok");
		$id = $this->uri->segment(4);
		$data['data_sj'] = $this->db->select('sj_wc.*,provinsi.nama as namaprov,kabupaten.nama as namakota
																					,kecamatan.nama as namakec,customer.alamat as almtcust
																					,master_ekspedisi_lokal.tipe_ekspedisi,master_ekspedisi_lokal.nama_ekspedisi
																					,master_ekspedisi_lokal.alamat as almteks,master_ekspedisi_lokal.id_ekspedisi,
																					master_ekspedisi_lokal.no_telp as notelpeks,customer.kode,mobil.plat_mobil
																					,customer.id_provinsi2,customer.id_kota2
																					,customer.id_kec2,customer.telepon as telpcs,customer.whatsapp as wacs')
															  ->from('sj_wc')
																->join('mobil', 'mobil.id_mobil=sj_wc.id_mobil','left')
																->join('customer', 'customer.id_cust=sj_wc.id_cust','left')
																->join('master_ekspedisi_lokal', 'customer.id_ekspedisi=master_ekspedisi_lokal.id_ekspedisi','left')
																->join('provinsi', 'customer.id_provinsi=provinsi.id_prov','left')
																->join('kabupaten', 'customer.id_kota=kabupaten.id_kab','left')
																->join('kecamatan', 'customer.id_kec=kecamatan.id_kec','left')
																->where('sj_wc.id_sj',$id)
																->get()->row();//dd($data['data_sj']);
		$data['data_barang'] = $this->db->select('giw.nomor,resi.nomor as nomor_resi,sum(volume*jumlah) as cbm,ctns as jumlah_koli,giw.customer_id')
															->from('giw')
															->join('invoice_product', 'invoice_product.id_giw=giw.id','left')
															->join('resi', 'giw.resi_id=resi.id_resi','left')
															->order_by('giw.id','desc')
															->group_by('giw.id')
															->where('invoice_product.id_sj_wc',$id)
															->get()->result();
		$this->template->load('template','admin/Mobilsj/detail_sj',$data);
	}

	function get_sj_json() {
    header('Content-Type: application/json');
    echo $this->Mmobil_sj->datasj();
  }

	function kirim_mobil(){
		$id_mobil = $this->uri->segment(4);
		$updmobil['status_mobil'] = 1;
		$savemobil = $this->db->where('id_mobil',$id_mobil)->update('mobil',$updmobil);
		$updsjwc['status'] = 1;
		$updsjwc['tanggal_kirim'] = date('Y-m-d');
		$savesj = $this->db->where('id_mobil',$id_mobil)->where('status',0)->update('sj_wc',$updsjwc);
		if($savesj){
		  //  $qhist = $this->db->select('invoice_product.id_giw')->from('invoice_product')->where('sj_wc.id_mobil.',$id_resi)
		  //  ->join('sj_wc', 'invoice_product.id_sj_wc=sj_wc.id_sj', 'left')->get()->result();
		    
			$this->session->set_flashdata('msg','okkirim');
			redirect(site_url('admin/mobilsj'));
		}
	}

	function pengiriman_selesai(){
		$id_mobil = $this->uri->segment(4);
		$updmobil['status_mobil'] = 0;
		$savemobil = $this->db->where('id_mobil',$id_mobil)->update('mobil',$updmobil);
		$updsjwc['status'] = 2;
		$updsjwc['tanggal_terima'] = date('Y-m-d');
		$savesj = $this->db->where('id_mobil',$id_mobil)->where('status',1)->update('sj_wc',$updsjwc);
		if($savesj){
			$this->session->set_flashdata('msg','okeselesai');
			redirect(site_url('admin/mobilsj'));
		}
	}

	function cancel_sj(){
		$id_sj = $this->uri->segment(4);
		$updinvprod['id_sj_wc']= 0;
		$saveupd = $this->db->where('id_sj_wc',$id_sj)->update('invoice_product',$updinvprod);
		if($saveupd){
			$delsj =$this->db->where('id_sj',$id_sj)->delete('sj_wc');
			if($delsj){
				$this->session->set_flashdata('msg','okcancel');
				redirect(site_url('admin/mobilsj'));
			}
		}
	}
}
