<?php	if (have_posts()) : the_post();
		get_header();
		$title = get_the_title();
		$css = get_vicuna_css('page');
		$navi_title = get_post_meta(get_the_ID(), 'navi', true);
		if (empty($navi_title)) $navi_title = $title;
?>
	<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>" />
	<title><?php vicuna_title($title); ?></title>
</head>
<body class="individual <?php vicuna_layout('page'); ?>" id="entry<?php the_ID(); ?>">
<div id="header">
	<p class="siteName"><a href="<?php bloginfo('home'); ?>" title="<?php printf(__('Return to %s index', 'vicuna'), get_bloginfo('name')); ?>"><?php bloginfo('name'); ?></a></p>
	<?php vicuna_description(); ?>
<?php		vicuna_global_navigation() ?>
</div>

<div id="content">
	<div id="main">
		<p class="topicPath"><a href="<?php bloginfo('home'); ?>" title="<?php _e('Home', 'vicuna'); ?>"><?php _e('Home', 'vicuna'); ?></a><?php
		$parent_pages = get_vicuna_page_navigation('sort_column=menu_order');
		if ($parent_pages) : ?> &gt; <?php echo $parent_pages; ?><?php endif; ?> &gt; <span class="current"><?php echo $navi_title; ?></span></p>
		<h1><?php echo $title; ?></h1>
		<div class="entry">
			<ul class="info">
				<li class="date"><?php echo get_the_modified_time(__('Y-m-d (D) G:i', 'vicuna')); ?></li>
<?php		do_action('page_entry_info'); ?>
				<?php edit_post_link(__('Edit', 'vicuna'), '<li class="admin">', '</li>'); ?>
			</ul>
			<div class="textBody">
<?php		the_content(__('Continue reading', 'vicuna')); ?>
			</div>
<?php		comments_template(); ?>
		</div><!--end entry-->
		<p class="topicPath"><a href="<?php bloginfo('home'); ?>" title="<?php _e('Home', 'vicuna'); ?>"><?php _e('Home', 'vicuna'); ?></a><?php if ($parent_pages) : ?> &gt; <?php echo $parent_pages; ?><?php endif; ?> &gt; <span class="current"><?php echo $navi_title; ?></span></p>
	</div><!-- end main-->
<?php		get_sidebar(); ?>
<?php		get_footer(); ?>
<?php	endif; ?>
