<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calculate extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->model('Mcalculate');
	}

	function index(){
		// echo $dataresi->statusgiw;
		$data['janisbarangnya']= $this->db->get('jenis_barang')->result();
		// foreach($janisbarangnya as $fd){
		// 	echo $fd->namalain;
		// }
		$this->template->load('template_calculate','calculate/index', $data);
	}
	function json(){
		$kategori= $this->input->post('kategori'); 
		$jumlahdus= $this->input->post('jumlahdus');
		$beratdus= $this->input->post('beratdus');
		$panjang= $this->input->post('panjang');
		$lebar= $this->input->post('lebar');
		$tinggi= $this->input->post('tinggi');
		$nilaibarang= preg_replace('/\D/', '',$this->input->post('nilaibarang'));
		$berattotal= $this->input->post('berattotal');
		$jumlahrmb= $this->input->post('jumlahrmb');
		$jumlahcontainer= $this->input->post('jumlahcontainer');
		$nilaibaranglclsea= preg_replace('/\D/', '',$this->input->post('nilaibaranglclsea'));
		
		$tipe= $this->input->post('tipe');

		$this->db->select('jenis_barang.namalain as namalain, jenis_barang.harga as harga');
		$this->db->from('jenis_barang');
		$this->db->where('id',$kategori);
		$janisbarang=$this->db->get()->row(); 
		$detailnya .='';
		if($tipe == 'lclsea'){
			$volumectns=($panjang*$lebar*$tinggi)/1000000;
			$volumejum          = $jumlahdus * $volumectns;     
			$beratjum           = $jumlahdus * $beratdus;
			$weight_new = ((($beratjum/$volumejum) - 600) / 2000) * $volumejum;
          	$volume_new = $volumejum + $weight_new;
			$hitung=$this->Mcalculate->hitung($kategori, $jumlahdus, $beratdus, $panjang, $lebar, $tinggi, $tipe);
			$totalnilaibarangrp = $nilaibaranglclsea;
			$totalvolume = $volumejum;
			$totalkompensasi = $totalvolume * 20000000;

			$selisihasuransi = $totalnilaibarangrp - $totalkompensasi;

			if($selisihasuransi > 0){
				$persentase = ($selisihasuransi/$totalvolume)/10000000;
					if($persentase < 1){
						$persentasebaru = 1;
					}else if(floor($persentase) > 20){
						$persentasebaru = 20;
					}else{
						$persentasebaru = floor($persentase);
					}
				$totalasuransi = $persentasebaru/100 * $selisihasuransi;
			}else{
				$totalasuransi = 0;
			}
			$detailnya .='
			<p class="detail-calk">Detail Kalkulasi</p>
			<ul class="nav nav-tabs kostum-tab">
				<li class="active"><a data-toggle="tab" href="#reguler">Biaya Reguler</a></li>
				<li data-toggle="tooltip" title="Lihat detail"><a data-toggle="tab" class="text-success" href="#asuransi"><i class="fa fa-plus-circle"></i> <strong>Biaya Asuransi</strong></a></li>
			</ul>
			<div class="tab-content">
				<div id="reguler" class="tab-pane fade show active">
					<div class="info-hasil">
						<table class="table table-borderless">
						<tr>
							<td class="w-25 t-label">Kategori Barang</td>
							<td>'.$janisbarang->namalain.'</td>
						</tr>
						<tr>
							<td class="t-label">Harga / CBM</td>
							<td>Rp. '.number_format($janisbarang->harga,0, ',', '.').'</td>
						</tr>
						<tr>
							<td class="t-label">Volume / Jumlah Dus</td>
							<td>'.$panjang.'(P) x '.$lebar.'(L) x '.$tinggi.'(T) / 1000000</td>
							<td>= '.$volumectns.' M<sup>3</sup></td>
						</tr>
						<tr>
							<td class="t-label">Volume</td>
							<td>'.$jumlahdus.' Dus x '.$volumectns.' M<sup>3</sup></td>
							<td>= '.$volumejum.' M<sup>3</sup></td>
						</tr>
						<tr>
							<td class="t-label">Berat</td>
							<td>'.$jumlahdus.' Dus x '.$beratdus.' KG</td>
							<td>= '.$beratjum.' KG</td>
						</tr>';
			if($beratjum/$volumejum > 600){
			$detailnya .='
						<tr>
							<td class="t-label">Berat Baru</td>
							<td>((('.$beratjum.' KG / '.$volumejum.' M<sup>3</sup>) - 600) / 2000) x '.$volumejum.' M<sup>3</sup></td>
							<td>= '.$weight_new.' KG</td>
						</tr>
						<tr>
							<td class="t-label">Volume Baru</td>
							<td>'.$volumejum.' M<sup>3</sup> + '.$weight_new.' KG</td>
							<td>= '.$volume_new.' M<sup>3</sup></td>
						</tr>
						<tr>
							<td class="t-label">Hasil</td>
							<td>'.$volume_new.' M<sup>3</sup> x Rp. '.number_format($janisbarang->harga,0, ',', '.').'</td>
						</tr>
						';
			}else{
				$detailnya .='<tr>
							<td class="t-label">Hasil (berat / volume <= 600)</td>
							<td>'.$volumejum.' M<sup>3</sup> x Rp. '.number_format($janisbarang->harga,0, ',', '.').'</td>
						</tr>';
			}
				$detailnya .='</tbody>
                                </table>
                            </div>';
		}else if ($tipe == 'fcl'){
			$pajak=$nilaibarang*0.3;
			$fee=50000000*$jumlahcontainer;
			$hitung=$pajak+$fee;
			$detailnya .='
					<p class="detail-calk">Detail Kalkulasi</p>
                    <div class="info-hasil">
                        <table class="table table-borderless">
							<tbody>
						<tr>
							<td class="w-25 t-label">Pajak Bea Cukai</td>
							<td>30 % x Rp. '.number_format($nilaibarang,0, ',', '.').'</td>
							<td>= Rp. '.number_format($pajak,0, ',', '.').'</td>
						</tr>
						<tr>
							<td class="t-label">Fee</td>
							<td>Rp. 50.000.000 x '.$jumlahcontainer.'</td>
							<td>= Rp. '.number_format($fee,0, ',', '.').'</td>
						</tr>
						<tr>
							<td class="t-label">Hasil</td>
							<td>Rp. '.number_format($pajak,0, ',', '.').' + Rp. '.number_format($fee,0, ',', '.').'</td>
						</tr>
						</tbody>
                        </table>
                    </div>';
		}else if($tipe == 'lclair'){
			
			if($kategori == '1'){
				$barangnya='UMUM';
				$harganya='200000';
			}else{
				$barangnya='GARMENT';
				$harganya='225000';
			}
			$hitung=$harganya*$berattotal;
			$detailnya .='
				<p class="detail-calk">Detail Kalkulasi</p>
                    <div class="info-hasil">
                        <table class="table table-borderless">
							<tbody>
						<tr>
							<td class="w-25 t-label">Kategori Barang</td>
							<td>'.$barangnya.'</td>
						</tr>
						<tr>
							<td class="t-label">Harga / CBM</td>
							<td>Rp. '.number_format($harganya,0, ',', '.').'</td>
						</tr>
						<tr>
							<td class="t-label">Hasil</td>
							<td>Rp. '.number_format($harganya,0, ',', '.').' x '.$berattotal.' KG</td>
						</tr>
						</tbody>
                        </table>
                    </div>';
		}else{
			$this->db->select('kurs_jual');
			$this->db->from('kurs');
			$kursnya=$this->db->get()->row(); 
			$hitung=($kursnya->kurs_jual)*($jumlahrmb+50);
			$detailnya .='<p class="detail-calk">Detail Kalkulasi</p>
                    <div class="info-hasil">
                        <table class="table table-borderless">
							<tbody>
						<tr>
							<td class="w-25 t-label">Kurs / RMB</td>
							<td>Rp. '.number_format($kursnya->kurs_jual,0, ',', '.').'</td>
						</tr>
						<tr>
							<td class="t-label">Hasil</td>
							<td>Rp. '.number_format($kursnya->kurs_jual,0, ',', '.').' x ('.$jumlahrmb.' +  Fee(50)) ¥</td>
						</tr>
						</tbody>
                        </table>
                    </div>';
		}
		
		//HASIL BAWAH RESUME
		if($tipe != 'lclsea'){
				$output ='<div id="hasilcalculate">
				<div class="frame-hasil buka">
						<div class="inner-hasil">';
							$output .=$detailnya;
							$output .='
							<div class="hasil mt-0">
								<h3 class="judul-hasil">';
							if($tipe == 'titiptransfer'){	
							    $output .='Total Biaya Rupiah Anda';
							}else{
							    $output .='Total Biaya Import Anda'; 
							}
							
							$output .='</h3>
								<h3>Rp. <span>'.number_format($hitung,0, ',', '.').'</span>,-</h3>
							</div>';
								if($tipe == 'titiptransfer'){	
							    $output .='<p class="mb-0 mt-3">Siap untuk titip transfer?</p>';
							}else{
							    $output .='<p class="mb-0 mt-3">Siap untuk import barang?</p>'; 
							}
							
							$output .='<div class="">
								<a class="hubungi-kami" href="https://wilopocargo.com/contact-us/">Hubungi Kami</a>
								<a class="link-ulang" onClick="hu()" href="#"><i class="fa fa-reload"></i> Hitung Ulang</a>
							</div>
						</div>
					</div>
			</div>';
		}else{
			$output ='<div id="hasilcalculate">
				<div class="frame-hasil buka">
						<div class="inner-hasil">';
							$output .=$detailnya;
							$output .='
							 <div class="hasil mt-0">
                                <h3 class="judul-hasil">Total Estimasi Biaya</h3>
                                <h3>Rp. <span>'.number_format($hitung,0, ',', '.').'</span>,-</h3>
                                <h4></h4>
                            </div>
                        </div>
                        <div id="asuransi" class="tab-pane fade ">
                            <div class="info-hasil asuransi">
                                <table class="table table-borderless">
                                    <tbody>
                                    <tr>
                                        <td class="w-25 t-label">Kompensasi (Tercover)</td>
                                        <td>'.$totalvolume.' M<sup>3</sup> * Rp. 20.000.000</td>
										<td>= Rp. '.number_format(@$totalkompensasi,0,',','.').'</td>
                                    </tr>
                                    <tr>
                                        <td class="t-label">Selisih</td>
                                        <td>Rp. '.number_format(@$totalnilaibarangrp,0,',','.').' - Rp. '.number_format(@$totalkompensasi,0,',','.').'</td>
										<td> = Rp. '.number_format(@$selisihasuransi,0,',','.').'</td>
                                    </tr>';
                                    if(@$selisihasuransi > 0){
										$output .='<tr>
											<td class="t-label">Persentase</td>
											<td>(Rp. '.number_format(@$selisihasuransi,0,',','.').' / '.@$totalvolume.') / 10000000</td>
											<td>= '.@$persentasebaru.' %</td>
										</tr>
										<tr>
											<td class="t-label">Asuransi</td>
											<td>'.$persentasebaru.' / 100 * Rp. '.number_format(@$selisihasuransi,0,',','.').'</td>
										</tr>';
									}else{
										$output .='<tr>
											<td class="t-label">Selisih Kurang Dari 0</td>
											<td>= Tidak Ada Tambahan Asuransi</td>
										</tr>';
									}
                              $output .='<tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="hasil asuransi mt-0">
                                <h3 class="judul-hasil">';
                                if($totalasuransi > 0){
                                    $output .='Total Estimasi Biaya Asuransi';
                                }else{
                                    $output .='Tidak Ada Biaya Asuransi Tambahan';
                                }
                            $output .='</h3>
                                <h3 class="text-success">Rp. <span>'.number_format($totalasuransi,0, ',', '.').'</span>,-</h3>
                                <h4></h4>
                            </div>
                        </div>
                    </div>
					<p class="mb-0 mt-3">Siap untuk import barang?</p>
							<div class="">
								<a class="hubungi-kami" href="https://wilopocargo.com/contact-us/">Hubungi Kami</a>
								<a class="link-ulang" onClick="hu()" href="#"><i class="fa fa-reload"></i> Hitung Ulang</a>
							</div>
						</div>
					</div>
			</div>';
		}
		$output .='';
	 echo $output;
		
	}

}
