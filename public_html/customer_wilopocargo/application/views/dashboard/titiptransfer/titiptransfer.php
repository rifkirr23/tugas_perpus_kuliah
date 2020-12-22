
<head><meta charset="euc-kr">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dashboard/css/ezds.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dashboard/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dashboard/css/introjs.min.css">
    <title>Wilopo Cargo - Titip Transfer</title>
</head>
    <section class="main-konten">
        <div class="container-fluid">
            <!--Start Jumbotron -->
            <div class="jumbotron-default">
                <div class="judul-jumbotron">
                    <h3><a href="resi.html"><img src="<?php echo base_url(); ?>assets/dashboard/gambar/icw-titiptransfer.svg" alt=""></a>Titip Transfer</h3>
                </div>
                <button href="#transaksiBaru" data-toggle="modal" class="btn btn-light btn-lg"><i class="fa fa-plus-circle"></i> Transaksi Baru</button>
            </div>
            <!--End Jumbotron-->
            <div class="top-minus">
                <!-- <div class="kartu-banner alert alert-dismissible fade show" role="alert">
                    <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> -->
                <div class="row kolom-row">
                    <div class="col-lg-7">
                        <div class="kartu ">
                            <div class="row-kartu min-150">
                                <div class="item">
                                    <div class="figur">
                                        <img src="<?php echo base_url(); ?>assets/dashboard/gambar/icw-transaksi.svg" alt="">
                                    </div>
                                    <div class="report">
                                        <label class="text-primary" for="">Transaksi Diproses</label>
                                        <h1><?php echo $proccess->jumlahproccess; ?></h1>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="figur">
                                        <img src="<?php echo base_url(); ?>assets/dashboard/gambar/icw-24.svg" alt="">
                                    </div>
                                    <div class="report">
                                        <label class="text-danger" for="">Transaksi Pending</label>
                                        <h1><?php echo $pending->jumlahproccess; ?></h1>
                                    </div>
                                </div>
                            </div>
                            <!-- <hr>
                            <div class="row-kartu">
                                <div class="item">
                                    <div class="figur">
                                        <img src="<?php echo base_url(); ?>assets/dashboard/gambar/icw-berhasil.svg" alt="">
                                    </div>
                                    <div class="report">
                                        <label class="text-success" for="">Semua Transaksi</label>
                                        <h1>128</h1>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="figur">
                                        <img src="<?php echo base_url(); ?>assets/dashboard/gambar/icw-uang.svg" alt="">
                                    </div>
                                    <div class="report">
                                        <label class="text-warning" for="">Semua Transaksi</label>
                                        <h1>128</h1>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="kartu min-150">
                            <div class="head-kartu">
                                <div class="kiri">
                                    <h3><i class="fa fa-coins text-primary"></i>Kurs Jual</h3>
                                </div>
                                <div class="kanan">
                                    <a href="#"><i class="fa fa-sync text-secondary"></i></a>
                                </div>
                            </div>
                            <div class="body-kartu p-0">
                                <div class="row-kurs cn">
                                    <div class="flag">
                                        <div class="gbr">
                                            <img src="<?php echo base_url(); ?>assets/dashboard/gambar/icw-bendera-cina.svg" alt="">
                                        </div>
                                        <div class="inf">
                                            <p>¥1 RMB</p>
                                            <span>Chinese Yuan Renminbi</span>
                                        </div>
                                    </div>
                                    <div class="valu">
                                        <p>IDR<span><?php echo number_format($kurs->kurs_jual,0,',','.');?></span></p>
                                    </div>
                                </div>
                                <!-- <div class="row-kurs id mb-2">
                                    <div class="flag">
                                        <div class="gbr">
                                            <img src="<?php echo base_url(); ?>assets/dashboard/gambar/icw-bendera-indo.svg" alt="">
                                        </div>
                                        <div class="inf">
                                            <p>IDR</p>
                                            <span>Indonesian Rupuah</span>
                                        </div>
                                    </div>
                                    <div class="valu">
                                        <p>Rp<span>1.900,00</span></p>
                                    </div>
                                </div> -->
                                <!-- <div class="info-kurs">
                                    <p>1 CNY = <span>1.997,00</span></p>
                                    <label for="">20 Januari, 2020</label>
                                </div> -->
                            </div>
                        </div>
                    </div>
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
                <div class="row kolom-row">
                    <div class="col-12">
                        <div class="kartu">
                            <div class="head-kartu">
                                <div class="kiri">
                                    <h3><i class="fa fa-history"></i> Semua Transaksi</h3>
                                </div>
                                <div class="kanan">
                                    <a href="#"><i class="fa fa-circle-notch"></i> Refresh</a>
                                </div>
                            </div>
                            <div class="body-kartu table-responsive">
                                <table id="titipTransfer" class="stripe hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Tanggal Transaksi</th>
                                            <th>Kode Transaksi</th>
                                            <th>Kode Invoice</th>
                                            <th>Jumlah Rmb</th>
                                            <th>Kurs Jual</th>
                                            <th>Fee Bank</th>
                                            <th>Fee Cs</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Start Main Konten-->
            <!--End Main Konten-->
        </div>
    </section>
    <!-- Input Transaksi Baru -->
    <div class="modal fade" id="transaksiBaru" data-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg">
          <div class="modal-content modal-input">
            <div class="modal-header">
                <h5 class="modal-title">Titip Transfer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <div class="jm-input">
                <h3>FORM JASA TITIP TRANSFER</h3>
                <p>Silahkan lengkapi formulir berikut ini untuk melakukan pembayaran via Jasa Titip Transfer</p>
              </div>
              <form id="fileupload" action="<?php echo base_url().'titiptransfer/save'?>" method="post" enctype="multipart/form-data">
                    <!--<div class="form-group">-->
                    <!--    <label for="">Tanggal Transaksi</label>-->
                        <input class="form-control" type="hidden" name="tanggal_transaksi" value="<?=date("Y-m-d H:i:s");?>" id="tglTransaksi" required>
                    <!--</div>-->
                    <div class="form-group">
                        <label for="jumlahRMB">Jumlah RMB</label>
                        <input type="number" name="jumlah_rmb[]" placeholder="¥ 00,00" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="jumlahRMB">Bank Tujuan (Copy Paste Bank Tujuan Apabila Format Text)</label>
                        <input type="text" name="bank_tujuan[]" placeholder="Bank" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="label-flex" for="idBank">Foto Bank Tujuan
                            <a href="#" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">
                                <i class="fa fa-question-circle"></i>
                            </a>
                        </label>
                        <input required type="file" required accept="image/*" name="file_bank_tujuan[]" id="idBank" required>
                        <label class="label-flex" for="idBank">(Upload Foto Bank Tujuan Apabila dalam Format Gambar)</label>
                    </div>
                    <div class="form-group">
                        <div id="education_fields">

                        </div>

                        <span class="pull-right" style="float: right;">

                            <a onclick="education_fields();" name="add-more" class="btn btn-primary color-white">+ Transaksi</a>

                        </span>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success submitt" type="submit" >Kirim</button>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
     <!-- End Transaksi Baru -->
     <div id="view_image"></div>
    <script src="<?php echo base_url(); ?>assets/dashboard/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/dashboard/js/jquery.ezdz.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/dashboard/js/intro.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/dashboard/js/upload.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){setTimeout(function(){$(".alert").fadeIn('fast');}, 100);});
          //angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
          setTimeout(function(){$(".alert").fadeOut('fast');}, 5000);
    </script>
