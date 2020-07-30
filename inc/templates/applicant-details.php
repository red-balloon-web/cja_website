<div class="applicant_details application_box">
    <h4>Applicant Details</h4>
    <p class="cja_listing_item">Name: <strong><?php echo $cja_current_applicant->full_name; ?></strong></p>
    <p class="cja_listing_item">Phone Number: <strong><?php echo $cja_current_applicant->phone; ?></strong></p>
    <p class="cja_listing_item">Postcode: <strong><?php echo $cja_current_applicant->postcode; ?></strong></p>
    <p class="cja_listing_item">Age Category: <strong><?php echo $cja_current_applicant->age_category; ?></strong></p>
    <p class="cja_listing_item">GCSE Maths: <strong><?php echo $cja_current_applicant->return_human('gcse_maths'); ?></strong></p>
    <p class="cja_listing_item">Weekends Availability: <strong><?php echo $cja_current_applicant->return_human('weekends_availability'); ?></strong></p>
    <p><a target="_blank" href="<?php echo $cja_current_application->cv_url; ?>" class="cja_button">Download CV</a></p>
</div>