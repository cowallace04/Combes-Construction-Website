<?php
/**
 * Template Name: Contact
 * Description: Contact page with map, contact info, and forms.
 */

get_header();
?>

<main id="primary" class="site-main page-contact">
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
