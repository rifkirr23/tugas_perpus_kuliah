<head>
  <meta charset="utf-8">
  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
  <link href="<?php echo base_url().'assets/jquery/select2.min.css'?>" rel="stylesheet" />
</head>

        <?php if($this->session->flashdata('msg')=='invoiceok'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Proses Invoice Success
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

        <?php if($this->session->flashdata('msg')=='depositok'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Proses Invoice dengan deposit Success
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

        <?php if($this->session->flashdata('msg')=='success'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Email Send
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Invoice Lainnya</b></h3>
      <span class="pull-right">
        <a class="btn btn-danger" href="<?php base_url(); ?>sendmail/semua_invoice_lainnya"><i class="fa fa-mail"> Kirim Invoice Global</i></a>
        <button class="btn btn-primary" data-toggle="modal" data-target="#myModalAdd"><i class="fa fa-plus"> Invoice</i></button>
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
             <th>Total Potongan</th>
             <th>Status</th>
             <th>Tanggal Kirim</th>
             <th>Action</th>
           </tr>
         </thead>
       </table>
    </div>
   </div>

   <!-- Modal Add Invoice -->
   <form id="add-row-form" action="<?php echo base_url().'admin/invoice_lainnya/save'?>" method="post" enctype="multipart/form-data">
      <div class="modal fade" id="myModalAdd" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add New Invoice</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group" id="customer_input">
                    <label>Kode Mark Customer</label>
                        <select name="id_cust" class="itemName form-control" style="width:100%;"></select>
                    </div>

                    <!-- <div class="form-group">
                      <label>Vendor</label>
                      <select name="id_vendor" class="itemName2 form-control" style="width:100%;">
                        <?php foreach ($vendor as $ven) { ?>
                          <option value="<?php echo $ven->id_vendor ?>"><?php echo $ven->nama_vendor ?></option>
                        <?php } ?>
                      </select>
                    </div> -->

                    <div class="form-group">
                      <label>Kategori</label>
                      <select name="id_kategori_il" class="kategori form-control" style="width:100%;">
                        <?php foreach ($kategori as $ktgr) { ?>
                          <option value="<?php echo $ktgr->id_kategori_il ?>"><?php echo $ktgr->nama_kategori_il ?></option>
                        <?php } ?>
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

  <form action="<?php echo base_url().'admin/invoice_lainnya/simpan_proses'?>" method="post" id="add-row-form" class="">
     <div class="modal fade" id="lunas_invoice"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                   <h4 class="modal-title" id="myModalLabel">Proses Invoice</h4>
               </div>
               <div class="modal-body">
                        <div id="text_inv"></div>
                        <input type="hidden" name="id_invoice" class="form-control" required>
                        <input type="hidden" name="kode_invoice" class="form-control" required>


                        <br/>
                        <div class="form-group" id="bank">
                          <label>Bank</label>
                          <select name="id_bank" class="form-control" style="width: 100%;">
                            <?php foreach ($bank as $rowbank){ ?>
                                <option value="<?php echo $rowbank->id_bank ?>"><?php echo $rowbank->nama_bank ?></option>
                            <?php } ?>
                          </select>
                        </div>
               </div>
               <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="yes" class="btn btn-success">Yes</button>
               </div>
            </div>
        </div>
     </div>
 </form>


  <form id="add-row-form" action="<?php echo base_url().'admin/invoice_lainnya/simpan_deposit'?>" method="post">
     <div class="modal fade" id="deposit_invoice"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="overflow:hidden;">
        <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                   <h4 class="modal-title" id="myModalLabel">Proses Invoice With Deposit</h4>
               </div>
               <div class="modal-body">

                        <div id="jml_deposit"></div>
                        <br/>
                        <div id="deposit_inv"></div>
                        <input type="hidden" name="id_invoice" class="form-control" required>
                        <input type="hidden" name="kode_invoice" class="form-control" required>

                         <br/>
                        <div class="form-group" id="bank">
                          <label>Jenis Potongan</label>
                          <select name="id_jenis_potongan" class="itemName form-control" style="width: 100%;" required></select>
                        </div>

                        <div class="form-group">
                           <label>Keterangan Potongan</label>
                           <textarea type="text" name="keterangan_potongan" placeholder="Keterangan " class="form-control"></textarea>
                        </div>

                       <p><br/></p>


               </div>
               <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="yes1" class="btn btn-success">Yes</button>
               </div>
            </div>
        </div>
     </div>
 </form>

 <div id="bayar_deposit"></div>

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
    $(document).ready(function(){
      $( '.uang' ).mask('000.000.000.000', {reverse: true});
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
                          id: item.kode,
                          text: item.kode
                      });
                  });
                  return{
                      results: results
                  };
              }
           }
       });

       $('.itemName2').select2({});
       $('.kategori').select2({});
});
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
              ajax: {"url": "<?php echo base_url()?>admin/invoice_lainnya/get_invoice_json", "type": "POST"},
                  columns: [
                        {"data": "kode"},
                        {"data": "kode_invoice"},
                        {"data": "tanggal_invoice"},
                        {"data": "total_tagihan", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                        {"data": "jumlah_bayar", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                        {"data": "total_potongan", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                        {"data": "status_invoice" ,
                          render : function(data,type,row){
                            var strStatus = "";
                            if(row.status_invoice == 0){
                              strStatus = "Belum Lunas";
                            }else if(row.status_invoice == 1){
                              strStatus = "Lunas";
                            }
                            return strStatus ;
                          }
                        },
                        {"data": "tanggal_kirim"},
                        {"data": "view"}
                  ],
              order: [[1, 'desc']],
          rowCallback: function(row, data, iDisplayIndex) {
              var info = this.fnPagingInfo();
              var page = info.iPage;
              var length = info.iLength;
              $('td:eq(0)', row).html();

              if (data['status_invoice'] == "1"){
                $('td', row).css('background-color', '#A9F096');//00FF7F
                $('td', row).css('color', 'black');
              }

              else if(data['status_invoice'] != "1"){
                $('td', row).css('background-color', '#FABAA5');
                $('td', row).css('color', 'black');
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

<script type="text/javascript">
  function bayar_deposit(id)
  {
    console.log(id);
    $.ajax({
      type : "GET",
      url : "<?php echo base_url() ?>admin/invoice_lainnya/bayar_deposit/"+id,
      cache : false,
      async : false,
      success : function(html){
        $("#bayar_deposit").html(html).show();
        $('#Modalbayar_deposit').modal('show');
      }
    })
  }
</script>
