
<?php

// Path to the install of this script.
$path = 'http://www.yoursite.com/ftpless/';

// The top most directory to look for files under.
// NO RELATIVE PATHS! Absolute paths ONLY.
$start_dir = './';

// Login information.
$username = 'admin';
$password = '123';
$secret = 'changethistosomethingelse2';

// The maxium file size allowed to be uploaded, in megabytes.
$max_size = 5;

// The maxium depth (folders inside folders).
$max_depth = 3;

/* ******************************* */
/* DO NOT EDIT BELOW THIS LINE     */
/* ******************************* */

error_reporting(E_ALL);
define('ABSPATH', dirname(__FILE__).'/');
define('PATH', rtrim($path, '/').'/');

include(ABSPATH.'includes/functions.php');

// Check login.
if (!is_logged_in()) {
	$error = false;
	if (isset($_POST['submit'])) {
		$c = get_post_data();
		
		if (empty($c['username']) || empty($c['password']) || $c['username'] != $username || $c['password'] != $password) $error = true;
		else {
			setcookie(md5($secret.'FTPLess'), md5(sha1(date('m').$secret.$c['password'])), time() + (60 * 60 * 24 * 30));
			header('Location: index.php');
		}
	}
		get_header();
?>

	<h2>&nbsp;«  Please login
	<img src="includes/images/logout.png"></h2>

	<form action="index.php" method="post" id="login">
<?php if ($error === true) { ?>
	<p class="error" align="center">&nbsp; Please enter correct username and password! &nbsp;
	<img src="includes/images/error.gif" style=""></p>
<?php } ?>
		<p><label for="username">&nbsp;: Username  &nbsp;</label><input type="text" name="username" id="username" value="your username"/><br class="clear" /></p>
		<p><label for="password">&nbsp;: Password &nbsp;</label><input type="password" name="password" id="password" value="your password"/><br class="clear" /></p>
		<p><input type="submit" name="submit" class="logbutton" value=" Login " /><br class="clear" /></p>
	</form>
<?php
	get_footer();
}
?>