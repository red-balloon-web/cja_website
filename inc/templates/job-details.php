<div class="application_box">
    <!--<p class="cja_listing_item job_description">Job Description:</p>--> 
    <h4>Job Description</h4>
    <div class="cja_description"><?php echo wpautop($cja_current_ad->content); ?></div>
    <hr>
    <h4>Job Details</h4>
    <p class="cja_listing_item">Salary: £<strong><?php echo $cja_current_ad->salary_numeric; ?> per <?php echo $cja_current_ad->salary_per; ?></strong></p>
    <p class="cja_listing_item">Job Type: <strong><?php echo $cja_current_ad->return_human('job_type'); ?></strong></p>
    <p class="cja_listing_item">Sector: <strong><?php echo $cja_current_ad->return_human('sector'); ?></strong></p>
    <p class="cja_listing_item">Contact person: <strong><?php echo $cja_current_ad->contact_person; ?></strong></p>
    <p class="cja_listing_item">Contact phone number: <strong><?php echo $cja_current_ad->contact_phone_number; ?></strong></p>
    <p class="cja_listing_item">Career level: <strong><?php echo $cja_current_ad->return_human('career_level'); ?></strong></p>
    <p class="cja_listing_item">Experience required: <strong><?php echo $cja_current_ad->return_human('experience_required'); ?></strong></p>
    <p class="cja_listing_item">Employer type: <strong><?php echo $cja_current_ad->return_human('employer_type'); ?></strong></p>
    <p class="cja_listing_item">Minimum qualification required: <strong><?php echo $cja_current_ad->return_human('minimum_qualification'); ?></strong></p>
    <p class="cja_listing_item">DBS required: <strong><?php echo $cja_current_ad->return_human('dbs_required'); ?></strong></p>
    <p class="cja_listing_item">Payment frequency: <strong><?php echo $cja_current_ad->return_human('payment_frequency'); ?></strong></p>
    <p class="cja_listing_item">Shift work: <strong><?php echo $cja_current_ad->return_human('shift_work'); ?></strong></p>
    <?php if ($cja_current_ad->shift_work == 'yes') { ?>
        <p class="cja_listing_item">Shifts: <strong><?php echo $cja_current_ad->return_human('shifts'); ?></strong></p>
    <?php } ?>
    <p class="cja_listing_item">Location options: <strong><?php echo $cja_current_ad->return_human('location_options'); ?></strong></p>
    <p class="cja_listing_item">Deadline: <strong><?php echo $cja_current_ad->return_human('deadline'); ?></strong></p>
    <p class="cja_listing_item"><a class="cja_button" href="<?php echo $cja_current_ad->job_spec_url; ?>" target="_blank">Download Job Specification</a></p>

</div>