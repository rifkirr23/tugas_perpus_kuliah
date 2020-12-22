<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function dd($var){
  echo "<pre>";
  print_r($var);
  echo "</pre>";die;
}

//footer email
function nama_perusahaan()
        {
            $nm="<p>Terimakasih atas kerjasamanya,</p>
            		<p>Wilopo Cargo<br />
                Rukan Venice Blok B-85 <br />
                Golf Lake Residence, Jl. Kamal Raya Outer Ring Road, Cengkareng Timur <br />
                Jakarta Barat, 11730 - Indonesia <br />
            		Tel : 021 22521995 <br />
                Email : cs@wilopocargo.com<br/>
                Web : www.wilopocargo.com
            	 </p>";
            return $nm;
        }

  //footer email new Customer
  function nama_perusahaan2()
          {
              $nmp="<p>Terimakasih atas kerjasamanya,</p>
              		<p>Wilopo Cargo<br />
                  Rukan Venice Blok B-85 <br />
                  Golf Lake Residence, Jl. Kamal Raya Outer Ring Road, Cengkareng Timur <br />
                  Jakarta Barat, 11730 - Indonesia <br />
              		Tel : 021 22521995 <br />
                  Email : cs@wilopocargo.com<br/>
                  Web : www.wilopocargo.com
              	 </p>";
              return $nmp;
          }

    //Alamat di Pdf
    function alamat_pdf()
            {
                $nmp="<font color='black'>
              	 Rukan Venice Blok B-85
              	<p>Golf Lake Residence, Jl. Kamal Raya Outer Ring Road, Cengkareng Timur</p>
              	<p> Jakarta Barat, 11730 - Indonesia  </p>
              	<p> Phone : (021) 22521995 </p>
              	<p> Email : cs@wilopocargo.com </p>
                <p> Web : www.wilopocargo.com</p>
              	</font>";
                return $nmp;
            }

  //File Sk
  function skwilopo()
          {
              $nmp="WilopoCargoSK.pdf";
              return $nmp;
          }

  //Email Sender
  function user_email()
  {
      $useremail ="admin@wilopocargo.com";
      return $useremail;
  }

  //Pass Sender
  function pass_email()
  {
      $passemail ="Wilopocargo2019";
      return $passemail;
  }

  function whatsapp_dev(){
    return "083815423599";
  }

  function whatsapp_direksi(){
    return "081310961108";
  }

  function whatsapp_cs(){
    return "";
  }

  function whatsapp_cs2(){
    return "";
  }

  function sales(){
    return "";
  }

 //rumus round ambil ... angka dibelakang koma
function round_up($value, $precision) {
    $pow = pow ( 10, $precision );
   $hsl = ( ceil ( $pow * $value ) + ceil ( $pow * $value - ceil ( $pow * $value ) ) ) / $pow;

   return $hsl;
}

//Send Whatsapp
function sendwhatsapp($msg,$number){
     $curl = curl_init();
     $token = "I3BrgPiHQXI4svgBjmJrDVRssanjtHzOcIjEaC8bfCDYOfYcDYkx7ZvJk9Rvpkaf";
     $data = [
         'phone' => $number,
         'message' => $msg,
     ];

     curl_setopt($curl, CURLOPT_HTTPHEADER,
         array(
             "Authorization: $token",
         )
     );
     curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
     curl_setopt($curl, CURLOPT_URL, "https://kemusu.wablas.com/api/send-message");
     curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
     $result = curl_exec($curl);
     curl_close($curl);
     // echo "<pre>";
     // print_r($result);

  }

  function send_document($file,$nmbr,$caption){
       $curl = curl_init();
       $token = "I3BrgPiHQXI4svgBjmJrDVRssanjtHzOcIjEaC8bfCDYOfYcDYkx7ZvJk9Rvpkaf";
       $data = [
          'phone' => $nmbr,
          'caption' => $caption, // can be null
          'document' => 'https://office.wilopocargo.com/'.$file,
      ];

      curl_setopt($curl, CURLOPT_HTTPHEADER,
          array(
              "Authorization: $token",
          )
      );
      curl_setopt($curl, CURLOPT_URL, "https://kemusu.wablas.com/api/send-document");
      curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
      $result = curl_exec($curl);
      curl_close($curl);

      // echo "<pre>";
      // print_r($result);

    }

    function send_newdoc($file,$nmbr,$caption){
         $curl = curl_init();
         $token = "I3BrgPiHQXI4svgBjmJrDVRssanjtHzOcIjEaC8bfCDYOfYcDYkx7ZvJk9Rvpkaf";
         $data = [
            'phone' => $nmbr,
            'caption' => $caption, // can be null
            'document' => 'https://office.wilopocargo.com/pdf_file/'.$file,
        ];

        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array(
                "Authorization: $token",
            )
        );
        curl_setopt($curl, CURLOPT_URL, "https://kemusu.wablas.com/api/send-document");
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);

        // echo "<pre>";
        // print_r($result);

      }

  // Function Send Whatsapp Group
  function whatsapp_grup($group_id,$message,$phone){
    $curl = curl_init();
    $token = "I3BrgPiHQXI4svgBjmJrDVRssanjtHzOcIjEaC8bfCDYOfYcDYkx7ZvJk9Rvpkaf";
    $data = [
        'groupId' => $group_id,
        'phone' => $phone,
        'message' => $message,
    ];

    curl_setopt($curl, CURLOPT_HTTPHEADER,
        array(
            "Authorization: $token",
        )
    );
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_URL, "https://kemusu.wablas.com/api/send-group");
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($curl);
    curl_close($curl);
    echo "<pre>";
    // print_r($result);
  }
  //Send Whatsap Image server
  function sendimage($msg,$number,$img){
    $curl = curl_init();
    $token = "I3BrgPiHQXI4svgBjmJrDVRssanjtHzOcIjEaC8bfCDYOfYcDYkx7ZvJk9Rvpkaf";
    $data = [
     'phone' => $number,
     'caption' => '', // can be null
     'image' => $img,
    ];

    curl_setopt($curl, CURLOPT_HTTPHEADER,
     array(
         "Authorization: $token",
     )
    );
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_URL, "https://kemusu.wablas.com/api/send-image");
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($curl);
    curl_close($curl);

    // print_r($result);
    }
    //Send Whatsapp image Upload
    function sendimagelocal($msg,$number,$img,$img2a){
      $token = "I3BrgPiHQXI4svgBjmJrDVRssanjtHzOcIjEaC8bfCDYOfYcDYkx7ZvJk9Rvpkaf";
      $filename = $img;
      $handle = fopen($filename, "r");
      $file = fread($handle, filesize($filename));

      $params = [
          'phone' => $number,
          'caption' => '', // can be null
          'file' => base64_encode($file),
          'data' => json_encode($img2a)
      ];

      /**
       * bulk message
      $params = [
          'phone' => '081XXXXXX91,0850011xxx',
          'caption' => 'hi', // can be null
          'file' => base64_encode($file),
          'data' => json_encode($_FILES['upload_file'])
      ];
       */

      $curl = curl_init();
      curl_setopt($curl, CURLOPT_HTTPHEADER, [ "Authorization: $token" ] );
      curl_setopt($curl, CURLOPT_URL, "https://kemusu.wablas.com//api/send-image-from-local");
      curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
      $result = curl_exec($curl);
      curl_close($curl);
      // print_r($result);
    }
