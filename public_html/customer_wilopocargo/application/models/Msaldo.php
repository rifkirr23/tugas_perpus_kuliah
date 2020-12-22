<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Msaldo extends CI_Model {
    function get_saldo(){
      $idcust=$this->session->userdata('id_cust');
      $this->datatables->select('deposit.*');
      $this->datatables->from('deposit');
      $this->datatables->where('deposit.id_cust',$idcust);
      return $this->datatables->generate();
    }

    function get_penarikan(){
      $idcust=$this->session->userdata('id_cust');
      $this->datatables->select('tarik_dana.id_tarik_dana,tarik_dana.id_cust,tarik_dana.status,tarik_dana.tanggal_pengajuan,tarik_dana.nominal');
      $this->datatables->from('tarik_dana');
      $this->datatables->where('tarik_dana.id_cust',$idcust);
      $this->datatables->add_column('statustarik','$1','status_tarik_dana(status)');
      return $this->datatables->generate();
    }

}
