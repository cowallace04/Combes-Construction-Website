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

    $count = (int) $atts['count'];
    if ( $count <= 0 ) {
        $count = 6;
    }

    // First try: featured projects only.
    $query_args = array(
        'post_type'      => 'combes_project',
        'posts_per_page' => $count,
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
    );

    $query = new WP_Query( $query_args );

    // Fallback: if no featured projects, show latest projects (no meta_query).
    if ( ! $query->have_posts() ) {
        $query = new WP_Query( array(
            'post_type'      => 'combes_project',
            'posts_per_page' => $count,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ) );
    }

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
                    No projects are published yet.
                </p>
            <?php endif; ?>
        </div>
    </section>
    <?php

    return ob_get_clean();
}
add_shortcode( 'combes_featured_projects', 'combes_featured_projects_shortcode' );

<?php
// ... existing code (shortcode, etc.)

function combes_theme_enqueue_assets() {
    // Main stylesheet is already enqueued from functions.php or style.css.
    // Add the theme JS for animations.
    wp_enqueue_script(
        'combes-theme',
        get_template_directory_uri() . '/assets/js/theme.js',
        array(),
        '1.0.0',
        true
    );
}
add_action( 'wp_enqueue_scripts', 'combes_theme_enqueue_assets' );


