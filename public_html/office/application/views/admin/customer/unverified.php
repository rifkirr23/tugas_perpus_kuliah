<head>
   <meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
   <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
</head>

<?php if($this->session->flashdata('msg')=='okeverif'){ ?>

   <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Verifikasi Customer Berhasil
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  </div></p>

<?php } ?>

<?php if($this->session->flashdata('msg')=='sudahada'){ ?>

   <p><div style="display: none;" class="alert alert-warning alert-dismissable"><i class="icon fa fa-warning"></i>Marking Sudah Ada Ya
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  </div></p>

<?php } ?>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4 class="pull-left" class="form-control"><b>Customer Unverified <?php ?></b></h4>
        <form method="post" action="<?php echo base_url('admin/customer/cek_customer') ?>">
          <span class="pull-right" style="margin-right:5px;">
            <input type="text" name="kode" class="form-control" value="<?php  ?>" placeholder="Marking"/>
          </span>
          <span class="pull-right" style="margin-right:5px;">
            <input type="text" name="email" class="form-control" value="<?php  ?>" placeholder="Email"/>
          </span>
          <span class="pull-right" style="margin-right:5px;">
            <input type="submit" name="max" class="form-control btn btn-info" value="Search"/>
          </span>
        </form>
    </div>
    <p><i><center>Silahkan Cari Kode Marking Atau Email Customer Yang Ingin di Verifikasi</center></i></p>
  </div>
</div>
<?php
if($cek_customer->id_pendaftar > 0){
  $pendaftar = $cek_customer->nama_pengguna;
}else{
  $pendaftar = $cek_customer->nama_crm;
}
 ?>
<form id="add-row-form" action="<?php echo base_url().'admin/customer/verifikasi'?>" method="post" enctype="multipart/form-data">
  <div class="modal fade" id="Munverified"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Form Verifikasi Customer</h4>
            </div>
            <div class="modal-body">
              <input type="hidden" name="id_cust" value="<?php echo $cek_customer->id_cust ?>">
              <div class="form-group">
              <label>Nama</label>
                  <input type="text" class="form-control" value="<?php echo $cek_customer->nama ?>" readonly>
              </div>
              <div class="form-group">
              <label>Marking</label>
                  <input type="text" class="form-control" value="<?php echo $cek_customer->kode ?>" name="kode">
              </div>
              <div class="form-group">
              <label>Email</label>
                  <input type="text" class="form-control" value="<?php echo $cek_customer->email ?>" readonly>
              </div>
              <div class="form-group">
              <label>Whatsapp</label>
                  <input type="text" name="whatsapp" class="form-control" value="<?php echo $cek_customer->whatsapp ?>" >
              </div>
              <div class="form-group">
              <label>Pendaftar</label>
                  <input type="text"  class="form-control" value="<?php echo $pendaftar ?>" readonly>
              </div>

              <div class="form-group">
              <label>Status</label>
                  <input type="text" class="form-control" value="<?php echo $cek_customer->s_aktivasi ?>" readonly>
              </div>
            </div>
            <div class="modal-footer">
                 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                 <?php if($cek_customer->s_aktivasi != "Sudah Aktivasi"){ ?>
                   <button type="submit" id="add-row" class="btn btn-primary">Verifikasi</button>
                 <?php } ?>
            </div>
         </div>
     </div>
  </div>
</form>

<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<?php if ($cek > 0){ ?>
  <script type="text/javascript">
    $(document).ready(function(){
      $(window).on('load',function(){
          $('#Munverified').modal('show');
      });
    });
  </script>
<?php } ?>
<script type="text/javascript">
    $(document).ready(function(){setTimeout(function(){$(".alert").fadeIn('fast');}, 100);});
      //angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
      setTimeout(function(){$(".alert").fadeOut('fast');}, 7000);
</script>
