<?php
/**
 * Admin meta boxes for Projects, Team Members, Jobs, and Bids.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register meta boxes.
 */
function combes_core_add_meta_boxes() {

    // Projects.
    add_meta_box(
        'combes_project_details',
        __( 'Project Details', 'combes-core' ),
        'combes_core_render_project_meta_box',
        'combes_project',
        'normal',
        'high'
    );

    // Team Members.
    add_meta_box(
        'combes_team_details',
        __( 'Team Member Details', 'combes-core' ),
        'combes_core_render_team_meta_box',
        'combes_team_member',
        'normal',
        'high'
    );

    // Job Openings.
    add_meta_box(
        'combes_job_details',
        __( 'Job Details', 'combes-core' ),
        'combes_core_render_job_meta_box',
        'combes_job_opening',
        'normal',
        'high'
    );

    // Bidding Opportunities.
    add_meta_box(
        'combes_bid_details',
        __( 'Bidding Details', 'combes-core' ),
        'combes_core_render_bid_meta_box',
        'combes_bid_opportunity',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'combes_core_add_meta_boxes' );

/**
 * Project meta box UI.
 */
function combes_core_render_project_meta_box( $post ) {

    wp_nonce_field( 'combes_project_meta_nonce', 'combes_project_meta_nonce' );

    $location  = get_post_meta( $post->ID, 'combes_project_location', true );
    $owner     = get_post_meta( $post->ID, 'combes_project_owner', true );
    $architect = get_post_meta( $post->ID, 'combes_project_architect', true );
    $timeline  = get_post_meta( $post->ID, 'combes_project_timeline', true );
    $featured  = get_post_meta( $post->ID, 'combes_project_featured', true );
    $order     = get_post_meta( $post->ID, 'combes_project_display_order', true );
    ?>

    <p>
        <label for="combes_project_location"><strong>Location</strong> (city, state)</label><br>
        <input type="text" id="combes_project_location" name="combes_project_location"
               value="<?php echo esc_attr( $location ); ?>" class="widefat">
    </p>

    <p>
        <label for="combes_project_owner"><strong>Owner</strong></label><br>
        <input type="text" id="combes_project_owner" name="combes_project_owner"
               value="<?php echo esc_attr( $owner ); ?>" class="widefat">
    </p>

    <p>
        <label for="combes_project_architect"><strong>Architect</strong></label><br>
        <input type="text" id="combes_project_architect" name="combes_project_architect"
               value="<?php echo esc_attr( $architect ); ?>" class="widefat">
    </p>

    <p>
        <label for="combes_project_timeline"><strong>Timeline</strong></label><br>
        <input type="text" id="combes_project_timeline" name="combes_project_timeline"
               value="<?php echo esc_attr( $timeline ); ?>" class="widefat">
    </p>

    <p>
        <label for="combes_project_featured">
            <input type="checkbox" id="combes_project_featured" name="combes_project_featured"
                   value="1" <?php checked( $featured, true ); ?>>
            <strong>Featured project</strong>
        </label>
    </p>

    <p>
        <label for="combes_project_display_order"><strong>Display order</strong> (lower shows earlier)</label><br>
        <input type="number" id="combes_project_display_order" name="combes_project_display_order"
               value="<?php echo esc_attr( $order ); ?>" class="small-text">
    </p>

    <?php
}

/**
 * Save Project meta.
 */
function combes_core_save_project_meta_box( $post_id ) {

    if ( ! isset( $_POST['combes_project_meta_nonce'] ) ||
         ! wp_verify_nonce( $_POST['combes_project_meta_nonce'], 'combes_project_meta_nonce' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $fields = array(
        'combes_project_location'      => 'sanitize_text_field',
        'combes_project_owner'         => 'sanitize_text_field',
        'combes_project_architect'     => 'sanitize_text_field',
        'combes_project_timeline'      => 'sanitize_text_field',
        'combes_project_display_order' => 'intval',
    );

    foreach ( $fields as $key => $sanitize ) {
        if ( isset( $_POST[ $key ] ) ) {
            update_post_meta( $post_id, $key, call_user_func( $sanitize, $_POST[ $key ] ) );
        }
    }

    $featured = isset( $_POST['combes_project_featured'] ) ? 1 : 0;
    update_post_meta( $post_id, 'combes_project_featured', $featured );
}
add_action( 'save_post_combes_project', 'combes_core_save_project_meta_box' );

/**
 * Team Member meta box UI.
 */
function combes_core_render_team_meta_box( $post ) {

    wp_nonce_field( 'combes_team_meta_nonce', 'combes_team_meta_nonce' );

    $position          = get_post_meta( $post->ID, 'combes_team_position', true );
    $email             = get_post_meta( $post->ID, 'combes_team_email', true );
    $years_with        = get_post_meta( $post->ID, 'combes_team_years_with_company', true );
    $years_industry    = get_post_meta( $post->ID, 'combes_team_years_in_industry', true );
    $life_outside      = get_post_meta( $post->ID, 'combes_team_life_outside_work', true );
    $order             = get_post_meta( $post->ID, 'combes_team_display_order', true );
    ?>

    <p>
        <label for="combes_team_position"><strong>Position</strong></label><br>
        <input type="text" id="combes_team_position" name="combes_team_position"
               value="<?php echo esc_attr( $position ); ?>" class="widefat">
    </p>

    <p>
        <label for="combes_team_email"><strong>Employee email</strong></label><br>
        <input type="email" id="combes_team_email" name="combes_team_email"
               value="<?php echo esc_attr( $email ); ?>" class="widefat">
    </p>

    <p>
        <label for="combes_team_years_with_company"><strong>Years with Combes</strong></label><br>
        <input type="number" id="combes_team_years_with_company" name="combes_team_years_with_company"
               value="<?php echo esc_attr( $years_with ); ?>" class="small-text" min="0">
    </p>

    <p>
        <label for="combes_team_years_in_industry"><strong>Years in construction</strong></label><br>
        <input type="number" id="combes_team_years_in_industry" name="combes_team_years_in_industry"
               value="<?php echo esc_attr( $years_industry ); ?>" class="small-text" min="0">
    </p>

    <p>
        <label for="combes_team_life_outside_work"><strong>Life outside work</strong></label><br>
        <textarea id="combes_team_life_outside_work" name="combes_team_life_outside_work"
                  rows="4" class="widefat"><?php echo esc_textarea( $life_outside ); ?></textarea>
    </p>

    <p>
        <label for="combes_team_display_order"><strong>Display order</strong> (lower shows earlier)</label><br>
        <input type="number" id="combes_team_display_order" name="combes_team_display_order"
               value="<?php echo esc_attr( $order ); ?>" class="small-text">
    </p>

    <?php
}

/**
 * Save Team meta.
 */
function combes_core_save_team_meta_box( $post_id ) {

    if ( ! isset( $_POST['combes_team_meta_nonce'] ) ||
         ! wp_verify_nonce( $_POST['combes_team_meta_nonce'], 'combes_team_meta_nonce' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $fields = array(
        'combes_team_position'              => 'sanitize_text_field',
        'combes_team_email'                 => 'sanitize_email',
        'combes_team_years_with_company'    => 'intval',
        'combes_team_years_in_industry'     => 'intval',
        'combes_team_life_outside_work'     => 'wp_kses_post',
        'combes_team_display_order'         => 'intval',
    );

    foreach ( $fields as $key => $sanitize ) {
        if ( isset( $_POST[ $key ] ) ) {
            update_post_meta( $post_id, $key, call_user_func( $sanitize, $_POST[ $key ] ) );
        }
    }
}
add_action( 'save_post_combes_team_member', 'combes_core_save_team_meta_box' );

/**
 * Job meta box UI.
 */
function combes_core_render_job_meta_box( $post ) {

    wp_nonce_field( 'combes_job_meta_nonce', 'combes_job_meta_nonce' );

    $department     = get_post_meta( $post->ID, 'combes_job_department', true );
    $location       = get_post_meta( $post->ID, 'combes_job_location', true );
    $employment     = get_post_meta( $post->ID, 'combes_job_employment_type', true );
    $responsibilities = get_post_meta( $post->ID, 'combes_job_responsibilities', true );
    $qualifications = get_post_meta( $post->ID, 'combes_job_qualifications', true );
    $benefits       = get_post_meta( $post->ID, 'combes_job_benefits', true );
    $destination    = get_post_meta( $post->ID, 'combes_job_application_destination', true );
    $opening_date   = get_post_meta( $post->ID, 'combes_job_opening_date', true );
    $closing_date   = get_post_meta( $post->ID, 'combes_job_closing_date', true );
    $active         = get_post_meta( $post->ID, 'combes_job_active', true );
    ?>

    <!-- same UI as we discussed earlier; omitted here for brevity -->

    <?php
}

/* Save Job meta, render Bid meta box, save Bid meta
   ... (you can keep your existing versions here, or reuse my earlier code)
*/
