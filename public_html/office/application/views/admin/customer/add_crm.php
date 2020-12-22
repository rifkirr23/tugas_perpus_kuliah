<head>
  <meta charset="utf-8">
  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
  <link href="<?php echo base_url().'assets/jquery/select2.min.css'?>" rel="stylesheet" />
</head>

<?php if($this->session->flashdata('msg')=='oksave'){ ?>

 <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Add Crm Berhasil
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
</div></p>

<?php } ?>

<?php if($this->session->flashdata('msg')=='nocheckbox'){ ?>

 <p><div style="display: none;" class="alert alert-danger alert-dismissable"><i class="icon fa fa-close"></i>Checkbox Harus terisi
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
</div></p>

<?php } ?>

<div class="row">
  <div class="box box-primary">
    <form class="" action="<?php echo site_url() ?>admin/customer/save_crm" method="post">
      <div class="box-header with-border">
        <h3 class="box-title"><b>Customer No Crm</b></h3>
        <span class="pull-right">
             <button class="btn btn-warning" type="submit"><i class="fa fa-paper-plane"> Save </i></button>
        </span>
        <span class="pull-right" style="margin-right:5px;">
          <select class="form-control" name="id_crm">
            <?php foreach ($crm as $dc ){ ?>
              <option value="<?php echo $dc->id_pengguna; ?>"><?php echo $dc->username ?></option>
            <?php } ?>
          </select>
        </span>
      </div>
      <div class="box-body">
        <div class="box-body table-responsive">
          <table class="table table-bordered table-striped no-margin" id="addcrm">
            <thead>
              <tr>
                <th><input type="checkbox" onclick="checkAll(this)"></th>
                <th>Tanggal Daftar</th>
                <th>Kode Marking</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Whatsapp</th>
                <th>Alamat</th>
                <th>Sales</th>
                <th>Crm</th>
                <th>Campaign</th>
                <th>Aktivasi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($customer as $record) { ?>
                <tr>
                  <th><input type="checkbox" name="id_cust[]" value="<?php echo $record->id_cust ?>" /></th>
                  <th><?php echo $record->tanggal_daftar ?></th>
                  <th><?php echo $record->kode ?></th>
                  <th><?php echo $record->nama ?></th>
                  <th><?php echo $record->email ?></th>
                  <th><?php echo $record->whatsapp ?></th>
                  <th><?php echo $record->alamat ?></th>
                  <th><?php echo $record->nama_pengguna ?></th>
                  <th><?php echo $record->nama_crm ?></th>
                  <th><?php echo $record->nama_campaign ?></th>
                  <th><?php echo $record->s_aktivasi ?></th>
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

  $('#addcrm').dataTable( {
    "pageLength": 100
  });

});
</script>
<script type="text/javascript">
        $(document).ready(function(){
          setTimeout(function(){$(".alert").fadeIn('fast');}, 100);});
          //angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
          setTimeout(function(){$(".alert").fadeOut('fast');}, 7000);
</script>
