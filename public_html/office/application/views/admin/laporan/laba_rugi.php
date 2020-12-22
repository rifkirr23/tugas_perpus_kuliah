<head>
   <meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
   <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
</head>

<style media="screen">
hr.onepixel {
  border-top: 1px solid black;
  border-bottom: 1px solid black;
  height: 0px;
  width: 50%;
  margin-right: 500%;
  text-align: left;
}
</style>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4 class="pull-left" class="form-control"><b>Laporan Laba Rugi <?php echo $tanggal_now ?></b></h4>
      <!-- <h4 class="pull-left" class="form-control"><b>Total CBM <?php echo $tanggal_now ." : ". round($total_cbm,3) ?>m<sup>3</sup></b></h4> -->
      <form method="post" action="<?php echo base_url('admin/laporan/laba_rugifilter') ?>">
        <span class="pull-right" style="margin-right:5px;">
          <input type="submit" name="max" class="form-control btn btn-success" value="Filter Date" placeholder="Max Date"/>
        </span>
        <span class="pull-right" style="margin-right:5px;">
          <input type="date" name="sampai_tanggal" class="form-control" value="<?php echo date("Y-m-d") ?>" placeholder="Max Date"/>
        </span>
        <span class="pull-right" style="margin-right:5px;">
          <input type="date" name="dari_tanggal" class="form-control" value="<?php echo date("Y-m-d") ?>" placeholder="Min Date"/>
        </span>
      </form>
    </div>
    <div class="box-body">
      <div class="box-body table-responsive">
        <table class="table table-striped no-margin" id="myresia">
          <thead>
            <!-- Keterangan -->
             <tr>
               <td colspan=""><h4><b>Keterangan</b></h4></td>
               <td></td>
               <td><h4><b>Total</b></h4></td>
             </tr>

             <!-- Penjualan  -->

             <tr>
               <td><b>Penjualan</b></td>
               <td></td>
               <td colspan=""><b><?php echo "Rp.".number_format($penjualan->jumlah - $total_potongan->jumlah) ?></b></td>
             </tr>
             <?php foreach ($penjualan_pisah as $pp ){
                  if($pp->tipe_invoice == "tt"){
                    $nama_keterangan_penjualan = "Titip Transfer";
                  }else if($pp->tipe_invoice == "air"){
                    $nama_keterangan_penjualan = "Import Udara";
                  }else if($pp->tipe_invoice == "barang"){
                    $nama_keterangan_penjualan = "Import Laut";
                  }else if($pp->tipe_invoice == "lainnya"){
                    $nama_keterangan_penjualan = "Lainnya";
                  }
                  if($status_filter == 2){
                    $potongan_pertipe = $this->db->select('sum(jumlah_potongan) as jumlah')
                              									 ->from('potongan')->where('tipe_potongan is Null',null,false)
                                                 ->where('tanggal_invoice >=',$daritanggal)
                            										 ->where('tanggal_invoice <=',$sampaitanggal)
                                                 ->where('invoice.tipe_invoice',$pp->tipe_invoice)
                              									 ->join('invoice','invoice.id_invoice=potongan.id_invoice','left')
                                                 ->get()->row();
                  }else if($status_filter == 1){
                    $potongan_pertipe = $this->db->select('sum(jumlah_potongan) as jumlah')
                              									 ->from('potongan')->where('tipe_potongan is Null',null,false)
                                                 ->where('tanggal_invoice',date("Y-m-d"))
                                                 ->where('invoice.tipe_invoice',$pp->tipe_invoice)
                              									 ->join('invoice','invoice.id_invoice=potongan.id_invoice','left')
                                                 ->get()->row();
                  }
              ?>
               <tr>
                 <td colspan=""> &nbsp;&nbsp;&nbsp;&nbsp; - Penjualan <?php echo $nama_keterangan_penjualan; ?></td>
                 <td colspan="">  <?php echo "Rp." . number_format($pp->jumlah - $potongan_pertipe->jumlah) ?></td>
                 <td></td>
               </tr>
             <?php } ?>
             <tr>
               <td colspan="3"><b>&nbsp;</b></td>
             </tr>
            <tr>
              <td><b>Potongan Penjualan</b></td>
              <td></td>
              <td colspan="" style="color:red;"><b><?php echo "Rp." . number_format($total_potongan->jumlah) ?></b></td>
            </tr>
            <?php foreach ($potongan_penjualan as $pot_pen ){ ?>
              <tr>
                <td colspan=""> &nbsp;&nbsp;&nbsp;&nbsp; - <?php echo $pot_pen->kjenis_potongan ?></td>
                <td colspan=""> <?php echo "Rp." . number_format($pot_pen->jumlah) ?></td>
                <td></td>
              </tr>
            <?php } ?>
            <tr>
              <td colspan="2">&nbsp;</td>
              <td></td>
            </tr>

            <tr>
              <td><b>Charge Penjualan</b></td>
              <td></td>
              <td colspan=""><b><?php echo "Rp." . number_format($total_charge->jumlah) ?></b></td>
            </tr>
            <?php foreach ($charge_penjualan as $charge_pen ){ ?>
              <tr>
                <td colspan=""> &nbsp;&nbsp;&nbsp;&nbsp; - <?php echo $charge_pen->kjenis_potongan ?></td>
                <td colspan=""> <?php echo "Rp." . number_format($charge_pen->jumlah) ?></td>
                <td></td>
              </tr>
            <?php } ?>
            <tr>
              <td colspan="2" style="text-align:right;"><b> </b></td>
              <td>  <hr class="onepixel"></td>
            </tr>

            <tr>
              <td><b>Penjualan Bersih</b></td>
              <td><b></b></td>
              <td><b><?php echo "Rp." . number_format($penjualan->jumlah) ?></b></td>
            </tr>
            <tr>
              <td colspan="3"><b>&nbsp;</b></td>
            </tr>

            <!-- Pembelian -->

            <?php $total_modal = ($total_pembelian->jumlah - $potongan_pembelian->jumlah) + $pembelian_rmb10; ?>
            <tr>
              <td colspan="3"><b>Pokok Penjualan</b></td>
            </tr>
            <?php foreach($pembelian as $pembel){
              if($status_filter == 2){
                $potonganbeli_pertipe = $this->db->select('sum(jumlah_potongan) as jumlah')
                                             ->from('potongan')->where('tipe_potongan',"beli")
                                             ->where('tanggal_invoice_beli >=',$daritanggal)
           																	 ->where('tanggal_invoice_beli <=',$sampaitanggal)
                                             ->where('invoice_beli.id_vendor',$pembel->id_vendor)
                                             ->join('invoice_beli','invoice_beli.id_invoice_beli=potongan.id_invoice','left')
                                             ->get()->row();
              }else if($status_filter == 1){
                $potonganbeli_pertipe = $this->db->select('sum(jumlah_potongan) as jumlah')
                                             ->from('potongan')->where('tipe_potongan',"beli")
                                             ->where('tanggal_invoice_beli',date("Y-m-d"))
                                             ->where('invoice_beli.id_vendor',$pembel->id_vendor)
                                             ->join('invoice_beli','invoice_beli.id_invoice_beli=potongan.id_invoice','left')
                                             ->get()->row();
              }
            ?>
              <tr>
                <td> &nbsp;&nbsp;&nbsp;&nbsp; - Pembelian <?php echo $pembel->nama_vendor ?></td>
                <td colspan="2"><?php echo "Rp.".number_format($pembel->jumlah - $potonganbeli_pertipe->jumlah) ?></td>
              </tr>
            <?php } ?>
           <tr>
             <td> &nbsp;&nbsp;&nbsp;&nbsp; - Pembelian Titip Transfer</td>
             <td colspan="2"><?php echo "Rp.".number_format($pembelian_rmb10) ?></td>
           </tr>
           <tr>
             <td> &nbsp;&nbsp;&nbsp;&nbsp; - Potongan / Charge Pembelian</td>
             <td colspan="2"><?php echo "Rp.".number_format($potongan_pembelian->jumlah) ?></td>
           </tr>
           <tr>
             <td colspan="2"><b>Pembelian Bersih</b></td>
             <td colspan="" style="color:red;"><b><?php echo "Rp.-" . number_format($total_modal + $potongan_pembelian->jumlah) ?></b></td>
           </tr>
           <tr>
             <td colspan="2" style="text-align:right;"><b> </b></td>
             <td> <hr class="onepixel"></td>
           </tr>
           <tr>
             <td colspan=""><b>Total Laba Kotor </b></td>
             <td></td>
             <td colspan=""><b><?php echo "Rp." . number_format($penjualan->jumlah - ($total_modal + $potongan_pembelian->jumlah)) ?></b></td>
           </tr>
           <tr>
             <td colspan="3"><b>&nbsp;</b></td>
           </tr>
           <tr>
             <td colspan="2"><b>Total Beban Usaha</b></td>
             <td style="color:red;"><b><?php echo "Rp.-" . number_format($total_pengeluaran->jumlah) ?></b></td>
           </tr>
           <?php foreach ($pengeluaran as $exp ){ ?>
             <tr>
               <td colspan=""><b><?php echo $exp->nama_parent ?></b></td>
               <td colspan=""><b><?php echo "Rp." . number_format($exp->jumlah) ?></b></td>
               <td></td>
             </tr>
             <?php
             if($status_filter == 2){
               $pengeluaran_per_jenis = $this->db->select('sum(nominal_transaksi_bank) as jumlah,jenis_transaksi_bank.kjenis_transaksi_bank')
           																		->from('transaksi_bank')
           																		->join('jenis_transaksi_bank','transaksi_bank.id_jenis_transaksi_bank=jenis_transaksi_bank.id_jenis_transaksi_bank','left')->join('parent_jenis_transaksi','parent_jenis_transaksi.id_parent=jenis_transaksi_bank.id_parent','left')
           																		->where('jenis_transaksi_bank.id_jenis_transaksi_utama',1)
                                              ->where('tanggal_transaksi_bank >=',$daritanggal)
                                 		   				->where('tanggal_transaksi_bank <=',$sampaitanggal)
           																		->where('tipe_transaksi_bank',"keluar")
                                               ->where('jenis_transaksi_bank.id_parent',$exp->id_parent)
           																		->group_by('jenis_transaksi_bank.id_jenis_transaksi_bank')
           																		->get()->result();
             }else if($status_filter == 1){
               $pengeluaran_per_jenis = $this->db->select('sum(nominal_transaksi_bank) as jumlah,jenis_transaksi_bank.kjenis_transaksi_bank')
           																		->from('transaksi_bank')
           																		->join('jenis_transaksi_bank','transaksi_bank.id_jenis_transaksi_bank=jenis_transaksi_bank.id_jenis_transaksi_bank','left')->join('parent_jenis_transaksi','parent_jenis_transaksi.id_parent=jenis_transaksi_bank.id_parent','left')
           																		->where('jenis_transaksi_bank.id_jenis_transaksi_utama',1)
                                               ->where('tanggal_transaksi_bank',date("Y-m-d"))
           																		->where('tipe_transaksi_bank',"keluar")
                                               ->where('jenis_transaksi_bank.id_parent',$exp->id_parent)
           																		->group_by('jenis_transaksi_bank.id_jenis_transaksi_bank')
           																		->get()->result();
             }
              foreach ($pengeluaran_per_jenis as $sub_pengeluaran){ ?>
                <tr>
                  <td colspan="">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $sub_pengeluaran->kjenis_transaksi_bank ?></td>
                  <td colspan=""><?php echo "Rp." . number_format($sub_pengeluaran->jumlah) ?></td>
                  <td></td>
                </tr>
              <?php } ?>
          <?php } ?>
          <?php $total_laba_bersih = (($penjualan->jumlah - ($total_modal + $potongan_pembelian->jumlah)) - $total_pengeluaran->jumlah) ; ?>
           <tr>
             <td colspan="3"><b>&nbsp;</b></td>
           </tr>
           <tr>
             <td colspan="2" style="text-align:right;"><b> </b></td>
             <td> <hr class="onepixel"></td>
           </tr>
           <tr>
             <td colspan="2" style="height:50px;"><h4><b>Total Laba <?php if($total_laba_bersih < 0){ echo "( Rugi )"; } ?> Bersih</h4></b></td>
             <td colspan=""><h4 <?php if($total_laba_bersih < 0){ ?> style="color:red;" <? } ?>><b><?php echo "Rp." . number_format($total_laba_bersih) ?></h4></b></td>
           </tr>
           <tr>
             <td colspan="3"><b>&nbsp;</b></td>
           </tr>
           <tr>
             <td colspan="2"><b>Total Dividen</b></td>
             <td style="color:red;"><b><?php echo "Rp.-" . number_format($total_dividen->jumlah) ?></b></td>
           </tr>
           <tr>
             <td colspan="3"><b>&nbsp;</b></td>
           </tr>
           <?php $total_laba = (($penjualan->jumlah - ($total_modal + $potongan_pembelian->jumlah)) - $total_pengeluaran->jumlah) - $total_dividen->jumlah ; ?>
           <tr>
             <td colspan="2" style="height:50px;"><h4><b>Total Laba <?php if($total_laba < 0){ echo "( Rugi )"; } ?> Ditahan</h4></b></td>
             <td colspan=""><h4 <?php if($total_laba < 0){ ?> style="color:red;" <? } ?>><b><?php echo "Rp." . number_format($total_laba) ?></h4></b></td>
           </tr>

          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
