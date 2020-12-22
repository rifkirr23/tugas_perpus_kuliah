<head>
   <meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
   <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
</head>
<?php if($this->session->flashdata('msg')=='kosong'){ ?>

   <p><div style="display: none;" class="alert alert-warning alert-dismissable"><i class="icon fa fa-warning"></i>Tidak Bisa Kosong , Silahkan Pilih Opsi Proses
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  </div></p>

<?php } ?>
<?php if($this->session->flashdata('msg')=='nomobil'){ ?>

   <p><div style="display: none;" class="alert alert-warning alert-dismissable"><i class="icon fa fa-warning"></i>Harus Pilih Mobil
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  </div></p>

<?php } ?>
<?php if($this->session->flashdata('msg')=='okposisi'){ ?>

   <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-success"></i> Posisi Berhasil Dirubah
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  </div></p>

<?php } ?>
<?php if($this->session->flashdata('msg')=='oksj'){ ?>

   <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-success"></i> Sj Berhasil Dibuat
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  </div></p>

<?php } ?>
<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4 class="pull-left" class="form-control"><b>Stok Barang Gudang</b></h4>
        <span class="pull-right" style="margin-right:1%;">
            <span class="pull-right" style="margin-right:5px;">
              <a href="<?php echo site_url('admin/stok_barang/viewpdf') ?>" class="form-control btn btn-success"><i class="fa fa-print"> View Pdf </i></a>
            </span>
        </span>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-4">
    <!-- small box -->
    <div class="small-box bg-blue">
      <div class="inner">
        <h3><div id="barang_boleh_kirim"> </div></h3>

        <p>Barang Boleh Kirim</p>
      </div>
      <div class="icon">
        <i class="fa fa-check"></i>
      </div>
      <a href="#" class="small-box-footer">Wilopo Cargo</a>
    </div>
  </div>

    <div class="col-lg-4">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3><div id="barang_tidak_fix"> </div></h3>

          <p>Barang Tidak Fix</p>
        </div>
        <div class="icon">
          <i class="fa fa-close"></i>
        </div>
        <a href="#" class="small-box-footer">Wilopo Cargo</a>
      </div>
    </div>

  <div class="col-lg-4">
    <!-- small box -->
    <div class="small-box bg-red">
      <div class="inner">
        <h3><div id="barang_tidak_boleh"> </div></h3>

        <p>Barang Tidak Boleh Kirim</p>
      </div>
      <div class="icon">
        <i class="fa fa-close"></i>
      </div>
      <a href="#" class="small-box-footer">Wilopo Cargo</a>
    </div>
  </div>

</div>


