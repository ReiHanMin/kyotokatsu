<?php
/**
 * The header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$bootstrap_version = get_theme_mod( 'understrap_bootstrap_version', 'bootstrap4' );
$navbar_type       = get_theme_mod( 'understrap_navbar_type', 'collapse' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link href="https://fonts.googleapis.com/css2?family=Bangers&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php understrap_body_attributes(); ?>>
<?php do_action( 'wp_body_open' ); ?>
<div class="site" id="page">

    <!-- ******************* The Navbar Area ******************* -->
    <header id="wrapper-navbar" class="site-header">

        <a class="skip-link <?php echo understrap_get_screen_reader_class( true ); ?>" href="#content">
            <?php esc_html_e( 'Skip to content', 'understrap' ); ?>
        </a>

		<div class="container">
    <div class="mobile-nav-toggle">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <div class="header-logo">
        <a href="<?php echo home_url(); ?>">KYOTO/KATSU</a>
    </div>
    <nav class="main-nav">
        <?php
        wp_nav_menu( array(
            'theme_location' => 'primary',
            'menu_id'        => 'primary-menu',
        ) );
        ?>
    </nav>
    <nav class="mobile-nav">
        <?php
        wp_nav_menu( array(
            'theme_location' => 'mobile-menu',
            'menu_id'        => 'mobile-menu',
        ) );
        ?>
    </nav>
</div>



    </header><!-- #wrapper-navbar -->

