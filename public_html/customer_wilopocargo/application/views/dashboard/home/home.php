<!-- Ganti Marking dari customer kelas Impor -->
<title>Wilopo Cargo - Dashboard</title>
<!-- Main Konten -->
    <section class="main-konten">
        <div class="container-fluid">

            <!-- Jumbotron -->
            <div class="jumbotron-banner">
                <div class="inner">
                    <div class="say-hai">
                        <div class="gb">
                            <img src="<?php echo base_url(); ?>assets/dashboard/gambar/ic-cerah.svg" alt="">
                        </div>

                        <div class="teks-hai">
                            <?php
                                $daftar_hari = array(
                                 'Sunday' => 'Minggu',
                                 'Monday' => 'Senin',
                                 'Tuesday' => 'Selasa',
                                 'Wednesday' => 'Rabu',
                                 'Thursday' => 'Kamis',
                                 'Friday' => 'Jumat',
                                 'Saturday' => 'Sabtu'
                                );
                                $date=date('Y-m-d H:i:s');
                                $namahari = date('l', strtotime($date));
                            ?>
                            <p><Span><?=$daftar_hari[$namahari];?></Span>, <span><?=date('d-M-Y');?></span> | <span><?=date('H:i');?></span></p>
                            <h3 class="teks-welcome">
                                <?php $b = time();
                                $hour = date("G",$b);

                                if ($hour>=0 && $hour<=11)
                                {
                                echo "Selamat Pagi!";
                                }
                                elseif ($hour >=12 && $hour<=14)
                                {
                                echo "Selamat Siang!";
                                }
                                elseif ($hour >=15 && $hour<=17)
                                {
                                echo "Selamat Sore!";
                                }
                                elseif ($hour >=17 && $hour<=18)
                                {
                                echo "Selamat Petang!";
                                }
                                elseif ($hour >=19 && $hour<=23)
                                {
                                echo "Selamat Malam!";
                                }?>, <span><?php echo $this->session->userdata('nama');?></span>!</h3>
                        </div>

                    </div>
                </div>
                 <!-- Gambar Upload dari Admin -->
                <img class="gb-tema" src="<?php echo base_url(); ?>assets/dashboard/gambar/topbar-bg.jpeg" alt="tema">
            </div>
            <div class="row kolom-row top-minus">
                        <div class="col-lg-3 col-md-3 col-xl-3">
                            <div class="kartu ">
                                <div class="head-kartu nobg">
                                    <div class="kiri">
                                        <h3><i class="fa fa-money-bill text-danger"></i> Invoices</h3>
                                    </div>
                                    <div class="kanan">
                                        <a href="#" class="text-secondary"><i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                                <div class="row-kartu">
                                    <div class="item ds w-100">
                                        <div class="figur ds">
                                            <img src="<?php echo base_url(); ?>assets/dashboard/gambar/ic-invoice.svg" alt="">
                                        </div>
                                        <div class="report">
                                            <label class="text-secondary" for="">Belum Dibayar</label>
                                            <h1 class="text-danger"><span>Rp.</span><?php echo number_format(@$invjumlah->jumlahnya);?>,-</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-xl-3">
                            <div class="kartu ">
                                <div class="head-kartu nobg">
                                    <div class="kiri">
                                        <h3><i class="fa fa-list"></i> Resi Barang</h3>
                                    </div>
                                    <div class="kanan">
                                        <a href="#" class="text-secondary"><i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                                <div class="row-kartu">
                                    <div class="item ds w-100">
                                        <div class="figur ds">
                                            <img src="<?php echo base_url(); ?>assets/dashboard/gambar/ic-resi.svg" alt="">
                                        </div>
                                        <div class="report">
                                            <label class="text-secondary" for="">Dalam Perjalanan</label>
                                            <h1><?php echo $resi->jumlahnya; ?></h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-xl-3">
                            <div class="kartu ">
                                <div class="head-kartu nobg">
                                    <div class="kiri">
                                        <h3><i class="fa fa-money-check text-success"></i> Saldo</h3>
                                    </div>
                                    <div class="kanan">
                                        <a href="#" class="text-secondary"><i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                                <div class="row-kartu">
                                    <div class="item ds w-100">
                                        <div class="figur ds">
                                            <img src="<?php echo base_url(); ?>assets/dashboard/gambar/ic-saldo.svg" alt="">
                                        </div>
                                        <div class="report">
                                            <label class="text-secondary" for="">Saldo Keseluruhan</label>
                                            <h1><span>Rp.</span><?php echo number_format($deposit->jumlah);?>,-</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-xl-3">
                            <div class="kartu ">
                                <div class="head-kartu nobg">
                                    <div class="kiri">
                                        <h3><i class="fa fa-exchange-alt text-info"></i> Titip Transfer</h3>
                                    </div>
                                    <div class="kanan">
                                        <a href="#" class="text-secondary"><i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                                <div class="row-kartu">
                                    <div class="item ds w-100">
                                        <div class="figur ds">
                                            <img src="<?php echo base_url(); ?>assets/dashboard/gambar/ic-titiptf.svg" alt="">
                                        </div>
                                        <div class="report">
                                            <label class="text-secondary" for="">Transaksi Pending</label>
                                            <h1><?php echo $pending->jumlahnya; ?></h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if($this->session->flashdata('msg')=='success'){ ?>

                    <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Terimakasih Ganti Marking Berhasil
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    </div></p>

                    <?php } ?>
                    <div class="row kolom-row">
                        <div class="col-md-7 col-lg-7 col-xl-7">
                            <!-- Lanjutkan Materi -->
                            <div class="kartu">
                                <div class="head-kartu">
                                    <div class="kiri">
                                        <h3><i class="fa fa-play-circle text-danger"></i> Lanjutkan Kelas Import</h3>
                                    </div>
                                </div>
                                <div class="profil-mat">
                                    <div class="figur">
                                        <img src="<?php echo base_url(); ?>assets/dashboard/gambar/cover-play.png" alt="">
                                    </div>
                                    <div class="info">
                                        <h3><?php echo $lj->judul;?></h3>
                                        <p>Progress:</p>
                                        <div class="progress">
                                            <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo (@$jumditonton->jumlahnya/(count($lv)))*100; ?>%"></div>
                                        </div>
                                        <a href="<?php echo base_url(); ?>classimport/play/<?php echo $lj->id;?>" class="btn btn-primary">Lanjutkan Materi</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-lg-5 col-xl-5">
                            <div class="kartu">
                                <div class="head-kartu">
                                    <div class="kiri">
                                        <h3><i class="fa fa-history text-info"></i>Aktifitas Terbaru</h3>
                                    </div>
                                </div>
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
