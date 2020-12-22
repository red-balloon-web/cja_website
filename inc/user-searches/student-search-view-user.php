<?php
if ($_GET['view-profile']) {

    $cja_current_applicant = new CJA_User($_GET['view-profile']);

    include (ABSPATH . 'wp-content/themes/courses-and-jobs/inc/templates/applicant-details.php');

    /*

    $viewed_user = new CJA_User($_GET['view-profile']);

    
    ?>
    
    <div class="applicant_details application_box">
    <h4>Student Details</h4>
    <p class="cja_listing_item">Name: <strong><?php echo $viewed_user->full_name; ?></strong></p>
    <p class="cja_listing_item">Phone Number: <strong><?php echo $viewed_user->phone; ?></strong></p>
    <p class="cja_listing_item">Postcode: <strong><?php echo $viewed_user->postcode; ?></strong></p>
    <p class="cja_listing_item">Age Category: <strong><?php echo $viewed_user->age_category; ?></strong></p>
    <p class="cja_listing_item">GCSE Maths: <strong><?php echo $viewed_user->return_human('gcse_maths'); ?></strong></p>
    <p class="cja_listing_item">Weekends Availability: <strong><?php echo $viewed_user->return_human('weekends_availability'); ?></strong></p>
    <?php if ($viewed_user->cv_url) { ?>
        <p><a target="_blank" href="<?php echo $viewed_user->cv_url; ?>" class="cja_button">View CV</a></p>
    <?php } ?>
    <h4>Student Profile</h4>
    <div class="cja_description"><?php echo wpautop($viewed_user->company_description); ?></div>
    <p><a href="<?php echo get_site_url() . '/search-students'; ?>"><< Back to Search Students</a></p>
</div> <?php

        */

    $display_search = false;
}