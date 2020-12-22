<head>
  <meta charset="utf-8">
  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">

</head>

<?php if($this->session->flashdata('msg')=='invoiceok'){ ?>

<p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Proses Invoice Success
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
</div></p>

<?php } ?>

<?php $idvendor = $this->uri->segment(4); ?>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Invoice Beda Hitungan Rts </b></h3>
    </div>

<div class="box-body">
  <div class="box-body table-responsive">
    <table class="table table-bordered table-striped no-margin" id="mytable">
      <thead>
        <tr>
          <th>Kode Mark Customer</th>
          <th>Kode Invoice</th>
          <th>Tanggal Invoice</th>
          <th>Total Tagihan</th>
          <th>Jumlah Bayar</th>
          <th>Jumlah dari Vendor</th>
          <th>Note</th>
          <th>Status</th>
          <th>Act</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($data_beda as $beda){
              if($beda->status_invoice_beli==1){
                $status = "Belum Lunas";
              }else if($beda->status_invoice_beli==2){
                $status = "Lunas";
              }
         ?>
          <tr style="background-color:#FABAA5">
          <td><?php echo $beda->kode ?></td>
          <td><?php echo $beda->kode_invoice_beli ?></td>
          <td><?php echo $beda->tanggal_invoice_beli ?></td>
          <td><?php echo "RP. ".number_format($beda->jumlah_invoice_beli) ?></td>
          <td><?php echo "RP. ".number_format($beda->jumlah_bayar_invoice_beli) ?></td>
          <td><?php echo "RP. ".number_format($beda->jumlah_dari_vendor) ?></td>
          <td><?php echo $beda->note_invoice_beli ?></td>
          <td><?php echo $status; ?></td>
          <td><a href="<?php echo site_url('admin/invoice_barang/detail/'.$beda->id_invoice) ?>" class="btn btn-info btn-xs">detail</a></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>


<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/jquery/select2.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>
<script src="<?php echo base_url() ?>assets/jquery/loadingoverlay.min.js"></script>
<script src="<?php echo base_url().'assets/jquery/jquery.mask.min.js'?>"?>></script>

<script type="text/javascript">
       $(document).ready(function(){
         $("#mytable").dataTable({
           ordering:false,
         });
         setTimeout(function(){$(".alert").fadeIn('fast');}, 100);});
         //angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
         setTimeout(function(){$(".alert").fadeOut('fast');}, 5000);
</script>

<script type="text/javascript">
 $('.submitt').on('click', function(){
  $.LoadingOverlay("show");
   //console.log('wtheck');
 });
</script>
