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
      <h3 class="box-title"><b>Invoice Titip Transfer List</b></h3>
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
              <th>Action</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- Form Proses Invoice -->
<form id="add-row-form" class="" action="<?php echo base_url().'admin/invoice/proses_invoice'?>" method="post">
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
                      <input type="hidden" name="total_tagihan" class="form-control" required>

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
<!-- Form Invoice Dengan Deposit -->
<form id="add-row-form" action="<?php echo base_url().'admin/invoice/deposit_invoice'?>" method="post">
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
                      <input type="hidden" name="total_tagihan" class="form-control" required>
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
<script>
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
              ajax: {"url": "<?php echo base_url()?>admin/invoice/get_invoice_json", "type": "POST"},
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
  function bayar_deposit(id)
  {
    console.log(id);
    $.ajax({
      type : "GET",
      url : "<?php echo base_url() ?>admin/invoice/bayar_deposit/"+id,
      cache : false,
      async : false,
      success : function(html){
        $("#bayar_deposit").html(html).show();
        $('#Modalbayar_deposit').modal('show');
      }
    })
  }
</script>
