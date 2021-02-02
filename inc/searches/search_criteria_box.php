<?php

// Display the search criteria box ?>
<div class="cja_search_criteria_box">
    <p><strong>Search Options:</strong></p><?php 
    
    // Display the search criteria
    if ($search_type == 'job') {
        //include ABSPATH . '/wp-content/themes/courses-and-jobs/inc/browse-jobs/display_search_criteria.php';
        include ABSPATH . '/wp-content/themes/courses-and-jobs/inc/searches/display_search_criteria_jobs.php';
    } else if ($search_type == 'course') {
        include ABSPATH . '/wp-content/themes/courses-and-jobs/inc/searches/display_search_criteria_courses.php';
    } else if ($search_type == 'classified') {
        include ABSPATH . '/wp-content/themes/courses-and-jobs/inc/searches/display_search_criteria_classifieds.php';
    }?>
    <p class="button-wrap"><a href="<?php echo get_the_permalink(); ?>?edit-search=true" class="cja_button cja_button--2">Edit Search Options</a></p>
</div>