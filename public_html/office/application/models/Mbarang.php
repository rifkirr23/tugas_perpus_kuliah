<?php
/**
*
*/
class Mbarang extends CI_Model
{
    function data_resi($nresi){
      $this->db->select('resi.*,customer.*,customer_grup.*');
      $this->db->from('resi');
      $this->db->join('customer', 'resi.cust_id=customer.id_cust', 'left');
      $this->db->join('customer_grup', 'customer.id_cgrup=customer_grup.id_cgrup', 'left');
      $this->db->where('resi.nomor',$nresi);
      return $this->db->get('');
    }

    function data_resiid($id){
      $this->db->select('resi.*,customer.*,customer_grup.*');
      $this->db->from('resi');
      $this->db->join('customer', 'resi.cust_id=customer.id_cust', 'left');
      $this->db->join('customer_grup', 'customer.id_cgrup=customer_grup.id_cgrup', 'left');
      $this->db->where('resi.id_resi',$id);
      return $this->db->get('');
    }

    function data_resirts($id){
      $this->db->select('resi.*,customer.*');
      $this->db->from('resi');
      $this->db->join('customer', 'resi.cust_id=customer.id_cust', 'left');
      $this->db->where('resi.id_resi_rts',$id);
      return $this->db->get('');
    }

    function dataresiresend(){
      $this->db->select('resi.*,customer.*');
      $this->db->from('resi');
      $this->db->join('customer', 'resi.cust_id=customer.id_cust', 'left');
      $this->db->where('resi.id_resi >=',1343);
      $this->db->where('resi.konfirmasi_resi',0);
      $this->db->where('resi.tanggal >=',"2019-03-14");
      return $this->db->get('');
    }

  function data_hb($id){

    $this->db->where('id',$id);
    return $this->db->get('jenis_barang');

  }

  function data_hbc($id_cust,$id_jenis_barang){
    $this->db->where('id_jenis_barang',$id_jenis_barang);
    $this->db->where('id_cust',$id_cust);
    $this->db->where('harga >',0);
    return $this->db->get('jenis_barang_customer');
  }

  function data_hbcg($id_cgrup,$id_jenis_barang){
    $this->db->where('id_jenis_barang',$id_jenis_barang);
    $this->db->where('id_cgrup',$id_cgrup);
    $this->db->where('harga >',0);
    return $this->db->get('jenis_barang_customer');
  }

  function resi_nomor($nresi){

    $this->db->select('resi.*');
    $this->db->from('resi');
    $this->db->where('resi.nomor',$nresi);

    return $this->db->get('');
  }


 public function resi_encrypt($n){

    $this->db->select('resi.*,customer.*,customer_grup.*');
    $this->db->from('resi');
    $this->db->join('customer', 'resi.cust_id=customer.id_cust', 'left');
    $this->db->join('customer_grup', 'customer.id_cgrup=customer_grup.id_cgrup', 'left');
    $this->db->where('resi.encrypt_resi',$n);
    return $this->db->get('');

  }

  public function data_customer($n){
    $this->db->select('customer.*,customer_grup.*');
    $this->db->from("customer");
    $this->db->where('customer.kode',$n);
    $this->db->join('customer_grup', 'customer.id_cgrup=customer_grup.id_cgrup', 'left');
    return $this->db->get();
  }

