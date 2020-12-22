<head>
  <meta charset="utf-8">
  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">

</head>

  <?php $idcust = $this->uri->segment(4); ?>

  <div class="box-header with-border">
    <h3 class="box-title"><b>Mutasi Penggunaan Deposit</b></h3>
    <span class="pull-right">

    </span>

  </div>

    <div class="box-body">
    <div class="box-body table-responsive">

      <table class="table table-bordered table-striped no-margin" id="mytable">
        <thead>
          <tr>
            <th>Nominal </th>
            <th>Transaksi</th>
            <th>Keterangan</th>
            <th>Tanggal</th>
          </tr>
        </thead>

      </table>

 </div>
 </div>

 <script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
 <script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
 <script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>

 <script type="text/javascript">
         $(document).ready(function(){setTimeout(function(){$(".alert").fadeIn('fast');}, 100);});
           //angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
           setTimeout(function(){$(".alert").fadeOut('fast');}, 5000);
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
               ajax: {"url": "<?php echo base_url('admin/customer/get_depositid_json/'.$idcust)?>", "type": "POST"},
               columns: [
                     {"data": "nominal_deposit", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                     {"data": "tipe_deposit"},
                     {"data": "keterangan_deposit"},
                     {"data": "tanggal_deposit"},
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
