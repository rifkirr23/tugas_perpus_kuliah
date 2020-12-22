<style type="text/css">
    .entry:not(:first-of-type)
{
    margin-top: 30px;
}

 .entry1:not(:first-of-type)
{
    margin-top: 30px;
}

.glyphicon
{
    font-size: 12px;
}
</style>
<link href="<?php echo base_url().'assets/jquery/select2.min.css'?>" rel="stylesheet" />

<?php if($this->session->flashdata('msg')=='ga_cukup'){ ?>

<p><div style="display: none;" class="alert alert-danger alert-dismissable"><i class="icon fa fa-check"></i>Saldo RMB Tidak Cukup
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
</div></p>

<?php } ?>

<?php if($this->session->flashdata('msg')=='gagal_input'){ ?>

<p><div style="display: none;" class="alert alert-danger alert-dismissable"><i class="icon fa fa-check"></i>Kode marking Tidak boleh Kosong
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
</div></p>

<?php } ?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title" id="title_grup"><b>New Transaksi</b></h3>
                  <div class="btn-group pull-right">
                    <button type="button" id="customer2" class="btn btn-info">Customer </button>
                    <button type="button" id="aktif_customer" class="btn" style="display:none;">Customer</button>
                    <button type="button" id="grup2" class="btn btn-info" style="display:none;">Customer Grup</button>
                    <button type="button" id="aktif_grup" class="btn">Customer Grup</button>
                  </div>
            </div>
            <div class="box-body">

                    <form id="fileupload" action="<?php echo base_url().'admin/transaksi/save'?>" method="post" enctype="multipart/form-data">

                     <div class="form-group" id="customer_input">
                     <label>Kode Mark Customer</label>
                         <select name="kode" class="itemName form-control" style="width:100%;" id="itemName"></select>
                     </div>

                     <div class="form-group" id="cust_grup_input">
                     <label>Kode Mark Grup</label>
                         <select name="kode_cgrup" class="itemName2 form-control" id="itemName2"></select>
                     </div>

                     <div class="form-group">
                     <label>Tanggal Transaksi</label>
                         <input type="date"  value="<?php echo date('Y-m-d') ?>" name="tanggal_transaksi" class="form-control date" required>
                     </div>

                     <div class="form-group">
                     <label>Kurs Jual</label>
                         <input type="text" name="kurs_jual" class="uang form-control" placeholder="Kurs Jual">
                     </div>

                     <div class="form-group">
                     <label>Jumlah RMB</label>
                         <input type="text" name="jumlah_rmb[]" class="form-control" placeholder="Jumlah Rmb" required>
                     </div>

                     <div class="form-group">
                     <label>Bank Tujuan (Text)</label>
                         <textarea type="text" name="bank_tujuan[]" class="form-control" placeholder="Bank Tujuan"></textarea>
                     </div>

                     <div class="form-group">
                     <label>Bank Tujuan (Gambar)</label>
                         <input type="file" name="file_bank_tujuan[]" class="btn btn-primary form-control">
                     </div>

                     <div id="education_fields">

                     </div>

                     <span class="pull-right">

                        <a onclick="education_fields();" name="add-more" class="btn btn-primary"><i class="fa fa-plus">Transaksi</i></a>

                     </span>

                     <button class="btn btn-success submitt" type="submit" >Save</button>
                </form>
            </div>
        </div>
    </div>


        </form>
     <script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
     <script src="<?php echo base_url().'assets/jquery/select2.min.js'?>"></script>
     <script src="<?php echo base_url().'assets/jquery/jquery.mask.min.js'?>"?>></script>
     <script src="<?php echo base_url() ?>assets/jquery/loadingoverlay.min.js"></script>
     <script>
     $(document).ready(function(){
                $("#cust_grup_input").hide(1000);
                // Format mata uang.
                $( '.uang' ).mask('000.000.000.000', {reverse: true});

                $('form').submit(function() {
                  $.LoadingOverlay("show");
                });

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

            })
    </script>

    <script type="text/javascript">
        $('.submitta').on('click', function(){
         $.LoadingOverlay("show");
          //console.log('wtheck');
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
          $('.itemName').select2({
              placeholder: 'Masukkan Kode Mark Customer',
              minimumInputLength: 1,
              allowClear: true,
              ajax:{
                  url: "<?php echo base_url(); ?>admin/transaksi/select_customer",
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
                              id: item.kode,
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
                          id: item.kode_cgrup,
                          text: item.kode_cgrup
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


      var room = 1;
      function education_fields() {

        room++;
        var objTo = document.getElementById('education_fields')
        var divtest = document.createElement("div");
        divtest.setAttribute("class", "form-group removeclass"+room);
        var rdiv = 'removeclass'+room;
        divtest.innerHTML = '<span class="pull-right"><a onclick="remove_education_fields('+ room +');" name="add-more" class="btn btn-danger"><i class="fa fa-minus">Transaksi</i></a></span><p><br/></p><div class="form-group"><label>Jumlah RMB</label><input type="text" name="jumlah_rmb[]" class="form-control" placeholder="Jumlah Rmb" required></div><div class="form-group"><label>Bank Tujuan (Text)</label><textarea type="text" name="bank_tujuan[]" class="form-control" placeholder="Bank Tujuan"></textarea></div><div class="form-group"><label>Bank Tujuan (Gambar)</label><input type="file" name="file_bank_tujuan[]" class="btn btn-primary form-control"></div>';

        objTo.appendChild(divtest)
      }
     function remove_education_fields(rid) {
       $('.removeclass'+rid).remove();
     }


</script>

    <script type="text/javascript">
            $(document).ready(function(){setTimeout(function(){$(".alert").fadeIn('fast');}, 100);});
              //angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
              setTimeout(function(){$(".alert").fadeOut('fast');}, 5000);
    </script>
