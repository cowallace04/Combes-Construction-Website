<?php
/**
 * Template Name: Contact
 * Description: Contact page with office info, contact forms, and map; content via blocks.
 */

get_header();
?>

<main id="primary" class="site-main page-contact">

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

                    <div class="page-contact__body">
                        <?php the_content(); // pattern: combes/page-contact ?>
                    </div>
                    <?php
                endwhile;
            endif;
            ?>
        </div>
    </section>

</main>

<?php
get_footer();
