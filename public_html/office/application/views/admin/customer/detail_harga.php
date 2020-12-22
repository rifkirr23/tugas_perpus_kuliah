<head>
  <meta charset="utf-8">
  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">

</head>

  <?php $idcust = $this->uri->segment(4); ?>

  <div class="box-header with-border">
    <h3 class="box-title"><b>Harga Customer</b></h3>
    <span class="pull-right">
      <?php if ($jenis_barang_customer > 0){ ?>
        <form id="add-row-form" action="<?php echo base_url().'admin/customer/harga10'?>" method="post" enctype="multipart/form-data">
           <input type="hidden" name="id_cust" value="<?php echo $this->uri->segment(4) ?>" class="form-control" required />
           <button type="submit" id="add-row" class="btn btn-info"> - RP 500.000 </button>
        </form>
    <?php } ?>
    </span>
  </div>

  <div class="box-body">
    <?php if ($jenis_barang_customer == 0){ ?>
      <form id="add-row-form" action="<?php echo base_url().'admin/customer/buka_harga'?>" method="post" enctype="multipart/form-data">
         <input type="hidden" name="id_cust" value="<?php echo $this->uri->segment(4) ?>" class="form-control" required />
         <button type="submit" id="add-row" class="btn btn-danger">Buka Harga Customer</button>
      </form>
    <?php }else{ ?>
    <div class="box-body table-responsive">
      <!-- <table class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info" id="mytable">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Nama Lain</th>
            <th>Harga</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rowjenisbarang as $jb){ ?>
            <tr>
              <td><?php echo $jb->nama ?></td>
              <td><?php echo $jb->namalain ?></td>
              <td><?php echo $jb->harga ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table> -->

      <form id="add-row-form" action="<?php echo base_url().'admin/customer/update_harga/'?>" method="post" enctype="multipart/form-data">
         <table class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info" id="mytable">
           <thead>
             <tr>
               <th>Nama</th>
               <th>Nama Lain</th>
               <th>Harga</th>
             </tr>
           </thead>
           <tbody>
             <input type="hidden" name="id_cust" value="<?php echo $this->uri->segment(4) ?>">
             <?php foreach ($rowjenisbarang as $jbform){ ?>
               <input type="hidden" name="id_jenis_barang_customer[]" value="<?php echo $jbform->id_jenis_barang_customer ?>">
               <tr>
                 <td><?php echo $jbform->nama ?></td>
                 <td><?php echo $jbform->namalain ?></td>
                 <td><input type="text" class="form-control" name="harga[]" value="<?php echo $jbform->harga ?>"></td>
               </tr>
             <?php } ?>
             <tr>
               <td>
                 <input type="submit" value="Save Changes" class="btn btn-success">
               </td>
             </tr>
           </tbody>
         </table>
      </form>

   </div>
 <?php } ?>
 </div>



<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>
<script src="<?php echo base_url() ?>assets/jquery/loadingoverlay.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    $( "#cek" ).click(function() {
    $.LoadingOverlay("show");
    });
  });
</script>
