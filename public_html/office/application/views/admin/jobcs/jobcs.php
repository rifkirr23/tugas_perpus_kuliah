<head><meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
</head>

            <?php if($this->session->flashdata('msg')=='success'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Input Success
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

        <?php if($this->session->flashdata('msg')=='updated'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>data Updated
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
      <h3 class="box-title"><b>List Job Cs</b></h3>
      <span class="pull-right">
        <button class="btn btn-primary" data-toggle="modal" data-target="#myModalAdd"><i class="fa fa-plus"> list </i></button>
      </span>
    </div>

    <div class="box-body">
    <div class="box-body table-responsive">

    <table class="table table-bordered table-striped no-margin" id="mytable">
      <thead>
        <tr>

          <th>Pertanyaan</th>
          <th>Jawaban</th>
          <th>Tanggal</th>
          <th>Peminta</th>
          <th>Masalah</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
    </table>

  <!-- Modal Add Customer-->
    <form id="add-row-form" action="<?php echo base_url().'admin/jobcs/save'?>" method="post">
       <div class="modal fade" id="myModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Form Input jobcs</h4>
                 </div>
                 <div class="modal-body">
                     <div class="form-group">
                     <label>Pertanyaan</label>
                         <input type="text" name="pertanyaan" class="form-control" placeholder="Pertanyaan" required>
                     </div>
                     <div class="form-group">
                     <label>Jawaban</label>
                         <input type="text" name="jawaban" class="form-control" placeholder="Jawaban">
                     </div>
                     <div class="form-group">
                         <label>Master Masalah</label>
                         <select class="form-control" name="id_masalah">
                           <?php foreach ($master_masalah as $mm): ?>
                             <option value="<?php echo $mm->id_masalah ?>"><?php echo $mm->keterangan_masalah ?></option>
                           <?php endforeach; ?>
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
    <form id="add-row-form" action="<?php echo base_url().'admin/jobcs/update'?>" method="post">
       <div class="modal fade" id="ModalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Update jobcs</h4>
                 </div>
                 <div class="modal-body">

                 <input type="hidden" name="id_job" class="form-control" required>

                   <div class="form-group">
                   <label>Pertanyaan</label>
                       <input type="text" name="pertanyaan" class="form-control" placeholder="Pertanyaan" required>
                   </div>
                   <div class="form-group">
                   <label>Jawaban</label>
                       <input type="text" name="jawaban" class="form-control" placeholder="Jawaban">
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

   <form id="add-row-form" action="<?php echo base_url().'admin/jobcs/complete'?>" method="post">
      <div class="modal fade" id="ModalComplete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Complete jobcs</h4>
                </div>
                <input type="hidden" name="id_job" class="form-control" required>
                <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                     <button type="submit" id="completebtn" class="btn btn-primary">Complete</button>
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
              ajax: {"url": "<?php echo base_url()?>/admin/jobcs/get_jobcs_json", "type": "POST"},
                  columns: [

                        {"data": "pertanyaan"},
                        {"data": "jawaban"},
                        {"data": "tanggal"},
                        {"data": "nama_pengguna"},
                        {"data": "keterangan_masalah"},
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
              // order: [[2, 'desc']],
          rowCallback: function(row, data, iDisplayIndex) {
              var info = this.fnPagingInfo();
              var page = info.iPage;
              var length = info.iLength;
              $('td:eq(0)', row).html();
          }

      });
      table.fnSort( [[5,"asc"], [2,"desc"]]);
      // end setup datatables
      // get Edit Records
      $('#mytable').on('click','.edit_record',function(){
            var id_job=$(this).data('id_job');
            var pertanyaan=$(this).data('pertanyaan');
            var jawaban=$(this).data('jawaban');
            var status=$(this).data('status');


            $('#ModalUpdate').modal('show');
            $('[name="id_job"]').val(id_job);
            $('[name="pertanyaan"]').val(pertanyaan);
            $('[name="jawaban"]').val(jawaban);
            $('[name="status"]').val(status);

      });
      // End Edit Records

      // get Complete Records
      $('#mytable').on('click','.complete_record',function(){
            var id_job=$(this).data('id_job');
            var status=$(this).data('status');
            if(status == 2){
                $('#completebtn').hide();
            }

            $('#ModalComplete').modal('show');
            $('[name="id_job"]').val(id_job);

      });
      // End Complete Records


  });
</script>
