<head><meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
  <link href="<?php echo base_url().'assets/jquery/select2.min.css'?>" rel="stylesheet" />
</head>

        <?php if($this->session->flashdata('msg')=='success'){ ?>

             <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Input Data Klaim Success
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            </div></p>

        <?php } ?>

        <?php if($this->session->flashdata('msg')=='deleted'){ ?>

           <p><div style="display: none;" class="alert alert-danger alert-dismissable"><i class="icon fa fa-check"></i>Klaim data Deleted
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          </div></p>

        <?php } ?>

        <?php if($this->session->flashdata('msg')=='refunded'){ ?>

           <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Success Refund
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          </div></p>

        <?php } ?>

        <?php if($this->session->flashdata('msg')=='okpotongan'){ ?>

           <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Success Add to Potongan
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          </div></p>

        <?php } ?>

        <?php if($this->session->flashdata('msg')=='okvendor'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Success
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Data Klaim </b></h3>
      <span class="pull-right">
        <button class="btn btn-primary" data-toggle="modal" data-target="#myModalAdd"><i class="fa fa-plus"> Klaim </i></button>
        <button class="btn btn-success" data-toggle="modal" data-target="#myModalKlaim"><i class="fa fa-plus"> Klaim Rts </i></button>
      </span>
    </div>

    <div class="box-body">
    <div class="box-body table-responsive">

    <table class="table table-bordered table-striped no-margin" id="mytable">
      <thead>
        <tr>
          <th>Tanggal Klaim</th>
          <th>Kode Marking</th>
          <th>Kode Barang</th>
          <th>Resi</th>
          <th>Jumlah klaim</th>
          <th>Keterangan Klaim</th>
          <th>Klaim Rts</th>
          <th>Keterangan Rts</th>
          <th>Status</th>
          <th>Klaim Rts</th>
          <th>Action</th>
        </tr>
      </thead>
    </table>

  <!-- Modal Add Customer-->
    <form id="add-row-form" action="<?php echo base_url().'admin/klaim/save'?>" method="post">
       <div class="modal fade" id="myModalAdd" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Form Klaim Asuransi</h4>
                 </div>
                 <div class="modal-body">
                     <div class="form-group">
                     <label>Kode Barang</label>
                         <select name="nomor" class="itemName form-control" id="giw" style="width:100%;"></select>
                     </div>
                     <div class="form-group">
                     <label>Jumlah Hilang</label>
                         <input type="text" name="jumlah_hilang" class="form-control" placeholder="Jumlah Hilang" required>
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

   <!-- Modal Delete-->
    <form id="add-row-form" action="<?php echo base_url().'admin/klaim/delete'?>" method="post">
       <div class="modal fade" id="ModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Apakah anda yakin menghapus data?</h4>
                 </div>
                 <div class="modal-body">

                 <input type="hidden" name="id_klaim" class="form-control" required>

                 </div>
                 <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" id="add-row" class="btn btn-primary">Delete</button>
                 </div>
              </div>
          </div>
       </div>
   </form>

   <!-- Modal Refund-->
    <form id="add-row-form" action="<?php echo base_url().'admin/klaim/refund'?>" method="post">
       <div class="modal fade" id="ModalRefund" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Refund klaim asuransi ke deposit?</h4>
                 </div>
                 <div class="modal-body">

                 <input type="hidden" name="id_klaim" class="form-control" required>

                 </div>
                 <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" id="add-row" class="btn btn-primary">Save</button>
                 </div>
              </div>
          </div>
       </div>
   </form>

   <!-- Modal Potongan-->
    <form id="add-row-form" action="<?php echo base_url().'admin/klaim/potongan'?>" method="post">
       <div class="modal fade" id="ModalPotongan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Tambahkan klaim asuransi ke Invoice?</h4>
                 </div>
                 <div class="modal-body">
                   <input type="hidden" name="id_klaim" class="form-control" required>
                   <div id="show_invoice">

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

   <!-- Modal Potongan-->
    <form id="add-row-form" action="<?php echo base_url().'admin/klaim/vendor_klaim'?>" method="post">
       <div class="modal fade" id="ModalVendor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Sudah klaim ke Rts?</h4>
                 </div>
                 <div class="modal-body">

                 <input type="hidden" name="id_klaim" class="form-control" required>

                 </div>
                 <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" id="add-row" class="btn btn-primary">Ok</button>
                 </div>
              </div>
          </div>
       </div>
   </form>


<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>
<script src="<?php echo base_url().'assets/jquery/jquery.mask.min.js'?>"?>></script>
<script src="<?php echo base_url().'assets/jquery/select2.min.js'?>"></script>

<script type="text/javascript">
        $(document).ready(function(){setTimeout(function(){$(".alert").fadeIn('fast');}, 100);});
          //angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
          setTimeout(function(){$(".alert").fadeOut('fast');}, 5000);
</script>

<script>
    $(document).ready(function(){
        // Format mata uang.
        $( '.uang' ).mask('000.000.000.000', {reverse: true});

        $('.itemName').select2({
            placeholder: 'Masukkan Kode Barang',
            minimumInputLength: 1,
            allowClear: true,
            ajax:{
                url: "<?php echo base_url(); ?>admin/resi/select_giw",
                dataType: "json",
                delay: 250,
                data: function(params){
                    return{
                        nomor: params.term
                    };
                },
                processResults: function(data){
                    var results = [];

                    $.each(data, function(index, item){
                        results.push({
                            id: item.id,
                            text: item.nomor
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
              ajax: {"url": "<?php echo base_url()?>/admin/klaim/get_klaim_json", "type": "POST"},
                  columns: [
                        {"data": "tanggal_klaim"},
                        {"data": "kode"},
                        {"data": "nomor"},
                        {"data": "nomor_resi"},
                        {"data": "jumlah_klaim",  render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                        {"data": "keterangan_klaim"},
                        {"data": "jumlah_klaim_rts",  render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                        {"data": "keterangan_klaim_rts"},
                        {"data": "status_klaim",
                          render : function(data,type,row){
                            var strStatus = "";
                            if(row.status_klaim == 1){
                              strStatus = "Potongan Invoice";
                            }else if(row.status_klaim == 2){
                              strStatus = "Refund";
                            }else{
                              strStatus = " - ";
                            }
                            return strStatus ;
                          }
                        },
                        {"data": "status_vendor" ,
                          render : function(data,type,row){
                            var strVendor = "";
                            if(row.status_vendor == 0){
                              strVendor = "Belum";
                            }else if(row.status_vendor == 1){
                              strVendor = "Sudah";
                            }else{
                              strVendor = " - ";
                            }
                            return strVendor ;
                          }
                        },
                        //render harga dengan format angka

                        {"data": "view"},
                  ],
              order: [[0, 'desc']],
          rowCallback: function(row, data, iDisplayIndex) {
              var info = this.fnPagingInfo();
              var page = info.iPage;
              var length = info.iLength;
              $('td:eq(0)', row).html();

              if (data['status_klaim'] > 0 && data['status_vendor'] == 0){
                $('td', row).css('background-color', '#FABAA5');//00FF7F
                $('td', row).css('color', 'black');
              }else if(data['status_klaim'] == 0 && data['status_vendor'] == "1"){
                $('td', row).css('background-color', '#FABAA5');//00FF7F
                $('td', row).css('color', 'black');
              }else if(data['status_klaim'] > 0 && data['status_vendor'] == "1"){
                $('td', row).css('background-color', '#A9F096');//00FF7F
                $('td', row).css('color', 'black');
              }

          }

      });
      // end setup datatables
      // Get Delete Record
      $('#mytable').on('click','.delete_klaim',function(){
            var id_klaim=$(this).data('id_klaim');
            $('#ModalDelete').modal('show');
            $('[name="id_klaim"]').val(id_klaim);
      });
      // End Delete
      // get refund Records
      $('#mytable').on('click','.refund_klaim',function(){
            var id_klaim=$(this).data('id_klaim');
            $('#ModalRefund').modal('show');
            $('[name="id_klaim"]').val(id_klaim);

      });
      // End Refund Records
      // Potongan klaim
      $('#mytable').on('click','.potongan_klaim',function(){
            var id_klaim=$(this).data('id_klaim');
            var id_cust=$(this).data('id_cust');
            $('#ModalPotongan').modal('show');
            $('[name="id_klaim"]').val(id_klaim);
            //Post ajax Get Invoice customer
            $.ajax({
              type: "POST", // Method pengiriman data bisa dengan GET atau POST
              url: "<?php echo base_url("index.php/admin/klaim/invoice_customer"); ?>", // Isi dengan url/path file php yang dituju
              data: {cust_id : id_cust}, // data yang akan dikirim ke file yang dituju
              dataType: "json",
              beforeSend: function(e) {
                if(e && e.overrideMimeType) {
                  e.overrideMimeType("application/json;charset=UTF-8");
                }
              },
              success: function(response){
                // show_invoice
                $("#show_invoice").html(response.get_invoice).show();
              },
              error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
              }
            });
      });
      // end Potongan
      // Potongan klaim
      $('#mytable').on('click','.vendor_klaim',function(){
            var id_klaim=$(this).data('id_klaim');
            $('#ModalVendor').modal('show');
            $('[name="id_klaim"]').val(id_klaim);
      });
      // end Potongan

  });
</script>
