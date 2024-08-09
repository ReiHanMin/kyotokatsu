<?php
/**
 * Template Name: Template: Barbershops
 *
 * Template for displaying a page without a sidebar even if a sidebar widget is published.
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>

<div class="wrapper" id="page-wrapper">
    <div id="content" class="container-fluid barbershops-page" style="background-color: #D5CCB8;">
        <div class="row">
            <div id="primary" class="col-lg-12 content-area">
                <main id="main" class="site-main" role="main">
                    <div class="barbershop-cards">
                        <?php
                        // The Query
                        $args = array(
                            'post_type' => 'barbershop',
                            'posts_per_page' => -1
                        );
                        $the_query = new WP_Query($args);

                        // The Loop
                        if ($the_query->have_posts()) {
                            while ($the_query->have_posts()) {
                                $the_query->the_post();
                                $rating = get_field('rating'); // Assuming you have a custom field for rating
                                $services = get_field('services'); // Assuming you have a custom field for services
                                $english_level = get_field('english_level'); // Assuming you have a custom field for English level
                                $latitude = get_field('latitude'); // Assuming you have a custom field for latitude
                                $longitude = get_field('longitude'); // Assuming you have a custom field for longitude
                                $status = get_field('status'); // Assuming you have a custom field for status
                                $opening_time = get_field('opening_time');
                                $closing_time = get_field('closing_time');
                                ?>
                                <a href="<?php the_permalink(); ?>" class="barbershop-card-link">
                                    <div class="barbershop-card hidden" data-latitude="<?php echo esc_attr($latitude); ?>" data-longitude="<?php echo esc_attr($longitude); ?>" data-opening-time="<?php echo esc_attr($opening_time); ?>" data-closing-time="<?php echo esc_attr($closing_time); ?>">
                                        <?php if (has_post_thumbnail()) {
                                            the_post_thumbnail('full', ['class' => 'barbershop-image']);
                                        } ?>
                                        <h3><?php the_title(); ?></h3>
                                        <div class="rating"><?php echo str_repeat('★', $rating); ?></div>
                                        <div class="services">
                                            <?php
                                            if ($services) {
                                                foreach ($services as $service) {
                                                    echo '<span class="service service-' . strtolower($service) . '">' . $service . '</span>';
                                                }
                                            }
                                            ?>
                                        </div>
                                        <p>English level: <span class="english-level english-<?php echo strtolower($english_level); ?>"><?php echo $english_level; ?></span></p>
                                        <p class="status status-<?php echo strtolower(str_replace(' ', '-', $status)); ?>">Status: not calculated</p>
                                        <p class="distance">Distance: not calculated</p>
                                    </div>
                                </a>
                                <?php
                            }
                        } else {
                            // no posts found
                            echo '<p>No barbershops found.</p>';
                        }
                        /* Restore original Post Data */
                        wp_reset_postdata();
                        ?>
                    </div>
                </main><!-- #main -->
            </div><!-- #primary -->
        </div><!-- .row -->
    </div><!-- Container end -->
</div><!-- Wrapper end -->

<?php
get_footer();
?>
