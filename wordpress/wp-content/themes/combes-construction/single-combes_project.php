<?php
/**
 * Single Project template.
 */

get_header();

if ( have_posts() ) :
    while ( have_posts() ) :
        the_post();

                $project_id = get_the_ID();

        $location   = get_post_meta( $project_id, 'combes_project_location', true );
        $address    = get_post_meta( $project_id, 'combes_project_address', true );
        $owner      = get_post_meta( $project_id, 'combes_project_owner', true );
        $architect  = get_post_meta( $project_id, 'combes_project_architect', true );
        $completion = get_post_meta( $project_id, 'combes_project_completion_date', true );

        $status_terms = get_the_terms( $project_id, 'combes_project_status' );
        $status_label = ( $status_terms && ! is_wp_error( $status_terms ) ) ? $status_terms[0]->name : '';

        $type_terms   = get_the_terms( $project_id, 'combes_project_type' );
        $type_label   = ( $type_terms && ! is_wp_error( $type_terms ) ) ? $type_terms[0]->name : '';

        ?>

        <main id="primary" class="site-main site-main--project">
            <article <?php post_class( 'project' ); ?>>

                <header class="project-hero">
                    <div class="project-hero__media">
                        <?php
                        if ( has_post_thumbnail() ) {
                            the_post_thumbnail( 'full', array( 'class' => 'project-hero__image' ) );
                        }
                        ?>
                    </div>

                    <div class="project-hero__content section__inner">
                        <p class="project-status">
                            <?php echo esc_html( $status_label ); ?>
                        </p>

                        <h1 class="project-title">
                            <?php the_title(); ?>
                        </h1>

                                                <ul class="project-summary">
                            <?php if ( $location ) : ?>
                                <li><strong>Location:</strong> <?php echo esc_html( $location ); ?></li>
                            <?php endif; ?>
                            <?php if ( $address ) : ?>
                                <li><strong>Address:</strong> <?php echo esc_html( $address ); ?></li>
                            <?php endif; ?>
                            <?php if ( $owner ) : ?>
                                <li><strong>Owner:</strong> <?php echo esc_html( $owner ); ?></li>
                            <?php endif; ?>
                            <?php if ( $architect ) : ?>
                                <li><strong>Architect:</strong> <?php echo esc_html( $architect ); ?></li>
                            <?php endif; ?>
                            <?php if ( $type_label ) : ?>
                                <li><strong>Type:</strong> <?php echo esc_html( $type_label ); ?></li>
                            <?php endif; ?>
                            <?php if ( $completion ) : ?>
                                <li><strong>Completion date:</strong> <?php echo esc_html( $completion ); ?></li>
                            <?php endif; ?>
                        </ul>

                    </div>
                </header>

                <section class="section section--project-content">
                    <div class="section__inner">
                        <div class="project-content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </section>

                <!-- Gallery and related projects can be added here later -->

            </article>
        </main>

        <?php
    endwhile;
endif;

get_footer();
