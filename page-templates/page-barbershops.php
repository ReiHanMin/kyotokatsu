<?php
/**
 * Template Name: Template: Barbershops
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>
<div class="wrapper" id="page-wrapper">
    <div id="content" class="container">
        <div class="row">
            <div id="primary" class="col-lg-12 content-area">
                <main id="main" class="site-main" role="main">
                    <header class="entry-header">
                        <h1 class="entry-title">Barbershops in Kyoto</h1>
                    </header><!-- .entry-header -->

                    <div class="search-bar">
                        <input type="text" placeholder="Search" id="search-bar" class="form-control">
                        <button id="find-barber" class="btn btn-primary">Find my barber!</button>
                    </div>
                    <div class="filter-buttons">
                        <button data-filter="distance" class="btn btn-outline-secondary">Distance</button>
                        <button data-filter="english-level" class="btn btn-outline-secondary">English level</button>
                        <button data-filter="rating" class="btn btn-outline-secondary">Rating</button>
                        <button data-filter="price" class="btn btn-outline-secondary">Price</button>
                    </div>
                    <div class="barbershop-cards" id="barbershop-cards">
                        <!-- Barbershop cards will be inserted here dynamically -->
                    </div>
                </main><!-- #main -->
            </div><!-- #primary -->
        </div><!-- .row -->
    </div><!-- Container end -->
</div><!-- Wrapper end -->

<?php
get_footer();
?>
