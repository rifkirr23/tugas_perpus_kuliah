<div class="modal fade" id="modal_update">
   <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4>Update Jenis Transaksi </h4>
        </div>
        <form id="add-row-form" action="<?php echo base_url().'admin/jenis_tb/update'?>" method="post">
          <div class="modal-body">
            <input type="hidden" name="id_jenis_transaksi_bank" value="<?php echo $data_jenis_tb->id_jenis_transaksi_bank; ?>">
            <div class="form-group">
            <label>Nama Jenis Transaksi</label>
                <input type="text" name="kjenis_transaksi_bank" class="form-control" value="<?php echo $data_jenis_tb->kjenis_transaksi_bank ?>" placeholder="Masukan Nama Jenis Transaksi Yang akan diinput" required>
            </div>

            <div class="form-group">
            <label>Tipe Jenis Transaksi</label>
               <select name="tipe_jenis_transaksi" class="form-control">
                  <?php if($data_jenis_tb->tipe_jenis_transaksi == 1){ ?>
                    <option value="1">Masuk</option>
                    <option value="2">Keluar</option>
                    <option value="3">Automatically</option>
                  <?php }else if($data_jenis_tb->tipe_jenis_transaksi == 2){ ?>
                    <option value="2">Keluar</option>
                    <option value="1">Masuk</option>
                    <option value="3">Automatically</option>
                  <?php }else if($data_jenis_tb->tipe_jenis_transaksi == 3){ ?>
                    <option value="3">Automatically</option>
                    <option value="1">Masuk</option>
                    <option value="2">Keluar</option>
                  <?php }?>
               </select>
            </div>

            <div class="form-group">
            <label>Parent Jenis Transaksi</label>
               <select name="id_parent" class="form-control">
                 <?php foreach ($data_parent as $dp) {
                   echo "<option value='$dp->id_parent'";
                   echo $data_jenis_tb->id_parent==$dp->id_parent?'selected':'';
                   echo ">$dp->nama_parent</option>";
                  } ?>
               </select>
            </div>
          </div>
        <div class="modal-footer">
          <button type="submit" name="submit" class="btn btn-primary">Save</button>
          <a href="#" class="btn btn-default" data-dismiss="modal">Tutup</a>
        </div>
      </form>
      </div>
   </div>
</div>
