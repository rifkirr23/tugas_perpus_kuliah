<div class="modal fade" id="modeditkurs">
   <div class="modal-dialog">
      <div class="modal-content">
      	<div class="modal-header">
				<h4>Update Kurs Beli <?php echo $r->kode_transaksi; ?></h4>
      	</div>

        <form class="" action="<?php echo base_url() ?>admin/pembelian/save_editkurs" method="post">
        	<div class="modal-body">
            <input type="hidden" name="id_transaksi" value="<?php echo $r->id_transaksi; ?>">
        		<div class="form-group">
              <input type="text" name="kurs_beli" class="form-control" placeholder="Kurs Beli" value="<?php echo $r->kurs_beli;  ?>">
            </div>
          </div>
        	<div class="modal-footer">
            <button type="submit" class="btn btn-info">Save</button>
        		<a href="#" class="btn btn-default" data-dismiss="modal">Tutup</a>
        	</div>
        </form>
      </div>
   </div>
</div>
