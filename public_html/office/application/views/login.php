
<?php if($this->session->userdata('level')=='admin' || $this->session->userdata('level')=='admin2' || $this->session->userdata('level')=='suadmin')
      { redirect(base_url('dashboard')); } ?>

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
      <div class="login-logo">
       <h1 style="color:#fff;">OFFICE</h1>
      </div>
   <!-- /.login-logo -->
   <div class="login-box-body">
   	 <p class="text-center"><img src="<?php echo base_url('assets/logo2.jpg'); ?>" alt="" style="width:290px;height:160px;"></p>
     <p class="login-box-msg" style="font-size:100%;">Masukkan Username dan Password</p>
     <?php if($this->session->flashdata('msg')=='gagal'){ ?>
       <p><div style="display: none;" class="alert alert-danger alert-dismissable">Username atau Password Salah!
           <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
       </div></p>
     <?php } ?>

     <?php if($this->session->flashdata('msg')=='nonaktif'){ ?>
       <p><div style="display: none;" class="alert alert-warning alert-dismissable">Akun Anda Dinonaktifkan!
           <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
       </div></p>
     <?php } ?>

     <?php if($this->session->flashdata('msg')=='noaccess'){ ?>
       <p><div style="display: none;" class="alert alert-warning alert-dismissable">Please Re Login
           <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
       </div></p>
     <?php } ?>

     <?php if($this->session->flashdata('msg')=='okee'){ ?>
       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"> Change Password Success Please Login With New Password
           <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
       </div></p>
        <?php } ?>

     <form action="<?php echo base_url('login/proses'); ?>" method="post">
       <div class="form-group has-feedback">
         <input type="text" name="username" class="form-control" placeholder="Username" required="" autocomplete="" autofocus="">
         <span class="glyphicon glyphicon-user form-control-feedback"></span>
       </div>
       <div class="form-group has-feedback">
         <input type="password" name="password" class="form-control" placeholder="Password" required="" autocomplete="off">
         <span class="glyphicon glyphicon-lock form-control-feedback"></span>
       </div>
       <button type="submit" name="submit" class="btn btn-primary btn-block btn-flat" style="font-size: 15px;">Login <i class="glyphicon glyphicon-log-in"></i></button>
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
