<head><meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>" />
</head>

            <?php if($this->session->flashdata('msg')=='success'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Input Account Success
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

        <?php if($this->session->flashdata('msg')=='updated'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Account data Updated
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Data Account </b></h3>
      <span class="pull-right">

        <button class="btn btn-primary" data-toggle="modal" data-target="#myModalAdd"><i class="fa fa-plus"></i></button>

      </span>
    </div>

    <div class="box-body">
    <div class="box-body table-responsive">

    <table class="table table-bordered table-striped no-margin" id="mytable">
      <thead>
        <tr>

          <th>Nama</th>
          <th>Username</th>
          <th>level</th>
          <th>Last Login</th>

          <th>Action</th>
        </tr>
      </thead>
    </table>

  <!-- Modal Add Customer-->

    <form id="add-row-form" action="<?php echo base_url().'admin/account/save'?>" method="post">
       <div class="modal fade" id="myModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Input New Account</h4>
                 </div>
                 <div class="modal-body">
                     <div class="form-group">
                     <label>Nama Pengguna </label>
                         <input type="text" name="nama_pengguna" class="form-control" placeholder="Nama Pengguna" required>
                     </div>
                     <div class="form-group">
                     <label>Username </label>
                         <input type="text" name="username" class="form-control" placeholder="Username" required>
                     </div>
                     <div class="form-group">
                     <label>Password </label>
                         <input type="password" name="password" class="form-control" placeholder="Password" required>
                     </div>

                     <div class="form-group">
                     <label>Level </label>
                         <select name="level" class="form-control" required>
                                    <option value="admin"> Admin</option>
                                    <option value="admin2">Admin 2</option>
                         </select>
                     </div>


                 </div>
                 <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" id="add-row" class="btn btn-primary">Save</button>
                 </div>
              </div>
          </div>
       </div>
   </form>

   <!-- Modal Update Produk-->
    <form id="add-row-form" action="<?php echo base_url().'admin/account/update'?>" method="post">
       <div class="modal fade" id="ModalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Update Account</h4>
                 </div>
                 <div class="modal-body">

                 <input type="hidden" name="id_pengguna" class="form-control" required>

                     <div class="form-group">
                     <label>Nama Pengguna </label>
                         <input type="text" name="nama_pengguna" class="form-control" placeholder="Nama Pengguna" required>
                     </div>
                     <div class="form-group">
                     <label>Username </label>
                         <input type="text" name="username" class="form-control" placeholder="Username" required>
                     </div>
                     <div class="form-group">
                     <label>New Password </label>
                         <input type="password" name="password" class="form-control" placeholder="New Password">
                     </div>

                     <div class="form-group">
                     <label>Level </label>
                         <select name="level" class="form-control" required>
                                    <option value="admin"> Admin</option>
                                    <option value="admin2">Admin 2</option>
                         </select>
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
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>
<script src="<?php echo base_url().'assets/jquery/jquery.mask.min.js'?>"?>></script>
<script src="<?php echo base_url() ?>assets/jquery/loadingoverlay.min.js"></script>

<script type="text/javascript">
        $(document).ready(function(){setTimeout(function(){$(".alert").fadeIn('fast');}, 100);});
          //angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
          setTimeout(function(){$(".alert").fadeOut('fast');}, 5000);
</script>



<script>
  $(document).ready(function(){

    $('form').submit(function() {
                  $.LoadingOverlay("show");
                });

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
              ajax: {"url": "<?php echo base_url()?>/admin/account/get_account_json", "type": "POST"},
                  columns: [

                        {"data": "nama_pengguna"},
                        {"data": "username"},
                        {"data": "level"},
                        {"data": "last_login"},

                        //render harga dengan format angka

                        {"data": "view"}
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
      // get Edit Records
      $('#mytable').on('click','.edit_record',function(){
            var id_pengguna=$(this).data('id_pengguna');
            var username=$(this).data('username');
            var nama_pengguna=$(this).data('nama_pengguna');
            var level=$(this).data('level');


            $('#ModalUpdate').modal('show');
            $('[name="id_pengguna"]').val(id_pengguna);
            $('[name="username"]').val(username);
            $('[name="nama_pengguna"]').val(nama_pengguna);
            $('[name="level"]').val(level);

      });
      // End Edit Records


  });
</script>
