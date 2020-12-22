<style type="text/css">


	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin:0px auto;
		font-size:12px;
		font-family:Arial;
		color: #4F5155;
		width:960px;

	}

	a {
		color: #FF3300;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		font-size: 20px;
		font-weight: bold;
		margin: 0 0 5px 0;
		padding: 14px 15px 0px 15px;
	}

	h2 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 14px;
		font-weight: bold;
		width:60%;
		margin: 0 0 14px 0;
		padding: 0px 15px 10px 15px;
	}

	h3 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px dotted #D0D0D0;
		font-size: 14px;
		font-weight: bold;
		margin: 0 0 14px 0;
		padding: 0px 15px 10px 15px;
	}



	#bg-line {
		font-size: 12px;
		background-color: black;
		border: 1px solid #D0D0D0;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}


	.record a{
		text-decoration:none;
	}

	#body{
		margin: 0 15px 0 15px;
	}

	#body h5{
		margin:0px;
		padding:0px;
	}

	#body h4{
		margin:0px 0px 10px 0px;
		padding:0px;
	}

	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		padding: 10px 10px 20px 10px;
		margin: 20px 0 0 0;
		line-height:18px;
	}

	#container{
		width: 75%;
		margin: 0px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
		background-color:#FFFFFF;
		background-image:url(../images/bg_pattern.jpg);
	}

	.border_table {
      border: solid;

   }

   .border_table {
      border: solid;

   }
                 #table {
                border-top: solid thin ;
                border-collapse: collapse;
                width:15%;
           }

    .posisi{

            position:fixed;
            top:60%;
            right:10%;

    }

     .tr_biasa{
   	height: 25px;

   }

   .logo{
   		position: fixed;
	  	left: 60%;
	  	top: 2%;
	  	height:120px;
	  	width:290px;
   }
   .customer{
   		width:100%;

   }
   .terbilang{
   		width:400px;

   }

	 .tdcenter{
		 text-align: center;
		 font-weight: bold;
	 }


</style>
<h3><center>List Stok Barang Gudang</center></h3>
<table border="1" cellpadding="4" cellspacing="0" width="100%" style=" border-collapse: collapse;" class="record">
  <tr>
    <th>Marking</th>
    <th>Alamat</th>
    <th>Nomor Resi</th>
    <th>Volume</th>
    <th>Jumlah Koli</th>
  </tr>
  <?php $no=1; $totalcbm = 0; $totalkoli=0; foreach($data_resi as $dr){
    $datagiw = $this->db->select('nomor')
                        ->from('giw')
                        ->where('resi_id',$dr->id_resi)
                        ->join('invoice_product', 'invoice_product.id_giw=giw.id','left')
                        ->get()->result();
   ?>
	 <tr <?php if($dr->boleh_kirim == 1){ ?>style='background-color:#F9DF9C; color:black; ' <?php } ?>
			 <?php if($dr->boleh_kirim == 2){ ?>style='background-color:#A9F096; color:black;' <?php } ?>
			 <?php if($dr->boleh_kirim == 0){ ?>style='background-color:#FABAA5; color:black;' <?php } ?>>
		 <?php
			 if($dr->id_ekspedisi >= 8 ){
				 $tipe_eks = "Ekspedisi ".$dr->tipe_ekspedisi;
			 }else{
				 $tipe_eks = $dr->nama_ekspedisi." , ".$dr->tipe_ekspedisi;
			 }
		 ?>
		 <td style="text-transform: capitalize; font-weight: bold;"><?php echo $dr->marking."<br /><br /><br />".$tipe_eks ?></td>
		 <td>
			 <?php
				 if($dr->id_ekspedisi >= 8 ){
					 $proveks = $this->db->select('provinsi.nama')->where('id_prov',$dr->id_provinsi2)->get('provinsi')->row();
					 $kotaeks = $this->db->select('kabupaten.nama')->where('id_kab',$dr->id_kota2)->get('kabupaten')->row();
					 $keceks = $this->db->select('kecamatan.nama')->where('id_kec',$dr->id_kec2)->get('kecamatan')->row();
					 echo "<b> Ekspedisi : ".$proveks->nama." , ".$kotaeks->nama." , ".$keceks->nama."</b> <br /><br />".
					 $dr->nama_ekspedisi." , ".$dr->almteks." , ".$dr->notelpeks.
					 "<br /><br /> Alamat : ".$dr->almtcust." , ".$dr->namaprov." , ".$dr->namakota." , ".$dr->namakec.
					 " <br /><br /> No. Telp : ".$dr->telpcs."<br /> WA : ".$dr->wacs;
				 }else{
					 echo "<b> Alamat : ".$dr->namaprov." , ".$dr->namakota." , ".$dr->namakec."</b> <br /><br />".$dr->almtcust.
					 " <br /><br /> No. Telp : ".$dr->telpcs."<br /> WA : ".$dr->wacs;
				 }
			 ?>
		 </td>
		 <td ><?php echo $dr->nomor_resi ?></td>
		 <td style="font-weight: bold; "><?php echo round($dr->cbm,3) ?> M<sup>3</sup></td>
		 <td style="font-weight: bold; "><?php echo $dr->jumlah_koli ?> Koli</td>
	 </tr>
   <?php $totalcbm +=$dr->cbm; $totalkoli +=$dr->jumlah_koli; $no++; } ?>
   <tr>
     <td colspan="3">Total</td>
     <td ><?php echo round($totalcbm,3); ?> M<sup>3</sup></td>
     <td ><?php echo $totalkoli ?> Koli</td>
   </tr>
</table>
