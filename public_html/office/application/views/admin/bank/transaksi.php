<head><meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

   <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>" />
   <link href="<?php echo base_url().'assets/jquery/select2.min.css'?>" rel="stylesheet" />
</head>

            <?php if($this->session->flashdata('msg')=='success'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Transaksi Success
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

        <?php if($this->session->flashdata('msg')=='updated'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i> Transaksi Updated
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

        <?php if($this->session->flashdata('msg')=='gagal'){ ?>

         <p><div style="display: none;" class="alert alert-danger alert-dismissable"><i class="icon fa fa-check"></i>Transaksi Gagal
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        </div></p>

        <?php } ?>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>List Transaksi Bank </b></h3>
      <span class="pull-right">

        <button class="btn btn-info" data-toggle="modal" data-target="#myModalAdd"><i class="fa fa-plus">Transaksi Masuk</i></button>
        <button class="btn btn-danger" data-toggle="modal" data-target="#myModalAdd2"><i class="fa fa-minus">Transaksi Keluar</i></button>

      </span>
    </div>

    <div class="box-body">
    <div class="box-body table-responsive" id="area">

    <table class="table table-bordered table-striped no-margin" id="mytable">
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>Nominal</th>
          <th>Transaksi</th>
          <th>Jenis Transaksi</th>
          <th>Keterangan Transaksi</th>
        </tr>
      </thead>
    </table>

  <!-- Modal Transaksi Masuk -->

    <form id="add-row-form" action="<?php echo base_url().'admin/bank/save_transaksi'?>" method="post">
       <div class="modal fade" id="myModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Transaksi Dana Masuk</h4>
                 </div>
                 <div class="modal-body">

                     <input type="hidden" name="id_bank" class="form-control" value="<?php echo $this->uri->segment(4) ?>" required>
                     <input type="hidden" name="tipe" class="form-control" value="masuk" required>

                     <div class="form-group">
                     <label>Jenis Transaksi</label>
                         <select name="kode" class="itemName form-control" style="width: 100%;" required>
                           <?php foreach ($jenis_transaksi_masuk as $jtm) { ?>
                             <option value="<?php echo $jtm->id_jenis_transaksi_bank ?>"><?php echo $jtm->kjenis_transaksi_bank ?></option>
                           <?php } ?>
                         </select>
                     </div>

                     <div class="form-group">
                     <label>Jumlah Uang</label>
                         <input type="text" name="nominal_transaksi_bank" class="uang form-control" placeholder="Nominal Transaksi" required>
                     </div>

                     <div class="form-group">
                     <label>Keterangan Transaksi</label>
                         <Textarea type="text" name="keterangan_transaksi_bank" class="form-control" placeholder="Keterangan Transaksi" required></Textarea>
                     </div>

                     <div class="form-group">
                     <label>Tanggal Transaksi</label>
                         <input type="date" name="tanggal_transaksi_bank" value="<?php echo date('Y-m-d') ?>" class="form-control" required>
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

   <!-- Modal Transaksi Keluar -->

    <form id="add-row-form" action="<?php echo base_url().'admin/bank/save_transaksi'?>" method="post">
       <div class="modal fade" id="myModalAdd2" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true" style="overflow:hidden;">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Transaksi Dana Keluar</h4>
                 </div>
                 <div class="modal-body">

                    <input type="hidden" name="id_bank" class="form-control" value="<?php echo $this->uri->segment(4) ?>" required>
                    <input type="hidden" name="tipe" class="form-control" value="keluar" required>

                     <div class="form-group">
                     <label>Jenis Transaksi</label>
                         <select name="kode" class="itemName form-control" style="width: 100%;" id="jenis_transaksi_keluar" required>
                           <?php foreach ($jenis_transaksi_keluar as $jtk) { ?>
                             <option value="<?php echo $jtk->id_jenis_transaksi_bank ?>"><?php echo $jtk->kjenis_transaksi_bank ?></option>
                           <?php } ?>
                         </select>
                     </div>

                     <div class="form-group" id="master_bank" style="display:none;">
                     <label>Bank Tujuan</label>
                       <select name="id_bank_tujuan" class="form-control" style="width: 100%;">
                         <?php foreach ($bank as $rowbank){ ?>
                             <option value="<?php echo $rowbank->id_bank ?>"><?php echo $rowbank->nama_bank ?></option>
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

                 </div>
                 <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" id="add-row" class="btn btn-primary">Save</button>
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
<script type="text/javascript">
$("#jenis_transaksi_keluar").change(function(){ // Ketika user mengganti atau memilih Customer
  if($("#jenis_transaksi_keluar").val()==3){
      $("#master_bank").hide();
      $("#kurs_rmb").show();
  }else if($("#jenis_transaksi_keluar").val()==15){
      $("#kurs_rmb").hide();
      $("#master_bank").show();
  }else{
    $("#kurs_rmb").hide();
    $("#master_bank").hide();
  }
});
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.itemName').select2({

        });

         $('.itemName2').select2({
            placeholder: 'Jenis Transaksi Bank',
            minimumInputLength: 1,
            allowClear: true,

            ajax:{
                url: "<?php echo base_url(); ?>admin/bank/select_jtb2/1",
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
                            id: item.id_jenis_transaksi_bank,
                            text: item.kjenis_transaksi_bank
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
<script>
    $(document).ready(function(){
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};

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

        function printDiv(divName) {
             var printContents = document.getElementById(divName).innerHTML;
             var originalContents = document.body.innerHTML;

             document.body.innerHTML = printContents;

             window.print();

             document.body.innerHTML = originalContents;
        }
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
              paging:false,
              scrollX: true,
              processing: true,
              serverSide: true,
              // paging:false,
              ajax: {"url": "<?php echo base_url()?>admin/bank/get_tb_json/<?php echo $this->uri->segment(4) ?>", "type": "POST"},
                  columns: [
                        {"data": "tanggal_transaksi_bank"},
                        {"data": "nominal_transaksi_bank", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                        {"data": "tipe_transaksi_bank"},
                        {"data": "kjenis_transaksi_bank"},
                        {"data": "keterangan_transaksi_bank"}

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
            var id_bank=$(this).data('id_bank');
            var nama_bank=$(this).data('nama_bank');
            var nomor_rekening_bank=$(this).data('nomor_rekening_bank');
            var atas_nama_bank=$(this).data('atas_nama_bank');
            var saldo_bank=$(this).data('saldo_bank');
            var edit_saldo=$(this).data('edit_saldo');


            $('#ModalUpdate').modal('show');
            $('[name="id_bank"]').val(id_bank);
            $('[name="nama_bank"]').val(nama_bank);
            $('[name="nomor_rekening_bank"]').val(nomor_rekening_bank);
            $('[name="atas_nama_bank"]').val(atas_nama_bank);
            $('[name="saldo_bank"]').val(saldo_bank);

            if(edit_saldo==1){
                $("#edit_saldo").hide();
            }

      });
      // End Edit Records


  });
</script>
