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

        // Project Inquiries.
    add_meta_box(
        'combes_inquiry_details',
        __( 'Project Inquiry Details', 'combes-core' ),
        'combes_core_render_inquiry_meta_box',
        'combes_project_inquiry',
        'normal',
        'high'
    );

}
add_action( 'add_meta_boxes', 'combes_core_add_meta_boxes' );

/**
 * Bid / Inquiry meta box UI.
 */
function combes_core_render_bid_meta_box( $post ) {

    wp_nonce_field( 'combes_bid_meta_nonce', 'combes_bid_meta_nonce' );

    $company      = get_post_meta( $post->ID, 'combes_inquiry_company', true );
    $contact_name = get_post_meta( $post->ID, 'combes_inquiry_contact_name', true );
    $email        = get_post_meta( $post->ID, 'combes_inquiry_email', true );
    $phone        = get_post_meta( $post->ID, 'combes_inquiry_phone', true );
    $project_type = get_post_meta( $post->ID, 'combes_inquiry_project_type', true );
    $location     = get_post_meta( $post->ID, 'combes_inquiry_location', true );
    $budget_range = get_post_meta( $post->ID, 'combes_inquiry_budget_range', true );
    $start_date   = get_post_meta( $post->ID, 'combes_inquiry_start_date', true );
    $services     = get_post_meta( $post->ID, 'combes_inquiry_services', true );
    $description  = get_post_meta( $post->ID, 'combes_inquiry_description', true );
    $documents    = get_post_meta( $post->ID, 'combes_inquiry_documents', true );
    ?>

    <p>
        <label for="combes_inquiry_company"><strong>Company / Organization</strong></label><br>
        <input type="text" id="combes_inquiry_company" name="combes_inquiry_company"
               value="<?php echo esc_attr( $company ); ?>" class="widefat">
    </p>

    <p>
        <label for="combes_inquiry_contact_name"><strong>Primary Contact</strong></label><br>
        <input type="text" id="combes_inquiry_contact_name" name="combes_inquiry_contact_name"
               value="<?php echo esc_attr( $contact_name ); ?>" class="widefat">
    </p>

    <p>
        <label for="combes_inquiry_email"><strong>Contact Email</strong></label><br>
        <input type="email" id="combes_inquiry_email" name="combes_inquiry_email"
               value="<?php echo esc_attr( $email ); ?>" class="widefat">
    </p>

    <p>
        <label for="combes_inquiry_phone"><strong>Contact Phone</strong></label><br>
        <input type="text" id="combes_inquiry_phone" name="combes_inquiry_phone"
               value="<?php echo esc_attr( $phone ); ?>" class="widefat">
    </p>

    <p>
        <label for="combes_inquiry_project_type"><strong>Project Type</strong></label><br>
        <input type="text" id="combes_inquiry_project_type" name="combes_inquiry_project_type"
               value="<?php echo esc_attr( $project_type ); ?>" class="widefat"
               placeholder="Commercial, Education, Municipal, Industrial, etc.">
    </p>

    <p>
        <label for="combes_inquiry_location"><strong>Project Location</strong></label><br>
        <input type="text" id="combes_inquiry_location" name="combes_inquiry_location"
               value="<?php echo esc_attr( $location ); ?>" class="widefat">
    </p>

    <p>
        <label for="combes_inquiry_budget_range"><strong>Estimated Budget Range</strong></label><br>
        <input type="text" id="combes_inquiry_budget_range" name="combes_inquiry_budget_range"
               value="<?php echo esc_attr( $budget_range ); ?>" class="widefat"
               placeholder="$5M–$10M, etc.">
    </p>

    <p>
        <label for="combes_inquiry_start_date"><strong>Estimated Start Date</strong></label><br>
        <input type="text" id="combes_inquiry_start_date" name="combes_inquiry_start_date"
               value="<?php echo esc_attr( $start_date ); ?>" class="widefat"
               placeholder="Month / Year or specific date">
    </p>

    <p>
        <label for="combes_inquiry_services"><strong>Desired Services</strong></label><br>
        <textarea id="combes_inquiry_services" name="combes_inquiry_services" rows="3" class="widefat"
                  placeholder="General contracting, design-build, CM-at-risk, preconstruction only, etc."><?php
            echo esc_textarea( $services );
        ?></textarea>
    </p>

    <p>
        <label for="combes_inquiry_description"><strong>Project Description</strong></label><br>
        <textarea id="combes_inquiry_description" name="combes_inquiry_description" rows="5" class="widefat"><?php
            echo esc_textarea( $description );
        ?></textarea>
    </p>

    <p>
        <label for="combes_inquiry_documents"><strong>Supporting Documents</strong></label><br>
        <textarea id="combes_inquiry_documents" name="combes_inquiry_documents" rows="3" class="widefat"
                  placeholder="List of uploaded files, links, or internal references"><?php
            echo esc_textarea( $documents );
        ?></textarea>
    </p>

    <?php
}

