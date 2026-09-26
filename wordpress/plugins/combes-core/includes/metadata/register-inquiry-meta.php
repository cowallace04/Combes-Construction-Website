<?php
/**
 * Register structured metadata for Project Inquiries.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function combes_core_inquiry_meta_auth( $allowed, $meta_key, $post_id, $user_id, $cap, $caps ) {
    return current_user_can( 'edit_post', $post_id );
}

function combes_core_register_inquiry_meta() {

    $post_type = 'combes_inquiry';

    // Contact info
    register_post_meta(
        $post_type,
        'combes_inquiry_contact_name',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => 'combes_core_inquiry_meta_auth',
            'show_in_rest'      => true,
        )
    );

    register_post_meta(
        $post_type,
        'combes_inquiry_company',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => 'combes_core_inquiry_meta_auth',
            'show_in_rest'      => true,
        )
    );

    register_post_meta(
        $post_type,
        'combes_inquiry_email',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'sanitize_email',
            'auth_callback'     => 'combes_core_inquiry_meta_auth',
            'show_in_rest'      => true,
        )
    );

    register_post_meta(
        $post_type,
        'combes_inquiry_phone',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => 'combes_core_inquiry_meta_auth',
            'show_in_rest'      => true,
        )
    );

    // Project details
    register_post_meta(
        $post_type,
        'combes_inquiry_project_name',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => 'combes_core_inquiry_meta_auth',
            'show_in_rest'      => true,
        )
    );

    register_post_meta(
        $post_type,
        'combes_inquiry_project_type',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => 'combes_core_inquiry_meta_auth',
            'show_in_rest'      => true,
        )
    );

    register_post_meta(
        $post_type,
        'combes_inquiry_location',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => 'combes_core_inquiry_meta_auth',
            'show_in_rest'      => true,
        )
    );

    register_post_meta(
        $post_type,
        'combes_inquiry_services',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'wp_kses_post',
            'auth_callback'     => 'combes_core_inquiry_meta_auth',
            'show_in_rest'      => true,
        )
    );

    // Budget & schedule
    register_post_meta(
        $post_type,
        'combes_inquiry_budget_range',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => 'combes_core_inquiry_meta_auth',
            'show_in_rest'      => true,
        )
    );

    register_post_meta(
        $post_type,
        'combes_inquiry_timeline',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => 'combes_core_inquiry_meta_auth',
            'show_in_rest'      => true,
        )
    );

    register_post_meta(
        $post_type,
        'combes_inquiry_start_date',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => 'combes_core_inquiry_meta_auth',
            'show_in_rest'      => true,
        )
    );

    // Description & documents
    register_post_meta(
        $post_type,
        'combes_inquiry_description',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'wp_kses_post',
            'auth_callback'     => 'combes_core_inquiry_meta_auth',
            'show_in_rest'      => true,
        )
    );

    register_post_meta(
        $post_type,
        'combes_inquiry_documents',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'wp_kses_post',
            'auth_callback'     => 'combes_core_inquiry_meta_auth',
            'show_in_rest'      => true,
        )
    );
}
add_action( 'init', 'combes_core_register_inquiry_meta' );
