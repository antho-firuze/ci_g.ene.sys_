<?php defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('setSession'))
{
	function setSession($data)
	{
		return get_instance()->session->set_userdata($data);
	}
}

if ( ! function_exists('setUserConfig'))
{
	function setUserConfig($data, $value = NULL)
	{
		$ci = &get_instance();
		
		if (! is_array($data))
		{
			$data[$data] = $value;
		}

		$headers = [
			'TOKEN'	 	=> $ci->session->userdata('token'),
		];
		$request = Requests::post(API_URL.'system/userConfig', $headers, $data);
		$result = json_decode($request->body);
		
		if (! empty($result->token))
			$ci->session->set_userdata('token', $result->token);
		
		$ci->session->set_userdata($data);
		
		xresponse(TRUE);
	}
}

