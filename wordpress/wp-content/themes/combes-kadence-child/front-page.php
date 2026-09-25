<?php
/**
 * Front Page template for Combes (Home).
 * Hero + masonry are dynamic; additional content is edited via Gutenberg/Kadence Blocks.
 */

get_header();

// Featured projects for hero + masonry.
$featured_args = array(
    'post_type'      => 'combes_project',
    'posts_per_page' => 6,
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

$featured_projects = new WP_Query( $featured_args );

// Fallback: latest projects if no featured are set.
if ( ! $featured_projects->have_posts() ) {
    $featured_args = array(
        'post_type'      => 'combes_project',
        'posts_per_page' => 6,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );
    $featured_projects = new WP_Query( $featured_args );
}
?>

<main id="primary" class="site-main front-page">

    <?php
    /**
     * HERO SLIDESHOW
     * Uses project featured images as full-viewport slides.
     * JS in assets/js/theme.js handles rotation and Ken Burns effects.
     */
    ?>
    <section class="section hero-slideshow animate-fade-in">
        <div class="hero-slideshow__slides">
            <?php
            if ( $featured_projects->have_posts() ) :
                while ( $featured_projects->have_posts() ) :
                    $featured_projects->the_post();

                    $thumb = get_the_post_thumbnail_url( get_the_ID(), 'full' );
                    ?>
                    <div class="hero-slideshow__slide">
                        <?php if ( $thumb ) : ?>
                            <div class="wp-block-cover has-parallax-bg" style="background-image:url('<?php echo esc_url( $thumb ); ?>');">
                                <span aria-hidden="true" class="wp-block-cover__background has-black-background-color has-background-dim"></span>
                                <div class="wp-block-cover__inner-container">
                                    <!-- Optional; you can remove this overlay content if you want pure imagery -->
                                    <p class="has-text-align-center text-muted">
                                        <?php echo esc_html( get_the_title() ); ?>
                                    </p>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="wp-block-cover has-parallax-bg">
                                <span aria-hidden="true" class="wp-block-cover__background has-black-background-color has-background-dim"></span>
                                <div class="wp-block-cover__inner-container">
                                    <p class="has-text-align-center">Add project photography to highlight in the hero.</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>

        <div class="hero-slideshow__content">
            <?php if ( function_exists( 'the_custom_logo' ) ) : ?>
                <div class="hero-slideshow__logo animate-fade-up">
                    <?php the_custom_logo(); ?>
                </div>
            <?php endif; ?>

            <p class="hero-slideshow__eyebrow animate-fade-up">
                COMBES CONSTRUCTION
            </p>

            <h1 class="hero-slideshow__headline animate-fade-up animate-delay-1">
                Building premium commercial environments across the Kansas City region.
            </h1>

            <p class="hero-slideshow__subline animate-fade-up animate-delay-2">
                A portfolio‑driven general contractor focused on civic, education, and commercial work where
                architecture, schedules, and construction performance must stay aligned.
            </p>

            <div class="wp-block-buttons hero-slideshow__actions animate-fade-up animate-delay-3">
                <div class="wp-block-button is-style-fill">
                    <a class="wp-block-button__link" href="<?php echo esc_url( home_url( '/projects/' ) ); ?>">
                        View Signature Projects
                    </a>
                </div>
                <div class="wp-block-button is-style-outline button--ghost">
                    <a class="wp-block-button__link button--ghost" href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>">
                        Learn About Combes
                    </a>
                </div>
            </div>
        </div>
    </section>

    <?php
    /**
     * HOMEPAGE MASONRY PROJECT SHOWCASE
     * Featured projects first, then additional recent work.
     */
    ?>

    <section class="section home-projects animate-fade-up">
        <div class="section__inner">
            <div class="home-projects__header">
                <h2 class="section-title">Featured Work</h2>
                <a class="home-projects__view-all" href="<?php echo esc_url( home_url( '/projects/' ) ); ?>">
                    View Full Portfolio &rarr;
                </a>
            </div>

            <div class="projects-masonry">
                <?php
                // Re-run featured query for masonry.
                $featured_masonry = new WP_Query( $featured_args );
                $featured_ids     = array();

                if ( $featured_masonry->have_posts() ) :
                    while ( $featured_masonry->have_posts() ) :
                        $featured_masonry->the_post();
                        $featured_ids[] = get_the_ID();

                        $project_id   = get_the_ID();
                        $location     = get_post_meta( $project_id, 'combes_project_location', true );
                        $completion   = get_post_meta( $project_id, 'combes_project_completion_date', true );
                        $type_terms   = get_the_terms( $project_id, 'combes_project_type' );
                        $type_label   = ( $type_terms && ! is_wp_error( $type_terms ) ) ? $type_terms[0]->name : '';
                        ?>
                        <article <?php post_class( 'card card--project animate-zoom-in' ); ?>>
                            <a href="<?php the_permalink(); ?>" class="card__link">
                                <div class="card__media">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <?php the_post_thumbnail( 'large' ); ?>
                                    <?php endif; ?>
                                    <div class="card__overlay">
                                        <?php if ( $type_label ) : ?>
                                            <span class="card__overlay-category">
                                                <?php echo esc_html( $type_label ); ?>
                                            </span>
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
                endif;

                // Additional non-featured projects to fill out the masonry.
                $additional = new WP_Query(
                    array(
                        'post_type'      => 'combes_project',
                        'posts_per_page' => 8,
                        'post__not_in'   => $featured_ids,
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                    )
                );

                if ( $additional->have_posts() ) :
                    while ( $additional->have_posts() ) :
                        $additional->the_post();

                        $project_id   = get_the_ID();
                        $location     = get_post_meta( $project_id, 'combes_project_location', true );
                        $completion   = get_post_meta( $project_id, 'combes_project_completion_date', true );
                        $type_terms   = get_the_terms( $project_id, 'combes_project_type' );
                        $type_label   = ( $type_terms && ! is_wp_error( $type_terms ) ) ? $type_terms[0]->name : '';
                        ?>
                        <article <?php post_class( 'card card--project animate-zoom-in' ); ?>>
                            <a href="<?php the_permalink(); ?>" class="card__link">
                                <div class="card__media">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <?php the_post_thumbnail( 'large' ); ?>
                                    <?php endif; ?>
                                    <div class="card__overlay">
                                        <?php if ( $type_label ) : ?>
                                            <span class="card__overlay-category">
                                                <?php echo esc_html( $type_label ); ?>
                                            </span>
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
                endif;
                ?>
            </div>
        </div>
    </section>

    <?php
    /**
     * ADDITIONAL HOMEPAGE CONTENT
     * Statistics band, about intro, etc – managed via Gutenberg/Kadence patterns.
     */
    ?>
    <section class="section section--dark">
        <div class="section__inner">
            <?php
            if ( have_posts() ) :
                while ( have_posts() ) :
                    the_post();
                    the_content();
                endwhile;
            endif;
            ?>
        </div>
    </section>

</main>

<?php
get_footer();
