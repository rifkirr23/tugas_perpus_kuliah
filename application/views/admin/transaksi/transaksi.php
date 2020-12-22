<head><meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
</head>

            <?php if($this->session->flashdata('msg')=='success'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Input Transaksi Success
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

        <?php if($this->session->flashdata('msg')=='updated'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Transaksi data Updated
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Data Transaksi </b></h3>
      <span class="pull-right">
        <button class="btn btn-primary" data-toggle="modal" data-target="#myModalAdd"><i class="fa fa-plus"> Transaksi</i></button>
      </span>
    </div>

    <div class="box-body">
    <div class="box-body table-responsive">

    <table class="table table-bordered table-striped no-margin" id="mytable">
      <thead>
        <tr>
          <th>Peminjam</th>
          <th>Buku</th>
          <th>Tanggal Pinjam</th>
          <th>Tanggal Kembali</th>
          <th>Denda</th>
          <th>Status</th>
          <th>Pilihan</th>
        </tr>
      </thead>
    </table>

  <!-- Modal Add Customer-->
    <form id="add-row-form" action="<?php echo base_url().'admin/transaksi/save'?>" method="post">
       <div class="modal fade" id="myModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Form Input Transaksi</h4>
                 </div>
                 <div class="modal-body">
                     <div class="form-group">
                     <label>Peminjam</label>
                         <select class="form-control" name="id_anggota">
                           <?php foreach($anggota as $ag){ ?>
                             <option value="<?php echo $ag->id_anggota ?>"><?php echo $ag->nama_anggota ?></option>
                           <?php } ?>
                         </select>
                     </div>
                     <div class="form-group">
                     <label>Buku</label>
                         <select class="form-control" name="id_buku">
                           <?php foreach($buku as $bk){ ?>
                             <option value="<?php echo $bk->id_buku ?>"><?php echo $bk->judul_buku ?></option>
                           <?php } ?>
                         </select>
                     </div>
                     <div class="form-group">
                     <label>Tanggal Pinjam</label>
                         <input type="date" value="<?php echo date('Y-m-d') ?>" name="tgl_pinjam" class="form-control" placeholder="Penerbit" required>
                     </div>
                     <div class="form-group">
                     <label>Tanggal Kembali</label>
                         <input type="date" name="tgl_kembali" value="<?php echo date('Y-m-d') ?>" class="form-control" placeholder="Tahun terbit" required>
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
    <form id="add-row-form" action="<?php echo base_url().'admin/Transaksi/update'?>" method="post">
       <div class="modal fade" id="ModalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Update Transaksi</h4>
                 </div>
                 <div class="modal-body">

                 <input type="hidden" name="id_Transaksi" class="form-control" required>

                     <div class="form-group">
                     <label>Transaksi Jual</label>
                         <input type="text" name="Transaksi_jual" class="uang form-control" placeholder="Transaksi Jual" required>
                     </div>
                     <div class="form-group">
                     <label>Transaksi Beli</label>
                         <input type="text" name="Transaksi_beli" class="uang form-control" placeholder="Transaksi Beli" required>
                     </div>
                     <div class="form-group">
                     <label>Transaksi Klaim</label>
                         <input type="text" name="Transaksi_klaim" class="uang form-control" placeholder="Transaksi Klaim" required>
                     </div>
                     <div class="form-group">
                     <label>Fee CS</label>
                         <input type="text" name="fee_cs" class="uang form-control" placeholder="Fee Cs" required>
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
              ajax: {"url": "<?php echo base_url()?>/admin/transaksi/get_transaksi_json", "type": "POST"},
                  columns: [

                        {"data": "nama_anggota"},
                        {"data": "judul_buku"},
                        {"data": "tgl_pinjam"},
                        {"data": "tgl_kembali"},
                        {"data": "total_denda",  render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                        {"data": "status_pinjam" ,
                          render : function(data,type,row){
                            var strStatus = "";
                            if(row.status_pinjam == 0){
                              strStatus = "Sedang Meminjam";
                            }else if(row.status_pinjam == 1){
                              strStatus = "Sudah di Kembalikan";
                            }
                            return strStatus ;
                          }},
                        {"data": "view"}
                  ],
              order: [[1, 'asc']],
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
            var id_Transaksi=$(this).data('id_Transaksi');
            var Transaksi_jual=$(this).data('Transaksi_jual');
            var Transaksi_beli=$(this).data('Transaksi_beli');
            var Transaksi_klaim=$(this).data('Transaksi_klaim');
            var fee_cs=$(this).data('fee_cs');


            $('#ModalUpdate').modal('show');
            $('[name="id_Transaksi"]').val(id_Transaksi);
            $('[name="Transaksi_jual"]').val(Transaksi_jual);
            $('[name="Transaksi_beli"]').val(Transaksi_beli);
            $('[name="Transaksi_klaim"]').val(Transaksi_klaim);
            $('[name="fee_cs"]').val(fee_cs);

      });
      // End Edit Records


  });
</script>
