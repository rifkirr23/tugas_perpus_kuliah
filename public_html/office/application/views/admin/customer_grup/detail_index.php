<head>
  <meta charset="utf-8">
  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">

</head>

  <?php $idcgrup = $this->uri->segment(4); ?>

  <div class="box-header with-border">
    <h3 class="box-title"><b>Detail Customer Grup </b></h3>
    <span class="pull-right">

    </span>
  </div>

  <div class="box-body">
    <div class="row">

      <div class="col-lg-6">
        <!-- small box -->
        <div class="small-box bg-blue">
          <div class="inner">
            <h3><?php echo round($data_giw->cbm,3) ?> m<sup>3</sup></h3>
            <p>Total Cbm <?php echo bindo(date('m')) ?> </p>
          </div>
          <div class="icon">
            <i></i>
          </div>
          <a href="#" class="small-box-footer">Perbulan</a>
        </div>
      </div>

      <div class="col-lg-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3><?php echo round($all_giw->cbm,3) ?> m<sup>3</sup></h3>
            <p>Total Cbm</p>
          </div>
          <div class="icon">
            <i></i>
          </div>
          <a href="#" class="small-box-footer">Seluruhnya</a>
        </div>
      </div>

      <div class="col-lg-6">
        <!-- small box -->
        <div class="small-box bg-blue">
          <div class="inner">
            <h3><?php echo "Rp." . number_format($invoice_barang->total_semua_tagihan) ?></h3>
            <p>Invoice Barang</p>
          </div>
          <div class="icon">
            <i></i>
          </div>
          <a href="#" class="small-box-footer">Invoice Barang</a>
        </div>
      </div>

      <div class="col-lg-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3><?php echo "Rp." . number_format($invoice_udara->total_semua_tagihan) ?></h3>
            <p>Invoice Udara</p>
          </div>
          <div class="icon">
            <i></i>
          </div>
          <a href="#" class="small-box-footer">Invoice Udara</a>
        </div>
      </div>

      <div class="col-lg-6">
        <!-- small box -->
        <div class="small-box bg-blue">
          <div class="inner">
            <h3><?php echo "Rp." . number_format($invoice_lainnya->total_semua_tagihan) ?></h3>
            <p>Invoice Lainnya</p>
          </div>
          <div class="icon">
            <i></i>
          </div>
          <a href="#" class="small-box-footer">Invoice Lainnya</a>
        </div>
      </div>

      <div class="col-lg-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3><?php echo "Rp." . number_format($invoice_titip_transfer->total_semua_tagihan) ?></h3>
            <p>Invoice Titip Transfer</p>
          </div>
          <div class="icon">
            <i></i>
          </div>
          <a href="#" class="small-box-footer">Invoice Titip Transfer</a>
        </div>
      </div>

      <div class="col-lg-6">
        <!-- small box -->
        <div class="small-box bg-navy">
          <div class="inner">
            <h3><?php echo "Rp." . number_format($r->deposit) ?></h3>
            <p>Deposit</p>
          </div>
          <div class="icon">
            <i></i>
          </div>
          <a href="#" class="small-box-footer">Deposit</a>
        </div>
      </div>

      <div class="col-lg-6">
        <!-- small box -->
        <div class="small-box bg-navy">
          <div class="inner">
            <h3><?php echo "Rp." . number_format($pembayaran->jumlah) ?></h3>
            <p>Pembayaran</p>
          </div>
          <div class="icon">
            <i></i>
          </div>
          <a href="#" class="small-box-footer">Pembayaran</a>
        </div>
      </div>

    </div>
  </div>

<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>
<script src="<?php echo base_url() ?>assets/jquery/loadingoverlay.min.js"></script>
