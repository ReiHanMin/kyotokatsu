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

                            <?php
                            // Set the opening and closing times before using them
                            $opening_time = get_field('opening_time');
                            $closing_time = get_field('closing_time');

                            $status = '';

                            if ($opening_time && $closing_time) {
                                $opening_time_timestamp = strtotime($opening_time);
                                $closing_time_timestamp = strtotime($closing_time);
                                $current_time = current_time('H:i');
                                $current_time_timestamp = strtotime($current_time);

                                // Determine status
                                if ($current_time_timestamp >= $opening_time_timestamp && $current_time_timestamp <= $closing_time_timestamp) {
                                    if ($current_time_timestamp >= ($closing_time_timestamp - 3600)) {
                                        $status = 'Closes soon at ' . $closing_time;
                                    } else {
                                        $status = 'Open now until ' . $closing_time;
                                    }
                                } elseif ($current_time_timestamp < $opening_time_timestamp) {
                                    if ($current_time_timestamp >= ($opening_time_timestamp - 3600)) {
                                        $status = 'Opens soon at ' . $opening_time;
                                    } else {
                                        $status = 'Closed, opens at ' . $opening_time;
                                    }
                                } else {
                                    $status = 'Closed, opens at ' . $opening_time;
                                }

                            } else {
                                $status = 'Closed';
                                // Debugging: No opening or closing times available
                                echo '<p>No opening or closing times available. Status set to Closed.</p>';
                            }
                            ?>

                            <div class="barbershop-card"
                                data-opening-time="<?php echo esc_attr($opening_time); ?>" 
                                data-closing-time="<?php echo esc_attr($closing_time); ?>">
                                
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
                                        <div class="status">
                                            <?php echo $status; ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="barbershop-content-grid">
                                    <div class="barbershop-images">
                                        <div class="gallery">
                                            <?php $image_1 = get_field('image_1'); ?>
                                            <?php if( $image_1 ): ?>
                                                <div class="image-item">
                                                    <img src="<?php echo esc_url($image_1['url']); ?>" alt="<?php echo esc_attr($image_1['alt']); ?>">
                                                </div>
                                            <?php endif; ?>

                                            <?php $image_2 = get_field('image_2'); ?>
                                            <?php if( $image_2 ): ?>
                                                <div class="image-item">
                                                    <img src="<?php echo esc_url($image_2['url']); ?>" alt="<?php echo esc_attr($image_2['alt']); ?>">
                                                </div>
                                            <?php endif; ?>

                                            <?php $image_3 = get_field('image_3'); ?>
                                            <?php if( $image_3 ): ?>
                                                <div class="image-item">
                                                    <img src="<?php echo esc_url($image_3['url']); ?>" alt="<?php echo esc_attr($image_3['alt']); ?>">
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="google-review">
                                        <h2>Customer Review</h2>
                                        <?php
                                        // Get the place_id from the ACF field
                                        $place_id = get_field('place_id');

                                        if ($place_id) {
                                            // Google API Key
                                            $api_key = GOOGLE_API_KEY; // Defined in wp-config.php

                                            // Make the API request
                                            $response = wp_remote_get("https://maps.googleapis.com/maps/api/place/details/json?place_id={$place_id}&fields=reviews&key={$api_key}");

                                            if (is_wp_error($response)) {
                                                echo '<p>Failed to retrieve reviews. Please try again later.</p>';
                                            } else {
                                                $body = wp_remote_retrieve_body($response);
                                                $data = json_decode($body);

                                                if (isset($data->error_message)) {
                                                    echo '<p>Error: ' . $data->error_message . '</p>';
                                                } elseif (!empty($data->result->reviews)) {
                                                    echo '<div class="google-review-list">';
                                                    foreach ($data->result->reviews as $review) {
                                                        echo "<div class='single-review' style='border-bottom: 1px solid #e0e0e0; padding: 10px 0;'>";
                                                        echo "<div style='display: flex; align-items: center;'>";
                                                        echo "<img src='{$review->profile_photo_url}' alt='{$review->author_name}' style='width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;'>";
                                                        echo "<div>";
                                                        echo "<strong><a href='{$review->author_url}' target='_blank' style='text-decoration: none; color: #333;'>{$review->author_name}</a></strong>";
                                                        echo "<div style='color: #999; font-size: 12px;'>{$review->relative_time_description}</div>";
                                                        echo "</div>";
                                                        echo "</div>";
                                                        echo "<div style='margin-top: 5px;'>";
                                                        echo "<div style='color: #f1c40f;'>";
                                                        for ($i = 0; $i < $review->rating; $i++) {
                                                            echo "★";
                                                        }
                                                        echo "</div>";
                                                        echo "<p style='margin-top: 5px; color: #333;'>{$review->text}</p>";
                                                        echo "</div>";
                                                        echo "</div>";
                                                    }
                                                    echo '</div>';
                                                } else {
                                                    echo "<p>No reviews available.</p>";
                                                }
                                            }
                                        } else {
                                            echo "<p>Place ID not available for this barbershop.</p>";
                                        }
                                        ?>
                                    </div>

                                    <div class="google-map">
                                        <h2>Location</h2>
                                        <div class="map-container">
                                            <?php 
                                            $google_maps_embed_code = get_field('google_maps_embed_code'); 
                                            ?>
                                            <iframe src="<?php echo esc_html($google_maps_embed_code); ?>" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                        </div>
                                    </div>

                                    <div class="barbershop-services">
                                        <h2>Services</h2>
                                        <ul class="services-list">
                                            <?php if( in_array('Haircuts', get_field('services')) && get_field('haircut_price') ): ?>
                                                <li>
                                                    <img src="<?php echo get_template_directory_uri(); ?>/img/scissors.png" alt="Haircut Icon" class="service-icon">
                                                    <span class="service-name">Haircuts</span>
                                                    <span class="service-price">¥<?php echo esc_html(get_field('haircut_price')); ?></span>
                                                </li>
                                            <?php endif; ?>
                                            
                                            <?php if( in_array('Shaves', get_field('services')) && get_field('shave_price') ): ?>
                                                <li>
                                                    <img src="<?php echo get_template_directory_uri(); ?>/img/shaver.png" alt="Shave Icon" class="service-icon">
                                                    <span class="service-name">Shaves</span>
                                                    <span class="service-price">¥<?php echo esc_html(get_field('shave_price')); ?></span>
                                                </li>
                                            <?php endif; ?>
                                            
                                            <?php if( in_array('Trims', get_field('services')) && get_field('trim_price') ): ?>
                                                <li>
                                                    <img src="<?php echo get_template_directory_uri(); ?>/img/comb.png" alt="Trim Icon" class="service-icon">
                                                    <span class="service-name">Trims</span>
                                                    <span class="service-price">¥<?php echo esc_html(get_field('trim_price')); ?></span>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>  
                                    
                                    <div class="barbershop-login">
                                        <p>Please log in or register to rate their English communication skills.</p>
                                        <a href="<?php echo wp_login_url(); ?>" class="btn btn-primary">Log in</a>
                                        <a href="<?php echo wp_registration_url(); ?>" class="btn btn-secondary">Register</a>
                                    </div>

                                    <div class="barbershop-english-level">
                                        <p>
                                            <img src="<?php echo get_template_directory_uri(); ?>/img/flag.png" alt="UK Flag" class="flag-icon">
                                            <span>English level: <span class="english-<?php echo strtolower(esc_html(get_field('english_level'))); ?>">
                                            <?php echo esc_html(get_field('english_level')); ?>
                                            </span> (<?php echo esc_html(get_field('reviews_count')); ?> reviews)</span>
                                        </p>
                                    </div>
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
