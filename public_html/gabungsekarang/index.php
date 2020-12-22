<!DOCTYPE html>
<html>
<?php
  require('backend/db.php');
  $sql_jenis_barang = mysql_query("SELECT * FROM jenis_barang ORDER BY nama ASC")or die(mysql_error());
  // $row_jenis_barang = mysql_fetch_array($sql_jenis_barang);
  // print_r($sql_jenis_barang);die();
 ?>
 <!-- Global site tag (gtag.js) - Google Analytics -->
 <!-- Global site tag (gtag.js) - Google Ads: 951614555 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-951614555"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-951614555');
</script>

<!-- Event snippet for Leads Box conversion page -->
<script>
  gtag('event', 'conversion', {'send_to': 'AW-951614555/KQT9CJz2prIBENv44cUD'});
</script>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-133151863-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-133151863-3');
</script>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Perusahaan Terpercaya Kargo Cina</title>
    <link rel="stylesheet" href="assets/css/bootstraap4-3-1.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="assets/css/select2.min.css">
    <link rel="shortcut icon" href="../assets/nophoto.png">
</head>

<body>
    <!-- Start: Section 1 -->
    <?php if($_GET['message'] == "success"){ ?>
      <div class="modal show" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="pull-left">
                      <h4 class="modal-title" id="myModalLabel" style="font-family:montserrat;">Selamat <i class="fa fa-check"></i></h4>
                    </span>
                </div>
                <div class="modal-body">
                    <p style="font-family:montserrat;">Anda telah sukses mendaftar, admin kami akan segera menghubungi Anda</p>
                </div>
                <div class="modal-footer">
                     <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
             </div>
         </div>
      </div>
      <div class="alert alert-success" role="alert">Terima Kasih Data Anda Telah Terdaftar</div>
    <?php } ?>
    <section class="section-hero">
        <div class="container">
            <h1 class="judul-huge">Jasa Import Cina<br><span>Terbesar</span>dan&nbsp;<span>Terbaik</span>di Indonesia</h1>
            <div class="list-hero">
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-5 col-xl-5">
                        <ul class="list-unstyled list-fitur-hero">
                            <li><img src="assets/img/2-langkah.svg">Import Murah Hanya dengan 2 langkah</li>
                            <li><img src="assets/img/customer-services.svg">Profesional Customer Services</li>
                        </ul>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-5 col-xl-5">
                        <ul class="list-unstyled list-fitur-hero">
                            <li><img src="assets/img/live-track.svg">Live 24/7 sistem tracking otomatis</li>
                            <li><img src="assets/img/garansi.svg">100% Garansi barang kembali</li>
                        </ul>
                    </div>
                </div>
            </div><a class="link-cta" href="https://wilopocargo.com/gabungsekarang?utm_source=dm&utm_source=dm&utm_medium=landingpage2&utm_campaign=gabungsekarangbutton#contactus">Gabung Sekarang Gratis</a></div>
    </section>
    <!-- End: Section 1 -->
    <!-- Start: section 2 -->
    <section class="text-center section-default bg-gradient">
        <div class="container mt-5">
            <h1 class="text-center judul-huge mb-5"><span>2 Langkah mudah</span>Impor Bersama Kami</h1>
            <div class="text-center flow-gambar"><img src="assets/img/flow-gambar_1.png"></div><a class="link-cta" href="https://wilopocargo.com/gabungsekarang?utm_source=dm&utm_source=dm&utm_medium=landingpage2&utm_campaign=gabungsekarangbutton#contactus">Gabung Sekarang Gratis</a></div><img class="bg-over" src="assets/img/city.svg"></section>
    <!-- End: section 2 -->
    <!-- Start: Section FAQ -->
    <section class="section-faq w-sep"><img class="separator-wafe" src="assets/img/separator-top.svg">
        <div class="container">
            <h1 class="judul-huge mb-5"><span>Kami Mengerti</span>&nbsp;Masalah Anda</h1><div data-ride="carousel" class="carousel slide" id="slider-faq">
    <ol
        class="carousel-indicators indikator-slide">
        <li data-target="#slider-faq" data-slide-to="0" class="active"><span>1</span></li>
        <li data-target="#slider-faq" data-slide-to="1"><span>2</span></li>
        <li data-target="#slider-faq" data-slide-to="2"><span>3</span></li>
        <li data-target="#slider-faq" data-slide-to="3"><span>4</span></li>
        <li data-target="#slider-faq" data-slide-to="4"><span>5</span></li>
        <li data-target="#slider-faq" data-slide-to="5"><span>6</span></li>
    </ol>
    <div role="listbox" class="carousel-inner slide-faq">
        <div class="carousel-item active">
            <div class="row">
                <div class="col-lg-3 col-xl-3"><img class="w-100" src="assets/img/pembayaran-suplier.svg" /></div>
                <div class="col-lg-9 col-xl-9">
                    <h3>Apakah bisa dibantu untuk pembayaran ke supplier?</h3>
                    <p>Kami menyediakan jasa titip transfer RMB ke rekening bank supplier di Cina. Anda dapat bayar kepada kami dalam Rupiah, tidak perlu repot lagi!</p><a class="link-cta sm" href="https://wilopocargo.com/gabungsekarang?utm_source=dm&utm_source=dm&utm_medium=landingpage2&utm_campaign=gabungsekarangbutton#contactus">Gabung Sekarang Gratis</a></div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="row">
                <div class="col-lg-3 col-xl-3"><img class="w-100" src="assets/img/ongkos-kirim.svg" /></div>
                <div class="col-lg-9 col-xl-9">
                    <h3>Bagaimana cara perhitungan ongkos kirimnya?</h3>
                    <p>Ongkos kirim melalui laut dihitung berdasarkan volume barang setelah packaging, dan udara dihitung berdasarkan berat barang setelah packaging.<br />Jika anda bingung, anda dapat menggunakan kalkulator harga dibawah!</p><a class="link-cta sm"
                        href="https://wilopocargo.com/gabungsekarang?utm_source=dm&utm_source=dm&utm_medium=landingpage2&utm_campaign=gabungsekarangbutton#contactus">Gabung Sekarang Gratis</a></div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="row">
                <div class="col-lg-3 col-xl-3"><img class="w-100" src="assets/img/langkah-impor.svg" /></div>
                <div class="col-lg-9 col-xl-9">
                    <h3>Bagaimana cara kerja Wilopo Cargo? Kok impor barang cuman 2 langkah aja?</h3>
                    <p>Benar sekali! Ternyata impor dari China itu sangat mudah jika menggunakan jasa kami! Anda TIDAK PERLU memiliki PT, tidak perlu mengurus ekspor dan impor, pemesanan kapal, pengurusan dokumen dan legalitas, pengurusan ijin impor, pembayaran
                        ke supplier China, pengiriman armada darat, dan lain-lain! Semua aktifitas ini akan kami urus dengan baik, Anda cukup menyuruh supplier di China mengirimkan barang Anda ke gudang kami di China, lalu duduk manis menunggu barang
                        Anda datang sampai di depan rumah Anda!</p><a class="link-cta sm" href="https://wilopocargo.com/gabungsekarang?utm_source=dm&utm_source=dm&utm_medium=landingpage2&utm_campaign=gabungsekarangbutton#contactus">Gabung Sekarang Gratis</a></div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="row">
                <div class="col-lg-3 col-xl-3"><img class="w-100" src="assets/img/faq-lama.svg" /></div>
                <div class="col-lg-9 col-xl-9">
                    <h3>Berapa lama proses pengiriminan dari China ke Jakarta?</h3>
                    <p>Proses impor lewat laut sekitar 3-5 minggu, dan impor lewat udara 5-7 hari!</p><a class="link-cta sm" href="https://wilopocargo.com/gabungsekarang?utm_source=dm&utm_source=dm&utm_medium=landingpage2&utm_campaign=gabungsekarangbutton#contactus">Gabung Sekarang Gratis</a></div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="row">
                <div class="col-lg-3 col-xl-3"><img class="w-100" src="assets/img/box-besar_1.svg" /></div>
                <div class="col-lg-9 col-xl-9">
                    <h3>Bagaimana jika barang saya hilang / tidak sampai?</h3>
                    <p>Barang yang hilang karena musibah tak terduga seperti kapal terbakar, kapal jatuh, force major, mobil dicuri, dan lain-lain yang menyebabkan barang tidak sampai, akan kami cover garansi uang kembali sesuai nilai barang anda!</p>
                    <a
                        class="link-cta sm" href="https://wilopocargo.com/gabungsekarang?utm_source=dm&utm_source=dm&utm_medium=landingpage2&utm_campaign=gabungsekarangbutton#contactus">Gabung Sekarang Gratis</a>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="row">
                <div class="col-lg-3 col-xl-3"><img class="w-100" src="assets/img/secure.svg" /></div>
                <div class="col-lg-9 col-xl-9">
                    <h3>Apakah transaksi uang dan barang kami aman bersama Wilopo Cargo?</h3>
                    <p>Jangan khawatir, ongkos kirim barang Anda dibayarkan ketika barang sampai di gudang Jakarta. Transaksi dan barang Anda pasti aman bersama kami. Kami adalah perusahaan berbadan hukum legal yang resmi terdaftar. Anda juga dapat datang
                        ke kantor kami agar lebih percaya :)<br /></p><a class="link-cta sm" href="https://wilopocargo.com/gabungsekarang?utm_source=dm&utm_source=dm&utm_medium=landingpage2&utm_campaign=gabungsekarangbutton#contactus">Gabung Sekarang Gratis</a></div>
            </div>
        </div>
    </div>

