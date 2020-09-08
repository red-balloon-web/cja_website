<?php
if ($_GET['view-profile']) {

    $viewed_user = new CJA_User($_GET['view-profile']);

    ?>
    
    <div class="applicant_details application_box">
    <h4>Jobseeker Details</h4>
    <p class="cja_listing_item">Name: <strong><?php echo $viewed_user->full_name; ?></strong></p>
    <p class="cja_listing_item">Phone Number: <strong><?php echo $viewed_user->phone; ?></strong></p>
    <p class="cja_listing_item">Postcode: <strong><?php echo $viewed_user->postcode; ?></strong></p>
    <p class="cja_listing_item">Age Category: <strong><?php echo $viewed_user->age_category; ?></strong></p>
    <p class="cja_listing_item">GCSE Maths: <strong><?php echo $viewed_user->return_human('gcse_maths'); ?></strong></p>
    <p class="cja_listing_item">Weekends Availability: <strong><?php echo $viewed_user->return_human('weekends_availability'); ?></strong></p>
    <?php if ($viewed_user->cv_url) { ?>
        <p><a target="_blank" href="<?php echo $viewed_user->cv_url; ?>" class="cja_button">View CV</a></p>
    <?php } ?>
    <p><a href="<?php echo get_site_url() . '/search-cvs'; ?>"><< Back to Search CVs</a></p>
</div> <?php

    $display_search = false;
}