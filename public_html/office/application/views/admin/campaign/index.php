<head><meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
</head>

            <?php if($this->session->flashdata('msg')=='success'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Input campaign Success
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

        <?php if($this->session->flashdata('msg')=='updated'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>campaign data Updated
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Data Campaign </b></h3>
      <span class="pull-right">
        <button class="btn btn-primary" data-toggle="modal" data-target="#myModalAdd"><i class="fa fa-plus"></i></button>
      </span>
    </div>

    <div class="box-body">
    <div class="box-body table-responsive">

    <table class="table table-bordered table-striped no-margin" id="mytable">
      <thead>
        <tr>

          <th>Kode</th>
          <th>Nama</th>
          <th>Teks Chat</th>
          <th>Link Whatsapp</th>
          <th>Action</th>
        </tr>
      </thead>
    </table>

  <!-- Modal Add Customer-->
    <form id="add-row-form" action="<?php echo base_url().'admin/campaign/save'?>" method="post">
       <div class="modal fade" id="myModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Form Campaign</h4>
                 </div>
                 <div class="modal-body">
                     <div class="form-group">
                     <label>Kode</label>
                         <input type="text" name="kode_campaign" value="<?php echo $kode_campaign ?>" class="form-control" placeholder="Kode Campaign" required>
                     </div>
                     <div class="form-group">
                     <label>Nama Campaign</label>
                         <input type="text" name="nama_campaign" class="form-control" placeholder="Nama Campaign" required>
                     </div>
                     <div class="form-group">
                     <label>Chat Campaign</label>
                         <input type="text" name="chat_campaign" class="form-control" placeholder="Chat">
                     </div>
                     <!-- <div class="form-group">
                     <label>Link Whatsapp</label>
                         <input type="text" name="link_whatsapp" class="form-control" placeholder="Link Whatsapp">
                     </div> -->
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
    <form id="add-row-form" action="<?php echo base_url().'admin/campaign/update'?>" method="post">
       <div class="modal fade" id="ModalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Update Campaign</h4>
                 </div>
                 <div class="modal-body">

                 <input type="hidden" name="id_campaign" class="form-control" required>

                 <div class="modal-body">
                     <div class="form-group">
                     <label>Kode</label>
                         <input type="text" name="kode_campaign" class="form-control" placeholder="Kode Campaign" readonly>
                     </div>
                     <div class="form-group">
                     <label>Nama Campaign</label>
                         <input type="text" name="nama_campaign" class="form-control" placeholder="Nama Campaign" required>
                     </div>
                     <div class="form-group">
                     <label>Chat Campaign</label>
                         <input type="text" name="chat_campaign" class="form-control" placeholder="Chat">
                     </div>
                     <div class="form-group">
                     <label>Link Whatsapp</label>
                         <input type="text" name="link_whatsapp" class="form-control" placeholder="Link Whatsapp">
                     </div>
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
              ajax: {"url": "<?php echo base_url()?>/admin/campaign/get_campaign_json", "type": "POST"},
                  columns: [

                        {"data": "kode_campaign"},
                        {"data": "nama_campaign"},
                        {"data": "chat_campaign"},
                        {"data": "link_whatsapp"},

                        //render harga dengan format angka

                        {"data": "view"}
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
            var id_campaign=$(this).data('id_campaign');
            var kode_campaign=$(this).data('kode_campaign');
            var nama_campaign=$(this).data('nama_campaign');
            var chat_campaign=$(this).data('chat_campaign');
            var link_whatsapp=$(this).data('link_whatsapp');


            $('#ModalUpdate').modal('show');
            $('[name="id_campaign"]').val(id_campaign);
            $('[name="kode_campaign"]').val(kode_campaign);
            $('[name="nama_campaign"]').val(nama_campaign);
            $('[name="chat_campaign"]').val(chat_campaign);
            $('[name="link_whatsapp"]').val(link_whatsapp);

      });
      // End Edit Records


  });
</script>
