<head>
   <meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
   <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
</head>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4 class="pull-left" class="form-control"><b>Laporan Penjualan <?php echo $tanggal_now ?></b></h4>
      <!-- <h4 class="pull-left" class="form-control"><b>Total CBM <?php echo $tanggal_now ." : ". round($total_cbm,3) ?>m<sup>3</sup></b></h4> -->
      <?php if($this->session->userdata('level') == "sales"){ ?>
        <form method="post" action="<?php echo base_url('admin/laporan/filter_sales') ?>">
          <span class="pull-right">
            <input type="submit" name="max" class="form-control btn btn-success" value="Filter Date" placeholder="Max Date"/>
          </span>
          <span class="pull-right">
            <input type="date" name="max_date" class="form-control" value="<?php echo $now ?>" placeholder="Max Date"/>
          </span>
          <span class="pull-right">
            <input type="date" name="min_date" class="form-control" value="<?php echo $now ?>" placeholder="Min Date"/>
          </span>
          <span class="pull-right">
            <select class="form-control" name="id_sales">
              <?php foreach ($data_sales as $ds ){ ?>
                <option value="<?php echo $ds->id_pengguna; ?>"><?php echo $ds->username ?></option>
              <?php } ?>
            </select>
          </span>
        </form>
      <?php }else{ ?>
        <form method="post" action="<?php echo base_url('admin/laporan/filter_sales') ?>">
          <span class="pull-right" style="margin-right:5px;">
            <input type="submit" name="max" class="form-control btn btn-success" value="Filter Date" placeholder="Max Date"/>
          </span>
          <span class="pull-right" style="margin-right:5px;">
            <input type="date" name="max_date" class="form-control" value="<?php echo $now ?>" placeholder="Max Date"/>
          </span>
          <span class="pull-right" style="margin-right:5px;">
            <input type="date" name="min_date" class="form-control" value="<?php echo $now ?>" placeholder="Min Date"/>
          </span>
          <span class="pull-right" style="margin-right:5px;">
            <select class="form-control" name="id_sales">
              <?php foreach ($data_sales as $ds ){
                echo "<option value='$ds->id_pengguna'";
                echo $id_sales==$ds->id_pengguna?'selected':'';
                echo ">$ds->username</option>";
              } ?>
            </select>
          </span>
        </form>
      <?php } ?>
    </div>
    <div class="box-body">
      <div class="box-body table-responsive">
        <table class="table table-striped no-margin" id="myresia">
          <thead>
            <?php
              $total_seluruhnya = $total_laba + $total_laba_sea + $total_laba_resi_udara + $total_laba_fcl - ($semua_komisi_barang + $semua_komisi_titip_trf);
              $cek_sales = $this->db->where('id_pengguna',$id_sales)->get('pengguna')->row();
              if($cek_sales->level == "sales"){
                $pembagiankomisi = 10;
              }else if($cek_sales->level == "saleso"){
                $pembagiankomisi = 133;
              }else if($cek_sales->level == "crm"){
                $pembagiankomisi = 100;
              }
             ?>
            <tr>
              <td>Total Jumlah Cbm Resi Sea</td>
              <td><b><?php echo round($total_cbm,3) ?> m<sup>3</sup></b></td>
            </tr>
            <tr>
              <td>Total Perkiraan Laba Resi Sea</td>
              <td><b><?php echo "RP.". number_format($total_perkiraan_laba_resi/$pembagiankomisi) ?></sup></b></td>
            </tr>
            <tr>
              <td>Total Komisi Invoice Sea </td>
              <td><b><?php echo "Rp." . number_format($total_laba_sea/$pembagiankomisi) ?></b></td>
            <tr>
            <tr>
              <td>Total Komisi Invoice Udara</td>
              <td><b><?php echo "Rp." . number_format($total_laba_resi_udara/$pembagiankomisi) ?></b></td>
            <tr>
            <tr>
              <td>Total Komisi Invoice FCL</td>
              <td><b><?php echo "Rp." . number_format($total_laba_fcl/$pembagiankomisi) ?></b></td>
            <tr>
            <tr>
              <td>Total Komisi Invoice Titip Transfer </td>
              <td><b><?php echo "Rp.". number_format($total_laba/$pembagiankomisi) ?></b></td>
            <tr>
            <tr>
              <td colspan="2"><center>&nbsp;</center></td>
            <tr>
            <tr>
              <td><h4><b>Total Komisi</b></h4></td>
              <td><h4><b><?php echo "Rp.". number_format($total_seluruhnya/$pembagiankomisi) ?></b></h4></td>
            <tr>
            <tr>
              <td colspan="2"><center>&nbsp;</center></td>
            </tr>

          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
