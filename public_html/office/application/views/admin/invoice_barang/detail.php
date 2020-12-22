<head>
  <meta charset="utf-8">
  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link href="<?php echo base_url().'assets/ignited/css/dataTables.bootstrap.css'?>" rel="stylesheet" type="text/css"/>
</head>

<?php
  if($r->status_invoice_beli == 1){
    $status_beli = "Belum Lunas";
  }else{
    $status_beli = "Lunas";
  }

  if($r->status_invoice == 1){
    $status = "Lunas";
  }else{
    $status = "Belum Lunas";
  }
?>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Invoice Jual <?php echo $this->session->userdata('level'); ?></b></h3>
      <span class="pull-right">
        <form method="post" action="<?php echo base_url('admin/invoice_barang/sesuaikan_invoice') ?>">
          <input type="hidden" name="no_inv" value="<?php echo $r->note_invoice_beli; ?>">
          <input type="hidden" name="id_invoice" value="<?php echo $r->id_invoice; ?>">
          <input type="submit" name="submit" value="Sesuaikan Invoice" class="btn btn-primary" <?php if(($this->session->userdata('level') != "suadmin" && $this->session->userdata('level') != "finance")){ echo "disabled";  } ?>>
        </form>
      </span>
      <?php if($this->session->flashdata('msg')=='potongan_tercancel'){ ?>

         <p><div style="display: none;" class="alert alert-success alert-dismissable"><i class="icon fa fa-check"></i>Potongan Tercancel
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        </div></p>

      <?php } ?>
    </div>

    <div class="box-body">
      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped " id="mytable">
          <thead>
            <tr>
              <th>Kode Mark Customer</th>
              <th>Kode Invoice</th>
              <th>Tanggal Invoice</th>
              <th>Total Tagihan</th>
              <th>Jumlah Bayar</th>
              <th>Status</th>

            </tr>
          </thead>
          <tbody>
                <tr>
                    <td><?php echo $r->kode ?></td>
                    <td><?php echo $r->kode_invoice ?></td>
                    <td><?php echo date_indo($r->tanggal_invoice) ?></td>
                    <td><?php echo "Rp. ". number_format($r->total_tagihan); ?></td>
                    <td><?php echo "Rp. ". number_format($r->jumlah_bayar); ?></td>
                    <td><?php echo $status; ?></td>
                </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Invoice Beli</b></h3>

    </div>

    <div class="box-body">
      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped " id="mytable">
          <thead>
            <tr>
              <th>Kode Invoice Beli</th>
              <th>Kode Invoice RTS</th>
              <th>Total Tagihan (WC)</th>
              <th>Total Tagihan (RTS)</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
                <tr>
                    <td><?php echo $r->kode_invoice_beli ?></td>
                    <td><?php echo $r->note_invoice_beli ?></td>
                    <td><?php echo "Rp. ". number_format($r->jumlah_invoice_beli); ?></td>
                    <td><?php echo "Rp. ". number_format($r->jumlah_dari_vendor); ?></td>
                    <td><?php echo $status_beli ?></td>
                </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

    <div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Detail Invoice</b></h3>
      <form method="post" action="<?php echo base_url('admin/invoice_barang/sesuaikan_jumlah') ?>">
      <span class="pull-right">
        <input type="hidden" name="id_invoice" value="<?php echo $this->uri->segment(4); ?>">
        <input type="submit" name="submit" value="Sesuaikan Jumlah" class="btn btn-danger"
         <?php if(($this->session->userdata('level') != "suadmin" && $this->session->userdata('level') != "finance")){ echo "disabled";  } ?>>
      </span>
    </div>

    <div class="box-body">
      <div class="box-body table-responsive">

        <table class="table table-bordered table-striped ">
          <thead>
    			<tr>
              <th><font color="black"><center>TGL</center></font></th>
              <th><font color="black"><center>RESI</center></font></th>
    					<th style="height: 30px;"><font color="black"><center>BARCODE</center></font></th>
    					<th><font color="black"><center>GOODS</center></font></th>
              <th><font color="black"><center>KATEGORI</center></font></th>
    					<th><font color="black"><center>CTNS</center></font></th>
    					<th><font color="black"><center>QTY</center></font></th>
    					<th><font color="black"><center>WEIGHT</center></font></th>
    					<th><font color="black"><center>RMB</center></font></th>
    					<th><font color="black"><center>VOLUME</center></font></th>
    					<th><font color="black"><center>FREIGHT</center></font></th>
    					<th><font color="black"><center>JUMLAH</center></font></th>
    			</tr>
                </thead>
    			<tr style="display: none;">

    			</tr>
                 <tbody>
    					<?php
    			    foreach ($invoicedetail as $ils ) {
                   $mrmb = $ils->nilai * $ils->jumlah * $ils->qty;
                   $mqty= $ils->qty * $ils->jumlah;
                   $mberat= $ils->berat * $ils->jumlah;
                   $mvolume= $ils->volume * $ils->jumlah;

                   $tctns  +=$ils->jumlah;
                   $tqty   +=$mqty;
                   $tberat +=$mberat;
                   $tvolume +=$mvolume;
                   $trmb +=$mrmb;
                   include APPPATH. 'helpers/harga.php';
                   $tharga += $harga;
    					 ?>

    			<tr>
            <td><font color="black"><center>
    				<?php echo $ils->tanggal ?>
    				</center></td>
            <td><font color="black"><center>
    				<?php echo $ils->nomorresi ?>
    				</center></td>
    				<td style="height: 25px;"><font color="black"><center>
    				<?php echo $ils->nomor ?>
    				</center></td>
    				<td><font color="black"><center>
    				<?php echo $ils->barang ?>
    				</center></td>
            <td><font color="black"><center>
    				<?php echo $ils->namalain ?>
    				</center></td>
    				<td><font color="black"><center>
    				<?php echo $ils->jumlah ?>
    				</center></td>
    				<td><font color="black"><center>
    				@<?php echo $ils->qty." / ".$mqty?> pcs
    				</center></td>
    				<td><font color="black"><center>
    				@<?php echo $ils->berat." / ".$mberat ?> kg
    				</center></td>
    				<td><font color="black"><center>
    				    @<?php echo $ils->nilai." / ".$mrmb ?> RMB
    				</center></td>
    				<td><font color="black"><center>
    				@<?php echo $ils->volume." / ".$mvolume ?> m<sup>3</sup>
    				</center></td>
            <td><font color="black"><center>
      				<?php
                if($stsberat == 1){
                    echo "Rp.". number_format($hargasatuan,2);
                }else{
                    echo "Rp.". number_format($hargasatuan);
                }
              ?>
    				</center></td>
    				<td><font color="black"><center>
    				<?php echo"Rp.". number_format($harga) ?>
    				</center></td>

    			</tr>

    			<?php  } ?>
    			<tr>
    			<td colspan="5"><center><font color="black">JUMLAH </center></td>
    			<td colspan=""><center><font color="black"><?php echo $tctns ?> </center></td>
    			<td colspan=""><center><font color="black"><?php echo $tqty ?> </center></td>
    			<td colspan=""><center><font color="black"><?php echo $tberat ?> Kg.</center></td>
    			<td colspan=""><center><font color="black"><?php echo $trmb ?> RMB</center></td>
    			<td colspan=""><center><font color="black"><?php echo $tvolume ?> m<sup>3</sup></center></td>
    			<td colspan="2"><center><font color="black"><?php echo "Rp.". number_format($tharga) ?> </center></td>
    			</tr>

          <?php $tasuransi=0; foreach ($record_asuransi as $asr){ ?>
    				<tr>
    				<td colspan="10"><center><font color="black">ASURANSI <?php echo $asr->nomor ; ?></center></td>
    				<td colspan="2" style="height: 40px;"><center><font color="black"><?php echo "Rp.".number_format($asr->jumlah_asuransi) ?> </center></td>
    				</tr>
    			<?php $tasuransi +=$asr->jumlah_asuransi; } ?>

          <?php $tpotongan=0; foreach ($potongan as $pot){ ?>
    				<tr>
    				<td colspan="10"><center><font color="black"><?php echo $pot->keterangan_potongan; ?></center></td>
    				<td colspan="2" style="height: 40px;"><center><font color="black"><?php echo "Rp.".number_format($pot->jumlah_potongan) ?> </center></td>
    				</tr>
    			<?php $tpotongan+=$pot->jumlah_potongan; } ?>
          <?php $totalsebenarnya = $tpotongan + $tasuransi + $tharga; ?>
    			<tr>
    			<td colspan="10"><center><font color="black" size="2"><b>TOTAL TAGIHAN</b> </center></td>
    			<td colspan="2" style="height: 30px;"><center><font color="black" size="2"><b><?php echo "Rp.".number_format(($r->total_tagihan - $r->jumlah_bayar) - $r->total_potongan) ?> </b></center></td>
    			</tr>

    			</tbody>
        </table>
        <input type="hidden" name="totalsebenarnya" value="<?php echo $totalsebenarnya; ?>" />
      </form>
    </div>
    </div>
    </div>
    </div>

    <div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Detail Invoice Beli</b></h3>

    </div>

    <div class="box-body">
      <div class="box-body table-responsive">

        <table class="table table-bordered table-striped ">
          <thead>
    			<tr>
              <th><font color="black"><center>TGL</center></font></th>
              <th><font color="black"><center>RESI</center></font></th>
    					<th style="height: 30px;"><font color="black"><center>BARCODE</center></font></th>
    					<th><font color="black"><center>GOODS</center></font></th>
              <th><font color="black"><center>KATEGORI</center></font></th>
    					<th><font color="black"><center>CTNS</center></font></th>
    					<th><font color="black"><center>QTY</center></font></th>
    					<th><font color="black"><center>WEIGHT</center></font></th>
    					<th><font color="black"><center>RMB</center></font></th>
    					<th><font color="black"><center>VOLUME</center></font></th>
    					<th><font color="black"><center>FREIGHT</center></font></th>
    					<th><font color="black"><center>JUMLAH</center></font></th>
    			</tr>
                </thead>
    			<tr style="display: none;">

    			</tr>
                 <tbody>
    					<?php
    			    foreach ($invoicedetail as $ils ) {
                  $mrmb = $ils->nilai * $ils->jumlah * $ils->qty;
                  $mqty= $ils->qty * $ils->jumlah;
                  $mberat= $ils->berat * $ils->jumlah;
                  $mvolume= $ils->volume * $ils->jumlah;
                   include APPPATH. 'helpers/harga_beli.php';
                   $tharga_beli += $harga;
    					 ?>

    			<tr>
            <td><font color="black"><center>
    				<?php echo $ils->tanggal ?>
    				</center></td>
            <td><font color="black"><center>
    				<?php echo $ils->nomorresi ?>
    				</center></td>
    				<td style="height: 25px;"><font color="black"><center>
    				<?php echo $ils->nomor ?>
    				</center></td>
    				<td><font color="black"><center>
    				<?php echo $ils->barang ?>
    				</center></td>
            <td><font color="black"><center>
    				<?php echo $ils->namalain ?>
    				</center></td>
    				<td><font color="black"><center>
    				<?php echo $ils->jumlah ?>
    				</center></td>
    				<td><font color="black"><center>
    				@<?php echo $ils->qty." / ".$mqty?> pcs
    				</center></td>
    				<td><font color="black"><center>
    				@<?php echo $ils->berat." / ".$mberat ?> kg
    				</center></td>
    				<td><font color="black"><center>
    				    @<?php echo $ils->nilai." / ".$mrmb ?> RMB
    				</center></td>
    				<td><font color="black"><center>
    				@<?php echo $ils->volume." / ".$mvolume ?> m<sup>3</sup>
    				</center></td>
            <td><font color="black"><center>
      				<?php
                if($stsberat == 1){
                    echo "Rp.". number_format($hargasatuan,2);
                }else{
                    echo "Rp.". number_format($hargasatuan);
                }
              ?>
    				</center></td>
    				<td><font color="black"><center>
    				<?php echo"Rp.". number_format($harga) ?>
    				</center></td>

    			</tr>

    			<?php  } ?>
    			<tr>
    			<td colspan="5"><center><font color="black">JUMLAH </center></td>
    			<td colspan=""><center><font color="black"><?php echo $tctns ?> </center></td>
    			<td colspan=""><center><font color="black"><?php echo $tqty ?> </center></td>
    			<td colspan=""><center><font color="black"><?php echo $tberat ?> Kg.</center></td>
    			<td colspan=""><center><font color="black"><?php echo $trmb ?> RMB</center></td>
    			<td colspan=""><center><font color="black"><?php echo $tvolume ?> m<sup>3</sup></center></td>
    			<td colspan="2"><center><font color="black"><?php echo "Rp.". number_format($tharga_beli) ?> </center></td>
    			</tr>

          <?php foreach ($potongan_beli as $pot){ ?>
    				<tr>
    				<td colspan="10"><center><font color="black"><?php echo $pot->keterangan_potongan; ?></center></td>
    				<td colspan="2" style="height: 40px;"><center><font color="black"><?php echo "Rp.".number_format($pot->jumlah_potongan) ?> </center></td>
    				</tr>
    			<?php } ?>

    			<tr>
    			<td colspan="10"><center><font color="black" size="2"><b>TOTAL TAGIHAN BELI</b> </center></td>
    			<td colspan="2" style="height: 30px;"><center><font color="black" size="2"><b><?php echo "Rp.".number_format($r->jumlah_invoice_beli) ?> </b></center></td>
    			</tr>

    			</tbody>

        </table>
    </div>
    </div>
    </div>
    </div>

    <div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Sub Pembayaran List</b></h3>

    </div>

    <div class="box-body">

    <div class="box-body table-responsive">

    <table class="table table-bordered table-striped " id="mytable">
      <thead>
        <tr>
          <th>No</th>
          <th>Kode Pembayaran</th>
          <th>Jumlah Bayar</th>
        </tr>
      </thead>
     <tbody>
              <?php $no=1; foreach($sub_pembayaran as $qq){ ?>
              <tr>
                  <td><?php echo $no ?></td>
                  <td><?php echo $qq->kode_pembayaran ?></td>
                  <td><?php echo "Rp. ". number_format($qq->jumlah_bayar_sub); ?></td>
              </tr>
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
        <h3 class="box-title"><b>Potongan List</b></h3>
        <span class="pull-right">
           <button class="btn btn-success" data-toggle="modal" data-target="#potbeliMod"><i class="fa fa-plus"> Potongan Beli</i></button>
           <button class="btn btn-primary" data-toggle="modal" data-target="#myModalAdd"><i class="fa fa-plus"> Potongan</i></button>
        </span>
      </div>

      <div class="box-body">

      <div class="box-body table-responsive">

      <table class="table table-bordered table-striped " id="mytable">
        <thead>
          <tr>
            <th>No</th>
            <th>Jenis Potongan</th>
            <th>Jumlah Potongan</th>
            <th>Keterangan</th>
            <th>Tipe Potongan</th>
            <th>Action</th>
          </tr>
        </thead>
       <tbody>
                <?php $no=1; foreach($semua_potongan as $fz){ ?>
                <tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $fz->kjenis_potongan ?></td>
                    <td><?php echo "Rp. ". number_format($fz->jumlah_potongan); ?></td>
                    <td><?php echo $fz->keterangan_potongan ?></td>
                    <td><?php echo $fz->tipe_potongan ?></td>
                    <td><font color="black"><center>
                    <a href="javascript:void(0);" onclick="edit_potongan(<?php echo $fz->id_potongan ?>)" class="btn btn-info btn-xs" alt="Update Data">
                    <i class="fa fa-edit"></i></a>
                    <a onclick="return confirm('Hapus Potongan?');" href="<?php echo base_url().'admin/jenis_potongan/hapus_potongan/'.$fz->id_potongan?>" class="btn btn-danger btn-xs" alt="Update Data">
                    <i class="fa fa-close"></i></a>
                    </center></td>
                </tr>
                <?php $no++; } ?>
        </tbody>
      </table>
    </div>
    </div>
    </div>
    </div>

    <!-- Modal Add Invoice -->
    <form id="add-row-form" action="<?php echo base_url().'admin/jenis_potongan/tambah_potongan'?>" method="post" enctype="multipart/form-data">
       <div class="modal fade" id="potbeliMod" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Tambah Potongan Beli</h4>
                 </div>
                 <div class="modal-body">
                     <input type="hidden" name="jumlah_invoice_beli" value="<?php echo $r->jumlah_invoice_beli;  ?>">
                     <input type="hidden" name="id_invoice_beli" value="<?php echo $r->id_invoice_beli ?>" ?>
                     <input type="hidden" name="redirect" value="<?php echo base_url()."admin/".$this->uri->segment(2)."/".$this->uri->segment(3)."/".$this->uri->segment(4) ?>" ?>
                     <input type="hidden" name="id_jenis_potongan" value="5">

                     <div class="form-group">
                         <label>Jumlah Potongan</label>
                         <input type="text" name="jumlah_potongan" class="form-control" placeholder="Jumlah Potongan" required>
                     </div>

                     <div class="form-group">
                          <label>Keterangan</label>
                          <textarea type="text" name="keterangan_potongan" class="form-control" placeholder="Keterangan"></textarea>
                     </div>

                 </div>
                 <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" id="add-row" class="btn btn-primary">Save</button>
                 </div>
              </div>
          </div>
       </div>
    </form>

    <!-- Modal Add Potongan -->
    <form id="add-row-form" action="<?php echo base_url().'admin/jenis_potongan/tambah_potongan'?>" method="post" enctype="multipart/form-data">
       <div class="modal fade" id="myModalAdd" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Tambah Potongan Baru</h4>
                 </div>
                 <div class="modal-body">
                     <input type="hidden" name="total_tagihan" value="<?php echo $r->total_tagihan;  ?>">
                     <input type="hidden" name="id_invoice" value="<?php echo $this->uri->segment(4) ?>" ?>
                     <input type="hidden" name="redirect" value="<?php echo base_url()."admin/".$this->uri->segment(2)."/".$this->uri->segment(3)."/".$this->uri->segment(4) ?>" ?>
                     <div class="form-group">
                         <label>Jenis Potongan</label>
                         <select class="form-control" name="id_jenis_potongan" id="jenis_potongan">
                           <?php foreach ($jenis_potongan as $jp){ ?>
                             <option value="<?php echo $jp->id_jenis_potongan ?>"><?php echo $jp->kjenis_potongan ?></option>
                           <?php } ?>
                         </select>
                     </div>

                     <div class="form-group">
                         <label>Jumlah Potongan</label>
                         <input type="text" name="jumlah_potongan" class="form-control" placeholder="Jumlah Potongan" required>
                     </div>

                     <div class="form-group">
                          <label>Keterangan</label>
                          <textarea type="text" name="keterangan_potongan" class="form-control" placeholder="Keterangan"></textarea>
                     </div>

                 </div>
                 <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" id="add-row" class="btn btn-primary">Save</button>
                 </div>
              </div>
          </div>
       </div>
    </form>

    <div id="edit_potongan"></div>

<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>
<script src="<?php echo base_url() ?>assets/jquery/loadingoverlay.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){setTimeout(function(){$(".alert").fadeIn('fast');}, 100);});
      //angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
      setTimeout(function(){$(".alert").fadeOut('fast');}, 5000);
</script>
<script type="text/javascript">
  function edit_potongan(id)
  {
    console.log(id);
    $.ajax({
      type : "GET",
      url : "<?php echo base_url() ?>admin/invoice_barang/edit_potongan/"+id,
      cache : false,
      async : false,
      success : function(html){
        $("#edit_potongan").html(html).show();
        $('#modeeditpotongan').modal('show');
      }
    })
  }
</script>
<script>
  $('form').submit(function() {
    $.LoadingOverlay("show");
  });
</script>
<script type="javascript">
  $("#jenis_potongan").change(function(){

  })
</script>
