<?php
/**
 * Register metadata for Job Openings.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function combes_core_job_meta_auth( $allowed, $meta_key, $post_id, $user_id, $cap, $caps ) {
    return current_user_can( 'edit_post', $post_id );
}

function combes_core_register_job_meta() {

    $post_type = 'combes_job_opening';

    // Department (e.g., Field Operations, Preconstruction).
    register_post_meta(
        $post_type,
        'combes_job_department',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => 'combes_core_job_meta_auth',
            'show_in_rest'      => true,
        )
    );

    // Location (city, state or remote).
    register_post_meta(
        $post_type,
        'combes_job_location',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => 'combes_core_job_meta_auth',
            'show_in_rest'      => true,
        )
    );

    // Employment type (Full-time, Part-time, Internship, etc.).
    register_post_meta(
        $post_type,
        'combes_job_employment_type',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => 'combes_core_job_meta_auth',
            'show_in_rest'      => true,
        )
    );

    // Responsibilities (short structured text).
    register_post_meta(
        $post_type,
        'combes_job_responsibilities',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'wp_kses_post',
            'auth_callback'     => 'combes_core_job_meta_auth',
            'show_in_rest'      => true,
        )
    );

    // Qualifications.
    register_post_meta(
        $post_type,
        'combes_job_qualifications',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'wp_kses_post',
            'auth_callback'     => 'combes_core_job_meta_auth',
            'show_in_rest'      => true,
        )
    );

    // Benefits.
    register_post_meta(
        $post_type,
        'combes_job_benefits',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'wp_kses_post',
            'auth_callback'     => 'combes_core_job_meta_auth',
            'show_in_rest'      => true,
        )
    );

    // Application destination (email address, URL, or ATS link).
    register_post_meta(
        $post_type,
        'combes_job_application_destination',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => 'combes_core_job_meta_auth',
            'show_in_rest'      => true,
        )
    );

    // Opening date (YYYY-MM-DD).
    register_post_meta(
        $post_type,
        'combes_job_opening_date',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => 'combes_core_job_meta_auth',
            'show_in_rest'      => true,
        )
    );

    // Closing date (YYYY-MM-DD).
    register_post_meta(
        $post_type,
        'combes_job_closing_date',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => 'combes_core_job_meta_auth',
            'show_in_rest'      => true,
        )
    );

    // Active flag (true/false).
    register_post_meta(
        $post_type,
        'combes_job_active',
        array(
            'type'              => 'boolean',
            'single'            => true,
            'default'           => true,
            'sanitize_callback' => 'rest_sanitize_boolean',
            'auth_callback'     => 'combes_core_job_meta_auth',
            'show_in_rest'      => true,
        )
    );
}
add_action( 'init', 'combes_core_register_job_meta' );
