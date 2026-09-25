<?php
/**
 * Front Page template for Combes (Home).
 * Content is edited via Gutenberg/Kadence Blocks.
 */

get_header();
?>

<main id="primary" class="site-main front-page">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) :
            the_post();
            the_content();
        endwhile;
    endif;
    ?>
</main>

<?php
get_footer();
