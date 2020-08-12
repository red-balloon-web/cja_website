<?php

if ($cja_current_user_obj->role == 'jobseeker') {
						
    // Display form to apply
    if ($_GET['action'] == 'apply') {
        ?>
        <!--
        <h2>Apply for Job: <?php echo $cja_current_ad->title; ?></h2>
        <form action="<?php echo get_the_permalink(); ?>" method="post">
            <input type="hidden" name="do-application" value="true">
            <p>Covering letter:</p>
            <textarea name="letter" id="" cols="30" rows="10"></textarea>
            <p></p>
            <p><input type="submit" value="Send Application"></p>
        </form>-->

        <?php
        $cja_current_ad = new CJA_Advert(get_the_ID());
        if (!$cja_current_ad->applied_to_by_current_user) {
            $cja_new_application = new CJA_Application;
            $cja_new_application->create(get_the_ID());
            $cja_new_application->update_from_form($cja_current_ad, $cja_current_user_obj);
            $cja_new_application->save();
            ?><p class="cja_alert cja_alert--success">You Applied to <?php echo $cja_current_ad->title; ?></p>
            <p><a class="cja_button cja_button--2" href="<?php echo get_site_url() . '/' . $cja_config['browse-jobs-slug']; ?>">Back to Search Jobs</a></p><?php
        }
    }

    // Create new application - no longer used since no form data to process
    // Application handled by above GET function
    if ($_POST['do-application']) {
        $cja_new_application = new CJA_Application;
        $cja_new_application->create(get_the_ID());
        $cja_new_application->update_from_form($cja_current_ad, $cja_current_user_obj);
        $cja_new_application->save();
        ?><p class="cja_alert">You Applied to <?php echo $cja_current_ad->title; ?></p><?php
    }

    // Display message if they already applied
    $cja_current_ad = new CJA_Advert(get_the_ID());
    if ($cja_current_ad->applied_to_by_current_user) {
        $cja_user_application = new CJA_Application($cja_current_ad->applied_to_by_current_user);

        ?><p><strong>You applied to this job on <?php echo $cja_user_application->human_application_date; ?></strong></p><?php
    }
}
?>