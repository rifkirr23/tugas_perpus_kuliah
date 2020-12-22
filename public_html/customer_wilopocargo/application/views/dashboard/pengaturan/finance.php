<!--Main Konten-->
<title>Wilopo Cargo - Finance</title>
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
                        <a class="nav-item nav-link active" href="<?php echo base_url(); ?>pengaturan/finance">finance</a>
                        <a class="nav-item nav-link" href="<?php echo base_url(); ?>pengaturan/keamanan">Keamanan</a>
                    </div>
                </nav>
            </div>
            <!--End Jumbotron-->

            <div class="row kolom-row mt-4">
                <div class="col-12">
                    <div class="tab-content" id="nav-tabContent">
                        <!--Akun-->
                        <?php if($this->session->flashdata('msg')=='success'){ ?>

<p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Berhasil Update Profile
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
                        <div class="tab-pane fade show active" id="nav-semua" role="tabpanel">
                            <div class="kartu-setting">
                                <div class="judul-kartu">
                                    <h3>Akun Personal</h3>
                                    <a href="#" class="text-secondary"><i class="fa fa-plus"></i></a>
                                </div>
                                <div class="setting-box">
                                    <form action="<?php echo base_url(); ?>pengaturan/updaterekening" method="POST" class="inner">
                                        <div class="form-group row">
                                            <label for="namaLengkap" class="col-sm-3 col-form-label">Rekening</label>
                                            <div class="col-sm-5 input-col">
                                                <input type="text" id="rekekning" name="rekening" value="<?php echo $rek->rekening;?>" class="form-control" placeholder="BCA" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="namaLengkap" class="col-sm-3 col-form-label">Atas Nama</label>
                                            <div class="col-sm-5 input-col">
                                                <input type="text" id="rekekning" name="an" value="<?php echo $rek->an;?>" class="form-control" placeholder="xx" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="namaLengkap" class="col-sm-3 col-form-label">No Rekening</label>
                                            <div class="col-sm-5 input-col">
                                                <input type="number" id="rekekning" name="no_rek" value="<?php echo $rek->no_rek;?>" class="form-control" placeholder="02918282" required>
                                            </div>
                                        </div>
                                </div>
                                <div class="set-save">
                                    <button type="submit" class="btn btn-lg btn-primary sukses">Simpan Perubahan</button>
                                </div>
                                </form>
                            </div>
                        </div>
                        <!--Finance-->
                        <!-- <div class="tab-pane fade" id="nav-titip" role="tabpanel">
                            <div class="kartu-setting">
                                <div class="judul-kartu">
                                    <h3>Pengaturan Finance</h3>
                                    <a href="#" class="text-secondary"><i class="fa fa-plus"></i></a>
                                </div>

                                <div class="setting-box">
                                    <form action="" class="inner">
                                        <div class="form-group row">
                                            <label for="namaBank" class="col-sm-3 col-form-label">Nama Bank</label>
                                            <div class="col-sm-5 input-col">
                                                <input type="text" id="namaBank" class="form-control" placeholder="bank name">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="set-save">
                                    <button type="submit" class="btn btn-lg btn-primary sukses">Simpan Perubahan</button>
                                </div>
                            </div>
                        </div> -->
                        <!--Kemanan-->
                        <!-- <div class="tab-pane fade" id="nav-barang" role="tabpanel">
                            <div class="kartu-setting">
                                <div class="judul-kartu">
                                    <h3>Ganti Password</h3>
                                    <a href="#" class="text-secondary"><i class="fa fa-plus"></i></a>
                                </div>

                                <div class="setting-box">
                                    <form action="" class="inner">
                                        <div class="form-group row">
                                            <label for="passLama" class="col-sm-3 col-form-label">Password sekarang</label>
                                            <div class="col-sm-5 input-col">
                                                <input type="password" id="passLama" class="form-control" placeholder="password">
                                                <span class="small inf-reset"><a href="#">Lupa Password?</a></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="newPass" class="col-sm-3 col-form-label">Password Baru</label>
                                            <div class="col-sm-5 input-col">
                                                <input type="password" id="newPass" class="form-control" placeholder="password baru">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="repeatPas" class="col-sm-3 col-form-label">Ulangi Password</label>
                                            <div class="col-sm-5 input-col">
                                                <input type="password" id="repeatPass" class="form-control" placeholder="ulangi password">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="set-save">
                                    <button type="submit" class="btn btn-lg btn-primary gagal">Simpan Perubahan</button>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">
    $(document).ready(function(){setTimeout(function(){$(".alert").fadeIn('fast');}, 100);});
        //angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
    setTimeout(function(){$(".alert").fadeOut('fast');}, 5000);
</script>
