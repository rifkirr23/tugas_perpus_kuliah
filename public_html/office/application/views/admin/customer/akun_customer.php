<div class="modal fade" id="ModalAkun" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                 <h4 class="modal-title" id="myModalLabel">Akun Login </h4>
             </div>
             <?php if($cek_akun > 0){ ?>
                 <form id="add-row-form" action="<?php echo base_url().'admin/customer/new_password'?>" method="post" enctype="multipart/form-data">
                   <input type="hidden" name="id_cust" value="<?php echo $data_cust->id_cust ?>" class="form-control" required>
                   <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="add-row" class="btn btn-primary">Generate New Password</button>
                   </div>
                 </form>
              <?php }else{ ?>
               <form id="add-row-form" action="<?php echo base_url().'admin/customer/buat_akun'?>" method="post" enctype="multipart/form-data">
                 <input type="hidden" name="id_cust" value="<?php echo $data_cust->id_cust ?>" class="form-control" required>
                 <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" id="add-row" class="btn btn-primary">Buat Akun</button>
                 </div>
            </form>
          <?php } ?>
        </div>
    </div>
 </div>
