<?php

if ($_GET) {

    /**
     * DISPLAY FORMS
     */

    // Display form to edit advert
    if ($_GET['edit-ad']) {
        $do_list = false;
        $cja_edit_ad = new CJA_Classified_Advert($_GET['edit-ad']);
        ?>
        <h1>Edit Advert</h1>
        
        <form action="<?php echo $cja_page_address; ?>" id="edit_ad_form" method="post" enctype="multipart/form-data">

            <?php include( ABSPATH . 'wp-content/themes/courses-and-jobs/inc/templates/classified-details-form.php'); ?>

            <br><br>
            <input type="hidden" name="update-ad" value="true" >
            <input type="hidden" name="advert-id" value="<?php echo ($cja_edit_ad->id); ?>">
            <input type="submit" class="cja_button cja_button--2" value="Update Advert">
            <a class = "cja_button" href="<?php echo get_site_url() . '/' . $cja_config['my-classified-ads-slug']; ?>">Cancel</a>

        </form>
        
        <?php
    }

    // Display success message on successful ad creation
    if ($_GET['create-ad-success']) {
        $cja_new_ad = new CJA_Classified_Advert($_GET['create-ad-success']);

        ?><p class="cja_alert cja_alert--success">Your Advert "<?php echo $cja_new_ad->title; ?>" Was Created<?php if (get_option('cja_charge_users')) { echo ' for 1 Credit'; } ?>!</p><?php
    }

    // Display success message on successful ad extension
    if ($_GET['extend-ad-success']) {
        $cja_extend_ad = new CJA_Classified_Advert($_GET['extend-ad-success']);
        ?><p class="cja_alert cja_alert--success">Your Advert "<?php echo $cja_extend_ad->title; ?>" Was Extended<?php if (get_option('cja_charge_users')) { echo ' for 1 Credit'; } ?>!</p><?php
    }

    // Display form to create new advert
    if ($_GET['create-ad']) { 

        $cja_user = new CJA_User;
        if ($cja_user->company_details_complete) {

            $do_list = false; ?>
            <h1>Create Advert</h1>
            <form action="<?php echo $cja_page_address; ?>" id="edit_ad_form" method="post" enctype="multipart/form-data">
                <?php         
                include( ABSPATH . 'wp-content/themes/courses-and-jobs/inc/templates/classified-details-form.php');
                ?>
                <br><br>
                <input type="hidden" name="process-create-classified-ad" value="true">
                <input type="submit" class="cja_button cja_button--2" value="Create Advert (1 Credit)">&nbsp;&nbsp;
                <!--<input type="submit" class="cja_button" formaction="<?php echo $cja_page_address; ?>?draft=true" value="Save as Draft">&nbsp;&nbsp;-->
                <a href="<?php echo get_page_link(); ?>" class="cja_button">Cancel</a>
            </form>

        <?php } else { ?>

            <p class="cja_alert cja_alert--red">Please <a href="<?php echo get_site_url() . $cja_config['user-details-page-slug']; ?>">complete your public details </a>before placing an advert</p>

        <?php } ?>
    <?php }


    /**
     * DO ADMIN TASKS
     */

    // Delete advert
    if ($_GET['delete-ad']) {
        $cja_delete_ad = new CJA_Classified_Advert($_GET['delete-ad']);
        if ($cja_delete_ad->status != 'deleted') {
            $cja_delete_ad->delete(); 
            $cja_delete_ad->save();
            ?><p class="cja_alert cja_alert--success">Your advert for "<?php echo ($cja_delete_ad->title); ?>" has been deleted.</p><?php
        }
    }
}
?>