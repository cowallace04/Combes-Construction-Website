<?php
/**
 * Register metadata for Bidding Opportunities.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function combes_core_bid_meta_auth( $allowed, $meta_key, $post_id, $user_id, $cap, $caps ) {
    return current_user_can( 'edit_post', $post_id );
}

function combes_core_register_bid_meta() {

    $post_type = 'combes_bid_opportunity';

    // Location (city, state).
    register_post_meta(
        $post_type,
        'combes_bid_location',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => 'combes_core_bid_meta_auth',
            'show_in_rest'      => true,
        )
    );

    // Bid deadline (YYYY-MM-DD, or date/time string).
    register_post_meta(
        $post_type,
        'combes_bid_deadline',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => 'combes_core_bid_meta_auth',
            'show_in_rest'      => true,
        )
    );

    // Contact (name or role).
    register_post_meta(
        $post_type,
        'combes_bid_contact',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => 'combes_core_bid_meta_auth',
            'show_in_rest'      => true,
        )
    );

    // Scope packages (e.g., sitework, structural, finishes).
    register_post_meta(
        $post_type,
        'combes_bid_scope_packages',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'wp_kses_post',
            'auth_callback'     => 'combes_core_bid_meta_auth',
            'show_in_rest'      => true,
        )
    );

    // Document links (one field for now; can be a list).
    register_post_meta(
        $post_type,
        'combes_bid_document_links',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'wp_kses_post',
            'auth_callback'     => 'combes_core_bid_meta_auth',
            'show_in_rest'      => true,
        )
    );

    // Addenda summary.
    register_post_meta(
        $post_type,
        'combes_bid_addenda',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'wp_kses_post',
            'auth_callback'     => 'combes_core_bid_meta_auth',
            'show_in_rest'      => true,
        )
    );

    // Open/closed status.
    register_post_meta(
        $post_type,
        'combes_bid_open',
        array(
            'type'              => 'boolean',
            'single'            => true,
            'default'           => true,
            'sanitize_callback' => 'rest_sanitize_boolean',
            'auth_callback'     => 'combes_core_bid_meta_auth',
            'show_in_rest'      => true,
        )
    );

    // Public/private visibility flag.
    register_post_meta(
        $post_type,
        'combes_bid_public',
        array(
            'type'              => 'boolean',
            'single'            => true,
            'default'           => true,
            'sanitize_callback' => 'rest_sanitize_boolean',
            'auth_callback'     => 'combes_core_bid_meta_auth',
            'show_in_rest'      => true,
        )
    );
}
add_action( 'init', 'combes_core_register_bid_meta' );
