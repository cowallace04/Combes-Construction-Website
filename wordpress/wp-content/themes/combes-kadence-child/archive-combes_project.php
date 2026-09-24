<?php
/**
 * Archive template for Projects (combes_project).
 */

get_header();
?>

<main id="primary" class="site-main site-main--projects">

    <section class="section" data-aos="fade-up">
        <div class="section__inner">
            <h1 class="section-title">Projects</h1>
            <p class="section-lead">
                Representative projects across commercial, education, municipal, and more.
            </p>
        </div>
    </section>

    <section class="section">
        <div class="section__inner">
            <?php if ( have_posts() ) : ?>
                <div class="projects-grid">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        $project_id = get_the_ID();
                        $location   = get_post_meta( $project_id, 'combes_project_location', true );
                        $completion = get_post_meta( $project_id, 'combes_project_completion_date', true );
                        ?>
                        <article <?php post_class( 'card card--project' ); ?> data-aos="fade-up">
                            <a href="<?php the_permalink(); ?>" class="card__link">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <div class="card__media">
                                        <?php the_post_thumbnail( 'large' ); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="card__body">
                                    <h2 class="card__title"><?php the_title(); ?></h2>
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
                    ?>
                </div>

                <?php the_posts_pagination(); ?>

            <?php else : ?>

                <p>No projects are available yet.</p>

            <?php endif; ?>
        </div>
    </section>

</main>

<?php
get_footer();
