  <head>
    <meta charset="utf-8">
    <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">

  </head>

  <?php if($this->session->flashdata('msg')=='invoiceok'){ ?>

  <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Proses Invoice Success
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  </div></p>

  <?php } ?>

  <?php $idvendor = $this->uri->segment(4); ?>
  <?php if($idvendor == 4) {?>
  <div class="row">
    <div class="col-lg-4">
      <!-- small box -->
      <div class="small-box bg-blue">
        <div class="inner">
          <h3><?php echo "Rp." . number_format($hitung->jumlah_hitung_wilopo) ?></h3>

          <p>Total Tagihan</p>
        </div>
        <div class="icon">
          <i>WC</i>
        </div>
        <a href="#" class="small-box-footer">Wilopo Cargo</a>
      </div>
    </div>
    <div class="col-lg-4">
      <!-- small box -->
      <div class="small-box bg-blue">
        <div class="inner">
          <h3><?php echo "Rp." . number_format($hitung->jumlah_hitung_vendor) ?></h3>

          <p>Total Tagihan</p>
        </div>
        <div class="icon">
          <i>RTS</i>
        </div>
        <a href="#" class="small-box-footer">by Wilopo Cargo</a>
      </div>
    </div>

    <div class="col-lg-4">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3><?php echo "Rp." . number_format($invrts) ?></h3>

          <p>Total Tagihan</p>
        </div>
        <div class="icon">
          <i>RTS</i>
        </div>
        <a href="#" class="small-box-footer">Live RTS</a>
      </div>
    </div>

  </div>

  <div class="row">

    <div class="col-md-2">
      <!-- small box -->
      <div class="small-box bg-blue">
        <div class="inner">
          <h3><?php echo $jumlah_rowwc; ?></h3>
          <p>Jumlah Invoice</p>
        </div>
        <a href="#" class="small-box-footer">Wilopo Cargo</a>
      </div>
    </div>

    <div class="col-md-2">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3><?php echo $jumlah_rowrts; ?></h3>

          <p>Jumlah Invoice </p>
        </div>
        <a href="#" class="small-box-footer">Live Rts</a>
      </div>
    </div>

  </div>

<?php } ?>

  <div class="row">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"><b>Invoice Beli</b></h3>
        <span class="pull-right">
          <?php if($idvendor == 4) {?>
            <a href="<?php echo site_url() ?>admin/vendor/detail_beda/4/invoice" class="btn btn-danger">
              List Beda Hitungan <sup style="background-color:rgb(9, 128, 188);"><b> &nbsp; <?php echo $cek_inv; ?> &nbsp;&nbsp; </b></sup>
            </a>
          <?php } ?>
        </span>
      </div>

  <div class="box-body">
    <div class="box-body table-responsive">
      <table class="table table-bordered table-striped no-margin" id="mytable">
        <thead>
          <tr>
            <th>Kode Mark Customer</th>
            <th>Kode Invoice</th>
            <th>Tanggal Invoice</th>
            <th>Total Tagihan</th>
            <th>Jumlah Bayar</th>
            <th>Jumlah dari Vendor</th>
            <!-- <th>Jumlah RTS</th> -->
            <th>Note</th>
            <th>Status</th>
            <th>Act</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>


 <script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
 <script src="<?php echo base_url().'assets/jquery/select2.min.js'?>"></script>
 <script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
 <script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>
 <script src="<?php echo base_url() ?>assets/jquery/loadingoverlay.min.js"></script>
 <script src="<?php echo base_url().'assets/jquery/jquery.mask.min.js'?>"?>></script>

 <script type="text/javascript">
         $(document).ready(function(){setTimeout(function(){$(".alert").fadeIn('fast');}, 100);});
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
               "scrollCollapse": false,
               scrollX: true,
               processing: true,
               serverSide: true,
               ajax: {"url": "<?php echo base_url('admin/vendor/get_invoice_beli_json/'.$idvendor)?>", "type": "POST"},
                   columns: [
                         {"data": "kode"},
                         {"data": "kode_invoice_beli"},
                         {"data": "tanggal_invoice_beli"},
                         {"data": "jumlah_invoice_beli", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                         {"data": "jumlah_bayar_invoice_beli", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                         {"data": "jumlah_dari_vendor", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                         // {"data": "jumlah", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                         {"data": "note_invoice_beli"},
                         {"data": "status_invoice_beli" ,
                           render : function(data,type,row){
                             var strStatus = "";
                             if(row.status_invoice_beli == 1){
                               strStatus = "Belum Lunas";
                             }else if(row.status_invoice_beli == 2){
                               strStatus = "Lunas";
                             }
                             return strStatus ;
                           }
                         },
                        {"data": "detail_invoice_beli"}
                   ],
               order: [[1, 'desc']],
           rowCallback: function(row, data, iDisplayIndex) {
               var info = this.fnPagingInfo();
               var page = info.iPage;
               var length = info.iLength;
               $('td:eq(0)', row).html();

               if (data['id_vendor'] == "4"){
                 if ((data['jumlah_invoice_beli'] == data['jumlah_dari_vendor']) && data['status_invoice_beli'] == 2){
                   $('td', row).css('background-color', '#A9F096');//00FF7F
                   $('td', row).css('color', 'black');
                 }else if(data['jumlah_invoice_beli'] != data['jumlah_dari_vendor']){
                   $('td', row).css('background-color', '#FABAA5');
                   $('td', row).css('color', 'black');
                 }else if((data['jumlah_invoice_beli'] == data['jumlah_dari_vendor']) && data['status_invoice_beli'] != 2){
                   $('td', row).css('background-color', '#F9DF9C');
                   $('td', row).css('color', 'black');
                 }
               }else{
                 if (data['status_invoice_beli'] == 2){
                   $('td', row).css('background-color', '#A9F096');//00FF7F
                   $('td', row).css('color', 'black');
                 }else if(data['status_invoice_beli'] == 1){
                   $('td', row).css('background-color', '#FABAA5');
                   $('td', row).css('color', 'black');
                 }
               }
           }

       });
       // end setup datatables

      //lunas Inv
       $('#mytable').on('click','.lunas_inv',function(){
             var id_invoice=$(this).data('id_invoice');
             var kode_invoice=$(this).data('kode_invoice');
             var total_tagihan=$(this).data('total_tagihan');
             var status_invoice=$(this).data('status_invoice');
             var total_potongan=$(this).data('total_potongan');
             var jumlah_bayar=$(this).data('jumlah_bayar');

             var hasil = (parseInt(total_tagihan)) - (parseInt(total_potongan) + parseInt(jumlah_bayar));
             var thasil= String(hasil).replace(/(.)(?=(\d{3})+$)/g,'$1,')

             if(status_invoice==0){
                     $('#text_inv').html('<h5>Proses Invoice <i>'+kode_invoice+'</i> sebesar Rp. '+thasil+' ?</h5>');
                     $("#yes").show();
             }else{
                     $('#text_inv').html('<h5>Invoice Telah Lunas</b></i> </h5>');
                     $("#yes").hide();
                      $("#bank").hide();
             }

             $('#lunas_invoice').modal('show');
             //$('#photoss').html('<img src="'+base_url+'upload/screenshoot/'+ss+'" class="img-responsive">');

             $('[name="id_invoice"]').val(id_invoice);
             $('[name="kode_invoice"]').val(kode_invoice);
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
             var total_rmb=$(this).data('total_rmb');

             var hasil = (parseInt(total_tagihan)) - (parseInt(total_potongan) + parseInt(jumlah_bayar));
             var thasil= String(hasil).replace(/(.)(?=(\d{3})+$)/g,'$1,')
             var tdeposit = String(deposit).replace(/(.)(?=(\d{3})+$)/g,'$1,');


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

       });
             //End Deposit

   });

 </script>
