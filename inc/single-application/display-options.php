<?php

if ($cja_current_user_obj->role == 'advertiser') {
    if (!$cja_current_application->$advertiser_archived) {
        ?>
        <p><a href="<?php echo get_site_url() . '/' . $cja_config['applications-page-slug']; ?>?advertiser_archive=<?php echo $cja_current_application->id; ?>" class="cja_button">Archive this Application</a></p>
        <?php
    }
}

?>