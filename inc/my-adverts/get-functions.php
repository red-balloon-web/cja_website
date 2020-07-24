<?php

if ($_GET) {

    /**
     * DISPLAY FORMS
     */

    // Display form to edit advert
    if ($_GET['edit-ad']) {
        $do_list = false;
        $cja_edit_ad = new CJA_Advert($_GET['edit-ad']);
        ?>
        <h1>Edit Advert</h1>
        <form action="<?php echo $cja_page_address; ?>" method="POST">
            <p class="label">Advert Title</p>
            <input type="text" name="ad-title" value="<?php echo ($cja_edit_ad->title); ?>">
            <p class="label">Advert Text</p>
            <textarea name="ad-content" id="" cols="30" rows="10"><?php echo ($cja_edit_ad->content); ?></textarea>
            <input type="hidden" name="update-ad" value="true" >
            <input type="hidden" name="advert-id" value="<?php echo ($cja_edit_ad->id); ?>">
            <input type="submit" class="cja_button cja_button--2" value="Update Advert">
        </form>
        <?php
    }

    // Display form to create new advert
    if ($_GET['create-ad']) { 
        $do_list = false; ?>
        <h1>Create Advert</h1>
        <form action="<?php echo $cja_page_address; ?>" method="POST">
            <p class="label">Advert Title</p>
            <input type="text" name="ad-title">
            <p class="label">Advert Text</p>
            <textarea name="ad-content" id="" cols="30" rows="10"></textarea>
            <input type="hidden" name="process-create-ad" value="true">
            <input type="submit" class="cja_button cja_button--2" value="Create Advert (1 Credit)">&nbsp;&nbsp;
            <input type="submit" class="cja_button" formaction="<?php echo $cja_page_address; ?>?draft=true" value="Save as Draft">&nbsp;&nbsp;
            <a href="<?php echo get_page_link(); ?>" class="cja_button">Cancel</a>
        </form>
    <?php }

    // Display buttons to purchase credits
    if ($_GET{'buy-credits'}) {
        $do_list = false;
        $cja_current_user = new CJA_User; ?>

        <h1>Buy Credits</h1>
        <p><span class="credits-large"><?php echo ($cja_current_user->credits); ?></span>&nbsp;&nbsp;advert credits remaining</p>
        <p>When you place an advert it costs you one credit per month. You can extend ads for another month for one credit.</p>
        <p>You can buy 1 credit for £30 or 10 credits for £150.</p>
        <p>
            <a href="<?php echo get_site_url(); ?>/basket?add-to-cart=8" class="cja_button cja_button--2 add-credits-to-cart"><span>1 Credit £30</span><br>Add to cart</a>
            <a href="<?php echo get_site_url(); ?>/basket?add-to-cart=7" class="cja_button cja_button--2 add-credits-to-cart"><span>10 Credits £150</span><br>Add to cart</a>
        </p>
        <p><a href="<?php echo get_page_link(); ?>" class="cja_button">Cancel</a></p>
    
    <?php }


    /**
     * DO ADMIN TASKS
     */

    // Delete advert
    if ($_GET['delete-ad']) {
        $cja_delete_ad = new CJA_Advert($_GET['delete-ad']);
        $cja_delete_ad->delete(); 
        $cja_delete_ad->save();
        ?><p class="cja_alert_success">Your advert for "<?php echo ($cja_delete_ad->title); ?>" has been deleted.</p><?php
    }


    // Extend ad for another month
    if ($_GET['extend-ad']) {
        $cja_extend_ad = new CJA_Advert($_GET['extend-ad']);
        $cja_extend_ad->extend();
        $cja_extend_ad->save();
        spend_credits();
        ?><p class="cja_alert_success">Your advert for "<?php echo ($cja_extend_ad->title); ?>" has been extended for 1 credit.</p><?php
    }

    // Activate ad
    if ($_GET['activate-ad']) {
        $cja_activate_ad = new CJA_Advert($_GET['activate-ad']);
        $cja_activate_ad->activate();
        $cja_activate_ad->save();
        spend_credits();
        ?><p class="cja_alert_success">Your advert for "<?php echo ($cja_activate_ad->title); ?>" has been activated for 1 credit.</p><?php
    }
}
?>