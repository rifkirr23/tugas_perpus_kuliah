<head>
  <meta charset="utf-8">
  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">




</head>

        <?php if($this->session->flashdata('msg')=='success'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Customer Added to Our data
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>


<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>List Resi yang berubah Data</b></h3>
      <span class="pull-right">
               <a class="btn btn-primary" id="cek" href="<?php echo site_url();?>admin/resi/cek_resi "><i class="fa fa-hourglass-o">Cek Ulang</i></a>
      </span>

    </div>

    <div class="box-body">
    <div class="box-body table-responsive">

    <table class="table table-bordered table-striped no-margin" id="mytable">
      <thead>
        <tr>
          <th>No.</no>
          <th>Kode Mark Customer</th>
          <th>Nomor Resi</th>
          <th>Tanggal</th>
          <th>Supplier</th>
          <th>Tel</th>
          <th>Note</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
            <?php $no=1; foreach($resi as $ra){ ?>
              <tr color="red">
                    <td><?php echo "(WC) ".$no ?></td>
                    <td><?php echo $ra->kode ?></td>
                    <td><?php echo $ra->nomor ?></td>
                    <td><?php echo $ra->tanggal ?></td>
                    <td><?php echo $ra->supplier ?></td>
                    <td><?php echo $ra->tel ?></td>
                    <td><?php echo $ra->note ?></td>
                    <td> Button WC </td>
              </tr>


              <?php foreach($resi_rts as $rts){ ?>
                <tr color="red">
                      <td><?php echo "(RTS) ".$no ?></td>
                      <td><?php echo $rts->kode ?></td>
                      <td><?php echo $rts->nomor ?></td>
                      <td><?php echo $rts->tanggal ?></td>
                      <td><?php echo $rts->supplier ?></td>
                      <td><?php echo $rts->tel ?></td>
                      <td><?php echo $rts->note ?></td>
                      <td> Button Edit </td>
                </tr>


              <?php  } ?>
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
       <h3 class="box-title"><b> List Barcode yang berubah Data </b></h3>

     </div>

     <div class="box-body">

     <div class="box-body table-responsive">

     <table class="table table-bordered table-striped no-margin" id="mybarcode">
       <thead>
         <tr>
           <th>No. </th>
           <th>Resi </th>
           <th>Barcode </th>
           <th>Barang</th>
           <th>Ctns</th>
           <th>Qty</th>
           <th>Berat</th>
           <th>Volume</th>
           <th>Nilai</th>
           <th>Note</th>
           <th>Remarks</th>
           <th>Status</th>
           <th>Kurs</th>
           <th>Harga</th>
           <th>Action</th>
         </tr>

       </thead>

       <tbody>
             <?php $no=1; foreach($barcode as $brc){ ?>
               <tr color="red">
                     <td><?php echo "(WC) ".$no ?></td>
                     <td><?php echo $brc->nresi ?></td>
                     <td><?php echo $brc->nomor ?></td>
                     <td><?php echo $brc->barang ?></td>
                     <td><?php echo $brc->ctns ?></td>
                     <td>@<?php echo $brc->qty.'/'.$brc->qty * $brc->ctns ?> pcs</td>
                     <td>@<?php echo $brc->berat.'/'.$brc->berat * $brc->ctns ?> kg</td>
                     <td>@<?php echo $brc->volume.'/'.$brc->volume * $brc->ctns ?> m<sup>3</sup></td>
                     <td>@<?php echo $brc->nilai.'/'.$brc->nilai * $brc->ctns * $brc->qty ?> RMB</td>
                     <td><?php echo $brc->note ?></td>
                     <td><?php echo $brc->remarks ?></td>
                     <td><?php echo $brc->status ?></td>
                     <td><?php echo $brc->kurs ?></td>
                     <td><?php echo number_format($brc->harga) ?></td>
                     <td> Button Edit </td>
               </tr>
             <?php $no++; } ?>

             <?php $no=1; foreach($barcode_rts as $brc){ ?>
               <tr color="red">
                     <td><?php echo "(RTS) ".$no ?></td>
                     <td><?php echo $brc->nresi ?></td>
                     <td><?php echo $brc->nomor ?></td>
                     <td><?php echo $brc->barang ?></td>
                     <td><?php echo $brc->ctns ?></td>
                     <td>@<?php echo $brc->qty.'/'.$brc->qty * $brc->ctns ?> pcs</td>
                     <td>@<?php echo $brc->berat.'/'.$brc->berat * $brc->ctns ?> kg</td>
                     <td>@<?php echo $brc->volume.'/'.$brc->volume * $brc->ctns ?> m<sup>3</sup></td>
                     <td>@<?php echo $brc->nilai.'/'.$brc->nilai * $brc->ctns * $brc->qty ?> RMB</td>
                     <td><?php echo $brc->note ?></td>
                     <td><?php echo $brc->remarks ?></td>
                     <td><?php echo $brc->status ?></td>
                     <td><?php echo $brc->kurs ?></td>
                     <td><?php echo number_format($brc->harga) ?></td>
                     <td> Button Edit </td>
               </tr>
             <?php $no++; } ?>
       </tbody>

     </table>
    </div>
  </div>
 </div>
</div>

 <script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
 <script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
 <script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>
 <script src="<?php echo base_url() ?>assets/jquery/loadingoverlay.min.js"></script>

 <script type="text/javascript">
 $(document).ready(function(){

   $( "#cek" ).click(function() {
   $.LoadingOverlay("show");
   });

         });
 </script>

 <script>
     $(function () {
        $("#mytable").DataTable({
          "pageLength": 20,

          scrollX: true,
        });

        $("#mybarcode").DataTable({
          "pageLength": 20,

          scrollX: true,
        });
    });
 </script>
