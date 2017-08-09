<?php defined('BASEPATH') OR exit('No direct script access allowed');

// MAIL
if ( ! function_exists('send_mail'))
{
	function send_mail_systems( $email_from=NULL, $email_to=NULL, $subject=NULL, $message=NULL ) {
		$ci = get_instance();
		
		$ci->load->library('email');
		$config = [];
		$config = $ci->base_model->getValueArray('head_title, protocol, smtp_host, smtp_port, smtp_user, smtp_pass, smtp_timeout, charset, mailtype, priority', 'a_system', ['client_id', 'org_id'], [DEFAULT_CLIENT_ID, DEFAULT_ORG_ID]);
		$config['useragent'] = 'CodeIgniter';
		$config['newline'] 	 = "\r\n";
		$ci->email->initialize($config);

		$ci->email->clear();
		
		$email_from = $email_from ? $email_from : $config['smtp_user'];
		
		$ci->email->from($email_from, $config['head_title']);
		$ci->email->to($email_to); 
		$ci->email->subject($subject);
		$ci->email->message($message);	

		if (! $ci->email->send()) {
			$ci->session->set_flashdata('message', $ci->email->print_debugger());
			return FALSE;
		}
		return TRUE;
	}
}
