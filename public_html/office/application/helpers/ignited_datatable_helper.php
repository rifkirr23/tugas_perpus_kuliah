<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function c_total_rmb($j1,$j2)
{
  // $this->db->select('customer.*')->from('customer')->where('id_cust',143)->get();
  return $j1 + $j2;
}

function c_qty($qty,$ctns)
{
  $mqty = $qty * $ctns;
  $output = "@".$qty.'/'.$mqty.' pcs';
  return $output;
}

function c_berat($berat,$ctns)
{
  $mberat = $berat * $ctns;
  $output = "@".$berat.'/'.$mberat.' kg';
  return $output;
}

function c_volume($volume,$ctns)
{
  $mvolume = $volume * $ctns;
  $output = "@".$volume.'/'.$mvolume.' m<sup>3</sup>';
  return $output;
}

function c_nilai($nilai,$ctns,$qty)
{
  $rmb = $nilai * $ctns * $qty;
  $output = "@".$nilai.'/'.$rmb.' RMB';
  return $output;
}

function c_est($jalur,$tglbrgkt)
{
  if($tglbrgkt == ""){
    $est = "Belum Otw";
  }else{
    if($jalur == 1){
      $est = date_indo(date("Y-m-d",strtotime("+21 days", strtotime($tglbrgkt))));
    }else{
      $est = date_indo(date("Y-m-d",strtotime("+14 days", strtotime($tglbrgkt))));
    }
  }
  return $est;
}

function status_transaksi($idinvoice,$kodeinvoice,$bank_tujuan,$file_bank_tujuan,$kode_transaksi,$id,$status,$level)
{
  $output='';
  if($level=="suadmin"){
    if($status==2 || $status==4){
      $output.='<a href="'.base_url().'admin/transaksi/update_v/'.$id.'" class="btn btn-info btn-xs" alt="Update Data"> <i class="fa fa-edit"></i></a> ';
      $output.='<a href="javascript:void(0);" class="update_bank btn btn-warning btn-xs"  data-id_transaksi="'.$id.'" data-bank_tujuan="'.$bank_tujuan.'"
                data-file_bank_tujuan="'.$file_bank_tujuan.'" data-kode_transaksi="'.$kode_transaksi.'"><i class="fa fa-edit"></i></a>
                <a href="javascript:void(0);" class="refund_transaksi btn btn-primary btn-xs"  data-id_invoice="'.$idinvoice.'" data-kode_invoice="'.$kodeinvoice.'">
                <i class="fa fa-close"></i></a>';
    }else if($status==1){
      $output.='<a href="javascript:void(0);" class="update_bank btn btn-warning btn-xs"  data-id_transaksi="'.$id.'" data-bank_tujuan="'.$bank_tujuan.'"
                data-file_bank_tujuan="'.$file_bank_tujuan.'" data-kode_transaksi="'.$kode_transaksi.'"><i class="fa fa-edit"></i></a>
                <a href="javascript:void(0);" class="cancel_transaksi btn btn-primary btn-xs"  data-id_invoice="'.$idinvoice.'" data-kode_invoice="'.$kodeinvoice.'">
                <i class="fa fa-close"></i></a>';
    }
  }else{
    if($status==2){
      if($level=="admin2"){
        $output.='<a href="'.base_url().'admin/transaksi/update_v/'.$id.'" class="btn btn-info btn-xs" alt="Update Data"> <i class="fa fa-edit"></i></a>
                 <a href="javascript:void(0);" class="salah_bank btn btn-warning btn-xs"  data-id_transaksi="'.$id.'" data-kode_transaksi="'.$kode_transaksi.'">
                 <i class="fa fa-bank"></i></a>';
      }else if($level=="admin"){
        $output.='<a href="javascript:void(0);" class="update_bank btn btn-warning btn-xs"  data-id_transaksi="'.$id.'" data-bank_tujuan="'.$bank_tujuan.'"
                  data-file_bank_tujuan="'.$file_bank_tujuan.'" data-kode_transaksi="'.$kode_transaksi.'"><i class="fa fa-edit"></i></a>';
      }
    }else if($status==4 || $status==1){
      if($level=="admin"){
        $output.='<a href="javascript:void(0);" class="update_bank btn btn-warning btn-xs"  data-id_transaksi="'.$id.'" data-bank_tujuan="'.$bank_tujuan.'"
                  data-file_bank_tujuan="'.$file_bank_tujuan.'" data-kode_transaksi="'.$kode_transaksi.'"><i class="fa fa-edit"></i></a>';
      }
    }

  }

  $output .= ' <a href="javascript:void(0);" onclick="view_image('.$id.')" class="btn btn-danger btn-xs" alt="Update Data"> <i class="fa fa-file-image-o"></i></a>';
  return $output;
}

