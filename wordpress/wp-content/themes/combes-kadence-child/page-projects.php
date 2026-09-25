<?php
/**
 * Template Name: Projects
 * Description: Projects overview page with filters, search, and masonry layout.
 */

get_header();

// Capture filters from query string.
$search       = isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : '';
$type_filter  = isset( $_GET['type'] ) ? sanitize_text_field( wp_unslash( $_GET['type'] ) ) : '';
$status_filter= isset( $_GET['status'] ) ? sanitize_text_field( wp_unslash( $_GET['status'] ) ) : '';

$tax_queries = array();

if ( $type_filter ) {
    $tax_queries[] = array(
        'taxonomy' => 'combes_project_type',
        'field'    => 'slug',
        'terms'    => $type_filter,
    );
}

if ( $status_filter ) {
    $tax_queries[] = array(
        'taxonomy' => 'combes_project_status',
        'field'    => 'slug',
        'terms'    => $status_filter,
    );
}

$paged = max( 1, get_query_var( 'paged' ) ?: ( isset( $_GET['paged'] ) ? (int) $_GET['paged'] : 1 ) );

$query_args = array(
    'post_type'      => 'combes_project',
    'posts_per_page' => 20,
    'paged'          => $paged,
    's'              => $search,
);

if ( ! empty( $tax_queries ) ) {
    $query_args['tax_query'] = $tax_queries;
}

$projects_query = new WP_Query( $query_args );
?>

<main id="primary" class="site-main page-projects">

    <!-- Intro / editable content via Gutenberg -->
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

                    <div class="page-projects__intro">
                        <?php the_content(); ?>
                    </div>
                    <?php
                endwhile;
                // Reset main query back to page.
                rewind_posts();
            endif;
            ?>
        </div>
    </section>

    <!-- Filter + search bar -->
    <section class="section section--surface" data-aos="fade-up">
        <div class="section__inner">
            <form class="page-projects__filters" method="get">
                <div class="page-projects__filters-row">
                    <?php
                    $type_terms = get_terms(
                        array(
                            'taxonomy'   => 'combes_project_type',
                            'hide_empty' => true,
                        )
                    );
                    $status_terms = get_terms(
                        array(
                            'taxonomy'   => 'combes_project_status',
                            'hide_empty' => true,
                        )
                    );
                    ?>

                    <div class="page-projects__filter">
                        <label for="filter-type">Type</label>
                        <select id="filter-type" name="type">
                            <option value="">All Types</option>
                            <?php foreach ( $type_terms as $term ) : ?>
                                <option value="<?php echo esc_attr( $term->slug ); ?>" <?php selected( $type_filter, $term->slug ); ?>>
                                    <?php echo esc_html( $term->name ); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="page-projects__filter">
                        <label for="filter-status">Status</label>
                        <select id="filter-status" name="status">
                            <option value="">All Statuses</option>
                            <?php foreach ( $status_terms as $term ) : ?>
                                <option value="<?php echo esc_attr( $term->slug ); ?>" <?php selected( $status_filter, $term->slug ); ?>>
                                    <?php echo esc_html( $term->name ); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="page-projects__filter page-projects__filter--search">
                        <label for="filter-search">Search</label>
                        <input id="filter-search" type="search" name="s" value="<?php echo esc_attr( $search ); ?>" placeholder="Search projects..." />
                    </div>

                    <div class="page-projects__filter-actions">
                        <button type="submit" class="button kt-button">
                            Apply
                        </button>
                        <a href="<?php echo esc_url( get_permalink() ); ?>" class="button button--ghost">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Masonry portfolio -->
    <section class="section section--dark" data-aos="fade-up">
        <div class="section__inner">
            <?php if ( $projects_query->have_posts() ) : ?>
                <div class="projects-masonry">
                    <?php
                    while ( $projects_query->have_posts() ) :
                        $projects_query->the_post();

                        $project_id   = get_the_ID();
                        $location     = get_post_meta( $project_id, 'combes_project_location', true );
                        $completion   = get_post_meta( $project_id, 'combes_project_completion_date', true );
                        $type_terms   = get_the_terms( $project_id, 'combes_project_type' );
                        $type_label   = ( $type_terms && ! is_wp_error( $type_terms ) ) ? $type_terms[0]->name : '';
                        ?>
                        <article <?php post_class( 'card card--project animate-fade-up' ); ?>>
                            <a href="<?php the_permalink(); ?>" class="card__link">
                                <div class="card__media">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <?php the_post_thumbnail( 'large' ); ?>
                                    <?php endif; ?>
                                    <div class="card__overlay">
                                        <?php if ( $type_label ) : ?>
                                            <span class="card__overlay-category">
                                                <?php echo esc_html( $type_label ); ?>
                                            </span>
                                        <?php endif; ?>
                                        <h3 class="card__overlay-title"><?php the_title(); ?></h3>
                                        <span class="card__overlay-cta">View Project &rarr;</span>
                                    </div>
                                </div>
                                <div class="card__body">
                                    <h3 class="card__title"><?php the_title(); ?></h3>
                                    <?php if ( $location ) : ?>
                                        <p class="card__location"><?php echo esc_html( $location ); ?></p>
                                    <?php endif; ?>
                                    <?php if ( $completion ) : ?>
                                        <p class="card__meta"><strong>Completed:</strong> <?php echo esc_html( $completion ); ?></p>
                                    <?php endif; ?>
                                    <?php if ( has_excerpt() ) : ?>
                                        <p class="card__excerpt">
                                            <?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </a>
                        </article>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>

                <div class="page-projects__pagination">
                    <?php
                    echo paginate_links(
                        array(
                            'total'   => $projects_query->max_num_pages,
                            'current' => $paged,
                        )
                    );
                    ?>
                </div>

            <?php else : ?>

                <p>No projects found. Try adjusting filters or check back as we add additional work.</p>

            <?php endif; ?>
        </div>
    </section>

</main>

<?php
get_footer();
