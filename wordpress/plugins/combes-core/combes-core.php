<?php
/**
 * Plugin Name:       Combes Core
 * Description:       Core business data structures for the Combes Construction website (projects, team, jobs, inquiries).
 * Version:           0.1.0
 * Author:            Colton Wallace
 * Text Domain:       combes-core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'COMBES_CORE_VERSION', '0.1.0' );
define( 'COMBES_CORE_PATH', plugin_dir_path( __FILE__ ) );
define( 'COMBES_CORE_URL', plugin_dir_url( __FILE__ ) );

/**
 * Load taxonomies, metadata, integrations, and admin meta boxes.
 */
function combes_core_load_includes() {
    // Taxonomies.
    require_once COMBES_CORE_PATH . 'includes/taxonomies/register-project-taxonomies.php';

    // Metadata.
    require_once COMBES_CORE_PATH . 'includes/metadata/register-project-meta.php';
    require_once COMBES_CORE_PATH . 'includes/metadata/register-team-meta.php';
    require_once COMBES_CORE_PATH . 'includes/metadata/register-job-meta.php';
    require_once COMBES_CORE_PATH . 'includes/metadata/register-bid-meta.php';
    require_once COMBES_CORE_PATH . 'includes/metadata/register-inquiry-meta.php';

    // Front-end integrations.
    require_once COMBES_CORE_PATH . 'includes/integrations/build-with-combes-handler.php';

    // Admin meta boxes (only in admin).
    if ( is_admin() ) {
        require_once COMBES_CORE_PATH . 'includes/admin/register-meta-boxes.php';
    }
}
add_action( 'plugins_loaded', 'combes_core_load_includes' );

/**
 * Register all custom post types.
 */
