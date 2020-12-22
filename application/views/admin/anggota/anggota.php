<head><meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
</head>

            <?php if($this->session->flashdata('msg')=='success'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Input anggota Success
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

        <?php if($this->session->flashdata('msg')=='updated'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>anggota data Updated
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Data Anggota </b></h3>
      <span class="pull-right">
        <button class="btn btn-primary" data-toggle="modal" data-target="#myModalAdd"><i class="fa fa-plus"> anggota</i></button>
      </span>
    </div>

    <div class="box-body">
    <div class="box-body table-responsive">

    <table class="table table-bordered table-striped no-margin" id="mytable">
      <thead>
        <tr>
          <th>Nama Anggota</th>
          <th>Gender</th>
          <th>No Telp</th>
          <th>Alamat</th>
          <th>Email</th>
          <th>Pilihan</th>
        </tr>
      </thead>
    </table>

  <!-- Modal Add Customer-->
    <form id="add-row-form" action="<?php echo base_url().'admin/anggota/save'?>" method="post">
       <div class="modal fade" id="myModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Form Tambah Anggota</h4>
                 </div>
                 <div class="modal-body">
                   <div class="form-group">
                   <label>Nama Anggota</label>
                       <input type="text" name="nama_anggota" class="form-control" placeholder="Nama Anggota" required>
                   </div>
                   <div class="form-group">
                   <label>Gender</label>
                   <select class="form-control" name="gender">
                     <option>Laki-Laki</option>
                     <option>Perempuan</option>
                   </select>
                       <!-- <input type="text" name="gender" class="form-control" placeholder="Gender" required> -->
                   </div>
                   <div class="form-group">
                   <label>No Telp</label>
                       <input type="text" name="no_telp" class="form-control" placeholder="No.Telp" required>
                   </div>
                   <div class="form-group">
                   <label>Alamat</label>
                       <textarea type="text" name="alamat" class="form-control" placeholder="Alamat" required></textarea>
                   </div>
                   <div class="form-group">
                   <label>Email</label>
                       <input type="text" name="email" class="form-control" placeholder="Email" required>
                   </div>
                   <div class="form-group">
                   <label>Password</label>
                       <input type="password" name="password" class="form-control" placeholder="Password" required>
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
    <form id="add-row-form" action="<?php echo base_url().'admin/anggota/update'?>" method="post">
       <div class="modal fade" id="ModalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Update anggota</h4>
                 </div>
                 <div class="modal-body">

                 <input type="hidden" name="id_anggota" class="form-control" required>

                     <div class="form-group">
                     <label>Nama Anggota</label>
                         <input type="text" name="nama_anggota" class="form-control" placeholder="Nama Anggota" required>
                     </div>
                     <div class="form-group">
                     <label>Gender</label>
                         <input type="text" name="gender" class="form-control" placeholder="Gender" required>
                     </div>
                     <div class="form-group">
                     <label>No Telp</label>
                         <input type="text" name="no_telp" class="form-control" placeholder="No.Telp" required>
                     </div>
                     <div class="form-group">
                     <label>Alamat</label>
                         <textarea type="text" name="alamat" class="form-control" placeholder="Alamat" required></textarea>
                     </div>
                     <div class="form-group">
                     <label>Email</label>
                         <input type="text" name="email" class="form-control" placeholder="Email" required>
                     </div>
                     <div class="form-group">
                     <label>Password</label>
                         <input type="password" name="password" class="form-control" placeholder="Password" required>
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
              ajax: {"url": "<?php echo base_url()?>/admin/anggota/get_anggota_json", "type": "POST"},
                  columns: [

                        {"data": "nama_anggota"},
                        {"data": "gender"},
                        {"data": "no_telp"},
                        {"data": "alamat"},
                        {"data": "email"},
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
            var id_anggota=$(this).data('id_anggota');
            var nama_anggota=$(this).data('nama_anggota');
            var gender=$(this).data('gender');
            var no_telp=$(this).data('no_telp');
            var alamat=$(this).data('alamat');
            var email=$(this).data('email');
            var password=$(this).data('password');


            $('#ModalUpdate').modal('show');
            $('[name="id_anggota"]').val(id_anggota);
            $('[name="nama_anggota"]').val(nama_anggota);
            $('[name="gender"]').val(gender);
            $('[name="no_telp"]').val(no_telp);
            $('[name="alamat"]').val(alamat);
            $('[name="email"]').val(email);
            $('[name="password"]').val(password);

      });
      // End Edit Records


  });
</script>