<?php if($this->session->userdata('level') != "a"){ ?>
<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Laporan Data Resi <?php echo $tanggal_now ?></b></h3>
    </div>

    <div class="box-body">
      <div class="box-body table-responsive">

        <table class="table table-bordered table-striped no-margin" id="myresi">
          <thead>
            <tr>
              <th>Kode Mark Customer</th>
              <th>Nomor</th>
              <th>Tanggal</th>
              <!-- <th>Supplier</th>
              <th>Tel</th>
              <th>Note</th> -->
              <th>Gudang</th>
              <th>Status</th>
              <th>Cbm</th>
              <th>Komisi </th>
              <!-- <th>Action</th> -->
            </tr>
          </thead>
          <?php $totalallll = 0; foreach($record_resi as $rr){
            // Row Gudang
            if($rr->gudang == 5){
               $gudang = "Ghuangzhou";
            }else{
               $gudang = "Yiwu";
            }

            // Row Status
            if($rr->konfirmasi_resi == 0){
               $status = "Belum Konfirmasi";
            }else if($rr->konfirmasi_resi == 1){
              $status = "Konfirmasi";
            }else if($rr->konfirmasi_resi == 2){
              $status = "Konfirmasi & Asuransi";
            }
            // row cbm
            $countcbm = $this->db->select('sum(giw.volume*giw.ctns) as cbm')
                                  ->from('giw')
                                  ->where('giw.resi_id',$rr->id_resi)
                                  ->get()->row();
            $cbmresi = $countcbm->cbm;

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
            // print_r($total_jual);die()
          ?>
          <tbody>
            <tr>
              <td><?php echo $rr->kode ?></td>
              <td><?php echo $rr->nomor ?></td>
              <td><?php echo date_indo($rr->tanggal) ?></td>
              <!-- <td><?php echo $rr->supplier ?></td>
              <td><?php echo $rr->tel ?></td>
              <td><?php echo $rr->note ?></td> -->
              <td><?php echo $gudang ?></td>
              <td><?php echo $status ?></td>
              <td><?php echo round($cbmresi,3) ?> m<sup>3</sup></td>
              <td><?php echo "Rp." . number_format((($total_jual-$total_beli)-$komisi_ref)/$pembagiankomisi) ?></td>
              <!-- <td><a href="<?php echo site_url('admin/resi/detail/'.$rr->id_resi) ?>" class="btn btn-info btn-xs"> <i class="fa fa-ellipsis-h"></i></a></td> -->
            </tr>
          </tbody>
          <?php $totalallll +=$komisi_ref; }  ?>
        </tbody>
       </table>
     </div>
   </div>
 </div>
</div>
<?php } ?>
<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Laporan Data Invoice Sea <?php echo $tanggal_now ?></b></h3>
    </div>

    <div class="box-body">
      <div class="box-body table-responsive">

        <table class="table table-bordered table-striped no-margin" id="myresi">
          <thead>
            <tr>
              <th>Kode Mark Customer</th>
              <th>Invoice Jual</th>
              <th>Invoice Beli</th>
              <th>Tanggal</th>
              <th>Total Jual</th>
              <th>Total Beli</th>
              <th>Laba</th>
              <th>Komisi</th>
              <th>Laba Bersih</th>
              <th>Presentase</th>
              <!-- <th>Action</th> -->
            </tr>
          </thead>
          <?php foreach($record_sea as $rs){
            $get_komisi_referal = $this->db->where('id_invoice',$rs->id_invoice)->get('komisi_referal')->row();
            if($get_komisi_referal->nilai > 0){
              $komisi_barang = $get_komisi_referal->nilai;
            }else{
              $komisi_barang = 0;
            }
            $labasea    = $rs->total_tagihan - $rs->jumlah_invoice_beli;
            $lababersih = $labasea - $komisi_barang;
            $presentase = ($lababersih/$rs->total_tagihan) * 100;
          ?>
          <tbody>
            <tr>
              <td><?php echo $rs->kode ?></td>
              <td><?php echo $rs->kode_invoice ?></td>
              <td><?php echo $rs->kode_invoice_beli ?></td>
              <td><?php echo $rs->tanggal_invoice ?></td>
              <td><?php echo "Rp." . number_format($rs->total_tagihan) ?></td>
              <td><?php echo "Rp." . number_format($rs->jumlah_invoice_beli) ?></td>
              <td><?php echo "Rp." . number_format($labasea) ?></td>
              <td><?php echo "Rp." . number_format($komisi_barang) ?></td>
              <td><?php echo "Rp." . number_format($lababersih) ?></td>
              <td style="text-align:center;"><?php echo round($presentase) ?>%</td>
              <!-- <td><a href="<?php echo site_url('admin/invoice_barang/detail/'.$rs->id_invoice) ?>" class="btn btn-info btn-xs"> <i class="fa fa-ellipsis-h"></i></a></td> -->
            </tr>
          </tbody>
          <?php } ?>
        </tbody>
       </table>
     </div>
   </div>
 </div>
