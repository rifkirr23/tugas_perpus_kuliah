<div class="modal fade" id="modvm">
   <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">

        <h4>Gambar <?php echo $file1->judul_buku; ?></h4>
        </div>

        <div class="modal-body">

          <div class="form-group">
            <center>Foto KTP </center>
            <?php
              if($file1->gambar != "" || $file1->gambar != null){ ?>
                <p><center><img src="<?php echo base_url() ?>assets/gambar/<?php echo $file1->gambar ?>" height="300px" width="350px"></center></p>
              <?php }else{
                echo "<center>No Image</center>";
              } ?>

         </div>
        <div class="modal-footer">

          <a href="#" class="btn btn-default" data-dismiss="modal">Tutup</a>
        </div>

      </div>
   </div>
</div>
