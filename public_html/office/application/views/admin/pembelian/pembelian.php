<head>
  <meta charset="utf-8">
   <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
   <link href="<?php echo base_url().'assets/jquery/select2.min.css'?>" rel="stylesheet" />
</head>

<?php if($this->session->flashdata('msg')=='updated'){ ?>

<p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Status Pembelian Successfully PAid
 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
</div></p>

<?php } ?>

<?php if($this->session->flashdata('msg')=='okkurs'){ ?>

<p><div style="display: none;" class="alert alert-success alert-dismissable"><i class="icon fa fa-check"></i>Update Kurs Berhasil
 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
</div></p>

<?php } ?>

<?php if($this->session->flashdata('msg')=='nokurs'){ ?>

<p><div style="display: none;" class="alert alert-danger alert-dismissable"><i class="icon fa fa-check"></i>Update Kurs Tidak Berhasil
 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
</div></p>

<?php } ?>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Pembelian List</b></h3>
      <span class="pull-right">

        <button class="btn btn-primary" data-toggle="modal" data-target="#myModalKurs"><i class="fa">¥ Update Kurs Beli</i></button>
        <button class="btn btn-danger" data-toggle="modal" data-target="#myModalLunasi"><i class="fa fa-money"> Lunasi Pembelian</i></button>

      </span>
    </div>

    <div class="box-body table-responsive">

    <table class="table table-bordered table-striped no-margin" id="mytable">
      <thead>
        <tr>
          <th>Kode Pembelian</th>
          <th>Kode Transaksi</th>
          <th>Keterangan</th>
          <th>Jumlah Rmb</th>
          <th>Total Pembelian</th>
          <th>Tanggal</th>
          <th>Status</th>
          <th>Action</th>

        </tr>
      </thead>
    </table>

    </div>
  </div>
</div>

  <!-- Modal Update Kurs-->
    <form id="add-row-form" action="<?php echo base_url().'admin/pembelian/update_kurs_beli'?>" method="post" enctype="multipart/form-data">
       <div class="modal fade" id="myModalKurs" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Update Kurs Beli Pembelian</h4>
                 </div>
                 <div class="modal-body">

                     <div class="form-group">
                         <label>Kurs Beli </label>
                         <input type="number" name="kurs_beli" class="form-control" placeholder="Kurs Beli" required>
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

   <!-- Modal Update Kurs-->
     <form id="add-row-form" action="<?php echo base_url().'admin/pembelian/lunasi_pembelian'?>" method="post" enctype="multipart/form-data">
        <div class="modal fade" id="myModalLunasi" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
           <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">Lunasi Pembelian</h4>
                  </div>
                  <div class="modal-body">

                      <div class="form-group">
                          <label>Total Semua Pembelian : <b>Rp.<?php echo number_format($total_semua_pembelian); ?></b> </label>
                      </div>

                      <div class="form-group">
                        <label>Bank</label>
                        <select name="id_bank" class="itemName2 form-control" style="width: 100%;" required></select>
                      </div>

                  </div>
                  <div class="modal-footer">
                       <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                       <?php if($total_semua_pembelian > 0){ ?>
                         <button type="submit" id="add-row" class="btn btn-primary">Lunasi</button>
                       <?php } ?>
                  </div>
               </div>
           </div>
        </div>
    </form>

    <form id="add-row-form" action="<?php echo base_url().'admin/pembelian/paid_pembelian'?>" method="post" enctype="multipart/form-data">
       <div class="modal fade" id="pembelian_paid"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel"> <div id="judul"></div> </h4>
                 </div>
                 <div class="modal-body">
                    <div id="text_pembelian"></div>
                    <input type="hidden" name="id_pembelian" class="form-control" required>
                    <input type="hidden" name="kode_pembelian" class="form-control" required>
                    <input type="hidden" name="id_transaksi" class="form-control" required>
                    <br/>
                    <div class="form-group">
                       <label>Upload Bukti Bayar Rmb</label>
                       <div class="control-group" id="fields1">
                           <div class="controls1">
                               <div class="entry1 input-group col-xs-3">
                                 <input class="btn btn-primary" name="file_bb_rmb[]" type="file">
                                 <span class="input-group-btn">
                                 <button class="btn btn-success btn-add1" type="button">
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
                      <button type="submit" id="yes1" class="btn btn-success">Yes</button>
                 </div>
              </div>
          </div>
       </div>
   </form>

   <form id="add-row-form" action="<?php echo base_url().'admin/pembelian/lunasi_satu'?>" method="post" enctype="multipart/form-data">
      <div class="modal fade" id="lunasi_satu"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"> <div id="judul_satu"></div> </h4>
                </div>
                <input type="hidden" name="id_transaksi">
                <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                     <button type="submit" id="yes1" class="btn btn-info">Yes</button>
                </div>
             </div>
         </div>
      </div>
  </form>

   <div id="view_image"></div>
   <div id="edit_kurs_beli"></div>

<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>

