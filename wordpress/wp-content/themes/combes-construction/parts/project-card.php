<?php
/**
 * Project card used in project grids.
 * Expects global $post (used in The Loop).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$project_id = get_the_ID();

// Meta.
$location  = get_post_meta( $project_id, 'combes_project_location', true );
$timeline  = get_post_meta( $project_id, 'combes_project_timeline', true );

// Taxonomies.
$types   = get_the_terms( $project_id, 'combes_project_type' );
$status  = get_the_terms( $project_id, 'combes_project_status' );

// Use first term in each taxonomy for the card label (you can expand later).
$type_label   = ( $types && ! is_wp_error( $types ) ) ? $types[0]->name : '';
$status_label = ( $status && ! is_wp_error( $status ) ) ? $status[0]->name : '';
?>

<article <?php post_class( 'card card--project' ); ?>>
    <a href="<?php the_permalink(); ?>" class="card__link">
        <div class="card__media">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'large', array( 'class' => 'card__image' ) ); ?>
            <?php else : ?>
                <div class="card__image card__image--placeholder"></div>
            <?php endif; ?>

            <?php if ( $status_label ) : ?>
                <span class="card__status">
                    <?php echo esc_html( $status_label ); ?>
                </span>
            <?php endif; ?>
        </div>

        <div class="card__body">
            <h2 class="card__title">
                <?php the_title(); ?>
            </h2>

            <?php if ( $location ) : ?>
                <p class="card__location">
                    <?php echo esc_html( $location ); ?>
                </p>
            <?php endif; ?>

            <?php if ( $type_label || $timeline ) : ?>
                <p class="card__meta">
                    <?php if ( $type_label ) : ?>
                        <span class="card__chip card__chip--type">
                            <?php echo esc_html( $type_label ); ?>
                        </span>
                    <?php endif; ?>

                    <?php if ( $timeline ) : ?>
                        <span class="card__chip card__chip--timeline">
                            <?php echo esc_html( $timeline ); ?>
                        </span>
                    <?php endif; ?>
                </p>
            <?php endif; ?>

            <?php if ( has_excerpt() ) : ?>
                <p class="card__excerpt">
                    <?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?>
                </p>
            <?php endif; ?>

            <span class="card__cta">View Project</span>
        </div>
    </a>
</article>
