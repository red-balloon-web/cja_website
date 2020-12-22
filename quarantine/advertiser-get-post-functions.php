<?php
// Does this ad belong to the current user
if ($cja_current_ad->created_by_current_user) {

    // Extend this ad
    if ($_GET['extend-ad']) {
        $cja_extend_ad = new CJA_Advert(get_the_ID());
        $cja_extend_ad->extend();
        $cja_extend_ad->save();
        spend_credits();
        ?><p class="cja_alert cja_alert--success">Your advert for "<?php echo ($cja_extend_ad->title); ?>" has been extended for 1 credit.</p><?php
        $cja_current_ad = new CJA_Advert(get_the_ID());
    }

    // Activate this ad
    if ($_GET['activate-ad']) {
        $cja_activate_ad = new CJA_Advert(get_the_ID());
        $cja_activate_ad->activate();
        $cja_activate_ad->save();
        spend_credits();
        ?><p class="cja_alert cja_alert--success">Your advert for "<?php echo ($cja_activate_ad->title); ?>" has been activated for 1 credit.</p><?php
        $cja_current_ad = new CJA_Advert(get_the_ID());
    }

    // Display edit ad form
    if ($_GET['edit-ad']) { 
        $cja_edit_ad = new CJA_Advert(get_the_ID()); 
        $display_advert = false; ?>
        <h1>Edit Advert</h1>
        <form action="<?php echo get_the_permalink() ?>" id="edit_ad_form" method="POST">
            <p class="label">Advert Title</p>
            <input type="text" name="ad-title" value="<?php echo ($cja_edit_ad->title); ?>">
            <p class="label">Advert Text</p>
            <textarea name="ad-content" id="" cols="30" rows="10"><?php echo ($cja_edit_ad->content); ?></textarea>
            <p class="label">Salary</p>
            <input type="text" name="salary" value="<?php echo ($cja_edit_ad->salary); ?>">
            <p class="label">Contact Person</p>
            <input type="text" name="contact_person" value="<?php echo ($cja_edit_ad->contact_person); ?>">
            <p class="label">Contact Phone Number</p>
            <input type="text" name="phone" value="<?php echo ($cja_edit_ad->phone); ?>">
            <p class="label">Deadline</p>
            <input type="date" name="deadline" value="<?php echo ($cja_edit_ad->deadline); ?>">
            <p class="label">Job Type</p>
            <select name="job_type" form="edit_ad_form">
                <option value="full_time" <?php if ($cja_edit_ad->job_type == 'full_time') { echo 'selected'; } ?>>Full Time</option>
                <option value="part_time" <?php if ($cja_edit_ad->job_type == 'part_time') { echo 'selected'; } ?>>Part Time</option>
                <option value="freelance" <?php if ($cja_edit_ad->job_type == 'freelance') { echo 'selected'; } ?>>Freelance</option>
                <option value="intern" <?php if ($cja_edit_ad->job_type == 'intern') { echo 'selected'; } ?>>Internship</option>
                <option value="temporary" <?php if ($cja_edit_ad->job_type == 'temporary') { echo 'selected'; } ?>>Temporary</option>
            </select>
            <p class="label">Sector</p>
            <select name="sectors" form="edit_ad_form">
                <option value="accountancy" <?php if ($cja_edit_ad->sectors == 'accountancy') { echo 'selected'; } ?>>Accountancy</option>
                <option value="construction" <?php if ($cja_edit_ad->sectors == 'construction') { echo 'selected'; } ?>>Construction</option>
                <option value="nursing" <?php if ($cja_edit_ad->sectors == 'nursing') { echo 'selected'; } ?>>Nursing</option>
            </select><br><br>
            <input type="hidden" name="update-ad" value="true" >
            <input type="hidden" name="advert-id" value="<?php echo ($cja_edit_ad->id); ?>">
            <input type="submit" class="cja_button cja_button--2" value="Update Advert">
        </form>
    <?php } 

    // Update advert if form submitted
    if ($_POST['update-ad']) {

        $cja_update_ad = new CJA_Advert($_POST['advert-id']);
        $cja_update_ad->update_from_form(); 
        $cja_update_ad->save(); 
        ?><p class="cja_alert cja_alert--success">Your advert for "<?php echo ($cja_update_ad->title); ?>" has been updated.</p><?php
        $cja_current_ad = new CJA_Advert(get_the_ID());
    }
} ?>