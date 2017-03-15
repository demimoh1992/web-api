<?php

header('Content-type: application/json');
//These files are directly taken from https://twitteroauth.com/redirect.php
// March 2015
//
// NB Calling header so avoid output
require 'config.php';
require 'twitteroauth/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

session_start();

//twitter oauth
$request_token = [];
$request_token['oauth_token'] = $_SESSION['oauth_token'];
$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];

if (isset($_REQUEST['oauth_token']) &&
    $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
  // Abort! Something is wrong.
  // Something's missing, go back to square 1
  header('Location: twitter_login.php');
}

//Now we make a TwitterOAuth instance with the temporary request token.
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $request_token['oauth_token'], $request_token['oauth_token_secret']);

//At this point we will use the temporary request token to get the long lived access_token that authorized to act as the user.
$access_token = $connection->oauth("oauth/access_token", array("oauth_verifier" => $_REQUEST['oauth_verifier']));


// Save it in a session var
$_SESSION['access_token'] = $access_token;

//Now we make a TwitterOAuth instance with the users access_token
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

// Let's get the user's info
$user_info = $connection->get('account/verify_credentials');

/**
//Only for debugging :) should re-direct
echo "<pre>";
print_r($user_info);
echo "</pre>"; */

$user_timeline = $connection->get('statuses/user_timeline');

//Only for debugging :) should re-direct
header('Location: userPage.php?twitter=logged');
?>