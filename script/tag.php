<?php
/**
 * Display a tag clouds.
 */
function vicuna_tag_cloud( $args = '' ) {

	global $wp_rewrite;
	$defaults = array( 'levels' => 6, 'orderby' => 'name', 'order' => 'ASC', 'exclude' => '', 'include' => '' );

	$args = wp_parse_args( $args, $defaults );

	$tags = get_tags( array_merge($args, array('orderby' => 'count', 'order' => 'ASC') ) ); // Always query top tags

	if ( empty($tags) )
		return;

	extract($args);

	if ( !$tags )
		return;
	$counts = $tag_links = array();
	foreach ( (array) $tags as $tag ) {
		$counts[$tag->name] = $tag->count;
		$tag_links[$tag->name] = get_tag_link( $tag->term_id );
		if ( is_wp_error( $tag_links[$tag->name] ) )
			return $tag_links[$tag->name];
		$tag_ids[$tag->name] = $tag->term_id;
	}

	$min_count = min($counts);
	$step = (int) ((max($counts) - $min_count) / $levels) + 1;
	
	if ( $step <= 1 )
		$step = 1;

	// SQL cannot save you; this is a second (potentially different) sort on a subset of data.
	if ( 'name' == $orderby )
		uksort($counts, 'strnatcasecmp');
	else
		asort($counts);

	if ( 'DESC' == $order )
		$counts = array_reverse( $counts, true );

	$a = array();

	$rel = ( is_object($wp_rewrite) && $wp_rewrite->using_permalinks() ) ? ' rel="tag"' : '';

	foreach ( $counts as $tag => $count ) {
		$tag_id = $tag_ids[$tag];
		$tag_link = clean_url($tag_links[$tag]);
		$level = $levels - (int) (($count - $min_count) / $step);
		$tag = str_replace(' ', '&nbsp;', wp_specialchars( $tag ));
		$a[] = "<li class=\"level".$level."\"><a href=\"$tag_link\" title=\"" . attribute_escape( sprintf( __('%d Entries', 'vicuna'), $count ) ) . "\"$rel>$tag</a></li>";
	}

	$return = "<ul class=\"tagCloud\">\n\t";
	$return .= join("\n\t", $a);
	$return .= "\n</ul>\n";

	if ( is_wp_error( $return ) )
		return false;
	else 
		echo apply_filters( 'vicuna_tag_cloud', $return, $tags, $args );
}

/**
 * Display a widget of tag clouds.
 */
function vicuna_widget_tag_cloud($args) {
	extract($args);
	$options = get_option('widget_tag_cloud');
	$title = empty($options['title']) ? __('Tag Cloud', 'vicuna') : $options['title'];

	echo $before_widget;
	echo $before_title . $title . $after_title;
	vicuna_tag_cloud();
	echo $after_widget;
}
wp_register_sidebar_widget('tag_cloud', __('Tag Cloud', 'vicuna'), 'vicuna_widget_tag_cloud');

?>