<head>
   <meta charset="utf-8">
   <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>" />
   <link href="<?php echo base_url().'assets/jquery/select2.min.css'?>" rel="stylesheet" />
</head>

    <?php if($this->session->flashdata('msg')=='success'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Customer Added to Our data
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

    <?php }else if($this->session->flashdata('msg')=='updated'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Customer data Updated
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

    <?php } else if($this->session->flashdata('msg')=='notvalid'){ ?>

       <p><div style="display: none;" class="alert alert-danger alert-dismissable"><i class="icon fa fa-check"></i>Kode Mark Tersebut Sudah ada , Silahkan gunakan search untuk melihat data tsb.
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

   <?php } ?>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Daftar Customer Import Sea > 10 Cbm Bulan <?php echo bindo(date('m'));  ?></b></h3>
      <span class="pull-right">
      </span>
    </div>

    <div class="box-body">
    <div class="box-body table-responsive">

    <table class="table table-bordered table-striped no-margin" id="mytable">
      <thead>
        <tr>
          <th>Kode Marking</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Alamat</th>
          <th>Cbm</th>
          <th>Bulan</th>
        </tr>
     </thead>
     <tbody>
       <?php
        foreach ($data_customer as $custom) {
          // code...
       ?>
       <tr>
         <td><?php echo $custom->kode ?></td>
         <td><?php echo $custom->nama ?></td>
         <td><?php echo $custom->email ?></td>
         <td><?php echo $custom->alamat ?></td>
         <td><?php echo round($custom->cbm,3) ?> m<sup>3</sup></td>
         <td><?php echo bindo($custom->bulan_barang) ?></td>
       </tr>
     <?php } ?>
     </tbody>
    </table>

 </div>
 </div>

  </div>
  </div>


<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/jquery/select2.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>
<script src="<?php echo base_url() ?>assets/jquery/loadingoverlay.min.js"></script>


<script type="text/javascript">
    $(document).ready(function(){setTimeout(function(){$(".alert").fadeIn('fast');}, 100);});
      //angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
      setTimeout(function(){$(".alert").fadeOut('fast');}, 5000);
</script>

<script type="text/javascript">
  function view_image(id)
  {
    console.log(id);
    $.ajax({
      type : "GET",
      url : "<?php echo base_url() ?>admin/customer/view_image/"+id,
      cache : false,
      async : false,
      success : function(html){
        $("#view_image").html(html).show();
        $('#modvm').modal('show');
      }
    })
  }
</script>

<script type="text/javascript">
  function edit_customer(id)
  {
    console.log(id);
    $.ajax({
      type : "GET",
      url : "<?php echo base_url() ?>admin/customer/edit_customer/"+id,
      cache : false,
      async : false,
      success : function(html){
        $("#edit_customer").html(html).show();
        $('#ModalUpdate').modal('show');
      }
    })
  }
</script>

<script type="text/javascript">
  function akun_customer(id)
  {
    console.log(id);
    $.ajax({
      type : "GET",
      url : "<?php echo base_url() ?>admin/customer/akun_customer/"+id,
      cache : false,
      async : false,
      success : function(html){
        $("#akun_customer").html(html).show();
        $('#ModalAkun').modal('show');
      }
    })
  }
</script>
