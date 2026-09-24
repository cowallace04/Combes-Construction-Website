<?php
/**
 * Register taxonomies for Projects.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function combes_core_register_project_taxonomies() {

    // Project Status.
    $status_labels = array(
        'name'          => __( 'Project Statuses', 'combes-core' ),
        'singular_name' => __( 'Project Status', 'combes-core' ),
        'menu_name'     => __( 'Project Status', 'combes-core' ),
        'all_items'     => __( 'All Statuses', 'combes-core' ),
        'edit_item'     => __( 'Edit Status', 'combes-core' ),
        'view_item'     => __( 'View Status', 'combes-core' ),
        'update_item'   => __( 'Update Status', 'combes-core' ),
        'add_new_item'  => __( 'Add New Status', 'combes-core' ),
        'search_items'  => __( 'Search Statuses', 'combes-core' ),
    );

    register_taxonomy(
        'combes_project_status',
        array( 'combes_project' ),
        array(
            'labels'            => $status_labels,
            'public'            => true,
            'show_in_rest'      => true,
            'hierarchical'      => true,
            'show_admin_column' => true,
            'rewrite'           => array(
                'slug'       => 'project-status',
                'with_front' => false,
            ),
        )
    );

    // Project Type.
    $type_labels = array(
        'name'          => __( 'Project Types', 'combes-core' ),
        'singular_name' => __( 'Project Type', 'combes-core' ),
        'menu_name'     => __( 'Project Type', 'combes-core' ),
        'all_items'     => __( 'All Types', 'combes-core' ),
        'edit_item'     => __( 'Edit Type', 'combes-core' ),
        'view_item'     => __( 'View Type', 'combes-core' ),
        'update_item'   => __( 'Update Type', 'combes-core' ),
        'add_new_item'  => __( 'Add New Type', 'combes-core' ),
        'search_items'  => __( 'Search Types', 'combes-core' ),
    );

    register_taxonomy(
        'combes_project_type',
        array( 'combes_project' ),
        array(
            'labels'            => $type_labels,
            'public'            => true,
            'show_in_rest'      => true,
            'hierarchical'      => true,
            'show_admin_column' => true,
            'rewrite'           => array(
                'slug'       => 'project-type',
                'with_front' => false,
            ),
        )
    );

    // Delivery Method.
    $delivery_labels = array(
        'name'          => __( 'Delivery Methods', 'combes-core' ),
        'singular_name' => __( 'Delivery Method', 'combes-core' ),
        'menu_name'     => __( 'Delivery Method', 'combes-core' ),
        'all_items'     => __( 'All Methods', 'combes-core' ),
        'edit_item'     => __( 'Edit Method', 'combes-core' ),
        'view_item'     => __( 'View Method', 'combes-core' ),
        'update_item'   => __( 'Update Method', 'combes-core' ),
        'add_new_item'  => __( 'Add New Method', 'combes-core' ),
        'search_items'  => __( 'Search Methods', 'combes-core' ),
    );

    register_taxonomy(
        'combes_delivery_method',
        array( 'combes_project' ),
        array(
            'labels'            => $delivery_labels,
            'public'            => true,
            'show_in_rest'      => true,
            'hierarchical'      => true,
            'show_admin_column' => true,
            'rewrite'           => array(
                'slug'       => 'delivery-method',
                'with_front' => false,
            ),
        )
    );

    // Seed default terms (idempotent).
    $default_statuses = array( 'Current', 'Completed', 'Bidding' );
    foreach ( $default_statuses as $status ) {
        if ( ! term_exists( $status, 'combes_project_status' ) ) {
            wp_insert_term( $status, 'combes_project_status' );
        }
    }

    $default_types = array(
        'Education',
        'Municipal',
        'Parks & Recreation',
        'Commercial',
        'Financial',
        'Other',
    );
    foreach ( $default_types as $type ) {
        if ( ! term_exists( $type, 'combes_project_type' ) ) {
            wp_insert_term( $type, 'combes_project_type' );
        }
    }

    $default_methods = array(
        'General Contracting',
        'Design-Build',
        'Construction Management',
    );
    foreach ( $default_methods as $method ) {
        if ( ! term_exists( $method, 'combes_delivery_method' ) ) {
            wp_insert_term( $method, 'combes_delivery_method' );
        }
    }
}
add_action( 'init', 'combes_core_register_project_taxonomies' );
