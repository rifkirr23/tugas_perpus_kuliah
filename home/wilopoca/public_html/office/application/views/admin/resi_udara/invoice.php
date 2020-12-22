<head>
  <meta charset="utf-8">
  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
  <link href="<?php echo base_url().'assets/jquery/select2.min.css'?>" rel="stylesheet" />
</head>

<div class="row">
  <div class="box box-primary">
    <form class="" action="<?php echo site_url() ?>admin/resi_udara/generate_invoice" method="post">
      <div class="box-header with-border">
        <h3 class="box-title"><b>Generate Invoice Resi Udara</b></h3>
        <span class="pull-right">
             <button class="btn btn-warning" type="submit"><i class="fa fa-paper-plane"> Generate Invoice</i></button>
        </span>
      </div>
      <div class="box-body">
        <div class="box-body table-responsive">
          <table class="table table-bordered table-striped no-margin" id="resiinv">
            <thead>
              <tr>
                <th><input type="checkbox" onclick="checkAll(this)"></th>
                <th>Kode Mark</th>
                <th>Nomor</th>
                <th>Invoice</th>
                <th>Tanggal</th>
                <th>Ctns</th>
                <th>Berat</th>
                <th>Harga Jual</th>
                <th>Harga Beli</th>
                <th>Harga Jual Goni</th>
                <th>Harga Beli Goni</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($resi as $record) { ?>
                <tr>
                  <th><input type="checkbox" name="id_resi_udara[]" value="<?php echo $record->id_resi_udara ?>" /></th>
                  <th><?php echo $record->kode ?></th>
                  <th><?php echo $record->nomor_resi ?></th>
                  <th><?php echo $record->kode_invoice ?></th>
                  <th><?php echo $record->tanggal_resi ?></th>
                  <th><?php echo $record->ctns ?></th>
                  <th><?php echo $record->berat ?></th>
                  <th><?php echo $record->harga_jual ?></th>
                  <th><?php echo $record->harga_beli ?></th>
                  <th><?php echo $record->harga_jual_goni ?></th>
                  <th><?php echo $record->harga_beli_goni ?></th>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </form>
  </div>
</div>


<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/jquery/select2.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>
<script src="<?php echo base_url() ?>assets/jquery/loadingoverlay.min.js"></script>
<script src="<?php echo base_url().'assets/jquery/jquery.mask.min.js'?>"?>></script>

<script type="text/javascript">
 function checkAll(bx) {
    var cbs = document.getElementsByTagName('input');
    for(var i=0; i < cbs.length; i++) {
      if(cbs[i].type == 'checkbox') {
        cbs[i].checked = bx.checked;
      }
    }
  }
$(document).ready(function(){

  $( "#cek" ).click(function() {
  $.LoadingOverlay("show");
  });

  $('#resiinv').dataTable( {
    "pageLength": 100
  });

});
</script>
