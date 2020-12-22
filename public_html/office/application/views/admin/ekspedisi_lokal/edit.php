
   <link href="<?php echo base_url().'assets/jquery/select2.min.css'?>" rel="stylesheet" />

   <div class="row">
       <div class="col-md-12">
           <div class="box box-primary">
               <div class="box-header with-border">
                   <h3 class="box-title" id="title_grup"><b>Update Data Customer</b></h3>
               </div>
               <div class="box-body">
                 <form id="add-row-form" action="<?php echo base_url().'admin/ekspedisi_lokal/update'?>" method="post">
                   <input type="hidden" name="id_ekspedisi" value="<?php echo $eks->id_ekspedisi ?>" class="form-control" required>
                   <div class="form-group">
                   <label>Nama Ekspedisi</label>
                       <input type="text" name="nama_ekspedisi" class="form-control" value="<?php echo $eks->nama_ekspedisi ?>" placeholder="Nama Ekspedisi Lokal" required>
                   </div>
                   <div class="form-group">
                   <label>Alamat</label>
                       <input type="text" name="alamat" class="form-control" value="<?php echo $eks->alamat ?>" placeholder="Alamat" required>
                   </div>
                   <div class="form-group">
                   <label>No Telp</label>
                       <input type="text" name="no_telp" class="form-control" value="<?php echo $eks->no_telp ?>" placeholder="No Telpon" required>
                   </div>
                   <div class="form-group">
                   <label>Tipe</label>
                   <select name="tipe_ekspedisi" class="form-control">
                     <?php if($eks->tipe_ekspedisi == "pickup"){ ?>
                       <option value="pickup">Pick Up</option>
                       <option value="kirim">Kirim</option>
                     <?php }else{ ?>
                       <option value="kirim">Kirim</option> 
                       <option value="pickup">Pick Up</option>
                     <?php } ?>
                   </select>
                   </div>

                   <div class="form-group">
                       <label>Provinsi</label>
                       <select name="id_provinsi" id="provinsi" style="width:100%;" class="form-control js-sl" required>
                         <?php foreach ($provinsi as $prov) {
                           echo "<option value='$prov->id_prov'";
                           echo $eks->id_provinsi==$prov->id_prov?'selected':'';
                           echo ">$prov->nama</option>";
                          } ?>
                       </select>
                   </div>

                   <div class="form-group">
                       <label>Kota</label>
                       <select name="id_kota" id="kota" style="width:100%;" class="form-control js-sl" required>
                         <option value="<?php echo $eks->id_kota ?>"><?php echo $eks->namakota ?></option>
                       </select>
                   </div>

                   <div class="form-group">
                       <label>Kecamatan</label>
                       <select name="id_kec" id="kecamatan" style="width:100%;" class="form-control js-sl" required>
                         <option value="<?php echo $eks->id_kec ?>"><?php echo $eks->namakec ?></option>
                       </select>
                   </div>

                   <button class="btn btn-primary submitt" style="margin-top:30px;" type="submit" >Save</button>
                 </form>
               </div>
           </div>
       </div>


           </form>
        <script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
        <script src="<?php echo base_url().'assets/jquery/select2.min.js'?>"></script>
        <script src="<?php echo base_url().'assets/jquery/jquery.mask.min.js'?>"?>></script>
        <script src="<?php echo base_url() ?>assets/jquery/loadingoverlay.min.js"></script>

       <script type="text/javascript">
               $(document).ready(function(){setTimeout(function(){$(".alert").fadeIn('fast');}, 100);});
                 //angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
                 setTimeout(function(){$(".alert").fadeOut('fast');}, 5000);
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
