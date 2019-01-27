<?php
/**
 * WP Bootstrap Starter Child functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WP_Bootstrap_Starter_Child
 */

error_reporting(E_ERROR | E_WARNING | E_PARSE & ~(E_NOTICE | E_USER_NOTICE | E_STRICT | E_ALL ));
require(get_stylesheet_directory()."/stds/Base/stds_autoloader.php");
$loader = new Psr4AutoloaderClass();
$loader->register();
$loader->addNameSpace('Stds',get_stylesheet_directory().'/stds');

require('func_includes/functions-wp-bootstrap-starter-setup.php');
require('func_includes/wp_bootstrap_starter_child_scripts.php');
require('func_includes/wp_enqueue_scripts_by_page.php');
require('func_includes/common_funcs.php');


require get_stylesheet_directory() . '/inc/customizer.php';



// Same handler function...
// !!!! IMPORTANT  - TO REMOVE NOPRIV NOPRIV ONLY FOR NOT LOGGED IN USERS!!!
add_action( 'wp_ajax_stds_router', 'stds_router' );
add_action('wp_ajax_nopriv_stds_router','stds_router');
function stds_router() {
    require('ajax_router.php');
    $_r = new AjaxRouter();
    echo $_r->index($_REQUEST);
	wp_die();
	
}

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
//require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
//require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
//require get_template_directory() . '/inc/customizer.php';

/**
 * Load plugin compatibility file.
 */
//require get_template_directory() . '/inc/plugin-compatibility/plugin-compatibility.php';

/**
 * Load custom WordPress nav walker.
 */
if ( ! class_exists( 'wp_bootstrap_navwalker' )) {
    require_once(get_template_directory() . '/inc/wp_bootstrap_navwalker.php');
}