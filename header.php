<?php echo '<?xml version="1.0" encoding="'. get_bloginfo('charset') . '" ?>'; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
	$lang = get_vicuna_language();
	if (!$lang) {
		$lang = 'ja';
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo $lang; ?>" xml:lang="<?php echo $lang; ?>">
<head profile="http://purl.org/net/ns/metaprof">
	<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<meta name="generator" content="WordPress" />
	<meta name="author" content="<?php bloginfo('name'); ?>" />
<?php	if ( !is_home() ) : ?>
	<link rel="start" href="<?php bloginfo('home'); ?>" title="<?php bloginfo('name'); ?> Home" />
<?php	endif; ?>
<?php	if ( $description = get_bloginfo('description') ) : ?>
	<meta name="description" content="<?php bloginfo('description'); ?>" />
<?php	endif; ?>
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php	if ( is_single() || is_page() ) : ?>
	<script type="text/javascript" charset="utf-8" src="<?php echo get_vicuna_javascript_uri() ?>"></script>
<?php	endif; ?>
<?php 	wp_head(); ?>
