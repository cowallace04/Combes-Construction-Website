<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function combes_core_register_team_meta() {
    // TODO: register team member meta (position, email, years, etc.).
}
add_action( 'init', 'combes_core_register_team_meta' );
