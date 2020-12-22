<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mapicustomer extends CI_Model {
    //Proses Simpan Customer BAru
  	function save($data)
  {                       //data Pelanggan
      $customer['nama'] = $this->input->post('nama');
      $customer['email'] = $this->input->post('email');
      $customer['telepon'] = $this->input->post('telepon');
      $customer['whatsapp'] = $this->input->post('whatsapp');
      $customer['alamat'] = $this->input->post('alamat');
      $customer['note'] = $this->input->post('note');
      $customer['kode'] = $this->input->post('kode');
			// $customer['foto_ktp'] =$f1;
			// $customer['foto_sk']  =$f2;

      //Validasi Kode Mark

      $this->db->insert('customer', $customer);
      $last_id = $this->db->insert_id();

			$the_message="<html>
													 <body>
																	 <h3>Yth. Bpk/Ibu (".$this->input->post('nama')."),</h3>
																	 <p>Berikut kami lampirkan surat ketentuan & pernyataan untuk pendaftaran member Wilopo Cargo,
																	  harap dibaca dan diperhatikan dengan teliti. Lalu, harap surat ditanda tangani di atas materai Rp. 6000.</p>
																	 <p>Setelah ditandatangani, harap surat dikirimkan kembali ke kantor kami di alamat:</p>
																	 <p>".nama_perusahaan2()."</p>

													 </body>
										 </html>";

			$atch=base_url().'assets/'.skwilopo();
			$config = Array(
				'protocol' => 'smtp',
        'smtp_host' => 'mail.wilopocargo.com',
				'smtp_port' => 587,
				'smtp_user' => user_email(), //isi dengan gmailmu!
				'smtp_pass' => pass_email(), //isi dengan password gmailmu!
				'mailtype' => 'html',
				'charset' => 'iso-8859-1',
				'wordwrap' => TRUE
			);
			$this->load->library('email', $config);
	    $this->email->attach($atch);
			$this->email->set_newline("\r\n");
	    $this->email->from(user_email());
	    $this->email->to($this->input->post('email')); //email tujuan. Isikan dengan emailmu!
	    $this->email->subject('Surat Ketentuan & Pernyataan Pendaftaran Member Wilopo Cargo');
	    $this->email->message($the_message);

	    if($this->email->send())
	    {

	    }
	    else
	    {
	      //show_error($this->email->print_debugger());
	    }

  }



}
