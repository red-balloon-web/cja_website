<?php

// Custom Pages
include('admin-menu/theme-options.php'); // Theme options page
include('admin-menu/manage-credits.php'); // Manage credits page
include('admin-menu/approve-adverts.php'); // Approve adverts page
include('admin-menu/approve-profiles.php'); // Approve profiles page
include('admin-menu/approve-attachments.php'); // Approve attachments page
include('admin-menu/monitoring.php'); // Monitoring page

// Customised Pages
include('admin-menu/edit-custom-post-types.php'); // Edit meta data for custom post types from admin screens
include('admin-menu/edit-user-profile.php'); // Edit user profiles from admin

/**
 * CJA Admin Menu
 * Adds menu pages to admin
 */
add_action( 'admin_menu', 'cja_admin_menu' );
function cja_admin_menu() {

    // Notification bubbles

        // Profile approvals
        $args = array(
            'meta_key' => 'description_approved',
            'meta_value' => 'pending'
        );
        $user_query = new WP_User_Query($args);
        $profile_approvals = $user_query->get_total();

        // Attachment approvals
        $args = array(
            'meta_key' => 'files_approved',
            'meta_value' => 'pending'
        );
        $user_query = new WP_User_Query($args);
        $files_approvals = $user_query->get_total();

        // Advert approvals
        $args = array(
            'post_type' => array('job_ad', 'course_ad', 'classified_ad'),
            'meta_query' => array(
                array(
                    'key' => 'cja_ad_status',
                    'value' => 'inactive'
                )
            )
        );
        $cja_query = new WP_Query( $args );
        $advert_approvals = $cja_query->found_posts;

        // Any approvals
        if ($profile_approvals || $files_approvals || $advert_approvals) {
            $any_approvals = true;
        } else {
            $any_approvals = false;
        }

        $any_approvals = $profile_approvals + $files_approvals + $advert_approvals;
        
    // Theme options top level menu item
    add_menu_page(
        'Theme Options',
        'Theme Options',
        'manage_options',
        'cja_options',
        'cja_admin_page_contents',
        'dashicons-admin-tools',
        3
    );

    // Theme options sub
    add_submenu_page(
        'cja_options',
        'Theme Options',
        'Theme Options',
        'manage_options',
        'cja_options',
        'cja_admin_page_contents',
        'dashicons-schedule',
        1
    );

    // Manage user credits page (add credits to user account)
    add_submenu_page(
        'cja_options',
        'Manage User Credits',
        'Manage User Credits',
        'manage_options',
        'cja_user_credits',
        'cja_user_credits_page_contents',
        'dashicons-admin-tools',
        3
    );

    // Monitoring Screen (how many ads etc created on various days)
    add_submenu_page(
        'cja_options',
        'Monitoring',
        'Monitoring',
        'manage_options',
        'cja_monitoring',
        'cja_monitoring_content',
        'dashicons-chart-bar',
        4
    );

    // Approvals top level menu item
    add_menu_page(
        'Approvals',
        $any_approvals ? sprintf('Approvals <span class="awaiting-mod">%d</span>', $any_approvals) : 'Approvals',
        'edit_pages',
        'cja_approve_ads',
        'cja_approve_ads_content',
        'dashicons-yes',
        4
    );

    // Approve adverts page (manually approve new adverts)
    add_submenu_page(
        'cja_approve_ads',
        'Approve Adverts',
        $advert_approvals ? sprintf('Approve Adverts <span class="awaiting-mod">%d</span>', $advert_approvals) : 'Approve Adverts',
        //'Approve Adverts',
        'manage_options',
        'cja_approve_ads', 
        'cja_approve_ads_content',
        'dashicons-yes',
        1
    );

    // Approve profiles page (manually approve new profiles)
    add_submenu_page(
        'cja_approve_ads',
        'Approve Profiles',
        $profile_approvals ? sprintf('Approve Profiles <span class="awaiting-mod">%d</span>', $profile_approvals) : 'Approve Profiles',
        //'Approve Profiles<span class="awaiting-mod">' . $profile_approvals . '</span>',
        'edit_pages',
        'cja_approve_profiles',
        'cja_approve_profiles_content',
        'dashicons-yes',
        2
    );

    // Approve attachments page (manually approve new attachments)
    add_submenu_page(
        'cja_approve_ads',
        'Approve Attachments',
        $files_approvals ? sprintf('Approve Attachments <span class="awaiting-mod">%d</span>', $files_approvals) : 'Approve Attachments',
        //'Approve Attachments',
        'edit_pages',
        'cja_approve_attachments',
        'cja_approve_attachments_content',
        'dashicons-yes',
        3
    );
}

add_action( 'admin_init', 'my_remove_admin_menus' );
function my_remove_admin_menus() {
    remove_menu_page( 'edit-comments.php' ); // comments
    remove_menu_page( 'upload.php' ); // media
    remove_menu_page( 'edit.php' ); // posts
}
