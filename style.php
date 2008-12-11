<?php
$cwd = dirname(__FILE__);
$dir = mb_substr( $cwd, 0, mb_strrpos($cwd, 'wp-content'));

require_once($dir.'wp-config.php');

$config = get_option('vicuna_config');

$skin = $config['skin'];

if (!isset($config['skin'])) {
	$config['skin'] = 'style-smartCanvas';
	update_option('vicuna_config', $config);
}
$multi = $_GET['multi'];

$eye_catch = $config['eye_catch'];
header("Content-Type: text/css");
?>
@charset "utf-8";

@import url(<?php echo $skin; ?>/1-element.css);
@import url(<?php echo $skin; ?>/2-class.css);
@import url(<?php echo $skin; ?>/3-context.css);
@import url(<?php echo $skin; ?>/4-layout.css);
@import url(<?php echo $skin; ?>/module/mod_subSkin/1-subSkin.css);
@import url(<?php echo $skin; ?>/module/mod_subSkin/2-singleUtilities.css);


<?php if ( $config['g_navi'] ) : ?>
@import url(<?php echo $skin; ?>/module/mod_gNavi/mod_gNavi.css);
<?php endif; ?>
<?php if ( $eye_catch ) : ?>
@import url(<?php echo $skin; ?>/module/mod_eyeCatch-<?php echo $eye_catch; ?>.css);
<?php endif; ?>
<?php if ( is_widget('navi', 'calendar') || is_widget('others', 'calendar') ) : ?>
@import url(<?php echo $skin; ?>/module/mod_calendar.css);
<?php endif; ?>
<?php if ( isset($multi) ) : ?>
@import url(<?php echo $skin; ?>/module/mod_multiCol-Type<?php echo $multi; ?>.css);
<?php endif; ?>

<?php do_action('vicuna_plugin_css'); ?>
