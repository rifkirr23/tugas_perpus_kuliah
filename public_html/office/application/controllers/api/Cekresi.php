<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cekresi extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->model('Mgiw');
	}

	function index(){
		// echo $dataresi->statusgiw;
		$this->template->load('template_cekresi','cekresi/index'. $dataresi);
	}
	function json(){
		$resi=$this->input->post('resi');
		$marking=$this->input->post('marking');
		$dataresi=$this->Mgiw->cekresi($resi,$marking);
		$detailgiw=$this->Mgiw->detailgiw($resi,$marking);
		// dd($dataresi);
		$output ='';
		// print_r($dataresi);die();
		if(empty($dataresi->id_resi)){
			$output .= '<div id="hasilresi"><div id="resiNull" class="data-null">
							<div class="data-null-img">
								<img src="'.base_url().'assets/resi/gambar/tidak-ditemukan.png" alt="not found">
							</div>
							<div class="data-null-text">
								<h3>Resi Tidak Ditemukan!</h3>
								<p>Data tidak ditemukan, mohon periksa kembali nomor resi anda.</p>
							</div>
						</div></div>';
		}else{
				$output .= '<div id="hasilresi">
				<div class="judul-kontainer">
					<h3 class="judul-noresi">Hasil Resi No. : <span>'.$resi.'</span></h3>
					<a href="#" onClick="cekresi()" class="link-refresh">Refresh Data</a>
				</div>
				<!-- Tabel Barang -->
				<div class="tabel-info">
					<table class="table table-borderless tabel-info-user">
						<tbody>
							<tr>
								<td class="w-25">No. Resi</td>
								<td>'.$resi.'</td>
							</tr>
							<tr>
								<td class="w-25">Kode Marking</td>
								<td>'.$dataresi->customerkode.'</td>
							</tr>
							<tr>
								<td>Nama</td>
								<td>'.$dataresi->customernama.'</td>
							</tr>
							<tr>
								<td>Alamat</td>
								<td>'.$dataresi->customeralamat.'</td>
							</tr>
							<tr>
								<td>Phone</td>
								<td>'.$dataresi->customertelepon.'</td>
							</tr>
						</tbody>
					</table>
					<div class="tabel-data">
                    <table class="table table-borderless table-hover table-striped tabel-resi">
						<thead>
							<tr>
								<th scope="col">Resi</th>
								<th scope="col">Barcode</th>
								<th scope="col">Goods</th>
								<th scope="col">CTNS</th>
								<th scope="col">QTY</th>
								<th scope="col">Weight</th>
								<th scope="col">RMB</th>
								<th scope="col">Volume</th>
							</tr>
						</thead>
						<tbody>';
						$jumctns=0; $jumpcs=0; $jumkg=0; $jumrmb=0; $jumvolume=0;
						foreach($detailgiw->result() as $dg){
						    $jumctns +=$dg->ctns; $jumpcs +=$dg->qty.'/'.$dg->qty*$dg->ctns; $jumkg +=$dg->berat.'/'.$dg->berat*$dg->ctns; $jumrmb +=$dg->nilai.'/'.$dg->nilai*$dg->ctns;
								$jumvolume +=$dg->volume*$dg->ctns;
				$output .='<tr>
								<td>'.$resi.'</td>
								<td>'.$dg->nomor.'</td>
								<td>'.$dg->barang.'</td>
								<td>'.$dg->ctns.'</td>
								<td>@'.$dg->qty.'/'.$dg->qty*$dg->ctns.' pcs</td>
								<td>@'.$dg->berat.'/'.$dg->berat*$dg->ctns.' kg</td>
								<td>@'.$dg->nilai.'/'.$dg->nilai*$dg->ctns.' RMB</td>
								<td>@'.$dg->volume.'/'.$dg->volume*$dg->ctns.' m3</td>
							</tr>';
						}
						$output .='<tfoot>
                        <tr>
                            <td colspan="3">Total</td>
                            <td>'.$jumctns.'</td>
                            <td>'.$jumpcs.' pcs</td>
                            <td>'.$jumkg.' kg</td>
                            <td>'.$jumrmb.' RMB</td>
                            <td>'.$jumvolume.' m3</td>
                        </tr>
                    </tfoot>';

				$output .='</tbody>
					</table>
					</div>
				</div>
                <!--end tabel barang -->
				<!-- <div class="spacer-border"></div> -->
				<div class="isi-dataresi">
					<ul class="list-timeline">';
			if($dataresi->statusfix >= '1'){
				$output .='<li class="li-timeline timeline-garis">
								<div class="item-timeline">
									<p class="tgl-resi"><span>'.$dataresi->tanggal.'</span></p>
									<h3 class="lokasi-resi">Tiba di <span>Gudang China</span></h3>
									<p class="detail-resi">Barang sudah diterima di warehouse china</p>
								</div>
							</li>';
			}
			if($dataresi->statusfix >= '2'){
				$output .='<li class="li-timeline timeline-garis">
								<div class="item-timeline">
										<p class="tgl-resi"><span>'.$dataresi->tanggal_loading.'</span></p>
									<h3 class="lokasi-resi">Loading Container di Gudang China</h3>
									<p class="detail-resi">Barang Sedang dimuat kedalam Container di China.</p>
								</div>
							</li>';
			}
			if($dataresi->statusfix >= '3' and !empty($dataresi->tgl_closing)){
				$output .='<li class="li-timeline timeline-garis">
								<div class="item-timeline">
										<p class="tgl-resi"><span>'.$dataresi->tgl_closing.'</span></p>
									<h3 class="lokasi-resi">Closing Container di Gudang China</h3>
									<p class="detail-resi">Barang Akan Segera dikirimkan di pelabuhan.</p>
								</div>
							</li>';
			}
			if($dataresi->statusfix >= '4'){
				$output .='<li class="li-timeline timeline-garis">
								<div class="item-timeline">
										<p class="tgl-resi"><span>'.$dataresi->tanggal_berangkat.'</span></p>
									<h3 class="lokasi-resi">Container OTW</h3>
									<p class="detail-resi">Barang dalam pengiriman ke warhouse di jakarta</p>
								</div>
							</li>';
			}
			if($dataresi->statusfix >= '5' and !empty($dataresi->tgl_eta)){
				$output .='<li class="li-timeline timeline-garis">
								<div class="item-timeline">
										<p class="tgl-resi"><span>'.$dataresi->tgl_eta.'</span></p>
									<h3 class="lokasi-resi">Container ETA</h3>
									<p class="detail-resi"></p>
								</div>
							</li>';
			}
			if($dataresi->statusfix >= '6' and !empty($dataresi->tgl_antri_kapal)){
				$output .='<li class="li-timeline timeline-garis">
								<div class="item-timeline">
										<p class="tgl-resi"><span>'.$dataresi->tgl_antri_kapal.'</span></p>
									<h3 class="lokasi-resi">Container Antri Kapal</h3>
									<p class="detail-resi"></p>
								</div>
							</li>';
			}
			if($dataresi->statusfix >= '7' and !empty($dataresi->tgl_atur_kapal)){
				$output .='<li class="li-timeline timeline-garis">
								<div class="item-timeline">
										<p class="tgl-resi"><span>'.$dataresi->tgl_atur_kapal.'</span></p>
									<h3 class="lokasi-resi">Container Atur Kapal</h3>
									<p class="detail-resi"></p>
								</div>
							</li>';
			}
			if($dataresi->statusfix >= '8' and !empty($dataresi->tgl_est_dumau)){
				$output .='<li class="li-timeline timeline-garis">
								<div class="item-timeline">
										<p class="tgl-resi"><span>'.$dataresi->tgl_est_dumau.'</span></p>
									<h3 class="lokasi-resi">Container Estimasi Dumai</h3>
									<p class="detail-resi"></p>
								</div>
							</li>';
			}
			if($dataresi->statusfix >= '9' and !empty($dataresi->tgl_pib)){
				$output .='<li class="li-timeline timeline-garis">
								<div class="item-timeline">
										<p class="tgl-resi"><span>'.$dataresi->tgl_pib.'</span></p>
									<h3 class="lokasi-resi">Container PIB</h3>
									<p class="detail-resi"></p>
								</div>
							</li>';
			}
			if($dataresi->statusfix >= '10' and !empty($dataresi->tgl_notul)){
				$output .='<li class="li-timeline timeline-garis">
								<div class="item-timeline">
										<p class="tgl-resi"><span>'.$dataresi->tgl_notul.'</span></p>
									<h3 class="lokasi-resi">Container NOTUL</h3>
									<p class="detail-resi"></p>
								</div>
							</li>';
			}
			if($dataresi->statusfix >= '11' and !empty($dataresi->tanggal_monitoring)){
				$output .='<li class="li-timeline timeline-garis">
								<div class="item-timeline">
										<p class="tgl-resi"><span>'.$dataresi->tanggal_monitoring.'</span></p>
									<h3 class="lokasi-resi">Container Monitoring</h3>
									<p class="detail-resi">Barang sudah Sudah Bisa di Monitoring</p>
								</div>
							</li>';
			}
			if($dataresi->statusfix >= '12' and !empty($dataresi->tanggal_tiba)){
				$output .='<li class="li-timeline timeline-garis">
								<div class="item-timeline">
										<p class="tgl-resi"><span>'.$dataresi->tanggal_tiba.'</span></p>
									<h3 class="lokasi-resi">Tiba di Warehous Jakarta</h3>
									<p class="detail-resi">Barang sudah diterima di warehouse jakarta</p>
								</div>
							</li>';
			}
			if($dataresi->statusfix >= '13'){
				$output .='<li class="li-timeline timeline-garis">
								<div class="item-timeline">
										<span class="tgl-resi"></span>
									<h3 class="lokasi-resi">Invoice / Proses Pengiriman</h3>
									<p class="detail-resi">Dalam proses pembayaran / Pengiriman dari Gudang Jakarta</p>
								</div>
							</li>';
			}

			if($dataresi->statusfix < '13'){
				$output .='<li class="li-timeline timeline-garis">
								<a href="#" onClick="cekresi()" class="item-timeline last-load">Refresh Data</a>
							</li>';
			}else{
				$output .='<li class="li-timeline timeline-garis">
								<a class="item-timeline last-load disable">Refresh Data</a>
							</li>';
			}
				$output .='</ul>
					</div>
				</div>';
		}
	 echo $output;

	}

}
