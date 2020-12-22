<?php

if ($cja_current_user_obj->role == 'jobseeker') {
						
    // Apply to job
    if ($_GET['action'] == 'apply') {

        // Create application
        $cja_current_ad = new CJA_Advert(get_the_ID());
        if (!$cja_current_ad->applied_to_by_current_user) {
            $cja_new_application = new CJA_Application;
            $cja_new_application->create(get_the_ID());
            $cja_new_application->update_from_form($cja_current_ad, $cja_current_user_obj);
            $cja_new_application->save();

            // Send email
            $cja_current_advertiser = new CJA_User($cja_current_ad->author);
            $email_details = array(
                'to' => $cja_current_advertiser->email,
                'subject' => "New Application to '" . $cja_current_ad->title . "'",
                'body' => "There has been a new application to your job '" . $cja_current_ad->title . "' by " . $cja_current_user_obj->full_name . ".\n\nTo view all applications to your jobs log in to your account at www.coursesandjobs.co.uk and select 'My Job Applications'. \n\nThank you for using the website!\n\nThe Courses and Jobs Team"
            );

            cja_sendmail($email_details);

            // Display message
            ?><p class="cja_alert cja_alert--success">You Applied to <?php echo $cja_current_ad->title; ?></p>
            <p><a class="cja_button cja_button--2" href="<?php echo get_site_url() . '/' . $cja_config['browse-jobs-slug']; ?>">Back to Search Jobs</a></p><?php
        }
    }

    // Display message 
    $cja_current_ad = new CJA_Advert(get_the_ID());
    if ($cja_current_ad->applied_to_by_current_user) {
        $cja_user_application = new CJA_Application($cja_current_ad->applied_to_by_current_user);

        ?><p><strong>You applied to this job on <?php echo $cja_user_application->human_application_date; ?></strong></p><?php
    }
}
?>