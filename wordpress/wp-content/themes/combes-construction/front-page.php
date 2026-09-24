<?php
/**
 * Custom Front Page for Combes Construction.
 *
 * This overrides the block front-page template and uses
 * featured projects to build a collage.
 */

get_header();
?>

<main id="primary" class="site-main site-main--front">

    <!-- Hero -->
    <section class="section home-hero">
        <div class="section__inner home-hero__inner">
            <div class="home-hero__content">
                <p class="home-hero__eyebrow">Combes Construction, LLC</p>
                <h1 class="home-hero__title">
                    Building community projects across Kansas and Missouri.
                </h1>
                <p class="home-hero__lead">
                    General Contractors &middot; Design/Build &middot; Construction Managers
                </p>

                <div class="home-hero__actions">
                    <a class="button home-hero__button-primary" href="<?php echo esc_url( home_url( '/projects/' ) ); ?>">
                        View Projects
                    </a>
                    <a class="button button--ghost" href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>">
                        Start a Project
                    </a>
                </div>
            </div>

            <div class="home-hero__media">
                <!-- Placeholder for looping video or image collage -->
                <div class="home-hero__media-placeholder">
                    <p>Homepage video / montage placeholder</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Projects Collage -->
    <section class="section home-projects">
        <div class="section__inner">
            <div class="home-projects__header">
                <h2 class="section-title">Featured Projects</h2>
                <a class="home-projects__view-all" href="<?php echo esc_url( home_url( '/projects/' ) ); ?>">
                    View All Projects &rarr;
                </a>
            </div>

            <?php
            // Query featured projects.
            $featured_projects = new WP_Query( array(
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
            ) );

            if ( $featured_projects->have_posts() ) : ?>
                <div class="home-projects__grid">
                    <?php
                    while ( $featured_projects->have_posts() ) :
                        $featured_projects->the_post();
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

    <!-- Simple Services strip (placeholder) -->
    <section class="section home-services">
        <div class="section__inner home-services__inner">
            <div class="home-services__item">
                <h3>General Contracting</h3>
                <p>Competitive bid and negotiated delivery for public and private owners.</p>
            </div>
            <div class="home-services__item">
                <h3>Design/Build</h3>
                <p>Single-source responsibility from preconstruction through completion.</p>
            </div>
            <div class="home-services__item">
                <h3>Construction Management</h3>
                <p>Partnering with owners and architects to deliver complex projects.</p>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
