<?php
/* Header and Footer of Widget */
register_sidebar(array(
	'name' => 'navi',
	'before_widget' => "\t\t<dt id=\"".'%1$s'."\" class=\"widget ".'%1$s'."\">",
	'after_widget' => "\t\t</dd>\n",
	'before_title' => '',
	'after_title' => "</dt>\n\t\t<dd>\n",
));
register_sidebar(array(
	'name' => 'others',
	'before_widget' => "\t\t<dt id=\"".'%1$s'."\" class=\"widget ".'%1$s'."\">",
	'after_widget' => "\t\t</dd>\n",
	'before_title' => '',
	'after_title' => "</dt>\n\t\t<dd>\n",
));

/**
 * Display a widget of calendar.
 */
function vicuna_widget_calendar($args) {
	extract($args);
	$options = get_option('widget_calendar');
	$title = empty($options['title']) ? __('Calendar', 'vicuna') : $options['title'];
	echo $before_widget . $before_title . $title . $after_title;
	vicuna_calendar();
	echo $after_widget;
}

/**
 * Display a widget of search form.
 */
function vicuna_widget_search($args) {
	extract($args);
	$options = get_option('widget_search');
	$title = empty($options['title']) ? __('Search', 'vicuna') : $options['title'];
	echo $before_widget . $before_title . $title . $after_title;
?>
			<form method="get" action="<?php bloginfo('home'); ?>/">
				<fieldset>
					<legend><label for="searchKeyword"><?php printf(__('Search %s', 'vicuna'), get_bloginfo('name')); ?></label></legend>
					<div>
						<input type="text" class="inputField" id="searchKeyword"  name="s" size="10" onfocus="if (this.value == 'Keyword(s)') this.value = '';" onblur="if (this.value == '') this.value = 'Keyword(s)';" value="<?php if ( is_search() ) echo wp_specialchars($s, 1); else echo 'Keyword(s)'; ?>" />
						<input type="submit" class="submit" id="submit" value="Search" />
					</div>
				</fieldset>
			</form>
<?php
	echo $after_widget;
}

/**
 * Search Widget Control
 */
function vicuna_widget_search_control() {
	$options = $newoptions = get_option('widget_search');
	if ( $_POST["search-submit"] ) {
		$newoptions['title'] = strip_tags(stripslashes($_POST["search-title"]));
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('widget_search', $options);
	}
	$title = attribute_escape($options['title']);
?>
			<p><label for="search-title"><?php _e('Title'); ?>: <input style="width: 250px;" id="search-title" name="search-title" type="text" value="<?php echo $title; ?>" /></label></p>
			<input type="hidden" id="search-submit" name="search-submit" value="1" />
<?php
}

/**
 * Display Meta Widget
 */
function vicuna_widget_meta($args) {
	extract($args);
	$options = get_option('widget_meta');
	$title = empty($options['title']) ? __('Meta') : $options['title'];
	echo $before_widget . $before_title . $title . $after_title;
?>
			<ul>
				<li><a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.0 Strict" rel="nofollow">Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a></li>
<?php	wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
<?php	wp_meta(); ?>
			</ul>
<?php
	echo $after_widget;
}

/**
 *
 */