function combes_core_register_post_types() {

    /* Projects (combes_project) */
    $project_labels = array(
        'name'               => __( 'Projects', 'combes-core' ),
        'singular_name'      => __( 'Project', 'combes-core' ),
        'menu_name'          => __( 'Projects', 'combes-core' ),
        'name_admin_bar'     => __( 'Project', 'combes-core' ),
        'add_new'            => __( 'Add New', 'combes-core' ),
        'add_new_item'       => __( 'Add New Project', 'combes-core' ),
        'edit_item'          => __( 'Edit Project', 'combes-core' ),
        'new_item'           => __( 'New Project', 'combes-core' ),
        'view_item'          => __( 'View Project', 'combes-core' ),
        'view_items'         => __( 'View Projects', 'combes-core' ),
        'search_items'       => __( 'Search Projects', 'combes-core' ),
        'not_found'          => __( 'No projects found.', 'combes-core' ),
        'not_found_in_trash' => __( 'No projects found in Trash.', 'combes-core' ),
        'all_items'          => __( 'All Projects', 'combes-core' ),
        'archives'           => __( 'Project Archives', 'combes-core' ),
    );

    $project_args = array(
        'labels'             => $project_labels,
        'public'             => true,
        'show_in_rest'       => true,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-building',
        'supports'           => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail',
            'revisions',
            'custom-fields',
        ),
        'has_archive'        => 'projects',
        'rewrite'            => array(
            'slug'       => 'projects',
            'with_front' => false,
        ),
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
    );

    register_post_type( 'combes_project', $project_args );

    /* Team Members (combes_team_member) */
    $team_labels = array(
        'name'               => __( 'Team Members', 'combes-core' ),
        'singular_name'      => __( 'Team Member', 'combes-core' ),
        'menu_name'          => __( 'Team Members', 'combes-core' ),
        'name_admin_bar'     => __( 'Team Member', 'combes-core' ),
        'add_new'            => __( 'Add New', 'combes-core' ),
        'add_new_item'       => __( 'Add New Team Member', 'combes-core' ),
        'edit_item'          => __( 'Edit Team Member', 'combes-core' ),
        'new_item'           => __( 'New Team Member', 'combes-core' ),
        'view_item'          => __( 'View Team Member', 'combes-core' ),
        'view_items'         => __( 'View Team Members', 'combes-core' ),
        'search_items'       => __( 'Search Team Members', 'combes-core' ),
        'not_found'          => __( 'No team members found.', 'combes-core' ),
        'not_found_in_trash' => __( 'No team members found in Trash.', 'combes-core' ),
        'all_items'          => __( 'All Team Members', 'combes-core' ),
        'archives'           => __( 'Team Member Archives', 'combes-core' ),
    );

    $team_args = array(
        'labels'             => $team_labels,
        'public'             => true,
        'show_in_rest'       => true,
        'hierarchical'       => false,
        'menu_position'      => 21,
        'menu_icon'          => 'dashicons-groups',
        'supports'           => array(
            'title',
            'editor',
            'thumbnail',
            'revisions',
            'custom-fields',
        ),
        'has_archive'        => 'our-people',
        'rewrite'            => array(
            'slug'       => 'our-people',
            'with_front' => false,
        ),
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
    );

    register_post_type( 'combes_team_member', $team_args );

    /* Job Openings (combes_job_opening) */
    $job_labels = array(
        'name'               => __( 'Job Openings', 'combes-core' ),
        'singular_name'      => __( 'Job Opening', 'combes-core' ),
        'menu_name'          => __( 'Job Openings', 'combes-core' ),
        'name_admin_bar'     => __( 'Job Opening', 'combes-core' ),
        'add_new'            => __( 'Add New', 'combes-core' ),
        'add_new_item'       => __( 'Add New Job Opening', 'combes-core' ),
        'edit_item'          => __( 'Edit Job Opening', 'combes-core' ),
        'new_item'           => __( 'New Job Opening', 'combes-core' ),
        'view_item'          => __( 'View Job Opening', 'combes-core' ),
        'view_items'         => __( 'View Job Openings', 'combes-core' ),
        'search_items'       => __( 'Search Job Openings', 'combes-core' ),
        'not_found'          => __( 'No job openings found.', 'combes-core' ),
        'not_found_in_trash' => __( 'No job openings found in Trash.', 'combes-core' ),
        'all_items'          => __( 'All Job Openings', 'combes-core' ),
        'archives'           => __( 'Job Opening Archives', 'combes-core' ),
    );

    $job_args = array(
        'labels'             => $job_labels,
        'public'             => true,
        'show_in_rest'       => true,
        'hierarchical'       => false,
        'menu_position'      => 22,
        'menu_icon'          => 'dashicons-clipboard',
        'supports'           => array(
            'title',
            'editor',
            'excerpt',
            'revisions',
            'custom-fields',
        ),
        'has_archive'        => 'available-positions',
        'rewrite'            => array(
            'slug'       => 'available-positions',
            'with_front' => false,
        ),
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
    );

    register_post_type( 'combes_job_opening', $job_args );

    /* Bidding Opportunities (combes_bid_opportunity) – retained but hidden */
    $bid_labels = array(
        'name'               => __( 'Bidding Opportunities', 'combes-core' ),
        'singular_name'      => __( 'Bidding Opportunity', 'combes-core' ),
        'menu_name'          => __( 'Bidding Opportunities', 'combes-core' ),
        'name_admin_bar'     => __( 'Bidding Opportunity', 'combes-core' ),
        'add_new'            => __( 'Add New', 'combes-core' ),
        'add_new_item'       => __( 'Add New Bidding Opportunity', 'combes-core' ),
        'edit_item'          => __( 'Edit Bidding Opportunity', 'combes-core' ),
        'new_item'           => __( 'New Bidding Opportunity', 'combes-core' ),
        'view_item'          => __( 'View Bidding Opportunity', 'combes-core' ),
        'view_items'         => __( 'View Bidding Opportunities', 'combes-core' ),
        'search_items'       => __( 'Search Bidding Opportunities', 'combes-core' ),
        'not_found'          => __( 'No bidding opportunities found.', 'combes-core' ),
        'not_found_in_trash' => __( 'No bidding opportunities found in Trash.', 'combes-core' ),
        'all_items'          => __( 'All Bidding Opportunities', 'combes-core' ),
        'archives'           => __( 'Bidding Opportunity Archives', 'combes-core' ),
    );

    $bid_args = array(
        'labels'             => $bid_labels,
        'public'             => false,
        'show_in_rest'       => false,
        'hierarchical'       => false,
        'menu_position'      => 23,
        'menu_icon'          => 'dashicons-media-spreadsheet',
        'supports'           => array(
            'title',
            'editor',
            'excerpt',
            'revisions',
            'custom-fields',
        ),
        'has_archive'        => false,
        'rewrite'            => false,
        'publicly_queryable' => false,
        'show_ui'            => false,
        'show_in_menu'       => false,
    );

    register_post_type( 'combes_bid_opportunity', $bid_args );

    /* Project Inquiries (combes_inquiry) */
    $inquiry_labels = array(
        'name'               => __( 'Project Inquiries', 'combes-core' ),
        'singular_name'      => __( 'Project Inquiry', 'combes-core' ),
        'menu_name'          => __( 'Project Inquiries', 'combes-core' ),
        'name_admin_bar'     => __( 'Project Inquiry', 'combes-core' ),
        'add_new'            => __( 'Add New', 'combes-core' ),
        'add_new_item'       => __( 'Add New Inquiry', 'combes-core' ),
        'edit_item'          => __( 'Edit Inquiry', 'combes-core' ),
        'new_item'           => __( 'New Inquiry', 'combes-core' ),
        'view_item'          => __( 'View Inquiry', 'combes-core' ),
        'view_items'         => __( 'View Inquiries', 'combes-core' ),
        'search_items'       => __( 'Search Inquiries', 'combes-core' ),
        'not_found'          => __( 'No inquiries found.', 'combes-core' ),
        'not_found_in_trash' => __( 'No inquiries found in Trash.', 'combes-core' ),
        'all_items'          => __( 'All Project Inquiries', 'combes-core' ),
        'archives'           => __( 'Project Inquiry Archives', 'combes-core' ),
    );

    $inquiry_args = array(
        'labels'             => $inquiry_labels,
        'public'             => false,
        'show_in_rest'       => false,
        'hierarchical'       => false,
        'menu_position'      => 24,
        'menu_icon'          => 'dashicons-email-alt',
        'supports'           => array(
            'title',
            'editor',
            'custom-fields',
        ),
        'has_archive'        => false,
        'rewrite'            => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
    );

    register_post_type( 'combes_inquiry', $inquiry_args );
}
add_action( 'init', 'combes_core_register_post_types' );

