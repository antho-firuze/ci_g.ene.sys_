<?php defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('xresponse'))
{
	function xresponse($status=TRUE, $response=[], $statusHeader=FALSE, $exit=TRUE)
	{
		$BM =& load_class('Benchmark', 'core');
		
		$statusCode = $status ? 200 : 401;
		$statusCode = $statusHeader ? $statusHeader : $statusCode;
		if (! is_numeric($statusCode))
			show_error('Status codes must be numeric', 500);
		
		$elapsed = $BM->elapsed_time('total_execution_time_start', 'total_execution_time_end');

		$output['status'] 				= $status;
		$output['execution_time'] = $elapsed;
		$output['environment'] 		= ENVIRONMENT;
		
		header("HTTP/1.0 $statusCode");
		header('Content-Type: application/json');
		echo json_encode(array_merge($output, $response));
		if ($exit) 
			exit();
	}
}
	
