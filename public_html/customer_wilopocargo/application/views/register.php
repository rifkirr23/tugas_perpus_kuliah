<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Pendaftaran Marking | Wilopo Cargo</title>
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
                        <h3 class="judul-form">Registrasi User Marking</h3>
                        <p class="m-0">Selamat datang, silahkan lengkapi form dibawah ini untuk pendaftaran</p>
                    </div>
                     <?php if($this->session->flashdata('msg')=='recapchasalah'){ ?>
						   <div class="alert alert-danger">Maaf! :), <b>Recapcha</b> salah, silahkan coba lagi!</div>
					 <?php } ?>
					 <?php if($this->session->flashdata('msg')=='kodeada'){ ?>
						   <div class="alert alert-danger">Maaf! :), <b>Kode Markin Atau Email sudah digunakan</b> silahkan coba lagi!</div>
					 <?php } ?>
                    <div class="pembatas"></div>
                    <form class="align-tengah" action="<?php echo base_url(); ?>register/save" method="post" enctype="multipart/form-data">
                        <!-- ID Marking -->
                        <div class="form-row">
                            <div class="form-group col-md-3 col-lg-3 col-sm-6 col-12 col-label">
                                <label class="label-form" for="idMarking">ID Marking</label>
                            </div>
                            <div class="form-group col-md-7">
                                <div class="input-group validasi">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="fixMarking">123/WC-</span>
                                    </div>
                                    <input id="idMarking" onkeyup="this.value = this.value.toUpperCase();" name="kode" required autocomplete="off" jenis-data="marking" type="text" class="form-control noEnterSubmit" placeholder="ID Marking">
                                    <!-- Jika ID tidak tersedia data-valid="novalid" -->
                                    <small data-valid="invalid" id="invalid"><i class="fa fa-frown"></i> ID Marking tidak tersedia, silahkan coba lagi</small>

                                    <!-- Jika ID tersedia data-valid="valid" -->
                                    <!-- <small data-valid="valid" class="fade"><i class="fa fa-smile"></i> ID Marking tersedia</small> -->
                                </div>
                            </div>
                        </div>
                        <!-- End ID Marking -->

                        <!-- Password -->
                        <div id="password-container" class="mb-3">
                            <div class="form-row align-items-center mb-0">
                                <div class="form-group col-md-3 col-lg-3 col-sm-6 col-12 col-label">
                                    <label class="label-form" for="idPassword">Password</label>
                                </div>
                                <div class="mb-0 form-group col-md-7">
                                    <div class="input-group">
                                        <input name="password" value="" id="idPassword" minlength="6" autocomplete="new-password" min="4" max="8" type="password" required class="form-control noEnterSubmit" placeholder="password">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-3">
                                </div>
                                <div class="col align-self-end col-7">
                                    <div class="progress-password"></div>
                                    <div id="pesan"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row mb-3">
                            <div class="form-group col-md-3 col-lg-3 col-sm-6 col-12 col-label">
                                <label class="label-form" for="konfirmasiPassword">Ulangi Password</label>
                            </div>
                            <div class="form-group col-md-7">
                                <div class="input-group">
                                    <input id="konfirmasiPassword" autocomplete="off" minlength="6" onChange="cekUlangiPassword();" type="password" required class="form-control noEnterSubmit" placeholder="ulangi password">
                                </div>
                                <div class="registrationFormAlert" id="kecocokanPassword"></div>
                            </div>
                        </div>
                        <!-- End Password -->

                        <!-- Nama Lengkap -->
                        <div class="form-row mb-3">
                            <div class="form-group col-md-3 col-lg-3 col-sm-6 col-12 col-label">
                                <label class="label-form" for="idNama">Nama Lengkap <small class="d-block">Sesuai ktp</small></label>
                            </div>
                            <div class="form-group col-md-7">
                                <div class="input-group validasi">
                                    <input name="nama" id="idNama" required autocomplete="off" jenis-data="nama-lengkap" type="text" class="form-control noEnterSubmit" placeholder="Nama lengkap" aria-describedby="fixMarking">
                                </div>
                            </div>
                        </div>
                        <!-- End Nama Lengkap -->

                        <!-- Email -->
                        <div class="form-row mb-3">
                            <div class="form-group col-md-3 col-lg-3 col-sm-6 col-12 col-label">
                                <label class="label-form" for="idEmail">Alamat Email</label>
                            </div>
                            <div class="form-group col-md-7">
                                <div class="input-group validasi">
                                    <input name="email" id="idEmail" required autocomplete="off" type="email" class="form-control noEnterSubmit" placeholder="Email" aria-describedby="fixMarking">
                                     <!-- Jika ID tidak tersedia data-valid="novalid" -->
                                     <small data-valid="invalid" id="invalidemail"><i class="fa fa-frown"></i> Email Sudah Ada, silahkan masukan email lain!</small>
                                </div>
                            </div>
                        </div>
                        <!-- End Email -->

                        <!-- No WA -->
                        <div class="form-row mb-3">
                            <div class="form-group col-md-3 col-lg-3 col-sm-6 col-12 col-label">
                                <label class="label-form" for="idWa">No. Whatsapp</label>
                            </div>
                            <div class="form-group col-md-7">
                                <div class="input-group">
                                    <input name="whatsapp" id="idWa" jenis-tipe="whatsapp" required autocomplete="off" type="tel" class="form-control noEnterSubmit" placeholder="No. Whatsapp">
                                </div>
                            </div>
                        </div>
                        <!-- End No. WA -->

                         <!-- Provinsi -->
                         <div class="form-row mb-3">
                            <div class="form-group col-md-3 col-lg-3 col-sm-6 col-12 col-label">
                                <label class="label-form" for="idProvinsi">Provinsi</label>
                            </div>
                            <div class="form-group col-md-7">
                                <div class="input-group">
                                    <select name="id_provinsi" id="provinsi" required class="form-control noEnterSubmit js-sl">
                                        <option value="">--Pilih--</option>
                                      <?php foreach ($provinsi as $prov) { ?>
                                        <option value="<?php echo $prov->id_prov; ?>"><?php echo $prov->nama; ?></option>
                                      <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- Provinsi -->

                        <!-- Kota -->
                        <div class="form-row mb-3">
                            <div class="form-group col-md-3 col-lg-3 col-sm-6 col-12 col-label">
                                <label class="label-form" for="kota">Kota</label>
                            </div>
                            <div class="form-group col-md-7">
                                <div class="input-group disabled">
                                    <select name="id_kota" id="kota" required class="custom-select form-control noEnterSubmit js-sl">

                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- end Kota -->

                        <!-- Kota -->
                        <div class="form-row mb-3">
                            <div class="form-group col-md-3 col-lg-3 col-sm-6 col-12 col-label">
                                <label class="label-form" for="kecamatan">Kecamatan</label>
                            </div>
                            <div class="form-group col-md-7">
                                <div class="input-group disabled">
                                    <select name="id_kec" id="kecamatan" class="custom-select form-control noEnterSubmit js-sl">

                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- end Kota -->

                        <!-- Alamat Lengkap -->
                        <div class="form-row mb-3 align-items-start">
                            <div class="form-group col-md-3 col-lg-3 col-sm-6 col-12 col-label">
                                <label class="label-form" for="idAlamat">Alamat Detail</label>
                            </div>
                            <div class="form-group col-md-7">
                                <textarea name="alamat" required id="idAlamat" placeholder="Alamat lengkap" class="form-control w-100 noEnterSubmit" rows="5"></textarea>
                            </div>
                        </div>
                        <!-- end Alamat -->

                        <!-- Start Upload KTP for="idKTP"  id="idKtp"-->
                        <div class="form-row">
                            <div class="form-group col-md-3 col-lg-3 col-sm-6 col-12 col-label">
                                <label class="label-form" >Unggah foto KTP<small class="d-block">Uk. Maksimal foto 7MB</small></label>
                            </div>
                            <div class="form-group col-md-7">
                                <input name="foto_ktp" class="noEnterSubmit" type="file" required accept="image/*" id="sizenya">
                                <small data-valid="invalid" style="display:none;" id="ukimage"><i class="fa fa-frown"></i> Ukuran Foto KTP Terlalu besar, MAX 7MB</small>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3 col-lg-3 col-sm-6 col-12 col-label">
                                <label class="label-form" for="idKTP">&nbsp;</label>
                            </div>
                            <?php if($this->session->flashdata('msg')=='recapchasalah'){ ?>
                            <div class="alert alert-danger" role="alert"><p style="color;red;">Recaptcha Salah!!</p></div>
                            <?php } ?>
                            <div class="form-group col-md-7">
                                <div class="g-recaptcha" data-sitekey="6Ld_u9MUAAAAAN_wLXkktcDOMWoIKRNaEwFRyRZh" required></div>
                            </div>
                        </div>

                        <!-- End KTP -->

                        <!-- Submit -->
                        <div class="text-center p-2">
                            <button class="btn btn-primary submitnya" type="submit">Submit</button>
                        </div>
                    </form>
                 </div>
                <div class="text-center p-2">
                    <p class="mb-0">Sudah terdaftar sebelumnya? <a href="<?php echo base_url(); ?>login">Login Disini</a></p>
                </div>
            </div>
            <div class="reg-footer">
                <img id="mobilBox" src="<?php echo base_url(); ?>assets/register_login/gambar/box-wilopo.png" alt="mobil box">
                <img id="mobilTruk" src="<?php echo base_url(); ?>assets/register_login/gambar/truk-wilopo.png" alt="">
            </div>
        </section>

        <!-- Float Whatsapp -->
        <!--<div class="call-wa">-->
        <!--    <div class="box-wa">-->
        <!--        <div class="head-boxwa">-->
        <!--            <h3>Kami siap membantu anda!</h3>-->
        <!--            <p>Untuk informasi dan pertanyaan lain, silahkan menghubungi kami via Whatsapp berikut.</p>-->
        <!--        </div>-->
        <!--        <div class="boxwa-konten">-->
        <!--            <ul>-->
        <!--                <li>-->
        <!--                    <a href="https://wa.me/6281310085523" target="_blank_">-->
        <!--                        <div class="li-wa">-->
        <!--                            <div class="profil-wa">-->
        <!--                                <img src="https://dummyimage.com/100/100/ff00ff/ffd68a.png" alt="">-->
        <!--                            </div>-->
        <!--                            <div class="tx-wa">-->
        <!--                                <p>Dennis</p>-->
        <!--                                <small>Customer Care</small>-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                    </a>-->
        <!--                </li>-->
        <!--                <li>-->
        <!--                    <a href="https://wa.me/6281310085523" target="_blank_">-->
        <!--                        <div class="li-wa">-->
        <!--                            <div class="profil-wa">-->
        <!--                                <img src="https://dummyimage.com/100/100/ff00ff/ffd68a.png" alt="">-->
        <!--                            </div>-->
        <!--                            <div class="tx-wa">-->
        <!--                                <p>Wilopo Cargo</p>-->
        <!--                                <small>Payment Care</small>-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                    </a>-->
        <!--                </li>-->
        <!--            </ul>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--    <div class="wa-label">-->
        <!--        <p>Butuh bantuan? <strong>Hubungi kami</strong></p>-->
        <!--    </div>-->
        <!--    <div class="wa-btn">-->
        <!--    </div>-->
        <!--</div>-->

        <script src="<?php echo base_url(); ?>assets/dashboard/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/dashboard/js/popper.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/register_login/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/dashboard/js/select2.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/register_login/js/jquery.ezdz.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/register_login/js/fontwesome.js"></script>
        <script src="<?php echo base_url(); ?>assets/register_login/js/password.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/register_login/js/style.js?v=22" async defer></script>
        <script src="<?php echo base_url(); ?>assets/register_login/js/uploadktp.js" async defer></script>
        <script src="<?php echo base_url(); ?>assets/dashboard/js/loadingoverlay.min.js?v=1.7" async defer></script>
        <script>
       
        $(document).ready(function(){ // Ketika halaman sudah siap (sudah selesai di load)
            $('#sizenya').bind('change', function() {
                var a=(this.files[0].size);
                // alert(a);
                if(a > 7500000) {
                    // alert('image terlalu besar');
                    $(".submitnya").hide();
                    $("#ukimage").show();
                }else{
                    $(".submitnya").show();
                    $("#ukimage").hide();
                }
            });
            $('form').submit(function() {
                  $.LoadingOverlay("show");
            });
            setTimeout(function(){$(".alert").fadeIn('fast');}, 100);
            var $recaptcha = document.querySelector('#g-recaptcha-response');
        
            if($recaptcha) {
                $recaptcha.setAttribute("required", "required");
            }
            
            $("#invalidemail").hide();
            $("#invalid").hide();
            $('.js-sl').select2();
            $('.noEnterSubmit').keypress(function(e) {
                if ( e.which == 13 ) return false;
            } );
          // Kita sembunyikan dulu untuk loadingnya
          $("#loading").hide();

          $("#provinsi").change(function(){ // Ketika user mengganti atau memilih data provinsi
            // $("#kota").hide(); // Sembunyikan dulu combobox kota nya
            // $("#loading").show(); // Tampilkan loadingnya

            $.ajax({
              type: "POST", // Method pengiriman data bisa dengan GET atau POST
              url: "<?php echo base_url("/Register/listkota"); ?>", // Isi dengan url/path file php yang dituju
              data: {id_provinsi : $("#provinsi").val()}, // data yang akan dikirim ke file yang dituju
              dataType: "json",
              beforeSend: function(e) {
                if(e && e.overrideMimeType) {
                  e.overrideMimeType("application/json;charset=UTF-8");
                }
              },
              success: function(response){ // Ketika proses pengiriman berhasil
                $("#loading").hide(500); // Sembunyikan loadingnya

                // set isi dari combobox kota
                // lalu munculkan kembali combobox kotanya
                $("#kota").html(response.list_kota).show(500);
              },
              error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
              }
            });
          });

          $("#kota").change(function(){ // Ketika user mengganti atau memilih data provinsi
            // $("#kota").hide(); // Sembunyikan dulu combobox kota nya
            // $("#loading").show(); // Tampilkan loadingnya

            $.ajax({
              type: "POST", // Method pengiriman data bisa dengan GET atau POST
              url: "<?php echo base_url("/Register/listkecamatan"); ?>", // Isi dengan url/path file php yang dituju
              data: {id_kota : $("#kota").val()}, // data yang akan dikirim ke file yang dituju
              dataType: "json",
              beforeSend: function(e) {
                if(e && e.overrideMimeType) {
                  e.overrideMimeType("application/json;charset=UTF-8");
                }
              },
              success: function(response){ // Ketika proses pengiriman berhasil
                $("#loading").hide(500); // Sembunyikan loadingnya

                // set isi dari combobox kota
                // lalu munculkan kembali combobox kotanya
                $("#kecamatan").html(response.list_kota).show(500);
              },
              error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
              }
            });
          });

          $("#kecamatan").change(function(){ // Ketika user mengganti atau memilih data provinsi
            // $("#kota").hide(); // Sembunyikan dulu combobox kota nya
            // $("#loading").show(); // Tampilkan loadingnya

            $.ajax({
              type: "POST", // Method pengiriman data bisa dengan GET atau POST
              url: "<?php echo base_url("/Register/listkelurahan"); ?>", // Isi dengan url/path file php yang dituju
              data: {id_kec : $("#kecamatan").val()}, // data yang akan dikirim ke file yang dituju
              dataType: "json",
              beforeSend: function(e) {
                if(e && e.overrideMimeType) {
                  e.overrideMimeType("application/json;charset=UTF-8");
                }
              },
              success: function(response){ // Ketika proses pengiriman berhasil
                $("#loading").hide(500); // Sembunyikan loadingnya

                // set isi dari combobox kota
                // lalu munculkan kembali combobox kotanya
                $("#kelurahan").html(response.list_kota).show(500);
              },
              error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
              }
            });
          });

          // On Input Marking
          $('#idMarking').on('input', function(){
            $.ajax({
              type: "POST", // Method pengiriman data bisa dengan GET atau POST
              url: "<?php echo base_url("index.php/register/cek_marking"); ?>", // Isi dengan url/path file php yang dituju
              data: {kode_mark : $("#idMarking").val()}, // data yang akan dikirim ke file yang dituju
              dataType: "json",
              beforeSend: function(e) {
                if(e && e.overrideMimeType) {
                  e.overrideMimeType("application/json;charset=UTF-8");
                }
              },
              success: function(response){
                // alert(response.result);
                if(response.result > 0){
                  $("#invalid").show();
                  $(".submitnya").hide();
                }else{
                  $("#invalid").hide();
                  $(".submitnya").show();
                }
              },
              error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
              }
            });
          });
          $('#idEmail').on('input', function(){
            $.ajax({
              type: "POST", // Method pengiriman data bisa dengan GET atau POST
              url: "<?php echo base_url("/register/cek_email"); ?>", // Isi dengan url/path file php yang dituju
              data: {email : $("#idEmail").val()}, // data yang akan dikirim ke file yang dituju
              dataType: "json",
              beforeSend: function(e) {
                if(e && e.overrideMimeType) {
                  e.overrideMimeType("application/json;charset=UTF-8");
                }
              },
              success: function(response){
                // alert(response.result);
                if(response.result > 0){
                  $("#invalidemail").show();
                  $(".submitnya").hide();
                }else{
                  $("#invalidemail").hide();
                  $(".submitnya").show();
                }
              },
              error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
              }
            });
          });
        });
        //angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
          setTimeout(function(){$(".alert").fadeOut('fast');}, 5000);
        </script>
    </body>
</html>
