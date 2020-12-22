<head>
  <meta charset="utf-8">
  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
  <link href="<?php echo base_url().'assets/jquery/select2.min.css'?>" rel="stylesheet" />
</head>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Resi Udara List</b></h3>
      <span class="pull-right">
           <a class="btn btn-primary" data-toggle="modal" data-target="#myModalAdd"><i class="fa fa-plus"> Resi</i></a>
      </span>
    </div>
    <div class="box-body">
      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped no-margin" id="mytable">
          <thead>
            <tr>
              <th>Kode Mark</th>
              <th>Nomor</th>
              <th>Invoice</th>
              <th>Tanggal</th>
              <th>Ctns</th>
              <th>Berat</th>
              <th>Harga Jual</th>
              <th>Harga Beli</th>
              <th>Harga Jual Goni</th>
              <th>Harga Beli Goni</th>
              <th>Action</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
    <!-- Modal Add Resi-->
    <form id="add-row-form" action="<?php echo base_url().'admin/resi_udara/save'?>" method="post" enctype="multipart/form-data">
       <div class="modal fade" id="myModalAdd" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Add New Resi</h4>
                 </div>
                 <div class="modal-body">

                     <div class="form-group" id="customer_input">
                         <label>Kode Mark Customer</label>
                         <select name="kode" class="itemName form-control" id="customer" style="width:100%;" required></select>
                     </div>

                     <div class="form-group">
                         <label>Nomor Resi</label>
                         <input name="nomor_resi" class="form-control" value="<?php echo $nomor_resi ?>" placeholder="Nomor Resi" type="text" readonly>
                     </div>

                     <div class="form-group">
                         <label>Nama Barang</label>
                         <input name="nama_barang" class="form-control" placeholder="Nama Barang / Deskripsi Barang" type="text">
                     </div>

                     <div class="form-group">
                         <label>Ctns</label>
                         <input name="ctns" placeholder="Ctns" class="form-control" type="text">
                     </div>

                     <div class="form-group">
                         <label>Berat</label>
                         <input name="berat" placeholder="Berat" type="text" class="form-control">
                     </div>

                     <div class="form-group">
                         <label>Tanggal Resi</label>
                         <input name="tanggal_resi" type="date" value="<?php echo date('Y-m-d') ?>" class="form-control">
                     </div>

                     <div class="form-group">
                         <label>Harga Jual</label>
                         <input name="harga_jual" id="harga_juals" type="text" placeholder="Harga Jual" class="form-control">
                     </div>

                     <div class="form-group">
                         <label>Harga Beli</label>
                         <input name="harga_beli" type="text" placeholder="Harga Beli" class="form-control">
                     </div>

                     <div class="form-group">
                         <label>Harga Jual Goni</label>
                         <input name="harga_jual_goni" type="text" placeholder="Harga Jual Goni" value="22000" class="form-control">
                     </div>

                     <div class="form-group">
                         <label>Harga Beli Goni</label>
                         <input name="harga_beli_goni" type="text" placeholder="Harga Beli Goni" class="form-control">
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

   <!-- Modal Update Resi Udara-->
    <form id="add-row-form" action="<?php echo base_url().'admin/resi_udara/update'?>" method="post" enctype="multipart/form-data">
       <div class="modal fade" id="ModalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Update Data Resi Udara</h4>
                 </div>
                 <div class="modal-body">

                 <input type="hidden" name="id_resi_udara" class="form-control" required>

                 <div class="form-group">
                     <label>Nomor Resi</label>
                     <input name="nomor_resi" class="form-control" value="<?php echo $nomor_resi ?>" placeholder="Nomor Resi" type="text" readonly>
                 </div>

                 <div class="form-group">
                     <label>Nama Barang</label>
                     <input name="nama_barang" class="form-control" placeholder="Nama Barang / Deskripsi Barang" type="text">
                 </div>

                 <div class="form-group">
                     <label>Ctns</label>
                     <input name="ctns" placeholder="Ctns" class="form-control" type="text">
                 </div>

                 <div class="form-group">
                     <label>Berat</label>
                     <input name="berat" placeholder="Berat" type="text" class="form-control">
                 </div>

                 <div class="form-group">
                     <label>Tanggal Resi</label>
                     <input name="tanggal_resi" type="date" value="<?php echo date('Y-m-d') ?>" class="form-control">
                 </div>

                 <div class="form-group">
                     <label>Harga Jual</label>
                     <input name="harga_jual" type="text" placeholder="Harga Jual" class="form-control">
                 </div>

                 <div class="form-group">
                     <label>Harga Beli</label>
                     <input name="harga_beli" type="text" placeholder="Harga Beli" class="form-control">
                 </div>

                 <div class="form-group">
                     <label>Harga Jual Goni</label>
                     <input name="harga_jual_goni" type="text" placeholder="Harga Jual Goni" value="22000" class="form-control">
                 </div>

                 <div class="form-group">
                     <label>Harga Beli Goni</label>
                     <input name="harga_beli_goni" type="text" placeholder="Harga Beli Goni" class="form-control">
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

  </div>
