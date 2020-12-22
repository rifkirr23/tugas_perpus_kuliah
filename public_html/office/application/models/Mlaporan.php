<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mlaporan extends CI_Model {

	public function __construct(){
		parent::__construct();
		// die("oke");
	}
	//Proses Get Data Json Titip Transfer
	function titip_transfer_json() {
		$tanggal  = date('Y-m-d '.'00:'.'00:'.'00');
    $this->datatables->select('transaksi.id_transaksi,transaksi.id_cust,transaksi.id_cgrup,transaksi.kode_transaksi,transaksi.tanggal_transaksi,
                               transaksi.jumlah_rmb,transaksi.kurs_jual,transaksi.kurs_beli,transaksi.bank_tujuan,transaksi.file_bank_tujuan,transaksi.status,
                               transaksi.input_name,transaksi.fee_bank,transaksi.fee_cs,transaksi.kurs_beli2,transaksi.jumlah_rmb2,
															 customer.kode,invoice.kode_invoice,customer_grup.kode_cgrup,customer.id_referal');
    $this->datatables->from('transaksi');
    $this->datatables->join('customer', 'transaksi.id_cust=customer.id_cust');
    $this->datatables->join('customer_grup', 'transaksi.id_cgrup=customer_grup.id_cgrup');
    $this->datatables->join('invoice', 'transaksi.id_invoice=invoice.id_invoice');
		$this->datatables->where('(status=2 OR status=4 OR status=3)', null ,FALSE);
		$this->datatables->where('transaksi.tanggal_transaksi >=',$tanggal);
		$this->db->order_by('transaksi.id_transaksi','desc');
    $this->datatables->add_column('mark_transaksi', '$1','kode_mark_transaksi(id_cust,id_cgrup,kode,kode_cgrup)');
    $this->datatables->add_column('laba_titip_transfer', '$1','laba_titip_transfer(jumlah_rmb,jumlah_rmb2,fee_cs,fee_bank,kurs_beli2,kurs_beli,kurs_jual)');
		// $this->datatables->add_column('komisi_trf', '$1','komisi_trf(jumlah_rmb,jumlah_rmb2,id_referal)');

    return $this->datatables->generate();
  }

	function get_trffilter($min,$max) {
    $this->db->select('transaksi.*,customer.*,customer_grup.*,invoice.*');
    $this->db->from('transaksi');
    $this->db->join('customer', 'transaksi.id_cust=customer.id_cust');
    $this->db->join('customer_grup', 'transaksi.id_cgrup=customer_grup.id_cgrup');
    $this->db->join('invoice', 'transaksi.id_invoice=invoice.id_invoice');
		$this->db->where('(status=2 OR status=4 OR status=3)', null ,FALSE);
		$this->db->where('transaksi.tanggal_transaksi >=',$min);
		$this->db->where('transaksi.tanggal_transaksi <=',$max);
		$this->db->order_by('transaksi.id_transaksi','desc');
    // $this->db->add_column('mark_transaksi', '$1','kode_mark_transaksi(id_cust,id_cgrup,kode,kode_cgrup)');
    // $this->db->add_column('laba_titip_transfer', '$1','laba_titip_transfer(jumlah_rmb,jumlah_rmb2,fee_cs,fee_bank,kurs_beli2,kurs_beli,kurs_jual)');

    return $this->db->get();
  }

	function get_trffilter_sales($min,$max,$idsales) {
		$getpengguna = $this->db->where('id_pengguna',$idsales)->get('pengguna')->row();
		if($getpengguna->level == "sales" || $getpengguna->level == "saleso"){
			$this->db->select('transaksi.*,customer.*,customer_grup.*,invoice.*');
	    $this->db->from('transaksi');
	    $this->db->join('customer', 'transaksi.id_cust=customer.id_cust');
	    $this->db->join('customer_grup', 'transaksi.id_cgrup=customer_grup.id_cgrup');
	    $this->db->join('invoice', 'transaksi.id_invoice=invoice.id_invoice');
			$this->db->where('(status=2 OR status=4 OR status=3)', null ,FALSE);
			$this->db->where('transaksi.tanggal_transaksi >=',$min);
			$this->db->where('transaksi.tanggal_transaksi <=',$max);
			$this->db->where('customer.id_pendaftar',$idsales);
			$this->db->order_by('transaksi.id_transaksi','desc');
	    // $this->db->add_column('mark_transaksi', '$1','kode_mark_transaksi(id_cust,id_cgrup,kode,kode_cgrup)');
	    // $this->db->add_column('laba_titip_transfer', '$1','laba_titip_transfer(jumlah_rmb,jumlah_rmb2,fee_cs,fee_bank,kurs_beli2,kurs_beli,kurs_jual)');
		}elseif($getpengguna->level == "crm"){
	    $this->db->select('transaksi.*,customer.*,customer_grup.*,invoice.*');
	    $this->db->from('transaksi');
	    $this->db->join('customer', 'transaksi.id_cust=customer.id_cust');
	    $this->db->join('customer_grup', 'transaksi.id_cgrup=customer_grup.id_cgrup');
	    $this->db->join('invoice', 'transaksi.id_invoice=invoice.id_invoice');
			$this->db->where('(status=2 OR status=4 OR status=3)', null ,FALSE);
			$this->db->where('transaksi.tanggal_transaksi >=',$min);
			$this->db->where('transaksi.tanggal_transaksi <=',$max);
			$this->db->where('customer.id_crm',$idsales);
			$this->db->order_by('transaksi.id_transaksi','desc');
	    // $this->db->add_column('mark_transaksi', '$1','kode_mark_transaksi(id_cust,id_cgrup,kode,kode_cgrup)');
	    // $this->db->add_column('laba_titip_transfer', '$1','laba_titip_transfer(jumlah_rmb,jumlah_rmb2,fee_cs,fee_bank,kurs_beli2,kurs_beli,kurs_jual)');
	 }
    return $this->db->get();
  }

	function get_trffilter_campaign($min,$max,$idcampaign) {
    $this->db->select('transaksi.*,customer.*,customer_grup.*,invoice.*');
    $this->db->from('transaksi');
    $this->db->join('customer', 'transaksi.id_cust=customer.id_cust');
    $this->db->join('customer_grup', 'transaksi.id_cgrup=customer_grup.id_cgrup');
    $this->db->join('invoice', 'transaksi.id_invoice=invoice.id_invoice');
		$this->db->where('(status=2 OR status=4 OR status=3)', null ,FALSE);
		$this->db->where('transaksi.tanggal_transaksi >=',$min);
		$this->db->where('transaksi.tanggal_transaksi <=',$max);
		$this->db->where('customer.id_campaign',$idcampaign);
		$this->db->order_by('transaksi.id_transaksi','desc');
    // $this->db->add_column('mark_transaksi', '$1','kode_mark_transaksi(id_cust,id_cgrup,kode,kode_cgrup)');
    // $this->db->add_column('laba_titip_transfer', '$1','laba_titip_transfer(jumlah_rmb,jumlah_rmb2,fee_cs,fee_bank,kurs_beli2,kurs_beli,kurs_jual)');

    return $this->db->get();
  }

	function get_trf() {
    $this->db->select('transaksi.*,customer.*,customer_grup.*,invoice.*');
    $this->db->from('transaksi');
    $this->db->join('customer', 'transaksi.id_cust=customer.id_cust');
    $this->db->join('customer_grup', 'transaksi.id_cgrup=customer_grup.id_cgrup');
    $this->db->join('invoice', 'transaksi.id_invoice=invoice.id_invoice');
		$this->db->where('(status=2 OR status=4 OR status=3)', null ,FALSE);
		$this->db->where('transaksi.tanggal_transaksi >=',date('Y-m-d '.'00:'.'00:'.'00'));
		$this->db->order_by('transaksi.id_transaksi','desc');
    // $this->db->add_column('mark_transaksi', '$1','kode_mark_transaksi(id_cust,id_cgrup,kode,kode_cgrup)');
    // $this->db->add_column('laba_titip_transfer', '$1','laba_titip_transfer(jumlah_rmb,jumlah_rmb2,fee_cs,fee_bank,kurs_beli2,kurs_beli,kurs_jual)');

    return $this->db->get();
  }
	// Get Laba Titip Transfer
	function get_laba_tt(){
		$tanggal  = date('Y-m-d '.'00:'.'00:'.'00');
		$getlaba = $this->db->select('transaksi.id_transaksi,transaksi.id_cust,transaksi.id_cgrup,transaksi.kode_transaksi,transaksi.tanggal_transaksi,
                               transaksi.jumlah_rmb,transaksi.kurs_jual,transaksi.kurs_beli,transaksi.bank_tujuan,transaksi.file_bank_tujuan,transaksi.status,
                               transaksi.input_name,transaksi.fee_bank,transaksi.fee_cs,transaksi.kurs_beli2,transaksi.jumlah_rmb2,customer.kode,invoice.kode_invoice,customer_grup.kode_cgrup')
    					->from('transaksi')
    				  ->join('customer', 'transaksi.id_cust=customer.id_cust')
		    		  ->join('customer_grup', 'customer.id_cgrup=customer_grup.id_cgrup')
		    		  ->join('invoice', 'transaksi.id_invoice=invoice.id_invoice')
						  ->where('(status=2 OR status=4 OR status=3)', null ,FALSE)
							->where('transaksi.tanggal_transaksi >=',$tanggal)
						  ->get()->result();

		$return = 0;
		foreach($getlaba as $rowlaba){
			$jual = ($rowlaba->jumlah_rmb+$rowlaba->fee_cs+$rowlaba->jumlah_rmb2) * $rowlaba->kurs_jual;
			if($rowlaba->jumlah_rmb2 != 0){
	      $beli = ($rowlaba->jumlah_rmb * $rowlaba->kurs_beli) + ($rowlaba->jumlah_rmb2 * $rowlaba->kurs_beli2) + ($rowlaba->fee_cs * $rowlaba->kurs_beli2);
	    }else if($rowlaba->jumlah_rmb2 == 0 && $rowlaba->kurs_beli2 != 0){
	      $beli = ($rowlaba->jumlah_rmb * $rowlaba->kurs_beli) + ($rowlaba->rowlaba->jumlah_rmb2 * $rowlaba->kurs_beli2) + ($rowlaba->fee_cs * $rowlaba->kurs_beli2);
	    }else{
	      $beli = ($rowlaba->jumlah_rmb+$rowlaba->fee_cs+$rowlaba->fee_bank) * $rowlaba->kurs_beli;
	    }
			$return += $jual - $beli;
		}

		return $return;
	}

	// Get Laba Titip Transfer Filter
	function get_laba_ttfilter($min,$max){

		$getlaba = $this->db->select('transaksi.id_transaksi,transaksi.id_cust,transaksi.id_cgrup,transaksi.kode_transaksi,transaksi.tanggal_transaksi,
                               transaksi.jumlah_rmb,transaksi.kurs_jual,transaksi.kurs_beli,transaksi.bank_tujuan,transaksi.file_bank_tujuan,transaksi.status,
                               transaksi.input_name,transaksi.fee_bank,transaksi.fee_cs,transaksi.kurs_beli2,transaksi.jumlah_rmb2,customer.kode,invoice.kode_invoice,customer_grup.kode_cgrup')
    					->from('transaksi')
    				  ->join('customer', 'transaksi.id_cust=customer.id_cust')
		    		  ->join('customer_grup', 'transaksi.id_cgrup=customer_grup.id_cgrup')
		    		  ->join('invoice', 'transaksi.id_invoice=invoice.id_invoice')
						  ->where('(status=2 OR status=4 OR status=3)', null ,FALSE)
							->where('transaksi.tanggal_transaksi >=',$min)
							->where('transaksi.tanggal_transaksi <=',$max)
						  ->get()->result();

		$return = 0;
		foreach($getlaba as $rowlaba){
			$jual = ($rowlaba->jumlah_rmb+$rowlaba->fee_cs+$rowlaba->jumlah_rmb2) * $rowlaba->kurs_jual;
			if($rowlaba->jumlah_rmb2 != 0){
	      $beli = ($rowlaba->jumlah_rmb * $rowlaba->kurs_beli) + ($rowlaba->jumlah_rmb2 * $rowlaba->kurs_beli2) + ($rowlaba->fee_cs * $rowlaba->kurs_beli2);
	    }else if($rowlaba->jumlah_rmb2 == 0 && $rowlaba->kurs_beli2 != 0){
	      $beli = ($rowlaba->jumlah_rmb * $rowlaba->kurs_beli) + ($rowlaba->rowlaba->jumlah_rmb2 * $rowlaba->kurs_beli2) + ($rowlaba->fee_cs * $rowlaba->kurs_beli2);
	    }else{
	      $beli = ($rowlaba->jumlah_rmb+$rowlaba->fee_cs+$rowlaba->fee_bank) * $rowlaba->kurs_beli;
	    }
			$return += $jual - $beli;
		}

		return $return;
	}

	function get_laba_ttfilter_sales($min,$max,$idsales){
		$getpengguna = $this->db->where('id_pengguna',$idsales)->get('pengguna')->row();
		if($getpengguna->level == "sales" || $getpengguna->level == "saleso"){
			$getlaba = $this->db->select('transaksi.id_transaksi,transaksi.id_cust,transaksi.id_cgrup,transaksi.kode_transaksi,transaksi.tanggal_transaksi,
	                               transaksi.jumlah_rmb,transaksi.kurs_jual,transaksi.kurs_beli,transaksi.bank_tujuan,transaksi.file_bank_tujuan,transaksi.status,
	                               transaksi.input_name,transaksi.fee_bank,transaksi.fee_cs,transaksi.kurs_beli2,transaksi.jumlah_rmb2,customer.kode,invoice.kode_invoice,customer_grup.kode_cgrup')
	    					->from('transaksi')
	    				  ->join('customer', 'transaksi.id_cust=customer.id_cust')
			    		  ->join('customer_grup', 'transaksi.id_cgrup=customer_grup.id_cgrup')
			    		  ->join('invoice', 'transaksi.id_invoice=invoice.id_invoice')
								->where('customer.id_pendaftar',$idsales)
							  ->where('(status=2 OR status=4 OR status=3)', null ,FALSE)
								->where('transaksi.tanggal_transaksi >=',$min)
								->where('transaksi.tanggal_transaksi <=',$max)
							  ->get()->result();
		}elseif($getpengguna->level == "crm"){
			$getlaba = $this->db->select('transaksi.id_transaksi,transaksi.id_cust,transaksi.id_cgrup,transaksi.kode_transaksi,transaksi.tanggal_transaksi,
	                               transaksi.jumlah_rmb,transaksi.kurs_jual,transaksi.kurs_beli,transaksi.bank_tujuan,transaksi.file_bank_tujuan,transaksi.status,
	                               transaksi.input_name,transaksi.fee_bank,transaksi.fee_cs,transaksi.kurs_beli2,transaksi.jumlah_rmb2,customer.kode,invoice.kode_invoice,customer_grup.kode_cgrup')
	    					->from('transaksi')
	    				  ->join('customer', 'transaksi.id_cust=customer.id_cust')
			    		  ->join('customer_grup', 'transaksi.id_cgrup=customer_grup.id_cgrup')
			    		  ->join('invoice', 'transaksi.id_invoice=invoice.id_invoice')
								->where('customer.id_crm',$idsales)
							  ->where('(status=2 OR status=4 OR status=3)', null ,FALSE)
								->where('transaksi.tanggal_transaksi >=',$min)
								->where('transaksi.tanggal_transaksi <=',$max)
							  ->get()->result();
		}

		$return = 0;
		foreach($getlaba as $rowlaba){
			$jual = ($rowlaba->jumlah_rmb+$rowlaba->fee_cs+$rowlaba->jumlah_rmb2) * $rowlaba->kurs_jual;
			if($rowlaba->jumlah_rmb2 != 0){
	      $beli = ($rowlaba->jumlah_rmb * $rowlaba->kurs_beli) + ($rowlaba->jumlah_rmb2 * $rowlaba->kurs_beli2) + ($rowlaba->fee_cs * $rowlaba->kurs_beli2);
	    }else if($rowlaba->jumlah_rmb2 == 0 && $rowlaba->kurs_beli2 != 0){
	      $beli = ($rowlaba->jumlah_rmb * $rowlaba->kurs_beli) + ($rowlaba->rowlaba->jumlah_rmb2 * $rowlaba->kurs_beli2) + ($rowlaba->fee_cs * $rowlaba->kurs_beli2);
	    }else{
	      $beli = ($rowlaba->jumlah_rmb+$rowlaba->fee_cs+$rowlaba->fee_bank) * $rowlaba->kurs_beli;
	    }
			$return += $jual - $beli;
		}

		return $return;
	}

	function get_laba_ttfilter_campaign($min,$max,$idcampaign){

		$getlaba = $this->db->select('transaksi.id_transaksi,transaksi.id_cust,transaksi.id_cgrup,transaksi.kode_transaksi,transaksi.tanggal_transaksi,
                               transaksi.jumlah_rmb,transaksi.kurs_jual,transaksi.kurs_beli,transaksi.bank_tujuan,transaksi.file_bank_tujuan,transaksi.status,
                               transaksi.input_name,transaksi.fee_bank,transaksi.fee_cs,transaksi.kurs_beli2,transaksi.jumlah_rmb2,customer.kode,invoice.kode_invoice,customer_grup.kode_cgrup')
    					->from('transaksi')
    				  ->join('customer', 'transaksi.id_cust=customer.id_cust')
		    		  ->join('customer_grup', 'transaksi.id_cgrup=customer_grup.id_cgrup')
		    		  ->join('invoice', 'transaksi.id_invoice=invoice.id_invoice')
							->where('customer.id_pendaftar',$idcampaign)
						  ->where('(status=2 OR status=4 OR status=3)', null ,FALSE)
							->where('transaksi.tanggal_transaksi >=',$min)
							->where('transaksi.tanggal_transaksi <=',$max)
						  ->get()->result();

		$return = 0;
		foreach($getlaba as $rowlaba){
			$jual = ($rowlaba->jumlah_rmb+$rowlaba->fee_cs+$rowlaba->jumlah_rmb2) * $rowlaba->kurs_jual;
			if($rowlaba->jumlah_rmb2 != 0){
	      $beli = ($rowlaba->jumlah_rmb * $rowlaba->kurs_beli) + ($rowlaba->jumlah_rmb2 * $rowlaba->kurs_beli2) + ($rowlaba->fee_cs * $rowlaba->kurs_beli2);
	    }else if($rowlaba->jumlah_rmb2 == 0 && $rowlaba->kurs_beli2 != 0){
	      $beli = ($rowlaba->jumlah_rmb * $rowlaba->kurs_beli) + ($rowlaba->rowlaba->jumlah_rmb2 * $rowlaba->kurs_beli2) + ($rowlaba->fee_cs * $rowlaba->kurs_beli2);
	    }else{
	      $beli = ($rowlaba->jumlah_rmb+$rowlaba->fee_cs+$rowlaba->fee_bank) * $rowlaba->kurs_beli;
	    }
			$return += $jual - $beli;
		}

		return $return;
	}

	//Proses Get Data Json Asuransi
	function asuransi_json($min,$max) {
		$tanggal  = date('Y-m-d '.'00:'.'00:'.'00');

    $this->datatables->select('invoice_asuransi.id_invoice_asuransi,invoice_asuransi.tanggal_inv_asuransi,invoice_asuransi.jumlah_asuransi,
															 invoice_asuransi.note,resi.nomor as nomor_resi,customer.kode,invoice.kode_invoice');
    $this->datatables->from('invoice_asuransi');
    $this->datatables->join('customer', 'invoice_asuransi.id_cust=customer.id_cust');
    $this->datatables->join('resi', 'resi.id_resi=invoice_asuransi.id_resi');
    $this->datatables->join('invoice', 'invoice_asuransi.id_invoice=invoice.id_invoice');
		$this->db->order_by('invoice_asuransi.id_invoice_asuransi','desc');
		$this->datatables->where('invoice_asuransi.tanggal_inv_asuransi >=',$tanggal);

    return $this->datatables->generate();
  }

	//Proses Get Data Asuransi
	function get_asrfilter($min,$max) {
    $this->db->select('invoice_asuransi.id_invoice_asuransi,invoice_asuransi.tanggal_inv_asuransi,invoice_asuransi.jumlah_asuransi,
															 invoice_asuransi.note,resi.nomor as nomor_resi,customer.kode,invoice.kode_invoice');
    $this->db->from('invoice_asuransi');
    $this->db->join('customer', 'invoice_asuransi.id_cust=customer.id_cust');
    $this->db->join('resi', 'resi.id_resi=invoice_asuransi.id_resi');
    $this->db->join('invoice', 'invoice_asuransi.id_invoice=invoice.id_invoice');
		$this->db->order_by('invoice_asuransi.id_invoice_asuransi','desc');
		$this->db->where('invoice_asuransi.tanggal_inv_asuransi >=',$min);
		$this->db->where('invoice_asuransi.tanggal_inv_asuransi <=',$max);

    return $this->db->get();
  }

	// Get Total Asuransi
	function total_asuransi(){
		$tanggal  = date('Y-m-d '.'00:'.'00:'.'00');
		$getasuransi = $this->db->select('sum(jumlah_asuransi) as total')
    					->from('invoice_asuransi')
							->where('invoice_asuransi.tanggal_inv_asuransi >=',$tanggal)
						  ->get()->row();

		$return = $getasuransi->total;

		return $return;
	}

	// Get Laba Asuransi Filter
	function total_asuransifilter($min,$max){
		$min1  = date($min.' 00:'.'00:'.'00');
		$max1  = date($max.' 23:'.'59:'.'59');
		$getasuransi = $this->db->select('sum(jumlah_asuransi) as total')
    					->from('invoice_asuransi')
							->where('invoice_asuransi.tanggal_inv_asuransi >=',$min)
							->where('invoice_asuransi.tanggal_inv_asuransi <=',$max)
						  ->get()->row();
		$return = $getasuransi->total;
		return $return;
	}


	// get data resi today
	function get_resi() {
    return $this->db->select('resi.*,customer.*')
			    					->from('resi')
			    					->join('customer', 'resi.cust_id=customer.id_cust')
										->where('resi.tanggal >=',date('Y-m-d '.'00:'.'00:'.'00'))
										->order_by('resi.id_resi','desc')
										->get();
  }

	// get data resi air today
	function get_invsea() {
		$tanggal = date('Y-m-d');
    return $this->db->select('invoice.*,invoice_beli.*,customer.*')
			    					->from('invoice')
										->join('customer', 'invoice.id_cust=customer.id_cust')
										->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
										->where('invoice.tipe_invoice','barang')
										->where('invoice.tanggal_invoice',$tanggal)
										->order_by('invoice.id_invoice','desc')
										->get();
  }

	// get data resi air today
	function get_fcl() {
    return $this->db->select('invoice.*,invoice_beli.*,customer.*')
			    					->from('invoice')
										->join('customer', 'invoice.id_cust=customer.id_cust')
										->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
										->where('invoice.tipe_invoice','lainnya')
										->where('invoice.tanggal_invoice >=',date('Y-m-d '.'00:'.'00:'.'00'))
										->order_by('invoice.id_invoice','desc')
										->get();
  }

	function get_laba_fcl(){
		$laba = $this->db->select('sum(invoice.total_tagihan) as jual,sum(invoice_beli.jumlah_invoice_beli) as beli')
										->from('invoice')
										->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
										->where('invoice.tipe_invoice','lainnya')
										->where('invoice.tanggal_invoice >=',date('Y-m-d '.'00:'.'00:'.'00'))
										->get()->row();
		return $laba->jual - $laba->beli;
	}

	function get_laba_invsea(){
		$tanggal = date('Y-m-d');
		$laba = $this->db->select('sum(invoice.total_tagihan) as jual,sum(invoice_beli.jumlah_invoice_beli) as beli')
										->from('invoice')
										->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
										->where('invoice.tipe_invoice','barang')
										->where('invoice.tanggal_invoice',$tanggal)
										->get()->row();
		return $laba->jual - $laba->beli;
	}

	// get data resi air today
	function get_air() {
    return $this->db->select('invoice.*,customer.*,resi_udara.*,invoice_beli.*')
			    					->from('invoice')
			    					->join('customer', 'invoice.id_cust=customer.id_cust')
										->join('resi_udara', 'invoice.id_invoice=resi_udara.id_invoice')
										->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
										->where('invoice.tipe_invoice','air')
										->where('invoice.tanggal_invoice >=',date('Y-m-d '.'00:'.'00:'.'00'))
										->order_by('invoice.id_invoice','desc')
										->get();
  }

	function get_laba_resi_udara(){
		$laba = $this->db->select('sum(invoice.total_tagihan) as jual,sum(invoice_beli.jumlah_invoice_beli) as beli')
										->from('invoice')
										->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
										->where('invoice.tipe_invoice','air')
										->where('invoice.tanggal_invoice >=',date('Y-m-d '.'00:'.'00:'.'00'))
										->get()->row();
		return $laba->jual - $laba->beli;
	}

	// Get Laba Import Barang per Resi
	function get_laba_resi(){
		$tanggal = date('Y-m-d');
    $getresi = $this->db->select('resi.*,customer.*')
			    					->from('resi')
			    					->join('customer', 'resi.cust_id=customer.id_cust')
										->where('resi.tanggal >=',date('Y-m-d '.'00:'.'00:'.'00'))
										->order_by('resi.id_resi','desc')
										->get()->result();
		$totallaba = 0;
		foreach($getresi as $rr){
			// row Total Jual
			$total  = 0;
			$jumlah = 0;
			$resijual = $this->db->select('giw.status_berat,giw.jenis_barang_id,giw.ctns as jumlah,giw.kurs,giw.volume,giw.berat,giw.qty,giw.nilai,giw.harga_jual')
														->from('giw')
														->join('resi', 'resi.id_resi=giw.resi_id', 'left')
														->where('giw.resi_id',$rr->id_resi)
														->get()->result();
			foreach ($resijual as $ils ) {
				include APPPATH. 'helpers/harga.php';
				$total_jual = $total ;
			}
			$total  = 0;
			$jumlah = 0;
			// row Total Beli
			$beliresi = $this->db->select('giw.status_berat,giw.jenis_barang_id,giw.ctns as jumlah,giw.kurs,giw.volume,giw.berat,giw.qty,giw.nilai,giw.harga as harga_jual')
														->from('giw')
														->join('resi', 'resi.id_resi=giw.resi_id', 'left')
														->where('giw.resi_id',$rr->id_resi)
														->get()->result();
			foreach ($beliresi as $ils ) {
				include APPPATH. 'helpers/harga.php';
				$total_beli = $total ;
			}
			$totallaba += $total_jual - $total_beli;
		}

		return $totallaba;
	}

	// Get Laba Import Barang per Resi Filter
	function get_laba_resifilter($min,$max){
		$tanggal = date('Y-m-d');
    $getresi = $this->db->select('resi.*,customer.*')
			    					->from('resi')
			    					->join('customer', 'resi.cust_id=customer.id_cust')
										->where('resi.tanggal >=',$min)
										->where('resi.tanggal <=',$max)
										->order_by('resi.id_resi','desc')
										->get()->result();
		$totallaba = 0;
		foreach($getresi as $rr){
			// row Total Jual
			$total  = 0;
			$jumlah = 0;
			$resijual = $this->db->select('giw.status_berat,giw.jenis_barang_id,giw.ctns as jumlah,giw.kurs,giw.volume,giw.berat,giw.qty,giw.nilai,giw.harga_jual')
														->from('giw')
														->join('resi', 'resi.id_resi=giw.resi_id', 'left')
														->where('giw.resi_id',$rr->id_resi)
														->get()->result();
			foreach ($resijual as $ils ) {
				include APPPATH. 'helpers/harga.php';
				$total_jual = $total ;
			}
			$total  = 0;
			$jumlah = 0;
			// row Total Beli
			$beliresi = $this->db->select('giw.status_berat,giw.jenis_barang_id,giw.ctns as jumlah,giw.kurs,giw.volume,giw.berat,giw.qty,giw.nilai,giw.harga as harga_jual')
														->from('giw')
														->join('resi', 'resi.id_resi=giw.resi_id', 'left')
														->where('giw.resi_id',$rr->id_resi)
														->get()->result();
			foreach ($beliresi as $ils ) {
				include APPPATH. 'helpers/harga.php';
				$total_beli = $total ;
			}
			$totallaba += $total_jual - $total_beli;
		}

		return $totallaba;
	}

	function get_laba_resifilter_sales($min,$max,$idsales){
		$getpengguna = $this->db->where('id_pengguna',$idsales)->get('pengguna')->row();
		if($getpengguna->level == "sales" || $getpengguna->level == "saleso"){
			$tanggal = date('Y-m-d');
	    $getresi = $this->db->select('resi.*,customer.*')
				    					->from('resi')
				    					->join('customer', 'resi.cust_id=customer.id_cust')
											->where('customer.id_pendaftar',$idsales)
											->where('resi.tanggal >=',$min)
											->where('resi.tanggal <=',$max)
											->order_by('resi.id_resi','desc')
											->get()->result();
		}elseif($getpengguna->level == "crm"){
			$tanggal = date('Y-m-d');
	    $getresi = $this->db->select('resi.*,customer.*')
				    					->from('resi')
				    					->join('customer', 'resi.cust_id=customer.id_cust')
											->where('customer.id_crm',$idsales)
											->where('resi.tanggal >=',$min)
											->where('resi.tanggal <=',$max)
											->order_by('resi.id_resi','desc')
											->get()->result();
		}
		// dd("oke");
		$totallaba = 0;
		foreach($getresi as $rr){
			// row Total Jual
			$total  = 0;
			$jumlah = 0;
			$resijual = $this->db->select('giw.status_berat,giw.jenis_barang_id,giw.ctns as jumlah,giw.kurs,giw.volume,giw.berat,giw.qty,giw.nilai,giw.harga_jual')
														->from('giw')
														->join('resi', 'resi.id_resi=giw.resi_id', 'left')
														->where('giw.resi_id',$rr->id_resi)
														->get()->result();
			foreach ($resijual as $ils ) {
				include APPPATH. 'helpers/harga.php';
				$total_jual = $total ;
			}
			$total  = 0;
			$jumlah = 0;
			// row Total Beli
			$beliresi = $this->db->select('giw.status_berat,giw.jenis_barang_id,giw.ctns as jumlah,giw.kurs,giw.volume,giw.berat,giw.qty,giw.nilai,giw.harga as harga_jual')
														->from('giw')
														->join('resi', 'resi.id_resi=giw.resi_id', 'left')
														->where('giw.resi_id',$rr->id_resi)
														->get()->result();
			foreach ($beliresi as $ils ) {
				include APPPATH. 'helpers/harga.php';
				$total_beli = $total ;
			}

			$asr_resi = $this->db->where('id_resi',$rr->id_resi)->get('invoice_asuransi')->row();

			$data_giw = $this->db->select('giw.*')
														->from('giw')
														->where('giw.resi_id',$rr->id_resi)
														->get()->result();
			$kurs_global_filter = $this->db->where('id_kurs',1)->get('kurs')->row();
			$komisi_global_barang = $kurs_global_filter->komisi_barang;
			$id_referal = $rr->id_referal;
			$komisi_ref = 0;

			if($id_referal > 0){
				$get_referal = $this->db->where('id_cust',$id_referal)->get('customer')->row();
				if($rr->nama == "Nurul Magfirah Putram"){
					$komisi_ref = 0;
					$ket_komisi_nurul   = "";
					foreach($data_giw as $ils2){
						$jumlahctns_nurul      = $ils2->ctns;
						$volume_nurul          = $jumlahctns_nurul * $ils2->volume;
						$jenis_barang_id_nurul = $ils2->jenis_barang_id;
						if($jenis_barang_id_nurul == 22){
							$komisi_nurul     = $volume_nurul * 500000;
						}else{
							$komisi_nurul     = $volume_nurul * 250000;
						}
						$komisi_ref += $komisi_nurul;
					}
				}else{
					if($get_referal->komisi_barang == 0){
						$komisi_ref  = $komisi_global_barang * $cbmresi;
					}else{
						$komisi_ref = $get_referal->komisi_barang * $cbmresi;
					}
				}
			}

			$totallaba += (($total_jual - $total_beli)) - $komisi_ref;
		}

		return $totallaba;
	}

	function laba_resi_no_inv(){
    $getresi = $this->db->query('SELECT giw.*,resi.*,customer.* from giw
																left join resi on resi.id_resi = giw.resi_id
																left join customer on giw.customer_id = customer.id_cust
																where counter < ctns
																group by resi_id')->result();
		$totallaba = 0;
		// print_r($getresi);die();
		foreach($getresi as $rr){
			// row Total Jual
			$idresi = 0;
			$idresi = $rr->id_resi;
			$total  = 0;
			$jumlah = 0;
			$resijual = $this->db->query('SELECT status_berat,jenis_barang_id,jumlah,kurs,volume,berat,qty,nilai,harga_jual
																			FROM (SELECT giw.status_berat,giw.jenis_barang_id,sum(giw.ctns - giw.counter) as jumlah,giw.kurs,giw.volume,giw.berat,giw.qty,giw.nilai,giw.harga_jual from giw
																			left join resi on resi.id_resi = giw.resi_id
																			left join customer on giw.customer_id = customer.id_cust
																	  	where counter < ctns and giw.resi_id = "'.$idresi.'") truegiw
																	')->result();
																	// print_r($this->db->last_query());die();

			foreach ($resijual as $ils ) {
				include APPPATH. 'helpers/harga.php';
				$total_jual = $total ;
			}
			$total  = 0;
			$jumlah = 0;
			// row Total Beli
			$beliresi = $this->db->query('SELECT status_berat,jenis_barang_id,jumlah,kurs,volume,berat,qty,nilai,harga_jual
																			FROM (SELECT giw.status_berat,giw.jenis_barang_id,sum(giw.ctns - giw.counter) as jumlah,giw.kurs,giw.volume,giw.berat,giw.qty,giw.nilai,giw.harga as harga_jual from giw
																			left join resi on resi.id_resi = giw.resi_id
																			left join customer on giw.customer_id = customer.id_cust
																	  	where counter < ctns and giw.resi_id = "'.$idresi.'") truegiw
																	')->result();
			foreach ($beliresi as $ils ) {
				include APPPATH. 'helpers/harga.php';
				$total_beli = $total ;
			}

			$asr_resi = $this->db->where('id_resi',$rr->id_resi)->get('invoice_asuransi')->row();

			$data_giw = $this->db->select('giw.*')
														->from('giw')
														->where('giw.resi_id',$rr->id_resi)
														->get()->result();
			$kurs_global_filter = $this->db->where('id_kurs',1)->get('kurs')->row();
			$komisi_global_barang = $kurs_global_filter->komisi_barang;
			$id_referal = $rr->id_referal;
			$komisi_ref = 0;

			if($id_referal > 0){
				$get_referal = $this->db->where('id_cust',$id_referal)->get('customer')->row();
				if($rr->nama == "Nurul Magfirah Putram"){
					$komisi_ref = 0;
					$ket_komisi_nurul   = "";
					foreach($data_giw as $ils2){
						$jumlahctns_nurul      = $ils2->ctns;
						$volume_nurul          = $jumlahctns_nurul * $ils2->volume;
						$jenis_barang_id_nurul = $ils2->jenis_barang_id;
						if($jenis_barang_id_nurul == 22){
							$komisi_nurul     = $volume_nurul * 500000;
						}else{
							$komisi_nurul     = $volume_nurul * 250000;
						}
						$komisi_ref += $komisi_nurul;
					}
				}else{
					if($get_referal->komisi_barang == 0){
						$komisi_ref  = $komisi_global_barang * $cbmresi;
					}else{
						$komisi_ref = $get_referal->komisi_barang * $cbmresi;
					}
				}
			}

			$totallaba += (($total_jual - $total_beli) - $asr_resi->jumlah_asuransi) - $komisi_ref;
		}

		return $totallaba;
	}

	// get cbm today per resi
	function get_cbm() {
    $countcbm =  $this->db->select('sum(giw.volume*giw.ctns) as cbm')
						    					->from('giw')
						    					->join('resi', 'resi.id_resi=giw.resi_id')
													->where('resi.tanggal >=',date('Y-m-d '.'00:'.'00:'.'00'))
													->get()->row();
		return $countcbm->cbm;
  }

	function get_resifilter($min,$max) {
    return $this->db->select('resi.*,customer.*')
			    					->from('resi')
			    					->join('customer', 'resi.cust_id=customer.id_cust')
										->where('resi.tanggal >=',$min)
										->where('resi.tanggal <=',$max)
										->order_by('resi.id_resi','desc')
										->get();
  }

	function get_resifilter_sales($min,$max,$idsales) {
		$getpengguna = $this->db->where('id_pengguna',$idsales)->get('pengguna')->row();
		if($getpengguna->level == "sales" || $getpengguna->level == "saleso"){
			return $this->db->select('resi.*,customer.*')
				    					->from('resi')
				    					->join('customer', 'resi.cust_id=customer.id_cust')
											->where('customer.id_pendaftar',$idsales)
											->where('resi.tanggal >=',$min)
											->where('resi.tanggal <=',$max)
											->order_by('resi.id_resi','desc')
											->get();
		}elseif($getpengguna->level == "crm"){
			return $this->db->select('resi.*,customer.*')
				    					->from('resi')
				    					->join('customer', 'resi.cust_id=customer.id_cust')
											->where('customer.id_crm',$idsales)
											->where('resi.tanggal >=',$min)
											->where('resi.tanggal <=',$max)
											->order_by('resi.id_resi','desc')
											->get();
		}
  }

	function get_resifilter_campaign($min,$max,$idcampaign) {
    return $this->db->select('resi.*,customer.*')
			    					->from('resi')
			    					->join('customer', 'resi.cust_id=customer.id_cust')
										->where('customer.id_campaign',$idcampaign)
										->where('resi.tanggal >=',$min)
										->where('resi.tanggal <=',$max)
										->order_by('resi.id_resi','desc')
										->get();
  }

	function get_invseafilter($min,$max) {
		return $this->db->select('invoice.*,invoice_beli.*,customer.*')
			    					->from('invoice')
										->join('customer', 'invoice.id_cust=customer.id_cust')
										->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
										->where('invoice.tipe_invoice','barang')
										->where('invoice.tanggal_invoice >=',$min)
										->where('invoice.tanggal_invoice <=',$max)
										->order_by('invoice.id_invoice','desc')
										->get();
  }

	function get_invseafilter_sales($min,$max,$idsales) {
		$getpengguna = $this->db->where('id_pengguna',$idsales)->get('pengguna')->row();
		if($getpengguna->level == "sales" || $getpengguna->level == "saleso"){
			return $this->db->select('invoice.*,invoice_beli.*,customer.*')
				    					->from('invoice')
											->join('customer', 'invoice.id_cust=customer.id_cust')
											->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
											->where('customer.id_pendaftar',$idsales)
											->where('invoice.tipe_invoice','barang')
											->where('invoice.tanggal_invoice >=',$min)
											->where('invoice.tanggal_invoice <=',$max)
											->order_by('invoice.id_invoice','desc')
											->get();
		}elseif($getpengguna->level == "crm"){
		 return $this->db->select('invoice.*,invoice_beli.*,customer.*')
			    					->from('invoice')
										->join('customer', 'invoice.id_cust=customer.id_cust')
										->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
										->where('customer.id_crm',$idsales)
										->where('invoice.tipe_invoice','barang')
										->where('invoice.tanggal_invoice >=',$min)
										->where('invoice.tanggal_invoice <=',$max)
										->order_by('invoice.id_invoice','desc')
										->get();
		}
  }

	function get_invseafilter_campaign($min,$max,$idcampaign) {
		return $this->db->select('invoice.*,invoice_beli.*,customer.*')
			    					->from('invoice')
										->join('customer', 'invoice.id_cust=customer.id_cust')
										->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
										->where('customer.id_campaign',$idcampaign)
										->where('invoice.tipe_invoice','barang')
										->where('invoice.tanggal_invoice >=',$min)
										->where('invoice.tanggal_invoice <=',$max)
										->order_by('invoice.id_invoice','desc')
										->get();
  }

	function get_fclfilter($min,$max) {
		return $this->db->select('invoice.*,invoice_beli.*,customer.*')
			    					->from('invoice')
										->join('customer', 'invoice.id_cust=customer.id_cust')
										->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
										->where('invoice.tipe_invoice','lainnya')
										->where('invoice.tanggal_invoice >=',$min)
										->where('invoice.tanggal_invoice <=',$max)
										->order_by('invoice.id_invoice','desc')
										->get();
  }

	function get_fclfilter_sales($min,$max,$idsales) {
		$getpengguna = $this->db->where('id_pengguna',$idsales)->get('pengguna')->row();
		if($getpengguna->level == "sales" || $getpengguna->level == "saleso"){
			return $this->db->select('invoice.*,invoice_beli.*,customer.*')
				    					->from('invoice')
											->join('customer', 'invoice.id_cust=customer.id_cust')
											->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
											->where('invoice.tipe_invoice','lainnya')
											->where('customer.id_pendaftar',$idsales)
											->where('invoice.tanggal_invoice >=',$min)
											->where('invoice.tanggal_invoice <=',$max)
											->order_by('invoice.id_invoice','desc')
											->get();
		}elseif($getpengguna->level == "crm"){
			return $this->db->select('invoice.*,invoice_beli.*,customer.*')
				    					->from('invoice')
											->join('customer', 'invoice.id_cust=customer.id_cust')
											->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
											->where('invoice.tipe_invoice','lainnya')
											->where('customer.id_crm',$idsales)
											->where('invoice.tanggal_invoice >=',$min)
											->where('invoice.tanggal_invoice <=',$max)
											->order_by('invoice.id_invoice','desc')
											->get();
		}
  }

	function get_fclfilter_campaign($min,$max,$idcampaign) {
		return $this->db->select('invoice.*,invoice_beli.*,customer.*')
			    					->from('invoice')
										->join('customer', 'invoice.id_cust=customer.id_cust')
										->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
										->where('invoice.tipe_invoice','lainnya')
										->where('customer.id_campaign',$idcampaign)
										->where('invoice.tanggal_invoice >=',$min)
										->where('invoice.tanggal_invoice <=',$max)
										->order_by('invoice.id_invoice','desc')
										->get();
  }

	function get_laba_fclfilter($min,$max){
		$laba = $this->db->select('sum(invoice.total_tagihan) as jual,sum(invoice_beli.jumlah_invoice_beli) as beli')
										->from('invoice')
										->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
										->where('invoice.tipe_invoice','lainnya')
										->where('invoice.tanggal_invoice >=',$min)
										->where('invoice.tanggal_invoice <=',$max)
										->get()->row();
		return $laba->jual - $laba->beli;
	}

	function get_laba_fclfilter_sales($min,$max,$idsales){
		$getpengguna = $this->db->where('id_pengguna',$idsales)->get('pengguna')->row();
		if($getpengguna->level == "sales" || $getpengguna->level == "saleso"){
			$laba = $this->db->select('sum(invoice.total_tagihan) as jual,sum(invoice_beli.jumlah_invoice_beli) as beli')
											->from('invoice')
											->join('customer', 'invoice.id_cust=customer.id_cust')
											->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
											->where('customer.id_pendaftar',$idsales)
											->where('invoice.tipe_invoice','lainnya')
											->where('invoice.tanggal_invoice >=',$min)
											->where('invoice.tanggal_invoice <=',$max)
											->get()->row();
		}elseif($getpengguna->level == "crm"){
			$laba = $this->db->select('sum(invoice.total_tagihan) as jual,sum(invoice_beli.jumlah_invoice_beli) as beli')
											->from('invoice')
											->join('customer', 'invoice.id_cust=customer.id_cust')
											->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
											->where('invoice.tipe_invoice','lainnya')
											->where('customer.id_crm',$idsales)
											->where('invoice.tanggal_invoice >=',$min)
											->where('invoice.tanggal_invoice <=',$max)
											->get()->row();
		}
		return $laba->jual - $laba->beli;
	}

	function get_laba_fclfilter_campaign($min,$max,$idcampaign){
		$laba = $this->db->select('sum(invoice.total_tagihan) as jual,sum(invoice_beli.jumlah_invoice_beli) as beli')
										->from('invoice')
										->join('customer', 'invoice.id_cust=customer.id_cust')
										->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
										->where('invoice.tipe_invoice','lainnya')
										->where('customer.id_campaign',$idcampaign)
										->where('invoice.tanggal_invoice >=',$min)
										->where('invoice.tanggal_invoice <=',$max)
										->get()->row();
		return $laba->jual - $laba->beli;
	}

	function get_laba_invseafilter($min,$max){
		$laba = $this->db->select('sum(invoice.total_tagihan) as jual,sum(invoice_beli.jumlah_invoice_beli) as beli')
										->from('invoice')
										->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
										->where('invoice.tipe_invoice','barang')
										->where('invoice.tanggal_invoice >=',$min)
										->where('invoice.tanggal_invoice <=',$max)
										->get()->row();
		return $laba->jual - $laba->beli;
	}

	function get_laba_invseafilter_sales($min,$max,$idsales){
		$getpengguna = $this->db->where('id_pengguna',$idsales)->get('pengguna')->row();
		if($getpengguna->level == "sales" || $getpengguna->level == "saleso"){
			$laba = $this->db->select('sum(invoice.total_tagihan) as jual,sum(invoice_beli.jumlah_invoice_beli) as beli')
											->from('invoice')
											->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
											->join('customer', 'invoice.id_cust=customer.id_cust')
											->where('invoice.tipe_invoice','barang')
											->where('customer.id_pendaftar',$idsales)
											->where('invoice.tanggal_invoice >=',$min)
											->where('invoice.tanggal_invoice <=',$max)
											->get()->row();
		}elseif($getpengguna->level == "crm"){
		$laba = $this->db->select('sum(invoice.total_tagihan) as jual,sum(invoice_beli.jumlah_invoice_beli) as beli')
										->from('invoice')
										->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
										->join('customer', 'invoice.id_cust=customer.id_cust')
										->where('invoice.tipe_invoice','barang')
										->where('customer.id_crm',$idsales)
										->where('invoice.tanggal_invoice >=',$min)
										->where('invoice.tanggal_invoice <=',$max)
										->get()->row();
		}
		return $laba->jual - $laba->beli;
	}

	function get_laba_invseafilter_campaign($min,$max,$idcampaign){
		$laba = $this->db->select('sum(invoice.total_tagihan) as jual,sum(invoice_beli.jumlah_invoice_beli) as beli')
										->from('invoice')
										->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
										->join('customer', 'invoice.id_cust=customer.id_cust')
										->where('invoice.tipe_invoice','barang')
										->where('customer.id_campaign',$idcampaign)
										->where('invoice.tanggal_invoice >=',$min)
										->where('invoice.tanggal_invoice <=',$max)
										->get()->row();
		return $laba->jual - $laba->beli;
	}

	function get_airfilter($min,$max) {
		return $this->db->select('invoice.*,customer.*,resi_udara.*,invoice_beli.*')
			    					->from('invoice')
			    					->join('customer', 'invoice.id_cust=customer.id_cust')
										->join('resi_udara', 'invoice.id_invoice=resi_udara.id_invoice')
										->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
										->where('invoice.tipe_invoice','air')
										->where('invoice.tanggal_invoice >=',$min)
										->where('invoice.tanggal_invoice <=',$max)
										->order_by('invoice.id_invoice','desc')
										->get();
  }

	function get_airfilter_sales($min,$max,$idsales) {
		$getpengguna = $this->db->where('id_pengguna',$idsales)->get('pengguna')->row();
		if($getpengguna->level == "sales" || $getpengguna->level == "saleso"){
			return $this->db->select('invoice.*,customer.*,resi_udara.*,invoice_beli.*')
			    					->from('invoice')
			    					->join('customer', 'invoice.id_cust=customer.id_cust')
										->join('resi_udara', 'invoice.id_invoice=resi_udara.id_invoice')
										->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
										->where('customer.id_pendaftar',$idsales)
										->where('invoice.tipe_invoice','air')
										->where('invoice.tanggal_invoice >=',$min)
										->where('invoice.tanggal_invoice <=',$max)
										->order_by('invoice.id_invoice','desc')
										->get();
		}elseif($getpengguna->level == "crm"){
			return $this->db->select('invoice.*,customer.*,resi_udara.*,invoice_beli.*')
			    					->from('invoice')
			    					->join('customer', 'invoice.id_cust=customer.id_cust')
										->join('resi_udara', 'invoice.id_invoice=resi_udara.id_invoice')
										->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
										->where('customer.id_crm',$idsales)
										->where('invoice.tipe_invoice','air')
										->where('invoice.tanggal_invoice >=',$min)
										->where('invoice.tanggal_invoice <=',$max)
										->order_by('invoice.id_invoice','desc')
										->get();
		}
  }

	function get_airfilter_campaign($min,$max,$idcampaign) {
		return $this->db->select('invoice.*,customer.*,resi_udara.*,invoice_beli.*')
			    					->from('invoice')
			    					->join('customer', 'invoice.id_cust=customer.id_cust')
										->join('resi_udara', 'invoice.id_invoice=resi_udara.id_invoice')
										->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
										->where('customer.id_campaign',$idcampaign)
										->where('invoice.tipe_invoice','air')
										->where('invoice.tanggal_invoice >=',$min)
										->where('invoice.tanggal_invoice <=',$max)
										->order_by('invoice.id_invoice','desc')
										->get();
  }

	function get_laba_resi_udarafilter($min,$max){
		$laba = $this->db->select('sum(invoice.total_tagihan) as jual,sum(invoice_beli.jumlah_invoice_beli) as beli,kode_invoice')
										->from('invoice')
										->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
										->join('resi_udara', 'invoice.id_invoice=resi_udara.id_invoice')
										->where('invoice.tipe_invoice','air')
										->where('invoice.tanggal_invoice >=',$min)
										->where('invoice.tanggal_invoice <=',$max)
										->get()->row();
		return $laba->jual - $laba->beli;
	}

	function get_laba_resi_udarafilter_sales($min,$max,$idsales){
		$getpengguna = $this->db->where('id_pengguna',$idsales)->get('pengguna')->row();
		if($getpengguna->level == "sales" || $getpengguna->level == "saleso"){
			$laba = $this->db->select('sum(invoice.total_tagihan) as jual,sum(invoice_beli.jumlah_invoice_beli) as beli')
											->from('invoice')
											->join('customer', 'invoice.id_cust=customer.id_cust')
											->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
											->where('customer.id_pendaftar',$idsales)
											->where('invoice.tipe_invoice','air')
											->where('invoice.tanggal_invoice >=',$min)
											->where('invoice.tanggal_invoice <=',$max)
											->get()->row();
		}elseif($getpengguna->level == "crm"){
			$laba = $this->db->select('sum(invoice.total_tagihan) as jual,sum(invoice_beli.jumlah_invoice_beli) as beli')
											->from('invoice')
											->join('customer', 'invoice.id_cust=customer.id_cust')
											->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
											->where('customer.id_crm',$idsales)
											->where('invoice.tipe_invoice','air')
											->where('invoice.tanggal_invoice >=',$min)
											->where('invoice.tanggal_invoice <=',$max)
											->get()->row();
		}

		return $laba->jual - $laba->beli;
	}

	function get_laba_resi_udarafilter_campaign($min,$max,$idcampaign){
		$laba = $this->db->select('sum(invoice.total_tagihan) as jual,sum(invoice_beli.jumlah_invoice_beli) as beli')
										->from('invoice')
										->join('customer', 'invoice.id_cust=customer.id_cust')
										->join('invoice_beli', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli')
										->where('customer.id_campaign',$idcampaign)
										->where('invoice.tipe_invoice','air')
										->where('invoice.tanggal_invoice >=',$min)
										->where('invoice.tanggal_invoice <=',$max)
										->get()->row();
		return $laba->jual - $laba->beli;
	}

	function get_laba_resifilter_campaign($min,$max,$idcampaign){
		$record_resi = $this->db->select('resi.*,customer.*')
			    					->from('resi')
			    					->join('customer', 'resi.cust_id=customer.id_cust')
										->where('customer.id_campaign',$idcampaign)
										->where('resi.tanggal >=',$min)
										->where('resi.tanggal <=',$max)
										->order_by('resi.id_resi','desc')
										->get()->result();
		$total_semuanya = 0;
		foreach($record_resi as $rr){
			// row Total Jual
			$total  = 0;
			$jumlah = 0;
			$resijual = $this->db->select('giw.status_berat,giw.jenis_barang_id,giw.ctns as jumlah,giw.kurs,giw.volume,giw.berat,giw.qty,giw.nilai,giw.harga_jual')
														->from('giw')
														->join('resi', 'resi.id_resi=giw.resi_id', 'left')
														->where('giw.resi_id',$rr->id_resi)
														->get()->result();
			foreach ($resijual as $ils ) {
				include APPPATH. 'helpers/harga.php';
				$total_jual = $total ;
			}

			$total  = 0;
			$jumlah = 0;
			// row Total Beli
			$beliresi = $this->db->select('giw.status_berat,giw.jenis_barang_id,giw.ctns as jumlah,giw.kurs,giw.volume,giw.berat,giw.qty,giw.nilai,giw.harga as harga_jual')
														->from('giw')
														->join('resi', 'resi.id_resi=giw.resi_id', 'left')
														->where('giw.resi_id',$rr->id_resi)
														->get()->result();
			foreach ($beliresi as $ils ) {
				include APPPATH. 'helpers/harga.php';
				$total_beli = $total ;
			}

			$data_giw = $this->db->select('giw.*')
														->from('giw')
														->where('giw.resi_id',$rr->id_resi)
														->get()->result();
			$kurs_global_filter = $this->db->where('id_kurs',1)->get('kurs')->row();
			$komisi_global_barang = $kurs_global_filter->komisi_barang;
			$id_referal = $rr->id_referal;
			$komisi_ref = 0;

			if($id_referal > 0){
				$get_referal = $this->db->where('id_cust',$id_referal)->get('customer')->row();
				if($rr->nama == "Nurul Magfirah Putram"){
					$komisi_ref = 0;
					$ket_komisi_nurul   = "";
					foreach($data_giw as $ils2){
						$jumlahctns_nurul      = $ils2->ctns;
						$volume_nurul          = $jumlahctns_nurul * $ils2->volume;
						$jenis_barang_id_nurul = $ils2->jenis_barang_id;
						if($jenis_barang_id_nurul == 22){
							$komisi_nurul     = $volume_nurul * 500000;
						}else{
							$komisi_nurul     = $volume_nurul * 250000;
						}
						$komisi_ref += $komisi_nurul;
					}
				}else{
					if($get_referal->komisi_barang == 0){
						$komisi_ref  = $komisi_global_barang * $cbmresi;
					}else{
						$komisi_ref = $get_referal->komisi_barang * $cbmresi;
					}
				}
			}
			// print_r($record_resi);die();
			$total_semuanya += ($total_jual-$total_beli)-$komisi_ref;
		}
		return $total_semuanya;
	}


	function get_cbmfilter($min,$max) {
    $countcbm =  $this->db->select('sum(giw.volume*giw.ctns) as cbm')
						    					->from('giw')
						    					->join('resi', 'resi.id_resi=giw.resi_id')
													->where('resi.tanggal >=',$min)
													->where('resi.tanggal <=',$max)
													->get()->row();
		return $countcbm->cbm;
  }

	function get_cbmfilter_sales($min,$max,$idsales) {
		// die("oke");
		$getpengguna = $this->db->where('id_pengguna',$idsales)->get('pengguna')->row();
		if($getpengguna->level == "sales" || $getpengguna->level == "saleso"){
			$countcbm =  $this->db->select('sum(giw.volume*giw.ctns) as cbm')
							    					->from('giw')
							    					->join('resi', 'resi.id_resi=giw.resi_id')
														->join('customer', 'customer.id_cust=resi.cust_id')
														// ->where('Case when pengguna.level = "sales" then customer.id_pendaftar = "$idsales" else ')
														->where('customer.id_pendaftar',$idsales)
														->where('resi.tanggal >=',$min)
														->where('resi.tanggal <=',$max)
														->get()->row();
		}elseif($getpengguna->level == "crm"){
			$countcbm =  $this->db->select('sum(giw.volume*giw.ctns) as cbm')
							    					->from('giw')
							    					->join('resi', 'resi.id_resi=giw.resi_id')
														->join('customer', 'customer.id_cust=resi.cust_id')
														// ->where('Case when pengguna.level = "sales" then customer.id_pendaftar = "$idsales" else ')
														->where('customer.id_crm',$idsales)
														->where('resi.tanggal >=',$min)
														->where('resi.tanggal <=',$max)
														->get()->row();
		}
		return $countcbm->cbm;
  }

	function get_cbmfilter_campaign($min,$max,$id_campaign) {
    $countcbm =  $this->db->select('sum(giw.volume*giw.ctns) as cbm')
						    					->from('giw')
						    					->join('resi', 'resi.id_resi=giw.resi_id')
													->join('customer', 'customer.id_cust=resi.cust_id')
													->where('customer.id_campaign',$id_campaign)
													->where('resi.tanggal >=',$min)
													->where('resi.tanggal <=',$max)
													->get()->row();
		return $countcbm->cbm;
  }

	function get_komisi_brg_filter($min,$max) {
    $resi_data = $this->db->select('resi.*,customer.*')
			    					->from('resi')
			    					->join('customer', 'resi.cust_id=customer.id_cust')
										->where('resi.tanggal >=',$min)
										->where('resi.tanggal <=',$max)
										->order_by('resi.id_resi','desc')
										->get()->result();
		$jumlah_semua_komisi = 0;
		// print_r($resi_data);die();
		foreach ($resi_data as $rr) {
			$data_giw = $this->db->select('giw.*')
														->from('giw')
														->where('giw.resi_id',$rr->id_resi)
														->get()->result();

			$kurs_global = $this->db->where('id_kurs',1)->get('kurs')->row();
			$komisi_global_barang = $kurs_global->komisi_barang;
			$id_referal = $rr->id_referal;
			$komisi_ref = 0;
			if($id_referal > 0){
				$get_referal = $this->db->where('id_cust',$rr->id_cust)->get('customer')->row();
				if($rr->nama == "Nurul Magfirah Putram"){
					$komisi_ref = 0;
					$ket_komisi_nurul   = "";
					foreach($data_giw as $giw_nurul){
						$jumlahctns_nurul      = $giw_nurul->ctns;
						$volume_nurul          = $jumlahctns_nurul * $giw_nurul->volume;
						$jenis_barang_id_nurul = $giw_nurul->jenis_barang_id;
						if($jenis_barang_id_nurul == 22){
							$komisi_nurul     = $volume_nurul * 500000;
						}else{
							$komisi_nurul     = $volume_nurul * 250000;
						}
						$komisi_ref += $komisi_nurul;
					}
				}else{
					if($get_referal->komisi_barang == 0){
						$komisi_ref  = $komisi_global_barang * $cbmresi;
					}else{
						$komisi_ref = $get_referal->komisi_barang * $cbmresi;
					}
				}//else Nurul
			}//else referal
			$jumlah_semua_komisi += $komisi_ref;
		}//foreach resi
		return $jumlah_semua_komisi;
  }

	function get_komisi_brg() {
    $resi_data = $this->db->select('resi.*,customer.*')
			    					->from('resi')
			    					->join('customer', 'resi.cust_id=customer.id_cust')
										->where('resi.tanggal >=',date('Y-m-d '.'00:'.'00:'.'00'))
										->order_by('resi.id_resi','desc')
										->get()->result();
		$jumlah_semua_komisi = 0;
		// print_r($resi_data);die();
		foreach ($resi_data as $rr) {
			$data_giw = $this->db->select('giw.*')
														->from('giw')
														->where('giw.resi_id',$rr->id_resi)
														->get()->result();

			$kurs_global = $this->db->where('id_kurs',1)->get('kurs')->row();
			$komisi_global_barang = $kurs_global->komisi_barang;
			$id_referal = $rr->id_referal;
			$komisi_ref = 0;
			if($id_referal > 0){
				$get_referal = $this->db->where('id_cust',$rr->id_cust)->get('customer')->row();
				if($rr->nama == "Nurul Magfirah Putram"){
					$komisi_ref = 0;
					$ket_komisi_nurul   = "";
					foreach($data_giw as $giw_nurul){
						$jumlahctns_nurul      = $giw_nurul->ctns;
						$volume_nurul          = $jumlahctns_nurul * $giw_nurul->volume;
						$jenis_barang_id_nurul = $giw_nurul->jenis_barang_id;
						if($jenis_barang_id_nurul == 22){
							$komisi_nurul     = $volume_nurul * 500000;
						}else{
							$komisi_nurul     = $volume_nurul * 250000;
						}
						$komisi_ref += $komisi_nurul;
					}
				}else{
					if($get_referal->komisi_barang == 0){
						$komisi_ref  = $komisi_global_barang * $cbmresi;
					}else{
						$komisi_ref = $get_referal->komisi_barang * $cbmresi;
					}
				}//else Nurul
			}//else referal
			$jumlah_semua_komisi += $komisi_ref;
		}//foreach resi
		return $jumlah_semua_komisi;
  }

	function get_komisi_trf_filter($min,$max){
		$data_titip_trf = $this->get_trffilter($min,$max)->result();
		$total_semua = 0;
		foreach($data_titip_trf as $trf){
			$id_referal = $trf->id_referal;
			$kurs_global_filter = $this->db->where('id_kurs',1)->get('kurs')->row();
			$komisi_global_trf = $kurs_global_filter->komisi_titip_trf;
			$total_komisi_trf = 0;
			$total_rmb = $trf->jumlah_rmb + $trf->jumlah_rmb2;
			if($id_referal > 0){
				$get_referal = $this->db->where('id_cust',$trf->id_cust)->get('customer')->row();
				if($get_referal->komisi_titip_trf == 0){
					$total_komisi_trf = $komisi_global_trf * $total_rmb;
				}else{
					$total_komisi_trf = $get_referal->komisi_titip_trf * $total_rmb;
				}
			}
			$total_semua += $total_komisi_trf ;
		}
		// print_r($total_semua);die();
		return $total_semua;
	}

	function get_komisi_trf(){
		$data_titip_trf = $this->get_trf()->result();
		$total_semua = 0;
		foreach($data_titip_trf as $trf){
			$id_referal = $trf->id_referal;
			$kurs_global_filter = $this->db->where('id_kurs',1)->get('kurs')->row();
			$komisi_global_trf = $kurs_global_filter->komisi_titip_trf;
			$total_komisi_trf = 0;
			$total_rmb = $trf->jumlah_rmb + $trf->jumlah_rmb2;
			if($id_referal > 0){
				$get_referal = $this->db->where('id_cust',$trf->id_cust)->get('customer')->row();
				if($get_referal->komisi_titip_trf == 0){
					$total_komisi_trf = $komisi_global_trf * $total_rmb;
				}else{
					$total_komisi_trf = $get_referal->komisi_titip_trf * $total_rmb;
				}
			}
			$total_semua += $total_komisi_trf ;
		}
		// print_r($total_semua);die();
		return $total_semua;
	}

	function komisi_barang_invfilter($min,$max){
		$data_komisi = $this->db->select('sum(komisi_referal.nilai) as total')
														->from('invoice')
														->join('komisi_referal', 'invoice.id_invoice=komisi_referal.id_invoice')
														->where('invoice.tipe_invoice','barang')
														->where('invoice.tanggal_invoice >=',$min)
														->where('invoice.tanggal_invoice <=',$max)
														->get()->row();
		return $data_komisi->total;
	}

	function komisi_trf_invfilter($min,$max){
		$data_komisi = $this->db->select('sum(komisi_referal.nilai) as total')
														->from('invoice')
														->join('komisi_referal', 'invoice.id_invoice=komisi_referal.id_invoice')
														->where('invoice.tipe_invoice','tt')
														->where('invoice.tanggal_invoice >=',$min)
														->where('invoice.tanggal_invoice <=',$max)
														->get()->row();
		return $data_komisi->total;
	}

	function komisi_barang_inv(){
		$data_komisi = $this->db->select('sum(komisi_referal.nilai) as total')
														->from('invoice')
														->join('komisi_referal', 'invoice.id_invoice=komisi_referal.id_invoice')
														->where('invoice.tipe_invoice','barang')
														->where('invoice.tanggal_invoice',date('Y-m-d'))
														->get()->row();
		return $data_komisi->total;
	}

	function komisi_trf_inv(){
		$data_komisi = $this->db->select('sum(komisi_referal.nilai) as total')
														->from('invoice')
														->join('komisi_referal', 'invoice.id_invoice=komisi_referal.id_invoice')
														->where('invoice.tipe_invoice','tt')
														->where('invoice.tanggal_invoice',date('Y-m-d'))
														->get()->row();
		return $data_komisi->total;
	}

	function pengeluaran_inv(){
		return $this->db->select('sum(nominal_transaksi_bank) as jumlah,jenis_transaksi_bank.kjenis_transaksi_bank')
						 ->from('transaksi_bank')
						 ->join('jenis_transaksi_bank', 'transaksi_bank.id_jenis_transaksi_bank=jenis_transaksi_bank.id_jenis_transaksi_bank')
						 ->where('jenis_transaksi_bank.id_jenis_transaksi_utama',1)
						 ->group_start()
                ->where('jenis_transaksi_bank.id_jenis_transaksi_bank !=','7')
                ->where('jenis_transaksi_bank.id_jenis_transaksi_bank !=','48')
			       ->group_end()
						 ->where('transaksi_bank.tipe_transaksi_bank',"keluar")
						 ->where('transaksi_bank.tanggal_transaksi_bank',date('Y-m-d'))
						 ->group_by('transaksi_bank.id_jenis_transaksi_bank')
						 ->get()->result();
	}

	function pengeluaran_invfilter($min,$max){
		return $this->db->select('sum(nominal_transaksi_bank) as jumlah,jenis_transaksi_bank.kjenis_transaksi_bank')
						 ->from('transaksi_bank')
						 ->join('jenis_transaksi_bank', 'transaksi_bank.id_jenis_transaksi_bank=jenis_transaksi_bank.id_jenis_transaksi_bank')
						 ->group_start()
                ->where('jenis_transaksi_bank.id_jenis_transaksi_bank !=','7')
                ->where('jenis_transaksi_bank.id_jenis_transaksi_bank !=','48')
			       ->group_end()
					   // ->where('jenis_transaksi_bank.id_jenis_transaksi_bank != 7',,FALSE)
					   // ->where('(jenis_transaksi_bank.id_jenis_transaksi_bank != 48 or jenis_transaksi_bank.id_jenis_transaksi_bank != 7)', NULL, FALSE)
					   // ->group_end() //this will end grouping
						 ->where('jenis_transaksi_bank.id_jenis_transaksi_utama',1)
						 ->where('transaksi_bank.tanggal_transaksi_bank >=',$min)
						 ->where('transaksi_bank.tanggal_transaksi_bank <=',$max)
						 ->where('transaksi_bank.tipe_transaksi_bank',"keluar")
						 ->group_by('transaksi_bank.id_jenis_transaksi_bank')
						 ->get()->result();
	}
	function get_kelasimport() {
        $this->datatables->select('customer.nama,customer.kode,count(status_tonton.id) as jumlahnya');
		$this->datatables->from('status_tonton');
		$this->datatables->join('customer', 'status_tonton.id_cust=customer.id_cust');
		$this->datatables->where('customer.id_cust IS NOT NULL', null, false);
		$this->datatables->group_by('status_tonton.id_cust');
		$this->db->order_by('status_tonton.tgl_tonton', 'DESC');

        return $this->datatables->generate();
  	}

}