<script>
  $(document).ready(function(){
      //select2
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
              ajax: {"url": "<?php echo base_url()?>admin/pembelian/get_pembelian_json", "type": "POST"},
                  columns: [
                        {"data": "kode_pembelian"},
                        {"data": "kode_transaksi"},
                        {"data": "keterangan_pembelian"},
                        {"data": "jumlah_rmb"},
                        {"data": "kurs_beli_pembelian", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                        {"data": "tanggal_pembelian"},
                        {"data": "status_pembelian" ,
                          render : function(data,type,row){
                            var strStatus = "";
                            if(row.status_pembelian == 1){
                              strStatus = "Unpaid";
                            }else if(row.status_pembelian == 2){
                              strStatus = "Paid";
                            }
                            return strStatus ;
                          }
                        },

                       {"data": "actionpaid"}
                  ],
              order: [[1, 'desc']],
          rowCallback: function(row, data, iDisplayIndex) {
              var info = this.fnPagingInfo();
              var page = info.iPage;
              var length = info.iLength;
              $('td:eq(0)', row).html();

              if (data['status_pembelian'] == "2" && data['status'] == "3"){
                $('td', row).css('background-color', '#A9F096');//00FF7F
                $('td', row).css('color', 'black');
              }

              else if (data['status_pembelian'] == "2" && data['status'] != "3"){
                $('td', row).css('background-color', '#F9DF9C');//00FF7F
                $('td', row).css('color', 'black');
              }

              else if(data['status_pembelian'] != "2"){
                $('td', row).css('background-color', '#FABAA5');
                $('td', row).css('color', 'black');
              }
          }

      });
      // end setup datatables

      //Paid Pembelian
       $('#mytable').on('click','.paid_pembelian',function(){
            var id_pembelian=$(this).data('id_pembelian');
            var status_pembelian=$(this).data('status_pembelian');
            var kode_pembelian=$(this).data('kode_pembelian');
            var id_transaksi=$(this).data('id_transaksi');

           $('#judul').html('<h4>Paid Pembayaran '+kode_pembelian+'</b></i> </h4>');
          if(status_pembelian==2){
            $('#text_pembelian').html('<h5>Status Pembelian <i>Paid</i></b></i> </h5>');
          }else if(status_pembelian==1){
            $('#text_pembelian').html('<h5>Paid Pembelian?</b></i> </h5>');
          }else{
            $('#text_pembelian').html('<h5>Pembelian Gagal</b></i> </h5>');
          }
            $('#pembelian_paid').modal('show');
            //$('#photoss').html('<img src="'+base_url+'upload/screenshoot/'+ss+'" class="img-responsive">');
            $('[name="id_pembelian"]').val(id_pembelian);
            $('[name="kode_pembelian"]').val(kode_pembelian);
            $('[name="id_transaksi"]').val(id_transaksi);
      });

      //Lunasi Satu
       $('#mytable').on('click','.lunasi_satu',function(){
            var kode_pembelian=$(this).data('kode_pembelian');
            var id_transaksi=$(this).data('id_transaksi');

           $('#judul_satu').html('<h4>Lunasi Pembelian <b>'+kode_pembelian+'?</b></h4>');
            $('#lunasi_satu').modal('show');
            //$('#photoss').html('<img src="'+base_url+'upload/screenshoot/'+ss+'" class="img-responsive">');
            $('[name="kode_pembelian"]').val(kode_pembelian);
            $('[name="id_transaksi"]').val(id_transaksi);
      });


});

</script>

<script type="text/javascript">
        $(document).ready(function(){setTimeout(function(){$(".alert").fadeIn('fast');}, 100);});
          //angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
          setTimeout(function(){$(".alert").fadeOut('fast');}, 5000);
</script>

<script type="text/javascript">
  function view_image(id)
  {
    console.log(id);
    $.ajax({
      type : "GET",
      url : "<?php echo base_url() ?>admin/pembelian/view_image/"+id,
      cache : false,
      async : false,
      success : function(html){
        $("#view_image").html(html).show();
        $('#modeditbuku').modal('show');
      }
    })
  }
</script>

<script type="text/javascript">
  function edit_kurs_beli(id)
  {
    // console.log(id);
    $.ajax({
      type : "GET",
      url : "<?php echo base_url() ?>admin/pembelian/edit_kurs_beli/"+id,
      cache : false,
      async : false,
      success : function(html){
        $("#edit_kurs_beli").html(html).show();
        $('#modeditkurs').modal('show');
      }
    })
  }
</script>


<script type="text/javascript">
$(function(){
  $(document).on('click', '.btn-add1', function(e){
      e.preventDefault();

      var controlForm = $('.controls1:first'),
          currentEntry = $(this).parents('.entry1:first'),
          newEntry = $(currentEntry.clone()).appendTo(controlForm);

      newEntry.find('input').val('');
      controlForm.find('.entry1:not(:last) .btn-add1')
          .removeClass('btn-add1').addClass('btn-remove1')
          .removeClass('btn-success').addClass('btn-danger')
          .html('<span class="glyphicon glyphicon-minus"></span>');
  }).on('click', '.btn-remove1', function(e)
  {
    $(this).parents('.entry1:first').remove();

      e.preventDefault();
      return false;
  });
});
</script>
