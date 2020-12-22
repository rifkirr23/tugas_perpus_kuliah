<head>
   <meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
   <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
</head>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4 class="pull-left" class="form-control"><b>Laporan Invoice <?php echo $tanggal_now ?></b></h4>
      <!-- <h4 class="pull-left" class="form-control"><b>Total CBM <?php echo $tanggal_now ." : ". round($total_cbm,3) ?>m<sup>3</sup></b></h4> -->
      <form method="post" action="<?php echo base_url('admin/laporan/filter_master_invoice') ?>">
        <span class="pull-right" style="margin-right:5px;">
          <input type="submit" name="max" class="form-control btn btn-success" value="Filter Date" placeholder="Max Date"/>
        </span>
        <span class="pull-right" style="margin-right:5px;">
          <input type="date" name="max_date" class="form-control" value="<?php echo $now ?>" placeholder="Max Date"/>
        </span>
        <span class="pull-right" style="margin-right:5px;">
          <input type="date" name="min_date" class="form-control" value="<?php echo $now ?>" placeholder="Min Date"/>
        </span>
      </form>
    </div>
    <div class="box-body">
      <div class="box-body table-responsive">
        <table class="table table-striped no-margin" id="myresia">
          <thead>
            <?php
              $total_seluruhnya = $total_laba + $total_laba_sea + $total_laba_resi_udara + $total_laba_fcl - ($semua_komisi_barang + $semua_komisi_titip_trf);
             ?>
            <tr>
              <td>Total Jumlah Cbm</td>
              <td><b><?php echo round($total_cbm,3) ?> m<sup>3</sup></b></td>
            </tr>
            <tr>
              <td>Total Laba Invoice Sea </td>
              <td><b><?php echo "Rp." . number_format($total_laba_sea) ?></b></td>
            <tr>
            <tr>
              <td>Total Laba Invoice Udara</td>
              <td><b><?php echo "Rp." . number_format($total_laba_resi_udara) ?></b></td>
            <tr>
            <tr>
              <td>Total laba Invoice FCL</td>
              <td><b><?php echo "Rp." . number_format($total_laba_fcl) ?></b></td>
            <tr>
            <tr>
              <td>Total laba Invoice Titip Transfer </td>
              <td><b><?php echo "Rp.". number_format($total_laba) ?></b></td>
            <tr>
            <tr>
              <td colspan="2"><center>&nbsp;</center></td>
            </tr>
            <tr>
              <td>Komisi Barang</td>
              <td><b><?php echo "Rp." . number_format($semua_komisi_barang) ?></b></td>
            <tr>
            <tr>
              <td>Komisi Titip Transfer </td>
              <td><b><?php echo "Rp.". number_format($semua_komisi_titip_trf) ?></b></td>
            <tr>
            <tr>
              <td colspan="2"><center>&nbsp;</center></td>
            <tr>
            <tr>
              <td><h4><b>Total Laba</b></h4></td>
              <td><h4><b><?php echo "Rp.". number_format($total_seluruhnya) ?></b></h4></td>
            <tr>
            <tr>
              <td>Total Asuransi</td>
              <td><b><?php echo "Rp.". number_format($total_asuransi) ?></b></td>
            </tr>
            <tr>
              <td colspan="2"><center>&nbsp;</center></td>
            </tr>
            <tr>
              <td colspan="2"><b>Pengeluaran</b></td>
            </tr>
            <?php $total_pengeluaran=0; foreach ($pengeluaran_perkategori as $pengeluarank){ ?>
              <tr>
                <td><?php echo $pengeluarank->kjenis_transaksi_bank; ?></td>
                <td><?php echo "Rp.". number_format($pengeluarank->jumlah) ?></td>
              <tr>
            <?php $total_pengeluaran +=$pengeluarank->jumlah; } ?>
            <tr>
              <td><h4><b>Total Pengeluaran</b></h4></td>
              <td><h4><b><?php echo "Rp.". number_format($total_pengeluaran) ?></b></h4></td>
            <tr>

            <tr>
              <td><h4><b>Total Laba Bersih</b></h4></td>
              <td><h4><b><?php echo "Rp.". number_format($total_seluruhnya - $total_pengeluaran) ?></b></h4></td>
            <tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Laporan Data Invoice Sea <?php echo $tanggal_now ?></b></h3>
    </div>

    <div class="box-body">
      <div class="box-body table-responsive">

        <table class="table table-bordered table-striped no-margin" id="myresi">
          <thead>
            <tr>
              <th>Kode Mark Customer</th>
              <th>Invoice Jual</th>
              <th>Invoice Beli</th>
              <th>Tanggal</th>
              <th>Total Jual</th>
              <th>Total Beli</th>
              <th>Laba</th>
              <th>Presentase</th>
              <th>Action</th>
            </tr>
          </thead>
          <?php foreach($record_sea as $rs){
            $labasea = $rs->total_tagihan - $rs->jumlah_invoice_beli;
            $presentase = ($labasea/$rs->total_tagihan) * 100;

            // $data_invoice_product = $this->Mapiinvoice->get_invoice_product($rs->id_invoice)->result();
            // print_r($data_invoice_product); die();
          ?>
          <tbody>
            <tr>
              <td><?php echo $rs->kode ?></td>
              <td><?php echo $rs->kode_invoice ?></td>
              <td><?php echo $rs->kode_invoice_beli ?></td>
              <td><?php echo $rs->tanggal_invoice ?></td>
              <td><?php echo "Rp." . number_format($rs->total_tagihan) ?></td>
              <td><?php echo "Rp." . number_format($rs->jumlah_invoice_beli) ?></td>
              <td><?php echo "Rp." . number_format($labasea) ?></td>
              <td style="text-align:center;"><?php echo round($presentase) ?>%</td>
              <td><a href="<?php echo site_url('admin/invoice_barang/detail/'.$rs->id_invoice) ?>" class="btn btn-info btn-xs"> <i class="fa fa-ellipsis-h"></i></a></td>
            </tr>
          </tbody>
          <?php } ?>
        </tbody>
       </table>
     </div>
   </div>
 </div>