function detail_invoice_beli($idvendor,$idinv,$idinvbeli)
{
  $output='';
  if($idvendor == 1){
      $output.='<a href="'.site_url().'admin/resi_udara/invoice_detail/'.$idinv.'/0/beli" class="btn btn-info btn-xs" target="_blank"><i class="fa fa-ellipsis-h"></i></a>';
  }else if($idvendor == 4){
      $output.='<a href="'.site_url().'admin/invoice_barang/detail/'.$idinv.'/0/beli" class="btn btn-info btn-xs" target="_blank"><i class="fa fa-ellipsis-h"></i></a>';
  }else if($idvendor == 2){
      $output.='<a href="'.site_url().'admin/invoice_lainnya/detail/'.$idinv.'/'.$idinvbeli.'" class="btn btn-info btn-xs" target="_blank"><i class="fa fa-ellipsis-h"></i></a>';
  }
  return $output;
}

function actionpaid($status,$id_pembelian,$status_pembelian,$kode_pembelian,$id_transaksi)
{
  $output = "";
  if($status==2 && $status_pembelian==2){
    $output .='<a href="javascript:void(0);" class="paid_pembelian btn btn-warning btn-xs" alt="Paid Data" data-id_pembelian="'.$id_pembelian.'"
              data-status_pembelian="'.$status_pembelian.'" data-kode_pembelian="'.$kode_pembelian.'" data-id_transaksi="'.$id_transaksi.'">
              <i class="fa fa-credit-card"></i></a>';
  }
  if($status!=3){
    $output .= '<a href="javascript:void(0);" onclick="edit_kurs_beli('.$id_transaksi.')" class="btn btn-info btn-xs" > <i class="fa fa-edit"></i></a>';
  }
  if($status==2){
    $output .= ' <a href="javascript:void(0);" class="lunasi_satu btn btn-warning btn-xs" alt="Lunasi Data"
                 data-kode_pembelian="'.$kode_pembelian.'" data-id_transaksi="'.$id_transaksi.'">
                 <i class="fa fa-money"></i></a> ';
  }
  $output .=' <a href="javascript:void(0);" onclick="view_image('.$id_transaksi.')" class="btn btn-danger btn-xs" alt="Update Data"> <i class="fa fa-file-image-o"></i></a>';
  return $output;
}

function setrowtransaksi($id){
  if($id > 0){
    $output = 'background-color: rgb(214, 233, 198);';
  }
  return $output;
}

function kurs_beli_pembelian($kurs_beli,$jumlah_rmb,$tgl){
  if($kurs_beli > 0){
    if($tgl >= "2019-12-19"){
      $output = ($kurs_beli * $jumlah_rmb);
    }else{
      $output = ($kurs_beli * $jumlah_rmb)+100000;
    }
  }else if($kurs_beli == 0){
    $output = 0;
  }
  return $output;
}

function keterangan_pembelian($kurs_beli,$jumlah_rmb,$tgl){
  if($kurs_beli > 0){
    if($tgl >= "2019-12-19"){
      $output = "(".$kurs_beli." * ".$jumlah_rmb.")";
    }else{
      $output = "(".$kurs_beli." * ".$jumlah_rmb.") + 100000";
    }
  }else if($kurs_beli == 0){
    $output = "";
  }
  return $output;
}

function result_rmb($tipe_pembelian,$jumlah_rmb){
  if($tipe_pembelian=="keluar"){
    $output = "- ".$jumlah_rmb;
  }else if($tipe_pembelian=="masuk"){
    $output = "+ ".$jumlah_rmb;;
  }
  return $output;
}

