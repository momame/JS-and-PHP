<?php
include('config.php');
session_start();
$_SESSION['token'] = sha1(md5(substr($username.$password, 0, rand(5,10))).md5($secret.time()).uniqid(date('m'), true));

get_header();

$current_dir = '';
if (!empty($_GET['dir'])) {
	$current_dir = get_global($_GET, 'dir');
	while(strpos($current_dir, '../') !== false) $current_dir = str_replace('../', '', $current_dir);
}
$start_dir="uploads";
if (empty($current_dir)) $current_dir = $start_dir;
$dirs = get_directories($start_dir);
?>
	<h2>&nbsp;File Management &nbsp;<?php if ($current_dir != $start_dir) { ?><span><a href="index.php?dir=<?php echo dirname($current_dir); ?>"><img src="includes/images/previous.png" alt="Go up one directory" /></a></span><?php } ?></h2>

	<form action="index.php" method="get" id="change">
		<p>
			<select name="dir" id="dir">
				<option value="<?php echo $start_dir ?>">&nbsp;Select Directory &nbsp;</option>
<?php foreach($dirs as $dir) { ?>
				<option value="<?php echo urlencode($dir); ?>"<?php if ($dir == $current_dir) echo ' selected="selected"'; ?>><?php echo $dir; ?></option>
<?php } ?>
			</select>
			<input type="submit" class="button" value="Go!" />
		</p>
	</form>
<?php
$list = get_directory_list($current_dir, 2);
if ($list !== false) echo $list;
else {
?>
	<p>&nbsp;&nbsp;<em><?php echo $current_dir; ?></em>&nbsp;File is not found&nbsp;</p>
<?php
}

get_footer();
?>