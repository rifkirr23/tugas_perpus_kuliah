<head>
   <meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
   <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
</head>
<?php if($this->session->flashdata('msg')=='kosong'){ ?>

   <p><div style="display: none;" class="alert alert-warning alert-dismissable"><i class="icon fa fa-warning"></i>Tidak Bisa Kosong , Silahkan Pilih Opsi Proses
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  </div></p>

<?php } ?>
<?php if($this->session->flashdata('msg')=='nomobil'){ ?>

   <p><div style="display: none;" class="alert alert-warning alert-dismissable"><i class="icon fa fa-warning"></i>Harus Pilih Mobil
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  </div></p>

<?php } ?>
<?php if($this->session->flashdata('msg')=='okposisi'){ ?>

   <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-success"></i> Posisi Berhasil Dirubah
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  </div></p>

<?php } ?>
<?php if($this->session->flashdata('msg')=='oksj'){ ?>

   <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-success"></i> Sj Berhasil Dibuat
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  </div></p>

<?php } ?>
<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4 class="pull-left" class="form-control"><b>Mobil & SJ </b></h4>
        <span class="pull-right" style="margin-right:1%;">
          <a class="btn btn-danger btn-xs" onclick="findPrinter()"><i class="fa fa-print"></i>  Detect Printer</a>
        </span>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-4">
    <!-- small box -->
    <div class="small-box bg-blue">
      <div class="inner">
        <h3><?php echo $jumlah_today; ?></h3>

        <p>Jumlah SJ Hari Ini</p>
      </div>
      <div class="icon">
        <i>SJ</i>
      </div>
      <a href="#" class="small-box-footer">Wilopo Cargo</a>
    </div>
  </div>

    <div class="col-lg-4">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3><?php echo $jumlah_kemarin; ?></h3>

          <p>Jumlah SJ Kemarin</p>
        </div>
        <div class="icon">
          <i class="fa fa-close"></i>
        </div>
        <a href="#" class="small-box-footer">Wilopo Cargo</a>
      </div>
    </div>

  <div class="col-lg-4">
    <!-- small box -->
    <div class="small-box bg-green">
      <div class="inner">
        <h3><?php echo round($jumlah_cbm->total); ?> m<sup>3</sup></h3>

        <p>Total Terkirim</p>
      </div>
      <div class="icon">
        <i class="fa fa-close"></i>
      </div>
      <a href="#" class="small-box-footer">Wilopo Cargo</a>
    </div>
  </div>

