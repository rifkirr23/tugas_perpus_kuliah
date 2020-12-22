<div class="modal fade" id="modvm">
   <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">

        <h4>Image Customer <?php echo $file1['kode']; ?></h4>
        </div>

        <div class="modal-body">

          <div class="form-group">
            <center>Foto KTP </center>
            <?php
              if($file1['foto_ktp'] != "" || file1['foto_ktp'] != null){ ?>
                <p><center><img src="<?php echo base_url() ?>assets/foto_ktp/<?php echo $file1['foto_ktp'] ?>" height="300px" width="350px"></center></p>
              <?php }else{
                echo "<center>No Image</center>";
              } ?>

         </div>
         <div class="form-group">
           <center>Foto Surat Ketentuan</center>
           <?php
             if($file1['foto_sk']!=""){ ?>
               <p><center><img src="<?php echo base_url() ?>assets/foto_sk/<?php echo $file1['foto_sk'] ?>" height="300px" width="350px"></center></p>
             <?php }else{
               echo "<center>No Image</center>";
             } ?>
        </div>
          <p><br/></p>
        <div class="modal-footer">

          <a href="#" class="btn btn-default" data-dismiss="modal">Tutup</a>
        </div>

      </div>
   </div>
</div>
