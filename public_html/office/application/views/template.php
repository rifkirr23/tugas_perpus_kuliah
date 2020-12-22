<!DOCTYPE html>
<html>
<head><meta charset="euc-kr">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Office| Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <link rel="stylesheet" href="<?php echo base_url() ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>

    <!-- Icon -->
 <link rel="shortcut icon" href="<?php echo base_url('assets/logo2.jpg'); ?>">
 <link rel="stylesheet" href="<?php echo base_url().'assets/bootstrap.min.css'?>?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!-- ADD THE CLASS sidebar-collapse TO HIDE THE SIDEBAR PRIOR TO LOADING THE SITE -->
<body class="hold-transition skin-blue sidebar-mini">
  <!-- Kalo Collapse tambah class -> sidebar-collapse di body class-->
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo site_url() ?>dashboard" class="logo" style="background-color:#1A2226;">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>WC</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>WC OFFICE </b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" style="background-color:rgb(9, 128, 188);">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu" >
        <ul class="nav navbar-nav">
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning"></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 10 notifications </li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                      page and may cause design problems
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo base_url(); ?>assets/nophoto.png" class="user-image" alt="User Image">
              <span class="hidden-xs">Hi <?php echo $this->session->userdata('nama_pengguna') ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo base_url(); ?>assets/nophoto.png" class="img-circle" alt="User Image">
                <p>
                  <?php echo $this->session->userdata('username') ?> - Administrator
                  <small>Last Login : <?php echo $this->session->userdata('last_login') ?></small>
                </p>
              </li>
              <!-- Menu Body -->

              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="<?php print site_url(); ?>login/logout" class="btn btn-default btn-flat">Sign out</a>
                </div>

                <div class="pull-left">
                  <a href="<?php print site_url(); ?>login/change_password" class="btn btn-default btn-flat">Change Password</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url(); ?>assets/nophoto.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $this->session->userdata('username') ?></p>
          <a href="#" style="text-transform: capitalize;"><i class="fa fa-circle text-success"></i> <?php echo $this->session->userdata('level') ?></a>
        </div>
      </div>
      <!-- search form -->

      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>

        <li>
          <a href="<?php print site_url();?>dashboard">
            <i class="fa fa-home"></i> <span>Dashboard</span>
          </a>
        </li>

        <?php if($this->session->userdata('level')=="admin2"){ ?>

             <li>
                <a href="<?php print site_url();?>admin/transaksi">
                  <i class="fa fa-credit-card"></i> <span>Transaksi</span>
                  <span class="pull-right-container">
                    <small class="label pull-right bg-red">Transaction</small>
                  </span>
                </a>
            </li>
            <li>
            <a href="<?php print site_url();?>admin/rmb/detail_rmb">
              <i class="fa">¥</i> <span>Rmb</span>
              <span class="pull-right-container">
                <small class="label pull-right bg-red">stock</small>
              </span>
            </a>
          </li>
        <?php }else if($this->session->userdata('level')=="sales" || $this->session->userdata('level')=="saleso"){ ?>
          <li><a href="<?php print site_url();?>admin/lead"><i class="fa fa-user"></i>List Leads</a></li>
          <li><a href="<?php print site_url();?>admin/customer"><i class="fa fa-user"></i> Customer</a></li>
          <li><a href="<?php print site_url();?>admin/laporan/sales"><i class="fa fa-user"></i>Laporan Sales</a></li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-credit-card"></i> <span>Titip Transfer</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li>
                <a href="<?php print site_url();?>admin/transaksi"><i class="fa fa-angle-right"></i> Transaksi</a>
             </li>
             <li><a href="<?php print site_url();?>admin/invoice"><i class="fa fa-angle-right"></i> Invoice </a></li>
            </ul>
          </li>

            <li class="treeview">
              <a href="#">
                <i class="fa fa-ship"></i> <span>Import by Sea</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li>
                  <a href="<?php print site_url();?>admin/resi">
                    <i class="fa fa-angle-right"></i> <span>Resi</span>
                  </a>
                </li>
                <li>
                 <a href="<?php print site_url();?>admin/invoice_barang"><i class="fa fa-angle-right"></i> Invoice </a>
                </li>
              </ul>
            </li>
         <li><a href="<?php print site_url();?>admin/customer/unverified"><i class="fa fa-check-square-o"></i> Customer Unverified </a></li>
         <li>
           <a href="<?php print site_url();?>admin/jobcs">
             <i class="fa fa-fax"></i> <span>Job Cs</span>
           </a>
         </li>
     <?php }else if($this->session->userdata('level')=="crm" || $this->session->userdata('level')=="spv"){ ?>
           <li><a href="<?php print site_url();?>admin/customer"><i class="fa fa-user"></i> Customer</a></li>
           <li><a href="<?php print site_url();?>admin/customer/index_tidakfix"><i class="fa fa-user"></i> Customer Tidak Fix</a></li>
           <li><a href="<?php print site_url();?>admin/laporan/sales" style="text-transform: capitalize;"><i class="fa fa-user"></i>Laporan <?php echo $this->session->userdata('level') ?></a></li>

          <li class="treeview">
            <a href="#">
              <i class="fa fa-credit-card"></i> <span>Titip Transfer</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li>
                <a href="<?php print site_url();?>admin/transaksi"><i class="fa fa-angle-right"></i> Transaksi</a>
             </li>
             <li><a href="<?php print site_url();?>admin/invoice"><i class="fa fa-angle-right"></i> Invoice </a></li>
            </ul>
          </li>

            <li class="treeview">
              <a href="#">
                <i class="fa fa-ship"></i> <span>Import by Sea</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li>
                  <a href="<?php print site_url();?>admin/resi">
                    <i class="fa fa-angle-right"></i> <span>Resi</span>
                  </a>
                </li>
                <li>
                 <a href="<?php print site_url();?>admin/invoice_barang"><i class="fa fa-angle-right"></i> Invoice </a>
                </li>
              </ul>
            </li>

            <li class="treeview">
              <a href="#">
                <i class="fa fa-plane"></i> <span>Import by Air</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li>
                  <a href="<?php print site_url();?>admin/resi_udara">
                    <i class="fa fa-angle-right"></i> <span>Resi</span>
                  </a>
                </li>
               <li><a href="<?php print site_url();?>admin/resi_udara/invoice"><i class="fa fa-angle-right"></i> Invoice </a></li>
              </ul>
            </li>
          <li><a href="<?php print site_url();?>admin/customer/unverified"><i class="fa fa-check-square-o"></i> Customer Unverified </a></li>
          <li>
            <a href="<?php print site_url();?>admin/jobcs">
              <i class="fa fa-fax"></i> <span>Job Cs</span>
            </a>
          </li>

          <?php if($this->session->userdata('level')=="spv" || $this->session->userdata('level')=="suadmin"){ ?>
               <li><a href="<?php print site_url();?>admin/customer/add_crm"><i class="fa fa-user"></i> Customer No CRM</a></li>
          <?php } ?>

     <?php }else if($this->session->userdata('level')=="admin" || $this->session->userdata('level')=="suadmin" || $this->session->userdata('level')=="finance" || $this->session->userdata('level')=="cs"){ ?>

              <li class="treeview">
                <a href="#">
                  <i class="fa fa-user"></i> <span>Customer</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="<?php print site_url();?>admin/customer"><i class="fa fa-user"></i> Customer</a></li>
                  <li><a href="<?php print site_url();?>admin/customer_grup"><i class="fa fa-users"></i> Customer Grup</a></li>
                  <li><a href="<?php print site_url();?>admin/customer/index_tidakfix"><i class="fa fa-user"></i> Customer Tidak Fix</a></li>
                  <li><a href="<?php print site_url();?>admin/komisi_referal"><i class="fa fa-money"></i> Komisi Referal </a></li>
                  <li><a href="<?php print site_url();?>admin/customer/index_10cbm"><i class="fa fa-user"></i> Customer > 10 Cbm</a></li>
                  <li><a href="<?php print site_url();?>admin/customer/no_sk"><i class="fa fa-user"></i> Customer No SK</a></li>
                  <?php if($this->session->userdata('level')=="sales"){ ?>
                    <li><a href="<?php print site_url();?>admin/customer/unverified"><i class="fa fa-check-square-o"></i> Customer Unverified </a></li>
                  <?php } ?>
                </ul>
              </li>
             <li class="treeview">
               <a href="#">
                 <i class="fa fa-credit-card"></i> <span>Titip Transfer</span>
                 <span class="pull-right-container">
                   <i class="fa fa-angle-left pull-right"></i>
                 </span>
               </a>
               <ul class="treeview-menu">
                 <li>
                   <a href="<?php print site_url();?>admin/transaksi"><i class="fa fa-angle-right"></i> Transaksi</a>
                </li>

                <li>
                  <a href="<?php print site_url();?>admin/pembelian">
                    <i class="fa fa-angle-right"></i> <span> Transaksi > 10000</span>
                  </a>
                </li>

                <li><a href="<?php print site_url();?>admin/invoice"><i class="fa fa-angle-right"></i> Invoice </a></li>
               </ul>
             </li>

               <li class="treeview">
                 <a href="#">
                   <i class="fa fa-ship"></i> <span>Import by Sea</span>
                   <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                   </span>
                 </a>
                 <ul class="treeview-menu">
                   <li>
                     <a href="<?php print site_url();?>admin/resi">
                       <i class="fa fa-angle-right"></i> <span>Resi</span>
                     </a>
                   </li>

                  <li>
                    <a href="<?php print site_url();?>admin/invoice_barang"><i class="fa fa-angle-right"></i> Invoice </a>
                  </li>

                  <li>
                    <a href="<?php print site_url();?>admin/pengiriman"><i class="fa fa-angle-right"></i> Pengiriman </a>
                  </li>

                  <li>
                    <a href="<?php print site_url();?>admin/resi/pl"><i class="fa fa-angle-right"></i> Invoice / Packing List  </a>
                  </li>

                 </ul>
               </li>

               <li class="treeview">
                 <a href="#">
                   <i class="fa fa-plane"></i> <span>Import by Air</span>
                   <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                   </span>
                 </a>
                 <ul class="treeview-menu">
                   <li>
                     <a href="<?php print site_url();?>admin/resi_udara">
                       <i class="fa fa-angle-right"></i> <span>Resi</span>
                     </a>
                   </li>
                  <li><a href="<?php print site_url();?>admin/resi_udara/gen_invoice"><i class="fa fa-angle-right"></i> Generate Invoice </a></li>
                  <li><a href="<?php print site_url();?>admin/resi_udara/invoice"><i class="fa fa-angle-right"></i> Invoice </a></li>
                 </ul>
               </li>

               <?php if($this->session->userdata('level')=="finance" || $this->session->userdata('level')=="admin" || $this->session->userdata('level')=="suadmin"){ ?>
                   <li>
                     <a href="<?php print site_url();?>admin/customer/tarik_dana">
                       <i class="fa fa-money"></i> <span>Tarik Dana</span>
                     </a>
                   </li>
               <?php } ?>

          <!-- Admin -->
          <?php if($this->session->userdata('level')=="cs" || $this->session->userdata('level')=="admin" || $this->session->userdata('level')=="suadmin"){ ?>
                <li>
                  <a href="<?php print site_url();?>admin/broadcast">
                    <i class="fa fa-wechat"></i> <span>Broadcast</span>
                  </a>
                </li>
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-fax"></i> <span>Job Cs</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <?php if($this->session->userdata('level')=="admin" || $this->session->userdata('level')=="suadmin"){ ?>
                      <li><a href="<?php print site_url();?>admin/master_masalah"><i class="fa fa-gift"></i> Masalah </a></li>
                    <?php } ?>
                    <li>
                      <a href="<?php print site_url();?>admin/jobcs">
                        <i class="fa fa-fax"></i> <span>Job Cs</span>
                      </a>
                    </li>
                  </ul>
                </li>

         <?php } ?>
          <!-- Sales -->
              <?php if($this->session->userdata('level')=="sales" || $this->session->userdata('level')=="suadmin"){ ?>
                <li class="treeview">
                 <a href="#">
                   <i class="fa fa-book"></i> <span>Marketing</span>
                   <span class="pull-right-container">
                     <i class="fa fa-angle-left pull-right"></i>
                   </span>
                 </a>
                 <ul class="treeview-menu">
                   <li><a href="<?php print site_url();?>admin/lead"><i class="fa fa-user"></i>List Leads</a></li>
                   <?php if ($this->session->userdata('level')=="suadmin"): ?>
                     <li><a href="<?php print site_url();?>admin/campaign"><i class="fa fa-map-o"></i> Campaign </a></li>
                   <?php endif; ?>
                 </ul>
               </li>
               <li><a href="<?php print site_url();?>admin/laporan/sales"><i class="fa fa-user"></i>Laporan Sales</a></li>
         <?php } ?>
         <!-- Finance -->
         <?php if($this->session->userdata('level')=="finance" || $this->session->userdata('level')=="suadmin"){ ?>

               <li>
                 <a href="<?php print site_url();?>admin/pembayaran_beli">
                   <i class="fa fa-money"></i> <span>Pembelian</span>
                 </a>
               </li>
               <li>
                 <a href="<?php print site_url();?>admin/vendor">
                   <i class="fa fa-users"></i> <span>Vendor</span>
                 </a>
               </li>
               <li>
                 <a href="<?php print site_url();?>admin/kelas_impor">
                   <i class="fa fa-fax"></i> <span>Kelas Impor</span>
                 </a>
               </li>
               <li class="treeview">
                <a href="#">
                  <i class="fa fa-book"></i> <span>Laporan</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li>
                    <a href="<?php print site_url();?>admin/laporan/master">
                      <i class="fa fa-book"></i> <span>Master</span>
                    </a>
                  </li>
                  <li>
                    <a href="<?php print site_url();?>admin/laporan/master_invoice">
                      <i class="fa fa-book"></i> <span>Master Invoice</span>
                    </a>
                  </li>
                  <li><a href="<?php print site_url();?>admin/laporan/laba_rugi"><i class="fa fa-money"></i> Laba Rugi </a></li>
                  <li><a href="<?php print site_url();?>admin/laporan/neraca"><i class="fa fa-balance-scale"></i> Neraca </a></li>
                  <li><a href="<?php print site_url();?>admin/laporan/neraca_new"><i class="fa fa-balance-scale"></i> Neraca New </a></li>
                  <li><a href="<?php print site_url();?>admin/laporan/sales"><i class="fa fa-bar-chart"></i> Sales </a></li>
                  <li><a href="<?php print site_url();?>admin/laporan/customer/30"><i class="fa fa-user"></i> Customer </a></li>
                  <li><a href="<?php print site_url();?>admin/laporan/customer_pertahun"><i class="fa fa-user"></i> Customer Pertahun</a></li>
                  <li><a href="<?php print site_url();?>admin/laporan/giw"><i class="fa fa-ship"></i> Giw </a></li>
                </ul>
              </li>

             <?php } ?>
            <li>
              <a href="<?php print site_url();?>admin/pembayaran">
                <i class="fa fa-money"></i> <span>Pembayaran</span>
              </a>
            </li>

            <li>
              <a href="<?php print site_url();?>admin/pengeluaran">
                <i class="fa fa-money"></i> <span>Pengeluaran / Expense</span>
              </a>
            </li>

            <li>
              <a href="<?php print site_url();?>admin/klaim">
                <i class="fa fa-money"></i> <span>Klaim</span>
              </a>
            </li>

            <li>
              <a href="<?php print site_url();?>admin/invoice_lainnya">
                <i class="fa fa-envelope-o"></i> <span>Invoice Lainnya</span>
              </a>
            </li>

            <li class="treeview">
              <a href="#">
                <i class="fa fa-bank"></i> <span>Bank</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php print site_url();?>admin/bank"><i class="fa  fa-credit-card"></i> Bank</a></li>
                  <li><a href="<?php print site_url();?>admin/jenis_tb"><i class="fa fa-ellipsis-h"></i> Jenis Transaksi Bank</a></li>
                <li><a href="<?php print site_url();?>admin/parent_jenis_transaksi"><i class="fa fa-ellipsis-h"></i> Parent Jenis Transaksi Bank</a></li>
              </ul>
            </li>

            <li class="treeview">
              <a href="#">
                <i class="fa">¥</i> <span>RMB</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php print site_url();?>admin/kurs">
                <i class="fa fa-angle-right"></i> <span>Kurs</span></a></li>

                <li><a href="<?php print site_url();?>admin/rmb">
                <i class="fa fa-angle-right"></i> <span>RMB</span></a></li>

                <li><a href="<?php print site_url();?>admin/rmb/detail_rmb">
                <i class="fa fa-angle-right"></i> <span>Detail Rmb</span></a></li>

              </ul>
            </li>

       <?php
          }if($this->session->userdata('level')=="suadmin"){
        ?>
              <li class="treeview">
                <a href="#">
                  <i class="fa fa-cubes"></i> <span>Jenis Barang</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="<?php print site_url();?>admin/jenis_barang"><i class="fa fa-angle-right"></i>Umum</a></li>
                  <li><a href="<?php print site_url();?>admin/jenis_barang_customer"><i class="fa fa-angle-right"></i>Customer</a></li>

                </ul>
              </li>

              <li>
                <a href="<?php print site_url();?>admin/jenis_potongan">
                  <i class="fa fa-shopping-cart"></i> <span>Jenis Potongan</span>
                </a>
              </li>

              <li>
                <a href="<?php print site_url();?>admin/account">
                  <i class="fa fa-user"></i> <span>Account</span>
                  <span class="pull-right-container">
                    <small class="label pull-right bg-yellow">Account</small>
                  </span>
                </a>
              </li>

              <li>
                 <a href="<?php print site_url();?>admin/pusat_bantuan">
                   <i class="fa fa-envelope-o"></i> <span>Pusat Bantuan</span>
                 </a>
               </li>
      <?php } ?>
      <?php if($this->session->userdata('level')!="admin2"){ ?>
        <li>
          <a href="<?php print site_url();?>admin/stok_barang">
            <i class="fa fa-cubes"></i> <span>Stok Barang</span>
          </a>
        </li>
        <li><a href="<?php print site_url();?>admin/ekspedisi_lokal"><i class="fa fa-bank"></i> Master Ekspedisi Lokal</a></li>
      <?php } ?>
      <?php if($this->session->userdata('level')=="gudang" || $this->session->userdata('level')=="admin" || $this->session->userdata('level')=="suadmin"){ ?>
        <li>
          <a href="<?php print site_url();?>admin/resi">
            <i class="fa fa-book"></i> <span>Resi</span>
          </a>
        </li>
        <li>
          <a href="<?php print site_url();?>admin/container/otw">
            <i class="fa fa-ship"></i> <span>Container Otw</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-blue">Otw</small>
            </span>
          </a>
        </li>
        <li>
          <a href="<?php print site_url();?>admin/container/monitoring">
            <i class="fa fa-hourglass-o"></i> <span>Container Monitoring</span>
          </a>
        </li>
        <li>
          <a href="<?php print site_url();?>admin/container/arrived">
            <i class="fa fa-university"></i> <span>Container Arrived</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">Arrived</small>
            </span>
          </a>
        </li>
        <li>
          <a href="<?php print site_url();?>admin/container/selesai">
            <i class="fa fa-university"></i> <span>Container Selesai</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-red">Selesai</small>
            </span>
          </a>
        </li>

        <li>
          <a href="<?php print site_url();?>admin/mobilsj">
            <i class="fa fa-car"></i> <span>Mobil & SJ</span>
          </a>
        </li>
        <?php if($this->session->userdata('level')=="gudang"){ ?>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-plane"></i> <span>Import by Air</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li>
                <a href="<?php print site_url();?>admin/resi_udara">
                  <i class="fa fa-angle-right"></i> <span>Resi</span>
                </a>
              </li>
             <li><a href="<?php print site_url();?>admin/resi_udara/gen_invoice"><i class="fa fa-angle-right"></i> Generate Invoice </a></li>
             <li><a href="<?php print site_url();?>admin/resi_udara/invoice"><i class="fa fa-angle-right"></i> Invoice </a></li>
            </ul>
          </li>
          <li><a href="<?php print site_url();?>admin/customer"><i class="fa fa-user"></i> Customer</a></li>
      <?php } ?>
      <?php } ?>
      <?php if($this->session->userdata('level')=="cschina"){ ?>
        <li><a href="<?php print site_url();?>admin/customer"><i class="fa fa-user"></i> Customer</a></li>
        <li>
          <a href="<?php print site_url();?>admin/jobcs">
            <i class="fa fa-fax"></i> <span>Job Cs</span>
          </a>
        </li>
        <li>
          <a href="<?php print site_url();?>admin/resi/pl"><i class="fa fa-book"></i> Invoice / Packing List  </a>
        </li>
      <?php } ?>


      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Wilopo Cargo
        <small>Apps</small>
      </h1>
      </section>

    <!-- Main content -->
    <section class="content">
      <?php if($this->uri->segment(2)=="customer" && $detail == 1){ ?>
        <div class="row">
          <div class="col-md-3">
            <!-- Profile Image -->
            <div class="box box-primary">
              <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url('assets/nophoto.png') ?>" alt="User profile picture">
                <h3 class="profile-username text-center"><?php echo $r->nama ?></h3>
                <p class="text-muted text-center"><?php echo $r->kode ?></p>
                <ul class="list-group list-group-unbordered">
                  <li class="list-group-item">
                    <?php $stremail = strlen($r->email); ?>
                    <b>Email</b>
                    <a <?php if($stremail < 15){ ?> class="pull-right" <?php } ?>><?php echo $r->email ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Telepon</b> <a class="pull-right"><?php echo $r->telepon ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Whatsapp</b> <a class="pull-right"><?php echo $r->whatsapp ?></a>
                  </li>
                </ul>
                <a href="<?php echo site_url('admin/customer/edit_customer/'.$r->id_cust) ?>" class="btn btn-primary btn-block" alt="Update Data">Update Data</b></a>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <!-- About Me Box -->
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">More Detail</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <strong><i class="fa fa-calendar"></i> Total Cbm LCL </strong>
                <p> <?php
                    if($cbm_customer->jumlah > 0){
                      echo round($cbm_customer->jumlah,2)." m<sup>3</sup>";
                    }else{
                      echo "0";
                    }
                     ?></p>
                <hr>
                <strong><i class="fa fa-calendar"></i> Tanggal Bergabung</strong>
                <p> <?php echo date_indo($r->tanggal_daftar) ?></p>
                <hr>
                <strong><i class="fa fa-map-marker margin-r-5"></i> Alamat</strong>
                <p class="text-muted">
                  <?php echo $r->alamat ?>
                </p>
                <hr>
                <strong><i class="fa fa-money margin-r-5"></i> Deposit</strong>
                <p>Rp. <?php echo number_format($r->deposit) ?></p>
                <hr>
                <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>
                <p><?php echo $r->note ?></p>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li <?php if($this->uri->segment(5) == "index"){ ?> class="active" <?php } ?>><a href="<?php echo site_url('admin/customer/detail/'.$this->uri->segment(4).'/index'); ?>"><i class="fa fa-ellipsis-h"></i> Detail </a></li>
                <li <?php if($this->uri->segment(5) == "resi"){ ?> class="active" <?php } ?>><a href="<?php echo site_url('admin/customer/detail/'.$this->uri->segment(4).'/resi'); ?>"><i class="fa fa-newspaper-o"></i> Resi </a></li>
                <li <?php if($this->uri->segment(5) == "barang"){ ?> class="active" <?php } ?>><a href="<?php echo site_url('admin/customer/detail/'.$this->uri->segment(4).'/barang'); ?>"><i class="fa fa-ship"></i> Barang</a></li>
                <li <?php if($this->uri->segment(5) == "transaksi"){ ?> class="active" <?php } ?>><a href="<?php echo site_url('admin/customer/detail/'.$this->uri->segment(4).'/transaksi'); ?>"><i class="fa fa-bookmark-o"></i> Titip Transfer</a></li>
                <li <?php if($this->uri->segment(5) == "invoice"){ ?> class="active" <?php } ?>><a href="<?php echo site_url('admin/customer/detail/'.$this->uri->segment(4).'/invoice'); ?>"><i class="fa fa-envelope"></i> Inv Trf</a></li>
                <li <?php if($this->uri->segment(5) == "invoice_barang"){ ?> class="active" <?php } ?>><a href="<?php echo site_url('admin/customer/detail/'.$this->uri->segment(4).'/invoice_barang'); ?>"><i class="fa fa-send-o"></i> Inv Brg</a></li>
                <li <?php if($this->uri->segment(5) == "pembayaran"){ ?> class="active" <?php } ?>><a href="<?php echo site_url('admin/customer/detail/'.$this->uri->segment(4).'/pembayaran'); ?>"><i class="fa fa-credit-card"></i> Pembayaran</a></li>
                <li <?php if($this->uri->segment(5) == "deposit"){ ?> class="active" <?php } ?>><a href="<?php echo site_url('admin/customer/detail/'.$this->uri->segment(4).'/deposit'); ?>"><i class="fa fa-money"></i> Deposit</a></li>
                <li <?php if($this->uri->segment(5) == "harga_khusus"){ ?> class="active" <?php } ?>><a href="<?php echo site_url('admin/customer/detail/'.$this->uri->segment(4).'/harga_khusus'); ?>"><i class="fa fa-cubes"></i> Harga Khusus </a></li>
                <li <?php if($this->uri->segment(5) == "cbm"){ ?> class="active" <?php } ?>><a href="<?php echo site_url('admin/customer/detail/'.$this->uri->segment(4).'/cbm'); ?>"><i class="fa fa-books"></i> Cbm Perbulan </a></li>
              </ul>
              <div class="tab-content">
                <div class="active tab-pane" id="activity">
                    <?php echo $contents; ?>
                </div>
                <!-- /.tab-pane -->
              </div>
              <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      <?php }else if($this->uri->segment(2)=="customer_grup" && $detail == 1){ ?>
        <div class="row">
          <div class="col-md-3">
            <!-- Profile Image -->
            <div class="box box-primary">
              <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url('assets/nophoto.png') ?>" alt="User profile picture">
                <h3 class="profile-username text-center"><?php echo $r->nama_cgrup ?></h3>
                <p class="text-muted text-center"><?php echo $r->kode_cgrup ?></p>
                <ul class="list-group list-group-unbordered">
                  <li class="list-group-item">
                    <?php $stremail = strlen($r->email_cgrup); ?>
                    <b>Email</b>
                    <a <?php if($stremail < 15){ ?> class="pull-right" <?php } ?>><?php echo $r->email_cgrup ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Telepon</b> <a class="pull-right"><?php echo $r->telepon_cgrup ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Whatsapp</b> <a class="pull-right"><?php echo $r->whatsapp_cgrup ?></a>
                  </li>
                </ul>
                <a data-toggle="modal" data-target="#ModalUpdate_grup" class="btn btn-primary btn-block"><b>Update Data</b></a>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <!-- About Me Box -->
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">More Detail</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <strong><i class="fa fa-calendar"></i> Tanggal Bergabung</strong>
                <p> <?php echo date_indo($r->tanggal_daftar_cgrup) ?></p>
                <hr>
                <strong><i class="fa fa-map-marker margin-r-5"></i> Alamat</strong>
                <p class="text-muted">
                  <?php echo $r->alamat_cgrup ?>
                </p>
                <hr>
                <strong><i class="fa fa-money margin-r-5"></i> Deposit</strong>
                <p>Rp. <?php echo number_format($r->deposit) ?></p>
                <hr>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li <?php if($this->uri->segment(5) == "index"){ ?> class="active" <?php } ?>><a href="<?php echo site_url('admin/customer_grup/detail/'.$this->uri->segment(4).'/index'); ?>"><i class="fa fa-ellipsis-h"></i> Detail </a></li>
                <li <?php if($this->uri->segment(5) == "customer"){ ?> class="active" <?php } ?>><a href="<?php echo site_url('admin/customer_grup/detail/'.$this->uri->segment(4).'/customer'); ?>"><i class="fa fa-user"></i> Customer </a></li>
                <li <?php if($this->uri->segment(5) == "resi"){ ?> class="active" <?php } ?>><a href="<?php echo site_url('admin/customer_grup/detail/'.$this->uri->segment(4).'/resi'); ?>"><i class="fa fa-newspaper-o"></i> Resi </a></li>
                <li <?php if($this->uri->segment(5) == "barang"){ ?> class="active" <?php } ?>><a href="<?php echo site_url('admin/customer_grup/detail/'.$this->uri->segment(4).'/barang'); ?>"><i class="fa fa-ship"></i> Barang</a></li>
                <li <?php if($this->uri->segment(5) == "transaksi"){ ?> class="active" <?php } ?>><a href="<?php echo site_url('admin/customer_grup/detail/'.$this->uri->segment(4).'/transaksi'); ?>"><i class="fa fa-bookmark-o"></i> Titip Transfer</a></li>
                <li <?php if($this->uri->segment(5) == "invoice"){ ?> class="active" <?php } ?>><a href="<?php echo site_url('admin/customer_grup/detail/'.$this->uri->segment(4).'/invoice'); ?>"><i class="fa fa-envelope"></i> Inv Trf</a></li>
                <li <?php if($this->uri->segment(5) == "invoice_barang"){ ?> class="active" <?php } ?>><a href="<?php echo site_url('admin/customer_grup/detail/'.$this->uri->segment(4).'/invoice_barang'); ?>"><i class="fa fa-send-o"></i> Inv Brg</a></li>
                <li <?php if($this->uri->segment(5) == "pembayaran"){ ?> class="active" <?php } ?>><a href="<?php echo site_url('admin/customer_grup/detail/'.$this->uri->segment(4).'/pembayaran'); ?>"><i class="fa fa-credit-card"></i> Pembayaran</a></li>
                <li <?php if($this->uri->segment(5) == "deposit"){ ?> class="active" <?php } ?>><a href="<?php echo site_url('admin/customer_grup/detail/'.$this->uri->segment(4).'/deposit'); ?>"><i class="fa fa-money"></i> Deposit</a></li>
                <li <?php if($this->uri->segment(5) == "harga_khusus"){ ?> class="active" <?php } ?>><a href="<?php echo site_url('admin/customer_grup/detail/'.$this->uri->segment(4).'/harga_khusus'); ?>"><i class="fa fa-cubes"></i> Harga Khusus </a></li>
              </ul>
              <div class="tab-content">
                <div class="active tab-pane" id="activity">
                    <?php echo $contents; ?>
                </div>
                <!-- /.tab-pane -->
              </div>
              <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      <?php }else{ ?>
      <?php echo $contents;  ?>
      <?php } ?>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright Admin LTE&copy; 2014-2016 <a href="#">Wilopo Cargo 2019</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>

    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->

      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>

  <form id="add-row-form" action="<?php echo base_url().'admin/customer_grup/update'?>" method="post" enctype="multipart/form-data">
     <div class="modal fade" id="ModalUpdate_grup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                   <h4 class="modal-title" id="myModalLabel">Update Data Customer Grup</h4>
               </div>
               <div class="modal-body">

               <input type="hidden" name="id_cgrup" value="<?php echo $r->id_cgrup ?>" class="form-control" required>

                   <div class="form-group">
                   <label>Nama </label>
                       <input type="text" name="nama_cgrup" class="form-control" placeholder="Nama Customer" value="<?php echo $r->nama_cgrup ?>" required>
                   </div>

                   <div class="form-group">
                   <label>Email </label>
                       <input type="text" name="email_cgrup" class="form-control" value="<?php echo $r->email_cgrup ?>" placeholder="Email Customer" required>
                   </div>

                   <div class="form-group">
                   <label>Telepon </label>
                       <input type="text" name="telepon_cgrup" class="form-control" value="<?php echo $r->telepon_cgrup ?>" placeholder="Telepon Customer" required>
                   </div>
                   <div class="form-group">
                     <label>Whatsapp</label>
                       <input type="text" name="whatsapp_cgrup" class="form-control" value="<?php echo $r->whatsapp_cgrup ?>" placeholder="Whatsapp Customer" required>
                   </div>

                   <div class="form-group">
                     <label>Alamat</label>
                       <textarea type="text" name="alamat_cgrup" class="form-control" placeholder="Alamat" required><?php echo $r->alamat_cgrup ?></textarea>
                   </div>

                   <div class="form-group">
                   <label>Noted</label>
                       <textarea type="text" name="note_cgrup" class="form-control" placeholder="Noted"><?php echo $r->note_cgrup ?></textarea>
                   </div>

                   <div class="form-group">
                        <label>Foto KTP</label>
                        <input type="file" name="foto_ktpcgrup" class="btn btn-primary">
                   </div>

                   <div class="form-group">
                        <label>Foto SK</label>
                        <input type="file" name="foto_skcgrup" class="btn btn-primary">
                   </div>

               </div>
               <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="add-row" class="btn btn-primary">Update</button>
               </div>
            </div>
        </div>
     </div>
  </form>

  <div id="edit_customer"></div>
