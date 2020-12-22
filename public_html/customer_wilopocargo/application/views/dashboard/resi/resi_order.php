<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Wilopo Cargo - Resi Order</title>
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dashboard/css/jquery.dataTables.min.css">
</head>
    <!--Main Konten-->
    <section class="main-konten">
        <div class="container-fluid">

            <!--Start Jumbotron -->
            <div id="bertema" class="jumbotron-default jumbotron-tab">
                <div class="judul-jumbotron">
                    <h3><img src="<?php echo base_url(); ?>assets/dashboard/gambar/icw-resi.svg" alt=""> Resi Order</h3>
                </div>
                <!--<button href="#" data-toggle="modal" class="btn btn-light btn-lg"><i class="fa fa-plus-circle"></i> Request Resi</button>-->
                <!-- <nav class="jumbotron-menu">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" href="#" role="tab" aria-controls="nav-home" aria-selected="true">Resi via Laut</a>
                        <a class="nav-item nav-link" href="<?php echo base_url(); ?>resi/udara" role="tab" aria-controls="nav-titip" aria-selected="false">Resi via Udara</a>
                    </div>
                </nav> -->
                <a href="<?php echo site_url('resi/request_resi') ?>"  class="btn btn-light btn-lg"><i class="fa fa-plus-circle"></i> Request Resi</a>
            </div>
            <!--End Jumbotron-->
            <?php if($this->session->flashdata('msg')=='oksave'){ ?>

            <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Request Resi Berhasil , Menunggu cek dari Admin kami
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            </div></p>

            <?php } ?>
            <?php $idcust=$this->session->userdata('id_cust'); ?>
            <div class="row kolom-row mt-4">
                <div class="col-12">
                    <div class="tab-content" id="nav-tabContent">
                        <!--LAut-->
                        <div class="tab-pane fade show active" id="viaLaut" role="tabpanel">
                            <div class="kartu">
                                <div class="head-kartu">
                                    <div class="kiri">
                                        <h3><i class="fa fa-bell"></i>Daftar Resi Order </h3>
                                    </div>
                                    <div class="kanan">
                                        <a href="#" onclick="reFresh()"><i class="fa fa-circle-notch"></i> Refresh</a>
                                    </div>
                                </div>
                                <div class="body-kartu">
                                    <table id="addresi" class="stripe hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Kode Request</th>
                                                <th>Resi China / Supplier</th>
                                                <th>Telp</th>
                                                <th>Jumlah Dus / Koli</th>
                                                <th>Gudang</th>
                                                <th>Note</th>
                                                <th>Status</th>
                                                <!-- <th>View</th> -->
                                            </tr>
                                        </thead>
                                        <!-- <tbody>

                                        </tbody> -->
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Main-->
<script src="<?php echo base_url(); ?>assets/dashboard/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){setTimeout(function(){$(".alert").fadeIn('fast');}, 100);});
      //angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
      setTimeout(function(){$(".alert").fadeOut('fast');}, 5000);
</script>
<script>
    $(document).ready(function() {
        Dataresi();
    });
    function reFresh() {
        location.reload();
    }

    function Dataresi() {
        $('#addresi').DataTable( {
            initComplete: function() {
                var api = this.api();
                $('#ddresi_filter keyup')
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
                ajax: {"url": "<?php echo base_url('resi/get_request_id_json/'.$idcust)?>", "type": "POST"},
                    columns: [
                            {"data": "tanggal_request"},
                            {"data": "kode_request"},
                            {"data": "supplier"},
                            {"data": "tel"},
                            {"data": "jumlah_koli"},
                            {"data": "gudang"},
                            {"data": "note"},
                            {"data": "status_request"},
                            // {"data": "view"}
                    ],
                order: [[0, 'desc']]
        } );
    }
</script>