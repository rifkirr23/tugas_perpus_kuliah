<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mvendor extends CI_Model {

	//Proses Get Data And Cloumn vendor and Parsing to Controller vendor function get_vendor_json
	function get_vendor() {
        $this->datatables->select('vendor.id_vendor,vendor.nama_vendor');
        $this->datatables->from('vendor');
        $this->datatables->add_column('view', '<a href="javascript:void(0);" class="edit_record btn btn-warning btn-xs"
																			 				 data-id_vendor="$1" data-nama_vendor="$2"> <i class="fa fa-edit"></i></a>
																							 <a href="'.site_url().'admin/vendor/detail/$1/invoice" class="btn btn-info btn-xs"><i class="fa fa-ellipsis-h"></i></a>
														          ', 'id_vendor,nama_vendor');
        return $this->datatables->generate();
  }

	//Proses Get Data And Cloumn vendor and Parsing to Controller vendor function get_vendor_json
	function get_invoice_beli($id) {
        $this->datatables->select('invoice_beli.id_invoice_beli,invoice_beli.id_vendor,invoice_beli.kode_invoice_beli,invoice_beli.tanggal_invoice_beli,invoice_beli.status_invoice_beli
																	 ,invoice_beli.note_invoice_beli,invoice_beli.jumlah_invoice_beli,invoice_beli.jumlah_bayar_invoice_beli
																	 ,invoice_beli.jumlah_dari_vendor,customer.kode,invoice.id_invoice');
        $this->datatables->from('invoice_beli');
				$this->datatables->join('customer', 'invoice_beli.id_cust=customer.id_cust');
				$this->datatables->join('invoice', 'invoice.id_invoice_beli=invoice_beli.id_invoice_beli');
				// $this->datatables->join('invoice_rts', 'invoice_rts.no_inv=invoice_beli.note_invoice_beli');
				$this->datatables->where('invoice_beli.id_vendor',$id);
				if($id==4){
					$this->db->order_by('invoice_beli.id_invoice_beli','desc');
				  // $this->datatables->where('invoice_beli.status_hitung',"");
				}
				// $this->db->order_by('status_invoice_beli','asc');
				$this->db->order_by('id_invoice_beli','desc');
				$this->datatables->add_column('detail_invoice_beli', '$1','detail_invoice_beli(id_vendor,id_invoice,id_invoice_beli)');
        return $this->datatables->generate();
  }

	//Proses Get Data And Cloumn vendor and Parsing to Controller vendor function get_vendor_json
	function get_rtsbeda($id) {
		$sql = "SELECT invoice_beli.id_invoice_beli,invoice_beli.id_vendor,invoice_beli.kode_invoice_beli,invoice_beli.tanggal_invoice_beli,invoice_beli.status_invoice_beli
									 ,invoice_beli.note_invoice_beli,invoice_beli.jumlah_invoice_beli,invoice_beli.jumlah_bayar_invoice_beli
									 ,invoice_beli.jumlah_dari_vendor,customer.kode,invoice.id_invoice FROM invoice_beli left join customer on invoice_beli.id_cust=customer.id_cust
									 left join invoice on invoice.id_invoice_beli=invoice_beli.id_invoice_beli where invoice_beli.id_vendor = $id and
									  invoice_beli.jumlah_invoice_beli != invoice_beli.jumlah_dari_vendor  order by jumlah_invoice_beli desc";

		// $sql = "SELECT invoice_beli.id_invoice_beli,invoice_beli.id_vendor,invoice_beli.kode_invoice_beli,invoice_beli.tanggal_invoice_beli,invoice_beli.status_invoice_beli
		// 							 ,invoice_beli.note_invoice_beli,invoice_beli.jumlah_invoice_beli,invoice_beli.jumlah_bayar_invoice_beli
		// 							 ,invoice_beli.jumlah_dari_vendor,customer.kode,invoice.id_invoice,invoice_rts.jumlah as jumlah_rts FROM invoice_beli left join customer on invoice_beli.id_cust=customer.id_cust
		// 							 left join invoice on invoice.id_invoice_beli=invoice_beli.id_invoice_beli left join invoice_rts on invoice_rts.no_inv = invoice_beli.note_invoice_beli
		// 							 where invoice_beli.id_vendor = $id and invoice_beli.jumlah_invoice_beli != invoice_rts.jumlah and status  order by jumlah_invoice_beli desc";
		return $this->db->query($sql)->result();
  }

	function getdata_vendor($id){
		return $this->db->where('id_vendor',$id)->get('vendor');
	}

  function save(){
    $vendor['nama_vendor']  =$this->input->post('nama_vendor');
    $this->db->insert('vendor', $vendor);
    $this->session->set_flashdata('msg','success');
    redirect(site_url('admin/vendor'));
  }

	function update(){
    $vendor['nama_vendor']  =$this->input->post('nama_vendor');
    $this->db->where('id_vendor',$this->input->post('id_vendor'))->update('vendor', $vendor);
    $this->session->set_flashdata('msg','updated');
    redirect(site_url('admin/vendor'));
  }

	public function select_vendor(){
    return $this->db->get('vendor')->result();
  }

}
