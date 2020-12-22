<head>
  <meta charset="utf-8">
  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">

</head>

  <?php $idcust = $this->uri->segment(4); ?>

  <div class="box-header with-border">
    <h3 class="box-title"><b>List Barang</b></h3>
    <span class="pull-right">

    </span>

  </div>

    <div class="box-body">
    <div class="box-body table-responsive">

      <table class="table table-bordered table-striped no-margin" id="mybarcode">
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
            <th>Jalur</th>

          </tr>
        </thead>
      </table>

     <div id="view_image"></div>
     <div id="view_keterangan"></div>

 </div>
 </div>

 <script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
 <script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
 <script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>

 <script>//Bc
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



       var table = $("#mybarcode").dataTable({
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
               ajax: {"url": "<?php echo base_url()?>admin/resi/get_barcodeidcust_json/<?php echo $this->uri->segment(4) ?>", "type": "POST"},
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
                             }else{
                               strStatus = "Invoice";
                             }
                             return strStatus ;
                           }
                         },
                         {"data": "remarks"},
                         {"data": "harga_jual", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                         {"data": "jalur" ,
                           render : function(data,type,row){
                             var strStatus = "";
                             if(row.jalur != 1 ){
                               strStatus = "Cepat";
                             }else if(row.jalur == 1){
                               strStatus = "Lambat";
                             }
                             return strStatus ;
                           }
                         },

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
