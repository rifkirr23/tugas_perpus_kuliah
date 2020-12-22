<head><meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
</head>

            <?php if($this->session->flashdata('msg')=='success'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Input Jenis Transaksi Bank Baru Success
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

        <?php if($this->session->flashdata('msg')=='updated'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Jenis Transaksi Bank Updated
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Data Jenis Transaksi Bank </b></h3>
      <span class="pull-right">

        <button class="btn btn-primary" data-toggle="modal" data-target="#myModalAdd"><i class="fa fa-plus">Jenis Transaksi</i></button>

      </span>
    </div>

    <div class="box-body">
    <div class="box-body table-responsive">

    <table class="table table-bordered table-striped no-margin" id="mytable">
      <thead>
        <tr>

          <th>Jenis Transaksi Bank</th>
          <th>Tipe Jenis Bank</th>
          <th>Action</th>
        </tr>
      </thead>
    </table>

  <!-- Modal Add Customer-->

    <form id="add-row-form" action="<?php echo base_url().'admin/jenis_tb/save'?>" method="post">
       <div class="modal fade" id="myModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Input Jenis Transaksi Bank Baru</h4>
                 </div>
                 <div class="modal-body">
                     <div class="form-group">
                     <label>Nama Jenis Transaksi</label>
                         <input type="text" name="kjenis_transaksi_bank" class="form-control" placeholder="Masukan Nama Jenis Transaksi Yang akan diinput" required>
                     </div>

                     <div class="form-group">
                     <label>Tipe Jenis Transaksi</label>
                            <select name="tipe_jenis_transaksi" class="form-control">
                                <option value="1">Masuk</option>
                                <option value="2">Keluar</option>
                                <option value="3">Automatically</option>
                            </select>
                     </div>

                     <div class="form-group">
                     <label>Parent Jenis Transaksi</label>
                            <select name="id_parent" class="form-control">
                              <option value="0">Pilih Parent (Optional)</option>
                              <?php foreach ($data_parent as $dp) { ?>
                                <option value="<?php echo $dp->id_parent ?>"><?php echo $dp->nama_parent ?></option>
                              <?php } ?>
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
    <form id="add-row-form" action="<?php echo base_url().'admin/jenis_tb/update'?>" method="post">
       <div class="modal fade" id="ModalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Update Data Jenis Transaksi Bank</h4>
                 </div>
                 <div class="modal-body">

                 <input type="hidden" name="id_jenis_transaksi_bank" class="form-control" required>

                     <div class="form-group">
                     <label>Nama Jenis Transaksi Bank</label>
                         <input type="text" name="kjenis_transaksi_bank" class="form-control" placeholder="Masukan Nama Jenis Transaksi Bank Yang akan diinput" required>
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

   <div id="view_update"></div>

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

    });

    function view_update(id)
    {
      console.log(id);
      $.ajax({
        type : "GET",
        url : "<?php echo base_url() ?>admin/jenis_tb/view_update/"+id,
        cache : false,
        async : false,
        success : function(html){
          $("#view_update").html(html).show();
          $('#modal_update').modal('show');
        }
      })
    }
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
              ajax: {"url": "<?php echo base_url()?>admin/jenis_tb/get_jtb_json", "type": "POST"},
                  columns: [

                        {"data": "kjenis_transaksi_bank"},
                        {"data": "tipe_jenis_transaksi" , render : function(data,type,row){
                            var strStatus = "";
                            if(row.tipe_jenis_transaksi == 1){
                              strStatus = "Masuk";
                            }else if(row.tipe_jenis_transaksi == 2){
                              strStatus = "Keluar";
                            }else if(row.tipe_jenis_transaksi == 3){
                              strStatus = "Automatically";
                            }
                            return strStatus ;
                          }

                        },


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
            var id_jenis_transaksi_bank=$(this).data('id_jenis_transaksi_bank');
            var kjenis_transaksi_bank=$(this).data('kjenis_transaksi_bank');


            $('#ModalUpdate').modal('show');
            $('[name="id_jenis_transaksi_bank"]').val(id_jenis_transaksi_bank);
            $('[name="kjenis_transaksi_bank"]').val(kjenis_transaksi_bank);


      });
      // End Edit Records


  });
</script>