<!-- ./wrapper -->
<!-- jQuery 3 -->
<!-- <script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script> -->
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url(); ?>assets/bower_components/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo base_url().'assets/jquery/select2.min.js'?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="<?php echo base_url(); ?>assets/bower_components/raphael/raphael.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url(); ?>assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo base_url(); ?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url(); ?>assets/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url(); ?>assets/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo base_url(); ?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url(); ?>assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url(); ?>assets/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script>
<script>
  $('form').submit(function() {
    $.LoadingOverlay("show");
  });
  $(function () {
    $(".example1").DataTable({
      "pageLength": 20
    });
  });
</script>
<!-- Select2 -->
<script src="<?php echo base_url() ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $(".select").select2();
  });
</script>
<script>
    function hanyaangka(evt){
  var charCode = (evt.which) ? evt.which : event.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57))
  return false;
  return true;
  //onkeypress="return hanyaangka(event)"
}
function tandaPemisahTitik(b){
	var _minus = false;
	if (b<0) _minus = true;
	b = b.toString();
	b=b.replace(".","");

	c = "";
	panjang = b.length;
	j = 0;
	for (i = panjang; i > 0; i--){
		 j = j + 1;
		 if (((j % 3) == 1) && (j != 1)){
		   c = b.substr(i-1,1) + "." + c;
		 } else {
		   c = b.substr(i-1,1) + c;
		 }
	}
	if (_minus) c = "-" + c ;
	return c;
}

