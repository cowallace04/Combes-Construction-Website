<?php
/**
 * Single Job Opening template.
 */

get_header();

if ( have_posts() ) :
    while ( have_posts() ) :
        the_post();

        $job_id       = get_the_ID();
        $department   = get_post_meta( $job_id, 'combes_job_department', true );
        $location     = get_post_meta( $job_id, 'combes_job_location', true );
        $employment   = get_post_meta( $job_id, 'combes_job_employment_type', true );
        $responsibilities = get_post_meta( $job_id, 'combes_job_responsibilities', true );
        $qualifications   = get_post_meta( $job_id, 'combes_job_qualifications', true );
        $benefits         = get_post_meta( $job_id, 'combes_job_benefits', true );
        $destination      = get_post_meta( $job_id, 'combes_job_application_destination', true );
        $opening_date     = get_post_meta( $job_id, 'combes_job_opening_date', true );
        $closing_date     = get_post_meta( $job_id, 'combes_job_closing_date', true );
        ?>

        <main id="primary" class="site-main site-main--job">

            <article <?php post_class( 'job' ); ?>>

                <section class="section section--job-hero">
                    <div class="section__inner">
                        <h1 class="job__title"><?php the_title(); ?></h1>

                        <p class="job__meta">
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

                        <?php if ( $opening_date || $closing_date ) : ?>
                            <p class="job__dates">
                                <?php if ( $opening_date ) : ?>
                                    <span><strong>Opening:</strong> <?php echo esc_html( $opening_date ); ?></span>
                                <?php endif; ?>
                                <?php if ( $closing_date ) : ?>
                                    <span> &middot; <strong>Closing:</strong> <?php echo esc_html( $closing_date ); ?></span>
                                <?php endif; ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </section>

                <section class="section section--job-content">
                    <div class="section__inner">
                        <?php if ( get_the_content() ) : ?>
                            <h2>Summary</h2>
                            <div class="job__summary">
                                <?php the_content(); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( $responsibilities ) : ?>
                            <h2>Responsibilities</h2>
                            <div class="job__responsibilities">
                                <?php echo wp_kses_post( wpautop( $responsibilities ) ); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( $qualifications ) : ?>
                            <h2>Qualifications</h2>
                            <div class="job__qualifications">
                                <?php echo wp_kses_post( wpautop( $qualifications ) ); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( $benefits ) : ?>
                            <h2>Benefits</h2>
                            <div class="job__benefits">
                                <?php echo wp_kses_post( wpautop( $benefits ) ); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( $destination ) : ?>
                            <p class="job__apply">
                                <strong>How to apply:</strong>
                                <?php echo esc_html( $destination ); ?>
                            </p>
                        <?php endif; ?>

                        <p class="job__back-link">
                            <a href="<?php echo esc_url( get_post_type_archive_link( 'combes_job_opening' ) ); ?>">
                                &larr; Back to Available Positions
                            </a>
                        </p>
                    </div>
                </section>

            </article>
        </main>

        <?php
    endwhile;
endif;

get_footer();
