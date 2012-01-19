<?php

require_once "facebook.php";

$FB_user_profile = array(); 
$faceBookUserData = array();
$facebook = new Facebook(array(
  'appId'  => FB_API_KEY,
  'secret' => FB_SECRET_KEY,
));

$facebookUser = $facebook->getUser();

if ($facebookUser) {

  try {
	// Proceed knowing you have a logged in user who's authenticated.
	$FB_user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
	error_log($e);
	$facebookUser = null;
  }
}
if ($facebookUser) {
  $FBlogoutUrl = $facebook->getLogoutUrl();
} else {
  $FBloginUrl = $facebook->getLoginUrl();
  $faceBookUserData = null;
}
