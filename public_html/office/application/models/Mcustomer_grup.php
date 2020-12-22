<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mcustomer_grup extends CI_Model {

	//Proses Get Data And Cloumn customer_grup and Parsing to Controller customer_grup function get_customer_grup_json
	function get_customer_grup() {
    $this->datatables->select('customer_grup.id_cgrup,customer_grup.nama_cgrup,customer_grup.email_cgrup,customer_grup.telepon_cgrup,customer_grup.whatsapp_cgrup,customer_grup.alamat_cgrup,
    							             customer_grup.kode_cgrup,customer_grup.note_cgrup,customer_grup.deposit_cgrup,customer_grup.foto_ktpcgrup,customer_grup.foto_skcgrup,customer_grup.harga_otomatis_grup');
    $this->datatables->from('customer_grup');
		$this->datatables->where('id_cgrup >',0);
		// $this->db->order_by('customer_grup.id_cgrup','desc');
		$q="$1";
    //$this->datatables->join('kategori', 'barang_kategori_id=kategori_id
    $this->datatables->add_column('view', '<a href="javascript:void(0);" class="edit_record btn btn-info btn-xs"
																	 data-id_cgrup="$1" data-nama_cgrup="$2" data-email_cgrup="$3" data-telepon_cgrup="$4" data-whatsapp_cgrup="$5" data-alamat_cgrup="$6" data-kode_cgrup="$7"
																	 data-note_cgrup="$8" data-harga_otomatis_grup="$9"> <i class="fa fa-edit"></i></a>

																	 <a href="javascript:void(0);" onclick="view_image('.$q.')" class="btn btn-danger btn-xs" alt="Update Data"> <i class="fa fa-file-image-o"></i></a>

												           <a href="'.site_url().'admin/customer_grup/detail/$1/index" class="btn btn-warning btn-xs"> <i class="fa fa-ellipsis-h"></i></a>

												          ', 'id_cgrup,nama_cgrup,email_cgrup,telepon_cgrup,whatsapp_cgrup,alamat_cgrup,kode_cgrup,note_cgrup,harga_otomatis_grup,foto_ktpcgrup,foto_skcgrup');
    return $this->datatables->generate();
  }

  function get_depositid($id) {
        $this->datatables->select('deposit.id_deposit,deposit.nominal_deposit,deposit.tipe_deposit,deposit.keterangan_deposit,deposit.id_cgrup');
        $this->datatables->from('deposit');
        $this->datatables->where('deposit.id_cgrup',$id);
        //$this->datatables->join('kategori', 'barang_kategori_id=kategori_id');

        return $this->datatables->generate();
  }

  //Get Data customer_grup per Kode MArk
  public function get_id($id){
    $this->db->where('kode_cgrup',$id);

    return $this->db->get('customer_grup');
  }

  //Get Deposit by ID Cust

  public function get_deposit($id){
    $this->db->where('id_cgrup',$id);

    return $this->db->get('deposit');
  }

  //get by id cust
  public function get_id2($id){
    $this->db->where('id_cgrup',$id);

    return $this->db->get('customer_grup');
  }

    //Proses Simpan customer_grup BAru
  	function save($f1,$f2)
  {                       //data Pelanggan
      $customer_grup['nama_cgrup'] = "GRUP - ".$this->input->post('nama_cgrup');
      $customer_grup['email_cgrup'] = $this->input->post('email_cgrup');
      $customer_grup['telepon_cgrup'] = $this->input->post('telepon_cgrup');
      $customer_grup['whatsapp_cgrup'] = $this->input->post('whatsapp_cgrup');
      $customer_grup['alamat_cgrup'] = $this->input->post('alamat_cgrup');
      $customer_grup['note_cgrup'] = $this->input->post('note_cgrup');
      $customer_grup['kode_cgrup'] = $this->input->post('kode_cgrup');
			$customer_grup['foto_ktpcgrup'] =$f1;
			$customer_grup['foto_skcgrup']  =$f2;
			$customer_grup['tanggal_daftar_cgrup']  =date("Y-m-d");
      //Validasi Kode Mark
      $this->db->insert('customer_grup', $customer_grup);
      $last_id = $this->db->insert_id();
      $this->session->set_flashdata('msg','success');
			// var_dump($image2);die();
      redirect(site_url('admin/customer_grup'));
  }



  //Proses Update Data customer_grup
  function update($f1,$f2)
  {
		$customer_grup['nama_cgrup'] = $this->input->post('nama_cgrup');
		$customer_grup['email_cgrup'] = $this->input->post('email_cgrup');
		$customer_grup['telepon_cgrup'] = $this->input->post('telepon_cgrup');
		$customer_grup['whatsapp_cgrup'] = $this->input->post('whatsapp_cgrup');
		$customer_grup['alamat_cgrup'] = $this->input->post('alamat_cgrup');
		$customer_grup['note_cgrup'] = $this->input->post('note_cgrup');
		$customer_grup['kode_cgrup'] = $this->input->post('kode_cgrup');
		$customer_grup['harga_otomatis_grup'] = $this->input->post('harga_otomatis_grup');
		$customer_grup['foto_ktpcgrup'] =$f1;
		$customer_grup['foto_skcgrup']  =$f2;

  	$this->db->where('id_cgrup',$this->input->post('id_cgrup'));
    $this->db->update('customer_grup', $customer_grup);

    $this->session->set_flashdata('msg','updated');
    redirect(site_url('admin/customer_grup'));

  }


}
