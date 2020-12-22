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
	 }


</style>
	<?php
	if($r->id_cust == 64){
		$beratudara = $r->berat;
	}else{
		if($r->tanggal_resi >= "2020-08-22" || $r->id_resi_udara == 297 ){
			$beratudara = $r->berat_pembulatan;
		}else{
			$beratudara = $r->berat_pembulatan;
		}
	}
	?>
	<table width="100%">
		<tr>
			<td width="200px"><font size="7" color="black"><b>WILOPO CARGO</b></font></td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><img src="<?php echo base_url() ?>assets/logo2.jpg" class="logo"></td>
</tr>
<tr>
	<td width="200px"><?php echo alamat_pdf(); ?>
	</td>
	<td width="10px">&nbsp;</td>
	<td>
		<font size="5" color="black">
		<b>INVOICE #</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		: 		  &nbsp;&nbsp;&nbsp;
		<?php echo $r->kode_invoice ?>
		</font>

		<p>
			<font size="5" color="black">
		<b> DATE </b> 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		: 		&nbsp;&nbsp;&nbsp;
		<?php echo date_indo($r->tanggal_invoice) ?>
		</font>
		</p>
	</td>
</tr>
</table>


		<font size="5">--------------------------------------------------------------</font>
		<font size="6" color="black"> INVOICE </font>
		<font size="5">-------------------------------------------------------------</font>

		<p></p>

		<div id="body">
		<p> <font color="black"> <b>CUSTOMER</b></font> </p>
		<div class="customer">
			<div class="border_table">
				<table width="100%" cellpadding="3" cellspacing="0">



				<tr><td width="180"> <font color="black"> Kode Mark</td><td width="20">:</td><td><label>
				<font color="black"><?php echo $r->kode; ?></label></td>
				</tr>

				<tr><td width="180"><font color="black">Nama</td><td>:</td><td>
				<label><font color="black"><?php echo $r->nama; ?></label></td>
				</tr>

				<tr><td width="180"><font color="black">Alamat</td><td>:</td><td>
				<label><font color="black"><?php echo $r->alamat; ?></label></td>
				</tr>

				<tr><td width="180"><font color="black">Phone</td><td>:</td><td>
				<label><font color="black"><?php echo $r->whatsapp; ?></label></td>
				</tr>
			</table>
		 </div>
	</div>
			<div class="cleaner_h5"></div>
			<br>
			<table border="1" cellpadding="4" cellspacing="0" width="100%" style=" border-collapse: collapse;" class="record">

			<tr>
					<td><b><center>NOMOR RESI</center></font></b></td>
					<td><b><center>DESKRIPSI </center></font></b></td>
					<td><b><center>CTNS		  </center></b></td>
					<td><b><center>BERAT			</center></b></td>
					<td><b><center>HARGA PER UNIT</center></b></font></td>
					<td><b><center>TOTAL </center></font></b></td>
			</tr>

			<tr style="display: none;">

			</tr>

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
					<?php if($r->tanggal_resi >= "2020-08-22" || $r->id_resi_udara == 297 ){
						$berat = $r->berat_pembulatan;
					}else{
						$berat = $r->berat_pembulatan;
					}
					echo $berat; ?> kg
				</td>
				<td class="tdcenter"><font color="black">
				<?php echo "Rp ". number_format($r->harga_jual); ?>
				</td>
				<td class="tdcenter"><font color="black">
				<?php echo "Rp ". number_format($r->harga_jual * $beratudara); ?>
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
		  <?php if($r->harga_ekspedisi_lokal > 0){ ?>
			<tr>
				<td colspan="5"><center>Ekspedisi Lokal</center></td>
				<td style="height: 30px;"><?php echo "Rp.". number_format($r->harga_ekspedisi_lokal) ?></td>
			</tr>
			<?php } ?>
			<?php
			    $potongan_resi_udara = $this->db->where("id_invoice",$r->id_invoice)->where("tipe_potongan",null)->get('potongan')->result();

			    foreach($potongan_resi_udara as $row_pot){

			?>
          <tr>
	    			<td colspan="5"><center><?php echo $row_pot->keterangan_potongan ?></center></td>
	    			<td style="height: 30px;"><?php echo "Rp.". number_format($row_pot->jumlah_potongan) ?></td>
    			</tr>
    	<?php } ?>
			<?php
			    $sub_pembayaran_inv = $this->db->where("id_invoice",$r->id_invoice)->where("tipe_sub",null)->get('sub_pembayaran')->result();
					$total_sub = 0;
			    foreach($sub_pembayaran_inv as $row_sub){

			?>
          <tr>
	    			<td colspan="5"><center>Sub Pembayaran</center></td>
	    			<td style="height: 30px;"><?php echo "Rp.". number_format($row_sub->jumlah_bayar_sub) ?></td>
    			</tr>

    	<?php $total_sub +=$row_sub->jumlah_bayar_sub; } ?>
			<tr>
			<td colspan="5"><center><b>TOTAL</b></center></td>
			<td style="height: 30px;"><b><?php echo "Rp ". number_format($r->total_tagihan-$total_sub); ?></b></td>
			</tr>





			</table>

	<p> <font color="black"> <b>INFO PEMBAYARAN</b></font> </p>
		<div class="terbilang">
			<div class="border_table">
				<table  width="100%" cellpadding="3" cellspacing="0">
					<tr>
						<td>BANK NAME</td>
						<td>:</td>
						<td> BCA (Bank Central Asia) </td>
					</tr>
					<tr>
						<td>BANK BRANCH</td>
						<td>:</td>
						<td> KCP Mega Mal Pluit </td>
					</tr>
					<tr>
						<td>BANK ACCOUNT NUMBER</td>
						<td>:</td>
						<td> 5810557747 </td>
					</tr>
					<tr>
						<td>BANK ACCOUNT NAME</td>
						<td>:</td>
						<td> GUSMAVIN WILLOPO </td>
					</tr>
				</table>
		 </div>
	</div>

	<p> <font color="black"> <b>STATUS INVOICE</b></font> </p>
		<div class="terbilang">
			<div class="border_table">
		<?php if($r->status_invoice==1){
			        if($status==1){
			 ?>

			 <p><br/><font color="black">&nbsp;&nbsp;&nbsp; SUDAH TERBAYAR</font><br/></p>

			<?php }else{ ?>

			<p><br/><font color="black">&nbsp;&nbsp;&nbsp; BELUM TERBAYAR</font><br/></p>

			<?php   }
		}else{ ?>
			        <p><br/><font color="black">&nbsp;&nbsp;&nbsp; BELUM TERBAYAR</font><br/></p>
		<?php } ?>

		 </div>
	</div>



			<div class="cleaner_h10"></div>
		</div>
	</div>
