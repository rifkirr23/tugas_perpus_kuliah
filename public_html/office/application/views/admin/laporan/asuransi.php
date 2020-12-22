<head><meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

   <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">

</head>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <?php if($min==0){ ?>
      <h4 class="pull-left"><b>Total Asuransi  <?php echo $tanggal_now ." : Rp.".number_format($total_asuransi) ?></p></b></h4>
      <?php }else if($min!=0){ ?>
      <h4 class="pull-left"><b>Total Asuransi  &nbsp;</h4> <h4><?php echo $tanggal_now ." : Rp.".number_format($total_asuransi) ?></b></h4>
      <?php } ?>
      <form method="post" action="<?php echo base_url('admin/laporan/asuransi_filter') ?>">
        <span class="pull-right" style="margin-right:5px;">
          <input type="submit" name="max" class="form-control btn btn-success" value="Filter Date" placeholder="Max Date"/>
        </span>
        <span class="pull-right" style="margin-right:5px;">
          <input type="date" name="max_date" class="form-control" value="<?php echo $now ?>" placeholder="Max Date"/>
        </span>
        <span class="pull-right" style="margin-right:5px;">
          <input type="date" name="min_date" class="form-control" value="<?php echo $now ?>" placeholder="Min Date"/>
        </span>
      </form>
    </div>
  </div>
</div>

<br/><br/>
<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Laporan Asuransi <?php echo $tanggal_now ?></b></h3>
    </div>
    <div class="box-body">
      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped no-margin" id="mytable">
          <thead>
            <tr>
              <th>Kode Mark Customer</th>
              <th>Resi</th>
              <th>Invoice</th>
              <th>Tanggal Asuransi</th>
              <th>Formula</th>
              <th>Jumlah</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>

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
              ajax: {"url": "<?php echo base_url('admin/laporan/asuransi_json/'.$min.'/'.$max)?>", "type": "POST"},
                  columns: [
                        {"data": "kode"},
                        {"data": "nomor_resi"},
                        {"data": "kode_invoice"},
                        {"data": "tanggal_inv_asuransi"},
                        {"data": "note"},
                        {"data": "jumlah_asuransi", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
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
            var id_transaksi=$(this).data('id_transaksi');
            var id_cust=$(this).data('id_cust');
            var tanggal_transaksi=$(this).data('tanggal_transaksi');
            var jumlah_rmb=$(this).data('jumlah_rmb');
            var status=$(this).data('status');
            var bank_tujuan=$(this).data('bank_tujuan');
            var kode=$(this).data('kode');
            var fee_bank=$(this).data('fee_bank');


            $('#ModalUpdate').modal('show');
            $('[name="id_transaksi"]').val(id_transaksi);
            $('[name="id_cust"]').val(id_cust);
            $('[name="tanggal_transaksi"]').val(tanggal_transaksi);
            $('[name="jumlah_rmb"]').val(jumlah_rmb);
            $('[name="status"]').val(status);
            $('[name="bank_tujuan"]').val(bank_tujuan);
            $('[name="kode"]').val(kode);
            $('[name="fee_bank"]').val(fee_bank);

      });
      // End Edit Records
      // get Hapus Records
      $('#mytable').on('click','.hapus_record',function(){
            var id_cust=$(this).data('id_cust');
            $('#ModalHapus').modal('show');
            $('[name="id_cust"]').val(id_cust);
      });
      // End Hapus Records

       // get Image Records
      $('#mytable').on('click','.image_bank',function(){
            var file_bank_tujuan=$(this).data('file_bank_tujuan');
            var base_url ="<?php echo base_url() ?>"


            $('#bank_image').modal('show');

            $('#bank').html('<img src="'+base_url+'assets/bank_tujuan/'+file_bank_tujuan+'" width="100%" height="400" />');

      });

      $('#mytable').on('click','.image_bukti',function(){
            var bukti_bayar=$(this).data('bukti_bayar');
            var base_url ="<?php echo base_url() ?>"


            $('#bukti_image').modal('show');
            //$('#photoss').html('<img src="'+base_url+'upload/screenshoot/'+ss+'" class="img-responsive">');

            //$('[name="jumlah_rmb"]').val(jumlah_rmb);
            $('#bukti').html('<img src="'+base_url+'assets/bukti_bayar/'+bukti_bayar+'" width="100%" height="400" />');

      });
      // End Image Records

      $('#mytable').on('click','.view_image',function(){
            var id=$(this).data('id_transaksi');
            $.ajax({
      type : "GET",
      url : "<?php echo base_url() ?>admin/transaksi/view_image/"+id,
      cache : false,
      async : false,
      success : function(html){
        $("#view_image").html(html).show();
        $('#modeditbuku').modal('show');
      }
    });

      });
      // End Image Records





  });
</script>
