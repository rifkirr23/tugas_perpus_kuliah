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
  					<th style="height: 30px;"><font color="black"><center>Deskripsi</center></font></th>
  					<th><font color="black"><center>Volume</center></font></th>
  					<th><font color="black"><center>Kategori</center></font></th>
  					<th><font color="black"><center>Harga</center></font></th>
  			</tr>
      </thead>
			<tr style="display: none;">

			</tr>
      <tbody>
         <tr>

           <td style="height: 25px;"><font color="black"><center>
             Barang Umum
           </center></td>

           <td><font color="black"><center>
             1.562 m<sup>3</sup>
           </center></td>

           <td><font color="black"><center>
             UMUM (GENERAL)
           </center></td>

           <td><font color="black"><center>
             <?php echo "Rp.". number_format("9372000") ?>
           </center></td>

         </tr>

      <tr>
      <td colspan=""><center><font color="black">TOTAL </center></td>
      <td colspan=""><center><font color="black">1.562 m<sup>3</sup> </center></td>
      <td colspan=""><center><font color="black"> </center></td>
      <td colspan=""><center><font color="black"> <?php echo "Rp.". number_format("9372000") ?></center></td>
      </tr>

      <tr>
      <td colspan="2"><center><font color="black"><b>TOTAL TAGIHAN</b> </center></td>
      <td colspan="2" style="height: 30px;"><center><font color="black"><b><?php echo "Rp.".number_format("9372000") ?> </b></center></td>
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
              <p><font style="font-style:bold;" color="red">&nbsp;&nbsp;&nbsp; Harga yang diberikan masih estimasi</font><br/></p>
		<?php } ?>




		 </div>
	</div>



			<div class="cleaner_h10"></div>
		</div>
	</div>
