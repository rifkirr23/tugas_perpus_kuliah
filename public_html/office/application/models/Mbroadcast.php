<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mbroadcast extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	//Proses Get Data kurs
	function get_broadcast() {
    $this->datatables->select('id_broadcast,pesan,tanggal_broadcast,file,subject_email,customer');
    $this->datatables->from('broadcast');
		$this->db->order_by('id_broadcast','desc');
    return $this->datatables->generate();
  }

  function save(){
    // sendwhatsapp($this->input->post('pesan'),"083815423599");die();
		// die("oke");
		// $tes = $this->db->query('UPDATE `customer` left join resi on resi.cust_id = customer.id_cust left join resi_udara on resi_udara.id_cust = customer.id_cust
		// 																				left join transaksi on transaksi.id_cust = customer.id_cust
		// 																				set status_broadcast = 0
		// 																				where resi.id_resi is not null or resi_udara.id_resi_udara is not null or transaksi.id_transaksi is not null');
		// 																				 dd("oke");die();
    $broadcast['subject_email'] = $this->input->post('subject_email');
    $broadcast['pesan'] = $this->input->post('pesan');
    $broadcast['tanggal_broadcast'] = date('Y-m-d');
		$broadcast['customer'] = $this->input->post('customer');
    $this->db->insert('broadcast', $broadcast);
		// set customer
		if($this->input->post('customer') == "aktivasi"){
			// query
			$upd = $this->db->query('UPDATE `customer` set status_broadcast = 0 where s_aktivasi = "Sudah Aktivasi"');

		}else if($this->input->post('customer') == 30){
			$now				 				  = date('Y-m-d');
			$tanggal_sebelumnya  = date('Y-m-d', strtotime('-30 days', strtotime($now)));
			// query
			$upd = $this->db->query('UPDATE `customer` left join resi on resi.cust_id = customer.id_cust left join resi_udara on resi_udara.id_cust = customer.id_cust
																							left join transaksi on transaksi.id_cust = customer.id_cust
																							set status_broadcast = 0
																							where (resi.id_resi is not null or resi_udara.id_resi_udara is not null or transaksi.id_transaksi is not null) and
																							((resi.tanggal < "'.$now.'" and resi.tanggal > "'.$tanggal_sebelumnya.'") or (resi_udara.tanggal_resi < "'.$now.'"
																							and resi_udara.tanggal_resi > "'.$tanggal_sebelumnya.'") or (transaksi.tanggal_transaksi < "'.$now.'" and
																						  transaksi.tanggal_transaksi > "'.$tanggal_sebelumnya.'"))');

		}else if($this->input->post('customer') == 60){
			$now				 				  = date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d'))));
			$tanggal_sebelumnya   = date('Y-m-d', strtotime('-60 days', strtotime($now)));
			// query
			$upd = $this->db->query('UPDATE `customer` left join resi on resi.cust_id = customer.id_cust left join resi_udara on resi_udara.id_cust = customer.id_cust
																							left join transaksi on transaksi.id_cust = customer.id_cust
																							set status_broadcast = 0
																							where  (resi.id_resi is not null or resi_udara.id_resi_udara is not null or transaksi.id_transaksi is not null) and
																							 ((resi.tanggal < "'.$now.'" and resi.tanggal > "'.$tanggal_sebelumnya.'") or (resi_udara.tanggal_resi < "'.$now.'" and
																							 resi_udara.tanggal_resi > "'.$tanggal_sebelumnya.'") or (transaksi.tanggal_transaksi < "'.$now.'" and
																							 transaksi.tanggal_transaksi > "'.$tanggal_sebelumnya.'"))');

		}else if($this->input->post('customer') == 90){
			$now				 				  = date('Y-m-d', strtotime('-60 days', strtotime(date('Y-m-d'))));
			$tanggal_sebelumnya   = date('Y-m-d', strtotime('-90 days', strtotime($now)));
			$upd = $this->db->query('UPDATE customer.* FROM `customer` left join resi on resi.cust_id = customer.id_cust left join resi_udara on resi_udara.id_cust = customer.id_cust
																							left join transaksi on transaksi.id_cust = customer.id_cust
																							set status_broadcast = 0
																							where  (resi.id_resi is not null or resi_udara.id_resi_udara is not null or transaksi.id_transaksi is not null) and
																							 ((resi.tanggal < "'.$now.'" and resi.tanggal > "'.$tanggal_sebelumnya.'") or (resi_udara.tanggal_resi < "'.$now.'"
																						  and resi_udara.tanggal_resi > "'.$tanggal_sebelumnya.'") or (transaksi.tanggal_transaksi < "'.$now.'"
																						  and transaksi.tanggal_transaksi > "'.$tanggal_sebelumnya.'"))');

		}else if($this->input->post('customer') == "lebih90"){
			$tanggal   									= date('Y-m-d', strtotime('-90 days', strtotime(date('Y-m-d'))));
			$upd = $this->db->query('UPDATE `customer` left join resi on resi.cust_id = customer.id_cust left join resi_udara on resi_udara.id_cust = customer.id_cust
																							left join transaksi on transaksi.id_cust = customer.id_cust
																							set status_broadcast = 0
																							where  (resi.id_resi is not null or resi_udara.id_resi_udara is not null or transaksi.id_transaksi is not null) and
																							 ((resi.tanggal < "'.$tanggal.'") or (resi_udara.tanggal_resi < "'.$tanggal.'") or (transaksi.tanggal_transaksi < "'.$tanggal.'"))');
		}else if($this->input->post('customer') == "tidak_pernah"){
			$upd = $this->db->query('UPDATE `customer` left join resi on resi.cust_id = customer.id_cust left join resi_udara on resi_udara.id_cust = customer.id_cust
																							left join transaksi on transaksi.id_cust = customer.id_cust
																							set status_broadcast = 0
																							where resi.id_resi is null and resi_udara.id_resi_udara is null and transaksi.id_transaksi is null');
		}else if($this->input->post('customer') == "pernah"){
			$upd = $this->db->query('UPDATE `customer` left join resi on resi.cust_id = customer.id_cust left join resi_udara on resi_udara.id_cust = customer.id_cust
																							left join transaksi on transaksi.id_cust = customer.id_cust
																							set status_broadcast = 0
																							where resi.id_resi is not null or resi_udara.id_resi_udara is not null or transaksi.id_transaksi is not null');
		}
		// $customer['status_broadcast'] = 0;
		// $this->db->where('id_cust >',0)->update('customer',$customer);
		// sendwhatsapp("Dear marking\n\n".$pesannya,$cust->whatsapp);
		if($upd){
			$this->session->set_flashdata('msg','success');
	    redirect(site_url('admin/broadcast'));
		}
    $this->session->set_flashdata('msg','success');
    redirect(site_url('admin/broadcast'));
  }

}
