<?php
/**
 * Template Name: Careers
 * Description: Careers page with intro content and separate sections for positions and internships.
 */

get_header();

$active_meta_key         = 'combes_job_active';
$employment_type_meta_key= 'combes_job_employment_type';
?>

<main id="primary" class="site-main page-careers">

    <!-- Intro / block-pattern content -->
    <section class="section section--dark" data-aos="fade-up">
        <div class="section__inner">
            <?php
            if ( have_posts() ) :
                while ( have_posts() ) :
                    the_post();
                    ?>
                    <header class="combes-page-header">
                        <h1 class="section-title"><?php the_title(); ?></h1>
                        <?php if ( has_excerpt() ) : ?>
                            <p class="section-lead"><?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?></p>
                        <?php endif; ?>
                    </header>

                    <div class="page-careers__intro">
                        <?php the_content(); // pattern: combes/page-careers ?>
                    </div>
                    <?php
                endwhile;
            endif;
            ?>
        </div>
    </section>

    <!-- Positions & internships columns -->
    <section class="section section--surface" data-aos="fade-up">
        <div class="section__inner combes-careers__columns">

            <?php
            // AVAILABLE POSITIONS: active and NOT Internship (Full-time, Part-time, etc.).
            $positions_query = new WP_Query(
                array(
                    'post_type'      => 'combes_job_opening',
                    'posts_per_page' => -1,
                    'meta_query'     => array(
                        'relation' => 'AND',
                        array(
                            'key'     => $active_meta_key,
                            'value'   => 1,
                            'compare' => '=',
                        ),
                        array(
                            'key'     => $employment_type_meta_key,
                            'value'   => 'Internship',
                            'compare' => '!=',
                        ),
                    ),
                    'orderby'        => array(
                        'meta_value' => 'DESC',
                        'date'       => 'DESC',
                    ),
                    'meta_key'       => 'combes_job_opening_date',
                )
            );

            // INTERNSHIPS: active and employment_type = Internship.
            $internships_query = new WP_Query(
                array(
                    'post_type'      => 'combes_job_opening',
                    'posts_per_page' => -1,
                    'meta_query'     => array(
                        'relation' => 'AND',
                        array(
                            'key'     => $active_meta_key,
                            'value'   => 1,
                            'compare' => '=',
                        ),
                        array(
                            'key'     => $employment_type_meta_key,
                            'value'   => 'Internship',
                            'compare' => '=',
                        ),
                    ),
                    'orderby'        => array(
                        'meta_value' => 'DESC',
                        'date'       => 'DESC',
                    ),
                    'meta_key'       => 'combes_job_opening_date',
                )
            );
            ?>

            <div class="combes-careers__col">
                <h2>Available Positions</h2>

                <?php
                if ( $positions_query->have_posts() ) :
                    while ( $positions_query->have_posts() ) :
                        $positions_query->the_post();

                        $job_id       = get_the_ID();
                        $department   = get_post_meta( $job_id, 'combes_job_department', true );
                        $location     = get_post_meta( $job_id, 'combes_job_location', true );
                        $employment   = get_post_meta( $job_id, 'combes_job_employment_type', true );
                        $opening_date = get_post_meta( $job_id, 'combes_job_opening_date', true );
                        $closing_date = get_post_meta( $job_id, 'combes_job_closing_date', true );
                        ?>
                        <article <?php post_class( 'combes-card combes-job-card animate-fade-up' ); ?>>
                            <h3 class="combes-card__title"><?php the_title(); ?></h3>

                            <p class="combes-job-card__meta-line">
                                <?php if ( $department ) : ?>
                                    <span class="combes-job-card__dept"><?php echo esc_html( $department ); ?></span>
                                <?php endif; ?>
                                <?php if ( $employment ) : ?>
                                    <span class="combes-job-card__type"><?php echo esc_html( $employment ); ?></span>
                                <?php endif; ?>
                            </p>

                            <?php if ( $location ) : ?>
                                <p class="combes-job-card__location"><?php echo esc_html( $location ); ?></p>
                            <?php endif; ?>

                            <?php if ( $opening_date || $closing_date ) : ?>
                                <p class="combes-job-card__dates">
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

                            <div class="combes-job-card__excerpt">
                                <?php the_excerpt(); ?>
                            </div>

                            <a href="<?php the_permalink(); ?>" class="button kt-button">
                                View Position
                            </a>
                        </article>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    ?>
                    <p>No positions are currently listed.</p>
                    <?php
                endif;
                ?>
            </div>

            <div class="combes-careers__col">
                <h2>Internships</h2>

                <?php
                if ( $internships_query->have_posts() ) :
                    while ( $internships_query->have_posts() ) :
                        $internships_query->the_post();

                        $job_id       = get_the_ID();
                        $department   = get_post_meta( $job_id, 'combes_job_department', true );
                        $location     = get_post_meta( $job_id, 'combes_job_location', true );
                        $opening_date = get_post_meta( $job_id, 'combes_job_opening_date', true );
                        $closing_date = get_post_meta( $job_id, 'combes_job_closing_date', true );
                        ?>
                        <article <?php post_class( 'combes-card combes-job-card animate-fade-up' ); ?>>
                            <h3 class="combes-card__title"><?php the_title(); ?></h3>

                            <?php if ( $department ) : ?>
                                <p class="combes-job-card__meta-line">
                                    <span class="combes-job-card__dept"><?php echo esc_html( $department ); ?></span>
                                    <span class="combes-job-card__type">Internship</span>
                                </p>
                            <?php endif; ?>

                            <?php if ( $location ) : ?>
                                <p class="combes-job-card__location"><?php echo esc_html( $location ); ?></p>
                            <?php endif; ?>

                            <?php if ( $opening_date || $closing_date ) : ?>
                                <p class="combes-job-card__dates">
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

                            <div class="combes-job-card__excerpt">
                                <?php the_excerpt(); ?>
                            </div>

                            <a href="<?php the_permalink(); ?>" class="button button--ghost">
                                View Internship
                            </a>
                        </article>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    ?>
                    <p>No internships are currently listed.</p>
                    <?php
                endif;
                ?>
            </div>

        </div>
    </section>

</main>

<?php
get_footer();
