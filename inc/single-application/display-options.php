<?php

if ($cja_current_user_obj->role == 'advertiser' || $cja_current_user_obj->role == 'administrator') {
    ?><p><?php
        if (!$cja_current_application->$advertiser_archived) {
        ?>
            <a href="<?php echo get_site_url() . '/' . $cja_config['applications-page-slug']; ?>?advertiser_archive=<?php echo $cja_current_application->id; ?>" class="cja_button cja_button--mar-right">Archive this Application</a>
            <?php
        } ?>
        <a href="<?php echo get_site_url() . '/' . $cja_config['applications-page-slug']; ?>" class="cja_button">My Job Applications</a>
    </p><?php
}

if ($cja_current_user_obj->role == 'jobseeker') {
    if (!$cja_current_application->applicant_archived) {
        ?>
        <p>You applied to this job on <?php echo $cja_current_application->human_application_date; ?></p>
        <p>
            <a href="<?php echo get_site_url() . '/' . $cja_config['applications-page-slug']; ?>?applicant_archive=<?php echo $cja_current_application->id; ?>" class="cja_button cja_button--mar-right">Archive this Application</a>
            <a href="<?php echo get_site_url() . '/' . $cja_config['applications-page-slug']; ?>" class="cja_button">My Job Applications</a>
        </p>
        <?php
    } else {
        ?><p class="red">You have archived this application</p>
        <p><a href="<?php echo get_site_url() . '/' . $cja_config['applications-page-slug']; ?>" class="cja_button">My Job Applications</a></p>
        <?php
    }
}

?>