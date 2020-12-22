<head>
  <meta charset="utf-8">
  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
  <link href="<?php echo base_url().'assets/jquery/select2.min.css'?>" rel="stylesheet" />
</head>

        <?php if($this->session->flashdata('msg')=='success'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Transaksi Success
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

        <?php if($this->session->flashdata('msg')=='update'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Proses Invoice dengan deposit Success
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Pengeluaran</b></h3>
      <span class="pull-right">
        <button class="btn btn-primary" data-toggle="modal" data-target="#myModalAdd2"><i class="fa fa-plus"> Transaksi</i></button>
      </span>
    </div>
    <div class="box-body">
      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped no-margin" id="mytable">
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>Bank</th>
              <th>Jumlah</th>
              <th>Transaksi</th>
              <th>Jenis Transaksi</th>
              <th>Keterangan</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- Form Transaksi -->
<form id="add-row-form" action="<?php echo base_url().'admin/pengeluaran/save_pengeluaran'?>" method="post" enctype="multipart/form-data">
   <div class="modal fade" id="myModalAdd2" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true" style="overflow:hidden;">
      <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                 <h4 class="modal-title" id="myModalLabel">Transaksi Dana Keluar</h4>
             </div>
             <div class="modal-body">

                <input type="hidden" name="tipe" class="form-control" value="keluar" required>

                <div class="form-group">
                <label>Bank</label>
                  <select name="id_bank" class="form-control" style="width: 100%;">
                    <?php foreach ($bank as $rowbank){ ?>
                        <option value="<?php echo $rowbank->id_bank ?>"><?php echo $rowbank->nama_bank ?></option>
                    <?php } ?>
                  </select>
                </div>

                 <div class="form-group">
                 <label>Jenis Transaksi</label>
                     <select name="kode" class="itemName form-control" style="width: 100%;" id="jenis_transaksi_keluar" required>
                       <?php foreach ($jenis_transaksi_keluar as $jtk) { ?>
                         <option value="<?php echo $jtk->id_jenis_transaksi_bank ?>"><?php echo $jtk->kjenis_transaksi_bank ?></option>
                       <?php } ?>
                     </select>
                 </div>

                 <div class="form-group">
                 <label>Jumlah</label>
                     <input type="text" name="nominal_transaksi_bank" class="uang form-control" placeholder="Nominal Transaksi" required>
                 </div>

                 <div class="form-group" id="kurs_rmb" style="display:none;">
                 <label>Kurs Beli Rmb (optional)</label>
                     <input type="number" name="kurs_trmb" class="form-control" placeholder="Nominal Transaksi" value="0" required>
                 </div>

                 <div class="form-group">
                 <label>Keterangan Transaksi</label>
                     <Textarea type="text" name="keterangan_transaksi_bank" class="form-control" placeholder="Keterangan Transaksi"></Textarea>
                 </div>

                 <div class="form-group">
                 <label>Tanggal Transaksi</label>
                     <input type="date" name="tanggal_transaksi_bank" value="<?php echo date('Y-m-d') ?>" class="form-control" required>
                 </div>

                 <div class="form-group">
                   <label>Bukti Transaksi</label>
                   <div class="control-group" id="fields">
                      <div class="controls">
                          <div class="entry input-group col-xs-3">
                            <input class="btn btn-primary" name="bukti_transaksi[]" type="file">
                            <span class="input-group-btn">
                              <button class="btn btn-success btn-add" type="button">
                                <span class="glyphicon glyphicon-plus"></span>
                              </button>
                            </span>
                          </div>
                       </div>
                    </div>
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
<!-- End Form -->

<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/jquery/select2.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>
<script src="<?php echo base_url() ?>assets/jquery/loadingoverlay.min.js"></script>

<script>
    $("#jenis_transaksi_keluar").change(function(){ // Ketika user mengganti atau memilih Customer
      if($("#jenis_transaksi_keluar").val()==3){
          $("#master_bank").hide();
          $("#kurs_rmb").show();
      }else{
        $("#kurs_rmb").hide();
        $("#master_bank").hide();
      }
    });
    $(document).ready(function(){

                $('form').submit(function() {
                  $.LoadingOverlay("show");
                });

                $('.itemName2').select2({
                placeholder: 'Bank',
                minimumInputLength: 1,
                allowClear: true,
                ajax:{
                    url: "<?php echo base_url(); ?>admin/bank/select_bank",
                    dataType: "json",
                    delay: 250,
                    data: function(params){
                        return{
                            id_bank: params.term
                        };
                    },
                    processResults: function(data){
                        var results = [];

                        $.each(data, function(index, item){
                            results.push({
                                id: item.id_bank,
                                text: item.nama_bank
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
        $(document).ready(function(){
          setTimeout(function(){$(".alert").fadeIn('fast');}, 100);});
          //angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
          setTimeout(function(){$(".alert").fadeOut('fast');}, 5000);
</script>

<script type="text/javascript">
  $('.submitt').on('click', function(){
         $.LoadingOverlay("show");
          //console.log('wtheck');
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
              "scrollY":        "400px",
              "scrollCollapse": false,
              scrollX: true,
              processing: true,
              serverSide: true,
              ajax: {"url": "<?php echo base_url()?>admin/pengeluaran/get_pengeluaran_json", "type": "POST"},
                  columns: [
                        {"data": "tanggal_transaksi_bank"},
                        {"data": "nama_bank"},
                        {"data": "nominal_transaksi_bank", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                        {"data": "tipe_transaksi_bank"},
                        {"data": "kjenis_transaksi_bank"},
                        {"data": "keterangan_transaksi_bank"}
                  ],
              order: [[3, 'desc']],
          rowCallback: function(row, data, iDisplayIndex) {
              var info = this.fnPagingInfo();
              var page = info.iPage;
              var length = info.iLength;
              $('td:eq(0)', row).html();
          }

      });

      //lunas Inv
      $('#mytable').on('click','.lunas_inv',function(){
            var id_invoice=$(this).data('id_invoice');
            var kode_invoice=$(this).data('kode_invoice');
            var total_tagihan=$(this).data('total_tagihan');
            var status_invoice=$(this).data('status_invoice');
            var total_potongan=$(this).data('total_potongan');
            var jumlah_bayar=$(this).data('jumlah_bayar');
            var deposit=$(this).data('deposit');
            var kode=$(this).data('kode');

            var hasil = (parseInt(total_tagihan)) - (parseInt(total_potongan) + parseInt(jumlah_bayar));
            var thasil= String(hasil).replace(/(.)(?=(\d{3})+$)/g,'$1,')
            var tdeposit = String(deposit).replace(/(.)(?=(\d{3})+$)/g,'$1,');

            if(status_invoice==0){
                    $('#text_inv').html('<h5>Proses Invoice <i>'+kode_invoice+'</i> sebesar Rp. '+thasil+' ?</h5>');
                    $("#yes").show();
                    $("#bank").show();
            }else{
                    $('#text_inv').html('<h5>Invoice Telah Lunas</b></i> </h5>');
                    $("#yes").hide();
                     $("#bank").hide();
            }

            $('#lunas_invoice').modal('show');
            //$('#photoss').html('<img src="'+base_url+'upload/screenshoot/'+ss+'" class="img-responsive">');

            $('[name="id_invoice"]').val(id_invoice);
            $('[name="kode_invoice"]').val(kode_invoice);
            $('[name="total_tagihan"]').val(total_tagihan);
            $('[name="id_cust"]').val(id_cust);
            $('[name="encrypt_invoice"]').val(encrypt_invoice);

            $('[name="email"]').val(email);

      });

       // end Lunas Inv

       //Deposit Inv
       $('#mytable').on('click','.deposit_inv',function(){
            var id_invoice=$(this).data('id_invoice');
            var kode_invoice=$(this).data('kode_invoice');
            var total_tagihan=$(this).data('total_tagihan');
            var status_invoice=$(this).data('status_invoice');
            var total_potongan=$(this).data('total_potongan');
            var jumlah_bayar=$(this).data('jumlah_bayar');
            var deposit=$(this).data('deposit');
            var kode=$(this).data('kode');

            var hasil = (parseInt(total_tagihan)) - (parseInt(total_potongan) + parseInt(jumlah_bayar));
            var thasil= String(hasil).replace(/(.)(?=(\d{3})+$)/g,'$1,')
            var tdeposit = String(deposit).replace(/(.)(?=(\d{3})+$)/g,'$1,');
            // "1,234,567,890"
            //console.log(thasil);

            $('#jml_deposit').html('<h5>Jumlah Deposit '+kode+'</i> : Rp.  '+tdeposit+'</h5>');

          if(status_invoice==0){
              if(deposit<=0){
                $('#deposit_inv').html('<h5>Deposit Tidak Mencukupi</b></i> </h5>');
                $("#yes1").hide();
              }else if(deposit>=0){
                $('#deposit_inv').html('<h5>Proses Invoice <i>'+kode_invoice+'</i> sebesar Rp. '+thasil+' ?</h5>');
                $("#yes1").show();
              }
          }else if(status_invoice==1){
              $('#deposit_inv').html('<h5>Invoice Telah Lunas</b></i> </h5>');
              $("#yes1").hide();
          }



            $('#deposit_invoice').modal('show');
            //$('#photoss').html('<img src="'+base_url+'upload/screenshoot/'+ss+'" class="img-responsive">');

            $('[name="id_invoice"]').val(id_invoice);
            $('[name="kode_invoice"]').val(kode_invoice);
            $('[name="total_tagihan"]').val(total_tagihan);
            $('[name="deposit"]').val(deposit);

      });
            //End Deposit

  });
</script>
<script type="text/javascript">
  $(function()
{
    $(document).on('click', '.btn-add', function(e)
    {
        e.preventDefault();

        var controlForm = $('.controls:first'),
            currentEntry = $(this).parents('.entry:first'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);

        newEntry.find('input').val('');
        controlForm.find('.entry:not(:last) .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="glyphicon glyphicon-minus"></span>');
    }).on('click', '.btn-remove', function(e)
    {
      $(this).parents('.entry:first').remove();

        e.preventDefault();
        return false;
    });
});
</script>
