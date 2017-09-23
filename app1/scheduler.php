<?php 
@date_default_timezone_set('Asia/Jakarta');

require_once __DIR__.'/../vendor/autoload.php';

use GO\Scheduler;

// Create a new scheduler
$scheduler = new Scheduler();

/* For testing */
$scheduler->call(function () {
	$bin = 'd:/nginx/php/php.exe';
	$script = 'd:/htdocs/ci/app1/index.php test/cron';
	$dt = date('Ymd_His');
	$params = '"Scheduler : '.$dt.'"';
	
	// echo "Testing output from [".gethostname()."] at ".date('Y-m-d H:i:s'); 
	// exec($bin . ' ' . $script . ' ' . $params);
	// passthru("$bin $script $params");
		
})
	->output(__DIR__.'/testing_output_'.date('Ymd_His').'.log')
	// ->daily('20:21')->daily('20:57')
;
				
/* For rotate nginx logs “At 19:00.” */
$scheduler->call(function () { 
	exec("d:/nginx/rotate.bat"); 
	echo "Rotate nginx on machine [".gethostname()."] at ".date('Y-m-d H:i:s'); 
})
	->configure(['email' => [
		'from' => 'do_not_reply@hdgroup.id',
		'subject' => 'Nginx rotate on machine ['.gethostname().'] at '.date('Y-m-d H:i:s'),
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
	echo "Restart nginx on machine [".gethostname()."] at ".date('Y-m-d H:i:s'); 
})
	->configure(['email' => [
		'from' => 'do_not_reply@hdgroup.id',
		'subject' => 'Nginx restart on machine ['.gethostname().'] at '.date('Y-m-d H:i:s'),
		'transport' => (new Swift_SmtpTransport('mail.hdgroup.id', 465, 'ssl'))->setUsername('do_not_reply@hdgroup.id')->setPassword('ReplyHDG2017'),
	]])
	->output(__DIR__.'/nginx_restart.log')
	->email(['hertanto@fajarbenua.co.id' => 'Hertanto'])
	->then(function(){ @unlink(__DIR__.'/nginx_restart.log'); })
	->at('0 0 * * 0')
;

$scheduler->run();
