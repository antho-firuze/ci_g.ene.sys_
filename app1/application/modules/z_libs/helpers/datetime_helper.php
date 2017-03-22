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

/* output_format : 'Y-m-d' */
if ( ! function_exists('date_db_format'))
{
	function date_db_format($date=NULL, $this_format='dd/mm/yyyy')
	{
		if ( empty($date) )
			return FALSE;
		
	if (strpos($this_format, '/') !== false) {

		
		list($tmp[2], $tmp[1], $tmp[0]) = explode('/', $date);
		return implode('-', $tmp);
	}
}

/* output_format : 'Y-m-d h:i:s' */
if ( ! function_exists('datetime_db_format'))
{
	function datetime_db_format($date=NULL)
	{
		if ( empty($date) )
			return FALSE;
		
		list($tmp[2], $tmp[1], $tmp[0]) = explode('/', $date);
		return implode('-', $tmp);
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

