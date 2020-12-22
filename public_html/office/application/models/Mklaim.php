<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mklaim extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	//Proses Get Data klaim
	function get_klaim() {
        $this->datatables->select('klaim.id_giw,klaim.id_klaim,klaim.id_cust,klaim.jumlah_klaim,klaim.tanggal_klaim,klaim.keterangan_klaim,klaim.jumlah_klaim_rts,klaim.keterangan_klaim_rts,klaim.status_klaim,klaim.status_vendor,
																	customer.kode,giw.nomor,resi.nomor as nomor_resi');
        $this->datatables->from('klaim');
				$this->datatables->join('customer','klaim.id_cust=customer.id_cust','left');
				$this->datatables->join('giw','klaim.id_giw=giw.id','left');
				$this->datatables->join('resi','giw.resi_id=resi.id_resi','left');
				// $this->db->order_by('klaim.id_klaim','desc');
        $this->datatables->add_column('view', '<center>
																									<a href="javascript:void(0);" class="delete_klaim btn btn-danger btn-xs"
																									data-id_klaim="$1"><i class="fa fa-close"></i></a>
																									<a href="javascript:void(0);" class="refund_klaim btn btn-info btn-xs"
																									data-id_klaim="$1"><i class="fa fa-money"></i></a>
																									<a href="javascript:void(0);" class="potongan_klaim btn btn-primary btn-xs"
																									data-id_klaim="$1" data-id_cust="$2"><i class="fa fa-envelope"></i></a>
																									<a href="javascript:void(0);" class="vendor_klaim btn btn-success btn-xs"
																									data-id_klaim="$1"><i class="fa fa-home"></i></a>
				 																			 </center>',
         'id_klaim,id_cust,jumlah_klaim,keterangan_klaim');
        return $this->datatables->generate();
  }

  	function save($data)
  {
      $id_giw = $this->input->post('nomor');
			$giw = $this->db->select('resi.konfirmasi_resi,giw.*,customer.kode,customer.whatsapp')->from('giw')->join('resi','resi.id_resi=giw.resi_id','left')
											->join('customer', 'resi.cust_id=customer.id_cust', 'left')->where('giw.id',$id_giw)->get()->row();
			// print_r($giw);die();
			$data_resi = $this->db->select('sum(giw.volume*giw.ctns) as total,sum(giw.qty*giw.ctns) as total_pcs,sum(giw.nilai*giw.qty*giw.ctns) as total_nilai')->where('giw.resi_id',$giw->resi_id)->get('giw')->row();
			// Get Kurs
			$kurs = $this->db->where('id_kurs',1)->get('kurs')->row();
      // rumus
			$total_volume = $data_resi->total;
			$nilai_barang = $data_resi->total_nilai * $giw->kurs;
			$total_pcs    = $data_resi->total_pcs;
      // kondisi
			if($giw->konfirmasi_resi == 2){
				$total_klaim = $this->input->post('jumlah_hilang') * $kurs->kurs_klaim * $giw->nilai; //kurs claim
				$keterangan_klaim = "Asuransi , Jumlah Barang ".$this->input->post('jumlah_hilang')." * kurs ".$kurs->kurs_klaim." * Harga per barang (rmb) ".$giw->nilai;
				// wa
				$whatsapp_to_customer = "Customer Yth.*".$giw->kode."* , Anda telah membeli asuransi untuk barang ini , Berikut kami lampirkan hitungan klaim untuk barang ini : \n".
																"Jumlah Barang ".$this->input->post('jumlah_hilang')." * kurs ".$kurs->kurs_klaim." * Harga per barang (rmb) ".$giw->nilai.
																"\n\n*Wilopo Cargo* _(do not reply)_";
			}else{
				if($nilai_barang > (20000000 * $total_volume)){
					$total_klaim = ((20000000 * $total_volume) / $total_pcs) * $this->input->post('jumlah_hilang');
					$keterangan_klaim = "Tidak Tercover dan Tidak membeli asuransi,Jumlah Barang ".$this->input->post('jumlah_hilang').
															" * ((Total Volume ".$total_volume . " * Coveran Asuransi Per CBM 20.000.000) / Total Pcs ".$total_pcs.")";
					// wa
					$whatsapp_to_customer = "Customer Yth.*".$giw->kode."* , Anda tidak membeli asuransi untuk barang ini , Berikut kami lampirkan hitungan klaim untuk barang ini : \n".
																	"Jumlah Barang ".$this->input->post('jumlah_hilang')." * ((Total Volume ".$total_volume . " * Coveran Asuransi Per CBM 20.000.000) / Total Pcs ".$total_pcs.")".
																	"\n\n*Wilopo Cargo* _(do not reply)_";
				}else if($nilai_barang < (20000000 * $total_volume)){
					$total_klaim = $this->input->post('jumlah_hilang') * $kurs->kurs_klaim * $giw->nilai;
					$keterangan_klaim = "Tercover , Jumlah Barang ".$this->input->post('jumlah_hilang')." * kurs ".$kurs->kurs_klaim." * Harga per barang (rmb) ".$giw->nilai;
					// wa
					$whatsapp_to_customer = "Customer Yth.*".$giw->kode."* , Barang anda tercover asuransi dari kami , Berikut kami lampirkan hitungan klaim untuk barang ini : \n".
																	"Jumlah Barang ".$this->input->post('jumlah_hilang')." * kurs ".$kurs->kurs_klaim." * Harga per barang (rmb) ".$giw->nilai.
																	"\n\n*Wilopo Cargo* _(do not reply)_";
				}
			}
			sendwhatsapp($whatsapp_to_customer,$giw->whatsapp);
			$klaimed = round($total_klaim);
			// print_r($keterangan_klaim);die();
			// Itungan rts
			$total_klaim_rts = round((20000000 * $total_volume)  * ($this->input->post('jumlah_hilang') / $total_pcs ));
			$keterangan_klaim_rts = "Tidak Tercover dan Tidak membeli asuransi,Jumlah Barang ".$this->input->post('jumlah_hilang').
													    " / Total Pcs ".$total_pcs." * (Total Volume ".$total_volume . " * Coveran Asuransi Per CBM 20.000.000)";
      // Going to Database
      $klaim['id_cust']       = $giw->customer_id;
      $klaim['id_giw']        = $giw->id;
      $klaim['jumlah_klaim']  = -$klaimed;
      $klaim['tanggal_klaim'] = date('Y-m-d');
      $klaim['keterangan_klaim'] = $keterangan_klaim;
			$klaim['jumlah_klaim_rts']  = -$total_klaim_rts;
			$klaim['keterangan_klaim_rts'] = $keterangan_klaim_rts;
			$klaim['status_klaim'] = 0;

      $this->db->insert('klaim', $klaim);
      $last_id = $this->db->insert_id();

      $this->session->set_flashdata('msg','success');
      redirect(site_url('admin/klaim'));

  }

  function update($data)
  {                       //data Pelanggan
      $klaim['nama_pengguna'] = $this->input->post('nama_pengguna');
      $klaim['username'] = $this->input->post('username');

    if($this->input->post('password')==""){

    }else{
      $klaim['password'] = md5($this->input->post('password'));
    }

      $klaim['level'] = $this->input->post('level');

      	$this->db->where('id_pengguna',$this->input->post('id_pengguna'));
        $this->db->update('pengguna', $klaim);

        $this->session->set_flashdata('msg','updated');
        redirect(site_url('admin/klaim'));

  }

	function refund($data){
		$cek_bank = $this->db->where('id_bank',$this->input->post('id_bank'))->get('master_bank')->row();
		$ssaldo   = $cek_bank->saldo_bank;
		$id_klaim = $this->input->post('id_klaim');
		$data_klaim = $this->db->select('klaim.*,customer.*,giw.nomor,resi.nomor as nomor_resi')->from('klaim')->join('customer','customer.id_cust=klaim.id_cust','left')
													 ->join('giw','giw.id=klaim.id_giw','left')->join('resi','resi.id_resi=giw.resi_id','left')->where('klaim.id_klaim',$id_klaim)->get()->row();//print_r($data_klaim);die();
		$jumlah_klaim = str_replace("-","",$data_klaim->jumlah_klaim);
		$klaim['status_klaim'] = 2;
		$this->db->where('id_klaim',$id_klaim)->update('klaim',$klaim);

		$cust['deposit'] =$jumlah_klaim + $data_klaim->deposit;
		$this->db->where('id_cust',$data_klaim->id_cust);
		$this->db->update('customer',$cust);

		$dpst['id_cust'] =$data_klaim->id_cust;
		$dpst['id_cgrup'] =0;
		$dpst['nominal_deposit'] =$jumlah_klaim;
		$dpst['tipe_deposit'] ="masuk";
		$dpst['tanggal_deposit'] =date('Y-m-d');
		$dpst['keterangan_deposit'] ="Deposit masuk dari Klaim Asuransi Barang".$data_klaim->nomor." ,".$data_klaim->nomor_resi;
		$this->db->insert('deposit', $dpst);

		$this->session->set_flashdata('msg','refunded');
		redirect(site_url('admin/klaim'));
	}

	function potongan($data){
		//print_r($this->input->post('id_invoice'));//die();
		$id_klaim = $this->input->post('id_klaim');
		$data_klaim = $this->db->select('klaim.*,customer.kode,giw.id,giw.nomor,resi.nomor as nomor_resi')->from('klaim')->join('customer','customer.id_cust=klaim.id_cust','left')
													 ->join('giw','giw.id=klaim.id_giw','left')->join('resi','resi.id_resi=giw.resi_id','left')->where('klaim.id_klaim',$id_klaim)->get()->row();//print_r($data_klaim);die();
		$cekinvbarang = $this->db->select('invoice.*')->from('invoice')->where('id_invoice',$this->input->post('id_invoice'))->get()->row();
		$klaim['status_klaim'] = 1;
		$this->db->where('id_klaim',$id_klaim)->update('klaim',$klaim);
		// Going to Transaksi Bank
		$potongan['id_invoice'] =$this->input->post('id_invoice');
		$potongan['id_jenis_potongan'] = 4;
		$potongan['jumlah_potongan'] = $data_klaim->jumlah_klaim;
		$potongan['keterangan_potongan'] = "Klaim Asuransi Barang ".$data_klaim->nomor;
		$this->db->insert('potongan', $potongan);
		if($data_klaim->jumlah_klaim > $cekinvbarang->total_tagihan){
			$sisa_tagihan = 0;
			$invoice['status_invoice'] = 1;
		}else{
			$sisa_tagihan = $cekinvbarang->total_tagihan + ($data_klaim->jumlah_klaim);
		}
		$invoice['total_tagihan'] = $sisa_tagihan;
		$this->db->where('id_invoice',$potongan['id_invoice'])->update('invoice', $invoice);

		$this->session->set_flashdata('msg','okpotongan');
		redirect(site_url('admin/klaim'));
	}

	function vendor_klaim(){
		$id_klaim = $this->input->post('id_klaim');
		$klaim['status_vendor'] = 1;
		$this->db->where('id_klaim',$id_klaim)->update('klaim',$klaim);
		$this->session->set_flashdata('msg','okvendor');
		redirect(site_url('admin/klaim'));
	}

}
