<head><meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
</head>
<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>List Leads</b></h3>

    </div>

    <div class="box-body">
    <div class="box-body table-responsive">
    <table class="table table-bordered table-striped no-margin" id="myrmb">
      <thead>

        <tr>
          <th> Tanggal Daftar </th>
          <th> Jenis Barang </th>
          <th> Nama </th>
          <th> Whatsapp </th>
          <th> Email </th>
          <th> Cargo </th>
          <th> Supplier </th>
          <th> Dihub melalui </th>
          <th> Sales </th>
       </tr>
      </thead>
    </table>
   </div>
  </div>
 </div>
</div>



<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>
<script src="<?php echo base_url().'assets/jquery/jquery.mask.min.js'?>"?>></script>

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

      var table = $("#myrmb").dataTable({
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
              ajax: {"url": "<?php echo base_url()?>admin/lead/json_list", "type": "POST"},
                  columns: [

                        //{"data": "id_rmb"},

                        {"data": "tanggal"},
                        {"data": "jenis_barang"},
                        {"data": "nama"},
                        {"data": "whatsapp"},
                        {"data": "email"},
                        {"data": "sp_cargo"},
                        {"data": "sp_supplier"},
                        {"data": "dihub"},
                        {"data": "nama_pengguna"},

                        //render harga dengan format angka

                       // {"data": "view"}
                  ],
              // order: [[0, 'desc']],
          rowCallback: function(row, data, iDisplayIndex) {
              var info = this.fnPagingInfo();
              var page = info.iPage;
              var length = info.iLength;
              $('td:eq(0)', row).html();
          }

      });


  });
</script>