  function data_brcd($nresi){

    $this->db->select('giw.*,jenis_barang.nama,jenis_barang.namalain,jenis_barang.harga,resi.id_resi_rts,
                       resi.nomor as nomor_resi,customer.jalur as jalurcust');
    $this->db->from('giw');
    $this->db->join('jenis_barang','giw.jenis_barang_id=jenis_barang.id','left');
    $this->db->join('resi','giw.resi_id=resi.id_resi','left');
    $this->db->join('customer','giw.customer_id=customer.id_cust','left');
    $this->db->where('giw.resi_id',$nresi);
    return $this->db->get('');

  }

  function data_brcd2($nresi){

    $this->db->select('giw.*,jenis_barang.nama,jenis_barang.namalain,jenis_barang.harga,resi.id_resi_rts');
    $this->db->from('giw');
    $this->db->join('jenis_barang','giw.jenis_barang_id=jenis_barang.id','left');
    $this->db->join('resi','giw.resi_id=resi.id_resi','left');
    $this->db->limit(15);
    $this->db->where('giw.resi_id',$nresi);
    return $this->db->get('');

  }

   function data_barcode($id){
    $this->db->where('resi_id',$id);
    $this->db->order_by('id','asc');
    return $this->db->get('giw');
  }

  function barcode_array($id){
    $this->db->select('giw.*,resi.id_resi,resi.nomor as nresi');
    $this->db->from('giw');
    $this->db->join('resi','giw.resi_id=resi.id_resi','left');
    $this->db->where_in('giw.nomor',$id);
    return $this->db->get('');
 }

 function barcode_nomor($id){
   $this->db->select('giw.*,resi.nomor as nomor_resi,customer.whatsapp,customer.kode');
   $this->db->join('resi','giw.resi_id=resi.id_resi','left');
   $this->db->join('customer','giw.customer_id=customer.id_cust','left');
   $this->db->where('giw.nomor',$id);
   return $this->db->get('giw');
 }

 function giw_byresi($id,$resi_id){
   $this->db->select('giw.*,resi.nomor as nomor_resi,customer.whatsapp,customer.kode');
   $this->db->join('resi','giw.resi_id=resi.id_resi','left');
   $this->db->join('customer','giw.customer_id=customer.id_cust','left');
   $this->db->where('giw.nomor',$id);
   $this->db->where('giw.resi_id',$resi_id);
   return $this->db->get('giw');
 }

 function giw_byresiarray($id,$resi_id){
   $this->db->select('giw.*,resi.nomor as nomor_resi,customer.whatsapp,customer.kode');
   $this->db->join('resi','giw.resi_id=resi.id_resi','left');
   $this->db->join('customer','giw.customer_id=customer.id_cust','left');
   $this->db->where_in('giw.nomor',$id);
   $this->db->where('giw.resi_id',$resi_id);
   return $this->db->get('giw');
 }

  function barcode_container($id,$resi_id){
    $this->db->select('giw.*,resi.nomor as nomor_resi,customer.whatsapp,customer.kode');
    $this->db->join('resi','giw.resi_id=resi.id_resi','left');
    $this->db->join('customer','giw.customer_id=customer.id_cust','left');
    $this->db->where('giw.container_id',$id);
    $this->db->where('giw.resi_id',$resi_id);
    return $this->db->get('giw');
  }

 public function code_invoice_barang(){
     $cekkode= $this->db->query("SELECT kode_invoice as maxkode FROM invoice  where tipe_invoice='barang' order by id_invoice desc limit 1")->result();
     foreach($cekkode as $hcekkode);
     $kodesaatini= $hcekkode->maxkode;
     $ambilkode= str_replace('INVOICE/BRG/','',$kodesaatini);
     if($ambilkode=="")
     {
      $ambilkode=0;
     }
     $kodejadi= $ambilkode+1;

     $hasil= $kodejadi;
     return 'INVOICE/BRG/'.$hasil;
 }

    function insert_barcode($barang,$nomor_brcd,$idc,$id_jenis_barang,$ctns,$qty,$berat,$volume,$nilai,$status,$note,$asuransi,
          $kurs,$remarks,$harga,$resi_id,$status_berat,$hb,$jalur,$packing_fare,$fare,$biaya_lain,$kurs_fare,$bm,$tax_import,$fee){

        $data_brcd= $this->barcode_nomor($nomor_brcd);

        if($data_brcd->num_rows() > 0){
          die();
        }else{

         $insert_brcd['barang']= $barang;
         $insert_brcd['nomor']=  $nomor_brcd;
         $insert_brcd['customer_id']= $idc;
         $insert_brcd['jenis_barang_id']=  $id_jenis_barang;
         $insert_brcd['container_id']=  0;
         $insert_brcd['ctns']= $ctns;
         $insert_brcd['qty']=  $qty;

         $insert_brcd['berat']= $berat;
         $insert_brcd['volume']=  $volume;
         $insert_brcd['nilai']= $nilai;
         $insert_brcd['status']=  $status;
         $insert_brcd['note']= $note;

         $insert_brcd['kurs']= $kurs;
         $insert_brcd['remarks']=  $remarks;
         $insert_brcd['harga']= $harga;
         $insert_brcd['packing_fare']= $packing_fare;
         $insert_brcd['fare']= $fare;
         $insert_brcd['biaya_lain']= $biaya_lain;
         $insert_brcd['kurs_fare']= $kurs_fare;
         $insert_brcd['bm']= $bm;
         $insert_brcd['tax_import']= $tax_import;
         $insert_brcd['fee']= $fee;
         $insert_brcd['resi_id']=  $resi_id;
         $insert_brcd['harga_jual']=  $hb;
         $insert_brcd['status_berat']= $status_berat;
         $insert_brcd['jalur']= $jalur;
         $insert_brcd['status_jalur']= 0;
         $this->db->insert('giw', $insert_brcd);
    }


  }

function insert_resi($eid,$id_resi_rts,$kd,$nomor_resi,$tanggal_resi,$supplier,$tel,$note,$kf,$gdg,$id_request_resi){

      $data_r= $this->resi_nomor($nomor_resi);

      if($data_r->num_rows()>0){
         $brg['validasi_email']= 2;
         $this->db->where('nomor',$nomor_resi);
         $this->db->update('resi', $brg);
      }else{

         $insert_brg['id_resi_rts']= $id_resi_rts;
         $insert_brg['encrypt_resi']= $eid;
         $insert_brg['nomor']= $nomor_resi;
         $insert_brg['cust_id']= $kd;
         $insert_brg['tanggal']= $tanggal_resi;
         $insert_brg['supplier']= $supplier;
         $insert_brg['tel']= $tel;
         $insert_brg['note']= $note;
         $insert_brg['konfirmasi_resi']= $kf;
         $insert_brg['gudang']= $gdg;
         $insert_brg['validasi_email']= 1;
         $this->db->insert('resi', $insert_brg);
      }

      if($id_request_resi > 0){
        $update_status_pl['nomor_resi'] = $nomor_resi;
        $update_status_pl['status_proses'] = 4;
        $this->db->where('id_request_resi',$id_request_resi)->update('file_packing',$update_status_pl);
      }

   }
   
   function deadline_status($resi_id, $container_id, $date, $status_giw_id, $tipe_resi){
       if($resi_id > 0){
           $cekdeadline=$this->db->select('id')->from('deadline_status')->where('deadline_status.resi_id', $resi_id)->where('deadline_status.tipe_resi', $tipe_resi)->get()->row();
           if(@$cekdeadline->id > 0){
                    $updatedeadline['date'] = $date;
                    $this->db->where('id',$cekdeadline->id)->update('deadline_status',$updatedeadline);
           }else{
                    $jumhari=$this->db->select('hari')->from('status_resi')->where('id', $tipe_resi)->get()->row();
                       $insertdeadline['date']= $date;
                       $insertdeadline['resi_id']= $resi_id;
                       $insertdeadline['tipe_resi']= $tipe_resi;
                       $insertdeadline['jum_hari']= $jumhari->hari;
                       $this->db->insert('deadline_status',$insertdeadline);
           }
       }else if($container_id > 0){
           $statusgiw=$this->db->select('id')->from('status_giw')->where('status_giw.id_rts', $status_giw_id)->get()->row();
          $cekdeadline=$this->db->select('id')->from('deadline_status')->where('deadline_status.container_id', $container_id)->where('deadline_status.status_giw_id', $statusgiw->id)->get()->row();
          if(@$cekdeadline->id > 0){
                    $updatedeadline['date'] = $date;
                    $this->db->where('id',$cekdeadline->id)->update('deadline_status',$updatedeadline);
          }else{
                    $jumhari=$this->db->select('hari')->from('status_giw')->where('id', $statusgiw->id)->get()->row();
                      $insertdeadline['date']= $date;
                      $insertdeadline['container_id']= $container_id;
                      $insertdeadline['status_giw_id']= $status_giw_id;
                      $insertdeadline['jum_hari']= $jumhari->hari;
                      $this->db->insert('deadline_status',$insertdeadline);
          }
       }
       
   }
   function history_status_gudang($resi_id, $container_id, $date, $status_giw_id, $giw_id, $tipe_delay){
                      $statusgiw=$this->db->select('id')->from('status_giw')->where('status_giw.id_rts', $status_giw_id)->get()->row();
                      $jumhari=$this->db->select('hari')->from('status_giw')->where('id', $statusgiw->id)->get()->row();
                      
                      $insertdeadline['tanggal']= $date;
                      $insertdeadline['resi_id']= $resi_id;
                      $insertdeadline['status_giw_id']= $status_giw_id;
                      $insertdeadline['giw_id']= $giw_id;
                      $insertdeadline['hari']= $jumhari->hari;
                      $insertdeadline['tipe_delay']= $tipe_delay;
                      $this->db->insert('history_date_gudang',$insertdeadline);
   }
   function history_status($resi_id, $container_id, $date, $status_giw_id, $tipe_resi, $tipe_delay){
                if(@$container_id > 0){
                      $statusgiw=$this->db->select('id')->from('status_giw')->where('status_giw.id_rts', $status_giw_id)->get()->row();
                      $jumhari=$this->db->select('hari')->from('status_giw')->where('id', $statusgiw->id)->get()->row();
                      
                      $insertdeadline['tanggal']= $date;
                      $insertdeadline['container_id']= $container_id;
                      $insertdeadline['resi_id']= $resi_id;
                      $insertdeadline['status_giw_id']= $status_giw_id;
                      $insertdeadline['tipe_resi']= $tipe_resi;
                      $insertdeadline['hari']= $jumhari->hari;
                      $insertdeadline['tipe_delay']= $tipe_delay;
                      $this->db->insert('history_date_container',$insertdeadline);
                }else if($resi_id > 0){
                      $jumhari=$this->db->select('hari')->from('status_resi')->where('id', $tipe_resi)->get()->row();
                      $insertdeadline['tanggal']= $date;
                      $insertdeadline['container_id']= $container_id;
                      $insertdeadline['resi_id']= $resi_id;
                      $insertdeadline['status_giw_id']= $status_giw_id;
                      $insertdeadline['tipe_resi']= $tipe_resi;
                      $insertdeadline['hari']= $jumhari->hari;
                      $insertdeadline['tipe_delay']= $tipe_delay;
                      $this->db->insert('history_date_status',$insertdeadline);
                }
                      
   }
   function add_to_container($data){
      $insert['status']= 2;
      $insert['container_id']= $this->input->post('container_id');
      $this->db->where_in('nomor', $this->input->post('nomor_giw'));
      $this->db->update('giw',$insert);

      // tipe container
      $containerdari = $this->input->post('containerdari');
      //sendwhatsapp("add to container","083815423599");
      $barcodebyresi = $this->db->select('giw.*,customer.kode,resi.nomor as nomor_resi,customer.whatsapp,customer.id_pendaftar')->from('giw')->join('customer','giw.customer_id=customer.id_cust','left')
                                ->join('resi','giw.resi_id=resi.id_resi','left')->where_in('giw.nomor',$this->input->post('nomor_giw'))->group_by('giw.resi_id')->get()->result();
      foreach ($barcodebyresi as $bbr) {
        $id_pendaftar = $bbr->id_pendaftar;
        $pesan = "";
        $pesanfor = "";
        if($bbr->status_jalur == 0){
          if($bbr->jalur != 1){
            $konfirmasimessage = "(Automatically) Anda Berhasil Konfirmasi ".$bbr->nomor_resi." \nTerimakasih \n\n*Wilopo Cargo* _(do not reply)_";
          }else if($bbr->jalur == 1){
            $konfirmasimessage = "(Automatically) Anda Berhasil Konfirmasi ".$bbr->nomor_resi." \nTerimakasih \n\n*Wilopo Cargo* _(do not reply)_";
          }
          // sendwhatsapp($konfirmasimessage,'081293972529');
          // sendwhatsapp($konfirmasimessage,'081310961108');
        }

        $nomor_giw = $this->input->post('nomor_giw');
        $jumlah_array = count($nomor_giw);
        // for ($i=0; $i<$jumlah_array; $i++) {
            $getbarcode = $this->giw_byresiarray($nomor_giw,$bbr->resi_id)->result();
            foreach($getbarcode as $get_barcode){
                  if($containerdari == "pk"){
                      // dd($get_barcode->jenis_barang_id);
                      $hargabaru=0;
                      if(in_array($get_barcode->jenis_barang_id,array(22,28,33,34))){
                        if($get_barcode->jenis_barang_id == 22){
                            $hargabaru = 4250000 ;
                        }else if($get_barcode->jenis_barang_id == 28){
                            $hargabaru = 4500000;
                        }else if($get_barcode->jenis_barang_id == 33){
                          $hargabaru = 5000000;
                        }else if($get_barcode->jenis_barang_id == 34){
                          $hargabaru = 5250000;
                        }
                        //  dd($hargabaru);
                        $updategiw['jalur'] = 1;    //var_dump($hargabaru);
                        $updategiw['harga'] = $hargabaru - 500000;
                        $this->db->where('id',$get_barcode->id)->update('giw',$updategiw);
                      }else{
                        $updategiw['jalur'] = 1;
                        $this->db->where('id',$get_barcode->id)->update('giw',$updategiw);
                      }
                }else{
                  // dd($get_barcode->jenis_barang_id);
                      // if(in_array($get_barcode->jenis_barang_id,array(22,28,33,34))){
                        $selectharga = $this->db->where('id',$get_barcode->jenis_barang_id)->get('jenis_barang')->row();
                        $jalur=0;    //var_dump($hargabaru);
                        $updategiw['jalur'] = 0;    //var_dump($hargabaru);
                        $updategiw['harga'] = $selectharga->harga_rts - 500000;
                        $this->db->where('id',$get_barcode->id)->update('giw',$updategiw);
                      // }else{
                      //     $jalur=0;
                      //     $updategiw['jalur'] = 0;
                      //     $this->db->where('id',$get_barcode->id)->update('giw',$updategiw);
                      // }
                }
                // Pesan to customer
                $pesanfor .= "\n".$get_barcode->nomor." : ".$get_barcode->barang;
            }
        // }
        $pesan = "Customer *Yth.".$bbr->kode."* , *".$bbr->nomor_resi."* sudah diloading ke container : \n".
                  $pesanfor.
                  "\n\n*Wilopo Cargo* _(do not reply)_";
        sendwhatsapp($pesan,"081310961108");
        sendwhatsapp($pesan,"081293972529");
        sendwhatsapp($pesan,'081299053976');
        sendwhatsapp($pesan,$bbr->whatsapp);
        if($id_pendaftar > 0 || $id_pendaftar != "" || $id_pendaftar != Null){
          $get_sales = $this->db->where('id_pengguna',$id_pendaftar)->get('pengguna')->row();
          sendwhatsapp($pesan,$get_sales->whatsapp);
        }
      }

    }

    function pindah_container($data){
       //$nomor_giw=implode('"',$this->input->post('nomor_giw'));
       if($this->input->post('container_id')==0){
         $insert['status']= 1;
       }else if($this->input->post('container_id')!=0){
         $insert['status']= 2;
       }
       $insert['container_id']= $this->input->post('container_id');
       $this->db->where_in('nomor', $this->input->post('nomor_giw'));
       $this->db->update('giw',$insert);
    }
    
    function container_closing($id,$tanggalclosing){
       $insert['status']= 6;
       $insert['tgl_closing']= $tanggalclosing;
       $this->db->where('container_id', $id);
       $this->db->update('giw',$insert);
       //
    //   $updatecontainer['status']= 4;
    //   $updatecontainer['tanggal_monitoring_c']= $tanggalclosing;
    //   $this->db->where('id_rts',$id)->update('container',$updatecontainer);
    //   $estimasi_tanggal_sampai = date('Y-m-d', strtotime('+5 days', strtotime($tanggalclosing)));
    //   $pesan1 = "";
    //   $pesan2 = "";
    //   $barcodebyresi = $this->db->select('giw.*,customer.kode,resi.nomor as nomor_resi,customer.whatsapp,customer.id_pendaftar')->from('giw')->join('customer','giw.customer_id=customer.id_cust','left')
    //                              ->join('resi','giw.resi_id=resi.id_resi','left')->where('giw.container_id',$id)->group_by('giw.resi_id')->get()->result();

    //   foreach ($barcodebyresi as $bbr) {
    //      $id_pendaftar = $bbr->id_pendaftar;
    //      $pesan1 = "";
    //      $pesan2 = "";
    //      $pesan3 = "";
    //      $row_barcode = $this->barcode_container($id,$bbr->resi_id)->result();
    //      foreach ($row_barcode as $get_barcode ) {
    //       $pesan1 .= "\n".$get_barcode->nomor." : ".$get_barcode->barang;
    //       $pesan3 .= "\n barcode :".$get_barcode->nomor;
    //      }
    //      $pesan2 = "Customer *Yth. ".$bbr->kode."* , *".$bbr->nomor_resi."* Telah Closing Container dan akan segera diberangkatkan : \n".
    //               $pesan1.
    //               "\n\nEstimasi Barang Sampai Gudang Jakarta : ".date_indo($estimasi_tanggal_sampai).
    //               "\n\n*Wilopo Cargo* _(do not reply)_";
    //      $pesan_ke_Dwi = "Barang Closing Container ".$bbr->nomor_resi.",".$pesan3;
    //      sendwhatsapp($pesan_ke_Dwi,'085318999004');
    //      sendwhatsapp($pesan2,"081310961108");
    //      sendwhatsapp($pesan2,"081293972529");
    //      sendwhatsapp($pesan2,'081299053976');
    //      sendwhatsapp($pesan2,$bbr->whatsapp);
    //      if($id_pendaftar > 0 || $id_pendaftar != "" || $id_pendaftar != Null){
    //       $get_sales = $this->db->where('id_pengguna',$id_pendaftar)->get('pengguna')->row();
    //       sendwhatsapp($pesan,$get_sales->whatsapp);
    //      }
    //   }
     }

    function container_otw($id,$tanggalotw){
       sendwhatsapp("Rifki Ada Container Otw Niii","083815423599");
       $insert['status']= 3;
       $insert['tanggal_berangkat']= $tanggalotw;
       $this->db->where('container_id', $id);
       $this->db->update('giw',$insert);
       // insert container
       $insertcontainer['id_rts']= $this->input->post('idcont');
       $insertcontainer['nomor']= $this->input->post('nomorcont');
       $insertcontainer['kode']= $this->input->post('kodecont');
       $insertcontainer['status']= 3;
       $insertcontainer['tanggal_berangkat_c']= $tanggalotw;
       $this->db->insert('container',$insertcontainer);
       $pesan1 = "";
       $pesan2 = "";
       $barcodebyresi = $this->db->select('giw.*,customer.kode,resi.nomor as nomor_resi,customer.whatsapp,customer.id_pendaftar')->from('giw')->join('customer','giw.customer_id=customer.id_cust','left')
                                 ->join('resi','giw.resi_id=resi.id_resi','left')->where('giw.container_id',$id)->group_by('giw.resi_id')->get()->result();

       foreach ($barcodebyresi as $bbr) {
         $id_pendaftar = $bbr->id_pendaftar;
         $pesan1 = "";
         $pesan2 = "";
         $pesan3 = "";
         $row_barcode = $this->barcode_container($id,$bbr->resi_id)->result();
         foreach ($row_barcode as $get_barcode ) {
           $pesan1 .= "\n".$get_barcode->nomor." : ".$get_barcode->barang;
           $pesan3 .= "\n barcode :".$get_barcode->nomor;
         }
         if($get_barcode->jalur == 1){
           $est = date_indo(date("Y-m-d",strtotime("+24 days", strtotime($insert['tanggal_berangkat']))));
         }else{
           $est = date_indo(date("Y-m-d",strtotime("+17 days", strtotime($insert['tanggal_berangkat']))));
         }
         $pesan2 = "Customer *Yth. ".$bbr->kode."* , *".$bbr->nomor_resi."* sudah diberangkatkan : \n".
                   $pesan1.//"\n\nEstimasi Barang Sampai Gudang Jakarta ".$est.
                   "\n\n*Wilopo Cargo* _(do not reply)_";
         $pesan_ke_Dwi = "Barang Otw ".$bbr->nomor_resi." Customer : ".$bbr->kode.",".$pesan3;
         sendwhatsapp($pesan_ke_Dwi,'085318999004');
         sendwhatsapp($pesan2,'081299053976');
         sendwhatsapp($pesan2,"081310961108");
         sendwhatsapp($pesan2,"081293972529");
         sendwhatsapp($pesan2,$bbr->whatsapp);
         if($id_pendaftar > 0 || $id_pendaftar != "" || $id_pendaftar != Null){
           $get_sales = $this->db->where('id_pengguna',$id_pendaftar)->get('pengguna')->row();
           sendwhatsapp($pesan,$get_sales->whatsapp);
         }
       }

     }
     
     function container_eta($id,$tanggaleta){
           $insert['status']= 8;
           $this->db->where('container_id', $id);
           $this->db->update('giw',$insert);
       //
    //   $updatecontainer['status']= 4;
          $updatecontainer['tgl_eta']= $tanggaleta;
          $this->db->where('id_rts',$id)->update('container',$updatecontainer);
    //   $estimasi_tanggal_sampai = date('Y-m-d', strtotime('+5 days', strtotime($tanggalclosing)));
    //   $pesan1 = "";
    //   $pesan2 = "";
    //   $barcodebyresi = $this->db->select('giw.*,customer.kode,resi.nomor as nomor_resi,customer.whatsapp,customer.id_pendaftar')->from('giw')->join('customer','giw.customer_id=customer.id_cust','left')
    //                              ->join('resi','giw.resi_id=resi.id_resi','left')->where('giw.container_id',$id)->group_by('giw.resi_id')->get()->result();

    //   foreach ($barcodebyresi as $bbr) {
    //      $id_pendaftar = $bbr->id_pendaftar;
    //      $pesan1 = "";
    //      $pesan2 = "";
    //      $pesan3 = "";
    //      $row_barcode = $this->barcode_container($id,$bbr->resi_id)->result();
    //      foreach ($row_barcode as $get_barcode ) {
    //       $pesan1 .= "\n".$get_barcode->nomor." : ".$get_barcode->barang;
    //       $pesan3 .= "\n barcode :".$get_barcode->nomor;
    //      }
    //      $pesan2 = "Customer *Yth. ".$bbr->kode."* , *".$bbr->nomor_resi."* Telah Closing Container dan akan segera diberangkatkan : \n".
    //               $pesan1.
    //               "\n\nEstimasi Barang Sampai Gudang Jakarta : ".date_indo($estimasi_tanggal_sampai).
    //               "\n\n*Wilopo Cargo* _(do not reply)_";
    //      $pesan_ke_Dwi = "Barang Closing Container ".$bbr->nomor_resi.",".$pesan3;
    //      sendwhatsapp($pesan_ke_Dwi,'085318999004');
    //      sendwhatsapp($pesan2,"081310961108");
    //      sendwhatsapp($pesan2,"081293972529");
    //      sendwhatsapp($pesan2,'081299053976');
    //      sendwhatsapp($pesan2,$bbr->whatsapp);
    //      if($id_pendaftar > 0 || $id_pendaftar != "" || $id_pendaftar != Null){
    //       $get_sales = $this->db->where('id_pengguna',$id_pendaftar)->get('pengguna')->row();
    //       sendwhatsapp($pesan,$get_sales->whatsapp);
    //      }
    //   }
     }
     
     function container_antri_kapal($id,$tanggalantrikapal){
           $insert['status']= 9;
           $this->db->where('container_id', $id);
           $this->db->update('giw',$insert);
       //
    //   $updatecontainer['status']= 4;
          $updatecontainer['tgl_antri_kapal']= $tanggalantrikapal;
          $this->db->where('id_rts',$id)->update('container',$updatecontainer);
    //   $estimasi_tanggal_sampai = date('Y-m-d', strtotime('+5 days', strtotime($tanggalclosing)));
    //   $pesan1 = "";
    //   $pesan2 = "";
    //   $barcodebyresi = $this->db->select('giw.*,customer.kode,resi.nomor as nomor_resi,customer.whatsapp,customer.id_pendaftar')->from('giw')->join('customer','giw.customer_id=customer.id_cust','left')
    //                              ->join('resi','giw.resi_id=resi.id_resi','left')->where('giw.container_id',$id)->group_by('giw.resi_id')->get()->result();

    //   foreach ($barcodebyresi as $bbr) {
    //      $id_pendaftar = $bbr->id_pendaftar;
    //      $pesan1 = "";
    //      $pesan2 = "";
    //      $pesan3 = "";
    //      $row_barcode = $this->barcode_container($id,$bbr->resi_id)->result();
    //      foreach ($row_barcode as $get_barcode ) {
    //       $pesan1 .= "\n".$get_barcode->nomor." : ".$get_barcode->barang;
    //       $pesan3 .= "\n barcode :".$get_barcode->nomor;
    //      }
    //      $pesan2 = "Customer *Yth. ".$bbr->kode."* , *".$bbr->nomor_resi."* Telah Closing Container dan akan segera diberangkatkan : \n".
    //               $pesan1.
    //               "\n\nEstimasi Barang Sampai Gudang Jakarta : ".date_indo($estimasi_tanggal_sampai).
    //               "\n\n*Wilopo Cargo* _(do not reply)_";
    //      $pesan_ke_Dwi = "Barang Closing Container ".$bbr->nomor_resi.",".$pesan3;
    //      sendwhatsapp($pesan_ke_Dwi,'085318999004');
    //      sendwhatsapp($pesan2,"081310961108");
    //      sendwhatsapp($pesan2,"081293972529");
    //      sendwhatsapp($pesan2,'081299053976');
    //      sendwhatsapp($pesan2,$bbr->whatsapp);
    //      if($id_pendaftar > 0 || $id_pendaftar != "" || $id_pendaftar != Null){
    //       $get_sales = $this->db->where('id_pengguna',$id_pendaftar)->get('pengguna')->row();
    //       sendwhatsapp($pesan,$get_sales->whatsapp);
    //      }
    //   }
     }
     
     function container_atur_kapal($id,$tanggalaturkapal){
           $insert['status']= 10;
           $this->db->where('container_id', $id);
           $this->db->update('giw',$insert);
       //
    //   $updatecontainer['status']= 4;
          $updatecontainer['tgl_atur_kapal']= $tanggalaturkapal;
          $this->db->where('id_rts',$id)->update('container',$updatecontainer);
    //   $estimasi_tanggal_sampai = date('Y-m-d', strtotime('+5 days', strtotime($tanggalclosing)));
    //   $pesan1 = "";
    //   $pesan2 = "";
    //   $barcodebyresi = $this->db->select('giw.*,customer.kode,resi.nomor as nomor_resi,customer.whatsapp,customer.id_pendaftar')->from('giw')->join('customer','giw.customer_id=customer.id_cust','left')
    //                              ->join('resi','giw.resi_id=resi.id_resi','left')->where('giw.container_id',$id)->group_by('giw.resi_id')->get()->result();

    //   foreach ($barcodebyresi as $bbr) {
    //      $id_pendaftar = $bbr->id_pendaftar;
    //      $pesan1 = "";
    //      $pesan2 = "";
    //      $pesan3 = "";
    //      $row_barcode = $this->barcode_container($id,$bbr->resi_id)->result();
    //      foreach ($row_barcode as $get_barcode ) {
    //       $pesan1 .= "\n".$get_barcode->nomor." : ".$get_barcode->barang;
    //       $pesan3 .= "\n barcode :".$get_barcode->nomor;
    //      }
    //      $pesan2 = "Customer *Yth. ".$bbr->kode."* , *".$bbr->nomor_resi."* Telah Closing Container dan akan segera diberangkatkan : \n".
    //               $pesan1.
    //               "\n\nEstimasi Barang Sampai Gudang Jakarta : ".date_indo($estimasi_tanggal_sampai).
    //               "\n\n*Wilopo Cargo* _(do not reply)_";
    //      $pesan_ke_Dwi = "Barang Closing Container ".$bbr->nomor_resi.",".$pesan3;
    //      sendwhatsapp($pesan_ke_Dwi,'085318999004');
    //      sendwhatsapp($pesan2,"081310961108");
    //      sendwhatsapp($pesan2,"081293972529");
    //      sendwhatsapp($pesan2,'081299053976');
    //      sendwhatsapp($pesan2,$bbr->whatsapp);
    //      if($id_pendaftar > 0 || $id_pendaftar != "" || $id_pendaftar != Null){
    //       $get_sales = $this->db->where('id_pengguna',$id_pendaftar)->get('pengguna')->row();
    //       sendwhatsapp($pesan,$get_sales->whatsapp);
    //      }
    //   }
     }
     
     function container_est_dumai($id,$tanggalestdumai){
           $insert['status']= 11;
           $this->db->where('container_id', $id);
           $this->db->update('giw',$insert);
       //
    //   $updatecontainer['status']= 4;
          $updatecontainer['tgl_est_dumai']= $tanggalestdumai;
          $this->db->where('id_rts',$id)->update('container',$updatecontainer);
    //   $estimasi_tanggal_sampai = date('Y-m-d', strtotime('+5 days', strtotime($tanggalclosing)));
    //   $pesan1 = "";
    //   $pesan2 = "";
    //   $barcodebyresi = $this->db->select('giw.*,customer.kode,resi.nomor as nomor_resi,customer.whatsapp,customer.id_pendaftar')->from('giw')->join('customer','giw.customer_id=customer.id_cust','left')
    //                              ->join('resi','giw.resi_id=resi.id_resi','left')->where('giw.container_id',$id)->group_by('giw.resi_id')->get()->result();

    //   foreach ($barcodebyresi as $bbr) {
    //      $id_pendaftar = $bbr->id_pendaftar;
    //      $pesan1 = "";
    //      $pesan2 = "";
    //      $pesan3 = "";
    //      $row_barcode = $this->barcode_container($id,$bbr->resi_id)->result();
    //      foreach ($row_barcode as $get_barcode ) {
    //       $pesan1 .= "\n".$get_barcode->nomor." : ".$get_barcode->barang;
    //       $pesan3 .= "\n barcode :".$get_barcode->nomor;
    //      }
    //      $pesan2 = "Customer *Yth. ".$bbr->kode."* , *".$bbr->nomor_resi."* Telah Closing Container dan akan segera diberangkatkan : \n".
    //               $pesan1.
    //               "\n\nEstimasi Barang Sampai Gudang Jakarta : ".date_indo($estimasi_tanggal_sampai).
    //               "\n\n*Wilopo Cargo* _(do not reply)_";
    //      $pesan_ke_Dwi = "Barang Closing Container ".$bbr->nomor_resi.",".$pesan3;
    //      sendwhatsapp($pesan_ke_Dwi,'085318999004');
    //      sendwhatsapp($pesan2,"081310961108");
    //      sendwhatsapp($pesan2,"081293972529");
    //      sendwhatsapp($pesan2,'081299053976');
    //      sendwhatsapp($pesan2,$bbr->whatsapp);
    //      if($id_pendaftar > 0 || $id_pendaftar != "" || $id_pendaftar != Null){
    //       $get_sales = $this->db->where('id_pengguna',$id_pendaftar)->get('pengguna')->row();
    //       sendwhatsapp($pesan,$get_sales->whatsapp);
    //      }
    //   }
     }
     function container_pib($id,$tanggalpib){
           $insert['status']= 12;
           $this->db->where('container_id', $id);
           $this->db->update('giw',$insert);
       //
    //   $updatecontainer['status']= 4;
          $updatecontainer['tgl_pib']= $tanggalpib;
          $this->db->where('id_rts',$id)->update('container',$updatecontainer);
    //   $estimasi_tanggal_sampai = date('Y-m-d', strtotime('+5 days', strtotime($tanggalclosing)));
    //   $pesan1 = "";
    //   $pesan2 = "";
    //   $barcodebyresi = $this->db->select('giw.*,customer.kode,resi.nomor as nomor_resi,customer.whatsapp,customer.id_pendaftar')->from('giw')->join('customer','giw.customer_id=customer.id_cust','left')
    //                              ->join('resi','giw.resi_id=resi.id_resi','left')->where('giw.container_id',$id)->group_by('giw.resi_id')->get()->result();

    //   foreach ($barcodebyresi as $bbr) {
    //      $id_pendaftar = $bbr->id_pendaftar;
    //      $pesan1 = "";
    //      $pesan2 = "";
    //      $pesan3 = "";
    //      $row_barcode = $this->barcode_container($id,$bbr->resi_id)->result();
    //      foreach ($row_barcode as $get_barcode ) {
    //       $pesan1 .= "\n".$get_barcode->nomor." : ".$get_barcode->barang;
    //       $pesan3 .= "\n barcode :".$get_barcode->nomor;
    //      }
    //      $pesan2 = "Customer *Yth. ".$bbr->kode."* , *".$bbr->nomor_resi."* Telah Closing Container dan akan segera diberangkatkan : \n".
    //               $pesan1.
    //               "\n\nEstimasi Barang Sampai Gudang Jakarta : ".date_indo($estimasi_tanggal_sampai).
    //               "\n\n*Wilopo Cargo* _(do not reply)_";
    //      $pesan_ke_Dwi = "Barang Closing Container ".$bbr->nomor_resi.",".$pesan3;
    //      sendwhatsapp($pesan_ke_Dwi,'085318999004');
    //      sendwhatsapp($pesan2,"081310961108");
    //      sendwhatsapp($pesan2,"081293972529");
    //      sendwhatsapp($pesan2,'081299053976');
    //      sendwhatsapp($pesan2,$bbr->whatsapp);
    //      if($id_pendaftar > 0 || $id_pendaftar != "" || $id_pendaftar != Null){
    //       $get_sales = $this->db->where('id_pengguna',$id_pendaftar)->get('pengguna')->row();
    //       sendwhatsapp($pesan,$get_sales->whatsapp);
    //      }
    //   }
     }
     function container_notul($id,$tanggalnotul){
           $insert['status']= 13;
           $this->db->where('container_id', $id);
           $this->db->update('giw',$insert);
       //
    //   $updatecontainer['status']= 4;
          $updatecontainer['tgl_pib']= $tanggalnotul;
          $this->db->where('id_rts',$id)->update('container',$updatecontainer);
    //   $estimasi_tanggal_sampai = date('Y-m-d', strtotime('+5 days', strtotime($tanggalclosing)));
    //   $pesan1 = "";
    //   $pesan2 = "";
    //   $barcodebyresi = $this->db->select('giw.*,customer.kode,resi.nomor as nomor_resi,customer.whatsapp,customer.id_pendaftar')->from('giw')->join('customer','giw.customer_id=customer.id_cust','left')
    //                              ->join('resi','giw.resi_id=resi.id_resi','left')->where('giw.container_id',$id)->group_by('giw.resi_id')->get()->result();

    //   foreach ($barcodebyresi as $bbr) {
    //      $id_pendaftar = $bbr->id_pendaftar;
    //      $pesan1 = "";
    //      $pesan2 = "";
    //      $pesan3 = "";
    //      $row_barcode = $this->barcode_container($id,$bbr->resi_id)->result();
    //      foreach ($row_barcode as $get_barcode ) {
    //       $pesan1 .= "\n".$get_barcode->nomor." : ".$get_barcode->barang;
    //       $pesan3 .= "\n barcode :".$get_barcode->nomor;
    //      }
    //      $pesan2 = "Customer *Yth. ".$bbr->kode."* , *".$bbr->nomor_resi."* Telah Closing Container dan akan segera diberangkatkan : \n".
    //               $pesan1.
    //               "\n\nEstimasi Barang Sampai Gudang Jakarta : ".date_indo($estimasi_tanggal_sampai).
    //               "\n\n*Wilopo Cargo* _(do not reply)_";
    //      $pesan_ke_Dwi = "Barang Closing Container ".$bbr->nomor_resi.",".$pesan3;
    //      sendwhatsapp($pesan_ke_Dwi,'085318999004');
    //      sendwhatsapp($pesan2,"081310961108");
    //      sendwhatsapp($pesan2,"081293972529");
    //      sendwhatsapp($pesan2,'081299053976');
    //      sendwhatsapp($pesan2,$bbr->whatsapp);
    //      if($id_pendaftar > 0 || $id_pendaftar != "" || $id_pendaftar != Null){
    //       $get_sales = $this->db->where('id_pengguna',$id_pendaftar)->get('pengguna')->row();
    //       sendwhatsapp($pesan,$get_sales->whatsapp);
    //      }
    //   }
     }

     function container_monitoring($id,$tanggalmonitoring){
       $insert['status']= 7;
       $insert['tanggal_monitoring']= $tanggalmonitoring;
       $this->db->where('container_id', $id);
       $this->db->update('giw',$insert);
       //
       $updatecontainer['status']= 4;
       $updatecontainer['tanggal_monitoring_c']= $tanggalmonitoring;
       $this->db->where('id_rts',$id)->update('container',$updatecontainer);
       $estimasi_tanggal_sampai = date('Y-m-d', strtotime('+5 days', strtotime($tanggalmonitoring)));
       $pesan1 = "";
       $pesan2 = "";
       $barcodebyresi = $this->db->select('giw.*,customer.kode,resi.nomor as nomor_resi,customer.whatsapp,customer.id_pendaftar')->from('giw')->join('customer','giw.customer_id=customer.id_cust','left')
                                 ->join('resi','giw.resi_id=resi.id_resi','left')->where('giw.container_id',$id)->group_by('giw.resi_id')->get()->result();

       foreach ($barcodebyresi as $bbr) {
         $id_pendaftar = $bbr->id_pendaftar;
         $pesan1 = "";
         $pesan2 = "";
         $pesan3 = "";
         $row_barcode = $this->barcode_container($id,$bbr->resi_id)->result();
         foreach ($row_barcode as $get_barcode ) {
           $pesan1 .= "\n".$get_barcode->nomor." : ".$get_barcode->barang;
           $pesan3 .= "\n barcode :".$get_barcode->nomor;
         }
         $pesan2 = "Customer *Yth. ".$bbr->kode."* , *".$bbr->nomor_resi."* telah sampai di pelabuhan, mohon ditunggu untuk proses custom clearance : \n".
                   $pesan1.
                   "\n\nEstimasi Barang Sampai Gudang Jakarta : ".date_indo($estimasi_tanggal_sampai).
                   "\n\n*Wilopo Cargo* _(do not reply)_";
         $pesan_ke_Dwi = "Barang Monitoring ".$bbr->nomor_resi.",".$pesan3;
         sendwhatsapp($pesan_ke_Dwi,'085318999004');
         sendwhatsapp($pesan2,"081310961108");
         sendwhatsapp($pesan2,"081293972529");
         sendwhatsapp($pesan2,'081299053976');
         sendwhatsapp($pesan2,$bbr->whatsapp);
         if($id_pendaftar > 0 || $id_pendaftar != "" || $id_pendaftar != Null){
           $get_sales = $this->db->where('id_pengguna',$id_pendaftar)->get('pengguna')->row();
           sendwhatsapp($pesan,$get_sales->whatsapp);
         }
      }
     }

     function container_arrived($id_container,$tgltiba){
        $insert['status']= 5;
        $insert['tanggal_tiba']= $tgltiba;

        $this->db->where('container_id', $id_container);
        $this->db->update('giw',$insert);

        $getcontainer = $this->db->where('id_rts',$id_container)->get('container')->row();
        if(strpos($getcontainer->kode, 'FCL') !== false){
          // echo "LCL NIH";
        }else if(strpos($getcontainer->kode, 'LCL') !== false){
          $updatecontainer['status']= 5;
          $updatecontainer['tanggal_arrived_c']= $tgltiba;
          $this->db->where('id_rts',$id_container)->update('container',$updatecontainer);
        }

        $pesan = "Container Arrived";
       //  $pesan = "";
       //  $barcodebyresi = $this->db->select('giw.*,customer.kode,resi.nomor as nomor_resi')->from('giw')->join('customer','giw.customer_id=customer.id_cust','left')
       //                            ->join('resi','giw.resi_id=resi.id_resi','left')->where_in('giw.container_id',$id)->group_by('giw.resi_id')->get()->result();
       //
       //  foreach ($barcodebyresi as $bbr) {
       //    $pesan .= "Customer Yth.*".$bbr->kode."* , *".$bbr->nomor_resi."* Sudah Tiba di Gudang Jakarta : \n\n";
       //    $row_barcode = $this->barcode_container($id,$bbr->resi_id)->result();
       //    foreach ($row_barcode as $get_barcode ) {
       //      $pesan .= $get_barcode->nomor." : ".$get_barcode->barang;
       //    }
       //    $pesan .= "\n\n*Wilopo Cargo* _(do not reply)_";
       //    sendwhatsapp($pesan,"081310961108");
          sendwhatsapp($pesan,"083815423599");
       // }
     }

     function konfirmasi($id){
       $data_resi= $this->resi_encrypt($id);
     	 foreach($data_resi->result() as $dresi ){
         $resi_id        =$dresi->id_resi;
         $resi_id_rts    =$dresi->id_resi_rts;
         $nomor_resiid   =$dresi->nomor;
         $idcs           =$dresi->cust_id;
         $kfid           =$dresi->konfirmasi_resi;
         $eid            =$dresi->encrypt_resi;
         $jalur          =$dresi->jalur;
         $whatsapp_customer= $dresi->whatsapp;
      	}
      	 if($kfid==1){
          // die("oke");
          $this->session->set_flashdata('msg','sudahkf');
          $this->load->view('konfirmasi/success');
        }else if($kfid==2){
         $this->session->set_flashdata('msg','gagal_konfirm');
         $this->load->view('konfirmasi/success');
        }else if($kfid!=2){
          $pilihharga = 0;
          $data_barcodes= $this->data_brcd($resi_id)->result();
          foreach ($data_barcodes as $g ) {
             $nilaibarangrp = $g->nilai * $g->qty * $g->ctns * $g->kurs;
             $volume = $g->volume * $g->ctns;
             $idgiw = $g->id;
             $status = $g->status;
             $statusjalur = $g->status_jalur;
             $jalur = $g->jalur;
             //dd($nilaibarangrp/$volume);
             $jalur_cepat = 0;
             if($g->jalurcust == 1){
               if(in_array($g->jenis_barang_id,array(18,19,20,21,22,28,33,34,37,38))){
                 $jalur = 0;
               }else{
                 $jalur = 1;
               }
             }else if($g->jalurcust == 2){
               $jalur = 1;
             }else if($g->jalurcust == 3){
               $jalur = 0;
               $jalur_cepat = 1;
             }else{
               $jalur = 0;
             }
           }//endforeach

           $resi['konfirmasi_resi'] = 1;
         	 $this->db->where('encrypt_resi',$id);
           $this->db->update('resi', $resi);
           // dd($jalur_cepat);
           $curl_handle=curl_init();
           curl_setopt($curl_handle,CURLOPT_URL,"https://office.rtsekspedisi.com/api/a_resi/konfirmasi");
           curl_setopt($curl_handle, CURLOPT_POST, 1);
           curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "jalur=$jalur&eid=$id&jalur_cepat=$jalur_cepat");
           $curlemail = curl_exec($curl_handle);
           curl_close($curl_handle);
           // dd($curlemail);

           $updategiw['status_jalur']= 1;
       		 $this->db->where('resi_id', $resi_id);
       		 $this->db->update('giw',$updategiw);

           $pesan = "Anda Berhasil Konfirmasi ".$nomor_resiid." \nTerimakasih \n\n*Wilopo Cargo* _(do not reply)_";
           sendwhatsapp($pesan,'081293972529');
           sendwhatsapp($pesan,'081310961108');
           sendwhatsapp($pesan,'081299053976');
           sendwhatsapp($pesan,$whatsapp_customer);

           // $data['resi_id'] = $resi_id;
           // $data['pilih_harga'] = $pilihharga;

           // if($pilihharga == 1){
           //    $this->session->set_flashdata('msg','success');
           // }else if($pilihharga == 0){
           //   $this->session->set_flashdata('msg','pharga');
           // }

           $this->session->set_flashdata('msg','success');
           $this->load->view('konfirmasi/success');

        }
     }

