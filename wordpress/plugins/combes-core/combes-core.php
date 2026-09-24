<?php
/**
 * Plugin Name:       Combes Core
 * Description:       Core business data structures for the Combes Construction website (projects, team, jobs, bidding).
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
 * Load taxonomies, metadata, and admin meta boxes.
 */
function combes_core_load_includes() {
    // Taxonomies.
    require_once COMBES_CORE_PATH . 'includes/taxonomies/register-project-taxonomies.php';

    // Metadata.
    require_once COMBES_CORE_PATH . 'includes/metadata/register-project-meta.php';
    require_once COMBES_CORE_PATH . 'includes/metadata/register-team-meta.php';
    require_once COMBES_CORE_PATH . 'includes/metadata/register-job-meta.php';
    require_once COMBES_CORE_PATH . 'includes/metadata/register-bid-meta.php';

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

    /* Bidding Opportunities (combes_bid_opportunity) */
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
        'public'             => true,
        'show_in_rest'       => true,
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
        'has_archive'        => 'bidding-opportunities',
        'rewrite'            => array(
            'slug'       => 'bidding-opportunities',
            'with_front' => false,
        ),
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
    );

    register_post_type( 'combes_bid_opportunity', $bid_args );
}
add_action( 'init', 'combes_core_register_post_types' );