function vicuna_widget_layout_manager($args) {
        if ( ! current_user_can('switch_themes') )
		return;
	extract($args);
	$options = get_option('vicuna_layout');
	$title = empty($options['title']) ? __('Layout Manager') : $options['title'];
	echo $before_widget . $before_title . $title . $after_title;
?>
			<form method="post">
				<fieldset>
<?php		if (is_home()) { ?>
				<legend><label for="layout"><?php _e('Index Layout', 'vicuna'); ?></label></legend>
					<div>
<?php			vicuna_layout_selector('vicuna_index_layout', $options['index_layout'] . $options['multi_index_layout']);
		} else if (is_category() ) { ?>
				<legend><label for="layout"><?php _e('Category Layout', 'vicuna'); ?></label></legend>
					<div>
<?php			vicuna_layout_selector('vicuna_category_layout', $options['category_layout'] . $options['multi_category_layout']);
		} else if (is_archive()) { ?>
				<legend><label for="layout"><?php _e('Archive Layout', 'vicuna'); ?></label></legend>
					<div>
<?php			vicuna_layout_selector('vicuna_archive_layout', $options['archive_layout'] . $options['multi_archive_layout']);
		} else if (is_search()) { ?>
				<legend><label for="layout"><?php _e('Search Layout', 'vicuna'); ?></label></legend>
					<div>
<?php			vicuna_layout_selector('vicuna_search_layout', $options['search_layout'] . $options['multi_search_layout']);
		} else if (is_page()) { ?>
				<legend><label for="layout"><?php _e('Page Layout', 'vicuna'); ?></label></legend>
					<div>
<?php			vicuna_layout_selector('vicuna_page_layout', $options['page_layout'] . $options['multi_page_layout']);
		} else if (is_single()) { ?>
				<legend><label for="layout"><?php _e('Single Layout', 'vicuna'); ?></label></legend>
					<div>
<?php			vicuna_layout_selector('vicuna_single_layout', $options['single_layout'] . $options['multi_single_layout']);
		} else if (is_404()) { ?>
				<legend><label for="layout"><?php _e('404 Layout', 'vicuna'); ?></label></legend>
					<div>
<?php			vicuna_layout_selector('vicuna_404_layout', $options['404_layout'] . $options['multi_404_layout']);
		} else if (is_tag()) { ?>
				<legend><label for="layout"><?php _e('Tag Layout', 'vicuna'); ?></label></legend>
					<div>
<?php			vicuna_layout_selector('vicuna_tag_layout', $options['tag_layout'] . $options['multi_tag_layout']);
		}
?>
					<input type="submit" class="submit" id="submit" value="<?php _e('Save'); ?>" />
					</div>
				</fieldset>
			</form>
<?php
	echo $after_widget;
}


/**
 * Recent Reactions Widget
 */
function vicuna_widget_recent_reactions($args) {
	extract($args);
	extract($args, EXTR_SKIP);
	$options = get_option('widget_recent_reactions');
	$title = empty($options['title']) ? __('Recent Reactions') : $options['title'];
	if ( !$number = (int) $options['number'] )
		$number = 5;
	else if ( $number < 1 )
		$number = 1;
	else if ( $number > 15 )
		$number = 15;

	echo $before_widget . $before_title . $title . $after_title;
	get_recent_reactions_list($number);
	echo $after_widget;
}

/**
 * Recent Comments Widget
 */
function vicuna_widget_recent_comments($args) {
	extract($args);
	extract($args, EXTR_SKIP);
	$options = get_option('widget_recent_comments');
	$title = empty($options['title']) ? __('Recent Comments') : $options['title'];
	if ( !$number = (int) $options['number'] )
		$number = 5;
	else if ( $number < 1 )
		$number = 1;
	else if ( $number > 15 )
		$number = 15;

	echo $before_widget . $before_title . $title . $after_title;
	get_recent_comments_list($number);
	echo $after_widget;
}

/**
 * Recent Pings Widget
 */
function vicuna_widget_recent_pings($args) {
	extract($args);
	extract($args, EXTR_SKIP);
	$options = get_option('widget_recent_pings');
	$title = empty($options['title']) ? __('Recent Pings') : $options['title'];
	if ( !$number = (int) $options['number'] )
		$number = 5;
	else if ( $number < 1 )
		$number = 1;
	else if ( $number > 15 )
		$number = 15;

	echo $before_widget . $before_title . $title . $after_title;
	get_recent_pings_list($number);
	echo $after_widget;
}

