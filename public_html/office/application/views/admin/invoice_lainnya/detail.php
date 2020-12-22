<head>
  <meta charset="utf-8">
  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link href="<?php echo base_url().'assets/ignited/css/dataTables.bootstrap.css'?>" rel="stylesheet" type="text/css"/>
</head>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Item List</b></h3>
      <span class="pull-right">
         <button class="btn btn-primary" data-toggle="modal" data-target="#myModalAdd"><i class="fa fa-plus"> Item</i></button>
      </span>
    </div>

    <div class="box-body">
      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped " id="mytable">
          <thead>
            <tr>
      					<th style="height: 30px;"><font color="black"><center>Keterangan</center></font></th>
      					<th><font color="black"><center>Qty</center></font></th>
      					<th><font color="black"><center>Harga Jual</center></font></th>
      					<th><font color="black"><center>Harga Beli</center></font></th>
      					<th><font color="black"><center>Total Jual</center></font></th>
      					<th><font color="black"><center>Total Beli</center></font></th>
                <th><font color="black"><center>Action</center></font></th>
      			</tr>
          </thead>
          <tr style="display: none;">
    			</tr>
          <tbody>
          <?php
             $qty = 0; $harga_jual=0; $harga_beli; $total_hj=0; $total_hb =0;
             foreach ($invoicedetail as $c ) {
               $qty += $c->qty_il; $harga_jual += $c->harga_jual; $harga_beli += $c->harga_beli;
               $total_jual = $c->harga_jual * $c->qty_il;
               $total_beli = $c->harga_beli * $c->qty_il;
               $total_hj += $total_jual;
               $total_hb += $total_beli;
          ?>
            <tr>
              <td style="height: 25px;"><font color="black"><center>
              <?php echo $c->keterangan_il ?>
              </center></td>

              <td><font color="black"><center>
              <?php echo $c->qty_il ?>
              </center></td>

              <td><font color="black"><center>
              <?php echo "Rp.". number_format($c->harga_jual) ?>
              </center></td>

              <td><font color="black"><center>
              <?php echo "Rp.". number_format($c->harga_beli) ?>
              </center></td>

              <td><font color="black"><center>
              <?php echo "Rp.". number_format($total_jual) ?>
              </center></td>

              <td><font color="black"><center>
              <?php echo "Rp.". number_format($total_beli) ?>
              </center></td>

              <td><font color="black"><center>
              <a href="javascript:void(0);" onclick="edit_item(<?php echo $c->id_item_il ?>)" class="btn btn-danger btn-xs" alt="Update Data">
              <i class="fa fa-edit"></i></a>
              </center></td>

            </tr>
            <?php  } ?>
            <tr>
      			<td colspan=""><center><font color="black">JUMLAH </center></td>
      			<td colspan=""><center><font color="black"><?php echo $qty ?> </center></td>
      			<td colspan=""><center><font color="black"><?php echo "Rp.". number_format($harga_jual) ?> </center></td>
      			<td colspan=""><center><font color="black"><?php echo "Rp.". number_format($harga_beli) ?> </center></td>
      			<td colspan=""><center><font color="black"><?php echo "Rp.". number_format($total_hj) ?></center></td>
      			<td colspan=""><center><font color="black"><?php echo "Rp.". number_format($total_hb) ?></sup></center></td>
      			</tr>

      			<tr>
      			<td colspan="4"><center><font color="black" size="2"><b>TOTAL TAGIHAN</b> </center></td>
      			<td colspan="2" style="height: 30px;"><center><font color="black" size="2"><b><?php echo "Rp.".number_format($r->total_tagihan) ?> </b></center></td>
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
      <h3 class="box-title"><b>Invoice List</b></h3>
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
                    <td><?php echo $r->status_invoice ?></td>
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
                  <td><?php echo $r->id_invoice_beli ?></td>
                  <td><?php echo $r->kode_invoice_beli ?></td>
                  <td><?php echo date_indo($r->tanggal_invoice_beli) ?></td>
                  <td><?php echo "Rp. ". number_format($r->jumlah_invoice_beli); ?></td>
                  <td><?php echo "Rp. ". number_format($r->jumlah_bayar_invoice_beli); ?></td>
                  <td><?php echo $r->status_invoice ?></td>
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

            </tr>
          </thead>
         <tbody>
            <?php $no=1; foreach($potongan as $fz){ ?>
            <tr>
                <td><?php echo $no ?></td>
                <td><?php echo $fz->kjenis_potongan ?></td>
                <td><?php echo "Rp. ". number_format($fz->jumlah_potongan); ?></td>
                <td><?php echo $fz->keterangan_potongan ?></td>

            </tr>
            <?php $no++; } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal Add Invoice -->
<form id="add-row-form" action="<?php echo base_url().'admin/invoice_lainnya/save_item'?>" method="post" enctype="multipart/form-data">
   <div class="modal fade" id="myModalAdd" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                 <h4 class="modal-title" id="myModalLabel">Add New Invoice</h4>
             </div>
             <div class="modal-body">
                 <input type="hidden" name="id_invoice" value="<?php echo $this->uri->segment(4) ?>" ?>
                 <input type="hidden" name="id_invoice_beli" value="<?php echo $this->uri->segment(5) ?>" ?>
                 <div class="form-group">
                     <label>Qty</label>
                     <input type="text" name="qty_il" class="form-control" placeholder="Jumlah Qty" required>
                 </div>

                 <div class="form-group">
                     <label>Harga Jual</label>
                     <input type="number" name="harga_jual" class="uang form-control" placeholder="Harga Jual" required>
                 </div>

                 <div class="form-group">
                     <label>Harga Beli </label>
                     <input type="number" name="harga_beli" class="uang form-control" placeholder="Harga Beli" required>
                 </div>

                 <div class="form-group">
                      <label>Keterangan</label>
                      <textarea type="text" name="keterangan_il" class="form-control" placeholder="Keterangan"></textarea>
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

<div id="edit_item"></div>

<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>
<script src="<?php echo base_url() ?>assets/jquery/loadingoverlay.min.js"></script>

<script type="text/javascript">
  function edit_item(id)
  {
    console.log(id);
    $.ajax({
      type : "GET",
      url : "<?php echo base_url() ?>admin/invoice_lainnya/edit_item/"+id,
      cache : false,
      async : false,
      success : function(html){
        $("#edit_item").html(html).show();
        $('#modeedititem').modal('show');
      }
    })
  }
</script>
