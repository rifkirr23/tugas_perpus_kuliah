<head>
  <title>Wilopo Cargo - Resi Detail</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
</head>

    <!--Main Konten-->
    <section class="main-konten">
        <div class="container-fluid">

            <!--Start Jumbotron -->
            <div class="jumbotron-default minimalis">
                <div class="judul-jumbotron">
                    <h3><a href="javascript: window.history.go(-1)"><img src="<?php echo base_url(); ?>assets/dashboard/gambar/icw-back.svg" alt=""></a> Detail Resi</h3>
                </div>
            </div>
            <!--End Jumbotron-->

            <div class="row kolom-row">
                <div class="col-12">
                    <div class="kartu">
                        <div class="head-kartu">
                            <div class="kiri">
                                <h3><i class="fa fa-sticky-note"></i> Detail Resi</h3>
                            </div>
                            <div class="kanan">
                                <a href="#" onclick="reFresh()"><i class="fa fa-circle-notch"></i> Refresh</a>
                            </div>
                        </div>
                        <div class="body-kartu">
                        <?php
                            $getdetailresi = $this->db->select('sum(ctns) as total_ctns,sum(qty*ctns) as total_qty,sum(berat*ctns) as total_berat,sum(volume*ctns) as total_volume')
                                                    ->where('resi_id',$r->id_resi)->get('giw')->row();

                            if(substr($r->nomorgiw,3,1) == 'Y'){ $gudang = "Yiwu"; }
                            else{  $gudang = "Guangzhou"; }

                            if($r->konfirmasi_resi == 0){ $kf = "<span class='badge badge-belum badge-pill'>Belum Terkonfirmasi1</span>"; }
                            else if($r->konfirmasi_resi == 1){  $kf = "<span class='badge badge-dikonfirmasi badge-pill'>Terkonfirmasi</span>"; }
                            else if($r->konfirmasi_resi == 2){  $kf = "<span class='badge badge-asuransi badge-pill'>Terkonfirmasi</span>"; }
                        ?>

                            <table class="table table-borderless table-striped table-detail">
                                <tbody>
                                <tr>
                                <th class="w-25">Kode Mark Customer</th>
                                <td><?php echo $r->kode; ?></td>
                                </tr>
                                <tr>
                                <th class="w-25">Nomor Resi</th>
                                <td><?php echo $r->nomor; ?></td>
                                <tr>
                                <tr>
                                <th class="w-25">Tanggal</th>
                                <td><?php echo $r->tanggal ?></td>
                                </tr>
                                <tr>
                                <th class="w-25">Tel</th>
                                <td><?php echo $r->tel ?></td>
                                </tr>
                                <tr>
                                <th class="w-25">Whatsapp</th>
                                <td><?php echo $r->whatsapp ?></td>
                                </tr>
                                <tr>
                                <th class="w-25">Note</th>
                                <td><?php if($r->note != ''){ echo $r->note; }else{ echo "-"; } ?></td>
                                </tr>
                                <tr>
                                <th class="w-25">Gudang</th>
                                <td><?php echo $gudang ?></td>
                                </tr>
                                <tr>
                                <th class="w-25">Status</th>
                                <td><?php echo $kf ?></td>
                                </tr>
                                <?php if($r->konfirmasi_resi == 2){
                                $getasuransi = $this->db->where('id_resi',$r->id_resi)->get('invoice_asuransi')->row();
                                ?>
                                <tr>
                                <th class="w-25">Asuransi</th>
                                    <td><span class="text-primary"><?php echo "Rp." . number_format($getasuransi->jumlah_asuransi) ?></span></td>
                                </tr>
                                <?php  } ?>
                                </tbody>
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
                                <h3><i class="fa fa-barcode"></i> Barcode Resi</h3>
                            </div>
                            <div class="kanan">
                                <!-- <a href="#"><i class="fa fa-circle-notch"></i> Refresh</a> -->
                            </div>
                        </div>
                        <div class="body-kartu">
                            <table id="detailResi" class="stripe hover table-responsive" style="width:100%">
                                <thead>
                                    <tr>
                                    <th>Barcode </th>
                                    <th>Barang</th>
                                    <th>Kategori</th>
                                    <th>Ctns</th>
                                    <th>Qty</th>
                                    <th>Berat</th>
                                    <th>Volume</th>
                                    <th>Nilai</th>
                                    <th>Note</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                    <th>Harga</th>
                                    <th>Est</th>
                                    </tr>
                                </thead>

                            </table>
                            <br/>
                            <table class="table table-bordered table-striped no-margin" id="">
                              <thead>
                                <tr>
                                  <td rowspan="2" style="font-weight:bold;">Total Ctns </td>
                                  <td style="font-weight:bold;"><?php echo $getdetailresi->total_ctns ?> ctns</td>
                                  <td rowspan="2" style="font-weight:bold;">Total Qty </td>
                                  <td style="font-weight:bold;"><?php echo $getdetailresi->total_qty ?> pcs</td>
                                  <td rowspan="2" style="font-weight:bold;">Total Berat </td>
                                  <td style="font-weight:bold;"><?php echo round($getdetailresi->total_berat,3) ?> kg</td>
                                  <td rowspan="2" style="font-weight:bold;">Total Volume </td>
                                  <td style="font-weight:bold;"><?php echo round($getdetailresi->total_volume,3) ?> m<sup>3</sup></td>
                                </tr>
                              </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row kolom-row">
                <div class="col-6">
                    <a class="hubungi-link" href="#">Hubungi Customer Services</a>
                </div>
                <!--<div class="col-6">-->
                <!--    <div class="bawah-konfirm">-->
                <!--        <button data-target="#konfirmasiResi" data-toggle="modal" class="btn btn-primary btn-lg">Konfirmasi Resi</button>-->
                <!--    </div>-->
                <!--</div>-->
            </div>
        </div>
    </section>
    <!--End Main-->

