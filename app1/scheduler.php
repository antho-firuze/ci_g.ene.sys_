<?php 
@date_default_timezone_set('Asia/Jakarta');

require_once __DIR__.'/../vendor/autoload.php';

use GO\Scheduler;

// Create a new scheduler
$scheduler = new Scheduler();

// Let the scheduler execute jobs which are due.
// $scheduler->call(function () {
	// echo "Hello";
	// return " world!";
// })->output(__DIR__.'/my_file.log');

$scheduler->call(function () {
	$bin = 'd:/nginx/php/php.exe';
	$script = 'd:/htdocs/ci/app1/index.php test/cron';
	
	$dt = date('Ymd_His');
	$params = '"Scheduler : '.$dt.'"';
	
	// exec($bin . ' ' . $script . ' ' . $params);
	passthru("$bin $script $params");
		
		// throw new \Exception('Something failed');
})->daily('20:21')->daily('20:57');
				
$scheduler->run();

// if (file_put_contents(__DIR__."/test_log.txt", "testing log"))
	// echo 'file_put_contents = true';
// else
	// echo 'file_put_contents = false';
