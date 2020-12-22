<div class="modal fade" id="modeeditpotongan">
   <div class="modal-dialog">
      <div class="modal-content">
      	<div class="modal-header">
				<h4>Edit Potongan</h4>
      	</div>
        <div class="modal-body">
          <form action="<?php echo base_url().'admin/invoice_barang/save_edit_potongan'?>" method="post" enctype="multipart/form-data">

            <input type="hidden" name="id_potongan" value="<?php echo $id ?>">
            <input type="hidden" name="id_invoice" value="<?php echo $record->id_invoice ?>">
            <div class="form-group">
                <label>Jumlah Potongan</label>
                <input type="text" name="jumlah_potongan" class="form-control" placeholder="Jumlah Potongan" value="<?php echo $record->jumlah_potongan ?>" required>
                <input type="hidden" name="jumlah_potongan_lama" class="form-control" placeholder="Harga Beli" value="<?php echo $record->jumlah_potongan ?>" required>
            </div>

            <div class="form-group">
                 <label>Keterangan</label>
                 <textarea type="text" name="keterangan_potongan" class="form-control" placeholder="Keterangan"><?php echo $record->keterangan_potongan ?></textarea>
            </div>

            <div class="modal-footer">
                 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                 <button type="submit" id="add-row" class="btn btn-primary">Save</button>
            </div>
          </form>
        </div>
    </div>
  </div>
</div>