function numbersonly(ini, e){
	if (e.keyCode>=49){
		if(e.keyCode<=57){
		a = ini.value.toString().replace(".","");
		b = a.replace(/[^\d]/g,"");
		b = (b=="0")?String.fromCharCode(e.keyCode):b + String.fromCharCode(e.keyCode);
		ini.value = tandaPemisahTitik(b);
		return false;
		}
		else if(e.keyCode<=105){
			if(e.keyCode>=96){
				//e.keycode = e.keycode - 47;
				a = ini.value.toString().replace(".","");
				b = a.replace(/[^\d]/g,"");
				b = (b=="0")?String.fromCharCode(e.keyCode-48):b + String.fromCharCode(e.keyCode-48);
				ini.value = tandaPemisahTitik(b);
				//alert(e.keycode);
				return false;
				}
			else {return false;}
		}
		else {
			return false; }
	}else if (e.keyCode==48){
		a = ini.value.replace(".","") + String.fromCharCode(e.keyCode);
		b = a.replace(/[^\d]/g,"");
		if (parseFloat(b)!=0){
			ini.value = tandaPemisahTitik(b);
			return false;
		} else {
			return false;
		}
	}else if (e.keyCode==95){
		a = ini.value.replace(".","") + String.fromCharCode(e.keyCode-48);
		b = a.replace(/[^\d]/g,"");
		if (parseFloat(b)!=0){
			ini.value = tandaPemisahTitik(b);
			return false;
		} else {
			return false;
		}
	}else if (e.keyCode==8 || e.keycode==46){
		a = ini.value.replace(".","");
		b = a.replace(/[^\d]/g,"");
		b = b.substr(0,b.length -1);
		if (tandaPemisahTitik(b)!=""){
			ini.value = tandaPemisahTitik(b);
		} else {
			ini.value = "";
		}

		return false;
	} else if (e.keyCode==9){
		return true;
	} else if (e.keyCode==17){
		return true;
	} else {
		//alert (e.keyCode);
		return false;
	}

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
  $('.referal').select2({});
</script>
</body>
</html>
