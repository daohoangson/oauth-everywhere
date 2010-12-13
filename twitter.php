<?php
require('class_oauthtwitter.php');

$oauth = new OAuthTwitter(
	array(
		'id' => 'D86n9Tbdz0Ivy5RzZWOMQ',
		'secret' => 'eEQ4KjWFoKOCGjboOxaatMxKiFz8dkR85lGLpISnuo',
		'callback' => 'http://ponology.com/oauth/twitter.php?step=callback',
	)
);

require('run.php');
?>