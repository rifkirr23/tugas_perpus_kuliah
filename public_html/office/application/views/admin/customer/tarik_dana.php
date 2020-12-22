<head><meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
</head>

            <?php if($this->session->flashdata('msg')=='oktarik'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Tarik Dana Berhasil
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

        <?php if($this->session->flashdata('msg')=='gagalrefund'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Gagal Tarik
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

        <?php if($this->session->flashdata('msg')=='completed'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>data completed
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>List Tarik Dana</b></h3>
    </div>

    <div class="box-body">
    <div class="box-body table-responsive">

    <table class="table table-bordered table-striped no-margin" id="mytable">
      <thead>
        <tr>
          <th>Tanggal Pengajuan</th>
          <th>Kode Marking</th>
          <th>Jumlah</th>
          <th>Bank</th>
          <th>No Rekening</th>
          <th>AN</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
    </table>

    <form id="add-row-form" action="<?php echo base_url().'admin/customer/accept_tarik_dana'?>" method="post" enctype="multipart/form-data">
       <div class="modal fade" id="Modal_tarikdana" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Tarik Dana Customer</h4>
                 </div>
                 <div class="modal-body">
                   <div class="form-group">
                   <label>Accept Tarik Dana?</label>
                       <input type="hidden" name="id_tarik_dana" class="form-control" required>
                   </div>
                 </div>
                 <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" id="add-row" class="btn btn-primary">Send</button>
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
      // table.fnSort( [[4,"asc"], [2,"desc"]]);
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
              ajax: {"url": "<?php echo base_url()?>/admin/customer/get_tarikdana_json", "type": "POST"},
                  columns: [

                        {"data": "tanggal_pengajuan"},
                        {"data": "kode"},
                        {"data": "nominal"},
                        {"data": "rekening"},
                        {"data": "no_rek"},
                        {"data": "an"},
                        // {"data": "nominal"},
                        {"data": "status" ,
                          render : function(data,type,row){
                            var strStatus = "";
                            if(row.status == 2){
                              strStatus = "Selesai";
                            }else{
                              strStatus = "Belum Selesai";
                            }
                            return strStatus ;
                          }
                        },
                        {"data": "view"}
                  ],
              order: [[2, 'desc']],
          rowCallback: function(row, data, iDisplayIndex) {
              var info = this.fnPagingInfo();
              var page = info.iPage;
              var length = info.iLength;
              $('td:eq(0)', row).html();
          }

      });
      // table.fnSort( [[4,"asc"], [2,"desc"]]);
      // end setup datatables
      // get Edit Records
      $('#mytable').on('click','.tarikd',function(){
            var id_tarik_dana=$(this).data('id_tarik_dana');

            $('#Modal_tarikdana').modal('show');
            $('[name="id_tarik_dana"]').val(id_tarik_dana);

      });
      // End Edit Records



  });
</script>
