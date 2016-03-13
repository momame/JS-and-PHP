<?php
 
function add_trailing_slash($str = '') {
	return rtrim($str, '/').'/';
}

function clean($str = '', $html = false) {
	if (empty($str)) return;
	
	if (is_array($str)) {
		foreach($str as $key => $value) $str[$key] = clean($value, $html);
	} else {
		if (get_magic_quotes_gpc()) $str = stripslashes($str);
		
		if (is_array($html)) $str = strip_tags($str, implode('', $html));
		elseif (preg_match('|<([a-z]+)>|i', $html)) $str = strip_tags($str, $html);
		elseif ($html !== true) $str = strip_tags($str);
		
		$str = trim($str);
	}
	
	return $str;
}

function error($error = '', $files = true) {
	if ($files === true) get_header();
	echo "<h2>&nbsp  Error !&nbsp</h2>\n<p class=\"error\">$error</p>\n\n";
	if ($files === true) get_footer();
}

function get_css_class($file = '') {
	return ' class="list-'.get_file_type($file).'"';
}

function get_directory_list($dir = './', $tab = 1, $classes = true) {
	$tab = (int)$tab;
	
	$ulTab = (($tab - 1) === 0) ? '' : get_tabs($tab - 1);
	$list = array();
	
	if (!empty($dir) && is_dir($dir)) {
		if (preg_match('|[^/]$|', $dir)) $dir .= '/';
		$dh = opendir($dir);
		$tabs = get_tabs($tab);
		
		while(($file = readdir($dh)) !== false) {
			if ($file == '.' || $file == '..') continue;
			elseif (is_dir($dir.$file)) {
				$thisTab = $tab + 1;
				$thisTabs = get_tabs($thisTab);
				
				$class = ($classes === true) ? ' class="list-directory"' : '';
				$links = '<a href="edit.php?dir='.urlencode($dir.$file).'" title="&nbsp Edit Directory &nbsp"><img src="includes/images/directory-edit.png" alt="&nbsp Edit &nbsp" /></a>&nbsp;&nbsp;<a href="delete.php?dir='.urlencode($dir.$file).'&amp;token='.substr(md5($_SESSION['token'].$dir.$file), 0, 7).'" title="&nbsp Directory Delete!&nbsp" class="delete"><img src="includes/images/directory-delete.png" alt="&nbsp Delete&nbsp" /></a>';
				
				$list[] = $tabs.'<li'.$class.'>'."\n".
								$thisTabs.'<strong>'.$file.'<span>'.$links.'</span></strong>'."\n".
								get_directory_list($dir.$file, $thisTab + 1, $classes).
								$tabs.'</li>';
			} else {
				$class = ($classes === true) ? get_css_class($file) : '';
				$links = '<a href="edit.php?dir='.urlencode($dir).'&amp;file='.urlencode($file).'" title="&nbsp Edit file &nbsp"><img src="includes/images/edit.png" alt="&nbsp Edit&nbsp" /></a>&nbsp;&nbsp;<a href="delete.php?dir='.urlencode($dir).'&amp;file='.urlencode($file).'&amp;token='.substr(md5($_SESSION['token'].$dir.$file), 0, 7).'" title="&nbspDelete file &nbsp" class="delete"><img src="includes/images/delete.png" alt="&nbspDelete&nbsp" /></a>';
				
				$list[] = $tabs.'<li id="'.$dir.$file.'"'.$class.'><a href="'.$dir.$file.'" title="&nbspEdit file&nbsp">'.$file.'</a><span>'.$links.'</span>'.'</li>';
			}
		}
	}
	
	$list = (count($list) > 0) ? array_merge((array)($ulTab.'<ul>'), $list, (array)($ulTab.'</ul>')) : $list;
	$return = trim(implode("\n", $list));
	return (!empty($return)) ? $return."\n" : false;
}

function get_directories($parent = '', $depth = 1) {
	global $max_depth;
	
	$return = array();
	if (!empty($parent) && is_dir($parent)) {
		$return[] = $parent;
		
		$dh = opendir($parent);
		while(($file = readdir($dh)) !== false) {
			if ($file == '.' || $file == '..') continue;
			$newParent = $parent.$file.'/';
			
			if (is_dir($newParent)) {
				if ($max_depth === -1 || $depth <= $max_depth) {
					$dirs = get_directories($newParent, $depth + 1);
					foreach($dirs as $dir) {
						$return[] = $dir;
					}
				}
			}
		}
	}
	
	return $return;
}

function get_file_type($file = '') {
	if (empty($file)) return '';
	$explode = explode('.', $file);
	$extension = $explode[count($explode) - 1];
	$type = '';
	
	if (preg_match('/(^html|htm)$/', $extension)) $type = 'html';
	elseif (preg_match('/^(php|phtml)$/', $extension)) $type = 'php';
	elseif (preg_match('/^(js)$/', $extension)) $type = 'js';
	elseif (preg_match('/^(css)$/', $extension)) $type = 'css';
	elseif (preg_match('/^(jpe?g|png|gif)$/', $extension)) $type = 'image';
	else $type = 'text';
	
	unset($explode, $extension);
	return $type;
}

function get_footer() {
	global $edit, $upload;
	include(ABSPATH.'includes/footer.php');
	exit;
}

function get_global($variable = '', $key = '') {
	if (empty($variable) || empty($key)) return false;
	return (!empty($variable[$key])) ? clean($variable[$key]) : '';
}

function get_header() {
	global $title;
	include(ABSPATH.'includes/header.php');
}

function get_post_data($html = false) {
	$c = array();
	if (!empty($_POST) && is_array($_POST))
		foreach($_POST as $key => $value) $c[$key] = clean($value, $html);
	
	return $c;
}

function get_tabs($num = 1) {
	$tabs = '';
	while($num--) $tabs .= "\t";
	return $tabs;
}

function is_logged_in() {
	global $password, $secret;
	
	$cookie = get_global($_COOKIE, md5($secret.'FTPLess'));
	return (!empty($cookie) && $cookie == md5(sha1(date('m').$secret.$password)));
}
?>