     function konfirmasi_pk($id){
       $data_resi= $this->resi_encrypt($id);
     	 foreach($data_resi->result() as $dresi ){
         $resi_id        =$dresi->id_resi;
         $resi_id_rts    =$dresi->id_resi_rts;
         $nomor_resiid   =$dresi->nomor;
         $idcs           =$dresi->cust_id;
         $kfid           =$dresi->konfirmasi_resi;
         $eid            =$dresi->encrypt_resi;
         $jalur          =$dresi->jalur;
         $whatsapp_customer= $dresi->whatsapp;
      	}
      	 if($kfid==1){
          // die("oke");
          $this->session->set_flashdata('msg','sudahkf');
          $this->load->view('konfirmasi/success');
        }else if($kfid==2){
         $this->session->set_flashdata('msg','gagal_konfirm');
         $this->load->view('konfirmasi/success');
        }else if($kfid!=2){
          $pilihharga = 0;
          $data_barcodes= $this->data_brcd($resi_id)->result();
          foreach ($data_barcodes as $g ) {
             $nilaibarangrp = $g->nilai * $g->qty * $g->ctns * $g->kurs;
             $volume = $g->volume * $g->ctns;
             $idgiw = $g->id;
             $status = $g->status;
             $statusjalur = $g->status_jalur;
             $jalur = $g->jalur;
             //dd($nilaibarangrp/$volume);
             // if($jalur != 1 && $status == 1 && $statusjalur != 1){
                $jalur = 1;
             // }
           }//endforeach

           $resi['konfirmasi_resi'] = 1;
         	 $this->db->where('encrypt_resi',$id);
           $this->db->update('resi', $resi);

           $curl_handle=curl_init();
           curl_setopt($curl_handle,CURLOPT_URL,"https://office.rtsekspedisi.com/api/a_resi/konfirmasi");
           curl_setopt($curl_handle, CURLOPT_POST, 1);
           curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "jalur=$jalur&eid=$id&jalur_cepat=0");
           $curlemail = curl_exec($curl_handle);
           curl_close($curl_handle);

           $updategiw['status_jalur']= 1;
       		 $this->db->where('resi_id', $resi_id);
       		 $this->db->update('giw',$updategiw);

           $pesan = "Anda Berhasil Konfirmasi ".$nomor_resiid." \nTerimakasih \n\n*Wilopo Cargo* _(do not reply)_";
           sendwhatsapp($pesan,'081293972529');
           sendwhatsapp($pesan,'081310961108');
           sendwhatsapp($pesan,'081299053976');
           sendwhatsapp($pesan,$whatsapp_customer);

           // $data['resi_id'] = $resi_id;
           // $data['pilih_harga'] = $pilihharga;

           // if($pilihharga == 1){
           //    $this->session->set_flashdata('msg','success');
           // }else if($pilihharga == 0){
           //   $this->session->set_flashdata('msg','pharga');
           // }

           $this->session->set_flashdata('msg','success');
           $this->load->view('konfirmasi/success');

        }
     }

     function konfirmasi_asuransi($id){
           $data_resi= $this->resi_encrypt($id);
         	 foreach($data_resi->result() as $dresi ){
             $resi_id        =$dresi->id_resi;
             $resi_id_rts    =$dresi->id_resi_rts;
             $nomor_resiid   =$dresi->nomor;
             $idcs           =$dresi->cust_id;
             $kfid           =$dresi->konfirmasi_resi;
             $eid           =$dresi->encrypt_resi;
             $whatsapp_customer= $dresi->whatsapp;
             $jalur          =$dresi->jalur;
           }
            $cek_asuransi = $this->db->where('id_resi',$resi_id)->get('invoice_asuransi')->num_rows();
            if($cek_asuransi > 0){
              $this->session->set_flashdata('msg','gagal_konfirm');
              $this->load->view('konfirmasi/success');
            }else{
          	 if($kfid==2){
              $this->session->set_flashdata('msg','gagal_konfirm');
              $this->load->view('konfirmasi/success');
          	 }else if($kfid!=2){
                 $pilihharga = 0;
              	  $data_barcodes= $this->data_brcd($resi_id)->result();
                  foreach ($data_barcodes as $g ) {
                    $nilaibarangrp = $g->nilai * $g->qty * $g->ctns * $g->kurs;
                    $volume = $g->volume * $g->ctns;
                    $idgiw = $g->id;
                    $status = $g->status;
                    $statusjalur = $g->status_jalur;
                    $jalur = $g->jalur;
                    //dd($nilaibarangrp/$volume);
                    $jalur_cepat = 1;
                    if($g->jalurcust == 1){
                      if(in_array($g->jenis_barang_id,array(18,19,20,21,22,28,33,34,37,38))){
                        $jalur = 0;
                      }else{
                        $jalur = 1;
                      }
                    }else if($g->jalurcust == 2){
                      $jalur = 1;
                    }else if($g->jalurcust == 3){
                      $jalur = 0;
                      $jalur_cepat = 1;
                    }else{
                      $jalur = 0;
                    }

                    if(($nilaibarangrp/$volume > 20000000) && ($status == 1 || $status == 2)){
                        $warning = 1;
                    }else if($status < 1 && $status > 2){
                        $warning = 2;
                    }else{
                        continue;
                    }
                  }//endforeach

                  $curl_handle=curl_init();
                  curl_setopt($curl_handle,CURLOPT_URL,"https://office.rtsekspedisi.com/api/a_resi/konfirmasi");
                  curl_setopt($curl_handle, CURLOPT_POST, 1);
                  curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "jalur=$jalur&eid=$id&jalur_cepat=$jalur_cepat");
                  $curlemail = curl_exec($curl_handle);
                  curl_close($curl_handle);

                   if($warning==2){
                    $resi['konfirmasi_resi'] = 1;
                    $this->db->where('encrypt_resi',$id);
                    $this->db->update('resi', $resi);

                    $this->session->set_flashdata('msg','no_asuransi');
                    $this->load->view('konfirmasi/success');
                   }else if($warning == 1){

                    $nilaibarangrpasu = array();
                    $volumeasu        = array();

                    foreach ($data_barcodes as $gi ) {
                        $nilaibarangrpasu[] = $gi->nilai * $gi->qty * $gi->ctns * $gi->kurs;
                        $volumeasu[] = $gi->volume * $gi->ctns;
                    }

                    $totalnilaibarangrp = array_sum($nilaibarangrpasu);
                    $totalvolume = array_sum($volumeasu);
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
                         if($jalur == 1){
                            $totalasuransi = ($persentasebaru/100 * $selisihasuransi)/2;
                         }else{
                            $totalasuransi = $persentasebaru/100 * $selisihasuransi;
                         }
                    }else{
                        $totalasuransi = 0;
                    }

                    if($totalasuransi > 0){

                      $insert['id_resi']= $resi_id;
                      $insert['id_cust']= $idcs;
                      $insert['id_invoice']= 0;
                      $insert['tanggal_inv_asuransi']= date('Y-m-d');
                      $insert['jumlah_asuransi']= round($totalasuransi);
                      $insert['note']= $persentase .' x '. $selisihasuransi;
                      $this->db->insert('invoice_asuransi', $insert);

                      $resi['konfirmasi_resi'] = 2;
                   	  $this->db->where('encrypt_resi',$id);
                      $this->db->update('resi', $resi);

                      $updategiw['status_jalur']= 1;
                  		$this->db->where('resi_id', $resi_id);
                  		$this->db->update('giw',$updategiw);

                      $pesan = "Anda Berhasil Membeli Asuransi dan Mengkonfirmasi ".$nomor_resiid." \nTerimakasih \n\n*Wilopo Cargo* _(do not reply)_";
                      sendwhatsapp($pesan,'081293972529');
                      sendwhatsapp($pesan,'081310961108');
                      sendwhatsapp($pesan,$whatsapp_customer);
                      // $data['pilih_harga'] = $pilihharga;
                      // $data['resi_id'] = $resi_id;
                      // if($pilihharga == 1){
                      //    $this->session->set_flashdata('msg','success');
                      // }else if($pilihharga == 0){
                      //   $this->session->set_flashdata('msg','pharga');
                      // }
                      $this->session->set_flashdata('msg','asuransi');
                      $this->load->view('konfirmasi/success');
                    }
                 }else{
                   $this->session->set_flashdata('msg','warning');
                   $this->load->view('konfirmasi/success');
                 }
             }//end cek Konfirmasi Id
           }//end cek asuransi
     }//function

     function konfirmasi_smgasuransi($id){
           $data_resi= $this->resi_encrypt($id);
         	 foreach($data_resi->result() as $dresi ){
             $resi_id        =$dresi->id_resi;
             $resi_id_rts    =$dresi->id_resi_rts;
             $nomor_resiid   =$dresi->nomor;
             $idcs           =$dresi->cust_id;
             $kfid           =$dresi->konfirmasi_resi;
             $eid           =$dresi->encrypt_resi;
             $whatsapp_customer= $dresi->whatsapp;
             $jalur          =$dresi->jalur;
           }
            $cek_asuransi = $this->db->where('id_resi',$resi_id)->get('invoice_asuransi')->num_rows();
            if($cek_asuransi > 0){
              $this->session->set_flashdata('msg','gagal_konfirm');
              $this->load->view('konfirmasi/success');
            }else{
          	 if($kfid==2){
              $this->session->set_flashdata('msg','gagal_konfirm');
              $this->load->view('konfirmasi/success');
          	 }else if($kfid!=2){
                 $pilihharga = 0;
              	  $data_barcodes= $this->data_brcd($resi_id)->result();
                  foreach ($data_barcodes as $g ) {
                    $nilaibarangrp = $g->nilai * $g->qty * $g->ctns * $g->kurs;
                    $volume = $g->volume * $g->ctns;
                    $idgiw = $g->id;
                    $status = $g->status;
                    $statusjalur = $g->status_jalur;
                    $jalur = $g->jalur;
                    //dd($nilaibarangrp/$volume);
                    if($jalur != 1 && $status == 1 && $statusjalur != 1){
                        if(in_array($g->jenis_barang_id,array(22,28,33,34))){
                          $pilihharga = 1;
                        }
                    }

                    if(($nilaibarangrp/$volume > 20000000) && ($status == 1 || $status == 2)){
                        $warning = 1;
                    }else if($status < 1 && $status > 2){
                        $warning = 2;
                    }else{
                        continue;
                    }
                  }//endforeach

                   $ch = curl_init();
                   curl_setopt($ch, CURLOPT_URL, "https://office.rtsekspedisi.com/api/a_resi/beli_asuransi/".$eid);
                   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                   curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                   $data = curl_exec($ch);
                   if($warning==2){
                    $resi['konfirmasi_resi'] = 1;
                    $this->db->where('encrypt_resi',$id);
                    $this->db->update('resi', $resi);

                    $this->session->set_flashdata('msg','no_asuransi');
                    $this->load->view('konfirmasi/success');
                   }else if($warning == 1){

                    $nilaibarangrpasu = array();
                    $volumeasu        = array();

                    foreach ($data_barcodes as $gi ) {
                        $nilaibarangrpasu[] = $gi->nilai * $gi->qty * $gi->ctns * $gi->kurs;
                        $volumeasu[] = $gi->volume * $gi->ctns;
                    }

                    $totalnilaibarangrp = array_sum($nilaibarangrpasu);
                    $totalvolume = array_sum($volumeasu);
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

                    if($totalasuransi > 0){

                      $insert['id_resi']= $resi_id;
                      $insert['id_cust']= $idcs;
                      $insert['id_invoice']= 0;
                      $insert['tanggal_inv_asuransi']= date('Y-m-d');
                      $insert['jumlah_asuransi']= round($totalasuransi);
                      $insert['note']= $persentase .' x '. $selisihasuransi;
                      $this->db->insert('invoice_asuransi', $insert);

                      $resi['konfirmasi_resi'] = 2;
                   	  $this->db->where('encrypt_resi',$id);
                      $this->db->update('resi', $resi);

                      $updategiw['status_jalur']= 1;
                  		$this->db->where('resi_id', $resi_id);
                  		$this->db->update('giw',$updategiw);

                      $pesan = "Anda Berhasil Membeli Asuransi dan Mengkonfirmasi ".$nomor_resiid." \nTerimakasih \n\n*Wilopo Cargo* _(do not reply)_";
                      sendwhatsapp($pesan,'081293972529');
                      sendwhatsapp($pesan,'081310961108');
                      sendwhatsapp($pesan,$whatsapp_customer);
                      // $data['pilih_harga'] = $pilihharga;
                      // $data['resi_id'] = $resi_id;
                      // if($pilihharga == 1){
                      //    $this->session->set_flashdata('msg','success');
                      // }else if($pilihharga == 0){
                      //   $this->session->set_flashdata('msg','pharga');
                      // }
                      $this->session->set_flashdata('msg','asuransi');
                      $this->load->view('konfirmasi/success');
                    }
                 }else{
                   $this->session->set_flashdata('msg','warning');
                   $this->load->view('konfirmasi/success');
                 }
             }//end cek Konfirmasi Id
           }//end cek asuransi
     }//function

     function konfirmasi_altasuransi($id){
           $data_resi= $this->resi_encrypt($id);
         	 foreach($data_resi->result() as $dresi ){
             $resi_id        =$dresi->id_resi;
             $resi_id_rts    =$dresi->id_resi_rts;
             $nomor_resiid   =$dresi->nomor;
             $idcs           =$dresi->cust_id;
             $kfid           =$dresi->konfirmasi_resi;
             $eid           =$dresi->encrypt_resi;
             $whatsapp_customer= $dresi->whatsapp;
             $jalur          =$dresi->jalur;
           }
            $cek_asuransi = $this->db->where('id_resi',$resi_id)->get('invoice_asuransi')->num_rows();
            if($cek_asuransi > 0){
              $this->session->set_flashdata('msg','gagal_konfirm');
              $this->load->view('konfirmasi/success');
            }else{
          	 if($kfid==2){
              $this->session->set_flashdata('msg','gagal_konfirm');
              $this->load->view('konfirmasi/success');
          	 }else if($kfid!=2){
                 $pilihharga = 0;
              	  $data_barcodes= $this->data_brcd($resi_id)->result();
                  foreach ($data_barcodes as $g ) {
                    $nilaibarangrp = $g->nilai * $g->qty * $g->ctns * $g->kurs;
                    $volume = $g->volume * $g->ctns;
                    $idgiw = $g->id;
                    $status = $g->status;
                    $statusjalur = $g->status_jalur;
                    $jalur = $g->jalur;
                    //dd($nilaibarangrp/$volume);
                    if($jalur != 1 && $status == 1 && $statusjalur != 1){
                        if(in_array($g->jenis_barang_id,array(22,28,33,34))){
                          $pilihharga = 1;
                        }
                    }

                    if(($nilaibarangrp/$volume > 20000000) && ($status == 1 || $status == 2)){
                        $warning = 1;
                    }else if($status < 1 && $status > 2){
                        $warning = 2;
                    }else{
                        continue;
                    }
                  }//endforeach

                   $ch = curl_init();
                   curl_setopt($ch, CURLOPT_URL, "https://office.rtsekspedisi.com/api/a_resi/beli_asuransi/".$eid);
                   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                   curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                   $data = curl_exec($ch);
                   if($warning==2){
                    $resi['konfirmasi_resi'] = 1;
                    $this->db->where('encrypt_resi',$id);
                    $this->db->update('resi', $resi);

                    $this->session->set_flashdata('msg','no_asuransi');
                    $this->load->view('konfirmasi/success');
                   }else if($warning == 1){

                    $nilaibarangrpasu = array();
                    $volumeasu        = array();

                    foreach ($data_barcodes as $gi ) {
                        $nilaibarangrpasu[] = $gi->nilai * $gi->qty * $gi->ctns * $gi->kurs;
                        $volumeasu[] = $gi->volume * $gi->ctns;
                    }

                    $totalnilaibarangrp = array_sum($nilaibarangrpasu);
                    $totalvolume = array_sum($volumeasu);
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
                        $totalasuransi = ($persentasebaru/100 * $selisihasuransi) / 2;
                    }else{
                        $totalasuransi = 0;
                    }

                    if($totalasuransi > 0){

                      $insert['id_resi']= $resi_id;
                      $insert['id_cust']= $idcs;
                      $insert['id_invoice']= 0;
                      $insert['tanggal_inv_asuransi']= date('Y-m-d');
                      $insert['jumlah_asuransi']= round($totalasuransi);
                      $insert['note']= $persentase .' x '. $selisihasuransi;
                      $this->db->insert('invoice_asuransi', $insert);

                      $resi['konfirmasi_resi'] = 2;
                   	  $this->db->where('encrypt_resi',$id);
                      $this->db->update('resi', $resi);

                      $updategiw['status_jalur']= 1;
                  		$this->db->where('resi_id', $resi_id);
                  		$this->db->update('giw',$updategiw);

                      $pesan = "Anda Berhasil Membeli Asuransi dan Mengkonfirmasi ".$nomor_resiid." \nTerimakasih \n\n*Wilopo Cargo* _(do not reply)_";
                      sendwhatsapp($pesan,'081293972529');
                      sendwhatsapp($pesan,'081310961108');
                      sendwhatsapp($pesan,$whatsapp_customer);
                      // $data['pilih_harga'] = $pilihharga;
                      // $data['resi_id'] = $resi_id;
                      // if($pilihharga == 1){
                      //    $this->session->set_flashdata('msg','success');
                      // }else if($pilihharga == 0){
                      //   $this->session->set_flashdata('msg','pharga');
                      // }
                      $this->session->set_flashdata('msg','asuransi');
                      $this->load->view('konfirmasi/success');
                    }
                 }else{
                   $this->session->set_flashdata('msg','warning');
                   $this->load->view('konfirmasi/success');
                 }
             }//end cek Konfirmasi Id
           }//end cek asuransi
     }//function

}
