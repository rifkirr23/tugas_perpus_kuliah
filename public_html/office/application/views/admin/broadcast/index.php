<head>
   <meta charset="utf-8">
   <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>" />
   <link href="<?php echo base_url().'assets/jquery/select2.min.css'?>" rel="stylesheet" />
</head>

    <?php if($this->session->flashdata('msg')=='success'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Success Broadcast
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

    <?php } ?>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Broadcast List</b></h3>
      <span class="pull-right">
                 <button class="btn btn-info" data-toggle="modal" data-target="#myModalAdd"><i class="fa fa-plus"> New Messages</i></button>
      </span>
    </div>

    <div class="box-body">
      <table class="table table-bordered table-striped no-margin" id="mytable">
        <thead>
          <tr>
            <th>Nama Broadcast</th>
            <th>Pesan</th>
            <th>Tanggal Broadcast</th>
            <th>Customer</th>
          </tr>
        </thead>
      </table>
    </div>

   </div>
  </div>
</div>

<!-- Modal Add Customer-->
  <form id="add-row-form" action="<?php echo base_url().'admin/broadcast/save'?>" method="post" enctype="multipart/form-data">
     <div class="modal fade" id="myModalAdd" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                   <h4 class="modal-title" id="myModalLabel">New Messages</h4>
               </div>
               <div class="modal-body">

                   <div class="form-group">
                     <input type="text" name="subject_email" class="form-control" placeholder="Nama Broadcast (Optional)">
                   </div>

                   <div class="form-group">
                       <textarea id="compose-textarea" name="pesan" class="form-control" style="height: 300px;" placeholder="Broadcast Message To Customer Wilopo Cargo"></textarea>
                   </div>

                   <div class="form-group">
                     <select class="form-control" name="customer">
                       <option value="aktivasi">Sudah Aktivasi</option>
                       <option value="pernah">Pernah Aktif Order</option>
                       <option value="30">Aktif Order < 30 Hari </option>
                       <option value="60">Aktif Order < 30 Hari s/d 60 hari</option>
                       <option value="90">Aktif Order < 60 Hari s/d 90 Hari</option>
                       <option value="lebih90">Aktif Order < Lebih 90 Hari</option>
                       <option value="tidak_pernah">Tidak Pernah Aktif Order</option>
                     </select>
                   </div>

                   <!-- <div class="form-group">
                        <label>File</label>
                        <input type="file" name="foto_sk" class="btn btn-primary">
                   </div> -->

               </div>
               <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="add-row" class="btn btn-primary">Save</button>
               </div>
            </div>
        </div>
     </div>
 </form>


<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/jquery/select2.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>
<script src="<?php echo base_url() ?>assets/jquery/loadingoverlay.min.js"></script>
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
              ajax: {"url": "<?php echo base_url()?>admin/broadcast/get_broadcast_json", "type": "POST"},
                  columns: [
                        {"data": "subject_email"},
                        {"data": "pesan"},
                        {"data": "tanggal_broadcast"},
                        {"data": "customer"}
                  ],
              order: [[1, 'asc']],
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
<script>
  $(document).ready(function(){

          $('form').submit(function() {
            $.LoadingOverlay("show");
          });
  });
</script>
