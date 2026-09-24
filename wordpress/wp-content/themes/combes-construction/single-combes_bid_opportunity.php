<?php
/**
 * Single Bidding Opportunity template.
 */

get_header();

if ( have_posts() ) :
    while ( have_posts() ) :
        the_post();

        $bid_id    = get_the_ID();
        $location  = get_post_meta( $bid_id, 'combes_bid_location', true );
        $deadline  = get_post_meta( $bid_id, 'combes_bid_deadline', true );
        $contact   = get_post_meta( $bid_id, 'combes_bid_contact', true );
        $scopes    = get_post_meta( $bid_id, 'combes_bid_scope_packages', true );
        $documents = get_post_meta( $bid_id, 'combes_bid_document_links', true );
        $addenda   = get_post_meta( $bid_id, 'combes_bid_addenda', true );
        $open      = get_post_meta( $bid_id, 'combes_bid_open', true );
        $public    = get_post_meta( $bid_id, 'combes_bid_public', true );
        ?>

        <main id="primary" class="site-main site-main--bid">

            <article <?php post_class( 'bid' ); ?>>

                <section class="section section--bid-hero">
                    <div class="section__inner">
                        <h1 class="bid__title"><?php the_title(); ?></h1>

                        <p class="bid__meta">
                            <?php if ( $location ) : ?>
                                <span><?php echo esc_html( $location ); ?></span>
                            <?php endif; ?>
                            <?php if ( $deadline ) : ?>
                                <span> &middot; Bid due <?php echo esc_html( $deadline ); ?></span>
                            <?php endif; ?>
                            <?php if ( $open ) : ?>
                                <span> &middot; <strong>Open</strong></span>
                            <?php else : ?>
                                <span> &middot; <strong>Closed</strong></span>
                            <?php endif; ?>
                            <?php if ( $public ) : ?>
                                <span> &middot; Public</span>
                            <?php else : ?>
                                <span> &middot; Private</span>
                            <?php endif; ?>
                        </p>

                        <?php if ( $contact ) : ?>
                            <p class="bid__contact">
                                <strong>Contact:</strong> <?php echo esc_html( $contact ); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </section>

                <section class="section section--bid-content">
                    <div class="section__inner">
                        <?php if ( get_the_content() ) : ?>
                            <h2>Summary</h2>
                            <div class="bid__summary">
                                <?php the_content(); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( $scopes ) : ?>
                            <h2>Scope packages</h2>
                            <div class="bid__scopes">
                                <?php echo wp_kses_post( wpautop( $scopes ) ); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( $documents ) : ?>
                            <h2>Document links</h2>
                            <div class="bid__documents">
                                <?php echo wp_kses_post( wpautop( $documents ) ); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( $addenda ) : ?>
                            <h2>Addenda</h2>
                            <div class="bid__addenda">
                                <?php echo wp_kses_post( wpautop( $addenda ) ); ?>
                            </div>
                        <?php endif; ?>

                        <p class="bid__back-link">
                            <a href="<?php echo esc_url( get_post_type_archive_link( 'combes_bid_opportunity' ) ); ?>">
                                &larr; Back to Bidding Opportunities
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
