<?php
require_once 'Google/Client.php';
$client_id = '867444719707-cd6p1jd0pgjhgqp6mk073k6hvs2dtulp.apps.googleusercontent.com';
$client_secret = 'emJpbLliLu5whjClOBRCHttZ';
$redirect_uri = 'http://www.applecrateseo.com/googlecalpush/index.php';
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
	$url = "https://www.googleapis.com/calendar/v3/calendars/primary/events/watch";
	$random_hex = md5(uniqid(mt_rand(), true));
	$token = md5(uniqid(mt_rand(), true)) . md5(uniqid(mt_rand(), true));
	/* setup the POST parameters */
	$fields = json_encode(array(
	    'id'        => $random_hex,
	    'type'      => "web_hook",
	    'address'   => 'https://www.applecrateseo.com/googlecalpush/webhook/index.php',
	    'token'		=> $token,
	    'iCalUID'	=> 'u9bg7l9pd9h1bfhd948neoua90@google.com'
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
	var_dump($random_hex);
	echo '<br><br>';
} else {
	$authUrl = $client->createAuthUrl();
}
?>
<?php if (isset($authUrl)){ ?>
	<a class='login' href='<?php echo $authUrl; ?>'>Connect Me!</a>
<?php } ?>