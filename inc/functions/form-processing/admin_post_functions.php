<?php

/**
 * Approve Profile
 * Back End
 * Approves profile of user ID POSTed
 * 
 * Redirects to: admin.php?page=cja_approve_profiles
 */

add_action( 'admin_post_approve-profile', 'approve_profiles_posted');
function approve_profiles_posted() {

    // Approve user profile
    update_user_meta($_POST['approve_user_id'], 'company_description', $_POST['user_description']);
    update_user_meta($_POST['approve_user_id'], 'description_approved', 'approved');
    update_user_meta($_POST['approve_user_id'], 'pending_description', FALSE);

    // Email user
    $cja_user = new CJA_User($_POST['approve_user_id']);
    wp_mail($cja_user->email, stripslashes(get_option('profile_approval_email_subject')), stripslashes(get_option('profile_approval_email_message')));

    // Redirect
    header('Location: ' . get_site_url() . '/wp-admin/admin.php?page=cja_approve_profiles');
    exit;
}

/**
 * Approve Advert
 * Back End
 * Approves advert with ID POSTed
 * 
 * Redirects to: 
 */

add_action( 'admin_post_approve-advert', 'approve_advert_posted');
function approve_advert_posted() {

    // Activate each advert sent (unapproved === 'inactive')
    foreach($_POST['cja_approve_ad'] as $advert) {
        if (get_post_type($advert) == 'job_ad') {
            $approve_ad = new CJA_Advert($advert);
        } else if (get_post_type($advert) == 'course_ad') {
            $approve_ad = new CJA_Course_Advert($advert);
        } else if (get_post_type($advert) == 'classified_ad') {
            $approve_ad = new CJA_Classified_Advert($advert);
        }
        $approve_ad->activate();
        $approve_ad->save();
    }

    // Redirect
    header('Location: ' . get_site_url() . '/wp-admin/admin.php?page=cja_approve_ads');
    exit;
}

/**
 * Approve attachment
 * Back End
 * Approves file with name POSTed for user POSTed or replaces it with uploaded file
 * 
 * Redirects to: admin.php?page=cja_approve_attachments
 */

add_action( 'admin_post_approve-attachment', 'approve_attachment_posted');
function approve_attachment_posted() {
        
    // Create user object
    $cja_user = new CJA_User($_POST['approve_user_id']);

    // If there is no replacement file then approve file
    if ($_FILES['cja_replace_file']['size'][0] == 0 ) { 
        
        // Find file in pending files array and move to approved files array
        foreach ($cja_user->pending_files_array as $pending_file => $value) {
            if ($value['name'] == $_POST['approve_attachment_name']) {

                $approved_file = array(
                    'name' => $value['name'],
                    'url' => $value['url']
                );
                $cja_user->files_array[] = $approved_file;
                unset($cja_user->pending_files_array[$pending_file]);
            }
        }

        // If the pending files array is now empty then mark user as files approved
        if (empty($cja_user->pending_files_array)) {
            $cja_user->files_approved = 'approved';
        }

        // Save details and email user
        $cja_user->save();
        wp_mail($cja_user->email, stripslashes(get_option('attachment_approval_email_subject')), stripslashes(get_option('attachment_approval_email_message')));
    
    // Otherwise if there is a replacement file then replace it
    } else {

        // WP Upload
        if ( ! function_exists( 'wp_handle_upload' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }
        $files = $_FILES['cja_replace_file'];
        $file = array(
            'name'     => $files['name'][0],
            'type'     => $files['type'][0],
            'tmp_name' => $files['tmp_name'][0],
            'error'    => $files['error'][0],
            'size'     => $files['size'][0]
        );
        $upload_overrides = array(
            'test_form' => false
        );
        $movefile = wp_handle_upload($file, $upload_overrides);
        $new_file_data = array(
            'name' => $files['name'][0],
            'url' => $movefile['url']
        );

        // Add uploaded file to user's files
        $cja_user = new CJA_User($_POST['approve_user_id']);
        $cja_user->files_array[] = $new_file_data;

        // Remove file from pending files array
        foreach ($cja_user->pending_files_array as $pending_file => $value) {
            if ($value['name'] == $_POST['approve_attachment_name']) {
                unset($cja_user->pending_files_array[$pending_file]);
            }
        }

        // If pending files is empty mark user as files approved
        if (empty($cja_user->pending_files_array)) {
            $cja_user->files_approved = 'approved';
        }

        // Save and email user
        $cja_user->save();
        wp_mail($cja_user->email, stripslashes(get_option('attachment_approval_email_subject')), stripslashes(get_option('attachment_edited_approval_email_message')));
    }

    // Redirect
    header('Location: ' . get_site_url() . '/wp-admin/admin.php?page=cja_approve_attachments');
    exit;
}