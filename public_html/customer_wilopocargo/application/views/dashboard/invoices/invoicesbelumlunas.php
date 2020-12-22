<head>
<title>Wilopo Cargo - Invoice Belum Lunas</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dashboard/css/jquery.dataTables.min.css">
</head>
<!--Main Konten-->
    <section class="main-konten">
        <div class="container-fluid">

            <!--Start Jumbotron -->
            <div id="bertema" class="jumbotron-default jumbotron-tab">
                <div class="judul-jumbotron">
                    <h3><img src="<?php echo base_url(); ?>assets/dashboard/gambar/icw-invoice.svg" alt=""> Invoice</h3>
                </div>
            </div>
            <!--End Jumbotron-->

            <div class="top-minus">
                <div class="row kolom-row">
                    <div class="col-lg-4 col-md-4 col-xl-4">
                        <div class="kartu ">
                            <div class="row-kartu min-150">
                                <div class="item w-100">
                                    <div class="figur">
                                        <img src="<?php echo base_url(); ?>assets/dashboard/gambar/icw-transaksi.svg" alt="">
                                    </div>
                                    <div class="report">
                                        <label class="text-secondary" for="">Semua Invoice</label>
                                        <h1><?php echo $semua->jumlahnya; ?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-xl-">
                        <div class="kartu">
                            <div class="row-kartu min-150">
                                <div class="item w-100">
                                    <div class="figur">
                                        <img src="<?php echo base_url(); ?>assets/dashboard/gambar/icw-lunas.svg" alt="">
                                    </div>
                                    <div class="report">
                                        <label class="text-success" for="">Sudah Lunas</label>
                                        <h1><?php echo $lunas->jumlahnya; ?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-xl-">
                        <div class="kartu">
                            <div class="row-kartu min-150">
                                <div class="item w-100">
                                    <div class="figur">
                                        <img src="<?php echo base_url(); ?>assets/dashboard/gambar/icw-24.svg" alt="">
                                    </div>
                                    <div class="report">
                                        <label class="text-warning" for="">Belum Lunas</label>
                                        <h1><?php echo $belumlunas->jumlahnya; ?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <nav class="jumbotron-menu tab-kartu">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link" href="<?php echo base_url(); ?>invoices" aria-controls="nav-home">Semua Invoice</a>
                    <a class="nav-item nav-link" href="<?php echo base_url(); ?>invoices/lunas" aria-controls="nav-titip">Sudah Lunas</a>
                    <a class="nav-item nav-link active" href="<?php echo base_url(); ?>invoices/belumlunas" aria-controls="nav-barang">Belum Lunas</a>
                </div>
            </nav>
            <div class="row kolom-row mt-4">
                <div class="col-12">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="fade show active" id="nav-semua">
                            <div class="kartu">
                                <div class="head-kartu">
                                    <div class="kiri">
                                        <h3><i class="fa fa-list"></i>Semua Invoices</h3>
                                    </div>
                                    <div class="kanan">
                                        <a href="#" class="text-secondary"><i class="fa fa-sync"></i></a>
                                    </div>
                                </div>
                                <div class="body-kartu">
                                    <table id="daftarinv" class="stripe hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Tanggal Invoice</th>
                                                <th>Kode Invoice</th>
                                                <th>Total Tagihan</th>
                                                <th>Jumlah Bayar</th>
                                                <th>Total Potongan</th>
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
            </div>
        </div>
    </section>
    <script src="<?php echo base_url(); ?>assets/dashboard/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        Datainv();
    });
    function reFresh(){
        location.reload();
    }

    function Datainv() {
            var table = $("#daftarinv").dataTable({
            initComplete: function() {
                var api = this.api();
                $('#daftarinv_filter keyup')
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
                // "scrollY":        "400px",
                // "scrollCollapse": false,
                // scrollX: true,
                processing: true,
                serverSide: true,
                ajax: {"url": "<?php echo base_url('invoices/get_invoicebelumlunas_json')?>", "type": "POST"},
                    columns: [
                            {"data": "tanggal_invoice"},
                            {"data": "kode_invoice"},
                            {"data": "total_tagihan", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                            {"data": "jumlah_bayar", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                            {"data": "total_potongan", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                            {"data": "status_invoice" ,
                            render : function(data,type,row){
                                var strStatus = "";
                                if(row.status_invoice == 0){
                                strStatus = "Belum Lunas";
                                }else if(row.status_invoice == 1){
                                strStatus = "Lunas";
                                }
                                return strStatus ;
                            }
                            },
                            {"data": "view"}
                    ],
                order: [[1, 'desc']],
            // rowCallback: function(row, data, iDisplayIndex) {
            //     var info = this.fnPagingInfo();
            //     var page = info.iPage;
            //     var length = info.iLength;
            //     $('td:eq(0)', row).html();

            //     if (data['status_invoice'] == "1"){
            //         $('td', row).css('background-color', '#A9F096');//00FF7F
            //         $('td', row).css('color', 'black');
            //     }

            //     else if(data['status_invoice'] != "1"){
            //         $('td', row).css('background-color', '#FABAA5');
            //         $('td', row).css('color', 'black');
            //     }
            // }

            });
    }
</script>
