<?php
/**
 * Register the Bidding Opportunity custom post type.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function combes_core_register_bidding_opportunity_post_type() {
    $labels = array(
        'name'                  => __( 'Bidding Opportunities', 'combes-core' ),
        'singular_name'         => __( 'Bidding Opportunity', 'combes-core' ),
        'menu_name'             => __( 'Bidding Opportunities', 'combes-core' ),
        'name_admin_bar'        => __( 'Bidding Opportunity', 'combes-core' ),
        'add_new'               => __( 'Add New', 'combes-core' ),
        'add_new_item'          => __( 'Add New Bidding Opportunity', 'combes-core' ),
        'edit_item'             => __( 'Edit Bidding Opportunity', 'combes-core' ),
        'new_item'              => __( 'New Bidding Opportunity', 'combes-core' ),
        'view_item'             => __( 'View Bidding Opportunity', 'combes-core' ),
        'view_items'            => __( 'View Bidding Opportunities', 'combes-core' ),
        'search_items'          => __( 'Search Bidding Opportunities', 'combes-core' ),
        'not_found'             => __( 'No bidding opportunities found.', 'combes-core' ),
        'not_found_in_trash'    => __( 'No bidding opportunities found in Trash.', 'combes-core' ),
        'all_items'             => __( 'All Bidding Opportunities', 'combes-core' ),
        'archives'              => __( 'Bidding Opportunity Archives', 'combes-core' ),
        'attributes'            => __( 'Bidding Opportunity Attributes', 'combes-core' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'show_in_rest'       => true,
        'hierarchical'       => false,
        'menu_position'      => 23,
        'menu_icon'          => 'dashicons-media-spreadsheet',
        'supports'           => array(
            'title',        // Bid/project name
            'editor',       // Description / scope summary
            'excerpt',
            'revisions',
            'custom-fields'
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

    register_post_type( 'combes_bid_opportunity', $args );
}
add_action( 'init', 'combes_core_register_bidding_opportunity_post_type' );
