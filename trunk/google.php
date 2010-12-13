<?php
require('class_oauthgoogle.php');

$private_key = <<<EOF
-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQC8SaaK+/etFBkM6R6rk6lTG2ZnWD2z3LTDvpIjVE8QOo03AbqN
CQuaXamFvfCJLi8PHZHzn8kGz7o+odaM8FhNe9alhWnO496EBzvNA4H6pMH30/+G
RpFaQvq58MYBrIbtwGCgyCKXHmIk2X44fGW6o12eSxeuWomU/6FY9HRgBQIDAQAB
AoGAdtdxw+WXhWnbCdgWIKuZwzfXIcGDaIQUoDwnlx7+rDqYqTBxI9WiujMF7cFe
EefRkhPS7FddFeyFHEUf22NUB7UDejYvkklI3PBeLMU+yNjvClhaGureI+tm1dWI
pKESdvctFYOfPOuwZrJ4uFvQpd620lpMOIZk/bYH6MpRuSECQQD18NRmEikTRtZU
ltsXntYogk7wjngqgIwUEZIEApSA19nyI/ntAIrJqIKoM2cD2AubgDvPOX81Rqvh
8aPPA+H5AkEAw/0nSpD77UB+0odBpjQ9dXwo5sfh5Z9Sk7jFOTX0m7aNn0N5SI8P
hlt8rteNgiCjje9QMfhSEkVawsmaSRCxbQJAJ6egJ6EP/Gq0jkkQpHtY3ok8Py9J
ktjNPUMj/v+HgErNemxwlNU8i41fG83F82m3XWhMvHnx195AQpsapXtjyQJAOxkx
KekCLo6OL4mdoDKMfcrMwppvYcBjNCw5PIEqm3G2ztmXzutksQ0RUd+pyh1xdDE/
q3HHvb6wGaCVJ4cjGQJBAIMBK/2EqWtyuiMUCK7akxQTCV8OTXaq357EOIuM+O/e
uAtzWET85RPUSFk/BRv+VLvD5rFWZKOKgyJxAA1QXYU=
-----END RSA PRIVATE KEY-----
EOF;

$public_key = <<<EOF
-----BEGIN CERTIFICATE-----
MIICjDCCAfWgAwIBAgIJAK8PxFap7tALMA0GCSqGSIb3DQEBBQUAMDkxCzAJBgNV
BAYTAlZOMRMwEQYDVQQHEwpIYW5vaSBWaWV3MRUwEwYDVQQDEwxwb25vbG9neS5j
b20wHhcNMTAwNDE3MTI1MTM1WhcNMTEwNDE3MTI1MTM1WjA5MQswCQYDVQQGEwJW
TjETMBEGA1UEBxMKSGFub2kgVmlldzEVMBMGA1UEAxMMcG9ub2xvZ3kuY29tMIGf
MA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC8SaaK+/etFBkM6R6rk6lTG2ZnWD2z
3LTDvpIjVE8QOo03AbqNCQuaXamFvfCJLi8PHZHzn8kGz7o+odaM8FhNe9alhWnO
496EBzvNA4H6pMH30/+GRpFaQvq58MYBrIbtwGCgyCKXHmIk2X44fGW6o12eSxeu
WomU/6FY9HRgBQIDAQABo4GbMIGYMB0GA1UdDgQWBBSuqWueDmSwmHxZgM70o9Hg
g0yCTTBpBgNVHSMEYjBggBSuqWueDmSwmHxZgM70o9Hgg0yCTaE9pDswOTELMAkG
A1UEBhMCVk4xEzARBgNVBAcTCkhhbm9pIFZpZXcxFTATBgNVBAMTDHBvbm9sb2d5
LmNvbYIJAK8PxFap7tALMAwGA1UdEwQFMAMBAf8wDQYJKoZIhvcNAQEFBQADgYEA
DMo7nVxKq9p44bNi4MIFeW3qZsVw0Fdp9PrdZdqKt803dusjIOZziCDDv35hu8hp
omazxIxJNITT4UQBbmwD/sOpPXaetH1cdt1TcvplOXWAaMTmtpZWQSlAKSyFoLy3
gqEXsoKAoWebLMXY+Wu4a6FkkPPa+lEXJrCp/W8g2lY=
-----END CERTIFICATE-----
EOF;

$oauth = new OAuthGoogle(
	array(
		'id' => 'ponology.com',
		'secret' => false,
		'private_key' => $private_key,
		'public_key' => $public_key,
		'callback' => 'http://ponology.com/oauth/google.php?step=callback',
		'scope' => OAuthGoogle::scopes('blogger','calendar','contacts','docs','gmail','maps','picasa','sites','webmastertools','youtube'),
	)
);

require('run.php');
?>