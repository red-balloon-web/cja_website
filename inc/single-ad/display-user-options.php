<?php
// Display advertiser options
if ($cja_current_ad->created_by_current_user) {
    
    // Active buttons
    if ($cja_current_ad->status == 'active') {
        ?>
        <p>You Placed this Advert on <?php echo $cja_current_ad->human_activation_date; ?> (<?php echo $cja_current_ad->days_left; ?> days left)</p>
        <p class="responsive_buttons">
            <a class="cja_button cja_button--2 cja_button--mar-right" href="<?php echo get_the_permalink(); ?>/?extend-ad=true">EXTEND (1 Credit)</a> 
            <a class="cja_button cja_button--mar-right" href="<?php echo get_the_permalink(); ?>?edit-ad=true">EDIT</a> 
            <a class="cja_button cja_button--mar-right" href="<?php echo get_site_url() . '/' . $cja_config['my-jobs-admin-page-slug'] . '?delete-ad=' . $cja_current_ad->id; ?>">DELETE</a>
        </p>
        <?php
    
    // Inactive buttons
    } else if ($cja_current_ad->status == 'inactive') { ?>
        <p><a class="cja_spend_button" href="<?php echo get_the_permalink() ?>?activate-ad=true"><span>ACTIVATE THIS ADVERT</span><br>1 Credit</a></p>
        <?php
    }
}
?>