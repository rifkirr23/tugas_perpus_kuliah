<?php
/**
*
*/
class Mcalculate extends CI_Model
{

    function hitung($kategori, $jumlahdus, $beratdus, $panjang, $lebar, $tinggi, $tipe){

      $volumeperctns= ($tinggi * $panjang * $lebar) / 1000000; 
      $this->db->select('jenis_barang.*');
      $this->db->from('jenis_barang');
      $this->db->where('id',$kategori);
      $janisbarangnya=$this->db->get()->row(); 
        $volume          = $jumlahdus * $volumeperctns;     
        $berat           = $jumlahdus * $beratdus;
        $hargafix        = ($jumlahdus * $volumeperctns) * $janisbarangnya->harga;
        $hargafix=0;
        if ($berat/$volume > 600){
          $weight_new = ((($berat/$volume) - 600) / 2000) * $volume;
          $volume_new = $volume + $weight_new;
          $hargafix   = $volume_new * $janisbarangnya->harga;
        }else{
          $hargafix = $volume * $janisbarangnya->harga;
        }

        return $hargafix;
    }
    
}
