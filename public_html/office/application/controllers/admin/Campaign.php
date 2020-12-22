<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Campaign extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		cek_session(); //cek session Login
		$this->load->model('Mcampaign');
		// $this->load->model('Mcustomer');
	}

	//Function Halaman Awal Menu campaign
	function index(){
    $data['kode_campaign'] = $this->Mcampaign->kode_campaign();
		$this->template->load('template','admin/campaign/index',$data);
	}

	// function tes(){
	//
	// }

	//Function Get data Json campaign
	function get_campaign_json() {
    header('Content-Type: application/json');
    echo $this->Mcampaign->get_campaign();
  }

	//Function Halaman Awal Menu campaign
	function customer(){
    // $data['kode_campaign'] = $this->Mcampaign->kode_campaign();
		$id = $this->uri->segment(4);
		$data['data_campaign'] = $this->db->where('id_campaign',$id)->get('campaign')->row();
		$this->template->load('template','admin/campaign/customer',$data);
	}

   //Function Simpan Add New campaign
  function save(){
    $data = $this->Mcampaign->save($this->input->post());
  }

	// Function Update campaign
  function update(){
    $data = $this->Mcampaign->update($this->input->post());
  }



}
