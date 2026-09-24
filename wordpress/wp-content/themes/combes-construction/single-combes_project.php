<?php
/**
 * Single Project template.
 */

get_header();

if ( have_posts() ) :
    while ( have_posts() ) :
        the_post();

        $project_id = get_the_ID();

        // Meta.
        $location   = get_post_meta( $project_id, 'combes_project_location', true );
        $address    = get_post_meta( $project_id, 'combes_project_address', true );
        $owner      = get_post_meta( $project_id, 'combes_project_owner', true );
        $architect  = get_post_meta( $project_id, 'combes_project_architect', true );
        $completion = get_post_meta( $project_id, 'combes_project_completion_date', true );

        // Taxonomies.
        $status_terms = get_the_terms( $project_id, 'combes_project_status' );
        $status_label = ( $status_terms && ! is_wp_error( $status_terms ) ) ? $status_terms[0]->name : '';

        $type_terms   = get_the_terms( $project_id, 'combes_project_type' );
        $type_label   = ( $type_terms && ! is_wp_error( $type_terms ) ) ? $type_terms[0]->name : '';

        // Get up to 4 attached images for the top grid (includes featured image).
        $attached_images = get_attached_media( 'image', $project_id );
        $top_images      = array_slice( $attached_images, 0, 4, true );

        ?>

        <main id="primary" class="site-main site-main--project">

            <article <?php post_class( 'project' ); ?>>

                <!-- Top grid: images + sidebar info -->
                <section class="section project-hero-grid">
                    <div class="section__inner project-hero-grid__inner">

                        <div class="project-hero-grid__images">
                            <?php
                            if ( ! empty( $top_images ) ) {
                                foreach ( $top_images as $image ) {
                                    echo wp_get_attachment_image(
                                        $image->ID,
                                        'large',
                                        false,
                                        array( 'class' => 'project-hero-grid__image' )
                                    );
                                }
                            } elseif ( has_post_thumbnail() ) {
                                the_post_thumbnail( 'large', array( 'class' => 'project-hero-grid__image project-hero-grid__image--single' ) );
                            }
                            ?>
                        </div>

                        <aside class="project-hero-grid__sidebar">

                            <?php if ( $status_label ) : ?>
                                <p class="project-status-badge">
                                    <?php echo esc_html( $status_label ); ?>
                                </p>
                            <?php endif; ?>

                            <h1 class="project-title">
                                <?php the_title(); ?>
                            </h1>

                            <?php if ( has_excerpt() ) : ?>
                                <div class="project-highlights">
                                    <h2 class="project-highlights__heading">Highlights</h2>
                                    <p class="project-highlights__body">
                                        <?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?>
                                    </p>
                                </div>
                            <?php endif; ?>

                            <div class="project-info-box">
                                <h2 class="project-info-box__heading">Project Info</h2>
                                <ul class="project-info-box__list">
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

                        </aside>

                    </div>
                </section>

                <!-- Main body and gallery -->
                <section class="section section--project-content">
                    <div class="section__inner project-content__inner">

                        <div class="project-content__body">
                            <?php the_content(); ?>
                        </div>

                        <p class="project-content__back-link">
                            <a href="<?php echo esc_url( get_post_type_archive_link( 'combes_project' ) ); ?>">
                                &larr; Back to Projects
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
