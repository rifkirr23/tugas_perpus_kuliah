<head>
  <title>Wilopo Cargo - Invoice Detail</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<!--Main Konten-->
<section class="main-konten">
    <div class="container-fluid">

        <!--Start Jumbotron -->
        <div id="bertema" class="jumbotron-default minimalis">
            <div class="judul-jumbotron">
                <h3><a href="invoice.html"><img src="<?php echo base_url(); ?>assets/dashboard/gambar/icw-back.svg" alt=""></a> Invoice Detail</h3>
            </div>
        </div>
        <!--End Jumbotron-->

        <div class="row kolom-row mt-4">
            <div class="col-12">
                <div class="wrap-blank">
                    <div class="top-btn">
                        <a class="btn btn-primary" type="button" href="<?php echo base_url(); ?>invoices/printdetail_tt/<?php echo $this->uri->segment(3); ?>"><i class="fa fa-print"></i> Print Invoice</a>
                        <a class="btn btn-secondary" type="button" href="<?php echo base_url(); ?>invoices/printdetail_tt/<?php echo $this->uri->segment(3); ?>/1"><i class="fa fa-download"></i> Download Invoice</a>
                    </div>
                    <!-- badge status pembayaran ditambahkan class .belum-dibayar, .dibayar, dan .dibayar-sebagian -->
                    <div class="detail-invoice belum-dibayar" id="invoice">
                        <div class="header-invoice">
                            <div class="kop-logo">
                                <img src="<?php echo base_url(); ?>assets/dashboard/gambar/logo.png" alt="">
                            </div>
                            <div class="kop-nomor">
                                <h3>Invoice<span>#<?php echo $r->kode_invoice; ?></span> </h3>
                            </div>
                        </div>
                        <div class="body-inv">
                            <div class="row row-alamat-inv">
                                <div class="col-md-5 col-lg-5 col-xl-5">
                                    <div class="alamat-inv">
                                        <h3>Wilopo Cargo</h3>
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th class="w-25">Alamat</th>
                                                    <td>Rukan Venice Blok B-85
                                                        Golf Lake Residence, Jl. Kamal Raya Outer 			  Ring Road, Cengkareng Timur.
                                                        Jakarta Barat, 11730 - Indonesia</td>
                                                </tr>
                                                <tr>
                                                    <th class="w-25">Phone</th>
                                                    <td>021 225 21995</td>
                                                </tr>
                                                <tr>
                                                    <th class="w-25">eMail</th>
                                                    <td>info@wilopocargo.com</td>
                                                </tr>
                                                <tr>
                                                    <th class="w-25">Website</th>
                                                    <td>https://wilopocargo.com</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-5 col-lg-5 col-xl-5">
                                    <div class="alamat-inv">
                                        <h3>Customer</h3>
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th class="w-25">No. Invoice</th>
                                                    <td><span class="text-primary">#<?php echo $invoice->kode_invoice; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <th class="w-25">Date</th>
                                                    <td><?php echo date_indo($invoice->tanggal_invoice); ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="w-25">Kode Mark.</th>
                                                    <td><?php echo $invoice->kode; ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="w-25">Alamat</th>
                                                    <td><?php echo $invoice->alamat; ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="w-25">Phone</th>
                                                    <td><?php echo $invoice->telepon; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="data-inv table-responsive">
                                <table class="table table-light" width="100%">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>JUMLAH RMB</th>
                                            <th>KURS</th>
                                            <th>FEE BANK</th>
                                            <th>FEE CS</th>
                                            <th>BANK TUJUAN</th>
                                            <th class="text-right">JUMLAH</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $jumlahtagihan=0;?>
                                    <?php $no=1; foreach($transaksi as $f){
                                    $jumlahdesimal = "0"; $pemisahdesimal = ",";
                                    $pemisahribuan =".";  $pemisahribuan =".";
                                        ?>
                                        <tr>
                                            <td class="text-right"><?php echo "짜 ". number_format($f->jumlah_rmb,$jumlahdesimal,$pemisahdesimal,$pemisahribuan); ?></td>
                                            <td class="text-right"><?php echo "Rp.". number_format($f->kurs_jual,$jumlahdesimal,$pemisahdesimal,$pemisahribuan); ?></td>
                                            <td class="text-right"><?php echo "짜 ". number_format($f->fee_bank,$jumlahdesimal,$pemisahdesimal,$pemisahribuan); ?></td>
                                            <td class="text-right"><?php echo "짜 ". number_format($f->fee_cs,$jumlahdesimal,$pemisahdesimal,$pemisahribuan); ?></td>
                                            <td><?php echo $f->bank_tujuan ?></td>
                                            <td class="text-right"><?php $jumlahtagihan +=($f->jumlah_rmb+$f->fee_bank+$f->fee_cs)*$f->kurs_jual;  echo "Rp.". number_format(($f->jumlah_rmb+$f->fee_bank+$f->fee_cs)*$f->kurs_jual); ?></td>
                                        </tr>
                                    <?php $no++; } ?>
                                    </tbody>
                                    <tfoot>
                                        <?php foreach ($potongan as $pot){ ?>
                                            <tr>
                                                <td colspan="5"><?php echo $pot->keterangan_potongan; ?></td>
                                                <td colspan="1" class="text-right"><?php echo "Rp.".number_format($pot->jumlah_potongan) ?> </td>
                                            </tr>
                                        <?php } ?>

                                            <tr>
                                                <td colspan="5"><b>TOTAL TAGIHAN</b> </td>
                                                <td colspan="" class="text-right"><b><?php echo "Rp.".number_format($invoice->total_tagihan); ?> </b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5"><b>JUMLAH BAYAR</b> </td>
                                                <td colspan="1" class="text-right"><b><?php echo "Rp.".number_format($invoice->jumlah_bayar) ?> </b></td>
                                            </tr>
                                            <?php if($invoice->total_tagihan-$invoice->jumlah_bayar > 0){?>
                                            <tr>
                                                <td colspan="5"><b>SISA BAYAR</b> </td>
                                                <td colspan="1" class="text-right"><b><?php echo "Rp.".number_format($invoice->total_tagihan-$invoice->jumlah_bayar) ?> </b></td>
                                            </tr>
                                            <?php }?>
                                    </tfoot>
                                </table>

                                        <?php if($invoice->status_invoice == '0'  and $invoice->total_tagihan > $invoice->jumlah_bayar and $invoice->jumlah_bayar != '0'){?>
                                            <div class="status-bayar dibayar-sebagian">
                                                <p>Status Invoice: <span>
                                                    <i class="fa fa-sync"></i> DIBAYAR SEBAGIAN
                                                    </span>
                                                </p>
                                            </div>
                                        <?php }else if($invoice->status_invoice == '0'){ ?>
                                            <div class="status-bayar belum-dibayar">
                                                <p>Status Invoice: <span>
                                                    <i class="fa fa-times-circle"></i> BELUM LUNAS
                                                    </span>
                                                </p>
                                            </div>
                                        <?php }else if($invoice->status_invoice == '1'){ ?>
                                            <div class="status-bayar sudah-dibayar">
                                                <p>Status Invoice: <span>
                                                    <i class="fa fa-check-circle"></i> SUDAH DIBAYAR
                                                    </span>
                                                </p>
                                            </div>
                                        <?php } ?>
                                    <!-- <p>Status Invoice: <span><i class="fa fa-check-circle"></i> SUDAH DIBAYAR</span></p> -->
                                    <!-- <p>Status Invoice: <span><i class="fa fa-sync"></i> DIBAYAR SEBAGIAN</span></p> -->
                            </div>
                            <div class="inf-rekening">
                                <h3>Info Pembayaran</h3>
                                <div class="inf">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>Nama Bank</td>
                                                <th>BCA (Bank Central Asia)</th>
                                            </tr>
                                            <tr>
                                                <td>Cabang</td>
                                                <th>KCP Mega Mall Pluit</th>
                                            </tr>
                                            <tr>
                                                <td>No. Rekening</td>
                                                <th>5810 557 747</th>
                                            </tr>
                                            <tr>
                                                <td>Nama Rekening</td>
                                                <th>Gusmavin Wilopo</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="top-btn">
                        <button class="btn btn-primary" type="button" onclick="printDiv('invoice')"><i class="fa fa-print"></i> Print Invoice</button>
                        <button class="btn btn-secondary" type="button"><i class="fa fa-download"></i> Download Invoice</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--End Main-->
<script>
      function printDiv(divName) {
          var printContents = document.getElementById(divName).innerHTML;
          var originalContents = document.body.innerHTML;

          document.body.innerHTML = printContents;

          window.print();

          document.body.innerHTML = originalContents;
      }
</script>
