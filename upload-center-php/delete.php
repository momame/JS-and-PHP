<?php


include('config.php');
session_start();
$dir = urldecode(get_global($_GET, 'dir'));
$file = urldecode(get_global($_GET, 'file'));
$token = get_global($_GET, 'token');

if (empty($token) || $token != substr(md5(get_global($_SESSION, 'token').$dir.$file), 0, 7)) error('&nbsp;That is not a valid token.&nbsp;«Not Valid»&nbsp;');
if (!is_dir($dir) && !file($dir.$file)) error('&nbsp;مـسـيـر فـايــل انـتـخـاب شـده مـعـتـبـر نـمـي بـاشــد&nbsp;');

if (!empty($file)) unlink($dir.$file);
else {
	if (count(glob(add_trailing_slash($dir).'*')) > 0) error('&nbsp;لـطـفـا قـبـل از پـاک کـردن، مـسـيــر را خـالـي کـنـيـد&nbsp;');
	rmdir($dir);
}

header('Location: index.php');
?>