<div class="cja_search_criteria">

    <?php if ($cja_jobsearch->salary_numeric) { ?>
        <p>Minimum salary: <strong>£<?php echo $cja_jobsearch->salary_numeric; ?> per <?php echo $cja_jobsearch->salary_per; ?></strong></p>
    <?php } ?>
    <?php if ($cja_jobsearch->job_type) { ?>
        <p>Job Type: <strong><?php echo $cja_jobsearch->return_human('job_type'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_jobsearch->sector) { ?>
        <p>Sector: <strong><?php echo $cja_jobsearch->return_human('sector'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_jobsearch->career_level) { ?>
        <p>Career Level: <strong><?php echo $cja_jobsearch->return_human('career_level'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_jobsearch->experience_required) { ?>
        <p>Experience Required: <strong><?php echo $cja_jobsearch->return_human('experience_required'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_jobsearch->employer_type) { ?>
        <p>Employer Type: <strong><?php echo $cja_jobsearch->return_human('employer_type'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_jobsearch->minimum_qualification) { ?>
        <p>Minimum Qualification Required: <strong><?php echo $cja_jobsearch->return_human('minimum_qualification'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_jobsearch->dbs_required) { ?>
        <p>DBS Required: <strong><?php echo $cja_jobsearch->return_human('dbs_required'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_jobsearch->payment_frequency) { ?>
        <p>Payment Frequency: <strong><?php echo $cja_jobsearch->return_human('payment_frequency'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_jobsearch->shift_work) { ?>
        <p>Shift Work: <strong><?php echo $cja_jobsearch->return_human('shift_work'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_jobsearch->location_options) { ?>
        <p>Location Options: <strong><?php echo $cja_jobsearch->return_human('location_options'); ?></strong></p>
    <?php } ?>

</div>