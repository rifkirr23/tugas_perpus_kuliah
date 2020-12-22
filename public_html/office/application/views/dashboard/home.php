<link rel="stylesheet" href="<?php echo base_url().'assets/chart/morris.css'?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
<?php if($this->session->userdata('level')=="admin" || $this->session->userdata('level')=="suadmin" || $this->session->userdata('level')=="finance"){ ?>
<!-- Small boxes (Stat box) -->
<div class="row">
<div class="col-lg-3 col-xs-6">
<!-- small box -->
<div class="small-box bg-aqua">
  <div class="inner">
    <h3><?php echo $customer ?></h3>
    <p>Data Customer</p>
  </div>
  <div class="icon">
    <i class="fa fa-user"></i>
  </div>
  <a href="<?php echo site_url() ?>admin/customer" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
</div>
</div>
<!-- ./col -->

<div class="col-lg-3 col-xs-6">
<!-- small box -->
<div class="small-box bg-yellow">
  <div class="inner">
    <h3><?php echo $transaksi ?></h3>

    <p>Data Transaksi</p>
  </div>
  <div class="icon">
    <i class="fa fa-bookmark-o"></i>
  </div>
  <a href="<?php echo site_url() ?>admin/transaksi" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
</div>
</div>
<!-- ./col -->


<div class="col-lg-3 col-xs-6">
<!-- small box -->
<div class="small-box bg-green">
  <div class="inner">
    <h3><?php echo $invoice ?><sup style="font-size: 20px"></sup></h3>

    <p>Data Invoice</p>
  </div>
  <div class="icon">
    <i class="fa fa-envelope"></i>
  </div>
  <a href="<?php echo site_url() ?>admin/invoice" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
</div>
</div>
<!-- ./col -->
<div class="col-lg-3 col-xs-6">
<!-- small box -->
<div class="small-box bg-maroon">
  <div class="inner">
    <h3><?php echo $pembayaran ?></h3>

    <p>Data Pembayaran</p>
  </div>
  <div class="icon">
    <i class="fa fa-credit-card"></i>
  </div>
  <a href="<?php echo site_url() ?>admin/pembayaran" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
</div>
</div>
</div>

<?php if($total_rmb < 10000){ ?>
<p><div style="" class="alert alert-danger alert-dismissable"><i class="icon fa fa-minus"></i>
  Jumlah Rmb Kurang dari 10.000 :(  Silahkan Isi ulang <i class="icon fa fa-money"></i>
   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
</div></p>
<?php } ?>

<?php if($cek_rmb > 0){ ?>
<p><div style="" class="alert alert-success alert-dismissable"><i class="icon fa fa-minus"></i>
 Isi Ulang Saldo <i class="icon fa fa-check"></i>
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
</div></p>
<?php } ?>

<div class="row">
<div class="col-lg-6 col-xs-8">
<!-- Info Boxes Style 2 -->
<div class="info-box bg-aqua">
  <span class="info-box-icon">¥</span>

  <div class="info-box-content">
    <span class="info-box-text">Jumlah Rmb</span>
    <span class="info-box-number"><?php echo $total_rmb ?></span>

    <div class="progress">
      <div class="progress-bar" style="width: 100%"></div>
    </div>
    <span class="progress-description">
        We Have <?php echo $total_rmb ?> Rmb
    </span>
  </div>
</div>
</div>

<div class="col-lg-6 col-xs-8">
 <!-- Info Boxes Style 2 -->
 <div class="info-box bg-yellow">
   <span class="info-box-icon"><i class="icon fa fa-credit-card"></i></span>

   <div class="info-box-content">
     <span class="info-box-text">Saldo Bank</span>
     <span class="info-box-number"><?php echo "Rp. " . number_format($rowbank); ?></span>

     <div class="progress">
       <div class="progress-bar" style="width: 100%"></div>
     </div>
     <span class="progress-description">
           We Have Rp. <?php echo number_format($rowbank->saldo_bank); ?>
     </span>
   </div>
 </div>
</div>

</div>
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Customer Tidak Fix (Gudang Jakarta)</h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
      </button>
      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <div class="table-responsive">
      <table class="table no-margin">
        <thead>
        <tr>
          <th>Nama</th>
          <th>Kode</th>
          <th>Alamat</th>
          <th>Email</th>
        </tr>
        </thead>
        <tbody id="real_time_afix">

        </tbody>
      </table>
    </div>
    <!-- /.table-responsive -->
  </div>
  <!-- /.box-body -->
  <div class="box-footer clearfix">
    <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Data</a>
  </div>
  <!-- /.box-footer -->
</div>

 <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Resi No Invoice & Packing List</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="table-responsive">
        <table class="table no-margin">
          <thead>
          <tr>
            <th>Semenjak Tanggal</th>
            <th>Nomor Resi</th>
            <th>Kode Marking</th>
            <th>Status</th>
            <th>&nbsp;</th>
          </tr>
          </thead>
          <tbody id="real_time_resi">

          </tbody>
        </table>
      </div>
      <!-- /.table-responsive -->
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix">
      <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Data</a>
    </div>
    <!-- /.box-footer -->
  </div>

<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Laporan Rekap Tahunan</h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
      </button>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <div class="row">
      <div class="col-md-6">
        <p class="text-center">
          <strong>Pengeluaran Bulanan</strong>
        </p>

        <div id="pengeluarantahunan"  style="height: 250px; width: 100%;"></div>
        <!-- /.chart-responsive -->
      </div>
      <!-- /.col -->
      <div class="col-md-6">
        <p class="text-center">
          <strong>CBM Perbulan</strong>
        </p>

        <div id="cbmtahunan"  style="height: 250px; width: 100%;"></div>

      </div>
      <!-- /.col -->


    </div>
    <!-- /.row -->
  </div>
  <!-- ./box-body -->
  <div class="box-footer">
    <div class="row">
      <div class="col-sm-3 col-xs-6">
        <div class="description-block border-right">
          <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>
          <h5 class="description-header">$35,210.43</h5>
          <span class="description-text">TOTAL REVENUE</span>
        </div>
        <!-- /.description-block -->
      </div>
      <!-- /.col -->
      <div class="col-sm-3 col-xs-6">
        <div class="description-block border-right">
          <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
          <h5 class="description-header">$10,390.90</h5>
          <span class="description-text">TOTAL COST</span>
        </div>
        <!-- /.description-block -->
      </div>
      <!-- /.col -->
      <div class="col-sm-3 col-xs-6">
        <div class="description-block border-right">
          <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>
          <h5 class="description-header">$24,813.53</h5>
          <span class="description-text">TOTAL PROFIT</span>
        </div>
        <!-- /.description-block -->
      </div>
      <!-- /.col -->
      <div class="col-sm-3 col-xs-6">
        <div class="description-block">
          <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 18%</span>
          <h5 class="description-header">1200</h5>
          <span class="description-text">GOAL COMPLETIONS</span>
        </div>
        <!-- /.description-block -->
      </div>
    </div>
    <!-- /.row -->
  </div>
  <!-- /.box-footer -->
</div>

<?php } ?>

<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/chart/raphael.js'?>"></script>
<script src="<?php echo base_url().'assets/chart/morris.min.js'?>"></script>

<script>

    Morris.Bar({
      element: 'pengeluarantahunan',
      data: <?php echo $pengeluaran;?>,
      xkey: 'bulan',
      ykeys: ['nominal_keluar'],
      labels: ['Pengeluaran'],
      hideHover:'auto',
    });

    // Morris.Bar({
    //   element: 'cbmtahunan',
    //   data:<?php echo $pengeluaran;?>,
    //   xkey: 'bulan',
    //   ykeys: ['nominal_keluar'],
    //   labels: ['Pengeluaran'],
    //   hideHover:'auto',
    // });
</script>
<!-- <script type="text/javascript">
    setInterval(function(){
      $.ajax({
        type: "POST", // Method pengiriman data bisa dengan GET atau POST
        url: "<?php echo base_url("index.php/admin/realtime/request_resi"); ?>",
        dataType: "json",
        beforeSend: function(e) {
          if(e && e.overrideMimeType) {
            e.overrideMimeType("application/json;charset=UTF-8");
          }
        },
        success: function(response){ // Ketika proses pengiriman berhasil
          //$("#loading").hide(500); // Sembunyikan loadingnya

          // set isi dari combobox kota
          // lalu munculkan kembali combobox kotanya
          $("#real_time_resi").html(response.listresi).show();
        },
        error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
          // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
        }
      }), 100000
 		});
</script>
<script type="text/javascript">
    setInterval(function(){
      $.ajax({
        type: "POST", // Method pengiriman data bisa dengan GET atau POST
        url: "<?php echo base_url("index.php/admin/realtime/afix"); ?>",
        dataType: "json",
        beforeSend: function(e) {
          if(e && e.overrideMimeType) {
            e.overrideMimeType("application/json;charset=UTF-8");
          }
        },
        success: function(response){ // Ketika proses pengiriman berhasil
          //$("#loading").hide(500); // Sembunyikan loadingnya

          // set isi dari combobox kota
          // lalu munculkan kembali combobox kotanya
          $("#real_time_afix").html(response.listcust).show();
        },
        error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
          // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
        }
      }), 100000
 		});
</script> -->
