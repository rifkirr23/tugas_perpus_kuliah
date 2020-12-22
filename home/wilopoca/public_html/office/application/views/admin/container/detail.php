<head>
   <meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
   <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
</head>
<?php
if(strpos($dc->kode, 'GZ2') !== false){
  $tipenya = "FCL";
}else{
  $tipenya = "LCL";
}
?>

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
              <div class="btn-group">
                <button type="button" class="btn btn-danger"><i class="fa fa-file-o"> View Pdf </i></button>
                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
                  <span class="caret"></span>
                  <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">

                  <li><a href="<?php echo site_url('admin/container/viewpdf/'.$this->uri->segment(4)) ?>/alamat">
                      <i class="fa fa-file-o"> Pdf With Alamat </i>
                      </a>
                  </li>

                  <li><a href="<?php echo site_url('admin/container/viewpdf/'.$this->uri->segment(4)) ?>/noalamat">
                      <i class="fa fa-file-o"> Pdf No Alamat </i>
                      </a>
                  </li>

                </ul>
              </div>
            </span>
            <?php if ($dc->status == 4 ){ ?>
              <?php if($tipenya == "FCL"){ ?>
                <span class="pull-right" style="margin-right:5px;">
                  <a onclick="return confirm(`Container Sudah Sampai?`);" href="<?php echo site_url('admin/container/arrived_cont/'.$this->uri->segment(4)); ?>"
                     class="form-control btn btn-primary olay"><i class="fa fa-book"> Arrived </i></a>
                </span>
              <?php } ?>
            <?php } ?>
            <span class="pull-right" style="margin-right:5px;">
              <a href="<?php echo site_url('admin/container/sesuaikan/'.$this->uri->segment(4)); ?>" class="diloadingaja btn btn-success olay"><i class="fa fa-spinner"> Sesuaikan </i></a>
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
      <h3 class="box-title"><b>List Resi & Giw</b></h3>
    </div>

    <div class="box-body">
      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped no-margin" id="myresi">
          <thead>
            <tr>
              <th>No.</th>
              <th>Marking</th>
              <th>Nomor Resi</th>
              <th>Giw</th>
              <th>Volume</th>
              <th>Jumlah Koli</th>
              <th>Berat</th>
              <th>Gudang</th>
              <th>Alamat</th>
            </tr>
          </thead>
          <?php $no=1; $tkoli = 0; $tvolume=0; $tberat=0; foreach($data_resi as $dr){
            $cekcbmcont = $this->db->select('sum(giw.volume * giw.ctns) as total')
                                   ->from('giw')
                                   ->where('customer_id',$dr->id_cust)
                                   ->where('container_id',$this->uri->segment(4))
                                   ->get()->row();
            $cekbarangjalan = $this->db->select('sum(giw.volume * giw.ctns) as total')
                                   ->from('giw')
                                   ->where('customer_id',$dr->id_cust)
                                   ->where('container_id !=',$this->uri->segment(4))
                                   ->group_start()
                                     ->where('status',7)
                                     ->or_where('status <',5)
 																   ->group_end()
                                   ->get()->row();
            if($cekbarangjalan->total > 0){
              $bolehkirim = 1;
            }else{
              $bolehkirim = 0;
            }
            if($dr->id_provinsi2 != "31" || $dr->id_kota2 == "3175" || $dr->id_kota2 == "3174" || $dr->tipe_ekspedisi == "pickup" ||
               $dr->tipe_ekspedisi == "nanya" || $dr->fix_alamat != 1 || $cekcbmcont->total < 0.5 || $bolehkirim == 0){
                 // $detailkondisi =  $dr->id_kota2.",".$dr->tipe_ekspedisi.",".$dr->id_kota2.",".$dr->id_kota2.","
                 $gudangnya = "Gudang WC";
            }else{
                 $gudangnya = "Gudang Joni";
            }
          ?>
          <tbody>
            <tr <?php if($gudangnya == "Gudang WC"){ ?> style='background-color:#A9F096; color:black;' <?php } ?>
                <?php if($gudangnya == "Gudang Joni"){ ?>style='background-color:#F9DF9C; color:black;' <?php } ?>
            >
              <td><?php echo $no; ?></td>
              <td><?php echo $dr->marking ?></td>
              <td><?php echo $dr->nomor_resi."(".$dr->resinote.")" ?></td>
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
              <td><?php echo $gudangnya ?></td>
              <td>
                <?php
                echo "<b>".$dr->namacs."</b><br />";
                if($gudangnya == "Gudang WC"){
                  echo "-";
                }else{
                  if($dr->id_ekspedisi >= 8 ){
                    $proveks = $this->db->select('provinsi.nama')->where('id_prov',$dr->id_provinsi2)->get('provinsi')->row();
                    $kotaeks = $this->db->select('kabupaten.nama')->where('id_kab',$dr->id_kota2)->get('kabupaten')->row();
                    $keceks = $this->db->select('kecamatan.nama')->where('id_kec',$dr->id_kec2)->get('kecamatan')->row();
                    echo "<b> Ekspedisi : ".$proveks->nama." , ".$kotaeks->nama." , ".$keceks->nama."</b> <br /><br />".
                    $dr->nama_ekspedisi." , ".$dr->almteks." , ".$dr->notelpeks.
                    "<br /><br /> Alamat : ".$dr->almtcust." , ".$dr->namaprov." , ".$dr->namakota." , ".$dr->namakec.
                    " <br /><br /> No. Telp : ".$dr->telpcs;
                  }else{
                    echo "<b> Alamat : ".$dr->namaprov." , ".$dr->namakota." , ".$dr->namakec."</b> <br /><br />".$dr->almtcust.
                    "<br /><br />".$dr->nama_ekspedisi.
                    " <br /><br /> No. Telp : ".$dr->telpcs;
                  }
                }
                ?>
              </td>
            </tr>
          </tbody>
          <?php $no++; $tkoli+=$dr->jumlah_koli; $tvolume+=$dr->cbm; $tberat+=$dr->total_berat; } ?>
          <tr>
            <td colspan="4">Total WC</td>
            <td><?php echo round($tvolume,3) ?> m <sup>3</sup></td>
            <td><?php echo $tkoli ?></td>
            <td><?php echo round($tberat,3) ?> Kg</td>
            <td colspan="2"></td>
          </tr>
          <tr>
            <td colspan="4">Total Live</td>
            <td><?php echo round($total_live->cbm,3) ?> m <sup>3</sup></td>
            <td><?php echo $total_live->jumlah_koli ?></td>
            <td><?php echo round($total_live->total_berat,3) ?> Kg</td>
            <td colspan="2"></td>
          </tr>
        </tbody>
      </table>
     </div>
   </div>
 </div>
