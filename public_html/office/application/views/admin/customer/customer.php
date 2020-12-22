<head>
   <meta charset="utf-8">
   <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>" />
   <link href="<?php echo base_url().'assets/jquery/select2.min.css'?>" rel="stylesheet" />
</head>

    <?php if($this->session->flashdata('msg')=='success'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Customer Added to Our data
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

    <?php }else if($this->session->flashdata('msg')=='updated'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Customer data Updated
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

    <?php } else if($this->session->flashdata('msg')=='notvalid'){ ?>

       <p><div style="display: none;" class="alert alert-danger alert-dismissable"><i class="icon fa fa-check"></i>Kode Mark Tersebut Sudah ada , Silahkan gunakan search untuk melihat data tsb.
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

    <?php } else if($this->session->flashdata('msg')=='okresend'){ ?>

      <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Resend Chat Success
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
     </div></p>

    <?php } else if($this->session->flashdata('msg')=='refund'){ ?>

      <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Refund Success
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
     </div></p>

   <?php } else if($this->session->flashdata('msg')=='buatakun'){ ?>

     <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Akun Berhasil dibuat
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    </div></p>

 <?php } else if($this->session->flashdata('msg')=='newpw'){ ?>

   <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Berhasil Membuat Password Baru
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  </div></p>
 <?php } else if($this->session->flashdata('msg')=='pushcust'){ ?>

  <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Berhasil Push Customer to China
     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  </div></p>

 <?php } ?>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Customer List</b></h3>
      <span class="pull-right">
          <button class="btn btn-primary" data-toggle="modal" data-target="#myModalAdd"><i class="fa fa-plus">Customer</i></button>
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
          <th>Sales</th>
          <th>Crm</th>
          <th>Aktivasi</th>
          <th>Campaign</th>
          <th>Action</th>
        </tr>
      </thead>
    </table>

 </div>
 </div>
  <!-- Modal Add Customer-->
    <form id="add-row-form" action="<?php echo base_url().'admin/customer/save'?>" method="post" enctype="multipart/form-data">
       <div class="modal fade" id="myModalAdd" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Add New Customer</h4>
                 </div>
                 <div class="modal-body">
                     <div class="form-group">
                       <label>Kode Mark</label>
                       <div class="input-group input-group-sm">
                        <div class="input-group-btn open">
                          <select class="btn btn-default dropdown-toggle" name="markingdepan">
                            <option value="123/WC-">123/WC-</option>
                            <option value="WC-">WC-</option>
                          </select>
                        </div>
                        <!-- /btn-group -->
                        <input type="text" name="kode" class="form-control" placeholder="Kode Mark Customer" required>
                      </div>
                     </div>

                     <div class="form-group">
                       <label>Customer Grup</label>
                       <select name="id_cgrup" class="itemName form-control" style="width:100%;" id="itemName"></select>
                     </div>

                     <div class="form-group">
                       <label>Referal</label>
                       <select name="id_referal" class="itemName2 form-control" style="width:100%;" id="itemName2"></select>
                     </div>

                     <div class="form-group">
                         <label>Nama </label>
                         <input type="text" name="nama" class="form-control" placeholder="Nama Customer" required>
                     </div>

                     <div class="form-group">
                     <label>Nama Penerima (Optional)</label>
                         <input type="text" name="nama_penerima" class="form-control" placeholder="Nama Penerima">
                     </div>

                     <div class="form-group">
                         <label>Email </label>
                         <input type="email" name="email" class="form-control" placeholder="Email Customer" required>
                     </div>

                     <div class="form-group">
                         <label>Telepon </label>
                         <input type="text" name="telepon" class="form-control" placeholder="Telepon Customer" required>
                     </div>

                     <div class="form-group">
                         <label>Whatsapp</label>
                         <input type="text" name="whatsapp" class="form-control" placeholder="Whatsapp Customer" required>
                     </div>

                     <div class="form-group">
                         <label>Provinsi</label>
                         <select name="id_provinsi" id="provinsi" style="width:100%;" class="form-control js-sl" required>
                             <option value="">--Pilih--</option>
                           <?php foreach ($provinsi as $prov) { ?>
                             <option value="<?php echo $prov->id_prov; ?>"><?php echo $prov->nama; ?></option>
                           <?php } ?>
                         </select>
                     </div>

                     <div class="form-group">
                         <label>Kota</label>
                         <select name="id_kota" id="kota" style="width:100%;" class="form-control js-sl" required>

                         </select>
                     </div>

                     <div class="form-group">
                         <label>Kecamatan</label>
                         <select name="id_kec" id="kecamatan" style="width:100%;" class="form-control js-sl" required>

                         </select>
                     </div>

                     <div class="form-group">
                       <label>Alamat</label>
                         <textarea type="text" name="alamat" class="form-control" placeholder="Alamat" required></textarea>
                     </div>

                     <div class="form-group">
                         <label>Ekspedisi Lokal</label>
                         <select class="form-control js-sl" style="width:100%;" name="id_ekspedisi">
                           <?php foreach ($data_ekspedisi as $deks): ?>
                             <option value="<?php echo $deks->id_ekspedisi ?>"><?php echo $deks->nama_ekspedisi ?></option>
                           <?php endforeach; ?>
                         </select>
                     </div>

                     <div class="form-group">
                       <label>Ekspedisi Lokal</label>
                         <textarea type="text" name="ekspedisi_lokal" class="form-control" placeholder="Ekspedisi Lokal"></textarea>
                     </div>

                     <div class="form-group">
                          <label>Noted</label>
                          <textarea type="text" name="note" class="form-control" placeholder="Noted"></textarea>
                     </div>

                     <div class="form-group">
                         <label>Harga Udara</label>
                         <input type="text" name="harga_udara" class="form-control" placeholder="Harga Udara" value="0">
                     </div>

                     <div class="form-group">
                         <label>Komisi Titip Trf</label>
                         <input type="text" name="komisi_titip_trf" class="form-control" placeholder="Komisi Titip Trf" value="0">
                     </div>

                     <div class="form-group">
                         <label>Komisi Barang</label>
                         <input type="number" name="komisi_barang" class="form-control" placeholder="Komisi Barang" value="0">
                     </div>

                     <div class="form-group">
                         <label>Komisi Udara</label>
                         <input type="number" name="komisi_udara" class="form-control" placeholder="Komisi Udara" value="0">
                     </div>

                     <div class="form-group">
                         <label>Fix Alamat</label>
                         <input type="checkbox" name="fix_alamat" value="1">
                     </div>

                     <div class="form-group">
                         <label>Harga otomatis > 10 cbm</label>
                         <input type="checkbox" name="harga_otomatis" value="1">
                     </div>

                      <div class="form-group">
                           <label>Jalur Lambat</label>
                           <select name="jalur" class="form-control">
                             <option value="1">Normal</option>
                             <option value="3">Harus Cepat</option>
                             <option value="2">Selalu Lambat</option>
                           </select>
                      </div>

                     <div class="form-group">
                         <label>Campaign</label>
                         <select class="form-control js-sl" style="width:100%;" name="id_campaign">
                           <?php foreach ($campaign as $cpg): ?>
                             <option value="<?php echo $cpg->id_campaign ?>"><?php echo $cpg->kode_campaign." (".$cpg->nama_campaign.")" ?></option>
                           <?php endforeach; ?>
                         </select>
                     </div>

                     <div class="form-group">
                          <label>Foto KTP</label>
                          <input type="file" name="foto_ktp" class="btn btn-primary">
                     </div>

                     <div class="form-group">
                          <label>Foto SK</label>
                          <input type="file" name="foto_sk" class="btn btn-primary">
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

   <!-- Modal Resend Chat Customer -->
   <form id="add-row-form" action="<?php echo base_url().'admin/customer/resend_chat'?>" method="post" enctype="multipart/form-data">
      <div class="modal fade" id="Modalresend" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Re-send Chat Customer</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                  <label>Resend Chat Register to Customer ?</label>
                      <input type="hidden" name="id_cust" class="form-control" required>
                  </div>
                </div>
                <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                     <button type="submit" id="add-row" class="btn btn-primary">Send</button>
                </div>
             </div>
         </div>
      </div>
  </form>

   <!-- Modal Hapus Customer-->
   <form id="add-row-form" action="<?php echo base_url().'admin/customer/refund_deposit'?>" method="post">
       <div class="modal fade" id="ModalRefund" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Refund Deposit</h4>
                 </div>
                 <div class="modal-body">
                     <input type="hidden" name="id_cust" class="form-control" required>
                     <div class="form-group">
                         <label>Jumlah</label>
                         <input type="text" name="jumlah_refund" class="form-control" placeholder="Jumlah Refund">
                     </div>
                 </div>
                 <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" id="add-row" class="btn btn-primary">Refund</button>
                 </div>
              </div>
          </div>
       </div>
   </form>

   <form id="add-row-form" action="<?php echo base_url().'admin/customer/setor_deposit'?>" method="post">
       <div class="modal fade" id="ModalSetor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Setor Deposit</h4>
                 </div>
                 <div class="modal-body">
                     <input type="hidden" name="id_cust" class="form-control" required>
                     <div class="form-group">
                         <label>Jumlah</label>
                         <input type="text" name="jumlah_setor" class="form-control" placeholder="Jumlah Setor">
                     </div>
                 </div>
                 <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" id="add-row" class="btn btn-primary">Refund</button>
                 </div>
              </div>
          </div>
       </div>
   </form>

   <form id="add-row-form" action="<?php echo base_url().'admin/customer/delete_customer'?>" method="post">
       <div class="modal fade" id="ModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Delete Customer</h4>
                 </div>
                 <div class="modal-body">
                     <input type="hidden" name="id_cust" class="form-control" required>
                 </div>
                 <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" id="add-row" class="btn btn-primary">Delete</button>
                 </div>
              </div>
          </div>
       </div>
   </form>

   <form id="add-row-form" action="<?php echo base_url().'admin/customer/push_customer'?>" method="post">
       <div class="modal fade" id="ModalPush" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Push Customer</h4>
                 </div>
                 <div class="modal-body">
                     <input type="hidden" name="id_cust" class="form-control" required>
                 </div>
                 <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" id="add-row" class="btn btn-primary">Push</button>
                 </div>
              </div>
          </div>
       </div>
   </form>


    <div id="view_image"></div>
    <div id="edit_customer"></div>
    <div id="akun_customer"></div>

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
$('.js-sl').select2();
$("#provinsi").change(function(){ // Ketika user mengganti atau memilih data provinsi
  // $("#kota").hide(); // Sembunyikan dulu combobox kota nya
  // $("#loading").show(); // Tampilkan loadingnya

  $.ajax({
    type: "POST", // Method pengiriman data bisa dengan GET atau POST
    url: "<?php echo base_url("admin/customer/listkota"); ?>", // Isi dengan url/path file php yang dituju
    data: {id_provinsi : $("#provinsi").val()}, // data yang akan dikirim ke file yang dituju
    dataType: "json",
    beforeSend: function(e) {
      if(e && e.overrideMimeType) {
        e.overrideMimeType("application/json;charset=UTF-8");
      }
    },
    success: function(response){ // Ketika proses pengiriman berhasil
      $("#loading").hide(500); // Sembunyikan loadingnya

      // set isi dari combobox kota
      // lalu munculkan kembali combobox kotanya
      $("#kota").html(response.list_kota).show(500);
    },
    error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
      alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
    }
  });
});

