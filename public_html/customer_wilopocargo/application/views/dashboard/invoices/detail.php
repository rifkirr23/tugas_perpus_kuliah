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
                        <a class="btn btn-primary" type="button" href="<?php echo base_url(); ?>invoices/printdetail/<?php echo $this->uri->segment(3); ?>"><i class="fa fa-print"></i> Print Invoice</a>
                        <a class="btn btn-secondary" type="button" href="<?php echo base_url(); ?>invoices/printdetail/<?php echo $this->uri->segment(3); ?>/1"><i class="fa fa-download"></i> Download Invoice</a>
                    </div>
                    <!-- badge status pembayaran ditambahkan class .belum-dibayar, .dibayar, dan .dibayar-sebagian -->
                    <div class="detail-invoice belum-dibayar">
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
                                                    <td><span class="text-primary">#<?php echo $r->kode_invoice; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <th class="w-25">Date</th>
                                                    <td><?php echo date_indo($r->tanggal_invoice); ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="w-25">Kode Mark.</th>
                                                    <td><?php echo $r->kode; ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="w-25">Alamat</th>
                                                    <td><?php echo $r->alamat; ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="w-25">Phone</th>
                                                    <td><?php echo $r->telepon; ?></td>
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
                                            <th>RESI</th>
                                            <th>BARCODE</th>
                                            <th>GOODS</th>
                                            <th>CTNS</th>
                                            <th>QTY</th>
                                            <th>WEIGHT</th>
                                            <th>RMB</th>
                                            <th>VOLUME</th>
                                            <th>FREIGHT</th>
                                            <th class="text-right">JUMLAH</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                            foreach ($invoicedetail as $ils ) {
                                        $mrmb = $ils->nilai * $ils->jumlah * $ils->qty;
                                        $mqty= $ils->qty * $ils->jumlah;
                                        $mberat= $ils->berat * $ils->jumlah;
                                        $mvolume= $ils->volume * $ils->jumlah;

                                        $tctns  +=$ils->jumlah;
                                        $tqty   +=$mqty;
                                        $tberat +=$mberat;
                                        $tvolume +=$mvolume;
                                        $trmb +=$mrmb;
                                        include APPPATH. 'helpers/harga.php';
                                        $tharga += $harga;
                                                ?>
                                        <tr>
                                            <td><?php echo $ils->nomorresi ?></td>
                                            <td style="height: 25px;"><?php echo $ils->nomor ?></td>
                                            <td><?php echo $ils->barang ?></td>
                                            <td><?php echo $ils->jumlah ?></td>
                                            <td>@<?php echo $ils->qty." / ".$mqty?> pcs</td>
                                            <td>@<?php echo $ils->berat." / ".$mberat ?> kg</td>
                                            <td>@<?php echo $ils->nilai." / ".$mrmb ?> RMB</td>
                                            <td>@<?php echo $ils->volume." / ".$mvolume ?> m<sup>3</sup></td>
                                            <td class="text-right"><?php
                                                if($stsberat == 1){
                                                    echo "Rp.". number_format($hargasatuan,2);
                                                }else{
                                                    echo "Rp.". number_format($hargasatuan);
                                                }
                                            ?>
                                            </td>
                                            <td class="text-right"><?php echo"Rp.". number_format($harga) ?></td>
                                        </tr>
                                        <?php  } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3">JUMLAH</td>
                                            <td colspan=""><?php echo $tctns ?></td>
                                            <td colspan=""><?php echo $tqty ?></td>
                                            <td colspan=""><?php echo $tberat ?> Kg</td>
                                            <td colspan=""><?php echo $trmb ?> RMB</td>
                                            <td colspan=""><?php echo $tvolume ?> m<sup>3</sup</td>
                                            <td colspan=""></td>
                                            <td colspan="2" class="text-right"><?php echo "Rp.". number_format($tharga) ?></td>
                                        </tr>
                                        <?php foreach ($record_asuransi as $asr){ ?>
                                            <tr>
                                                <td colspan="9">ASURANSI <?php echo $asr->nomor ; ?></td>
                                                <td colspan="2" class="text-right"><?php echo "Rp.".number_format($asr->jumlah_asuransi) ?> </td>
                                            </tr>
                                        <?php } ?>

                                        <?php foreach ($potongan as $pot){ ?>
                                            <tr>
                                                <td colspan="9"><?php echo $pot->keterangan_potongan; ?></td>
                                                <td colspan="2" class="text-right"><?php echo "Rp.".number_format($pot->jumlah_potongan) ?> </td>
                                            </tr>
                                        <?php } ?>

                                            <tr>
                                                <td colspan="9"><b>TOTAL TAGIHAN</b> </td>
                                                <td colspan="2" class="text-right"><b><?php echo "Rp.".number_format($r->total_tagihan) ?> </b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="9"><b>JUMLAH BAYAR</b> </td>
                                                <td colspan="2" class="text-right"><b><?php echo "Rp.".number_format($r->jumlah_bayar) ?> </b></td>
                                            </tr>
                                            <?php if($r->total_tagihan-$r->jumlah_bayar > 0){?>
                                            <tr>
                                                <td colspan="9"><b>SISA BAYAR</b> </td>
                                                <td colspan="2" class="text-right"><b><?php echo "Rp.".number_format($r->total_tagihan-$r->jumlah_bayar) ?> </b></td>
                                            </tr>
                                            <?php }?>
                                    </tfoot>
                                </table>

                                        <?php if($r->status_invoice == '0'  and $r->total_tagihan > $r->jumlah_bayar and $r->jumlah_bayar != '0'){?>
                                            <div class="status-bayar dibayar-sebagian">
                                                <p>Status Invoice: <span>
                                                    <i class="fa fa-sync"></i> DIBAYAR SEBAGIAN
                                                    </span>
                                                </p>
                                            </div>
                                        <?php }else if($r->status_invoice == '0'){ ?>
                                            <div class="status-bayar belum-dibayar">
                                                <p>Status Invoice: <span>
                                                    <i class="fa fa-times-circle"></i> BELUM LUNAS
                                                    </span>
                                                </p>
                                            </div>
                                        <?php }else if($r->status_invoice == '1'){ ?>
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