</div>


<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/jquery/select2.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>
<script src="<?php echo base_url() ?>assets/jquery/loadingoverlay.min.js"></script>
<script src="<?php echo base_url().'assets/jquery/jquery.mask.min.js'?>"?>></script>

<script type="text/javascript">
$(document).ready(function(){

  $( "#cek" ).click(function() {
  $.LoadingOverlay("show");
  });

});
</script>
<script type="text/javascript">
    $(document).ready(function(){
      $('.itemName').select2({
          placeholder: 'Masukkan Kode Mark Customer',
          minimumInputLength: 1,
          allowClear: true,
          ajax:{
              url: "<?php echo base_url(); ?>admin/transaksi/select_customer",
              dataType: "json",
              delay: 250,
              data: function(params){
                  return{
                      kode: params.term
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
});
</script>
<script type="text/javascript">
$("#customer").change(function(){ // Ketika user mengganti atau memilih Customer
  $.ajax({
    type: "POST", // Method pengiriman data bisa dengan GET atau POST
    url: "<?php echo base_url("index.php/admin/resi_udara/get_harga"); ?>", // Isi dengan url/path file php yang dituju
    data: {id_cust : $("#customer").val()}, // data yang akan dikirim ke file yang dituju
    dataType: "json",
    beforeSend: function(e) {
      if(e && e.overrideMimeType) {
        e.overrideMimeType("application/json;charset=UTF-8");
      }
    },
    success: function(response){ // Ketika proses pengiriman berhasil
      //$("#loading").hide(500); // Sembunyikan loadingnya

      // set isi dari combobox kota
      // lalu munculkan kembali combobox kotanya
      console.log(response.harga_udara);
      $("#harga_juals").val(response.harga_udara);
    },
    error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
      alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
    }
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
              ajax: {"url": "<?php echo base_url()?>admin/resi_udara/get_resi_json", "type": "POST"},
                  columns: [
                        {"data": "kode"},
                        {"data": "nomor_resi"},
                        {"data": "kode_invoice"},
                        {"data": "tanggal_resi"},
                        {"data": "ctns"},
                        {"data": "berat"},
                        {"data": "harga_jual", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                        {"data": "harga_beli", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                        {"data": "harga_jual_goni", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                        {"data": "harga_beli_goni", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                        {"data": "view"},
                  ],
              order: [[3, 'asc']],
          rowCallback: function(row, data, iDisplayIndex) {
              var info = this.fnPagingInfo();
              var page = info.iPage;
              var length = info.iLength;
              $('td:eq(0)', row).html();
              if (data['id_invoice'] != "0"){
                $('td', row).css('background-color', '#A9F096');//00FF7F
                $('td', row).css('color', 'black');
              }
              else if(data['id_invoice'] == "0"){
                $('td', row).css('background-color', '#FABAA5');
                $('td', row).css('color', 'black');
              }
          }

      });
      // end setup datatables
      // get Edit Records
      $('#mytable').on('click','.edit_record',function(){
            console.log(id_resi_udara);
            var id_resi_udara=$(this).data('id_resi_udara');
            var nama_barang=$(this).data('nama_barang');
            var ctns=$(this).data('ctns');
            var berat=$(this).data('berat');
            var harga_jual=$(this).data('harga_jual');
            var harga_beli=$(this).data('harga_beli');
            var harga_jual_goni=$(this).data('harga_jual_goni');
            var harga_beli_goni=$(this).data('harga_beli_goni');
            var tanggal_resi=$(this).data('tanggal_resi');


            $('#ModalUpdate').modal('show');
            $('[name="id_resi_udara"]').val(id_resi_udara);
            $('[name="nama_barang"]').val(nama_barang);
            $('[name="ctns"]').val(ctns);
            $('[name="berat"]').val(berat);
            $('[name="harga_jual"]').val(harga_jual);
            $('[name="harga_beli"]').val(harga_beli);
            $('[name="harga_jual_goni"]').val(harga_jual_goni);
            $('[name="harga_beli_goni"]').val(harga_beli_goni);
            $('[name="tanggal_resi"]').val(tanggal_resi);
      });
      // End Edit Records
      // get Hapus Records
      $('#mytable').on('click','.hapus_record',function(){
            var id_cust=$(this).data('id_cust');
            $('#ModalHapus').modal('show');
            $('[name="id_cust"]').val(id_cust);
      });
      // End Hapus Records

  });
</script>
