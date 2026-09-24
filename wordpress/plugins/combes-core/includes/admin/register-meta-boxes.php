<?php
/**
 * Admin meta boxes for Projects and Team Members.
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
        <label for="combes_project_timeline"><strong>Timeline</strong> (e.g., 2021–2023)</label><br>
        <input type="text" id="combes_project_timeline" name="combes_project_timeline"
               value="<?php echo esc_attr( $timeline ); ?>" class="widefat">
    </p>

    <p>
        <label for="combes_project_featured">
            <input type="checkbox" id="combes_project_featured" name="combes_project_featured"
                   value="1" <?php checked( $featured, true ); ?>>
            <strong>Featured project</strong> (show in homepage collage)
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
               value="<?php echo esc_attr( $position ); ?>" class="widefat"
               placeholder="President, Project Manager &amp; Estimator, etc.">
    </p>

    <p>
        <label for="combes_team_email"><strong>Employee email</strong></label><br>
        <input type="email" id="combes_team_email" name="combes_team_email"
               value="<?php echo esc_attr( $email ); ?>" class="widefat"
               placeholder="name@combesconstruction.net">
    </p>

    <p>
        <label for="combes_team_years_with_company"><strong>Years with Combes</strong></label><br>
        <input type="number" id="combes_team_years_with_company" name="combes_team_years_with_company"
               value="<?php echo esc_attr( $years_with ); ?>" class="small-text" min="0" step="1">
    </p>

    <p>
        <label for="combes_team_years_in_industry"><strong>Years in construction</strong></label><br>
        <input type="number" id="combes_team_years_in_industry" name="combes_team_years_in_industry"
               value="<?php echo esc_attr( $years_industry ); ?>" class="small-text" min="0" step="1">
    </p>

    <p>
        <label for="combes_team_life_outside_work"><strong>Life outside work</strong></label><br>
        <textarea id="combes_team_life_outside_work" name="combes_team_life_outside_work"
                  rows="4" class="widefat"
                  placeholder="Family, hobbies, community involvement, etc."><?php
            echo esc_textarea( $life_outside );
        ?></textarea>
    </p>

    <p>
        <label for="combes_team_display_order"><strong>Display order</strong> (lower shows earlier)</label><br>
        <input type="number" id="combes_team_display_order" name="combes_team_display_order"
               value="<?php echo esc_attr( $order ); ?>" class="small-text" min="0" step="1">
    </p>

    <?php
}

/**
 * Save Project meta.
 */
function combes_core_save_project_meta( $post_id ) {

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
        'combes_project_location'       => 'sanitize_text_field',
        'combes_project_owner'          => 'sanitize_text_field',
        'combes_project_architect'      => 'sanitize_text_field',
        'combes_project_timeline'       => 'sanitize_text_field',
        'combes_project_display_order'  => 'intval',
    );

    foreach ( $fields as $key => $sanitize ) {
        if ( isset( $_POST[ $key ] ) ) {
            update_post_meta( $post_id, $key, call_user_func( $sanitize, $_POST[ $key ] ) );
        }
    }

    // Featured checkbox: present = true, absent = false.
    $featured = isset( $_POST['combes_project_featured'] ) ? 1 : 0;
    update_post_meta( $post_id, 'combes_project_featured', $featured );
}
add_action( 'save_post_combes_project', 'combes_core_save_project_meta' );

/**
 * Save Team meta.
 */
