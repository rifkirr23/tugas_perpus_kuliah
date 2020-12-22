<head>
  <meta charset="utf-8">
  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">

</head>

  <?php $id_cgrup = $this->uri->segment(4); ?>

  <div class="box-header with-border">
    <h3 class="box-title"><b>Customer List</b></h3>
    <span class="pull-right">
    </span>
  </div>

  <div class="box-body">
  <div class="box-body table-responsive">

  <table class="table table-bordered table-striped no-margin" id="mytable">
    <thead>
      <tr>
        <th>Tanggal Daftar</th>
        <th>Fix Alamat</th>
        <th>Kode Mark Customer</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Telepon</th>
        <th>Whatsapp</th>
        <th>Alamat</th>
        <th>Ekspedisi Lokal</th>
        <th>Note</th>
        <th>Deposit</th>
        <th>Pendaftar</th>
        <th>Action</th>
      </tr>
    </thead>
  </table>

</div>
</div>


 <!-- Modal Resend Chat Customer -->
 <form id="add-row-form" action="<?php echo base_url().'admin/customer/resend_chat'?>" method="post" enctype="multipart/form-data">
    <div class="modal fade" id="Modalresend" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Re-send Chat Customer</h4>
              </div>
              <div class="modal-body">
                <div class="form-group">
                <label>Resend Chat Register to Customer ?</label>
                    <input type="hidden" name="id_cust" class="form-control" required>
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

 <!-- Modal Hapus Customer-->
 <form id="add-row-form" action="<?php echo base_url().'admin/customer/refund_deposit'?>" method="post">
     <div class="modal fade" id="ModalRefund" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                   <h4 class="modal-title" id="myModalLabel">Refund Deposit</h4>
               </div>
               <div class="modal-body">
                   <input type="hidden" name="id_cust" class="form-control" required>
                   <div class="form-group">
                       <label>Jumlah</label>
                       <input type="text" name="jumlah_refund" class="form-control" placeholder="Jumlah Refund">
                   </div>
               </div>
               <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="add-row" class="btn btn-primary">Refund</button>
               </div>
            </div>
        </div>
     </div>
 </form>

 <!-- Modal View Image Customer -->
 <!-- <div class="modal fade" id="Modal_view_gambar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
       <div class="modal-content">
           <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <h4 class="modal-title" id="myModalLabel"><span class="judul_modal"></span></h4>
           </div>
           <div class="modal-body">

               <div class="form-group">
               <label>Foto KTP</label>
                   <div id="ktp"> </div>
               </div>
               <div class="form-group">
               <label>Foto SK</label>
                   <div id="fsk"></div>
               </div>

           </div>
           <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" id="add-row" class="btn btn-primary">Update</button>
           </div>
        </div>
    </div>
 </div> -->

  <div id="view_image"></div>
  <div id="edit_customer"></div>

 </div>
</div>


<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/jquery/select2.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>
<script src="<?php echo base_url() ?>assets/jquery/loadingoverlay.min.js"></script>

<script>
$(document).ready(function(){

      $('form').submit(function() {
        $.LoadingOverlay("show");
      });

      $('.itemName').select2({
          placeholder: 'Customer Grup (Optional)',
          minimumInputLength: 1,
          allowClear: true,
          ajax:{
              url: "<?php echo base_url(); ?>admin/customer/select_grup",
              dataType: "json",
              delay: 250,
              data: function(params){
                  return{
                      kode_cgrup: params.term
                  };
              },
              processResults: function(data){
                  var results = [];

                  $.each(data, function(index, item){
                      results.push({
                          id: item.id_cgrup,
                          text: item.kode_cgrup
                      });
                  });
                  return{
                      results: results
                  };
              }
          }
      });

      $('.itemName2').select2({
          placeholder: 'Customer Referal',
          minimumInputLength: 1,
          allowClear: true,
          ajax:{
              url: "<?php echo base_url(); ?>admin/customer/select_customer",
              dataType: "json",
              delay: 250,
              data: function(params){
                  return{
                      id_referal: params.term
                  };
              },
              processResults: function(data){
                  var results = [];

                  $.each(data, function(index, item){
                      results.push({
                          id: item.id_cust,
                          text: item.kode
                      });
                  });
                  return{
                      results: results
                  };
              }
          }
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
            ajax: {"url": "<?php echo base_url('admin/customer/get_customerid_json/'.$id_cgrup)?>", "type": "POST"},
                columns: [
                      {"data": "tanggal_daftar"},
                      {"data": "fix_alamat" ,
                        render : function(data,type,row){
                          var strFix = "";
                          var nf = Intl.NumberFormat();
                          if(row.fix_alamat == 1){
                            strFix = " ✓ fix ";
                          }else{
                            strFix = " - ";
                          }
                          return strFix ;
                        }
                      },
                      {"data": "kode"},
                      {"data": "nama"},
                      {"data": "email"},
                      {"data": "telepon"},
                      {"data": "whatsapp"},
                      {"data": "alamat" },
                      {"data": "ekspedisi_lokal"},
                      {"data": "note"},
                      {"data": "deposit" ,
                        render : function(data,type,row){
                          var strDeposit = "";
                          var nf = Intl.NumberFormat();
                          if(row.deposit <= 0){
                            strDeposit = "No Deposit";
                          }else if(row.deposit >=0){
                            strDeposit = "Rp."+nf.format(row.deposit);
                          }
                          return strDeposit ;
                        }
                      },
                      {"data": "nama_pengguna"},
                      //render harga dengan format angka
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
