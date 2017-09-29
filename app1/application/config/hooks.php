<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/
$hook['pre_controller'] = function()
{
	// $file = APPPATH.'logs/test.txt';
	// if (! file_exists($file))
		// file_put_contents($file, '');
	
	// $str = file_get_contents($file);
	
	// $newstr = date('Y-m-d H:i:s').' '.getenv('HTTP_FORWARDED').'|'.$_SERVER['REQUEST_METHOD'].'|'.$_SERVER['HTTP_USER_AGENT']."\r\n".$str;
	
	// file_put_contents($file, $newstr);
};