function combes_core_save_team_meta( $post_id ) {

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
add_action( 'save_post_combes_team_member', 'combes_core_save_team_meta' );
// In combes_core_add_meta_boxes(), add:

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

    <p>
        <label for="combes_job_department"><strong>Department</strong></label><br>
        <input type="text" id="combes_job_department" name="combes_job_department"
               value="<?php echo esc_attr( $department ); ?>" class="widefat"
               placeholder="Field Operations, Preconstruction, Office, etc.">
    </p>

    <p>
        <label for="combes_job_location"><strong>Location</strong></label><br>
        <input type="text" id="combes_job_location" name="combes_job_location"
               value="<?php echo esc_attr( $location ); ?>" class="widefat"
               placeholder="City, State or Remote">
    </p>

    <p>
        <label for="combes_job_employment_type"><strong>Employment type</strong></label><br>
        <input type="text" id="combes_job_employment_type" name="combes_job_employment_type"
               value="<?php echo esc_attr( $employment ); ?>" class="widefat"
               placeholder="Full-time, Part-time, Internship, etc.">
    </p>

    <p>
        <label for="combes_job_responsibilities"><strong>Responsibilities</strong></label><br>
        <textarea id="combes_job_responsibilities" name="combes_job_responsibilities"
                  rows="4" class="widefat"><?php echo esc_textarea( $responsibilities ); ?></textarea>
    </p>

    <p>
        <label for="combes_job_qualifications"><strong>Qualifications</strong></label><br>
        <textarea id="combes_job_qualifications" name="combes_job_qualifications"
                  rows="4" class="widefat"><?php echo esc_textarea( $qualifications ); ?></textarea>
    </p>

    <p>
        <label for="combes_job_benefits"><strong>Benefits</strong></label><br>
        <textarea id="combes_job_benefits" name="combes_job_benefits"
                  rows="4" class="widefat"><?php echo esc_textarea( $benefits ); ?></textarea>
    </p>

    <p>
        <label for="combes_job_application_destination"><strong>Application destination</strong></label><br>
        <input type="text" id="combes_job_application_destination" name="combes_job_application_destination"
               value="<?php echo esc_attr( $destination ); ?>" class="widefat"
               placeholder="Email address or application URL">
    </p>

    <p>
        <label for="combes_job_opening_date"><strong>Opening date</strong></label><br>
        <input type="date" id="combes_job_opening_date" name="combes_job_opening_date"
               value="<?php echo esc_attr( $opening_date ); ?>">
    </p>

    <p>
        <label for="combes_job_closing_date"><strong>Closing date</strong></label><br>
        <input type="date" id="combes_job_closing_date" name="combes_job_closing_date"
               value="<?php echo esc_attr( $closing_date ); ?>">
    </p>

    <p>
        <label for="combes_job_active">
            <input type="checkbox" id="combes_job_active" name="combes_job_active"
                   value="1" <?php checked( $active, true ); ?>>
            <strong>Job is currently active</strong>
        </label>
    </p>

    <?php
}

/**
 * Save Job meta.
 */
