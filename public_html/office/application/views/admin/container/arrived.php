<head><meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
</head>

            <?php if($this->session->flashdata('msg')=='success'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Input Ekspedisi Success
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

        <?php if($this->session->flashdata('msg')=='updated'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Ekspedisi data Updated
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Data Container Arrived </b></h3>
      <span class="pull-right">
      </span>
    </div>

    <div class="box-body">
    <div class="box-body table-responsive">

    <table class="table table-bordered table-striped no-margin" id="mytable">
      <thead>
        <tr>
          <th>Kode</th>
          <th>Nomor</th>
          <th>Tanggal Otw</th>
          <th>Tanggal Monitoring</th>
          <th>Tanggal Sampai </th>
          <th>Action</th>
        </tr>
      </thead>
    </table>

    <form id="add-row-form" action="<?php echo base_url().'admin/container/complete_container'?>" method="post">
       <div class="modal fade" id="ModalComplete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Complete Container?</h4>
                 </div>

                 <input type="hidden" name="id_cont" class="form-control" required>

                 <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" id="add-row" class="btn btn-primary">Save</button>
                 </div>
              </div>
          </div>
       </div>
    </form>

<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>
<script src="<?php echo base_url().'assets/jquery/jquery.mask.min.js'?>"?>></script>

<script type="text/javascript">
        $(document).ready(function(){setTimeout(function(){$(".alert").fadeIn('fast');}, 100);});
          //angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
          setTimeout(function(){$(".alert").fadeOut('fast');}, 5000);
</script>

<script>
    $(document).ready(function(){

                // Format mata uang.
                $( '.uang' ).mask('000.000.000.000', {reverse: true});

            })
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
              ajax: {"url": "<?php echo base_url()?>/admin/Container/get_arrived_json", "type": "POST"},
                  columns: [
                        {"data": "kode"},
                        {"data": "nomor"},
                        {"data": "tanggal_berangkat_c"},
                        {"data": "tanggal_monitoring_c"},
                        {"data": "tanggal_arrived_c"},
                        {"data": "view"}
                  ],
              order: [[4, 'desc']],
          rowCallback: function(row, data, iDisplayIndex) {
              var info = this.fnPagingInfo();
              var page = info.iPage;
              var length = info.iLength;
              $('td:eq(0)', row).html();
          }

      });
      // end setup datatables
      // get Edit Records
      $('#mytable').on('click','.complete_container',function(){
            var id_cont=$(this).data('id_cont');

            $('#ModalComplete').modal('show');
            $('[name="id_cont"]').val(id_cont);

      });
      // End Edit Records


  });
</script>
