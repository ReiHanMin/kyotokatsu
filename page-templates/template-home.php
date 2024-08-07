<?php
/**
 * Template Name: Template: Home
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>

<div class="home-banner-wrapper">
    <div class="home-banner">
        <!-- Your banner image or content goes here -->
        <div class="gradient-overlay"></div>
    </div>
    <div class="search-bar-wrapper">
    <form class="search-bar" action="your-search-url" method="get">
        <div class="search-icon">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0z" fill="none"/><path d="M15.5 14h-.79l-.28-.27a6.471 6.471 0 0 0 1.48-5.34C15.23 5.34 12.8 3 10 3S4.77 5.34 4.77 8.39c0 3.05 2.43 5.39 5.39 5.39 1.61 0 3.07-.7 4.1-1.8l.27.28v.79l4.25 4.25a1.5 1.5 0 0 0 2.12-2.12l-4.25-4.25zm-5.5 0C8.01 14 6 11.99 6 9.5S8.01 5 10.5 5 15 7.01 15 9.5 12.99 14 10.5 14z"/></svg>
        </div>
        <input type="text" placeholder="Search..." aria-label="Search" name="s">
        <button class="search-button" type="submit">Find my barber!</button>
    </form>
</div>

</div>


</div>

<div class="local-barbers-background">
    <h2>Barbers near you...</h2>
    <div class="barbershop-cards">
        <?php
        // The Query
        $args = array(
            'post_type' => 'barbershop',
            'posts_per_page' => 3 // Limit to 4 posts
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
                <div class="barbershop-card" data-latitude="<?php echo esc_attr($latitude); ?>" data-longitude="<?php echo esc_attr($longitude); ?>">
                    <?php if (has_post_thumbnail()) {
                        the_post_thumbnail('thumbnail', ['class' => 'barbershop-image']);
                    } ?>
                    <div class="card-content">
                        <h3><?php the_title(); ?></h3>
                        <div class="rating"><?php echo str_repeat('★', $rating); ?></div>
                        <div class="services">
                        <?php
                        $services = get_field('services');
                        if ($services) {
                            foreach ($services as $service) {
                                echo '<span class="service service-' . strtolower($service) . '">' . $service . '</span>';
                            }
                        }
                        ?>
                    </div>
                    <div class="level">
                    <p>English level: <span class="english-level english-<?php echo strtolower($english_level); ?>"><?php echo $english_level; ?></span></p>
                    </div>
                        <div class="status status-<?php echo strtolower(str_replace(' ', '-', $status)); ?>">
                            <?php
                            $current_time = current_time('H:i');
                            $open_soon_threshold = date('H:i', strtotime('+1 hour', strtotime($opening_time)));
                            $close_soon_threshold = date('H:i', strtotime('-1 hour', strtotime($closing_time)));

                            if ($status === 'Closed' && $current_time >= $closing_time && $current_time < $open_soon_threshold) {
                                echo 'Opens soon ' . $opening_time;
                            } elseif ($status === 'Open' && $current_time >= $close_soon_threshold && $current_time < $closing_time) {
                                echo 'Closes soon ' . $closing_time;
                            } else {
                                if ($status === 'Open') {
                                    echo 'Open now until ' . $closing_time;
                                } else {
                                    echo 'Closed, opens at ' . $opening_time;
                                }
                            }
                            ?>
                        </div>
                        <div class="distance"><?php // Add code here to calculate and display distance ?></div>
                    </div>
                </div>
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
    <!-- Add CTA Button -->
    <div class="cta-wrapper">
        <a href="<?php echo get_permalink(get_page_by_path('barbershops')); ?>" class="cta-button">See All Barbershops</a>
    </div>
</div>


<?php
get_footer();
?>
