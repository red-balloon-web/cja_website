<div class="cja_search_criteria">

    <?php // print_r($cja_usersearch); ?>

    <?php if ($cja_usersearch->cja_id) { ?>
        <p>User ID: <strong><?php echo $cja_usersearch->cja_id; ?></strong></p>
    <?php } ?>

    <?php if ($cja_usersearch->max_distance) { ?>
        <p>Maximum Distance: <strong><?php echo $cja_usersearch->max_distance; ?> miles</strong></p>
    <?php } ?>

    <?php if ($cja_usersearch->opportunity_required) { 
        $display_string = '';
        $is_first = true;
        foreach ($cja_usersearch->opportunity_required as $opportunity_req) {
            if (!$is_first) {
                $display_string .= ' / ';
            } else {
                $is_first = false;
            }
            foreach ($cja_usersearch->form_fields['opportunity_required']['options'] as $option) {
                if ($option['value'] == $opportunity_req) {
                    $display_string .= $option['label'];
                }
            }
        } ?>
        <p>Opportunity Required: <strong><?php echo $display_string; ?></strong></p>
    <?php } ?>

    <?php if ($cja_usersearch->course_time) { ?>
        <p>Courses FT/PT: <strong><?php $cja_usersearch->display_field('course_time'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_usersearch->job_time) { ?>
        <p>Jobs FT/PT: <strong><?php $cja_usersearch->display_field('job_time'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_usersearch->cover_work) { ?>
        <p>Cover Work: <strong><?php $cja_usersearch->display_field('cover_work'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_usersearch->progress_to_university) { ?>
        <p>Course to progress to university: <strong><?php $cja_usersearch->display_field('progress_to_university'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_usersearch->progress_to_employment) { ?>
        <p>Course to progress to employment: <strong><?php $cja_usersearch->display_field('progress_to_employment'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_usersearch->looking_for_loan) { ?>
        <p>Looking for student or advanced learner loan: <strong><?php $cja_usersearch->display_field('looking_for_loan'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_usersearch->weekends_availability) { ?>
        <p>Weekends Availability: <strong><?php $cja_usersearch->display_field('weekends_availability'); ?></strong></p>
    <?php } ?>

    
    <?php if ($cja_usersearch->gcse_maths) { ?>
        <p>Minimum GCSE Maths Grade: <strong><?php $cja_usersearch->display_field('gcse_maths'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_usersearch->gcse_english) { ?>
        <p>Minimum GCSE English Grade: <strong><?php $cja_usersearch->display_field('gcse_english'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_usersearch->functional_maths) { ?>
        <p>Minimum Functional Maths Grade: <strong><?php $cja_usersearch->display_field('functional_maths'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_usersearch->functional_english) { ?>
        <p>Minimum Functional English Grade: <strong><?php $cja_usersearch->display_field('functional_english'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_usersearch->highest_qualification) { ?>
        <p>Minimum Highest Current Qualification: <strong><?php $cja_usersearch->display_field('highest_qualification'); ?></strong></p>
    <?php } ?>

    <?php if ($cja_usersearch->age_category) { ?>
        <p>Age Category: <strong><?php $cja_usersearch->display_field('age_category'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_usersearch->current_status) { ?>
        <p>Current Status: <strong><?php $cja_usersearch->display_field('current_status'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_usersearch->unemployed) { ?>
        <p>Unemployed: <strong><?php $cja_usersearch->display_field('unemployed'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_usersearch->receiving_benefits) { ?>
        <p>Receving Benefits: <strong><?php $cja_usersearch->display_field('receiving_benefits'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_usersearch->dbs) { ?>
        <p>Do you have a DBS: <strong><?php $cja_usersearch->display_field('dbs'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_usersearch->current_availability) { ?>
        <p>Current Availability: <strong><?php $cja_usersearch->display_field('current_availability'); ?></strong></p>
    <?php } ?>
    <?php if ($cja_usersearch->prevent_safeguarding) { ?>
        <p>Have you done the Prevent or Safeguarding training: <strong><?php $cja_usersearch->display_field('prevent_safeguarding'); ?></strong></p>
    <?php } ?>



    

    <?php if ($cja_usersearch->specialism_area) { 
        $display_string = '';
        $is_first = true;
        foreach ($cja_usersearch->specialism_area as $specialism) {
            if (!$is_first) {
                $display_string .= ' / ';
            } else {
                $is_first = false;
            }
            foreach ($cja_usersearch->form_fields['specialism_area']['options'] as $option) {
                if ($option['value'] == $specialism) {
                    $display_string .= $option['label'];
                }
            }
        } ?>
        <p>Specialism Area(s): <strong><?php echo $display_string; ?></strong></p>
    <?php } ?>

    <!--<p>Order results by: <strong><?php 
        if ($cja_usersearch->order_by == 'alphabet') {
            echo 'Alphabetical';
        } else if ($cja_usersearch->order_by == 'distance') {
            echo 'Closest Users First';
        } ?></strong></p>-->
</div>