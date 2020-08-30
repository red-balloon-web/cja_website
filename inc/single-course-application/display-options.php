<?php

if ($cja_current_user_obj->role == 'advertiser') {
    if (!$cja_current_application->$advertiser_archived) {
        ?>
        <p><a href="<?php echo get_site_url() . '/' . $cja_config['course-applications-page-slug']; ?>?advertiser_archive=<?php echo $cja_current_application->id; ?>" class="cja_button">Archive this Application</a></p>
        <?php
    }
}

if ($cja_current_user_obj->role == 'jobseeker') {
    if (!$cja_current_application->applicant_archived) {
        ?>
        <p>You applied to this course on <?php echo $cja_current_application->human_application_date; ?></p>
        <p><a href="<?php echo get_site_url() . '/' . $cja_config['course-applications-page-slug']; ?>?applicant_archive=<?php echo $cja_current_application->id; ?>" class="cja_button">Archive this Application</a></p>
        <?php
    } else {
        ?><p class="red">You have archived this application</p><?php
    }
}

?>