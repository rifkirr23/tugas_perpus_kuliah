<style type="text/css">
    .entry:not(:first-of-type)
{
    margin-top: 10px;
}

 .entry1:not(:first-of-type)
{
    margin-top: 10px;
}

.glyphicon
{
    font-size: 12px;
}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/responsive.bootstrap.min.css'?>">
<link href="<?php echo base_url().'assets/jquery/select2.min.css'?>" rel="stylesheet" />
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><b>New Pembayaran Beli</b></h3>
            </div>
            <div class="box-body">

                    <form id="fileupload" action="<?php echo base_url().'admin/pembayaran_beli/save'?>" method="post" enctype="multipart/form-data">

                     <div class="form-group" id="vendor_input">
                     <label>Vendor</label>
                        <select name="id_vendor" class="itemName form-control" id="vendor">
                          <option value="0"><font color="gray">Pilih Vendor <br /></font></option>
                          <?php foreach ($vendor as $rowvendor){ ?>
                            <option value="<?php echo $rowvendor->id_vendor ?>"><?php echo $rowvendor->nama_vendor ?></option>
                          <?php } ?>
                        </select>
                     </div>

                     <div class="form-group">
                     <label>Bank</label>
                       <select name="id_bank" class="form-control" style="width: 100%;">
                         <?php foreach ($bank as $rowbank){ ?>
                             <option value="<?php echo $rowbank->id_bank ?>"><?php echo $rowbank->nama_bank ?></option>
                         <?php } ?>
                       </select>
                     </div>

                     <div class="form-group">
                     <label>Kode Pembayaran</label>
                         <input type="text"  value="<?php echo $kode_pembayaran_beli ?>" name="kode_pembel" class="form-control date" required>
                     </div>

                     <div class="form-group">
                     <label>Tanggal Bayar</label>
                         <input type="date" value="<?php echo date('Y-m-d') ?>" name="tanggal_pembel" class="form-control" required>
                     </div>

                     <div class="form-group">
                     <label>Jumlah Bayar</label>
                         <input type="text"  id="jumlah_bayar_invoice_beli" name="jumlah_pembel" class="form-control" placeholder="Jumlah Bayar" required>
                     </div>

                         <label>Select Invoice</label>

                        <table border='1' class='table table-bordered' >
                            <tr>
                            <td width='50px'> <center>Select</center></td>
                            <td width='200px'><center>Kode Invoice</center></td>
                            <td width='200px'><center>Tagihan</center></td>
                            </tr>

                         </table>
                         <table border='1' class='table table-bordered show_invoice' id='show_invoice'>
                            <tr>
                            <td>Select</td>
                            <td>Kode Invoice</td>
                            <td>Tagihan</td>
                            </tr>
                         </table>


                     <div class="form-group">
                     <label>Total Biaya</label>
                         <input type="text" name="total_dibayar" id="total_bayar" class="form-control" readonly>

                     </div>

                   <div class="form-group">
                     <label>Sisa Bayar</label>
                         <input type="text" id="sisa_billing" name="sisa_billing" class="form-control" placeholder="Sisa Billing" readonly>
                         <p id="info_sisa"><font color="red"><i><u>sisa bayar  (-) minus</u></i></font> </p>

                     </div>

                   <div class="form-group">
                      <label>Bukti Bayar</label>
                      <div class="control-group" id="fields">
                          <div class="controls">
                              <div class="entry input-group col-xs-3">
                                <input class="btn btn-primary" name="bukti_beli[]" type="file">
                                <span class="input-group-btn">
                                <button class="btn btn-success btn-add" type="button">
                                <span class="glyphicon glyphicon-plus"></span>
                                </button>
                                </span>
                              </div>
                          </div>
                      </div>
                  </div>
                  <button class="btn btn-success submitt" id="update_service">Save</button>
                  </form>
            <br/>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/jquery/select2.min.js'?>"></script>
