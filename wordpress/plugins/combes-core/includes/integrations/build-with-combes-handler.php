<?php
/**
 * Handle Build With Combes wizard submissions.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Email recipients for new inquiries.
 * Default: WordPress admin email.
 */
function combes_core_inquiry_notification_recipients() {
    $admin = get_option( 'admin_email' );
    return apply_filters( 'combes_core_inquiry_notification_recipients', array( $admin ) );
}

function combes_core_handle_build_with_combes_submit() {

    // Validate nonce; if invalid, redirect back with error instead of throwing a fatal page.
    if ( ! isset( $_POST['combes_build_nonce'] ) ||
         ! wp_verify_nonce( $_POST['combes_build_nonce'], 'combes_build_with_combes' ) ) {

        $redirect = isset( $_POST['_wp_http_referer'] ) ? wp_unslash( $_POST['_wp_http_referer'] ) : home_url( '/build-with-combes/' );
        $redirect = add_query_arg( 'build_error', 'invalid_nonce', $redirect );
        wp_safe_redirect( $redirect );
        exit;
    }

    // Basic sanitization
    $name          = isset( $_POST['bw_name'] ) ? sanitize_text_field( wp_unslash( $_POST['bw_name'] ) ) : '';
    $company       = isset( $_POST['bw_company'] ) ? sanitize_text_field( wp_unslash( $_POST['bw_company'] ) ) : '';
    $email         = isset( $_POST['bw_email'] ) ? sanitize_email( wp_unslash( $_POST['bw_email'] ) ) : '';
    $phone         = isset( $_POST['bw_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['bw_phone'] ) ) : '';

    $project_name  = isset( $_POST['bw_project_name'] ) ? sanitize_text_field( wp_unslash( $_POST['bw_project_name'] ) ) : '';
    $project_type  = isset( $_POST['bw_project_type'] ) ? sanitize_text_field( wp_unslash( $_POST['bw_project_type'] ) ) : '';
    $location      = isset( $_POST['bw_location'] ) ? sanitize_text_field( wp_unslash( $_POST['bw_location'] ) ) : '';
    $services      = isset( $_POST['bw_services'] ) ? sanitize_text_field( wp_unslash( $_POST['bw_services'] ) ) : '';

    $budget_range  = isset( $_POST['bw_budget_range'] ) ? sanitize_text_field( wp_unslash( $_POST['bw_budget_range'] ) ) : '';
    $timeline      = isset( $_POST['bw_timeline'] ) ? sanitize_text_field( wp_unslash( $_POST['bw_timeline'] ) ) : '';
    $start_date    = isset( $_POST['bw_start_date'] ) ? sanitize_text_field( wp_unslash( $_POST['bw_start_date'] ) ) : '';

    $description   = isset( $_POST['bw_description'] ) ? wp_kses_post( wp_unslash( $_POST['bw_description'] ) ) : '';

    // Handle file uploads -> attachments; collect URLs
    $document_list = array();
    if ( ! empty( $_FILES['bw_documents']['name'][0] ) ) {
        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        $files = $_FILES['bw_documents'];

        foreach ( $files['name'] as $index => $filename ) {
            if ( empty( $filename ) ) {
                continue;
            }

            $file_array = array(
                'name'     => $files['name'][ $index ],
                'type'     => $files['type'][ $index ],
                'tmp_name' => $files['tmp_name'][ $index ],
                'error'    => $files['error'][ $index ],
                'size'     => $files['size'][ $index ],
            );

            $_FILES['bw_documents_single'] = $file_array;

            $attachment_id = media_handle_upload( 'bw_documents_single', 0 );
            if ( ! is_wp_error( $attachment_id ) ) {
                $url = wp_get_attachment_url( $attachment_id );
                if ( $url ) {
                    $document_list[] = $url;
                }
            }
        }

        unset( $_FILES['bw_documents_single'] );
    }

    $documents_string = '';
    if ( $document_list ) {
        $documents_string = implode( "\n", array_map( 'esc_url_raw', $document_list ) );
    }

    // Build internal post title
    $title_bits = array();
    if ( $project_name ) {
        $title_bits[] = $project_name;
    }
    if ( $company ) {
        $title_bits[] = $company;
    }
    if ( $name ) {
        $title_bits[] = $name;
    }
    if ( ! $title_bits ) {
        $title_bits[] = 'Project Inquiry';
    }
    $post_title = implode( ' – ', $title_bits );

    // Compose content summary
    $body  = '';
    $body .= "Contact: {$name}\n";
    if ( $company ) {
        $body .= "Company: {$company}\n";
    }
    if ( $email ) {
        $body .= "Email: {$email}\n";
    }
    if ( $phone ) {
        $body .= "Phone: {$phone}\n";
    }
    $body .= "\nProject:\n";
    if ( $project_name ) {
        $body .= "  Name: {$project_name}\n";
    }
    if ( $project_type ) {
        $body .= "  Type: {$project_type}\n";
    }
    if ( $location ) {
        $body .= "  Location: {$location}\n";
    }
    if ( $services ) {
        $body .= "  Services requested: {$services}\n";
    }
    if ( $budget_range ) {
        $body .= "  Budget range: {$budget_range}\n";
    }
    if ( $timeline ) {
        $body .= "  Timeline: {$timeline}\n";
    }
    if ( $start_date ) {
        $body .= "  Preferred start date: {$start_date}\n";
    }

    if ( $description ) {
        $body .= "\nDescription:\n{$description}\n";
    }

    if ( $documents_string ) {
        $body .= "\nDocuments:\n{$documents_string}\n";
    }

    $post_id = wp_insert_post(
        array(
            'post_type'   => 'combes_project_inquiry',
            'post_title'  => $post_title,
            'post_content'=> $body,
            'post_status' => 'private', // internal only
        ),
        true
    );

    if ( is_wp_error( $post_id ) ) {
        $redirect = isset( $_POST['_wp_http_referer'] ) ? wp_unslash( $_POST['_wp_http_referer'] ) : home_url( '/build-with-combes/' );
        $redirect = add_query_arg( 'build_error', 'save_failed', $redirect );
        wp_safe_redirect( $redirect );
        exit;
    }

    // Save structured meta
    update_post_meta( $post_id, 'combes_inquiry_contact_name',   $name );
    update_post_meta( $post_id, 'combes_inquiry_company',        $company );
    update_post_meta( $post_id, 'combes_inquiry_email',          $email );
    update_post_meta( $post_id, 'combes_inquiry_phone',          $phone );
    update_post_meta( $post_id, 'combes_inquiry_project_name',   $project_name );
    update_post_meta( $post_id, 'combes_inquiry_project_type',   $project_type );
    update_post_meta( $post_id, 'combes_inquiry_location',       $location );
    update_post_meta( $post_id, 'combes_inquiry_services',       $services );
    update_post_meta( $post_id, 'combes_inquiry_budget_range',   $budget_range );
    update_post_meta( $post_id, 'combes_inquiry_timeline',       $timeline );
    update_post_meta( $post_id, 'combes_inquiry_start_date',     $start_date );
    update_post_meta( $post_id, 'combes_inquiry_description',    $description );
    update_post_meta( $post_id, 'combes_inquiry_documents',      $documents_string );

    // Notification email
    $recipients = combes_core_inquiry_notification_recipients();
    $subject    = '[Combes] New Project Inquiry';
    $message    = $body;

    foreach ( $recipients as $to ) {
        $to = sanitize_email( $to );
        if ( $to ) {
            wp_mail( $to, $subject, $message );
        }
    }

    // Redirect back to Build With Combes with success flag
    $redirect = isset( $_POST['_wp_http_referer'] ) ? wp_unslash( $_POST['_wp_http_referer'] ) : home_url( '/build-with-combes/' );
    $redirect = add_query_arg( 'build_submitted', '1', $redirect );
    wp_safe_redirect( $redirect );
    exit;
}

add_action( 'admin_post_nopriv_combes_build_with_combes_submit', 'combes_core_handle_build_with_combes_submit' );
add_action( 'admin_post_combes_build_with_combes_submit', 'combes_core_handle_build_with_combes_submit' );