</div>
<?php if ($dc->status == 5 ){ ?>
          <form action="<?php echo site_url('admin/container/add_to_stok'); ?>" method="post">
            <div class="row">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><b>List Resi & Giw</b></h3>
                  <?php if($tipenya == "FCL"){ ?>
                    <span class="pull-right" style="margin-right:5px;">
                      <select class="form-control btn btn-danger" name="posisi">
                        <option value="1">Pilih Opsi Proses</option>
                        <?php foreach($data_posisi as $dp){ ?>
                          <option value="<?php echo $dp->id_posisi_indo ?>"><?php echo $dp->tempat ?></option>
                        <?php } ?>
                      </select>
                    </span>
                    <span class="pull-right" style="margin-right:5px;">
                      <button type="submit" name="action" value="generatefcl" class="form-control btn btn-warning"><i class="fa fa-cubes"> Generate Invoice </i></button>
                    </span>
                  <?php }else{ ?>
                    <span class="pull-right" style="margin-right:5px;">
                      <select class="form-control btn btn-danger" name="posisi">
                        <option value="1">Pilih Opsi Proses</option>
                        <?php foreach($data_posisi as $dp){ ?>
                          <option value="<?php echo $dp->id_posisi_indo ?>"><?php echo $dp->tempat ?></option>
                        <?php } ?>
                      </select>
                    </span>

                    <span class="pull-right" style="margin-right:5px;">
                      <button type="submit" name="action" value="addstok" class="form-control btn btn-primary"><i class="fa fa-cubes"> Tambahkan ke Stok Barang </i></button>
                    </span>
                    <span class="pull-right" style="margin-right:5px;">
                      <button type="submit" name="action" value="drts" class="form-control btn btn-danger"><i class="fa fa-cubes"> Dikirim Rts </i></button>
                    </span>
                  <?php } ?>
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
                          <th><input type="checkbox" onclick="checkAll(this)"></th>
                          <th>Marking</th>
                          <th>Nomor Resi</th>
                          <th>Giw</th>
                          <th>Volume</th>
                          <th>Jumlah Koli</th>
                          <th>Berat</th>
                          <th>Invoice</th>
                          <th>SJ</th>
                          <th>Hilang</th>
                        </tr>
                      </thead>
                      <?php $no=1; $tkoli2 = 0; $tvolume2=0; $tberat2=0; foreach($data_resi2 as $dr2){         ?>
                      <tbody>
                        <tr>
                          <td>
                            <?php if($dr2->posisi_indo > 0){
                              echo $dr2->tempat;
                             }else{
                               if($tipenya == "FCL"){ ?>
                                 <input type="checkbox" name="id_giw[]" value="<?php echo $dr2->idgiw ?>" />
                               <?php }else{ ?>
                                 <input type="checkbox" name="id_resi[]" value="<?php echo $dr2->id_resi ?>" />
                               <?php } ?>
                            <?php } ?>
                          </td>
                          <td><?php echo $dr2->marking ?></td>
                          <td><?php echo $dr2->nomor_resi."(".$dr->resinote.")" ?></td>
                          <td>
                            <?php
                              if($tipenya == "FCL"){
                                echo $dr2->nomor_giw;
                              }else{
                                $datagiw = $this->db->select('nomor')->from('giw')->where('resi_id',$dr2->id_resi)->where('container_id',$this->uri->segment(4))->get()->result();
                                foreach ($datagiw as $dg ) {
                                  echo $dg->nomor.", ";
                                }
                              }
                             ?>
                          </td>
                          <td><?php echo round($dr2->cbm,3) ?> M<sup>3</sup></td>
                          <td><?php echo $dr2->jumlah_koli ?> Koli</td>
                          <td><?php echo round($dr2->total_berat,3) ?> Kg</td>
                          <td><?php echo $dr2->kode_invoice ?></td>
                          <td>
                            <?php if($dr2->posisi_indo == 21){
                              echo $dr2->no_sj;
                             }else{
                              echo $dr2->kode_sj;
                             } ?>
                          </td>
                          <td>
                            <?php if($dr2->posisi_indo > 0){
                              echo "Stok Barang";
                             }else{
                               if($tipenya == "FCL"){
                                 if($dr2->hilang == "" || $dr2->hilang == null ){
                                   $hilangnya = 0;
                                 }else{
                                   $hilangnya = $dr2->hilang;
                                 }
                               ?>
                                <input type="text" name="hilang[]" value="<?php echo $hilangnya ?>" />
                               <?php }else{
                                 echo "LCL";
                                } ?>
                            <?php } ?>
                          </td>
                        </tr>
                      </tbody>
                      <?php $no++; $tkoli2+=$dr2->jumlah_koli; $tvolume2+=$dr2->cbm; $tberat2+=$dr2->total_berat; } ?>
                      <tr>
                        <td colspan="4">Total</td>
                        <td><?php echo round($tvolume2,3) ?> m <sup>3</sup></td>
                        <td><?php echo $tkoli2 ?></td>
                        <td><?php echo round($tberat2,3) ?> Kg</td>
                        <td colspan="2"></td>
                      </tr>
                  </table>
                 </div>
               </div>
             </div>
            </div>
          </form>

<?php } ?>
<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url() ?>assets/jquery/loadingoverlay.min.js"></script>
<script type="text/javascript">
        $(document).ready(function(){setTimeout(function(){$(".alert").fadeIn('fast');}, 100);});
          //angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
          setTimeout(function(){$(".alert").fadeOut('fast');}, 5000);
</script>
<script type="text/javascript">
function checkAll(bx) {
   var cbs = document.getElementsByTagName('input');
   for(var i=0; i < cbs.length; i++) {
     if(cbs[i].type == 'checkbox') {
       cbs[i].checked = bx.checked;
     }
   }
 }
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
