<?php
/**
 * add menu of vicuna options
 */
function add_vicuna_layout_menu() {
        if ( ! current_user_can('switch_themes') )
		return;
	add_theme_page(__('Layout', 'vicuna'), __('Layout', 'vicuna'), 0, basename(__FILE__), 'vicuna_layout_menu');
}
add_action( 'admin_menu', 'add_vicuna_layout_menu' );

/**
 * Get a parameter for layout in the page.
 */
function vicuna_layout($page) {
	$options = get_option('vicuna_layout');
	$key = $page . '_layout';
	if (!isset($options[$key])) {
		$options['index_layout'] = 'double';
		$options['category_layout'] = 'double';
		$options['archive_layout'] = 'double';
		$options['tag_layout'] = 'double';
		$options['page_layout'] = 'single';
		$options['single_layout'] = 'single';
		$options['search_layout'] = 'double';
		$options['404_layout'] = 'single';
		update_option('vicuna_layout', $options);
	}
	echo $options[$key];
}

function get_vicuna_css($page) {
	$options = get_option('vicuna_layout');
	$key = 'multi_'. $page .'_layout';
	$multi = $options[$key];
	$css = get_bloginfo('template_url') .'/style.php';
	if ($multi) {
		$css .= '?multi='. $multi;
	}
	return $css;
}

/**
 * Update parameters of layout
 */
function update_vicuna_layout() {
        if ( ! current_user_can('switch_themes') )
		return;

	$options = get_option('vicuna_layout');
	$keys = array('index', 'category', 'archive', 'tag', 'page', 'single', 'search', '404');
	foreach ($keys as $key) {
		$key .= '_layout';
		if (isset($_POST['vicuna_'. $key])) {
			if (mb_ereg('multi(1|2)', $_POST['vicuna_'. $key], $ary)) {
				$options[$key] = 'multi';
				$options['multi_'. $key] = $ary[1];
			} else {
				$options[$key] = $_POST['vicuna_'. $key];
				$options['multi_'. $key] = "";
			}
		}
	}
	update_option('vicuna_layout', $options);
}
add_action( 'init', 'update_vicuna_layout');

/**
 * Display menu of layout setting.
 */
function vicuna_layout_menu() {
        if ( ! current_user_can('switch_themes') )
		return;

	$options = get_option('vicuna_layout');
	$layout_index = $options['index_layout']; ?>
<div class="wrap">
	<h2><?php _e('Layout', 'vicuna'); ?></h2>
	<p><?php _e('You can select layout of your each pages.', 'vicuna'); ?></p>
	<form method="post" action="<?php echo attribute_escape($_SERVER['REQUEST_URI']); ?>">
		<p class="submit">
			<input type="submit" value="<?php _e('Save Changes &raquo;', 'vicuna'); ?>" />
		</p>
		<dl>
			<dt><?php _e('Index Layout', 'vicuna'); ?></dt>
			<dd><?php vicuna_layout_selector('vicuna_index_layout', $options['index_layout'] . $options['multi_index_layout']); ?></dd>
			<dt><?php _e('Category Layout', 'vicuna'); ?></dt>
			<dd><?php vicuna_layout_selector('vicuna_category_layout', $options['category_layout'] . $options['multi_category_layout']); ?></dd>
			<dt><?php _e('Archive Layout', 'vicuna'); ?></dt>
			<dd><?php vicuna_layout_selector('vicuna_archive_layout', $options['archive_layout'] . $options['multi_archive_layout']); ?></dd>
			<dt><?php _e('Tag Layout', 'vicuna'); ?></dt>
			<dd><?php vicuna_layout_selector('vicuna_tag_layout', $options['tag_layout'] . $options['multi_tag_layout']); ?></dd>
			<dt><?php _e('Single Layout', 'vicuna'); ?></dt>
			<dd><?php vicuna_layout_selector('vicuna_single_layout', $options['single_layout'] . $options['multi_single_layout']); ?></dd>
			<dt><?php _e('Page Layout', 'vicuna'); ?></dt>
			<dd><?php vicuna_layout_selector('vicuna_page_layout', $options['page_layout'] . $options['multi_page_layout']); ?></dd>
			<dt><?php _e('Search Layout', 'vicuna'); ?></dt>
			<dd><?php vicuna_layout_selector('vicuna_search_layout', $options['search_layout'] . $options['multi_search_layout']); ?></dd>
			<dt><?php _e('404 Layout', 'vicuna'); ?></dt>
			<dd><?php vicuna_layout_selector('vicuna_404_layout', $options['404_layout'] . $options['multi_404_layout']); ?></dd>
		</dl>
		<p class="submit">
			<input type="submit" value="<?php _e('Save Changes &raquo;', 'vicuna'); ?>" />
		</p>
	</form>
</div>
<?php
}

function vicuna_layout_selector($name, $layout) {
?>
			<select name="<?php echo $name; ?>">
					<option value="single"<?php if ($layout == "single") : echo ' selected'; endif; ?>>Single column</option>
					<option value="double"<?php if ($layout == "double") : echo ' selected'; endif; ?>>2column</option>
					<option value="multi1"<?php if ($layout == "multi1") : echo ' selected'; endif; ?>>3column type 1</option>
					<option value="multi2"<?php if ($layout == "multi2") : echo ' selected'; endif; ?>>3column type 2</option>
			</select>
<?php
}
?>