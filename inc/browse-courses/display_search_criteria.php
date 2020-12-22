<div class="cja_search_criteria">

    <?php if ($cja_coursesearch->max_distance) { ?>
        <p>Maximum Distance: <strong><?php echo $cja_coursesearch->max_distance; ?> miles</strong></p>
    <?php } ?>
    <?php if ($cja_coursesearch->offer_type) { ?>
        <p>Offer Type: <strong><?php echo $cja_coursesearch->return_human('offer_type'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_coursesearch->category) { ?>
        <p>Category: <strong><?php echo $cja_coursesearch->return_human('category'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_coursesearch->sector) { ?>
        <p>Sector: <strong><?php echo $cja_coursesearch->return_human('sector'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_coursesearch->deposit_required) { ?>
        <p>Deposit Required: <strong><?php echo $cja_coursesearch->return_human('deposit_required'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_coursesearch->career_level) { ?>
        <p>Career Level: <strong><?php echo $cja_coursesearch->return_human('career_level'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_coursesearch->experience_required) { ?>
        <p>Experience Required: <strong><?php echo $cja_coursesearch->return_human('experience_required'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_coursesearch->provider_type) { ?>
        <p>Training Provider Type: <strong><?php echo $cja_coursesearch->return_human('provider_type'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_coursesearch->previous_qualification) { ?>
        <p>Previous Qualification Required: <strong><?php echo $cja_coursesearch->return_human('previous_qualification'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_coursesearch->course_pathway) { ?>
        <p>Course Pathway: <strong><?php echo $cja_coursesearch->return_human('course_pathway'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_coursesearch->funding_options) { ?>
        <p>Course Funding Options: <strong><?php echo $cja_coursesearch->return_human('funding_options'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_coursesearch->payment_plan) { ?>
        <p>Payment Plan: <strong><?php echo $cja_coursesearch->return_human('payment_plan'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_coursesearch->qualification_level) { ?>
        <p>Qualification Level: <strong><?php echo $cja_coursesearch->return_human('qualification_level'); ?></strong></p>
    <?php } ?>   
    <?php if ($cja_coursesearch->qualification_type) { ?>
        <p>Qualification Type: <strong><?php echo $cja_coursesearch->return_human('qualification_type'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_coursesearch->total_units) { ?>
        <p>Total Units: <strong><?php echo $cja_coursesearch->return_human('total_units'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_coursesearch->dbs_required) { ?>
        <p>DBS Required: <strong><?php echo $cja_coursesearch->return_human('dbs_required'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_coursesearch->availability_period) { ?>
        <p>Availability Period: <strong><?php echo $cja_coursesearch->return_human('availability_period'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_coursesearch->allowance_available) { ?>
        <p>Allowance Available: <strong><?php echo $cja_coursesearch->return_human('allowance_available'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_coursesearch->awarding_body) { ?>
        <p>Awarding Body: <strong><?php echo $cja_coursesearch->return_human('awarding_body'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_coursesearch->duration) { ?>
        <p>Duration: <strong><?php echo $cja_coursesearch->return_human('duration'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_coursesearch->suitable_benefits) { ?>
        <p>Suitable for Those on Benefits: <strong><?php echo $cja_coursesearch->return_human('suitable_benefits'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_coursesearch->social_services) { ?>
        <p>Social Services - Service Users: <strong><?php echo $cja_coursesearch->return_human('social_services'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_coursesearch->delivery_route) { ?>
        <p>Delivery Route: <strong><?php echo $cja_coursesearch->return_human('delivery_route'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_coursesearch->available_start) { ?>
        <p>Available to Start: <strong><?php echo $cja_coursesearch->return_human('available_start'); ?></strong></p>
    <?php } ?>
    <p>Order results by: <strong><?php 
        if ($cja_coursesearch->order_by == 'date') {
            echo 'Newest Courses First';
        } else if ($cja_coursesearch->order_by == 'distance') {
            echo 'Closest Courses First';
        } ?></strong></p>
    <?php if ($cja_coursesearch->show_applied) {
        ?><p>Include courses I have already applied for</p><?php
    } else {
        ?><p>Exclude courses I have already applied for</p><?php
    } ?>

</div>