<!-- Modal Konfirmasi -->
<div class="modal fade" id="konfirmasiResi" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <a class="dsms" href="#" data-dismiss="modal"><i class="fa fa-times-circle"></i></a>
        <div class="modal-body p-0">
            <div class="bodi-konfirmasi">
                <div class="judul-konfirmasi">
                    <h3>Konfirmasi Resi</h3>
                    <p>Anda akan mengkonfirmasi Resi berikut ini, pastikan anda telah memeriksa kembali resi anda</p>
                </div>
                <div class="pita-resi">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th>No. Resi</th>
                                <td>RESI-12343545</td>
                            </tr>
                            <tr>
                                <th>Kode Marking</th>
                                <td>124/WC-Johnlenon</td>
                            </tr>
                            <tr>
                                <th>Gudang</th>
                                <td>Guangzhou</td>
                            </tr>
                            <tr>
                                <th>Supplier</th>
                                <td>Alibaba</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td><span class="badge badge-belum badge-pill">Belum Dikonfirmasi</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="form-check check-kostum">
                    <input id="my-input" class="form-check-input" type="checkbox" name="" value="true">
                    <label for="my-input" class="form-check-label">
                        <h3>Tambahkan Asuransi?</h3>
                        <p>Lihat syarat & ketentuan serta informasi mengenai Asuransi <a class="text-primary" href="#">Disini</a>.</p>
                    </label>
                </div>
            </div>
            <!--<div class="pb-3 text-center">-->
            <!--    <button class="btn btn-primary btn-lg rounded-pill" data-dismiss="modal">Ya, Konfirmasi Resi</button>-->
            <!--</div>-->
        </div>
        <a class="hbng" href="#">Butuh bantuan? Hubungi Customer Services</a>
        </div>
    </div>
    </div>
<!-- End Modal Konfirmasi -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script>
    function reFresh(){
        location.reload();
    }
    $(document).ready(function() {
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

        var table = $("#detailResi").dataTable({
            initComplete: function() {
                var api = this.api();
                $('#mytable_filter keyup')
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
                //   scrollX: true,
                processing: true,
                serverSide: true,
                ajax: {"url": "<?php echo base_url()?>resi/get_barcodeid_json/<?php echo $this->uri->segment(3) ?>", "type": "POST"},
                    columns: [

                            {"data": "nomor"},
                            {"data": "barang"},
                            {"data": "namalain"},
                            {"data": "ctns"},
                            {"data": "qtys"},
                            {"data": "berats"},
                            {"data": "volumes"},
                            {"data": "nilais"},
                            {"data": "note"},
                            {"data": "status" ,
                              render : function(data,type,row){
                                var strStatus = "";
                                if(row.status == 1 ){
                                  strStatus = "Gudang China";
                                }else if(row.status == 2){
                                  strStatus = "Loading Container";
                                }else if(row.status == 3){
                                  strStatus = "Dalam Perjalanan";
                                }else if(row.status == 4){
                                  strStatus = "Gudang Jakarta";
                                }else if(row.status == 7){
                                  strStatus = "Monitoring";
                                }else if(row.status == 5){
                                  strStatus = "Invoice";
                                }
                                return strStatus ;
                              }
                            },
                            {"data": "remarks"},
                            {"data": "harga_jual", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},

                            {"data": "est"},

                    ],
                order: [[1, 'desc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                $('td:eq(0)', row).html();
            }

        });
        // end setup datatables
    });
</script>
