<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	<title><?php if (!empty($title)) echo $title.' » '; ?>&nbsp;« Management &nbsp;</title>
	<link rel="stylesheet" type="text/css" href="includes/css/style.css" />
	<style>
	</style	>
	<script type="text/javascript" src="includes/js/jquery.js"></script>
	<script type="text/javascript" src="includes/js/main.js"></script>
</head>
<body>

<?php if (is_logged_in()) { ?>
<div id="header">
	<ul>
		<li><a href="index.php?dir=uploads">Contents</a></li>
		<li><a href="upload.php"> File Upload </a></li>
		<li><a href="create.php?action=file">File Adding</a></li>
		<li><a href="create.php?action=directory"> Directory Adding</a></li>
		<li><a href="logout.php">Exit</a></li>
	</ul>
	<br class="clear" />
</div>
<?php } ?>
<div id="container"<?php if (!is_logged_in()) echo ' class="margin"'; ?>>
