<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class customer_grup extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		cek_session(); //cek session User Login
		$this->load->model('Mcustomer_grup'); //Load Model customer_grup
		$this->load->model('Mtransaksi'); //Load Model customer_grup
		$this->load->model('Minvoice'); //Load Model customer_grup
		$this->load->model('Mpembayaran'); //Load Model customer_grup
	}

	//Function Halaman Awal Menu customer_grup
	function index(){
		$this->template->load('template','admin/customer_grup/customer_grup');
	}

	//Function Get data Json customer_grup
	function get_customer_grup_json() {
    header('Content-Type: application/json');
    echo $this->Mcustomer_grup->get_customer_grup();
  }

	//Function Get data Json Deposit Grup
  function get_depositid_json() {
    header('Content-Type: application/json');
    $id=$this->uri->segment(4);
    echo $this->Mcustomer_grup->get_depositid($id);
  }

	//Function View Image (Ktp,Sk) Customer Grup
	function view_image(){
	 $id= $this->uri->segment(4);
	 $file1= $this->Mcustomer_grup->get_id2($id)->row_array();
	 include APPPATH. 'views/admin/customer_grup/view_image.php';
	}

	// Function Detail Customer Grup
	function detail(){
    $id = $this->uri->segment(4);
		$segment = $this->uri->segment(5);
		$bulanini  = bulan_angka(date('m'));
		$tahun_ini = date('Y');
		$parse['data_giw'] = $this->db->select('sum(giw.volume * giw.ctns) as cbm')->from('giw')->join('customer','giw.customer_id=customer.id_cust','left')
													 ->join('resi','giw.resi_id=resi.id_resi','left')
													 ->where('month(resi.tanggal)',$bulanini)->where('year(resi.tanggal)',$tahun_ini)->where('customer.id_cgrup',$id)
													 ->get()->row();
	  $parse['all_giw'] = $this->db->select('sum(giw.volume * giw.ctns) as cbm')->from('giw')->join('customer','giw.customer_id=customer.id_cust','left')
													 ->join('resi','giw.resi_id=resi.id_resi','left')
													 ->where('customer.id_cgrup',$id)
													 ->get()->row();
		 $parse['jenis_barang_customer']=$this->db->where('id_cgrup',$id)->get('jenis_barang_customer')->num_rows();
 		$parse['rowjenisbarang']=$this->db->where('id_cgrup',$id)->from('jenis_barang_customer')->get()->result();
		$parse['detail'] = 1; //Set Detail = 1 Untuk di view/template.php
    $parse['r']=$this->Mcustomer_grup->get_id2($id)->row();
		// $parse['rowjenisbarang']=$this->db->select('jenis_barang_customer.*')->from('jenis_barang_customer')
		// 																	->join('customer', 'customer.id_cust=jenis_barang_customer.id_cust', 'left')
		// 																	->where('customer.id_cgrup',$id)
		// 																	->get()->result();
		$parse['invoice_barang'] = $this->db->select('sum(total_tagihan - jumlah_bayar) as total_semua_tagihan')
																				->from('invoice')
																				->where('tipe_invoice','barang')
																				->join('customer', 'customer.id_cust=invoice.id_cust', 'left')
																				->join('customer_grup', 'customer.id_cgrup=customer_grup.id_cgrup', 'left')
																				->where('customer.id_cgrup',$id)
																				->get()->row();
		$parse['invoice_titip_transfer'] = $this->db->select('sum(total_tagihan - jumlah_bayar) as total_semua_tagihan')
																								->from('invoice')
																								->join('customer', 'customer.id_cust=invoice.id_cust', 'left')
																								->join('customer_grup', 'customer.id_cgrup=customer_grup.id_cgrup', 'left')
																								->where('tipe_invoice','tt')
																								->where('customer.id_cgrup',$id)
																								->get()->row();
		$parse['invoice_udara'] = $this->db->select('sum(total_tagihan - jumlah_bayar) as total_semua_tagihan')
																			 ->from('invoice')
																			 ->where('tipe_invoice','air')
																			 ->where('customer.id_cgrup',$id)
																			 ->join('customer', 'customer.id_cust=invoice.id_cust', 'left')
																			 ->join('customer_grup', 'customer.id_cgrup=customer_grup.id_cgrup', 'left')
																			 ->get()->row();
		$parse['invoice_lainnya'] = $this->db->select('sum(total_tagihan - jumlah_bayar) as total_semua_tagihan')
																				 ->from('invoice')
																				 ->where('tipe_invoice','lainnya')
																				 ->where('customer.id_cgrup',$id)
																				 ->join('customer', 'customer.id_cust=invoice.id_cust', 'left')
																				 ->join('customer_grup', 'customer.id_cgrup=customer_grup.id_cgrup', 'left')
																				 ->get()->row();
		$parse['pembayaran'] = $this->db->select('sum(jumlah_bayar) as jumlah')
																		->where('customer.id_cgrup',$id)
																		->from('pembayaran')
																		->join('customer', 'customer.id_cust=pembayaran.id_cust', 'left')
																		->join('customer_grup', 'customer.id_cgrup=customer_grup.id_cgrup', 'left')
																		->get()->row();
		// print_r($parse['rowjenisbarang']);die();
		// Untuk Tab Menu di Customer
		if($segment == "index"){
			$this->template->load('template','admin/customer_grup/detail_index',$parse);
		}else if($segment == "customer"){
			// die("ok");
			$this->template->load('template','admin/customer_grup/detail_customer',$parse);
		}else if($segment == "resi"){
			$this->template->load('template','admin/customer_grup/detail_resi',$parse);
		}else if($segment == "transaksi"){
			$this->template->load('template','admin/customer_grup/detail_transaksi',$parse);
		}else if($segment == "invoice"){
			$this->template->load('template','admin/customer_grup/detail_invoice',$parse);
		}else if($segment == "pembayaran"){
			$this->template->load('template','admin/customer_grup/detail_pembayaran',$parse);
		}else if($segment == "deposit"){
			$this->template->load('template','admin/customer_grup/detail_deposit',$parse);
		}else if($segment == "invoice_barang"){
			$this->template->load('template','admin/customer_grup/detail_invoicebarang',$parse);
		}else if($segment == "barang"){
			$this->template->load('template','admin/customer_grup/detail_barcode',$parse);
		}else if($segment == "harga_khusus"){
			$this->template->load('template','admin/customer_grup/detail_harga',$parse);
		}
  }

	function buka_harga(){
		$idcgrup = $this->input->post('id_cgrup');
		$cekjb = $this->db->where('id_cgrup',$idcgrup)->get('jenis_barang_customer')->num_rows();
		// print_r($idcgrup);die();
		if($cekjb == 0){
			$jenisbarang = $this->db->get('jenis_barang')->result();
			foreach ($jenisbarang as $jb) {
				$jbc['id_jenis_barang'] = $jb->id;
				$jbc['id_cgrup'] = $idcgrup;
				$jbc['nama'] = $jb->nama;
				$jbc['namalain'] = $jb->namalain;
				$jbc['harga'] = $jb->harga - 500000;
				$this->db->insert('jenis_barang_customer', $jbc);
			}
		}
		redirect(site_url('admin/customer_grup/detail/'.$idcgrup.'/harga_khusus'));
	}

   //Function Proses Simpan Add New customer_grup
   function save(){
			 $h=date('H')+5;  $i=date('i');   $s=date('s');
			 $date= date('Y-m-d');
			 $data_kode= $this->Mcustomer_grup->get_id($this->input->post('kode_cgrup'));
			 // Validasi Marking Grup
       if($data_kode->num_rows()>0){
	        foreach($data_kode->result() as $c ){
	          $kode=$c->kode;
	        }
        }else{
          $kode="";
        }
        if($kode == $this->input->post('kode_cgrup')){
          $this->session->set_flashdata('msg','notvalid');
        	?><script type="text/javascript">
	        		window.location.href = "<?php print site_url() ?>admin/customer_grup";
      	  </script><?php
 				}else{
					$temp1 = explode(".", $_FILES['foto_ktpcgrup']['name']);
					$new_name1 = time().'.'.end($temp1);
					$config1['upload_path'] = './assets/foto_ktpcgrup/';
			    $config1['file_name'] = $new_name1;
			    $config1['allowed_types'] = 'jpg|jpeg|png|pdf';
			    $this->load->library('upload');
			    $this->upload->initialize($config1);
			    if(!$this->upload->do_upload('foto_ktpcgrup')){
				   	$this->upload->display_errors();
				    $new_name1 = "";
			    }
			    $media1 = $this->upload->data('foto_ktpcgrup');

				  $temp2 = explode(".", $_FILES['foto_skcgrup']['name']);
				  $new_name2 = time().'.'.end($temp2);
				  $config2['upload_path'] = './assets/foto_skcgrup/';
				  $config2['file_name'] = $new_name2;
				  $config2['allowed_types'] = 'jpg|jpeg|png|pdf';
				  $this->load->library('upload');
				  $this->upload->initialize($config2);
				  if(!$this->upload->do_upload('foto_skcgrup')){
					 $this->upload->display_errors();
					 $new_name1 = "";
				  }
				  $media2 = $this->upload->data('foto_skcgrup');

		      $data = $this->Mcustomer_grup->save($new_name1,$new_name2);
				}
  	 }

    //Function Proses Update customer_grup
    function update(){
			$data_kode= $this->Mcustomer_grup->get_id($this->input->post('kode_cgrup'));
			// Validasi Marking Customer
			 if($data_kode->num_rows()>0){
				 foreach($data_kode->result() as $c ){
					 $kode=$c->kode;
				 }
			 }else{
				 $kode="";
			 }
			 if ($kode == $this->input->post('kode_cgrup')){
					 $this->session->set_flashdata('msg','notvalid');
				 ?><script type="text/javascript">
						 window.location.href = "<?php print site_url() ?>admin/customer_grup";
					 </script><?php
			 }else{
				 $temp1 = explode(".", $_FILES['foto_ktpcgrup']['name']);
				 $new_name1 = time().'.'.end($temp1);
				 $config1['upload_path'] = './assets/foto_ktpcgrup/';
				 $config1['file_name'] = $new_name1;
				 $config1['allowed_types'] = 'jpg|jpeg|png|pdf';
				 $this->load->library('upload');
				 $this->upload->initialize($config1);
				 if(!$this->upload->do_upload('foto_ktpcgrup')){
					 $this->upload->display_errors();
					 $new_name1 = "";
				 }
				$media1 = $this->upload->data('foto_ktpcgrup');

				$temp2 = explode(".", $_FILES['foto_skcgrup']['name']);
				$new_name2 = time().'.'.end($temp2);
				$config2['upload_path'] = './assets/foto_skcgrup/';
				$config2['file_name'] = $new_name2;
				$config2['allowed_types'] = 'jpg|jpeg|png|pdf';
				$this->load->library('upload');
				$this->upload->initialize($config2);
				if(!$this->upload->do_upload('foto_skcgrup')){
					$this->upload->display_errors();
					$new_name1 = "";
				}
			 $media2 = $this->upload->data('foto_skcgrup');

			 $data = $this->Mcustomer_grup->update($new_name1,$new_name2);
		}
  }

}
