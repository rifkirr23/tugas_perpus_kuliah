<head>
  <meta charset="utf-8">
  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
</head>

          <?php if($this->session->flashdata('msg')=='success'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Payment Success
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>



<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Pembayaran Beli List</b></h3>
      <span class="pull-right">
         <a class="btn btn-primary" href="<?php echo site_url() ?>admin/pembayaran_beli/new"><i class="fa fa-plus"> Pembayaran Beli </i></a>
      </span>
    </div>

    <div class="box-body table-responsive">

    <table class="table table-bordered table-striped no-margin" id="mytable">
      <thead>
        <tr>
          <th>Vendor</th>
          <th>Kode Bayar</th>
          <th>Tanggal Pembayaran</th>
          <th>Jumlah</th>
          <th>Action</th>
        </tr>
      </thead>
    </table>

   <div id="view_image"></div>
   <div id="view_keterangan"></div>


<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>

<script type="text/javascript">
        $(document).ready(function(){setTimeout(function(){$(".alert").fadeIn('fast');}, 100);});
          //angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
          setTimeout(function(){$(".alert").fadeOut('fast');}, 5000);
</script>

<script type="text/javascript">
  function view_image(id)
  {
    console.log(id);
    $.ajax({
      type : "GET",
      url : "<?php echo base_url() ?>admin/pembayaran_beli/view_image/"+id,
      cache : false,
      async : false,
      success : function(html){
        $("#view_image").html(html).show();
        $('#modeditbuku').modal('show');
      }
    })
  }

  function view_keterangan(id)
  {
    console.log(id);
    $.ajax({
      type : "GET",
      url : "<?php echo base_url() ?>admin/pembayaran_beli/view_keterangan/"+id,
      cache : false,
      async : false,
      success : function(html){
        $("#view_keterangan").html(html).show();
        $('#modview_keterangan').modal('show');
      }
    })
  }
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
              ajax: {"url": "<?php echo base_url()?>/admin/pembayaran_beli/get_pembayaran_beli_json", "type": "POST"},
                  columns: [
                        {"data": "nama_vendor"},
                        {"data": "id_pembel"},
                        {"data": "tanggal_pembel"},
                        {"data": "jumlah_pembel", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                        {"data": "view"}
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