/**
 * Save Bid / Inquiry meta.
 */
function combes_core_save_bid_meta_box( $post_id ) {

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
        'combes_inquiry_company'       => 'sanitize_text_field',
        'combes_inquiry_contact_name'  => 'sanitize_text_field',
        'combes_inquiry_email'         => 'sanitize_email',
        'combes_inquiry_phone'         => 'sanitize_text_field',
        'combes_inquiry_project_type'  => 'sanitize_text_field',
        'combes_inquiry_location'      => 'sanitize_text_field',
        'combes_inquiry_budget_range'  => 'sanitize_text_field',
        'combes_inquiry_start_date'    => 'sanitize_text_field',
        'combes_inquiry_services'      => 'wp_kses_post',
        'combes_inquiry_description'   => 'wp_kses_post',
        'combes_inquiry_documents'     => 'wp_kses_post',
    );

    foreach ( $fields as $key => $sanitize ) {
        if ( isset( $_POST[ $key ] ) ) {
            $value = call_user_func( $sanitize, wp_unslash( $_POST[ $key ] ) );
            update_post_meta( $post_id, $key, $value );
        }
    }
}
add_action( 'save_post_combes_bid_opportunity', 'combes_core_save_bid_meta_box' );

/**
 * Project Inquiry meta box UI.
 */
