<?php
/**
 * Single Team Member template.
 */

get_header();

if ( have_posts() ) :
    while ( have_posts() ) :
        the_post();

        $member_id = get_the_ID();

        $position          = get_post_meta( $member_id, 'combes_team_position', true );
        $email             = get_post_meta( $member_id, 'combes_team_email', true );
        $years_with        = get_post_meta( $member_id, 'combes_team_years_with_company', true );
        $years_in_industry = get_post_meta( $member_id, 'combes_team_years_in_industry', true );
        $life_outside      = get_post_meta( $member_id, 'combes_team_life_outside_work', true );
        ?>

        <main id="primary" class="site-main site-main--team-member">

            <article <?php post_class( 'team-member' ); ?>>

                <header class="team-member-hero section">
                    <div class="section__inner team-member-hero__inner">

                        <div class="team-member-hero__media">
                            <?php
                            if ( has_post_thumbnail() ) {
                                the_post_thumbnail( 'large', array( 'class' => 'team-member-hero__image' ) );
                            }
                            ?>
                        </div>

                        <div class="team-member-hero__content">
                            <h1 class="team-member__name">
                                <?php the_title(); ?>
                            </h1>

                            <?php if ( $position ) : ?>
                                <p class="team-member__position">
                                    <?php echo esc_html( $position ); ?>
                                </p>
                            <?php endif; ?>

                            <ul class="team-member__facts">
                                <?php if ( $years_with ) : ?>
                                    <li><strong>Years with Combes:</strong> <?php echo esc_html( $years_with ); ?></li>
                                <?php endif; ?>
                                <?php if ( $years_in_industry ) : ?>
                                    <li><strong>Years in industry:</strong> <?php echo esc_html( $years_in_industry ); ?></li>
                                <?php endif; ?>
                                <?php if ( $email ) : ?>
                                    <li><strong>Email:</strong>
                                        <a href="<?php echo esc_url( 'mailto:' . $email ); ?>">
                                            <?php echo esc_html( $email ); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </header>

                <section class="section section--team-member-content">
                    <div class="section__inner">
                        <h2 class="section-subtitle">Biography &amp; Education</h2>
                        <div class="team-member__bio">
                            <?php the_content(); ?>
                        </div>

                        <?php if ( $life_outside ) : ?>
                            <h2 class="section-subtitle">Life Outside Work</h2>
                            <div class="team-member__life-outside">
                                <?php echo wp_kses_post( wpautop( $life_outside ) ); ?>
                            </div>
                        <?php endif; ?>

                        <p class="team-member__back-link">
                            <a href="<?php echo esc_url( get_post_type_archive_link( 'combes_team_member' ) ); ?>">
                                &larr; Back to Our People
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