</div>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Laporan Data Resi Udara <?php echo $tanggal_now ?></b></h3>
    </div>

    <div class="box-body">
      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped no-margin" id="myresi">
          <thead>
            <tr>
              <th>Kode Mark Customer</th>
              <th>Resi</th>
              <th>Invoice Jual</th>
              <th>Invoice Beli</th>
              <th>Nama Barang</th>
              <th>Ctns</th>
              <th>Berat</th>
              <th>Tanggal Resi</th>
              <th>Total Jual</th>
              <th>Total Beli</th>
              <th> Laba</th>
              <th>Action</th>
            </tr>
          </thead>
          <?php foreach($record_air as $ra){
            $labaair = $ra->total_tagihan - $ra->jumlah_invoice_beli
          ?>
          <tbody>
            <tr>
              <td><?php echo $ra->kode ?></td>
              <td><?php echo $ra->nomor_resi ?></td>
              <td><?php echo $ra->kode_invoice ?></td>
              <td><?php echo $ra->kode_invoice_beli ?></td>
              <td><?php echo $ra->nama_barang ?></td>
              <td><?php echo $ra->ctns ?></td>
              <td><?php echo $ra->berat ?> Kg</td>
              <td><?php echo $ra->tanggal_resi ?></td>
              <td><?php echo "Rp." . number_format($ra->total_tagihan) ?></td>
              <td><?php echo "Rp." . number_format($ra->jumlah_invoice_beli) ?></td>
              <td><?php echo "Rp." . number_format($labaair) ?></td>
              <td><a href="<?php echo site_url('admin/resi_udara/invoice_detail/'.$ra->id_invoice.'/'.$ra->id_resi_udara.'/air') ?>" class="btn btn-info btn-xs"> <i class="fa fa-ellipsis-h"></i></a></td>
            </tr>
          </tbody>
          <?php } ?>
        </tbody>
       </table>
     </div>
   </div>
 </div>
</div>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Laporan Data FCL <?php echo $tanggal_now ?></b></h3>
    </div>

    <div class="box-body">
      <div class="box-body table-responsive">

        <table class="table table-bordered table-striped no-margin" id="myresi">
          <thead>
            <tr>
              <th>Kode Mark Customer</th>
              <th>Invoice Jual</th>
              <th>Invoice Beli</th>
              <th>Tanggal Resi</th>
              <th>Total Jual</th>
              <th>Total Beli</th>
              <th> Laba</th>
              <th>Action</th>
            </tr>
          </thead>
          <?php foreach($record_fcl as $rf){
            $labaair = $rf->total_tagihan - $rf->jumlah_invoice_beli
          ?>
          <tbody>
            <tr>
              <td><?php echo $rf->kode ?></td>
              <td><?php echo $rf->kode_invoice ?></td>
              <td><?php echo $rf->kode_invoice_beli ?></td>
              <td><?php echo $rf->tanggal_invoice ?></td>
              <td><?php echo "Rp." . number_format($rf->total_tagihan) ?></td>
              <td><?php echo "Rp." . number_format($rf->jumlah_invoice_beli) ?></td>
              <td><?php echo "Rp." . number_format($labaair) ?></td>
              <td><a href="<?php echo site_url('admin/resi_udarf/invoice_detail/'.$rf->id_invoice.'/'.$rf->id_resi_udara.'/air') ?>" class="btn btn-info btn-xs"> <i class="fa fa-ellipsis-h"></i></a></td>
            </tr>
          </tbody>
          <?php } ?>
        </tbody>
       </table>
     </div>
   </div>
 </div>