function kode_mark_transaksi($id_cust,$id_cgrup,$kode,$kodeg)
{
  //$this->load->model('Mtransaksi')
  if($id_cust != 0){
    $return = $kode;
  }else if($id_cgrup != 0){
    $return = $kodeg;
  }
  return $return;
}



function laba_titip_transfer($jumlah_rmb,$jumlah_rmb2,$fee_cs,$fee_bank,$kurs_beli2,$kurs_beli,$kurs_jual)
{
  //$this->load->model('Mtransaksi')
  if($jumlah_rmb < 10000){
    $jual = ($jumlah_rmb+$fee_cs+$jumlah_rmb2) * $kurs_jual;
    if($jumlah_rmb2 != 0){
      $beli = ($jumlah_rmb * $kurs_beli) + ($jumlah_rmb2 * $kurs_beli2) + ($fee_cs * $kurs_beli2);
    }else if($jumlah_rmb2 == 0 && $kurs_beli2 != 0){
      $beli = ($jumlah_rmb * $kurs_beli) + ($jumlah_rmb2 * $kurs_beli2) + ($fee_cs * $kurs_beli2);
    }else{
      $beli = ($jumlah_rmb+$fee_cs+$fee_bank) * $kurs_beli;
    }

  }else if($jumlah_rmb >= 10000){
    $jual = ($jumlah_rmb+$fee_cs) * $kurs_jual;
    $beli = ($jumlah_rmb * $kurs_beli) + 100000;
  }
  $return = $jual - $beli;

  return $return;
}

function view_kelas_impor($status)
{
  if($status != 1){
    $output = '<center><a href="javascript:void(0);" class="proses_konfirmasi btn btn-warning btn-xs" data-id_daftar_kelas_impor="$1"> <i class="fa fa-credit-card"></i></a> </center>';
  }else{
    $output = "<center><b>Paid</b></center>";
  }
  return $output;
}


function keterangan_request_resi($id_req , $supp , $tel , $jmlh , $gudang){
  if($id_req == 0){
    $output = "Request Pl & Inv";
  }else{
    $output = "<label>Supplier : ".$supp."</label><p></p>
               <label>Tel : ".$tel."</label><p></p>
               <label>Jumlah Koli : ".$jmlh."</label><p></p>
               <label>Gudang : ".$gudang."</label>";
  }
  return $output;
}

function view_pl($nresi , $encrypt_resi , $id_file_packing , $kode , $pesan_tolak , $idreq){
  if($idreq == 0){
    $output = '<a onclick="view_packing('.$id_file_packing.')" class="btn btn-danger btn-xs" alt="Update Data"> <i class="fa fa-file-image-o"></i></a>
               <a href="javascript:void(0);" class="upload_pl btn btn-info btn-xs" data-encrypt_resi="'.$encrypt_resi.'"><i class="fa fa-upload"></i></a>
               <a href="javascript:void(0);" class="tolak_pl btn btn-warning btn-xs" data-encrypt_resi="'.$encrypt_resi.'" data-nomor_resi="'.$nresi.'"
                   data-kode="'.$kode.'"  data-pesan_tolak="'.$pesan_tolak.'"><i class="fa fa-user"></i></a>';
  }else{
    $output = '<a onclick="view_packing('.$id_file_packing.')" class="btn btn-danger btn-xs" alt="Update Data"> <i class="fa fa-file-image-o"></i></a>
               <a href="javascript:void(0);" class="add_resi btn btn-success btn-xs" data-nomor_resi="'.$nresi.'"><i class="fa fa-upload"></i></a>
               <a href="javascript:void(0);" class="tolak_resi btn btn-warning btn-xs" data-encrypt_resi="'.$encrypt_resi.'" data-nomor_resi="'.$nresi.'"
                   data-kode="'.$kode.'"  data-pesan_tolak="'.$pesan_tolak.'"><i class="fa fa-user"></i></a>';
  }
  return $output;
}

function req_kode($id_req , $kode , $real_kode ){
  if($id_req == 0){
    $output = $kode;
  }else{
    $output = $real_kode;
  }
  return $output;
}
