<head>
   <meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
   <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
</head>
<?php
  $tahun_ini = date('Y');
  $tahun_kmarin = date('Y')-1;
?>
<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4 class="pull-left" class="form-control"><b>Laporan CBM Customer <?php echo $tahun_ini ?></b></h4>
        <span class="pull-right" style="margin-right:1%;">
          <form method="post" action="<?php echo base_url('admin/laporan/sortgiw') ?>">
            <span class="pull-right" style="margin-right:5px;">
              <input type="submit" name="max" class="form-control btn btn-info" value="Filter Date" placeholder="Max Date"/>
            </span>
            <span class="pull-right" style="margin-right:5px;">
              <select class="form-control" name="tahun">
                <option>2019</option>
                <option>2020</option>
              </select>
            </span>
          </form>
        </span>
      </form>
    </div>
  </div>
</div>


<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Laporan CBM Customer <?php echo $tahun_ini;  ?></b></h3>
    </div>

    <div class="box-body">
      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped no-margin" id="myresi">
          <thead>
            <tr>
              <th>No.</th>
              <th>Customer</th>
              <?php
              $bulanini  = bulan_angka(date('m'));
              for($i=$bulanini; $i<=12; $i++){ ?>
                <th><?php echo bindo($i)." ".$tahun_kmarin; ?></th>
              <?php } ?>
              <?php
              for($i=1; $i<=$bulanini; $i++){ ?>
                <th><?php echo bindo($i)." ".$tahun_ini; ?></th>
              <?php } ?>

              <th>Total Volume</th>
            </tr>
          </thead>
          <tbody>
          <?php $no=1; foreach($customer as $cust){ ?>
            <tr>
              <td><?php echo $no; ?></td>
              <td><?php echo $cust->kode ?></td>
              <?php $total_percustomer = 0; for($i=$bulanini; $i<=12; $i++){
                $data_giw = $this->db->select('sum(giw.volume * giw.ctns) as cbm')->from('giw')->join('customer','giw.customer_id=customer.id_cust','left')
            													 ->join('resi','giw.resi_id=resi.id_resi','left')
            													 ->where('month(resi.tanggal)',$i)->where('year(resi.tanggal)',$tahun_kmarin)->where('giw.customer_id',$cust->id_cust)
                                       ->where('giw.volume >',0)
                                       ->group_by('customer.id_cust')->get()->row();
                $total_percustomer += $data_giw->cbm;
                ?>
                <?php if ($data_giw->cbm == 0){ ?>
                  <th></th>
                <?php }else{ ?>
                  <th><?php echo round($data_giw->cbm,3) ; ?>m<sup>3</sup></th>
                <?php } ?>
              <?php } ?>

              <?php $total_percustomer = 0; for($i=1; $i<=$bulanini; $i++){
                $data_giw = $this->db->select('sum(giw.volume * giw.ctns) as cbm')->from('giw')->join('customer','giw.customer_id=customer.id_cust','left')
            													 ->join('resi','giw.resi_id=resi.id_resi','left')
            													 ->where('month(resi.tanggal)',$i)->where('year(resi.tanggal)',$tahun_ini)->where('giw.customer_id',$cust->id_cust)
                                       ->where('giw.volume >',0)
                                       ->group_by('customer.id_cust')->get()->row();
                $total_percustomer += $data_giw->cbm;
                ?>
                <?php if ($data_giw->cbm == 0){ ?>
                  <th></th>
                <?php }else{ ?>
                  <th><?php echo round($data_giw->cbm,3) ; ?>m<sup>3</sup></th>
                <?php } ?>
              <?php } ?>
              <th><?php echo round($total_percustomer,3); ?> m<sup>3</sup></th>
            </tr>
          <?php $no++; } ?>
       </tbody>
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
    "pageLength": 1000

  });

});
</script>
