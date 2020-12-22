<div class="modal fade" id="modeditbuku">
   <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">

        <h4>Bukti Bayar Vendor</h4>
        </div>

        <div class="modal-body">

         <div class="form-group">
                     <center>Bukti Bayar </center>
          <?php $no=1; foreach($file1 as $f){ ?>

            <p><center><img src="<?php echo base_url() ?>assets/bukti_beli/<?php echo $f->bukti_beli ?>" height="300px" width="350px"></center></p>

                     </div>
          <?php } ?>

          <p><br/></p>
        <div class="modal-footer">

          <a href="#" class="btn btn-default" data-dismiss="modal">Tutup</a>
        </div>

      </div>
   </div>
</div>
