<head><meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
</head>

            <?php if($this->session->flashdata('msg')=='success'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Input Kurs Success
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

        <?php if($this->session->flashdata('msg')=='updated'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Kurs data Updated
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Data Komisi Referal </b></h3>
      <span class="pull-right">
        <!-- <button class="btn btn-primary" data-toggle="modal" data-target="#myModalAdd"><i class="fa fa-plus"></i></button> -->
      </span>
    </div>

    <div class="box-body">
    <div class="box-body table-responsive">

    <table class="table table-bordered table-striped no-margin" id="mytable">
      <thead>
        <tr>
          <th>Kode Komisi</th>
          <th>Referal</th>
          <th>Customer</th>
          <th>Kode Invoice</th>
          <th>Jumlah</th>
          <th>Keterangan</th>
          <th>Status</th>
        </tr>
      </thead>
    </table>

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
              ajax: {"url": "<?php echo base_url()?>/admin/komisi_referal/get_komisi_referal_json", "type": "POST"},
                  columns: [

                        {"data": "kode_komisi"},
                        {"data": "kode"},
                        {"data": "customer"},
                        {"data": "kode_invoice"},
                        {"data": "nilai",  render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                        {"data": "keterangan"},
                        {"data": "status" ,
                          render : function(data,type,row){
                            var strStatus = "";
                            if(row.status == 1){
                              strStatus = "Pending";
                            }else if(row.status == 2){
                              strStatus = "Complete";
                            }else if(row.status == 3){
                              strStatus = "-";
                            }else if(row.status == 4){
                              strStatus = "cancel";
                            }
                            return strStatus ;
                          }
                        },
                  ],
              order: [[1, 'asc']],
          rowCallback: function(row, data, iDisplayIndex) {
              var info = this.fnPagingInfo();
              var page = info.iPage;
              var length = info.iLength;
              $('td:eq(0)', row).html();
              if (data['status'] == "2"){
                $('td', row).css('background-color', '#A9F096');//00FF7F
                $('td', row).css('color', 'black');
              }
          }

      });
      // end setup datatables
      // get Edit Records
      $('#mytable').on('click','.edit_record',function(){
            var id_kurs=$(this).data('id_kurs');
            var kurs_jual=$(this).data('kurs_jual');
            var kurs_beli=$(this).data('kurs_beli');
            var kurs_klaim=$(this).data('kurs_klaim');
            var fee_cs=$(this).data('fee_cs');


            $('#ModalUpdate').modal('show');
            $('[name="id_kurs"]').val(id_kurs);
            $('[name="kurs_jual"]').val(kurs_jual);
            $('[name="kurs_beli"]').val(kurs_beli);
            $('[name="kurs_klaim"]').val(kurs_klaim);
            $('[name="fee_cs"]').val(fee_cs);

      });
      // End Edit Records


  });
</script>
