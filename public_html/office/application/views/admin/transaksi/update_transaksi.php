<style type="text/css">
    .entry:not(:first-of-type)
{
    margin-top: 10px;
}

 .entry1:not(:first-of-type)
{
    margin-top: 10px;
}

.glyphicon
{
    font-size: 12px;
}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><b>Update Transaksi </b></h3>
            </div>
            <div class="box-body">

                    <form id="fileupload" action="<?php echo base_url().'admin/transaksi/update'?>" method="post" enctype="multipart/form-data">

                     <input type="hidden" name="id_transaksi" class="form-control" placeholder="The Primary" value="<?php echo $transaksi['id_transaksi'] ?>" required>
                     <input type="hidden" name="id_invoice" class="uang form-control" placeholder="The Primary" value="<?php echo $transaksi['id_invoice'] ?>" required>
                     <input type="hidden" name="id_cust" value="<?php echo $transaksi['id_cust'] ?>"?>
                     <input type="hidden" name="id_cgrup" value="<?php echo $transaksi['id_cgrup'] ?>"?>
                     <?php if($transaksi['id_cust']!=0){ ?>
                       <div class="form-group">
                       <label>Kode Mark</label>
                           <input type="text" value="<?php echo $transaksi['kode'] ?>" class="form-control" readonly>
                       </div>
                     <?php }else if($transaksi['id_cust']==0){ ?>
                       <div class="form-group">
                       <label>Kode Mark Customer grup</label>
                           <input type="text" value="<?php echo $transaksi['kode_cgrup'] ?>" class="form-control" readonly>
                       </div>
                     <?php } ?>
                     <div class="form-group">
                     <label>Tanggal Transaksi</label>
                         <input type="text"  value="<?php echo $transaksi['tanggal_transaksi'] ?>" class="form-control date" readonly>
                     </div>

                     <div class="form-group">
                     <label>Kode Transaksi</label>
                         <input type="text" name="kode_transaksi" value="<?php echo $transaksi['kode_transaksi'] ?>" class="form-control" readonly>
                     </div>

                     <div class="form-group">
                     <label>Jumlah RMB</label>
                         <input type="text" name="jumlah_rmb" class="form-control" placeholder="Jumlah Rmb" value="<?php echo $transaksi['jumlah_rmb'] ?>" required readonly>
                     </div>

                     <div class="form-group">
                     <label>Fee Bank</label>
                         <input type="text" name="fee_bank" class="form-control" placeholder="Fee Bank" value="<?php echo $transaksi['fee_bank'] ?>" required readonly>
                     </div>

                     <div class="form-group">
                     <label>Fee CS</label>
                         <input type="text" name="fee_cs" class="uang form-control" placeholder="Fee Bank" value="<?php echo $transaksi['fee_cs'] ?>" required readonly>
                     </div>

                     <div class="form-group">
                     <label>Kurs Jual </label>
                         <input type="text" name="kurs_jual" class="uang form-control" placeholder="Kurs Jual" value="<?php echo $transaksi['kurs_jual'] ?>" required readonly>
                     </div>

                     <div class="form-group">
                     <label>Kurs Beli</label>
                         <input type="text" name="kurs_beli" class="uang form-control" placeholder="Fee Bank" value="<?php echo $transaksi['kurs_beli'] ?>" required readonly>
                     </div>

                     <div class="form-group">
                     <label>Bank Tujuan (Text)</label>
                         <textarea type="text" name="bank_tujuan" class="form-control" placeholder="Bank Tujuan" readonly><?php echo $transaksi['bank_tujuan'] ?></textarea>

                     </div>

                     <div class="form-group">
                        <label>Bukti Bayar Rmb</label>
                        <div class="control-group" id="fields1">
                            <div class="controls1">
                                <div class="entry1 input-group col-xs-3">
                                  <input class="btn btn-primary" name="file_bb_rmb[]" type="file">
                                  <span class="input-group-btn">
                                  <button class="btn btn-success btn-add1" type="button">
                                  <span class="glyphicon glyphicon-plus"></span>
                                  </button>
                                  </span>
                               </div>
                            </div>
                        </div>
                      </div>

                   <div class="form-group">
                      <table>
                        <tr>
                        <?php $no=1; foreach($file2 as $ff){ ?>
                         <td>
                           <img src="<?php echo base_url() ?>assets/bukti_bayar_rmb/<?php echo $ff->file_bb_rmb ?>" height="130px" width ="150px">
                         </td>
                        <?php } ?>
                        </tr>
                     </table>
                   </div>

            </div>
        <?php if($transaksi['status']==2){ ?>

        <button class="btn btn-success submitt" type="submit">Save</button>

        <?php }else if($transaksi['status']==3){ ?>

                    <i>Transaksi Completed</i>

        <?php }else{ echo "<i>Transaksi Harus diproses terlebih dahulu</i>"; } ?>
        </form>
     <script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
     <script src="<?php echo base_url().'assets/jquery/jquery.mask.min.js'?>"?>></script>
     <script src="<?php echo base_url() ?>assets/jquery/loadingoverlay.min.js"></script>
     <script>
    $(document).ready(function(){

                // Format mata uang.
                $( '.uang' ).mask('000.000.000.000', {reverse: true});

            })
    </script>

    <script type="text/javascript">
  $('.submitt').on('click', function(){
         $.LoadingOverlay("show");
          //console.log('wtheck');
        });
    </script>

    <script type="text/javascript">
         $(function(){
              $(document).on('click', '.btn-add1', function(e){
                  e.preventDefault();

                  var controlForm = $('.controls1:first'),
                      currentEntry = $(this).parents('.entry1:first'),
                      newEntry = $(currentEntry.clone()).appendTo(controlForm);

                  newEntry.find('input').val('');
                  controlForm.find('.entry1:not(:last) .btn-add1')
                      .removeClass('btn-add1').addClass('btn-remove1')
                      .removeClass('btn-success').addClass('btn-danger')
                      .html('<span class="glyphicon glyphicon-minus"></span>');
              }).on('click', '.btn-remove1', function(e){
                $(this).parents('.entry1:first').remove();
                  e.preventDefault();
                  return false;
              });
          });
    </script>
