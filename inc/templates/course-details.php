<div class="application_box">
    <!--<p class="cja_listing_item job_description">Job Description:</p>--> 
    <h4>Course Description</h4>
    <div class="cja_description"><?php echo wpautop($cja_current_ad->description); ?></div>
    <hr>
    <h4>Course Details</h4>
    <p class="cja_listing_item">Offer Type: <strong><?php echo $cja_current_ad->return_human('offer_type'); ?></strong></p>
    <p class="cja_listing_item">Category: <strong><?php echo $cja_current_ad->return_human('category'); ?></strong></p>
    <p class="cja_listing_item">Organisation Name: <strong><?php echo $cja_current_ad->organisation_name; ?></strong></p>
    <p class="cja_listing_item">Address: <strong><?php echo wpautop($cja_current_ad->address); ?></strong></p>
    <p class="cja_listing_item">Postcode: <strong><?php echo $cja_current_ad->postcode; ?></strong></p>
    <p class="cja_listing_item">Price for Students not Eligible for Funding (if applicable): <strong><?php echo $cja_current_ad->price; ?></strong></p>
    <p class="cja_listing_item">Contact Phone Number: <strong><?php echo $cja_current_ad->phone; ?></strong></p>
    <p class="cja_listing_item">Sector: <strong><?php echo $cja_current_ad->return_human('sector'); ?></strong></p>
    <p class="cja_listing_item">Deposit Required: <strong><?php echo $cja_current_ad->return_human('deposit_required'); ?></strong></p>
    <p class="cja_listing_item">Career Level: <strong><?php echo $cja_current_ad->return_human('career_level'); ?></strong></p>
    <p class="cja_listing_item">Experience Required: <strong><?php echo $cja_current_ad->return_human('experience_required'); ?></strong></p>
    <p class="cja_listing_item">Training Provider Type: <strong><?php echo $cja_current_ad->return_human('provider_type'); ?></strong></p>
    <p class="cja_listing_item">Previous Qualification Required: <strong><?php echo $cja_current_ad->return_human('previous_qualification'); ?></strong></p>
    <p class="cja_listing_item">Course Pathway: <strong><?php echo $cja_current_ad->return_human('course_pathway'); ?></strong></p>
    <p class="cja_listing_item">Course Funding Options: <strong><?php echo $cja_current_ad->return_human('funding_options'); ?></strong></p>
    <p class="cja_listing_item">Payment Plan: <strong><?php echo $cja_current_ad->return_human('payment_plan'); ?></strong></p>
    <p class="cja_listing_item">Qualification Level: <strong><?php echo $cja_current_ad->return_human('qualification_level'); ?></strong></p>
    <p class="cja_listing_item">Qualification Type: <strong><?php echo $cja_current_ad->return_human('qualification_type'); ?></strong></p>
    <p class="cja_listing_item">Contact for Course Enquiry: <strong><?php echo $cja_current_ad->return_human('contact_for_enquiry'); ?></strong></p>
    <p class="cja_listing_item">Total Units: <strong><?php echo $cja_current_ad->return_human('total_units'); ?></strong></p>
    <p class="cja_listing_item">DBS Required: <strong><?php echo $cja_current_ad->return_human('dbs_required'); ?></strong></p>
    <p class="cja_listing_item">Availability Period: <strong><?php echo $cja_current_ad->return_human('availability_period'); ?></strong></p>
    <p class="cja_listing_item">Allowance Available: <strong><?php echo $cja_current_ad->return_human('allowance_available'); ?></strong></p>
    <p class="cja_listing_item">Awarding Body: <strong><?php echo $cja_current_ad->return_human('awarding_body'); ?></strong></p>
    <p class="cja_listing_item">Duration: <strong><?php echo $cja_current_ad->return_human('duration'); ?></strong></p>
    <p class="cja_listing_item">Suitable for Those on Benefits: <strong><?php echo $cja_current_ad->return_human('suitable_benefits'); ?></strong></p>
    <p class="cja_listing_item">Social Services - Service Users: <strong><?php echo $cja_current_ad->return_human('social_services'); ?></strong></p>
    <p class="cja_listing_item">Deivery Route: <strong><?php echo $cja_current_ad->return_human('delivery_route'); ?></strong></p>
    <p class="cja_listing_item">Available to Start: <strong><?php echo $cja_current_ad->return_human('available_start'); ?></strong></p>
    <p class="cja_listing_item">Deadline: <strong><?php echo $cja_current_ad->return_human('deadline'); ?></strong></p>
    <?php if ($cja_current_ad->course_file_url) { ?>
        <p class="cja_listing_item"><a class="cja_button" href="<?php echo $cja_current_ad->course_file_url; ?>" target="_blank">Download Course Information</a></p>
    <?php } ?>

</div>