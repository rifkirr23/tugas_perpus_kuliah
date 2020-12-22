<div class="modal fade" id="modpacking">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
      	<div class="modal-header">
				      <h4>File Invoice & Packing List <?php echo $record->nomor_resi ?></h4>
      	</div>

      	<div class="modal-body">
          <div class="form-group">
             <?php $file= $this->db->where('nomor_resi',$record->nomor_resi)->get('file_packing')->result(); ?>
             <table class="table table-bordered table-striped">
               <tr>
                 <th>Tgl</th>
                 <th>File</th>
                 <th>Action</th>
               </tr>
               <?php $no=1; foreach($file as $ff){ $extension=end(explode(".", $ff->file_pl)); ?>
                 <tr>
                   <td><?php echo $ff->tanggal_upload; ?></td>
                   <td>
                     <?php if($extension == "jpg" || $extension == "jpeg" || $extension == "png"){ ?>
                       <a target="_blank" href="<?php echo base_url() ?>assets/file_pl/<?php echo $ff->file_pl ?>">
                         <img src="<?php echo base_url() ?>assets/file_pl/<?php echo $ff->file_pl ?>" width="100%">
                       </a>
                     <?php }else{ ?>
                       <a href="<?php echo base_url() ?>assets/file_pl/<?php echo $ff->file_pl ?>" target="_blank"><?php echo $ff->file_pl; ?></a>
                     <?php } ?>
                   </td>
                   <td><a onclick="return confirm(`Delete File Inv PL?`);" href="<?php echo site_url('admin/resi/delete_pl/'.$ff->id_file_packing) ?>" class="btn btn-danger btn-xs"><i class="fa fa-close"></i></a></td>
                 </tr>
               <?php $no++; } ?>
            </table>
          </div>
          <p><br/></p>
      	<div class="modal-footer">

      		<a href="#" class="btn btn-default" data-dismiss="modal">Tutup</a>
      	</div>

      </div>
   </div>
</div>
