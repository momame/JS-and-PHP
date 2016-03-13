<?php
include('config.php');
$action = get_global($_GET, 'action');
$dirs = get_directories($start_dir);

if ($action == 'directory') {
	if (isset($_POST['submit'])) {
		$c = get_post_data();
		
		if (empty($c['directory']) || !in_array($c['directory'], $dirs)) $c['directory'] = $currentDir;
		if (empty($c['name'])) error('&nbsp;   Please choose a name for directory &nbsp;');
		if (preg_match('|[^/]$|', $c['name'])) $c['name'] .= '/'; 
		
		$test = ABSPATH.$c['directory'].$c['name'];
		if (is_dir($test)) error('&nbsp;There is already a similar directory name     &nbsp;');
		
		if (mkdir($test)) header('Location: index.php');
		else error('&nbsp;! You can creat directory at this time!&nbsp;');
	} else {
		$title = '&nbsp; Create Directory  &nbsp;';
		get_header();
?>
	<h2>&nbsp;Create Directory &nbsp;</h2>
	<form action="create.php?action=directory" method="post">
		<p>
			<label for="directory">&nbsp;: Directory &nbsp;</label>
			<select name="directory">
<?php foreach($dirs as $dir) { ?>
				<option value="<?php echo $dir; ?>"><?php echo $dir; ?></option>
<?php } ?>
			</select>
			<br class="clear" />
		</p>
		<p>
			<label for="name">&nbsp;: Name &nbsp;</label>
			<input type="text" name="name" id="name" />
			<br class="clear" />
		</p>
		<p><input type="submit" name="submit" class="button" value=" add " /><br class="clear" /></p>
	</form>
<?php
		get_footer();
	}
} else {
	if (isset($_POST['submit'])) {
		$c = get_post_data();
		
		if (empty($c['directory']) || !in_array($c['directory'], $dirs)) $c['directory'] = $currentDir;
		if (empty($c['name'])) error('&nbsp;Please choose a file for respective directory &nbsp');
		
		$test = ABSPATH.$c['directory'].$c['name'];
		if (is_dir($test)) error('&nbsp; There is already a similar file name      &nbsp');
		
		$fh = fopen($test, 'w');
		if (fwrite($fh, $c['content']) !== false) {
			fclose($fh);
			header('Location: index.php');
		} else {
			fclose($fh);
			error('&nbsp;You can add files at this time! &nbsp;');
		}
	} else {
		$edit = true;
		$title = '&nbsp;Add file  &nbsp;';
		get_header();
?>
	<h2>&nbsp;Adding File  &nbsp;</h2>
	<form action="create.php?action=file" method="post">
		<p>
			<label for="directory">&nbsp;: Directory &nbsp;</label>
			<select name="directory">
<?php foreach($dirs as $dir) { ?>
				<option value="<?php echo $dir; ?>"><?php echo $dir; ?></option>
<?php } ?>
			</select>
			<br class="clear" />
		</p>
		<p>
			<label for="name">&nbsp;: Name &nbsp;</label>
			<input type="text" name="name" id="name" />
			<br class="clear" />
		</p>
		<p>
			<label for="content">&nbsp;: Description &nbsp;</label>
			<textarea type="text" name="content" id="content" rows="10" cols="60"></textarea>
			<br class="clear" />
		</p>
		<p><input type="submit" name="submit" class="button" value=" Create " /><br class="clear" /></p>
	</form>
<?php
		get_footer();
	}
}
?>