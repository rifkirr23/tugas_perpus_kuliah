<head>
   <meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
   <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
</head>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4 class="pull-left" class="form-control"><b>Laporan Customer<?php echo $tempo ?></b></h4>
        <span class="pull-right" style="margin-right:1%;">
          <div class="btn-group">
            <button type="button" class="btn btn-danger" style="width:250px;">Rentang Waktu</button>
            <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
              <span class="caret"></span>
              <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu"  style="width:250px;">
              <li><a href="<?php echo site_url('admin/laporan/customer/30') ?>"> < 30 hari </a></li>
              <li><a href="<?php echo site_url('admin/laporan/customer/60') ?>"> 30 - 60 Hari </a></li>
              <li><a href="<?php echo site_url('admin/laporan/customer/90') ?>"> 60 - 90 Hari </a></li>
              <li><a href="<?php echo site_url('admin/laporan/customer/lebih90') ?>"> > 90 Hari </a></li>
              <li><a href="<?php echo site_url('admin/laporan/customer/tidak_pernah') ?>"> Tidak Pernah Import dan Titip Trf</a></li>
            </ul>
          </div>
        </span>
      </form>
    </div>
  </div>
</div>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Laporan Customer Aktif</b></h3>
    </div>

    <div class="box-body">
      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped no-margin" id="myresi">
          <thead>
            <tr>
              <th>No.</th>
              <th>Kode Mark Customer</th>
              <th>Nama</th>
            </tr>
          </thead>
          <?php $no=1; foreach($customer as $cust){         ?>
          <tbody>
            <tr>
              <td><?php echo $no; ?></td>
              <td><?php echo $cust->kode ?></td>
              <td><?php echo $cust->nama ?></td>
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
