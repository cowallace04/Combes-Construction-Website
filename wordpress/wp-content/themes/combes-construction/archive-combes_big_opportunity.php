<?php
/**
 * Archive template for Bidding Opportunities (combes_bid_opportunity).
 */

get_header();
?>

<main id="primary" class="site-main site-main--bids">

    <section class="section section--bids-hero">
        <div class="section__inner">
            <h1 class="section-title">Bidding Opportunities</h1>
            <p class="section-lead">
                Current projects open for subcontractor and trade-partner bidding.
            </p>
        </div>
    </section>

    <section class="section section--bids-list">
        <div class="section__inner">
            <?php if ( have_posts() ) : ?>

                <div class="bids-list">
                    <?php
                    while ( have_posts() ) :
                        the_post();

                        $bid_id   = get_the_ID();
                        $location = get_post_meta( $bid_id, 'combes_bid_location', true );
                        $deadline = get_post_meta( $bid_id, 'combes_bid_deadline', true );
                        $open     = get_post_meta( $bid_id, 'combes_bid_open', true );
                        ?>

                        <article <?php post_class( 'bid-summary' ); ?>>
                            <a href="<?php the_permalink(); ?>" class="bid-summary__link">
                                <div class="bid-summary__header">
                                    <h2 class="bid-summary__title"><?php the_title(); ?></h2>
                                    <?php if ( $open ) : ?>
                                        <span class="bid-summary__badge">Open</span>
                                    <?php else : ?>
                                        <span class="bid-summary__badge bid-summary__badge--closed">Closed</span>
                                    <?php endif; ?>
                                </div>

                                <p class="bid-summary__meta">
                                    <?php if ( $location ) : ?>
                                        <span><?php echo esc_html( $location ); ?></span>
                                    <?php endif; ?>
                                    <?php if ( $deadline ) : ?>
                                        <span> &middot; Bid due <?php echo esc_html( $deadline ); ?></span>
                                    <?php endif; ?>
                                </p>

                                <?php if ( has_excerpt() ) : ?>
                                    <p class="bid-summary__excerpt">
                                        <?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?>
                                    </p>
                                <?php endif; ?>
                            </a>
                        </article>

                    <?php endwhile; ?>
                </div>

                <?php the_posts_pagination(); ?>

            <?php else : ?>

                <p>No bidding opportunities are currently listed.</p>

            <?php endif; ?>
        </div>
    </section>

</main>

<?php
get_footer();
