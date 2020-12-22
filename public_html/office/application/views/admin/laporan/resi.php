<head>
   <meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
   <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
</head>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4 class="pull-left" class="form-control"><b>Laporan Data Wilopo Cargo <?php echo $tanggal_now ?></b></h4>
      <!-- <h4 class="pull-left" class="form-control"><b>Total CBM <?php echo $tanggal_now ." : ". round($total_cbm,3) ?>m<sup>3</sup></b></h4> -->
      <form method="post" action="<?php echo base_url('admin/laporan/filter_resi') ?>">
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
  </div>
</div>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Laporan Data Resi <?php echo $tanggal_now ?></b></h3>
    </div>

    <div class="box-body">
      <div class="box-body table-responsive">

        <table class="table table-bordered table-striped no-margin" id="myresi">
          <thead>
            <tr>
              <th>Kode Mark Customer</th>
              <th>Nomor</th>
              <th>Tanggal</th>
              <th>Supplier</th>
              <th>Tel</th>
              <th>Note</th>
              <th>Gudang</th>
              <th>Status</th>
              <th>Cbm</th>
              <th>Total Jual</th>
              <th>Total Beli</th>
              <th>Perkiraan Laba</th>
              <th>Action</th>
            </tr>
          </thead>
          <?php foreach($record_resi as $rr){
            // Row Gudang
            if($rr->gudang == 5){
               $gudang = "Ghuangzhou";
            }else{
               $gudang = "Yiwu";
            }

            // Row Status
            if($rr->konfirmasi_resi == 0){
               $status = "Belum Konfirmasi";
            }else if($rr->konfirmasi_resi == 1){
              $status = "Konfirmasi";
            }else if($rr->konfirmasi_resi == 2){
              $status = "Konfirmasi & Asuransi";
            }

            // row cbm
            $countcbm = $this->db->select('sum(giw.volume*giw.ctns) as cbm')
                                  ->from('giw')
                                  ->where('giw.resi_id',$rr->id_resi)
                                  ->get()->row();
            $cbmresi = $countcbm->cbm;

            // row Total Jual
            $total  = 0;
            $jumlah = 0;
            $resijual = $this->db->select('giw.status_berat,giw.jenis_barang_id,giw.ctns as jumlah,giw.kurs,giw.volume,giw.berat,giw.qty,giw.nilai,giw.harga_jual')
                                  ->from('giw')
                                  ->join('resi', 'resi.id_resi=giw.resi_id', 'left')
                                  ->where('giw.resi_id',$rr->id_resi)
                                  ->get()->result();
            foreach ($resijual as $ils ) {
              include APPPATH. 'helpers/harga.php';
              $total_jual = $total ;
            }
            $total  = 0;
            $jumlah = 0;
            // row Total Beli
            $beliresi = $this->db->select('giw.status_berat,giw.jenis_barang_id,giw.ctns as jumlah,giw.kurs,giw.volume,giw.berat,giw.qty,giw.nilai,giw.harga as harga_jual')
                                  ->from('giw')
                                  ->join('resi', 'resi.id_resi=giw.resi_id', 'left')
                                  ->where('giw.resi_id',$rr->id_resi)
                                  ->get()->result();
            foreach ($beliresi as $ils ) {
              include APPPATH. 'helpers/harga.php';
              $total_beli = $total ;
            }
            // print_r($total_jual);die()
          ?>
          <tbody>
            <tr>
              <td><?php echo $rr->kode ?></td>
              <td><?php echo $rr->nomor ?></td>
              <td><?php echo date_indo($rr->tanggal) ?></td>
              <td><?php echo $rr->supplier ?></td>
              <td><?php echo $rr->tel ?></td>
              <td><?php echo $rr->note ?></td>
              <td><?php echo $gudang ?></td>
              <td><?php echo $status ?></td>
              <td><?php echo round($cbmresi,3) ?> m<sup>3</sup></td>
              <td><?php echo "Rp." . number_format($total_jual) ?></td>
              <td><?php echo "Rp." . number_format($total_beli) ?></td>
              <td><?php echo "Rp." . number_format($total_jual-$total_beli) ?></td>
              <td><a href="<?php echo site_url('admin/resi/detail/'.$rr->id_resi) ?>" class="btn btn-info btn-xs"> <i class="fa fa-ellipsis-h"></i></a></td>
            </tr>
          </tbody>
          <?php } ?>
        </tbody>
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
            ajax: {"url": "<?php echo base_url('admin/laporan/asuransi_json/'.$min.'/'.$max)?>", "type": "POST"},
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
              ajax: {"url": "<?php echo base_url('admin/laporan/titip_transfer_json/'.$min.'/'.$max)?>", "type": "POST"},
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
