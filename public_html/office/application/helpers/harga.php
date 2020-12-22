<?php

@$id_invoice     = $ils->id_invoice;
$status_berat    = $ils->status_berat;
$jenis_barang_id = $ils->jenis_barang_id;
$jumlahctns      = $ils->jumlah;
$kurs            = $ils->kurs;
@$perbandingan    = $jumlahctns / $ils->ctns;
$volume          = $jumlahctns * $ils->volume;
$berat           = $jumlahctns * $ils->berat;
$nilaibarangrmb  = $jumlahctns * $ils->qty * $ils->nilai;
$nilaibarang     = $nilaibarangrmb * $kurs;
$hargafreight    = $ils->harga_jual;
@$tesharga        = $ils->harga;

if (($berat/$volume > 600) && $status_berat == 1){
    $weight_new = ((($berat/$volume) - 600) / 2000) * $volume;
    $volume_new = $volume + $weight_new;

    $harga = $volume_new * $hargafreight;
    $hargasatuan = $harga / $berat;
    $stsberat = 1;
}else{
    $hargasatuan = $hargafreight;
    $harga = $volume * $hargafreight;
    $stsberat = 0;
}

$hitungbiaya = $this->db->select('sum(jumlah) as jumlah_biaya,jenis_biaya_tam.nama')
                        ->from('biaya_tambahan')
                        ->join('jenis_biaya_tam','biaya_tambahan.jenis_biaya_tam_id=jenis_biaya_tam.id','left')
                        ->where('giw_id',$ils->idgiw)
                        ->get()->row();
$biayatambahan +=$perbandingan*@$hitungtambahan->jumlah_biaya;
$ketbiaya .= $hitungbiaya->nama." , ";


@$total_volume += $volume;
$totalsamping = $harga;
$jumlah += $totalsamping;


if(@$diskon == 1){
  $harga_diskon    =  $ils->harga_jual - 500000;

  if (($berat/$volume > 600) && $status_berat == 1){
      $weight_new = ((($berat/$volume) - 600) / 2000) * $volume;
      $volume_new = $volume + $weight_new;

      $harga_jual_diskon = $volume_new * $harga_diskon;
      $hargasatuan_jual_diskon = $harga / $berat;
      $stsberat = 1;
  }else{
      $hargasatuan_jual_diskon = $harga_diskon;
      $harga_jual_diskon = $volume * $harga_diskon;
      $stsberat = 0;
  }
  $potongan_diskon = $totalsamping - $harga_jual_diskon;
  $jumlah_diskon += $harga_jual_diskon;
  $total_diskon += $potongan_diskon;
}

$total = $jumlah + @$asuransiinvoice;
