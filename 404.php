<?php	get_header();
	$css = get_vicuna_css('404');
?>
	<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>" />
	<title><?php vicuna_title(__('Error 404', 'vicuna')); ?></title>
</head>
<body class="individual <?php vicuna_layout('404'); ?>">
<div id="header">
	<p class="siteName"><a href="<?php bloginfo('home'); ?>" title="<?php printf(__('Return to %s index', 'vicuna'), get_bloginfo('name')); ?>"><?php bloginfo('name'); ?></a></p>
	<?php vicuna_description(); ?>
<?php vicuna_global_navigation() ?>
</div>

<div id="content">
	<div id="main">
		<p class="topicPath"><a href="<?php bloginfo('home'); ?>" title="<?php _e('Home', 'vicuna'); ?>"><?php _e('Home', 'vicuna'); ?></a> &gt; <span class="current"><?php _e('Error 404', 'vicuna'); ?></span></p>
		<h1><?php _e('Error 404', 'vicuna'); ?> - <?php _e('Not Found', 'vicuna'); ?></h1>
		<div class="entry">
			<div class="textBody">
			<p><?php _e("Sorry, but you are looking for something that isn't here.", 'vicuna'); ?></p>
			</div>
		</div><!--end entry-->
		<p class="topicPath"><a href="<?php bloginfo('home'); ?>" title="<?php _e('Home', 'vicuna'); ?>"><?php _e('Home', 'vicuna'); ?></a> &gt; <span class="current"><?php _e('Error 404', 'vicuna'); ?></span></p>
	</div><!-- end main-->

<?php	get_sidebar(); ?>

<?php	get_footer(); ?>
