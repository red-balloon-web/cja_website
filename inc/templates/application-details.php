<div class="basic_details application_box">
    <h4>Basic Details</h4>
    <p class="cja_listing_item">Applicant: <strong><?php echo $cja_current_applicant->full_name; ?></strong></p>
    <p class="cja_listing_item">Job Title: <strong><?php echo $cja_current_ad->title; ?></strong></p>
    <p class="cja_listing_item">Company: <strong><?php echo $cja_current_advertiser->company_name; ?></strong></p>
    <p class="cja_listing_item">Date: <strong><?php echo $cja_current_application->human_application_date; ?></strong></p>
    <p class="cja_listing_item">Covering Letter:</p> 
    <div class="cja_description"><?php echo wpautop($cja_current_application->applicant_letter); ?></div>
</div>