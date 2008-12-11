<?php

/**
 * add menu of vicuna options
 */
function add_vicuna_config_menu() {
        if ( ! current_user_can('switch_themes') )
		return;

	add_theme_page('Vicuna Config', 'Vicuna Config', 0, basename(__FILE__), 'vicuna_config_menu');
}

add_action( 'admin_menu', 'add_vicuna_config_menu' );

function vicuna_global_navigation() {
	$options = get_option('vicuna_config');
	if ( $options['g_navi'] ) { ?>
	<ul id="globalNavi">
<?php			if ( $options['g_navi_home'] ) { ?>
		<li><a href="<?php bloginfo('home'); ?>" title="Home">Home</a></li>
<?php			}
		if ( $options['g_navi'] == 1 ) {
			wp_list_pages('sort_column=menu_order&title_li=0&depth=1');
		} else if ($options['g_navi'] == 2 ) {
			wp_list_categories('title_li=0&hierarchical=0');
		}
?>
	</ul>
<?php	}
}

/**
 * Display the title of this page.
 */
function vicuna_title($title) {
	$options = get_option('vicuna_config');
	if ($options['title']) {
		echo $title . ' - ' . get_bloginfo('name');
	} else {
		echo get_bloginfo('name') . ' - ' . $title;
	}
}

/**
 * Display a page of config.
 */
function vicuna_config_menu() {

        if ( ! current_user_can('switch_themes') )
		return;

	$options = get_option('vicuna_config');
?>
<div class="wrap">
	<h2><?php _e('Vicuna Config', 'vicuna'); ?></h2>
	<p><?php _e('You can customize the vicuna theme.', 'vicuna'); ?></p>
	<form method="post" action="<?php echo attribute_escape($_SERVER['REQUEST_URI']); ?>">
		<p class="submit">
			<input type="submit" value="<?php _e('Save Changes &raquo;', 'vicuna'); ?>" />
		</p>
		<dl>
			<dt><?php _e('Skin'); ?></dt>
			<dd><select name="vicuna_skin">
<?php
	$skin = $options['skin'];
	foreach (get_skin_dirs() as $file) : ?>
				<option<?php if ($file == $skin) : echo ' selected'; endif; ?>><?php echo $file; ?></option>
<?php	endforeach; ?>
			</select></dd>
			<dt><?php _e('Language'); ?></dt>
			<dd><select name="vicuna_language">
				<option value="">default</option>
<?php
	$language = $options['language'];
	foreach (get_languages() as $lang) : ?>
				<option<?php if ($lang == $language) : echo ' selected'; endif; ?>><?php echo $lang; ?></option>
<?php	endforeach; ?>
			</select></dd>
			<dt><?php _e('Eye Catch Type'); ?></dt>
<?php	$eye_catch = $options['eye_catch']; ?>
			<dd><select name="vicuna_eye_catch">
				<option value="0">none</option>
				<option value="long"<?php if ($eye_catch == 'long') : echo ' selected'; endif; ?>>Long</option>
				<option value="short"<?php if ($eye_catch == 'short') : echo ' selected'; endif; ?>>Short</option>
				<option value="mini"<?php if ($eye_catch == 'mini') : echo ' selected'; endif; ?>>Mini</option>
				<option value="header"<?php if ($eye_catch == 'header') : echo ' selected'; endif; ?>>Header</option>
			</select></dd>
			<dt>Feed Type</dt>
			<dd><select name="vicuna_feed_type">
				<option value="0">default</option>
				<option value="rss+xml"<?php if ($options['feed_type'] == 'rss+xml') : ?> selected<?php endif; ?>>rss+xml</option>
				<option value="atom+xml"<?php if ($options['feed_type'] == 'atom+xml') : ?> selected<?php endif; ?>>atom+xml</option>
			</select></dd>
			<dt>Feed URL</dt>
			<dd><input type="text" name="vicuna_feed_url" value="<?php echo $options['feed_url']; ?>" /></dd>
			<dt>Title Tag</dt>
			<dd><select name="vicuna_title">
				<option value="0"<?php if (!$options['title']) : ?> selected<?php endif; ?>>Blog Name  - Entry Title</option>
				<option value="1"<?php if ($options['title']) : ?> selected<?php endif; ?>>Entry Title - Blog Name</option>
			</select></dd>
		</dl>
		<h3>Navigation</h3>
		<dt>
			<dt>Global Navigation</dt>
			<dd><select name="vicuna_g_navi">
				<option value="0">none</option>
				<option value="1"<?php if ($options['g_navi'] == 1) : ?> selected<?php endif; ?>>pages</option>
				<option value="2"<?php if ($options['g_navi'] == 2) : ?> selected<?php endif; ?>>categories</option>
			</select>
			<select name="vicuna_g_navi_home">
				<option value="0">hide Home</option>
				<option value="1"<?php if ($options['g_navi_home']) : ?> selected<?php endif; ?>>display Home</option>
			</select></dd>
		</dl>
  	</form>
</div>
<?php
}

