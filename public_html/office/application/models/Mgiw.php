<?php
/**
*
*/
class Mgiw extends CI_Model
{

    function cekresi($resi, $marking){
      $this->db->select('customer.kode as customerkode,customer.nama as customernama,customer.alamat as customeralamat,customer.telepon as customertelepon,
                         resi.*,giw.status as statusgiw,giw.tanggal_monitoring,giw.tanggal_berangkat,giw.tanggal_tiba,resi.tanggal as tanggal,giw.tgl_closing,
                         container.tgl_eta,container.tgl_antri_kapal,container.tgl_atur_kapal,container.tgl_est_dumai,container.tgl_pib,container.tgl_notul,container.tanggal_berangkat_c,
                         container.tanggal_monitoring_c,container.tanggal_arrived_c,status_giw.urutan as statusfix, giw.tanggal_loading');
      $this->db->from('resi');
      $this->db->join('giw', 'resi.id_resi=giw.resi_id', 'left');
      $this->db->join('status_giw', 'giw.status=status_giw.id', 'left');
      $this->db->join('container', 'giw.container_id=container.id_rts', 'left');
      $this->db->join('customer', 'customer.id_cust=resi.cust_id', 'left');
      $this->db->where('resi.nomor',$resi);
      $this->db->where('customer.kode',$marking);
      return $this->db->get()->row();
    }
    function cekresioffice($resi){
      $this->db->select('customer.kode as customerkode,customer.nama as customernama,customer.alamat as customeralamat,customer.telepon as customertelepon,
                         resi.*,giw.status as statusgiw,giw.tanggal_monitoring,giw.tanggal_berangkat,giw.tanggal_tiba,resi.tanggal as tanggal,giw.tgl_closing,
                         container.tgl_eta,container.tgl_antri_kapal,container.tgl_atur_kapal,container.tgl_est_dumai,container.tgl_pib,container.tgl_notul,container.tanggal_berangkat_c,
                         container.tanggal_monitoring_c,container.tanggal_arrived_c,status_giw.urutan as statusfix, giw.tanggal_loading,container.id_rts as containerid');
      $this->db->from('resi');
      $this->db->join('giw', 'resi.id_resi=giw.resi_id', 'left');
      $this->db->join('status_giw', 'giw.status=status_giw.id', 'left');
      $this->db->join('container', 'giw.container_id=container.id_rts', 'left');
      $this->db->join('customer', 'customer.id_cust=resi.cust_id', 'left');
      $this->db->group_by('container.id_rts');
      $this->db->where('resi.id_resi',$resi);
      return $this->db->get();
    }
    function detailgiw($resi, $marking){
        $this->db->select('giw.*');
        $this->db->from('resi');
        $this->db->join('giw', 'resi.id_resi=giw.resi_id', 'left');
        $this->db->join('customer', 'customer.id_cust=resi.cust_id', 'left');
        $this->db->where('resi.nomor',$resi);
        $this->db->where('customer.kode',$marking);
        return $this->db->get();
      }

}
