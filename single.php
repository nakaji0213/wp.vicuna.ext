<?php	get_header();
	$title = get_the_title();
	if ( is_attachment() ) :
		$older_post = &get_post($GLOBALS['post']->post_parent);
	else :
		$older_post = get_previous_post(false, '');
	endif;
	$css = get_vicuna_css('single');
	if ($older_post) : ?>
	<link rel="prev" href="<?php echo get_permalink($older_post->ID) ?>" title="<?php echo apply_filters('the_title', $older_post->post_title, $older_post) ?>" />
<?php endif; ?>
<?php	if ( $newer_post = get_next_post(false, '') ) : ?>
	<link rel="next" href="<?php echo get_permalink($newer_post->ID) ?>" title="<?php echo apply_filters('the_title', $newer_post->post_title, $newer_post) ?>" />
<?php	endif; ?>
	<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>" />
	<title><?php vicuna_title($title); ?></title>
</head>
<?php	if (have_posts()) : the_post(); ?>
<body class="individual <?php vicuna_layout('single'); ?>" id="entry<?php the_ID(); ?>">
<div id="header">
	<p class="siteName"><a href="<?php bloginfo('home'); ?>" title="<?php printf(__('Return to %s index', 'vicuna'), get_bloginfo('name')); ?>"><?php bloginfo('name'); ?></a></p>
	<?php vicuna_description(); ?>
<?php vicuna_global_navigation() ?>
</div>
<div id="content">
	<div id="main">
		<p class="topicPath"><a href="<?php bloginfo('home'); ?>" title="<?php _e('Home', 'vicuna'); ?>"><?php _e('Home', 'vicuna'); ?></a> &gt; <?php the_category(' | ') ?> &gt; <span class="current"><?php echo $title; ?></span></p>
		<ul class="flip" id="flip1">
<?php		if ($newer_post) : ?>
		<li class="newer"><a href="<?php echo get_permalink($newer_post->ID) ?>" title="<?php echo apply_filters('the_title', $newer_post->post_title, $newer_post) ?>" rel="nofollow"><?php _e('Newer', 'vicuna'); ?></a></li>
<?php		endif; ?>
<?php		if ( $older_post ) : ?>
		<li class="older"><a href="<?php echo get_permalink($older_post->ID) ?>" title="<?php echo apply_filters('the_title', $older_post->post_title, $older_post); ?>" rel="nofollow"><?php _e('Older', 'vicuna'); ?></a></li>
<?php		endif; ?>
		</ul>
		<h1><?php echo $title; ?></h1>
		<div class="entry">
			<ul class="info">
				<li class="date"><?php the_time(__('Y-m-d (D) G:i', 'vicuna')) ?></li>
				<li class="category"><?php the_category(' | ') ?></li>
				<?php if (function_exists('the_tags')) : the_tags('<li class="tags">', ' | ', '</li>'); endif; ?>
<?php		do_action('single_entry_info'); ?>
				<?php edit_post_link(__('Edit', 'vicuna'), '<li class="admin">', '</li>'); ?>
			</ul>
			<div class="textBody">
<?php		the_content(__('Continue reading', 'vicuna')); ?>
			</div>

<?php		do_action('entry_footer'); ?>

			<ul class="flip" id="flip2">
<?php		if ( $newer_post ) : ?>
				<li class="newer"><?php _e('Newer', 'vicuna'); ?>: <a href="<?php echo get_permalink($newer_post->ID) ?>" title="<?php _e('a newer entry', 'vicuna'); ?>"><?php echo apply_filters('the_title', $newer_post->post_title, $newer_post) ?></a></li>
<?php		endif; ?>
<?php		if ( $older_post ) : ?>
				<li class="older"><?php _e('Older', 'vicuna'); ?>: <a href="<?php echo get_permalink($older_post->ID) ?>" title="<?php _e('an older entry', 'vicuna'); ?>"><?php echo apply_filters('the_title', $older_post->post_title, $older_post) ?></a></li>
<?php		endif; ?>
			</ul>

<?php		comments_template(); ?>

		</div><!--end entry-->
		<p class="topicPath"><a href="<?php bloginfo('home'); ?>" title="<?php _e('Home', 'vicuna'); ?>"><?php _e('Home', 'vicuna'); ?></a> &gt; <?php the_category(' | ') ?> &gt; <span class="current"><?php echo $title; ?></span></p>
	</div><!-- end main-->

<?php		get_sidebar(); ?>

<?php		get_footer(); ?>
<?php	endif; ?>
