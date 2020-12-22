<head><meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link href="<?php echo base_url().'assets/ignited/css/dataTables.bootstrap.css'?>" rel="stylesheet" type="text/css"/>
</head>

<?php if($this->session->flashdata('msg')=='okcancel'){ ?>

<p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Asuransi Berhasil diCancel
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
</div></p>

<?php } ?>

<?php if($this->session->flashdata('msg')=='okeupdate'){ ?>

<p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Edit Barcode Berhasil
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
</div></p>

<?php } ?>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Resi</b></h3>
      <span class="pull-right">
        <?php if($r->konfirmasi_resi == 2){ ?>
          <button type="button" class="btn bg-navy" data-toggle="modal" data-target="#myModalcancel" name="button">Cancel Asuransi</button>
        <?php } ?>
      </span>
    </div>

    <div class="box-body">
    <div class="box-body table-responsive">

      <?php

      $getdetailresi = $this->db->select('sum(ctns) as total_ctns,sum(qty*ctns) as total_qty,sum(berat*ctns) as total_berat,
                                          sum(volume*ctns) as total_volume,sum(nilai*qty*ctns) as total_nilai')
                                ->where('resi_id',$r->id_resi)->get('giw')->row();

       if($r->gudang == 1){ $gudang = "Gudang 1"; }
       else if($r->gudang == 2){  $gudang = "Gudang 2"; }

       if($r->konfirmasi_resi == 0){ $kf = "Belum Terkonfirmasi1"; }
       else if($r->konfirmasi_resi == 1){  $kf = "Terkonfirmasi"; }
       else if($r->konfirmasi_resi == 2){  $kf = "Terkonfirmasi"; }

       $getinvsj = $this->db->select('invoice_product.posisi_indo,posisi_indo.tempat,invoice.kode_invoice,sj_wc.kode_sj,surat_jalan.no_sj,
                                      invoice_product.id_invoice,sj_wc.id_sj
                                    ')
                                     ->from('invoice_product')
                                     ->join('posisi_indo', 'invoice_product.posisi_indo=posisi_indo.id_posisi_indo','left')
                                     ->join('giw', 'invoice_product.id_giw=giw.id','left')
                                     ->join('invoice', 'invoice_product.id_invoice=invoice.id_invoice','left')
                                     ->join('sj_wc', 'invoice_product.id_sj_wc=sj_wc.id_sj','left')
                                     ->join('surat_jalan', 'invoice_product.id_sj=surat_jalan.id_surat_jalan','left')
                                     ->join('customer', 'customer.id_cust=giw.customer_id','left')
                                     ->join('resi', 'giw.resi_id=resi.id_resi','left')
                                     ->where('giw.resi_id',$r->id_resi)
                                     ->group_by('resi.id_resi')
                                     ->order_by('container_generate','desc')
                                     ->order_by('customer.kode','desc')
                                     ->get()->result();

       $getcontainernya = $this->db->select('container.kode,container.id_rts')
                                ->from('giw')
                                ->join('container', 'giw.container_id=container.id_rts','left')
                                ->where('resi_id',$r->id_resi)
                                ->group_by('giw.container_id')
                                ->get()->result();
       ?>

    <table class="table table-striped no-margin" id="myresia">
      <thead>
        <tr>
          <td>Kode Mark Customer</td>
          <td><?php echo $r->kode ?></td>
        </tr>
        <tr>
          <td>Nomor Resi</td>
          <td><?php echo $r->nomor ?></td>
        <tr>
        <tr>
          <td>Tanggal</td>
          <td><?php echo $r->tanggal ?></td>
        </tr>
        <tr>
          <td>Invoice</td>
          <td><?php foreach ($getinvsj as $gisj){
            echo "<a target='_blank' href='".base_url('admin/invoice_barang/detail/'.$gisj->id_invoice)."'>".$gisj->kode_invoice."</a>,";
          } ?></td>
        </tr>
        <tr>
          <td>Surat Jalan</td>
          <td><?php foreach ($getinvsj as $gisj2){
            if($gisj2->id_invoice > 0 && $gisj2->posisi_indo == 0){
              echo $gisj2->no_sj;
            }else{
              echo "<a target='_blank' href='".base_url('admin/mobilsj/detail_sj/'.$gisj->id_sj)."'>".$gisj->kode_sj."</a>,";
            }
          } ?></td>
        </tr>
        <tr>
          <td>Container</td>
          <td><?php foreach ($getcontainernya as $gcn){
            echo "<a target='_blank' href='".base_url('admin/container/detail/'.$gcn->id_rts)."'>".$gcn->kode."</a>,";
          } ?></td>
        </tr>
        <tr>
          <td>Tel</td>
          <td><?php echo $r->tel ?></td>
        </tr>
        <tr>
          <td>Whatsapp</td>
          <td><?php echo $r->whatsapp ?></td>
        </tr>
        <tr>
          <td>Note</td>
          <td><?php echo $r->note ?></td>
        </tr>
        <tr>
          <td>Gudang</td>
          <td><?php echo $gudang ?></td>
        </tr>
        <tr>
          <td>Status</td>
          <td><?php echo $kf ?></td>
        </tr>
        <?php if($r->konfirmasi_resi == 2){
          $getasuransi = $this->db->where('id_resi',$r->id_resi)->get('invoice_asuransi')->row();
        ?>
          <tr>
            <td>Asuransi</td>
            <td><?php echo "Rp." . number_format($getasuransi->jumlah_asuransi) ?></td>
          </tr>
        <?php  } ?>
      </thead>

    </table>
   </div>

    </div>
    </div>
    </div>


<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b> Barcode Resi </b></h3>

    </div>

    <div class="box-body">

    <div class="box-body table-responsive">

    <table class="table no-margin" id="mybarcode">
      <thead>
        <tr>
          <th>Barcode </th>
          <th>Barang</th>
          <th>Kategori</th>
          <th>Ctns</th>
          <th>Qty</th>
          <th>Berat</th>
          <th>Volume</th>
          <th>Nilai</th>
          <th>Note</th>
          <th>Status</th>
          <th>Remarks</th>
          <th>Harga</th>
          <th>Jalur</th>
          <th>Est</th>
          <th>Action</th>
        </tr>
      </thead>
    </table>

    <table class="table table-bordered table-striped no-margin" id="">
      <thead>
        <tr>
          <td rowspan="2" style="font-weight:bold;">Total Ctns </td>
          <td style="font-weight:bold;"><?php echo $getdetailresi->total_ctns ?> ctns</td>
          <td rowspan="2" style="font-weight:bold;">Total Qty </td>
          <td style="font-weight:bold;"><?php echo $getdetailresi->total_qty ?> pcs</td>
          <td rowspan="2" style="font-weight:bold;">Total Berat </td>
          <td style="font-weight:bold;"><?php echo round($getdetailresi->total_berat,3) ?> kg</td>
          <td rowspan="2" style="font-weight:bold;">Total Volume </td>
          <td style="font-weight:bold;"><?php echo round($getdetailresi->total_volume,3) ?> m<sup>3</sup></td>
          <td rowspan="2" style="font-weight:bold;">Total Rmb </td>
          <td style="font-weight:bold;"><?php echo round($getdetailresi->total_nilai,3) ?> m<sup>3</sup></td>
        </tr>
      </thead>
    </table>
   </div>
    </div>
    </div>
    </div>

<div class="row">
  <div class="box box-primary">
    <section class="content">
      <!-- row -->
      <div class="row">
        <div class="col-md-12">
          <!-- The time line -->
          <ul class="timeline">
            <!-- timeline time label -->
            <li class="time-label">
                  <span class="bg-green">
                    Kode Resi : <?php echo $r->nomor ?>
                  </span>
            </li>
            <!-- /.timeline-label -->
            <!-- timeline item -->
            <?php if(!empty($s[0])){ ?>
            <?php foreach($s as $sr) { ?>
            <li>
              <i class="fa <?=$sr->icon;?> bg-<?=$sr->warna;?>"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> &nbsp;<?=$sr->tanggal;?></span>

                <h3 class="timeline-header"><a href="#"><?=$sr->nama;?></a></h3>

                <div class="timeline-body">
                  <?=$sr->keterangan;?>
                  (Batas Est <?=$sr->jumlahhari;?> Hari: <span class="time"><i class="fa fa-clock-o"></i> &nbsp;<?=date('Y-m-d', strtotime($sr->tanggal. ' + '.$sr->jumlahhari.' days'));?></span>)
                </div>
              </div>
            </li>
            <?php } ?>
            <?php }else{ ?>
                <li>
                  <i class="fa fa-calendar-check-o bg-blue"></i>

                  <div class="timeline-item">
                    <h3 class="timeline-header"><a href="#">Tidak Ada Status</a></h3>
                  </div>
                </li>
            <?php } ?>

            <!-- END timeline item -->
            <li>
              <i class="fa fa-clock-o bg-gray"></i>
            </li>
          </ul>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
  </div>
</div>
<!--row status-->
<?php if($hr->containerid <='999'){?>
<?php foreach($h as $hr) { ?>
<div class="row">
  <div class="box box-primary">
    <section class="content">
      <!-- row -->
      <div class="row">
        <div class="col-md-12">
          <!-- The time line -->
          <ul class="timeline">
            <!-- timeline time label -->
            <li class="time-label">
                <?php
                        $barcodenya=array();
                        $barcodenya=$this->db->select('nomor')->from('giw')->where('container_id', $hr->containerid)->where('resi_id', $d->id_resi_rts)->get()->result();
                ?>
                  <span class="bg-red">
                    Kode Barcode : &nbsp;<?php if(!empty($barcodenya[0])) foreach($barcodenya as $bc){ ?><?=$bc->nomor;?>,<? }else{ ?>All<?php } ?>
                  </span>
            </li>
            <!-- /.timeline-label -->
            <!-- timeline item -->
            <?php if($hr->statusfix >= '1'){ ?>
            <li>
                <?php
                        $urutan1=array();
                        $urutan1=$this->db->select('hari')->from('status_giw')->where('urutan', 1)->get()->row();
                ?>
              <i class="fa fa-ship bg-blue"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> &nbsp;<?=$hr->tanggal;?></span>

                <h3 class="timeline-header"><a href="#">Tiba Gudang China</a></h3>

                <div class="timeline-body">
                  Barang sudah diterima di warehouse china
                  (Est <?=$urutan1->hari;?> Hari: <span class="time"><i class="fa fa-clock-o"></i> &nbsp;<?=date('Y-m-d', strtotime($hr->tanggal. ' + '.$urutan1->hari.' days'));?></span>)
                </div>
                <!--<div class="timeline-footer">-->
                <!--  <a class="btn btn-primary btn-xs">Read more</a>-->
                <!--  <a class="btn btn-danger btn-xs">Delete</a>-->
                <!--</div>-->
              </div>
            </li>
            <?php } ?>
            <?php if($hr->statusfix >= '2'){ ?>
            <li>
                <?php
                        $urutan2=array();
                        $urutan2=$this->db->select('hari')->from('status_giw')->where('urutan', 2)->get()->row();
                ?>
              <i class="fa fa-ship bg-yellow"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> &nbsp;<?=$hr->tanggal_loading;?></span>

                <h3 class="timeline-header"><a href="#">Loading Container di Gudang China</a></h3>

                <div class="timeline-body">
                  Barang Sedang dimuat kedalam Container di China.
                  (Est <?=$urutan2->hari;?> Hari: <span class="time"><i class="fa fa-clock-o"></i> &nbsp;<?=date('Y-m-d', strtotime($hr->tanggal_loading. ' + '.$urutan2->hari.' days'));?></span>)
                </div>
              </div>
            </li>
            <?php } ?>
            <?php if($hr->statusfix >= '3' and !empty($hr->tgl_closing)){ ?>
                <?php
                        $urutan3=array();
                        $urutan3=$this->db->select('hari')->from('status_giw')->where('urutan', 3)->get()->row();
                ?>
            <li>
              <i class="fa fa-ship bg-green"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> &nbsp;<?=$hr->tgl_closing;?></span>

                <h3 class="timeline-header"><a href="#">Closing Container di Gudang China</a></h3>

                <div class="timeline-body">
                  Barang Akan Segera dikirimkan di pelabuhan.
                  (Est <?=$urutan3->hari;?> Hari: <span class="time"><i class="fa fa-clock-o"></i> &nbsp;<?=date('Y-m-d', strtotime($hr->tgl_closing. ' + '.$urutan3->hari.' days'));?></span>)
                </div>
              </div>
            </li>
            <?php } ?>
            <?php if($hr->statusfix >= '4'){ ?>
                <?php
                        $urutan4=array();
                        $urutan4=$this->db->select('hari')->from('status_giw')->where('urutan', 4)->get()->row();
                ?>
            <li>
              <i class="fa fa-ship bg-blue"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> &nbsp;<?=$hr->tanggal_berangkat;?></span>

                <h3 class="timeline-header"><a href="#">Container OTW</a></h3>

                <div class="timeline-body">
                  Barang dalam pengiriman ke warhouse di jakarta.
                  (Est <?=$urutan4->hari;?> Hari: <span class="time"><i class="fa fa-clock-o"></i> &nbsp;<?=date('Y-m-d', strtotime($hr->tanggal_berangkat. ' + '.$urutan4->hari.' days'));?></span>)
                </div>
              </div>
            </li>
            <?php } ?>
            <?php if($hr->statusfix >= '5' and !empty($hr->tgl_eta)){ ?>
                <?php
                        $urutan5=array();
                        $urutan5=$this->db->select('hari')->from('status_giw')->where('urutan', 5)->get()->row();
                ?>
            <li>
              <i class="fa fa-ship bg-red"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> &nbsp;<?=$hr->tgl_eta;?></span>

                <h3 class="timeline-header"><a href="#">Container ETA</a></h3>

                <div class="timeline-body">
                 (Est <?=$urutan5->hari;?> Hari: <span class="time"><i class="fa fa-clock-o"></i> &nbsp;<?=date('Y-m-d', strtotime($hr->tgl_eta. ' + '.$urutan5->hari.' days'));?></span>)
                </div>
              </div>
            </li>
            <?php } ?>
            <?php if($hr->statusfix >= '6' and !empty($dataresi->tgl_antri_kapal)){ ?>
                <?php
                        $urutan6=array();
                        $urutan6=$this->db->select('hari')->from('status_giw')->where('urutan', 6)->get()->row();
                ?>
            <li>
              <i class="fa fa-ship bg-orange"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> &nbsp;<?=$hr->tgl_antri_kapal;?></span>

                <h3 class="timeline-header"><a href="#">Container Antri Kapal</a></h3>

                <div class="timeline-body">
                 (Est <?=$urutan6->hari;?> Hari: <span class="time"><i class="fa fa-clock-o"></i> &nbsp;<?=date('Y-m-d', strtotime($hr->tgl_antri_kapal. ' + '.$urutan6->hari.' days'));?></span>)
                </div>
              </div>
            </li>
            <?php } ?>
            <?php if($hr->statusfix >= '7' and !empty($hr->tgl_atur_kapal)){ ?>
                <?php
                        $urutan7=array();
                        $urutan7=$this->db->select('hari')->from('status_giw')->where('urutan', 7)->get()->row();
                ?>
            <li>
              <i class="fa fa-ship bg-yellow"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> &nbsp;<?=$hr->tgl_atur_kapal;?></span>

                <h3 class="timeline-header"><a href="#">Container Atur Kapal</a></h3>

                <div class="timeline-body">
                 (Est <?=$urutan7->hari;?> Hari: <span class="time"><i class="fa fa-clock-o"></i> &nbsp;<?=date('Y-m-d', strtotime($hr->tgl_atur_kapal. ' + '.$urutan7->hari.' days'));?></span>)
                </div>
              </div>
            </li>
            <?php } ?>
            <?php if($hr->statusfix >= '8' and !empty($hr->tgl_est_dumai)){ ?>
                <?php
                        $urutan8=array();
                        $urutan8=$this->db->select('hari')->from('status_giw')->where('urutan', 8)->get()->row();
                ?>
            <li>
              <i class="fa fa-ship bg-blue"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> &nbsp;<?=$hr->tgl_est_dumai;?></span>

                <h3 class="timeline-header"><a href="#">Container Estimasi Dumai</a></h3>

                <div class="timeline-body">
                 (Est <?=$urutan8->hari;?> Hari: <span class="time"><i class="fa fa-clock-o"></i> &nbsp;<?=date('Y-m-d', strtotime($hr->tgl_est_dumai. ' + '.$urutan8->hari.' days'));?></span>)
                </div>
              </div>
            </li>
            <?php } ?>
            <?php if($hr->statusfix >= '9' and !empty($hr->tgl_pib)){ ?>
                <?php
                        $urutan9=array();
                        $urutan9=$this->db->select('hari')->from('status_giw')->where('urutan', 9)->get()->row();
                ?>
            <li>
              <i class="fa fa-ship bg-blue"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> &nbsp;<?=$hr->tgl_pib;?></span>

                <h3 class="timeline-header"><a href="#">Container PIB</a></h3>

                <div class="timeline-body">
                 (Est <?=$urutan9->hari;?> Hari: <span class="time"><i class="fa fa-clock-o"></i> &nbsp;<?=date('Y-m-d', strtotime($hr->tgl_pib. ' + '.$urutan9->hari.' days'));?></span>)
                </div>
              </div>
            </li>
            <?php } ?>
            <?php if($hr->statusfix >= '10' and !empty($hr->tgl_notul)){ ?>
                <?php
                        $urutan10=array();
                        $urutan10=$this->db->select('hari')->from('status_giw')->where('urutan', 10)->get()->row();
                ?>
            <li>
              <i class="fa fa-ship bg-blue"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> &nbsp;<?=$hr->tgl_notul;?></span>

                <h3 class="timeline-header"><a href="#">Container Notul</a></h3>

                <div class="timeline-body">
                 (Est <?=$urutan10->hari;?> Hari: <span class="time"><i class="fa fa-clock-o"></i> &nbsp;<?=date('Y-m-d', strtotime($hr->tgl_notul. ' + '.$urutan10->hari.' days'));?></span>)
                </div>
              </div>
            </li>
            <?php } ?>
            <?php if($hr->statusfix >= '11' and !empty($hr->tanggal_monitoring)){ ?>
                <?php
                        $urutan11=array();
                        $urutan11=$this->db->select('hari')->from('status_giw')->where('urutan', 11)->get()->row();
                ?>
            <li>
              <i class="fa fa-ship bg-blue"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> &nbsp;<?=$hr->tanggal_monitoring;?></span>

                <h3 class="timeline-header"><a href="#">Container Monitoring</a></h3>

                <div class="timeline-body">
                    Barang sudah Sudah Bisa di Monitoring
                    (Est <?=$urutan11->hari;?> Hari: <span class="time"><i class="fa fa-clock-o"></i> &nbsp;<?=date('Y-m-d', strtotime($hr->tanggal_monitoring. ' + '.$urutan11->hari.' days'));?></span>)
                </div>
              </div>
            </li>
            <?php } ?>
            <?php if($hr->statusfix >= '12' and !empty($hr->tanggal_tiba)){ ?>
                <?php
                        $urutan12=array();
                        $urutan12=$this->db->select('hari')->from('status_giw')->where('urutan', 12)->get()->row();
                ?>
            <li>
              <i class="fa fa-ship bg-blue"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> &nbsp;<?=$hr->tanggal_tiba;?></span>

                <h3 class="timeline-header"><a href="#">Tiba di Warehouse Jakarta</a></h3>

                <div class="timeline-body">
                    Barang sudah diterima di warehouse jakarta
                    (Est <?=$urutan12->hari;?> Hari: <span class="time"><i class="fa fa-clock-o"></i> &nbsp;<?=date('Y-m-d', strtotime($hr->tanggal_tiba. ' + '.$urutan12->hari.' days'));?></span>)
                </div>
              </div>
            </li>
            <?php } ?>
            <!-- END timeline item -->
            <li>
              <i class="fa fa-clock-o bg-gray"></i>
            </li>
          </ul>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
  </div>
</div>
<?php } ?>
<?php } ?>

<?php foreach($detailcontainer as $srr) { ?>
<?php if($srr->container_id > '999'){?>
<div class="row">
  <div class="box box-primary">
    <section class="content">
      <!-- row -->
      <div class="row">
        <div class="col-md-12">
          <!-- The time line -->
          <ul class="timeline">
            <!-- timeline time label -->
            <li class="time-label">
                <?php
                        $barcodenya2=array();
                        $barcodenya2=$this->db->select('nomor')->from('giw')->where('container_id', $srr->container_id)->where('resi_id', $d->id_resi_rts)->get()->result();
                ?>
                  <span class="bg-red">
                    Kode Barcode : &nbsp;<?php if(!empty($barcodenya2[0])) foreach($barcodenya2 as $bc2){ ?><?=$bc2->nomor;?>,<? }else{ ?>All<?php } ?>
                  </span>
            </li>
            <!-- /.timeline-label -->
            <!-- timeline item -->
            <?php
                $historycont=array();
                $historycont=$this->db->select('history_date_container.tanggal,status_giw.*,history_date_container.hari as jumlahhari')->from('history_date_container')->join('status_giw', 'history_date_container.status_giw_id=status_giw.id')->where('history_date_container.container_id', $srr->container_id)->order_by('history_date_container.tanggal','asc')->order_by('history_date_container.id','asc')->get()->result();
            ?>
            <?php if(!empty($historycont[0])){ ?>
            <?php foreach($historycont as $shr) { ?>
                <?php if($shr->tanggal >= date('Y-m-d')){?>
                <li>
                  <i class="fa <?=$shr->icon;?> bg-<?=$shr->warna;?>"></i>

                  <div class="timeline-item">
                    <span class="time"><i class="fa fa-clock-o"></i> &nbsp;<?=$shr->tanggal;?></span>

                    <h3 class="timeline-header"><a href="#"><?=$shr->nama;?></a></h3>

                    <div class="timeline-body">
                      <?=$shr->keterangan;?>
                      (Batas Est <?=$shr->jumlahhari;?> Hari: <span class="time"><i class="fa fa-clock-o"></i> &nbsp;<?=date('Y-m-d', strtotime($shr->tanggal. ' + '.$shr->jumlahhari.' days'));?></span>)
                    </div>
                  </div>
                </li>
                <?php } ?>
            <?php } ?>
            <?php }else{ ?>
                <li>
                  <i class="fa fa-calendar-check-o bg-blue"></i>

                  <div class="timeline-item">
                    <h3 class="timeline-header"><a href="#">Tidak Ada Status</a></h3>
                  </div>
                </li>
            <?php } ?>

            <!-- END timeline item -->
            <li>
              <i class="fa fa-clock-o bg-gray"></i>
            </li>
          </ul>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
  </div>
</div>
<?php } ?>
<?php } ?>
<!-- akhir row status-->
    <br/><br/><br/><br/>

    <!-- Modal Add Invoice -->
    <form id="add-row-form" action="<?php echo base_url().'admin/resi/cancel_asuransi'?>" method="post" enctype="multipart/form-data">
       <div class="modal fade" id="myModalcancel" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Cancel Asuransi</h4>
                 </div>
                 <div class="modal-body">
                   <label>Apakah Anda Yakin Mengcancel Asuransi?</label>
                     <input type="hidden" name="id_resi" value="<?php echo $r->id_resi ?>" ?>
                 </div>
                 <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" id="add-row" class="btn btn-primary">Save</button>
                 </div>
              </div>
          </div>
       </div>
    </form>

    <div id="edit_barcode"></div>

<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>
<script type="text/javascript">
        $(document).ready(function(){setTimeout(function(){$(".alert").fadeIn('fast');}, 100);});
          //angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
          setTimeout(function(){$(".alert").fadeOut('fast');}, 5000);
</script>
<script>//Bc
  $(document).ready(function(){
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



      var table = $("#mybarcode").dataTable({
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
              ajax: {"url": "<?php echo base_url()?>admin/resi/get_barcodeid_json/<?php echo $this->uri->segment(4) ?>", "type": "POST"},
                  columns: [

                       {"data": "nomor"},
                        {"data": "barang"},
                        {"data": "namalain"},
                        {"data": "ctns"},
                        {"data": "qtys"},
                        {"data": "berats"},
                        {"data": "volumes"},
                        {"data": "nilais"},
                        {"data": "note"},
                        {"data": "status" ,
                          render : function(data,type,row){
                            var strStatus = "";
                            if(row.status == 1 ){
                              strStatus = "Gudang China";
                            }else if(row.status == 2){
                              strStatus = "Loading Container";
                            }else if(row.status == 3){
                              strStatus = "Dalam Perjalanan";
                            }else if(row.status == 4){
                              strStatus = "Gudang Jakarta";
                            }else if(row.status == 7){
                              strStatus = "Monitoring";
                            }else if(row.status == 5){
                              strStatus = "Invoice";
                            }
                            return strStatus ;
                          }
                        },
                        {"data": "remarks"},
                        {"data": "harga_jual", render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                        {"data": "jalur" ,
                          render : function(data,type,row){
                            var strStatus = "";
                            if(row.jalur != 1 ){
                              strStatus = "Cepat";
                            }else if(row.jalur == 1){
                              strStatus = "Lambat";
                            }
                            return strStatus ;
                          }
                        },
                        {"data": "est"},
                        {"data": "view"},

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
<script type="text/javascript">
  function edit_barcode(id)
  {
    console.log(id);
    $.ajax({
      type : "GET",
      url : "<?php echo base_url() ?>admin/resi/edit_barcode/"+id,
      cache : false,
      async : false,
      success : function(html){
        $("#edit_barcode").html(html).show();
        $('#modeditbar').modal('show');
      }
    })
  }
</script>
