<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat_sales extends CI_Controller {

	public function __construct(){
		parent::__construct();
		// $this->load->model('Mgiw');
	}

	function c01(){
		// echo $dataresi->statusgiw;
    $sales 					= $this->db->where('level','sales')->where('status_sales',1)->get('pengguna')->row();
		$whatsapp_sales = $sales->whatsapp;
		$get_campaign   = $this->db->where('kode_campaign','C01')->get('campaign')->row();
		$pesanredirect  = $get_campaign->chat_campaign;
		$redirect ="https://api.whatsapp.com/send?phone=$whatsapp_sales&text=$pesanredirect.";
     // "https://api.whatsapp.com/send?phone=$whatsapp_sales&amp;text=$pesanredirect";
    redirect($redirect);
	}

	function c02(){
		// echo $dataresi->statusgiw;
    $sales 					= $this->db->where('level','sales')->where('status_sales',1)->get('pengguna')->row();
		$whatsapp_sales = $sales->whatsapp;
		$get_campaign   = $this->db->where('kode_campaign','C02')->get('campaign')->row();
		$pesanredirect  = $get_campaign->chat_campaign;
		$redirect ="https://api.whatsapp.com/send?phone=$whatsapp_sales&text=$pesanredirect.";
     // "https://api.whatsapp.com/send?phone=$whatsapp_sales&amp;text=$pesanredirect";
    redirect($redirect);
	}

	function c03(){
		// echo $dataresi->statusgiw;
    $sales 					= $this->db->where('level','sales')->where('status_sales',1)->get('pengguna')->row();
		$whatsapp_sales = $sales->whatsapp;
		$get_campaign   = $this->db->where('kode_campaign','C03')->get('campaign')->row();
		$pesanredirect  = $get_campaign->chat_campaign;
		$redirect ="https://api.whatsapp.com/send?phone=$whatsapp_sales&text=$pesanredirect.";
     // "https://api.whatsapp.com/send?phone=$whatsapp_sales&amp;text=$pesanredirect";
    redirect($redirect);
	}

	function c04(){
		// echo $dataresi->statusgiw;
    $sales 					= $this->db->where('level','sales')->where('status_sales',1)->get('pengguna')->row();
		$whatsapp_sales = $sales->whatsapp;
		$get_campaign   = $this->db->where('kode_campaign','C04')->get('campaign')->row();
		$pesanredirect  = $get_campaign->chat_campaign;
		$redirect ="https://api.whatsapp.com/send?phone=$whatsapp_sales&text=$pesanredirect.";
     // "https://api.whatsapp.com/send?phone=$whatsapp_sales&amp;text=$pesanredirect";
    redirect($redirect);
	}

	function c05(){
		// echo $dataresi->statusgiw;
    $sales 					= $this->db->where('level','sales')->where('status_sales',1)->get('pengguna')->row();
		$whatsapp_sales = $sales->whatsapp;
		$get_campaign   = $this->db->where('kode_campaign','C05')->get('campaign')->row();
		$pesanredirect  = $get_campaign->chat_campaign;
		$redirect ="https://api.whatsapp.com/send?phone=$whatsapp_sales&text=$pesanredirect.";
     // "https://api.whatsapp.com/send?phone=$whatsapp_sales&amp;text=$pesanredirect";
    redirect($redirect);
	}

	function c06(){
		// echo $dataresi->statusgiw;
    $sales 					= $this->db->where('level','sales')->where('status_sales',1)->get('pengguna')->row();
		$whatsapp_sales = $sales->whatsapp;
		$get_campaign   = $this->db->where('kode_campaign','C06')->get('campaign')->row();
		$pesanredirect  = $get_campaign->chat_campaign;
		$redirect ="https://api.whatsapp.com/send?phone=$whatsapp_sales&text=$pesanredirect.";
     // "https://api.whatsapp.com/send?phone=$whatsapp_sales&amp;text=$pesanredirect";
    redirect($redirect);
	}

	function c07(){
		// echo $dataresi->statusgiw;
    $sales 					= $this->db->where('level','sales')->where('status_sales',1)->get('pengguna')->row();
		$whatsapp_sales = $sales->whatsapp;
		$get_campaign   = $this->db->where('kode_campaign','C07')->get('campaign')->row();
		$pesanredirect  = $get_campaign->chat_campaign;
		$redirect ="https://api.whatsapp.com/send?phone=$whatsapp_sales&text=$pesanredirect.";
     // "https://api.whatsapp.com/send?phone=$whatsapp_sales&amp;text=$pesanredirect";
    redirect($redirect);
	}

	function c08(){
		// echo $dataresi->statusgiw;
    $sales 					= $this->db->where('level','sales')->where('status_sales',1)->get('pengguna')->row();
		$whatsapp_sales = $sales->whatsapp;
		$get_campaign   = $this->db->where('kode_campaign','C08')->get('campaign')->row();
		$pesanredirect  = $get_campaign->chat_campaign;
		$redirect ="https://api.whatsapp.com/send?phone=$whatsapp_sales&text=$pesanredirect.";
     // "https://api.whatsapp.com/send?phone=$whatsapp_sales&amp;text=$pesanredirect";
    redirect($redirect);
	}

	function c09(){
		// echo $dataresi->statusgiw;
    $sales 					= $this->db->where('level','sales')->where('status_sales',1)->get('pengguna')->row();
		$whatsapp_sales = $sales->whatsapp;
		$get_campaign   = $this->db->where('kode_campaign','C09')->get('campaign')->row();
		$pesanredirect  = $get_campaign->chat_campaign;
		$redirect ="https://api.whatsapp.com/send?phone=$whatsapp_sales&text=$pesanredirect.";
     // "https://api.whatsapp.com/send?phone=$whatsapp_sales&amp;text=$pesanredirect";
    redirect($redirect);
	}

}
