<title>Wilopo Cargo - Kelas Impor</title>
<section class="main-konten">
        <div class="container-fluid">
            <!--Start Jumbotron -->
            <div class="jumbotron-default bg-class">
                <div class="judul-jumbotron">
                    <h3><img src="<?php echo base_url(); ?>assets/dashboard/gambar/ic-kelas.svg" alt="">Kelas Import</h3>
                </div>
                 <!-- Gambar Upload dari Admin -->
                <img class="gb-tema" src="<?php echo base_url(); ?>assets/dashboard/gambar/bg-kelas.png" alt="tema">
            </div>
            <!--End Jumbotron-->
            <!--Start Main Konten-->

            <div class="top-minus">
                <div class="kartu-banner">
                    <div class="row no-gutters align-items-center">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="profil-klas">
                                <div class="img">
                                    <img src="<?php echo base_url(); ?>assets/dashboard/gambar/user-kelas.png" alt="user">
                                </div>
                                <div class="name">
                                    <p>Selamat datang di Kelas,</p>
                                    <h3><?php echo $this->session->userdata('nama');?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="profil-mat">
                                <div class="figur">
                                    <img src="<?php echo base_url(); ?>assets/dashboard/gambar/cover-play.png" alt="cover play" alt="">
                                </div>
                                <div class="info">
                                    <label for="">Materi Saya:</label>
                                    <h3>1. Memulai bisnis import untuk pemula</h3>
                                    <p>Progress:</p>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo (@$jumditonton->jumlahnya/(count($lv)))*100; ?>%"></div>
                                    </div>
                                    &nbsp;<a href="<?php echo base_url(); ?>classimport/play/<?php echo $lj->videoId;?>" class="btn btn-primary">Lanjutkan Materi</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $idcust=$this->session->userdata('id_cust');?>
        <?php

        foreach($kategori as $kat){ ?>
            <div class="row kolom-row">
                <div class="list-video">
                    <div class="judul-row">
                        <h3>Kategori <span><?php echo $kat->judul; ?> </span></h3>
                        <!--<a href="#"><i class="fa fa-play-circle"></i> Putar Semua</a>-->
                    </div>
                    <ul class="list-grup">
                    <?php
                            $lvnya=array();
            		    	$lvnya=$this->db->select('y_video.*')->from('y_video')->where('id_kategori_video', $kat->id)->order_by('title', 'ASC')->get()->result();


                     foreach($lvnya as $item){  if(isset($item->videoId)){
                        $statustonton=$this->db->select('id')->from('status_tonton')
                        ->where('videoid',$item->videoId)
                        ->where('id_cust',$idcust)
                        ->get()->row();
                        ?>
                        <li>
                            <!--Sudah Ditonton-->
                        <?php if(@$statustonton->id > 0){?>
                            <a class="video-item ditonton" href="<?php echo base_url(); ?>classimport/play/<?php echo $item->videoId ;?>">
                                <label class="badge badge-success badge-pill" for=""><i class="fa fa-check-circle"></i> Ditonton</label>
                        <?php }else{?>
                            <a class="video-item" href="<?php echo base_url(); ?>classimport/play/<?php echo $item->videoId ;?>">
                                <label class="badge badge-success badge-pill" for=""><i class="fa fa-check-circle"></i> Putar Sekarang</label>
                        <?php } ?>
                                <div class="vid-inner">
                                    <div class="thumb">
                                        <img src="<?php echo $item->thumbnails; ?>" alt="">
                                    </div>
                                    <div class="detail">
                                        <h3><?php echo $item->title; ?></h3>
                                        <p><?php echo substr($item->description,0,100);?>....</p>
                                    </div>
                                </div>
                            </a>
                            <!--End Sudah Ditontont-->
                        </li>
                    <?php } } ?>

                    </ul>
                </div>
            </div>
            <?php } ?>
            <!--End Main Konten-->
        </div>

</section>
