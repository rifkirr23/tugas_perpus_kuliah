<div class="modal fade" id="modeedititem">
   <div class="modal-dialog">
      <div class="modal-content">
      	<div class="modal-header">
				<h4>Edit Item</h4>
      	</div>
        <div class="modal-body">
          <form action="<?php echo base_url().'admin/resi_udara/update'?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_cust" class="form-control" value="<?php echo $record->id_cust ?>" required>
            <input type="hidden" name="id_resi_udara" class="form-control" value="<?php echo $record->id_resi_udara ?>" required>
            <input type="hidden" name="id_invoice" class="form-control" value="<?php echo $record->id_invoice ?>" required>
            <input type="hidden" name="id_invoice_beli" class="form-control" value="<?php echo $record->id_invoice_beli ?>" required>

            <div class="form-group">
                <label>Nomor Resi</label>
                <input name="nomor_resi" class="form-control" value="<?php echo $record->nomor_resi ?>" placeholder="Nomor Resi" type="text" readonly>
            </div>

            <div class="form-group">
                <label>Nama Barang</label>
                <input name="nama_barang" class="form-control" value="<?php echo $record->nama_barang ?>" placeholder="Nama Barang / Deskripsi Barang" type="text">
            </div>

            <div class="form-group">
                <label>Ctns</label>
                <input name="ctns" placeholder="Ctns" class="form-control" value="<?php echo $record->ctns ?>" type="text">
            </div>

            <div class="form-group">
                <label>Berat</label>
                <input name="berat" placeholder="Berat" type="text" value="<?php echo $record->berat ?>" class="form-control">
            </div>

            <div class="form-group">
                <label>Tanggal Resi</label>
                <input name="tanggal_resi" type="date" value="<?php echo $record->tanggal_resi ?>" class="form-control">
            </div>

            <div class="form-group">
                <label>Harga Jual</label>
                <input name="harga_jual" type="text" placeholder="Harga Jual" value="<?php echo $record->harga_jual ?>" class="form-control">
            </div>

            <div class="form-group">
                <label>Harga Beli</label>
                <input name="harga_beli" type="text" placeholder="Harga Beli" value="<?php echo $record->harga_beli ?>" class="form-control">
            </div>

            <div class="form-group">
                <label>Harga Jual Goni</label>
                <input name="harga_jual_goni" type="text" placeholder="Harga Jual Goni" value="<?php echo $record->harga_jual_goni ?>" class="form-control">
            </div>

            <div class="form-group">
                <label>Harga Beli Goni</label>
                <input name="harga_beli_goni" type="text" value="<?php echo $record->harga_beli_goni ?>" placeholder="Harga Beli Goni" class="form-control">
            </div>

            <div class="form-group">
                <label>Harga Ekspedisi Lokal</label>
                <input name="harga_ekspedisi_lokal" type="text" value="<?php echo $record->harga_ekspedisi_lokal ?>" placeholder="Harga Ekspedisi Lokal" class="form-control">
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
