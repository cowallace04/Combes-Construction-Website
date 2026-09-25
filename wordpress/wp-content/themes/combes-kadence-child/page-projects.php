<?php
/**
 * Template Name: Projects
 * Description: Projects overview page using Gutenberg/Kadence Blocks.
 */

get_header();
?>

<main id="primary" class="site-main page-projects">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) :
            the_post();
            // Editable content (filters, featured projects, intro) via blocks.
            the_content();
        endwhile;
    endif;
    ?>
</main>

<?php
get_footer();
