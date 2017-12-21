<?php 
@date_default_timezone_set('Asia/Jakarta');

require_once __DIR__.'/../vendor/autoload.php';

use GO\Scheduler;

// Create a new scheduler
$scheduler = new Scheduler();

/**
 *	Scheduler: Every hour
 *	Task:
 *	- Update IP PUBLIC (execute php function via cli)
 *	- Clear tmp forlder FCPATH.'var/tmp/'
 *
 */
$scheduler->call(function () {
	/* ================================================================ */
	/* Sample for execute php function via CLI (Command Line Interface) */
	/* Using "passthru" or "exec" =====================================	*/
	/* ================================================================ */
	// $bin = 'd:/nginx/php/php.exe';
	// $script = 'd:/htdocs/ci/app1/index.php test/cron';
	// $params = '';
	// passthru("$bin $script $params");
	// exec($bin . ' ' . $script . ' ' . $params);
	
	/* For update IP PUBLIC (execute php function via cli) */
	// $bin = 'd:/nginx/php/php.exe';
	// $script = 'd:/htdocs/ci/app1/index.php z_libs/shared/cron_update_ip_public';
	// $params = '';
	// passthru("$bin $script $params");

	/* Clear tmp forlder */
	/* Note: 60(sec) x 60(min) x 2-24(hour) x 2~(day) */
	// $dir = dirname(__FILE__).DIRECTORY_SEPARATOR.'var/tmp/';
	$dir = 'd:\htdocs/ci/app1/var/tmp/';
	$old = 60 * 60 * 1 * 1;
	if ($handle = @opendir($dir)) {
		while (($file = @readdir($handle)) !== false) {
			if (! preg_match('/^(\.htaccess|index\.(html|htm|php)|web\.config|\.|\.\.)$/i', $file)) {
				if ((time() - @filectime($dir.$file)) > $old) {  
					@unlink($dir.$file);
				}
			}
		}
	}
	
})
	->at('0 * * * *')
;

/**
 *	Scheduler: Every day “At 19:00”
 *	Task:
 *	- Rotate Nginx Logs
 *
 *
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

/**
 *	Scheduler: Every day “At 20:00”
 *	Task:
 *	- Backup Database "db_genesys"
 *
 *
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

/**
 *	Scheduler: Every week “At 00:00 on Sunday”
 *	Task:
 *	- Restart Nginx
 *	- Remove old Nginx log files (older than 1 week)
 *
 */
$scheduler->call(function () { 
	/* restart nginx */
	exec("d:/nginx/reload.bat"); 
	echo "Task: Restart nginx on machine [".gethostname()."] at ".date('Y-m-d H:i:s'); 
	
	/* remove old nginx log files (older than 1 week) */
	/* Note: 60(sec) x 60(min) x 2-24(hour) x 2~(day) */
	$dir = 'd:\nginx/logs/';
	$old = 60 * 60 * 24 * 7;
	$count = 0;
	if ($handle = @opendir($dir)) {
		while (($file = @readdir($handle)) !== false) {
			if (preg_match('/(\.log)$/i', $file)) {
				if ((time() - @filemtime($dir.$file)) > $old) {  
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

