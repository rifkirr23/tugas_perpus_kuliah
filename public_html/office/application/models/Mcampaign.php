<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mcampaign extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	//Proses Get Data campaign
	function get_campaign() {
        $this->datatables->select('id_campaign,kode_campaign,nama_campaign,chat_campaign,link_whatsapp');
        $this->datatables->from('campaign');
        $this->datatables->where('id_campaign >',0);
        $this->datatables->add_column('view', '<center><a href="javascript:void(0);" class="edit_record btn btn-warning btn-xs"
                                                          data-id_campaign="$1" data-kode_campaign="$2" data-nama_campaign="$3" data-chat_campaign="$4"
                                                          data-link_whatsapp="$5"> <i class="fa fa-edit"></i></a>
																											 <a href="'.site_url().'admin/campaign/customer/$1" class="btn btn-info btn-xs"> <i class="fa fa-user"></i></a>
																											 <a href="'.site_url().'admin/laporan/campaign/$1" target="_blank" class="btn btn-primary btn-xs"> <i class="fa fa-book"></i></a>
																							 </center>',
         'id_campaign,kode_campaign,nama_campaign,chat_campaign,link_whatsapp');
        return $this->datatables->generate();
  }

  public function kode_campaign(){
      $cekkode= $this->db->query("SELECT kode_campaign as maxkode FROM campaign order by id_campaign desc limit 1")->result();
      foreach($cekkode as $hcekkode);
      $kodesaatini= $hcekkode->maxkode;
      $ambilkode= str_replace('C0','',$kodesaatini);
      if($ambilkode=="")
      {
       $ambilkode=0;
      }
      $kodejadi= $ambilkode+1;

      $hasil= $kodejadi;
      return 'C0'.$hasil;
  }

  	function save($data)
  {
      $campaign['kode_campaign'] = $this->input->post('kode_campaign');
      $campaign['nama_campaign'] = $this->input->post('nama_campaign');
			$campaign['chat_campaign'] = $this->input->post('chat_campaign');
      $campaign['link_whatsapp'] = 'wilopocargo.com/chat_sales_'.$campaign['kode_campaign'];
      $this->db->insert('campaign', $campaign);
      $last_id = $this->db->insert_id();
      $this->session->set_flashdata('msg','success');
      redirect(site_url('admin/campaign'));

  }

  function update($data)
  {                       //data Pelanggan
    $campaign['kode_campaign'] = $this->input->post('kode_campaign');
    $campaign['nama_campaign'] = $this->input->post('nama_campaign');
    $campaign['chat_campaign'] = $this->input->post('chat_campaign');
    $campaign['link_whatsapp'] = $this->input->post('link_whatsapp');
    $this->db->where('id_campaign',$this->input->post('id_campaign'));
    $this->db->update('campaign', $campaign);
    // whatsapp_grup("1583918717",$pesan,"081310085523");
    // die("ok");
    $this->session->set_flashdata('msg','updated');
    redirect(site_url('admin/campaign'));


  }

  function deleted($data)
  {                       //data Pelanggan
      $campaign['aktif'] = '1';

      	$this->db->where('id_cust',$this->input->post('id_cust'));
        $this->db->update('campaign', $campaign);

        redirect(site_url('admin/campaign'));


  }
}
