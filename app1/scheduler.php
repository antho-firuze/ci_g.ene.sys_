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

/* For update IP PUBLIC */
// $scheduler->call(function () {
	// $bin = 'd:/nginx/php/php.exe';
	// $script = 'd:/htdocs/ci/app1/index.php z_libs/shared/cron_update_ip_public';
	// $params = '';
	
	// passthru("$bin $script $params");
// })
	// ->at('*/5 * * * *')
// ;

/* 	For rotate nginx logs 
 * 	“At 19:00.” 
 * 	Everuday
 */
$scheduler->call(function () { 
	exec("d:/nginx/rotate.bat"); 
	echo "Task: Rotate nginx on machine [".gethostname()."] at ".date('Y-m-d H:i:s'); 
})
	->configure(['email' => [
		'from' => 'do_not_reply@hdgroup.id',
		'subject' => 'Task: Nginx rotate on machine ['.gethostname().'] at '.date('Y-m-d H:i:s'),
		'body' => 'Task: Rotating Nginx Log File <br><br>
			For more information please see the attachment !',
		'transport' => (new Swift_SmtpTransport('mail.hdgroup.id', 465, 'ssl'))->setUsername('do_not_reply@hdgroup.id')->setPassword('ReplyHDG2017'),
	]])
	->output(__DIR__.'/nginx_rotate.log')
	->email(['hertanto@fajarbenua.co.id' => 'Hertanto'])
	->then(function(){ @unlink(__DIR__.'/nginx_rotate.log'); })
	->at('0 19 * * *')
;

/* 	For backup database db_genesys 
 *	“At 20:00.” 
 * 	Everyday 
 */
$scheduler->call(function () { 
	exec("D:/htdocs (db)/postgre/pgbackup.bat"); 
	$dt = date('Ymd_Hi');
	echo "Task: Backup database on machine [".gethostname()."] at ".date('Y-m-d H:i:s')." and filename is [db_genesys_$dt.backup]"; 
})
	->configure(['email' => [
		'from' => 'do_not_reply@hdgroup.id',
		'subject' => 'Task: Backup database on machine ['.gethostname().'] at '.date('Y-m-d H:i:s'),
		'body' => 'Task: Backup database to the file, with extension (.backup) <br><br>
			For more information please see the attachment !',
		'transport' => (new Swift_SmtpTransport('mail.hdgroup.id', 465, 'ssl'))->setUsername('do_not_reply@hdgroup.id')->setPassword('ReplyHDG2017'),
	]])
	->output(__DIR__.'/pg_dump.log')
	->email(['hertanto@fajarbenua.co.id' => 'Hertanto'])
	->then(function(){ @unlink(__DIR__.'/pg_dump.log'); })
	->at('0 20 * * *')
;

/* 	For restart nginx, remove old nginx log files (older than 1 week) 
 *	“At 00:00 on Sunday.” 
 *	Everyweek
 */
$scheduler->call(function () { 
	/* restart nginx */
	// exec("d:/nginx/reload.bat"); 
	echo "Task: Restart nginx on machine [".gethostname()."] at ".date('Y-m-d H:i:s'); 
	
	/* remove old nginx log files (older than 1 week) */
	$dir = 'd:\nginx/logs/';
	$old = 60 * 60 * 24 * 7;
	$count = 0;
	if ($handle = @opendir($dir)) {
		while (($file = @readdir($handle)) !== false) {
			if (preg_match('/(\.log)$/i', $file)) {
				if ((time() - @filectime($dir.$file)) > $old) {  
					@unlink($dir.$file);
					$count++;
				}
			}
		}
	}
	echo chr(13);
	echo "Task: Removed ($count) nginx log file(s) on machine [".gethostname()."] at ".date('Y-m-d H:i:s'); 
})
	->configure(['email' => [
		'from' => 'do_not_reply@hdgroup.id',
		'subject' => 'Task: Nginx restart & clear log on machine ['.gethostname().'] at '.date('Y-m-d H:i:s'),
		'body' => 'Task: Restart Nginx Server & clear older Nginx log file(s) <br><br>
			For more information please see the attachment !',
		'transport' => (new Swift_SmtpTransport('mail.hdgroup.id', 465, 'ssl'))->setUsername('do_not_reply@hdgroup.id')->setPassword('ReplyHDG2017'),
	]])
	->output(__DIR__.'/nginx_restart.log')
	->email(['hertanto@fajarbenua.co.id' => 'Hertanto'])
	->then(function(){ @unlink(__DIR__.'/nginx_restart.log'); })
	->at('0 0 * * 0')
;

$scheduler->run();

