<?php
/**
 * Template Name: Careers
 * Description: Careers page; content editable via blocks, can include Job Openings loops.
 */

get_header();
?>

<main id="primary" class="site-main page-careers">
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
