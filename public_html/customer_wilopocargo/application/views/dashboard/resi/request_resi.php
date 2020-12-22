<title>Wilopo Cargo - Request Resi</title>
<section class="main-konten">
                <div class="container-fluid">

                    <!--Start Jumbotron -->
                    <div id="bertema" class="jumbotron-default">
                        <div class="judul-jumbotron">
                            <h3><i class="fa fa-tools"></i> Order Resi</h3>
                        </div>

                    </div>
                    <!--End Jumbotron-->

                    <div class="row kolom-row mt-4">
                        <div class="col-12">
                            <div class="kartu-setting">
                                <div class="judul-kartu">
                                    <h3>Form Isian</h3>
                                    <a href="#" class="text-secondary"><i class="fa fa-plus"></i></a>
                                </div>

                                <div class="setting-box">
                                    <form action="<?php echo site_url('resi/save_requestresi') ?>" class="inner" method="post" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <label for="supplier" class="col-sm-3 col-form-label">Nama Supplier / No Resi Ekspedisi Lokal</label>
                                            <div class="col-sm-5 input-col">
                                              <input type="text" id="suplier" class="form-control" name="supplier" placeholder="Nama Supplier / No Resi Ekspedisi Lokal" data-toggle="tooltip" data-placement="top" title="Nama Supplier / No Resi Ekspedisi Lokal" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="supplier" class="col-sm-3 col-form-label">Foto Resi Ekspedisi Lokal</label>
                                            <div class="col-sm-5 input-col">
                                              <input class="btn btn-primary" name="fotoekspedisi_lokal[]" type="file">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="tel" class="col-sm-3 col-form-label">Tel Supplier</label>
                                            <div class="col-sm-5 input-col">
                                              <input type="text" id="tel" class="form-control" name="tel" placeholder="Tel" data-toggle="tooltip" data-placement="top" title="Masukkan tel">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="tgl" class="col-sm-3 col-form-label">Gudang Yiwu / Gz</label>
                                            <div class="col-sm-5 input-col">
                                              <select class="form-control" name="gudang">
                                                <option value="Ghuangzhou">Ghuangzhou</option>
                                                <option value="Yiwu">Yiwu</option>
                                              </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="tgl" class="col-sm-3 col-form-label">Jumlah Koli / Dus</label>
                                            <div class="col-sm-5 input-col">
                                              <input type="text" id="jumlah_koli" name="jumlah_koli" class="form-control" placeholder="Jumlah Koli / Dus" data-toggle="tooltip" data-placement="top" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="notes" class="col-sm-3 col-form-label">Note / Catatan</label>
                                            <div class="col-sm-5 input-col">
                                              <textarea class="form-control" name="notes" id="notes" cols="30" rows="5" data-toggle="tooltip" data-placement="top" title="Masukkan catatan khusus"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="notes" class="col-sm-3 col-form-label"><i></i></label>
                                            <div class="col-sm-5 input-col">
                                              <p style="color:red"><i>Harap Perhatikan!<br /><br />Harap upload packing list lengkap! (pdf / excel) Contoh seperti ini : <a href="https://www.wilopocargo.com/contohfile/pl_contoh.xlsx">file pl</a>
                                                                   <br /><br />Jika supplier tidak ada packing list, Anda dapat mengisi sendiri / menyuruh supplier isi dengan format excel yang dapat di download disini : <a href="https://wilopocargo.com/contohfile/pl_contoh.xlsx">form pl</i></p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <!-- <p class=""><i>Tes</i></p> -->
                                            <label for="notes" class="col-sm-3 col-form-label">Invoice & Packing List</label>
                                            <div class="col-sm-5 input-col">
                                              <div class="control-group" id="fields1">
                                                  <div class="controls1">
                                                      <div class="entry1 input-group col-xs-3" style="margin-top:10px;">
                                                        <input class="btn btn-primary" name="file_pl[]" type="file" data-toggle="tooltip" data-placement="top" title="Wajib Upload Packing List Lengkap!" required>
                                                        <span class="input-group-btn">
                                                          <button class="input-group-text btn-success btn-add1" type="button">
                                                            <span class="fa fa-plus"></span>
                                                          </button>
                                                        </span>
                                                     </div>
                                                  </div>
                                              </div>
                                                <small data-valid="invalid" style="display:none;" id="ukimage"><i class="fa fa-frown"></i> Ukuran File Terlalu besar, MAX 2.5MB</small>
                                            </div>
                                        </div>
                                </div>
                                <div class="pull-left" style="margin-top:10px; margin-left:10px;">
                                    <button type="submit" class="btn btn-lg btn-primary sukses">Simpan</button>
                                </div>
                              </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <script type="text/javascript">
                 $(function(){
                      $(document).on('click', '.btn-add1', function(e){
                          e.preventDefault();

                          var controlForm = $('.controls1:first'),
                              currentEntry = $(this).parents('.entry1:first'),
                              newEntry = $(currentEntry.clone()).appendTo(controlForm);

                          newEntry.find('input').val('');
                          controlForm.find('.entry1:not(:last) .btn-add1')
                              .removeClass('btn-add1').addClass('btn-remove1')
                              .removeClass('btn-success').addClass('btn-danger')
                              .html('<span class="fa fa-minus"></span>');
                      }).on('click', '.btn-remove1', function(e){
                        $(this).parents('.entry1:first').remove();
                          e.preventDefault();
                          return false;
                      });
                  });
            </script>
