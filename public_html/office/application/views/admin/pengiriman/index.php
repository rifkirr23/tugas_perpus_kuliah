<head>
  <meta charset="utf-8">
  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
   <link href="<?php echo base_url().'assets/jquery/select2.min.css'?>" rel="stylesheet" />
</head>

        <?php if($this->session->flashdata('msg')=='okstatus'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Update Status Berhasil
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

        <?php if($this->session->flashdata('msg')=='okgudang'){ ?>

           <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Whatsapp ke Gudang terkirim
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          </div></p>

        <?php } ?>

        <?php if($this->session->flashdata('msg')=='okekspedisi'){ ?>

           <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Upload Ekspedisi dan Harga Berhasil
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          </div></p>

        <?php } ?>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Pengiriman List</b></h3>

    </div>

    <div class="box-body">
      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped no-margin" id="mytable">
          <thead>
            <tr>
              <th>Kode Mark Customer</th>
              <th>Kode Invoice</th>
              <th>List Resi</th>
              <th>Kubikasi & Koli</th>
              <th>Tanggal Invoice</th>
              <th>Tanggal kasih alamat</th>
              <th>Tanggal Kirim</th>
              <th>Alamat</th>
              <th>Alamat Fix</th>
              <th>H+</th>
              <th>Status Pengiriman</th>
              <th>Status Boleh Kirim</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($pengiriman as $kirim) {
              $resi_list = $this->db->select('resi.nomor as nomor_resi')->from('invoice_product')
                                    ->join('giw', 'invoice_product.id_giw=giw.id')
                                    ->join('resi', 'giw.resi_id=resi.id_resi')
                                    ->group_by('resi.id_resi')
                                    ->where('invoice_product.id_invoice',$kirim->id_invoice)
                                    ->get()->result();
              $getcbm = $this->db->select('sum(invoice_product.jumlah * giw.volume) as cbm,sum(invoice_product.jumlah) as total_koli')->from('invoice_product')
                                    ->join('giw', 'invoice_product.id_giw=giw.id')
                                    ->join('resi', 'giw.resi_id=resi.id_resi')
                                    ->where('invoice_product.id_invoice',$kirim->id_invoice)
                                    ->get()->row();
              if($kirim->fix_alamat == 1){
                $strFix = " ✓ fix ";
              }else{
                $strFix = " tidak fix ";
              }

              if($kirim->tanggal_kasih_alamat == "" || $kirim->tanggal_kasih_alamat == "0000-00-00"){
                $strtgl_alamat = "-";
              }else{
                $tgl_alamat  = strtotime($kirim->tanggal_kasih_alamat);
            		$sekarang    = time(); // Waktu sekarang
            		$diff   = $sekarang - $tgl_alamat;

                $strtgl_alamat = "H+".floor($diff / (60 * 60 * 24));
              }

              if($kirim->status_pengiriman == "" || $kirim->status_pengiriman == "0"){
                $strpengiriman = "belum dikirim";
              }else{
                $strpengiriman = "sudah dikirim";
              }

              if($kirim->status_boleh_kirim == "" || $kirim->status_boleh_kirim == "0" || $kirim->status_boleh_kirim == "3"){
                $strboleh_kirim = " - ";
              }else{
                $strboleh_kirim = " ✓ ";
              }
            ?>
              <tr
                <?php if($kirim->status_pengiriman == "" || $kirim->status_pengiriman == "0"){ ?> style="background-color:#FABAA5;" <?php }else{ ?>
                  style="background-color:#A9F096;"
                <?php } ?>
              >
                <td><?php echo $kirim->kode ?></td>
                <td><?php echo $kirim->kode_invoice ?></td>
                <td><?php foreach ($resi_list as $re_list) {
                  echo $re_list->nomor_resi.",";
                } ?></td>
                <td><?php echo round($getcbm->cbm,3)."m<sup>3</sup> (".$getcbm->total_koli." koli )"?></td>
                <td><?php echo $kirim->tanggal_invoice ?></td>
                <td><?php echo $kirim->tanggal_kasih_alamat ?></td>
                <td><?php echo $kirim->tanggal_kirim ?></td>
                <td><?php echo $kirim->alamat ?></td>
                <td><?php echo $strFix ?></td>
                <td><?php echo $strtgl_alamat ?></td>
                <td><?php echo $strpengiriman ?></td>
                <td><?php echo $strboleh_kirim ?></td>
                <td>
                  <?php if($strtgl_alamat == "-"){ ?>
                    <a href="<?php echo base_url() ?>admin/pengiriman/pesan_gudang/<?php echo $kirim->id_invoice ?>"
                       onclick="return confirm('kirim pesan ke gudang?');" class="btn btn-xs btn-success" alt="chat eti">
                    <i class="fa fa-wechat"></i></a>&nbsp;
                  <?php } ?>
                  <a href="<?php echo base_url() ?>admin/pengiriman/update_status/<?php echo $kirim->id_invoice ?>" onclick="return confirm('Update status barang terkirim?');" class="btn btn-xs btn-info" alt="chat eti"><i class="fa fa-send"></i></a>&nbsp;
                  <a class="btn btn-xs btn-warning" data-toggle="modal" data-target="#myModal<?php echo $kirim->id_invoice ?>" alt="ekspedisi"><i class="fa fa-truck"></i></a>&nbsp;
                </td>
              </tr>

              <!-- Modal Upload-->
            <div class="modal fade" id="myModal<?php echo $kirim->id_invoice; ?>" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update Data Pengiriman</h4>
                  </div>
                  <div class="modal-body">
                    <form role="form" action="editmhs.php" method="get">
                        <input type="hidden" name="id_invoice" value="<?php echo $kirim->id_invoice; ?>">
                        <input type="hidden" name="id_cust" value="<?php echo $kirim->id_cust; ?>">
                        <div class="form-group">
                          <label>Upload File Ekspedisi Lokal</label>
                          <div class="control-group" id="fields">
                             <div class="controls">
                                 <div class="entry input-group col-xs-3">
                                   <input class="btn btn-primary" name="file[]" type="file">
                                   <span class="input-group-btn">
                                     <button class="btn btn-success btn-add" type="button">
                                       <span class="glyphicon glyphicon-plus"></span>
                                     </button>
                                   </span>
                                 </div>
                             </div>
                           </div>
                         </div>
                        <div class="form-group">
                          <label>Harga</label>
                          <input type="text" name="harga_lokal" class="form-control" placeholder="Harga Lokal" value="<?php echo ""; ?>">
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Update</button>
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                      </form>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
          </tbody>
        </table>
      </div>
    </div>


<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/jquery/select2.min.js'?>"></script>
<script src="<?php echo base_url() ?>assets/jquery/loadingoverlay.min.js"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>
<script type="text/javascript">
  var table = $("#mytable").dataTable({
    // filter:false
    // aaSorting: [[8, 'asc']]
    // order: [[3, 'desc']]
  });
  table.fnSort( [[8,"asc"], [3,"desc"]]);
  // table
  //   .order( [ 3, 'desc' ] )
  //   .draw();
  $(function(){
      $(document).on('click', '.btn-add', function(e){
          e.preventDefault();

          var controlForm = $('.controls:first'),
              currentEntry = $(this).parents('.entry:first'),
              newEntry = $(currentEntry.clone()).appendTo(controlForm);

          newEntry.find('input').val('');
          controlForm.find('.entry:not(:last) .btn-add')
              .removeClass('btn-add').addClass('btn-remove')
              .removeClass('btn-success').addClass('btn-danger')
              .html('<span class="glyphicon glyphicon-minus"></span>');
      }).on('click', '.btn-remove', function(e)
      {
        $(this).parents('.entry:first').remove();

          e.preventDefault();
          return false;
      });
  });
</script>
