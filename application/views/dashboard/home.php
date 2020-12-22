<link rel="stylesheet" href="<?php echo base_url().'assets/chart/morris.css'?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
<?php if($this->session->userdata('level')=="admin" || $this->session->userdata('level')=="suadmin" || $this->session->userdata('level')=="finance"){ ?>
<!-- Small boxes (Stat box) -->
<div class="row">
<div class="col-lg-3 col-xs-6">
<!-- small box -->
<div class="small-box bg-red">
  <div class="inner">
    <h3><?php echo $anggota ?></h3>
    <p>Data Anggota</p>
  </div>
  <div class="icon">
    <i class="fa fa-user"></i>
  </div>
  <a href="<?php echo site_url() ?>admin/anggota" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
</div>
</div>
<!-- ./col -->

<div class="col-lg-3 col-xs-6">
<!-- small box -->
<div class="small-box bg-yellow">
  <div class="inner">
    <h3><?php echo $peminjaman ?></h3>

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
    <h3><?php echo $buku ?><sup style="font-size: 20px"></sup></h3>

    <p>Data Buku</p>
  </div>
  <div class="icon">
    <i class="fa fa-envelope"></i>
  </div>
  <a href="<?php echo site_url() ?>admin/buku" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
</div>
</div>

<div class="col-lg-3 col-xs-6">
<!-- small box -->
<div class="small-box bg-blue">
  <div class="inner">
    <h3><?php echo $buku ?><sup style="font-size: 20px"></sup></h3>

    <p>Data Kategori</p>
  </div>
  <div class="icon">
    <i class="fa fa-envelope"></i>
  </div>
  <a href="<?php echo site_url() ?>admin/kategori" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
</div>
</div>
<!-- ./col -->
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
          <strong>Transaksi</strong>
        </p>

        <div id="trsbuku"  style="height: 250px; width: 100%;"></div>
        <!-- /.chart-responsive -->
      </div>
      <!-- /.col -->


    </div>
    <!-- /.row -->
  </div>


<?php } ?>

<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/chart/raphael.js'?>"></script>
<script src="<?php echo base_url().'assets/chart/morris.min.js'?>"></script>

<script>

    Morris.Bar({
      element: 'trsbuku',
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
