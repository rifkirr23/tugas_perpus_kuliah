<head>
  <title>Wilopo Cargo - Saldo</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dashboard/css/jquery.dataTables.min.css">
</head>
<section class="main-konten">
    <div class="container-fluid">

        <!--Start Jumbotron -->
        <div id="bertema" class="jumbotron-default">
            <div class="judul-jumbotron">
                <h3><img src="<?php echo base_url(); ?>assets/dashboard/gambar/icw-finance.svg" alt=""> Saldo Keuangan</h3>
            </div>
            <button href="#tardan" data-toggle="modal" class="btn btn-light btn-lg" <?php if($saldomasuk->jumlahnya-$saldokeluar->jumlahnya-$tarikdana->jumlahnya <= 0){ ?>disabled<?php } ?>><i class="fa fa-cash-register"></i> Request Tarik Dana</button>
        </div>
        <!--End Jumbotron-->

        <div class="row kolom-row top-minus">
            <div class="col-lg-4">
                <div class="kartu">
                    <div class="row-kartu min-150">
                        <div class="item w-100">
                            <div class="figur">
                                <img src="<?php echo base_url(); ?>assets/dashboard/gambar/ic-titiptf.svg" alt="">
                            </div>
                            <div class="report">
                                <label class="text-danger" for="">Saldo Keseluruhan</label>
                                <h1>IDR<?php echo number_format(($saldomasuk->jumlahnya-$saldokeluar->jumlahnya)-$tarikdana->jumlahnya);?>,-</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--<div class="col-lg-4">-->
            <!--    <div class="kartu">-->
            <!--        <div class="row-kartu min-150">-->
            <!--            <div class="item">-->
            <!--                <div class="figur">-->
            <!--                    <img src="<?php echo base_url(); ?>assets/dashboard/gambar/ic-refer.svg" alt="">-->
            <!--                </div>-->
            <!--                <div class="report">-->
            <!--                    <label class="text-warning" for="">Saldo Referral</label>-->
            <!--                    <h1>IDR<?php echo number_format($saldo->komisi);?>,-</h1>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
            <!--<div class="col-lg-4">-->
            <!--    <div class="kartu">-->
            <!--        <div class="row-kartu min-150">-->
            <!--            <div class="item">-->
            <!--                <div class="figur">-->
            <!--                    <img src="<?php echo base_url(); ?>assets/dashboard/gambar/icw-transaksi.svg" alt="">-->
            <!--                </div>-->
            <!--                <div class="report">-->
            <!--                    <label class="text-info" for="">Saldo Refund</label>-->
            <!--                    <h1>IDR<?php echo number_format($refund->jumlahnya);?>,-</h1>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
        </div>
        <?php if($this->session->flashdata('msg')=='success'){ ?>

        <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Transaction Success
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        </div></p>

        <?php } ?>

        <?php if($this->session->flashdata('msg')=='updated'){ ?>

        <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Update data Success
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        </div></p>

        <?php } ?>

        <?php if($this->session->flashdata('msg')=='passwordsalah'){ ?>

        <p><div style="display: none;" class="alert alert-danger alert-dismissable"><i class="icon fa fa-check"></i>Password Yang anda masukan salah!!
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
        <div class="row kolom-row">
            <div class="col-12">
                <div class="kartu">
                    <div class="head-kartu">
                        <div class="kiri">
                            <h3><i class="fa fa-list-ol"></i> Histori Transaksi</h3>
                        </div>
                        <div class="kanan">
                            <a href="#"><i class="fa fa-sync-alt text-secondary"></i></a>
                        </div>
                    </div>
                    <div class="body-kartu">
                        <table id="daftartarik" class="stripe hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Tgl</th>
                                    <th>Keterangan</th>
                                    <th>Jumlah</th>
                                    <th>Tipe</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row kolom-row">
            <div class="col-12">
                <div class="kartu">
                    <div class="head-kartu">
                        <div class="kiri">
                            <h3><i class="fa fa-table"></i> Penarikan Dana</h3>
                        </div>
                        <div class="kanan">
                            <a href="#"><i class="fa fa-sync-alt text-secondary"></i></a>
                        </div>
                    </div>
                    <div class="body-kartu">
                        <table id="tarikDana" class="stripe hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Tgl</th>
                                    <th>Jumlah Penarikan</th>
                                    <th>Status</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="row kolom-row">
            <div class="col-12">
                <div class="kartu">
                    <div class="box-help">
                        <h3>Butuh Bantuan? Hubungi customer service kami.</h3>
                        <button href="#tarikDana" data-toggle="modal" class="btn btn-lg btn-light"><i class="fa fa-user-cog"></i> Hubungi Customer Service</button>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</section>
<!--End Main-->
 <!--Tarik Dana-->
 <div class="modal fade" id="tardan" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <a class="dsms" href="#" data-dismiss="modal"><i class="fa fa-times-circle"></i></a>
        <div class="modal-body p-0">
        <?php if($saldomasuk->jumlahnya-$saldokeluar->jumlahnya > 0){ ?>
            <form class="jm-form" action="<?php echo base_url();?>saldo/save" method="POST">
        <?php } ?>
            <div class="bodi-konfirmasi">
                <div class="judul-konfirmasi">
                    <h3>Request Tarik Dana</h3>
                    <p>Anda akan menarik dana silahkan masukkan jumlah yang diinginkan</p>
                </div>
                <div class="pita-resi">
                    <div class="info-saldo">
                        <label class="d-block" for="">Saldo Keseluruhan aktif saat ini:</label>
                        <h3><span><div id="saldorp">Rp. <?php echo number_format($saldomasuk->jumlahnya-$saldokeluar->jumlahnya-$tarikdana->jumlahnya);?></saldorp></span></h3>
                            <div class="form-group">
                                <label for="jumlahRMB">Masukkan jumlah penarikan yang diinginkan:</label>
                                <input type="number" id="nominalnya" name="nominal" placeholder="000.000" max="<?php echo $saldomasuk->jumlahnya-$saldokeluar->jumlahnya-$tarikdana->jumlahnya;?>" class="form-control">
                                <input type="hidden" value="<?=$saldomasuk->jumlahnya-$saldokeluar->jumlahnya-$tarikdana->jumlahnya;?>" name="saldoready" id="saldonya">
                            </div>
                    </div>
                </div>
                <div class="form-check check-kostum">
                    <input id="my-input" class="form-check-input" type="checkbox" name="semua" value="1">
                    <label for="my-input" class="form-check-label">
                        <h3>Tarik Seluruhnya?</h3>
                        <p>Saya ingin menarik semua dana yang ada.</p>
                    </label>
                </div>
                <div class="form-check check-kostum pw" style="display:none">
                    <label for="my-input" class="form-check-label">
                        <h3>Masukan Paasword Anda</h3>
                    </label>
                    <input type="password" name="password" class="form-control form-kostum" placeholder="Password" required autocomplete="off">
                </div>
            </div>

            <?php if($saldomasuk->jumlahnya-$saldokeluar->jumlahnya-$tarikdana->jumlahnya > 0){ ?>
            <div class="pb-3 text-center bt">
                <a class="btn btn-primary btn-lg rounded-pill" onclick="nextform()"><font color="white">Kirim Permintaan</font></a>
            </div>
            <div class="pb-3 text-center btnext" style="display:none">
                <button class="btn btn-primary btn-lg rounded-pill">Kirim Permintaan</button>
            </div>
            </form>
            <?php } ?>
        </div>
        </div>
    </div>
    </div>
<!--End Tarik Dana-->
<script src="<?php echo base_url(); ?>assets/dashboard/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){setTimeout(function(){$(".alert").fadeIn('fast');}, 100);});
        //angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
    setTimeout(function(){$(".alert").fadeOut('fast');}, 5000);
</script>
<script>
    $(document).ready(function() {
        $('#nominalnya').on('input', function(){
            var nominalnya=$('#nominalnya').val();
            var saldonya=$('#saldonya').val();
            var hasil=saldonya-nominalnya;
            if (hasil > 0) {
            var	reverse = hasil.toString().split('').reverse().join(''),
                ribuan 	= reverse.match(/\d{1,3}/g);
                ribuan	= ribuan.join('.').split('').reverse().join('');
            }else if(hasil < 0){
                var	reverse = saldonya.toString().split('').reverse().join(''),
                ribuan 	= reverse.match(/\d{1,3}/g);
                ribuan	= ribuan.join('.').split('').reverse().join('');
                alert('jumlah penarikan melebihi saldo yang tersedia');
                $("#nominalnya").val("");
            }else{
                ribuan = 0;
            }

           $('#saldorp').html('<div id="saldorp">Rp. '+ribuan+'</di>');
        });
        Dataresi();
    });
    function reFresh(){
        location.reload();
    }
    function nextform(){
        $(".btnext").show("slow");
        $(".pw").show("slow");
        $(".bt").hide();
    }

    function Dataresi() {
        $('#daftartarik').DataTable( {
            initComplete: function() {
                var api = this.api();
                $('#daftartarik_filter keyup')
                    .off('.DT')
                    .on('keyup.DT', function() {
                        api.search(this.value).draw();
                });
            },
            oLanguage: {
                sProcessing: "loading..."
            },
            "language": {
                "url" : "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Indonesian.json"
            },
                // scrollX: true,
                processing: true,
                serverSide: true,
                ajax: {"url": "<?php echo base_url('saldo/get_historitransaksi_json')?>", "type": "POST"},
                    columns: [
                            {"data": "tanggal_deposit"},
                            {"data": "keterangan_deposit"},
                            {"data": "nominal_deposit", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                            {"data": "tipe_deposit"}
                    ],
                order: [[0, 'desc']],
            // rowCallback: function(row, data, iDisplayIndex) {
            //     var info = this.fnPagingInfo();
            //     var page = info.iPage;
            //     var length = info.iLength;
            //     $('td:eq(0)', row).html();
            //     if (data['konfirmasi_resi'] != "0"){
            //         $('td', row).css('background-color', '#A9F096');//00FF7F
            //         $('td', row).css('color', 'black');
            //     }
            //     else if(data['konfirmasi_resi'] == "0"){
            //         $('td', row).css('background-color', '#FABAA5');
            //         $('td', row).css('color', 'black');
            //     }
            // }
        } );
        $('#tarikDana').DataTable( {
            initComplete: function() {
                var api = this.api();
                $('#daftartarik_filter keyup')
                    .off('.DT')
                    .on('keyup.DT', function() {
                        api.search(this.value).draw();
                });
            },
            oLanguage: {
                sProcessing: "loading..."
            },
            "language": {
                "url" : "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Indonesian.json"
            },
                // scrollX: true,
                processing: true,
                serverSide: true,
                ajax: {"url": "<?php echo base_url('saldo/get_penarikandana_json')?>", "type": "POST"},
                    columns: [
                            {"data": "tanggal_pengajuan"},
                            {"data": "nominal", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                            {"data": "statustarik"},
                    ],
                order: [[1, 'asc']],
            // rowCallback: function(row, data, iDisplayIndex) {
                // var info = this.fnPagingInfo();
                // var page = info.iPage;
                // var length = info.iLength;
                // $('td:eq(0)', row).html();
                // if (data['konfirmasi_resi'] != "0"){
                //     $('td', row).css('background-color', '#A9F096');//00FF7F
                //     $('td', row).css('color', 'black');
                // }
                // else if(data['konfirmasi_resi'] == "0"){
                //     $('td', row).css('background-color', '#FABAA5');
                //     $('td', row).css('color', 'black');
                // }
            // }
        } );
    }
</script>
