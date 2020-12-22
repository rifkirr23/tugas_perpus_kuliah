<head>
  <meta charset="utf-8">
  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">

</head>

<?php if($this->session->flashdata('msg')=='uploadok'){ ?>

<p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Berhasil Upload China
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
</div></p>

<?php } ?>

<?php if($this->session->flashdata('msg')=='deleteplok'){ ?>

<p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Berhasil Delete Pl
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
</div></p>

<?php } ?>

<?php if($this->session->flashdata('msg')=='oketolak'){ ?>

<p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Berhasil Kirim Pesan Ke Customer
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
</div></p>

<?php } ?>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Invoice Packing List Resi</b></h3>
      <span class="pull-right"></span>

    </div>

    <div class="box-body">
    <div class="box-body table-responsive">

    <table class="table table-bordered table-striped no-margin" id="mytable">
      <thead>
        <tr>
          <th>Tanggal Upload</th>
          <th>Nomor Resi</th>
          <th>Kode</th>
          <th> Keterangan </th>
          <th> Status </th>
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
<form id="add-row-form" action="<?php echo base_url().'admin/resi/upload_to_china'?>" method="post">
   <div class="modal fade" id="Modal_upload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                 <h4 class="modal-title" id="myModalLabel">Upload Invoice & Packing List To China</h4>
             </div>
             <div class="modal-body">

               <input type="hidden" name="encrypt_resi" class="form-control" required>

             </div>
             <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" id="add-row" class="btn btn-primary">Upload</button>
             </div>
          </div>
      </div>
   </div>
</form>

<form id="add-row-form" action="<?php echo base_url().'admin/resi/upload_resi_to_china'?>" method="post">
   <div class="modal fade" id="Modal_addresi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                 <h4 class="modal-title" id="myModalLabel">Add Resi & Upload Invoice Packing List To China</h4>
             </div>
             <div class="modal-body">

               <input type="hidden" name="nomor_resi" class="form-control" required>

             </div>
             <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" id="add-row" class="btn btn-primary">Upload</button>
             </div>
          </div>
      </div>
   </div>
</form>

<form id="add-row-form" action="<?php echo base_url().'admin/resi/savepesan_tolak'?>" method="post">
   <div class="modal fade" id="Modal_tolak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                 <h4 class="modal-title" id="myModalLabel">Pesan ke Customer</h4>
             </div>
             <div class="modal-body">

               <input type="hidden" name="encrypt_resi" class="form-control" required>
               <input type="hidden" name="kode" class="form-control" required>
               <textarea name="pesan_tolak" rows="8" class="form-control" cols="50" id="pesan_tolak"></textarea>

             </div>
             <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" id="add-row" class="btn btn-primary">Upload</button>
             </div>
          </div>
      </div>
   </div>
</form>

<form id="add-row-form" action="<?php echo base_url().'admin/resi/savepesan_tolakresi'?>" method="post">
   <div class="modal fade" id="Modal_tolak_resi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                 <h4 class="modal-title" id="myModalLabel">Pesan ke Customer</h4>
             </div>
             <div class="modal-body">

               <input type="hidden" name="nomor_resi" class="form-control" required>
               <input type="hidden" name="kode" class="form-control" required>
               <textarea name="pesan_tolak" rows="8" class="form-control" cols="50" id="pesan_tolak"></textarea>

             </div>
             <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" id="add-row" class="btn btn-primary">Upload</button>
             </div>
          </div>
      </div>
   </div>
</form>

 <div id="view_packing"></div>


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

              ajax: {"url": "<?php echo base_url()?>admin/resi/get_pl_json", "type": "POST"},
                  columns: [
                        {"data": "tanggal_upload"},
                        {"data": "nomor_resi"},
                        {"data": "req_kode"},
                        {"data": "krequest"},
                        {"data": "status_proses" ,
                          render : function(data,type,row){
                            var strStatus = "";
                            if(row.status_proses == 0){
                              strStatus = "Belum Proses";
                            }else if(row.status_proses == 1){
                              strStatus = "Selesai";
                            }else if(row.status_proses == 2){
                              strStatus = "Cancel";
                            }else if(row.status_proses == 4){
                              strStatus = "Selesai Request";
                            }
                            return strStatus ;
                          }
                        },
                        {"data": "view"},
                  ],
              order: [[0, 'asc']],
          rowCallback: function(row, data, iDisplayIndex) {
              var info = this.fnPagingInfo();
              var page = info.iPage;
              var length = info.iLength;
              $('td:eq(0)', row).html();
              if(data['id_request_resi'] > "0" && data['encrypt_resi'] == null && data['status_proses'] == "0"){
                $('td', row).css('background-color', '#87CEFA');//00FF7F
                $('td', row).css('color', 'black');
              }
              else if(data['status_proses'] == "1"){
                $('td', row).css('background-color', '#A9F096');//00FF7F
                $('td', row).css('color', 'black');
              }
              else if(data['status_proses'] == "0"){
                $('td', row).css('background-color', 'white');
                $('td', row).css('color', 'black');
              }
              else if(data['status_proses'] == "2" || data['status_proses'] == "4"){
                $('td', row).css('background-color', '#FABAA5');
                $('td', row).css('color', 'black');
              }
          }

      });
        // table.fnSort( [[0,"asc"], [3,"desc"]]);
      // end setup datatables

      // Delete Resi
      $('#mytable').on('click','.upload_pl',function(){
            var encrypt_resi=$(this).data('encrypt_resi');
            $('#Modal_upload').modal('show');
            $('[name="encrypt_resi"]').val(encrypt_resi);
      });

      $('#mytable').on('click','.add_resi',function(){
            var nomor_resi=$(this).data('nomor_resi');
            $('#Modal_addresi').modal('show');
            $('[name="nomor_resi"]').val(nomor_resi);
      });

      $('#mytable').on('click','.tolak_resi',function(){
            var nomor_resi=$(this).data('nomor_resi');
            var kode=$(this).data('kode');
            var pesan_tolak=$(this).data('pesan_tolak');
            $('#Modal_tolak_resi').modal('show');
            $('[name="pesan_tolak"]').val(pesan_tolak);
            $('[name="nomor_resi"]').val(nomor_resi);
            $('[name="kode"]').val(kode);
      });

      $('#mytable').on('click','.tolak_pl',function(){
            var encrypt_resi=$(this).data('encrypt_resi');
            var kode=$(this).data('kode');
            var pesan_tolak=$(this).data('pesan_tolak');
            $('#Modal_tolak').modal('show');
            $('[name="pesan_tolak"]').val(pesan_tolak);
            $('[name="encrypt_resi"]').val(encrypt_resi);
            $('[name="kode"]').val(kode);
      });


  });
</script>

<script type="text/javascript">
  function view_packing(id)
  {
    console.log(id);
    $.ajax({
      type : "GET",
      url : "<?php echo base_url() ?>admin/resi/view_packing/"+id,
      cache : false,
      async : false,
      success : function(html){
        $("#view_packing").html(html).show();
        $('#modpacking').modal('show');
      }
    })
  }
</script>
