<?php defined('BASEPATH') OR exit('No direct script access allowed');

// MAIL
if ( ! function_exists('send_mail'))
{
	function send_mail( $email_to=NULL, $subject=NULL, $message=NULL ) {
		$ci = get_instance();
		
		$ci->load->library('email');

		$ci->email->clear();
		
		$ci->email->set_newline("\r\n");
		// $ci->email->from('hertanto@fajarbenua.co.id', 'SYSTEM');
		$ci->email->from('antho.firuze@gmail.com', 'SYSTEM');
		$ci->email->to($email_to); 
		// $ci->email->bcc('hertanto@fajarbenua.co.id');

		$ci->email->subject($subject);
		$ci->email->message($message);	

		return ($ci->email->send()==TRUE) ? TRUE : $this->email->print_debugger();
	}
}
