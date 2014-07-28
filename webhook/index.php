<?php

$headers = getallheaders();
$data = array();
$unused_elseifs = 0;

$data['http_user_agent'] = $_SERVER['HTTP_USER_AGENT']; // Check for: APIs-Google

$data['boolean'] = (substr($_SERVER['HTTP_USER_AGENT'], 0, 11) === 'APIs-Google') ? 'true' : 'false';

if(isset($_SERVER['HTTP_X_GOOG_CHANNEL_ID'])) {
	$data['x_goog_channel_id'] = $_SERVER['HTTP_X_GOOG_CHANNEL_ID'];
	$unused_elseifs++;
} elseif(isset($headers['X-Goog-Channel-ID'])) {
	$data['x_goog_channel_id'] = $headers['X-Goog-Channel-ID'];
}
if(isset($_SERVER['HTTP_X_GOOG_MESSAGE_NUMBER'])) {
	$data['x_goog_message_number'] = $_SERVER['HTTP_X_GOOG_MESSAGE_NUMBER'];
	$unused_elseifs++;
} elseif(isset($headers['X-Goog-Message-Number'])) {
	$data['x_goog_message_number'] = $headers['X-Goog-Message-Number'];
}
if(isset($_SERVER['HTTP_X_GOOG_RESOURCE_ID'])) {
	$data['x_goog_resource_id'] = $_SERVER['HTTP_X_GOOG_RESOURCE_ID'];
	$unused_elseifs++;
} elseif(isset($headers['X-Goog-Resource-ID'])) {
	$data['x_goog_resource_id'] = $headers['X-Goog-Resource-ID'];
}
if(isset($_SERVER['HTTP_X_GOOG_RESOURCE_STATE'])) {
	$data['x_goog_resource_state'] = $_SERVER['HTTP_X_GOOG_RESOURCE_STATE'];
	$unused_elseifs++;
} elseif(isset($headers['X-Goog-Resource-State'])) {
	$data['x_goog_resource_state'] = $headers['X-Goog-Resource-State'];
}
if(isset($_SERVER['HTTP_X_GOOG_RESOURCE_URI'])) {
	$data['x_goog_resource_uri'] = $_SERVER['HTTP_X_GOOG_RESOURCE_URI'];
	$unused_elseifs++;
} elseif(isset($headers['X-Goog-Resource-URI'])) {
	$data['x_goog_resource_uri'] = $headers['X-Goog-Resource-URI'];
}
if(isset($_SERVER['HTTP_X_GOOG_CHANNEL_EXPIRATION'])) {
	$data['x_goog_channel_expiration'] = $_SERVER['HTTP_X_GOOG_CHANNEL_EXPIRATION'];
	$unused_elseifs++;
} elseif(isset($headers['X-Goog-Channel-Expiration'])) {
	$data['x_goog_channel_expiration'] = $headers['X-Goog-Channel-Expiration'];
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

header("HTTP/1.1 200 OK");
// header('HTTP/1.1 500 Internal Server Error');
