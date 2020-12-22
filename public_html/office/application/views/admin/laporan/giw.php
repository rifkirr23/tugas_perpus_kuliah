<head>
   <meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
   <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
</head>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4 class="pull-left" class="form-control"><b>Laporan Giw <?php echo $tempo ?></b></h4>
        <span class="pull-right" style="margin-right:1%;">
          <form method="post" action="<?php echo base_url('admin/laporan/sortgiw') ?>">
            <span class="pull-right" style="margin-right:5px;">
              <input type="submit" name="max" class="form-control btn btn-info" value="Filter Date" placeholder="Max Date"/>
            </span>
            <span class="pull-right" style="margin-right:5px;">
              <input type="date" name="max_date" class="form-control" value="<?php echo date('Y-m-d') ?>" placeholder="Max Date"/>
            </span>
            <span class="pull-right" style="margin-right:5px;">
              <input type="date" name="min_date" class="form-control" value="<?php echo date('Y-m-d') ?>" placeholder="Min Date"/>
            </span>
          </form>
        </span>
      </form>
    </div>
  </div>
</div>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Laporan Giw per Customer</b></h3>
    </div>

    <div class="box-body">
      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped no-margin" id="myresi">
          <thead>
            <tr>
              <th>No.</th>
              <th>Kode Mark Customer</th>
              <th>Jenis Barang</th>
              <th>Total Volume</th>
            </tr>
          </thead>
          <?php $no=1; foreach($giwcustomer as $gcust){         ?>
          <tbody>
            <tr>
              <td><?php echo $no; ?></td>
              <td><?php echo $gcust->kode ?></td>
              <td><?php echo $gcust->namalain ?></td>
              <td><?php echo round($gcust->total_volume,3) ?> m<sup>3</sup></td>
            </tr>
          </tbody>
          <?php $no++; } ?>
        </tbody>
      </table>
     </div>
   </div>
 </div>
</div>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Laporan Giw per Kategori</b></h3>
    </div>

    <div class="box-body">
      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped no-margin" id="myresi">
          <thead>
            <tr>
              <th>No.</th>
              <th>Jenis Barang</th>
              <th>Total Volume</th>
            </tr>
          </thead>
          <?php $no=1; foreach($giwkategori as $gkategori){         ?>
          <tbody>
            <tr>
              <td><?php echo $no; ?></td>
              <td><?php echo $gkategori->namalain ?></td>
              <td><?php echo round($gkategori->total_volume,3) ?> m<sup>3</sup></td>
            </tr>
          </tbody>
          <?php $no++; } ?>
        </tbody>
      </table>
     </div>
   </div>
 </div>
</div>

<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>

<script>
$(document).ready(function(){
  // Setup datatables
  $('#myresi').dataTable( {
    "pageLength": 10
  });

});
</script>
