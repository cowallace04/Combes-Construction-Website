<?php
/**
 * Theme setup and asset loading.
 *
 * @package CombesConstruction
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Load the theme's global stylesheet.
 */
function combes_construction_enqueue_styles(): void
{
    $theme_version = wp_get_theme()->get('Version');

    wp_enqueue_style(
        'combes-construction-theme',
        get_theme_file_uri('/assets/css/theme.css'),
        array(),
        $theme_version
    );
}
add_action('wp_enqueue_scripts', 'combes_construction_enqueue_styles');

/**
 * Load editor styles so the editor resembles the front end.
 */
function combes_construction_setup(): void
{
    add_theme_support('editor-styles');
    add_editor_style('assets/css/theme.css');
}
add_action('after_setup_theme', 'combes_construction_setup');