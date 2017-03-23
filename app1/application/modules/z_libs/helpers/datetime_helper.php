<?php defined('BASEPATH') OR exit('No direct script access allowed');

// DATE & TIME ===========================
if ( ! function_exists('date_first'))
{
	function date_first($format=NULL, $y, $m) {
		
		if (empty($format)) 
			$format = 'Y-m-d';
			
		return date( $format, mktime(0, 0, 0, $m, 1, $y) );
	}
}

if ( ! function_exists('date_last'))
{
	function date_last($format=NULL, $y, $m) {
		
		if (empty($format)) 
			$format = 'Y-m-d';
			
		$d = cal_days_in_month(CAL_GREGORIAN, $m, $y);
		return date( $format, mktime(0, 0, 0, $m, $d, $y) );
	}
}

/* 
*	datetime 		: '22/03/2017' or '22/03/2017 07:07'
*	this_format	: 'dd/mm/yyyy', 'mm/dd/yyyy', 'dd-mm-yyyy', 'mm-dd-yyyy', 'dd/mm/yyyy hh:mm', 'mm/dd/yyyy hh:mm', 'dd-mm-yyyy hh:mm', 'mm-dd-yyyy hh:mm'
*	is_datetime	: TRUE/FALSE (With Time/Without Time)
*	
*	output_format : 'Y-m-d h:i:s' or 'Y-m-d'
*	
*/
if ( ! function_exists('datetime_db_format'))
{
	function datetime_db_format($datetime, $this_format, $is_datetime = TRUE)
	{
		if (empty($datetime))
			return FALSE;
		
		if (! in_array($this_format, ['dd/mm/yyyy', 'mm/dd/yyyy', 'dd-mm-yyyy', 'mm-dd-yyyy', 'dd/mm/yyyy hh:mm', 'mm/dd/yyyy hh:mm', 'dd-mm-yyyy hh:mm', 'mm-dd-yyyy hh:mm']))
			return FALSE;
		
		/* seperate between date & time */
		$dt = [];
		$dt_format = [];
		$dt = explode(' ', $datetime);
		$dt_format = explode(' ', $this_format);

		$date = (count($dt) > 1) ? $dt[0] : $dt[0];
		$time = (count($dt) > 1) ? $dt[1].':00' : FALSE;
		$date_format = (count($dt_format) > 1) ? $dt_format[0] : $dt_format[0];
		$time_format = (count($dt_format) > 1) ? $dt_format[1] : FALSE;
		
		/* time */
		$time_result = ($time !== FALSE) ? $time : '00:00:00';
		
		/* date */
		if (strpos($date_format, '/') !== false) {
			list($f[0], $f[1], $f[2]) = explode('/', $date_format);
			list($d[0], $d[1], $d[2]) = explode('/', $date);
		} else {
			list($f[0], $f[1], $f[2]) = explode('-', $date_format);
			list($d[0], $d[1], $d[2]) = explode('-', $date);
		}
		$date_result = implode('-',[$d[array_search("yyyy",$f)], $d[array_search("mm",$f)], $d[array_search("dd",$f)]]);
		return $is_datetime ? implode(' ', [$date_result, $time_result]) : $date_result;
	}
}

if ( ! function_exists('date_mk'))
{
	// FORMAT $date = 'Y-m-d'
	function date_mk($date) {
		list($y, $m, $d) = explode('-', $date);
		return mktime(
				0,
				0,
				0,
				$m,
				$d, 
				$y
			);
	}
}

if ( ! function_exists('date_set'))
{
	function date_set($format=NULL, $date, $d=0,$m=0,$y=0) {
		
		if (empty($format)) 
			$format = 'Y-m-d';
			
		$date = strtotime($date);
		return date( $format, mktime(
				0,
				0,
				0,
				date('m',$date)+$m,
				date('d',$date)+$d, 
				date('Y',$date)+$y
			));
	}
}

if ( ! function_exists('datetime_set'))
{
	function datetime_set($date,$d=0,$m=0,$y=0,$h=0,$i=0,$s=0) {

		$cd = strtotime($date);
		return date(
			'Y-m-d h:i:s', 
			mktime(
				date('h',$cd)+$h, 
				date('i',$cd)+$i, 
				date('s',$cd)+$s, 
				date('m',$cd)+$m,
				date('d',$cd)+$d, 
				date('Y',$cd)+$y)
			);
	}
}

if ( ! function_exists('datetime_weekday'))
{
	function datetime_weekday($date,$d=0,$m=0,$y=0,$h=0,$i=0,$s=0) {

		$cd = strtotime($date);
		$new = date( 'Y-m-d h:i:s', mktime(
				date('h',$cd)+$h, 
				date('i',$cd)+$i, 
				date('s',$cd)+$s, 
				date('m',$cd)+$m,
				date('d',$cd)+$d, 
				date('Y',$cd)+$y)
			);
		if (date("N", strtotime($new))==6)
			return date( 'Y-m-d h:i:s', mktime(
				date('h',$cd)+$h, 
				date('i',$cd)+$i, 
				date('s',$cd)+$s, 
				date('m',$cd)+$m,
				date('d',$cd)+$d+2, 
				date('Y',$cd)+$y)
			);
		elseif (date("N", strtotime($new))==7)
			return date( 'Y-m-d h:i:s', mktime(
				date('h',$cd)+$h, 
				date('i',$cd)+$i, 
				date('s',$cd)+$s, 
				date('m',$cd)+$m,
				date('d',$cd)+$d+1, 
				date('Y',$cd)+$y)
			);
		else
			return $new;
	}
}

