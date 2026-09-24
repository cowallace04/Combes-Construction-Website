<?php
/**
 * Theme functions for Combes Construction.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Shortcode: [combes_featured_projects]
 *
 * Renders the Featured Projects collage using the existing project-card partial.
 */
function combes_featured_projects_shortcode( $atts ) {

    $atts = shortcode_atts(
        array(
            'count' => 6,
        ),
        $atts,
        'combes_featured_projects'
    );

    $query = new WP_Query( array(
        'post_type'      => 'combes_project',
        'posts_per_page' => (int) $atts['count'],
        'meta_query'     => array(
            array(
                'key'     => 'combes_project_featured',
                'value'   => 1,
                'compare' => '=',
            ),
        ),
        'orderby'        => array(
            'meta_value_num' => 'ASC',
            'date'           => 'DESC',
        ),
        'meta_key'       => 'combes_project_display_order',
    ) );

    ob_start();

    ?>
    <section class="section home-projects">
        <div class="section__inner">
            <div class="home-projects__header">
                <h2 class="section-title">Featured Projects</h2>
                <a class="home-projects__view-all" href="<?php echo esc_url( home_url( '/projects/' ) ); ?>">
                    View All Projects &rarr;
                </a>
            </div>

            <?php if ( $query->have_posts() ) : ?>
                <div class="home-projects__grid">
                    <?php
                    while ( $query->have_posts() ) :
                        $query->the_post();
                        get_template_part( 'parts/project-card' );
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            <?php else : ?>
                <p class="home-projects__empty">
                    Mark key projects as &ldquo;Featured&rdquo; in the Project Details box to show them here.
                </p>
            <?php endif; ?>
        </div>
    </section>
    <?php

    return ob_get_clean();
}
add_shortcode( 'combes_featured_projects', 'combes_featured_projects_shortcode' );
