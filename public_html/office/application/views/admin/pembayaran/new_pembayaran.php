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
<!-- blueimp Gallery styles -->
<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/upload_jquery/blueimp-gallery.min.css"> -->
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/upload_jquery/css/jquery.fileupload.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/upload_jquery/css/jquery.fileupload-ui.css"> -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/responsive.bootstrap.min.css'?>">


<link href="<?php echo base_url().'assets/jquery/select2.min.css'?>" rel="stylesheet" />
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><b>New Pembayaran </b></h3>
                <div class="btn-group pull-right">
                  <button type="button" id="customer2" class="btn btn-info">Customer </button>
                  <button type="button" id="aktif_customer" class="btn" style="display:none;">Customer</button>
                  <button type="button" id="grup2" class="btn btn-info" style="display:none;">Customer Grup</button>
                  <button type="button" id="aktif_grup" class="btn">Customer Grup</button>
                </div>
            </div>
            <div class="box-body">

                    <form id="fileupload" action="<?php echo base_url().'admin/pembayaran/save'?>" method="post" enctype="multipart/form-data">

                     <div class="form-group" id="customer_input">
                     <label>Kode Mark Customer</label>
                        <select name="kode" class="itemName form-control" id="customer"></select>
                     </div>

                     <div class="form-group" id="cust_grup_input">
                     <label>Kode Mark Grup</label>
                         <select name="kode_cgrup" class="itemName3 form-control" id="customer_grup"></select>
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
                         <input type="text"  value="<?php echo $kode_pembayaran ?>" name="kode_pembayaran" class="form-control date" required>
                     </div>

                     <div class="form-group">
                     <label>Tanggal Bayar</label>
                         <input type="date" value="<?php echo date('Y-m-d') ?>" name="tanggal_bayar" class="form-control" required>
                     </div>

                     <div class="form-group">
                     <label>Jumlah Bayar</label>
                         <input type="text"  id="jumlah_bayar" name="jumlah_bayar" class="form-control" placeholder="Jumlah Bayar" required>
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
                                <input class="btn btn-primary" name="file_bb_cust[]" type="file">
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
            $('.itemName').select2({
                placeholder: 'Masukkan Kode Mark Customer',
                minimumInputLength: 1,
                allowClear: true,
                ajax:{
                    url: "<?php echo base_url(); ?>admin/pembayaran/select_customer",
                    dataType: "json",
                    delay: 250,
                    data: function(params){
                        return{
                            kode: params.term
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

            $('.itemName3').select2({
                placeholder: 'Masukkan Kode Mark Customer Grup',
                minimumInputLength: 1,
                allowClear: true,
                ajax:{
                    url: "<?php echo base_url(); ?>admin/transaksi/select_customergrup",
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
            $("#cust_grup_input").hide(1000);

            $("#aktif_grup").click(function() {
              $("#cust_grup_input").show(200);
              $("#customer_input").hide(200);
              $("#aktif_grup").hide(200);
              $("#aktif_customer").show(200);
              $("#customer2").hide(200);
              $("#grup2").show(200);
            });

            $("#aktif_customer").click(function() {
              $("#cust_grup_input").hide(200);
              $("#customer_input").show(200);
              $("#aktif_grup").show(200);
              $("#aktif_customer").hide(200);
              $("#customer2").show(200);
              $("#grup2").hide(200);
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
          }).on('click', '.btn-remove', function(e)
          {
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

    $("#customer").change(function(){ // Ketika user mengganti atau memilih Customer

      $.ajax({
        type: "POST", // Method pengiriman data bisa dengan GET atau POST
        url: "<?php echo base_url("index.php/admin/pembayaran/get_invoice"); ?>", // Isi dengan url/path file php yang dituju
        data: {id_cust : $("#customer").val()}, // data yang akan dikirim ke file yang dituju
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
          $("#show_invoice").html(response.get_invoice).show();
          $("#show_invoice").hide(); // hide BEfore Input
        },
        error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
        }
      });
    });

    $("#customer_grup").change(function(){ // Ketika user mengganti atau memilih Customer

      $.ajax({
        type: "POST", // Method pengiriman data bisa dengan GET atau POST
        url: "<?php echo base_url("index.php/admin/pembayaran/get_invoicegrup"); ?>", // Isi dengan url/path file php yang dituju
        data: {id_cgrup : $("#customer_grup").val()}, // data yang akan dikirim ke file yang dituju
        dataType: "json",
        beforeSend: function(e) {
          if(e && e.overrideMimeType) {
            e.overrideMimeType("application/json;charset=UTF-8");
          }
        },
        success: function(response){ // Ketika proses pengiriman berhasil
          // console.log(response);
          $("#show_invoice").html(response.get_invoicegrup).show();
          $("#show_invoice").hide(); // hide BEfore Input
        },
        error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
        }
      });
    });

  });

      $('#jumlah_bayar').on('input', function(){
        $("#show_invoice").show(); //Show After Input
      });

var tmp = [];
  $(".show_invoice").on('change','.checkboxs', function(e) {
      var checked = $(this).is(":checked");
      var id      = $(this).val();
      $('#jumlah_bayar').on('input', function(){
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
        url: "<?php echo base_url("index.php/admin/pembayaran/get_invoice2"); ?>", // Isi dengan url/path file php yang dituju
        data: {id_invoice : tmp},
         // data yang akan dikirim ke file yang dituju
        dataType: "json",
        beforeSend: function(e) {
          if(e && e.overrideMimeType) {
            e.overrideMimeType("application/json;charset=UTF-8");
          }
        },
        success: function(response){ // Ketika proses pengiriman berhasil
          //$("#loading").hide(500); // Sembunyikan loadingnya
          //console.log(response[1].total_tagihan);

         $("#sisa_billing").val(0);
        $("#total_bayar").val(0);
         console.log(response.length);

          if (response.length == ""){
                 //console.log(response[0].total_tagihan);
                var response_hasil = 0;
                $("#total_bayar").val(response_hasil);
                $("#sisa_billing").val(response_hasil);


          }
          else if (response.length==1){
                 //console.log(response[0].total_tagihan);
                var response_hasil = parseInt(response[0].total_tagihan)- parseInt(response[0].jumlah_bayar) - parseInt (response[0].total_potongan);
                $("#total_bayar").val(response_hasil);
                //console.log(response_hasil);

          }else if(response.length > 1){
            var hasil = 0;
            for(i = 0; i < response.length; i++){
              var response_hasil = parseInt(response[i].total_tagihan)- parseInt(response[i].jumlah_bayar) - parseInt (response[i].total_potongan);
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
             // document.getElementById("id_invoice").disabled= false;
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
        url: "<?php echo base_url("index.php/admin/pembayaran/get_invoice2"); ?>", // Isi dengan url/path file php yang dituju
        data: {id_invoice : tmp},
         // data yang akan dikirim ke file yang dituju
        dataType: "json",
        beforeSend: function(e) {
          if(e && e.overrideMimeType) {
            e.overrideMimeType("application/json;charset=UTF-8");
          }
        },
        success: function(response){ // Ketika proses pengiriman berhasil
          //$("#loading").hide(500); // Sembunyikan loadingnya
          //console.log(response[1].total_tagihan);
          $("#sisa_billing").val(0);
        $("#total_bayar").val(0);

          console.log(response.length);

          if (response.length == ""){
                 //console.log(response[0].total_tagihan);
                var response_hasil = 0;
                $("#total_bayar").val(response_hasil);
                $("#sisa_billing").val(response_hasil);

          }
          else if (response.length==1){
                 //console.log(response[0].total_tagihan);
                var response_hasil = parseInt(response[0].total_tagihan)- parseInt(response[0].jumlah_bayar) - parseInt (response[0].total_potongan);
                $("#total_bayar").val(response_hasil);
                //console.log(response_hasil);

          }else if(response.length > 1){
            var hasil = 0;
            for(i = 0; i < response.length; i++){
              var response_hasil = parseInt(response[i].total_tagihan)- parseInt(response[i].jumlah_bayar) - parseInt (response[i].total_potongan);
              hasil += parseInt(response_hasil);
              console.log(response[i].total_potongan);
            }


                    $("#total_bayar").val(hasil);
                    //console.log(hasil);
          }

            var jumlah = document.getElementById("jumlah_bayar").value;
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
              //document.getElementById("id_invoice").removeAttribute('disabled');
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
        url: "<?php echo base_url("index.php/admin/pembayaran/get_invoice2"); ?>", // Isi dengan url/path file php yang dituju
        data: {id_invoice : tmp},
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
                 //console.log(response[0].total_tagihan);
                var response_hasil = 0;
                $("#total_bayar").val(response_hasil);
                $("#sisa_billing").val(response_hasil);
                console.log('tes');
          }
          else if (response.length==1){
                 //console.log(response[0].total_tagihan);
                var response_hasil = parseInt(response[0].total_tagihan)- parseInt(response[0].jumlah_bayar) - parseInt (response[0].total_potongan);
                $("#total_bayar").val(response_hasil);
                //console.log(response_hasil);

          }else if(response.length > 1){
            var hasil = 0;
            for(i = 0; i < response.length; i++){
              var response_hasil = parseInt(response[i].total_tagihan)- parseInt(response[i].jumlah_bayar) - parseInt (response[i].total_potongan);
              hasil += parseInt(response_hasil);
              //console.log(response[i].total_potongan);
            }


                    $("#total_bayar").val(hasil);
                    //console.log(hasil);
          }

            var jumlah = document.getElementById("jumlah_bayar").value;
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
              //document.getElementById("id_invoice").disabled= false;
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
    $('#jumlah_bayar').on('input', function(){
          var input = $(this).val();
          var total   = document.getElementById("total_bayar").value;
          if(total == ""){
            $('#sisa_billing').val(input);
          }else{

          }

        });
  </script>
