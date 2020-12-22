<div class="box box-info">
   <div class="box-header with-border">
     <h3 class="box-title">Resi No Invice & Packing List</h3>

     <div class="box-tools pull-right">
       <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
       </button>
       <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
     </div>
   </div>
   <!-- /.box-header -->
   <div class="box-body">
     <div class="table-responsive">
       <table class="table no-margin">
         <thead>
         <tr>
           <th>Semenjak Tanggal</th>
           <th>Nomor Resi</th>
           <th>Kode Marking</th>
           <th>Status</th>
         </tr>
         </thead>
         <tbody>
           <?php foreach($reqpl as $rp){ ?>
             <tr>
               <td><?php echo $rp->tanggal_fpr ?></td>
               <td><?php echo $rp->nomor_resi ?></td>
               <td><?php echo $rp->kode_marking ?></td>
               <td><span class="label label-warning">Need</span></td>
               <td>
                 <div class="sparkbar" data-color="#f39c12" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div>
               </td>
             </tr>
           <?php } ?>
         </tbody>
       </table>
     </div>
     <!-- /.table-responsive -->
   </div>
   <!-- /.box-body -->
   <div class="box-footer clearfix">
     <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Data</a>
   </div>
   <!-- /.box-footer -->
 </div>
