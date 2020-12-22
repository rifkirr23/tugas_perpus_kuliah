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


</style>

	<table width="100%">
		<tr>
			<td width="200px"><font size="7" color="black"><b>WILOPO CARGO</b></font></td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><img src="<?php echo base_url() ?>assets/logo2.jpg" class="logo"></td>
</tr>
<tr>
	<td width="200px"><font color="black">
	 <?php echo alamat_pdf(); ?>
	</td>
	<td width="10px">&nbsp;</td>
	<td>
		<font size="5" color="black">
		<b>INVOICE #</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		: 		  &nbsp;&nbsp;&nbsp;
		<?php echo $record->kode_invoice ?>
		</font>

		<p>
			<font size="5" color="black">
		<b> DATE </b> 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		: 		&nbsp;&nbsp;&nbsp;
		<?php echo date_indo($record->tanggal_invoice) ?>
		</font>
		</p>

		<!-- <p>
			 <font size="5" color="black">
		<b> RESI </b> 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		: 		&nbsp;&nbsp;&nbsp;
		<?php //echo $record->nomor ?>
		</font>
		</p> -->
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
				<font color="black"><?php echo $record->kode; ?></label></td>
				</tr>

				<tr><td width="180"><font color="black">Nama</td><td>:</td><td>
				<label><font color="black"><?php echo $record->nama; ?></label></td>
				</tr>

				<tr><td width="180"><font color="black">Alamat</td><td>:</td><td>
				<label><font color="black"><?php echo $record->alamat; ?></label></td>
				</tr>

				<tr><td width="180"><font color="black">Phone</td><td>:</td><td>
				<label><font color="black"><?php echo $record->whatsapp; ?></label></td>
				</tr>
			</table>
		 </div>
	</div>

			<div class="cleaner_h5"></div>
			<br>
			<table border="1" cellpadding="4" cellspacing="0" width="100%" style=" border-collapse: collapse;" class="record">

			<thead>
			<tr>
					<th><font color="black"><center>RESI</center></font></th>
					<th style="height: 30px;"><font color="black"><center>BARCODE</center></font></th>
					<th><font color="black"><center>GOODS</center></font></th>
					<th><font color="black"><center>KATEGORI</center></font></th>
					<th><font color="black"><center>CTNS</center></font></th>
					<th><font color="black"><center>QTY</center></font></th>
					<th><font color="black"><center>WEIGHT</center></font></th>
					<th><font color="black"><center>RMB</center></font></th>
					<th><font color="black"><center>VOLUME</center></font></th>
					<th><font color="black"><center>FREIGHT</center></font></th>
					<th><font color="black"><center>JUMLAH</center></font></th>
			</tr>
            </thead>
			<tr style="display: none;">

			</tr>
             <tbody>
					<?php
			   foreach ($barcode as $ils ) {

               $harga_barcode = $ils->harga_jual * $ils->jumlah * $ils->volume;
               $mrmb = $ils->nilai * $ils->jumlah * $ils->qty;
               $mqty= $ils->qty * $ils->jumlah;
               $mberat= $ils->berat * $ils->jumlah;
               $mvolume= $ils->volume * $ils->jumlah;
							 $hargafreight    = $ils->harga_jual;
							 $status_berat    = $ils->status_berat;

               $tctns  +=$ils->jumlah;
               $tqty   +=$mqty;
               $tberat +=$mberat;
               $tvolume +=$mvolume;
               $trmb +=$mrmb;
               $tharga +=$ils->harga_jual;
							 include APPPATH. 'helpers/harga.php';
							 $tharga_barcode +=$harga;
					 ?>


			<tr>
				<td><font color="black"><center>
				<?php echo $ils->nomorresi ?>
				</center></td>
				<td style="height: 25px;"><font color="black"><center>
				<?php echo $ils->nomor ?>
				</center></td>
				<td><font color="black"><center>
				<?php echo $ils->barang ?>
				</center></td>
				<td><font color="black"><center>
				<?php echo $ils->namalain ?>
				</center></td>
				<td><font color="black"><center>
				<?php echo $ils->jumlah ?>
				</center></td>
				<td><font color="black"><center>
				@<?php echo $ils->qty." / ".$mqty?> pcs
				</center></td>
				<td><font color="black"><center>
				@<?php echo $ils->berat." / ".$mberat ?> kg
				</center></td>
				<td><font color="black"><center>
				    @<?php echo $ils->nilai." / ".$mrmb ?> RMB
				</center></td>
				<td><font color="black"><center>
				@<?php echo $ils->volume." / ".$mvolume ?> m<sup>3</sup>
				</center></td>
				<td><font color="black"><center>
					<?php
						if($stsberat == 1){
								echo "Rp.". number_format($hargasatuan,2);
						}else{
								echo "Rp.". number_format($hargasatuan);
						}
					?>
				</center></td>
				<td><font color="black"><center>
				<?php echo"Rp.". number_format($harga) ?>
				</center></td>

			</tr>

			<?php  } ?>
			<tr>
			<td colspan="4"><center><font color="black">JUMLAH </center></td>
			<td colspan=""><center><font color="black"><?php echo $tctns ?> </center></td>
			<td colspan=""><center><font color="black"><?php echo $tqty ?> </center></td>
			<td colspan=""><center><font color="black"><?php echo $tberat ?> Kg</center></td>
			<td colspan=""><center><font color="black"><?php echo $trmb ?> RMB</center></td>
			<td colspan=""><center><font color="black"><?php echo $tvolume ?> m<sup>3</sup></center></td>
			<td colspan=""><center><font color="black"> </center></td>
			<td colspan=""><center><font color="black"><?php echo "Rp.". number_format($tharga_barcode) ?> </center></td>
			</tr>

			<?php foreach ($record_asuransi as $asr){ ?>
				<tr>
				<td colspan="10"><center><font color="black">ASURANSI <?php echo $asr->nomor ; ?></center></td>
				<td style="height: 40px;"><center><font color="black"><?php echo "Rp.".number_format($asr->jumlah_asuransi) ?> </center></td>
				</tr>
			<?php } ?>

			<?php foreach ($potongan as $pot){ ?>
				<tr>
				<td colspan="10"><center><font color="black"><?php echo $pot->keterangan_potongan; ?></center></td>
				<td colspan="2" style="height: 40px;"><center><font color="black"><?php echo "Rp.".number_format($pot->jumlah_potongan) ?> </center></td>
				</tr>
			<?php } ?>
			<?php
			    $sub_pembayaran_inv = $this->db->where("id_invoice",$record->id_invoice)->where("tipe_sub",null)->get('sub_pembayaran')->result();
					$total_sub = 0;
			    foreach($sub_pembayaran_inv as $row_sub){

			?>
          <tr>
	    			<td colspan="10"><center>Sub Pembayaran</center></td>
	    			<td style="height: 30px;"><?php echo "Rp.". number_format($row_sub->jumlah_bayar_sub) ?></td>
    			</tr>

    	<?php $total_sub +=$row_sub->jumlah_bayar_sub; } ?>
			<tr>
 			<td colspan="10"><center><font color="black"><b>TOTAL TAGIHAN</b> </center></td>
 			<td colspan="" style="height: 30px;"><center><font color="black"><b><?php echo "Rp.".number_format(($record->total_tagihan - $record->total_potongan) - $total_sub) ?> </b></center></td>
 			</tr>

			</tbody>

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
		<?php if($record->status_invoice==1){
			        if($status==1){
			 ?>

			 <p><br/><font color="black">&nbsp;&nbsp;&nbsp; SUDAH TERBAYAR</font><br/></p>

			<?php }else{ ?>

			<p><br/><font color="black">&nbsp;&nbsp;&nbsp; BELUM TERBAYAR</font><br/></p>

			<?php }
		}else{ ?>
			        <p><br/><font color="black">&nbsp;&nbsp;&nbsp; BELUM TERBAYAR</font><br/></p>
		<?php } ?>




		 </div>
	</div>



			<div class="cleaner_h10"></div>
		</div>
	</div>
