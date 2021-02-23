<?php
if ($_GET['view-profile']) {

    $cja_current_applicant = new CJA_User($_GET['view-profile']);

    $candidate_template = 'jobseeker';
    include (ABSPATH . 'wp-content/themes/courses-and-jobs/inc/templates/candidate-details.php');

    $display_search = false;
}