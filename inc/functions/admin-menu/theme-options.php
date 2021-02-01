<?php
/**
 * CJA Admin Page Contents
 * Displays content for 'theme options' page in admin
 */
function cja_admin_page_contents() { ?>

    <h1>Theme Options</h1>
    <form action="<?php echo admin_url('admin.php?page=cja_options'); ?>" method="POST"><?php 

        // Charge for adverts ?>
        <p><input type="checkbox" name="cja_charge_users" value="true" <?php if (get_option('cja_charge_users')) { echo 'checked'; } ?>> Charge users to place adverts</p>
        <p class="label">Display message to users that adverts are free (leave blank for no message)</p>
        <p><input type="text" name="cja_free_ads_message" value="<?php echo get_option('cja_free_ads_message'); ?>"></p>
        <hr><?php

        // Number of days old an advert is still considered "new" ?>
        <p class="label">Number of days old an advert is still "new" (0 = today only, -1 = turn off)</p>
        <input type="number" name="days_new" value="<?php echo get_option('cja_days_still_new'); ?>" max="15" min="-1" >
        <hr><?php

        // Number of days old an advert is still considered "new" ?>
        <p class="label">Number of days old a user is still "new" (0 = today only, -1 = turn off)</p>
        <input type="number" name="user_days_new" value="<?php echo get_option('cja_user_days_still_new'); ?>" max="15" min="-1" >
        <hr><?php

        // Display homepage or holding page ?>
        <p><input type="checkbox" name="display_homepage" <?php if (get_option('cja_display_homepage')) { echo 'checked'; } ?>> Display full homepage</p><?php

        // Display footer menu ?>
        <p><input type="checkbox" name="display_footer_menu" <?php if (get_option('cja_display_footer_menu')) { echo 'checked'; } ?>> Display footer menu</p>
        
        <hr>
        <p class="label">Profile Approval Email Subject</p>
        <p><input type="text" name="profile_approval_email_subject" style="width: 500px;" value="<?php echo stripslashes(get_option('profile_approval_email_subject')); ?>"></p>

        <p class="label">Profile Approval Email Message</p>
        <textarea name="profile_approval_email_message" id="" cols="60" rows="10"><?php echo stripslashes(get_option('profile_approval_email_message')); ?></textarea>

        <p class="label">Attachment Approval Email Subject</p>
        <p><input type="text" name="attachment_approval_email_subject" style="width: 500px;" value="<?php echo stripslashes(get_option('attachment_approval_email_subject')); ?>"></p>

        <p class="label">Attachment Approval Email Message</p>
        <textarea name="attachment_approval_email_message" id="" cols="60" rows="10"><?php echo stripslashes(get_option('attachment_approval_email_message')); ?></textarea>

        <p class="label">Attachment Approval (edited) Email Message</p>
        <textarea name="attachment_edited_approval_email_message" id="" cols="60" rows="10"><?php echo stripslashes(get_option('attachment_edited_approval_email_message')); ?></textarea>

        <p class="label">Copy 'awaiting approval' notification emails to</p>
        <p><input type="text" name="approval_notification_cc" style="width: 500px;" value="<?php echo stripslashes(get_option('approval_notification_cc')); ?>"></p>
        <hr>

        <input type="submit" value="Update Options">
        <input type="hidden" name="cja_action" value="update_theme_options">

    </form><?php
}