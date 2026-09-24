<?php
/**
 * Archive template for Team Members (combes_team_member).
 */

get_header();
?>

<main id="primary" class="site-main site-main--team">

    <section class="section section--team-hero">
        <div class="section__inner">
            <h1 class="section-title">Our People</h1>
            <p class="section-lead">
                The team behind Combes Construction&rsquo;s projects in the field and in preconstruction.
            </p>
        </div>
    </section>

    <section class="section section--team-grid">
        <div class="section__inner">
            <?php if ( have_posts() ) : ?>

                <div class="team-grid">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        get_template_part( 'parts/team-card' );
                    endwhile;
                    ?>
                </div>

            <?php else : ?>

                <p class="team-empty">
                    No team members are published yet. Add profiles in the admin to populate this page.
                </p>

            <?php endif; ?>
        </div>
    </section>

</main>

<?php
get_footer();
