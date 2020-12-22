<head><meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
  <link href="<?php echo base_url().'assets/jquery/select2.min.css'?>" rel="stylesheet" />
</head>

            <?php if($this->session->flashdata('msg')=='success'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Input Jenis barang Baru Success
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

        <?php if($this->session->flashdata('msg')=='updated'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Jenis barang Updated
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Data Jenis barang Customer</b></h3>
      <span class="pull-right">

        <button class="btn btn-primary" data-toggle="modal" data-target="#myModalAdd"><i class="fa fa-plus">Jenis barang</i></button>

      </span>
    </div>

    <div class="box-body">
    <div class="box-body table-responsive">

    <table class="table table-bordered table-striped no-margin" id="mytable">
      <thead>
        <tr>
          <th>Kode Mark</th>
          <th>Nama</th>
          <th>Nama Lain</th>
          <th>Harga</th>
          <th>Action</th>
        </tr>
      </thead>
    </table>

  <!-- Modal Add Customer-->

    <form id="add-row-form" action="<?php echo base_url().'admin/jenis_barang_customer/save'?>" method="post">
       <div class="modal fade" id="myModalAdd" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Input Jenis barang Customer Baru</h4>
                 </div>
                 <div class="modal-body">

                   <div class="form-group">
                   <label>Customer</label>
                       <select name="id_cust" class="itemName form-control" style="width: 100%;" required></select>
                   </div>
                   <div class="form-group">
                     <label>Jenis Barang</label>
                     <select name="id_jenis_barang" class="jenis_barang form-control" style="width: 100%;" required>
                       <?php foreach ($jenis_barang as $jb){ ?>
                         <option value="<?php echo $jb->id ?>"><?php echo $jb->nama ?></option>
                       <?php } ?>
                     </select>
                   </div>
                   <div class="form-group">
                     <label>Harga</label>
                     <input type="text" name="harga" class="form-control" placeholder="Masukan Harga" required>
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
    <form id="add-row-form" action="<?php echo base_url().'admin/jenis_barang_customer/update'?>" method="post">
       <div class="modal fade" id="ModalUpdate" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Update Data Jenis barang</h4>
                 </div>
                 <div class="modal-body">

                 <input type="hidden" name="id_jenis_barang_customer" class="form-control" required>

                 <div class="form-group">
                 <label>Customer</label>
                     <select name="id_cust" class="itemName2 form-control" style="width: 100%;"></select>
                 </div>
                 <div class="form-group">
                   <label>Jenis Barang</label>
                   <select name="id_jenis_barang" class="jenis_barangs form-control" style="width: 100%;" required>
                     <?php foreach ($jenis_barang as $jb){ ?>
                       <option value="<?php echo $jb->id ?>"><?php echo $jb->nama ?></option>
                     <?php } ?>
                   </select>
                 </div>
                 <div class="form-group">
                   <label>Harga</label>
                   <input type="text" name="harga" class="form-control" placeholder="Masukan Harga" required>
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
<script src="<?php echo base_url().'assets/jquery/select2.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>
<script src="<?php echo base_url().'assets/jquery/jquery.mask.min.js'?>"?>></script>
<script src="<?php echo base_url() ?>assets/jquery/loadingoverlay.min.js"></script>

<script>
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

          $('.itemName2').select2({
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

          $('.jenis_barang').select2({});

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
              ajax: {"url": "<?php echo base_url()?>admin/jenis_barang_customer/get_jbc_json", "type": "POST"},
                  columns: [
                        {"data": "kode"},
                        {"data": "nama"},
                        {"data": "namalain"},
                        {"data": "harga", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                        {"data": "view"}
                  ],

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
            var id_jenis_barang_customer=$(this).data('id_jenis_barang_customer');
            var id_cust=$(this).data('id_cust');
            var namalain=$(this).data('namalain');
            var harga=$(this).data('harga');
            var nama=$(this).data('nama');
            var id_jenis_barang=$(this).data('id_jenis_barang');
            // console.log(id_jenis_barang);
            $('#ModalUpdate').modal('show');
            $('[name="id_jenis_barang_customer"]').val(id_jenis_barang_customer);
            $('[name="nama"]').val(nama);
            $('[name="namalain"]').val(namalain);
            $('[name="harga"]').val(harga);
            $('[name="id_cust"]').val(id_cust);
            $('[name="id_jenis_barang"]').val(id_jenis_barang);

      });
      // End Edit Records

  });
</script>
