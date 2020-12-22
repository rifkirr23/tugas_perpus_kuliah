<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Jasa Transfer</title>
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
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/dist/css/skins/_all-skins.min.css">
  <!-- Java Script -->
  
  <!-- Izi Alert-->
</head>
<?php ?>
<body style="background:url(<?php echo base_url('assets/img/blogin.jpg'); ?>)
no-repeat center center fixed; background-size: cover;
 -webkit-background-size: cover; 
 -moz-background-size: cover; -o-background-size: cover;">
 <div class="row">
<div class="login-box">
  <div class="login-logo">
    <h1 style="color:#fff;">Change Password </h1>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
  	 <p class="text-center"><img src="<?php echo base_url('assets/logo2.jpg'); ?>" alt="" style="width:290px;height:160px;"></p>
    <p class="login-box-msg" style="font-size:100%;">Masukkan Password Baru</p>  
    
    

    <form action="<?php echo base_url('login/simpancp'); ?>" method="post">
      
      <div class="form-group has-feedback">
         <input type="hidden" name="password_lama" class="form-control" value="<?php echo $change['password'] ?>" placeholder="Password lama" autocomplete="off">
        <input type="password" name="password" class="form-control" placeholder="Password Baru" required="" autocomplete="off">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <button type="submit" name="submit" class="btn btn-primary btn-block btn-flat" style="font-size: 15px;">Save Change <i class="fa fa-check-square"></i></button>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
</div>
<!-- jQuery 2.2.3 -->

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
  $('.btn-flat').on('click', function(){
         $.LoadingOverlay("show");
          console.log('wtheck');
        });
</script>
</body>
</html>

