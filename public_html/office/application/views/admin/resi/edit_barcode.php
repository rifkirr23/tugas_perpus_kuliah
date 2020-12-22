<div class="modal fade" id="modeditbar">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
      	<div class="modal-header">
				      <h4>Edit data <?php echo $record->nomor ?></h4>
      	</div>
        <form action="<?php echo site_url('admin/resi/saveeditbarcode') ?>" method="post">
        	<div class="modal-body">
              <input type="hidden"  value="<?php echo $record->id ?>" name="id" class="form-control" required>
              <div class="form-group">
                <label>Barang</label>
                <input type="text"  value="<?php echo $record->barang ?>" name="barang" class="form-control" required>
              </div>

              <div class="form-group">
                <label>Kategori</label>
                <select class="form-control" name="id_jenis_barang">
                  <?php foreach ($jenis_barang as $jb) {
                    echo "<option value='$jb->id'";
                    echo $record->jenis_barang_id==$jb->id?'selected':'';
                    echo ">$jb->namalain</option>";
                   } ?>
                </select>
              </div>

              <div class="form-group">
                <label>Berat</label>
                <input type="text"  value="<?php echo $record->berat ?>" name="berat" class="form-control" required>
              </div>

              <div class="form-group">
                <label>Qty</label>
                <input type="text"  value="<?php echo $record->qty ?>" name="qty" class="form-control" required>
              </div>

              <div class="form-group">
                <label>Ctns</label>
                <input type="text"  value="<?php echo $record->ctns ?>" name="ctns" class="form-control" required>
              </div>

              <div class="form-group">
                <label>Volume</label>
                <input type="text"  value="<?php echo $record->volume ?>" name="volume" class="form-control" required>
              </div>

              <div class="form-group">
                <label>Harga Rmb Barang</label>
                <input type="text"  value="<?php echo $record->nilai ?>" name="nilai" class="form-control" required>
              </div>
          </div>
        <p><br/></p>
      	<div class="modal-footer">
          <button type="submit" class="btn btn-info">Save</button>
      		<a href="#" class="btn btn-default" data-dismiss="modal">Tutup</a>
      	</div>
      </form>

      </div>
   </div>
</div>