</div>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Laporan Invoice Resi Udara <?php echo $tanggal_now ?></b></h3>
    </div>

    <div class="box-body">
      <div class="box-body table-responsive">

        <table class="table table-bordered table-striped no-margin" id="myresi">
          <thead>
            <tr>
              <th>Kode Mark Customer</th>
              <th>Resi</th>
              <th>Invoice Jual</th>
              <th>Invoice Beli</th>
              <th>Nama Barang</th>
              <th>Ctns</th>
              <th>Berat</th>
              <th>Tanggal Resi</th>
              <th>Total Jual</th>
              <th>Total Beli</th>
              <th> Laba</th>
              <!-- <th>Action</th> -->
            </tr>
          </thead>
          <?php foreach($record_air as $ra){
            $labaair = $ra->total_tagihan - $ra->jumlah_invoice_beli
          ?>
          <tbody>
            <tr>
              <td><?php echo $ra->kode ?></td>
              <td><?php echo $ra->nomor_resi ?></td>
              <td><?php echo $ra->kode_invoice ?></td>
              <td><?php echo $ra->kode_invoice_beli ?></td>
              <td><?php echo $ra->nama_barang ?></td>
              <td><?php echo $ra->ctns ?></td>
              <td><?php echo $ra->berat ?> Kg</td>
              <td><?php echo $ra->tanggal_resi ?></td>
              <td><?php echo "Rp." . number_format($ra->total_tagihan) ?></td>
              <td><?php echo "Rp." . number_format($ra->jumlah_invoice_beli) ?></td>
              <td><?php echo "Rp." . number_format($labaair) ?></td>
              <!-- <td><a href="<?php echo site_url('admin/resi_udara/invoice_detail/'.$ra->id_invoice.'/'.$ra->id_resi_udara.'/air') ?>" class="btn btn-info btn-xs"> <i class="fa fa-ellipsis-h"></i></a></td> -->
            </tr>
          </tbody>
          <?php } ?>
        </tbody>
       </table>
     </div>
   </div>
 </div>