<script src="<?php echo base_url() ?>assets/jquery/loadingoverlay.min.js"></script>
<script type="text/javascript">
        $(document).ready(function(){
          $('.itemName').select2({});

          $('.itemName2').select2({
                placeholder: 'Bank',
                minimumInputLength: 1,
                allowClear: true,
                ajax:{
                    url: "<?php echo base_url(); ?>admin/bank/select_bank",
                    dataType: "json",
                    delay: 250,
                    data: function(params){
                        return{
                            id_bank: params.term
                        };
                    },
                    processResults: function(data){
                        var results = [];

                        $.each(data, function(index, item){
                            results.push({
                                id: item.id_bank,
                                text: item.nama_bank
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
    <script type="text/javascript">
      $(function(){
          $(document).on('click', '.btn-add', function(e){
              e.preventDefault();
              var controlForm = $('.controls:first'),
                  currentEntry = $(this).parents('.entry:first'),
                  newEntry = $(currentEntry.clone()).appendTo(controlForm);

              newEntry.find('input').val('');
              controlForm.find('.entry:not(:last) .btn-add')
                  .removeClass('btn-add').addClass('btn-remove')
                  .removeClass('btn-success').addClass('btn-danger')
                  .html('<span class="glyphicon glyphicon-minus"></span>');
          }).on('click', '.btn-remove', function(e){
            $(this).parents('.entry:first').remove();
              e.preventDefault();
              return false;
          });
      });
  </script>
  <script>
  $(document).ready(function(){ // Ketika halaman sudah siap (sudah selesai di load)

    $('form').submit(function() {
      $.LoadingOverlay("show");
    });

    // Kita sembunyikan dulu untuk loadingnya
    $("#show_invoice").hide();
    $("#info_sisa").hide();

    $("#vendor").change(function(){ // Ketika user mengganti atau memilih Customer
        $.ajax({
          type: "POST", // Method pengiriman data bisa dengan GET atau POST
          url: "<?php echo base_url("index.php/admin/pembayaran_beli/get_invoice"); ?>", // Isi dengan url/path file php yang dituju
          data: {id_vendor : $("#vendor").val()}, // data yang akan dikirim ke file yang dituju
          dataType: "json",
          beforeSend: function(e) {
            if(e && e.overrideMimeType) {
              e.overrideMimeType("application/json;charset=UTF-8");
            }
          },
          success: function(response){ // Ketika proses pengiriman berhasil
            //$("#loading").hide(500); // Sembunyikan loadingnya
            // set isi dari combobox kota
            // lalu munculkan kembali combobox kotanya
            // console.log(response);
            $("#show_invoice").html(response.get_invoice).show();
             $("#show_invoice").hide(); // hide BEfore Input
          },
          error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
          }
        });
    });

  });

$('#jumlah_bayar_invoice_beli').on('input', function(){
  $("#show_invoice").show(); //Show After Input
});

var tmp = [];
  $(".show_invoice").on('change','.checkboxs', function(e) {
      var checked = $(this).is(":checked");
      var id      = $(this).val();
      $('#jumlah_bayar_invoice_beli').on('input', function(){
          var input = $(this).val();
          $('#sisa').text(input);

          if(input ==""){
            input = 0;
          }

          tmp.push(id);
          if (tmp.length==0){
                $("#keterangan").html('Tidak Ada Pembayaran');
                $("#sisa_billing").val(0);
                $("#total_bayar").val(0);
          }else{
             $.ajax({
            type: "POST", // Method pengiriman data bisa dengan GET atau POST
            url: "<?php echo base_url("index.php/admin/pembayaran_beli/get_invoice2"); ?>", // Isi dengan url/path file php yang dituju
            data: {id_invoice_beli : tmp},
             // data yang akan dikirim ke file yang dituju
            dataType: "json",
            beforeSend: function(e) {
              if(e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
              }
            },
            success: function(response){ // Ketika proses pengiriman berhasil
              //$("#loading").hide(500); // Sembunyikan loadingnya
              //console.log(response[1].jumlah_invoice_beli);
            $("#sisa_billing").val(0);
            $("#total_bayar").val(0);
            console.log(response.length);

              if (response.length == ""){
                 //console.log(response[0].jumlah_invoice_beli);
                var response_hasil = 0;
                $("#total_bayar").val(response_hasil);
                $("#sisa_billing").val(response_hasil);
              }
              else if (response.length==1){
                 //console.log(response[0].jumlah_invoice_beli);
                var response_hasil = parseInt(response[0].jumlah_invoice_beli)- parseInt(response[0].jumlah_bayar_invoice_beli);
                $("#total_bayar").val(response_hasil);
                //console.log(response_hasil);
              }else if(response.length > 1){
                var hasil = 0;
                for(i = 0; i < response.length; i++){
                  var response_hasil = parseInt(response[i].jumlah_invoice_beli)- parseInt(response[i].jumlah_bayar_invoice_beli);
                  hasil += parseInt(response_hasil);
                 // console.log(response[i].total_potongan);
                }
                  $("#total_bayar").val(hasil);
                  //console.log(hasil);
              }
                var jumlah = input; console.log(input);
                var total   = document.getElementById("total_bayar").value;
                console.log(total);
                var sisa  = parseInt(input) - parseInt(total) ;
                $("#sisa_billing").val(sisa);
                if(sisa < 0){
                    $('input.checkboxs:not(:checked)').attr('disabled', 'disabled');
                    $("#info_sisa").show();
                    $("#keterangan").html('');
                }else{
                  $('input.checkboxs:not(:checked)').removeAttr('disabled', 'disabled');
                   $("#info_sisa").hide();
                  // $("#keterangan").html('Untuk pelunasan pembayaran kode invoice : '+response.map(function(item){return item['kode_invoice']}).join(' , '));
                 // document.getElementById("id_invoice_beli").disabled= false;
                }

            },
            error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
              alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
            }
          });
        }
          //console.log(tmp);
        });


      if (checked) {
         tmp.push(id);
         if (tmp.length==0){
                $("#keterangan").html('Tidak Ada Pembayaran');
                $("#sisa_billing").val(0);
               $("#total_bayar").val(0);
        }else{
             $.ajax({
            type: "POST", // Method pengiriman data bisa dengan GET atau POST
            url: "<?php echo base_url("index.php/admin/pembayaran_beli/get_invoice2"); ?>", // Isi dengan url/path file php yang dituju
            data: {id_invoice_beli : tmp},
             // data yang akan dikirim ke file yang dituju
            dataType: "json",
            beforeSend: function(e) {
              if(e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
              }
            },
            success: function(response){ // Ketika proses pengiriman berhasil
              //$("#loading").hide(500); // Sembunyikan loadingnya
              //console.log(response[1].jumlah_invoice_beli);
              $("#sisa_billing").val(0);
            $("#total_bayar").val(0);

              console.log(response.length);

              if (response.length == ""){
                     //console.log(response[0].jumlah_invoice_beli);
                    var response_hasil = 0;
                    $("#total_bayar").val(response_hasil);
                    $("#sisa_billing").val(response_hasil);

              }
              else if (response.length==1){
                 //console.log(response[0].jumlah_invoice_beli);
                var response_hasil = parseInt(response[0].jumlah_invoice_beli)- parseInt(response[0].jumlah_bayar_invoice_beli);
                $("#total_bayar").val(response_hasil);
                //console.log(response_hasil);
              }else if(response.length > 1){
                var hasil = 0;
                for(i = 0; i < response.length; i++){
                  var response_hasil = parseInt(response[i].jumlah_invoice_beli)- parseInt(response[i].jumlah_bayar_invoice_beli);
                  hasil += parseInt(response_hasil);
                  console.log(response[i].total_potongan);
                }
                        $("#total_bayar").val(hasil);
                        //console.log(hasil);
              }

                var jumlah = document.getElementById("jumlah_bayar_invoice_beli").value;
                if(jumlah ==""){
                jumlah = 0;
                }
                var total   = document.getElementById("total_bayar").value;
                var sisa  = parseInt(jumlah) - parseInt(total) ;
                $("#sisa_billing").val(sisa);

                if(sisa < 0){
                  $('input.checkboxs:not(:checked)').attr('disabled', 'disabled');
                    $("#info_sisa").show();
                    $("#keterangan").html('');
                }else{
                  $('input.checkboxs:not(:checked)').removeAttr('disabled', 'disabled');
                  $("#info_sisa").hide();
                  //document.getElementById("id_invoice_beli").removeAttribute('disabled');
                  //$("#keterangan").html('Untuk pelunasan pembayaran kode invoice : '+response.map(function(item){return item['kode_invoice']}).join(' , '));
                }
              // set isi dari combobox kota
              // lalu munculkan kembali combobox kotanya
              //$("#show_invoice").html(response.get_invoice).show(500);
            },
            error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
              alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
            }
          });
         }
      }else{
        var index = tmp.indexOf(id);
        if (index !== -1) tmp.splice(index , 1);
        //console.log('ini array '+tmp);
        //$("#total_bayar").val(0);
        if (tmp.length==0){
                $("#keterangan").html('Tidak Ada Pembayaran');
                $("#sisa_billing").val(0);
               $("#total_bayar").val(0);
        }else{
       // tmp.splice($.inArray(id, tmp),1);

            $.ajax({
        type: "POST", // Method pengiriman data bisa dengan GET atau POST
        url: "<?php echo base_url("index.php/admin/pembayaran_beli/get_invoice2"); ?>", // Isi dengan url/path file php yang dituju
        data: {id_invoice_beli : tmp},
         // data yang akan dikirim ke file yang dituju
        dataType: "json",
        beforeSend: function(e) {
          if(e && e.overrideMimeType) {
            e.overrideMimeType("application/json;charset=UTF-8");
          }
        },
        success: function(response){ // Ketika proses pengiriman berhasil
          //$("#loading").hide(500); // Sembunyikan loadingnya
          $("#sisa_billing").val(0);
          $("#total_bayar").val(0);

           if (response.length ==""){
                 //console.log(response[0].jumlah_invoice_beli);
                var response_hasil = 0;
                $("#total_bayar").val(response_hasil);
                $("#sisa_billing").val(response_hasil);
                console.log('tes');
          }
          else if (response.length==1){
                 //console.log(response[0].jumlah_invoice_beli);
                var response_hasil = parseInt(response[0].jumlah_invoice_beli)- parseInt(response[0].jumlah_bayar_invoice_beli);
                $("#total_bayar").val(response_hasil);
                //console.log(response_hasil);

          }else if(response.length > 1){
            var hasil = 0;
            for(i = 0; i < response.length; i++){
              var response_hasil = parseInt(response[i].jumlah_invoice_beli)- parseInt(response[i].jumlah_bayar_invoice_beli);
              hasil += parseInt(response_hasil);
              //console.log(response[i].total_potongan);
            }
            $("#total_bayar").val(hasil);
            //console.log(hasil);
          }

            var jumlah = document.getElementById("jumlah_bayar_invoice_beli").value;
            if(jumlah ==""){
            jumlah = 0;
            }
            var total   = document.getElementById("total_bayar").value;
            var sisa  = parseInt(jumlah) - parseInt(total) ;
            $("#sisa_billing").val(sisa);
            if(sisa < 0){
                $('input.checkboxs:not(:checked)').attr('disabled', 'disabled');
                $("#info_sisa").show();
               // $("#keterangan").html('');
            }else{
              $('input.checkboxs:not(:checked)').removeAttr('disabled', 'disabled');
              $("#info_sisa").hide();
              //document.getElementById("id_invoice_beli").disabled= false;
              //$("#keterangan").html('Untuk pelunasan pembayaran kode invoice : '+response.map(function(item){return item['kode_invoice']}).join(' , '));
            }
          // set isi dari combobox kota
          // lalu munculkan kembali combobox kotanya
          //$("#show_invoice").html(response.get_invoice).show(500);
        },
        error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
        }
      });
     }
    }

   });
  </script>

  <script type="text/javascript">
    $('#jumlah_bayar_invoice_beli').on('input', function(){
          var input = $(this).val();
          var total   = document.getElementById("total_bayar").value;
          if(total == ""){
            $('#sisa_billing').val(input);
          }else{

          }

        });
  </script>