</div>


  <div class="row">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"><b>List Mobil</b></h3>
        <span class="pull-right" style="margin-right:1%;">

        </span>
      </div>

      <div class="box-body">
        <div class="box-body table-responsive">
          <table class="table table-bordered table-striped no-margin">
            <thead>
              <tr>
                <th>Kode Mobil </th>
                <th>Plat Mobil</th>
                <th>Limit Cbm Mobil</th>
                <th>SJ di Mobil</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php $no=1; foreach ($data_mobil as $dm){
                $sumsj  =  $this->db->select('sum(volume*jumlah) as cbm')
      															->from('giw')
      															->join('invoice_product', 'invoice_product.id_giw=giw.id','left')
      															->join('sj_wc', 'sj_wc.id_sj=invoice_product.id_sj_wc','left')
      															->where('sj_wc.id_mobil',$dm->id_mobil)
                                    ->where('sj_wc.status <',2)
      															->get()->row();
              ?>
                <tr <?php if($dm->status_mobil == 1){ ?> style='background-color:#F9DF9C; color:black;' <?php } ?>>
                  <td><?php echo $dm->kode_mobil ?>
                        <br /><br />
                              <a class="btn btn-default btn-xs" onclick="bukasj(<?php echo $no; ?>)" style="margin-top:10px;">
                                <i class="fa fa-angle-right"> Lihat SJ </i>
                              </a>
                        <p></p>
                  </td>
                  <td><?php echo $dm->plat_mobil ?></td>
                  <td><?php echo $dm->limit_cbm ?></td>
                  <td><?php echo round($sumsj->cbm,3) ?> m<sup>3</sup></td>
                  <td><?php
                        if($dm->status_mobil == Null || $dm->status_mobil == "" || $dm->status_mobil == 0){
                          echo "Tidak Sedang Mengirim";
                        }else if($dm->status_mobil == 1){
                          echo "Sedang Mengirim";
                        }else {
                          echo "-";
                        }
                      ?>
                  </td>
                  <td style="text-align:center">
                    <?php
                    if($dm->status_mobil == Null || $dm->status_mobil == "" || $dm->status_mobil == 0){ ?>
                      <a onclick="return confirm('Kirim Mobil?'');" href="<?php echo site_url('admin/mobilsj/kirim_mobil/'.$dm->id_mobil) ?>" style="margin-right:10px;">
                        <i class="fa fa-send"></i>
                      </a>
                    <?php } ?>
                    <?php
                    if($dm->status_mobil == 1){ ?>
                      <a onclick="return confirm('Selesai Mengirim?'');" href="<?php echo site_url('admin/mobilsj/pengiriman_selesai/'.$dm->id_mobil) ?>" style="margin-right:10px;">
                        <i class="fa fa-bank"></i>
                      </a>
                    <?php } ?>
                    <a href="<?php echo site_url('admin/mobilsj/detail_mobil/'.$dm->id_mobil) ?>" style="margin-right:10px;">
                      <i class="fa fa-ellipsis-h"></i>
                    </a>
                  </td>
                </tr>
                <?php
                $data_sj = $this->db->select('sj_wc.id_sj,sj_wc.kode_sj,sj_wc.tanggal_kirim,sj_wc.tanggal_terima,sj_wc.status,customer.kode,
                                                      mobil.plat_mobil,sum(volume*jumlah) as cbm')
                                          ->from('giw')
            															->join('invoice_product', 'invoice_product.id_giw=giw.id','left')
            															->join('sj_wc', 'sj_wc.id_sj=invoice_product.id_sj_wc','left')
                                          ->join('customer', 'sj_wc.id_cust=customer.id_cust')
                                          ->join('mobil', 'sj_wc.id_mobil=mobil.id_mobil')
                                          ->order_by('sj_wc.status','asc')
                                          ->order_by('sj_wc.id_mobil','desc')
                                          ->order_by('sj_wc.id_sj','desc')
                                          ->where('sj_wc.id_mobil',$dm->id_mobil)
                                          ->where('sj_wc.status <',2)
                                          ->group_by('sj_wc.id_sj')
                                          ->get()->result();
                  foreach ($data_sj as $dsj ) { ?>
                    <tr class="listsj<?php echo $no ?> sjnya<?php echo $no ?>" style="display:none;" >
                      <td><a class="btn btn-default btn-xs" onclick="closesj(<?php echo $no; ?>)"><i class="fa fa-close"> SJ  </i></a></td>
                      <td><?php echo $dsj->kode_sj ?></td>
                      <td><?php echo $dsj->kode ?></td>
                      <td><?php echo round($dsj->cbm,3) ?> m<sup>3</sup></td>
                      <td><?php echo date_indo($dsj->tanggal_kirim) ?></td>
                      <td><a href="<?php echo site_url('admin/mobilsj/detail_sj/'.$dsj->id_sj) ?>" class="" target="_blank" style="margin-right:10px;"> <i class="fa fa-ellipsis-h"></i></a>
                          <a onclick="return confirm('Cancel Sj?');" href="<?php echo site_url('admin/mobilsj/cancel_sj/'.$dsj->id_sj) ?>" class=""  style="margin-right:10px;"> <i class="fa fa-close"></i></a>
                      </td>
                    </tr>
                <?php
                  }
                ?>
              <?php $no++; } ?>
            </tbody>
        </table>
       </div>
     </div>
   </div>
  </div>

  <div class="row">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"><b>List SJ</b></h3>
      </div>

      <div class="box-body">
      <div class="box-body table-responsive">

      <table class="table table-bordered table-striped no-margin" id="mytable">
        <thead>
          <tr>
            <th>Kode Sj </th>
            <th>Marking</th>
            <th>Plat Mobil</th>
            <th>Tanggal Kirim</th>
            <th>Tanggal Terima</th>
            <!-- <th>Cbm</th> -->
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
      </table>

   </div>
   </div>
    <!-- Modal Add Customer-->
   </div>
   </div>

  <script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
  <script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
  <script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>
  <script src="<?php echo base_url() ?>assets/jquery/loadingoverlay.min.js"></script>
  <script src="<?php echo base_url() ?>assets/jquery/qz-websocket.js"></script>

  <script type="text/javascript">
          $(document).ready(function(){setTimeout(function(){$(".alert").fadeIn('fast');}, 100);});
            //angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
            setTimeout(function(){$(".alert").fadeOut('fast');}, 5000);
  </script>
  <script type="text/javascript">
  $(document).ready(function(){

    $( "#cek" ).click(function() {
    $.LoadingOverlay("show");
    });

          });
  </script>
  <script>
    $(document).ready(function(){
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

        var table = $("#mytable").dataTable({
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
                scrollX: true,
                processing: true,
                serverSide: true,

                ajax: {"url": "<?php echo base_url()?>admin/mobilsj/get_sj_json", "type": "POST"},
                    columns: [
                          {"data": "kode_sj"},
                          {"data": "kode"},
                          {"data": "plat_mobil"},
                          {"data": "tanggal_kirim"},
                          {"data": "tanggal_terima"},
                          // {"data": "cbm" ,
                          //   render : function(data,type,row){
                          //     var strStatus = "";
                          //     strCBM = row.jumlah * row.volume;
                          //     return strCBM ;
                          //   }
                          // },
                          {"data": "status" ,
                            render : function(data,type,row){
                              var strStatus = "";
                              if(row.status == 0 ){
                                strStatus = "Belum Terkirim";
                              }else if(row.status == 1){
                                strStatus = "Terkirim";
                              }
                              else if(row.status == 2){
                                strStatus = "Selesai Terkirim";
                              }
                              return strStatus ;
                            }
                          },

                          {"data": "view"},
                    ],
                order: [[1, 'asc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                $('td:eq(0)', row).html();
                if (data['status'] == "2"){
                  $('td', row).css('background-color', '#A9F096');//00FF7F
                  $('td', row).css('color', 'black');
                }
                else if(data['status'] == "1"){
                  $('td', row).css('background-color', '#F9DF9C');
                  $('td', row).css('color', 'black');
                }
            }

        });

        // end setup datatables

        // get Send Kf
        $('#mytable').on('click','.send_konfirmasi',function(){
              var id_resi=$(this).data('id_resi');
              $('#ModalSendKf').modal('show');
              $('[name="id_resi"]').val(id_resi);

        });
        // End Send Kf

        // Delete Resi
        $('#mytable').on('click','.delete_resi',function(){
              var id_resi=$(this).data('id_resi');
              $('#ModalDelete').modal('show');
              $('[name="id_resi"]').val(id_resi);

        });

    });
  </script>

<script type="text/javascript">
  function closesj(id)
  {
    $(".listsj"+id).hide();
  }

  function bukasj(id)
  {
    $(".listsj"+id).removeAttr("style");
  }
</script>
<script type="text/javascript">
        //Deploys QZ Tray
        deployQZ();

        function getCertificate(callback) {
            /*
            $.ajax({
                method: 'GET',
                url: 'assets/auth/digital-certificate.txt',
                async: false,
                success: callback // Data returned from ajax call should be the site certificate
            });
            */
            //Non-ajax method, only include public key and intermediate key
            callback("-----BEGIN CERTIFICATE-----\n" +
                "MIIFAzCCAuugAwIBAgICEAIwDQYJKoZIhvcNAQEFBQAwgZgxCzAJBgNVBAYTAlVT\n" +
                "MQswCQYDVQQIDAJOWTEbMBkGA1UECgwSUVogSW5kdXN0cmllcywgTExDMRswGQYD\n" +
                "VQQLDBJRWiBJbmR1c3RyaWVzLCBMTEMxGTAXBgNVBAMMEHF6aW5kdXN0cmllcy5j\n" +
                "b20xJzAlBgkqhkiG9w0BCQEWGHN1cHBvcnRAcXppbmR1c3RyaWVzLmNvbTAeFw0x\n" +
                "NTAzMTkwMjM4NDVaFw0yNTAzMTkwMjM4NDVaMHMxCzAJBgNVBAYTAkFBMRMwEQYD\n" +
                "VQQIDApTb21lIFN0YXRlMQ0wCwYDVQQKDAREZW1vMQ0wCwYDVQQLDAREZW1vMRIw\n" +
                "EAYDVQQDDAlsb2NhbGhvc3QxHTAbBgkqhkiG9w0BCQEWDnJvb3RAbG9jYWxob3N0\n" +
                "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAtFzbBDRTDHHmlSVQLqjY\n" +
                "aoGax7ql3XgRGdhZlNEJPZDs5482ty34J4sI2ZK2yC8YkZ/x+WCSveUgDQIVJ8oK\n" +
                "D4jtAPxqHnfSr9RAbvB1GQoiYLxhfxEp/+zfB9dBKDTRZR2nJm/mMsavY2DnSzLp\n" +
                "t7PJOjt3BdtISRtGMRsWmRHRfy882msBxsYug22odnT1OdaJQ54bWJT5iJnceBV2\n" +
                "1oOqWSg5hU1MupZRxxHbzI61EpTLlxXJQ7YNSwwiDzjaxGrufxc4eZnzGQ1A8h1u\n" +
                "jTaG84S1MWvG7BfcPLW+sya+PkrQWMOCIgXrQnAsUgqQrgxQ8Ocq3G4X9UvBy5VR\n" +
                "CwIDAQABo3sweTAJBgNVHRMEAjAAMCwGCWCGSAGG+EIBDQQfFh1PcGVuU1NMIEdl\n" +
                "bmVyYXRlZCBDZXJ0aWZpY2F0ZTAdBgNVHQ4EFgQUpG420UhvfwAFMr+8vf3pJunQ\n" +
                "gH4wHwYDVR0jBBgwFoAUkKZQt4TUuepf8gWEE3hF6Kl1VFwwDQYJKoZIhvcNAQEF\n" +
                "BQADggIBAFXr6G1g7yYVHg6uGfh1nK2jhpKBAOA+OtZQLNHYlBgoAuRRNWdE9/v4\n" +
                "J/3Jeid2DAyihm2j92qsQJXkyxBgdTLG+ncILlRElXvG7IrOh3tq/TttdzLcMjaR\n" +
                "8w/AkVDLNL0z35shNXih2F9JlbNRGqbVhC7qZl+V1BITfx6mGc4ayke7C9Hm57X0\n" +
                "ak/NerAC/QXNs/bF17b+zsUt2ja5NVS8dDSC4JAkM1dD64Y26leYbPybB+FgOxFu\n" +
                "wou9gFxzwbdGLCGboi0lNLjEysHJBi90KjPUETbzMmoilHNJXw7egIo8yS5eq8RH\n" +
                "i2lS0GsQjYFMvplNVMATDXUPm9MKpCbZ7IlJ5eekhWqvErddcHbzCuUBkDZ7wX/j\n" +
                "unk/3DyXdTsSGuZk3/fLEsc4/YTujpAjVXiA1LCooQJ7SmNOpUa66TPz9O7Ufkng\n" +
                "+CoTSACmnlHdP7U9WLr5TYnmL9eoHwtb0hwENe1oFC5zClJoSX/7DRexSJfB7YBf\n" +
                "vn6JA2xy4C6PqximyCPisErNp85GUcZfo33Np1aywFv9H+a83rSUcV6kpE/jAZio\n" +
                "5qLpgIOisArj1HTM6goDWzKhLiR/AeG3IJvgbpr9Gr7uZmfFyQzUjvkJ9cybZRd+\n" +
                "G8azmpBBotmKsbtbAU/I/LVk8saeXznshOVVpDRYtVnjZeAneso7\n" +
                "-----END CERTIFICATE-----\n" +
                "--START INTERMEDIATE CERT--\n" +
                "-----BEGIN CERTIFICATE-----\n" +
                "MIIFEjCCA/qgAwIBAgICEAAwDQYJKoZIhvcNAQELBQAwgawxCzAJBgNVBAYTAlVT\n" +
                "MQswCQYDVQQIDAJOWTESMBAGA1UEBwwJQ2FuYXN0b3RhMRswGQYDVQQKDBJRWiBJ\n" +
                "bmR1c3RyaWVzLCBMTEMxGzAZBgNVBAsMElFaIEluZHVzdHJpZXMsIExMQzEZMBcG\n" +
                "A1UEAwwQcXppbmR1c3RyaWVzLmNvbTEnMCUGCSqGSIb3DQEJARYYc3VwcG9ydEBx\n" +
                "emluZHVzdHJpZXMuY29tMB4XDTE1MDMwMjAwNTAxOFoXDTM1MDMwMjAwNTAxOFow\n" +
                "gZgxCzAJBgNVBAYTAlVTMQswCQYDVQQIDAJOWTEbMBkGA1UECgwSUVogSW5kdXN0\n" +
                "cmllcywgTExDMRswGQYDVQQLDBJRWiBJbmR1c3RyaWVzLCBMTEMxGTAXBgNVBAMM\n" +
                "EHF6aW5kdXN0cmllcy5jb20xJzAlBgkqhkiG9w0BCQEWGHN1cHBvcnRAcXppbmR1\n" +
                "c3RyaWVzLmNvbTCCAiIwDQYJKoZIhvcNAQEBBQADggIPADCCAgoCggIBANTDgNLU\n" +
                "iohl/rQoZ2bTMHVEk1mA020LYhgfWjO0+GsLlbg5SvWVFWkv4ZgffuVRXLHrwz1H\n" +
                "YpMyo+Zh8ksJF9ssJWCwQGO5ciM6dmoryyB0VZHGY1blewdMuxieXP7Kr6XD3GRM\n" +
                "GAhEwTxjUzI3ksuRunX4IcnRXKYkg5pjs4nLEhXtIZWDLiXPUsyUAEq1U1qdL1AH\n" +
                "EtdK/L3zLATnhPB6ZiM+HzNG4aAPynSA38fpeeZ4R0tINMpFThwNgGUsxYKsP9kh\n" +
                "0gxGl8YHL6ZzC7BC8FXIB/0Wteng0+XLAVto56Pyxt7BdxtNVuVNNXgkCi9tMqVX\n" +
                "xOk3oIvODDt0UoQUZ/umUuoMuOLekYUpZVk4utCqXXlB4mVfS5/zWB6nVxFX8Io1\n" +
                "9FOiDLTwZVtBmzmeikzb6o1QLp9F2TAvlf8+DIGDOo0DpPQUtOUyLPCh5hBaDGFE\n" +
                "ZhE56qPCBiQIc4T2klWX/80C5NZnd/tJNxjyUyk7bjdDzhzT10CGRAsqxAnsjvMD\n" +
                "2KcMf3oXN4PNgyfpbfq2ipxJ1u777Gpbzyf0xoKwH9FYigmqfRH2N2pEdiYawKrX\n" +
                "6pyXzGM4cvQ5X1Yxf2x/+xdTLdVaLnZgwrdqwFYmDejGAldXlYDl3jbBHVM1v+uY\n" +
                "5ItGTjk+3vLrxmvGy5XFVG+8fF/xaVfo5TW5AgMBAAGjUDBOMB0GA1UdDgQWBBSQ\n" +
                "plC3hNS56l/yBYQTeEXoqXVUXDAfBgNVHSMEGDAWgBQDRcZNwPqOqQvagw9BpW0S\n" +
                "BkOpXjAMBgNVHRMEBTADAQH/MA0GCSqGSIb3DQEBCwUAA4IBAQAJIO8SiNr9jpLQ\n" +
                "eUsFUmbueoxyI5L+P5eV92ceVOJ2tAlBA13vzF1NWlpSlrMmQcVUE/K4D01qtr0k\n" +
                "gDs6LUHvj2XXLpyEogitbBgipkQpwCTJVfC9bWYBwEotC7Y8mVjjEV7uXAT71GKT\n" +
                "x8XlB9maf+BTZGgyoulA5pTYJ++7s/xX9gzSWCa+eXGcjguBtYYXaAjjAqFGRAvu\n" +
                "pz1yrDWcA6H94HeErJKUXBakS0Jm/V33JDuVXY+aZ8EQi2kV82aZbNdXll/R6iGw\n" +
                "2ur4rDErnHsiphBgZB71C5FD4cdfSONTsYxmPmyUb5T+KLUouxZ9B0Wh28ucc1Lp\n" +
                "rbO7BnjW\n" +
                "-----END CERTIFICATE-----\n");
        }

        function signRequest(toSign, callback) {
          /*
          $.ajax({
            method: 'GET',
            contentType: "text/plain",
            url: '/secure/url/for/sign-message.php?request=' + toSign,
            async: false,
            success: callback // Data returned from ajax call should be the signature
          });
          */

          //Send unsigned messages to socket - users will then have to Allow/Deny each print request
          callback();
        }

        function printsj(id) {
          console.log(id);
          qz.appendFile("https://www.wilopocargo.com/office/printsj/sj_permobil.php?idmobil="+id;);
        }
        function qzDoneAppending() {
         qz.print();
        }

        /**
         * Automatically gets called when "qz.print()" is finished.
         */
        function qzDonePrinting() {
          // Alert error, if any
          if (qz.getException()) {
            alert('Error printing:\n\n\t' + qz.getException().getLocalizedMessage());
            qz.clearException();
            return;
          }

          // Alert success message
          alert('Successfully sent print data to "' + qz.getPrinter() + '" queue.');
        }

        /*************************
        * Prototype function for listing all printers attached to the system
        * Usage:
        *    qz.findPrinter('\\{dummy_text\\}');
        *    window['qzDoneFinding'] = function() { alert(qz.getPrinters()); };
        *************************/
        function findPrinter(name) {
          // alert("bajingan");
          qz.findPrinter("EPSON LX-310 ESC/P");
        }

        function qzDoneFinding() {
          if (qz.getPrinter()) {
             alert("Printer " + qz.getPrinter() + " found.");
          } else {
             alert("Printer EPSON LX-310 not found.");
          }
        }
    </script>
