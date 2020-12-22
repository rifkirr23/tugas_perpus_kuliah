<head><meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
</head>

            <?php if($this->session->flashdata('msg')=='success'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Input Jenis barang Baru Success
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

        <?php if($this->session->flashdata('msg')=='updated'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Jenis barang Updated
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Data Jenis barang </b></h3>
      <span class="pull-right">

        <button class="btn btn-primary" data-toggle="modal" data-target="#myModalAdd"><i class="fa fa-plus">Jenis barang</i></button>

      </span>
    </div>

    <div class="box-body">
    <div class="box-body table-responsive">

    <table class="table table-bordered table-striped no-margin" id="mytable">
      <thead>
        <tr>
          <th>Nama</th>
          <th>List</th>
          <th>Note</th>
          <th>Nama Lain</th>
          <th>Harga</th>
          <th>Action</th>
        </tr>
      </thead>
    </table>

  <!-- Modal Add Customer-->

    <form id="add-row-form" action="<?php echo base_url().'admin/jenis_barang/save'?>" method="post">
       <div class="modal fade" id="myModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Input Jenis barang Baru</h4>
                 </div>
                 <div class="modal-body">

                   <div class="form-group">
                   <label>Nama Jenis barang</label>
                       <input type="text" name="nama" class="form-control" placeholder="Masukan Nama Jenis barang Yang akan diinput" required>
                   </div>
                   <div class="form-group">
                   <label>List</label>
                       <input type="text" name="list" class="form-control" placeholder="Masukan List">
                   </div>
                   <div class="form-group">
                   <label>Note</label>
                       <textarea type="text" name="note" class="form-control" placeholder="Masukan Note"></textarea>
                   </div>
                   <div class="form-group">
                     <label>Nama Lain</label>
                     <input type="text" name="namalain" class="form-control" placeholder="Masukan Nama Lain" required>
                   </div>
                   <div class="form-group">
                     <label>Harga</label>
                     <input type="text" name="harga" class="form-control" placeholder="Masukan Harga" required>
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
    <form id="add-row-form" action="<?php echo base_url().'admin/jenis_barang/update'?>" method="post">
       <div class="modal fade" id="ModalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Update Data Jenis barang</h4>
                 </div>
                 <div class="modal-body">

                 <input type="hidden" name="id" class="form-control" required>

                     <div class="form-group">
                     <label>Nama Jenis barang</label>
                         <input type="text" name="nama" class="form-control" placeholder="Masukan Nama Jenis barang Yang akan diinput" required>
                     </div>
                     <div class="form-group">
                     <label>List</label>
                         <input type="text" name="list" class="form-control" placeholder="Masukan List" required>
                     </div>
                     <div class="form-group">
                     <label>Note</label>
                         <textarea type="text" name="note" class="form-control" placeholder="Masukan Note" required></textarea>
                     </div>
                     <div class="form-group">
                       <label>Nama Lain</label>
                       <input type="text" name="namalain" class="form-control" placeholder="Masukan Nama Lain" required>
                     </div>
                     <div class="form-group">
                       <label>Harga</label>
                       <input type="text" name="harga" class="form-control" placeholder="Masukan Harga" required>
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

<script>
    $(document).ready(function(){

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
              ajax: {"url": "<?php echo base_url()?>admin/jenis_barang/get_jb_json", "type": "POST"},
                  columns: [

                        {"data": "nama"},
                        {"data": "list"},
                        {"data": "note"},
                        {"data": "namalain"},
                        {"data": "harga", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                        {"data": "view"}
                  ],

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
            var id=$(this).data('id');
            var nama=$(this).data('nama');
            var list=$(this).data('list');
            var namalain=$(this).data('namalain');
            var harga=$(this).data('harga');


            $('#ModalUpdate').modal('show');
            $('[name="id"]').val(id);
            $('[name="nama"]').val(nama);
            $('[name="list"]').val(list);
            $('[name="namalain"]').val(namalain);
            $('[name="harga"]').val(harga);

      });
      // End Edit Records

  });
</script>