</div>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Laporan Titip Transfer <?php echo $tanggal_now ?></b></h3>
    </div>
    <div class="box-body">
      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped no-margin" id="mytrf">
          <thead>
            <tr>
              <th>Kode Mark Customer</th>
              <th>Kode Transaksi</th>
              <th>Kode Invoice</th>
              <th>Tanggal Transaksi</th>
              <th>Jumlah Rmb</th>
              <th>Jumlah Rmb2</th>
              <th>Kurs Jual</th>
              <th>Kurs Beli</th>
              <th>Kurs Beli2</th>
              <th>Fee Bank</th>
              <th>Fee Cs</th>
              <th>Status</th>
              <th>Laba</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

<br/><br/>
<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Laporan Asuransi <?php echo $tanggal_now ?></b></h3>
    </div>
    <div class="box-body">
      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped no-margin" id="myasuransi">
          <thead>
            <tr>
              <th>Kode Mark Customer</th>
              <th>Resi</th>
              <th>Invoice</th>
              <th>Tanggal Asuransi</th>
              <th>Formula</th>
              <th>Jumlah</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>

<script>
$(document).ready(function(){
  // Setup datatables
  $('#myresi').dataTable( {
    "pageLength": 10
  });
  // Setup datatables
  $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
    {
        return {
            "iStart": oSettings._iDisplayStart,
            "iEnd": oSettings.fnDisplayEnd(),
            "iLength": oSettings._iDisplayLength,
            "iTotal": oSettings.fnRecordsTotal(),
            "iFilteredTotal": oSettings.fnRecordsDisplay(),
            "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
            "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
        };
    };

    var table = $("#myasuransi").dataTable({
        initComplete: function() {
            var api = this.api();
            $('#mytable_filter keyup')
                .off('.DT')
                .on('keyup.DT', function() {
                    api.search(this.value).draw();
            });
        },
            oLanguage: {
            sProcessing: "loading..."
        },
            scrollX: true,
            processing: true,
            serverSide: true,
            ajax: {"url": "<?php echo base_url('admin/laporan/asuransi_json/')?>", "type": "POST"},
                columns: [
                      {"data": "kode"},
                      {"data": "nomor_resi"},
                      {"data": "kode_invoice"},
                      {"data": "tanggal_inv_asuransi"},
                      {"data": "note"},
                      {"data": "jumlah_asuransi", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                ],
            order: [[1, 'desc']],
        rowCallback: function(row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            $('td:eq(0)', row).html();
        }

    });
    // end setup datatables

    // Setup datatables
    $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
      {
          return {
              "iStart": oSettings._iDisplayStart,
              "iEnd": oSettings.fnDisplayEnd(),
              "iLength": oSettings._iDisplayLength,
              "iTotal": oSettings.fnRecordsTotal(),
              "iFilteredTotal": oSettings.fnRecordsDisplay(),
              "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
              "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
          };
      };

      var table = $("#mytrf").dataTable({
          initComplete: function() {
              var api = this.api();
              $('#mytable_filter keyup')
                  .off('.DT')
                  .on('keyup.DT', function() {
                      api.search(this.value).draw();
              });
          },
              oLanguage: {
              sProcessing: "loading..."
          },
              scrollX: true,
              processing: true,
              serverSide: true,
              ajax: {"url": "<?php echo base_url('admin/laporan/titip_transfer_json/')?>", "type": "POST"},
                  columns: [
                        {"data": "mark_transaksi"},
                        {"data": "kode_transaksi"},
                        {"data": "kode_invoice"},
                        {"data": "tanggal_transaksi"},
                        {"data": "jumlah_rmb"},
                        {"data": "jumlah_rmb2"},
                        {"data": "kurs_jual", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                        {"data": "kurs_beli",  render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                        {"data": "kurs_beli2",  render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                        {"data": "fee_bank"},
                        {"data": "fee_cs",  render: $.fn.dataTable.render.number(',', '.','','¥ ')},
                        {"data": "status" ,
                          render : function(data,type,row){
                            var strStatus = "";
                            if(row.status == 1){
                              strStatus = "Pending";
                            }else if(row.status == 2){
                              strStatus = "Process";
                            }else if(row.status == 3){
                              strStatus = "Complete";
                            }
                            return strStatus ;
                          }
                        },
                        //render harga dengan format angka
                        {"data": "laba_titip_transfer",  render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                  ],
              order: [[1, 'desc']],
          rowCallback: function(row, data, iDisplayIndex) {
              var info = this.fnPagingInfo();
              var page = info.iPage;
              var length = info.iLength;
              $('td:eq(0)', row).html();
          }

      });
      // end setup datatables
});
</script>
