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
        $active           = get_post_meta( $job_id, 'combes_job_active', true );
        ?>

        <main id="primary" class="site-main site-main--job">

            <article <?php post_class( 'job-opening' ); ?>>

                <!-- Hero / summary -->
                <section class="section section--dark" data-aos="fade-up">
                    <div class="section__inner">
                        <p class="job-status-badge">
                            <?php echo $active ? 'Accepting Applications' : 'Position Closed'; ?>
                        </p>

                        <h1 class="section-title"><?php the_title(); ?></h1>

                        <p class="job-meta-line">
                            <?php if ( $department ) : ?>
                                <span class="job-meta-dept"><?php echo esc_html( $department ); ?></span>
                            <?php endif; ?>
                            <?php if ( $employment ) : ?>
                                <span class="job-meta-type"><?php echo esc_html( $employment ); ?></span>
                            <?php endif; ?>
                        </p>

                        <?php if ( $location ) : ?>
                            <p class="job-location"><?php echo esc_html( $location ); ?></p>
                        <?php endif; ?>

                        <?php if ( $opening_date || $closing_date ) : ?>
                            <p class="job-dates">
                                <?php
                                if ( $opening_date ) {
                                    echo 'Posted ' . esc_html( $opening_date );
                                }
                                if ( $closing_date ) {
                                    echo ( $opening_date ? ' · ' : '' ) . 'Apply by ' . esc_html( $closing_date );
                                }
                                ?>
                            </p>
                        <?php endif; ?>

                        <?php if ( has_excerpt() ) : ?>
                            <div class="job-intro">
                                <p><?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?></p>
                            </div>
                        <?php endif; ?>

                        <div class="job-cta">
                            <?php if ( $destination ) : ?>
                                <a href="<?php echo esc_url( $destination ); ?>" class="button kt-button">
                                    Apply / Express Interest
                                </a>
                            <?php endif; ?>
                            <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'careers' ) ) ); ?>" class="button button--ghost">
                                Back to Careers
                            </a>
                        </div>
                    </div>
                </section>

                <!-- Details body -->
                <section class="section section--surface" data-aos="fade-up">
                    <div class="section__inner job-body-grid">
                        <div class="job-body-main">
                            <?php the_content(); ?>
                        </div>

                        <aside class="job-body-sidebar">
                            <?php if ( $responsibilities ) : ?>
                                <div class="combes-card job-card-section">
                                    <h2>Responsibilities</h2>
                                    <div class="job-card-section__body">
                                        <?php echo wp_kses_post( wpautop( $responsibilities ) ); ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ( $qualifications ) : ?>
                                <div class="combes-card job-card-section">
                                    <h2>Qualifications</h2>
                                    <div class="job-card-section__body">
                                        <?php echo wp_kses_post( wpautop( $qualifications ) ); ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ( $benefits ) : ?>
                                <div class="combes-card job-card-section">
                                    <h2>Benefits</h2>
                                    <div class="job-card-section__body">
                                        <?php echo wp_kses_post( wpautop( $benefits ) ); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </aside>
                    </div>
                </section>

            </article>

        </main>

        <?php
    endwhile;
endif;

get_footer();
