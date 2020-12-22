<head>
   <meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
   <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
</head>
<?php if($this->session->flashdata('msg')=='okstok'){ ?>

   <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-success"></i> Barang Berhasil di tambahkan
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  </div></p>

<?php } ?>
<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4 class="pull-left" class="form-control"><b><?php echo $dc->kode ?></b></h4>
        <span class="pull-right" style="margin-right:1%;">
          <form method="post" action="<?php echo base_url('admin/laporan/sortgiw') ?>">
            <span class="pull-right" style="margin-right:5px;">
              <a href="<?php echo site_url('admin/container/viewpdf/'.$this->uri->segment(4)) ?>" class="form-control btn btn-danger"><i class="fa fa-file-o"> View Pdf </i></a>
            </span>
          </form>
        </span>
    </div>
  </div>
</div>

<form action="<?php echo site_url('admin/container/add_to_stok'); ?>" method="post">
  <div class="row">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"><b>List Resi & Giw</b></h3>
        <span class="pull-right" style="margin-right:5px;">
          <button type="submit" class="form-control btn btn-success"><i class="fa fa-cubes"> Tambahkan ke Stok Barang </i></button>
        </span>
        <span class="pull-right" style="margin-right:5px;">
          <a href="<?php echo site_url('admin/container/sesuaikan/'.$this->uri->segment(4)); ?>" class="diloadingaja btn btn-success olay"><i class="fa fa-spinner"> Sesuaikan </i></a>
        </span>
      </div>
      <input type="hidden" name="id_container" value="<?php echo $this->uri->segment(4) ?>">

      <div class="box-body">
        <div class="box-body table-responsive">
          <table class="table table-bordered table-striped no-margin" id="myresi">
            <thead>
              <tr>
                <th>Check / No</th>
                <th>Marking</th>
                <th>Nomor Resi</th>
                <th>Giw</th>
                <th>Volume</th>
                <th>Jumlah Koli</th>
                <th>Berat</th>
              </tr>
            </thead>
            <?php $no=1; $tkoli = 0; $tvolume=0; $tberat=0; foreach($data_resi as $dr){         ?>
            <tbody>
              <tr>
                <td>
                  <?php
                    if($dr->container_generate == 1){ ?>
                      <input type="checkbox" name="id_resi[]" value="<?php echo $dr->id_resi ?>" />
                  <?php
                    }else{
                      echo $no;
                    }
                  ?>
                </td>
                <td><?php echo $dr->marking ?></td>
                <td><?php echo $dr->nomor_resi ?></td>
                <td>
                  <?php
                    $datagiw = $this->db->select('nomor')->from('giw')->where('resi_id',$dr->id_resi)->where('container_id',$this->uri->segment(4))->get()->result();
                    foreach ($datagiw as $dg ) {
                      echo $dg->nomor.", ";
                    }
                   ?>
                </td>
                <td><?php echo round($dr->cbm,3) ?> M<sup>3</sup></td>
                <td><?php echo $dr->jumlah_koli ?> Koli</td>
                <td><?php echo round($dr->total_berat,3) ?> Kg</td>
              </tr>
            </tbody>
            <?php $no++; $tkoli+=$dr->jumlah_koli; $tvolume+=$dr->cbm; $tberat+=$dr->total_berat; } ?>
            <tr>
              <td colspan="4">Total</td>
              <td><?php echo round($tvolume,3) ?> m <sup>3</sup></td>
              <td><?php echo $tkoli ?></td>
              <td><?php echo round($tberat,3) ?> Kg</td>
              <td colspan="2"></td>
            </tr>
        </table>
       </div>
     </div>
   </div>
  </div>
</form>

<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url() ?>assets/jquery/loadingoverlay.min.js"></script>
<script type="text/javascript">
        $(document).ready(function(){setTimeout(function(){$(".alert").fadeIn('fast');}, 100);});
          //angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
          setTimeout(function(){$(".alert").fadeOut('fast');}, 5000);
</script>
<script>
$(document).ready(function(){
  // Setup datatables
  $('#myresi').dataTable( {
    "paging": false
  });

  $('.diloadingaja').click(function() {
    $.LoadingOverlay("show");
  });

});
</script>
