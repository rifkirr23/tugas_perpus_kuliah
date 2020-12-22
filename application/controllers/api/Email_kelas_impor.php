<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class email_kelas_impor extends CI_Controller {

	public function __construct(){
		parent::__construct();

		  $this->load->model('Mcustomer');
      $this->load->model('Mapicustomer');
			$this->load->model('Mapiinvoice');
			$this->load->model('Mkomisi_referal');
	}

	 function email_pertama(){
     $config = Array(
       'protocol' => 'smtp',
       'smtp_host' => 'mail.wilopocargo.com',
       'smtp_port' => 25,
       'smtp_user' => user_email(), //isi dengan gmailmu!
       'smtp_pass' => pass_email(),
       'mailtype' => 'html',
       'charset' => 'iso-8859-1',
       'wordwrap' => TRUE
     );

     $this->load->library('email', $config);
     $nama = $this->input->post('nama');
     $email = $this->input->post('email');
      $the_message='<body style="background-color: #fbfbfb; font-family: Arial, Helvetica, sans-serif; margin: 0;">

          <div style="max-width: 500px; margin: auto; padding: 15px;">
              <div style="text-align: center; padding: 15px;">
                  <img style="height: 40px;" src="https://wilopocargo.com/wp-content/uploads/2019/12/cropped-logo-wc-01-1-e1580449499503.png" alt="">
              </div>
              <div style="padding: 25px 15px; background-color: #fff; border-radius: 2px; border: 1px solid #f0f0f0;">
                  <div style="margin-bottom: 15px; text-align: center;">
                      <H1 style="font-size: 20px; color: #333; font-weight: 700; margin-bottom: 10px; text-transform: uppercase;">Selamat Datang '.$nama.'!</H1>
                  </div>
                  <div style="text-align: center;">
                      <p style="font-size: 15px; line-height: 1.8; color: #333; font-weight: 300;">Terimakasih telah mendaftar 2 hari kelas online eksklusif <strong>"Cara Mencari Supplier di Alibaba"</strong>
                      <br/><br>Saya ingin mengucapkan selamat kepada Anda karena telah mendaftar di kelas ini. Karena kita tahu hanya
                          1 dari 10 orang yang mau belajar, dan Anda adalah 1 orang tersebut!

                          <br/><br>Pertama-tama Anda harus klik tombol di bawah ini untuk join grup Telegram kelas ini, materi dan langkah
                              selanjutnya akan kami informasikan di dalam grup. Selamat Belajar!</p>
                      <div style="padding:15px 10px; display: block; text-align: center;">
                          <a href="https://t.me/joinchat/PtZIFhhHWUYFxQEN4Cn6zg" target="blank" style="display: inline-block; padding: 15px 35px; text-decoration: none; background: #F43B3B; font-size: 15px; color: #fff; border-radius: 4px;">JOIN GRUP TELEGRAM</a>
                      </div>
                  </div>
              </div>
              <div style="text-align: center; padding: 15px;">
                  <ul style="list-style: none; display: flex; align-items: center;justify-content: center; margin: 5px auto; padding-inline-start: 0; opacity: .5;">
                      <li style="display: inline; padding: 3px 5px; font-size: 12px; color: #666;">
                          <a style="text-decoration: none; color: #666;" href="https://wilopocargo.com/">Homepage</a></li>
                      <li style="display: inline; padding: 3px 5px; font-size: 12px; color: #666;">
                          <a style="text-decoration: none; color: #666;" href="https://wilopocargo.com/contact-us/">Hubungi Kami</a></li>
                  </ul>
                  <p style="font-size: 12px; opacity: .5; color: #666; line-height: 1.2; margin: 0;">Copyright ©2020 <a href="https://wilopocargo.com">Wilopo Cargo</a> All right reserved.</p>
              </div>
          </div>
      </body>';

     $this->email->set_newline("\r\n");
     $this->email->from(user_email());
     $this->email->to($email); //email tujuan. Isikan dengan emailmu!
     $this->email->subject('[Wilopo Cargo] Selamat Datang di 2 Hari Kelas Impor Online Ekslusif Gratis');
     $this->email->message($the_message);

     if($this->email->send())
     {
       if($sendoc){
        $path_unlink = './'.$time;
        unlink($path_unlink );
       }
     }
     else
     {
       //show_error($this->email->print_debugger());
     }

	 }

	 function email_expert(){
     $config = Array(
       'protocol' => 'smtp',
       'smtp_host' => 'mail.wilopocargo.com',
       'smtp_port' => 25,
       'smtp_user' => user_email(), //isi dengan gmailmu!
       'smtp_pass' => pass_email(),
       'mailtype' => 'html',
       'charset' => 'iso-8859-1',
       'wordwrap' => TRUE
     );

     $this->load->library('email', $config);
     $nama = $this->input->post('nama');
     $email = $this->input->post('email');
     $telepon = $this->input->post('telepon');
     $paket = $this->input->post('paket');
     $harga = $this->input->post('harga');
      $the_message='<body style="background-color: #fbfbfb; background-image: url(https://wilopocargo.com/wp-content/uploads/2020/03/abstrak-bg.svg); background-repeat: repeat; background-position: center center; background-size: contain; font-family: Arial, Helvetica, sans-serif; margin: 0;">

									    <div style="max-width: 500px; margin: auto; padding: 15px;">
									        <div style="text-align: center; padding: 10px; height: 50px;">
									            <img style="height: 100%; width: 100%; object-fit: contain; object-position: center;" src="https://wilopocargo.com/wp-content/uploads/2019/12/cropped-logo-wc-01-1-e1580449499503.png" alt="">
									        </div>
									        <div style="padding: 25px 15px; background-color: #fff; border-radius: 2px; border: 1px solid #f0f0f0;">
									            <div style="margin-bottom: 15px; text-align: left;">
									                <H1 style="font-size: 20px; color: #333; font-weight: 700; margin-bottom: 10px; text-transform: uppercase;">Hai '.$nama.'!</H1>
									            </div>
									            <div style="text-align: left; font-size: 15px; line-height: 1.8; color: #333; font-weight: 300;">
									                <p>Terima kasih telah mendaftar di <strong>"Kelas Expert Importir"</strong>. Untuk melanjutkan, silahkan melakukan pembayaran membership untuk melanjutkan.</p>
									                <p style="text-align: center; color: #666;">Berikut ini informasi Anda:</p>
									                <div style="padding: 10px; background-color: #f7f7f7;">
									                    <table style="width: 100%;">
									                        <tbody>
									                            <tr>
									                                <th style="width: 50%">Nama Lengkap</th>
									                                <td >'.$nama.'</td>
									                            </tr>
									                            <tr>
									                                <th style="width: 50%">Email</th>
									                                <td>'.$email.'</td>
									                            </tr>
									                            <tr>
									                                <th style="width: 50%">No. Telp</th>
									                                <td >'.$telepon.'</td>
									                            </tr>
									                            <tr>
									                                <th style="width: 50%">Membership</th>
									                                <td >'.$paket.'</td>
									                            </tr>
									                        </tbody>
									                    </table>
									                </div>

									                <!-- Tabel Rekening -->
									                <div style="display: block; margin: 25px auto; height: 1px; background: #ddd;"></div>
									                <p style="text-align: center; color: #111;">Silahkan lakukan pembayaran ke rekening berikut ini:</p>
									                <div style="width: 90%;
									                background-color: #2E4550;
									                padding: 15px;
									                margin: auto;
									                box-shadow: 0 10px 15px 0 rgba(49,49,49,0.15);
									                border-radius: 6px;
									                border-top-left-radius: 0;
									                border-top-right-radius: 0;
									                border-top: 2px solid #F43B3B;
									                color: #fff;">
									                    <table style="width: 100%;">
									                        <tr>
									                            <th>No. Rekening</th>
									                            <td>5810557747</td>
									                        </tr>
									                        <tr>
									                            <th>Nama Rekening</th>
									                            <td>Gusmavin Wilopo</td>
									                        </tr>
									                        <tr>
									                            <th>Bank</th>
									                            <td>BCA Cab. Pluit</td>
									                        </tr>
									                        <tr>
									                            <th>Jumlah Transfer</th>
									                            <td class="jumlah-tf">Rp. '.number_format($harga,0,',','.').'</td>
									                        </tr>
									                    </table>
									                </div>
									                <div style="padding:15px 10px; border: 1px solid #ddd; display: block; text-align: center; background: #fbfbfb; font-style: italic;">
									                    <p style="color: red; font-weight: 600;">Harap transfer sejumlah nominal yang tertera diatas ini agar pembayaran dapat kami check secara otomatis, jika pembayaran Anda belum terkonfirmasi secara otomatis lebih dari 30 menit setelah Anda melakukan pembayaran, harap hubungi kami  <a style="text-decoration: underline" href="http://wilopocargo.com/contact-us">disini</a>.</p>
									                </div>
									                <div style="text-align: center;">
									                    <p style="font-style: italic; color: #666; margin:0;">Salam Hangat</p>
									                    <h3 style="margin: 0;">Wilopocargo</h3>
									                </div>
									            </div>
									        </div>
									        <div style="text-align: center; padding: 15px;">
									            <ul style="list-style: none; display: flex; align-items: center;justify-content: center; margin: 5px auto; padding-inline-start: 0; opacity: .5;">
									                <li style="display: inline; padding: 3px 5px; font-size: 12px; color: #666;">
									                    <a style="text-decoration: none; color: #666;" href="https://wilopocargo.com/">Homepage</a></li>
									                <li style="display: inline; padding: 3px 5px; font-size: 12px; color: #666;">
									                    <a style="text-decoration: none; color: #666;" href="https://wilopocargo.com/contact-us/">Hubungi Kami</a></li>
									            </ul>
									            <p style="font-size: 12px; opacity: .5; color: #666; line-height: 1.2; margin: 0;">Copyright ©2020 <a href="https://wilopocargo.com">Wilopo Cargo</a> All right reserved.</p>
									        </div>
									    </div>
									</body>';

     $this->email->set_newline("\r\n");
     $this->email->from(user_email());
     $this->email->to($email); //email tujuan. Isikan dengan emailmu!
     $this->email->subject('[Wilopo Cargo] Pendaftaran Kelas Expert Importir!');
     $this->email->message($the_message);

     if($this->email->send())
     {
       if($sendoc){
        $path_unlink = './'.$time;
        unlink($path_unlink );
       }
     }
     else
     {
       //show_error($this->email->print_debugger());
     }

	 }


}