<form method="post" action="<?php echo base_url('admin/stok_barang/pindahkan') ?>">
  <div class="row">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"><b>List Stok Barang Gudang</b></h3>
        <span class="pull-right" style="margin-right:1%;">
            <span class="pull-right" style="margin-right:15px;">
              <button type="submit" class="form-control btn btn-primary">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-spinner"> Save Process &nbsp;&nbsp;&nbsp;&nbsp;</i></button>
            </span>
            <span class="pull-right" style="margin-right:5px;">
              <select class="form-control btn btn-danger" name="id_proses">
                <option value="0">Pilih Opsi Proses</option>
                <option value="-1">Generate Surat jalan</option>
                <?php foreach($data_posisi as $dp){ ?>
                  <option value="<?php echo $dp->id_posisi_indo ?>"><?php echo $dp->tempat ?></option>
                <?php } ?>
              </select>
            </span>
            <span class="pull-right" style="margin-right:5px;">
              <select class="form-control btn btn-default" name="id_mobil">
                <option value="0">Pilih Mobil (Jika SJ)</option>
                <?php foreach($data_mobil as $dm){ ?>
                  <option value="<?php echo $dm->id_mobil ?>"><?php echo $dm->plat_mobil." ( ".$dm->limit_cbm." ) " ?></option>
                <?php } ?>
              </select>
            </span>
        </span>
      </div>

      <div class="box-body">
        <div class="box-body table-responsive">
          <table class="table table-bordered table-striped no-margin">
            <thead>
              <tr>
                <th>Check </th>
                <th>Marking</th>
                <th>Alamat</th>
                <th>Nomor</th>
                <th>Volume</th>
                <th>Berat</th>
                <th>Jumlah Koli</th>
                <th>Container</th>
                <th>Posisi</th>
                <th>Lamanya</th>
              </tr>
            </thead>
            <?php $no=1; $totalberat = 0; $totalcbm = 0; $totalkoli=0; $total_boleh_kirim = 0; $total_tidak_fix=0; $total_tidak_boleh=0;
             foreach($data_resi as $dr){
              $datagiw = $this->db->select('nomor,volume,ctns,id,id_invoice_product')
                                  ->from('invoice_product')
                                  ->where('resi_id',$dr->id_resi)
                                  ->join('giw', 'invoice_product.id_giw=giw.id','left')
                                  ->get()->result();

              if($dr->boleh_kirim == 1){
                $total_tidak_fix += $dr->cbm;
              }else if($dr->boleh_kirim == 2){
                $total_boleh_kirim += $dr->cbm;
              }else if($dr->boleh_kirim == 0){
                $total_tidak_boleh += $dr->cbm;
              }
              $jumlah_hari = 0;
              $tanggal_boleh_kirim  = strtotime($dr->tanggal_boleh_kirim);
              $tanggal_sekarang    = strtotime(date('Y-m-d'));
              $diff   =  $tanggal_sekarang - $tanggal_boleh_kirim;
              $jumlah_hari = floor($diff / (60 * 60 * 24)) ;
              if($jumlah_hari > 100){
                $jumlah_hari = "-";
              }
             ?>
             <!-- <b>Ekspedisi : </b>(".$dr->nama_ekspedisi." , ".$dr->almteks." , ".$dr->notelpeks.") <br /><br />" -->

            <tbody>
              <tr <?php if($dr->boleh_kirim == 1){ ?>style='background-color:#F9DF9C; color:black;' <?php } ?>
                  <?php if($dr->boleh_kirim == 2){ ?>style='background-color:#A9F096; color:black;' <?php } ?>
                  <?php if($dr->boleh_kirim == 0){ ?>style='background-color:#FABAA5; color:black;' <?php } ?>
                  <?php if($dr->boleh_kirim == 2 && $jumlah_hari > 2 && ($dr->tanggal_boleh_kirim != "" || $dr->tanggal_boleh_kirim != null) ){ ?> class="bg-light-blue" <?php } ?>>
                <td><input type="checkbox" name="id_resi[]" value="<?php echo $dr->id_resi ?>" />
                    <br /><a class="btn btn-default btn-xs" onclick="opengiw(<?php echo $no; ?>)" style="margin-top:10px;"><i class="fa fa-angle-right"> Giw  </i></a>
                </td>
                <?php
                  if($dr->id_ekspedisi >= 8 ){
                    $tipe_eks = "Ekspedisi ".$dr->tipe_ekspedisi;
                  }else{
                    $tipe_eks = $dr->nama_ekspedisi." , ".$dr->tipe_ekspedisi;
                  }
                ?>
                <td style="text-transform: capitalize; font-weight: bold;"><?php echo $dr->marking."<br /><br /><br />".$tipe_eks ?></td>
                <td>
                  <?php
                    if($dr->id_ekspedisi >= 8 ){
                      $proveks = $this->db->select('provinsi.nama')->where('id_prov',$dr->id_provinsi2)->get('provinsi')->row();
                      $kotaeks = $this->db->select('kabupaten.nama')->where('id_kab',$dr->id_kota2)->get('kabupaten')->row();
                      $keceks = $this->db->select('kecamatan.nama')->where('id_kec',$dr->id_kec2)->get('kecamatan')->row();
                      echo "<b> Ekspedisi : ".$proveks->nama." , ".$kotaeks->nama." , ".$keceks->nama."</b> <br /><br />".
                      $dr->nama_ekspedisi." , ".$dr->almteks." , ".$dr->notelpeks.
                      "<br /><br /> Alamat : ".$dr->almtcust." , ".$dr->namaprov." , ".$dr->namakota." , ".$dr->namakec.
                      " <br /><br /> No. Telp : ".$dr->telpcs."<br /> WA : ".$dr->wacs;
                    }else{
                      echo "<b> Alamat : ".$dr->namaprov." , ".$dr->namakota." , ".$dr->namakec."</b> <br /><br />".$dr->almtcust.
                      " <br /><br /> No. Telp : ".$dr->telpcs."<br /> WA : ".$dr->wacs;
                    }
                  ?>
                </td>
                <td><?php echo $dr->nomor_resi ?></td>
                <td><?php echo round($dr->cbm,3) ?> M<sup>3</sup></td>
                <td><?php echo $dr->jumlah_koli ?> Koli</td>
                <td><?php echo $dr->total_berat ?> Kg</td>
                <td><?php echo $dr->no_cont ?></td>
                <td><?php echo $dr->tempat ?></td>
                <td><?php
                      echo $jumlah_hari." hari";
                     ?>
                </td>
              </tr>
              <tr>

              </tr>

              <?php
                foreach ($datagiw as $dg ) { ?>
                  <tr class="listgiw<?php echo $no ?>" style="display:none;" >
                    <td><a class="btn btn-default btn-xs" onclick="closegiw(<?php echo $no; ?>)"><i class="fa fa-close"> Giw  </i></a></td>
                    <td><input type="checkbox" name="id_invoice_product[]" value="<?php echo $dg->id_invoice_product ?>" /></td>
                    <td>Giw : </td>
                    <td><?php echo $dg->nomor; ?></td>
                    <td><?php echo round($dg->volume*$dg->ctns,3) ?></td>
                    <td><?php echo $dg->ctns ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
              <?php
                }
              ?>
            </tbody>
            <?php $totalberat +=$dr->total_berat; $totalcbm +=$dr->cbm; $totalkoli +=$dr->jumlah_koli; $no++; } ?>
            <input type="hidden" id="total_boleh" value="<?php echo $total_boleh_kirim; ?>">
            <input type="hidden" id="total_tfix" value="<?php echo $total_tidak_fix; ?>">
            <input type="hidden" id="total_tboleh" value="<?php echo $total_tidak_boleh; ?>">
            <tr>
              <td colspan="5">Total</td>
              <td><?php echo round($totalcbm,3) ?> M<sup>3</sup></td>
              <td><?php echo round($totalberat,3) ?> Kg</td>
              <td><?php echo $totalkoli ?> Koli</td>
            </tr>
          </tbody>
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
  var totalnyaboleh = $("#total_boleh").val();
  $("#barang_boleh_kirim").html(Math.round(totalnyaboleh)+" m<sup>3</sup>");
  var totalnyatfix = $("#total_tfix").val();
  $("#barang_tidak_fix").html(Math.round(totalnyatfix)+" m<sup>3</sup>");
  var totalnyatboleh = $("#total_tboleh").val();
  $("#barang_tidak_boleh").html(Math.round(totalnyatboleh)+" m<sup>3</sup>");
  // Setup datatables
  $('#myresi').dataTable( {
    "paging": false
  });

});
</script>
<script type="text/javascript">
  function opengiw(id)
  {
    $(".listgiw"+id).show();
  }

  function closegiw(id)
  {
    $(".listgiw"+id).hide();
  }
</script>
