<?php	get_header();
	$page_title = get_vicuna_archive_title();
	$css = get_vicuna_css('archive');
?>
	<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>" />
	<title><?php vicuna_title($page_title); ?></title>
</head>
<body class="dateBasedArchive <?php vicuna_layout('archive'); ?>">
<div id="header">
	<p class="siteName"><a href="<?php bloginfo('home'); ?>" title="<?php printf(__('Return to %s index', 'vicuna'), get_bloginfo('name')); ?>"><?php bloginfo('name'); ?></a></p>
	<?php vicuna_description(); ?>
<?php vicuna_global_navigation() ?>
</div>
<div id="content">
	<div id="main">
		<p class="topicPath"><a href="<?php bloginfo('home'); ?>" title="<?php _e('Home', 'vicuna'); ?>"><?php _e('Home', 'vicuna'); ?></a> &gt; <?php _e('Archives', 'vicuna'); ?> &gt; <span class="current"><?php echo $page_title; ?></span></p>
		<h1><?php echo $page_title; ?></h1>
<?php
	if (have_posts()) :
		while (have_posts()) : the_post();
			$title = get_the_title();
?>

		<div class="section entry" id="entry<?php the_ID(); ?>">
			<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
			<ul class="info">
				<li class="date"><?php the_time(__('Y-m-d (D)', 'vicuna')) ?></li>
				<li class="category"><?php the_category(' | ') ?></li>
				<?php if (function_exists('the_tags')) : the_tags('<li class="tags">', ' | ', '</li>'); endif; ?>
<?php			do_action('entry_info'); ?>
				<?php edit_post_link(__('Edit', 'vicuna'), '<li class="admin">', '</li>'); ?>
			</ul>
			<div class="textBody">
<?php the_content('Continue reading', 'vicuna'); ?>
			</div>
			<ul class="reaction">
<?php
			$trackpingCount = get_vicuna_pings_count();
			$commentCount = (int) get_comments_number() - (int) $trackpingCount;
			if ($commentCount > 0 || 'open' == $post->comment_status) : ?>
				<li class="comment"><a href="<?php the_permalink() ?>#comments" title="<?php printf(__('Comments on %s', 'vicuna'), $title); ?>" rel="nofollow"><?php if ('open' == $post->comment_status) : _e('Comments', 'vicuna'); else : _e('Comments (Close)', 'vicuna'); endif; ?></a>: <span class="count"><?php echo $commentCount; ?></span></li>
<?php			else : ?>
				<li><?php _e('Comments (Close)', 'vicuna'); ?>: <span class="count"><?php echo $commentCount; ?></span></li>
<?php
			endif;
			if ($trackpingCount > 0 || 'open' == $post->ping_status) :
?>
				<li class="trackback"><a href="<?php the_permalink() ?>#trackback" title="<?php printf(__('Trackbacks to %s', 'vicuna'), $title); ?>" rel="nofollow"><?php if ('open' == $post->ping_status) : _e('Trackbacks', 'vicuna'); else : _e('Trackbacks (Close)', 'vicuna'); endif; ?></a>: <span class="count"><?php echo $trackpingCount; ?></span></li>
<?php			else : ?>
				<li><?php _e('Trackbacks (Close)', 'vicuna'); ?>: <span class="count"><?php echo $trackpingCount; ?></span></li>
<?php			endif ?>
<?php			do_action('entry_reaction'); ?>
			</ul>
		</div>
<?php
		endwhile;
	endif;
?>
<?php	do_action('entries_footer'); ?>
		<p class="topicPath"><a href="<?php bloginfo('home'); ?>" title="<?php _e('Home', 'vicuna'); ?>"><?php _e('Home', 'vicuna'); ?></a> &gt; <?php _e('Archives', 'vicuna'); ?> &gt; <span class="current"><?php echo $page_title; ?></span></p>

	</div><!-- end main-->

<?php	get_sidebar(); ?>

<?php	get_footer(); ?>
