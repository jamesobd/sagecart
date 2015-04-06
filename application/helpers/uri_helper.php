<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function buildUriString($data) 
{
	$uriString = '';
	$isFirst = true;
	foreach($data as $name => $parameter) {
		$identifier = ($isFirst) ? '?' : '&';
		$uriString .= $identifier . urlencode($name) . '=' . $parameter;
		$isFirst = false;
	}
	return $uriString;
}