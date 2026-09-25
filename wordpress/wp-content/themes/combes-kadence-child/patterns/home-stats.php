<?php
/**
 * Title: Statistics – Combes
 * Slug: combes/home-stats
 * Categories: combes-home
 * Description: Three-column statistics band with animated counters.
 */
?>
<!-- wp:group {"align":"full","className":"section home-stats animate-fade-up"} -->
<div class="wp-block-group alignfull section home-stats animate-fade-up">
  <!-- wp:group {"className":"section__inner home-stats__inner"} -->
  <div class="wp-block-group section__inner home-stats__inner">
    <!-- wp:columns -->
    <div class="wp-block-columns">
      <!-- Stat 1 -->
      <!-- wp:column -->
      <div class="wp-block-column">
        <!-- wp:paragraph {"className":"home-stat"} -->
        <p class="home-stat">
          <span class="stat-counter animate-fade-up" data-counter data-counter-target="50" data-counter-duration="1200">0</span><br>
          <span class="stat-label">Projects Completed</span>
        </p>
        <!-- /wp:paragraph -->
      </div>
      <!-- /wp:column -->

      <!-- Stat 2 -->
      <!-- wp:column -->
      <div class="wp-block-column">
        <!-- wp:paragraph {"className":"home-stat"} -->
        <p class="home-stat">
          <span class="stat-counter animate-fade-up animate-delay-1" data-counter data-counter-target="20" data-counter-duration="1200">0</span><br>
          <span class="stat-label">Years Experience</span>
        </p>
        <!-- /wp:paragraph -->
      </div>
      <!-- /wp:column -->

      <!-- Stat 3 -->
      <!-- wp:column -->
      <div class="wp-block-column">
        <!-- wp:paragraph {"className":"home-stat"} -->
        <p class="home-stat">
          <span class="stat-counter animate-fade-up animate-delay-2" data-counter data-counter-target="100" data-counter-duration="1500">0</span><br>
          <span class="stat-label">$M+ Construction Value</span>
        </p>
        <!-- /wp:paragraph -->
      </div>
      <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->
  </div>
  <!-- /wp:group -->
</div>
<!-- /wp:group -->
