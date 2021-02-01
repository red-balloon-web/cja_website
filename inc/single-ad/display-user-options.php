<?php
// Display advertiser options
if ($cja_current_user_obj->role == 'advertiser' || $cja_current_user_obj->role == 'administrator') {
    if ($cja_current_ad->created_by_current_user) {

        // Active buttons
        if ($cja_current_ad->status == 'active') {
            ?>
            <p>This advert was placed on <?php echo $cja_current_ad->human_activation_date; ?> (<?php echo $cja_current_ad->days_left; ?> days left)</p>
            <p class="responsive_buttons">
                <a class="cja_button cja_button--2 cja_button--mar-right" href="<?php echo get_site_url() . '/' . $cja_config['my-jobs-admin-page-slug'] . '?extend-ad=' . $cja_current_ad->id; ?>">EXTEND<!-- (1 Credit) --></a> 
                <a class="cja_button cja_button--mar-right" href="<?php echo get_site_url() . '/' . $cja_config['my-jobs-admin-page-slug'] . '?edit-ad=' . $cja_current_ad->id; ?>">EDIT</a> 
                <a class="cja_button cja_button--mar-right" href="<?php echo get_site_url() . '/' . $cja_config['my-jobs-admin-page-slug'] . '?delete-ad=' . $cja_current_ad->id; ?>">DELETE</a>
                <a class="cja_button " href="<?php echo get_site_url() . '/' . $cja_config['my-jobs-admin-page-slug']; ?>">My Job Adverts</a>
            </p>
            <?php
        
        // Inactive buttons
        } else if ($cja_current_ad->status == 'expired') { ?>
            <p>
                <a class="cja_spend_button cja_button--mar-right" href="<?php echo get_the_permalink() ?>?activate-ad=true"><span>ACTIVATE THIS ADVERT</span><!--<br>1 Credit--></a>
                <a class="cja_button cja_button--mar-right" href="<?php echo get_site_url() . '/' . $cja_config['my-jobs-admin-page-slug'] . '?delete-ad=' . $cja_current_ad->id; ?>">DELETE</a>
                <a class="cja_button " href="<?php echo get_site_url() . '/' . $cja_config['my-jobs-admin-page-slug']; ?>">My Job Adverts</a>
            </p>
            <?php
        }

        ?>

        <?php
    } else {?>
        <p>
            <a class="cja_button cja_button--mar-right" href="<?php echo get_site_url(); ?>/search-jobs">Search Jobs</a>
        </p><?php
    }
}
?>