function combes_core_save_job_meta( $post_id ) {

    if ( ! isset( $_POST['combes_job_meta_nonce'] ) ||
         ! wp_verify_nonce( $_POST['combes_job_meta_nonce'], 'combes_job_meta_nonce' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $fields = array(
        'combes_job_department'             => 'sanitize_text_field',
        'combes_job_location'              => 'sanitize_text_field',
        'combes_job_employment_type'       => 'sanitize_text_field',
        'combes_job_responsibilities'      => 'wp_kses_post',
        'combes_job_qualifications'        => 'wp_kses_post',
        'combes_job_benefits'              => 'wp_kses_post',
        'combes_job_application_destination'=> 'sanitize_text_field',
        'combes_job_opening_date'          => 'sanitize_text_field',
        'combes_job_closing_date'          => 'sanitize_text_field',
    );

    foreach ( $fields as $key => $sanitize ) {
        if ( isset( $_POST[ $key ] ) ) {
            update_post_meta( $post_id, $key, call_user_func( $sanitize, $_POST[ $key ] ) );
        }
    }

    $active = isset( $_POST['combes_job_active'] ) ? 1 : 0;
    update_post_meta( $post_id, 'combes_job_active', $active );
}
add_action( 'save_post_combes_job_opening', 'combes_core_save_job_meta' );

/**
 * Bid meta box UI.
 */
function combes_core_render_bid_meta_box( $post ) {

    wp_nonce_field( 'combes_bid_meta_nonce', 'combes_bid_meta_nonce' );

    $location   = get_post_meta( $post->ID, 'combes_bid_location', true );
    $deadline   = get_post_meta( $post->ID, 'combes_bid_deadline', true );
    $contact    = get_post_meta( $post->ID, 'combes_bid_contact', true );
    $scopes     = get_post_meta( $post->ID, 'combes_bid_scope_packages', true );
    $documents  = get_post_meta( $post->ID, 'combes_bid_document_links', true );
    $addenda    = get_post_meta( $post->ID, 'combes_bid_addenda', true );
    $open       = get_post_meta( $post->ID, 'combes_bid_open', true );
    $public     = get_post_meta( $post->ID, 'combes_bid_public', true );
    ?>

    <p>
        <label for="combes_bid_location"><strong>Location</strong></label><br>
        <input type="text" id="combes_bid_location" name="combes_bid_location"
               value="<?php echo esc_attr( $location ); ?>" class="widefat"
               placeholder="City, State">
    </p>

    <p>
        <label for="combes_bid_deadline"><strong>Bid deadline</strong></label><br>
        <input type="text" id="combes_bid_deadline" name="combes_bid_deadline"
               value="<?php echo esc_attr( $deadline ); ?>" class="widefat"
               placeholder="YYYY-MM-DD or date/time">
    </p>

    <p>
        <label for="combes_bid_contact"><strong>Contact</strong></label><br>
        <input type="text" id="combes_bid_contact" name="combes_bid_contact"
               value="<?php echo esc_attr( $contact ); ?>" class="widefat"
               placeholder="Name or role">
    </p>

    <p>
        <label for="combes_bid_scope_packages"><strong>Scope packages</strong></label><br>
        <textarea id="combes_bid_scope_packages" name="combes_bid_scope_packages"
                  rows="4" class="widefat"><?php echo esc_textarea( $scopes ); ?></textarea>
    </p>

    <p>
        <label for="combes_bid_document_links"><strong>Document links</strong></label><br>
        <textarea id="combes_bid_document_links" name="combes_bid_document_links"
                  rows="4" class="widefat"
                  placeholder="Links to plans, specs, etc."><?php echo esc_textarea( $documents ); ?></textarea>
    </p>

    <p>
        <label for="combes_bid_addenda"><strong>Addenda</strong></label><br>
        <textarea id="combes_bid_addenda" name="combes_bid_addenda"
                  rows="3" class="widefat"><?php echo esc_textarea( $addenda ); ?></textarea>
    </p>

    <p>
        <label for="combes_bid_open">
            <input type="checkbox" id="combes_bid_open" name="combes_bid_open"
                   value="1" <?php checked( $open, true ); ?>>
            <strong>Bid is open</strong>
        </label>
    </p>

    <p>
        <label for="combes_bid_public">
            <input type="checkbox" id="combes_bid_public" name="combes_bid_public"
                   value="1" <?php checked( $public, true ); ?>>
            <strong>Bid is public</strong>
        </label>
    </p>

    <?php
}

/**
 * Save Bid meta.
 */
function combes_core_save_bid_meta( $post_id ) {

    if ( ! isset( $_POST['combes_bid_meta_nonce'] ) ||
         ! wp_verify_nonce( $_POST['combes_bid_meta_nonce'], 'combes_bid_meta_nonce' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $fields = array(
        'combes_bid_location'        => 'sanitize_text_field',
        'combes_bid_deadline'        => 'sanitize_text_field',
        'combes_bid_contact'         => 'sanitize_text_field',
        'combes_bid_scope_packages'  => 'wp_kses_post',
        'combes_bid_document_links'  => 'wp_kses_post',
        'combes_bid_addenda'         => 'wp_kses_post',
    );

    foreach ( $fields as $key => $sanitize ) {
        if ( isset( $_POST[ $key ] ) ) {
            update_post_meta( $post_id, $key, call_user_func( $sanitize, $_POST[ $key ] ) );
        }
    }

    $open   = isset( $_POST['combes_bid_open'] ) ? 1 : 0;
    $public = isset( $_POST['combes_bid_public'] ) ? 1 : 0;

    update_post_meta( $post_id, 'combes_bid_open', $open );
    update_post_meta( $post_id, 'combes_bid_public', $public );
}
add_action( 'save_post_combes_bid_opportunity', 'combes_core_save_bid_meta' );
