<head>
  <title>Wilopo Cargo - Pembayaran</title>
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dashboard/css/jquery.dataTables.min.css">
</head>
<section class="main-konten">
    <div class="container-fluid">

        <!--Start Jumbotron -->
        <div id="bertema" class="jumbotron-default">
            <div class="judul-jumbotron">
                <h3><img src="<?php echo base_url(); ?>assets/dashboard/gambar/icw-pembayaran.svg" alt=""> Pembayaran</h3>
            </div>
        </div>
        <!--End Jumbotron-->

        <div class="row kolom-row top-minus">
            <div class="col-12">
                <div class="kartu">
                    <div class="head-kartu">
                        <div class="kiri">
                            <h3><i class="fa fa-money-bill"></i>List Pembayaran</h3>
                        </div>
                        <div class="kanan">
                            <a href="#" onclick="reFresh()"><i class="fa fa-circle-notch"></i> Refresh</a>
                        </div>
                    </div>
                    <div class="body-kartu">
                        <table id="listPembayaran" class="stripe hover m-0" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Kode Mark</th>
                                    <th>Kode Bayar</th>
                                    <th>Tanggal Pembayaran</th>
                                    <th>Jumlah</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="view_image"></div>
</section>
<script src="<?php echo base_url(); ?>assets/dashboard/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        listPembayaran();
    });
    function view_image(id)
    {
        // console.log(id);
        // alert(id);
        $.ajax({
        type : "GET",
        url : "<?php echo base_url() ?>pembayaran/view_image/"+id,
        cache : false,
        async : false,
        success : function(html){
            $("#view_image").html(html).show();
            $('#modeditbuku').modal('show');
        }
        })
    }
    function reFresh(){
        location.reload();
    }

    function listPembayaran() {
        $('#listPembayaran').DataTable( {
            initComplete: function() {
                var api = this.api();
                $('#listPembayaran_filter keyup')
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
                ajax: {"url": "<?php echo base_url()?>/pembayaran/get_pembayaran_json", "type": "POST"},
                    columns: [
                            {"data": "kode"},
                            {"data": "kode_pembayaran"},
                            {"data": "tanggal_bayar"},
                            {"data": "jumlah_bayar", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                            {"data": "view"}
                    ],
                order: [[1, 'desc']],
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
