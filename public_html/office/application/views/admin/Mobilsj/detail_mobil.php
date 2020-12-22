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
<?php if($this->session->flashdata('msg')=='okupdate'){ ?>

   <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-success"></i> Berhasil Update Mobil
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
      <h4 class="pull-left" class="form-control">Mobil ( <?php echo $data_mobil->plat_mobil ?> )</h4>
        <span class="pull-right" style="margin-right:1%;">
        </span>
    </div>
    <div class="box-body">
      <div class="box-body table-responsive">
        <form action="<?php echo site_url('admin/mobilsj/update_mobil') ?>" method="post">
          <input type="hidden" name="id_mobil" value="<?php echo $data_mobil->id_mobil ?>">
          <div class="form-group">
              <label>Plat Mobil </label>
              <input type="text" value="<?php echo $data_mobil->plat_mobil ?>" name="plat_mobil" class="form-control" placeholder="Plat Mobil" value="<?php echo $data_cust->nama ?>" required>
          </div>
          <div class="form-group">
              <label>Limit CBM </label>
              <input type="text" value="<?php echo $data_mobil->limit_cbm ?>" name="limit_cbm" class="form-control" placeholder="Limit Cbm" value="<?php echo $data_cust->nama ?>" required>
          </div>

          <div class="form-group">
              <button type="submit" class="btn btn-primary">Save </button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

  <div class="row">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"><b>List SJ</b></h3>
        <span class="pull-right">
          <a class="btn btn-info" onclick="printsj()" style="margin-right:10px;">
            <i class="fa fa-print"></i>
          </a>
          <a class="btn btn-danger" onclick="findPrinter()"><i class="fa fa-print"></i>  Detect Printer</a>
        </span>
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
            <th>Cbm</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $totalsj = 0; foreach($data_sj as $dsj){ ?>
            <tr>
              <td><?php echo $dsj->kode_sj ?></td>
              <td><?php echo $dsj->kode ?></td>
              <td><?php echo $dsj->plat_mobil ?></td>
              <td><?php echo date_indo($dsj->tanggal_kirim) ?></td>
              <td><?php echo date_indo($dsj->tanggal_terima) ?></td>
              <td><?php echo round($dsj->cbm,3) ?> m<sup>3</sup></td>
              <td><?php
                    if($dsj->status == Null || $dsj->status == "" || $dsj->status ==0){
                      echo "Belum Terkirim";
                    }else if($dsj->status == 1){
                      echo "Terkirim";
                    }else if($dsj->status == 2){
                      echo "Selesai Terkirim";
                    }else {
                      echo "-";
                    }
                  ?>
              </td>
              <td><a href="<?php echo site_url('admin/mobilsj/detail_sj/'.$dsj->id_sj) ?>" class="" target="_blank" style="margin-right:10px;"> <i class="fa fa-ellipsis-h"></i></a></td>
            </tr>
          <?php $totalsj+=$dsj->cbm; } ?>
          <tr>
            <td colspan="5">Total</td>
            <td><?php echo round($totalsj,3) ?> m<sup>3</sup></td>
          </tr>
        </tbody>
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

        function printsj() {
          console.log("ok");
          qz.appendFile("https://www.wilopocargo.com/office/printsj/sj_permobil.php?idmobil="+<?php echo $this->uri->segment(4); ?>);
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
