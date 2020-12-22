<div class="modal fade" id="moded">
   <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">

        <h4>Buku <?php echo $file1->judul_buku; ?></h4>
        </div>

        <div class="modal-body">
          <form id="add-row-form" action="<?php echo base_url().'admin/buku/update'?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_buku" value="<?php echo $file1->id_buku  ?>" class="form-control" required>

            <div class="form-group">
            <label>Judul Buku</label>
                <input type="text" name="judul_buku" value="<?php echo $file1->judul_buku  ?>" class="form-control" placeholder="Judul Buku" required>
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <select name="id_provinsi" id="provinsi" style="width:100%;" class="form-control js-sl" required>
                  <?php foreach ($kategori as $kg) {
                    echo "<option value='$kg->id_kategori'";
                    echo $file1->id_kategori==$kg->id_kategori?'selected':'';
                    echo ">$kg->nama_kategori</option>";
                   } ?>
                </select>
            </div>
            <div class="form-group">
            <label>Pengarang</label>
                <input type="text" name="pengarang" value="<?php echo $file1->pengarang  ?>" class="form-control" placeholder="Pengarang" required>
            </div>
            <div class="form-group">
            <label>Penerbit</label>
                <input type="text" name="penerbit" value="<?php echo $file1->penerbit  ?>" class="form-control" placeholder="Penerbit" required>
            </div>
            <div class="form-group">
            <label>Tahun Terbit</label>
                <input type="text" name="thn_terbit" value="<?php echo $file1->thn_terbit  ?>" class="form-control" placeholder="Tahun terbit" required>
            </div>
            <div class="form-group">
            <label>ISBN</label>
                <input type="text" name="isbn" value="<?php echo $file1->isbn  ?>" class="form-control" placeholder="Isbn" required>
            </div>
            <div class="form-group">
            <label>Lokasi</label>
                <select class="form-control" name="lokasi">
                  <?php if($file1->lokasi == "Rak 1"){ ?>
                    <option>Rak 1</option>
                    <option>Rak 2</option>
                    <option>Rak 3</option>
                  <?php }else if($file1->lokasi == "Rak 2"){ ?>
                    <option>Rak 2</option>
                    <option>Rak 3</option>
                    <option>Rak 1</option>
                  <?php }else{ ?>
                    <option>Rak 3</option>
                    <option>Rak 2</option>
                    <option>Rak 1</option>
                  <?php } ?>
                </select>
            </div>
            <div class="form-group">
                 <label>Gambar</label>
                 <input type="file" name="gambar[]" class="btn btn-primary">
            </div>

            <div class="form-group">
                 <label>Gambar Yang Sudah Ada</label>
                 <img src="<?php echo base_url() ?>assets/gambar/<?php echo $file1->gambar ?>" height="100px" width="150px">
            </div>

            <button type="submit" id="add-row" class="btn btn-primary">Save</button>

          </form>
        <div class="modal-footer">

          <a href="#" class="btn btn-default" data-dismiss="modal">Tutup</a>
        </div>

      </div>
   </div>
</div>
