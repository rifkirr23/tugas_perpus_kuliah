<head><meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
  <link href="<?php echo base_url().'assets/jquery/select2.min.css'?>" rel="stylesheet" />
</head>

            <?php if($this->session->flashdata('msg')=='success'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Input Ekspedisi Success
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

        <?php if($this->session->flashdata('msg')=='updated'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Ekspedisi data Updated
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Data Ekspedisi </b></h3>
      <span class="pull-right">
        <button class="btn btn-primary" data-toggle="modal" data-target="#myModalAdd"><i class="fa fa-plus"> Ekspedisi Lokal </i></button>
      </span>
    </div>

    <div class="box-body">
    <div class="box-body table-responsive">

    <table class="table table-bordered table-striped no-margin" id="mytable">
      <thead>
        <tr>
          <th>Tipe</th>
          <th>Nama Ekspedisi</th>
          <th>Alamat</th>
          <th>No telp</th>
          <th>Provinsi</th>
          <th>Kota</th>
          <th>Kecamatan</th>
          <th>Action</th>
        </tr>
      </thead>
    </table>

  <!-- Modal Add Customer-->
    <form id="add-row-form" action="<?php echo base_url().'admin/ekspedisi_lokal/save'?>" method="post">
       <div class="modal fade" id="myModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Form Input Ekspedisi</h4>
                 </div>
                 <div class="modal-body">
                     <div class="form-group">
                     <label>Nama Ekspedisi</label>
                         <input type="text" name="nama_ekspedisi" class="form-control" placeholder="Nama Ekspedisi Lokal" required>
                     </div>
                     <div class="form-group">
                     <label>Alamat</label>
                         <input type="text" name="alamat" class="form-control" placeholder="Alamat" required>
                     </div>
                     <div class="form-group">
                     <label>No Telp</label>
                         <input type="text" name="no_telp" class="form-control" placeholder="No Telpon" required>
                     </div>
                     <div class="form-group">
                     <label>Tipe</label>
                     <select name="tipe_ekspedisi" class="form-control">
                         <option value="pickup">Pick Up</option>
                         <option value="kirim">Kirim</option>
                     </select>
                     </div>

                     <div class="form-group">
                         <label>Provinsi</label>
                         <select name="id_provinsi" id="provinsi" style="width:100%;" class="form-control js-sl" required>
                           <?php foreach ($provinsi as $prov) {
                             echo "<option value='$prov->id_prov'";
                             echo $data_cust->id_provinsi==$prov->id_prov?'selected':'';
                             echo ">$prov->nama</option>";
                            } ?>
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
    <form id="add-row-form" action="<?php echo base_url().'admin/ekspedisi_lokal/update'?>" method="post">
       <div class="modal fade" id="ModalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Update Ekspedisi Lokal</h4>
                 </div>
                 <div class="modal-body">

                   <input type="hidden" name="id_ekspedisi" class="form-control" required>

                   <div class="form-group">
                   <label>Nama Ekspedisi</label>
                       <input type="text" name="nama_ekspedisi" class="form-control" placeholder="Nama Ekspedisi Lokal" required>
                   </div>
                   <div class="form-group">
                   <label>Alamat</label>
                       <input type="text" name="alamat" class="form-control" placeholder="Alamat" required>
                   </div>
                   <div class="form-group">
                   <label>No Telp</label>
                       <input type="text" name="no_telp" class="form-control" placeholder="No Telpon" required>
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

   <div id="edit"></div>

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
              ajax: {"url": "<?php echo base_url()?>/admin/ekspedisi_lokal/get_data_json", "type": "POST"},
                  columns: [
                        {"data": "tipe_ekspedisi"},
                        {"data": "nama_ekspedisi"},
                        {"data": "alamat"},
                        {"data": "no_telp"},
                        {"data": "namaprov"},
                        {"data": "namakota"},
                        {"data": "namakec"},
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
            var id_ekspedisi=$(this).data('id_ekspedisi');
            var nama_ekspedisi=$(this).data('nama_ekspedisi');
            var alamat=$(this).data('alamat');
            var no_telp=$(this).data('no_telp');


            $('#ModalUpdate').modal('show');
            $('[name="id_ekspedisi"]').val(id_ekspedisi);
            $('[name="nama_ekspedisi"]').val(nama_ekspedisi);
            $('[name="alamat"]').val(alamat);
            $('[name="no_telp"]').val(no_telp);

      });
      // End Edit Records


  });
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
  function edit(id)
  {
    console.log(id);
    $.ajax({
      type : "GET",
      url : "<?php echo base_url() ?>admin/ekspedisi_lokal/edit/"+id,
      cache : false,
      async : false,
      success : function(html){
        $("#edit").html(html).show();
        $('#modedit').modal('show');
      }
    })
  }
</script>
