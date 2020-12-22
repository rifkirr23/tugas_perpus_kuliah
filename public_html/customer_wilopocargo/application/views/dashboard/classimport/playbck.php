<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Wilopo Cargo - Kelas Impor</title>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,400i,500,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dashboard/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dashboard/css/style.css">
</head>
<body>
<?php foreach($detail->items as $dt){  if(isset($dt->id->videoId)){
    $idvideo=$dt->id->videoId;
    $keterangan=$dt->snippet->description;
    $judulnya=$dt->snippet->title;
} } ?>
<section class="section-play">
    <div class="topbar-play">
        <h3><a href="<?php echo base_url(); ?>classimport"><i class="fa fa-arrow-left"></i> Kembali ke daftar video</a></h3>
        <a id="tutupMenuVideo" href="#"><i class="fa fa-compress"></i></a>
    </div>
    <div id="jendelaKonten" class="jendela-konten">
        <div class="jendela-video">
            <div class="wrap-video">
                <iframe src="https://www.youtube.com/embed/<?php echo $idvideo; ?>?controls=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

            </div>
            <div class="video-action">
                <button class="btn btn-secondary" onClick="clicksebelumnya()" type="button">Sebelumnya</button>
                <button class="btn btn-primary" onClick="clickselanjutnya()" type="button">Selanjutnya</button>
            </div>
        </div>
        <div class="daftar-antrian">
            <nav>
                <div class="nav nav-tabs tab-side" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fa fa-book-reader"></i> Deskripsi</a>
                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fa fa-list"></i> List Video</a>
                </div>
            </nav>
            <div class="overflow-x">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="deskripsi-video">
                            <h3><?php $judulnya; ?></h3>
                            <p>
                               <?php echo $keterangan; ?></p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="overflow-x">
                            <ul class="list-unstyled list-video-track">
                            <?php foreach($lv->items as $key => $item){  if(isset($item->id->videoId)){?>
                                <li>
                            <a class="item-track <?php if($item->id->videoId == $idvideo){?>active<?php } ?>" href="<?php echo base_url(); ?>classimport/play/<?php echo $item->id->videoId ;?>">
                                        <div class="inner">
                                            <div class="thumb">
                                                <img src="<?php echo $item->snippet->thumbnails->medium->url; ?>" alt="">
                                            </div>
                                            <div class="desc">
                                            <?php if($item->id->videoId == $idvideo){ $idsebelumnya=$lv->items[$key-1]->id->videoId; $idselanjutnya=$lv->items[$key+1]->id->videoId;?>
                                                <label class="diputar" for=""><i class="fa fa-play"></i> Sedang diputar</label>
                                            <?php } ?>
                                                <h3><?php echo $item->snippet->title; ?></h3>
                                                <!-- <p><i class="fa fa-clock"></i><span>15:25</span></p> -->
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            <?php } } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="<?php echo base_url(); ?>assets/dashboard/js/jquery-3.3.1.js"></script>
<script src="<?php echo base_url(); ?>assets/dashboard/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>assets/dashboard/js/all.min.js"></script>
<script src="<?php echo base_url(); ?>assets/dashboard/js/style.js"></script>
<script>
function clickselanjutnya(){
    // alert('sdfsdf');
    <?php if(empty($idselanjutnya)){?>
        alert('Tidak ada Video selanjutnya!!');
    <?php } else {?>
        window.location = '<?php echo base_url();?>classimport/play/<?php echo $idselanjutnya; ?>';
    <?php } ?>
}
function clicksebelumnya(){
    <?php if(empty($idsebelumnya)){?>
        alert('Tidak ada Video selanjutnya!!');
    <?php } else {?>
        window.location = '<?php echo base_url();?>classimport/play/<?php echo $idsebelumnya; ?>';
    <?php } ?>
}
</script>
</body>
<!-- Script Default -->