$("#kota").change(function(){ // Ketika user mengganti atau memilih data provinsi
  // $("#kota").hide(); // Sembunyikan dulu combobox kota nya
  // $("#loading").show(); // Tampilkan loadingnya

  $.ajax({
    type: "POST", // Method pengiriman data bisa dengan GET atau POST
    url: "<?php echo base_url("admin/customer/listkecamatan"); ?>", // Isi dengan url/path file php yang dituju
    data: {id_kota : $("#kota").val()}, // data yang akan dikirim ke file yang dituju
    dataType: "json",
    beforeSend: function(e) {
      if(e && e.overrideMimeType) {
        e.overrideMimeType("application/json;charset=UTF-8");
      }
    },
    success: function(response){ // Ketika proses pengiriman berhasil
      $("#loading").hide(500); // Sembunyikan loadingnya

      // set isi dari combobox kota
      // lalu munculkan kembali combobox kotanya
      $("#kecamatan").html(response.list_kota).show(500);
    },
    error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
      alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
    }
  });
});

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
              ajax: {"url": "<?php echo base_url()?>admin/customer/get_customer_json", "type": "POST"},
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
                        {"data": "nama_crm"},
                        {"data": "s_aktivasi"},
                        {"data": "kode_campaign"},
                        {"data": "view"},
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

      $('#mytable').on('click','.setor_deposit',function(){
            var id_cust=$(this).data('id_cust');
            $('#ModalSetor').modal('show');
            $('[name="id_cust"]').val(id_cust);
      });

      $('#mytable').on('click','.delete_customer',function(){
            var id_cust=$(this).data('id_cust');
            $('#ModalDelete').modal('show');
            $('[name="id_cust"]').val(id_cust);
      });

      $('#mytable').on('click','.push_customer',function(){
            var id_cust=$(this).data('id_cust');
            $('#ModalPush').modal('show');
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

<script type="text/javascript">
  function akun_customer(id)
  {
    console.log(id);
    $.ajax({
      type : "GET",
      url : "<?php echo base_url() ?>admin/customer/akun_customer/"+id,
      cache : false,
      async : false,
      success : function(html){
        $("#akun_customer").html(html).show();
        $('#ModalAkun').modal('show');
      }
    })
  }
</script>
