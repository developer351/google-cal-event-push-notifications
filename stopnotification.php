<?php
require_once 'Google/Client.php';
require_once 'Google/Service/Calendar.php';

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

	$service = new Google_Service_Calendar($client);
	$channel = new Google_Service_Calendar_Channel($client);
	$channel->setId('52f09c5a8f54b06e29bada627666e09d'); // THIS ALWAYS CHANGES
	$channel->setResourceId('o8NNPk5X3IO__w-CeO7U6WgkvWY'); // THIS IS THE CALENDAR ID, OR WHATEVER

	try {
		$channelStop = $service->channels->stop($channel);
		var_dump($channelStop);die();
	} catch(Google_Service_Exception $e) {
		echo "Google Service Exception Caught: " . $e->getMessage();die();
	}
  	
	// $url = "https://www.googleapis.com/calendar/v3/channels/stop";
	// /* setup the POST parameters */
	// $fields = json_encode(array(
	//     'id'      => "e09cbc80745b77ef4d0d3a191e57cdc6",
	//     'resourceId'   => 'o8NNPk5X3IO__w-CeO7U6WgkvWY'
 //    ));

	// /* setup POST headers */
	// $headers[] = 'Content-Type: application/json';
	// $headers[] = 'Authorization: Bearer ' . $access_token;

	// /* send POST request */
	// $channel = curl_init();
	// curl_setopt($channel, CURLOPT_HTTPHEADER, $headers);
	// curl_setopt($channel, CURLOPT_URL, $url);
	// curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
	// curl_setopt($channel, CURLOPT_POST, true);
	// curl_setopt($channel, CURLOPT_POSTFIELDS, $fields);
	// curl_setopt($channel, CURLOPT_CONNECTTIMEOUT, 2);
	// curl_setopt($channel, CURLOPT_TIMEOUT, 3);
	// $response = curl_exec($channel);
	// curl_close($channel);

	// var_dump($response);
	// echo '<br><br>';
} else {
	$authUrl = $client->createAuthUrl();
}
?>
<?php if (isset($authUrl)){ ?>
	<a class='login' href='<?php echo $authUrl; ?>'>Connect Me!</a>
<?php } ?>