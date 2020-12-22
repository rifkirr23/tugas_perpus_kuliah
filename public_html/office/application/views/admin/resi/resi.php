<head>
  <meta charset="utf-8">
  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">

</head>

<?php if($this->session->flashdata('msg')=='success'){ ?>

<p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Send Konfirmasi Success
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
</div></p>

<?php } ?>

<?php if($this->session->flashdata('msg')=='deleted'){ ?>

<p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Delete data Success
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
</div></p>

<?php } ?>

<?php if($this->session->flashdata('msg')=='gagal'){ ?>

<p><div style="display: none;" class="alert alert-danger alert-dismissable"><i class="icon fa fa-check"></i>Tidak mempunyai Akses untuk Menghapus :)
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
</div></p>

<?php } ?>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Resi List</b></h3>
      <span class="pull-right">
         <a class="btn btn-primary" id="cek" href="<?php echo site_url();?>admin/resi/cek_resi "><i class="fa fa-hourglass-o">Cek Resi</i></a>
      </span>

    </div>

    <div class="box-body">
    <div class="box-body table-responsive">

    <table class="table table-bordered table-striped no-margin" id="mytable">
      <thead>
        <tr>
          <th>Kode Mark Customer</th>
          <th>Nomor Resi</th>
          <th>Tanggal</th>
          <th>Supplier</th>
          <th>Tel</th>
          <th>Note</th>
          <th>Gudang</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
    </table>

 </div>
 </div>
  <!-- Modal Add Customer-->
 </div>
 </div>

<!-- Form Send Kf -->
 <form id="add-row-form" action="<?php echo base_url().'admin/resi/send_kf'?>" method="post">
    <div class="modal fade" id="ModalSendKf" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Kirim Pesan Konfirmasi?</h4>
              </div>

              <input type="hidden" name="id_resi" class="form-control" required>

              <div class="modal-footer">
                   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                   <button type="submit" id="add-row" class="btn btn-primary">Save</button>
              </div>
           </div>
       </div>
    </div>
 </form>

 <!-- Modal Delete-->
  <form id="add-row-form" action="<?php echo base_url().'admin/resi/delete'?>" method="post">
     <div class="modal fade" id="ModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                   <h4 class="modal-title" id="myModalLabel">Apakah anda yakin menghapus data?</h4>
               </div>
               <div class="modal-body">

               <input type="hidden" name="id_resi" class="form-control" required>

               </div>
               <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="add-row" class="btn btn-primary">Delete</button>
               </div>
            </div>
        </div>
     </div>
 </form>


<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>
<script src="<?php echo base_url() ?>assets/jquery/loadingoverlay.min.js"></script>
<script type="text/javascript">
        $(document).ready(function(){setTimeout(function(){$(".alert").fadeIn('fast');}, 100);});
          //angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
          setTimeout(function(){$(".alert").fadeOut('fast');}, 5000);
</script>
<script type="text/javascript">
$(document).ready(function(){

  $( "#cek" ).click(function() {
  $.LoadingOverlay("show");
  });

        });
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
              
              ajax: {"url": "<?php echo base_url()?>admin/resi/get_resi_json", "type": "POST"},
                  columns: [
                        {"data": "kode"},
                        {"data": "nomor"},
                        {"data": "tanggal"},
                        {"data": "supplier"},
                        {"data": "tel"},
                        {"data": "note"},
                        {"data": "gudang" ,
                          render : function(data,type,row){
                            var strGudang = "";
                            if(row.gudang == 5){
                              strGudang = "Ghuangzhou";
                            }else if(row.gudang == 6){
                              strGudang = "Yiwu";
                            }
                            return strGudang ;
                          }
                        },

                        {"data": "konfirmasi_resi" ,
                          render : function(data,type,row){
                            var strStatus = "";
                            if(row.konfirmasi_resi == 0 ){
                              strStatus = "Belum Terkonfirmasi";
                            }else if(row.konfirmasi_resi == 1){
                              strStatus = "Terkonfirmasi";
                            }
                            else if(row.konfirmasi_resi == 2){
                              strStatus = "Terkonfirmasi & Asuransi";
                            }
                            return strStatus ;
                          }
                        },

                        {"data": "view"},
                  ],
              order: [[1, 'asc']],
          rowCallback: function(row, data, iDisplayIndex) {
              var info = this.fnPagingInfo();
              var page = info.iPage;
              var length = info.iLength;
              $('td:eq(0)', row).html();
              if (data['konfirmasi_resi'] != "0"){
                $('td', row).css('background-color', '#A9F096');//00FF7F
                $('td', row).css('color', 'black');
              }
              else if(data['konfirmasi_resi'] == "0"){
                $('td', row).css('background-color', '#FABAA5');
                $('td', row).css('color', 'black');
              }
          }

      });

      // end setup datatables

      // get Send Kf
      $('#mytable').on('click','.send_konfirmasi',function(){
            var id_resi=$(this).data('id_resi');
            $('#ModalSendKf').modal('show');
            $('[name="id_resi"]').val(id_resi);

      });
      // End Send Kf

      // Delete Resi
      $('#mytable').on('click','.delete_resi',function(){
            var id_resi=$(this).data('id_resi');
            $('#ModalDelete').modal('show');
            $('[name="id_resi"]').val(id_resi);

      });

  });
</script>
