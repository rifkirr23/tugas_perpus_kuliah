<head>
  <meta charset="utf-8">
  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link href="<?php echo base_url().'assets/ignited/css/dataTables.bootstrap.css'?>" rel="stylesheet" type="text/css"/>
</head>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Invoice List</b></h3>

    </div>

    <div class="box-body">

    <div class="box-body table-responsive">

    <table class="table table-bordered table-striped " id="mytable">
      <thead>
        <tr>
          <th>Kode Mark Customer</th>
          <th>Kode Transaksi</th>
          <th>Kode Invoice</th>
          <th>Tanggal Invoice</th>
          <th>Total Tagihan</th>
          <th>Total Potongan</th>
          <th>Jumlah Bayar</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
              <?php $no=1; foreach($invoice as $r){ ?>
              <tr>
                  <td><?php echo $r->kode ?></td>
                  <td><?php echo $r->kode_transaksi ?></td>
                  <td><?php echo $r->kode_invoice ?></td>
                  <td><?php echo date_indo($r->tanggal_invoice) ?></td>
                  <td><?php echo "Rp. ". number_format($r->total_tagihan); ?></td>
                  <td><?php echo "Rp. ". number_format($r->total_potongan); ?></td>
                  <td><?php echo "Rp. ". number_format($r->jumlah_bayar); ?></td>
                  <td><?php echo $r->status_invoice ?></td>
              </tr>
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
      <h3 class="box-title"><b>Transaksi List Customer</b></h3>

    </div>

    <div class="box-body">

    <div class="box-body table-responsive">

    <table class="table table-bordered table-striped " id="mytable">
      <thead>
        <tr>
          <th>No.</th>
          <th>Kode Mark Customer</th>
          <th>Kode Transaksi</th>
          <th>Kode Invoice</th>
          <th>Tanggal Transaksi</th>
          <th>Jumlah Rmb</th>
          <th>Kurs Jual</th>
          <th>Kurs Beli</th>
          <th>Fee Bank</th>
          <th>Fee Cs</th>
          <th>Bank Tujuan</th>
          <th>Status</th>

        </tr>
      </thead>
     <tbody>
              <?php $no=1; foreach($transaksi as $f){
              $jumlahdesimal = "0"; $pemisahdesimal = ",";
               $pemisahribuan =".";  $pemisahribuan =".";
                ?>
              <tr>
                  <td><?php echo $no ?></td>
                  <td><?php echo $f->kode ?></td>
                  <td><?php echo $f->kode_transaksi ?></td>
                  <td><?php echo $f->kode_invoice ?></td>
                  <td><?php echo date_indo($f->tanggal_transaksi) ?></td>
                  <td><?php echo "짜 ". number_format($f->jumlah_rmb,$jumlahdesimal,$pemisahdesimal,$pemisahribuan); ?></td>
                  <td><?php echo "Rp. ". number_format($f->kurs_jual,$jumlahdesimal,$pemisahdesimal,$pemisahribuan); ?></td>
                  <td><?php echo "Rp. ". number_format($f->kurs_beli,$jumlahdesimal,$pemisahdesimal,$pemisahribuan); ?></td>
                  <td><?php echo "짜 ". number_format($f->fee_bank,$jumlahdesimal,$pemisahdesimal,$pemisahribuan); ?></td>
                  <td><?php echo "짜 ". number_format($f->fee_cs,$jumlahdesimal,$pemisahdesimal,$pemisahribuan); ?></td>
                  <td><?php echo $f->bank_tujuan ?></td>
                  <?php
                  if($f->status ==1){ $status = "pending"; }
                  else if($f->status ==2){ $status = "process"; }
                  else if($f->status ==3){ $status = "complete"; }
                   ?>
                  <td><?php echo $status ?></td>

              </tr>
              <?php $no++; } ?>
      </tbody>
    </table>
    </div>
    </div>
    </div>
    </div>


    <div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Sub Pembayaran List</b></h3>

    </div>

    <div class="box-body">

    <div class="box-body table-responsive">

    <table class="table table-bordered table-striped " id="mytable">
      <thead>
        <tr>
          <th>No</th>
          <th>Kode Pembayaran</th>
          <th>Jumlah Bayar</th>

        </tr>
      </thead>
     <tbody>
              <?php $no=1; foreach($sub_pembayaran as $qq){ ?>
              <tr>
                  <td><?php echo $no ?></td>
                  <td><?php echo $qq->kode_pembayaran ?></td>
                  <td><?php echo "Rp. ". number_format($qq->jumlah_bayar_sub); ?></td>

              </tr>
              <?php $no++; } ?>
      </tbody>
    </table>
    </div>
    </div>
    </div>
    </div>


    <div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Potongan List</b></h3>

    </div>

    <div class="box-body">

    <div class="box-body table-responsive">

    <table class="table table-bordered table-striped " id="mytable">
      <thead>
        <tr>
          <th>No</th>
          <th>Jenis Potongan</th>
          <th>Jumlah Potongan</th>
          <th>Keterangan</th>

        </tr>
      </thead>
     <tbody>
              <?php $no=1; foreach($potongan as $fz){ ?>
              <tr>
                  <td><?php echo $no ?></td>
                  <td><?php echo $fz->kjenis_potongan ?></td>
                  <td><?php echo "Rp. ". number_format($fz->jumlah_potongan); ?></td>
                  <td><?php echo $fz->keterangan_potongan ?></td>

              </tr>
              <?php $no++; } ?>
      </tbody>
    </table>
    </div>
    </div>
    </div>
    </div>



<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>
