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
        
        <form action="<?php echo $cja_page_address; ?>" id="edit_ad_form" method="post" enctype="multipart/form-data">

            <?php include( ABSPATH . 'wp-content/themes/courses-and-jobs/inc/templates/job-details-form.php'); ?>

            <br><br>
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
        <form action="<?php echo $cja_page_address; ?>" id="edit_ad_form" method="post" enctype="multipart/form-data">
            <?php         
            include( ABSPATH . 'wp-content/themes/courses-and-jobs/inc/templates/job-details-form.php');
            ?>
            <br><br>
            <input type="hidden" name="process-create-ad" value="true">
            <input type="submit" class="cja_button cja_button--2" value="Create Advert (1 Credit)">&nbsp;&nbsp;
            <input type="submit" class="cja_button" formaction="<?php echo $cja_page_address; ?>?draft=true" value="Save as Draft">&nbsp;&nbsp;
            <a href="<?php echo get_page_link(); ?>" class="cja_button">Cancel</a>
        </form>
    <?php }


    /**
     * DO ADMIN TASKS
     */

    // Delete advert
    if ($_GET['delete-ad']) {
        $cja_delete_ad = new CJA_Advert($_GET['delete-ad']);
        $cja_delete_ad->delete(); 
        $cja_delete_ad->save();
        ?><p class="cja_alert cja_alert--success">Your advert for "<?php echo ($cja_delete_ad->title); ?>" has been deleted.</p><?php
    }


    // Extend ad for another month
    if ($_GET['extend-ad']) {
        $cja_extend_ad = new CJA_Advert($_GET['extend-ad']);
        $cja_extend_ad->extend();
        $cja_extend_ad->save();
        spend_credits();
        ?><p class="cja_alert cja_alert--success">Your advert for "<?php echo ($cja_extend_ad->title); ?>" has been extended for 1 credit.</p><?php
    }

    // Activate ad
    if ($_GET['activate-ad']) {
        $cja_activate_ad = new CJA_Advert($_GET['activate-ad']);
        $cja_activate_ad->activate();
        $cja_activate_ad->save();
        spend_credits();
        ?><p class="cja_alert cja_alert--success">Your advert for "<?php echo ($cja_activate_ad->title); ?>" has been activated for 1 credit.</p><?php
    }
}
?>