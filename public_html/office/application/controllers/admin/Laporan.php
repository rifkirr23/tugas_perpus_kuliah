<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

	//Function Construct :  Load Model , Cek Session
	public function __construct(){
		parent::__construct();
		cek_session(); //cek session Login
		$this->load->model('Mapiinvoice');
		$this->load->model('Mlaporan');
		$this->load->model('Mpembelian'); //Load Model pembelian
	}

	//Function Laporan Transaksi Titip Transfer
	function titip_transfer(){
		$data['stts'] = 0;
		$data['now'] = date('Y-m-d');
		$data['tanggal_now'] = date_indo($data['now']);
		$data['total_laba'] =  $this->Mlaporan->get_laba_tt();
		$data['min'] = 0;
		$data['max'] = 0;
		$this->template->load('template','admin/laporan/titip_transfer',$data);
	}

	//Function Laporan Transaksi Titip Transfer Filter
	function titip_transfer_filter(){
		$data['stts'] = 1;
		$data['now'] = date('Y-m-d');
		$min = date('Y-m-d ',strtotime($this->input->post('min_date')));
		$max = date('Y-m-d ',strtotime($this->input->post('max_date')));
		$data['tanggal_now'] = "dari " .date_indo($min). " sampai " . date_indo($max);
		$data['total_laba'] =  $this->Mlaporan->get_laba_ttfilter($min,$max);
		$data['min'] = date('Y-m-d ',strtotime($this->input->post('min_date')));
		$data['max'] = date('Y-m-d ',strtotime($this->input->post('max_date')));
		$this->template->load('template','admin/laporan/titip_transfer',$data);
	}

	//Function Get data Json Transaksi Titip Transfer
	function titip_transfer_json() {
    header('Content-Type:application/json');
    echo $this->Mlaporan->titip_transfer_json();
  }

	function titip_transferfilter_json() {
    header('Content-Type: application/json');
		$min = $this->uri->segment(4);
		$max = $this->uri->segment(5);
    echo $this->Mlaporan->titip_transferfilter_json($min,$max);
  }

	//Function Laporan Transaksi Resi
	function master(){
		$data['now'] 				 = date('Y-m-d');
		$data['tanggal_now'] = date_indo($data['now']);
		$data['total_asuransi'] =  $this->Mlaporan->total_asuransi();
		$data['total_laba'] =  $this->Mlaporan->get_laba_tt();
		$data['total_laba_resi'] =  $this->Mlaporan->get_laba_resi();
		$data['total_laba_resi_udara'] =  $this->Mlaporan->get_laba_resi_udara();
		$data['total_laba_fcl'] =  $this->Mlaporan->get_laba_fcl();
		$data['semua_komisi_barang'] =  $this->Mlaporan->get_komisi_brg();
		$data['semua_komisi_titip_trf'] =  $this->Mlaporan->get_komisi_trf();
		$data['total_cbm']   =  $this->Mlaporan->get_cbm();
		$data['record_resi'] =  $this->Mlaporan->get_resi()->result();//print_r($data['record_resi']);die();
		$data['record_air'] =  $this->Mlaporan->get_air()->result();
		$data['record_fcl'] =  $this->Mlaporan->get_fcl()->result();
		$data['record_trf'] =  $this->Mlaporan->get_trf()->result();
		$data['data_master'] =  $this->db->where('id_master_laporan',1)->get('master_laporan')->row();
		// print_r($data['total_perkiraan_laba_resi']);die();
		$this->template->load('template','admin/laporan/master',$data);
	}

	//Function Filter Data Laporan Resi
	function filter_master() {
		$data['now'] = date('Y-m-d');
		$min = date('Y-m-d 00:00:00',strtotime($this->input->post('min_date')));
		$max = date('Y-m-d 23:59:59',strtotime($this->input->post('max_date')));
		// $data['total_perkiraan_laba_resi'] =  $this->Mlaporan->laba_resi_no_inv();
		$data['total_cbm'] =  $this->Mlaporan->get_cbmfilter($min,$max);
		$data['record_resi'] =  $this->Mlaporan->get_resifilter($min,$max)->result();//print_r($data['record_resi']);die();
		$data['record_air'] =  $this->Mlaporan->get_airfilter($min,$max)->result();
		$data['record_fcl'] =  $this->Mlaporan->get_fclfilter($min,$max)->result();
		$data['record_trf'] =  $this->Mlaporan->get_trffilter($min,$max)->result();
		$data['total_laba_resi'] =  $this->Mlaporan->get_laba_resifilter($min,$max);
		$data['total_laba_resi_udara'] =  $this->Mlaporan->get_laba_resi_udarafilter($min,$max);
		$data['total_laba_fcl'] =  $this->Mlaporan->get_laba_fclfilter($min,$max);
		$data['total_laba'] =  $this->Mlaporan->get_laba_ttfilter($min,$max);
		$data['total_asuransi'] =  $this->Mlaporan->total_asuransifilter($min,$max);
		$data['semua_komisi_barang'] =  $this->Mlaporan->get_komisi_brg_filter($min,$max);
		$data['semua_komisi_titip_trf'] =  $this->Mlaporan->get_komisi_trf_filter($min,$max);
		$data['min'] = date('Y-m-d ',strtotime($this->input->post('min_date')));
		$data['max'] = date('Y-m-d ',strtotime($this->input->post('max_date')));
		$data['record_asuransi'] =  $this->Mlaporan->get_asrfilter($data['min'],$data['max'])->result();//print_r($data['record_asuransi']);die();
		$data['tanggal_now'] = "dari " .date_indo($data['min']). " sampai " . date_indo($data['max']);
		$this->template->load('template','admin/laporan/filter_master',$data);
  }


	//Function Laporan Transaksi Resi
	function master_invoice(){
		// echo "sasa"; die("oke");
		$data['now'] 				 = date('Y-m-d');
		$data['tanggal_now'] = date_indo($data['now']);
		$data['total_asuransi'] =  $this->Mlaporan->total_asuransi();
		$data['total_laba'] =  $this->Mlaporan->get_laba_tt();
		$data['total_laba_sea'] 				 =  $this->Mlaporan->get_laba_invsea();
		$data['total_laba_resi_udara'] 	 =  $this->Mlaporan->get_laba_resi_udara();
		$data['total_laba_fcl'] 				 =  $this->Mlaporan->get_laba_fcl();
		$data['semua_komisi_titip_trf']  =  $this->Mlaporan->komisi_barang_inv();
		$data['semua_komisi_barang']     =  $this->Mlaporan->komisi_trf_inv();
		$data['pengeluaran_perkategori'] =  $this->Mlaporan->pengeluaran_inv();//print_r($data['pengeluaran_perkategori']);die();
		$data['total_cbm']  =  $this->Mlaporan->get_cbm();
		$data['record_sea'] =  $this->Mlaporan->get_invsea()->result();//print_r($data['record_resi']);die();
		$data['record_air'] =  $this->Mlaporan->get_air()->result();
		$data['record_fcl'] =  $this->Mlaporan->get_fcl()->result();
		$this->template->load('template','admin/laporan/master_invoice',$data);
	}

	//Function Filter Data Laporan Resi
	function filter_master_invoice() {
		// die("oke");
		$data['now'] = date('Y-m-d');
		$min = date('Y-m-d 00:00:00',strtotime($this->input->post('min_date')));
		$max = date('Y-m-d 23:59:59',strtotime($this->input->post('max_date')));
		$data['total_cbm'] =  $this->Mlaporan->get_cbmfilter($min,$max);
		$data['record_sea'] =  $this->Mlaporan->get_invseafilter($min,$max)->result();//print_r($data['record_resi']);die();
		$data['record_air'] =  $this->Mlaporan->get_airfilter($min,$max)->result();
		$data['record_fcl'] =  $this->Mlaporan->get_fclfilter($min,$max)->result();
		$data['record_trf'] =  $this->Mlaporan->get_trffilter($min,$max)->result();
		$data['total_laba_sea'] =  $this->Mlaporan->get_laba_invseafilter($min,$max);
		$data['total_laba_resi_udara'] =  $this->Mlaporan->get_laba_resi_udarafilter($min,$max);
		$data['total_laba_fcl'] =  $this->Mlaporan->get_laba_fclfilter($min,$max);
		$data['total_laba'] =  $this->Mlaporan->get_laba_ttfilter($min,$max);
		$data['total_asuransi'] =  $this->Mlaporan->total_asuransifilter($min,$max);
		$data['semua_komisi_barang'] =  $this->Mlaporan->komisi_barang_invfilter($min,$max);
		$data['semua_komisi_titip_trf'] =  $this->Mlaporan->komisi_trf_invfilter($min,$max);
		$data['pengeluaran_perkategori'] =  $this->Mlaporan->pengeluaran_invfilter($min,$max);
		$data['min'] = date('Y-m-d ',strtotime($this->input->post('min_date')));
		$data['max'] = date('Y-m-d ',strtotime($this->input->post('max_date')));
		$data['record_asuransi'] =  $this->Mlaporan->get_asrfilter($data['min'],$data['max'])->result();//print_r($data['record_asuransi']);die();
		$data['tanggal_now'] = "dari " .date_indo($data['min']). " sampai " . date_indo($data['max']);
		$this->template->load('template','admin/laporan/filter_master_invoice',$data);
  }

	//Function Laporan Asuransi
	function asuransi(){
		$data['stts'] = 0;
		$data['now'] = date('Y-m-d');
		$data['tanggal_now'] = date_indo($data['now']);
		$data['total_asuransi'] =  $this->Mlaporan->total_asuransi();
		$data['min'] = 0;
		$data['max'] = 0;
		$this->template->load('template','admin/laporan/asuransi',$data);
	}

	//Function Laporan Asuransi Filter
	function asuransi_filter(){
		$data['stts'] = 1;
		$data['now'] = date('Y-m-d');
		$min = date('Y-m-d ',strtotime($this->input->post('min_date')));
		$max = date('Y-m-d ',strtotime($this->input->post('max_date')));
		$data['tanggal_now'] = "dari " .date_indo($min). " sampai " . date_indo($max);
		$data['total_asuransi'] =  $this->Mlaporan->total_asuransifilter($min,$max);
		$data['min'] = date('Y-m-d ',strtotime($this->input->post('min_date')));
		$data['max'] = date('Y-m-d ',strtotime($this->input->post('max_date')));
		$this->template->load('template','admin/laporan/asuransi',$data);
	}

	//Function Get data Json Asuransi
	function asuransi_json() {
    header('Content-Type: application/json');
		$min = $this->uri->segment(4);
		$max = $this->uri->segment(5);
    echo $this->Mlaporan->asuransi_json($min,$max);
  }

	// Function Neraca
	function neraca(){
		//Aktiva / Assets
		$data['invoicelainnya'] = $this->db->select('sum((total_tagihan-jumlah_bayar) - total_potongan) as jumlah')->where('tipe_invoice','lainnya')->get('invoice')->row();
		$data['invoiceair'] = $this->db->select('sum((total_tagihan-jumlah_bayar) - total_potongan) as jumlah')->where('tipe_invoice','air')->get('invoice')->row();
		$data['invoicesea'] = $this->db->select('sum((total_tagihan-jumlah_bayar) - total_potongan) as jumlah')->where('tipe_invoice','barang')->get('invoice')->row();
		$data['invoicetrf'] = $this->db->select('sum((total_tagihan-jumlah_bayar) - total_potongan) as jumlah')->where('status_invoice <',2)->where('tipe_invoice','tt')->get('invoice')->row();//print_r($data['invoicetrf']);die();
		// Passiva
		$data['hutang_lclsea']  = $this->db->select('sum(jumlah_invoice_beli-jumlah_bayar_invoice_beli) as jumlah')->where('id_vendor',4)->from('invoice_beli')->get()->row();
		$data['hutang_lclair']  = $this->db->select('sum(jumlah_invoice_beli-jumlah_bayar_invoice_beli) as jumlah')->where('id_vendor',1)->from('invoice_beli')->get()->row();
		$data['hutang_invoice_lainnya']  = $this->db->select('sum(jumlah_invoice_beli-jumlah_bayar_invoice_beli) as jumlah')->where('id_vendor',2)->from('invoice_beli')->get()->row();
		$data['hutang_titiptrf']  = $this->db->select('sum(jumlah_rmb) as jumlah')->from('transaksi')->where('jumlah_rmb <',10000)->where('(status=2 OR status=4 OR status=1)', null ,FALSE)->get()->row();
		$data['trf10000']  = $this->Mpembelian->total_semua_pembelian() + $this->Mpembelian->transaksi_pending();
		$data['komisi_tertahan'] = $this->db->select('sum(nilai) as jumlah')->where('status',1)->get('komisi_referal')->row();
		$data['deposit'] = $this->db->select('sum(deposit) as jumlah')->get('customer')->row();
		$data['rekening'] = $this->db->get('master_bank')->result();
		$data['datarmb']  = $this->db->order_by('status_rmb','asc')->get('rmb')->result();
		$this->template->load('template','admin/laporan/neraca',$data);
	}

	function neraca_new(){
		$data['tanggal_now'] = date_indo(date('Y-m-d'));
		// laba ditahan
		$penjualannya = $this->db->select('sum(total_tagihan) as jumlah')->from('invoice')
																	->where('tipe_invoice !=','null')
																	->where('status_invoice !=','2')->get()->row();

		$datapembelian = $this->db->select('sum(transaksi.kurs_beli * transaksi.jumlah_rmb) as jumlah')->from('pembelian')
																				->join('transaksi', 'pembelian.id_transaksi=transaksi.id_transaksi')
																				->where('pembelian.status_pembelian !=',3)->get()->row();

		$rp100= $this->db->where('pembelian.tanggal_pembelian <=',"2019-12-19")
										 ->where('pembelian.status_pembelian !=',3)->get('pembelian')->num_rows();

		$get_modal_rmb = $this->db->select('sum(nominal_transaksi_bank) as jumlah')
															->where('id_jenis_transaksi_bank',3)
															->get('transaksi_bank')->row();

		$pembelian_rmb10 = $datapembelian->jumlah + ($rp100 * 100000) + $get_modal_rmb->jumlah;

		$total_pengeluaran = $this->db->select('sum(nominal_transaksi_bank) as jumlah')->from('transaksi_bank')
																					->join('jenis_transaksi_bank','transaksi_bank.id_jenis_transaksi_bank=jenis_transaksi_bank.id_jenis_transaksi_bank','left')
																					->where('jenis_transaksi_bank.id_jenis_transaksi_utama',1)
																					->where('id_parent !=',"23")
																					->where('tipe_transaksi_bank',"keluar")
																					->get()->row();

		$total_dividen = $this->db->select('sum(nominal_transaksi_bank) as jumlah')->from('transaksi_bank')
																					->join('jenis_transaksi_bank','transaksi_bank.id_jenis_transaksi_bank=jenis_transaksi_bank.id_jenis_transaksi_bank','left')
																					->where('jenis_transaksi_bank.id_jenis_transaksi_utama',1)
																					->where('id_parent',"23")
																					->where('tipe_transaksi_bank',"keluar")
																					->get()->row();

		$total_pembelian = $this->db->select('sum(jumlah_invoice_beli) as jumlah')->get('invoice_beli')->row();

		$total_modal = $total_pembelian->jumlah + $pembelian_rmb10;
		$data['total_laba'] = (($penjualannya->jumlah - $total_modal) - $total_pengeluaran->jumlah) - $total_dividen->jumlah ;
		//Aktiva / Assets
		$data['invoicelainnya'] = $this->db->select('sum((total_tagihan-jumlah_bayar) - total_potongan) as jumlah')->where('tipe_invoice','lainnya')
																			 ->where('tanggal_invoice',date('Y-m-d'))->get('invoice')->row();
		$data['invoiceair'] = $this->db->select('sum((total_tagihan-jumlah_bayar) - total_potongan) as jumlah')->where('tipe_invoice','air')
																	 ->where('tanggal_invoice',date('Y-m-d'))->get('invoice')->row();
		$data['invoicesea'] = $this->db->select('sum((total_tagihan-jumlah_bayar) - total_potongan) as jumlah')->where('tipe_invoice','barang')
																	 ->where('tanggal_invoice',date('Y-m-d'))->get('invoice')->row();
		$data['invoicetrf'] = $this->db->select('sum((total_tagihan-jumlah_bayar) - total_potongan) as jumlah')->where('status_invoice <',2)->where('tipe_invoice','tt')
																	 ->where('tanggal_invoice',date('Y-m-d'))->get('invoice')->row();
		$data['rekening'] = $this->db->get('master_bank')->result();
 		$data['datarmb']  = $this->db->order_by('status_rmb','asc')->get('rmb')->result();
 		$data['perlengkapan_kantor'] = $this->db->where('id_jenis_transaksi_bank',34)->where('tanggal_transaksi_bank',date('Y-m-d'))->get('transaksi_bank')->result();
 		$data['peralatan_kantor'] = $this->db->where('id_jenis_transaksi_bank',25)->where('tanggal_transaksi_bank',date('Y-m-d'))->get('transaksi_bank')->result();
		// Passiva
		$data['hutang_lclsea']  = $this->db->select('sum(jumlah_invoice_beli-jumlah_bayar_invoice_beli) as jumlah')->where('id_vendor',4)
																			 ->where('tanggal_invoice_beli',date('Y-m-d'))->from('invoice_beli')->get()->row();
		$data['hutang_lclair']  = $this->db->select('sum(jumlah_invoice_beli-jumlah_bayar_invoice_beli) as jumlah')->where('id_vendor',1)
																			 ->where('tanggal_invoice_beli',date('Y-m-d'))->from('invoice_beli')->get()->row();
		$data['hutang_invoice_lainnya']  = $this->db->select('sum(jumlah_invoice_beli-jumlah_bayar_invoice_beli) as jumlah')->where('id_vendor',2)
																								->where('tanggal_invoice_beli',date('Y-m-d'))->from('invoice_beli')->get()->row();
		$data['hutang_titiptrf']  = $this->db->select('sum(jumlah_rmb) as jumlah')->from('transaksi')->where('jumlah_rmb <',10000)
																				 ->where('transaksi.tanggal_transaksi >=',date('Y-m-d '.'00:'.'00:'.'00'))
																				 ->where('(status=2 OR status=4 OR status=1)', null ,FALSE)->get()->row();
		$data['trf10000']  = $this->Mpembelian->total_semua_pembelian_today() + $this->Mpembelian->transaksi_pending_today();
		$data['komisi_tertahan'] = $this->db->select('sum(nilai) as jumlah')->from('komisi_referal')->where('komisi_referal.status',1)
																				->where('invoice.tanggal_invoice',date('Y-m-d'))
																				->join('invoice', 'invoice.id_invoice=komisi_referal.id_invoice', 'left')->get()->row();
		$deposit_masuk = $this->db->select('sum(nominal_deposit) as nodep')->from('deposit')->where('tipe_deposit','masuk')->get()->row();
		$deposit_keluar = $this->db->select('sum(nominal_deposit) as nodep')->from('deposit')->where('tipe_deposit','keluar')->get()->row();
		// print_r($deposit_masuk->nodep-$deposit_keluar->nodep);die();
		$data['deposit'] = $this->db->select('sum(deposit) as jumlah')->get('customer')->row();
		$this->template->load('template','admin/laporan/neraca_new',$data);
	}

	function filter_neraca_new(){
		$data['min'] = date('Y-m-d ',strtotime($this->input->post('min_date')));
		$data['max'] = date('Y-m-d ',strtotime($this->input->post('max_date')));
		$min = date('Y-m-d 00:00:00',strtotime($this->input->post('min_date')));
		$max = date('Y-m-d 23:59:59',strtotime($this->input->post('max_date')));
		$daritanggal =date('Y-m-d ',strtotime($this->input->post('min_date')));
		$sampaitanggal = date('Y-m-d ',strtotime($this->input->post('max_date')));
		// $data['maxdate'] = date('Y-m-d 23:59:59',strtotime($this->input->post('max_date')));
		$data['tanggal_now'] = "dari " .date_indo($data['min']). " sampai " . date_indo($data['max']);
		// laba ditahan
		$penjualannya = $this->db->select('sum(total_tagihan) as jumlah')->from('invoice')
																	->where('tipe_invoice !=','null')
																	->where('tanggal_invoice >=',$daritanggal)
																	->where('tanggal_invoice <=',$sampaitanggal)
																	->where('status_invoice !=','2')->get()->row();

		$datapembelian = $this->db->select('sum(transaksi.kurs_beli * transaksi.jumlah_rmb) as jumlah')->from('pembelian')
															->where('tanggal_pembelian >=',$daritanggal)
															->where('tanggal_pembelian <=',$sampaitanggal)
															->join('transaksi', 'pembelian.id_transaksi=transaksi.id_transaksi')
															->where('pembelian.status_pembelian !=',3)->get()->row();

		$rp100= $this->db->where('pembelian.data_lama',1)
										 ->where('tanggal_pembelian >=',$daritanggal)
										 ->where('tanggal_pembelian <=',$sampaitanggal)
										 ->where('pembelian.status_pembelian !=',3)
										 ->get('pembelian')->num_rows();

		$get_modal_rmb = $this->db->select('sum(nominal_transaksi_bank) as jumlah')
															->where('tanggal_transaksi_bank >=',$daritanggal)
														  ->where('tanggal_transaksi_bank <=',$sampaitanggal)
															->where('id_jenis_transaksi_bank',3)
															->get('transaksi_bank')->row();

		$pembelian_rmb10 = $datapembelian->jumlah + ($rp100 * 100000) + $get_modal_rmb->jumlah;

		$total_pengeluaran = $this->db->select('sum(nominal_transaksi_bank) as jumlah')->from('transaksi_bank')
										->join('jenis_transaksi_bank','transaksi_bank.id_jenis_transaksi_bank=jenis_transaksi_bank.id_jenis_transaksi_bank','left')
										->where('tanggal_transaksi_bank >=',$daritanggal)
										->where('tanggal_transaksi_bank <=',$sampaitanggal)
										->where('id_parent !=',"23")
										->where('jenis_transaksi_bank.id_jenis_transaksi_utama',1)
										->where('tipe_transaksi_bank',"keluar")
										->get()->row();

		$total_dividen = $this->db->select('sum(nominal_transaksi_bank) as jumlah')->from('transaksi_bank')
																					->join('jenis_transaksi_bank','transaksi_bank.id_jenis_transaksi_bank=jenis_transaksi_bank.id_jenis_transaksi_bank','left')
																					->where('tanggal_transaksi_bank >=',$daritanggal)
																					->where('tanggal_transaksi_bank <=',$sampaitanggal)
																					->where('jenis_transaksi_bank.id_jenis_transaksi_utama',1)
																					->where('id_parent',"23")
																					->where('tipe_transaksi_bank',"keluar")
																					->get()->row();

		$total_pembelian = $this->db->select('sum(jumlah_invoice_beli) as jumlah')
																				->where('tanggal_invoice_beli >=',$daritanggal)
																				->where('tanggal_invoice_beli <=',$sampaitanggal)
																				->get('invoice_beli')->row();
		$total_modal = $total_pembelian->jumlah + $pembelian_rmb10;
		$data['total_laba'] = (($penjualannya->jumlah - $total_modal)- $total_pengeluaran->jumlah) - $total_dividen->jumlah ;
		//Aktiva / Assets
		$data['invoicelainnya'] = $this->db->select('sum((total_tagihan-jumlah_bayar) - total_potongan) as jumlah')->where('tipe_invoice','lainnya')
																			 ->where('tanggal_invoice >=',$data['min'])->where('tanggal_invoice <=',$data['max'])->get('invoice')->row();
		$data['invoiceair'] = $this->db->select('sum((total_tagihan-jumlah_bayar) - total_potongan) as jumlah')->where('tipe_invoice','air')
																	 ->where('tanggal_invoice >=',$data['min'])->where('tanggal_invoice <=',$data['max'])->get('invoice')->row();
		$data['invoicesea'] = $this->db->select('sum((total_tagihan-jumlah_bayar) - total_potongan) as jumlah')->where('tipe_invoice','barang')
																	 ->where('tanggal_invoice >=',$data['min'])->where('tanggal_invoice <=',$data['max'])->get('invoice')->row();
		$data['invoicetrf'] = $this->db->select('sum((total_tagihan-jumlah_bayar) - total_potongan) as jumlah')->where('status_invoice <',2)->where('tipe_invoice','tt')
																	 ->where('tanggal_invoice >=',$data['min'])->where('tanggal_invoice <=',$data['max'])->get('invoice')->row();
		$data['rekening'] = $this->db->get('master_bank')->result();
 		$data['datarmb']  = $this->db->order_by('status_rmb','asc')->get('rmb')->result();
 		$data['perlengkapan_kantor'] = $this->db->where('id_jenis_transaksi_bank',34)->where('tanggal_transaksi_bank >=',$data['min'])->where('tanggal_transaksi_bank <=',$data['max'])->get('transaksi_bank')->result();
 		$data['peralatan_kantor'] = $this->db->where('id_jenis_transaksi_bank',25)->where('tanggal_transaksi_bank >=',$data['min'])->where('tanggal_transaksi_bank <=',$data['max'])->get('transaksi_bank')->result();
		// Passiva
		$data['hutang_lclsea']  = $this->db->select('sum(jumlah_invoice_beli-jumlah_bayar_invoice_beli) as jumlah')->where('id_vendor',4)
																			 ->where('tanggal_invoice_beli >=',$data['min'])->where('tanggal_invoice_beli <=',$data['max'])->from('invoice_beli')->get()->row();
		$data['hutang_lclair']  = $this->db->select('sum(jumlah_invoice_beli-jumlah_bayar_invoice_beli) as jumlah')->where('id_vendor',1)
																			 ->where('tanggal_invoice_beli >=',$data['min'])->where('tanggal_invoice_beli <=',$data['max'])->from('invoice_beli')->get()->row();
		$data['hutang_invoice_lainnya']  = $this->db->select('sum(jumlah_invoice_beli-jumlah_bayar_invoice_beli) as jumlah')->where('id_vendor',2)
																								->where('tanggal_invoice_beli >=',$data['min'])->where('tanggal_invoice_beli <=',$data['max'])->from('invoice_beli')->get()->row();
		$data['hutang_titiptrf']  = $this->db->select('sum(jumlah_rmb) as jumlah')->from('transaksi')->where('jumlah_rmb <',10000)
																				 ->where('transaksi.tanggal_transaksi >=',$min)->where('transaksi.tanggal_transaksi <=',$max)
																				 ->where('(status=2 OR status=4 OR status=1)', null ,FALSE)->get()->row();
		$data['trf10000']  = $this->Mpembelian->total_semua_pembelian_filter($data['min'],$data['max']) + $this->Mpembelian->transaksi_pending_filter($min,$max);
		$data['komisi_tertahan'] = $this->db->select('sum(nilai) as jumlah')->from('komisi_referal')->where('komisi_referal.status',1)
																				->where('invoice.tanggal_invoice',date('Y-m-d'))
																				->join('invoice', 'invoice.id_invoice=komisi_referal.id_invoice', 'left')->get()->row();
		$deposit_masuk = $this->db->select('sum(nominal_deposit) as nodep')->from('deposit')->where('tipe_deposit','masuk')->get()->row();
		$deposit_keluar = $this->db->select('sum(nominal_deposit) as nodep')->from('deposit')->where('tipe_deposit','keluar')->get()->row();
		// print_r($deposit_masuk->nodep-$deposit_keluar->nodep);die();
		$data['deposit'] = $this->db->select('sum(deposit) as jumlah')->get('customer')->row();
		$this->template->load('template','admin/laporan/filter_neraca_new',$data);
	}

	// Function Laba Rugi
	function laba_rugi(){
		$data['tanggal_now'] = date_indo(date("Y-m-d"));
		//Penjualan
		$data['penjualan'] = $this->db->select('sum(total_tagihan) as jumlah')->from('invoice')
																	->where('tipe_invoice !=','null')
																	->where('status_invoice !=','2')->get()->row();

		$data['penjualan_pisah'] = $this->db->select('sum(total_tagihan) as jumlah,tipe_invoice')
																				->where('tipe_invoice !=','null')
																				->group_by('tipe_invoice')->where('status_invoice !=','2')->get('invoice')->result();
		// Potongan < 0 Per Jenis Potongan
		$data['potongan_penjualan'] = $this->db->select('sum(jumlah_potongan) as jumlah,jenis_potongan.kjenis_potongan')
																					 ->from('potongan')->where('tipe_potongan is Null',null,false)
																					 ->where('jumlah_potongan <',0)
																					 ->join('jenis_potongan','jenis_potongan.id_jenis_potongan=potongan.id_jenis_potongan','left')
																					 ->group_by('potongan.id_jenis_potongan')->get()->result();

		// Potongan atau Charge  > 0 Per jenis Potongan
	  $data['charge_penjualan'] =  $this->db->select('sum(jumlah_potongan) as jumlah,jenis_potongan.kjenis_potongan')
																					 ->from('potongan')->where('tipe_potongan is Null',null,false)
																					 ->where('jumlah_potongan >',0)
																					 ->join('jenis_potongan','jenis_potongan.id_jenis_potongan=potongan.id_jenis_potongan','left')
																					 ->group_by('potongan.id_jenis_potongan')->get()->result();
		// Total Charge
	  $data['total_charge'] = $this->db->select('sum(jumlah_potongan) as jumlah')->where('tipe_potongan is Null',null,false)
																  		 ->where('jumlah_potongan >',0)->get('potongan')->row();
		// Total Potongan
	  $data['total_potongan'] = $this->db->select('sum(jumlah_potongan) as jumlah')->where('tipe_potongan is Null',null,false)
																  		 ->where('jumlah_potongan <',0)->get('potongan')->row();
		// Pembelian
		$data['pembelian'] = $this->db->select('sum(jumlah_invoice_beli) as jumlah,vendor.nama_vendor,vendor.id_vendor')
																	->join('vendor','vendor.id_vendor=invoice_beli.id_vendor','left')
																	->group_by('invoice_beli.id_vendor')->where('invoice_beli.id_vendor >',0)->get('invoice_beli')->result();

		$data['total_pembelian'] = $this->db->select('sum(jumlah_invoice_beli) as jumlah')->get('invoice_beli')->row();

		$data['potongan_pembelian'] = $this->db->select('sum(jumlah_potongan) as jumlah')->where('tipe_potongan','beli')
																  				 ->get('potongan')->row();
		// Pembelian Rmb
		$datapembelian = $this->db->select('sum(transaksi.kurs_beli * transaksi.jumlah_rmb) as jumlah')->from('pembelian')
																				->join('transaksi', 'pembelian.id_transaksi=transaksi.id_transaksi')
																				->where('pembelian.status_pembelian !=',3)->get()->row();

		$rp100= $this->db->where('pembelian.tanggal_pembelian <=',"2019-12-19")
										 ->where('pembelian.status_pembelian !=',3)->get('pembelian')->num_rows();

		$get_modal_rmb = $this->db->select('sum(nominal_transaksi_bank) as jumlah')
															->where('id_jenis_transaksi_bank',3)
															->get('transaksi_bank')->row();

		$data['pembelian_rmb10'] = $datapembelian->jumlah + ($rp100 * 100000) + $get_modal_rmb->jumlah;
		// $data['potongan_pembelian'] = $this->db->select('sum(jumlah_potongan) as jumlah')->where('tipe_potongan','beli')
		// 														  					 ->where('jumlah_potongan <',0)->get('potongan')->row();
		// Pengeluaran
		$data['pengeluaran'] = $this->db->select('sum(nominal_transaksi_bank) as jumlah,parent_jenis_transaksi.nama_parent,parent_jenis_transaksi.id_parent')
																		->from('transaksi_bank')
																		->join('jenis_transaksi_bank','transaksi_bank.id_jenis_transaksi_bank=jenis_transaksi_bank.id_jenis_transaksi_bank','left')
																		->join('parent_jenis_transaksi','parent_jenis_transaksi.id_parent=jenis_transaksi_bank.id_parent','left')
																		->where('jenis_transaksi_bank.id_jenis_transaksi_utama',1)
																		->where('tipe_transaksi_bank',"keluar")
																		->where('parent_jenis_transaksi.id_parent !=',"23")
																		->group_by('parent_jenis_transaksi.id_parent')
																		->get()->result();

		$data['total_pengeluaran'] = $this->db->select('sum(nominal_transaksi_bank) as jumlah')->from('transaksi_bank')
																					->join('jenis_transaksi_bank','transaksi_bank.id_jenis_transaksi_bank=jenis_transaksi_bank.id_jenis_transaksi_bank','left')
																					->where('jenis_transaksi_bank.id_jenis_transaksi_utama',1)
																					->where('id_parent !=',"23")
																					->where('tipe_transaksi_bank',"keluar")
																					->get()->row();

		$data['total_dividen'] = $this->db->select('sum(nominal_transaksi_bank) as jumlah')->from('transaksi_bank')
																					->join('jenis_transaksi_bank','transaksi_bank.id_jenis_transaksi_bank=jenis_transaksi_bank.id_jenis_transaksi_bank','left')
																					->where('jenis_transaksi_bank.id_jenis_transaksi_utama',1)
																					->where('id_parent',"23")
																					->where('tipe_transaksi_bank',"keluar")
																					->get()->row();

	  $data['status_filter'] = 1;
		// print_r($data['total_dividen']);die();															;

		$this->template->load('template','admin/laporan/laba_rugi',$data);
	}

	function laba_rugifilter(){
		$daritanggal =date('Y-m-d ',strtotime($this->input->post('dari_tanggal')));
		$sampaitanggal = date('Y-m-d ',strtotime($this->input->post('sampai_tanggal')));
		$data['tanggal_now'] = "dari " .date_indo($daritanggal). " sampai " . date_indo($sampaitanggal);
		$data['daritanggal'] = $daritanggal;
		$data['sampaitanggal'] = $sampaitanggal;
		// print_r($data['tanggal_now']);die();
		//Penjualan
		$data['penjualan'] = $this->db->select('sum(total_tagihan) as jumlah')->from('invoice')
																	->where('tipe_invoice !=','null')
																	->where('tanggal_invoice >=',$daritanggal)
																	->where('tanggal_invoice <=',$sampaitanggal)
																	->where('status_invoice !=','2')->get()->row();

		$data['penjualan_pisah'] = $this->db->select('sum(total_tagihan) as jumlah,tipe_invoice')
																				->where('tipe_invoice !=','null')
																				->where('tanggal_invoice >=',$daritanggal)
																				->where('tanggal_invoice <=',$sampaitanggal)
																				->group_by('tipe_invoice')->where('status_invoice !=','2')->get('invoice')->result();
		// Potongan < 0 Per Jenis Potongan
		$data['potongan_penjualan'] = $this->db->select('sum(jumlah_potongan) as jumlah,jenis_potongan.kjenis_potongan')
										 ->from('potongan')->where('tipe_potongan is Null',null,false)
										 ->where('jumlah_potongan <',0)
										 ->where('tanggal_invoice >=',$daritanggal)
										 ->where('tanggal_invoice <=',$sampaitanggal)
										 ->join('invoice','invoice.id_invoice=potongan.id_invoice','left')
										 ->join('jenis_potongan','jenis_potongan.id_jenis_potongan=potongan.id_jenis_potongan','left')
										 ->group_by('potongan.id_jenis_potongan')->get()->result();

		// Potongan atau Charge  > 0 Per jenis Potongan
		$data['charge_penjualan'] =  $this->db->select('sum(jumlah_potongan) as jumlah,jenis_potongan.kjenis_potongan')
										 ->from('potongan')->where('tipe_potongan is Null',null,false)
										 ->where('jumlah_potongan >',0)
										 ->where('tanggal_invoice >=',$daritanggal)
										 ->where('tanggal_invoice <=',$sampaitanggal)
										 ->join('invoice','invoice.id_invoice=potongan.id_invoice','left')
										 ->join('jenis_potongan','jenis_potongan.id_jenis_potongan=potongan.id_jenis_potongan','left')
										 ->group_by('potongan.id_jenis_potongan')->get()->result();
		// Total Charge
		$data['total_charge'] = $this->db->select('sum(jumlah_potongan) as jumlah')->from('potongan')
																		 ->where('tipe_potongan is Null',null,false)
																		 ->where('tanggal_invoice >=',$daritanggal)
	 																	 ->where('tanggal_invoice <=',$sampaitanggal)
																		 ->join('invoice','invoice.id_invoice=potongan.id_invoice','left')
					  		 										 ->where('jumlah_potongan >',0)->get()->row();
		// Total Potongan
		$data['total_potongan'] = $this->db->select('sum(jumlah_potongan) as jumlah')->from('potongan')
																			 ->where('tipe_potongan is Null',null,false)
																			 ->where('tanggal_invoice >=',$daritanggal)
		 																	 ->where('tanggal_invoice <=',$sampaitanggal)
																			 ->join('invoice','invoice.id_invoice=potongan.id_invoice','left')
					  		 										 	 ->where('jumlah_potongan <',0)->get()->row();
		// Pembelian
		$data['pembelian'] = $this->db->select('sum(jumlah_invoice_beli) as jumlah,vendor.nama_vendor,vendor.id_vendor')
																	->from('invoice_beli')
																	->where('tanggal_invoice_beli >=',$daritanggal)
																	->where('tanggal_invoice_beli <=',$sampaitanggal)
																	->join('vendor','vendor.id_vendor=invoice_beli.id_vendor','left')
																	->group_by('invoice_beli.id_vendor')->where('invoice_beli.id_vendor >',0)->get()->result();

		$data['total_pembelian'] = $this->db->select('sum(jumlah_invoice_beli) as jumlah')
																				->where('tanggal_invoice_beli >=',$daritanggal)
																				->where('tanggal_invoice_beli <=',$sampaitanggal)
																				->get('invoice_beli')->row();

		$data['potongan_pembelian'] = $this->db->select('sum(jumlah_potongan) as jumlah')
																					 ->from('potongan')
																					 ->where('tanggal_invoice_beli >=',$daritanggal)
				 																	 ->where('tanggal_invoice_beli <=',$sampaitanggal)
																					 ->join('invoice_beli','invoice_beli.id_invoice_beli=potongan.id_invoice','left')
																					 ->where('tipe_potongan','beli')
																  				 ->get()->row();
		// Pembelian Rmb
		$datapembelian = $this->db->select('sum(transaksi.kurs_beli * transaksi.jumlah_rmb) as jumlah')->from('pembelian')
															->where('tanggal_pembelian >=',$daritanggal)
															->where('tanggal_pembelian <=',$sampaitanggal)
															->join('transaksi', 'pembelian.id_transaksi=transaksi.id_transaksi')
															->where('pembelian.status_pembelian !=',3)->get()->row();

		$rp100= $this->db->where('pembelian.data_lama',1)
										 ->where('tanggal_pembelian >=',$daritanggal)
										 ->where('tanggal_pembelian <=',$sampaitanggal)
										 ->where('pembelian.status_pembelian !=',3)
										 ->get('pembelian')->num_rows();

		$get_modal_rmb = $this->db->select('sum(nominal_transaksi_bank) as jumlah')
															->where('tanggal_transaksi_bank >=',$daritanggal)
														  ->where('tanggal_transaksi_bank <=',$sampaitanggal)
															->where('id_jenis_transaksi_bank',3)
															->get('transaksi_bank')->row();

		$data['pembelian_rmb10'] = $datapembelian->jumlah + ($rp100 * 100000) + $get_modal_rmb->jumlah;
		// $data['potongan_pembelian'] = $this->db->select('sum(jumlah_potongan) as jumlah')->where('tipe_potongan','beli')
		// 														  					 ->where('jumlah_potongan <',0)->get('potongan')->row();
		// Pengeluaran
		$data['pengeluaran'] = $this->db->select('sum(nominal_transaksi_bank) as jumlah,parent_jenis_transaksi.nama_parent,parent_jenis_transaksi.id_parent')
							->from('transaksi_bank')
							->join('jenis_transaksi_bank','transaksi_bank.id_jenis_transaksi_bank=jenis_transaksi_bank.id_jenis_transaksi_bank','left')
							->join('parent_jenis_transaksi','parent_jenis_transaksi.id_parent=jenis_transaksi_bank.id_parent','left')
							->where('tanggal_transaksi_bank >=',$daritanggal)
							->where('tanggal_transaksi_bank <=',$sampaitanggal)
							->where('jenis_transaksi_bank.id_jenis_transaksi_utama',1)
							->where('parent_jenis_transaksi.id_parent !=',"23")
							->where('tipe_transaksi_bank',"keluar")
							->group_by('parent_jenis_transaksi.id_parent')
							->get()->result();

		$data['total_pengeluaran'] = $this->db->select('sum(nominal_transaksi_bank) as jumlah')->from('transaksi_bank')
										->join('jenis_transaksi_bank','transaksi_bank.id_jenis_transaksi_bank=jenis_transaksi_bank.id_jenis_transaksi_bank','left')
										->where('tanggal_transaksi_bank >=',$daritanggal)
										->where('tanggal_transaksi_bank <=',$sampaitanggal)
										->where('id_parent !=',"23")
										->where('jenis_transaksi_bank.id_jenis_transaksi_utama',1)
										->where('tipe_transaksi_bank',"keluar")
										->get()->row();

		$data['total_dividen'] = $this->db->select('sum(nominal_transaksi_bank) as jumlah')->from('transaksi_bank')
																					->join('jenis_transaksi_bank','transaksi_bank.id_jenis_transaksi_bank=jenis_transaksi_bank.id_jenis_transaksi_bank','left')
																					->where('tanggal_transaksi_bank >=',$daritanggal)
																					->where('tanggal_transaksi_bank <=',$sampaitanggal)
																					->where('jenis_transaksi_bank.id_jenis_transaksi_utama',1)
																					->where('id_parent',"23")
																					->where('tipe_transaksi_bank',"keluar")
																					->get()->row();
		$data['status_filter'] = 2;
		$this->template->load('template','admin/laporan/laba_rugi',$data);
	}
	// Laporan Penjualan Super Admin sales
	function sales(){
		// echo "sasa"; die("oke");
		$data['now'] 				 = date('Y-m-d');
		$data['tanggal_now'] = date_indo($data['now']);
		if($this->session->userdata('level') == "sales" || $this->session->userdata('level') == "crm" || $this->session->userdata('level') == "saleso"){
			$data['data_sales']  = $this->db->group_start()
																		    ->where('level','sales')
																		    ->or_where('level','crm')
																				->or_where('level','saleso')
																	    ->group_end()
																			->where('nama_pengguna',$this->session->userdata('nama_pengguna'))
																			->get('pengguna')->result();
		}else if($this->session->userdata('level') == "spv"){
			$data['data_sales']  = $this->db->group_start()
																			  ->where('level','sales')
																		    ->or_where('level','crm')
																				->or_where('level','saleso')
																	    ->group_end()
																			->group_start()
																			  ->where('id_pengguna !=','14')
																		    ->where('id_pengguna !=','15')
																				->where('id_pengguna !=','16')
																	    ->group_end()
																			->where('status',1)
																			->get('pengguna')->result();
		}else{
			$data['data_sales']  = $this->db->group_start()
																		    ->where('level','sales')
																		    ->or_where('level','crm')
																				->or_where('level','saleso')
																	    ->group_end()
																			->where('status',1)
																			->get('pengguna')->result();
		}
		// print_r($data['data_sales']);die();
		$this->template->load('template','admin/laporan/sales',$data);
	}

	//Function Filter LAporan Super admin Sales
	function filter_sales(){
		// die("oke");
		$data['now'] = date('Y-m-d');
		$min = date('Y-m-d 00:00:00',strtotime($this->input->post('min_date')));
		$max = date('Y-m-d 23:59:59',strtotime($this->input->post('max_date')));
		$id_sales = $this->input->post('id_sales');
		// print_r($id_sales);die();
		if($this->session->userdata('level') == "sales" || $this->session->userdata('level') == "crm" || $this->session->userdata('level') == "saleso"){
			$data['data_sales']  = $this->db->group_start()
																		    ->where('level','sales')
																		    ->or_where('level','crm')
																				->or_where('level','saleso')
																	    ->group_end()
																			->where('nama_pengguna',$this->session->userdata('nama_pengguna'))
																			->get('pengguna')->result();
		}else{
			$data['data_sales']  = $this->db->group_start()
																		    ->where('level','sales')
																		    ->or_where('level','crm')
																				->or_where('level','saleso')
																	    ->group_end()
																			->get('pengguna')->result();
		}
		$data['id_sales'] = $id_sales;
		$data['total_cbm'] =  $this->Mlaporan->get_cbmfilter_sales($min,$max,$id_sales);
		$data['record_resi'] =  $this->Mlaporan->get_resifilter_sales($min,$max,$id_sales)->result();
		$data['record_sea'] =  $this->Mlaporan->get_invseafilter_sales($min,$max,$id_sales)->result();//print_r($data['record_resi']);die();
		$data['record_air'] =  $this->Mlaporan->get_airfilter_sales($min,$max,$id_sales)->result();
		$data['record_fcl'] =  $this->Mlaporan->get_fclfilter_sales($min,$max,$id_sales)->result();
		$data['record_trf'] =  $this->Mlaporan->get_trffilter_sales($min,$max,$id_sales)->result();
		$data['total_laba_sea'] =  $this->Mlaporan->get_laba_invseafilter_sales($min,$max,$id_sales);
		$data['total_laba_resi_udara'] =  $this->Mlaporan->get_laba_resi_udarafilter_sales($min,$max,$id_sales);
		$data['total_laba_fcl'] =  $this->Mlaporan->get_laba_fclfilter_sales($min,$max,$id_sales);
		$data['total_laba'] =  $this->Mlaporan->get_laba_ttfilter_sales($min,$max,$id_sales);
		$data['total_perkiraan_laba_resi'] =  $this->Mlaporan->get_laba_resifilter_sales($min,$max,$id_sales);
		// $data['total_asuransi'] =  $this->Mlaporan->total_asuransifilter_sales($min,$max,$id_sales);
		// $data['semua_komisi_barang'] =  $this->Mlaporan->komisi_barang_invfilter_sales($min,$max,$id_sales);
		// $data['semua_komisi_titip_trf'] =  $this->Mlaporan->komisi_trf_invfilter_sales($min,$max,$id_sales);
		// $data['pengeluaran_perkategori'] =  $this->Mlaporan->pengeluaran_invfilter_sales($min,$max,$id_sales);
		$data['min'] = date('Y-m-d ',strtotime($this->input->post('min_date')));
		$data['max'] = date('Y-m-d ',strtotime($this->input->post('max_date')));
		// $data['record_asuransi'] =  $this->Mlaporan->get_asrfilter($data['min'],$data['max'])->result();//print_r($data['record_asuransi']);die();
		$data['tanggal_now'] = "dari " .date_indo($data['min']). " sampai " . date_indo($data['max']);
		$this->template->load('template','admin/laporan/filter_sales',$data);
  }

	// Laporan Penjualan Super Admin sales
	function campaign(){
		// echo "sasa"; die("oke");
		$id = $this->uri->segment(4);
		$data['now'] 				 = date('Y-m-d');
		$data['tanggal_now'] = date_indo($data['now']);
		$data['data_campaign']  = $this->db->where('id_campaign',$id)->get('campaign')->row();
		$this->template->load('template','admin/laporan/campaign',$data);
	}

	//Function Filter Laporan Super admin Sales
	function filter_campaign(){
		// die("oke");
		$data['now'] = date('Y-m-d');
		$min = date('Y-m-d 00:00:00',strtotime($this->input->post('min_date')));
		$max = date('Y-m-d 23:59:59',strtotime($this->input->post('max_date')));
		$id_campaign = $this->input->post('id_campaign');
		// print_r($id_campaign);die();
		$data['id_campaign'] = $id_campaign;
		$data['data_campaign']  = $this->db->where('id_campaign',$id_campaign)->get('campaign')->row();
		$data['total_cbm'] =  $this->Mlaporan->get_cbmfilter_campaign($min,$max,$id_campaign);
		$data['record_resi'] =  $this->Mlaporan->get_resifilter_campaign($min,$max,$id_campaign)->result();
		$data['record_sea'] =  $this->Mlaporan->get_invseafilter_campaign($min,$max,$id_campaign)->result();//print_r($data['record_resi']);die();
		$data['record_air'] =  $this->Mlaporan->get_airfilter_campaign($min,$max,$id_campaign)->result();
		$data['record_fcl'] =  $this->Mlaporan->get_fclfilter_campaign($min,$max,$id_campaign)->result();
		$data['record_trf'] =  $this->Mlaporan->get_trffilter_campaign($min,$max,$id_campaign)->result();
		$data['total_laba_sea'] =  $this->Mlaporan->get_laba_invseafilter_campaign($min,$max,$id_campaign);
		$data['total_laba_resi_udara'] =  $this->Mlaporan->get_laba_resi_udarafilter_campaign($min,$max,$id_campaign);
		$data['total_laba_fcl'] =  $this->Mlaporan->get_laba_fclfilter_campaign($min,$max,$id_campaign);
		$data['total_laba'] =  $this->Mlaporan->get_laba_ttfilter_campaign($min,$max,$id_campaign);
		$data['total_perkiraan_laba_resi'] =  $this->Mlaporan->get_laba_resifilter_campaign($min,$max,$id_campaign);
		// $data['total_asuransi'] =  $this->Mlaporan->total_asuransifilter_sales($min,$max,$id_campaign);
		// $data['semua_komisi_barang'] =  $this->Mlaporan->komisi_barang_invfilter_sales($min,$max,$id_campaign);
		// $data['semua_komisi_titip_trf'] =  $this->Mlaporan->komisi_trf_invfilter_sales($min,$max,$id_campaign);
		// $data['pengeluaran_perkategori'] =  $this->Mlaporan->pengeluaran_invfilter_sales($min,$max,$id_campaign);
		$data['min'] = date('Y-m-d ',strtotime($this->input->post('min_date')));
		$data['max'] = date('Y-m-d ',strtotime($this->input->post('max_date')));
		// $data['record_asuransi'] =  $this->Mlaporan->get_asrfilter($data['min'],$data['max'])->result();//print_r($data['record_asuransi']);die();
		$data['tanggal_now'] = "dari " .date_indo($data['min']). " sampai " . date_indo($data['max']);
		$this->template->load('template','admin/laporan/filter_campaign',$data);
  }

	//Function Laporan Transaksi Resi
	function customer(){
		$rentang_waktu        = $this->uri->segment(4);
		if($rentang_waktu == 30){
			$now				 				  = date('Y-m-d');
			$tanggal_sebelumnya  = date('Y-m-d', strtotime('-30 days', strtotime($now)));
			$data['customer'] 		= $this->db->query('SELECT customer.* FROM `customer` left join resi on resi.cust_id = customer.id_cust left join resi_udara on resi_udara.id_cust = customer.id_cust
																							left join transaksi on transaksi.id_cust = customer.id_cust
																							where  (resi.id_resi is not null or resi_udara.id_resi_udara is not null or transaksi.id_transaksi is not null) and
																							((resi.tanggal < "'.$now.'" and resi.tanggal > "'.$tanggal_sebelumnya.'") or (resi_udara.tanggal_resi < "'.$now.'"
																							and resi_udara.tanggal_resi > "'.$tanggal_sebelumnya.'") or (transaksi.tanggal_transaksi < "'.$now.'" and transaksi.tanggal_transaksi > "'.$tanggal_sebelumnya.'"))
																							group by customer.id_cust')->result();
			$data['tempo'] = " 30 hari Ke belakang";
		}else if($rentang_waktu == 60){
			$now				 				  = date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d'))));
			$tanggal_sebelumnya   = date('Y-m-d', strtotime('-60 days', strtotime($now)));
			$data['customer'] 		= $this->db->query('SELECT customer.* FROM `customer` left join resi on resi.cust_id = customer.id_cust left join resi_udara on resi_udara.id_cust = customer.id_cust
																							left join transaksi on transaksi.id_cust = customer.id_cust
																							where  (resi.id_resi is not null or resi_udara.id_resi_udara is not null or transaksi.id_transaksi is not null) and
																							 ((resi.tanggal < "'.$now.'" and resi.tanggal > "'.$tanggal_sebelumnya.'") or (resi_udara.tanggal_resi < "'.$now.'" and resi_udara.tanggal_resi > "'.$tanggal_sebelumnya.'") or (transaksi.tanggal_transaksi < "'.$now.'" and transaksi.tanggal_transaksi > "'.$tanggal_sebelumnya.'")) group by customer.id_cust')->result();
			$data['tempo'] = " 30 - 60 hari ke belakang";
		}else if($rentang_waktu == 90){
			$now				 				  = date('Y-m-d', strtotime('-60 days', strtotime(date('Y-m-d'))));
			$tanggal_sebelumnya   = date('Y-m-d', strtotime('-90 days', strtotime($now)));
			$data['customer'] 		= $this->db->query('SELECT customer.* FROM `customer` left join resi on resi.cust_id = customer.id_cust left join resi_udara on resi_udara.id_cust = customer.id_cust
																							left join transaksi on transaksi.id_cust = customer.id_cust
																							where  (resi.id_resi is not null or resi_udara.id_resi_udara is not null or transaksi.id_transaksi is not null) and
																							 ((resi.tanggal < "'.$now.'" and resi.tanggal > "'.$tanggal_sebelumnya.'") or (resi_udara.tanggal_resi < "'.$now.'" and resi_udara.tanggal_resi > "'.$tanggal_sebelumnya.'") or (transaksi.tanggal_transaksi < "'.$now.'" and transaksi.tanggal_transaksi > "'.$tanggal_sebelumnya.'")) group by customer.id_cust')->result();
			$data['tempo'] = " 60 - 90 hari ke belakang";
		}else if($rentang_waktu == "lebih90"){
			// die("oke");
			$tanggal   									= date('Y-m-d', strtotime('-90 days', strtotime(date('Y-m-d'))));
			$data['customer'] 		= $this->db->query('SELECT customer.* FROM `customer` left join resi on resi.cust_id = customer.id_cust left join resi_udara on resi_udara.id_cust = customer.id_cust
																							left join transaksi on transaksi.id_cust = customer.id_cust
																							where  (resi.id_resi is not null or resi_udara.id_resi_udara is not null or transaksi.id_transaksi is not null) and
																							 ((resi.tanggal < "'.$tanggal.'") or (resi_udara.tanggal_resi < "'.$tanggal.'") or (transaksi.tanggal_transaksi < "'.$tanggal.'")) group by customer.id_cust')->result();
			$data['tempo'] = " > 90 hari";
		}else if($rentang_waktu == "tidak_pernah"){
			$data['customer'] 		= $this->db->query('SELECT customer.* FROM `customer` left join resi on resi.cust_id = customer.id_cust left join resi_udara on resi_udara.id_cust = customer.id_cust
																							left join transaksi on transaksi.id_cust = customer.id_cust
																							where resi.id_resi is null and resi_udara.id_resi_udara is null and transaksi.id_transaksi is null
																							group by customer.id_cust')->result();
			$data['tempo'] = " Tidak pernah import dan transaksi titip transfer";
		}
		// print_r($this->db->last_query());die();
		$this->template->load('template','admin/laporan/customer',$data);
	}

	function giw(){
		// giw by customer
		$data['giwcustomer'] = $this->db->select('jenis_barang.namalain,customer.kode,giw.*,sum(giw.ctns*giw.volume) as total_volume')->from('giw')->join('customer','giw.customer_id=customer.id_cust','left')
													 ->join('resi','giw.resi_id=resi.id_resi','left')->join('jenis_barang','giw.jenis_barang_id=jenis_barang.id','left')
													 ->where('resi.tanggal',date('Y-m-d'))->group_by('customer.id_cust')->order_by('customer.kode','asc')->get()->result();
		// giw by kategori
		$data['giwkategori'] = $this->db->select('jenis_barang.namalain,giw.*,sum(giw.ctns*giw.volume) as total_volume')->from('giw')->join('jenis_barang','giw.jenis_barang_id=jenis_barang.id','left')
													 ->join('resi','giw.resi_id=resi.id_resi','left')->where('resi.tanggal',date('Y-m-d'))->group_by('giw.jenis_barang_id')
													 ->order_by('jenis_barang.namalain','asc')->get()->result();
		// tempo
		$data['tempo']  = date_indo(date('Y-m-d'));
		$this->template->load('template','admin/laporan/giw',$data);
	}

	function sortgiw(){
		$mindate = date('Y-m-d',strtotime($this->input->post('min_date')));
		$maxdate = date('Y-m-d',strtotime($this->input->post('max_date')));
		// giw by customer
		$data['giwcustomer'] = $this->db->select('jenis_barang.namalain,customer.kode,giw.*,sum(giw.ctns*giw.volume) as total_volume')->from('giw')->join('customer','giw.customer_id=customer.id_cust','left')
													 ->join('resi','giw.resi_id=resi.id_resi','left')->join('jenis_barang','giw.jenis_barang_id=jenis_barang.id','left')
													 ->where('resi.tanggal >=',$mindate)->where('resi.tanggal <=',$maxdate)->group_by('customer.id_cust')->order_by('customer.kode','asc')->get()->result();
		// giw by kategori
		$data['giwkategori'] = $this->db->select('jenis_barang.namalain,giw.*,sum(giw.ctns*giw.volume) as total_volume')->from('giw')->join('jenis_barang','giw.jenis_barang_id=jenis_barang.id','left')
													 ->join('resi','giw.resi_id=resi.id_resi','left')->where('resi.tanggal >=',$mindate)->where('resi.tanggal <=',$maxdate)->group_by('giw.jenis_barang_id')
													 ->order_by('jenis_barang.namalain','asc')->get()->result();
		// tempo
		$data['tempo']  = date_indo($mindate)." - ".date_indo($maxdate);
		$this->template->load('template','admin/laporan/giw',$data);
	}

	function customer_pertahun(){
		$awal = "01-01-".date('Y');
		$akhir = "31-12-".date('Y');
		// $data['customer'] = $this->db->select('customer.id_cust,customer.kode')
		// 														 ->from('customer')
		// 														 ->join('resi','resi.cust_id=customer.id_cust','left')
		// 														 ->where('resi.id_resi is not null',null,false)
		// 														 ->order_by('resi.tanggal','desc')
		// 														 ->group_by('id_cust')
		// 														 ->get()->result();
																 // print_r($data['customer']);die();
		$data['customer'] =  $this->db->query('SELECT kode,id_cust from (SELECT customer.id_cust,customer.kode,resi.id_resi,max(resi.tanggal) as tanggal_resi FROM `customer` left join resi on resi.cust_id = customer.id_cust
										 																							where resi.id_resi is not null
																																	group by id_cust
										 																							-- order by resi.id_resi desc
																																	-- order by resi.tanggal desc
																																) as r order by tanggal_resi desc ,kode asc')->result();//print_r($data['customer']);die();
		$this->template->load('template','admin/laporan/customer_pertahun',$data);
	}

	//Function Halaman kelas import
	function kelasimport(){
		$this->template->load('template','admin/laporan/kelasimport');
	}

	//Function Get data Json kelas import
 	function json_kelasimport() {
		header('Content-Type: application/json');
		echo $this->Mlaporan->get_kelasimport();
  	}

}
