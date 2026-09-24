<?php
/**
 * Register the Team Member custom post type.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function combes_core_register_team_member_post_type() {
    $labels = array(
        'name'                  => __( 'Team Members', 'combes-core' ),
        'singular_name'         => __( 'Team Member', 'combes-core' ),
        'menu_name'             => __( 'Team Members', 'combes-core' ),
        'name_admin_bar'        => __( 'Team Member', 'combes-core' ),
        'add_new'               => __( 'Add New', 'combes-core' ),
        'add_new_item'          => __( 'Add New Team Member', 'combes-core' ),
        'edit_item'             => __( 'Edit Team Member', 'combes-core' ),
        'new_item'              => __( 'New Team Member', 'combes-core' ),
        'view_item'             => __( 'View Team Member', 'combes-core' ),
        'view_items'            => __( 'View Team Members', 'combes-core' ),
        'search_items'          => __( 'Search Team Members', 'combes-core' ),
        'not_found'             => __( 'No team members found.', 'combes-core' ),
        'not_found_in_trash'    => __( 'No team members found in Trash.', 'combes-core' ),
        'all_items'             => __( 'All Team Members', 'combes-core' ),
        'archives'              => __( 'Team Member Archives', 'combes-core' ),
        'attributes'            => __( 'Team Member Attributes', 'combes-core' ),
        'insert_into_item'      => __( 'Insert into team member', 'combes-core' ),
        'uploaded_to_this_item' => __( 'Uploaded to this team member', 'combes-core' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'show_in_rest'       => true,
        'hierarchical'       => false,
        'menu_position'      => 21,
        'menu_icon'          => 'dashicons-groups',
        'supports'           => array(
            'title',        // Name
            'editor',       // Bio + education
            'thumbnail',    // Headshot
            'revisions',
            'custom-fields'
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

    register_post_type( 'combes_team_member', $args );
}
add_action( 'init', 'combes_core_register_team_member_post_type' );
