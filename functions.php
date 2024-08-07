<?php
/**
 * UnderStrap functions and definitions
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// UnderStrap's includes directory.
$understrap_inc_dir = 'inc';

// Array of files to include.
$understrap_includes = array(
    '/theme-settings.php',                  // Initialize theme default settings.
    '/setup.php',                           // Theme setup and custom theme supports.
    '/widgets.php',                         // Register widget area.
    '/enqueue.php',                         // Enqueue scripts and styles.
    '/template-tags.php',                   // Custom template tags for this theme.
    '/pagination.php',                      // Custom pagination for this theme.
    '/hooks.php',                           // Custom hooks.
    '/extras.php',                          // Custom functions that act independently of the theme templates.
    '/customizer.php',                      // Customizer additions.
    '/custom-comments.php',                 // Custom Comments file.
    '/class-wp-bootstrap-navwalker.php',    // Load custom WordPress nav walker. Trying to get deeper navigation? Check out: https://github.com/understrap/understrap/issues/567.
    '/editor.php',                          // Load Editor functions.
    '/block-editor.php',                    // Load Block Editor functions.
    '/deprecated.php',                      // Load deprecated functions.
);

// Load WooCommerce functions if WooCommerce is activated.
if ( class_exists( 'WooCommerce' ) ) {
    $understrap_includes[] = '/woocommerce.php';
}

// Load Jetpack compatibility file if Jetpack is activiated.
if ( class_exists( 'Jetpack' ) ) {
    $understrap_includes[] = '/jetpack.php';
}

// Include files.
foreach ( $understrap_includes as $file ) {
    require_once get_theme_file_path( $understrap_inc_dir . $file );
}

// Create Barbershop custom post type
function create_barbershop_post_type() {
    register_post_type('barbershop',
        array(
            'labels' => array(
                'name' => __('Barbershops'),
                'singular_name' => __('Barbershop')
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail'),
            'rewrite' => array('slug' => 'barbershops'),
        )
    );
}
add_action('init', 'create_barbershop_post_type');

// Enqueue Barbershop scripts
function enqueue_barbershop_scripts() {
    wp_enqueue_script(
        'barbershop-js',
        get_template_directory_uri() . '/js/barbershop.js',
        array(),
        null,
        true
    );
}
add_action('wp_enqueue_scripts', 'enqueue_barbershop_scripts');


function enqueue_custom_scripts() {
    wp_enqueue_script('custom-script', get_template_directory_uri() . '/js/custom.js', array(), null, true);
    wp_enqueue_style('custom-styles', get_template_directory_uri() . '/css/theme.css');
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');


function register_my_menus() {
	register_nav_menus(
	  array(
		'primary' => __( 'Primary Menu', 'theme-slug' ),
		'mobile-menu' => __( 'Mobile Menu', 'theme-slug' )
	  )
	);
  }
  add_action( 'init', 'register_my_menus' );

  
  