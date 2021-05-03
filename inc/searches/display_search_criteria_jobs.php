<div class="cja_search_criteria">

    <?php global $pagenow; ?>

    <?php if ($cja_search->cja_id) { ?>
        <p>Job ID: <strong><?php echo $cja_search->cja_id; ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->salary_type) { ?>
        <p>Paid / Unpaid: <strong><?php echo $cja_search->return_human('salary_type'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->salary_numeric) { ?>
        <p>Minimum salary: <strong>£<?php echo $cja_search->salary_numeric; ?> per <?php echo $cja_search->salary_per; ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->max_distance) { ?>
        <p>Maximum Distance: <strong><?php echo $cja_search->max_distance; ?> miles</strong></p>
    <?php } ?>
    <?php if ($cja_search->job_type) { ?>
        <p>Job Type: <strong><?php echo $cja_search->return_human('job_type'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->sector) { ?>
        <p>Sector: <strong><?php echo $cja_search->return_human('sector'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->career_level) { ?>
        <p>Career Level: <strong><?php echo $cja_search->return_human('career_level'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->experience_required) { ?>
        <p>Maximum Experience Required: <strong><?php echo $cja_search->return_human('experience_required'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->employer_type) { ?>
        <p>Employer Type: <strong><?php echo $cja_search->return_human('employer_type'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->minimum_qualification) { ?>
        <p>Highest Qualification Required: <strong><?php echo $cja_search->return_human('minimum_qualification'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->dbs_required) { ?>
        <p>DBS Required: <strong><?php echo $cja_search->return_human('dbs_required'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->payment_frequency) { ?>
        <p>Payment Frequency: <strong><?php echo $cja_search->return_human('payment_frequency'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->shift_work) { ?>
        <p>Shift Work: <strong><?php echo $cja_search->return_human('shift_work'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_search->location_options) { ?>
        <p>Location Options: <strong><?php echo $cja_search->return_human('location_options'); ?></strong></p>
    <?php } ?>

    <?php if ($pagenow != 'edit.php') { ?>
        <p>Order results by: <strong><?php 
            if ($cja_search->order_by == 'date') {
                echo 'Newest Jobs First';
            } else if ($cja_search->order_by == 'distance') {
                echo 'Closest Jobs First';
            } ?></strong></p>
        <?php if ($cja_search->show_applied) {
            ?><p>Include jobs I have already applied for</p><?php
        } else {
            ?><p>Exclude jobs I have already applied for</p><?php
        } 
    } 

    if ($cja_search->earliest_creation_date || $cja_search->latest_creation_date) { ?>
        <p>Display jobs posted<?php
        if ($cja_search->earliest_creation_date) {
            $date_time = new DateTime($cja_search->earliest_creation_date);
            echo ' after ';
            echo $date_time->format('D d F Y');
            if ($cja_search->latest_creation_date) {
                echo ' and ';
            }
        }
        if ($cja_search->latest_creation_date) {
            $date_time = new DateTime($cja_search->latest_creation_date);
            echo ' before ';
            echo $date_time->format('D d F Y');
        }
    } ?>

</div>