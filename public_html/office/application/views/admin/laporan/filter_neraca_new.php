<head>
   <meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
   <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
</head>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4 class="pull-left" class="form-control"><b>Laporan Neraca <?php echo $tanggal_now ?></b></h4>
      <!-- <h4 class="pull-left" class="form-control"><b>Total CBM <?php echo $tanggal_now ." : ". round($total_cbm,3) ?>m<sup>3</sup></b></h4> -->
      <form method="post" action="<?php echo base_url('admin/laporan/filter_neraca_new') ?>">
        <span class="pull-right" style="margin-right:5px;">
          <input type="submit" name="max" class="form-control btn btn-success" value="Filter Date" placeholder="Max Date"/>
        </span>
        <span class="pull-right" style="margin-right:5px;">
          <input type="date" name="max_date" class="form-control" value="<?php echo date("Y-m-d") ?>" placeholder="Max Date"/>
        </span>
        <span class="pull-right" style="margin-right:5px;">
          <input type="date" name="min_date" class="form-control" value="<?php echo date("Y-m-d") ?>" placeholder="Min Date"/>
        </span>
      </form>
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
                  <td colspan="2" style="color:green;"><b><center>Aktiva Lancar</center></b></td>
              </tr>
              <tr>
                  <td colspan="2"><b>Rekening</b></td>
              </tr>
              <?php $jumlah_rekening = 0; ?>
              <?php foreach ($rekening as $rek){
                $transaksi_bank_masuk  = $this->db->select('sum(nominal_transaksi_bank) as jumlah')->where('id_bank',$rek->id_bank)->where('tipe_transaksi_bank','masuk')->where('tanggal_transaksi_bank <=',$max)->get('transaksi_bank')->row();
                $transaksi_bank_keluar = $this->db->select('sum(nominal_transaksi_bank) as jumlah')->where('id_bank',$rek->id_bank)->where('tipe_transaksi_bank','keluar')->where('tanggal_transaksi_bank <=',$max)->get('transaksi_bank')->row();
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
                  <td colspan="2"><b>Perlengkapan</b></td>
              </tr>
              <?php $total_perlengkapan = 0; foreach ($perlengkapan_kantor as $pk ){ ?>
                <tr>
                  <td><?php echo $pk->keterangan_transaksi_bank; ?></td>
                  <td><?php echo "RP. " . number_format($pk->nominal_transaksi_bank); ?></td>
                </tr>
              <?php $total_perlengkapan += $pk->nominal_transaksi_bank; } ?>
              <tr>
                <td><b>Total Jumlah Perlengkapan</b></td>
                <td><b><?php echo "RP. ". number_format($total_perlengkapan); ?></b></td>
              </tr>
              <tr>
                  <td colspan="2"><b>Asuransi dibayar dimuka</b></td>
              </tr>
              <!-- <tr>
                <td colspan="2" style="height:35px;"> </td>
              </tr> -->
              <?php $total_aktiva_lancar = $invoicesea->jumlah + $invoiceair->jumlah + $invoicelainnya->jumlah + $invoicetrf->jumlah + $total_jumlah_rmb + $jumlah_rekening + $total_perlengkapan ; ?>
              <tr>
                <td colspan="2" style="color:green;"><center><b>Total Aktiva Lancar &nbsp;&nbsp;&nbsp;<?php echo "RP. ". number_format($total_aktiva_lancar); ?></b></center></td>
              </tr>
              <tr>
                <td colspan="2" style="height:35px;"> </td>
              </tr>
              <!-- Selesai Aktiva lancar -->
              <tr>
                  <td colspan="2" style="color:green;"><b><center>Aktiva Tetap</center></b></td>
              </tr>
              <tr>
                  <td colspan="2"><b>Peralatan</b></td>
              </tr>
              <?php $total_peralatan = 0;
                    foreach ($peralatan_kantor as $peralat ){
                      $tanggal_transaksi  = strtotime($peralat->tanggal_transaksi_bank);
                  		$sekarang    = time(); // Waktu sekarang
                  		$diff   = $sekarang - $tanggal_transaksi;
                  		$berapabulan = floor($diff / (60 * 60 * 24 * 30));
              ?>
                      <tr>
                        <td><?php echo $peralat->keterangan_transaksi_bank; ?></td>
                        <td><?php echo "RP. " . number_format($peralat->nominal_transaksi_bank); ?></td>
                      </tr>
                      <?php if ($berapabulan > 0 && $peralat->penyusutan > 0){
                        $total_penyusutan = $peralat->penyusutan * $berapabulan;
                       ?>
                        <tr>
                          <td style="color:red;">Penyusutan Bulan ke <?php echo $berapabulan; ?></td>
                          <td style="color:red;"><?php echo "RP. -" . number_format($peralat->penyusutan * $berapabulan); ?></td>
                        </tr>
                      <?php } ?>
              <?php $total_peralatan   += $peralat->nominal_transaksi_bank - $total_penyusutan; }
                    $total_aktiva_tetap = $total_peralatan;
              ?>
              <tr>
                <td><b>Total Jumlah Perlengkapan</b></td>
                <td><b><?php echo "RP. ". number_format($total_peralatan); ?></b></td>
              </tr>
              <tr>
                <td colspan="2" style="color:green;"><center><b>Total Aktiva Tetap &nbsp;&nbsp;&nbsp;<?php echo "RP. ". number_format($total_aktiva_tetap); ?></b></center></td>
              </tr>
              <tr>
                <td colspan="2" style="height:35px;"> </td>
              </tr>
              <tr>
                <td colspan="2" style="color:green;"><center><b>Total Aktiva &nbsp;&nbsp;&nbsp;<?php echo "RP. ". number_format($total_aktiva_tetap + $total_aktiva_lancar); ?></b></center></td>
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
                  <td colspan="2" style="color:red;"><b><center>Kewajiban</center></b></td>
              </tr>
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
              <?php
                $month = date("m",strtotime(date('Y-m-d')));
                $cek_gaji = $this->db->where('id_jenis_transaksi_bank',16)->where('month(tanggal_transaksi_bank)',$month)->get('transaksi_bank')->num_rows();
                // print_r($this->db->last_query());die();
                $get_gaji_sebelumnya = $this->db->where('id_jenis_transaksi_bank',16)->order_by('id_transaksi_bank','desc')->limit(1)->get('transaksi_bank')->row();
              ?>
              <?php if ($cek_gaji == 0){ ?>
                <tr>
                    <td colspan=""><b>Hutang Gaji</b></td>
                    <td colspan=""><b><?php echo "RP. " . number_format($get_gaji_sebelumnya->nominal_transaksi_bank); ?></b></td>
                </tr>
              <?php } ?>

              <?php $total_liabilitas = $hutang_lclsea->jumlah + $hutang_lclair->jumlah + $hutang_invoice_lainnya->jumlah + $trf10000 + $total_hutangrmb + $komisi_tertahan->jumlah + $deposit->jumlah; ?>
              <tr>
                <td colspan="2" style="color:red;"><center><b>Total Kewajiban &nbsp;&nbsp;&nbsp;<?php echo "RP. ". number_format($total_liabilitas); ?></b></center></td>
              </tr>
              <tr>
                <td colspan="2" style="height:25px;"> </td>
              </tr>
              <tr>
                <td><b>Total Laba Ditahan</b></td>
                <td><b><?php echo "RP. ". number_format($total_laba); ?></b></td>
              </tr>
              <tr>
                <td colspan="2" style="height:25px;"> </td>
              </tr>
              <?php $ekuitas = (($total_aktiva_tetap + $total_aktiva_lancar) - $total_liabilitas) - $total_laba; ?>
              <tr>
                <td><b>Total Ekuitas</b></td>
                <td><b><?php echo "RP. ". number_format($ekuitas); ?></b></td>
              </tr>

              <tr>
                <td colspan="2" style="height:25px;"> </td>
              </tr>
              <tr>
                <td colspan="2"  style="color:red;"><center><b>Total Pasiva &nbsp;&nbsp;&nbsp;<?php echo "RP. ". number_format($total_liabilitas + $total_laba + $ekuitas); ?></b></center></td>
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
