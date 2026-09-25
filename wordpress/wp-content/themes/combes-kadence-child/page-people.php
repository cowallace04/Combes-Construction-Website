<?php
/**
 * Template Name: Our People
 * Description: Our People page (leadership / team); editable content + Team CPT grid.
 */

get_header();
?>

<main id="primary" class="site-main page-people">
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
