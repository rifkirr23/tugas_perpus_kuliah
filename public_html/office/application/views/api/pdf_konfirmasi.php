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

	<table width="100%">
		<tr>
			<td width="200px"><font size="7" color="black"><b>WILOPO CARGO</b></font></td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><img src="<?php echo base_url() ?>assets/logo2.jpg" class="logo"></td>
</tr>
<tr>
	<td width="200px"><font color="black">
	 <?php echo alamat_pdf(); ?>
	</font>
	</td>
	<td width="10px">&nbsp;</td>
	<td>
		<font size="5" color="black">
		<b>RESI #</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		: 		  &nbsp;&nbsp;&nbsp;
		<?php echo $resi['nomor'] ?>
		</font>

		<p>
			<font size="5" color="black">
		<b> DATE </b> 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		: 		&nbsp;&nbsp;&nbsp;
		<?php echo date_indo($resi['tanggal']) ?>
		</font>
		</p>
	</td>
</tr>
</table>


		<font size="5">--------------------------------------------------------------</font>
		<font size="6" color="black">DETAIL RESI  </font>
		<font size="5">-------------------------------------------------------------</font>

		<p></p>

		<div id="body">
		<p> <font color="black"> <b>RESI</b></font> </p>
		<div class="customer">
			<div class="border_table">
				<table width="100%" cellpadding="3" cellspacing="0">



				<tr><td width="180"> <font color="black"> Kode Mark Customer</td><td width="20">:</td><td><label>
				<font color="black"><?php echo $resi['kode'] ?></label></td>

				 </tr>

				<tr><td width="180"><font color="black">Supplier</td><td>:</td><td>
				<label><font color="black"><?php echo $resi['supplier'] ?></label></td>
				</tr>

				<tr><td width="180"><font color="black">Supplier Tel</td><td>:</td><td>
				<label><font color="black"><?php echo $resi['tel'] ?></label></td>
				</tr>

			</table>
		 </div>
	</div>
			<div class="cleaner_h5"></div>
			<br>
			<table border="1" cellpadding="4" cellspacing="0" width="100%" style=" border-collapse: collapse;" class="record">

			<tr>

					<td style="height: 25px;" class="tdcenter"><font color="black">BARCODE</font></td>
					<td class="tdcenter"><font color="black">GOODS</font></td>
					<td class="tdcenter"><font color="black">CTNS</font></td>
					<td class="tdcenter"><font color="black">QTY</font></td>
					<td class="tdcenter"><font color="black">WEIGHT</font></td>
					<td class="tdcenter"><font color="black">VOLUME</font></td>
					<td class="tdcenter"><font color="black">RMB</font></td>
					<td class="tdcenter"><font color="black">REMARK</font></td>
			</tr>

			<tr style="display: none;">

			</tr>

					<?php
			   foreach ($barcode as $c ) {

               $mrmb = $c->nilai * $c->ctns * $c->qty;
               $mqty= $c->qty * $c->ctns;
               $mberat= $c->berat * $c->ctns;
               $mvolume= $c->volume * $c->ctns;

               $tctns  +=$c->ctns;
               $tqty   +=$mqty;
               $tberat +=$mberat;
               $tvolume +=$mvolume;
               $trmb +=$mrmb;
					 ?>


			<tr>

				<td style="height: 25px;"><font color="black">
				<?php echo $c->nomor ?>
				</td>
				<td><font color="black">
				<?php echo $c->barang ?>
				</td>
				<td><font color="black"><font color="black">
				<?php echo $c->ctns ?>
				</td>
				<td><font color="black">
				<?php echo "@".$c->qty." / ".$mqty ?> pcs
				</td>
				<td><font color="black">
				<?php echo "@".$c->berat." / ".$mberat ?> kg
				</td>
				<td><font color="black">
				<?php echo "@".$c->volume." / ".$mvolume ?> m<sup>3</sup>
				</td>
				<td><font color="black">
				    <?php echo "@".$c->nilai." / ".$mrmb ?> RMB
				</td>
				<td><font color="black">
				<?php echo $c->remarks ?>
				</td>

			</tr>

			<?php  } ?>
			<tr>
			<td colspan="2"><center><b>TOTAL </b></center></td>
			<td colspan=""><center><b><?php echo $tctns ?> </b></center></td>
			<td colspan=""><center><b><?php echo $tqty ?> pcs</b></center></td>
			<td colspan=""><center><b><?php echo $tberat ?> kg</b></center></td>
			<td colspan=""><center><b><?php echo round_up($tvolume,3) ?> m<sup>3</sup></b></center></td>
			<td colspan=""><center><b><?php echo ceil($trmb) ?> RMB</b></center></td>
			<td style="height: 30px;"></td>
			</tr>





			</table>






			<div class="cleaner_h10"></div>
		</div>
	</div>
