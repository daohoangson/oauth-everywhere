<?php
session_start();

$session_prefix = md5($_SERVER['SCRIPT_NAME']) . '_';

if (isset($_REQUEST['refresh'])) {
	session_unset();
} else if (isset($_REQUEST['access_token'])) {
	$_SESSION[$session_prefix . 'access_token'] = $_REQUEST['access_token'];
}

if (isset($_SESSION[$session_prefix . 'access_token'])) {
	$oauth->setAccessToken($_SESSION[$session_prefix . 'access_token'],$_SESSION[$session_prefix . 'access_token_secret']);
}

if (!$oauth->authorized()) {
	if ($_REQUEST['step'] == 'callback') {
		if ($oauth->getAccessToken()) {
			$info = $oauth->getInfo();
			$_SESSION[$session_prefix . 'access_token'] = $info['access_token'];
			$_SESSION[$session_prefix . 'access_token_secret'] = $info['access_token_secret'];
			var_dump($info);
		} else {
			var_dump($oauth->getErrors());
		}
	} else {
		$uri = $oauth->buildAuthorizeURI();
		if ($uri) {
			echo '<a href="',$uri,'">',$uri,'</a>';
		} else {
			var_dump($oauth->getErrors());
		}
	}
}

if ($oauth->authorized()) {
	if (isset($_REQUEST['uri']) AND isset($_REQUEST['method'])) {
		function strhex($str) {
			$out = '';
			for($i = 0; $i < strlen($str); $i++) $out .= ' 0x' . strtoupper(dechex(ord($str[$i])));
			return $out;
		}
		function callback_markup_translate($matches) {
			$hex = $matches[1];
			$utf16 = chr(hexdec(substr($hex, 0, 2)))
				. chr(hexdec(substr($hex, 2, 2)));
			//$utf8 = mb_convert_encoding($utf16,'UTF-8','UTF-16');
			$bytes = (ord($utf16{0}) << 8) | ord($utf16{1});
			$utf8 = chr(0xE0 | (($bytes >> 12) & 0x0F))
				. chr(0x80 | (($bytes >> 6) & 0x3F))
				. chr(0x80 | ($bytes & 0x3F));
			echo ' [' . strhex($utf16) . '->' . strhex($utf8) . '] ';
			return $utf8;
		}
		
		$parameters = array();
		$tmp = explode("\r\n",$_REQUEST['parameters']);
		foreach ($tmp as $line) {
			$tmp2 = explode("=",$line);
			if (count($tmp2) > 1) {
				$key = array_shift($tmp2);
				$value = implode("=",$tmp2);
				$parameters[$key] = $value;
				
				//special parsing
				if ($key == 'message') {
					$parameters[$key] =  preg_replace_callback('/\[U([A-F0-9]{4})\]/i','callback_markup_translate',$parameters[$key]);
					var_dump($parameters[$key]); echo '<hr/>';
				}
			}
		}
		
		$response = $oauth->fetch(
			$_REQUEST['uri'],
			$_REQUEST['method'],
			$parameters
		);
	}
?>
<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>">
	<div>
		Access Token
		<a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?refresh">REFRESH</a>
		<ul>
			<li>Key: <?php echo $_SESSION[$session_prefix . 'access_token']; ?></li>
			<li>Secret: <?php echo $_SESSION[$session_prefix . 'access_token_secret']; ?></li>
		</ul>
	</div>
	<div>
		Method
		<select name="method">
			<option value="GET"<?php if (@$_REQUEST['method'] == 'GET') echo ' selected="selected"'; ?>>GET</option>
			<option value="POST"<?php if (@$_REQUEST['method'] == 'POST') echo ' selected="selected"'; ?>>POST</option>
		</select>
	</div>
	<div>
		URI:<br/>
		<input type="text" name="uri" style="width: 75%" value="<?php echo @$_REQUEST['uri']; ?>"/>
	</div>
	<div>
		Parameters (one per line, format "key=value"):<br/>
		<textarea name="parameters" rows="10" style="width: 75%"><?php echo @$_REQUEST['parameters']; ?></textarea>
	</div>
	<div>
		<input type="submit" value="Test"/>
	</div>
</form>
<?php
}