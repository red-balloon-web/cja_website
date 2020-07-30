<div class="application_box">
    <!--<p class="cja_listing_item job_description">Job Description:</p>--> 
    <h4>Job Description</h4>
    <div class="cja_description"><?php echo wpautop($cja_current_ad->content); ?></div>
    <hr>
    <h4>Job Details</h4>
    <p class="cja_listing_item">Salary: <strong><?php echo $cja_current_ad->salary; ?></strong></p>
    <p class="cja_listing_item">Contact person: <strong><?php echo $cja_current_ad->contact_person; ?></strong></p>
    <p class="cja_listing_item">Contact phone number: <strong><?php echo $cja_current_ad->phone; ?></strong></p>
    <p class="cja_listing_item">Deadline: <strong><?php echo $cja_current_ad->deadline; ?></strong></p>
    <p class="cja_listing_item">Job Type: <strong><?php echo $cja_current_ad->return_human('job_type'); ?></strong></p>
    <p class="cja_listing_item">Sector: <strong><?php echo $cja_current_ad->return_human('sectors'); ?></strong></p>
</div>