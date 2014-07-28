<?php

// @TODO: Add test for token as well...
if(substr($_SERVER['HTTP_USER_AGENT'], 0, 11) === 'APIs-Google') {
	$data = array();

	$data['http_user_agent'] = $_SERVER['HTTP_USER_AGENT']; // Check for: APIs-Google

	if(isset($_SERVER['HTTP_X_GOOG_CHANNEL_ID'])) {
		$data['x_goog_channel_id'] = $_SERVER['HTTP_X_GOOG_CHANNEL_ID'];
	}
	if(isset($_SERVER['HTTP_X_GOOG_MESSAGE_NUMBER'])) {
		$data['x_goog_message_number'] = $_SERVER['HTTP_X_GOOG_MESSAGE_NUMBER'];
	}
	if(isset($_SERVER['HTTP_X_GOOG_RESOURCE_ID'])) {
		$data['x_goog_resource_id'] = $_SERVER['HTTP_X_GOOG_RESOURCE_ID'];
	}
	if(isset($_SERVER['HTTP_X_GOOG_RESOURCE_STATE'])) {
		$data['x_goog_resource_state'] = $_SERVER['HTTP_X_GOOG_RESOURCE_STATE'];
	}
	if(isset($_SERVER['HTTP_X_GOOG_RESOURCE_URI'])) {
		$data['x_goog_resource_uri'] = $_SERVER['HTTP_X_GOOG_RESOURCE_URI'];
	}
	if(isset($_SERVER['HTTP_X_GOOG_CHANNEL_EXPIRATION'])) {
		$data['x_goog_channel_expiration'] = $_SERVER['HTTP_X_GOOG_CHANNEL_EXPIRATION'];
	}
	if(isset($_SERVER['HTTP_X_GOOG_CHANNEL_TOKEN'])) {
		$data['x_goog_channel_token'] = $_SERVER['HTTP_X_GOOG_CHANNEL_TOKEN'];
	}

	$str = '';
	foreach($data as $key=>$val) {
		$str .= "$key: $val\n";
	}
	$str .= "------------------------------------END-REQUEST-----------------------------------------\n\n";

	$file = 'webhook.thelog';
	$handler = fopen($file, 'a') or die("can't open file");
	fwrite($handler, $str);
	fclose($handler);
}

header("HTTP/1.1 200 OK");
// header('HTTP/1.1 500 Internal Server Error');
