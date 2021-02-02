<div class="cja_search_criteria">

    <?php if ($cja_search->cja_id) { ?>
        <p>Course ID: <strong><?php echo $cja_search->cja_id; ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->max_distance) { ?>
        <p>Maximum Distance: <strong><?php echo $cja_search->max_distance; ?> miles</strong></p>
    <?php } ?>
    <?php if ($cja_search->offer_type) { ?>
        <p>Offer Type: <strong><?php echo $cja_search->return_human('offer_type'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->category) { ?>
        <p>Category: <strong><?php echo $cja_search->return_human('category'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->sector) { ?>
        <p>Sector: <strong><?php echo $cja_search->return_human('sector'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->deposit_required) { ?>
        <p>Deposit Required: <strong><?php echo $cja_search->return_human('deposit_required'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->career_level) { ?>
        <p>Career Level: <strong><?php echo $cja_search->return_human('career_level'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->experience_required) { ?>
        <p>Experience Required: <strong><?php echo $cja_search->return_human('experience_required'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->provider_type) { ?>
        <p>Training Provider Type: <strong><?php echo $cja_search->return_human('provider_type'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->previous_qualification) { ?>
        <p>Previous Qualification Required: <strong><?php echo $cja_search->return_human('previous_qualification'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->course_pathway) { ?>
        <p>Course Pathway: <strong><?php echo $cja_search->return_human('course_pathway'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->funding_options) { ?>
        <p>Course Funding Options: <strong><?php echo $cja_search->return_human('funding_options'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->payment_plan) { ?>
        <p>Payment Plan: <strong><?php echo $cja_search->return_human('payment_plan'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->qualification_level) { ?>
        <p>Qualification Level: <strong><?php echo $cja_search->return_human('qualification_level'); ?></strong></p>
    <?php } ?>   
    <?php if ($cja_search->qualification_type) { ?>
        <p>Qualification Type: <strong><?php echo $cja_search->return_human('qualification_type'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->total_units) { ?>
        <p>Total Units: <strong><?php echo $cja_search->return_human('total_units'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->dbs_required) { ?>
        <p>DBS Required: <strong><?php echo $cja_search->return_human('dbs_required'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->availability_period) { ?>
        <p>Availability Period: <strong><?php echo $cja_search->return_human('availability_period'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->allowance_available) { ?>
        <p>Allowance Available: <strong><?php echo $cja_search->return_human('allowance_available'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->awarding_body) { ?>
        <p>Awarding Body: <strong><?php echo $cja_search->return_human('awarding_body'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->duration) { ?>
        <p>Duration: <strong><?php echo $cja_search->return_human('duration'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->suitable_benefits) { ?>
        <p>Suitable for Those on Benefits: <strong><?php echo $cja_search->return_human('suitable_benefits'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->social_services) { ?>
        <p>Social Services - Service Users: <strong><?php echo $cja_search->return_human('social_services'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->delivery_route) { ?>
        <p>Delivery Route: <strong><?php echo $cja_search->return_human('delivery_route'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->available_start) { ?>
        <p>Available to Start: <strong><?php echo $cja_search->return_human('available_start'); ?></strong></p>
    <?php } ?>
    <p>Order results by: <strong><?php 
        if ($cja_search->order_by == 'date') {
            echo 'Newest Courses First';
        } else if ($cja_search->order_by == 'distance') {
            echo 'Closest Courses First';
        } ?></strong></p>
    <?php if ($cja_search->show_applied) {
        ?><p>Include courses I have already applied for</p><?php
    } else {
        ?><p>Exclude courses I have already applied for</p><?php
    } ?>

</div>