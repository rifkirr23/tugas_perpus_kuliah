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

	td {
		font-size: 14px;
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
<h3><center>List Resi & Giw di Container <?php echo $dc->kode ?></center></h3>
<table border="1" cellpadding="4" cellspacing="0" width="100%" style=" border-collapse: collapse;" class="record">
	<tr>
		<th>No.</th>
		<th>Marking</th>
		<?php if($this->uri->segment(5) == "alamat"){ ?>
			<th>Nomor Resi</th>
			<th>Giw</th>
	  <?php } ?>
		<th>Volume</th>
		<th>Jumlah Koli</th>
		<th>Berat</th>
		<?php if($this->uri->segment(5) == "alamat"){ ?>
			<th>Gudang</th>
			<th>Alamat</th>
		<?php } ?>
	</tr>
	<?php $no=1; $tkoli = 0; $tvolume=0; $tberat=0; foreach($data_resi as $dr){
		$cekcbmcont = $this->db->select('sum(giw.volume * giw.ctns) as total')
													 ->from('giw')
													 ->where('customer_id',$dr->id_cust)
													 ->where('container_id',$this->uri->segment(4))
													 ->get()->row();
		$cekbarangjalan = $this->db->select('sum(giw.volume * giw.ctns) as total')
													 ->from('giw')
													 ->where('customer_id',$dr->id_cust)
													 ->where('container_id !=',$this->uri->segment(4))
													 ->group_start()
														 ->where('status',7)
														 ->or_where('status <',5)
													 ->group_end()
													 ->get()->row();
		if($cekbarangjalan->total > 0){
			$bolehkirim = 1;
		}else{
			$bolehkirim = 0;
		}
		if($dr->id_provinsi2 != "31" || $dr->id_kota2 == "3175" || $dr->id_kota2 == "3174" || $dr->tipe_ekspedisi == "pickup" ||
			 $dr->tipe_ekspedisi == "nanya" || $dr->fix_alamat != 1 || $cekcbmcont->total < 0.5 || $bolehkirim == 0){
				 // $detailkondisi =  $dr->id_kota2.",".$dr->tipe_ekspedisi.",".$dr->id_kota2.",".$dr->id_kota2.","
				 $gudangnya = "Gudang WC";
		}else{
				 $gudangnya = "Gudang Joni";
		}
	?>
	<tbody>
		<tr <?php if($gudangnya == "Gudang WC"){ ?> style='background-color:#A9F096; color:black;' <?php } ?>
				<?php if($gudangnya == "Gudang Joni"){ ?>style='background-color:#F9DF9C; color:black;' <?php } ?>

		>
			<td><?php echo $no; ?></td>
			<td><?php echo $dr->marking ?></td>
			<?php if($this->uri->segment(5) == "alamat"){ ?>
				<td><?php echo $dr->nomor_resi."(".$dr->resinote.")" ?></td>
				<td>
					<?php
						$datagiw = $this->db->select('nomor')->from('giw')->where('resi_id',$dr->id_resi)->where('container_id',$this->uri->segment(4))->get()->result();
						foreach ($datagiw as $dg ) {
							echo $dg->nomor.", ";
						}
					 ?>
				</td>
			<?php } ?>
			<td><?php echo round($dr->cbm,3) ?> M<sup>3</sup></td>
			<td><?php echo $dr->jumlah_koli ?> Koli</td>
			<td><?php echo round($dr->total_berat,3) ?> Kg</td>
			<?php if($this->uri->segment(5) == "alamat"){ ?>
			<td><?php echo $gudangnya ?></td>
			<td>
				<?php
				echo "<b>".$dr->namacs."</b><br />";
				if($gudangnya == "Gudang WC"){
					echo "-";
				}else{
					if($dr->id_ekspedisi >= 8 ){
						$proveks = $this->db->select('provinsi.nama')->where('id_prov',$dr->id_provinsi2)->get('provinsi')->row();
						$kotaeks = $this->db->select('kabupaten.nama')->where('id_kab',$dr->id_kota2)->get('kabupaten')->row();
						$keceks = $this->db->select('kecamatan.nama')->where('id_kec',$dr->id_kec2)->get('kecamatan')->row();
						echo "<b> Ekspedisi : ".$proveks->nama." , ".$kotaeks->nama." , ".$keceks->nama."</b> <br /><br />".
						$dr->nama_ekspedisi." , ".$dr->almteks." , ".$dr->notelpeks.
						"<br /><br /> Alamat : ".$dr->almtcust." , ".$dr->namaprov." , ".$dr->namakota." , ".$dr->namakec.
						" <br /><br /> No. Telp : ".$dr->telpcs;
					}else{
						echo "<b> Alamat : ".$dr->namaprov." , ".$dr->namakota." , ".$dr->namakec."</b> <br /><br />".$dr->almtcust.
						"<br /><br />".$dr->nama_ekspedisi.
						" <br /><br /> No. Telp : ".$dr->telpcs;
					}
				}
				?>
			</td>
		<?php } ?>
		</tr>
		<!-- <tr>
			<td>Notes</td>
			<td colspan="4">&nbsp;<p>&nbsp;</p></td>
		</tr> -->
	</tbody>
	<?php $no++; $tkoli+=$dr->jumlah_koli; $tvolume+=$dr->cbm; $tberat+=$dr->total_berat; } ?>
	<tr>
		<td colspan="2">Total</td>
		<td><?php echo round($tvolume,3) ?> m <sup>3</sup></td>
		<td><?php echo $tkoli ?></td>
		<td><?php echo round($tberat,3) ?> Kg</td>
	</tr>
</table>
