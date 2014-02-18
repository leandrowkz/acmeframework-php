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
$config['protocol']     = EMAIL_PROTOCOL;
$config['smtp_host']    = EMAIL_SMTP_HOST;
$config['smtp_port']    = EMAIL_SMTP_PORT;
$config['smtp_timeout'] = EMAIL_SMTP_TIMEOUT;
$config['smtp_user']    = EMAIL_SMTP_USER;
$config['smtp_pass']    = EMAIL_SMTP_PASS;
$config['newline']      = EMAIL_CHAR_NEWLINE;
$config['crlf'] 		= EMAIL_CHAR_CRLF;
$config['mailtype']     = EMAIL_MAILTYPE;
$config['charset']      = EMAIL_CHARSET;

/* End of file email.php */
/* Location: ./application/config/email.php */