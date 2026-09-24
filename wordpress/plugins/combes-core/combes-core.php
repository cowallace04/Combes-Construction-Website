<?php
/**
 * Plugin Name:       Combes Core
 * Description:       Core business data structures for the Combes Construction website (projects, team, jobs, bidding).
 * Version:           0.1.0
 * Author:            Colton Wallace
 * Text Domain:       combes-core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'COMBES_CORE_VERSION', '0.1.0' );
define( 'COMBES_CORE_PATH', plugin_dir_path( __FILE__ ) );
define( 'COMBES_CORE_URL', plugin_dir_url( __FILE__ ) );

/**
 * Load includes.
 */
function combes_core_load_includes() {
    // Post types.
    require_once COMBES_CORE_PATH . 'includes/post-types/register-project.php';
    require_once COMBES_CORE_PATH . 'includes/post-types/register-team-member.php';
    require_once COMBES_CORE_PATH . 'includes/post-types/register-job-opening.php';
    require_once COMBES_CORE_PATH . 'includes/post-types/register-bidding-opportunity.php';

    // Taxonomies.
    require_once COMBES_CORE_PATH . 'includes/taxonomies/register-project-taxonomies.php';

    // Metadata.
    require_once COMBES_CORE_PATH . 'includes/metadata/register-project-meta.php';
    require_once COMBES_CORE_PATH . 'includes/metadata/register-team-meta.php';
    require_once COMBES_CORE_PATH . 'includes/metadata/register-job-meta.php';
    require_once COMBES_CORE_PATH . 'includes/metadata/register-bid-meta.php';

    // Admin meta boxes: only load in the real admin UI.
    if ( is_admin() ) {
        require_once COMBES_CORE_PATH . 'includes/admin/register-meta-boxes.php';
    }
}
add_action( 'plugins_loaded', 'combes_core_load_includes' );
