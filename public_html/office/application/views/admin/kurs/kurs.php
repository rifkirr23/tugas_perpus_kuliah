<head><meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
</head>

            <?php if($this->session->flashdata('msg')=='success'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Input Kurs Success
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

        <?php if($this->session->flashdata('msg')=='updated'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Kurs data Updated
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Data Kurs </b></h3>
      <span class="pull-right">
          <?php if($jumlah_kurs > 0){ }else{ ?>
        <button class="btn btn-primary" data-toggle="modal" data-target="#myModalAdd"><i class="fa fa-plus"></i></button>
          <?php } ?>
      </span>
    </div>

    <div class="box-body">
    <div class="box-body table-responsive">

    <table class="table table-bordered table-striped no-margin" id="mytable">
      <thead>
        <tr>

          <th>Kurs Jual</th>
          <th>Kurs Beli</th>
          <th>Fee Cs</th>
          <th>Kurs Klaim</th>

          <th>Action</th>
        </tr>
      </thead>
    </table>

  <!-- Modal Add Customer-->
    <form id="add-row-form" action="<?php echo base_url().'admin/kurs/save'?>" method="post">
       <div class="modal fade" id="myModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Form Input Kurs</h4>
                 </div>
                 <div class="modal-body">
                     <div class="form-group">
                     <label>Kurs Jual</label>
                         <input type="text" name="kurs_jual" class="uang form-control" placeholder="Kurs Jual" required>
                     </div>
                     <div class="form-group">
                     <label>Kurs Beli</label>
                         <input type="text" name="kurs_beli" class="uang form-control" placeholder="Kurs Beli" required>
                     </div>
                     <div class="form-group">
                     <label>Kurs Klaim</label>
                         <input type="text" name="kurs_klaim" class="uang form-control" placeholder="Kurs Klaim" required>
                     </div>
                     <div class="form-group">
                     <label>Fee CS</label>
                         <input type="text" name="fee_cs" class="uang form-control" placeholder="Fee Cs" required>
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
    <form id="add-row-form" action="<?php echo base_url().'admin/kurs/update'?>" method="post">
       <div class="modal fade" id="ModalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Update Kurs</h4>
                 </div>
                 <div class="modal-body">

                 <input type="hidden" name="id_kurs" class="form-control" required>

                     <div class="form-group">
                     <label>Kurs Jual</label>
                         <input type="text" name="kurs_jual" class="uang form-control" placeholder="Kurs Jual" required>
                     </div>
                     <div class="form-group">
                     <label>Kurs Beli</label>
                         <input type="text" name="kurs_beli" class="uang form-control" placeholder="Kurs Beli" required>
                     </div>
                     <div class="form-group">
                     <label>Kurs Klaim</label>
                         <input type="text" name="kurs_klaim" class="uang form-control" placeholder="Kurs Klaim" required>
                     </div>
                     <div class="form-group">
                     <label>Fee CS</label>
                         <input type="text" name="fee_cs" class="uang form-control" placeholder="Fee Cs" required>
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
              ajax: {"url": "<?php echo base_url()?>/admin/kurs/get_kurs_json", "type": "POST"},
                  columns: [

                        {"data": "kurs_jual", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                        {"data": "kurs_beli",  render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                        {"data": "fee_cs",  render: $.fn.dataTable.render.number(',', '.','','¥ ')},
                        {"data": "kurs_klaim",  render: $.fn.dataTable.render.number(',', '.','','Rp. ')},

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
            var id_kurs=$(this).data('id_kurs');
            var kurs_jual=$(this).data('kurs_jual');
            var kurs_beli=$(this).data('kurs_beli');
            var kurs_klaim=$(this).data('kurs_klaim');
            var fee_cs=$(this).data('fee_cs');


            $('#ModalUpdate').modal('show');
            $('[name="id_kurs"]').val(id_kurs);
            $('[name="kurs_jual"]').val(kurs_jual);
            $('[name="kurs_beli"]').val(kurs_beli);
            $('[name="kurs_klaim"]').val(kurs_klaim);
            $('[name="fee_cs"]').val(fee_cs);

      });
      // End Edit Records


  });
</script>
