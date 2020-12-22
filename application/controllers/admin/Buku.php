<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		// cek_session(); //cek session Login
		$this->load->model('Mbuku');
	}

	// function get_invsea_nobelilcl() {
	// 	$tanggal = date('Y-m-d');
  //       return $this->db->select('invoice.*,invoice_beli.*,customer.*')
	// 		    					->from('invoice')
	// 									->join('customer', 'invoice.id_cust=customer.id_cust')
	// 									->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
	// 							// 		->where('invoice.id_cust !=',6106)
	// 									->where('invoice_beli.id_invoice_beli >',2)
	// 									->where('invoice_beli.note_invoice_beli !=','LCL')
	// 									->where('invoice.tipe_invoice','barang')
	// 									->where('invoice.tanggal_invoice',$tanggal)
	// 									->order_by('invoice.id_invoice','desc')
	// 									->get()->result();
  //  }
	//
  //  function get_invsea_nobelifcl() {
  //      $containerl  = $this->db->select('container_id')->where('container_id >','0')->get('invoice')->result();//dd($containerl);
	// 	$clist = array();
	// 	foreach($containerl as $cl){
	// 	    $clist[] = $cl->container_id;
	// 	}
	// 	$tanggal = date('Y-m-d');
  //       return $this->db->select('invoice.*,invoice_beli.*,customer.*')
	// 		    					->from('invoice')
	// 									->join('customer', 'invoice.id_cust=customer.id_cust')
	// 									->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
	// 							// 		->where('invoice.id_cust !=',6106)
	// 									->where('invoice_beli.id_invoice_beli',1)
	// 									->where_in('cont_jual_id',$clist)
	// 									->where('invoice.tipe_invoice','barang')
	// 									->where('invoice.tanggal_invoice',$tanggal)
	// 									->order_by('invoice.id_invoice','desc')
	// 									->get()->result();
  //  }
	//
	// function tesaja(){
	// 	$giwrtslive=file_get_contents("http://localhost:8000/customertes");
  //           // $content=utf8_encode($cont);
  //   $resultgiwrts=json_decode($giwrtslive,true);
	// 	$datagiwcont = $resultgiwrts['data'];
	//     print_r($resultgiwrts);die();
	// }
	//Function Halaman Awal Menu buku
	function index(){
		$this->db->like('id_buku');
		$this->db->from('buku');
		$data['jumlah_buku'] = $this->db->count_all_results();
		$data['kategori'] = $this->db->get('kategori')->result();
		$this->template->load('template','admin/buku/buku',$data);
	}

	//Function Get data Json buku
	function get_buku_json() {
    header('Content-Type: application/json');
    echo $this->Mbuku->get_buku();
  }

   //Function Simpan Add New buku
  function save(){
		foreach ($_FILES['gambar']['name'] as $key => $image) {
				// print_r($image."<br>");
          if($_FILES['gambar']['name'][$key] == "")
          {

          }else{
            move_uploaded_file($_FILES["gambar"]["tmp_name"][$key], './assets/gambar/'.$_FILES["gambar"]["name"][$key]);

            $gambar=$_FILES["gambar"]["name"][$key];
						$insbuku['gambar'] = $gambar;
      			//$this->Mtransaksi->save_bb_cust($file_bb_cust);
     			}
			}
    $insbuku['judul_buku'] = $this->input->post('judul_buku');
		$insbuku['id_kategori'] = $this->input->post('id_kategori');
    $insbuku['pengarang'] = $this->input->post('pengarang');
    $insbuku['thn_terbit'] = $this->input->post('thn_terbit');
    $insbuku['penerbit'] = $this->input->post('penerbit');
    $insbuku['isbn'] = $this->input->post('isbn');
    $insbuku['lokasi'] = $this->input->post('judul_buku');
    $insbuku['status_buku'] = 0;
    $this->db->insert('buku',$insbuku);
    redirect($_SERVER['HTTP_REFERER']);
  }

	// Function Update buku
  function update(){
		// dd($this->input->post());
		foreach ($_FILES['gambar']['name'] as $key => $image) {
				// print_r($image."<br>");
          if($_FILES['gambar']['name'][$key] == "")
          {

          }else{
            move_uploaded_file($_FILES["gambar"]["tmp_name"][$key], './assets/gambar/'.$_FILES["gambar"]["name"][$key]);

            $gambar=$_FILES["gambar"]["name"][$key];
						$insbuku['gambar'] = $gambar;

      			//$this->Mtransaksi->save_bb_cust($file_bb_cust);
     			}
			}
			// dd($gambar);
    $insbuku['judul_buku'] = $this->input->post('judul_buku');
		$insbuku['id_kategori'] = $this->input->post('id_kategori');
    $insbuku['pengarang'] = $this->input->post('pengarang');
    $insbuku['thn_terbit'] = $this->input->post('thn_terbit');
    $insbuku['penerbit'] = $this->input->post('penerbit');
    $insbuku['isbn'] = $this->input->post('isbn');
    $insbuku['lokasi'] = $this->input->post('judul_buku');
    // $insbuku['status_buku'] = 0;
    $upd = $this->db->where('id_buku',$this->input->post('id_buku'))->update('buku',$insbuku);
		if($upd){
				redirect($_SERVER['HTTP_REFERER']);
		}
  }

	function view_image(){
	   $id= $this->uri->segment(4);
	   $file1= $this->db->where('id_buku',$id)->get('buku')->row();
	   include APPPATH. 'views/admin/buku/view_image.php';
  }

	function edit_buku(){
	   $id= $this->uri->segment(4);
	   $file1= $this->db->where('id_buku',$id)->get('buku')->row();
		 $kategori = $this->db->get('kategori')->result();
	   include APPPATH. 'views/admin/buku/edit_buku.php';
  }

	function delete(){
	   $id= $this->uri->segment(4);
	   $delete = $this->db->where('id_buku',$id)->delete('buku');
	   redirect($_SERVER['HTTP_REFERER']);
  }



}
