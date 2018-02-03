<?php

/**
 *
 * @copyright  2010-2011 izend.org
 * @version    1
 * @link       http://www.izend.org
 */

require_once 'sendhttp.php';

function qrencode($s, $size=100, $quality='M') {
	$url = 'http://chart.googleapis.com/chart';
	$args = array(
		'cht'	=> 'qr',
		'chf'	=> 'bg,s,ffffff',
		'chs'	=> "${size}x${size}",
		'chld'	=> "${quality}|0",
		'chl'	=> $s,
	);

	$response=sendget($url, $args);

	if (!$response or $response[0] != 200) {
		return false;
	}

	return $response[2];
}

function qrdecode($file, $filetype='image/png') {
	$url = 'http://zxing.org/w/decode';
	$args = array(
		'full'	=> 'true',
	);
	$files=array('f' => array('name' => basename($file), 'tmp_name' => $file, 'type' => $filetype));

	$response=sendpost($url, $args, $files, false);	// DON'T encode data in base64

	if (!$response or $response[0] != 200) {
		return false;
	}

	if (preg_match('#<html>.*</html>#', $response[2])) {
		return false;
	}
	
	return strip_tags($response[2]);
}


