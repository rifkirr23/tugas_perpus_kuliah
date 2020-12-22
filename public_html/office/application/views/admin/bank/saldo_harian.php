<head><meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

   <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>" />
   <link href="<?php echo base_url().'assets/jquery/select2.min.css'?>" rel="stylesheet" />
</head

        <?php if($this->session->flashdata('msg')=='updated'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i> Transaksi Updated
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Saldo Harian</b></h3>
      <span class="pull-right"></span>
    </div>

    <div class="box-body">
    <div class="box-body table-responsive" id="area">

    <table class="table table-bordered table-striped no-margin" id="mytable">
      <thead>
        <tr>
          <th>Bank</th>
          <th>Tanggal</th>
          <th>Jumlah</th>
          <th>Keterangan</th>
          <th>Action</th>
        </tr>
      </thead>
    </table>

    <!-- Form Update -->
    <form id="add-row-form" action="<?php echo base_url().'admin/bank/update_saldoharian'?>" method="post">
       <div class="modal fade" id="ModalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Update Keterangan Harian Bank</h4>
                 </div>
                 <div class="modal-body">
                   <input type="hidden" name="id_saldo_harian" class="form-control" required>
                   <input type="hidden" name="id_bank" class="form-control" required>

                   <div class="form-group">
                   <label>Keterangan</label>
                       <input type="text" name="keterangan" class="form-control" placeholder="Keterangan Saldo Harian" required>
                   </div>

                 </div>
                 <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" id="add-row" class="btn btn-primary">Update</button>
                 </div>
              </div>
          </div>
       </div>
   </form>


<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/jquery/select2.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>
<script src="<?php echo base_url().'assets/jquery/jquery.mask.min.js'?>"?>></script>
<script src="<?php echo base_url() ?>assets/jquery/loadingoverlay.min.js"></script>
<script>
    $(document).ready(function(){
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};

        $('form').submit(function() {
          $.LoadingOverlay("show");
        });

    })
</script>

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
              // paging:false,
              ajax: {"url": "<?php echo base_url()?>admin/bank/get_saldo_harian_json/<?php echo $this->uri->segment(4) ?>", "type": "POST"},
                  columns: [
                        {"data": "nama_bank"},
                        {"data": "tanggal_saldo"},
                        {"data": "jumlah", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                        {"data": "keterangan"},
                        {"data": "view"}
                  ],
                  order: [[0, 'desc']],

          rowCallback: function(row, data, iDisplayIndex) {
              var info = this.fnPagingInfo();
              var page = info.iPage;
              var length = info.iLength;
              $('td:eq(0)', row).html();
          }

      });
      // end setup datatables
      // get Edit Records
      $('#mytable').on('click','.edit_record',function(){
            var id_saldo_harian=$(this).data('id_saldo_harian');
            var keterangan=$(this).data('keterangan');
            var id_bank=$(this).data('id_bank');

            $('#ModalUpdate').modal('show');
            $('[name="id_saldo_harian"]').val(id_saldo_harian);
            $('[name="keterangan"]').val(keterangan);
            $('[name="id_bank"]').val(id_bank);

      });
      // End Edit Records


  });
</script>
