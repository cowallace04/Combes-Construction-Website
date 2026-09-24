<?php
/**
 * Register structured metadata for Projects.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Simple auth callback: only users who can edit the post can edit meta.
 */
function combes_core_meta_auth_callback( $allowed, $meta_key, $post_id, $user_id, $cap, $caps ) {
    return current_user_can( 'edit_post', $post_id );
}

/**
 * Register meta for combes_project.
 */
function combes_core_register_project_meta() {

    $post_type = 'combes_project';

    // Location (city, state).
    register_post_meta(
        $post_type,
        'combes_project_location',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => 'combes_core_meta_auth_callback',
            'show_in_rest'      => true,
        )
    );

    // Owner.
    register_post_meta(
        $post_type,
        'combes_project_owner',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => 'combes_core_meta_auth_callback',
            'show_in_rest'      => true,
        )
    );

    // Architect.
    register_post_meta(
        $post_type,
        'combes_project_architect',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => 'combes_core_meta_auth_callback',
            'show_in_rest'      => true,
        )
    );

    // Timeline (e.g., "2021–2023" or "12 months").
    register_post_meta(
        $post_type,
        'combes_project_timeline',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => 'combes_core_meta_auth_callback',
            'show_in_rest'      => true,
        )
    );

        // Location (city, state) - already there.

    // Address (full street address).
    register_post_meta(
        $post_type,
        'combes_project_address',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => 'combes_core_meta_auth_callback',
            'show_in_rest'      => true,
        )
    );


    // Completion date (stored as YYYY-MM-DD).
    register_post_meta(
        $post_type,
        'combes_project_completion_date',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => 'combes_core_meta_auth_callback',
            'show_in_rest'      => true,
        )
    );

    // Featured toggle (true/false) for homepage collage, etc.
    register_post_meta(
        $post_type,
        'combes_project_featured',
        array(
            'type'              => 'boolean',
            'single'            => true,
            'default'           => false,
            'sanitize_callback' => 'rest_sanitize_boolean',
            'auth_callback'     => 'combes_core_meta_auth_callback',
            'show_in_rest'      => true,
        )
    );

    // Display order (integer; lower = earlier).
    register_post_meta(
        $post_type,
        'combes_project_display_order',
        array(
            'type'              => 'integer',
            'single'            => true,
            'default'           => 0,
            'sanitize_callback' => 'intval',
            'auth_callback'     => 'combes_core_meta_auth_callback',
            'show_in_rest'      => true,
        )
    );
}
add_action( 'init', 'combes_core_register_project_meta' );
