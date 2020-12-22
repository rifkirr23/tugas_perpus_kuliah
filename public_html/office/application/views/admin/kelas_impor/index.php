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
      <h3 class="box-title"><b>List Pendaftaran Kelas Impor </b></h3>
      <span class="pull-right"><button class="btn btn-primary" data-toggle="modal" data-target="#myModalAdd"><i class="fa fa-plus"> Daftar</i></button></span>
    </div>

    <div class="box-body">
    <div class="box-body table-responsive">

    <table class="table table-bordered table-striped no-margin" id="mytable">
      <thead>
        <tr>
          <th>Tanggal_daftar</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Telepon</th>
          <th>Paket</th>
          <th>Harga</th>
          <th>Action</th>
        </tr>
      </thead>
    </table>

  <!-- Modal Add Customer-->

    <form id="add-row-form" action="<?php echo base_url().'admin/kelas_impor/save_admin'?>" method="post">
       <div class="modal fade" id="myModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Daftar Kelas Impor</h4>
                 </div>
                 <div class="modal-body">
                     <div class="form-group">
                       <label>Nama Lengkap</label>
                       <input type="text" name="nama_pengguna" class="form-control" placeholder="Nama Pengguna" required>
                     </div>
                     <div class="form-group">
                       <label>Email </label>
                       <input type="text" name="username" class="form-control" placeholder="Username" required>
                     </div>
                     <div class="form-group">
                       <label>Telepon</label>
                       <input type="password" name="password" class="form-control" placeholder="Password" required>
                     </div>
                     <div class="form-group">
                       <label>Paket Kelas Impor</label>
                       <select class="form-control" name="paket_member">
                         <option value="1">(Rp. 4.000.000) 3 Tahun</option>
                         <option value="2">(Rp. 4.000.000) 1 Tahun</option>
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
    <form id="add-row-form" action="<?php echo base_url().'admin/kelas_impor/proses_konfirmasi'?>" method="post">
       <div class="modal fade" id="ModalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Konfirmasi Pembayaran </h4>
                 </div>
                   <input type="hidden" name="id_daftar_kelas_impor" class="form-control" required>
                 <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" id="add-row" class="btn btn-primary">Konfirmasi</button>
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
              ajax: {"url": "<?php echo base_url()?>/admin/kelas_impor/get_kelas_impor_json", "type": "POST"},
                  columns: [

                        {"data": "tgl_daftar"},
                        {"data": "nama_lengkap"},
                        {"data": "customer_email"},
                        {"data": "customer_phone"},
                        {"data": "paket_member" ,
                          render : function(data,type,row){
                            var strStatus = "";
                            if(row.paket_member == 1){
                              strStatus = "Promo 3 Tahun";
                            }else if(row.paket_member == 2){
                              strStatus = "Promo 1 Tahun";
                            }
                            return strStatus ;
                          }
                        },
                        {"data": "harga_member", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                        //render harga dengan format angka

                        {"data": "view"}
                  ],
              order: [[0, 'desc']],
          rowCallback: function(row, data, iDisplayIndex) {
              var info = this.fnPagingInfo();
              var page = info.iPage;
              var length = info.iLength;
              $('td:eq(0)', row).html();

              if (data['s_konfirmasi'] == "1"){
                $('td', row).css('background-color', '#A9F096');//00FF7F
                $('td', row).css('color', 'black');
              }
          }

      });
      // end setup datatables
      // get Edit Records
      $('#mytable').on('click','.proses_konfirmasi',function(){
            var id_daftar_kelas_impor=$(this).data('id_daftar_kelas_impor');

            $('#ModalUpdate').modal('show');
            $('[name="id_daftar_kelas_impor"]').val(id_daftar_kelas_impor);

      });
      // End Edit Records


  });
</script>