</div>
            <div class="carousel slide d-none" data-ride="carousel" id="slider-faq">
                <div class="carousel-inner slide-faq" role="listbox">
                    <div class="carousel-item active">
                        <div class="row">
                            <div class="col-lg-3 col-xl-3"><img class="w-100" src="assets/img/pembayaran-suplier.svg"></div>
                            <div class="col-lg-9 col-xl-9">
                                <h3>Apakah bisa dibantu untuk pembayaran ke supplier?</h3>
                                <p>Kami menyediakan jasa titip transfer RMB ke rekening bank supplier di Cina. Anda dapat bayar kepada kami dalam Rupiah, tidak perlu repot lagi!</p><a class="link-cta sm" href="https://wilopocargo.com/gabungsekarang?utm_source=dm&utm_source=dm&utm_medium=landingpage2&utm_campaign=gabungsekarangbutton#contactus">Gabung Sekarang Gratis</a></div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-lg-3 col-xl-3"><img class="w-100" src="assets/img/ongkos-kirim.svg"></div>
                            <div class="col-lg-9 col-xl-9">
                                <h3>Bagaimana cara perhitungan ongkos kirimnya?</h3>
                                <p>Ongkos kirim melalui laut dihitung berdasarkan volume barang setelah packaging, dan udara dihitung berdasarkan berat barang setelah packaging.<br>Jika anda bingung, anda dapat menggunakan kalkulator harga dibawah!</p>
                                <a
                                    class="link-cta sm" href="https://wilopocargo.com/gabungsekarang?utm_source=dm&utm_source=dm&utm_medium=landingpage2&utm_campaign=gabungsekarangbutton#contactus">Gabung Sekarang Gratis</a>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-lg-3 col-xl-3"><img class="w-100" src="assets/img/langkah-impor.svg"></div>
                            <div class="col-lg-9 col-xl-9">
                                <h3>Bagaimana cara kerja Wilopo Cargo? Kok impor barang cuman 2&nbsp;langkah aja?</h3>
                                <p>Benar sekali! Ternyata impor dari China itu sangat mudah jika menggunakan jasa kami! Anda TIDAK PERLU memiliki PT, tidak perlu mengurus ekspor dan impor, pemesanan kapal, pengurusan dokumen dan legalitas, pengurusan ijin
                                    impor, pembayaran ke supplier China, pengiriman armada darat, dan lain-lain! Semua aktifitas ini akan kami urus dengan baik, Anda cukup menyuruh supplier di China mengirimkan barang Anda ke gudang kami di China, lalu
                                    duduk manis menunggu barang Anda datang sampai di depan rumah Anda!</p><a class="link-cta sm" href="https://wilopocargo.com/gabungsekarang?utm_source=dm&utm_source=dm&utm_medium=landingpage2&utm_campaign=gabungsekarangbutton#contactus">Gabung Sekarang Gratis</a></div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-lg-3 col-xl-3"><img class="w-100" src="assets/img/langkah-impor.svg"></div>
                            <div class="col-lg-9 col-xl-9">
                                <h3>Berapa lama proses pengiriminan dari China ke Jakarta?</h3>
                                <p>Proses impor lewat laut sekitar 3-5 minggu, dan impor lewat udara 5-7 hari!</p><a class="link-cta sm" href="https://wilopocargo.com/gabungsekarang?utm_source=dm&utm_source=dm&utm_medium=landingpage2&utm_campaign=gabungsekarangbutton#contactus">Gabung Sekarang Gratis</a></div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-lg-3 col-xl-3"><img class="w-100" src="assets/img/langkah-impor.svg"></div>
                            <div class="col-lg-9 col-xl-9">
                                <h3>Bagaimana jika barang saya hilang / tidak sampai?</h3>
                                <p>Barang yang hilang karena musibah tak terduga seperti kapal terbakar, kapal jatuh, force major, mobil dicuri, dan lain-lain&nbsp;yang menyebabkan barang tidak sampai, akan kami cover garansi uang kembali sesuai nilai barang
                                    anda!</p><a class="link-cta sm" href="https://wilopocargo.com/gabungsekarang?utm_source=dm&utm_source=dm&utm_medium=landingpage2&utm_campaign=gabungsekarangbutton#contactus">Gabung Sekarang Gratis</a></div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-lg-3 col-xl-3"><img class="w-100" src="assets/img/langkah-impor.svg"></div>
                            <div class="col-lg-9 col-xl-9">
                                <h3>Apakah transaksi uang dan barang kami aman bersama Wilopo Cargo?</h3>
                                <p>Jangan khawatir, ongkos kirim barang Anda dibayarkan ketika barang sampai di gudang Jakarta. Transaksi dan barang Anda pasti aman bersama kami. Kami adalah perusahaan berbadan hukum legal yang resmi terdaftar. Anda juga
                                    dapat datang ke kantor kami agar lebih percaya :)<br></p><a class="link-cta sm" href="https://wilopocargo.com/gabungsekarang?utm_source=dm&utm_source=dm&utm_medium=landingpage2&utm_campaign=gabungsekarangbutton#contactus">Gabung Sekarang Gratis</a></div>
                        </div>
                    </div>
                </div>
                <div>
                    <!-- Start: Previous --><a class="carousel-control-prev" href="#slider-faq" role="button" data-slide="prev"><span class="carousel-control-prev-icon"></span><span class="sr-only">Previous</span></a>
                    <!-- End: Previous -->
                    <!-- Start: Next --><a class="carousel-control-next" href="#slider-faq" role="button" data-slide="next"><span class="carousel-control-next-icon"></span><span class="sr-only">Next</span></a>
                    <!-- End: Next -->
                </div>
                <ol class="carousel-indicators indikator-slide">
                    <li data-target="#slider-faq" data-slide-to="0" class="active"></li>
                    <li data-target="#slider-faq" data-slide-to="1"></li>
                    <li data-target="#slider-faq" data-slide-to="2"></li>
                    <li data-target="#slider-faq" data-slide-to="3"></li>
                    <li data-target="#slider-faq" data-slide-to="4"></li>
                    <li data-target="#slider-faq" data-slide-to="5"></li>
                </ol>
            </div>
        </div>
    </section>
    <!-- End: Section FAQ -->
    <!-- Start: section testi -->
    <section class="section-testimoni gradien-testi">
        <div class="container">
            <div class="text-center mb-5">
                <h1 class="text-uppercase text-white judul-huge">Testimonials</h1>
            </div>
            <div class="row">
                <div class="col-lg-6 col-xl-6">
                    <ul class="list-unstyled list-testi">
                        <li>
                            <div class="testi-blok-link">
                                <div class="img-testi"><img src="assets/img/angga-putra.jpeg"></div><a class="link-testi" href="#faq-1" data-toggle="collapse">Angga Putra<span>Pedagang sepatu online</span></a></div>
                            <div id="faq-1" class="collapse inner-clp">
                                <p>Harus diakui Jasa Wilopo Cargo sangat membantu saya dalam melakukan impor sepatu, dengan menggunakan jasa ini. Barang saya bisa sampai tanpa masalah Bea cukai.</p>
                            </div>
                        </li>
                        <li>
                            <div class="testi-blok-link">
                                <div class="img-testi"><img src="assets/img/aneline.jpeg"></div><a class="link-testi" href="#faq-2" data-toggle="collapse">Angeline<span>Jualan Baju Anak</span></a></div>
                            <div id="faq-2" class="collapse inner-clp">
                                <p>Pelayanan di wilopo cargo sangat baik, mereka melayani saya dengan responsive. Bahkan ketika terjadi kendala pada barang saya mereka sangat responsive dan memberikan solusi seperti mengganti jumlah biaya produk saya yang
                                    mengalami kerusakan karena pengiriman.</p>
                            </div>
                        </li>
                        <li>
                            <div class="testi-blok-link">
                                <div class="img-testi"><img src="assets/img/testi3.jpg"></div><a class="link-testi" href="#faq-3" data-toggle="collapse">Selly Susanto<span>Selly Bag Tanah Abang</span></a></div>
                            <div id="faq-3" class="collapse inner-clp">
                                <p>Senang sekali dengan pelayanan Wilopo Cargo, awalnya saya bingung gimana cara import dan cari barang di China untuk saya dagangkan di Indonesia. Tanpa pengetahuan apa-apa, saya dipandu oleh tim Wilopo Cargo, mulai dari
                                    diberi pilihan beberapa model barang, diurusi pembayaran ke supplier, dan di pengirimannya. Pokoknya saya cuman tinggal duduk manis aja!<br><br></p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-6 col-xl-6">
                    <ul class="list-unstyled list-testi">
                        <li>
                            <div class="testi-blok-link">
                                <div class="img-testi"><img src="assets/img/testi2.jpg"></div><a class="link-testi" href="#faq-4" data-toggle="collapse">Lidya<span>Pedagang Aksesoris HP ITC mangga dua</span></a></div>
                            <div id="faq-4" class="collapse inner-clp show">
                                <p>Aku puas banget dengan pelayanan Wilopo Cargo, karena semua kirimanku tidak pernah ada masalah dan selalu sampai di tempatku dengan aman. Memang kadang ada yang hilang atau rusak karena proses pengiriman, tapi selalu diganti
                                    sama pihak Wilopo Cargo sesuai dengan nilai barang saya. Top Banget!<br></p>
                            </div>
                        </li>
                        <li>
                            <div class="testi-blok-link">
                                <div class="img-testi"><img src="assets/img/testi1.jpg"></div><a class="link-testi" href="#faq-5" data-toggle="collapse">Reyhan Saputra<span>Owner RX Tekstile</span></a></div>
                            <div id="faq-5" class="collapse inner-clp">
                                <p>Sudah 3 tahun saya menggunakan jasa Wilopo Cargo sebagai forwarder utama saya dalam mengimport kain tekstil grosir dari China. Selain harganya yang sangat murah, saya juga tidak pernah kecewa dengan pelayanan Wilopo Cargo
                                    yang selalu mengutamakan pelanggan. Walaupun ada masalah, Wilopo Cargo selalu memberikan solusi yang fair dan tidak merugikan saya.<br></p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="text-center p-3"><a class="link-cta fill" href="https://wilopocargo.com/gabungsekarang?utm_source=dm&utm_source=dm&utm_medium=landingpage2&utm_campaign=gabungsekarangbutton#contactus">Gabung Sekarang Gratis</a></div>
        </div>
        <div class="line-kapal"><img src="assets/img/kapal-layar.svg"></div>
    </section>
    <!-- End: section testi -->
    <!-- Start: Section Promo -->
    <section class="section-promo">
        <div class="container-fluid p-0 bg-transparent z-front">
            <div class="row no-gutters">
                <div class="col-8 col-sm-8 col-md-4 col-lg-4 col-xl-4"><img src="assets/img/promo-dorong.svg"></div>
                <div class="col-lg-8 col-xl-8">
                    <div class="text-promo">
                        <h1 class="judul-huge"><span>Promo Ongkir</span>&nbsp;BULAN INI</h1>
                        <h5>JANGAN SAMPAI KETINGGALAN</h5>
                        <p>Untuk customer yang daftar di Bulan September akan mendapatkan harga special! Hanya bulan ini!</p><a class="link-cta sm" href="https://wilopocargo.com/gabungsekarang?utm_source=dm&utm_source=dm&utm_medium=landingpage2&utm_campaign=gabungsekarangbutton#contactus">Gabung Sekarang Gratis</a></div>
                </div>
            </div>
        </div>
    </section>
    <!-- End: Section Promo -->
    <!-- Start: Section Pricelist -->
    <section class="section-pricelist gradien-pricelist">
        <div class="container">
            <div class="text-center mb-5">
                <h1 class="text-uppercase text-white judul-huge">PRICELIST</h1>
            </div>
            <div class="karosel-harga owl-carousel owl-theme">
                <div class="item-harga"><img src="assets/img/barang-besar.png">
                    <h1>Barang Besar</h1>
                    <p>Berat, Mesin, &amp; Lartas</p>
                    <p class="font-weight-bold"><span>8jt / cbm</span><br>7 jt / CBM</p>
                </div>
                <div class="item-harga"><img src="assets/img/garmen.png">
                    <h1>Garmen</h1>
                    <p class="font-weight-bold"><span>11jt / cbm</span><br>10 jt / CBM</p>
                </div>
                <div class="item-harga"><img src="assets/img/semi-garmen.png">
                    <h1>Semi Garmen</h1>
                    <p class="font-weight-bold"><span>8,5 jt / cbm</span><br>7,5 jt / CBM</p>
                </div>
                <div class="item-harga"><img src="assets/img/barang-umum.png">
                    <h1>Barang Umum</h1>
                    <p class="font-weight-bold"><span>8jt / cbm</span><br>7 jt / CBM</p>
                </div>
                <div class="item-harga"><img src="assets/img/sepatu.png">
                    <h1>Sepatu</h1>
                    <p class="font-weight-bold"><span>7 jt / cbm</span><br>6 jt / CBM</p>
                </div>
                <div class="item-harga"><img src="assets/img/tas.png">
                    <h1>Tas</h1>
                    <p class="font-weight-bold"><span>6,5 jt / cbm</span><br>5 jt / CBM</p>
                </div>
                <div class="item-harga"><img src="assets/img/textile.png">
                    <h1>tekstil</h1>
                    <p class="font-weight-bold"><span>9 jt / cbm</span><br>8 jt / CBM</p>
                </div>
            </div>
            <div class="text-white p-3 text-center">
                <p>*Pengiriman barang diatas 10 CBM / BULAN, akan kami potong lagi 500 RB / CBM<br></p><a class="link-cta fill" href="https://wilopocargo.com/gabungsekarang?utm_source=dm&utm_source=dm&utm_medium=landingpage2&utm_campaign=gabungsekarangbutton#contactus">Gabung Sekarang Gratis</a></div>
        </div>
    </section>
    <!-- End: Section Pricelist -->
    <!-- Start: Section Calculator -->
    <section class="section-kalkulator">
        <div class="container">
            <div class="mb-3">
                <h1 class="text-uppercase judul-huge">Hitung Biaya&nbsp;<span>Impor Anda</span></h1>
            </div>
            <div class="row">
                <div class="col-lg-6 col-xl-6">
                    <form class="form-kalkulator">
                        <div class="form-gr">
                          <label for="kategoriBarang">Kategori Barang</label>
                          <select class="form-control" id="jenis_barang" name="id_jenis_barang">
                            <?php while($row_jenis_barang = mysql_fetch_array($sql_jenis_barang)) { ?>
                              <option value="<?php echo $row_jenis_barang['id'] ?>"> <?php echo $row_jenis_barang['namalain']; ?> </option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="form-gr"><label for="jumlahDus">Jumlah Dus</label><input id="ctns" class="form-control" type="number" name="ctns"></div>
                        <div class="form-row form-gr">
                            <div class="col-4">
                                <div class="form-gr"><label for="panjangCm">Panjang (cm)</label><input id="panjang" class="form-control" type="number" name="panjang"></div>
                            </div>
                            <div class="col-4">
                                <div class="form-gr"><label for="lebar">Lebar (cm)</label><input id="lebar" class="form-control" type="number" name="lebar"></div>
                            </div>
                            <div class="col-4">
                                <div class="form-gr"><label for="tinggi">Tinggi (cm)</label><input id="tinggi" class="form-control" type="number" name="tinggi"></div>
                            </div>
                        </div>
                        <div class="form-row form-gr">
                            <div class="col-6">
                                <div class="form-gr"><label for="berat">Berat Dus (KG)</label><input id="berat" class="form-control" type="number" name="berat"></div>
                            </div>
                            <div class="col-6">
                                <div class="form-gr"><label for="nilaitotal">Nilai Biaya Total</label><input id="rmb" class="form-control" type="number" name="rmb"></div>
                            </div>
                        </div>
                        <div><button class="btn btn-danger border-50" id="hitungimpor" type="button">Hitung</button></div>
                </form>
            </div>
            <div class="col">
                <form class="form-hasil"><label class="text-uppercase font-weight-bold" for="biaya">Biaya Impor</label>
                    <div class="form-hasil-inner"><input class="form-control" type="text" id="hasilnya" name="biaya"></div>
                </form>
            </div>
        </div>
        </div>
    </section>
    <!-- End: Section Calculator -->
    <!-- Start: Section Contact -->
    <section class="section-contact" id="contactus"><img class="of-sep" src="assets/img/ofset-wafe.svg">
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-lg-6 col-xl-6">
                    <h1 class="judul-huge font-weight-bold">Ajukan Sekarang!</h1>
                    <p>*Setelah pengajuan anda kami terima, tim kami akan segera menghubungi anda.</p>
                    <form class="form-contact" action="backend/daftar.php" method="post">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-user"></i></span></div><input class="form-control" type="text" placeholder="Nama" name="nama"></div>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fab fa-whatsapp"></i></span></div><input class="form-control" type="text" placeholder="Whatsapp" name="whatsapp" inputmode="tel"></div>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-envelope"></i></span></div><input class="form-control" type="text" placeholder="Email" name="email" inputmode="tel"></div>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-map"></i></span></div><input class="form-control" type="text" placeholder="Alamat kirim" name="alamat" inputmode="tel"></div>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-box"></i></span></div>
                            <input class="form-control" type="text" placeholder="Barang apa yang dijual?" name="jenis_barang">
                        </div>
                        <div class="form-group bg-white p-2 mb-1"><label>Apakah anda sudah pernah menggunakan cargo ke China?</label>
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-check form-check-inline"><input class="form-check-input" name="sp_cargo" value="ya" type="radio" id="formCheck-1" ><label class="form-check-label" for="formCheck-1">Ya</label></div>
                                </div>
                                <div class="col">
                                    <div class="form-check form-check-inline"><input class="form-check-input" name="sp_cargo" value="tidak" type="radio" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Tidak</label></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group bg-white p-2 mb-2"><label>Apakah anda sudah mempunyai suplier ke China?</label>
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-check form-check-inline"><input class="form-check-input" name="sp_supplier" value="ya" type="radio" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Ya</label></div>
                                </div>
                                <div class="col">
                                    <div class="form-check form-check-inline"><input class="form-check-input" name="sp_supplier" value="tidak" type="radio" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Tidak</label></div>
                                </div>
                            </div>
                        </div>
                        <div><button class="btn btn-danger border-50" type="submit">Gabung Sekarang Gratis</button></div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- End: Section Contact --><a class="float-whatsapp" id="wastickyajax" href="https://api.whatsapp.com/send?phone=6281310085523&text=Halo,%20saya%20ingin%20bertanya%20kepada%20cs%20Wilopo%20Cargo....%20"><i class="fab fa-whatsapp"></i><div class="tcl"><p>Masih bingung?<br>Yuk chat dengan admin.</p></div></a>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/style.js"></script>
    <script src="assets/js/select2.min.js"></script>
    <script src="assets/js/loadingoverlay.min.js"></script>
    <script type="text/javascript">
      $(window).on('load',function(){
          $('#myModal').modal('show');
      });
    </script>
    <script type="text/javascript">
      function numberWithCommas(x) {
        var	number_string = x.toString(),
          	split	= number_string.split(','),
          	sisa 	= split[0].length % 3,
          	rupiah 	= split[0].substr(0, sisa),
          	ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);

          if (ribuan) {
          	separator = sisa ? '.' : '';
          	rupiah += separator + ribuan.join('.');
          }
          rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return "Total : Rp. "+rupiah;
      }
      $("#hitungimpor").click(function(){ // Ketika user mengganti atau memilih Customer
        $.ajax({
          type: "POST", // Method pengiriman data bisa dengan GET atau POST
          url: "backend/api_ajax.php", // Isi dengan url/path file php yang dituju
          data: {
                  id_jenis_barang : $("#jenis_barang").val(),
                  ctns : $("#ctns").val(),
                  panjang : $("#panjang").val(),
                  lebar : $("#lebar").val(),
                  tinggi : $("#tinggi").val(),
                  berat : $("#berat").val(),
                  rmb : $("#rmb").val(),
                }, // data yang akan dikirim ke file yang dituju
          dataType: "json",
          beforeSend: function(e) {
            if(e && e.overrideMimeType) {
              e.overrideMimeType("application/json;charset=UTF-8");
            }
          },
          success: function(response){ // Ketika proses pengiriman berhasil
            console.log(numberWithCommas(response.hasil));
            $("#hasilnya").val(numberWithCommas(response.hasil));
          },
          error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
          }
        });
        $("#wastickyajax").click(function(){ // Ketika user mengganti atau memilih Customer
          $.ajax({
            type: "POST", // Method pengiriman data bisa dengan GET atau POST
            url: "backend/whatsapp.php",
            success: function(response){ // Ketika proses pengiriman berhasil

            },
            error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
              alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
            }
          });
      });
    </script>
    <script type="text/javascript">
      $(document).ready(function(){
        // $('form').submit(function() {
        //   $.LoadingOverlay("show");
        // });
        $('.jb').select2({});
      });
    </script>
    <script type="text/javascript">
            $(document).ready(function(){
              setTimeout(function(){$(".alert").fadeIn('fast');}, 100);});
              //angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
              setTimeout(function(){$(".alert").fadeOut('fast');}, 5000);
    </script>

</body>

</html>
