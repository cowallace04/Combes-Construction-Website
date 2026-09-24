<?php
/**
 * Register the Project custom post type.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function combes_core_register_project_post_type() {
    $labels = array(
        'name'                  => __( 'Projects', 'combes-core' ),
        'singular_name'         => __( 'Project', 'combes-core' ),
        'menu_name'             => __( 'Projects', 'combes-core' ),
        'name_admin_bar'        => __( 'Project', 'combes-core' ),
        'add_new'               => __( 'Add New', 'combes-core' ),
        'add_new_item'          => __( 'Add New Project', 'combes-core' ),
        'edit_item'             => __( 'Edit Project', 'combes-core' ),
        'new_item'              => __( 'New Project', 'combes-core' ),
        'view_item'             => __( 'View Project', 'combes-core' ),
        'view_items'            => __( 'View Projects', 'combes-core' ),
        'search_items'          => __( 'Search Projects', 'combes-core' ),
        'not_found'             => __( 'No projects found.', 'combes-core' ),
        'not_found_in_trash'    => __( 'No projects found in Trash.', 'combes-core' ),
        'all_items'             => __( 'All Projects', 'combes-core' ),
        'archives'              => __( 'Project Archives', 'combes-core' ),
        'attributes'            => __( 'Project Attributes', 'combes-core' ),
        'insert_into_item'      => __( 'Insert into project', 'combes-core' ),
        'uploaded_to_this_item' => __( 'Uploaded to this project', 'combes-core' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'show_in_rest'       => true,              // Gutenberg + REST.
        'hierarchical'       => false,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-building',
        'supports'           => array(
            'title',
            'editor',       // Full story / description.
            'excerpt',      // Short card blurb.
            'thumbnail',    // Featured image.
            'revisions',
            'custom-fields' // Needed for registered post meta.
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

    register_post_type( 'combes_project', $args );
}
add_action( 'init', 'combes_core_register_project_post_type' );
