<?php
date_default_timezone_set('America/Los_Angeles');
require_once 'Google/Client.php';
require_once 'Google/Service/Calendar.php';
require_once 'Google/Service/Oauth2.php';

$client_id = '867444719707-cd6p1jd0pgjhgqp6mk073k6hvs2dtulp.apps.googleusercontent.com';
$client_secret = 'emJpbLliLu5whjClOBRCHttZ';
$redirect_uri = 'http://www.applecrateseo.com/googlecalpush/index.php';
$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->setScopes(array('https://www.googleapis.com/auth/userinfo.email','https://www.googleapis.com/auth/calendar'));

if (isset($_GET['code'])) {
	$client->authenticate($_GET['code']);
	$plus = new Google_Service_Oauth2($client);
	$userinfo = $plus->userinfo;
	$userinfo = $userinfo->get();
	$user_email = $userinfo->email;
	$random_hex = md5(uniqid(mt_rand(), true));
	$type = "web_hook";
	$address = 'https://www.applecrateseo.com/googlecalpush/webhook/index.php';

	$service = new Google_Service_Calendar($client);
	$channel = new Google_Service_Calendar_Channel($client);
	$channel->setId($random_hex);
	$channel->setType($type);
	$channel->setAddress($address);
	$channel->setToken($user_email);

	$watchEvent = $service->events->watch($user_email, $channel);

	if($watchEvent->id) {
		$channel_id = $watchEvent->id;
		$channel_expiration = date('Y-m-d H:i:s', $watchEvent->expiration / 1000);
		$channel_token = $watchEvent->token;
		$channel_resource = $watchEvent->resourceId;
		echo "Channel ID:<br>$channel_id<br><br>";
		echo "Token:<br>$channel_token<br><br>";
		echo "Channel Expiration:<br>$channel_expiration<br><br>";
	} else {
		die('no results received');
	}
} else {
	$authUrl = $client->createAuthUrl();
}
if(isset($authUrl)){ ?>
	<a class='login' href='<?php echo $authUrl; ?>'>Connect Me!</a>
<?php }