function combes_core_render_inquiry_meta_box( $post ) {

    wp_nonce_field( 'combes_inquiry_meta_nonce', 'combes_inquiry_meta_nonce' );

    $contact_name = get_post_meta( $post->ID, 'combes_inquiry_contact_name', true );
    $company      = get_post_meta( $post->ID, 'combes_inquiry_company', true );
    $email        = get_post_meta( $post->ID, 'combes_inquiry_email', true );
    $phone        = get_post_meta( $post->ID, 'combes_inquiry_phone', true );
    $project_name = get_post_meta( $post->ID, 'combes_inquiry_project_name', true );
    $project_type = get_post_meta( $post->ID, 'combes_inquiry_project_type', true );
    $location     = get_post_meta( $post->ID, 'combes_inquiry_location', true );
    $services     = get_post_meta( $post->ID, 'combes_inquiry_services', true );
    $budget_range = get_post_meta( $post->ID, 'combes_inquiry_budget_range', true );
    $timeline     = get_post_meta( $post->ID, 'combes_inquiry_timeline', true );
    $start_date   = get_post_meta( $post->ID, 'combes_inquiry_start_date', true );
    $description  = get_post_meta( $post->ID, 'combes_inquiry_description', true );
    $documents    = get_post_meta( $post->ID, 'combes_inquiry_documents', true );
    ?>

    <p>
        <label for="combes_inquiry_contact_name"><strong>Contact name</strong></label><br>
        <input type="text" id="combes_inquiry_contact_name" name="combes_inquiry_contact_name"
               value="<?php echo esc_attr( $contact_name ); ?>" class="widefat">
    </p>

    <p>
        <label for="combes_inquiry_company"><strong>Company / organization</strong></label><br>
        <input type="text" id="combes_inquiry_company" name="combes_inquiry_company"
               value="<?php echo esc_attr( $company ); ?>" class="widefat">
    </p>

    <p>
        <label for="combes_inquiry_email"><strong>Email</strong></label><br>
        <input type="email" id="combes_inquiry_email" name="combes_inquiry_email"
               value="<?php echo esc_attr( $email ); ?>" class="widefat">
    </p>

    <p>
        <label for="combes_inquiry_phone"><strong>Phone</strong></label><br>
        <input type="text" id="combes_inquiry_phone" name="combes_inquiry_phone"
               value="<?php echo esc_attr( $phone ); ?>" class="widefat">
    </p>

    <p>
        <label for="combes_inquiry_project_name"><strong>Project name</strong></label><br>
        <input type="text" id="combes_inquiry_project_name" name="combes_inquiry_project_name"
               value="<?php echo esc_attr( $project_name ); ?>" class="widefat">
    </p>

    <p>
        <label for="combes_inquiry_project_type"><strong>Project type</strong></label><br>
        <input type="text" id="combes_inquiry_project_type" name="combes_inquiry_project_type"
               value="<?php echo esc_attr( $project_type ); ?>" class="widefat">
    </p>

    <p>
        <label for="combes_inquiry_location"><strong>Location</strong></label><br>
        <input type="text" id="combes_inquiry_location" name="combes_inquiry_location"
               value="<?php echo esc_attr( $location ); ?>" class="widefat">
    </p>

    <p>
        <label for="combes_inquiry_services"><strong>Services requested</strong></label><br>
        <textarea id="combes_inquiry_services" name="combes_inquiry_services" rows="3" class="widefat"><?php
            echo esc_textarea( $services );
        ?></textarea>
    </p>

    <p>
        <label for="combes_inquiry_budget_range"><strong>Budget range</strong></label><br>
        <input type="text" id="combes_inquiry_budget_range" name="combes_inquiry_budget_range"
               value="<?php echo esc_attr( $budget_range ); ?>" class="widefat">
    </p>

    <p>
        <label for="combes_inquiry_timeline"><strong>Timeline</strong></label><br>
        <input type="text" id="combes_inquiry_timeline" name="combes_inquiry_timeline"
               value="<?php echo esc_attr( $timeline ); ?>" class="widefat">
    </p>

    <p>
        <label for="combes_inquiry_start_date"><strong>Preferred start date</strong></label><br>
        <input type="text" id="combes_inquiry_start_date" name="combes_inquiry_start_date"
               value="<?php echo esc_attr( $start_date ); ?>" class="widefat">
    </p>

    <p>
        <label for="combes_inquiry_description"><strong>Project description</strong></label><br>
        <textarea id="combes_inquiry_description" name="combes_inquiry_description" rows="5" class="widefat"><?php
            echo esc_textarea( $description );
        ?></textarea>
    </p>

    <p>
        <label for="combes_inquiry_documents"><strong>Documents</strong></label><br>
        <textarea id="combes_inquiry_documents" name="combes_inquiry_documents" rows="3" class="widefat"
                  placeholder="List of attached files or references"><?php
            echo esc_textarea( $documents );
        ?></textarea>
    </p>

    <?php
}

/**
 * Save Project Inquiry meta.
 */
