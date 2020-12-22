<head>
  <meta charset="utf-8">
  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">

</head>

  <?php $idcust = $this->uri->segment(4); ?>

  <div class="box-header with-border">
    <h3 class="box-title"><b>Cbm Perbulan <?php echo date('Y') ?></b></h3>
    <span class="pull-right">

    </span>

  </div>

    <div class="box-body">
    <div class="box-body table-responsive">

      <table class="table table-bordered table-striped no-margin" id="mybarcode">
        <thead>
          <tr>
            <th>Bulan </th>
            <th>Cbm </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($cbm_perbulan as $cbmper){ ?>
            <tr>
              <td><?php echo bindo($cbmper->bulan) ?></td>
              <td><?php echo round($cbmper->cbm,3) ?> m<sup>3</sup></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>

     <div id="view_image"></div>
     <div id="view_keterangan"></div>

 </div>
 </div>

 <script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
 <script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
 <script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>
