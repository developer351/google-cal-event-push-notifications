<?php
require_once 'Google/Client.php';
$client_id = '867444719707-cd6p1jd0pgjhgqp6mk073k6hvs2dtulp.apps.googleusercontent.com';
$client_secret = 'emJpbLliLu5whjClOBRCHttZ';
$redirect_uri = 'http://www.applecrateseo.com/googlecalpush/stopnotification.php';
$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->setScopes('https://www.googleapis.com/auth/calendar');

if (isset($_GET['code'])) {
	$client->authenticate($_GET['code']);
  	$access_json = $client->getAccessToken();
  	$access_object = json_decode($access_json);
  	$access_token = $access_object->access_token;
	$url = "https://www.googleapis.com/calendar/v3/channels/stop";
	/* setup the POST parameters */
	$fields = json_encode(array(
	    'id'      => "26822eac3e1e2b9c54b164ae8a9c030a",
	    'resourceId'   => 'o8NNPk5X3IO__w-CeO7U6WgkvWY'
    ));

	/* setup POST headers */
	$headers[] = 'Content-Type: application/json';
	$headers[] = 'Authorization: Bearer ' . $access_token;

	/* send POST request */
	$channel = curl_init();
	curl_setopt($channel, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($channel, CURLOPT_URL, $url);
	curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($channel, CURLOPT_POST, true);
	curl_setopt($channel, CURLOPT_POSTFIELDS, $fields);
	curl_setopt($channel, CURLOPT_CONNECTTIMEOUT, 2);
	curl_setopt($channel, CURLOPT_TIMEOUT, 3);
	$response = curl_exec($channel);
	curl_close($channel);

	var_dump($response);
	echo '<br><br>';
	var_dump($access_token);
	echo '<br><br>';
} else {
	$authUrl = $client->createAuthUrl();
}
?>
<?php if (isset($authUrl)){ ?>
	<a class='login' href='<?php echo $authUrl; ?>'>Connect Me!</a>
<?php } ?>