function combes_core_save_inquiry_meta_box( $post_id ) {

    if ( ! isset( $_POST['combes_inquiry_meta_nonce'] ) ||
         ! wp_verify_nonce( $_POST['combes_inquiry_meta_nonce'], 'combes_inquiry_meta_nonce' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $fields = array(
        'combes_inquiry_contact_name' => 'sanitize_text_field',
        'combes_inquiry_company'      => 'sanitize_text_field',
        'combes_inquiry_email'        => 'sanitize_email',
        'combes_inquiry_phone'        => 'sanitize_text_field',
        'combes_inquiry_project_name' => 'sanitize_text_field',
        'combes_inquiry_project_type' => 'sanitize_text_field',
        'combes_inquiry_location'     => 'sanitize_text_field',
        'combes_inquiry_budget_range' => 'sanitize_text_field',
        'combes_inquiry_timeline'     => 'sanitize_text_field',
        'combes_inquiry_start_date'   => 'sanitize_text_field',
        'combes_inquiry_services'     => 'wp_kses_post',
        'combes_inquiry_description'  => 'wp_kses_post',
        'combes_inquiry_documents'    => 'wp_kses_post',
    );

    foreach ( $fields as $key => $sanitize ) {
        if ( isset( $_POST[ $key ] ) ) {
            $value = call_user_func( $sanitize, wp_unslash( $_POST[ $key ] ) );
            update_post_meta( $post_id, $key, $value );
        }
    }
}
add_action( 'save_post_combes_project_inquiry', 'combes_core_save_inquiry_meta_box' );



/**
 * Project meta box UI.
 */
function combes_core_render_project_meta_box( $post ) {

    wp_nonce_field( 'combes_project_meta_nonce', 'combes_project_meta_nonce' );

    $location        = get_post_meta( $post->ID, 'combes_project_location', true );
    $address         = get_post_meta( $post->ID, 'combes_project_address', true );
    $owner           = get_post_meta( $post->ID, 'combes_project_owner', true );
    $architect       = get_post_meta( $post->ID, 'combes_project_architect', true );
    $completion_date = get_post_meta( $post->ID, 'combes_project_completion_date', true );
    $featured        = get_post_meta( $post->ID, 'combes_project_featured', true );
    $order           = get_post_meta( $post->ID, 'combes_project_display_order', true );
    ?>

    <p>
        <label for="combes_project_location"><strong>Location</strong> (city, state)</label><br>
        <input type="text" id="combes_project_location" name="combes_project_location"
               value="<?php echo esc_attr( $location ); ?>" class="widefat">
    </p>

    <p>
        <label for="combes_project_address"><strong>Address</strong></label><br>
        <input type="text" id="combes_project_address" name="combes_project_address"
               value="<?php echo esc_attr( $address ); ?>" class="widefat"
               placeholder="Street address, city, state, ZIP">
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
        <label for="combes_project_completion_date"><strong>Completion date</strong></label><br>
        <input type="date" id="combes_project_completion_date" name="combes_project_completion_date"
               value="<?php echo esc_attr( $completion_date ); ?>">
    </p>

    <p>
        <label for="combes_project_featured">
            <input type="checkbox" id="combes_project_featured" name="combes_project_featured"
                   value="1" <?php checked( (bool) $featured, true ); ?>>
            <strong>Featured project</strong>
        </label>
    </p>

    <p>
        <label for="combes_project_display_order"><strong>Display order</strong> (0 = default; lower shows earlier)</label><br>
        <input type="number" id="combes_project_display_order" name="combes_project_display_order"
               value="<?php echo esc_attr( $order ); ?>" class="small-text" min="0" step="1">
    </p>

    <?php
}

/**
 * Save Project meta.
 */
function combes_core_save_project_meta_box( $post_id ) {

    // Correct nonce / autosave / capability checks.
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

    // Text fields.
    $fields = array(
        'combes_project_location',
        'combes_project_address',
        'combes_project_owner',
        'combes_project_architect',
        'combes_project_completion_date',
    );

    foreach ( $fields as $key ) {
        if ( isset( $_POST[ $key ] ) ) {
            update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) );
        }
    }

    // Display order: clamp to >= 0.
    if ( isset( $_POST['combes_project_display_order'] ) ) {
        $order = intval( $_POST['combes_project_display_order'] );
        if ( $order < 0 ) {
            $order = 0;
        }
        update_post_meta( $post_id, 'combes_project_display_order', $order );
    }

    // Featured checkbox: present = 1, absent = 0.
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
