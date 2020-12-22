<head><meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>" />
</head>

            <?php if($this->session->flashdata('msg')=='success'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Input Bank Baru Success
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

        <?php if($this->session->flashdata('msg')=='updated'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i> Bank Updated
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Data Bank </b></h3>
      <span class="pull-right">

        <button class="btn btn-primary" data-toggle="modal" data-target="#myModalAdd"><i class="fa fa-plus">Bank</i></button>

      </span>
    </div>

    <div class="box-body">
    <div class="box-body table-responsive">

    <table class="table table-bordered table-striped no-margin" id="mytableblabla">
      <thead>
        <tr>

          <th>Nama Bank</th>
          <th>Nomor Rekening Bank</th>
          <th>Atas Nama</th>
          <th>Saldo Bank</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($master_bank as $record_bank){
          $transaksi_bank_masuk  = $this->db->select('sum(nominal_transaksi_bank) as jumlah')->where('id_bank',$record_bank->id_bank)->where('tipe_transaksi_bank','masuk')->get('transaksi_bank')->row();
          $transaksi_bank_keluar = $this->db->select('sum(nominal_transaksi_bank) as jumlah')->where('id_bank',$record_bank->id_bank)->where('tipe_transaksi_bank','keluar')->get('transaksi_bank')->row();
        ?>
          <tr>
            <td><?php echo $record_bank->nama_bank ?></td>
            <td><?php echo $record_bank->nomor_rekening_bank ?></td>
            <td><?php echo $record_bank->atas_nama_bank ?></td>
            <td><?php echo number_format($transaksi_bank_masuk->jumlah - $transaksi_bank_keluar->jumlah) ?></td>
            <td><?php echo '<a href="'.site_url().'admin/bank/transaksi/'.$record_bank->id_bank.'" class="btn btn-info btn-xs"> <i class="fa fa-ellipsis-h"></i></a>
                            <a href="'.site_url().'admin/bank/saldo_harian/'.$record_bank->id_bank.'" class="btn btn-primary btn-xs"> <i class="fa fa-calendar-check-o"></i></a>' ?></td>

          </tr>
        <?php } ?>
      </tbody>
    </table>

  <!-- Modal Add Customer-->

    <form id="add-row-form" action="<?php echo base_url().'admin/bank/save'?>" method="post">
       <div class="modal fade" id="myModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Input Bank Baru</h4>
                 </div>
                 <div class="modal-body">
                     <div class="form-group">
                     <label>Nama Bank</label>
                         <input type="text" name="nama_bank" class="form-control" placeholder="Nama Bank" required>
                     </div>

                     <div class="form-group">
                     <label>Nomor Rekening</label>
                         <input type="text" name="nomor_rekening_bank" class="form-control" placeholder="Rekening Bank" required>
                     </div>

                     <div class="form-group">
                     <label>Atas Nama</label>
                         <input type="text" name="atas_nama_bank" class="form-control" placeholder="Atas Nama Bank" required>
                     </div>

                     <div class="form-group">
                     <label>Saldo Awal</label>
                         <input type="text" name="saldo_bank" class="uang form-control" placeholder="Saldo Bank" required>
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
    <form id="add-row-form" action="<?php echo base_url().'admin/bank/update'?>" method="post">
       <div class="modal fade" id="ModalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Update Data Jenis Transaksi Bank</h4>
                 </div>
                 <div class="modal-body">

                 <input type="hidden" name="id_bank" class="form-control" required>
                 <input type="hidden"  name="edit_saldo" class="form-control" required>

                     <div class="form-group">
                     <label>Nama Bank</label>
                         <input type="text" name="nama_bank" class="form-control" placeholder="Nama Bank" required>
                     </div>

                     <div class="form-group">
                     <label>Nomor Rekening</label>
                         <input type="text" name="nomor_rekening_bank" class="form-control" placeholder="Rekening Bank" required>
                     </div>

                     <div class="form-group">
                     <label>Atas Nama</label>
                         <input type="text" name="atas_nama_bank" class="form-control" placeholder="Atas Nama Bank" required>
                     </div>

                     <div class="form-group" id="edit_saldo">
                     <label>Saldo Awal</label>
                         <input type="text" name="saldo_bank" class="uang form-control" placeholder="Saldo Bank" required>
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
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>
<script src="<?php echo base_url().'assets/jquery/jquery.mask.min.js'?>"?>></script>
<script src="<?php echo base_url() ?>assets/jquery/loadingoverlay.min.js"></script>

<script>
    $(document).ready(function(){

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
              ajax: {"url": "<?php echo base_url()?>admin/bank/get_bank_json", "type": "POST"},
                  columns: [

                        {"data": "nama_bank"},
                        {"data": "nomor_rekening_bank"},
                        {"data": "atas_nama_bank"},
                        {"data": "hitung_saldo_bank", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},


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
            var id_bank=$(this).data('id_bank');
            var nama_bank=$(this).data('nama_bank');
            var nomor_rekening_bank=$(this).data('nomor_rekening_bank');
            var atas_nama_bank=$(this).data('atas_nama_bank');
            var saldo_bank=$(this).data('saldo_bank');
            var edit_saldo=$(this).data('edit_saldo');


            $('#ModalUpdate').modal('show');
            $('[name="id_bank"]').val(id_bank);
            $('[name="edit_saldo"]').val(edit_saldo);
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