function get_recent_reactions_list($number = 5) {
	global $wpdb, $comments, $comment;
	if ( !$comments = wp_cache_get( 'recent_reactions', 'widget' ) ) {
		$comments = $wpdb->get_results("SELECT comment_author, comment_author_url, comment_ID, comment_post_ID, comment_date, comment_type FROM $wpdb->comments WHERE comment_approved = '1' ORDER BY comment_date_gmt DESC LIMIT $number");
		wp_cache_add( 'recent_reactions', $comments, 'widget' );
	}
?>
				<ul id="recent_reactions">
<?php	if ( $comments ) {
		$post_ID = -1;
		foreach ($comments as $comment) {
			if ($comment->comment_post_ID != $post_ID) {
				if ($post_ID >= 0) {
?>
					</ul></li>
<?php
				}
				$post_ID = $comment->comment_post_ID;
?>
					<li class="comment_on"><a href="<?php echo get_permalink($post_ID); ?>#comments"><?php echo get_the_title($post_ID); ?></a><ul>
<?php			}
			$type = $comment->comment_type ? 'ping' : 'comment';
?>
						<li class="comment_author"><a href="<?php echo get_permalink($post_ID); ?>#<?php echo $type . $comment->comment_ID; ?>"><?php comment_time('Y-m-d'); ?> <?php comment_author(); ?></a></li>
<?php		}
	} ?>
					</ul></li>
				</ul>
<?php
}

function get_recent_comments_list($number = 5) {
	global $wpdb, $comments, $comment;
	if ( !$comments = wp_cache_get( 'recent_comments', 'widget' ) ) {
		$comments = $wpdb->get_results("SELECT comment_author, comment_author_url, comment_ID, comment_post_ID, comment_date FROM $wpdb->comments WHERE comment_approved = '1' AND comment_type = '' ORDER BY comment_date_gmt DESC LIMIT $number");
		wp_cache_add( 'recent_comments', $comments, 'widget' );
	}
?>
				<ul id="recent_comments">
<?php	if ( $comments ) {
		$post_ID = -1;
		foreach ($comments as $comment) {
			if ($comment->comment_post_ID != $post_ID) {
				if ($post_ID >= 0) {
?>
					</ul></li>
<?php				}
				$post_ID = $comment->comment_post_ID;
?>
					<li class="comment_on"><a href="<?php echo get_permalink($post_ID); ?>#comments"><?php echo get_the_title($post_ID); ?></a><ul>
<?php
			} ?>
						<li class="comment_author"><a href="<?php echo get_permalink($post_ID); ?>#comment<?php echo $comment->comment_ID; ?>"><?php comment_time('Y-m-d'); ?> <?php comment_author(); ?></a></li>
<?php
		}
	} ?>
					</ul></li>
				</ul>
<?php
}

function get_recent_pings_list($number = 5) {
	global $wpdb, $comments, $comment;
	if ( !$comments = wp_cache_get( 'recent_pings', 'widget' ) ) {
		$comments = $wpdb->get_results("SELECT comment_author, comment_author_url, comment_ID, comment_post_ID, comment_date FROM $wpdb->comments WHERE comment_approved = '1' AND (comment_type = 'trackback' OR comment_type = 'pingback') ORDER BY comment_date_gmt DESC LIMIT $number");
		wp_cache_add( 'recent_pings', $comments, 'widget' );
	}
?>
				<ul id="recentpings">
<?php	if ( $comments ) {
		$post_ID = -1;
		foreach ($comments as $comment) {
			if ($comment->comment_post_ID != $post_ID) {
				if ($post_ID >= 0) {
?>
					</ul></li>
<?php				}
				$post_ID = $comment->comment_post_ID;
?>
					<li class="recentpings"><a href="<?php echo get_permalink($post_ID); ?>#trackback"><?php echo get_the_title($post_ID); ?></a><ul>
<?php
			}
?>
						<li class="recentpings"><a href="<?php echo get_permalink($post_ID); ?>#ping<?php echo $comment->comment_ID ?>"><? comment_time('Y-m-d'); ?> <?php comment_author(); ?></a></li>
<?php
		}
	}
?>
					</ul></li>
				</ul>
<?php
}

