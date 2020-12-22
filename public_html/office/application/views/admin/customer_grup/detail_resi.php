<head>
  <meta charset="utf-8">
  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">

</head>

  <?php $id_cgrup = $this->uri->segment(4); ?>

  <div class="box-header with-border">
    <h3 class="box-title"><b>Resi List</b></h3>
    <span class="pull-right">

    </span>

  </div>

    <div class="box-body">
    <div class="box-body table-responsive">

    <table class="table table-bordered table-striped no-margin" id="mytable">
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>Kode Mark Customer</th>
          <th>Nomor Resi</th>
          <th>Supplier</th>
          <th>Tel</th>
          <th>Note</th>
          <th>Gudang</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>

      <!-- <tbody>
        <tr>
          <th>Kode Mark Customer</th>
          <th>Nomor Resi</th>
          <th>Tanggal</th>
          <th>Supplier</th>
          <th>Tel</th>
          <th>Note</th>
          <th>Gudang</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </tbody> -->
    </table>

 </div>
 </div>



<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>
<script src="<?php echo base_url() ?>assets/jquery/loadingoverlay.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){

  $( "#cek" ).click(function() {
  $.LoadingOverlay("show");
  });

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
              scrollX: true,
              processing: true,
              serverSide: true,
              ajax: {"url": "<?php echo base_url('admin/resi/get_resiidgrup_json/'.$id_cgrup)?>", "type": "POST"},
                  columns: [
                        {"data": "tanggal"},
                        {"data": "kode"},
                        {"data": "nomor"},
                        {"data": "supplier"},
                        {"data": "tel"},
                        {"data": "note"},
                        {"data": "gudang" ,
                          render : function(data,type,row){
                            var strGudang = "";
                            if(row.gudang == 5){
                              strGudang = "Ghuangzhou";
                            }else if(row.gudang == 6){
                              strGudang = "Yiwu";
                            }
                            return strGudang ;
                          }
                        },

                        {"data": "konfirmasi_resi" ,
                          render : function(data,type,row){
                            var strStatus = "";
                            if(row.konfirmasi_resi == 0 ){
                              strStatus = "Belum Terkonfirmasi";
                            }else if(row.konfirmasi_resi == 1){
                              strStatus = "Terkonfirmasi";
                            }
                            else if(row.konfirmasi_resi == 2){
                              strStatus = "Terkonfirmasi & Asuransi";
                            }
                            return strStatus ;
                          }
                        },

                        {"data": "view"},
                  ],
              order: [[0, 'desc']],
          rowCallback: function(row, data, iDisplayIndex) {
              var info = this.fnPagingInfo();
              var page = info.iPage;
              var length = info.iLength;
              $('td:eq(0)', row).html();
              if (data['konfirmasi_resi'] != "0"){
                $('td', row).css('background-color', '#A9F096');//00FF7F
                $('td', row).css('color', 'black');
              }
              else if(data['konfirmasi_resi'] == "0"){
                $('td', row).css('background-color', '#FABAA5');
                $('td', row).css('color', 'black');
              }
          }

      });

      new $.fn.dataTable.FixedHeader( table );
      // end setup datatables
      // get Edit Records
      $('#mytable').on('click','.edit_record',function(){
            var kode=$(this).data('kode');
            var id_cust=$(this).data('id_cust');
            var nama=$(this).data('nama');
            var email=$(this).data('email');
            var telepon=$(this).data('telepon');
            var whatsapp=$(this).data('whatsapp');
            var alamat=$(this).data('alamat');
            var note=$(this).data('note');

            $('#ModalUpdate').modal('show');
            $('[name="kode"]').val(kode);
            $('[name="id_cust"]').val(id_cust);
            $('[name="nama"]').val(nama);
            $('[name="email"]').val(email);
            $('[name="telepon"]').val(telepon);
            $('[name="whatsapp"]').val(whatsapp);
            $('[name="alamat"]').val(alamat);
            $('[name="note"]').val(note);
      });
      // End Edit Records
      // get Hapus Records
      $('#mytable').on('click','.hapus_record',function(){
            var id_cust=$(this).data('id_cust');
            $('#ModalHapus').modal('show');
            $('[name="id_cust"]').val(id_cust);
      });
      // End Hapus Records

  });
</script>
