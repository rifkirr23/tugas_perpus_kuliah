<head>
   <meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
   <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
</head>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4 class="pull-left" class="form-control"><b>Laporan Invoice <?php echo $tanggal_now ?></b></h4>
      <!-- <h4 class="pull-left" class="form-control"><b>Total CBM <?php echo $tanggal_now ." : ". round($total_cbm,3) ?>m<sup>3</sup></b></h4> -->
      <form method="post" action="<?php echo base_url('admin/laporan/filter_master_invoice') ?>">
        <span class="pull-right" style="margin-right:5px;">
          <input type="submit" name="max" class="form-control btn btn-success" value="Filter Date" placeholder="Max Date"/>
        </span>
        <span class="pull-right" style="margin-right:5px;">
          <input type="date" name="max_date" class="form-control" value="<?php echo $now ?>" placeholder="Max Date"/>
        </span>
        <span class="pull-right" style="margin-right:5px;">
          <input type="date" name="min_date" class="form-control" value="<?php echo $now ?>" placeholder="Min Date"/>
        </span>
      </form>
    </div>
    <div class="box-body">
      <div class="box-body table-responsive">
        <table class="table table-striped no-margin" id="myresia">
          <thead>
            <?php
              $total_seluruhnya = $total_laba + $total_laba_sea + $total_laba_resi_udara + $total_laba_fcl - ($semua_komisi_barang + $semua_komisi_titip_trf);
             ?>
            <tr>
              <td>Total Jumlah Cbm</td>
              <td><b><?php echo round($total_cbm,3) ?> m<sup>3</sup></b></td>
            </tr>
            <tr>
              <td>Total Laba Invoice Sea </td>
              <td><b><?php echo "Rp." . number_format($total_laba_sea) ?></b></td>
            <tr>
            <tr>
              <td>Total Laba Invoice Udara</td>
              <td><b><?php echo "Rp." . number_format($total_laba_resi_udara) ?></b></td>
            <tr>
            <tr>
              <td>Total laba Invoice FCL</td>
              <td><b><?php echo "Rp." . number_format($total_laba_fcl) ?></b></td>
            <tr>
            <tr>
              <td>Total laba Invoice Titip Transfer </td>
              <td><b><?php echo "Rp.". number_format($total_laba) ?></b></td>
            <tr>
            <tr>
              <td colspan="2"><center>&nbsp;</center></td>
            </tr>
            <tr>
              <td>Komisi Barang</td>
              <td><b><?php echo "Rp." . number_format($semua_komisi_barang) ?></b></td>
            <tr>
            <tr>
              <td>Komisi Titip Transfer </td>
              <td><b><?php echo "Rp.". number_format($semua_komisi_titip_trf) ?></b></td>
            <tr>
            <tr>
              <td colspan="2"><center>&nbsp;</center></td>
            <tr>
            <tr>
              <td><h4><b>Total Laba</b></h4></td>
              <td><h4><b><?php echo "Rp.". number_format($total_seluruhnya) ?></b></h4></td>
            <tr>
            <tr>
              <td>Total Asuransi</td>
              <td><b><?php echo "Rp.". number_format($total_asuransi) ?></b></td>
            </tr>
            <tr>
              <td colspan="2"><center>&nbsp;</center></td>
            </tr>
            <tr>
              <td colspan="2"><b>Pengeluaran</b></td>
            </tr>
            <?php $total_pengeluaran=0; foreach ($pengeluaran_perkategori as $pengeluarank){ ?>
              <tr>
                <td><?php echo $pengeluarank->kjenis_transaksi_bank; ?></td>
                <td><?php echo "Rp.". number_format($pengeluarank->jumlah) ?></td>
              <tr>
            <?php $total_pengeluaran +=$pengeluarank->jumlah; } ?>
            <tr>
              <td><h4><b>Total Pengeluaran</b></h4></td>
              <td><h4><b><?php echo "Rp.". number_format($total_pengeluaran) ?></b></h4></td>
            <tr>

            <tr>
              <td><h4><b>Total Laba Bersih</b></h4></td>
              <td><h4><b><?php echo "Rp.". number_format($total_seluruhnya - $total_pengeluaran) ?></b></h4></td>
            <tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

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
              <th>Action</th>
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
              <td><a href="<?php echo site_url('admin/invoice_barang/detail/'.$rs->id_invoice) ?>" class="btn btn-info btn-xs"> <i class="fa fa-ellipsis-h"></i></a></td>
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
      <h3 class="box-title"><b>Laporan Data Resi Udara <?php echo $tanggal_now ?></b></h3>
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
              <th>Action</th>
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
              <td><a href="<?php echo site_url('admin/resi_udara/invoice_detail/'.$ra->id_invoice.'/'.$ra->id_resi_udara.'/air') ?>" class="btn btn-info btn-xs"> <i class="fa fa-ellipsis-h"></i></a></td>
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
              <th>Action</th>
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
              <td><a href="<?php echo site_url('admin/resi_udarf/invoice_detail/'.$rf->id_invoice.'/'.$rf->id_resi_udara.'/air') ?>" class="btn btn-info btn-xs"> <i class="fa fa-ellipsis-h"></i></a></td>
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
              <th>Jumlah Rmb2</th>
              <th>Kurs Jual</th>
              <th>Kurs Beli</th>
              <th>Kurs Beli2</th>
              <th>Fee Bank</th>
              <th>Fee Cs</th>
              <th>Status</th>
              <th>Laba</th>
              <th>Komisi</th>
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
              <td><?php echo "¥ ".$trf->jumlah_rmb ?></td>
              <td><?php echo "¥ ".$trf->jumlah_rmb2 ?></td>
              <td><?php echo "Rp." . number_format($trf->kurs_jual) ?></td>
              <td><?php echo "Rp." . number_format($trf->kurs_beli) ?></td>
              <td><?php echo "Rp." . number_format($trf->kurs_beli2) ?></td>
              <td><?php echo "¥ ". $trf->fee_bank ?></td>
              <td><?php echo "¥ ".$trf->fee_cs ?></td>
              <td><?php echo $status ?></td>
              <td><?php echo "Rp." . number_format($laba) ?></td>
              <td><?php echo "Rp." . number_format($komisi_trf) ?></td>
              <td><?php echo "Rp." . number_format($laba_bersih_trf) ?></td>
            </tr>
          </tbody>
          <?php } ?>
        </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<br/><br/>
<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Laporan Asuransi <?php echo $tanggal_now ?></b></h3>
    </div>
    <div class="box-body">
      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped no-margin" id="myasuransi">
          <thead>
            <tr>
              <th>Kode Mark Customer</th>
              <th>Resi</th>
              <th>Invoice</th>
              <th>Tanggal Asuransi</th>
              <th>Formula</th>
              <th>Jumlah</th>
            </tr>
          </thead>
          <?php foreach($record_asuransi as $asr){
          ?>
          <tbody>
            <tr>
              <td><?php echo $asr->kode ?></td>
              <td><?php echo $asr->nomor_resi ?></td>
              <td><?php echo $asr->kode_invoice ?></td>
              <td><?php echo date_indo($asr->tanggal_inv_asuransi) ?></td>
              <td><?php echo $asr->note ?></td>
              <td><?php echo "Rp." . number_format($asr->jumlah_asuransi) ?></td>
            </tr>
          </tbody>
          <?php } ?>
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
