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
        <form action="<?php echo get_the_permalink() ?>" method="POST">
            <p class="label">Advert Title</p>
            <input type="text" name="ad-title" value="<?php echo ($cja_edit_ad->title); ?>">
            <p class="label">Advert Text</p>
            <textarea name="ad-content" id="" cols="30" rows="10"><?php echo ($cja_edit_ad->content); ?></textarea>
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