/**
 * Ensure a page exists with a given slug/title/template/parent.
 * Idempotent: will reuse existing pages if they already exist.
 */
function combes_core_ensure_page( $slug, $title, $template = '', $parent_id = 0 ) {
    $existing = get_page_by_path( $slug );
    if ( $existing && 'page' === $existing->post_type ) {
        $page_id = $existing->ID;

        // Ensure correct parent if specified.
        if ( $parent_id && $existing->post_parent !== $parent_id ) {
            wp_update_post(
                array(
                    'ID'          => $page_id,
                    'post_parent' => $parent_id,
                )
            );
        }
    } else {
        $page_id = wp_insert_post(
            array(
                'post_title'   => $title,
                'post_name'    => $slug,
                'post_type'    => 'page',
                'post_status'  => 'publish',
                'post_parent'  => $parent_id,
                'post_content' => '',
            )
        );
    }

    if ( $page_id && $template ) {
        update_post_meta( $page_id, '_wp_page_template', $template );
    }

    return $page_id;
}

/**
 * Seed block-pattern content only if a page is currently empty.
 */
function combes_core_seed_page_if_empty( $page_id, $content ) {
    if ( ! $page_id ) {
        return;
    }
    $page = get_post( $page_id );
    if ( $page && '' === trim( $page->post_content ) ) {
        wp_update_post(
            array(
                'ID'           => $page_id,
                'post_content' => $content,
            )
        );
    }
}

/**
 * On plugin activation, create core pages & primary menu.
 */
