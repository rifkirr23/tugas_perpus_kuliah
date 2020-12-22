<head>
   <meta charset="utf-8">
   <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>" />
   <link href="<?php echo base_url().'assets/jquery/select2.min.css'?>" rel="stylesheet" />
</head>

    <?php if($this->session->flashdata('msg')=='success'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Customer Added to Our data
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

    <?php }else if($this->session->flashdata('msg')=='updated'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Customer data Updated
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

    <?php } else if($this->session->flashdata('msg')=='notvalid'){ ?>

       <p><div style="display: none;" class="alert alert-danger alert-dismissable"><i class="icon fa fa-check"></i>Kode Mark Tersebut Sudah ada , Silahkan gunakan search untuk melihat data tsb.
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

    <?php } else if($this->session->flashdata('msg')=='okresend'){ ?>

      <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Resend Chat Success
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
     </div></p>

    <?php } else if($this->session->flashdata('msg')=='refund'){ ?>

      <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Refund Success
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
     </div></p>

   <?php } else if($this->session->flashdata('msg')=='buatakun'){ ?>

     <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Akun Berhasil dibuat
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    </div></p>

 <?php } else if($this->session->flashdata('msg')=='newpw'){ ?>

   <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Berhasil Membuat Password Baru
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  </div></p>
 <?php } else if($this->session->flashdata('msg')=='pushcust'){ ?>

  <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Berhasil Push Customer to China
     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  </div></p>

 <?php } ?>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Customer List</b></h3>
      <span class="pull-right">
          <!-- <button class="btn btn-primary" data-toggle="modal" data-target="#myModalAdd"><i class="fa fa-plus">Customer</i></button> -->
      </span>
    </div>

    <div class="box-body">
    <div class="box-body table-responsive">

    <table class="table table-bordered table-striped no-margin" id="mytable">
      <thead>
        <tr>
          <tr>
            <th>Nama</th>
            <th>Kode Marking</th>
            <th>Alamat</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
      </thead>
    </table>

 </div>
 </div>


   </div>
  </div>


<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/jquery/select2.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>
<script src="<?php echo base_url() ?>assets/jquery/loadingoverlay.min.js"></script>

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
              ajax: {"url": "<?php echo base_url()?>admin/customer/get_tidakfix_json", "type": "POST"},
                  columns: [
                        {"data": "nama"},
                        {"data": "kode"},
                        {"data": "alamat"},
                        {"data": "email"},
                        {"data": "view"},
                  ],
              order: [[0, 'desc']],
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
            var fix_alamat=$(this).data('fix_alamat');
            if(fix_alamat == 1){
              $('input[type="checkbox"]').attr("checked", "checked");
            }

            var id_cust=$(this).data('id_cust');
            var nama=$(this).data('nama');
            var email=$(this).data('email');
            var telepon=$(this).data('telepon');
            var whatsapp=$(this).data('whatsapp');
            var alamat=$(this).data('alamat');
            var note=$(this).data('note');
            var harga_udara=$(this).data('harga_udara');
            var nama_penerima=$(this).data('nama_penerima');

            $('#ModalUpdate').modal('show');
            // $('[name="fix_alamat"]').val(fix_alamat);
            $('[name="id_cust"]').val(id_cust);
            $('[name="nama"]').val(nama);
            $('[name="email"]').val(email);
            $('[name="telepon"]').val(telepon);
            $('[name="whatsapp"]').val(whatsapp);
            $('[name="alamat"]').val(alamat);
            $('[name="note"]').val(note);
            $('[name="harga_udara"]').val(harga_udara);
            $('[name="nama_penerima"]').val(nama_penerima);
      });
      // End Edit Records

      // Resend Records
      $('#mytable').on('click','.resend_chat',function(){
            var id_cust=$(this).data('id_cust');

            $('#Modalresend').modal('show');
            $('[name="id_cust"]').val(id_cust);
      });
      // End Resend Records
      // get Hapus Records
      $('#mytable').on('click','.refund_deposit',function(){
            var id_cust=$(this).data('id_cust');
            $('#ModalRefund').modal('show');
            $('[name="id_cust"]').val(id_cust);
      });

      $('#mytable').on('click','.setor_deposit',function(){
            var id_cust=$(this).data('id_cust');
            $('#ModalSetor').modal('show');
            $('[name="id_cust"]').val(id_cust);
      });

      $('#mytable').on('click','.delete_customer',function(){
            var id_cust=$(this).data('id_cust');
            $('#ModalDelete').modal('show');
            $('[name="id_cust"]').val(id_cust);
      });

      $('#mytable').on('click','.push_customer',function(){
            var id_cust=$(this).data('id_cust');
            $('#ModalPush').modal('show');
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
      url : "<?php echo base_url() ?>admin/customer/view_image/"+id,
      cache : false,
      async : false,
      success : function(html){
        $("#view_image").html(html).show();
        $('#modvm').modal('show');
      }
    })
  }
</script>

<script type="text/javascript">
  function edit_customer(id)
  {
    console.log(id);
    $.ajax({
      type : "GET",
      url : "<?php echo base_url() ?>admin/customer/edit_customer/"+id,
      cache : false,
      async : false,
      success : function(html){
        $("#edit_customer").html(html).show();
        $('#ModalUpdate').modal('show');
      }
    })
  }
</script>

<script type="text/javascript">
  function akun_customer(id)
  {
    console.log(id);
    $.ajax({
      type : "GET",
      url : "<?php echo base_url() ?>admin/customer/akun_customer/"+id,
      cache : false,
      async : false,
      success : function(html){
        $("#akun_customer").html(html).show();
        $('#ModalAkun').modal('show');
      }
    })
  }
</script>
