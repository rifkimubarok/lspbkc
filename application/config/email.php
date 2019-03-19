<?php if (! defined('BASEPATH')) exit ('No direct access allowed');
/*
 | -------------------------------------------------------------------
 | EMAIL CONFING
 | -------------------------------------------------------------------
 | Configuration of outgoing mail server.
 | */ 
	$config['smtp'] = [
       'smtp_timeout' => 10,
       'useragent' => 'DPP Purna Pasukan Utama Kirab Remaja Nasional',
       'protocol'  => 'smtp',
       'smtp_host' => 'ssl://smtp.gmail.com',
       'smtp_user' => 'dpppurnapasmakrn@gmail.com',   // Ganti dengan email gmail Anda.
       'smtp_pass' => 'Granadi44',             // Password gmail Anda.
       'smtp_port' => 465,
       'smtp_keepalive' => TRUE,
       'smtp_crypto' => 'SSL',
       'wordwrap'  => TRUE,
       'wrapchars' => 80,
       'mailtype'  => 'html',
       'charset'   => 'utf-8',
       'validate'  => TRUE,
       'crlf'      => "\r\n",
       'newline'   => "\r\n",
     ];
 /* End of file email.php */
 /* Location application/config/email.php */
 ?>