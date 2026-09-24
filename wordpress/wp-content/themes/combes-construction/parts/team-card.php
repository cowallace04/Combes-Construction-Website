<?php
/**
 * Team member card for grids.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$member_id = get_the_ID();

$position          = get_post_meta( $member_id, 'combes_team_position', true );
$email             = get_post_meta( $member_id, 'combes_team_email', true );
$years_with        = get_post_meta( $member_id, 'combes_team_years_with_company', true );
$years_in_industry = get_post_meta( $member_id, 'combes_team_years_in_industry', true );
?>

<article <?php post_class( 'card card--team' ); ?>>
    <a href="<?php the_permalink(); ?>" class="card__link">
        <div class="card__media card__media--headshot">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'medium', array( 'class' => 'card__image card__image--headshot' ) ); ?>
            <?php else : ?>
                <div class="card__image card__image--headshot-placeholder"></div>
            <?php endif; ?>
        </div>

        <div class="card__body">
            <h2 class="card__title">
                <?php the_title(); ?>
            </h2>

            <?php if ( $position ) : ?>
                <p class="card__position">
                    <?php echo esc_html( $position ); ?>
                </p>
            <?php endif; ?>

            <?php if ( $years_with || $years_in_industry ) : ?>
                <p class="card__tenure">
                    <?php if ( $years_with ) : ?>
                        <span><?php echo esc_html( $years_with ); ?> yrs with Combes</span>
                    <?php endif; ?>
                    <?php if ( $years_in_industry ) : ?>
                        <span><?php echo esc_html( $years_in_industry ); ?> yrs in industry</span>
                    <?php endif; ?>
                </p>
            <?php endif; ?>

            <?php if ( $email ) : ?>
                <p class="card__email">
                    <a href="<?php echo esc_url( 'mailto:' . $email ); ?>">
                        <?php echo esc_html( $email ); ?>
                    </a>
                </p>
            <?php endif; ?>

            <span class="card__cta">View Profile</span>
        </div>
    </a>
</article>
