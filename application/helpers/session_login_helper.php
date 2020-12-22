<?php

function cek_session()
{
		$ci= & get_instance();
	 	$session= $ci->session->userdata('id_pengguna');
	 	$level= $ci->session->userdata('level');
	if ($session ==0 || $level=="admin2" || $level=="") {
		# code...
	?> <script>

	        alert('Please Re-Login');
	        window.location = "<?php print site_url();?>login";

	</script> <?php
	}
}

function session_suadmin()
{
		$ci= & get_instance();
	 	$session= $ci->session->userdata('id_pengguna');
	 	$level= $ci->session->userdata('level');
		if ($level!="suadmin") {
			# code...
		?> <script>

		        alert('Tidak mempunyai Akses');
		        window.location = "<?php print site_url();?>login";

			 </script> <?php
		}
}

function cek_session_all()
{
		$ci= & get_instance();
	 	$session= $ci->session->userdata('id_pengguna');
	 	$level= $ci->session->userdata('level');
	if ($session ==0  || $level=="") {
		# code...
	?> <script>

	        alert('Please Re-Login');
	        window.location = "<?php print site_url();?>login";

	</script> <?php
	}
}



 function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " Belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." Puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " Seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " Ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " Seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " Ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " Juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " Milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " Trilyun" . penyebut(fmod($nilai,1000000000000));
		}
		return $temp;
	}

 function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim(penyebut($nilai));
		} else {
			$hasil = trim(penyebut($nilai));
		}
		return $hasil;
	}