/**
 * Recent Reactions Widget Control
 */
function vicuna_widget_recent_reactions_control() {
	$options = $newoptions = get_option('widget_recent_reactions');
	if ( $_POST["recent-reactions-submit"] ) {
		$newoptions['title'] = strip_tags(stripslashes($_POST["recent-reactions-title"]));
		$newoptions['number'] = (int) $_POST["recent-reactions-number"];
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('widget_recent_reactions', $options);
		vicuna_delete_recent_comments_cache();
	}
	$title = attribute_escape($options['title']);
	if ( !$number = (int) $options['number'] )
		$number = 5;
?>
				<p><label for="recent-reactions-title"><?php _e('Title:', 'vicuna'); ?> <input style="width: 250px;" id="recent-reactions-title" name="recent-reactions-title" type="text" value="<?php echo $title; ?>" /></label></p>
				<p><label for="recent-reactions-number"><?php _e('Number of reactions to show:', 'vicuna'); ?> <input style="width: 25px; text-align: center;" id="recent-reactions-number" name="recent-reactions-number" type="text" value="<?php echo $number; ?>" /></label> <?php _e('(at most 15)', 'vicuna'); ?></p>
				<input type="hidden" id="recent-reactions-submit" name="recent-reactions-submit" value="1" />
<?php
}

/**
 * Recent Pings Widget Control
 */
function vicuna_widget_recent_pings_control() {
	$options = $newoptions = get_option('widget_recent_pings');
	if ( $_POST["recent-pings-submit"] ) {
		$newoptions['title'] = strip_tags(stripslashes($_POST["recent-pings-title"]));
		$newoptions['number'] = (int) $_POST["recent-pings-number"];
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('widget_recent_pings', $options);
		vicuna_delete_recent_comments_cache();
	}
	$title = attribute_escape($options['title']);
	if ( !$number = (int) $options['number'] )
		$number = 5;
?>
				<p><label for="recent-pings-title"><?php _e('Title:'); ?> <input style="width: 250px;" id="recent-pings-title" name="recent-pings-title" type="text" value="<?php echo $title; ?>" /></label></p>
				<p><label for="recent-pings-number"><?php _e('Number of pings to show:'); ?> <input style="width: 25px; text-align: center;" id="recent-pings-number" name="recent-pings-number" type="text" value="<?php echo $number; ?>" /></label> <?php _e('(at most 15)'); ?></p>
				<input type="hidden" id="recent-pings-submit" name="recent-pings-submit" value="1" />
<?php
}

function vicuna_list_pages() {
	global $wpdb, $class, $post;

	// Query pages.
	$pages = get_pages('');

	if (!empty($pages)) {
		echo "<table>\n";
		foreach ( $pages as $post) {
			setup_postdata( $post);
			if ( '0000-00-00 00:00:00' == $post->post_modified )
				continue;
			if ( $hierarchy && ($post->post_parent != $parent) )
				continue;

			$post->post_title = wp_specialchars( $post->post_title );
			$pad = str_repeat( '&#8212; ', $level );
			$id = (int) $post->ID;
			$class = ('alternate' == $class ) ? '' : 'alternate';
	?>
		<tr id='page-<?php echo $id; ?>' class='<?php echo $class; ?>'>
			<th scope="row" style="text-align: center"><?php echo $post->ID; ?></th>
			<td>
				<?php echo $pad; ?><?php the_title() ?>
			</td>
			<td><?php the_author() ?></td>
			<td><?php echo mysql2date( __('Y-m-d g:i a'), $post->post_modified ); ?></td>
			<td><a href="<?php the_permalink(); ?>" rel="permalink" class="view"><?php _e( 'View' ); ?></a></td>
		</tr>
	<?php
			if ( $hierarchy ) page_rows( $id, $level + 1, $pages );
		}
		echo "</table>\n";
	}
	return $output;
}

