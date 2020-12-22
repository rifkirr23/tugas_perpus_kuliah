<div class="modal fade" id="Modalbayar_deposit">
      <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                 <h4 class="modal-title" id="myModalLabel">Pembayaran Deposit </h4>
             </div>
             <form id="add-row-form" action="<?php echo base_url().'admin/invoice_barang/simpan_deposit'?>" method="post" enctype="multipart/form-data">
             <?php
             $status_update = 2;
             $label_jumlah = "";
              if($get_data_inv->id_cgrup > 0){
                $label_jumlah = $get_data_inv->kode_cgrup;
                $deposit = $get_data_inv->deposit_cgrup;
              }else if($get_data_inv->id_cgrup == 0){
                $deposit = $get_data_inv->deposit;
              }else{
                $deposit = -1;
                $status_update = 0;
              }
             ?>
               <div class="modal-body">
                  <div><h5>Jumlah Deposit <?php echo $label_jumlah. " Rp.". number_format($deposit); ?></h5></div>
                  <?php if($get_data_inv->status_invoice == 0){ ?>

                    <?php if($deposit<=0){ $status_update = 0; ?>
                      <h5>Deposit Tidak Mencukupi</b></i> </h5>
                    <?php }else if($deposit>=0){ ?>
                      <h5>Proses Invoice <i><?php echo $get_data_inv->kode_invoice ?></i> sebesar Rp. <?php echo number_format($deposit); ?>?</h5>
                    <?php } ?>

                  <?php }else{ $status_update = 0; ?>
                    <h5>Invoice Telah lunas</h5>
                  <?php } ?>
                  <br/>
                  <input type="hidden" name="id_invoice" value="<?php echo $get_data_inv->id_invoice ?>" class="form-control" required>
                  <input type="hidden" name="kode_invoice" value="<?php echo $get_data_inv->kode_invoice ?>" class="form-control" required>

               </div>
               <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <?php if($status_update != 0){ ?>
                      <button type="submit" id="add-row" class="btn btn-primary">Save</button>
                    <?php } ?>
               </div>
          </form>
        </div>
    </div>
 </div>
