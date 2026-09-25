<?php
/**
 * Single Team Member template.
 */

get_header();

if ( have_posts() ) :
    while ( have_posts() ) :
        the_post();

        $team_id       = get_the_ID();
        $position      = get_post_meta( $team_id, 'combes_team_position', true );
        $email         = get_post_meta( $team_id, 'combes_team_email', true );
        $years_company = get_post_meta( $team_id, 'combes_team_years_with_company', true );
        $years_industry= get_post_meta( $team_id, 'combes_team_years_in_industry', true );
        $life_outside  = get_post_meta( $team_id, 'combes_team_life_outside_work', true );

        ?>

        <main id="primary" class="site-main site-main--team">

            <article <?php post_class( 'team-member' ); ?>>

                <section class="section section--dark" data-aos="fade-up">
                    <div class="section__inner team-hero-grid">
                        <div class="team-hero-grid__photo">
                            <?php
                            if ( has_post_thumbnail() ) {
                                the_post_thumbnail( 'large', array( 'class' => 'team-hero-grid__image' ) );
                            }
                            ?>
                        </div>

                        <div class="team-hero-grid__content">
                            <h1 class="section-title"><?php the_title(); ?></h1>

                            <?php if ( $position ) : ?>
                                <p class="team-position"><?php echo esc_html( $position ); ?></p>
                            <?php endif; ?>

                            <?php if ( $years_company || $years_industry ) : ?>
                                <p class="team-years">
                                    <?php
                                    if ( $years_industry ) {
                                        echo esc_html( $years_industry ) . ' years in construction';
                                    }
                                    if ( $years_company ) {
                                        echo $years_industry ? ' · ' : '';
                                        echo esc_html( $years_company ) . ' years with Combes';
                                    }
                                    ?>
                                </p>
                            <?php endif; ?>

                            <?php if ( $email ) : ?>
                                <p class="team-email">
                                    <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
                                </p>
                            <?php endif; ?>

                            <?php if ( has_excerpt() ) : ?>
                                <div class="team-intro">
                                    <p><?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?></p>
                                </div>
                            <?php endif; ?>

                            <p class="team-back-link">
                                <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'our-people' ) ) ); ?>">
                                    &larr; Back to Our People
                                </a>
                            </p>
                        </div>
                    </div>
                </section>

                <section class="section section--surface" data-aos="fade-up">
                    <div class="section__inner team-body-grid">
                        <div class="team-body-main">
                            <?php the_content(); ?>
                        </div>

                        <?php if ( $life_outside ) : ?>
                            <aside class="team-body-sidebar">
                                <div class="combes-card">
                                    <h2>Life Outside Work</h2>
                                    <div class="team-life-body">
                                        <?php echo wp_kses_post( wpautop( $life_outside ) ); ?>
                                    </div>
                                </div>
                            </aside>
                        <?php endif; ?>
                    </div>
                </section>

                <aside class="team-body-sidebar">
                <div class="combes-card">
                    <h2>Life Outside Work</h2>
                    <div class="team-life-body">
                        <?php
                        if ( $life_outside ) {
                            echo wp_kses_post( wpautop( $life_outside ) );
                        } else {
                            echo '<p>Update this section in the “Life outside work” field on the team member edit screen.</p>';
                        }
                        ?>
                    </div>
                </div>
            </aside>


            </article>

        </main>

        <?php
    endwhile;
endif;

get_footer();
