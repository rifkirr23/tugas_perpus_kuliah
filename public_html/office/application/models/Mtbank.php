<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mtbank extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->model('Mbank');
    $this->load->model('Mtransaksi');
    $this->load->model('Mrmb');
	}
	//Proses Get Data Transaksi Per Bank
	function get_transaksi($id) {
      $this->datatables->select('transaksi_bank.id_transaksi_bank,transaksi_bank.id_bank,transaksi_bank.tipe_transaksi_bank,transaksi_bank.nominal_transaksi_bank,transaksi_bank.keterangan_transaksi_bank,
                                 jenis_transaksi_bank.kjenis_transaksi_bank,transaksi_bank.tanggal_transaksi_bank,transaksi_bank.sisa_saldo_bank');
      $this->datatables->from('transaksi_bank');
      // $this->db->order_by('transaksi_bank.id_transaksi_bank','desc');
      $this->datatables->join('jenis_transaksi_bank', 'transaksi_bank.id_jenis_transaksi_bank=jenis_transaksi_bank.id_jenis_transaksi_bank');
      $this->datatables->where('transaksi_bank.id_bank',$id);
			// $this->datatables->where('transaksi_bank.tanggal_transaksi_bank >=',"2020-08-03");
			// $this->datatables->where('transaksi_bank.tanggal_transaksi_bank <=',"2020-08-04");
      $this->datatables->add_column('view', '
      <center>
      <a href="javascript:void(0);" class="edit_record btn btn-warning btn-xs" data-id_bank="$1" data-nama_bank="$2" data-nomor_rekening_bank="$3" data-atas_nama_bank="$4" data-saldo_bank="$5"
      data-edit_saldo="$6">
      <i class="fa fa-edit"></i>
      </a>
      <a href="'.site_url().'admin/bank/transaksi/$1" class="btn btn-info btn-xs"> <i class="fa fa-ellipsis-h"></i></a>
      </center>',
       'id_bank,nama_bank,nomor_rekening_bank,atas_nama_bank,saldo_bank,edit_saldo');
      return $this->datatables->generate();
  }

	// Function Get Semua Transaksi bank
	// function get_transaksi($id) {
  //     $this->datatables->select('transaksi_bank.id_transaksi_bank,transaksi_bank.id_bank,transaksi_bank.tipe_transaksi_bank,transaksi_bank.nominal_transaksi_bank,transaksi_bank.keterangan_transaksi_bank,
  //                                jenis_transaksi_bank.kjenis_transaksi_bank,transaksi_bank.tanggal_transaksi_bank,transaksi_bank.sisa_saldo_bank,');
  //     $this->datatables->from('transaksi_bank');
  //     $this->db->order_by('transaksi_bank.id_transaksi_bank','desc');
  //     $this->datatables->join('jenis_transaksi_bank', 'transaksi_bank.id_jenis_transaksi_bank=jenis_transaksi_bank.id_jenis_transaksi_bank');
  //     $this->datatables->add_column('view', '
  //     <center>
  //     <a href="javascript:void(0);" class="edit_record btn btn-warning btn-xs" data-id_bank="$1" data-nama_bank="$2" data-nomor_rekening_bank="$3" data-atas_nama_bank="$4" data-saldo_bank="$5"
  //     data-edit_saldo="$6">
  //     <i class="fa fa-edit"></i>
  //     </a>
  //     <a href="'.site_url().'admin/bank/transaksi/$1" class="btn btn-info btn-xs"> <i class="fa fa-ellipsis-h"></i></a>
  //     </center>',
  //      'id_bank,nama_bank,nomor_rekening_bank,atas_nama_bank,saldo_bank,edit_saldo');
  //     return $this->datatables->generate();
  // }


  	function save($data){
			// Data Bank
      $data_bank= $this->Mbank->get_dbank($this->input->post('id_bank'));
      foreach($data_bank->result() as $dbank ){
       $sbank     = $dbank->saldo_bank;
			 $nama_bank = $dbank->nama_bank;
      }
			// Go Transaksi
		 $h=date('H');  $i=date('i');    $s=date('s');
     $nominal=str_replace(".", "",$this->input->post('nominal_transaksi_bank'));
		 // jika beli rmb
     if($this->input->post('kode')==3){
		 			$kurs_beli =str_replace(".", ",",$this->input->post('kurs_trmb'));
	        $result=$nominal * $kurs_beli;

					if($sbank < $result){
						$this->session->set_flashdata('msg','gagal');
				    redirect(site_url('admin/bank/transaksi/'.$this->input->post('id_bank')));
					}

					$datarmbid = $this->Mrmb->rmb_nonaktif()->result();
					foreach($datarmbid as $rowrmb){
						$id_rmb = $rowrmb->id_rmb;
						$saldo_rmb = $rowrmb->saldo_rmb;
						$kurs_beli_rmb = $rowrmb->saldo_rmb;
					}
					if($saldo_rmb > 0){
						$this->session->set_flashdata('msg','gagal');
				    redirect(site_url('admin/bank/transaksi/'.$this->input->post('id_bank')));
					}
	        $rmbb['jumlah_trmb'] = $nominal;
	        $rmbb['keterangan_rmb'] = "Isi Saldo Rmb";
	        $rmbb['id_rmb'] = $id_rmb;
					$rmbb['tipe_trmb'] = 'masuk';
					$rmbb['sisa_saldo_trmb'] = $saldo_rmb + $nominal;

					$rmbb['kurs_trmb'] = str_replace(".", ",",$this->input->post('kurs_trmb'));
					$rmb2['kurs_beli_rmb'] = str_replace(".", ",",$this->input->post('kurs_trmb'));

					$rmbb['tanggal_rmb'] = date('Y-m-d '.$h.'-'.$i.'-'.$s);
	        $this->db->insert('transaksi_rmb', $rmbb);
	        $last_id = $this->db->insert_id();

	        $rmb2['saldo_rmb'] = $saldo_rmb + $nominal;
	        $this->db->where('id_rmb',$id_rmb);
	        $this->db->update('rmb', $rmb2);

					$tdrmb['jumlah_tdrmb'] = $nominal;
					$tdrmb['formula_tdrmb'] = "Isi saldo ".$nominal;
		      $tdrmb['keterangan_tdrmb'] = "Isi Saldo Rmb";
		      $tdrmb['tanggal_tdrmb'] = date('Y-m-d '.$h.'-'.$i.'-'.$s);
					$tdrmb['tipe_tdrmb'] = "masuk";
		      $this->db->insert('transaksi_detail_rmb', $tdrmb);

			// Jika Transaksi Rekening Internal
     }else if($this->input->post('kode')==15){
			 $result=$nominal;
			 $data_bank_tujuan = $this->Mbank->get_dbank($this->input->post('id_bank_tujuan'))->row();
			 $trb['id_jenis_transaksi_bank'] = $this->input->post('kode');
       $trb['id_bank'] = $this->input->post('id_bank_tujuan');
       $trb['tipe_transaksi_bank'] = "masuk";
       $trb['nominal_transaksi_bank'] = $result;
       $trb['keterangan_transaksi_bank'] = "Transfer internal dari ".$nama_bank;
       $trb['tanggal_transaksi_bank'] = date('Y-m-d',strtotime($this->input->post('tanggal_transaksi_bank')));
       $trb['sisa_saldo_bank'] = $data_bank_tujuan->saldo_bank + $result;
       $this->db->insert('transaksi_bank', $trb);
       // $last_id = $this->db->insert_id();

       $bank['saldo_bank'] = $trb['sisa_saldo_bank'];
       $bank['edit_saldo'] = 1;
   	   $this->db->where('id_bank',$this->input->post('id_bank_tujuan'));
       $this->db->update('master_bank', $bank);
		 }else{
            $result=$nominal;
     }

         if($this->input->post('tipe') == "masuk"){
					   $ssaldo = $sbank + $result;
         }else if($this->input->post('tipe') == "keluar"){
					  $ssaldo = $sbank - $result;
						if($sbank < $result){
							$this->session->set_flashdata('msg','gagal');
					    redirect(site_url('admin/bank/transaksi/'.$this->input->post('id_bank')));
						}
				 }

      $trb['id_jenis_transaksi_bank'] = $this->input->post('kode');
      $trb['id_bank'] = $this->input->post('id_bank');
      $trb['tipe_transaksi_bank'] = $this->input->post('tipe');
      $trb['nominal_transaksi_bank'] = $result;
      $trb['keterangan_transaksi_bank'] = $this->input->post('keterangan_transaksi_bank');
      $trb['tanggal_transaksi_bank'] = date('Y-m-d',strtotime($this->input->post('tanggal_transaksi_bank')));
      $trb['sisa_saldo_bank'] = $ssaldo;
      $this->db->insert('transaksi_bank', $trb);
      $last_id = $this->db->insert_id();

      $bank['saldo_bank'] = $ssaldo;
      $bank['edit_saldo'] = 1;
  	  $this->db->where('id_bank',$this->input->post('id_bank'));
      $this->db->update('master_bank', $bank);

			// Upload Bukti transaksi
			$no = 1;
		  foreach ($_FILES['bukti_transaksi']['name'] as $key => $image) {
				$time = "buktitransaksi".time().$no; $no++;
	 		  $filename=$_FILES['bukti_transaksi']['name'][$key];
	 		  $extension=end(explode(".", $filename));
	 		  $newfilename=$time .".".$extension;
		    if($_FILES['bukti_transaksi']['name'][$key] == "")
		    {

		    }else{
		      move_uploaded_file($_FILES["bukti_transaksi"]["tmp_name"][$key], './assets/bukti_transaksi/'.$newfilename);

					$imagepath = $newfilename;
			    $save = "./assets/bukti_transaksi/" . $imagepath; //This is the new file you saving
			    $file = "./assets/bukti_transaksi/" . $imagepath; //This is the original file
					// print_r($save);die();
			    list($width, $height) = getimagesize($file) ;
					if($width > 1500){
						$modwidth = 800;

						$diff = ceil($width / $modwidth);

						$modheight = $height / $diff;
						$tn = imagecreatetruecolor($modwidth, $modheight) ;
						$image = imagecreatefromjpeg($file) ;
						imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ;

						imagejpeg($tn, $save, 100) ;
					}

		      $bukti_transaksi=$newfilename;

		      $bukti_trs['id_transaksi_bank'] = $last_id;
		      $bukti_trs['bukti_transaksi'] = $bukti_transaksi;
		      $this->db->insert('bukti_transaksi', $bukti_trs);
		     }
		  }

			// sesiion flash
    	$this->session->set_flashdata('msg','success');

  }

  function update($data)
  {                       //data Pelanggan
        $jp['kbank'] = $this->input->post('kbank');

      	$this->db->where('id_bank',$this->input->post('id_bank'));
        $this->db->update('bank', $jp);

        $this->session->set_flashdata('msg','updated');
        redirect(site_url('admin/jenis_tb'));

  }

	public function data_tb(){
    $this->db->select('sum(nominal_transaksi_bank) as nominal_keluar,MONTHNAME(tanggal_transaksi_bank) as bulan');
		$this->db->where('tipe_transaksi_bank','keluar');
		$this->db->group_by('MONTH(tanggal_transaksi_bank)');
    $this->db->from('transaksi_bank');
    return $this->db->get();
  }

  public function select_jtb($kode){
    $this->db->select('id_jenis_transaksi_bank,kjenis_transaksi_bank');
    $this->db->limit(10);
    $this->db->from('jenis_transaksi_bank');
    $this->db->like('kjenis_transaksi_bank', $kode);
    return $this->db->get()->result_();
  }

  public function select_jtb2($kode,$id){
    $this->db->select('id_jenis_transaksi_bank,kjenis_transaksi_bank');
    $this->db->limit(10);
    $this->db->from('jenis_transaksi_bank');
    $this->db->where('tipe_jenis_transaksi',$id);
    $this->db->like('kjenis_transaksi_bank', $kode);
    return $this->db->get()->result_array();
  }


}
