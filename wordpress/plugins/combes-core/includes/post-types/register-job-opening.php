<?php
/**
 * Register the Job Opening custom post type.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function combes_core_register_job_opening_post_type() {
    $labels = array(
        'name'                  => __( 'Job Openings', 'combes-core' ),
        'singular_name'         => __( 'Job Opening', 'combes-core' ),
        'menu_name'             => __( 'Job Openings', 'combes-core' ),
        'name_admin_bar'        => __( 'Job Opening', 'combes-core' ),
        'add_new'               => __( 'Add New', 'combes-core' ),
        'add_new_item'          => __( 'Add New Job Opening', 'combes-core' ),
        'edit_item'             => __( 'Edit Job Opening', 'combes-core' ),
        'new_item'              => __( 'New Job Opening', 'combes-core' ),
        'view_item'             => __( 'View Job Opening', 'combes-core' ),
        'view_items'            => __( 'View Job Openings', 'combes-core' ),
        'search_items'          => __( 'Search Job Openings', 'combes-core' ),
        'not_found'             => __( 'No job openings found.', 'combes-core' ),
        'not_found_in_trash'    => __( 'No job openings found in Trash.', 'combes-core' ),
        'all_items'             => __( 'All Job Openings', 'combes-core' ),
        'archives'              => __( 'Job Opening Archives', 'combes-core' ),
        'attributes'            => __( 'Job Opening Attributes', 'combes-core' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'show_in_rest'       => true,
        'hierarchical'       => false,
        'menu_position'      => 22,
        'menu_icon'          => 'dashicons-clipboard',
        'supports'           => array(
            'title',        // Job title
            'editor',       // Summary / description
            'excerpt',      // Short teaser
            'revisions',
            'custom-fields'
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

    register_post_type( 'combes_job_opening', $args );
}
add_action( 'init', 'combes_core_register_job_opening_post_type' );
