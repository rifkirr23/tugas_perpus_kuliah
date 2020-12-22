<head>
   <meta charset="utf-8">
   <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>" />
   <link href="<?php echo base_url().'assets/jquery/select2.min.css'?>" rel="stylesheet" />
</head>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Customer List <?php echo $data_campaign->kode_campaign ?></b></h3>
      <span class="pull-right">
          <!-- <button class="btn btn-primary" data-toggle="modal" data-target="#myModalAdd"><i class="fa fa-plus">Customer</i></button> -->
      </span>
    </div>

    <div class="box-body">
    <div class="box-body table-responsive">

    <table class="table table-bordered table-striped no-margin" id="mytable">
      <thead>
        <tr>
          <th>Tanggal Daftar</th>
          <th>Fix Alamat</th>
          <th>Kode Mark Customer</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Telepon</th>
          <th>Whatsapp</th>
          <th>Alamat</th>
          <th>Ekspedisi Lokal</th>
          <th>Note</th>
          <th>Deposit</th>
          <th>Pendaftar</th>
          <th>Aktivasi</th>
          <th>Campaign</th>
        </tr>
      </thead>
    </table>

      </div>
    </div>
   </div>
  </div>


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

        $('.itemName').select2({
            placeholder: 'Customer Grup (Optional)',
            minimumInputLength: 1,
            allowClear: true,
            ajax:{
                url: "<?php echo base_url(); ?>admin/customer/select_grup",
                dataType: "json",
                delay: 250,
                data: function(params){
                    return{
                        kode_cgrup: params.term
                    };
                },
                processResults: function(data){
                    var results = [];

                    $.each(data, function(index, item){
                        results.push({
                            id: item.id_cgrup,
                            text: item.kode_cgrup
                        });
                    });
                    return{
                        results: results
                    };
                }
            }
        });

        $('.itemName2').select2({
            placeholder: 'Customer Referal',
            minimumInputLength: 1,
            allowClear: true,
            ajax:{
                url: "<?php echo base_url(); ?>admin/customer/select_customer",
                dataType: "json",
                delay: 250,
                data: function(params){
                    return{
                        id_referal: params.term
                    };
                },
                processResults: function(data){
                    var results = [];

                    $.each(data, function(index, item){
                        results.push({
                            id: item.id_cust,
                            text: item.kode
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
    $(document).ready(function(){setTimeout(function(){$(".alert").fadeIn('fast');}, 100);});
      //angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
      setTimeout(function(){$(".alert").fadeOut('fast');}, 5000);
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
              ajax: {"url": "<?php echo base_url('admin/customer/get_customercg_json/'.$data_campaign->id_campaign)?>", "type": "POST"},
                  columns: [
                        {"data": "tanggal_daftar"},
                        {"data": "fix_alamat" ,
                          render : function(data,type,row){
                            var strFix = "";
                            var nf = Intl.NumberFormat();
                            if(row.fix_alamat == 1){
                              strFix = " ✓ fix ";
                            }else{
                              strFix = " - ";
                            }
                            return strFix ;
                          }
                        },
                        {"data": "kode"},
                        {"data": "nama"},
                        {"data": "email"},
                        {"data": "telepon"},
                        {"data": "whatsapp"},
                        {"data": "alamat" },
                        {"data": "ekspedisi_lokal"},
                        {"data": "note"},
                        {"data": "deposit" ,
                          render : function(data,type,row){
                            var strDeposit = "";
                            var nf = Intl.NumberFormat();
                            if(row.deposit <= 0){
                              strDeposit = "No Deposit";
                            }else if(row.deposit >=0){
                              strDeposit = "Rp."+nf.format(row.deposit);
                            }
                            return strDeposit ;
                          }
                        },
                        {"data": "nama_pengguna"},
                        {"data": "s_aktivasi" ,
                          render : function(data,type,row){
                            var strAktiv = "";
                            if(row.s_aktivasi == 1){
                              strAktiv = "Sudah Aktivasi";
                            }else if(row.s_aktivasi == 0){
                              strAktiv = "Belum Aktivasi";
                            }
                            return strAktiv ;
                          }
                        },
                        {"data": "kode_campaign"},
                        // {"data": "view"},
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
            var fix_alamat=$(this).data('fix_alamat');
            if(fix_alamat == 1){
              $('input[type="checkbox"]').attr("checked", "checked");
            }

            var id_cust=$(this).data('id_cust');
            var nama=$(this).data('nama');
            var email=$(this).data('email');
            var telepon=$(this).data('telepon');
            var whatsapp=$(this).data('whatsapp');
            var alamat=$(this).data('alamat');
            var note=$(this).data('note');
            var harga_udara=$(this).data('harga_udara');
            var nama_penerima=$(this).data('nama_penerima');

            $('#ModalUpdate').modal('show');
            // $('[name="fix_alamat"]').val(fix_alamat);
            $('[name="id_cust"]').val(id_cust);
            $('[name="nama"]').val(nama);
            $('[name="email"]').val(email);
            $('[name="telepon"]').val(telepon);
            $('[name="whatsapp"]').val(whatsapp);
            $('[name="alamat"]').val(alamat);
            $('[name="note"]').val(note);
            $('[name="harga_udara"]').val(harga_udara);
            $('[name="nama_penerima"]').val(nama_penerima);
      });
      // End Edit Records

      // Resend Records
      $('#mytable').on('click','.resend_chat',function(){
            var id_cust=$(this).data('id_cust');

            $('#Modalresend').modal('show');
            $('[name="id_cust"]').val(id_cust);
      });
      // End Resend Records
      // get Hapus Records
      $('#mytable').on('click','.refund_deposit',function(){
            var id_cust=$(this).data('id_cust');
            $('#ModalRefund').modal('show');
            $('[name="id_cust"]').val(id_cust);
      });

  });
</script>

<script type="text/javascript">
  function view_image(id)
  {
    console.log(id);
    $.ajax({
      type : "GET",
      url : "<?php echo base_url() ?>admin/customer/view_image/"+id,
      cache : false,
      async : false,
      success : function(html){
        $("#view_image").html(html).show();
        $('#modvm').modal('show');
      }
    })
  }
</script>

<script type="text/javascript">
  function edit_customer(id)
  {
    console.log(id);
    $.ajax({
      type : "GET",
      url : "<?php echo base_url() ?>admin/customer/edit_customer/"+id,
      cache : false,
      async : false,
      success : function(html){
        $("#edit_customer").html(html).show();
        $('#ModalUpdate').modal('show');
      }
    })
  }
</script>
