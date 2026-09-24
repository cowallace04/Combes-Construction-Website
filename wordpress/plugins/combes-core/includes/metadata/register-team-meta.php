<?php
/**
 * Register structured metadata for Team Members.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function combes_core_team_meta_auth( $allowed, $meta_key, $post_id, $user_id, $cap, $caps ) {
    return current_user_can( 'edit_post', $post_id );
}

function combes_core_register_team_meta() {

    $post_type = 'combes_team_member';

    // Position / title (e.g., President, Project Manager & Estimator).
    register_post_meta(
        $post_type,
        'combes_team_position',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => 'combes_core_team_meta_auth',
            'show_in_rest'      => true,
        )
    );

    // Public email.
    register_post_meta(
        $post_type,
        'combes_team_email',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'sanitize_email',
            'auth_callback'     => 'combes_core_team_meta_auth',
            'show_in_rest'      => true,
        )
    );

    // Years with Combes.
    register_post_meta(
        $post_type,
        'combes_team_years_with_company',
        array(
            'type'              => 'number',
            'single'            => true,
            'sanitize_callback' => 'intval',
            'auth_callback'     => 'combes_core_team_meta_auth',
            'show_in_rest'      => true,
        )
    );

    // Years in industry.
    register_post_meta(
        $post_type,
        'combes_team_years_in_industry',
        array(
            'type'              => 'number',
            'single'            => true,
            'sanitize_callback' => 'intval',
            'auth_callback'     => 'combes_core_team_meta_auth',
            'show_in_rest'      => true,
        )
    );

    // Life outside work (short paragraph).
    register_post_meta(
        $post_type,
        'combes_team_life_outside_work',
        array(
            'type'              => 'string',
            'single'            => true,
            'sanitize_callback' => 'wp_kses_post',
            'auth_callback'     => 'combes_core_team_meta_auth',
            'show_in_rest'      => true,
        )
    );

    // Display order (integer, lower = earlier).
    register_post_meta(
        $post_type,
        'combes_team_display_order',
        array(
            'type'              => 'integer',
            'single'            => true,
            'default'           => 0,
            'sanitize_callback' => 'intval',
            'auth_callback'     => 'combes_core_team_meta_auth',
            'show_in_rest'      => true,
        )
    );
}
add_action( 'init', 'combes_core_register_team_meta' );