function vicuna_widget_pages_control() {
        $options = $newoptions = get_option('widget_pages');
        if ( $_POST['pages-submit'] ) {
                $newoptions['title'] = strip_tags(stripslashes($_POST['pages-title']));

                $sortby = stripslashes( $_POST['pages-sortby'] );

                if ( in_array( $sortby, array( 'post_title', 'menu_order', 'ID' ) ) ) {
                        $newoptions['sortby'] = $sortby;
                } else {
                        $newoptions['sortby'] = 'menu_order';
                }

                $newoptions['exclude'] = strip_tags( stripslashes( $_POST['pages-exclude'] ) );
        }
        if ( $options != $newoptions ) {
                $options = $newoptions;
                update_option('widget_pages', $options);
        }
        $title = attribute_escape($options['title']);
        $exclude = attribute_escape( $options['exclude'] );
?>
                        <p><label for="pages-title"><?php _e('Title:'); ?> <input style="width: 250px;" id="pages-title" name="pages-title" type="text" value="<?php echo $title; ?>" /></label></p>
                        <p><label for="pages-sortby"><?php _e( 'Sort by:' ); ?>
                                <select name="pages-sortby" id="pages-sortby">
                                        <option value="post_title"<?php selected( $options['sortby'], 'post_title' ); ?>><?php _e('Page title'); ?></option>
                                        <option value="menu_order"<?php selected( $options['sortby'], 'menu_order' ); ?>><?php _e('Page order'); ?></option>
                                        <option value="ID"<?php selected( $options['sortby'], 'ID' ); ?>><?php _e( 'Page ID' ); ?></option>
                                </select></label></p>
                        <p><label for="pages-exclude"><?php _e( 'Exclude:' ); ?> <input type="text" value="<?php echo $exclude; ?>" name="pages-exclude" id="pages-exclude" style="width: 180px;" /></label><br />
                        <small><?php _e( 'Page IDs, separated by commas.' ); ?></small></p>
                        <input type="hidden" id="pages-submit" name="pages-submit" value="1" />
<?php
	vicuna_list_pages();
}


function vicuna_delete_recent_comments_cache() {
	wp_cache_delete( 'recent_comments', 'widget' );
	wp_cache_delete( 'recent_pings', 'widget' );
	wp_cache_delete( 'recent_reactions', 'widget' );
}

add_action( 'comment_post', 'vicuna_delete_recent_comments_cache' );
add_action( 'wp_set_comment_status', 'vicuna_delete_recent_comments_cache' );

/* Override Widget */
wp_register_sidebar_widget('calendar', __('Calendar', 'vicuna'), 'vicuna_widget_calendar');
wp_register_sidebar_widget('search', __('Search', 'vicuna'), 'vicuna_widget_search');
register_widget_control('search', 'vicuna_widget_search_control', 300, 90);
wp_register_sidebar_widget('meta', __('Meta'), 'vicuna_widget_meta');

wp_register_widget_control('pages', __('Pages'), 'vicuna_widget_pages_control', 300, 90);

/* Add Widget */
wp_register_sidebar_widget('recent-reactions', __('Recent Reactions'), 'vicuna_widget_recent_reactions');
register_widget_control('recent-reactions', 'vicuna_widget_recent_reactions_control', 300, 90);
wp_register_sidebar_widget('recent-comments', __('Recent Comments'), 'vicuna_widget_recent_comments');
wp_register_sidebar_widget('recent-pings', __('Recent Pings'), 'vicuna_widget_recent_pings');
register_widget_control('recent-pings', 'vicuna_widget_recent_pings_control', 300, 90);

wp_register_sidebar_widget('layout-manager', __('Layout Manager'), 'vicuna_widget_layout_manager');

?>
