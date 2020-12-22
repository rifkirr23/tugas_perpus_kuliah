
   <link href="<?php echo base_url().'assets/jquery/select2.min.css'?>" rel="stylesheet" />

   <div class="row">
       <div class="col-md-12">
           <div class="box box-primary">
               <div class="box-header with-border">
                   <h3 class="box-title" id="title_grup"><b>Update Data Customer</b></h3>
               </div>
               <div class="box-body">

                       <form id="add-row-form" action="<?php echo base_url().'admin/customer/update'?>" method="post" enctype="multipart/form-data">

                         <input type="hidden" name="id_cust" value="<?php echo $data_cust->id_cust ?>" class="form-control" required>

                          <div class="form-group">
                          <label>Nama </label>
                              <input type="text" name="nama" class="form-control" placeholder="Nama Customer" value="<?php echo $data_cust->nama ?>" required>
                          </div>
                          <div class="form-group">
                             <label>Customer Grup</label>
                             <select name="id_cgrup" class="form-control">
                              <option value="">Pilih Grup</option>
                              <?php foreach ($cust_grup as $cg) {
                                echo "<option value='$cg->id_cgrup'";
                                echo $data_cust->id_cgrup==$cg->id_cgrup?'selected':'';
                                echo ">$cg->nama_cgrup</option>";
                               } ?>
                             </select>
                          </div>
                          <div class="form-group">
                             <label>Customer Referal</label>
                             <select name="id_referal" class="form-control referal">
                              <option value="">Pilih Referal</option>
                              <?php foreach ($cust_referal as $cf) {
                                echo "<option value='$cf->id_cust'";
                                echo $data_cust->id_referal==$cf->id_cust?'selected':'';
                                echo ">$cf->kode</option>";
                               } ?>
                             </select>
                          </div>
                          <div class="form-group">
                          <label>Nama Penerima </label>
                              <input type="text" name="nama_penerima" class="form-control" placeholder="Nama Penerima" value="<?php echo $data_cust->nama_penerima ?>">
                          </div>

                          <div class="form-group">
                          <label>Email </label>
                              <input type="text" name="email" class="form-control" placeholder="Email Customer" value="<?php echo $data_cust->email ?>" required>
                          </div>

                          <div class="form-group">
                          <label>Telepon </label>
                              <input type="text" name="telepon" class="form-control" placeholder="Telepon Customer" value="<?php echo $data_cust->telepon ?>" required>
                          </div>
                          <div class="form-group">
                            <label>Whatsapp</label>
                              <input type="text" name="whatsapp" class="form-control" placeholder="Whatsapp Customer" value="<?php echo $data_cust->whatsapp ?>" required>
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
                                <option value="<?php echo $data_cust->id_kota ?>"><?php echo $data_cust->nama_kota ?></option>
                              </select>
                          </div>

                          <div class="form-group">
                              <label>Kecamatan</label>
                              <select name="id_kec" id="kecamatan" style="width:100%;" class="form-control js-sl" required>
                                <option value="<?php echo $data_cust->id_kec ?>"><?php echo $data_cust->nama_kecamatan ?></option>
                              </select>
                          </div>

                          <div class="form-group">
                            <label>Alamat</label>
                              <textarea type="text" name="alamat" class="form-control" placeholder="Alamat" required>"<?php echo $data_cust->alamat ?></textarea>
                          </div>

                          <div class="form-group">
                              <label>Ekspedisi Lokal</label>
                              <select class="form-control js-sl" name="id_ekspedisi">
                                <?php foreach ($data_ekspedisi as $deks) {
                                  echo "<option value='$deks->id_ekspedisi'";
                                  echo $data_cust->id_ekspedisi==$deks->id_ekspedisi?'selected':'';
                                  echo ">$deks->nama_ekspedisi</option>";
                                 } ?>
                              </select>
                          </div>

                          <div class="form-group">
                            <label>Ekspedisi Lokal</label>
                              <textarea type="text" name="ekspedisi_lokal" class="form-control" placeholder="Ekspedisi Lokal"><?php echo $data_cust->ekspedisi_lokal ?></textarea>
                          </div>

                          <div class="form-group">
                          <label>Noted</label>
                              <textarea type="text" name="note" class="form-control" placeholder="Noted"><?php echo $data_cust->note ?></textarea>
                          </div>

                          <div class="form-group">
                              <label>Harga Udara</label>
                              <input type="text" name="harga_udara" class="form-control" placeholder="Harga Udara" value="<?php echo $data_cust->harga_udara ?>">
                          </div>

                          <div class="form-group">
                              <label>Komisi Titip Trf</label>
                              <input type="text" name="komisi_titip_trf" class="form-control" placeholder="Komisi Titip Trf" value="<?php echo $data_cust->komisi_titip_trf ?>">
                          </div>

                          <div class="form-group">
                              <label>Komisi Barang</label>
                              <input type="number" name="komisi_barang" class="form-control" placeholder="Komisi Barang" value="<?php echo $data_cust->komisi_barang ?>">
                          </div>

                          <div class="form-group">
                              <label>Komisi Udara</label>
                              <input type="number" name="komisi_udara" class="form-control" placeholder="Komisi Udara" value="<?php echo $data_cust->komisi_udara ?>">
                          </div>

                          <div class="form-group">
                              <label>Fix Alamat</label>
                              <input type="checkbox" name="fix_alamat" value="1" <?php if($data_cust->fix_alamat == 1){ echo"checked"; } ?>>
                          </div>

                          <div class="form-group">
                              <label>Harga otomatis</label>
                              <input type="checkbox" name="harga_otomatis" value="1" <?php if($data_cust->harga_otomatis == 1){ echo"checked"; } ?>>
                          </div>

                          <div class="form-group">
                               <label>Jalur Lambat</label>
                               <select name="jalur" class="form-control">
                                 <?php if($data_cust->jalur == 1){ ?>
                                   <option value="1">Normal</option>
                                   <option value="3">Harus Cepat</option>
                                   <option value="2">Selalu Lambat</option>
                                 <?php }else if($data_cust->jalur == 2){ ?>
                                   <option value="2">Selalu Lambat</option>
                                   <option value="1">Normal</option>
                                   <option value="3">Harus Cepat</option>
                                 <?php }else if($data_cust->jalur == 3){ ?>
                                   <option value="3">Harus Cepat</option>
                                   <option value="1">Normal</option>
                                   <option value="2">Selalu Lambat</option>
                                 <?php } ?>
                               </select>
                          </div>

                          <?php $campaign = $this->db->where('id_campaign >',0)->get('campaign')->result(); ?>
                          <div class="form-group">
                             <label>Campaign</label>
                             <select name="id_campaign" class="form-control">
                              <option value="">Pilih Referal</option>
                              <?php foreach ($campaign as $cpg) {
                                echo "<option value='$cpg->id_campaign'";
                                echo $data_cust->id_campaign==$cpg->id_campaign?'selected':'';
                                echo ">$cpg->kode_campaign</option>";
                               } ?>
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
