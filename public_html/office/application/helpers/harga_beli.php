<?php

$id_invoice      = $ils->id_invoice;
$status_berat    = $ils->status_berat;
$jenis_barang_id = $ils->jenis_barang_id;
$jumlahctns      = $ils->jumlah;
$kurs            = $ils->kurs;
$perbandingan    = $jumlahctns / $ils->ctns;
$volume          = $jumlahctns * $ils->volume;
$berat           = $jumlahctns * $ils->berat;
$nilaibarangrmb  = $jumlahctns * $ils->qty * $ils->nilai;
$nilaibarang     = $nilaibarangrmb * $kurs;
$hargafreight    = $ils->harga;

if (($berat/$volume > 600) && $status_berat == 1){
    $weight_new = ((($berat/$volume) - 600) / 2000) * $volume;
    $volume_new = $volume + $weight_new;

    $harga = $volume_new * $hargafreight;
    $hargasatuan = $harga / $berat;
}else{
    $hargasatuan = $hargafreight;
    $harga = $volume * $hargafreight;
}
$totalsamping = $harga;
$jumlah += $totalsamping;

$total = $jumlah ;
