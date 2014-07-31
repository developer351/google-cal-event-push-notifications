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
	$channel->setId('6c340d284275b6e6a3bbcfc78180bdf9'); // THIS ALWAYS CHANGES
	$channel->setResourceId('o8NNPk5X3IO__w-CeO7U6WgkvWY'); // THIS IS THE CALENDAR ID, OR WHATEVER

	try {
		$service->channels->stop($channel);
		echo "DONE!";
		die();
	} catch(Google_Service_Exception $e) {
		echo "Google Service Exception Caught: " . $e->getMessage();die();
	}
} else {
	$authUrl = $client->createAuthUrl();
}
?>
<?php if (isset($authUrl)){ ?>
	<a class='login' href='<?php echo $authUrl; ?>'>Connect Me!</a>
<?php } ?>