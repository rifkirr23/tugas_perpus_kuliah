<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Upload PL | Wilopo Cargo</title>
        <meta name="description" content="Pendaftaran marking Wilopocargo">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <link rel="icon" type="image/png" href="<?php echo base_url() ?>/assets/register_login/gambar/favicon.png" />
        <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/register_login/css/jquery.ezdz.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/register_login/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/register_login/css/fontawesome.css">
        <link href="<?php echo base_url(); ?>assets/dashboard/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/register_login/css/style.css?v=22">
        <style>
            #g-recaptcha-response {
                display: block !important;
                position: absolute;
                margin: -78px 0 0 0 !important;
                width: 302px !important;
                height: 76px !important;
                z-index: -999999;
                opacity: 0;
            }
        </style>
    </head>
    <body>
        <section class="section-register">
            <!-- Slider -->
            <!-- End Slider -->
            <div class="container">
                <div class="wrap-form">
                    <div class="text-center pt-3">
                        <img class="reg-logo" src="<?php echo base_url(); ?>assets/register_login/gambar/logo.png" alt="">
                        <h3 class="judul-form">Form Upload Invoice Packing List Resi <?php echo $data_fpr->nomor_resi; ?></h3>
                        <p class="m-0">Selamat datang,Silahkan Upload File </p>
                    </div>
                     <?php if($this->session->flashdata('msg')=='success'){ ?>
          						   <div class="alert alert-success">Upload File Berhasil</div>
          					 <?php } ?>
                     <?php $cek_file = $this->db->where('id_fp_resi',$id_fpr)->get('file_packing')->num_rows(); ?>
                    <div class="pembatas"></div>
                    <?php if($cek_file >= 3){ ?>
                      <div class="text-center pt-3">
                          <h3 class="label-form">File Resi Anda Sudah Ada</h3>
                      </div>
                    <?php }else{ ?>
                      <form class="align-tengah" action="<?php echo base_url(); ?>public_c/save_upload_pl" method="post" enctype="multipart/form-data">
                          <!-- Start Upload KTP for="idKTP"  id="idKtp"-->
                          <input type="hidden" name="id_fp_resi" value="<?php echo $id_fpr; ?>">
                          <input type="hidden" name="kode_marking" value="<?php echo $data_fpr->kode_marking; ?>">
                          <input type="hidden" name="nomor_resi" value="<?php echo $data_fpr->nomor_resi; ?>">
                          <?php $encrypt_resi = md5($data_fpr->nomor_resi); ?>
                          <input type="hidden" name="encrypt_resi" value="<?php echo $encrypt_resi; ?>">
                          <div class="form-row">
                              <div class="form-group col-md-3 col-lg-3 col-sm-6 col-12 col-label">
                                  <label class="label-form" >Unggah File</label>
                              </div>
                              <div class="form-group col-md-7">
                                <div class="control-group" id="fields1">
                                    <div class="controls1">
                                        <div class="entry1 input-group col-xs-3" style="margin-top:10px;">
                                          <input class="btn btn-primary" name="file_pl[]" type="file">
                                          <span class="input-group-btn">
                                            <button class="input-group-text btn-success btn-add1" type="button">
                                              <span class="fa fa-plus"></span>
                                            </button>
                                          </span>
                                       </div>
                                    </div>
                                </div>
                                  <small data-valid="invalid" style="display:none;" id="ukimage"><i class="fa fa-frown"></i> Ukuran File Terlalu besar, MAX 2.5MB</small>
                              </div>
                          </div>
                          <div class="form-row">
                              <div class="form-group col-md-3 col-lg-3 col-sm-6 col-12 col-label">
                                  <label class="label-form" ></label>
                              </div>
                              <div class="form-group col-md-7">
                                <p style="color:red"><i>Harap Perhatikan!<br /><br />Harap upload packing list lengkap! (pdf / excel) Contoh seperti ini : <a href="https://www.wilopocargo.com/contohfile/pl_contoh.xlsx">file pl</a>
                                                     <br /><br />Jika supplier tidak ada packing list, Anda dapat mengisi sendiri / menyuruh supplier isi dengan format excel yang dapat di download disini : <a href="https://wilopocargo.com/contohfile/pl_contoh.xlsx">form pl</i></p>
                              </div>
                          </div>

                          <!-- <div class="form-row">
                              <div class="form-group col-md-3 col-lg-3 col-sm-6 col-12 col-label">
                                  <label class="label-form" for="idKTP">&nbsp;</label>
                              </div>
                              <?php if($this->session->flashdata('msg')=='recapchasalah'){ ?>
                              <div class="alert alert-danger" role="alert"><p style="color;red;">Recaptcha Salah!!</p></div>
                              <?php } ?>
                              <div class="form-group col-md-7">
                                  <div class="g-recaptcha" data-sitekey="6Ld_u9MUAAAAAN_wLXkktcDOMWoIKRNaEwFRyRZh" required></div>
                              </div>
                          </div> -->

                          <!-- End KTP -->

                          <!-- Submit -->
                          <div class="text-center p-2">
                              <button class="btn btn-primary submitnya" type="submit">Submit</button>
                          </div>
                      </form>
                    <?php } ?>

                 </div>
            </div>
            <div class="reg-footer">
                <img id="mobilBox" src="<?php echo base_url(); ?>assets/register_login/gambar/box-wilopo.png" alt="mobil box">
                <img id="mobilTruk" src="<?php echo base_url(); ?>assets/register_login/gambar/truk-wilopo.png" alt="">
            </div>
        </section>


        <script src="<?php echo base_url(); ?>assets/dashboard/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/dashboard/js/popper.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/register_login/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/dashboard/js/select2.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/register_login/js/jquery.ezdz2.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/register_login/js/fontwesome.js"></script>
        <script src="<?php echo base_url(); ?>assets/register_login/js/password.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/register_login/js/style.js?v=22" async defer></script>
        <!-- <script src="<?php echo base_url(); ?>assets/register_login/js/packinglist.js" async defer></script> -->
        <script src="<?php echo base_url(); ?>assets/dashboard/js/loadingoverlay.min.js?v=1.7" async defer></script>
        <script>

        $(document).ready(function(){ // Ketika halaman sudah siap (sudah selesai di load)

        });
        //angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
          setTimeout(function(){$(".alert").fadeOut('fast');}, 5000);
        </script>
        <script type="text/javascript">
             $(function(){
                  $(document).on('click', '.btn-add1', function(e){
                      e.preventDefault();

                      var controlForm = $('.controls1:first'),
                          currentEntry = $(this).parents('.entry1:first'),
                          newEntry = $(currentEntry.clone()).appendTo(controlForm);

                      newEntry.find('input').val('');
                      controlForm.find('.entry1:not(:last) .btn-add1')
                          .removeClass('btn-add1').addClass('btn-remove1')
                          .removeClass('btn-success').addClass('btn-danger')
                          .html('<span class="fa fa-minus"></span>');
                  }).on('click', '.btn-remove1', function(e){
                    $(this).parents('.entry1:first').remove();
                      e.preventDefault();
                      return false;
                  });
              });
        </script>
    </body>
</html>
