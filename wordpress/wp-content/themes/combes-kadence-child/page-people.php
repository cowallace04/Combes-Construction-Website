<?php
/**
 * Template Name: Our People
 * Description: Our People page with intro content (blocks) and team member grid.
 */

get_header();
?>

<main id="primary" class="site-main page-people">

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

                    <div class="page-people__intro">
                        <?php the_content(); // pattern: combes/page-people ?>
                    </div>
                    <?php
                endwhile;
            endif;
            ?>
        </div>
    </section>

    <!-- Team member grid -->
    <section class="section section--surface" data-aos="fade-up">
        <div class="section__inner">
            <?php
            $team_query = new WP_Query(
                array(
                    'post_type'      => 'combes_team_member',
                    'posts_per_page' => -1,
                    'orderby'        => array(
                        'meta_value_num' => 'ASC',
                        'title'          => 'ASC',
                    ),
                    'meta_key'       => 'combes_team_display_order',
                )
            );

            if ( $team_query->have_posts() ) :
                ?>
                <div class="combes-people-grid">
                    <?php
                    while ( $team_query->have_posts() ) :
                        $team_query->the_post();

                        $team_id          = get_the_ID();
                        $position         = get_post_meta( $team_id, 'combes_team_position', true );
                        $years_company    = get_post_meta( $team_id, 'combes_team_years_with_company', true );
                        $years_industry   = get_post_meta( $team_id, 'combes_team_years_in_industry', true );
                        $email            = get_post_meta( $team_id, 'combes_team_email', true );
                        ?>
                        <article <?php post_class( 'combes-card combes-people-card animate-fade-up' ); ?>>
                            <div class="combes-people-card__photo">
                                <?php
                                if ( has_post_thumbnail() ) {
                                    the_post_thumbnail( 'medium_large' );
                                }
                                ?>
                            </div>

                            <div class="combes-people-card__body">
                                <h2 class="combes-card__title"><?php the_title(); ?></h2>

                                <?php if ( $position ) : ?>
                                    <p class="combes-people-card__title">
                                        <?php echo esc_html( $position ); ?>
                                    </p>
                                <?php endif; ?>

                                <?php if ( $years_industry || $years_company ) : ?>
                                    <p class="combes-people-card__meta">
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

                                <div class="combes-people-card__excerpt">
                                    <?php the_excerpt(); ?>
                                </div>

                                <div class="combes-people-card__footer">
                                    <?php if ( $email ) : ?>
                                        <a href="mailto:<?php echo esc_attr( $email ); ?>" class="button button--ghost">
                                            Email
                                        </a>
                                    <?php endif; ?>
                                    <a href="<?php the_permalink(); ?>" class="button kt-button">
                                        View Profile
                                    </a>
                                </div>
                            </div>
                        </article>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
                <?php
            else :
                ?>
                <p>No team members have been added yet.</p>
                <?php
            endif;
            ?>
        </div>
    </section>

</main>

<?php
get_footer();
