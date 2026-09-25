<?php
/**
 * Template Name: Our Process
 * Description: Combes process page; editable blocks for steps/timeline.
 */

get_header();
?>

<main id="primary" class="site-main page-process">
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
