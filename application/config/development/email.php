<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Email Sections
| -------------------------------------------------------------------------
| This file lets you determine global configurations about sending emails
| method used in application. All configurations mentioned below are really
| setted up in config/application_settings.php.
| Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/libraries/email.html
|
*/
$config['protocol']     = 'smtp';
$config['smtp_host']    = 'ssl://smtp.mailgun.org';
$config['smtp_port']    = '465';
$config['smtp_user']    = 'postmaster@sandbox46a5ccffa9164f6889a7df7adc239548.mailgun.org';
$config['smtp_pass']    = 'dc99f395324d904b22ce590015595d97';
$config['mailtype']  	= 'html';
$config['starttls']  	= true;
$config['newline']   	= "\r\n";

/* End of file email.php */
/* Location: ./application/config/email.php */