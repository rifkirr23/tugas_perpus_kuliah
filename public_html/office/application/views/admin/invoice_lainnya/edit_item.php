<div class="modal fade" id="modeedititem">
   <div class="modal-dialog">
      <div class="modal-content">
      	<div class="modal-header">
				<h4>Edit Item</h4>
      	</div>
        <div class="modal-body">
          <form action="<?php echo base_url().'admin/invoice_lainnya/saveedit_item'?>" method="post" enctype="multipart/form-data">

            <input type="hidden" name="id_item_il" value="<?php echo $this->uri->segment(4) ?>">
            <input type="hidden" name="id_invoice" value="<?php echo $record->id_invoice ?>">
            <input type="hidden" name="id_invoice_beli" value="<?php echo $record->id_invoice_beli ?>">
            <div class="form-group">
                <label>Qty</label>
                <input type="text" name="qty_il" class="form-control" placeholder="Jumlah Qty" value="<?php echo $record->qty_il ?>" required>
            </div>

            <div class="form-group">
                <label>Harga Jual</label>
                <input type="text" name="harga_jual" class="uang form-control" placeholder="Harga Jual" value="<?php echo $record->harga_jual ?>" required>
                <input type="hidden" name="harga_jual_lama" class="uang form-control" placeholder="Harga Jual" value="<?php echo $record->harga_jual ?>" required>
            </div>

            <div class="form-group">
                <label>Harga Beli </label>
                <input type="number" name="harga_beli" class="uang form-control" placeholder="Harga Beli" value="<?php echo $record->harga_beli ?>" required>
                <input type="hidden" name="harga_beli_lama" class="uang form-control" placeholder="Harga Beli" value="<?php echo $record->harga_beli ?>" required>
            </div>

            <div class="form-group">
                 <label>Keterangan</label>
                 <textarea type="text" name="keterangan_il" class="form-control" placeholder="Keterangan"><?php echo $record->keterangan_il ?></textarea>
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
