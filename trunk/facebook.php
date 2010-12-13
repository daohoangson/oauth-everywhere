<?php
require('class_oauthfacebook.php');

$oauth = new OAuthFacebook(
	array(
		'id' => '115407971814270',
		'secret' => 'dfbbc67188e38aadc8c0378a2f17b20c',
		'callback' => 'http://ponology.com/oauth/facebook.php?step=callback',
		'scope' => OAuthFacebook::scopes(OAUTH_PERMISSION_READ | OAUTH_PERMISSION_WRITE),
	)
);

require('run.php');
?>