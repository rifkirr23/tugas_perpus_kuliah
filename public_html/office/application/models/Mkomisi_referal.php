<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mkomisi_referal extends CI_Model {

	//Proses Get Data And Cloumn Customer and Parsing to Controller Customer function get_customer_json
	function get_komisi_referal() {
        $this->datatables->select('komisi_referal.id_komisi_referal,komisi_referal.kode_komisi,,komisi_referal.customer,komisi_referal.nilai,komisi_referal.keterangan
                                   ,komisi_referal.status
                                   ,invoice.id_invoice,invoice.kode_invoice,
                                   customer.kode,customer.id_cust');
        $this->datatables->from('komisi_referal');
        $this->datatables->join('customer', 'customer.id_cust=komisi_referal.id_cust');
        $this->datatables->join('invoice', 'invoice.id_invoice=komisi_referal.id_invoice');
        $this->datatables->where('komisi_referal.status !=',4);
				$this->db->order_by('komisi_referal.id_komisi_referal','desc');
				$q="$1";
        //$this->datatables->join('kategori', 'barang_kategori_id=kategori_id
        return $this->datatables->generate();
  }

  function kode_komisi(){
   $hcekkode= $this->db->select('kode_komisi as maxkode')->order_by('id_komisi_referal','desc')->get('komisi_referal')->row();
   $kodesaatini= $hcekkode->maxkode;
   $ambilkode= str_replace('KOM-','',$kodesaatini);
   if($ambilkode=="")
   {
    $ambilkode=0;
   }
   $kodejadi= $ambilkode+1;

   $hasil= $kodejadi;
   return 'KOM-'.$hasil;
  }



}
