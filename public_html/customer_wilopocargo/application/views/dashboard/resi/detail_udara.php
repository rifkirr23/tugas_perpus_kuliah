<head>
  <title>Wilopo Cargo - Resi Detail</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

    <!--Main Konten-->
    <section class="main-konten">
        <div class="container-fluid">

            <!--Start Jumbotron -->
            <div class="jumbotron-default minimalis">
                <div class="judul-jumbotron">
                    <h3><a href="javascript: window.history.go(-1)"><img src="<?php echo base_url(); ?>assets/dashboard/gambar/icw-back.svg" alt=""></a> Detail Resi Udara</h3>
                </div>
            </div>
            <!--End Jumbotron-->

            <div class="row kolom-row">
                <div class="col-12">
                    <div class="kartu">
                        <div class="head-kartu">
                            <div class="kiri">
                                <h3><i class="fa fa-sticky-note"></i> Detail Resi Udara</h3>
                            </div>
                            <div class="kanan">
                                <a href="#" onclick="reFresh()"><i class="fa fa-circle-notch"></i> Refresh</a>
                            </div>
                        </div>
                        <div class="body-kartu">
                        <?php
                            $getdetailresi = $this->db->select('sum(ctns) as total_ctns,sum(qty*ctns) as total_qty,sum(berat*ctns) as total_berat,sum(volume*ctns) as total_volume')
                                                    ->where('resi_id',$r->id_resi)->get('giw')->row();

                            if(substr($r->nomorgiw,3,1) == 'Y'){ $gudang = "Yiwu"; }
                            else{  $gudang = "Guangzhou"; }

                            if($r->konfirmasi_resi == 0){ $kf = "<span class='badge badge-belum badge-pill'>Belum Terkonfirmasi1</span>"; }
                            else if($r->konfirmasi_resi == 1){  $kf = "<span class='badge badge-dikonfirmasi badge-pill'>Terkonfirmasi</span>"; }
                            else if($r->konfirmasi_resi == 2){  $kf = "<span class='badge badge-asuransi badge-pill'>Terkonfirmasi</span>"; }
                        ?>

                            <table class="table table-borderless table-striped table-detail">
                                <tbody>
                                <tr>
                                <th class="w-25">Kode Mark Customer</th>
                                <td><?php echo $r->kodecustomer; ?></td>
                                </tr>
                                <tr>
                                <th class="w-25">Nomor Resi</th>
                                <td><?php echo $r->nomor_resi; ?></td>
                                <tr>
                                <tr>
                                <th class="w-25">Tanggal</th>
                                <td><?php echo $r->tanggal_resi; ?></td>
                                </tr>
                                <tr>
                                <th class="w-25">Whatsapp</th>
                                <td><?php echo $r->whatsapp ?></td>
                                </tr>
                                </tbody>
                                </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- detail -->
            <div class="row kolom-row">
                <div class="col-12">
                    <div class="kartu">
                        <div class="head-kartu">
                            <div class="kiri">
                                <h3><i class="fa fa-barcode"></i> Detail</h3>
                            </div>
                            <div class="kanan">
                                <!-- <a href="#"><i class="fa fa-circle-notch"></i> Refresh</a> -->
                            </div>
                        </div>
                        <div class="body-kartu">
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
                                    <?php if($r->berat < 5){
                                        $berat = 5;
                                    }else{
                                        $berat = $r->berat;
                                    }
                                    echo $berat; ?> kg
                                    </td>
                                    <td class="tdcenter"><font color="black">
                                    <?php echo "Rp ". number_format($r->harga_jual); ?>
                                    </td>
                                    <td class="tdcenter"><font color="black">
                                    <?php echo "Rp ". number_format($r->harga_jual * $r->berat); ?>
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
            <!-- invoice -->
            <div class="row kolom-row">
                <div class="col-12">
                    <div class="kartu">
                        <div class="head-kartu">
                            <div class="kiri">
                                <h3><i class="fa fa-barcode"></i> Invoice</h3>
                            </div>
                            <div class="kanan">
                                <!-- <a href="#"><i class="fa fa-circle-notch"></i> Refresh</a> -->
                            </div>
                        </div>
                        <div class="body-kartu">
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
            <!-- Sub Pembayaran List -->
            <div class="row kolom-row">
                <div class="col-12">
                    <div class="kartu">
                        <div class="head-kartu">
                            <div class="kiri">
                                <h3><i class="fa fa-barcode"></i> Sub Pembayaran List</h3>
                            </div>
                            <div class="kanan">
                                <!-- <a href="#"><i class="fa fa-circle-notch"></i> Refresh</a> -->
                            </div>
                        </div>
                        <div class="body-kartu">
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
            <!-- Potongan -->
            <div class="row kolom-row">
                <div class="col-12">
                    <div class="kartu">
                        <div class="head-kartu">
                            <div class="kiri">
                                <h3><i class="fa fa-barcode"></i> Potongan</h3>
                            </div>
                            <div class="kanan">
                                <!-- <a href="#"><i class="fa fa-circle-notch"></i> Refresh</a> -->
                            </div>
                        </div>
                        <div class="body-kartu">
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

            <div class="row kolom-row">
                <div class="col-6">
                    <a class="hubungi-link" href="#">Hubungi Customer Services</a>
                </div>
            </div>
        </div>
    </section>
    <!--End Main-->

<script>
    function reFresh(){
        location.reload();
    }

</script>
