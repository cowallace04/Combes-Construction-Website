<?php
/**
 * Template Name: About Us
 * Description: About page; layout driven by Gutenberg/Kadence blocks plus child page links.
 */

get_header();
?>

<main id="primary" class="site-main page-about">

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

                    <div class="page-about__body">
                        <?php the_content(); // pattern: combes/page-about ?>
                    </div>
                    <?php
                endwhile;
            endif;
            ?>
        </div>
    </section>

    <?php
    // Child pages: Our People, Our History (and any future About children).
    $children = get_pages(
        array(
            'child_of'    => get_the_ID(),
            'sort_column' => 'menu_order',
            'post_status' => 'publish',
        )
    );

    if ( $children ) : ?>
        <section class="section section--surface" data-aos="fade-up">
            <div class="section__inner">
                <div class="combes-card">
                    <h2>Explore Combes</h2>
                    <div class="page-about__children">
                        <?php foreach ( $children as $child ) : ?>
                            <a href="<?php echo esc_url( get_permalink( $child->ID ) ); ?>" class="button button--ghost">
                                <?php echo esc_html( $child->post_title ); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

</main>

<?php
get_footer();