/**
 * Get directries of skin.
 */
function get_skin_dirs() {
	$theme_dir = get_theme_local_path();
	if ($dir = opendir($theme_dir)) {
		while (($file = readdir($dir)) !== false) {
			if ($file != "." && $file != ".." && is_dir($theme_dir . '/'. $file) && mb_substr($file, 0, 6) == 'style-') {
				$files[] = $file;
			}
		} 
		closedir($dir);
	}
	return $files;
}

/**
 * Get supported languages.
 */
function get_languages() {
	$language_dir = get_theme_local_path() . '/languages';
	if ($dir = opendir($language_dir)) {
		while (($file = readdir($dir)) != false) {
			$l = strlen($file);
			if (mb_substr($file, $l - 3, $l) == ".mo") {
				$languages[] = mb_substr($file, 0, $l - 3);
			}
		}
		closedir($dir);
	}
	return $languages;
}

/**
 * Get a local path of the theme.
 */
function get_theme_local_path() {
	$cwd = getcwd();
	$theme_dir = get_bloginfo('template_directory');
	return mb_substr( $cwd, 0, strlen($cwd) - 8) . mb_substr( $theme_dir, mb_strrpos($theme_dir, 'wp-content'));
}

/**
 * Update the config of Vicuna
 */
function update_vicuna_config() {
        if ( ! current_user_can('switch_themes') )
		return;

	$options = get_option('vicuna_config');
	if (isset($_POST['vicuna_skin'])) {
		$options['skin'] = $_POST['vicuna_skin'];
	}
	if (isset($_POST['vicuna_language'])) {
		$options['language'] = $_POST['vicuna_language'];
	}
	if (isset($_POST['vicuna_eye_catch'])) {
		$options['eye_catch'] = $_POST['vicuna_eye_catch'];
	}
	if (isset($_POST['vicuna_feed_type'])) {
		$options['feed_type'] = $_POST['vicuna_feed_type'];
	}
	if (isset($_POST['vicuna_feed_url'])) {
		$options['feed_url'] = $_POST['vicuna_feed_url'];
	}
	if (isset($_POST['vicuna_g_navi'])) {
		$options['g_navi'] = $_POST['vicuna_g_navi'];
	}
	if (isset($_POST['vicuna_g_navi_home'])) {
		$options['g_navi_home'] = $_POST['vicuna_g_navi_home'];
	}
	if (isset($_POST['vicuna_title'])) {
		$options['title'] = $_POST['vicuna_title'];
	}
	if (isset($_POST['vicuna_fontsize_switcher'])) {
		$options['fontsize_switcher'] = $_POST['vicuna_fontsize_switcher'];
	}
	update_option('vicuna_config', $options);
}
add_action( 'init', 'update_vicuna_config');

?>