<head>
  <meta charset="utf-8">
  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">

</head>

  <?php $idcust = $this->uri->segment(4); ?>

  <div class="box-header with-border">
    <h3 class="box-title"><b>Titip Transfer List</b></h3>
    <span class="pull-right">

    </span>

  </div>

    <div class="box-body">
    <div class="box-body table-responsive">

      <table class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info" id="mytable">
        <thead>
          <tr>
            <th>Kode Mark Customer</th>
            <th>Kode Transaksi</th>
            <th>Kode Invoice</th>
            <th>Tanggal Transaksi</th>
            <th>Jumlah Rmb</th>
            <th>Kurs Jual</th>
            <th>Fee Bank</th>
            <th>Fee Cs</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
      </table>

      <form id="add-row-form" action="<?php echo base_url().'admin/transaksi/update_bank'?>" method="post" enctype="multipart/form-data">
         <div class="modal fade" id="Modalsb" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
               <div class="modal-content">
                   <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                       <h4 class="modal-title" id="myModalLabel">Update Bank Tujuan </h4>
                   </div>
                   <div class="modal-body">
                   <label id="sendbank"></label>
                   <input type="hidden" name="id_transaksi" class="form-control" required />
                   <input type="hidden" name="kode_transaksi" class="form-control" required />

                   <div class="form-group">
                   <label>Bank Tujuan (Text)</label>
                       <textarea type="text" name="bank_tujuan" class="form-control" rows="7" required ></textarea>
                   </div>

                   <div class="form-group">
                   <label>Bank Tujuan (Gambar)</label>
                       <input type="file" name="file_bank_tujuan[]" class="btn btn-primary form-control">
                   </div>
                   <br />
                   <div class="jfile_bank_tujuan"></div>
                   </div>
                   <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="add-row" class="btn btn-primary">Ok</button>
                   </div>
                </div>
            </div>
         </div>
     </form>

     <!-- Modal Update Produk-->
      <form id="add-row-form" action="<?php echo base_url().'admin/transaksi/cancel_transaksi'?>" method="post" enctype="multipart/form-data">
         <div class="modal fade" id="Modalcl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
               <div class="modal-content">
                   <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                       <h4 class="modal-title" id="myModalLabel"><label id="judulcancel"></label> </h4>
                   </div>
                   <input type="hidden" name="id_invoice" class="form-control" required />

                   <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="add-row" class="btn btn-primary">Ok</button>
                   </div>
                </div>
            </div>
         </div>
     </form>

     <!-- Modal Update Produk-->
      <form id="add-row-form" action="<?php echo base_url().'admin/transaksi/refund_invoice'?>" method="post" enctype="multipart/form-data">
         <div class="modal fade" id="Modalrf" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
               <div class="modal-content">
                   <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                       <h4 class="modal-title" id="myModalLabel"><label id="judulrefund"></label> </h4>
                   </div>
                   <input type="hidden" name="id_invoice" class="form-control" required />
                   <input type="hidden" name="kode_invoice" class="form-control" required />

                   <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="add-row" class="btn btn-primary">Ok</button>
                   </div>
                </div>
            </div>
         </div>
     </form>

     <div id="view_image"></div>


 </div>
 </div>



<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>
<script src="<?php echo base_url() ?>assets/jquery/loadingoverlay.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){

  $( "#cek" ).click(function() {
  $.LoadingOverlay("show");
  });

        });
</script>
<script type="text/javascript">
  function view_image(id)
  {
    console.log(id);
    $.ajax({
      type : "GET",
      url : "<?php echo base_url() ?>admin/transaksi/view_image/"+id,
      cache : false,
      async : false,
      success : function(html){
        $("#view_image").html(html).show();
        $('#modeditbuku').modal('show');
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
              ajax: {"url": "<?php echo base_url('admin/transaksi/get_transaksiid_json/'.$idcust)?>", "type": "POST"},
                  columns: [
                        {"data": "mark_transaksi"},
                        {"data": "kode_transaksi"},
                        {"data": "kode_invoice"},
                        {"data": "tanggal_transaksi"},
                        {"data": "total_rmb"},
                        {"data": "kurs_jual", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                        {"data": "fee_bank"},
                        {"data": "fee_cs",  render: $.fn.dataTable.render.number(',', '.','','¥ ')},
                        {"data": "status" ,
                          render : function(data,type,row){
                            var strStatus = "";
                            if(row.status == 1){
                              strStatus = "Pending";
                            }else if(row.status == 2){
                              strStatus = "Process";
                            }else if(row.status == 3){
                              strStatus = "Complete";
                            }else if(row.status == 4){
                              strStatus = "Salah Bank";
                            }
                            return strStatus ;
                          }
                        },
                        //render harga dengan format angka

                        {"data": "view"}
                  ],
              order: [[1, 'desc']],
          rowCallback: function(row, data, iDisplayIndex) {
              var info = this.fnPagingInfo();
              var page = info.iPage;
              var length = info.iLength;
              $('td:eq(0)', row).html();
              if (data['status'] == "3"){
                $('td', row).css('background-color', '#A9F096');//00FF7F
                $('td', row).css('color', 'black');
              }
              else if(data['status'] == "2"){
                $('td', row).css('background-color', '#FABAA5');
                $('td', row).css('color', 'black');
              }
              else if(data['status'] == "4"){
                $('td', row).css('background-color', '#F9DF9C');
                $('td', row).css('color', 'black');
              }
          },
      });
      // end setup datatables
      // get Edit Records
      $('#mytable').on('click','.update_bank',function(){
            var id_transaksi=$(this).data('id_transaksi');
            var kode_transaksi=$(this).data('kode_transaksi');
            var bank_tujuan=$(this).data('bank_tujuan');
            var file_bank_tujuan=$(this).data('file_bank_tujuan');
            var base_url ="<?php echo base_url() ?>";

            $('#Modalsb').modal('show');
            $('[name="id_transaksi"]').val(id_transaksi);
            $('[name="kode_transaksi"]').val(kode_transaksi);
            $('[name="bank_tujuan"]').val(bank_tujuan);
            $('#jfile_bank_tujuan').html('<img src="'+base_url+'assets/bank_tujuan/'+file_bank_tujuan+'" width="100%" height="400" />');

      });
      // End Edit Records

      $('#mytable').on('click','.cancel_transaksi',function(){
            var id_invoice=$(this).data('id_invoice');
            var kode_invoice=$(this).data('kode_invoice');

            $('#Modalcl').modal('show');
            $('[name="id_invoice"]').val(id_invoice);
            $('#judulcancel').html('<label>Cancel Invoice '+kode_invoice+'?</label>');
      });

      $('#mytable').on('click','.refund_transaksi',function(){
            var id_invoice=$(this).data('id_invoice');
            var kode_invoice=$(this).data('kode_invoice');

            $('#Modalrf').modal('show');
            $('[name="id_invoice"]').val(id_invoice);
            $('[name="kode_invoice"]').val(kode_invoice);
            $('#judulrefund').html('<label>Refund Invoice '+kode_invoice+'?</label>');
      });
      // End Edit Records


      $('#mytable').on('click','.view_image',function(){
          var id=$(this).data('id_transaksi');
          $.ajax({
            type : "GET",
            url : "<?php echo base_url() ?>admin/transaksi/view_image/"+id,
            cache : false,
            async : false,
            success : function(html){
              $("#view_image").html(html).show();
              $('#modeditbuku').modal('show');
            }
          });
      });
      // End Image Records

});
</script>
