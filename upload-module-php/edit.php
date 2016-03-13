<?php


include('config.php');

$dirs = get_directories($start_dir);
$dir = urldecode(get_global($_GET, 'dir'));
$file = urldecode(get_global($_GET, 'file'));

if (!empty($dir)) {
	while(strpos($dir, '../') !== false) $dir = str_replace('../', '', $dir);
}

if (!empty($file)) {
	while(strpos($file, '../') !== false) $file = str_replace('../', '', $file);
}

if (!in_array($dir, $dirs)) error('&nbsp;Selected Directory is not valid! &nbsp;');

if (isset($_POST['submit'])) {
	$c = get_post_data(true);
	
	if (empty($file)) {
		if ($c['name'] != $dir && is_dir($c['name'])) error('&nbsp;<a href="javascript:history.back();">&nbsp;« Return Back &nbsp;</a>&nbsp;Select Directory alreday exists! &nbsp;');
		
		chmod($dir, octdec($c['chmod']));
		rename($dir, $c['name']);
		header('Location: index.php');
		exit;
	} else {
		if (!empty($c['directory']) && in_array($c['directory'], $dirs)) $newDir = $c['directory'];
		else $newDir = '';
		
		if ($c['name'] != $file && is_file($newDir.$c['name'])) error('&nbsp;<a href="javascript:history.back();">&nbsp;« Return &nbsp;</a>&nbsp;File alreay exists &nbsp;');
		
		chmod($dir.$file, octdec($c['chmod']));
		
		if (get_file_type($dir.$file) != 'image' && is_writeable($dir.$file)) {
			$fh = fopen($dir.$file, 'w');
			fwrite($fh, $c['file_contents']);
			fclose($fh);
		}
		
		
		rename($dir.$file, $newDir.$c['name']);
		header('Location: index.php');
	}
} else {
	if (!is_file($dir.$file) && !is_dir($dir.$file)) error('&nbsp;<a href="index.php">&nbsp;« Return &nbsp;</a>&nbsp;File or Directory is not valid! &nbsp;');
	
	if (!empty($file) && get_file_type($file) != 'image') $edit = true;
	else $edit = false;
	$title = $dir.$file.'&nbsp;&nbsp;: Edit file &nbsp;';
	get_header();
	
	if ($edit === true) $contents = htmlspecialchars(implode("\n", file($dir.$file, FILE_IGNORE_NEW_LINES))); // Requires PHP 5.0
?>
	<h2><?php echo $title; ?><span><a href="index.php">&nbsp;« Return &nbsp;</a></span></h2>

	<form action="edit.php?dir=<?php echo urlencode($dir); ?><?php if (!empty($file)) echo '&amp;file='.urlencode($file); ?>" method="post">
<?php if (!empty($file)) { ?>
		<p>
			<label for="directory">&nbsp;: Directoy&nbsp;</label>
			<select name="directory">
<?php foreach($dirs as $directory) { ?>
				<option value="<?php echo $directory; ?>"<?php if ($directory == $dir) echo ' selected="selected"'; ?>><?php echo $directory; ?></option>
<?php } ?>
			</select>
			<br class="clear" />
		</p>
<?php } ?>
		<p>
			<label for="name">&nbsp;: name&nbsp;</label> <input type="text" name="name" id="name" value="<?php if (!empty($file)) echo $file; else echo $dir; ?>" /><br class="clear" /></p>
<?php if ($edit === true) { ?>
		<p><label for="file_contents">&nbsp;</label><textarea name="file_contents" id="file_contents" rows="10" cols="60"><?php echo $contents; ?></textarea><br class="clear" /></p>
<?php } ?>
		<p>
			<label for="chmod">&nbsp;: Accessibility &nbsp;</label>
			<input type="text" name="chmod" id="chmod" value="<?php echo substr(sprintf('%o', fileperms($dir.$file)), -3, 3); ?>" />
			<br class="clear" />
		</p>
		<p><input type="submit" name="submit" class="button" accesskey="s" value=" Save " /><br class="clear" /></p>
	</form>
<?php
	get_footer();
}
?>