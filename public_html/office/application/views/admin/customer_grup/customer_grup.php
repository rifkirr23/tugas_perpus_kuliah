<head>
  <meta charset="utf-8">
  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
</head>

        <?php if($this->session->flashdata('msg')=='success'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Customer Grup Added to Our data
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

        <?php if($this->session->flashdata('msg')=='updated'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Customer Grup data Updated
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

        <?php if($this->session->flashdata('msg')=='notvalid'){ ?>

       <p><div style="display: none;" class="alert alert-danger alert-dismissable"><i class="icon fa fa-check"></i>Kode Mark Tersebut Sudah ada , Silahkan gunakan search untuk melihat data tsb.
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Customer Grup List</b></h3>
      <span class="pull-right">
         <button class="btn btn-primary" data-toggle="modal" data-target="#myModalAdd"><i class="fa fa-plus">Customer Grup</i></button>
      </span>

    </div>

    <div class="box-body">
    <div class="box-body table-responsive">

    <table class="table table-bordered table-striped no-margin" id="mytable">
      <thead>
        <tr>
          <th>Kode Mark</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Telepon</th>
          <th>Whatsapp</th>
          <th>Alamat</th>
          <th>Note</th>
          <th>Deposit</th>
          <th>Action</th>
        </tr>
      </thead>
    </table>

 </div>
 </div>
  <!-- Modal Add Customer Grup-->

    <form id="add-row-form" action="<?php echo base_url().'admin/customer_grup/save'?>" method="post" enctype="multipart/form-data">
       <div class="modal fade" id="myModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Add New Customer Grup</h4>
                 </div>
                 <div class="modal-body">
                     <div class="form-group">
                         <label>Kode Mark</label>
                         <div class="input-group">
                            <span class="input-group-addon" style="background-color:Gainsboro;">GRUP - </span>
                            <input type="text" name="kode_cgrup" class="form-control" placeholder="Kode Grup" required>
                        </div>
                     </div>
                     <div class="form-group">
                         <label>Nama </label>
                         <input type="text" name="nama_cgrup" class="form-control" placeholder="Nama Customer Grup" required>
                     </div>

                     <div class="form-group">
                         <label>Email </label>
                         <input type="email" name="email_cgrup" class="form-control" placeholder="Email Customer Grup" required>
                     </div>

                     <div class="form-group">
                         <label>Telepon </label>
                         <input type="text" name="telepon_cgrup" class="form-control" placeholder="Telepon Customer Grup" required>
                     </div>
                     <div class="form-group">
                         <label>Whatsapp</label>
                         <input type="text" name="whatsapp_cgrup" class="form-control" placeholder="Whatsapp Customer Grup" required>
                     </div>

                     <div class="form-group">
                       <label>Alamat</label>
                         <textarea type="text" name="alamat_cgrup" class="form-control" placeholder="Alamat" required></textarea>
                     </div>

                     <div class="form-group">
                          <label>Noted</label>
                          <textarea type="text" name="note_cgrup" class="form-control" placeholder="Noted"></textarea>
                     </div>

                     <div class="form-group">
                          <label>Foto KTP</label>
                          <input type="file" name="foto_ktpcgrup" class="btn btn-primary">
                     </div>

                     <div class="form-group">
                          <label>Foto SK</label>
                          <input type="file" name="foto_skcgrup" class="btn btn-primary">
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
    <form id="add-row-form" action="<?php echo base_url().'admin/customer_grup/update'?>" method="post" enctype="multipart/form-data">
       <div class="modal fade" id="ModalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Update Data Customer Grup</h4>
                 </div>
                 <div class="modal-body">

                 <input type="hidden" name="id_cgrup" class="form-control" required>

                   <div class="form-group">
                       <label>Kode Mark</label>
                       <input type="text" name="kode_cgrup" class="form-control" placeholder="Kode Mark Customer Grup" readonly>
                   </div>
                   <div class="form-group">
                       <label>Nama </label>
                       <input type="text" name="nama_cgrup" class="form-control" placeholder="Nama Customer Grup" required>
                   </div>

                   <div class="form-group">
                       <label>Email </label>
                       <input type="email" name="email_cgrup" class="form-control" placeholder="Email Customer Grup" required>
                   </div>

                   <div class="form-group">
                       <label>Telepon </label>
                       <input type="text" name="telepon_cgrup" class="form-control" placeholder="Telepon Customer Grup" required>
                   </div>
                   <div class="form-group">
                       <label>Whatsapp</label>
                       <input type="text" name="whatsapp_cgrup" class="form-control" placeholder="Whatsapp Customer Grup" required>
                   </div>

                   <div class="form-group">
                     <label>Alamat</label>
                       <textarea type="text" name="alamat_cgrup" class="form-control" placeholder="Alamat" required></textarea>
                   </div>

                   <div class="form-group">
                        <label>Noted</label>
                        <textarea type="text" name="note_cgrup" class="form-control" placeholder="Noted"></textarea>
                   </div>

                   <div class="form-group">
                       <label>Harga otomatis</label>
                       <input type="checkbox" name="harga_otomatis_grup" value="1">
                   </div>
                   
                   <div class="form-group">
                        <label>Foto KTP</label>
                        <input type="file" name="foto_ktpcgrup" class="btn btn-primary">
                   </div>

                   <div class="form-group">
                        <label>Foto SK</label>
                        <input type="file" name="foto_skcgrup" class="btn btn-primary">
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

   <div id="view_image"></div>

   </div>
   </div>


<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>
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
              ajax: {"url": "<?php echo base_url()?>admin/customer_grup/get_customer_grup_json", "type": "POST"},
                  columns: [
                        {"data": "kode_cgrup"},
                        {"data": "nama_cgrup"},
                        {"data": "email_cgrup"},
                        {"data": "telepon_cgrup"},
                        {"data": "whatsapp_cgrup"},
                        {"data": "alamat_cgrup"},
                        {"data": "note_cgrup"},

                        {"data": "deposit_cgrup" ,
                          render : function(data,type,row){
                            var strDeposit = "";
                            var nf = Intl.NumberFormat();
                            if(row.deposit_cgrup <= 0){
                              strDeposit = "No Deposit";
                            }else if(row.deposit_cgrup >=0){
                              strDeposit = "Rp."+nf.format(row.deposit_cgrup);
                            }
                            return strDeposit ;
                          }
                        },
                        //render harga dengan format angka

                        {"data": "view"},
                  ],
              order: [[1, 'desc']],
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
            var kode_cgrup=$(this).data('kode_cgrup');
            var id_cgrup=$(this).data('id_cgrup');
            var nama_cgrup=$(this).data('nama_cgrup');
            var email_cgrup=$(this).data('email_cgrup');
            var telepon_cgrup=$(this).data('telepon_cgrup');
            var whatsapp_cgrup=$(this).data('whatsapp_cgrup');
            var alamat_cgrup=$(this).data('alamat_cgrup');
            var note_cgrup=$(this).data('note_cgrup');
            var harga_otomatis_grup=$(this).data('harga_otomatis_grup');

            $('#ModalUpdate').modal('show');
            $('[name="kode_cgrup"]').val(kode_cgrup);
            $('[name="id_cgrup"]').val(id_cgrup);
            $('[name="nama_cgrup"]').val(nama_cgrup);
            $('[name="email_cgrup"]').val(email_cgrup);
            $('[name="telepon_cgrup"]').val(telepon_cgrup);
            $('[name="whatsapp_cgrup"]').val(whatsapp_cgrup);
            $('[name="alamat_cgrup"]').val(alamat_cgrup);
            $('[name="note_cgrup"]').val(note_cgrup);
            if(harga_otomatis_grup == 1){
              $('[name="harga_otomatis_grup"]').attr("checked", true);
            }
      });
      // End Edit Records
      // get Hapus Records
      $('#mytable').on('click','.hapus_record',function(){
            var id_cust=$(this).data('id_cust');
            $('#ModalHapus').modal('show');
            $('[name="id_cust"]').val(id_cust);
      });

  });
</script>

<script type="text/javascript">
  function view_image(id)
  {
    console.log(id);
    $.ajax({
      type : "GET",
      url : "<?php echo base_url() ?>admin/customer_grup/view_image/"+id,
      cache : false,
      async : false,
      success : function(html){
        $("#view_image").html(html).show();
        $('#modvm').modal('show');
      }
    })
  }
</script>
