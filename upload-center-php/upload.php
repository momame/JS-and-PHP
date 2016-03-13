<?php

include('config.php');

$dirs = get_directories($start_dir);
$max = $max_size * 1048576;
if (isset($_POST['submit'])) {
	$c = get_post_data();
	
	if (empty($c['directory']) || !in_array($c['directory'], $dirs)) $c['directory'] = $current_dir;
	
	if (!empty($_FILES) && is_array($_FILES) && !empty($_FILES['file']) && is_array($_FILES['file']) && (int)$_FILES['file']['error'] === 0 && $_FILES['file']['size'] <= $max) {
		$file = $_FILES['file'];
		$move = ABSPATH.$c['directory'].$file['name'];
		
		if (is_file($move)) error('&nbsp;This filename is already exist &nbsp;');
		if (@move_uploaded_file($file['tmp_name'], $move)) header('Location: index.php');
		else error('&nbsp;Unable to upload, please try again later &nbsp;');
	} else error('&nbsp;Please select a file which is less than &nbsp;'.$maxSize.'&nbsp;&nbsp;');
} else {
	$title = '&nbsp Upload files &nbsp;';
	get_header();
?>
	<h2>&nbsp;Upload files&nbsp;</h2>
	<form action="upload.php" method="post" enctype="multipart/form-data">
		<p>
			<label for="directory">&nbsp;: Directory&nbsp;</label>
			<select name="directory" id="directory">
<?php foreach($dirs as $dir) { ?>
				<option value="<?php echo $dir; ?>"><?php echo $dir; ?></option>
<?php } ?>
			</select>
			<br class="clear" />
		</p>
		<p>
			<label for="file">&nbsp;: file&nbsp;</label>
			<input type="file" name="file" id="file" />
			<input type="hidden" name="MAX_UPLOAD_SIZE" value="<?php echo $max ?>" />
			<br/>
	<em id="emem">&nbsp;Max allowed size :&nbsp;<?php echo $max_size; ?>&nbsp MegaByte &nbsp;</em>
			<br class="clear" />
		</p>
		<p><input type="submit" name="submit" class="button" value=" Upload " /><br class="clear" /></p>
	</form>
<?php
	get_footer();
}
?>