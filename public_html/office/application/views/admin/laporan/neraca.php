<head>
   <meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
   <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
</head>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4 class="pull-left" class="form-control"><b>Laporan Neraca<?php echo $tanggal_now ?></b></h4>
      <!-- <h4 class="pull-left" class="form-control"><b>Total CBM <?php echo $tanggal_now ." : ". round($total_cbm,3) ?>m<sup>3</sup></b></h4> -->

    </div>
    <div class="box-body">
      <div class="box-body table-responsive">
        <div class="col-lg-6">
          <table class="table table-bordered no-margin" id="myresia">
            <thead>
              <th class="text-center">Aktiva</th>
              <th class="text-center">Jumlah</th>
            </thead>
            <tbody>
              <tr>
                  <td colspan="2"><b>Rekening</b></td>
              </tr>
              <?php $jumlah_rekening = 0; ?>
              <?php foreach ($rekening as $rek){
                $transaksi_bank_masuk  = $this->db->select('sum(nominal_transaksi_bank) as jumlah')->where('id_bank',$rek->id_bank)->where('tipe_transaksi_bank','masuk')->get('transaksi_bank')->row();
                $transaksi_bank_keluar = $this->db->select('sum(nominal_transaksi_bank) as jumlah')->where('id_bank',$rek->id_bank)->where('tipe_transaksi_bank','keluar')->get('transaksi_bank')->row();
                $fix_saldo = $transaksi_bank_masuk->jumlah - $transaksi_bank_keluar->jumlah;
              ?>
                <tr>
                  <td><?php echo $rek->nama_bank ?></td>
                  <td><?php echo number_format($fix_saldo) ?></td>
                </tr>
              <?php $jumlah_rekening+=$fix_saldo; } ?>
              <tr>
                  <td><b>Total Jumlah Rekening</b></td>
                  <td><b><?php echo "RP. ". number_format($jumlah_rekening); ?></b></td>
              </tr>
              <tr>
                  <td colspan="2"><b>RMB</b></td>
              </tr>
              <?php $total_jumlah_rmb = 0; $satu_saldo = 0; $kursrmb = 0; $totalrmb = 0;?>
              <?php foreach ($datarmb as $drmb){
                if($drmb->status_rmb == 1){
                  $namastock = "Stock Aktif";
                }else{
                  $namastock = "Stock Non-Aktif";
                }
                if($drmb->saldo_rmb == 0){
                  $satu_saldo = 1;
                  $datakurs = $this->db->order_by('status_rmb','asc')->get('rmb')->row();
                  $kurs_hitung = $datakurs->kurs_beli_rmb;
                }
                if($satu_saldo != 1){
                  $kursrmb += $drmb->kurs_beli_rmb;
                }
                $rupiahrmb = $drmb->saldo_rmb * $drmb->kurs_beli_rmb;
                $total_jumlah_rmb += $rupiahrmb;
                $totalrmb += $drmb->saldo_rmb;
              ?>
                <tr>
                  <td><?php echo $namastock ?></td>
                  <td><?php echo "¥. " . $drmb->saldo_rmb." ( Rp.".number_format($rupiahrmb).")";  ?></td>
                </tr>
              <?php }
                if($satu_saldo != 1 ){
                  $kurs_hitung = $kursrmb /2;
                }
              ?>
              <tr>
                  <td><b>Total Jumlah RMB</b></td>
                  <td><b><?php echo "¥. ". $totalrmb. " (RP. ". number_format($total_jumlah_rmb).")"; ?></b></td>
              </tr>
              <tr>
                  <td colspan="2"><b>Piutang per Vendor</b></td>
              </tr>
              <tr>
                <td>Invoice Import Laut</td>
                <td><?php echo "RP. " . number_format($invoicesea->jumlah); ?></td>
              </tr>
              <tr>
                <td>Invoice Import Udara</td>
                <td><?php echo "RP. " . number_format($invoiceair->jumlah); ?></td>
              </tr>
              <tr>
                <td>Invoice Lainnya</td>
                <td><?php echo "RP. " . number_format($invoicelainnya->jumlah); ?></td>
              </tr>
              <tr>
                <td>Invoice Titip Transfer</td>
                <td><?php echo "RP. " . number_format($invoicetrf->jumlah); ?></td>
              </tr>
              <tr>
                <td><b>Total Jumlah Piutang</b></td>
                <td><b><?php echo "RP. ". number_format($invoicesea->jumlah + $invoiceair->jumlah + $invoicelainnya->jumlah + $invoicetrf->jumlah); ?></b></td>
              </tr>
              <tr>
                <td colspan="2" style="height:25px;"> </td>
              </tr>
              <?php $totalassets = $invoicesea->jumlah + $invoiceair->jumlah + $invoicelainnya->jumlah + $invoicetrf->jumlah + $total_jumlah_rmb + $jumlah_rekening ; ?>
              <tr>
                <td><b>Total Assets</b></td>
                <td><b><?php echo "RP. ". number_format($totalassets); ?></b></td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="col-lg-6">
          <table class="table table-bordered no-margin" id="myresia">
            <thead>
              <th class="text-center">Liabilites</th>
              <th class="text-center">Jumlah</th>
            </thead>
            <tbody>
              <tr>
                  <td colspan="2"><b>Hutang Vendor</b></td>
              </tr>
              <tr>
                <td>Hutang ke Vendor LCL Laut </td>
                <td><?php echo "RP. " . number_format($hutang_lclsea->jumlah); ?></td>
              </tr>
              <tr>
                <td>Hutang ke Vendor LCL Udara </td>
                <td><?php echo "RP. " . number_format($hutang_lclair->jumlah); ?></td>
              </tr>
              <tr>
                <td>Hutang ke Vendor Invoice Lainnya</td>
                <td><?php echo "RP. " . number_format($hutang_invoice_lainnya->jumlah); ?></td>
              </tr>
              <tr>
                <td>Hutang Titip Transfer > 10000</td>
                <td><?php echo "RP. " . number_format($trf10000); ?></td>
              </tr>
              <?php $total_hutangrmb = $hutang_titiptrf->jumlah * $kurs_hitung; ?>
              <tr>
                <td>Hutang Titip Transfer < 10000</td>
                <td><?php echo "¥.".$hutang_titiptrf->jumlah. "  (RP. ". number_format($total_hutangrmb).")"; ?></td>
              </tr>

              <tr>
                  <td colspan="2"><b>Hutang Customer</b></td>
              </tr>
              <tr>
                <td>Komisi Tertahan</td>
                <td><?php echo "RP. " . number_format($komisi_tertahan->jumlah); ?></td>
              </tr>
              <tr>
                <td>Deposit </td>
                <td><?php echo "RP. " . number_format($deposit->jumlah); ?></td>
              </tr>

              <?php $total_liabilitas = $hutang_lclsea->jumlah + $hutang_lclair->jumlah + $hutang_invoice_lainnya->jumlah + $trf10000 + $total_hutangrmb + $komisi_tertahan->jumlah + $deposit->jumlah; ?>
              <tr>
                <td><b>Total Liabilitas</b></td>
                <td><b><?php echo "RP. ". number_format($total_liabilitas); ?></b></td>
              </tr>
              <tr>
                <td colspan="2" style="height:25px;"> </td>
              </tr>
              <tr>
                <td><b>Total Ekuitas</b></td>
                <td><b><?php echo "RP. ". number_format($totalassets - $total_liabilitas); ?></b></td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/jquery/select2.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>
<script src="<?php echo base_url() ?>assets/jquery/loadingoverlay.min.js"></script>
