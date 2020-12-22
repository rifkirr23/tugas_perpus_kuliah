<head>
<title>Wilopo Cargo - Resi Udara</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dashboard/css/jquery.dataTables.min.css">
</head>
    <!--Main Konten-->
    <section class="main-konten">
        <div class="container-fluid">

            <!--Start Jumbotron -->
            <div id="bertema" class="jumbotron-default jumbotron-tab">
                <div class="judul-jumbotron">
                    <h3><img src="<?php echo base_url(); ?>assets/dashboard/gambar/icw-resi.svg" alt=""> Resi</h3>
                </div>
                <nav class="jumbotron-menu">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link" href="<?php echo base_url(); ?>resi" aria-controls="nav-home" aria-selected="false">Resi via Laut</a>
                        <a class="nav-item nav-link active" href="#" aria-controls="nav-titip" aria-selected="true">Resi via Udara</a>
                    </div>
                </nav>
            </div>
            <!--End Jumbotron-->
            <?php $idcust=$this->session->userdata('id_cust'); ?>
            <div class="row kolom-row mt-4">
                <div class="col-12">
                    <div>
                        <!--Finance-->
                        <div>
                        <div class="kartu">
                            <div class="head-kartu">
                                    <div class="kiri">
                                        <h3><i class="fa fa-bell"></i>Daftar Resi udara</h3>
                                    </div>
                                    <div class="kanan">
                                        <a href="#" onclick="reFresh()"><i class="fa fa-circle-notch"></i> Refresh</a>
                                    </div>
                                </div>
                                <div class="body-kartu">
                                    <table id="daftarResiudara" class="stripe hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Kode Mark</th>
                                                <th>Nomor</th>
                                                <th>Tanggal</th>
                                                <th>Ctns</th>
                                                <th>Berat</th>
                                                <th>Harga</th>
                                                <th>Harga Goni</th>
                                                <th>Action</th>
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
<script>
    $(document).ready(function() {
        Dataresi();
    });
    function reFresh(){
        location.reload();
    }

    function Dataresi() {
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

      var table = $("#daftarResiudara").dataTable({
          initComplete: function() {
              var api = this.api();
              $('#daftarResiudara_filter keyup')
                  .off('.DT')
                  .on('keyup.DT', function() {
                      api.search(this.value).draw();
              });
          },
              oLanguage: {
              sProcessing: "loading..."
          },
            //   scrollX: true,
              processing: true,
              serverSide: true,
              ajax: {"url": "<?php echo base_url('resi/get_resiudara_json')?>", "type": "POST"},
                  columns: [
                        {"data": "kode"},
                        {"data": "nomor_resi"},
                        {"data": "tanggal_resi"},
                        {"data": "ctns"},
                        {"data": "berat"},
                        {"data": "harga_jual", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                        {"data": "harga_jual_goni", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                        {"data": "view"},
                  ],
              order: [[1, 'asc']]
        //   rowCallback: function(row, data, iDisplayIndex) {
        //       var info = this.fnPagingInfo();
        //       var page = info.iPage;
        //       var length = info.iLength;
        //       $('td:eq(0)', row).html();
        //       if (data['id_invoice'] != "0"){
        //         $('td', row).css('background-color', '#A9F096');//00FF7F
        //         $('td', row).css('color', 'black');
        //       }
        //       else if(data['id_invoice'] == "0"){
        //         $('td', row).css('background-color', '#FABAA5');
        //         $('td', row).css('color', 'black');
        //       }
        //   }

      });
      // end setup datatables
    }
</script>
