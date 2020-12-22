<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stok_barang extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		cek_session(); //cek session Login
		$this->load->model('Mstok_barang');
	}

  function index(){
		// dd("ok");
		$id = $this->uri->segment(4);
		$data['dc'] = $this->db->where('id_rts',$id)->get('container')->row();
		$data['data_mobil'] = $this->db->where('status_mobil',0)->get('mobil')->result();
		$data['data_posisi'] = $this->db->where('id_posisi_indo <',20)->where('id_posisi_indo !=',5)->get('posisi_indo')->result();
		$data['data_resi'] = $this->db->select('resi.nomor as nomor_resi,sum(giw.volume * invoice_product.jumlah) as cbm, sum(invoice_product.jumlah) as jumlah_koli
																					 , sum(giw.berat * invoice_product.jumlah) as total_berat,customer.kode as marking,resi.id_resi,posisi_indo.tempat
																					 ,container.kode as no_cont,master_ekspedisi_lokal.nama_ekspedisi,master_ekspedisi_lokal.alamat as almteks,
																					 master_ekspedisi_lokal.no_telp as notelpeks,master_ekspedisi_lokal.tipe_ekspedisi,customer.id_ekspedisi,provinsi.nama as namaprov,kabupaten.nama as namakota
																					 ,kecamatan.nama as namakec,customer.alamat as almtcust,giw.boleh_kirim,customer.ekspedisi_lokal
																					 ,customer.telepon as telpcs,customer.whatsapp as wacs,customer.id_provinsi2,customer.id_kota2
																					 ,customer.id_kec2,giw.tanggal_boleh_kirim')
																	->from('invoice_product')
 																	->join('posisi_indo', 'invoice_product.posisi_indo=posisi_indo.id_posisi_indo','left')
 																	->join('giw', 'invoice_product.id_giw=giw.id','left')
                                  ->join('container', 'container.id_rts=giw.container_id','left')
																	->join('customer', 'customer.id_cust=giw.customer_id','left')
																	->join('master_ekspedisi_lokal', 'customer.id_ekspedisi=master_ekspedisi_lokal.id_ekspedisi','left')
																	->join('provinsi', 'customer.id_provinsi=provinsi.id_prov','left')
																	->join('kabupaten', 'customer.id_kota=kabupaten.id_kab','left')
																	->join('kecamatan', 'customer.id_kec=kecamatan.id_kec','left')
																	->join('resi', 'giw.resi_id=resi.id_resi','left')
																	->where('invoice_product.posisi_indo <',99)
                                  ->where('invoice_product.posisi_indo >',0)
																	->where('invoice_product.id_sj_wc',0)
																	->where('resi.id_resi >',0)
																	->order_by('giw.boleh_kirim',"desc")
																	->order_by('master_ekspedisi_lokal.tipe_ekspedisi','asc')
																	->order_by('customer.id_provinsi2',"desc")
																	->order_by('customer.id_kota2',"desc")
																	->order_by('customer.id_kec2',"desc")
																	->order_by('customer.id_cust',"desc")
																	->group_by('resi.id_resi')
																	->get()->result();
																	// dd($this->db->last_query());
		// $data['data_resi'] = $this->db->query("SELECT resi.nomor as nomor_resi,sum(giw.volume * invoice_product.jumlah) as cbm, sum(invoice_product.jumlah) as jumlah_koli
		// 																			 , sum(giw.berat * invoice_product.jumlah) as total_berat,customer.kode as marking,resi.id_resi,posisi_indo.tempat
		// 																			 ,container.kode as no_cont,master_ekspedisi_lokal.nama_ekspedisi,master_ekspedisi_lokal.alamat as almteks,
		// 																			 master_ekspedisi_lokal.no_telp as notelpeks,master_ekspedisi_lokal.tipe_ekspedisi,customer.id_ekspedisi,provinsi.nama as namaprov,kabupaten.nama as namakota
		// 																			 ,kecamatan.nama as namakec,customer.alamat as almtcust,giw.boleh_kirim,customer.ekspedisi_lokal
		// 																			 ,customer.telepon as telpcs,customer.whatsapp as wacs,master_ekspedisi_lokal.id_provinsi,master_ekspedisi_lokal.id_kota
		// 																			 ,master_ekspedisi_lokal.id_kec
		// 																			 FROM giw
		// 																			 left join posisi_indo on giw.posisi_indo=posisi_indo.id_posisi_indo
		// 																			 left join container on container.id_rts=giw.container_id
		// 																			 left join invoice_product on invoice_product.id_giw=giw.id
		// 																			 left join customer on customer.id_cust=giw.customer_id
		// 																			 left join master_ekspedisi_lokal on customer.id_ekspedisi=master_ekspedisi_lokal.id_ekspedisi
		// 																			 left join provinsi on customer.id_provinsi=provinsi.id_prov
		// 																			 left join kabupaten on customer.id_kota=kabupaten.id_kab
		// 																			 left join kecamatan on customer.id_kec=kecamatan.id_kec
		// 																			 left join resi on giw.resi_id=resi.id_resi
		// 																			 where giw.posisi_indo < 20
		// 																			 and giw.posisi_indo > 0
		// 																			 group by resi.id_resi
		// 																			 order by giw.boleh_kirim desc,master_ekspedisi_lokal.tipe_ekspedisi asc,
		//
		//
		// 																			 ")->result();
		$this->template->load('template','admin/stok_barang/index',$data);
	}
	function viewpdf(){
		$data['data_resi'] = $this->db->select('resi.nomor as nomor_resi,sum(giw.volume * invoice_product.jumlah) as cbm, sum(invoice_product.jumlah) as jumlah_koli
																					 , sum(giw.berat * invoice_product.jumlah) as total_berat,customer.kode as marking,resi.id_resi,posisi_indo.tempat
																					 ,container.kode as no_cont,master_ekspedisi_lokal.nama_ekspedisi,master_ekspedisi_lokal.alamat as almteks,
																					 master_ekspedisi_lokal.no_telp as notelpeks,master_ekspedisi_lokal.tipe_ekspedisi,customer.id_ekspedisi,provinsi.nama as namaprov,kabupaten.nama as namakota
																					 ,kecamatan.nama as namakec,customer.alamat as almtcust,giw.boleh_kirim,customer.ekspedisi_lokal
																					 ,customer.telepon as telpcs,customer.whatsapp as wacs,customer.id_provinsi2,customer.id_kota2
																					 ,customer.id_kec2')
																	->from('invoice_product')
																	->join('posisi_indo', 'invoice_product.posisi_indo=posisi_indo.id_posisi_indo','left')
																	->join('giw', 'invoice_product.id_giw=giw.id','left')
                                  ->join('container', 'container.id_rts=giw.container_id','left')
																	->join('customer', 'customer.id_cust=giw.customer_id','left')
																	->join('master_ekspedisi_lokal', 'customer.id_ekspedisi=master_ekspedisi_lokal.id_ekspedisi','left')
																	->join('provinsi', 'customer.id_provinsi=provinsi.id_prov','left')
																	->join('kabupaten', 'customer.id_kota=kabupaten.id_kab','left')
																	->join('kecamatan', 'customer.id_kec=kecamatan.id_kec','left')
																	->join('resi', 'giw.resi_id=resi.id_resi','left')
																	->where('invoice_product.posisi_indo <',99)
                                  ->where('invoice_product.posisi_indo >',0)
																	->where('invoice_product.id_sj_wc',0)
																	// ->where('giw.boleh_kirim >',0)
																	->order_by('giw.boleh_kirim',"desc")
																	->order_by('master_ekspedisi_lokal.tipe_ekspedisi','asc')
																	->order_by('customer.id_provinsi2',"desc")
																	->order_by('customer.id_kota2',"desc")
																	->order_by('customer.id_kec2',"desc")
																	->order_by('customer.id_cust',"desc")
																	->group_by('resi.id_resi')
																	->get()->result();
		$data = $this->load->view('admin/stok_barang/pdf_detail',$data,True);

		$mpdf = new \Mpdf\Mpdf();
		//$data = $this->load->view('hasilPrint', [], TRUE);
		$mpdf->WriteHTML($data);
		$mpdf->Output();
	}

	function pindahkan(){
		// dd($this->input->post());
		$id_proses = $this->input->post('id_proses');
		$id_invoice_product = $this->input->post('id_invoice_product');
		$id_resi = $this->input->post('id_resi');
		$id_mobil = $this->input->post('id_mobil');
		// $getbarang = $this->db->select('giw.id,giw.resi_id,giw.nomor')->where_in('id',$id_giw)->or_where_in('resi_id',$id_resi)->get('giw')->result(); dd($getbarang);
		// dd($this->input->post());
		if($id_proses == 0 ){
			// harus salah satu
			$this->session->set_flashdata('msg','kosong');
      redirect(site_url('admin/stok_barang'));
		}else if($id_proses == "-1"){
			// dd($id_resi);
			$getbarang = $this->db->select('giw.customer_id')
														->from('invoice_product')
														->join('giw', 'invoice_product.id_giw=giw.id','left')
													  ->where_in('id_invoice_product',$id_invoice_product)->or_where_in('resi_id',$id_resi)
														->group_by('giw.customer_id')
														->get()->result();
			foreach ($getbarang as $gb) {
				// Generate Sj
				if($id_mobil == 0 ){
					$this->session->set_flashdata('msg','nomobil');
					redirect(site_url('admin/stok_barang'));
				}
				if($id_mobil == 7 ){
					$insertsjwc['kode_sj']= $this->kode_sjwc();
					$insertsjwc['id_mobil']= $id_mobil;
					$insertsjwc['id_cust']= $gb->customer_id;
					$insertsjwc['tanggal_kirim'] = date('Y-m-d');
					$insertsjwc['status'] = 2;
					$insertsjwc['tanggal_terima'] = date('Y-m-d');
			    $this->db->insert('sj_wc', $insertsjwc);
			    $sj_id_wc = $this->db->insert_id();
				}else{
					$insertsjwc['kode_sj']= $this->kode_sjwc();
					$insertsjwc['id_mobil']= $id_mobil;
					$insertsjwc['id_cust']= $gb->customer_id;
			    $this->db->insert('sj_wc', $insertsjwc);
			    $sj_id_wc = $this->db->insert_id();
				}
				// invoice product
				$getbarangcust = $this->db->select('id_invoice_product')
																	->from('invoice_product')
																	->join('giw', 'invoice_product.id_giw=giw.id','left')
																	->group_start()
																		 ->where_in('id_invoice_product',$id_invoice_product)
																		 ->or_where_in('resi_id',$id_resi)
																  ->group_end()
																	->where('giw.customer_id',$gb->customer_id)
																	->get()->result();
	      foreach($getbarangcust as $gbc){
					$updinvprod['id_sj_wc']= $sj_id_wc;
					$savegiw = $this->db->where('id_invoice_product',$gbc->id_invoice_product)->update('invoice_product',$updinvprod);
				}
			}
			if($savegiw){
				$this->session->set_flashdata('msg','oksj');
				redirect(site_url('admin/stok_barang'));
			}
		}else if($id_proses > 0){
			// die("ok");
			$getgiw = $this->db->select('id_invoice_product')
														->from('invoice_product')
														->join('giw', 'invoice_product.id_giw=giw.id','left')
													  ->where_in('id_invoice_product',$id_invoice_product)->or_where_in('resi_id',$id_resi)
														->get()->result();
														// dd($getgiw);
			foreach ($getgiw as $gg) {
				$invprodupd['posisi_indo']= $id_proses;
				// $getprodd = $this->db->where_in('id_invoice_product',$gg->id_invoice_product)->get('invoice_product')->result();
				// dd($getprodd);
		    $savegiw = $this->db->where('id_invoice_product',$gg->id_invoice_product)->update('invoice_product',$invprodupd);
			}
			// $updgiw['posisi_indo']= $id_proses;
	    // $savegiw = $this->db->where_in('id',$id_giw)->or_where_in('resi_id',$id_resi)->update('giw',$updgiw);
			if($savegiw){
				$this->session->set_flashdata('msg','okposisi');
	      redirect(site_url('admin/stok_barang'));
			}
		}else{
			dd('tidak bisa proses');
		}
	}
	function kode_sjwc(){
    $hcekkode= $this->db->select('kode_sj as maxkode')->order_by('id_sj','desc')->get('sj_wc')->row();
		$kodesaatini= $hcekkode->maxkode;
		$ambilkode= str_replace('SJ-','',$kodesaatini);
	  if($ambilkode=="")
		{
		 $ambilkode=0;
		}
		$kodejadi= $ambilkode+1;

		$hasil= $kodejadi;
		return 'SJ-'.$hasil;
  }

	function teswarna(){
		$this->template->load('template','admin/stok_barang/test');
	}
}
