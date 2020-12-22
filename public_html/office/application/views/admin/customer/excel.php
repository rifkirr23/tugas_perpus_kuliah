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
		<div id="body">
		  <h3>Data Customer Wilopo Cargo</h3>
			<div class="cleaner_h5"></div>
			<br />
			<table border="1" cellpadding="4" cellspacing="0" width="100%" style=" border-collapse: collapse;" class="record">
  			<tr>
            <td class="tdcenter" style="height: 30px;"><font color="black">No</font></td>
  					<td class="tdcenter" style="height: 30px;"><font color="black">Nama Customer</font></td>
  					<td class="tdcenter"><font color="black">Alamat Email</font></td>
  					<td class="tdcenter"><font color="black">Nomor Hp</font></td>
  			</tr>
  			<tr style="display: none;"></tr>
  			<?php $no=1;
  	       foreach ($data_customer as $dc ) {
             $subwhatsapp = substr($dc->whatsapp,0,1);
             if($subwhatsapp == 0){
               $whatsappcustomer = substr($dc->whatsapp,1);
               $realwhatsapp = "62".$whatsappcustomer;
             }else{
               $realwhatsapp = $dc->whatsapp;
             }
  			 ?>
  			<tr>
  				<td style="height: 50px;"><font color="black">
  				<?php echo $no; ?>
  				</td>
  				<td style="height: 50px;"><font color="black">
  				<?php echo $dc->nama; ?>
  				</td>
          <td style="height: 50px;"><font color="black">
  				<?php echo $dc->email; ?>
  				</td>
          <td style="height: 50px;"><font color="black">
  				<?php echo $realwhatsapp; ?>
  				</td>
  			</tr>
  			<?php  $no++; } ?>
			</table>

		</div>
	</div>
