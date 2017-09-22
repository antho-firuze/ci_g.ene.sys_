<?php 
@date_default_timezone_set('Asia/Jakarta');

require_once __DIR__.'/../vendor/autoload.php';

use GO\Scheduler;

// Create a new scheduler
$scheduler = new Scheduler(
	// [
		// 'email' => [
			// 'from' => 'do_not_reply@hdgroup.id',
			// 'transport' => (new Swift_SmtpTransport('mail.hdgroup.id', 465, 'ssl'))->setUsername('do_not_reply@hdgroup.id')->setPassword('ReplyHDG2017'),
		// ]
	// ]
);

/* For rotate nginx logs “At 19:00.” */
$scheduler->call(function () { 
	exec("d:/nginx/rotate.bat"); 
	echo "Rotate nginx success at ".date('Y-m-d H:i:s'); 
})
	->configure(['email' => [
		'from' => 'do_not_reply@hdgroup.id',
		'subject' => 'Nginx rotate at '.date('Y-m-d H:i:s'),
		'transport' => (new Swift_SmtpTransport('mail.hdgroup.id', 465, 'ssl'))->setUsername('do_not_reply@hdgroup.id')->setPassword('ReplyHDG2017'),
	]])
	->output(__DIR__.'/nginx_rotate.log')
	->email(['hertanto@fajarbenua.co.id' => 'Hertanto'])
	->then(function(){ @unlink(__DIR__.'/nginx_rotate.log'); })
	->at('0 19 * * *')
;

/* For restart nginx “At 00:00 on Sunday.” */
$scheduler->call(function () { 
	exec("d:/nginx/reload.bat"); 
	echo "Restart nginx success at ".date('Y-m-d H:i:s'); 
})
	->configure(['email' => [
		'from' => 'do_not_reply@hdgroup.id',
		'subject' => 'Nginx restart at '.date('Y-m-d H:i:s'),
		'transport' => (new Swift_SmtpTransport('mail.hdgroup.id', 465, 'ssl'))->setUsername('do_not_reply@hdgroup.id')->setPassword('ReplyHDG2017'),
	]])
	->output(__DIR__.'/nginx_restart.log')
	->email(['hertanto@fajarbenua.co.id' => 'Hertanto'])
	->then(function(){ @unlink(__DIR__.'/nginx_restart.log'); })
	->at('0 0 * * 0')
;

/* For testing */
$scheduler->call(function () {
	$bin = 'd:/nginx/php/php.exe';
	$script = 'd:/htdocs/ci/app1/index.php test/cron';
	
	$dt = date('Ymd_His');
	$params = '"Scheduler : '.$dt.'"';
	
	// exec($bin . ' ' . $script . ' ' . $params);
	passthru("$bin $script $params");
		
})->daily('20:21')->daily('20:57');
				
$scheduler->run();

// if (file_put_contents(__DIR__."/test_log.txt", "testing log"))
	// echo 'file_put_contents = true';
// else
	// echo 'file_put_contents = false';
