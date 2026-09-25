<?php
/**
 * Title: Featured Projects – Combes
 * Slug: combes/home-featured-projects
 * Categories: combes-home
 * Description: Featured Projects section using the [combes_featured_projects] shortcode.
 */
?>
<!-- wp:group {"align":"full","className":"section home-projects animate-fade-up"} -->
<div class="wp-block-group alignfull section home-projects animate-fade-up">
  <!-- wp:group {"className":"section__inner"} -->
  <div class="wp-block-group section__inner">
    <!-- Header is rendered by the shortcode, but you can add a manual one if desired -->

    <!-- Shortcode block -->
    <!-- wp:shortcode -->
    [combes_featured_projects layout="masonry"]

    <!-- /wp:shortcode -->

  </div>
  <!-- /wp:group -->
</div>
<!-- /wp:group -->
