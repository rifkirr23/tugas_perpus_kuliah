<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
<?php $status_kf = $this->uri->segment(3); ?>
<center>
<div class="jumbotron text-xs-center">
  <?php if($this->session->flashdata('msg')=='success'){ ?>
    <h1 class="display-3">Terima Kasih!</h1>
    <p class="lead"><strong>Resi telah Terkonfirmasi </strong>Barang Anda akan kami loading ke container</p>

  <?php }if($this->session->flashdata('msg')=='gagal_konfirm'){ ?>
    <h1 class="display-3">Terimakasih</h1>
    <p class="lead"><strong>Anda Telah Membeli Asuransi  </strong></p>

  <?php }if($this->session->flashdata('msg')=='no_asuransi'){ ?>
    <h1 class="display-3">Wilopo Cargo</h1>
    <p class="lead"><strong>Anda Berhasil Mengkonfirmasi </strong>Tetapi Tidak Bisa Membeli Asuransi Karena Barang Sudah Dalam Perjalanan </p>

  <?php }if($this->session->flashdata('msg')=='asuransi'){ ?>
    <h1 class="display-3">Terimakasih </h1>
    <p class="lead"><strong>Anda Berhasil Membeli Asuransi </strong>dan Mengkonfirmasi Resi </p>

  <?php }if($this->session->flashdata('msg')=='warning'){ ?>
    <h1 class="display-3">Wilopo Cargo </h1>
    <p class="lead"><strong>Barang Anda Tidak Termasuk Klasifikasi Asuransi Tambahan</strong></p>

  <?php }if($this->session->flashdata('msg')=='sudahkf'){ ?>
    <h1 class="display-3">Wilopo Cargo </h1>
    <p class="lead"><strong>Barang Anda Sudah Terkonfirmasi</strong></p>
  <?php } ?>


  <p>
    Having trouble? <a href="https://wilopocargo.com/index.php?contact">Contact us</a>
  </p>

</div>
</center>

<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
