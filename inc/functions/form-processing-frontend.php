<?php 
/**
 * Function name: Process and Redirect
 * Description: processes forms on init hook and redirects without form data if required. 
 * Prevents users duplicating an action by using the refresh button and allows database to be updated before page load.
 */

add_action('init', 'process_and_redirect');
function process_and_redirect() {

    // Create new job ad
    if ($_POST['process-create-ad']) {
        $cja_new_ad = new CJA_Advert;
        $cja_new_ad->create(); // create a new post in the database
        $cja_new_ad->update_from_form();
        // $cja_new_ad->activate(); // ads are now activated when approved by admin
        $cja_new_ad->save();
        new_ad_email($cja_new_ad->title);
        if (get_option('cja_charge_users')) { spend_credits(); }
        header('Location: ' . get_site_url() . '/my-job-ads?create-ad-success=' . $cja_new_ad->id . '&edit-ad=' . $cja_new_ad->id);
        exit;
    }

    // Create new course ad
    if ($_POST['process-create-course-ad']) {
        $cja_new_ad = new CJA_Course_Advert;
        $cja_new_ad->create(); // create a new post in the database
        $cja_new_ad->update_from_form();
        // $cja_new_ad->activate(); // ads are now activated when approved by admin
        $cja_new_ad->save();
        new_ad_email($cja_new_ad->title);
        if (get_option('cja_charge_users')) { spend_credits(); }
        header('Location: ' . get_site_url() . '/my-course-ads?create-ad-success=' . $cja_new_ad->id . '&edit-ad=' . $cja_new_ad->id);
        exit;
    }

    // Create new classified ad
    if ($_POST['process-create-classified-ad']) {
        $cja_new_ad = new CJA_Classified_Advert;
        $cja_new_ad->create(); // create a new post in the database
        $cja_new_ad->update_from_form();
        // $cja_new_ad->activate(); // ads are now activated when approved by admin
        $cja_new_ad->save();
        new_ad_email($cja_new_ad->title);
        if (get_option('cja_charge_users')) { spend_classified_credits(); }
        header('Location: ' . get_site_url() . '/my-classified-ads?create-ad-success=' . $cja_new_ad->id . '&edit-ad=' . $cja_new_ad->id);
        exit;
    }

    // User updates their details
    if ($_POST['user-details-update']) {
        $cja_current_user_obj = new CJA_User;
        $cja_current_user_obj->updateFromForm();
        $cja_current_user_obj->save();
        header('Location: ' . get_site_url() . '/my-account/my-details?update-user-details=true');
        exit;
    }
    
    // Extend job ad
    if ($_GET['extend-ad']) {
        $cja_extend_ad = new CJA_Advert($_GET['extend-ad']);
        $cja_extend_ad->extend();
        $cja_extend_ad->save();
        if (get_option('cja_charge_users')) { spend_credits(); }
        header('Location: ' . get_site_url() . '/my-job-ads?extend-ad-success=' . $cja_extend_ad->id);
        exit;
    }

    // Extend course ad
    if ($_GET['extend-course-ad']) {
        $cja_extend_ad = new CJA_Course_Advert($_GET['extend-course-ad']);
        $cja_extend_ad->extend();
        $cja_extend_ad->save();
        if (get_option('cja_charge_users')) { spend_credits(); }
        header('Location: ' . get_site_url() . '/my-course-ads?extend-ad-success=' . $cja_extend_ad->id);
        exit;
    }

    // Extend classified ad
    if ($_GET['extend-classified-ad']) {
        $cja_extend_ad = new CJA_Classified_Advert($_GET['extend-classified-ad']);
        $cja_extend_ad->extend();
        $cja_extend_ad->save();
        if (get_option('cja_charge_users')) { spend_classified_credits(); }
        header('Location: ' . get_site_url() . '/my-classified-ads?extend-ad-success=' . $cja_extend_ad->id);
        exit;
    }

    // Update theme options (sent from theme options in admin)
    // Todo: move this to admin post hook and admin processing file
    if ($_POST['cja_action'] == 'update_theme_options') {

        // charge users for ads Y/N
        if ($_POST['cja_charge_users'] == 'true') {
            update_option('cja_charge_users', TRUE);
        } else {
            update_option('cja_charge_users', FALSE);
        }

        // number of days ad is still new
        update_option('cja_days_still_new', $_POST['days_new']);

        // number of user is still new
        update_option('cja_user_days_still_new', $_POST['user_days_new']);

        // Display homepage or holding page
        if ($_POST['display_homepage']) {
            update_option('cja_display_homepage', TRUE);
        } else {
            update_option('cja_display_homepage', FALSE);
        }

        // Display footer menu
        if ($_POST['display_footer_menu']) {
            update_option('cja_display_footer_menu', TRUE);
        } else {
            update_option('cja_display_footer_menu', FALSE);
        }

        update_option('cja_free_ads_message', $_POST['cja_free_ads_message']);
        update_option('profile_approval_email_subject', $_POST['profile_approval_email_subject']);
        update_option('profile_approval_email_message', $_POST['profile_approval_email_message']);
        update_option('attachment_approval_email_subject', $_POST['attachment_approval_email_subject']);
        update_option('attachment_approval_email_message', $_POST['attachment_approval_email_message']);
        update_option('attachment_edited_approval_email_message', $_POST['attachment_edited_approval_email_message']);
        update_option('approval_notification_cc', $_POST['approval_notification_cc']);

        update_option('advert_running_out_message_days', $_POST['advert_running_out_message_days']);
        update_option('advert_running_out_email_subject', $_POST['advert_running_out_email_subject']);
        update_option('advert_running_out_email_message', $_POST['advert_running_out_email_message']);

        update_option('advert_expired_email_subject', $_POST['advert_expired_email_subject']);
        update_option('advert_expired_email_message', $_POST['advert_expired_email_message']);
    }
}