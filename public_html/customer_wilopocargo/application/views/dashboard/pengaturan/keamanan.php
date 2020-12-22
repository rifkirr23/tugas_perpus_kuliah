<!--Main Konten-->
<title>Wilopo Cargo - Keamanan</title>
    <section class="main-konten">
        <div class="container-fluid">

            <!--Start Jumbotron -->
            <div id="bertema" class="jumbotron-default jumbotron-tab">
                <div class="judul-jumbotron">
                    <h3><i class="fa fa-tools"></i> Pengaturan</h3>
                </div>
                <nav class="jumbotron-menu">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link" href="<?php echo base_url(); ?>pengaturan">Account</a>
                        <a class="nav-item nav-link" href="<?php echo base_url(); ?>pengaturan/finance">finance</a>
                        <a class="nav-item nav-link active" href="<?php echo base_url(); ?>pengaturan/keamanan">Keamanan</a>
                    </div>
                </nav>
            </div>
            <!--End Jumbotron-->

            <div class="row kolom-row mt-4">
                <div class="col-12">
                    <div id="nav-tabContent">
                        <!--Kemanan-->
                        <?php if($this->session->flashdata('msg')=='success'){ ?>

<p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Berhasil Ubah Password Silahkan Login Ulang!
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
</div></p>

<?php } ?>

<?php if($this->session->flashdata('msg')=='updated'){ ?>

<p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Update data Success
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
</div></p>

<?php } ?>

<?php if($this->session->flashdata('msg')=='okbank'){ ?>

<p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Bank Tujuan Telah Terupdate
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
</div></p>

<?php } ?>

<?php if($this->session->flashdata('msg')=='okcancel'){ ?>

<p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Cancel Transaksi Berhasil
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
</div></p>

<?php } ?>

<?php if($this->session->flashdata('msg')=='okrefund'){ ?>

<p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Refnd Invoice Berhasil
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
</div></p>

<?php } ?>
                        <div class="fade show active" id="nav-barang">
                            <div class="kartu-setting">
                                <div class="judul-kartu">
                                    <h3>Ganti Password</h3>
                                    <a href="#" class="text-secondary"><i class="fa fa-plus"></i></a>
                                </div>

                                <div class="setting-box">
                                    <form action="<?php echo base_url(); ?>pengaturan/updatepassword" method="POST" class="inner">
                                        <div class="form-group row">
                                            <label for="passLama" class="col-sm-3 col-form-label">Password sekarang</label>
                                            <div class="col-sm-5 input-col">
                                                <input type="password" id="passLama" name="passwordlama" class="form-control" placeholder="password" required>
                                                <span class="small inf-reset"><a href="#tardan" data-toggle="modal">Lupa Password?</a></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="newPass" class="col-sm-3 col-form-label">Password Baru</label>
                                            <div class="col-sm-5 input-col">
                                                <input type="password" id="newPass" name="passwordbaru" class="form-control" placeholder="password baru" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="repeatPas" class="col-sm-3 col-form-label">Ulangi Password</label>
                                            <div class="col-sm-5 input-col">
                                                <input type="password" id="repeatPass" name="passwordconfirm" class="form-control" placeholder="ulangi password" required>
                                            </div>
                                        </div>
                                </div>
                                <div class="set-save">
                                    <button type="submit" class="btn btn-lg btn-primary gagal">Simpan Perubahan</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Tarik Dana-->
     <div class="modal fade" id="tardan" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" >
          <div class="modal-content">
              <a class="dsms" href="#" data-dismiss="modal"><i class="fa fa-times-circle"></i></a>
            <div class="modal-body p-0">
                <form action="<?php echo base_url() ?>resetpassword" method="POST">
                    <div class="bodi-konfirmasi">
                        <div class="judul-konfirmasi">
                            <h3>Apa Anda Yakin?</h3>
                            <p>Langkah Untuk reset password akan dikirim ke email anda!</p>
                        </div>
                        <input type="hidden" name="tipesend" value="1">
                    </div>
                    <div class="pb-3 text-center">
                        <button class="btn btn-primary btn-lg rounded-pill" data-dismiss="modal">Lanjut!</button>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
    <!--End Tarik Dana-->
    <script type="text/javascript">
    $(document).ready(function(){setTimeout(function(){$(".alert").fadeIn('fast');}, 100);});
        //angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
    setTimeout(function(){$(".alert").fadeOut('fast');}, 5000);
</script>
