<?php
/**
 * The template for displaying single barbershop posts
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>

<div class="wrapper" id="single-barbershop-wrapper">
    <div id="content" class="container-fluid" style="background-color: #D5CCB8;">
        <div class="row">
            <div id="primary" class="col-lg-12 content-area">
                <main id="main" class="site-main" role="main">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <article <?php post_class('barbershop-single'); ?> id="post-<?php the_ID(); ?>">
                            <div class="barbershop-card">
                            <div class="barbershop-header">
    <div class="barbershop-info-left">
        <h1><?php the_title(); ?></h1>
        <p class="address"><?php echo esc_html(get_field('address')); ?></p>
        <div class="rating">
            <?php 
                $rating = get_field('rating');
                echo str_repeat('★', $rating);
            ?>
        </div>
    </div>
    <div class="barbershop-info-right">
        <h2>Opening hours</h2>
        <ul class="opening-hours">
            <li><strong>Mon:</strong> <?php echo esc_html(get_field('monday_hours')); ?></li>
            <li><strong>Tues:</strong> <?php echo esc_html(get_field('tuesday_hours')); ?></li>
            <li><strong>Wed:</strong> <?php echo esc_html(get_field('wednesday_hours')); ?></li>
            <li><strong>Thurs:</strong> <?php echo esc_html(get_field('thursday_hours')); ?></li>
            <li><strong>Fri:</strong> <?php echo esc_html(get_field('friday_hours')); ?></li>
            <li><strong>Sat:</strong> <?php echo esc_html(get_field('saturday_hours')); ?></li>
            <li><strong>Sun:</strong> <?php echo esc_html(get_field('sunday_hours')); ?></li>
        </ul>
        <p class="status"><?php echo esc_html(get_field('status')); ?></p>
    </div>
</div>


                                <div class="barbershop-details">
                                    <div class="barbershop-images">
                                        <?php if ( have_rows('gallery_images') ): ?>
                                            <div class="gallery">
                                                <?php while ( have_rows('gallery_images') ) : the_row(); ?>
                                                    <img src="<?php echo esc_url(get_sub_field('image')); ?>" alt="Gallery Image">
                                                <?php endwhile; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>


                                </div>

                                <div class="barbershop-services">
                                    <h2>Services</h2>
                                    <ul class="services-list">
                                        <li>Haircuts - ¥<?php echo esc_html(get_field('haircut_price')); ?></li>
                                        <li>Trims - ¥<?php echo esc_html(get_field('trim_price')); ?></li>
                                        <li>Shaves - ¥<?php echo esc_html(get_field('shave_price')); ?></li>
                                    </ul>
                                </div>

                                <div class="barbershop-english-level">
                                    <p>English level: <span class="english-<?php echo strtolower(esc_html(get_field('english_level'))); ?>">
                                        <?php echo esc_html(get_field('english_level')); ?>
                                    </span> (<?php echo esc_html(get_field('reviews_count')); ?> reviews)</p>
                                </div>

                                <div class="barbershop-map">
                                    <h2>Location</h2>
                                    <div class="map-container">
                                        <?php echo get_field('map_embed_code'); // Assuming you have a Google Maps embed code field ?>
                                    </div>
                                </div>
                                
                                <div class="barbershop-review">
                                    <h2>Customer Review</h2>
                                    <div class="review-content">
                                        <?php echo esc_html(get_field('customer_review')); // Assuming you have a field for a customer review ?>
                                    </div>
                                </div>

                                <div class="barbershop-login">
                                    <p>Please log in or register to rate their English communication skills.</p>
                                    <a href="<?php echo wp_login_url(); ?>" class="btn btn-primary">Log in</a>
                                    <a href="<?php echo wp_registration_url(); ?>" class="btn btn-secondary">Register</a>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </main><!-- #main -->
            </div><!-- #primary -->
        </div><!-- .row -->
    </div><!-- Container end -->
</div><!-- Wrapper end -->

<?php get_footer(); ?>
