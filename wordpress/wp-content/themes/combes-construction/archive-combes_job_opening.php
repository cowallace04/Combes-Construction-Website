<?php
/**
 * Archive template for Job Openings (combes_job_opening).
 */

get_header();
?>

<main id="primary" class="site-main site-main--jobs">

    <section class="section section--jobs-hero">
        <div class="section__inner">
            <h1 class="section-title">Available Positions</h1>
            <p class="section-lead">
                Current opportunities to join Combes Construction in the field and office.
            </p>
        </div>
    </section>

    <section class="section section--jobs-list">
        <div class="section__inner">
            <?php if ( have_posts() ) : ?>

                <div class="jobs-list">
                    <?php
                    while ( have_posts() ) :
                        the_post();

                        $job_id       = get_the_ID();
                        $department   = get_post_meta( $job_id, 'combes_job_department', true );
                        $location     = get_post_meta( $job_id, 'combes_job_location', true );
                        $employment   = get_post_meta( $job_id, 'combes_job_employment_type', true );
                        $active       = get_post_meta( $job_id, 'combes_job_active', true );
                        ?>

                        <article <?php post_class( 'job-summary' ); ?>>
                            <a href="<?php the_permalink(); ?>" class="job-summary__link">
                                <div class="job-summary__header">
                                    <h2 class="job-summary__title"><?php the_title(); ?></h2>
                                    <?php if ( $active ) : ?>
                                        <span class="job-summary__badge">Active</span>
                                    <?php endif; ?>
                                </div>

                                <p class="job-summary__meta">
                                    <?php if ( $department ) : ?>
                                        <span><?php echo esc_html( $department ); ?></span>
                                    <?php endif; ?>
                                    <?php if ( $location ) : ?>
                                        <span> &middot; <?php echo esc_html( $location ); ?></span>
                                    <?php endif; ?>
                                    <?php if ( $employment ) : ?>
                                        <span> &middot; <?php echo esc_html( $employment ); ?></span>
                                    <?php endif; ?>
                                </p>

                                <?php if ( has_excerpt() ) : ?>
                                    <p class="job-summary__excerpt">
                                        <?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?>
                                    </p>
                                <?php endif; ?>
                            </a>
                        </article>

                    <?php endwhile; ?>
                </div>

                <?php the_posts_pagination(); ?>

            <?php else : ?>

                <p>No job openings are currently listed.</p>

            <?php endif; ?>
        </div>
    </section>

</main>

<?php
get_footer();
