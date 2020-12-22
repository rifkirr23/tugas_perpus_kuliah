<head>
   <meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
   <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
</head>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4 class="pull-left" class="form-control"><b>Laporan Penjualan Sales <?php echo $tanggal_now ?></b></h4>
      <?php if($this->session->userdata('level') == "sales" || $this->session->userdata('level') == "saleso" || $this->session->userdata('level') == "crm"){ ?>
        <form method="post" action="<?php echo base_url('admin/laporan/filter_sales') ?>">
          <span class="pull-right" style="margin-right:5px;">
            <input type="submit" name="max" class="form-control btn btn-success" value="Filter Date" placeholder="Max Date"/>
          </span>
          <span class="pull-right" style="margin-right:5px;">
            <input type="date" name="max_date" class="form-control" value="<?php echo $now ?>" placeholder="Max Date"/>
          </span>
          <span class="pull-right" style="margin-right:5px;">
            <input type="date" name="min_date" class="form-control" value="<?php echo $now ?>" placeholder="Min Date"/>
          </span>
          <span class="pull-right" style="margin-right:5px;">
            <select class="form-control" name="id_sales">
              <?php foreach ($data_sales as $ds ){ ?>
                <option value="<?php echo $ds->id_pengguna; ?>"><?php echo $ds->username ?></option>
              <?php } ?>
            </select>
          </span>
          <!-- <input type="hidden" name="id_sales" value="<?php //echo $this->session->userdata('id_pengguna') ?>"> -->
        </form>
      <?php }else{ ?>
        <form method="post" action="<?php echo base_url('admin/laporan/filter_sales') ?>">
          <span class="pull-right" style="margin-right:5px;">
            <input type="submit" name="max" class="form-control btn btn-success" value="Filter Date" placeholder="Max Date"/>
          </span>
          <span class="pull-right" style="margin-right:5px;">
            <input type="date" name="max_date" class="form-control" value="<?php echo $now ?>" placeholder="Max Date"/>
          </span>
          <span class="pull-right" style="margin-right:5px;">
            <input type="date" name="min_date" class="form-control" value="<?php echo $now ?>" placeholder="Min Date"/>
          </span>
          <span class="pull-right" style="margin-right:5px;">
            <select class="form-control" name="id_sales">
              <?php foreach ($data_sales as $ds ){ ?>
                <option value="<?php echo $ds->id_pengguna; ?>"><?php echo $ds->username ?></option>
              <?php } ?>
            </select>
          </span>
        </form>
      <?php } ?>
    </div>
    <p><i><center>Silahkan Filter Nama Sales dan Tanggal Terlebih Dahulu</center></i></p>
  </div>
</div>

<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
