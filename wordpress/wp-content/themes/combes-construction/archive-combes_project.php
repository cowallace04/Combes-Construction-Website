<?php
/**
 * Archive template for Projects (combes_project).
 */

get_header();
?>

<main id="primary" class="site-main site-main--projects">

    <!-- Hero / intro -->
    <section class="section section--projects-hero">
        <div class="section__inner">
            <h1 class="section-title">Projects</h1>
            <p class="section-lead">
                Representative work across municipal, parks &amp; recreation, education,
                commercial and more.
            </p>

            <!-- Filter placeholder (will wire up later) -->
            <div class="projects-filters">
                <span class="projects-filters__label">Filter by:</span>
                <!-- Status, Type, Delivery Method chips go here in a later phase -->
            </div>
        </div>
    </section>

    <!-- Project grid -->
    <section class="section section--projects-grid">
        <div class="section__inner">
            <?php if ( have_posts() ) : ?>

                <div class="projects-grid">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        get_template_part( 'parts/project-card' );
                    endwhile;
                    ?>
                </div>

                <div class="projects-pagination">
                    <?php
                    the_posts_pagination( array(
                        'mid_size'  => 2,
                        'prev_text' => __( 'Previous', 'combes-construction' ),
                        'next_text' => __( 'Next', 'combes-construction' ),
                    ) );
                    ?>
                </div>

            <?php else : ?>

                <p class="projects-empty">
                    No projects are available yet. Add projects in the admin to populate this page.
                </p>

            <?php endif; ?>
        </div>
    </section>

</main>

<?php
get_footer();
