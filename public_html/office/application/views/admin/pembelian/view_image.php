<div class="modal fade" id="modeditbuku">
   <div class="modal-dialog">
      <div class="modal-content">
      	<div class="modal-header">
        <?php $no=1; foreach($record as $r){ ?>
				<h4>View Image Upload <?php echo $r->kode_transaksi ?></h4>
      	</div>

      	<div class="modal-body">

      		<div class="form-group">
             <center>File Bank Tujuan</center>
             <?php if($r->file_bank_tujuan == ""){ ?>
             <span><b><?php echo $r->bank_tujuan ?></b></span>
             <?php }else{ ?>
             <p><center><img src="<?php echo base_url() ?>assets/bank_tujuan/<?php echo $r->file_bank_tujuan ?>" width="100%"></center></p>
              <?php } ?>
           </div>
      	<?php } ?>


          <div class="form-group">
                     <center>Bukti Bayar Rmb</center>
          <?php $no=1; foreach($file2 as $ff){ ?>

                     <p><center><img src="<?php echo base_url() ?>assets/bukti_bayar_rmb/<?php echo $ff->file_bb_rmb ?>" width="100%"></center></p>
                     <?php echo $ff->file_bb_rmb ?>
                     </div>
          <?php } ?>
          <p><br/></p>
      	<div class="modal-footer">

      		<a href="#" class="btn btn-default" data-dismiss="modal">Tutup</a>
      	</div>

      </div>
   </div>
</div>
