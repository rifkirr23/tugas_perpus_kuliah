
<?php if(!empty($this->session->userdata('kode')))
      { redirect(base_url('dashboard')); } ?>

<!DOCTYPE html>
<html lang="id">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Wilopo Cargo | Customer Dashboard</title>
    <link rel="icon" type="image/png" href="<?php echo base_url() ?>/assets/register_login/gambar/favicon.png" />
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/register_login/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css?v=22">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/register_login/css/style.css?v=22">

</head>
<body>
   <section class="hal-login">
        <div class="kolom-login">
            <div class="row-login">
                <div class="kolom-25">
                    <div class="text-center">
                        <img class="logo" src="<?php echo base_url() ?>assets/register_login/gambar/logo.png" alt="wilopo">
                        <h3>Selamat datang di<br>halaman Customer Wilopo Cargo</h3>
                    </div>

                </div>
                <div class="kolom-75">
                    <form class="form-login" action="<?php echo base_url('login/proses'); ?>" method="post">
                        <!-- Alert Warning dll -->
						<?php if($this->session->flashdata('msg')=='gagal'){ ?>
                        <div class="alert alert-danger">
                            ID Marking atau Password tidak cocok, silahkan coba lagi!
                        </div>
						<?php } ?>
						 <?php if($this->session->flashdata('msg')=='salahpass'){ ?>
							<div class="alert alert-danger">Password Salah!</div>
						 <?php } ?>
						 <?php if($this->session->flashdata('msg')=='salahus'){ ?>
						   <div class="alert alert-danger">username/kode marking Tidak Terdaftar!</div>
						 <?php } ?>

						 <?php if($this->session->flashdata('msg')=='tidakaktif'){ ?>
						   <div class="alert alert-danger">Akun anda belum aktif, silahkan cek dan verifikasi email anda agar dapat login.</div>
						 <?php } ?>

						 <?php if($this->session->flashdata('msg')=='banned15'){ ?>
						   <div class="alert alert-danger">Anda 3 kali salah memasukan password. Demi Keamanan akun anda, silahkan login setelah <?php echo abs($selisih);?> menit.</div>
						 <?php } ?>

						 <?php if($this->session->flashdata('msg')=='successregis'){ ?>
							<div class="alert alert-success">Silahkan Cek Inbox & Spam Email Anda Untuk Verifikasi email!</div>
						 <?php } ?>

						 <?php if($this->session->flashdata('msg')=='successaktif'){ ?>
							<div class="alert alert-success">Selamat! Anda telah berhasil mendaftar, silahkan Login</div>
						 <?php } ?>

						 <?php if($this->session->flashdata('msg')=='okee' or $this->session->flashdata('msg')=='successreset'){ ?>
						   <div class="alert alert-info">Reset password berhasil. Silahkan login kembali menggunakan password baru Anda.</div>
						 <?php } ?>
						 <?php if($this->session->flashdata('msg')=='berhasilsendreset'){ ?>
						   <div class="alert alert-info">Silahkan Cek Email Anda Untuk Reset Password!</div>
						 <?php } ?>
						 <?php if($this->session->flashdata('msg')=='gagalsendreset'){ ?>
						   <div class="alert alert-danger">Email Atau Marking Anda Tidak Terdaftar!</div>
						 <?php } ?>
                        <!-- End Alert -->
                        <h3 class="judul-form">Login Customer</h3>
                        <div class="mb-3"></div>

                        <!-- Start Form Login -->
                        <div class="form-group" data-toggle="tooltip" title="Masukkan kode marking" data-placement="left">
							<input type="text" name="username" class="form-control form-kostum" placeholder="Email/Kode Marking" required="" autocomplete="" autofocus="">
                        </div>
                        <div class="form-group" data-toggle="tooltip" title="Masukkan password" data-placement="left">
							<input type="password" name="password" class="form-control form-kostum" placeholder="password" required="" autocomplete="off">
                        </div>
                        <!--<div class="custom-control text-left custom-checkbox mb-3">-->
                        <!--    <input type="checkbox" class="custom-control-input" id="customCheck" value="1" name="rememberme">-->
                        <!--</div>-->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="custom-control text-left custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck" name="example1">
                                <label class="custom-control-label" for="customCheck">Biarkan tetap login</label>
                            </div>
                            <a href="#lupaPassword" data-toggle="modal" class="link-lupa">Lupa password?</a>
                        </div>
                        <div class="p-2">
                            <button type="submit" class="btn btn-primary btn-login">Login</button>
                        </div>
                       <div class="text-center mt-3">
                            <p class="m-0 small">Belum punya akun? <a href="https://customer.wilopocargo.com/register/">Daftar Disini</a></p>
                        </div>
                        <!-- End Form Login -->

                    </form>
                </div>
            </div>
        </div>

        <!-- Start Lupa Password -->
        <div id="lupaPassword" class="modal fade">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                  <!-- Modal body -->
                  <div class="modal-body p-3">

                      <div class="row justify-content-center">
                        <div class="col-10">
                            <div class="judul-reset">
                                <h3 class="judul-form">Reset Password!</h3>
                                <p>Silahkan masukkan Kode Marking Anda. Kami akan mengirimkan instruksi reset password pada Email Anda</p>
                            </div>
                            <form action="<?php echo base_url() ?>resetpassword" method="POST">
                                <div class="form-group" data-toggle="tooltip" title="Masukkan email" data-placement="left">
                                    <input type="text" name="kodemarking" class="form-control form-kostum" placeholder="Alamat email" required>
                                </div>
                                <div class="text-center pt-3">
                                    <button type="submit" class="btn btn-primary btn-login">Reset Password</button>
                                </div>
                            </form>
                        </div>
                      </div>

                  </div>
                  <!-- End Modal Body -->
                </div>
              </div>
            </div>
        </div>
        <!-- End Lupa Password -->

        <a class="float-whatsapp" target="_blank_" id="wastickyajax" href="https://wilopocargo.com/chat_sales?id=C10"><i class="fab fa-whatsapp"></i><div class="tcl"><p>Masih bingung?<br>Kami jawab sampai paham.</p></div></a>
   </section>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="<?php echo base_url() ?>assets/register_login/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/register_login/js/style.js?v=22"></script>
<script src="<?php echo base_url() ?>assets/register_login/js/loadingoverlay.min.js"></script>
<script type="text/javascript">
  $('form').submit(function() {
    $.LoadingOverlay("show");
  });
</script>
</body>
</html>
