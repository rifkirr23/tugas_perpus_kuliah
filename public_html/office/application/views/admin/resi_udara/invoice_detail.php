<head>
  <meta charset="utf-8">
  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link href="<?php echo base_url().'assets/ignited/css/dataTables.bootstrap.css'?>" rel="stylesheet" type="text/css"/>
  <style>
  .tdcenter{
     text-align: center;
   }
  </style>
</head>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Resi Udara</b></h3>
      <span class="pull-right"><a href="javascript:void(0);" onclick="edit_item(<?php echo $r->id_resi_udara ?>)" class="btn btn-primary" alt="Update Data">
      <i class="fa fa-edit"> Edit </i></a></span>
    </div>

<div class="box-body">
  <div class="box-body table-responsive">

    <table class="table table-bordered table-striped ">
      <thead>
        <tr>
            <td><b><center>NOMOR RESI</center></font></b></td>
            <td><b><center>DESKRIPSI </center></font></b></td>
            <td><b><center>CTNS		  </center></b></td>
            <td><b><center>BERAT			</center></b></td>
            <td><b><center>HARGA PER UNIT</center></b></font></td>
            <td><b><center>TOTAL </center></font></b></td>
        </tr>
            </thead>
      <tr style="display: none;">

      </tr>
      <tbody>
        <tr>
          <td style="height: 50px;" rowspan="2" class="tdcenter"><font color="black">
          <?php echo $r->nomor_resi ?>
          </td>
          <td class="tdcenter"><font color="black">
          <?php echo $r->nama_barang; ?>
          </td>
          <td class="tdcenter" rowspan="2"><font color="black"><font color="black">
          <?php echo $r->ctns; ?>
          </td>
          <td class="tdcenter" rowspan="2"><font color="black">
          <?php
            if($r->tanggal_resi >= "2020-08-22" || $r->id_resi_udara == 297 ){
              $berat = $r->berat_pembulatan;
            }else{
              $berat = $r->berat_pembulatan;
            }
            echo $berat; ?> kg
          </td>
          <td class="tdcenter"><font color="black">
          <?php echo "Rp ". number_format($r->harga_jual); ?>
          </td>
          <td class="tdcenter"><font color="black">
          <?php echo "Rp ". number_format($r->harga_jual * $berat); ?>
          </td>
        </tr>

        <tr>
          <td class="tdcenter"><font color="black">Goni</td>
          <td class="tdcenter"><font color="black">
          <?php echo "Rp ". number_format($r->harga_jual_goni); ?>
          </td>
          <td class="tdcenter"><font color="black">
          <?php echo "Rp ". number_format($r->harga_jual_goni * $r->ctns); ?>
          </td>
        </tr>

        <tr>
        <td colspan="5"><center><b>TOTAL</b></center></td>
        <td style="height: 30px;"><b><?php echo "Rp ". number_format($r->total_tagihan); ?></b></td>
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
      <h3 class="box-title"><b>Invoice Jual</b></h3>

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
      <span class="pull-right">
        <button class="btn btn-primary" data-toggle="modal" data-target="#myModalAdd"><i class="fa fa-plus"> Potongan </i></button>
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
                     <input type="hidden" name="redirect" value="<?php echo base_url()."admin/".$this->uri->segment(2)."/".$this->uri->segment(3)."/".$this->uri->segment(4)."/".$this->uri->segment(5)."/".$this->uri->segment(6) ?>" ?>
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

    <div id="edit_item"></div>


<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>

<script type="text/javascript">
  function edit_item(id)
  {
    console.log(id);
    $.ajax({
      type : "GET",
      url : "<?php echo base_url() ?>admin/resi_udara/edit_item/"+id,
      cache : false,
      async : false,
      success : function(html){
        $("#edit_item").html(html).show();
        $('#modeedititem').modal('show');
      }
    })
  }
</script>
