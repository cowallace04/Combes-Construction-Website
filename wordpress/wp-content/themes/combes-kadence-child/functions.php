<?php
/**
 * Combes Kadence Child theme functions.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Enqueue parent & child styles, AOS, and theme JS.
 */
function combes_child_enqueue_assets() {

    // Parent Kadence style.
    $parent = wp_get_theme( 'kadence' );
    wp_enqueue_style(
        'kadence-style',
        get_template_directory_uri() . '/style.css',
        array(),
        $parent ? $parent->get( 'Version' ) : null
    );

    // Child style.
    $child = wp_get_theme();
    wp_enqueue_style(
        'combes-child-style',
        get_stylesheet_uri(),
        array( 'kadence-style' ),
        $child->get( 'Version' )
    );

    // AOS CSS.
    wp_enqueue_style(
        'aos',
        'https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css',
        array(),
        '2.3.4'
    );

    // Theme JS (counters, parallax, hover, scroll animations).
    wp_enqueue_script(
        'combes-theme',
        get_stylesheet_directory_uri() . '/assets/js/theme.js',
        array(),
        '0.1.0',
        true
    );

    // AOS JS.
    wp_enqueue_script(
        'aos',
        'https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js',
        array(),
        '2.3.4',
        true
    );

    // Initialize AOS globally (even though we also use our own class-based animations).
    $init = '
    document.addEventListener("DOMContentLoaded", function () {
        if (window.AOS) {
            AOS.init({
                once: true,
                duration: 600,
                easing: "ease-out",
                offset: 80
            });
        }
    });
    ';
    wp_add_inline_script( 'aos', $init );
}
add_action( 'wp_enqueue_scripts', 'combes_child_enqueue_assets' );

/**
 * Block pattern categories.
 */
function combes_register_block_pattern_category() {
    if ( function_exists( 'register_block_pattern_category' ) ) {
        register_block_pattern_category(
            'combes-home',
            array( 'label' => __( 'Combes – Homepage', 'combes-kadence-child' ) )
        );
        register_block_pattern_category(
            'combes-pages',
            array( 'label' => __( 'Combes – Pages', 'combes-kadence-child' ) )
        );
    }
}
add_action( 'init', 'combes_register_block_pattern_category' );

/**
 * Shortcode: [combes_featured_projects layout="grid|masonry"]
 */
function combes_featured_projects_shortcode( $atts ) {

    $atts = shortcode_atts(
        array(
            'count'  => 6,
            'layout' => 'grid', // or 'masonry'
        ),
        $atts,
        'combes_featured_projects'
    );

    $count = (int) $atts['count'];
    if ( $count <= 0 ) {
        $count = 6;
    }

    $layout = ( 'masonry' === $atts['layout'] ) ? 'masonry' : 'grid';

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

    // Fallback: latest projects if none are featured.
    if ( ! $query->have_posts() ) {
        $query = new WP_Query(
            array(
                'post_type'      => 'combes_project',
                'posts_per_page' => $count,
                'orderby'        => 'date',
                'order'          => 'DESC',
            )
        );
    }

    $container_class = ( 'masonry' === $layout ) ? 'projects-masonry' : 'home-projects__grid';

    ob_start();
    ?>
    <section class="section home-projects animate-fade-up">
        <div class="section__inner">
            <div class="home-projects__header">
                <h2 class="section-title">Featured Projects</h2>
                <a class="home-projects__view-all" href="<?php echo esc_url( home_url( '/projects/' ) ); ?>">
                    View All Projects &rarr;
                </a>
            </div>

            <?php if ( $query->have_posts() ) : ?>
                <div class="<?php echo esc_attr( $container_class ); ?>">
                    <?php
                    while ( $query->have_posts() ) :
                        $query->the_post();

                        $project_id = get_the_ID();
                        $location   = get_post_meta( $project_id, 'combes_project_location', true );
                        $completion = get_post_meta( $project_id, 'combes_project_completion_date', true );
                        $type_terms = get_the_terms( $project_id, 'combes_project_type' );
                        $type_label = ( $type_terms && ! is_wp_error( $type_terms ) ) ? $type_terms[0]->name : '';

                        ?>
                        <article <?php post_class( 'card card--project animate-fade-up' ); ?>>
                            <a href="<?php the_permalink(); ?>" class="card__link">
                                <div class="card__media">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <?php the_post_thumbnail( 'large' ); ?>
                                    <?php endif; ?>
                                    <div class="card__overlay">
                                    <?php if ( $type_label ) : ?>
                                        <span class="card__overlay-category"><?php echo esc_html( $type_label ); ?></span>
                                    <?php endif; ?>
                                    <h3 class="card__overlay-title"><?php the_title(); ?></h3>
                                    <span class="card__overlay-cta">View Project &rarr;</span>
                                </div>

                                </div>
                                <div class="card__body">
                                    <h3 class="card__title"><?php the_title(); ?></h3>
                                    <?php if ( $location ) : ?>
                                        <p class="card__location"><?php echo esc_html( $location ); ?></p>
                                    <?php endif; ?>
                                    <?php if ( $completion ) : ?>
                                        <p class="card__meta">
                                            <strong>Completed:</strong> <?php echo esc_html( $completion ); ?>
                                        </p>
                                    <?php endif; ?>
                                    <?php if ( has_excerpt() ) : ?>
                                        <p class="card__excerpt">
                                            <?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </a>
                        </article>
                        <?php
                    endwhile;

                    wp_reset_postdata();
                    ?>
                </div>
            <?php else : ?>
                <p>No projects are published yet.</p>
            <?php endif; ?>

        </div>
    </section>
    <?php

    return ob_get_clean();
}
add_shortcode( 'combes_featured_projects', 'combes_featured_projects_shortcode' );
