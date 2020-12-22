<!DOCTYPE html>
<html lang="id">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="google-site-verification" content="TccR4AHzVDtMaW3XKrmOT8pv10VGAmlKF4c2dl6OEUg" />
    <meta name="viewport" content="width=412, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script type="module" href="<?php echo base_url(); ?>assets/dashboard/js/pwabuilder-sw-register.json"> </script>
    <link rel="manifest" href="<?php echo base_url(); ?>manifest.json" />
    <!-- <title>Customer Area | Wilopo Cargo</title> -->
    <meta name="theme-color" content="#169CDA">
    <link rel="apple-touch-icon" href="<?php echo base_url(); ?>assets/dashboard/gambar/apple_touch.png">
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>assets/dashboard/gambar/favicon.png"/>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,400i,500,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dashboard/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dashboard/css/style.css?v=21">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script type="module" src="https://cdn.jsdelivr.net/npm/@pwabuilder/pwainstall"></script>
</head>
<body>

    <div id="wrapBody" class="body-wrapper">
        <!-- Sidebar Menu -->
        <div id="sidebarMenu" class="sidebar-wrapper">
            <div class="inner">
                <a href="#" class="logo">
                    <img class="logoFull" src="<?php echo base_url(); ?>assets/dashboard/gambar/logo.png" alt="Wilopo">
                    <img class="logoKecil" src="<?php echo base_url(); ?>assets/dashboard/gambar/ic-logo.png" alt="Wilopo">
                    <img class="menuToggle tutup" src="<?php echo base_url(); ?>assets/dashboard/gambar/icw-close.svg" alt="">
                </a>
                <ul class="nav sidebar-menu">
                    <li class="nav-item"><a href="<?php echo base_url(); ?>dashboard" class="nav-link <?php if($this->uri->segment(1)=="dashboard"){echo "active";}?>"><img src="<?php echo base_url(); ?>assets/dashboard/gambar/ic-dashboard.svg" alt=""><span>Beranda</span></a></li>

                    <li class="nav-item"><a href="<?php echo base_url(); ?>classimport" class="nav-link <?php if($this->uri->segment(1)=="classimport"){echo "active";}?>"><img src="<?php echo base_url(); ?>assets/dashboard/gambar/ic-kelas.svg" alt=""><span>Kelas Impor</span></a></li>
                    <!--<li class="nav-item"><a target="_blank" href="https://wilopocargo.com/jagoan-impor#daft" class="nav-link <?php if($this->uri->segment(1)=="classimport"){echo "active";}?>"><img src="<?php echo base_url(); ?>assets/dashboard/gambar/ic-kelas.svg" alt=""><span>Kelas Impor</span></a></li>-->
                    <li class="nav-item"><a href="<?php echo base_url(); ?>resi" class="nav-link <?php if($this->uri->segment(1)=="resi" && ($this->uri->segment(2)!="resi_order" && $this->uri->segment(2)!="request_resi") ){echo "active";}?>"><img src="<?php echo base_url(); ?>assets/dashboard/gambar/ic-resi.svg" alt=""><span>Resi</span></a></li>
                    <li class="nav-item"><a href="<?php echo base_url(); ?>resi/resi_order" class="nav-link <?php if($this->uri->segment(1)=="resi" && ($this->uri->segment(2)=="resi_order" || $this->uri->segment(2)=="request_resi") ){echo "active";}?>"><img src="<?php echo base_url(); ?>assets/dashboard/gambar/ic-box.svg" alt=""><span>Kirim Barang</span></a></li>
                    <li class="nav-item"><a href="<?php echo base_url(); ?>titiptransfer" class="nav-link <?php if($this->uri->segment(1)=="titiptransfer"){echo "active";}?>"><img src="<?php echo base_url(); ?>assets/dashboard/gambar/ic-titiptf.svg" alt=""><span>Titip Transfer</span></a></li>
                    <li class="nav-item"><a href="<?php echo base_url(); ?>invoices" class="nav-link <?php if($this->uri->segment(1)=="invoices"){echo "active";}?>"><img src="<?php echo base_url(); ?>assets/dashboard/gambar/ic-invoice.svg" alt=""><span>Invoices</span></a></li>
                    <li class="nav-item"><a href="<?php echo base_url(); ?>pembayaran" class="nav-link <?php if($this->uri->segment(1)=="pembayaran"){echo "active";}?>"><img src="<?php echo base_url(); ?>assets/dashboard/gambar/ic-pembayaran.svg" alt=""><span>Pembayaran</span></a></li>
                    <li class="nav-item"><a href="<?php echo base_url(); ?>saldo" class="nav-link <?php if($this->uri->segment(1)=="saldo"){echo "active";}?>"><img src="<?php echo base_url(); ?>assets/dashboard/gambar/ic-saldo.svg" alt=""><span>Saldo</span></a></li>
                </ul>
                <hr>
                <ul class="nav sidebar-menu mt-0" >
                    <li class="nav-item"><a href="<?php echo base_url(); ?>referral" class="nav-link"><img src="<?php echo base_url(); ?>assets/dashboard/gambar/ic-refer.svg" alt=""><span>Referral</span></a></li>
                    <li class="nav-item"><a href="<?php echo base_url(); ?>pusatbantuan" class="nav-link"><img src="<?php echo base_url(); ?>assets/dashboard/gambar/ic-bantuan.svg" alt=""><span>Pusat Bantuan</span></a></li>
                    <li class="nav-item"><a href="<?php echo base_url(); ?>pengaturan" class="nav-link"><img src="<?php echo base_url(); ?>assets/dashboard/gambar/ic-setting.svg" alt=""><span>Pengaturan</span></a></li>
                </ul>
            </div>
        </div>
        <script src="<?php echo base_url(); ?>assets/dashboard/js/jquery.min.js"></script>
        <div class="konten-wrapper">
            <!--Start Topbar-->
            <div class="topbar-navbar">
                <div class="topbar-container">
                    <div class="topbar-a">
                        <ul class="list-unstyled d-flex m-0 align-items-center">
                            <li>
                                <a class="menuToggle" href="#"><img src="<?php echo base_url(); ?>assets/dashboard/gambar/ic-menu.svg" alt="menu"></a>
                            </li>
                            <div class="info-marking">
                                <p><span><?php echo $this->session->userdata('kode');?></span></p>
                            </div>
                            <!--<li>-->
                            <!--    <form  action=""><input class="form-control tp-pencarian" autocomplete="none" type="search" placeholder="pencarian"></form>-->
                            <!--</li>-->
                        </ul>
                    </div>
                    <div class="topbar-b">
                        <ul class="list-unstyled list-ikon m-0">
                            <!--<li>-->
                            <!--    <div class="dropdown menu-icon">-->
                            <!--        <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                            <!--            <i class="fa fa-bell"></i>-->
                            <!--        </button>-->
                            <!--        <div class="dropdown-menu dropdown-menu-right">-->
                            <!--            <ul class="list-unstyled mb-2">-->
                            <!--                <li class="m-0 p-0"><a class="dropdown-item" href="#">-->
                            <!--                    <div class="inner-drop">-->
                            <!--                        <div class="gbr">-->
                            <!--                            <img src="<?php echo base_url(); ?>assets/dashboard/gambar/notif-kelas.svg" alt="">-->
                            <!--                        </div>-->
                            <!--                        <div class="detail">-->
                            <!--                            <span class="badge badge-kelas ">Kelas Import</span>-->
                            <!--                            <p>Pembayaran invoice <span>#12387345</span> berhasil dilakukan</p>-->
                            <!--                        </div>-->
                            <!--                    </div>-->
                            <!--                    </a>-->
                            <!--                </li>-->
                            <!--                <li class="m-0 p-0"><a class="dropdown-item" href="#">-->
                            <!--                    <div class="inner-drop">-->
                            <!--                        <div class="gbr">-->
                            <!--                            <img src="<?php echo base_url(); ?>assets/dashboard/gambar/notif-finance.svg" alt="">-->
                            <!--                        </div>-->
                            <!--                        <div class="detail">-->
                            <!--                            <span class="badge badge-finance ">Finance</span>-->
                            <!--                            <p>Pembayaran invoice <span>#12387345</span> berhasil dilakukan</p>-->
                            <!--                        </div>-->
                            <!--                    </div>-->
                            <!--                    </a>-->
                            <!--                </li>-->
                            <!--                <li class="m-0 p-0"><a class="dropdown-item" href="#">-->
                            <!--                    <div class="inner-drop">-->
                            <!--                        <div class="gbr">-->
                            <!--                            <img src="<?php echo base_url(); ?>assets/dashboard/gambar/notif-referral.svg" alt="">-->
                            <!--                        </div>-->
                            <!--                        <div class="detail">-->
                            <!--                            <span class="badge badge-referral">Referral</span>-->
                            <!--                            <p>Pembayaran invoice <span>#12387345</span> berhasil dilakukan</p>-->
                            <!--                        </div>-->
                            <!--                    </div>-->
                            <!--                    </a>-->
                            <!--                </li>-->
                            <!--            </ul>-->
                            <!--            <a class="semua" href="#">Lihat Semua Notifikasi</a>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--</li>-->
                            <!--<li>-->
                            <!--    <div class="dropdown menu-icon">-->
                            <!--        <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                            <!--            <i class="fa fa-globe-asia"></i>-->
                            <!--            <span class="badge badge-light">2</span>-->
                            <!--        </button>-->
                            <!--        <div class="dropdown-menu dropdown-menu-right">-->
                            <!--            <ul class="list-unstyled mb-2">-->
                            <!--                <li class="m-0 p-0"><a class="dropdown-item" href="#">-->
                            <!--                    <div class="inner-drop">-->
                            <!--                        <div class="gbr">-->
                            <!--                            <img src="<?php echo base_url(); ?>assets/dashboard/gambar/notif-kelas.svg" alt="">-->
                            <!--                        </div>-->
                            <!--                        <div class="detail">-->
                            <!--                            <span class="badge badge-kelas ">Kelas Import</span>-->
                            <!--                            <p>Pembayaran invoice <span>#12387345</span> berhasil dilakukan</p>-->
                            <!--                        </div>-->
                            <!--                    </div>-->
                            <!--                    </a>-->
                            <!--                </li>-->
                            <!--                <li class="m-0 p-0"><a class="dropdown-item" href="#">-->
                            <!--                    <div class="inner-drop">-->
                            <!--                        <div class="gbr">-->
                            <!--                            <img src="<?php echo base_url(); ?>assets/dashboard/gambar/notif-finance.svg" alt="">-->
                            <!--                        </div>-->
                            <!--                        <div class="detail">-->
                            <!--                            <span class="badge badge-finance ">Finance</span>-->
                            <!--                            <p>Pembayaran invoice <span>#12387345</span> berhasil dilakukan</p>-->
                            <!--                        </div>-->
                            <!--                    </div>-->
                            <!--                    </a>-->
                            <!--                </li>-->
                            <!--                <li class="m-0 p-0"><a class="dropdown-item" href="#">-->
                            <!--                    <div class="inner-drop">-->
                            <!--                        <div class="gbr">-->
                            <!--                            <img src="<?php echo base_url(); ?>assets/dashboard/gambar/notif-referral.svg" alt="">-->
                            <!--                        </div>-->
                            <!--                        <div class="detail">-->
                            <!--                            <span class="badge badge-referral">Referral</span>-->
                            <!--                            <p>Pembayaran invoice <span>#12387345</span> berhasil dilakukan</p>-->
                            <!--                        </div>-->
                            <!--                    </div>-->
                            <!--                    </a>-->
                            <!--                </li>-->
                            <!--            </ul>-->
                            <!--            <a class="semua" href="#">Lihat Semua Notifikasi</a>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--</li>-->
                            <li>
                                <div class="dropdown menu-profil">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <div class="foto-cst"><img src="<?php echo base_url(); ?>assets/dashboard/gambar/dummy-cst.png" alt="user"></div><span><?php echo $this->session->userdata('nama');?></span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <div class="head-dropmenu">
                                            <div class="pic-profil">
                                                <img src="<?php echo base_url(); ?>assets/dashboard/gambar/dummy-cst.png" alt="">
                                            </div>
                                            <h3><?php echo $this->session->userdata('nama');?></h3>
                                        </div>
                                        <a class="dropdown-item" href="<?php echo base_url(); ?>pengaturan"><img src="<?php echo base_url(); ?>assets/dashboard/gambar/ic-akun.svg" alt="">Pengaturan Akun</a>
                                        <a class="dropdown-item" href="<?php echo base_url(); ?>pengaturan/finance"><img src="<?php echo base_url(); ?>assets/dashboard/gambar/ic-finance.svg" alt="">Finance</a>
                                        <a class="dropdown-item" href="<?php echo base_url(); ?>pengaturan/keamanan"><img src="<?php echo base_url(); ?>assets/dashboard/gambar/ic-alat.svg" alt="">Keamanan</a>
                                        <a class="dropdown-item dropdown-signout" href="<?php echo base_url(); ?>login/logout"><img src="<?php echo base_url(); ?>assets/dashboard/gambar/ic-signout.svg" alt="">Keluar</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--End Topbar-->
            <?php echo $contents;  ?>
            <footer class="footer-wrapper">
                <!-- Chat Whatsapp -->
                <?php
                  $customer = $this->db->select('id_crm')->where('id_cust',$this->session->userdata('id_cust'))->get('customer')->row();
                  $pengguna = $this->db->where('id_pengguna',$customer->id_crm)->get('pengguna')->row();
                  if($customer->id_crm == 0 || $customer->id_crm =="" || $customer->id_crm == null){
                ?>
                  <a class="float-whatsapp" target="_blank_" id="wastickyajax" href="https://wilopocargo.com/chat_sales?id=C10"><i class="fab fa-whatsapp"></i><div class="tcl"><p>Butuh Bantuan?<br>Hubungi kami sekarang</p></div></a>
                <?php }else{ ?>
                  <a class="float-whatsapp" target="_blank_" id="wastickyajax"
                   href="<?php echo 'https://api.whatsapp.com/send?phone='.$pengguna->nama_pengguna.'&text='.$pengguna->whatsapp ?>">
                   <i class="fab fa-whatsapp"></i><div class="tcl"><p>Butuh Bantuan?<br>Hubungi kami sekarang</p></div>
                  </a>
                <?php } ?>
            </footer>
        </div>
        <?php
                $statusimport=$this->db->select('s_aktivasi')->from('customer')
                        ->where('id_cust',$this->session->userdata('id_cust'))
                        ->get()->row();
        ?>
        <?php if($statusimport->s_aktivasi == 0){ ?>
        <!-- alert nonaktif -->
        <div class="alert alert-light alert-dismissible show float-notif"  role="alert">
          <p class="m-0"><b>Sudah Siap Import <?php echo $this->session->userdata('nama');?>?</b>
          <small class="d-block">Jika Anda sudah menemukan supplier dan barang yg ingin diimpor, Anda bisa langsung mengaktifkan akun dengan <a class="text-danger" target="blank" href="https://wilopocargo.com/chat_sales?id=C10">Whatsapp Sales Kami Sekarang!</a></small>

          </p>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span>&times;</span>
          </button>
        </div>
        <?php } ?>
    </div>

    <!-- Script Default -->

    <script src="<?php echo base_url(); ?>assets/dashboard/js/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/dashboard/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/dashboard/js/all.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/dashboard/js/style.js?v=21"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script> -->
    <script src="<?php echo base_url() ?>assets/register_login/js/loadingoverlay.min.js"></script>
    <script type="text/javascript">
      $('form').submit(function() {
            $.LoadingOverlay("show");
      });
    </script>
</body>
</html>
