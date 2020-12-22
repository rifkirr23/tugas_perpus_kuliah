<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Office Wilopo Cargo</title>
  <link rel="icon" href="<?php echo base_url('assets/logo.jpg'); ?>">
  <link rel="shortcut icon" href="<?php echo base_url('assets/logo2.jpg'); ?>">

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- assets style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/dist/css/AdminLTE.min.css">

  <link rel="stylesheet" href="<?php echo base_url() ?>assets/login.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/dist/css/skins/_all-skins.min.css">
  <!-- Java Script -->

  <!-- Izi Alert-->
</head>

<div class="bg"></div>
<div class="bg bg2"></div>
<div class="bg bg3"></div>

  <div class="row">
    <div class="login-box">
   <!-- /.login-logo -->
   <div class="login-box-body">
   	 <p class="text-center" style="margin-top:20px;"><img src="<?php echo base_url('assets/logo3.jpg'); ?>" alt="" style="width:290px;height:80px;"></p>
     <p class="login-box-msg" style="font-size:100%;">Silahkan Contact Cs Kami via Whatsapp</p>
     <?php if($this->session->flashdata('msg')=='okee'){ ?>
       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"> b
           <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
       </div></p>
        <?php } ?>

     <form action="<?php echo base_url('api/chat_sales/proses_chat'); ?>" method="post">
       <div class="form-group has-feedback">
         <input type="text" name="" value="<?php echo $sales->nama_pengguna ?>" class="form-control" placeholder="Number Sales" required="" autocomplete="" autofocus="" readonly>
         <span class="glyphicon glyphicon-user form-control-feedback"></span>
       </div>

       <div class="form-group has-feedback">
         <input type="text" name="whatsapp_sales" value="<?php echo $sales->whatsapp ?>" class="form-control" placeholder="Number Sales" required="" autocomplete="" autofocus="" readonly>
         <span class="glyphicon glyphicon-user form-control-feedback"></span>
       </div>
       <div class="form-group has-feedback">
         <textarea type="text" name="pesan"  class="form-control" placeholder="Pesan" required="" autocomplete="off" rows="4" cols="100">Hai jadi Saya Mau Tanya-Tanya Tentang Jasa Import Barang Dari China.</textarea>
         <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
       </div>
       <button type="submit" name="submit" class="btn btn-danger btn-block btn-flat" style="font-size: 15px;">Send Chat <i class="glyphicon glyphicon-edit"></i></button>
     </form>
   </div>
   <!-- /.login-box-body -->
  </div>
 </div>


<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url() ?>assets/jquery/loadingoverlay.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url() ?>assets/bootstrap/js/bootstrap.min.js"></script>
<script>
//angka 500 dibawah ini artinya pesan akan muncul dalam 0,5 detik setelah document ready
$(document).ready(function(){setTimeout(function(){$(".alert").fadeIn('fast');}, 100);});
//angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
setTimeout(function(){$(".alert").fadeOut('fast');}, 5000);

</script>
<script type="text/javascript">
  $('form').submit(function() {
    $.LoadingOverlay("show");
  });
</script>
</body>
</html>