function combes_core_activate() {

    // Ensure CPTs exist during activation.
    combes_core_register_post_types();

    // Top-level pages.
    $home_id     = combes_core_ensure_page( 'home', 'Home', 'front-page.php' );
    $about_id    = combes_core_ensure_page( 'about-us', 'About Us', 'page-about.php' );
    $process_id  = combes_core_ensure_page( 'our-process', 'Our Process', 'page-process.php' );
    $projects_id = combes_core_ensure_page( 'projects', 'Projects', 'page-projects.php' );
    $careers_id  = combes_core_ensure_page( 'careers', 'Careers', 'page-careers.php' );
    $build_id    = combes_core_ensure_page( 'build-with-combes', 'Build With Combes', 'page-build-with-combes.php' );
    $contact_id  = combes_core_ensure_page( 'contact-us', 'Contact Us', 'page-contact.php' );

    // Children under About Us.
    $people_id  = combes_core_ensure_page( 'our-people', 'Our People', 'page-people.php', $about_id );
    $history_id = combes_core_ensure_page( 'our-history', 'Our History', 'page.php', $about_id );

    // Children under Careers.
    $positions_page_id   = combes_core_ensure_page( 'available-positions', 'Available Positions', 'page.php', $careers_id );
    $internships_page_id = combes_core_ensure_page( 'internships', 'Internships', 'page.php', $careers_id );

    // Seed content using patterns – only if pages are empty.
    combes_core_seed_page_if_empty(
        $home_id,
        '<!-- wp:pattern {"slug":"combes/home-hero"} /-->'
        . '<!-- wp:pattern {"slug":"combes/home-featured-projects"} /-->'
        . '<!-- wp:pattern {"slug":"combes/home-stats"} /-->'
    );

    combes_core_seed_page_if_empty( $about_id,   '<!-- wp:pattern {"slug":"combes/page-about"} /-->' );
    combes_core_seed_page_if_empty( $people_id,  '<!-- wp:pattern {"slug":"combes/page-people"} /-->' );
    combes_core_seed_page_if_empty( $careers_id, '<!-- wp:pattern {"slug":"combes/page-careers"} /-->' );
    combes_core_seed_page_if_empty( $process_id, '<!-- wp:pattern {"slug":"combes/page-process"} /-->' );
    combes_core_seed_page_if_empty( $contact_id, '<!-- wp:pattern {"slug":"combes/page-contact"} /-->' );

    // Build primary navigation menu (top-level pages only).
    $page_ids = array(
        'home'             => $home_id,
        'about-us'         => $about_id,
        'our-process'      => $process_id,
        'projects'         => $projects_id,
        'careers'          => $careers_id,
        'build-with-combes'=> $build_id,
        'contact-us'       => $contact_id,
    );

    $menu_name = 'Combes Primary Navigation';
    $menu      = wp_get_nav_menu_object( $menu_name );
    $menu_id   = $menu ? $menu->term_id : wp_create_nav_menu( $menu_name );

    $order = array( 'home', 'about-us', 'our-process', 'projects', 'careers', 'build-with-combes', 'contact-us' );

    foreach ( $order as $position => $slug ) {
        if ( empty( $page_ids[ $slug ] ) ) {
            continue;
        }

        wp_update_nav_menu_item(
            $menu_id,
            0,
            array(
                'menu-item-object-id' => $page_ids[ $slug ],
                'menu-item-object'    => 'page',
                'menu-item-type'      => 'post_type',
                'menu-item-title'     => get_the_title( $page_ids[ $slug ] ),
                'menu-item-url'       => get_permalink( $page_ids[ $slug ] ),
                'menu-item-status'    => 'publish',
                'menu-item-position'  => $position + 1,
            )
        );
    }

    // Assign menu to Kadence primary location.
    $locations = get_theme_mod( 'nav_menu_locations' );
    if ( ! is_array( $locations ) ) {
        $locations = array();
    }
    $locations['primary'] = $menu_id;
    set_theme_mod( 'nav_menu_locations', $locations );
}
register_activation_hook( __FILE__, 'combes_core_activate' );
