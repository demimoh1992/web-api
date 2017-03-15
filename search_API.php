<?php

header('Content-type: application/json');

require 'config.php';
require 'twitteroauth/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

session_start();

$access_token = $_SESSION['access_token'];

//Now we make a TwitterOAuth instance with the users access_token
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

$user = $connection->get("account/verify_credentials");

$statuses = $connection->get("search/tweets", ["q" => "#CM0677"]);

echo(json_encode($statuses));

?>