<script>
    function view_image(id)
  {
    // alert(id);
    $.ajax({
      type : "GET",
      url : "<?php echo base_url() ?>titiptransfer/view_image/"+id,
      cache : false,
      async : false,
      success : function(html){
        $("#view_image").html(html).show();
        $('#modeditbuku').modal('show');
      }
    })
  }
    $(document).ready(function() {
        Datatt();
    });

    function reFresh(){
        location.reload();
    }

    function Datatt() {
        // Setup datatables
        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
        {
            return {
                "iStart": oSettings._iDisplayStart,
                "iEnd": oSettings.fnDisplayEnd(),
                "iLength": oSettings._iDisplayLength,
                "iTotal": oSettings.fnRecordsTotal(),
                "iFilteredTotal": oSettings.fnRecordsDisplay(),
                "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
            };
        };



        var table = $("#titipTransfer").dataTable({
            initComplete: function() {
                var api = this.api();
                $('#titipTransfer_filter keyup')
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
                ajax: {"url": "<?php echo base_url()?>titiptransfer/get_transaksi_json", "type": "POST"},
                    columns: [
                                {"data": "tanggal_transaksi"},
                                {"data": "kode_transaksi"},
                                {"data": "kode_invoice"},
                                {"data": "total_rmb"},
                                {"data": "kurs_jual", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                                {"data": "fee_bank"},
                                {"data": "fee_cs",  render: $.fn.dataTable.render.number(',', '.','','¥ ')},
                                {"data": "status" ,
                                render : function(data,type,row){
                                    var strStatus = "";
                                    if(row.status == 1){
                                    strStatus = "<span class='status-resi text-warning'>Pending</span>";
                                    }else if(row.status == 2){
                                    strStatus = "<span class='status-resi text-secondary'>Process</span>";
                                    }else if(row.status == 3){
                                    strStatus = "<span class='status-resi dikonfirmasi'>Complete</span>";
                                    }else if(row.status == 4){
                                    strStatus = "<span class='status-resi text-warning'>Salah Bank</span>";
                                    }else if(row.status == 5){
                                    strStatus = "<span class='status-resi text-danger'>Dibatalkan</span>";
                                    }
                                    return strStatus ;
                                }
                            },
                            //render harga dengan format angka

                            {"data": "view"}
                    ],
                order: [[1, 'desc']],
            // rowCallback: function(row, data, iDisplayIndex) {
            //     var info = this.fnPagingInfo();
            //     var page = info.iPage;
            //     var length = info.iLength;
            //     $('td:eq(0)', row).html();
            //     if (data['status'] == "3"){
            //         $('td', row).css('background-color', '#A9F096');//00FF7F
            //         $('td', row).css('color', 'black');
            //     }
            //     else if(data['status'] == "2"){
            //         $('td', row).css('background-color', '#FABAA5');
            //         $('td', row).css('color', 'black');
            //     }
            //     else if(data['status'] == "4"){
            //         $('td', row).css('background-color', '#F9DF9C');
            //         $('td', row).css('color', 'black');
            //     }
            // },
        });
        // end setup datatables


    }

    var room = 1;
    function education_fields() {
        room++;
        var objTo = document.getElementById('education_fields')
        var divtest = document.createElement("div");
        divtest.setAttribute("class", "form-group removeclass"+room);
        var rdiv = 'removeclass'+room;
        divtest.innerHTML = '<span class="pull-right" style="float: right;"><a onclick="remove_education_fields('+ room +');" name="add-more" class="btn btn-danger">- Hapus Transaksi</a></span><p><br/></p><div class="form-group"><label for="jumlahRMB">Jumlah RMB</label><input type="number" name="jumlah_rmb[]" placeholder="¥ 00,00" class="form-control" required></div><div class="form-group"><label for="jumlahRMB">Bank Tujuan (Copy Paste Bank Tujuan Apabila Format Text)</label><input type="text" name="bank_tujuan[]" placeholder="Nama bank" class="form-control"></div><div class="form-group"><label class="label-flex" for="idBank">Foto Bank Tujuan<a href="#" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus."><i class="fa fa-question-circle"></i></a></label><input required type="file" required accept="image/*" name="file_bank_tujuan[]" id="idBank"><label class="label-flex" for="idBank">(Upload Foto Bank Tujuan Apabila dalam Format Gambar)</label></div>';

        objTo.appendChild(divtest)
    }
   function remove_education_fields(rid) {
     $('.removeclass'+rid).remove();
   }
</script>
