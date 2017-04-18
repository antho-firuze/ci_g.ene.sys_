<?php 	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = [

	'tables'	=> [
		'users'	=> 'a_user',
		'roles'	=> 'a_role',
		'user_role'	=> 'a_user_role',
		'login_attempts' => 'a_loginattempt'
	],
	'join'		=> [
		'users'	=> 'user_id',
		'roles'	=> 'role_id'
	],
	
	'hash_method' 	=>	'bcrypt',
	'default_rounds'	=> 8,
	'random_rounds'		=> FALSE,
	'min_rounds'		=> 5,
	'max_rounds'		=> 9,
	
	'store_salt'		=> TRUE,
	'salt_length'		=> 22,
	'salt_prefix'		=> version_compare(PHP_VERSION, '5.3.7', '<') ? '$2a$' : '$2y$',
	
	'default_role'				=> 'Paradise User',          
	'admin_role'				=> 'Paradise Admin',        
	'identity'					=> 'name',
	'identity_id'				=> 'id',
	'min_password_length'		=> 6,
	'max_password_length'		=> 20,
	'email_activation'			=> FALSE,
	'manual_activation'			=> FALSE,
	'remember_users'				=> TRUE,			// Allow users to be remembered and enable auto-login
	'user_expire'						=> 86500,			// How long to remember the user (seconds). Set to zero for no expiration
	'user_extend_on_login'	=> FALSE,			// Extend the users cookies everytime they auto-login
	'track_login_attempts'		=> TRUE,		// Track the number of failed login attempts for each user or ip.
	'maximum_login_attempts' 	=> 7,				// The maximum number of failed login attempts.
	'track_login_ip_address'	=> FALSE,
	'lockout_time'				=> 600,					// The number of seconds to lockout an account due to exceeded attempts
	'forgot_password_expiration' => 60*60,// The number of seconds after which a forgot password request will expire. If set to 0, forgot password requests will not expire.
	'use_captcha' 				=> TRUE,
	
	'message_start_delimiter'	=> '<p>',
	'message_end_delimiter'		=> '</p>',
	'error_start_delimiter'		=> '<p>',
	'error_end_delimiter'		=> '</p>',
];