</div>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Laporan Data FCL <?php echo $tanggal_now ?></b></h3>
    </div>

    <div class="box-body">
      <div class="box-body table-responsive">

        <table class="table table-bordered table-striped no-margin" id="myresi">
          <thead>
            <tr>
              <th>Kode Mark Customer</th>
              <th>Invoice Jual</th>
              <th>Invoice Beli</th>
              <th>Tanggal Resi</th>
              <th>Total Jual</th>
              <th>Total Beli</th>
              <th>Laba</th>
              <th>Presentase</th>
              <!-- <th>Action</th> -->
            </tr>
          </thead>
          <?php foreach($record_fcl as $rf){
            $labaair = $rf->total_tagihan - $rf->jumlah_invoice_beli;
          ?>
          <tbody>
            <tr>
              <td><?php echo $rf->kode ?></td>
              <td><?php echo $rf->kode_invoice ?></td>
              <td><?php echo $rf->kode_invoice_beli ?></td>
              <td><?php echo $rf->tanggal_invoice ?></td>
              <td><?php echo "Rp." . number_format($rf->total_tagihan) ?></td>
              <td><?php echo "Rp." . number_format($rf->jumlah_invoice_beli) ?></td>
              <td><?php echo "Rp." . number_format($labaair) ?></td>
              <!-- <td><a href="<?php echo site_url('admin/resi_udarf/invoice_detail/'.$rf->id_invoice.'/'.$rf->id_resi_udara.'/air') ?>" class="btn btn-info btn-xs"> <i class="fa fa-ellipsis-h"></i></a></td> -->
            </tr>
          </tbody>
          <?php } ?>
        </tbody>
       </table>
     </div>
   </div>
 </div>
</div>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Laporan Titip Transfer <?php echo $tanggal_now ?></b></h3>
    </div>
    <div class="box-body">
      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped no-margin" id="mytrf">
          <thead>
            <tr>
              <th>Kode Mark Customer</th>
              <th>Kode Transaksi</th>
              <th>Kode Invoice</th>
              <th>Tanggal Transaksi</th>
              <th>Jumlah Rmb</th>
              <th>Laba Bersih</th>
            </tr>
          </thead>
          <?php foreach($record_trf as $trf){
            $get_komisi_trf = $this->db->where('id_invoice',$trf->id_invoice)->get('komisi_referal')->row();
            if($get_komisi_trf->nilai > 0){
              $komisi_trf = $get_komisi_trf->nilai;
            }else{
              $komisi_trf = 0;
            }
            // Row Kode
            if($trf->id_cust == 0){
               $kode = $trf->kode_cgrup;
            }else if($trf->id_cgrup == 0){
               $kode = $trf->kode;
            }

            // Row Kode
            if($trf->status == 1){
               $status = "Process";
            }else if($trf->status == 2){
               $status = "Process";
            }else if($trf->status == 3){
               $status = "Complete";
            }

            $laba        = laba_titip_transfer($trf->jumlah_rmb,$trf->jumlah_rmb2,$trf->fee_cs,$trf->fee_bank,$trf->kurs_beli2,$trf->kurs_beli,$trf->kurs_jual);
            $laba_bersih_trf = $laba - $komisi_trf;

          ?>
          <tbody>
            <tr>
              <td><?php echo $kode ?></td>
              <td><?php echo $trf->kode_transaksi ?></td>
              <td><?php echo $trf->kode_invoice ?></td>
              <td><?php echo $trf->tanggal_transaksi ?></td>
              <td><?php echo "¥ ".($trf->jumlah_rmb+$trf->jumlah_rmb2) ?></td>
              <td><?php echo "Rp." . number_format($laba_bersih_trf/$pembagiankomisi) ?></td>
            </tr>
          </tbody>
          <?php } ?>
        </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>

<script>
$(document).ready(function(){
  // Setup datatables
  $('#myresi').dataTable( {
    "pageLength": 10
  });

  $('#myasuransi').dataTable( {
    "pageLength": 10
  });

  $('#mytrf').dataTable( {
    "pageLength": 10
  });

});
</script>
